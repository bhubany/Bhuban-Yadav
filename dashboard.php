<?php
if(!session_id()){
  session_start();
}?>

<?php 
  date_default_timezone_set('Asia/Kathmandu');
	require('db.php');
	require ("auth.php");
  require 'includes/functions.php';
  $errors=array();
  $Sucess="";
	$username=$_SESSION['username'];
  $created_at=date("Y-m-d H:i:s");



// -------------------------CHANGING PROFILE PICTURES-----------------
if (clean_values($con,isset($_POST['upload_img']))) { 

  if ($_FILES['user_img']['size']==0) {
    array_push($errors, "Please select image first.");
  }
  
  //----If no errors---
  if (count($errors)==0) {
    $uploaded_name=$_FILES['user_img']['name'];
    $uploaded_ext=substr($uploaded_name, strrpos($uploaded_name, '.') +1);
    $uploaded_size=$_FILES['user_img']['size'];
    $uploaded_type=$_FILES['user_img']['type'];
    $uploaded_temp=$_FILES['user_img']['tmp_name'];

    //------Working paths
    $target_path="secure/user_images/";
    $target_file="onlineEntrance".$username.'.'.$uploaded_ext;
    $temp_file=((ini_get('upload_tmp_dir')=='')?(sys_get_temp_dir() ) : (ini_get('upload_tmp_dir') ) );
    $temp_file .=DIRECTORY_SEPARATOR.md5(uniqid(). $uploaded_name).'.'.$uploaded_ext;

    // ---------Is image ?------------
    if((strtolower($uploaded_ext)=='jpg' || strtolower($uploaded_ext)=='jpeg' || strtolower($uploaded_ext)=='png' || strtoupper($uploaded_ext)=='JPG' || strtoupper($uploaded_ext)=='JPEG' || strtoupper($uploaded_ext)=='PNG') && ($uploaded_type == 'image/jpeg' || $uploaded_type =='image/png') && getimagesize($uploaded_temp)) {  

      if ($uploaded_size<=204800) {
        //--------Creating new image by using previous data(i.e Striping metadata by re-encoding)--------
        if ($uploaded_type =='image/jpeg') {
          $img=@imagecreatefromjpeg($uploaded_temp);
          if($img!=""){
            $is_converted=imagejpeg($img,$temp_file,-1);
          }else{
            array_push($errors, "Invalid image format. Try another image.");
          }
    
        }elseif ($uploaded_type=='image/png') {
          $img=@imagecreatefrompng($uploaded_temp);
          if($img!=""){
            $is_converted=imagepng($img,$temp_file,-1);
          }else{
            array_push($errors,"Invalid image format. Try another image.");
          }
        }else{
          array_push($errors,"Invalid image format. Try another image.");
        }

       //------Can we move the file to the web root from temp folder----
        if ($img!="" && $is_converted!="") {
          $ren= rename($temp_file, (getcwd().DIRECTORY_SEPARATOR.$target_path.$target_file));//move the file
          imagedestroy($img);//clearing memory by deleting temp files
          if ($ren==1) {
            // -----------Inserting into Db-------
            $qry_chng_act=@"UPDATE user_information SET image='$target_file' WHERE username='$username' LIMIT 1";
            $qry_chng_act_res=mysqli_query($con,$qry_chng_act) or die($con);
            if ($qry_chng_act_res==1) {
              $Sucess="Your profile picture has been updated sucessfully.";
            
            }else{
              $stat="Error occur during uploading your profile picture.";
            }
          }else{
            array_push($errors, "Error occurs try again later");
          }
        }else{
          array_push($errors,"Invalid image format. Try another image.");
        }
      }else{
          array_push($errors, "We only accept image size upto 200 KB. Decrease size and try again later.");
        }
    }else{
      array_push($errors, "Your Image was not uploaded. We only accept JPEG or PNG images.");
    }    
    //Deleting Temp files
    if (file_exists($temp_file)) {
      unlink($temp_file);
    }
  }
}

// -------------------CHANGING NAME OF USER-------------------


if (clean_values($con,isset($_POST['change_name']))) {
  $fname=clean_values($con,$_POST['fname']);
  $mname=clean_values($con,$_POST['mname']);
  $sname=clean_values($con,$_POST['sname']);

  if (empty($fname)) {
    array_push($errors, "First name is required");
  }elseif (strlen($fname)>30) {
    array_push($errors,"First Name can't be more than 30 characters");
  }elseif (!is_string($fname) or is_numeric($fname)) {
    array_push($errors, "Please enter your valid first name");
  }

  if (!empty($mname)) {
    if (strlen($mname)>30) {
      array_push($errors,"Please enter your valid Middle Name which can't be more than 30 characters.");
    }elseif (!is_string($mname) or is_numeric($mname)) {
      array_push($errors, "Please enter valid middle name");
    }
  }

  if (empty($sname)) {
    array_push($errors, "Sur name is required");
  }elseif (strlen($sname)>30) {
    array_push($errors,"Surname can't be more than 30 characters");
  }elseif (!is_string($sname) or is_numeric($sname)) {
    array_push($errors, "Please enter your valid last name");
  }

  if (count($errors)==0) {
    $update_name=@"UPDATE user_information SET firstname='$fname',middlename='$mname',surname='$sname' WHERE username='$username' LIMIT 1";
    $update_name_res=mysqli_query($con, $update_name) or die($con);
    if ($update_name_res==1) {
      $Sucess="Your name has been updated sucessfully";
    }
    else{
      array_push($errors, "Error occurs on updating your name");
    }
  }
}


// -----------------UPDATING PERMANENT ADDRESS-------------

