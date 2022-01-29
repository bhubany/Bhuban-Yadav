<?php
	if(!session_id()){
	  session_start();
	}
?>

<?php
	require 'db.php';
	require 'includes/functions.php';
	if (isset($_SESSION["username"])) {
	 	header("Location:dashboard.php");
	}elseif (isset($_SESSION['otp_verify'])) {
?>
 	
<?php 

$Sucess="";
$errors=array();
$reset_email=$_SESSION['pwd_reset_email'];
$input_otp=$_SESSION['otp'];

if (clean_values($con,isset($_POST['new_pwd_submit']))) {
	$new_pwd=clean_values($con,$_POST['new_pwd']);
	$conf_new_pwd=clean_values($con,$_POST['conf_new_pwd']);

	if (empty($new_pwd)) {
		array_push($errors,"Please enter your Password");
	}elseif (strlen($new_pwd)<8 or strlen($new_pwd)>20) {
		array_push($errors, "Password must lies between 8 to 20 characters.");
	}

	if (empty($conf_new_pwd)) {
		array_push($errors,"Please conform your Password");
	}elseif (strlen($conf_new_pwd)<8 or strlen($conf_new_pwd)>20) {
		array_push($errors, "Password must lies between 8 to 20 characters.");
	}

	if ($new_pwd!==$conf_new_pwd) {
		array_push($errors, "Both password doesnot match try again");
	}

	if (count($errors)==0) {
		$qry_is_otp=@"SELECT * FROM otp_expiry WHERE email='$reset_email' AND is_expired=0 LIMIT 1";
		$qry_is_otp_res=mysqli_query($con,$qry_is_otp) or die($con);

		if (mysqli_num_rows($qry_is_otp_res)>0) {
			$conf_pwd=md5($new_pwd);
			$qry_chng_pwd=@"UPDATE user_information SET password='$conf_pwd' WHERE email='$reset_email' LIMIT 1";
			$qry_chng_pwd_res=mysqli_query($con,$qry_chng_pwd) or die($con);
			if ($qry_chng_pwd_res==1) {
				$qry_action_performed=@"UPDATE otp_expiry SET is_expired=1,is_action_performed=1 WHERE email='$reset_email' AND otp=$input_otp";
				$qry_action_performed_res=mysqli_query($con,$qry_action_performed) or die($con);

				if ($qry_action_performed_res==1) {
					$Sucess="Password has been changed sucessfully for email: ".$reset_email."<a href='login.php'> Click here</a> to login.";
					$_SESSION['password_changed']=1;
				}
			}else{
				array_push($errors, "Error occurs on changing your password try again later.");
			}
		}else{
			$qry_already_verified=@"SELECT * FROM otp_expiry WHERE (email='$reset_email' AND otp=$input_otp) AND is_action_performed=1 LIMIT 1";
			$qry_already_verified_res=mysqli_query($con,$qry_already_verified) or die($con);
			if (mysqli_num_rows($qry_already_verified_res)>0) {
				array_push($errors,"Your password has already changed can't take new password<a href='login.php'> click here</a> to Login.");
			}else{
				array_push($errors, "You might have entered wrong codes so many time or code has been expired. Please request for new one.");
			}
		}
	}
}

 ?>

 <head>
 	<link rel="stylesheet" type="text/css" href="assests/css/resetpwd_style.css">
 	<title>Resetting password-secure pages</title>
 </head>
 
 <style type="text/css">
 
 </style>


	<?php include 'header.php'; ?>

<!-- --------------------Error/sucess message---------------- -->

<div class="row">
	<div class="col-lg-1 col-md-1"></div>
	<div class="col-lg-10 col-md-10 col-xs-12 myRowBorder">
		<div class="" style="padding-top: 5px;padding-bottom: 5px;">
        <?php include 'errors.php'; ?>
      <?php if ($Sucess!="") {?>
      <div class="mySuccess"><?php echo $Sucess; ?></div>
      <?php } ?>
    </div>
	</div>
	<div class="col-lg-1 col-md-1"></div>
</div>


<!-- ---------------HEADER-------------- -->
<div class="row">
	<div class="col-lg-1 col-md-1"></div>
	<div class="col-lg-10 col-md-10 col-xs-12 myRowBorder">
		<div class="mySubRowBorder">
			<u  style="color: #1222B5;"><h2 class="text-center">RESET PASSWORD</h2></u>
			<h4 class="text-center text-warning">Enter your new password for Account: "<span class="font-weight-bold" style="color: black;"><?php echo $reset_email; ?></span>"</h4>
		</div>
	</div>
	<div class="col-lg-1 col-md-1"></div>
</div>

<!-- --------------TAKING NEW PASSWORD AS INPUT---------- -->
<div class="row">
	<div class="col-lg-1 col-md-1"></div>
	<div class="col-lg-10 col-md-10 col-xs-12 myRowBorder">
		<div class="row">
			<div class="col-lg-4 col-md-4"></div>
			<div class="col-lg-4 col-md-4 col-xs-12 shadow-lg" style="background-color: #f2f2f2;"><br>
				<form action="" method="post">

					<div class="form-group">
		      			<label for="password_1" class="font-weight-bold">ENTER NEW PASSWORD:</label>
		      			<input type="password" class="form-control" id="password_1" placeholder="Enter new password" name="new_pwd" onkeyup='checkPwd();' minlength="8" maxlength="20" required="on">
		    		</div>

		    		<div class="form-group">
		      			<label for="password_2" class="font-weight-bold">CONFIRM NEW PASSWORD:</label>
		      			<input type="password" class="form-control" id="password_2" placeholder="Conform new password" name="conf_new_pwd" onkeyup='checkPwd();' minlength="8" maxlength="20" required="on"><span id='message'></span>
		    		</div>
		      			<span class="help-block text-info">Password mut be of minimum 8 and maximum 20 charactes. For strong password you must enter one big letter, special character and number.</span>

					<div class="custom-control custom-checkbox mb-3 was-validated">
					    <input type="checkbox" class="custom-control-input" id="customControlValidation2" name="robot" required value="1">
					    <label class="custom-control-label" for="customControlValidation2">I Am not a Robot?</label>
					</div>

					<div>
						<button type="submit" class="btn btn-default myLoginBtn" name="new_pwd_submit">Submit</button>
					</div>
				</form><br>
			</div>
			<div class="col-lg-4 col-md-4"></div>
		</div>
	</div>
	<div class="col-lg-1 col-md-1"></div>
</div>


<!-- -----------------STARTING OF FOOTER---------------------- -->
 	<?php include 'footer.php'; ?>

<!-- ---------------ENDING OF IS_LOGGED_IN OR NOT------------------- -->
<?php 
	}  
	else{
		header("Location:resetpwd.php");
	}
?>
