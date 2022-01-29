<?php 
session_start();
#Destroying All sessions
if (session_destroy()) {
	# Redirect to home page
	header("location:login.php");
}
 ?>