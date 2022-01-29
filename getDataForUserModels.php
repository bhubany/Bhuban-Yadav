<?php 

	require('db.php');
  require 'includes/functions.php';

// -------------------CHANGING NAME OF USER--------------

if (clean_values($con,isset($_POST['update_name_username'])) && clean_values($con,isset($_POST['update_name_username'])!=="")) {
	$username=clean_values($con,$_POST['update_name_username']);
	$qry_name=@"SELECT * FROM user_information WHERE username='$username'";
	$res_name=mysqli_query($con,$qry_name) or die($con);

	$name_response=array();

	if (mysqli_num_rows($res_name)>0) {
		while($name_row=mysqli_fetch_assoc($res_name)){
			$name_response=$name_row;
		}
	}
	else{
		$name_response['status']=200;
		$name_response['message']="Data not Found!!";
	}
	echo json_encode($name_response);
}
else{
	$name_response['status']=200;
	$name_response['message']="Invalid Request!!";
}


// --------------------------FOR UPDATING Permanent Address----------------

if (clean_values($con,isset($_POST['update_pAddress_username'])) && clean_values($con,isset($_POST['update_pAddress_username']))!="") {
  $username=clean_values($con,$_POST['update_pAddress_username']);
  $pAddress_qry=@"SELECT * FROM user_information WHERE username='$username'";
  $pAddress_result=mysqli_query($con,$pAddress_qry) or die($con);

  $pAddress_response=array();

  if (mysqli_num_rows($pAddress_result)>0) {
    while ($pAddress_rows=mysqli_fetch_assoc($pAddress_result)) {
      $pAddress_response=$pAddress_rows;
    }
  }else{
    $pAddress_response['status']= 200;
    $pAddress_response['message']="Data not Found";
  }

  // -----------------PHP BUILT IN FUNCTION ----------------
  echo json_encode($pAddress_response);
}else{
  $pAddress_response['status']=200;
  $pAddress_response['message']="Invalid Request";
}


 // --------------------------FOR UPDATING Temporary Address----------------

if (clean_values($con,isset($_POST['update_tAddress_username'])) && clean_values($con,isset($_POST['update_tAddress_username']))!="") {
  $username=clean_values($con,$_POST['update_tAddress_username']);
  $tAddress_qry=@"SELECT * FROM user_information WHERE username='$username'";
  $tAddress_result=mysqli_query($con,$tAddress_qry) or die($con);

  $tAddress_response=array();

  if (mysqli_num_rows($tAddress_result)>0) {
    while ($tAddress_rows=mysqli_fetch_assoc($tAddress_result)) {
      $tAddress_response=$tAddress_rows;
    }
  }else{
    $tAddress_response['status']= 200;
    $tAddress_response['message']="Data not Found";
  }

  // -----------------PHP BUILT IN FUNCTION ----------------
  echo json_encode($tAddress_response);
}else{
  $tAddress_response['status']=200;
  $tAddress_response['message']="Invalid Request";
}


 // --------------------------FOR UPDATING DOB----------------

if (clean_values($con,isset($_POST['update_dob_username'])) && clean_values($con,isset($_POST['update_dob_username']))!="") {
  $username=clean_values($con,$_POST['update_dob_username']);
  $dob_qry=@"SELECT * FROM user_information WHERE username='$username'";
  $dob_result=mysqli_query($con,$dob_qry) or die($con);

  $dob_response=array();

  if (mysqli_num_rows($dob_result)>0) {
    while ($dob_rows=mysqli_fetch_assoc($dob_result)) {
      $dob_response=$dob_rows;
    }
  }else{
    $dob_response['status']= 200;
    $dob_response['message']="Data not Found";
  }

  // -----------------PHP BUILT IN FUNCTION ----------------
  echo json_encode($dob_response);
}else{
  $dob_response['status']=200;
  $dob_response['message']="Invalid Request";
}



 // --------------------------FOR UPDATING Cell(Primary)----------------

if (clean_values($con,isset($_POST['update_cell_primary_username'])) && clean_values($con,isset($_POST['update_cell_primary_username']))!="") {
  $username=clean_values($con,$_POST['update_cell_primary_username']);
  $cell_primary_qry=@"SELECT * FROM user_information WHERE username='$username'";
  $cell_primary_result=mysqli_query($con,$cell_primary_qry) or die($con);

  $cell_primary_response=array();

  if (mysqli_num_rows($cell_primary_result)>0) {
    while ($cell_primay_rows=mysqli_fetch_assoc($cell_primary_result)) {
      $cell_primary_response=$cell_primay_rows;
    }
  }else{
    $cell_primary_response['status']= 200;
    $cell_primary_response['message']="Data not Found";
  }

  // -----------------PHP BUILT IN FUNCTION ----------------
  echo json_encode($cell_primary_response);
}else{
  $cell_primary_response['status']=200;
  $cell_primary_response['message']="Invalid Request";
}



 // --------------------------FOR UPDATING Cell(Secondary)----------------