if (clean_values($con,isset($_POST['update_paddress']))) {
  $pcountry=clean_values($con,$_POST['pcountry']);
  $pzone=clean_values($con,$_POST['pzone']);
  $pdistrict=clean_values($con,$_POST['pdistrict']);
  $pcity=clean_values($con,$_POST['pcity']);
  $ptole=clean_values($con,$_POST['ptole']);
  // echo $pcountry.$mname.$sname;
  if (empty($pcountry)) {
    array_push($errors, "Country is required");
  }elseif (strlen($pcountry)>30) {
    array_push($errors,"Country name can't be more than 30 characters");
  }elseif (!is_string($pcountry) or is_numeric($pcountry)) {
    array_push($errors, "Please enter your valid country name");
  }

  if (empty($pzone)) {
    array_push($errors, "Zone is required");
  }elseif (strlen($pzone)>30) {
    array_push($errors,"Zone name can't be more than 30 characters");
  }elseif (!is_string($pzone) or is_numeric($pzone)) {
    array_push($errors, "Please enter your valid Zonal name");
  }

  if (empty($pdistrict)) {
    array_push($errors, "District is required");
  }elseif (strlen($pdistrict)>30) {
    array_push($errors,"District name can't be more than 30 characters");
  }elseif (!is_string($pdistrict) or is_numeric($pdistrict)) {
    array_push($errors, "Please enter your valid District name.");
  }

  if (empty($pcity)) {
    array_push($errors, "City is required");
  }elseif (strlen($pcity)>40) {
    array_push($errors,"City name can't be more than 40 characters");
  }elseif (!is_string($pcity) or is_numeric($pcity)) {
    array_push($errors, "Please enter your valid city name.");
  }


  if (empty($ptole)) {
    array_push($errors, "Tole is required");
  }elseif (strlen($ptole)>40) {
    array_push($errors,"Tole name can't be more than 40 characters");
  }elseif (!is_string($ptole) or is_numeric($ptole)) {
    array_push($errors, "Please enter your valid Tole name.");
  }

  if (count($errors)==0) {
    $update_name=@"UPDATE user_information SET pcountry='$pcountry',pzone='$pzone',pdistrict='$pdistrict',pcity='$pcity',ptole='$ptole' WHERE username='$username' LIMIT 1";
    $update_name_res=mysqli_query($con, $update_name) or die($con);
    if ($update_name_res==1) {
      $Sucess="Your Permanent Address details has been updated sucessfully.";
    }
    else{
      $sucess=0;
      array_push($errors, "Error occurs on updating your details");
    }
  }
  // print_r($errors);
}


// --------------------UPDATING TEMPORARY ADDRESS--------------

//---------FOR TEMPORARY DETAILS----------
if (clean_values($con,isset($_POST['update_taddress']))) {
  $tcountry=clean_values($con,$_POST['tcountry']);
  $tzone=clean_values($con,$_POST['tzone']);
  $tdistrict=clean_values($con,$_POST['tdistrict']);
  $tcity=clean_values($con,$_POST['tcity']);
  $ttole=clean_values($con,$_POST['ttole']);
  // echo $pcountry.$mname.$sname;
  if (empty($tcountry)) {
    array_push($errors, "Country is required");
  }elseif (strlen($tcountry)>30) {
    array_push($errors,"Country name can't be more than 30 characters");
  }elseif (!is_string($tcountry) or is_numeric($tcountry)) {
    array_push($errors, "Please enter your valid country name");
  }

  if (empty($tzone)) {
    array_push($errors, "Zone is required");
  }elseif (strlen($tzone)>30) {
    array_push($errors,"Zone name can't be more than 30 characters");
  }elseif (!is_string($tzone) or is_numeric($tzone)) {
    array_push($errors, "Please enter your valid Zonal name");
  }

  if (empty($tdistrict)) {
    array_push($errors, "District is required");
  }elseif (strlen($tdistrict)>30) {
    array_push($errors,"District name can't be more than 30 characters");
  }elseif (!is_string($tdistrict) or is_numeric($tdistrict)) {
    array_push($errors, "Please enter your valid District name.");
  }

  if (empty($tcity)) {
    array_push($errors, "City is required");
  }elseif (strlen($tcity)>40) {
    array_push($errors,"City name can't be more than 40 characters");
  }elseif (!is_string($tcity) or is_numeric($tcity)) {
    array_push($errors, "Please enter your valid city name.");
  }

  if (empty($ttole)) {
    array_push($errors, "Tole is required");
  }elseif (strlen($ttole)>40) {
    array_push($errors,"Tole name can't be more than 40 characters");
  }elseif (!is_string($ttole) or is_numeric($ttole)) {
    array_push($errors, "Please enter your valid Tole name.");
  }

  if (count($errors)==0) {
    $update_name=@"UPDATE user_information SET tcountry='$tcountry',tzone='$tzone',tdistrict='$tdistrict',tcity='$tcity',ttole='$ttole' WHERE username='$username' LIMIT 1";
    $update_name_res=mysqli_query($con, $update_name) or die($con);
    if ($update_name_res==1) {
      $Sucess="Your Temporary Address details has been updated sucessfully.";
    }
    else{
      array_push($errors, "Error occurs on updating your details");
    }
  }
  // print_r($errors);
}


// !!!!!!!!!******** PASSWORD CHANGING ************!!!!!!!!!!!!//

if (clean_values($con,isset($_POST['change_pwd']))) {
    $old_password=clean_values($con,$_POST['oldpassword']);
    $new_password=clean_values($con,$_POST['newpassword']);
    $conform_pwd=clean_values($con,$_POST['conformpwd']);
    // Checking errors on passwords

    if (empty($old_password)) {
      array_push($errors, "Old password is required");
    }elseif (strlen($old_password)<8 or strlen($old_password)>20) {
      array_push($errors, "Incorrect old password.");
    }

    if (empty($new_password)) {
        array_push($errors, "Enter new password ");
    }elseif (strlen($new_password)<8 or strlen($new_password)>20) {
      array_push($errors, "Password must lies between 8 to 20 characters.");
    }
   
    if (empty($conform_pwd)) {
      array_push($errors, "Enter new password again");
    }elseif (strlen($conform_pwd)<8 or strlen($conform_pwd)>20) {
      array_push($errors, "Password must lies between 8 to 20 characters.");
    }

    if ($new_password!==$conform_pwd) {
      array_push($errors, "Both Password did not matched");
    }

    //------i am not a robot------
    if (!clean_values($con,isset($_POST['robot']))) {
      array_push($errors, "Check I am not a Robot.");
    }

    //   !!!!!!***** checking is there any error on changing password********//////
  if (count($errors) == 0) {
    $old_password = md5($old_password);
    $query="SELECT * FROM user_information WHERE username='$username' AND password='$old_password' LIMIT 1";
    $result=mysqli_query($con,$query) or die(mysqli_error($con));
    if (mysqli_num_rows($result)>0) {
        $pwd=md5($new_password);
        $update="UPDATE user_information SET password='$pwd' WHERE username='$username' LIMIT 1";
        $password_changed=mysqli_query($con,$update) or die(mysqli_error($con));
        if ($password_changed==1) {
          $Sucess= "Password has been changed sucessfully";
        }else{
          array_push($errors, "Error occurs while changing password. Try again later.");
        }
    }else{
      array_push($errors, "Incorrect old password.");
    }
  }
}

