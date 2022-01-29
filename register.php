 <?php 
require 'db.php';
require 'includes/functions.php';
require 'secure/mail.php';
session_start();
if (isset($_SESSION["username"])) {
 	header("Location:dashboard.php");
 } 
 else
 	{ ?>


<?php
	date_default_timezone_set('Asia/Kathmandu');
	$errors=array();
	// $sucess=array();
	


//-----------IP ADDRESS-----------
$ip_address="";
//whether ip is from share internet
if (!empty($_SERVER['HTTP_CLIENT_IP']))   
  {
    $ip_address = $_SERVER['HTTP_CLIENT_IP'];
  }
//whether ip is from proxy
elseif (!empty($_SERVER['HTTP_X_FORWARDED_FOR']))  
  {
    $ip_address = $_SERVER['HTTP_X_FORWARDED_FOR'];
  }
//whether ip is from remote address
else
  {
    $ip_address = $_SERVER['REMOTE_ADDR'];
  }

//!!!!!************REGISTER USERS*************!!!!!!!!!!//


	$reg_username="";
	$reg_email="";
	$firstName="";
	$middleName="";
	$surName="";
	$pCountry="";
	$pZone="";
	$pDistrict="";
	$pCity="";
	$pTole="";
	$tCountry="";
	$tZone="";
	$tDistrict="";
	$tCity="";
	$tTole="";
	$dob_bs="";
	$contact1="";
	$contact2="";
	$is_expired=0;
	$is_action_performed=0;
	$image_name="onlineEntrance.jpg";

if (clean_values($con,isset($_POST['reg_user']))) {
	// imap_alerts("good");
	$firstName=clean_values($con,$_POST['firstName']);
	$middleName=clean_values($con,$_POST['middleName']);
	$surName=clean_values($con,$_POST['surName']);
	$dob_ad=clean_values($con,Date('Y-m-d'));
	$dob_bs=clean_values($con,$_POST['dob_bs']);
	$contact1=clean_values($con,$_POST['contact_1']);
	$contact2=clean_values($con,$_POST['contact_2']);
	$reg_username=clean_values($con,$_REQUEST['username']);
	$reg_email=clean_values($con,$_REQUEST['email']);
	$reg_email = filter_var($reg_email, FILTER_SANITIZE_EMAIL);
  	$password_1=clean_values($con,$_POST['password_1']);
  	$password_2=clean_values($con,$_POST['password_2']);
	$created_at=clean_values($con,date("Y-m-d H:i:s"));
	$reset_code=clean_values($con,md5($reg_username));


		// ----------------VALIDATING NAME------------
	if (empty($firstName)) {
		array_push($errors,"Please enter your First Name");
	}elseif (strlen($firstName)>30) {
		array_push($errors,"First Name can't be more than 30 characters");
	}elseif (!is_string($firstName) or is_numeric($firstName)) {
		array_push($errors, "Please enter your valid first name");
	}

	if (!empty($middleName)) {
		if (strlen($middleName)>30) {
			array_push($errors,"Please enter your valid Middle Name which can't be more than 30 characters.");
		}elseif (!is_string($middleName) or is_numeric($middleName)) {
			array_push($errors, "Please enter valid middle name");
		}
	}

	if (empty($surName)) {
		array_push($errors,"Please enter your Surname");
	}elseif (strlen($surName)>30) {
		array_push($errors,"Surname can't be more than 30 characters");
	}elseif (!is_string($surName) or is_numeric($surName)) {
		array_push($errors, "Please enter your valid last name");
	}


		// --------------VALIDATING DOB---------
	if (empty($dob_bs)) {
		array_push($errors,"Please enter your Date of Birth In B.S.");
	// }elseif (!is_numeric($dob_bs)) {
		// array_push($errors, "Please enter valid Date of Birth In B.S. (DOB)");
	}elseif (strlen($dob_bs)!=10) {
		array_push($errors, "len Please enter valid Date of Birth In B.S. (DOB)");
	}

	if (empty($dob_ad)) {
		array_push($errors,"Please enter your Date of Birth In A.D.");
	// }elseif (!is_numeric($dob_ad)) {
		// array_push($errors, "Please enter valid Date of Birth In A.D. (DOB)".$dob_ad);
	}elseif (strlen($dob_ad)!=10) {
		array_push($errors, "Please enter valid Date of Birth In A.D. (DOB)");
	}


		// -------------VALIDATING CONTACT Number-------
	if (empty($contact1)) {
		array_push($errors,"Please enter your Primary Contact Number.");
	}elseif (!is_numeric($contact1)) {
		array_push($errors,"Please enter your valid primary contact number.");
	}elseif (strlen($contact1)<9 or strlen($contact1)>15) {
		array_push($errors,"Please enter your valid primary contact number.");
	}

	if (!empty($contact2)) {
		if (!is_numeric($contact2)) {
			array_push($errors,"Please enter your valid secondary contact number.");
		}elseif (strlen($contact2)<9 or strlen($contact1)>15) {
			array_push($errors,"Please enter your valid secondary contact number.");
		}
	}


		// ---------VALIDATING LOGIN DETAILS------------

	if (empty($reg_username)) {
		array_push($errors,"Please Enter your unique username");
	}elseif (strlen($reg_username)<5 or strlen($reg_username)>50) {
		array_push($errors, "Username must be lie between 5 to 50 characters");
	}elseif (is_numeric($reg_username)) {
		array_push($errors, "Username cant be numeric value only. Keep combination of number and character.");
	}elseif (strrpos($reg_username," ")) {
		array_push($errors, "Username cant contain any spaces. Keep combination of number and character.");

	if (empty($reg_email)) {
		array_push($errors,"Please enter your email");
	}elseif (!filter_var($reg_email, FILTER_VALIDATE_EMAIL)) {
		array_push($errors, "Please enter valid email");
	}elseif (strlen($reg_email)<8 or strlen($reg_email)>50) {
    	array_push($errors, "Please enter valid email");
  	}

	if (empty($password_1)) {
		array_push($errors,"Please enter your Password");
	}elseif (strlen($password_1)<8 or strlen($password_1)>20) {
		array_push($errors, "Password must lies between 8 to 20 characters.");
	}

	if (empty($password_2)) {
		array_push($errors,"Please conform your Password");
	}elseif (strlen($password_2)<8 or strlen($password_2)>20) {
		array_push($errors, "Password must lies between 8 to 20 characters.");
	}

	if ($password_1!==$password_2) {
		array_push($errors, "Both Password did not matched");
	}

	// -----------FOR I AM NOT A ROBOT AND TERMS CONDITIONS----------------
	if (clean_values($con,isset($_POST['robot']))) {
		$reg_robot=1;
		}
		else{
			$reg_robot=0;
		}
	if (isset($_POST['termsConditions'])) {
			$reg_term=1;
		}
		else{
			$reg_term=0;
		}

	if ($reg_robot!=1)
  		{
    	array_push($errors, "Check I am not a Robot.");
		}
	if ($reg_term!=1) {
		array_push($errors, "You must agree to our terms and conditions. Please read it carefully.<a href='privacy_policy.php' target='blank'> Click here</a> to read ");
	}

// ----------------MAIN SECTION-------------------

	if (count($errors) == 0) {
		// ---------IF USER NAME OR EMAIL IS ALREADY REGISTERED----------------
		$sql_u="SELECT * FROM user_information WHERE username='$reg_username'LIMIT 1";
		$sql_e="SELECT * FROM user_information WHERE email='$reg_email'LIMIT 1";
		$res_u=mysqli_query($con,$sql_u) or die(mysqli_error($con));
		$res_e=mysqli_query($con,$sql_e) or die(mysqli_error($con));
		
		if (mysqli_num_rows($res_u)>0) {
			array_push($errors, "Sorry username already taken.");
		}
		else if(mysqli_num_rows($res_e)>0){	
			array_push($errors, "Already registered with this email try loging."."<a style='text-decoration: none;' href='login.php'>Click here.</a>");
		}
		else{
			if(($password_1===$password_2)){
				$password=$password_1;
				$query = @"INSERT INTO user_information(firstname,middlename,surname,pcountry,pzone,pdistrict,pcity,ptole,username,email,contact1,contact2,tcountry,tzone,tdistrict,tcity,ttole,dob_bs,dob_ad,image,created_at,about_me,is_active,password,verified,is_email_verified,user_ip)
				VALUES ('$firstName','$middleName', '$surName','NA','NA','NA','NA','NA','$reg_username','$reg_email','$contact1','$contact2','NA','NA','NA','NA','NA','$dob_bs','$dob_ad','$image_name','$created_at','Na',0,'".md5($password)."','no','1','$ip_address')" ;
				$result=mysqli_query($con,$query) or die (mysqli_error($con));
				if ($result==1) {
					# Generating verification code
					$otp=rand(100000,999999);	//GENERATES OTP


// ----------------------SEND EMAIL FROM HERE----------------------------
					$to=$reg_email;
					$name=$firstName.' '.$middleName.' '.$surName;
					$subject='VERIFY YOUR ONLINE ENTRANCE ACCOUNT';
					$msg='Your account for ONLINE ENTRANCE has been created sucessfully.';
					$mail_sent=sendMail($to,$name,$otp,$subject,$msg);
					$mail_sent=1;	//CONCLUDE THAT MAIL WAS SENT TO REGSTERED USER

					if ($mail_sent==1) {
						$will_expired = date("Y-m-d H:i:s",strtotime('+1 day +0 hour +0 minutes +0 seconds',strtotime($created_at)));
						$exp_query=@"INSERT INTO otp_expiry(email,otp,is_expired,is_action_performed,created_at,will_expired)
									VALUES ('$reg_email',$otp,$is_expired,'$is_action_performed','$created_at','$will_expired')";
						$exp_result=mysqli_query($con,$exp_query) or die(mysqli_error($con));
						if($exp_result==1){
							$_SESSION['conf_email']=$reg_email;
							header("location:conform.php");
						}
						else{
							array_push($errors, "Error occurs try again Later.");
						}
					}
					else{
							array_push($errors, "Error occurs try again Later.");
					}
 				}
 				else{
 					array_push($errors, "Error occurs while registering try again Later.");
				}
 			}
			else{
				array_push($errors, "Both Password did not matched.");
			}

		}
	}
}

?>





<head>
	<title>Registration System-Online Entrance</title>
	<!-- <link rel="stylesheet" type="text/css" href="assests/css/reg_style.css"> -->
	<script src="assests/js/check.js" type="text/javascript"></script>
</head>


<?php include 'header.php'; ?>
<?php include 'nav.php'; ?>


<div class="row">
	<div class="col-lg-1 col-md-1"></div>
	<div class="col-lg-10 col-md-10 col-xs-12 myContainer">
		<div class="row">
			<div class="col-lg-2 col-md-2"></div>
			<div class="col-lg-8 col-md-8 col-xs-8">
				<div class="myForm">
		  			<div class="myFormTitle mySubRowBorder">
		  				<u style="color: #1222B5; font-weight: bold;"><h2>REGISTER</h2></u>
						<!-- <h4 class="text-warning">Please leave this page if you are not authorised persons.</h4> -->
						<h4 class="text-info">Please enter your correct details. (<span class="text-danger"> * </span>Includes required fields are compulsory.)</h4>
					</div>

					<div class="mySubRowBorder">
	    				<?php include 'errors.php'; ?>
					</div>

					<div class="mySubRowBorder text-center" id="jsError">
		
					</div>

					<form action="" class="" method="post" onsubmit="return validated();">

							<!-- !!!*********PRINTINGs ERRORS.**********!!!! -->
							<br>
							<?php //include 'errors.php'; ?>
						<label for="inputName" class="font-weight-bold text-center">Name :<span class="text-danger"> * </span></label>
					  	<div class="form-row">
						    <div class="col">
						    	<span class="help-block">First Name</span>
						      <input type="text" class="form-control" name="firstName" id="firstName" placeholder="First name" minlength="" maxlength="30" required="on" value="<?php echo $firstName; ?>">
						    </div>

						    <div class="col">
						    	<span class="help-block">Middle Name</span>
						      <input type="text" class="form-control" name="middleName" id="middleName" placeholder="Middle Name" minlength="" maxlength="30" value="<?php echo $middleName; ?>">
						    </div>

						    <div class="col">
						    	<span class="help-block">Surname</span>
						      <input type="text" class="form-control" id="surName" name="surName" placeholder="Last name" minlength="" maxlength="30" required="on" value="<?php echo $surName; ?>">
						    </div>
						</div>

						<label for="inputName" class="font-weight-bold">Date OF Birth :<span class="text-danger"> * </span></label>
						<div class="form-row">
						    <div class="col">
						    	<span class="help-block">B.S.</span>
						      <input type="date" class="form-control" placeholder="First name" required="on" name="dob_bs" id="dob_bs" value="<?php echo $dob_bs; ?>">
						    </div>

						    <div class="col">
						    	<span class="help-block">A.D.</span>
						      <input type="date" class="form-control" name="dob_ad" id="dob_ad" readonly="" value="<?php echo $dob_ad; ?>">
						    </div>
						</div>


						<label for="inputName" class="font-weight-bold">Contact :<span class="text-danger"> * </span></label>
						<div class="form-row">
						    <div class="col">
						    	<span class="help-block">Primary(Compulsory)</span>
						      <input type="tel" class="form-control" name="contact_1" id="contact_1" required="on" placeholder="+97798XXXXXXXX" minlength="9" maxlength="15" value="<?php echo $contact1; ?>">
						    </div>

						    <div class="col">
						    	<span class="help-block">Secondary(Optional)</span>
						      <input type="tel" class="form-control" placeholder="+97798XXXXXXXX" minlength="9" maxlength="15" name="contact_2" id="contact_2" value="<?php echo $contact2; ?>">
						    </div>
						</div>

						<label for="inputUsername" class="font-weight-bold">Username :<span class="text-danger"> * </span></label>
						<div class="form-row">
						    <div class="col">
						      	<input type="text" class="form-control" name="username" placeholder="Username" minlength="5" maxlength="50" required="on" id="username" value='<?php echo $reg_username;?>' minlength="5" maxlength="50" onkeyup="checkUname();"><span id="umessage"></span>
						 		<span class="help-block text-info">Keep username unique and must be of minimum 5 and maximum 50 characters.</span>
						    </div>
						</div>

						<label for="inputUsername" class="font-weight-bold">Email :<span class="text-danger"> * </span></label>
						<div class="form-row">
						    <div class="col">
						      	<input type="email" class="form-control" name="email" id="email" minlength="8" maxlength="50" required="on" placeholder="someone@gmail.com" value="<?php echo $reg_email; ?>">
						 		<!-- <span class="help-block">Keep username unique and must be of minimum 5 and maximum 50 characters.</span> -->
						    </div>
						</div>

						<label for="inputPassword" class="font-weight-bold">Password :<span class="text-danger"> * </span></label>
						<div class="form-row">
						    <div class="col">
						 		<span class="help-block">Enter Password :</span>
						      	<input type="password" class="form-control" name="password_1" id="password_1" placeholder="Enter password" onkeyup='checkPwd();' minlength="8" maxlength="20" required="on">
						    </div>

						    <div class="col">
						 		<span class="help-block">Conform Password :</span>
						      	<input type="password" class="form-control" placeholder="conform Password" name="password_2" id="password_2" placeholder="Conform password" onkeyup='checkPwd();' minlength="8" maxlength="20" required="on"> <span id='message'></span>
						    </div>
						    <span class="help-block text-info">Password mut be of minimum 8 and maximum 20 charactes. For strong password you must enter one big letter, special character and number.</span>
						</div>

						<div class="custom-control custom-checkbox mb-3 was-validated">
						    <input type="checkbox" class="custom-control-input" id="customControlValidation1" name="termsConditions" required value="1">
						    <label class="custom-control-label" for="customControlValidation1">I agree with the every terms, conditions and policy of this website.<a style="text-decoration: none;" href="privacy_policy.php" target="blank"> Click here</a> to read the terms and conditions.</label>
						    <!-- <div class="invalid-feedback">Example invalid feedback text</div> -->
						</div>

						<div class="custom-control custom-checkbox mb-3 was-validated">
						    <input type="checkbox" class="custom-control-input" id="customControlValidation2" name="robot" required value="1">
						    <label class="custom-control-label" for="customControlValidation2">I Am not a Robot?</label>
						    <!-- <div class="invalid-feedback">Example invalid feedback text</div> -->
						</div>

						<div>
							<button type="submit" class="btn btn-primary btn-lg btn-block" name="reg_user">Register</button>
						</div>
					</form>

					<div class="text-center">
						<p>ALREADY REGISTERED? <a style="text-decoration: none;" href="login.php">LOGIN.</a></p>
					</div>
				</div>
			</div>
		</div>
		<div class="col-lg-2 col-md-2"></div>
	</div>
	<div class="col-lg-1 col-md-1"></div>
</div>

<?php include("footer.php") ?>
<?php } ?>