if (clean_values($con,isset($_POST['update_cell_secondary_username'])) && clean_values($con,isset($_POST['update_cell_secondary_username']))!="") {
  $username=clean_values($con,$_POST['update_cell_secondary_username']);
  $cell_secondary_qry=@"SELECT * FROM user_information WHERE username='$username'";
  $cell_secondary_result=mysqli_query($con,$cell_secondary_qry) or die($con);

  $cell_secondary_response=array();

  if (mysqli_num_rows($cell_secondary_result)>0) {
    while ($cell_secondary_rows=mysqli_fetch_assoc($cell_secondary_result)) {
      $cell_secondary_response=$cell_secondary_rows;
    }
  }else{
    $cell_secondary_response['status']= 200;
    $cell_secondary_response['message']="Data not Found";
  }

  // -----------------PHP BUILT IN FUNCTION ----------------
  echo json_encode($cell_secondary_response);
}else{
  $cell_secondary_response['status']=200;
  $cell_secondary_response['message']="Invalid Request";
}


 // --------------------------FOR UPDATING Email----------------

if (clean_values($con,isset($_POST['update_email_username'])) && clean_values($con,isset($_POST['update_email_username']))!="") {
  $username=clean_values($con,$_POST['update_email_username']);
  $email_qry=@"SELECT * FROM user_information WHERE username='$username'";
  $email_result=mysqli_query($con,$email_qry) or die($con);

  $email_response=array();

  if (mysqli_num_rows($email_result)>0) {
    while ($email_rows=mysqli_fetch_assoc($email_result)) {
      $email_response=$email_rows;
    }
  }else{
    $email_response['status']= 200;
    $email_response['message']="Data not Found";
  }

  // -----------------PHP BUILT IN FUNCTION ----------------
  echo json_encode($email_response);
}else{
  $email_response['status']=200;
  $email_response['message']="Invalid Request";
}

// --------------------------FOR Verifing Email----------------

if (clean_values($con,isset($_POST['verify_email_username'])) && clean_values($con,isset($_POST['verify_email_username']))!="") {
  $username=clean_values($con,$_POST['verify_email_username']);
  $verify_email_qry=@"SELECT * FROM user_information WHERE username='$username'";
  $verify_email_result=mysqli_query($con,$verify_email_qry) or die($con);

  $verify_email_response=array();

  if (mysqli_num_rows($verify_email_result)>0) {
    while ($verify_email_rows=mysqli_fetch_assoc($verify_email_result)) {
      $verify_email_response=$verify_email_rows;
    }
  }else{
    $verify_email_response['status']= 200;
    $verify_email_response['message']="Data not Found";
  }

  // -----------------PHP BUILT IN FUNCTION ----------------
  echo json_encode($verify_email_response);
}else{
  $verify_email_response['status']=200;
  $verify_email_response['message']="Invalid Request";
}

  // --------------------------FOR UPDATING Email----------------

if (clean_values($con,isset($_POST['update_about_me_username'])) && clean_values($con,isset($_POST['update_about_me_username']))!="") {
  $username=clean_values($con,$_POST['update_about_me_username']);
  $about_me_qry=@"SELECT * FROM user_information WHERE username='$username'";
  $about_me_result=mysqli_query($con,$about_me_qry) or die($con);

  $about_me_response=array();

  if (mysqli_num_rows($about_me_result)>0) {
    while ($about_me_rows=mysqli_fetch_assoc($about_me_result)) {
      $about_me_response=$about_me_rows;
    }
  }else{
    $about_me_response['status']= 200;
    $about_me_response['message']="Data not Found";
  }

  // -----------------PHP BUILT IN FUNCTION ----------------
  echo json_encode($about_me_response);
}else{
  $about_me_response['status']=200;
  $about_me_response['message']="Invalid Request";
}



//----------For viewing user profile on ranks sections----
if (clean_values($con,isset($_POST['view_user_profile_username'])) && clean_values($con,isset($_POST['view_user_profile_username']))!="") {
  $username=clean_values($con,$_POST['view_user_profile_username']);
  $view_user_qry=@"SELECT * FROM user_information WHERE username='$username'";
  $view_user_result=mysqli_query($con,$view_user_qry) or die($con);

  $view_user_response=array();

  if (mysqli_num_rows($view_user_result)>0) {
    while ($view_user_rows=mysqli_fetch_assoc($view_user_result)) {
      $view_user_response=$view_user_rows;
    }
  }else{
    $view_user_response['status']= 200;
    $view_user_response['message']="Data not Found";
  }

  // -----------------PHP BUILT IN FUNCTION ----------------
  echo json_encode($view_user_response);
}else{
  $view_user_response['status']=200;
  $view_user_response['message']="Invalid Request";
}


 ?>