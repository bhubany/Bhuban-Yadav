<?php
	date_default_timezone_set('Asia/Kathmandu');
	// require 'db.php';
	$errors=array();
	$sucess=array();
	



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

if (isset($_POST['reg_user'])) {
	
	$firstName=$_POST['firstName'];
	$middleName=$_POST['middleName'];
	$surName=$_POST['surName'];
	$dob_ad=Date('Y-m-d');
	$dob_bs=$_POST['dob_bs'];
	$contact1=$_POST['contact_1'];
	$contact2=$_POST['contact_2'];
	$reg_username=stripslashes($_REQUEST['username']);
	$reg_username =mysqli_real_escape_string($con, $reg_username);
	$reg_email=stripslashes($_REQUEST['email']);
  	$reg_email= mysqli_real_escape_string($con, $reg_email);
  	$password_1=stripslashes($_REQUEST['password_1']);
  	$password_1 = mysqli_real_escape_string($con, $password_1);
  	$password_2=stripslashes($_REQUEST['password_2']);
  	$password_2 = mysqli_real_escape_string($con, $password_2);
	$created_at=date("Y-m-d H:i:s");
	$reset_code=md5($reg_username);
	$is_active=0;
	$sql_u="SELECT * FROM user_information WHERE username='$reg_username'LIMIT 1";
	$sql_e="SELECT * FROM user_information WHERE email='$reg_email'LIMIT 1";
	$res_u=mysqli_query($con,$sql_u) or die(mysqli_error($con));
	$res_e=mysqli_query($con,$sql_e) or die(mysqli_error($con));
// -----------FOR I AM NOT A ROBOT AND TERMS CONDITIONS----------------
	if (isset($_POST['robot'])) {
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
// -------------------------------------------------

//------------IF EMPTY------------------

	if (empty($reg_email)) {
		$name_error="Please enter your email";
	}
	if (empty($reg_username)) {
		$name_error="Please enter your username";
	}
//--------------------------------------------------	

// ---------IF USER NAME OR EMAIL IS ALREADY REGISTERED----------------
	if (mysqli_num_rows($res_u)>0) {
		$name_error="Sorry username already taken";
	}
	else if(mysqli_num_rows($res_e)>0)
		{
			$email_error="Already registered with this email try loging.";
		}
	else 
		{
	if(($password_1===$password_2))
		{
			$password=$password_1;
	$query = @"INSERT INTO user_information(firstname,middlename,surname,pcountry,pzone,pdistrict,pcity,ptole,username,email,contact1,contact2,tcountry,tzone,tdistrict,tcity,ttole,dob_bs,dob_ad,image,created_at,reset_code,is_active,password,verified)
	VALUES ('$firstName','$middleName', '$surName','NA','NA','NA','NA','NA','NA','NA','$contact1','$contact2','NA','NA','NA','NA','NA','$dob_bs','$dob_ad','$image_name','$created_at','$reset_code','$is_active','".md5($password)."','no')" ;
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
 						exit();
 				}
 				else{
 					$register_error="Error occurs during registration";
					}
 				}
				else{
					$register_error="Error occurs during registration";
				}

			}
			else{
				$register_error="Error occurs during registration";
			}
 			
 		}
	else
		{
		$password_error="Both password do not matched";
		}
	}

}



// !!!!!!!!!!***********LOGIN USERS**********!!!!!!!!!!!!//


$log_username="";
$log_uname="";
$log_pwd="";
$log_eml="";
$log_email="";
$log_remember="";
$log_robot="";

if (isset($_POST['log_user'])){
	// Cleaning Values
	$log_username=clean_values($con,$_REQUEST['username']);
	$log_password=clean_values($con,$_REQUEST['password']);

	if (clean_values($con,isset($_POST['robot']))) {
		$log_robot=1;
	}
	else{
		$log_robot=0;
	}
	if (clean_values($con,isset($_POST['remember']))) {
		$log_rem=1;
	}
	else{
		$log_rem=0;
	}

	if (empty($log_username)) {
    	array_push($errors, "Username is required");
  	}elseif (strlen($log_username)>50) {
  		array_push($errors, "Invalid username or password");
  	}

  	if (empty($log_password)){
    	array_push($errors, "Password is required");
	}elseif (strlen($log_password)>20) {
		array_push($errors, "Invalid username or password");
	}
	
	if ($log_robot!=1){
    	array_push($errors, "Check I am not a Robot.");
	}

	if (count($errors) == 0) {
	
		$login_password = md5($log_password);
		$query="SELECT * FROM user_information WHERE (username='$log_username' or email='$log_username') and password='$login_password' ";
		$result=mysqli_query($con,$query) or die(mysqli_error($con));
		
		while($rows=mysqli_fetch_assoc($result)) {
				$log_uname=$rows['username'];
				$log_pwd=$rows['password'];
				$log_eml=$rows['email'];
				$log_id=$rows['id'];
				$active=$rows['is_active'];
		}


		if ($log_uname===$log_username || $log_eml===$log_username) {
			if ($login_password===$log_pwd) {
				if ($active==1){


					$_SESSION['username']=$log_uname;
					
						#redirect to index.php
					header("Location:dashboard.php");
					if ($log_rem===1) {
						setcookie('pwd',$log_password,time()+7*24*60*60);
						setcookie('uname',$log_username,time()+7*24*60*60);
					}
				}
				else if ($active==10) {
					// $_SESSION['active']=10;
					 $_SESSION['conf_email']=$log_eml;
					header("Location:acountdeleted.php");
				}

				else{
					// $_SESSION['active']=11;
					$_SESSION['conf_email']=$log_eml;
					header("Location:conform.php");
				}
			}
			else{
				array_push($errors, "Wrong username/password combination");
			}
		}
		else
			{
			array_push($errors, "Wrong username/password combination");
		}
	}
}


