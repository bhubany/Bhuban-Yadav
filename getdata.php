<?php 	
	$username=$_SESSION['username'];
	// $count=1;
	$sel_query="SELECT * FROM user_information WHERE username='$username';";
	$result = mysqli_query($con,$sel_query);
	while($row = mysqli_fetch_assoc($result)) {
	$newid=$row["id"];
	 }
?>