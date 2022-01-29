<?php 
$host="localhost";
$user='root';
$password="";
$db_name="exam_database";
$con_exam=@mysqli_connect($host,$user,$password,$db_name);
if (mysqli_connect_errno()) {
	echo "Failed to connect to server".mysqli_connect_error();
	exit();
}
// else{
// 	echo "sucess";
//  }
 ?>
