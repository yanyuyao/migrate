<?php 
define('MYSQL_HOST','47.88.227.140');
define('MYSQL_PORT','3306');
define('MYSQL_USER','root');
define('MYSQL_PASS','rootran');
define('MYSQL_DB','ascdb');
define('MYSQL_CONN','');
define('MYSQL_CODING','UTF8');

include('mysql.php');
error_reporting(E_ALL);
header("Content-type: text/html; charset=utf-8");
ini_set('display_errors', TRUE);
ini_set('display_startup_errors', TRUE);
date_default_timezone_set('Europe/London');
/** Include PHPExcel */
require_once 'PHPExcel/Classes/PHPExcel.php';
define('EOL',(PHP_SAPI == 'cli') ? PHP_EOL : '<br />');

$db = new mysql(MYSQL_HOST, MYSQL_USER, MYSQL_PASS, MYSQL_DB, MYSQL_CONN,MYSQL_CODING);
//table tax_calculation_rate
//加载文件
$uploadfile='files/zipcode-09-20.xlsx';
$objPHPExcel = new PHPExcel();
$objReader = PHPExcel_IOFactory::createReader('Excel2007');/*Excel5 for 2003 excel2007 for 2007*/
$objPHPExcel = $objReader->load($uploadfile); //Excel 路径

//获得基本信息
$objWorksheet = $objPHPExcel->getActiveSheet();  

$highestRow = $objWorksheet->getHighestRow();   // 取得总行数  
//$highestRow = 10;

$highestColumn = $objWorksheet->getHighestColumn();        
$highestColumnIndex = PHPExcel_Cell::columnIndexFromString($highestColumn);//总列数
	echo "共".$highestRow."行<br>";	
//获取标题
$cols_array =array();
//注意highestColumnIndex的列数索引从0开始
for ($col = 0;$col < $highestColumnIndex;$col++)            {
	$cols_array[$col] =$objWorksheet->getCellByColumnAndRow($col, 1)->getValue();
}


//row = 2, 去掉标题行
for ($row = 2;$row <= $highestRow;$row++) {
	//使用sku来做唯一判断
	//$tax_country_id = $objWorksheet->getCellByColumnAndRow(0, $row)->getValue();
	//$code = $objWorksheet->getCellByColumnAndRow(1, $row)->getValue();
	//$tax_region_id = $objWorksheet->getCellByColumnAndRow(2, $row)->getValue();
	$postcode = $objWorksheet->getCellByColumnAndRow(3, $row)->getValue();
	$rate = $objWorksheet->getCellByColumnAndRow(4, $row)->getValue();
	$zip_is_range = $objWorksheet->getCellByColumnAndRow(5, $row)->getValue();
	$zip_from = $objWorksheet->getCellByColumnAndRow(6, $row)->getValue();
	$zip_to = $objWorksheet->getCellByColumnAndRow(7, $row)->getValue();
	$zip_from = $zip_from?$zip_from:0;
	$zip_to = $zip_to?$zip_to:0;
	$rate = floatval($rate)*100;
	if(!$postcode){ continue;}
	$tax_country_id = "US";
	$tax_region_id = "12";
	if($zip_is_range == 1){
		$tax_postcode = $zip_from."-".$zip_to;
	}else{
		$tax_postcode = $postcode;
	}
	$code = "US-CA-".$postcode;
	
	//echo $tax_country_id."---".$code."---".$tax_region_id."---".$postcode."----".$rate."---".$zip_is_range."----".$zip_from."----".$zip_to."<br>";
	echo $tax_country_id."---".$tax_region_id."---".$tax_postcode."---".$code."---".$rate."----$zip_is_range
---[$zip_from - $zip_to]<br>";
	
	$rs = $db->select("tax_calculation_rate","tax_postcode"," tax_postcode = '".$tax_postcode."' limit 1 ");
	var_dump($rs);
	
	if($rs==null){
		//如果有数据，则更新rate
		$flag = $db->update('tax_calculation_rate', " rate = '".$rate."' ", " tax_postcode = '$tax_postcode' limit 1 ");
		$type = "update";
	}else{
		$columnName_str = "tax_country_id,tax_region_id,tax_postcode,code,rate,zip_is_range,zip_from,zip_to";
		$value_str = "'$tax_country_id','$tax_region_id','$tax_postcode','$code','$rate','$zip_is_range','$zip_from','$zip_to'";
		$flag = $db->insert('tax_calculation_rate', $columnName_str, $value_str);
		$type = "insert";
	}
	
	echo "==>".$type."===".$flag."<br>";
}
?>