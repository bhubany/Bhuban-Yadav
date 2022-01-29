<?php
if(!session_id()){
  session_start();
}?>

<?php 
require 'auth.php';
require 'db.php';
require 'includes/functions.php';
$id=$newid;
$reg_pwd="";
$username=$_SESSION['username'];
$errors=array();
$Sucess="";
#Destroying All sessions
if (clean_values($con,isset($_POST['unsubscribe']))) {
	$password=(clean_values($con,$_POST['oldpassword']));
	$input_pwd=(clean_values($con,md5($password)));

	if (empty($password)) {
		array_push($errors,"Password is required for unsubscribtion process");
	}elseif (strlen($password)<8 or strlen($password)>20) {
      array_push($errors, "Incorrect old password.");
    }

	if (!clean_values($con,isset($_POST['robot']))) {
		array_push($errors, "Check I am not a Robot.");	
	}

	$qry_check_pwd=@"SELECT * FROM user_information WHERE username='$username' AND is_active=1 LIMIT 1";
	$res=mysqli_query($con,$qry_check_pwd) or die($con);
	if (mysqli_num_rows($res)>0) {
		while ($row=mysqli_fetch_assoc($res)) {
			$reg_pwd=$row['password'];
			$registered_active=$row['is_active'];
		}
		if ($registered_active!=1){
			array_push($errors, 'Account deletion failed. Try again later.');
		}
	}else{
		array_push($errors, "Incorrect old password.");
	}

	if (count($errors)==0) {
		$update=@"UPDATE user_information SET is_active=10 WHERE username='$username' AND password='$input_pwd' LIMIT 1";
		$active_status=mysqli_query($con,$update) or die(mysqli_error($con));
		if ($active_status==1){
			$Sucess= "Your account has been unsubscribed sucessfully";
			if(session_destroy()){
				header("Location:acountdeleted.php");
			}
			exit();	
		}else{
			array_push($errors, "Account Deletion Failed");
		}
	}
}
 ?>

 <head>
 	<title>ONLINE ENTRANCE -Delete Account</title>
 </head>

 <style type="text/css">

 </style>

 <?php include 'header.php'; ?>
 <?php include 'dashboard_nav.php'; ?>


<!-- ************************STARTING OF MAIN SECTIONS**************** -->

				<!-- ------------------------HEADER---------------------- -->
<div class="row">
	<div class="col-lg-1 col-md-1"></div>
	<div class="col-lg-10 col-md-10 col-xs-12 myHeader" style="color: #fff; font-weight: bold;">
		<u><h2 class="text-center">CONFORM UNSUBSCRIBTION</h2></u>
		<h4 class="text-center text-warning">If you unsubscribe then you cannot acess exam and download section provided by us.</h4>
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

<!-- --------------------------CHECKING PASSWORD------------------ -->

<div class="row">
	<div class="col-lg-1 col-md-1"></div>
	<div class="col-lg-10 col-md-10 col-xs-12 myRowBorder" style="border-top: none;">
		<div class="row">
			<div class="col-lg-4 col-md-4"></div>
			<div class="col-lg-4 col-md-4 col-xs-12 myRowBorder shadow-lg" style="background-color: #f2f2f2;"><br>
				<form action="" method="post">

					<div class="form-group">
		      			<label for="text" class="font-weight-bold">Enter Your Password:</label>
		      			<input type="password" class="form-control" id="username" placeholder="Enter your password" name="oldpassword">
		    		</div>

					<div class="custom-control custom-checkbox mb-3 was-validated">
					    <input type="checkbox" class="custom-control-input" id="customControlValidation2" name="robot" required value="1">
					    <label class="custom-control-label" for="customControlValidation2">I Am not a Robot?</label>
					    <!-- <div class="invalid-feedback">Example invalid feedback text</div> -->
					</div>

					<div>
						<button type="submit" class="btn btn-default myLoginBtn" name="unsubscribe">Login</button>
					</div>
				</form><br>
			</div>
			<div class="col-lg-4 col-md-4"></div>
		</div>
	</div>
	<div class="col-lg-1 col-md-1"></div>
</div>


<!-- -------------------FOOTER------------- -->
<?php include 'footer.php'; ?>