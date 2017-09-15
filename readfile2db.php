<?php 
define('MYSQL_HOST','127.0.0.1');
define('MYSQL_PORT','3306');
define('MYSQL_USER','root');
define('MYSQL_PASS','root');
define('MYSQL_DB','randb');
define('MYSQL_CONN','');
define('MYSQL_CODING','UTF8');

include('mysql.php');
$db = new mysql(MYSQL_HOST, MYSQL_USER, MYSQL_PASS, MYSQL_DB, MYSQL_CONN,MYSQL_CODING);

$file = "files/CA_Features_20170801.txt";

$myfile = fopen($file, "r") or die("Unable to open file!");
// 输出单行直到 end-of-file
$line = 0;
$title = array();
while(!feof($myfile)) {
	$line_content = fgets($myfile);
	if($line == 0){
		$title = explode("|",$line_content);
		$title_str = implode(",",$title);
		echo $title_str;
	}else{
		$data = explode("|",$line_content);
		$value_str = implode("','",$data);
		$value_str = "'".$value_str."'";
		$flag = $db->insert('asc_ca_zipcode', $title_str, $value_str);
		echo "Line $line : ".$flag."<br>";
	}
	
	//$line_content = fgets($myfile) . "<br>";
	$line++;
}
fclose($myfile);

?>