//!!!!!********UPDATE DETAILS**********!!!!!!!!!!!!//


// $status = "";
// if(isset($_POST['update_user']))
// {
// // $id=$_REQUEST['id'];
 
// $update_firstName =$_REQUEST['firstname'];
// $update_middleName =$_REQUEST['middlename'];
// $update_surName =$_REQUEST['surname'];
// $update_pCountry=$_REQUEST['pcountry'];
// $update_pZone=$_REQUEST['pzone'];
// $update_pDistrict=$_REQUEST['pdistrict'];
// $update_pCity=$_REQUEST['pcity'];
// $update_pTole=$_REQUEST['ptole'];
// $update_tCountry=$_REQUEST['tcountry'];
// $update_tZone=$_REQUEST['tzone'];
// $update_tDistrict=$_REQUEST['tdistrict'];
// $update_tCity=$_REQUEST['tcity'];
// $update_tTole=$_REQUEST['ttole'];
// $update_Dob_bs=$_REQUEST['dob_bs'];
// $update_contact1=$_REQUEST['contact1'];
// $update_contact2=$_REQUEST['contact2'];
// $old_password=$_REQUEST['oldPassword'];


// 	if (empty($update_firstName)) 
// 		 {
//     	array_push($errors, "Old password is required");
//   		 }
// 	if (empty($update_surName)) 
// 		 {
//     	array_push($errors, "Enter new password ");
//   		 }
// 	if (empty($update_pCountry)) 
// 		 {
//     	array_push($errors, "Enter new password again");
//   		 }
//   	if (empty($update_pZone)) 
// 		 {
//     	array_push($errors, "Old password is required");
//   		 }
// 	if (empty($update_pDistrict)) 
// 		 {
//     	array_push($errors, "Enter new password ");
//   		 }
// 	if (empty($update_pCity)) 
// 		 {
//     	array_push($errors, "Enter new password again");
//   		 }
//   	if (empty($update_pTole)) 
// 		 {
//     	array_push($errors, "Old password is required");
//   		 }
// 	if (empty($update_tCountry)) 
// 		 {
//     	array_push($errors, "Enter new password ");
//   		 }
// 	if (empty($update_tZone)) 
// 		 {
//     	array_push($errors, "Enter new password again");
//   		 }
//   	if (empty($update_tDistrict)) 
// 		 {
//     	array_push($errors, "Old password is required");
//   		 }
// 	if (empty($update_tCity)) 
// 		 {
//     	array_push($errors, "Enter new password ");
//   		 }
// 	if (empty($update_tTole)) 
// 		 {
//     	array_push($errors, "Enter new password again");
//   		 }
//   	if (empty($update_Dob_bs)) 
// 		 {
//     	array_push($errors, "Old password is required");
//   		 }
// 	if (empty($update_contact1)) 
// 		 {
//     	array_push($errors, "Enter new password ");
//   		 }
// 	if (empty($old_password)) 
// 		 {
//     	array_push($errors, "Password is required");
//   		 }

//   	if (count($errors) == 0) {
// 	$old_password = md5($old_password);
// 	$query="SELECT * FROM user_information WHERE id='$id' LIMIT 1";
// 	$result=mysqli_query($con,$query) or die(mysqli_error($con));
// 	while ($rows=mysqli_fetch_assoc($result)) {
// 			$registered_password=$rows['password'];
// 			// $log_pwd=$rows['password'];
// 			// $log_eml=$rows['email'];
// 		}
// if ($old_password===$registered_password) 
// 	{
// 		$update="UPDATE user_information SET firstname='$update_firstName',
// 					middleName='$update_middleName', surname='$update_surName', pcountry='$update_pCountry',pzone='$update_pZone', pdistrict='$update_pDistrict', pcity='$update_pCity', ptole='$update_pTole',tcountry='$update_tCountry',tzone='$update_tZone', tdistrict='$update_tDistrict', tcity='$update_tCity', ttole='$update_tTole', contact1='$update_contact1', contact2='$update_contact2', updated_date='$update_date' where id='$id' LIMIT 1";
// 	$details_update = mysqli_query($con, $update) or die(mysqli_error($con));
// 	if ($details_update==1) {
// 			array_push($sucesses, "Your details has been updated sucessfully");
// 				}
// 	else
// 		{
// 	array_push($errors, "ERROR OCCURS DURING UPDATING DETAILS");
// 		}

