<?php
if(!session_id()){
  session_start();
}?> 

<?php

if (clean_values($con,isset($_SESSION["username"]))) {
 	header("Location:dashboard.php");
 }else{

date_default_timezone_set('Asia/Kathmandu');
require 'db.php';
require 'secure/mail.php';
require 'includes/functions.php';
require 'server.php';

 $mail_sent=1;
 $created_at=clean_values($con,date("Y-m-d H:i:s"));
 $is_expired=0;
 $is_action_performed=0;

//--------------STARTING FROM HERE---------

 if (!clean_values($con,isset($_SESSION['conf_email']))) {
 	header("Location:login.php");
 }
 $sent_email=clean_values($con,$_SESSION['conf_email']);


 if (clean_values($con,isset($_POST['activate_acnt']))) {
 	$mail=clean_values($con,$_REQUEST['email']);
 		$otp=rand(100000,999999);	//GENERATES OTP


// ----------------------SEND EMAIL FROM HERE----------------------------
 			$to=$mail;
			$name=" ";
			$subject='VERIFY YOUR ONLINE ENTRANCE ACCOUNT';
			$msg='Password reset for your ONLINE ENTRANCE has been requested.';
			// $mail_sent=sendMail($to,$name,$otp,$subject,$msg);
			
	$qry_is_otp=@"SELECT * FROM otp_expiry WHERE email='$sent_email' AND is_expired='0' LIMIT 1";
	$qry_is_otp_res=mysqli_query($con,$qry_is_otp) or die();
	if (mysqli_num_rows($qry_is_otp_res)>0) {
		header("Location:conform.php");
	}
	else{
 	if ($mail_sent==1) {
		$will_expired = date("Y-m-d H:i:s",strtotime('+1 day +0 hour +0 minutes +0 seconds',strtotime($created_at)));
		
		$exp_query=@"INSERT INTO otp_expiry(email,otp,is_expired,is_action_performed,created_at,will_expired)
				VALUES ('$sent_email',$otp,$is_expired,'$is_action_performed','$created_at','$will_expired')";
			$exp_result=mysqli_query($con,$exp_query) or die(mysqli_error());
			if($exp_result==1){
				// $_SESSION['conf_email']=$reg_email;
				header("location:conform.php");
 				// exit();
 				}
 				else{
 					$register_error="Error occurs during registration";
					}
				}	// CLOSING OF if ($mail_sent==1) 
			}	///CLOSING OF ELSE(if (mysqli_num_rows($qry_is_otp_res)>0))
 }	//CLOSING OF  if (!isset($_SESSION['conf_email']))
?>
<head>
	<title>ONLINE ENTRANCE -account has deleted</title>
</head>
<style type="text/css">

</style>
<?php include 'header.php'; ?>
<?php include 'nav.php'; ?>

<div class="row">
	<div class="col-lg-1 col-md-1"></div>
	<div class="col-lg-10 col-md-10 col-xs-12 myRowBorder">
		<div class="mySubRowBorder">
			<u  style="color: #1222B5;"><h2 class="text-center">ACCOUNT INACTIVE</h2></u>
			<h4 class="text-center text-info">Your account is in inactive status. Please read the instructions below for activation process.</h4>
		</div>

		<div class="row">
			<div class="col-lg-12 col-md-12 col-xs-12">
				<p class="font-italic text-justify">You have unsubscribed your account from <a style="text-decoration: none;" href="index.php">ONLINE ENTRANCE MODEL TEST</a> If you want to activate your account again then you must have accessed to your registered email <span class="font-weight-bold alert">"<?php echo $sent_email; ?>"</span>.We will conform you through that email.</p>
	 		</div>
		</div>

		<div class="row">
			<div class="col-lg-4 col-md-4"></div>
			<div class="col-lg-4 col-md-4 col-xs-12" style="padding-bottom: 5px;">
				<form action="" method="post" id="acountactivate_form">
					<input type="hidden" name="email" value="<?php echo($sent_email); ?>">
					<input type="submit" name="activate_acnt" value="ACTIVATE" class="btn btn-primary btn-lg btn-block" id="activate_btn">
				</form>
			</div>
			<div class="col-lg-4 col-md-4"></div>
		</div>
	</div>
	<div class="col-lg-1 col-md-1"></div>
</div>

<!-- -----------------FOOTER-------------- -->
<?php include 'footer.php'; ?>

<?php } ?>