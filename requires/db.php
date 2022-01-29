<?php 
// session_start();
# initializing variables
$host='localhost';
$user='root';
$password="";
$db="user_info";
# connecting to the database
$con=@mysqli_connect($host,$user,$password,$db);
if (mysqli_connect_errno()) {
	echo "Failed to connect to MySQL:".mysqli_connect_error();
}
 ?>