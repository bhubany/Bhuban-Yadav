<?php
	if(!session_id()){
	  session_start();
	}
?>

<?php 
// session_start();
require 'db.php';
if (!isset($_SESSION["username"])) {
	header("Location:login.php");
	exit();
}
else{
	require 'getdata.php';
	// $username=$_SESSION['username'];
	// $sel_query="SELECT * FROM user_information WHERE username='$username';";
	// $result = mysqli_query($con,$sel_query);
	// while($row = mysqli_fetch_assoc($result)) {
	// $newid=$row["id"];
// }
}
 ?>
