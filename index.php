<?php
header("Content-type: text/html; charset=utf-8");
require_once 'phpexcel.php';
require_once 'PHPExcel\IOFactory.php';
require_once 'PHPExcel\Reader\Excel2007.php';


$uploadfile='data.xlsx';

$objReader = PHPExcel_IOFactory::createReader('Excel2007');/*Excel5 for 2003 excel2007 for 2007*/
$objPHPExcel = $objReader->load($uploadfile); //Excel 路径
$sheet = $objPHPExcel->getSheet(0);
$highestRow = $sheet->getHighestRow(); // 取得总行数
$highestColumn = $sheet->getHighestColumn(); // 取得总列数
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

/*方法二【推荐】*/
$objWorksheet = $objPHPExcel->getActiveSheet();        
$highestRow = $objWorksheet->getHighestRow();   // 取得总行数     
$highestColumn = $objWorksheet->getHighestColumn();        
$highestColumnIndex = PHPExcel_Cell::columnIndexFromString($highestColumn);//总列数

for ($row = 1;$row <= $highestRow;$row++)         {
	$strs=array();
	//注意highestColumnIndex的列数索引从0开始
	for ($col = 0;$col < $highestColumnIndex;$col++)            {
		$strs[$col] =$objWorksheet->getCellByColumnAndRow($col, $row)->getValue();
	}
	print_r($strs);
}
?>