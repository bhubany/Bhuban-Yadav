<?php 
// session_start();
$host="localhost";
$user="root";
$password="";
$db_name="admin_database";
$con_admin=@mysqli_connect($host,$user,$password,$db_name);
if (mysqli_connect_errno()) {
	echo "Failed to connect to server".mysqli_connect_error();
	exit();
}
 ?>