<?php
	session_start();
	require 'db.php';
	require 'includes/functions.php';

	if (isset($_SESSION["username"])) {
	 	header("Location:dashboard.php");
	 }elseif (isset($_SESSION['pwd_reset_email'])) { 

 ?>
 	
<?php 
$Sucess="";
$errors=array();
$reg_email="";
$reg_otp="";
$tried_times="";
$new_tried="";
$reg_date="";
$reg_is_expired="";
$expiry_date="";
$reset_email=$_SESSION['pwd_reset_email'];
$now= date("Y-m-d H:i:s");

// ----------------OTP VERIFICATION---------------------------

if (clean_values($con,isset($_POST['otp_submit']))) {
	$input_otp=clean_values($con,$_POST['otp_code']);

	if (empty($input_otp)) {
		array_push($errors, "Enter valid six digit code.");
	}elseif (strlen($input_otp)!=6 or !is_numeric($input_otp)) {
		array_push($errors, "Enter valid six digit code");
	}

	if (count($errors) == 0) {
		$qry_is_otp=@"SELECT * FROM otp_expiry WHERE email='$reset_email' AND is_expired='0' LIMIT 1";
		$qry_is_otp_res=mysqli_query($con,$qry_is_otp) or die($con);
		if (mysqli_num_rows($qry_is_otp_res)>0) {
			while ($qry_is_otp_res_row=mysqli_fetch_assoc($qry_is_otp_res)) {
				$reg_email=$qry_is_otp_res_row['email'];
				$reg_otp=$qry_is_otp_res_row['otp'];
				$reg_date=$qry_is_otp_res_row['created_at'];
				$reg_is_expired=$qry_is_otp_res_row['is_expired'];
				$expiry_date=$qry_is_otp_res_row['will_expired'];
				$tried_times=$qry_is_otp_res_row['tried_times'];
			}
			$new_tried=$tried_times+1;
			$qry_attempt=@"UPDATE otp_expiry SET tried_times='$new_tried' WHERE email='$reset_email'";
			$qry_attempt_res=mysqli_query($con,$qry_attempt) or die($con);
			if ($qry_attempt_res==1) {
				if ($input_otp===$reg_otp) {
					if (($now<=$expiry_date) and ($tried_times<=5)){
						 $_SESSION['otp_verify']=1;
						 $_SESSION['otp']=$input_otp;
						 header("Location:taking_new_password.php");
					}else{
						$qry_exp_otp=@"UPDATE otp_expiry SET is_expired=1 WHERE email='$reset_email' AND otp=$input_otp";
						$qry_exp_otp_res=mysqli_query($con,$qry_exp_otp) or die($con);	
						if ($qry_exp_otp_res==1) {
							array_push($errors, "You might have entered wrong codes so many time or code has been expired. Please request for new one.");
						}
		 			}
		 		}else{
					array_push($errors, "You have entered wrong code. Please check your email and enter code again correctly.");
				}
			}else{
				array_push($errors, "Errors occcur try again later");
			}
		}else{
			array_push($errors, "You might have entered wrong codes so many time or code has been expired. Please request for new one.");
		}
	}
}


// ----------------Sending OtP code again-------------
if (clean_values($con,isset($_POST['resend_otp']))) {
  $requested_email=clean_values($con,$_SESSION['pwd_reset_email']);
  
  if (empty($requested_email)){
      array_push($errors, "Error occurs on Email try again later");
  }elseif (!filter_var($requested_email, FILTER_VALIDATE_EMAIL)) {
    array_push($errors, "Please enter valid email");
  }elseif (strlen($requested_email)<8 or strlen($requested_email)>50) {
    array_push($errors, "Please enter valid email");
  }

  if (count($errors) == 0) {

    $qry_is_otp=@"SELECT * FROM otp_expiry WHERE email='$requested_email' AND is_expired='0' LIMIT 1";
    $qry_is_otp_res=mysqli_query($con,$qry_is_otp) or die($con);
    if (mysqli_num_rows($qry_is_otp_res)>0) {
      while ($qry_is_otp_res_row=mysqli_fetch_assoc($qry_is_otp_res)) {
        $reg_email=$qry_is_otp_res_row['email'];
        $reg_otp=$qry_is_otp_res_row['otp'];
        $reg_date=$qry_is_otp_res_row['created_at'];
        $reg_is_expired=$qry_is_otp_res_row['is_expired'];
        $expiry_date=$qry_is_otp_res_row['will_expired'];
      }
        // -----------Limit 1 Gives only one result----
      if ($now<=$expiry_date) { #is value expired or not(not)
        
        //----------SEND EMAIL- from above data---------
        $email_sent=1;
        if ($email_sent==1) {
          $Sucess="Verification code has been sent to you sucessfully (Email: ".$requested_email." ) .Check your spam folder also. Wait for some time before requesting for new verification code.";
       
        }else{
       
          array_push($errors, "Error occurs try again later.");
        } 
     
      }else{
        $otp=rand(100000,999999); //GENERATES OTP
        // ---------SEND EMAIL FROM HERE----------------------------
        $to=$requested_email;
        // $name=$firstName.' '.$middleName.' '.$surName;
        // $subject='VERIFY YOUR ONLINE ENTRANCE MODEL TEST EMAIL';
        // $msg='Your account for ONLINE ENTRANCE has been created sucessfully.';
        // $mail_sent=sendMail($to,$name,$otp,$subject,$msg);
        $mail_sent=1; //CONCLUDE THAT MAIL WAS SENT TO REGSTERED USER

        if ($mail_sent==1) {
          $will_expired = date("Y-m-d H:i:s",strtotime('+1 day +0 hour +0 minutes +0 seconds',strtotime($created_at)));
          $exp_query=@"INSERT INTO otp_expiry(email,otp,is_expired,is_action_performed,created_at,will_expired) VALUES ('$requested_email',$otp,0,0,'$created_at','$will_expired')";
          $exp_result=mysqli_query($con,$exp_query) or die(mysqli_error($con));
          if($exp_result==1){
            $Sucess="Verification code has been sent to you sucessfully (Email: ".$requested_email." ) .Check your spam folder also. Wait for some time before requesting for new verification code.";
          
          }else{
            array_push($errors, "Error occurs try again Later.");
          }
        }else{
          array_push($errors, "Error occurs try again Later.");
        }
      }
    }else{  #if there is not any data on db---
      $otp=rand(100000,999999); //GENERATES OTP


      // ---------SEND EMAIL FROM HERE----------------------------
      $to=$requested_email;
      // $name=$firstName.' '.$middleName.' '.$surName;
      // $subject='VERIFY YOUR ONLINE ENTRANCE MODEL TEST EMAIL';
      // $msg='Your account for ONLINE ENTRANCE has been created sucessfully.';
      // $mail_sent=sendMail($to,$name,$otp,$subject,$msg);
      $mail_sent=1; //CONCLUDE THAT MAIL WAS SENT TO REGSTERED USER

      if ($mail_sent==1) {
        $will_expired = date("Y-m-d H:i:s",strtotime('+1 day +0 hour +0 minutes +0 seconds',strtotime($created_at)));
        $exp_query=@"INSERT INTO otp_expiry(email,otp,is_expired,is_action_performed,created_at,will_expired) VALUES ('$requested_email',$otp,0,0,'$created_at','$will_expired')";
        $exp_result=mysqli_query($con,$exp_query) or die(mysqli_error($con));
        if($exp_result==1){
          $Sucess="Verification code has been sent to you sucessfully (Email: ".$requested_email." ) .Check your spam folder also. Wait for some time before requesting for new verification code.";
        
        }else{
          array_push($errors, "Error occurs try again Later.");
        }
      
      }else{
          array_push($errors, "Error occurs try again Later.");
      }
    }
  }
}
 ?>

 <head>
 	<title>Resetting password-secure pages</title>
 </head>


	<?php include 'header.php'; ?>

<!-- ************************STARTING OF MAIN SECTIONS**************** -->

			<!-- -----------------FOR SUCESS MESSAGE_----------- -->

<div class="row">
	<div class="col-lg-1 col-md-1"></div>
	<div class="col-lg-10 col-md-10 col-xs-12 myRowBorder">
		<div class="row">
			<div class="col-lg-12 col-md-12 col-xs-12 p-2">
					<?php include('errors.php');?>
							<?php if ($Sucess!="") {?>
				<div class="mySuccess">
					<?php echo $Sucess; ?>
				</div>
						<?php  } ?>
			</div>
		</div>
	</div>
	<div class="col-lg-1 col-md-1"></div>
</div>


<div class="row">
	<div class="col-lg-1 col-md-1"></div>
	<div class="col-lg-10 col-md-10 col-xs-12 myRowBorder" style="border-bottom: none;">
		<div class="mySubRowBorder">
			<u  style="color: #1222B5;"><h2 class="text-center">RESET PASSWORD</h2></u>
		</div>

		<div class="row">
			<div class="col-lg-12 col-md-12 col-xs-12">
				<p class="font-italic text-center">We have sent you a email with verification code on<span class="font-weight-bold alert">"<?php echo $reset_email; ?>"</span>. <br>Check your inbox and enter the code below to verify your account. <br>Check your spam folder also, sometimes it stores on it also. <br>The code we have sent you for verification will be valid for one day(24 hour) only.</p>
	 		</div>
		</div>
	</div>
	<div class="col-lg-1 col-md-1"></div>
</div>


<!-- -----------IF CODE IS ALREADY/NOW SENT------------ -->

<div class="row">
	<div class="col-lg-1 col-md-1"></div>
	<div class="col-lg-10 col-md-10 col-xs-12 myRowBorder" style="border-top: none;">
		<div class="row">
			<div class="col-lg-4 col-md-4"></div>
			<div class="col-lg-4 col-md-4 col-xs-12 shadow-lg" style="background-color: #f2f2f2;"><br>
				<form action="" method="post">

					<div class="form-group">
		      			<label for="otp_code" class="font-weight-bold">Enter the code you have received: </label>
		      			OE-<input type="tel" class="form-control" id="otp_code" placeholder="Enter 6 digit code" maxlength="6" name="otp_code">
		    		</div>

					<div>
						<button type="submit" class="btn btn-primary" style="width: 150px;" id="value_submit_btn" name="otp_submit">SUBMIT</button>
			            <button type="submit" id="clickable_btn" class="btn btn-default myLoginBtn" name="resend_otp">Resend</button>
					</div>

					<div>
			 			<p>Remember ? <a style="text-decoration: none;" href="login.php">Try loging.</a></p>
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
<?php 
	}  
	else{
		header("Location:resetpwd.php");
	}
?>
