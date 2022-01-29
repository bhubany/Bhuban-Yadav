<?php
if(!session_id()){
  session_start();
}?>

<?php
	require 'db.php';
	require 'includes/functions.php';
	 // require 'server.php';
	if (isset($_SESSION["username"])) {
	 	header("Location:dashboard.php");
	 } else{ 
?>
 	
<?php 
$Sucess="";
$errors=array();
// $reset_email="";
$is_expired=0;
$is_action_performed=0;
$otp=rand(100000,999999);
$email_sent=0;
$condition="";
$reg_email="";
$reg_otp="";
$reg_is_expired="";
$expiry_date="";
$created_at = date("Y-m-d H:i:s");
$will_expired = date("Y-m-d H:i:s",strtotime('+1 day +0 hour +0 minutes +0 seconds',strtotime($created_at)));
$reg_email="";
$reg_otp="";
$reg_date="";
$reg_is_expired="";


if (clean_values($con,isset($_POST['resetpwd_user']))) {
	$resetpwd_email=clean_values($con,$_POST['email']);
	// echo $resetpwd_email;
	if (empty($resetpwd_email)) {
		array_push($errors, "Please Enter email");
	}elseif (!filter_var($resetpwd_email, FILTER_VALIDATE_EMAIL)) {
    	array_push($errors, "Please enter valid email");
  	}elseif (strlen($resetpwd_email)<8 or strlen($resetpwd_email)>50) {
    	array_push($errors, "Please enter valid email");
  	}

	if (count($errors) == 0) {
		$query=@"SELECT * FROM user_information WHERE email='$resetpwd_email' LIMIT 1";
		$result=mysqli_query($con,$query) or die(mysqli_error($con));

		if (mysqli_num_rows($result)>0) {
			$qry_is_otp=@"SELECT * FROM otp_expiry WHERE email='$resetpwd_email' AND is_expired=0 LIMIT 1";
			$qry_is_otp_res=mysqli_query($con,$qry_is_otp) or die();

		  	if (mysqli_num_rows($qry_is_otp_res)>0) {
		  		$_SESSION['pwd_reset_email']=$resetpwd_email;
			  	header("Location:taking_otp.php");
			}else{
		  	// SENT EMAIL
		  		$email_sent=1;

			  	if ($email_sent==1){
					$otp_qry=@"INSERT INTO otp_expiry(email,otp,is_expired,is_action_performed,created_at,will_expired,tried_times)	VALUES('$resetpwd_email',$otp,0,0,'$created_at','$will_expired',0)";
					$otp_res=mysqli_query($con,$otp_qry) or die($con);
					if ($otp_res==1) {
						header("Location:taking_otp.php");
						$Sucess= "We have sent verification email please check it.";
				 	}else{
				 		array_push($errors, "Error occurs try again later");
				 	}
		  		}else{
		  			array_push($errors,"Error occurs try again later.");
		  		} 
		 	}
		}else{ //---------------ELSE STATEMENT OF $resetpwd_email===$reset_email--------------
			array_push($errors, "Email: \"".$resetpwd_email."\" you have entered is not registered yet. <a href='register.php'>(click here)</a> to register. ");
		}
	}
}
 ?>



 <head>
 	<title>Resetting password-secure pages</title>
 </head>


	<?php include 'header.php'; ?>


<!-- ************************STARTING OF MAIN SECTIONS**************** -->

				<!-- ------------------------HEADER---------------------- -->
<div class="row">
	<div class="col-lg-1 col-md-1"></div>
	<div class="col-lg-10 col-md-10 col-xs-12 myHeader" style="color: #fff; font-weight: bold;">
		<u><h2 class="text-center">RESET PASSWORD</h2></u>
		<h4 class="text-center text-warning">If you unsubscribe then you cannot acess exam and download's section provided by us.</h4>
	</div>
	<div class="col-lg-1 col-md-1"></div>
</div>


			<!-- -----------------FOR SUCESS MESSAGE_----------- -->

<div class="row">
	<div class="col-lg-1 col-md-1"></div>
	<div class="col-lg-10 col-md-10 col-xs-12 myRowBorder">
		<div class="row">
			<div class="col-lg-12 col-md-12 col-xs-12">
					<?php include('errors.php');?>
							<?php if ($Sucess!="") {?>
				<div class="success">
					<?php echo $Sucess; ?>
				</div><br>
						<?php  } ?>
			</div>
		</div>
	</div>
	<div class="col-lg-1 col-md-1"></div>
</div>


 <!-- ------------------TAKING EMAIL---------------- -->
<div class="row">
	<div class="col-lg-1 col-md-1"></div>
	<div class="col-lg-10 col-md-10 col-xs-12 myRowBorder">
		<div class="row">
			<div class="col-lg-4 col-md-4"></div>
			<div class="col-lg-4 col-md-4 col-xs-12 myRowBorder shadow-lg" style="background-color: #f2f2f2;"><br>
				<form action="" method="post">

					<div class="form-group">
		      			<label for="reset_email" class="font-weight-bold">Email or Username:</label>
		      			<input type="email" class="form-control" id="reset_email" placeholder="Enter your registered email" name="email" minlength="8" maxlength="50" required="on">
		    		</div>

					<div class="custom-control custom-checkbox mb-3 was-validated">
					    <input type="checkbox" class="custom-control-input" id="customControlValidation2" name="robot" required value="1">
					    <label class="custom-control-label" for="customControlValidation2">I Am not a Robot?</label>
					</div>

					<div>
						<input type="hidden" name="resetpwd_email" value="">
						<button type="submit" class="btn btn-default myLoginBtn" name="resetpwd_user">Submit</button>
					</div>

					<div>
						<p>Try Loging?<span><a href="login.php">CLICK HERE.</a></span></p>	
					</div>
				</form>
			</div>
			<div class="col-lg-4 col-md-4"></div>
		</div>
	</div>
	<div class="col-lg-1 col-md-1"></div>
</div>


<!-- -----------------STARTING OF FOOTER---------------------- -->

 	<?php include 'footer.php'; ?>



<!-- ---------------ENDING OF IS_LOGGED_IN OR NOT------------------- -->
 	<?php  } ?>