// ---------------UPDATING DOB---------------

if (clean_values($con,isset($_POST['update_dob']))) {
  $dob_bs=clean_values($con,$_POST['dob_bs']);
  $dob_ad=clean_values($con,$_POST['dob_ad']);

  if (empty($dob_bs)) {
    array_push($errors, "Please enter your date of Birth in B.S.");
  }elseif (strlen($dob_bs)!=10) {
    array_push($errors, "len Please enter valid Date of Birth In B.S. (DOB)");
  }

  if (empty($dob_ad)) {
    array_push($errors, "Please enter your date of Birth in A.D.");
  }elseif (strlen($dob_ad)!=10) {
    array_push($errors, "Please enter valid Date of Birth In A.D. (DOB)");
  }

  if (count($errors) == 0) {
    $update_dob=@"UPDATE user_information SET dob_bs='$dob_bs',dob_ad='$dob_ad' WHERE username='$username' LIMIT 1";
    $update_dob_res=mysqli_query($con, $update_dob) or die($con);
    if ($update_dob_res==1) {
      $Sucess="Your Date of Birth (DOB) has been updated sucessfully.";
    
    }else{
      array_push($errors, "Error occurs on updating your Date of Birth (DOB).");
    }
  }
}

// -------------------UPDATING CELL(Primary)--------------
if (clean_values($con,isset($_POST['update_cell_primary']))) {
  $cell_primary=clean_values($con,$_POST['cell_primary']);
  if (empty($cell_primary)){
      array_push($errors, "Primary Contact number can't be empty.");
  }elseif (!is_numeric($cell_primary)) {
    array_push($errors,"Please enter your valid primary contact number.");
  }elseif (strlen($cell_primary)<9 or strlen($cell_primary)>15) {
    array_push($errors,"Please enter your valid primary contact number.");
  }

  if (count($errors) == 0) {
    $update_cell_primary=@"UPDATE user_information SET contact1='$cell_primary' WHERE username='$username' LIMIT 1";
    $update_cell_primary_res=mysqli_query($con, $update_cell_primary) or die($con);
    if ($update_cell_primary_res==1) {
      $Sucess="Your Primary Cell number has been updated sucessfully.";
    }
    else{
      array_push($errors, "Error occurs on updating your Primary Contact Number.");
    }
  }
}

// -------------------UPDATING CELL(Secondary)--------------
if (clean_values($con,isset($_POST['update_cell_secondary']))) {
 $cell_secondary=clean_values($con,$_POST['cell_secondary']);

  if (empty($cell_secondary)){
      array_push($errors, "Secondary Contact number can't be empty.");
  }elseif (!is_numeric($cell_secondary)) {
    array_push($errors,"Please enter your valid primary contact number.");
  }elseif (strlen($cell_secondary)<9 or strlen($cell_secondary)>15) {
    array_push($errors,"Please enter your valid primary contact number.");
  }

  if (count($errors) == 0) {
    $update_cell_secondary=@"UPDATE user_information SET contact2='$cell_secondary' WHERE username='$username' LIMIT 1";
    $update_cell_secondary_res=mysqli_query($con, $update_cell_secondary) or die($con);
    if ($update_cell_secondary_res==1) {
      $Sucess="Your Secondary Cell number has been updated sucessfully.";
    }
    else{
      array_push($errors, "Error occurs on updating your Secondary Contact Number.");
    }
  }
}


