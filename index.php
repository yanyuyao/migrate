<?php

//require_once 'phpexcel.php';
//require_once 'PHPExcel\IOFactory.php';
//require_once 'PHPExcel\Reader\Excel2007.php';

include('config.php');
include('mysql.php');

error_reporting(E_ALL);
header("Content-type: text/html; charset=utf-8");
ini_set('display_errors', TRUE);
ini_set('display_startup_errors', TRUE);
date_default_timezone_set('Europe/London');
/** Include PHPExcel */
require_once 'PHPExcel/Classes/PHPExcel.php';
define('EOL',(PHP_SAPI == 'cli') ? PHP_EOL : '<br />');

//加载文件
$uploadfile='files/081717 BOB Total Catalog.xlsx';
$objPHPExcel = new PHPExcel();
$objReader = PHPExcel_IOFactory::createReader('Excel2007');/*Excel5 for 2003 excel2007 for 2007*/
$objPHPExcel = $objReader->load($uploadfile); //Excel 路径

//获得基本信息
$objWorksheet = $objPHPExcel->getActiveSheet();  
if(ISTEST){
	$highestRow = 20;
}else{ 
	$highestRow = $objWorksheet->getHighestRow();   // 取得总行数  
} 

$highestColumn = $objWorksheet->getHighestColumn();        
$highestColumnIndex = PHPExcel_Cell::columnIndexFromString($highestColumn);//总列数
		

//进行操作
$exec = isset($_REQUEST['exec'])?$_REQUEST['exec']:'default';
//获取标题
$cols_array =array();
//注意highestColumnIndex的列数索引从0开始
for ($col = 0;$col < $highestColumnIndex;$col++)            {
	$cols_array[$col] =$objWorksheet->getCellByColumnAndRow($col, 1)->getValue();
}
//输出所有的数据
//for ($row = 1;$row <= $highestRow;$row++)         {
//	$strs=array();
//	//注意highestColumnIndex的列数索引从0开始
//	for ($col = 0;$col < $highestColumnIndex;$col++)            {
//		$strs[$col] =$objWorksheet->getCellByColumnAndRow($col, $row)->getValue();
//	}
//	//print_r($strs);
//}
$logfile = "";			
		
