<?php
if(!session_id()){
  session_start();
}
// require 'admin_db.php';
if (!isset($_SESSION["admin_username"])) {
	header("Location:login.php");
	exit();
}

 ?>