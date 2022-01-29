<?php
    session_start();
	require 'db.php';
	require 'includes/functions.php';
	// require 'server.php';
	if (isset($_SESSION["username"])) {
	 	header("Location:dashboard.php");
	}
	elseif (isset($_SESSION['conf_email'])) {
?>

<?php

$errors=array();
$Sucess="";
$reg_otp="";
$tried_times="";
$new_tried="";
$condition=0;
$email_sent=1;
$sent_email=$_SESSION['conf_email'];
// echo $_SESSION['conf_email'];
$now= date("Y-m-d H:i:s");
// echo $sent_email;

if (clean_values($con,isset($_POST['otp_submit']))) {
	$input_otp=clean_values($con,$_REQUEST['input_otp']);

	if (empty($input_otp)) {
		array_push($errors, "Enter valid six digit code.");
	}elseif (strlen($input_otp)!=6 or !is_numeric($input_otp)) {
		array_push($errors, "Enter valid six digit code");
	}

	if (count($errors) == 0) {
		$qry_is_otp=@"SELECT * FROM otp_expiry WHERE email='$sent_email' AND is_expired=0 LIMIT 1";
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
			$qry_attempt=@"UPDATE otp_expiry SET tried_times='$new_tried' WHERE email='$sent_email'";
			$qry_attempt_res=mysqli_query($con,$qry_attempt) or die($con);
			if ($qry_attempt_res==1) {
				if ($input_otp===$reg_otp) {
					if (($now<=$expiry_date) and ($tried_times<=5)) {
						$qry_chng_act=@"UPDATE user_information SET is_active='1' WHERE email='$sent_email' LIMIT 1";
						$qry_chng_act_res=mysqli_query($con,$qry_chng_act) or die($con);
						if ($qry_chng_act_res==1) {
							$qry_otp_exp=@"UPDATE otp_expiry SET is_expired=1,is_action_performed=1 WHERE email='$sent_email' AND otp=$input_otp";
							$qry_otp_exp_res=mysqli_query($con,$qry_otp_exp) or die($con);
							if ($qry_otp_exp_res==1) {
								$Sucess="Your email has been verified sucessfully <a href='login.php'> click here</a> to Login.";
							}
						}	
					}else{
						$qry_exp_otp=@"UPDATE otp_expiry SET is_expired=1 WHERE email='$sent_email' AND otp=$input_otp";
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
			$qry_already_verified=@"SELECT * FROM otp_expiry WHERE (email='$sent_email' AND otp=$input_otp) AND is_action_performed=1 LIMIT 1";
			$qry_already_verified_res=mysqli_query($con,$qry_already_verified) or die($con);
			if (mysqli_num_rows($qry_already_verified_res)>0) {
				$Sucess="Your email has already verified <a href='login.php'> click here</a> to Login.";
			}else{
				array_push($errors, "You might have entered wrong codes so many time or code has been expired. Please request for new one.");
			}
		}
	}
}


// ----------------Sending OtP code again-------------
if (clean_values($con,isset($_POST['resend_otp']))) {
  $requested_email=clean_values($con,$_SESSION['conf_email']);
  
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
	<title>ONLINE ENTRANCE- Email verification</title>
</head>

<style type="text/css">

</style>

<?php include 'header.php'; ?>

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

<div class="row">
	<div class="col-lg-1 col-md-1"></div>
	<div class="col-lg-10 col-md-10 col-xs-12 myRowBorder" style="border-bottom: none;">
		<div class="mySubRowBorder">
			<u  style="color: #1222B5;"><h2 class="text-center">THANK YOU FOR JOINING WITH US</h2></u>
		</div>

		<div class="row">
			<div class="col-lg-12 col-md-12 col-xs-12">
				<p class="font-italic text-center">We have sent you a email with verification code on<span class="font-weight-bold alert">"<?php echo $sent_email; ?>"</span>. <br>Check your inbox and enter the code below to verify your account. <br>Check your spam folder also, sometimes it stores on it also. <br>The code we have sent you for verification will be valid for one day(24 hour) only.</p>
	 		</div>
		</div>
	</div>
	<div class="col-lg-1 col-md-1"></div>
</div>



<div class="row">
	<div class="col-lg-1 col-md-1"></div>
	<div class="col-lg-10 col-md-10 col-xs-12 myRowBorder" style="border-top: none;">
		<div class="row">
			<div class="col-lg-4 col-md-4"></div>
			<div class="col-lg-4 col-md-4 col-xs-4 shadow-lg" style="background-color: #f2f2f2;">
				<form method="post" action="">
				 	<div class="text-center">
						<label for="input_otp" class="font-weight-bold">Enter the code you have received:</label>
						OE-<input type="tel" name="input_otp" class="form-control" id="input_otp" placeholder="Enter code" maxlength="6">
					</div>
					<div class="text-center" style="padding-top: 10px;">
						<button type="submit" class="btn btn-primary" style="width: 150px;" id="value_submit_btn" name="otp_submit">SUBMIT</button>
			            <button type="submit" id="clickable_btn" class="btn btn-default myLoginBtn" name="resend_otp">Resend</button>
					</div>
					<div class="text-center">
						<p>Already verified?<a style="text-decoration: none;" href="login.php"> login.</a></p>
					</div>
				</form>
			</div>
			<div class="col-lg-4 col-md-4"></div>
		</div>
	</div>
	<div class="col-lg-1 col-md-1"></div>
</div>

<?php include 'footer.php'; ?>

<?php 
	}  
	else{
		header("Location:login.php");
	}
 ?>