// -------------------UPDATING EMAIL--------------
if (clean_values($con,isset($_POST['update_email']))) {
  $email=clean_values($con,$_POST['email']);
  
  if (empty($email)){
      array_push($errors, "Email can't be empty.");
  }elseif (filter_var($email, FILTER_VALIDATE_EMAIL)) {
    array_push($errors, "Please enter valid email");
  }elseif (strlen($email)<8 or strlen($email)>50) {
    array_push($errors, "Please enter valid email");
  }

  if (count($errors) == 0) {

          // -----------------ENTERED EMAIL iS NEW OR NOT? -------------
    $exist_query="SELECT * FROM user_information WHERE username='$username' AND email='$email' LIMIT 1";
    $exist_result=mysqli_query($con,$exist_query) or die(mysqli_error($con));
    if (mysqli_num_rows($exist_result)>0) {
      $update_email=@"UPDATE user_information SET email='$email' WHERE username='$username' LIMIT 1";
      $update_email_res=mysqli_query($con, $update_email) or die($con);
      if ($update_email_res==1) {
        $Sucess="Your email has been updated sucessfully.";
      }
      else{
        array_push($errors, "Error occurs on updating your email.");
      }
    }
    else{
      $update_email=@"UPDATE user_information SET email='$email',is_email_verified=0 WHERE username='$username' LIMIT 1";
      $update_email_res=mysqli_query($con, $update_email) or die($con);
      if ($update_email_res==1) {
        $created_at=date("Y-m-d H:i:s");
        $otp=rand(100000,999999); //GENERATES OTP


// ----------------------SEND EMAIL FROM HERE----------------------------
          $to=$email;
          // $name=$firstName.' '.$middleName.' '.$surName;
          // $subject='VERIFY YOUR ONLINE ENTRANCE MODEL TEST EMAIL';
          // $msg='Your account for ONLINE ENTRANCE has been created sucessfully.';
          // $mail_sent=sendMail($to,$name,$otp,$subject,$msg);
          $mail_sent=1; //CONCLUDE THAT MAIL WAS SENT TO REGSTERED USER

          if ($mail_sent==1) {
            $will_expired = date("Y-m-d H:i:s",strtotime('+1 day +0 hour +0 minutes +0 seconds',strtotime($created_at)));
            $exp_query=@"INSERT INTO otp_expiry(email,otp,is_expired,is_action_performed,created_at,will_expired)
                  VALUES ('$email',$otp,0,0,'$created_at','$will_expired')";
            $exp_result=mysqli_query($con,$exp_query) or die(mysqli_error($con));
            if($exp_result==1){
             $Sucess="Your email has been updated sucessfully. Please verify it.";
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
        array_push($errors, "Error occurs on updating your email.");
      }
    }
  }
}


// ----------------Sending OtP code again-------------
if (clean_values($con,isset($_POST['resend_otp']))) {
  $requested_email=clean_values($con,$_POST['sent_email']);
  
  if (empty($requested_email)){
      array_push($errors, "Error occurs on Email try again later");
  }elseif (filter_var($requested_email, FILTER_VALIDATE_EMAIL)) {
    array_push($errors, "Please enter valid email");
  }elseif (strlen($requested_email)<8 or strlen($requested_email)>50) {
    array_push($errors, "Please enter valid email");
  }

  $now= date("Y-m-d H:i:s");

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

// ---------------VERIFING EMAIL------------------

$reg_otp="";
$condition=0;
$email_sent=1;
$now= date("Y-m-d H:i:s");
// echo $sent_email;

if (clean_values($con,isset($_POST['verify_email']))) {
  $input_otp=clean_values($con,$_POST['input_otp']);
  $sent_email=clean_values($con,$_POST['sent_email']);

  if (empty($input_otp)) {
    array_push($errors, "Enter valid six digit code.");
  }elseif (strlen($input_otp)!=6 or !is_numeric($input_otp)) {
    array_push($errors, "Enter valid six digit code");
  }

  if (count($errors) == 0) {
    $qry_is_otp=@"SELECT * FROM otp_expiry WHERE email='$sent_email' AND is_expired='0' LIMIT 1";
    $qry_is_otp_res=mysqli_query($con,$qry_is_otp) or die($con);
    while ($qry_is_otp_res_row=mysqli_fetch_assoc($qry_is_otp_res)) {
      $reg_email=$qry_is_otp_res_row['email'];
      $reg_otp=$qry_is_otp_res_row['otp'];
      $reg_date=$qry_is_otp_res_row['created_at'];
      $reg_is_expired=$qry_is_otp_res_row['is_expired'];
      $expiry_date=$qry_is_otp_res_row['will_expired'];
      // $reg_username=
    }
      // echo $reg_otp;
    if ($input_otp===$reg_otp) {
      if ($now<=$expiry_date) {
        $qry_chng_act=@"UPDATE user_information SET is_email_verified=1 WHERE email='$sent_email' LIMIT 1";
        $qry_chng_act_res=mysqli_query($con,$qry_chng_act) or die($con);
        if ($qry_chng_act_res==1) {
          $qry_otp_exp=@"UPDATE otp_expiry SET is_expired=1,is_action_performed=1 WHERE email='$sent_email' AND otp=$input_otp";
          $qry_otp_exp_res=mysqli_query($con,$qry_otp_exp) or die($con);
          if ($qry_otp_exp_res==1) {
            $Sucess="Your email has been verified sucessfully.";
          }
        } 
      }
      else{
        $qry_exp_otp=@"UPDATE otp_expiry SET is_expired=1 WHERE email='$sent_email' AND otp=$input_otp";
        $qry_exp_otp_res=mysqli_query($con,$qry_exp_otp) or die($con);  
        if ($qry_exp_otp_res==1) {
          array_push($errors, "Code you have entered has been expired. Please request for new OTP code.");
        }
      }
    }
    else{
      array_push($errors, "You have entered wrong code. Please check your email and enter code again correctly.");
    }
  }
}


// -----------Updating About me------------
if (clean_values($con,isset($_POST['update_about_me']))) {
  $about_me=clean_values($con,$_POST['input_about_me']);
  if (empty($about_me)) {
      array_push($errors, "Can't upload empty value");
  
  }elseif (strlen($about_me)<=0 or strlen($about_me)>255) {
    array_push($errors, "Details must lie between 1 to 255 characters.");
  
  }elseif (is_numeric($about_me)) {
    array_push($errors, "Invalid details");
  
  }


  if (count($errors) == 0) {
    $update_about_me=@"UPDATE user_information SET about_me='$about_me' WHERE username='$username' LIMIT 1";
    $update_about_me_res=mysqli_query($con, $update_about_me) or die($con);
    if ($update_about_me_res==1) {
      $Sucess="Your value on about me section has been updated sucessfully.";
    
    }else{
      array_push($errors, "Error occurs on updating your Details");
    }
  }
}


// ------------------GETTING FULL DETAILS OF USER -------------------

  $sel_query=@"SELECT * FROM user_information WHERE username='$username'";
  $result = mysqli_query($con,$sel_query) or die ( mysqli_error());
  while($row = mysqli_fetch_assoc($result)) {
    $full_name=$row["firstname"]." ".$row["middlename"]." ".$row["surname"];
      $image_name=$row["image"];
      $_SESSION['fullname']=$full_name;

 ?>

<?php include 'header.php'; ?>

<head>
  	<title> DASHBOARD Main Profile -Secure Page</title>
</head>
<style type="text/css">
  .mySuccess {
  width: 92%; 
  margin: 0px auto; 
  padding: 10px; 
  border: 1px solid #3c763d; 
  color: #3c763d; 
  background: #dff0d8; 
  border-radius: 5px; 
  text-align: center;
}
</style>


<?php include 'dashboard_nav.php'; ?>

<!-- ----------------------------DASHBOARD HEADER------------------------- -->
<div class="row">
  <div class="col-lg-1 col-md-1"></div>
  <div class="col-lg-10 col-md-10 col-xs-12 myHeader" style="color: #fff; font-weight: bold;">
	   <h2 class="text-center"><u> DASHBOARD</u></h2>
	   <h5 class="text-center">Welcome back <?php echo$full_name; ?></h5>		
  </div>
  <div class="col-lg-1 col-md-1"></div>	
</div>



<div class="row">
  <div class="col-lg-1 col-md-1"></div>
  <div class="col-lg-10 col-md-10 col-xs-12 myRowBorder" style="border-bottom: none;">
    <div class="" style="padding-top: 5px;padding-bottom: 5px;">
        <?php include 'errors.php'; ?>
      <?php if ($Sucess!="") {?>
      <div class="mySuccess"><?php echo $Sucess; ?></div>
      <?php } ?>
    </div>

    <div class="row">

      <div class="col-lg-4 col-md-4 col-xs-4">
        <div class="mySubRowBorder" style="color: #;">
            <h2 class="text-center">PROFILE PICTURE</h2>
        </div>
        <div class="myRowBorder text-center" style="padding-bottom: 5px;">
            <img height="200" width="200" src="secure/user_images/<?php echo($image_name); ?>" alt="ONLINE ENTRANCE-User image">
            <div style="padding-top: 10px; padding-bottom: 5px;">
                <button type="submit" name="subject_submit" class="btn btn-default myLoginBtn" data-toggle="modal" data-target="#forUploadingImg" onclick="changeImage('<?php echo($username); ?>')">CHANGE IMAGE</button>
            </div>
        </div>
      </div>
    

      <div class="col-lg-4 col-md-4 col-xs-12">
        <div class="mySubRowBorder" style="color: #;">
            <h2 class="text-center">PERSONAL DETAILS</h2>
        </div>

        <div class="myRowBorder">
          <table border="1" class="table table-design">
             <thead>
               <tr><th>Profile Details: </th><th> Actions: </th></tr>
             </thead>
             <tbody>
               <tr>
                  <td><span class="pull-left">NAME : </span><span class="pull-right"><?php echo $full_name; ?></span></td>
                  <td><button type="button" class="btn btn-primary" data-toggle="modal" data-target="#forUpdatingName" onclick="updateName('<?php echo $row["username"]; ?>')">Edit</button></td>
                </tr>
               
               <tr><td><span>DOB (BS) : </span><span class="pull-right"><?php echo $row["dob_bs"]; ?></span></td><td><button type="button" class="btn btn-primary" data-toggle="modal" data-target="#forUpdatingDob" onclick="updateDob('<?php echo $row["username"]; ?>')">Edit</button></td></tr>

               <tr><td><span>DOB (AD) : </span><span class="pull-right"><?php echo $row["dob_bs"]; ?></span></td><td><button type="button" class="btn btn-primary" data-toggle="modal" data-target="#forUpdatingDob" onclick="updateDob('<?php echo $row["username"]; ?>')">Edit</button></td></tr>
             </tbody>
          </table>
        </div>
      </div>

      <div class="col-lg-4 col-md-4 col-xs-12">
          <div class="mySubRowBorder" style="color: #;">
              <h2 class="text-center">CONTACT DETAILS</h2>
          </div>

          <div class="myRowBorder">
            <table border="1" class="table table-design">
               <thead>
                 <tr><th>Profile Details : </th><th>Actions:</th></tr>
               </thead>
               <tbody>
                 <tr>
                    <td><span class="pull-left">Email : </span><span class="pull-right"><?php echo $row["email"]; ?></span></td>
                    <td><button type="button" class="btn btn-primary" data-toggle="modal" data-target="#forUpdatingEmail" onclick="updateEmail('<?php echo $row["username"]; ?>')">Edit</button></td>
                  </tr>
                 
                 <tr><td><span>Cell Phone (primary) : </span><span class="pull-right"><?php echo $row["contact1"]; ?></span></td><td><button type="button" class="btn btn-primary" data-toggle="modal" data-target="#forCellPrimary" onclick="updateCellPrimary('<?php echo $row["username"]; ?>')">Edit</button></td></tr>

                 <tr><td><span>Cell Phone (Secondary) : </span><span class="pull-right"><?php echo $row["contact2"]; ?></span></td><td><button type="button" class="btn btn-primary" data-toggle="modal" data-target="#forCellSecondary" onclick="updateCellSecondary('<?php echo $row["username"]; ?>')">Edit</button></td></tr>
               </tbody>
             </table>
           </div>
      </div>
    </div>

    <div class="row">
       <div class="col-lg-4 col-md-4 col-xs-12">
          <div class="mySubRowBorder" style="color: #;">
              <h2 class="text-center">PERMANENT ADDRESS</h2>
          </div>

          <div class="myRowBorder">
            <table border="1" class="table table-design">
               <thead>
               </thead>
               <tbody>
                 <tr>
                    <td><span class="pull-left">Country : </span><span class="pull-right"><?php echo $row["pcountry"]; ?></span></td>
                  </tr>
                 
                 <tr><td><span>Zone : </span><span class="pull-right" style="padding-left: 150px;"><?php echo $row["pzone"]; ?></span></td></tr>

                 <tr><td><span>District : </span><span class="pull-right" style="padding-left: 150px;"><?php echo $row["pdistrict"]; ?></span></td></tr>

                 <tr><td><span>City : </span><span class="pull-right" style="padding-left: 150px;"><?php echo $row["pcity"]; ?></span></td></tr>

                 <tr><td><span>Tole : </span><span class="pull-right" style="padding-left: 150px;"><?php echo $row["ptole"]; ?></span></td></td></tr>
                 <tr><th> <span>Actions : </span><span class="pull-right" style="padding-left: 150px;"><button type="button" class="btn btn-primary" data-toggle="modal" data-target="#forUpdatingPAddress" onclick="updatePAddress('<?php echo($username); ?>')">Edit</button></span></th></tr>
               </tbody>
             </table>
           </div>
        </div>

       <div class="col-lg-4 col-md-4 col-xs-12">
        <div class="mySubRowBorder" style="color: #;"><h2 class="text-center">TEMPORARY ADDRESS</h2></div>
        <div class="myRowBorder">
          <table border="1" class="table table-design">
             <thead>
             </thead>
             <tbody>

               <tr><td><span class="pull-left">Country : </span><span class="pull-right" style="padding-left: 150px;"><?php echo $row["tcountry"]; ?></span></td></tr>
               
               <tr><td><span>Zone : </span><span class="pull-right" style="padding-left: 150px;"><?php echo $row["tzone"]; ?></span></td></tr>

               <tr><td><span>District : </span><span class="pull-right" style="padding-left: 150px;"><?php echo $row["tdistrict"]; ?></span></td></tr>

               <tr><td><span>City : </span><span class="pull-right" style="padding-left: 150px;"><?php echo $row["tcity"]; ?></span></td></tr>

               <tr><td><span>Tole : </span><span class="pull-right" style="padding-left: 150px;"><?php echo $row["ttole"]; ?></span></td></tr>
               <tr><th> <span>Actions : </span><span class="pull-right" style="padding-left: 150px;"><button type="button" class="btn btn-primary" data-toggle="modal" data-target="#forUpdatingtAddress" onclick="updateTAddress('<?php echo($username); ?>')">Edit</button></span></th></tr>
             </tbody>
           </table>
         </div>
      </div>

       <div class="col-lg-4 col-md-4 col-xs-12">
        <div class="mySubRowBorder" style="color: #;"><h2 class="text-center">ACCOUNT DETAILS</h2></div>
        <div class="myRowBorder">
          <table border="1" class="table table-design">
             <thead>
               <tr><th>Profile Details: </th><th> Actions: </th></tr>
             </thead>
             <tbody>
               <tr>
                  <td><span class="pull-left">Email: </span><span class="pull-right"><?php echo $row["email"]; ?></span></td>
                  <td><?php if ($row['is_email_verified']==1) {?><span class="badge badge-success">Verified</span><?php }else{?><button type="button" class="btn btn-danger" data-toggle="modal" data-target="#forVerifyingEmail" onclick="verifyEmail('<?php echo $row["username"]; ?>')">Verify</button><?php } ?></td>
                </tr>
               
               <tr>
                  <td>Username: <span class="pull-right"><?php echo $row["username"]; ?></span></td>

                  <td><?php if ($row['is_active']==1) {?><span class="badge badge-success">active</span><?php }else{?><span class="badge badge-danger">Not-active</span><?php } ?>
                  </td>
                </tr>

               <tr>
                  <td><span>Password: </span><span class="pull-right">************</span></td>
                  <td><button type="button" class="btn btn-primary" data-toggle="modal" data-target="#forChangingPassword">Edit</button></td>
                </tr>

               <tr><td><span>Reg. Date: </span><span class="pull-right" ><?php echo $row["created_at"]; ?></span></td><td></td></tr>

               <tr><td><span>Verified: </span><span class="pull-right" style="padding-left: 150px;"><?php if ($row['verified']=='yes' or $row['verified']=='YES') {?>
          <td style="color:#3c763d ;font-weight: bold;"><?php echo $row['verified']; ?></td>
                    <?php } else{?>
          <td style="color: red;font-weight: bold;"><?php echo $row['verified']; ?></td>
                    <?php } ?></span></td>
             </tbody>
           </table>
         </div>
      </div>
    </div> 
  </div>
  <div class="col-lg-1 col-md-1"></div>
</div>

<div class="row">
  <div class="col-lg-1 col-md-1"></div>
  <div class="col-lg-10 col-md-10 col-xs-12 myRowBorder p-1" style="border-top: none;">
    <div class="mySubRowBorder" style="color: #;border-top-left-radius: 10px;border-top-right-radius: 10px;">
        <h2 class="text-center">About me</h2>
    </div>

    <div class="myRowBorder p-2" style="border-bottom-right-radius: 10px;border-bottom-left-radius: 10px;">
      <h5 class="text-info p-4 font-italic"><?php echo $row["about_me"]; ?></h5>
    <center>
      <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#forUpdatingAboutMe" onclick="updateAboutMe('<?php echo($username); ?>')">Edit</button>
    </center>
    </div>

  </div>
  <div class="col-lg-1 col-md-1"></div>
</div>

<!-- -------------------AJAX CODES--------------------- -->

<script type="text/javascript">

        // ------------NAME OF USER-------
       function updateName(username) {
      // $('#update_download_cat_details_id').val(id);

      $.post("getDataForUserModels.php",{
        update_name_username:username
      },function(data,status){
        var user_name=JSON.parse(data);
        $('#fname').val(user_name.firstname);
        $('#mname').val(user_name.middlename);
        $('#sname').val(user_name.surname);
      }

        );
      $('#forUpdatingName').modal("show");
    }


    // -----------------PERMANENT ADDRESS------
    function updatePAddress(username) {
      // $('#update_download_cat_details_id').val(id);

      $.post("getDataForUserModels.php",{
        update_pAddress_username:username
      },function(data,status){
        var address=JSON.parse(data);
        $('#pcountry').val(address.pcountry);
        $('#pzone').val(address.pzone);
        $('#pdistrict').val(address.pdistrict);
        $('#pcity').val(address.pcity);
        $('#ptole').val(address.ptole);
      }

        );
      $('#forUpdatingPAddress').modal("show");
    }
    
            // --------------TEMPORARY ADDRESS-------

    function updateTAddress(username) {
      // $('#update_download_cat_details_id').val(id);

      $.post("getDataForUserModels.php",{
        update_tAddress_username:username
      },function(data,status){
        var address=JSON.parse(data);
        $('#tcountry').val(address.tcountry);
        $('#tzone').val(address.tzone);
        $('#tdistrict').val(address.tdistrict);
        $('#tcity').val(address.tcity);
        $('#ttole').val(address.ttole);
      }

        );
      $('#forUpdatingtAddress').modal("show");
    }

    // ------------------DOB----------

    function updateDob(username) {
      // $('#update_download_cat_details_id').val(id);

      $.post("getDataForUserModels.php",{
        update_dob_username:username
      },function(data,status){
        var dob=JSON.parse(data);
        $('#dob_bs').val(dob.dob_bs);
        $('#dob_ad').val(dob.dob_ad);
      }

        );
      $('#forUpdatingDob').modal("show");
    }

      // -------------cell primary---------
     function updateCellPrimary(username) {
      // $('#update_download_cat_details_id').val(id);

      $.post("getDataForUserModels.php",{
        update_cell_primary_username:username
      },function(data,status){
        var cell=JSON.parse(data);
        $('#cell_primary').val(cell.contact1);
      }

        );
      $('#forCellPrimary').modal("show");
    }

    // -------------cell secondary---------
     function updateCellSecondary(username) {
      // $('#update_download_cat_details_id').val(id);

      $.post("getDataForUserModels.php",{
        update_cell_secondary_username:username
      },function(data,status){
        var cell=JSON.parse(data);
        $('#cell_secondary').val(cell.contact2);
      }

        );
      $('#forCellSecondary').modal("show");
    }

    // -------------Email---------
     function updateEmail(username) {
      // $('#update_download_cat_details_id').val(id);

      $.post("getDataForUserModels.php",{
        update_email_username:username
      },function(data,status){
        var email=JSON.parse(data);
        $('#email').val(email.email);
      }

        );
      $('#forUpdatingEmail').modal("show");
    }

    // ------------ VERIFYING-Email---------
     function verifyEmail(username) {
      // $('#update_download_cat_details_id').val(id);

      $.post("getDataForUserModels.php",{
        verify_email_username:username
      },function(data,status){
        var email=JSON.parse(data);
        $('#verify_email').html(email.email);
        $('#sent_email').val(email.email);
      }

        );
      $('#forVerifyingEmail').modal("show");
    }

     // -------------About_me---------
     function updateAboutMe(username) {
      // $('#update_download_cat_details_id').val(id);

      $.post("getDataForUserModels.php",{
        update_about_me_username:username
      },function(data,status){
        var about_me=JSON.parse(data);
        $('#input_about_me').val(about_me.about_me);
      }

        );
      $('#forUpdatingAboutMe').modal("show");
    }
</script>


<?php include 'footer.php'; ?>
<?php } ?>
<!-- *****************ENDING OF MAIN SECTIONS************** -->


<!-- ----------------------MODELS--------------------- -->


<!-- ..........for Uploading New Image............ -->

<div class="modal fade" id="forUploadingImg" tabindex="-1" role="dialog" aria-labelledby="forUploadingImg" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="forUploadingImg">Change Profile Pictures</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <div class="myForm">
            <form method="post" action="" enctype="multipart/form-data">
              <div class="form-group">
                  <label for="user_img">Select Image:</label>
                  <input type="file" class="form-control" id="user_img" name="user_img"><br>
                  <label for="text" class="text-warning text-center">Image size must be less than 200 KB</label>
              </div>

              <button type="submit" class="btn btn-primary" name="upload_img">Upload Image</button>
            
            </form>
        </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
      </div>
    </div>
  </div>
</div>
<!-- .............Uploading New Image finished........... -->


<!-- ------------------changing Name----------------- -->

<div class="modal fade" id="forUpdatingName" tabindex="-1" role="dialog" aria-labelledby="forUpdatingName" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="forUpdatingName">Change Name ( Use your original name )</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <div class="myForm">
            <form method="post" action="">
              <div class="form-group">
                  <label for="fname">First Name:</label>
                  <input type="text" class="form-control text-info" id="fname" name="fname" placeholder="Enter first name" maxlength="30">
              </div>

              <div class="form-group">
                  <label for="mname">Middle Name:</label>
                  <input type="text" class="form-control text-info" id="mname" name="mname" placeholder="Enter middle name" maxlength="30">
              </div>

              <div class="form-group">
                  <label for="sname">Surname:</label>
                  <input type="text" class="form-control text-info" id="sname" name="sname" placeholder="Enter surname" maxlength="30">
              </div>

              <button type="submit" class="btn btn-primary" name="change_name">Save Changes</button>
            
            </form>
        </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
      </div>
    </div>
  </div>
</div>
<!-- ----------------CHANGING NAME FINISHED---------------- -->


<!-- ------------------Updating Permanent Address----------------- -->

<div class="modal fade" id="forUpdatingPAddress" tabindex="-1" role="dialog" aria-labelledby="forUpdatingPAddress" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="forUpdatingPAddress">Updating Permanent Address</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <div class="myForm">
            <form method="post" action="">
              <div class="form-group">
                  <label for="pcountry">Country:</label>
                  <input type="text" class="form-control text-info" id="pcountry" name="pcountry" placeholder="Enter Country Name" maxlength="30">
              </div>

              <div class="form-group">
                  <label for="pzone">Zone:</label>
                  <input type="text" class="form-control text-info" id="pzone" name="pzone" placeholder="Enter Zone name" maxlength="30">
              </div>

              <div class="form-group">
                  <label for="pdistrict">District:</label>
                  <input type="text" class="form-control text-info" id="pdistrict" name="pdistrict" placeholder="Enter District Name" maxlength="30">
              </div>

              <div class="form-group">
                  <label for="pcity">City:</label>
                  <input type="text" class="form-control text-info" id="pcity" name="pcity" placeholder="Enter City Name" maxlength="40">
              </div>

              <div class="form-group">
                  <label for="ptole">Tole (eg: tole-03):</label>
                  <input type="text" class="form-control text-info" id="ptole" name="ptole" placeholder="Enter Tole Name with Ward No." maxlength="40">
              </div>

              <button type="submit" class="btn btn-primary" name="update_paddress">Save Changes</button>
            
            </form>
        </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
      </div>
    </div>
  </div>
</div>
<!-- ----------------Updating Permanent Addresss FINISHED---------------- -->

<!-- ------------------Updating Temporary Address----------------- -->

<div class="modal fade" id="forUpdatingtAddress" tabindex="-1" role="dialog" aria-labelledby="forUpdatingtAddress" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="forUpdatingtAddress">Updating Temporary Address</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <div class="myForm">
            <form method="post" action="">
              <div class="form-group">
                  <label for="tcountry">Country:</label>
                  <input type="text" class="form-control text-info" id="tcountry" name="tcountry" placeholder="Enter Country Name" maxlength="30">
              </div>

              <div class="form-group">
                  <label for="tzone">Zone:</label>
                  <input type="text" class="form-control text-info" id="tzone" name="tzone" placeholder="Enter Zone name" maxlength="30">
              </div>

              <div class="form-group">
                  <label for="tdistrict">District:</label>
                  <input type="text" class="form-control text-info" id="tdistrict" name="tdistrict" placeholder="Enter District Name" maxlength="30">
              </div>

              <div class="form-group">
                  <label for="tcity">City:</label>
                  <input type="text" class="form-control text-info" id="tcity" name="tcity" placeholder="Enter City Name" maxlength="40">
              </div>

              <div class="form-group">
                  <label for="ttole">Tole (eg: tole-03):</label>
                  <input type="text" class="form-control text-info" id="ttole" name="ttole" placeholder="Enter Tole Name with Ward No." maxlength="40">
              </div>

              <button type="submit" class="btn btn-primary" name="update_taddress">Save Changes</button>
            
            </form>
        </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
      </div>
    </div>
  </div>
</div>
<!-- ----------------Updating Temporary Addresss FINISHED---------------- -->

<!-- ------------------Changing Password----------------- -->

<div class="modal fade" id="forChangingPassword" tabindex="-1" role="dialog" aria-labelledby="forChangingPassword" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="forChangingPassword">Changing Password</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <div class="myForm">
            <form method="post" action="">
              <div class="form-group">
                  <label for="oldpassword">Old Password:</label>
                  <input type="Password" class="form-control text-info" id="oldpassword" name="oldpassword" placeholder="Enter Old Password" minlength="8" maxlength="20" required="on">
              </div>

              <div class="form-group">
                  <label for="newpassword">New Password:</label>
                  <input type="Password" class="form-control text-info" id="password_1" name="newpassword" placeholder="Enter New Password" onkeyup='checkPwd();' minlength="8" maxlength="20" required="on">
              </div>

              <div class="form-group">
                  <label for="conformpwd">Conform Password:</label>
                  <input type="password" class="form-control text-info" id="password_2" name="conformpwd" placeholder="Enter New Password Again" onkeyup='checkPwd();' minlength="8" maxlength="20" required="on"><span id='message'></span>
              </div>

              <div class="custom-control custom-checkbox mb-3 was-validated">
                <input type="checkbox" class="custom-control-input" id="customControlValidation2" name="robot" required="on" value="1">
                <label class="custom-control-label" for="customControlValidation2">I Am not a Robot?</label>
                <!-- <div class="invalid-feedback">Example invalid feedback text</div> -->
            </div>


              <button type="submit" class="btn btn-primary" name="change_pwd">Save Changes</button>
            
            </form>
        </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
      </div>
    </div>
  </div>
</div>
<!-- ----------------Changing Password FINISHED---------------- -->

<!-- ------------------Changing DOB B.S.----------------- -->

<div class="modal fade" id="forUpdatingDob" tabindex="-1" role="dialog" aria-labelledby="forUpdatingDob" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="forUpdatingDob">Changing Date of Birth(DOB)</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <div class="myForm">
            <form method="post" action="">
              <div class="form-group">
                  <label for="dob_bs">DOB(B.S.):</label>
                  <input type="date" class="form-control text-info" id="dob_bs" name="dob_bs" maxlength="10" required="on">
              </div>

              <div class="form-group">
                  <label for="dob_ad">DOB(A.D.):</label>
                  <input type="date" class="form-control text-info" id="dob_ad" name="dob_ad" maxlength="10" required="on">
              </div>

              <button type="submit" class="btn btn-primary" name="update_dob">Save Changes</button>
            
            </form>
        </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
      </div>
    </div>
  </div>
</div>
<!-- ----------------Changing DOB B.S. FINISHED---------------- -->


<!-- ------------------Changing Cell phone Primary.----------------- -->

<div class="modal fade" id="forCellPrimary" tabindex="-1" role="dialog" aria-labelledby="forCellPrimary" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="forCellPrimary">Changing Cell Phone (Primary)</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <div class="myForm">
            <form method="post" action="">
              <div class="form-group">
                  <label for="cell_primary">Cell Phone (Primary):</label>
                  <input type="tel" class="form-control text-info" id="cell_primary" name="cell_primary" placeholder="+977 98XXXXXXXX" minlength="9" maxlength="15" required="on">
              </div>
              <button type="submit" class="btn btn-primary" name="update_cell_primary">Save Changes</button>
            
            </form>
        </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
      </div>
    </div>
  </div>
</div>
<!-- ----------------Changing Cell(primary). FINISHED---------------- -->


<!-- ------------------Changing Cell phone (Secondary)----------------- -->

<div class="modal fade" id="forCellSecondary" tabindex="-1" role="dialog" aria-labelledby="forCellSecondary" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="forCellSecondary">Changing Cell Phone (Secondary)</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <div class="myForm">
            <form method="post" action="">
              <div class="form-group">
                  <label for="cell_secondary">Cell Phone (Secondary):</label>
                  <input type="tel" class="form-control text-info" id="cell_secondary" name="cell_secondary" placeholder="+977 98XXXXXXXX" minlength="9" maxlength="15" required="on">
              </div>

              <button type="submit" class="btn btn-primary" name="update_cell_secondary">Save Changes</button>
            
            </form>
        </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
      </div>
    </div>
  </div>
</div>
<!-- ----------------Changing Cell phone (Secondary) FINISHED---------------- -->


<!-- ------------------Changing Email----------------- -->

<div class="modal fade" id="forUpdatingEmail" tabindex="-1" role="dialog" aria-labelledby="forUpdatingEmail" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="forUpdatingEmail">Changing Email</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <div class="myForm">
            <form method="post" action="">
              <div class="form-group">
                  <label for="email">Email :</label>
                  <input type="emal" class="form-control text-info" id="email" name="email" placeholder="someone@gmail.com" minlength="8" maxlength="50" required="on">
              </div>

              <button type="submit" class="btn btn-primary" name="update_email">Save Changes</button>
            
            </form>
        </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
      </div>
    </div>
  </div>
</div>
<!-- ----------------Changing email FINISHED---------------- -->

<!-- ------------------Verifing Email----------------- -->

<div class="modal fade" id="forVerifyingEmail" tabindex="-1" role="dialog" aria-labelledby="forVerifyingEmail" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="forVerifyingEmail">Verifing Email</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <p class="text-info">Please enter the six digit OTP code we have sent on your email "<span id="verify_email" class="font-weight-bold">someone@gmail.com</span>"</p>
        <div class="myForm">
            <form method="post" action="">
              <div class="form-group">
                  <label for="verifing_code">OTP(six digit code) :</label>
                  <input type="tel" class="form-control text-info" id="verifing_code" name="input_otp" placeholder="Enter 6-digit otp code" maxlength="6" minlength="6">
              </div>
              <input type="hidden" name="sent_email" id="sent_email" maxlength="50" minlength="8">
              <button type="submit" class="btn btn-primary" name="verify_email">Save Changes</button>
              <button type="submit" id="clickable_btn" class="btn btn-default myLoginBtn" name="resend_otp">Resend</button>
            </form>
        </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
      </div>
    </div>
  </div>
</div>
<!-- ----------------Verifing email FINISHED---------------- -->


<!-- ------------------About me----------------- -->

<div class="modal fade" id="forUpdatingAboutMe" tabindex="-1" role="dialog" aria-labelledby="forUpdatingAboutMe" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="forUpdatingAboutMe">About me</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <p class="text">Basic about yourself</p>
        <div class="myForm">
            <form method="post" action="">
              <div class="form-group">
                  <label for="input_about_me">About me (max=255 char) :</label>
                  <textarea type="text" class="form-control text-info" id="input_about_me" name="input_about_me" placeholder="Enter about yourself" maxlength="255"></textarea>
              </div>
              <button type="submit" class="btn btn-primary" name="update_about_me">Save Changes</button>
            </form>
        </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
      </div>
    </div>
  </div>
</div>
<!-- ----------------About me FINISHED---------------- -->

