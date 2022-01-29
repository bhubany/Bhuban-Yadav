<?php 
// session_start();
# initializing variables
$host='localhost';
$user='root';
$password="";
$db="engineering_questions";
$database="discussion_database";
# connecting to the database
$con_discussion=@mysqli_connect($host,$user,$password,$database);
if (mysqli_connect_errno()) {
	echo "Failed to connect to MySQL:".mysqli_connect_error();
}
 ?>