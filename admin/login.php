 <?php
  require 'admin_database.php';
  session_start();
  require 'admin_server.php';
if (isset($_SESSION["admin_username"])) {
 	header("Location:index.php");
 } 
 else
 	{ ?>
 <?php 
 include 'heading.php';
  ?>
<head>
	<title>ONLINE ENTRANCE | LOGIN </title>
	<link rel="stylesheet" type="text/css" href="assests/css/login_style.css">
</head>


<div class="row">
	<div class="col-lg-1 col-md-1"></div>
	<div class="col-lg-10 col-md-10 col-xs-12 myContainer">
		<div class="row">
			<div class="col-lg-2 col-md-2"></div>
			<div class="col-lg-8 col-md-8 col-xs-12">
				<div class="myForm">
		  			<div class="myFormTitle mySubRowBorder">
		  				<u style="color: #1222B5; font-weight: bold;"><h2>LOGIN - ADMIN PANEL</h2></u>
						<h4 class="text-danger">Please leave this page if you are not authorised persons.</h4>
					</div>

					<form action="login.php" method="post">
		
							<!-- !!!*********PRINTINGs ERRORS.**********!!!! -->
							<br>
		 
							<?php include('errors.php'); ?>
				
						<div class="form-group">
			      			<label for="text" class="font-weight-bold">Email or Username:</label>
			      			<input type="text" class="form-control" id="username" placeholder="Enter username or email" name="username" autocomplete="on">
			    		</div>

						<div class="form-group">
			      			<label for="password" class="font-weight-bold">Password:</label>
			      			<input type="password" class="form-control" id="password" placeholder="Enter Password" name="password">
			    		</div>
						
						<div class="form-check">
						    <input type="checkbox" class="form-check-input" name="robot" value="1">
						    <label class="form-check-label" for="exampleCheck1">I AM NOT A ROBOT?</label>
						</div>

						<div>
							<button type="submit" class="btn btn-default myLoginBtn" name="log_admin">Login</button>
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

<!-- ******************FOOTER******************* -->
<?php  include("footer.php") ?>
