 <?php
 session_start();
require 'db.php';
require 'includes/functions.php';
require 'server.php';
if (isset($_SESSION["username"])) {
 	header("Location:dashboard.php");
 } 
 else
 	{ ?>
 	<?php include 'header.php'; ?>
 	<?php include 'nav.php'; ?>
<head>
	<title>ONLINE ENTRANCE | LOGIN</title>
	<!-- <link rel="stylesheet" type="text/css" href="assests/css/login_style.css"> -->
	<style type="text/css">
		.mySubRowBorder{
	border: solid #095EA7 2px;
	background-color: white;
}
	</style>
</head>

<div class="row">
	<div class="col-lg-1 col-md-1"></div>
	<div class="col-lg-10 col-md-10 col-xs-12 myContainer">
		<div class="row">
			<div class="col-lg-2 col-md-2"></div>
			<div class="col-lg-8 col-md-8 col-xs-12">
				<div class="myForm">
		  			<div class="myFormTitle mySubRowBorder">
		  				<u style="color: #1222B5; font-weight: bold;"><h2>LOGIN</h2></u>
						<!-- <h4 class="text-warning">Please leave this page if you are not authorised persons.</h4> -->
						<h4 class="text-info">Please register first if not registered yet. <a href="register.php">Click here</a>.</h4>
					</div>

					<form action="login.php" method="post">
		
							<!-- !!!*********PRINTINGs ERRORS.**********!!!! -->
							<br>
		 
							<?php include('errors.php'); ?>
				
						<div class="form-group">
			      			<label for="text" class="font-weight-bold">Email or Username:</label>
			      			<input type="text" class="form-control" id="username" placeholder="Enter username or email" name="username" value="<?php if(isset($_COOKIE['uname'])){echo $_COOKIE['uname'];} else {echo $log_username; } ?>">
			    		</div>

						<div class="form-group">
			      			<label for="password" class="font-weight-bold">Password:</label>
			      			<input type="password" class="form-control" id="password" placeholder="Enter Password" name="password" value="<?php if(isset($_COOKIE['pwd'])){echo $_COOKIE['pwd'];} ?>">
			    		</div>

						<div class="form-group">
						    <label for="password" class="font-weight-bold"><a href="resetpwd.php" style="text-decoration: none;">FORGOT PASSWORD?</a></label>
						</div>

						<div class="form-check">
						    <input type="checkbox" class="form-check-input" name="robot" value="1">
						    <label class="form-check-label" for="exampleCheck1">I AM NOT A ROBOT?</label>
						</div>

						<div class="form-check">
						    <input type="checkbox" class="form-check-input" name="remember" value="1" <?php if(isset($_COOKIE["member_login"])) { ?> checked <?php } ?> >
						    <label class="form-check-label" for="exampleCheck1">REMEMBER ME?</label>
						</div>

						<div>
							<button type="submit" class="btn btn-default myLoginBtn" name="log_user">Login</button>
						</div>

						<div class="form-group">
						    <label for="password">NOT REGISTERED YET? <a href="register.php">SIGN UP.</a></label>
						</div>
					</form>
				</div>
			</div>
		</div>
		<div class="col-lg-2 col-md-2"></div>
	</div>
	<div class="col-lg-1 col-md-1"></div>
</div>
<?php } ?>
<?php  include("footer.php") ?>
