<?php 
// session_start();
$host="localhost";
$user="root";
$password="";
$db_name="user_info";
$con_user=@mysqli_connect($host,$user,$password,$db_name);
if (mysqli_connect_errno()) {
	echo "Failed to connect to server".mysqli_connect_error();
	exit();
}
 ?>