// }
// else{
// 	array_push($errors,"!!! Incorrect Password !!!");
// 	}
// }
// }

//  // !!!!!!!!!******** PASSWORD CHANGING ************!!!!!!!!!!!!//



// $registered_password="";
// // $id="";
// if (isset($_POST['change_pwd'])) {
// 		# removes backslashes
// 		$old_password=stripslashes($_REQUEST['oldpassword']);
// 		#escapes special characters in a string
// 		$old_password=mysqli_real_escape_string($con,$old_password);
// 		$new_password=stripslashes($_REQUEST['newpassword']);
// 		$new_password=mysqli_real_escape_string($con,$new_password);
// 		$conform_pwd=stripslashes($_REQUEST['conformpwd']);
// 		$conform_pwd=mysqli_real_escape_string($con,$new_password);	

// 		// Checking errors on passwords

// 	if (empty($old_password)) 
// 		 {
//     	array_push($errors, "Old password is required");
//   		 }
// 	if (empty($new_password)) 
// 		 {
//     	array_push($errors, "Enter new password ");
//   		 }
// 	if (empty($conform_pwd)) 
// 		 {
//     	array_push($errors, "Enter new password again");
//   		 }


// 		//	 !!!!!!***** checking is there any error on changing password********//////
// 	if (count($errors) == 0) {
// 		$old_password = md5($old_password);
// 	$query="SELECT * FROM user_information WHERE id='$id' LIMIT 1";
// 		$result=mysqli_query($con,$query) or die(mysqli_error($con));
// 		// $rows=mysqli_num_rows($result);
// 		while ($rows=mysqli_fetch_assoc($result)) {
// 			$registered_password=$rows['password'];
// 			// $log_pwd=$rows['password'];
// 			// $log_eml=$rows['email'];
// 		}

//   if ($old_password===$registered_password) 
// 	{
// 	  if ($new_password===$conform_pwd) 
// 	    {
// 			$pwd=md5($new_password);
// 			$update="UPDATE user_information SET password='$pwd' WHERE id='$id' LIMIT 1";
// 			$password_changed=mysqli_query($con,$update) or die(mysqli_error($con));
// 				if ($password_changed==1) 
// 				{
			
// 			$Sucess= "Password has been changed sucessfully";
// 			// header("Location:dashboard.php");
// 			// exit();	
// 				}
// 		}
// 		else{
// 			array_push($errors, "New password did not matched on both box" );
// 			}
// 	}
// 	else
// 		{
// 		array_push($errors, "Incorrect old password");
// 		}

// 	}
// }


// !!!!!!!!!******** RESET PASSWORD ************!!!!!!!!!!!!//

$reset_email="";
$is_expired=0;
$otp=rand(100000,999999);
$created_at=Date('Y-m-d h:i:s:ms');
$reg_email="";
$reg_otp="";
$reg_date="";
$reg_is_expired="";
if (isset($_POST['resetpwd_user'])) {
	$resetpwd_email=stripslashes($_REQUEST['email']);
	$resetpwd_email=mysqli_real_escape_string($con,$resetpwd_email);

	if (empty($resetpwd_email)) {
		array_push($errors, "Please Enter email");
	}

	if (count($errors) == 0) {
		$query=@"SELECT * FROM user_information WHERE email='$resetpwd_email' LIMIT 1";
		$result=mysqli_query($con,$query) or die(mysqli_error($con));
		while ($rows=mysqli_fetch_assoc($result)) {
			$reset_email=$rows['email'];
		}
		// if ($result==1) {
			if ($resetpwd_email===$reset_email) {
				$qry_is_otp=@"SELECT * FROM otp_expiry WHERE email='$resetpwd_email' AND is_expired='1' LIMIT 1";
				$qry_is_otp_res=mysqli_query($con,$qry_is_otp) or die();
				while ($qry_is_otp_res_row=mysqli_fetch_assoc($qry_is_otp_res)) {
					$reg_email=$qry_is_otp_res_row['email'];
					$reg_otp=$qry_is_otp_res_row['otp'];
					$reg_date=$qry_is_otp_res_row['created_at'];
					$reg_is_expired=$qry_is_otp_res_row['is_expired'];
					// echo $reg_email.$reg_date.$reg_otp.$reg_is_expired;
				}

				$otp_qry=@"INSERT INTO otp_expiry(email,otp,is_expired,created_at) VALUES('$reset_email',$otp,$is_expired,'$created_at')";
				$otp_res=mysqli_query($con,$otp_qry) or die($con);
				if ($otp_qry==1) {
				array_push($sucess, "We have sent verification email please check it");
				// header("Location:conform.php");
				// exit();
			}
			}
			else{
				array_push($errors, "Email ".$resetpwd_email." you have entered is not registered yet, Try registering");
			}
		// }
		// else{
			// array_push($errors, "Email you have entered is not registered yet, Try registering".$reset_email.$resetpwd_email.$rows);
			// array_push($errors, "Please Enter Registered Email");
		// }
		}
}
// }

 ?>