if($exec == 'default'){
			$db = new mysql(MYSQL_HOST, MYSQL_USER, MYSQL_PASS, MYSQL_DB, MYSQL_CONN,MYSQL_CODING);
			$list = $db->findall('role');
			$list = $db->fetch_array();
		
		 $db->update('role', " weight = 10 ", " rid = 3 ");
	
	$showpage = "update";	
	include('html/default.html.php');	
}else if($exec == 'update'){ //修改字段
	
		// Create new PHPExcel object
		echo date('H:i:s') , " Create new PHPExcel object" , EOL;
		$logfile = '';
		if($_POST){
			$db = new mysql(MYSQL_HOST, MYSQL_USER, MYSQL_PASS, MYSQL_DB, MYSQL_CONN,MYSQL_CODING);
			
			$tablecolumn = isset($_POST['tablecolumn'])?$_POST['tablecolumn']:'';
			$tablecolumn_id = isset($_POST['tablecolumn_id'])?$_POST['tablecolumn_id']:0;
			//$tablecolumn_base = isset($_POST['tablecolumn_base'])?$_POST['tablecolumn_base']:'';
			//$tablecolumn_base_id = isset($_POST['tablecolumn_base_id'])?$_POST['tablecolumn_base_id']:0;
			$tablename = isset($_POST['tablename'])?$_POST['tablename']:'';
			$fieldname = isset($_POST['fieldname'])?$_POST['fieldname']:'';
			echo $tablecolumn_id;
			$logs = "";
			$logfile = LOG_PATH."/update-$tablename-$fieldname-".date("Ymd-His",time()).".log";
			if(!ISTEST){
				$log = fopen($logfile,"a+");
			}
			//row = 2, 去掉标题行
			for ($row = 2;$row <= $highestRow;$row++) {
				$strs=array();
				//注意highestColumnIndex的列数索引从0开始           {
				$value = $objWorksheet->getCellByColumnAndRow($tablecolumn_id, $row)->getValue();
				
				//使用sku来做唯一判断
				$sku = $objWorksheet->getCellByColumnAndRow(0, $row)->getValue();
				$rs = $db->select("field_data_field_sku","entity_id", " field_sku_value = '".$sku."' limit 1 ");
				$info = $db->fetch_array();
				$entity_id = 0;
				if($info){
					$entity_id = $info['entity_id'];
				}
				
		
			
				$rowlog = "";
				if($entity_id){
					
					if($tablename == 'node'){
						$rs = $db->select("node","title"," nid = '".$entity_id."' limit 1 ");
					}elseif($tablename == 'field_data_field_altnames'){
						$rs = $db->select("$tablename","$fieldname"," entity_id = '".$entity_id."' limit 1 ");
					}elseif($tablename == 'field_data_field_product_type'){
						$value = str_replace("For ","",$value);
						$value = str_replace("for ","",$value);
						
						$rs = $db->select("$tablename","$fieldname"," entity_id = '".$entity_id."' limit 1 ");
						$tid = 0;
						foreach($productType2_config as $k=>$v){
							if($value == $v){
								$tid = $k;
								$value = $tid;
							}
						}
						
					}
					
					$checkinfo = $db->fetch_array();
					//var_dump($checkinfo);
					//echo "<br>==========";
					if($checkinfo){
						$oldvalue = $checkinfo[$fieldname];
						
						if($oldvalue == $value){
							$rowlog = "SKU : [$sku]\t $fieldname is same , no change; \t OLD[$oldvalue]  NEW[$value] \r\n";
						}else{
							//修改字段
							if($tablename == 'node'){
								$flag = $db->update($tablename, " $fieldname = '".addslashes($value)."' ", " nid = $entity_id limit 1 ");
							}elseif($tablename == 'field_data_field_altnames'){
								$flag = $db->update($tablename, " $fieldname = '".addslashes($value)."' ", " entity_id = $entity_id limit 1 ");
							}elseif($tablename == 'field_data_field_product_type'){
								$flag = $db->update($tablename, "$fieldname = '".$tid."' ", "entity_id = $entity_id limit 1");
							}
							$rowlog = "SKU : [$sku] \t $fieldname changed; [entity_id: $entity_id] \t from [$oldvalue] to [$tid] \t execute result : $flag \r\n";
						}
						
					}else{
						$rowlog = "SKU : [$sku]\t Info : not found in [$tablename] table; entity_id = [$entity_id] \r\n";
						
						if($tablename == "node"){
							
						}elseif($tablename == 'field_data_field_altnames'){
							$columnName_str = "entity_type,bundle, deleted, entity_id, revision_id,delta,$fieldname";
							$value_str = "'node','bob_product',0,$entity_id,$entity_id,'0','".addslashes($value)."'";
							
							$flag = $db->insert($tablename, $columnName_str, $value_str);
							
							$rowlog .="SKU : [$sku]\t Added new record(Execute : $flag); \t entity_id = [$entity_id], $fieldname = [$value] \r\n";
						}elseif($tablename == 'field_data_field_product_type'){
							//在修改之前，先执行移植sql
						}
					}
					
					
				}else{
					$rowlog = "SKU : [$sku]\t not found entity_id on [field_data_field_sku] table \r\n";
				}
				$logs .= $rowlog;
			}
			if(ISTEST){
				echo nl2br($logs);
			}
			if(!ISTEST){
				fwrite($log, $logs);
				fclose($log);
			}
			//print_r($strs);
		}
	$showpage = 'update';//修改结果
	include('html/default.html.php');
}else if($exec == 'check'){//检测数据

	$logfile = '';
	if($_POST){
		
		$tablecolumn = isset($_POST['tablecolumn'])?$_POST['tablecolumn']:'';
		$tablecolumn_id = isset($_POST['tablecolumn_id'])?$_POST['tablecolumn_id']:0;
		$tablename = isset($_POST['tablename'])?$_POST['tablename']:'';
		$fieldname = isset($_POST['fieldname'])?$_POST['fieldname']:'';

		$db = new mysql(MYSQL_HOST, MYSQL_USER, MYSQL_PASS, MYSQL_DB, MYSQL_CONN,MYSQL_CODING);
		$rs = $db->select(CHECK_TABLE,CHECK_FIELD, $condition = '');
		$list = $db->fetch_all();
		$list_array = array();
		foreach($list as $k=>$v){
			$list_array[] = $v[CHECK_FIELD];
		}
		
		
		$logfile = LOG_PATH."/check-".CHECK_TABLE.".".date("Ymd-His",time()).".log";
		$log = fopen($logfile,"a+");
		if($tablecolumn && $tablename && $fieldname){
			//row = 2, 去掉标题行
			for ($row = 2;$row <= $highestRow;$row++)         {
				$strs=array();
				$value =$objWorksheet->getCellByColumnAndRow($tablecolumn_id, $row)->getValue();
				//echo $value."<br>";
				$log_str = "";
				if(in_array($value, $list_array)){
					$log_str = $value." ==> Found";
				}else{
					$log_str = $value." ==>NOT Found";
				}
				if($log_str){
					fwrite($log, $log_str."\r\n");
				}
			}
		}
		fclose($log);
	}
	
	$check_table = CHECK_TABLE;
	$check_field = CHECK_FIELD;
	$check_table_column = CHECK_TABLECOLUMN;
	$check_table_column_id = CHECK_TABLECOLUMNID;
		
	$showpage = 'check';
	include('html/default.html.php');
}

//{{{
		//$sheet = $objPHPExcel->getSheet(0);
		//$highestRow = $sheet->getHighestRow(); // 取得总行数
		//$highestColumn = $sheet->getHighestColumn(); // 取得总列数
		/*方法一*/
		//$strs=array();
		//for ($j=1;$j<=$highestRow;$j++){//从第一行开始读取数据
		//	/*注销上一行读取数据*/
		//	unset($str);
		//	unset($strs);
		//	for($k='A';$k<=$highestColumn;$k++){//从A列读取数据
		//		//实测在excel中，如果某单元格的值包含了||||||导入的数据会为空                     
		//		 $str .=$objPHPExcel->getActiveSheet()->getCell("$k$j")->getValue().'||||||';//读取单元格
		//	}
		//	//explode:函数把字符串分割为数组。            
		//	$strs = explode("||||||",$str);
		//	$sql = "INSERT INTO te() VALUES ( '{$strs[0]}','{$strs[1]}', '{$strs[2]}','{$strs[3]}','{$strs[4]}')";
		//	echo $sql.'<br>';
		//}
///}}}
?>