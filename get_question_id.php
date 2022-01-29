<?php
session_start(); 
if (isset($_REQUEST['goto_replies'])) {
	$subjects=$_REQUEST['subject'];
	$qsn_id=$_REQUEST['id'];
	$_SESSION['subject']=$subjects;
	$_SESSION['question_id']=$qsn_id;
}
 ?>