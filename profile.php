<?php
 require('db.php');
include("auth.php");
include 'header.php';
include 'nav.php';
echo"<hr/>";

?>
 <!DOCTYPE html>
 <html>
 <head>
 	<title>Dashboard - Secured Page</title>
 </head>
 <body>
 	<div class="container">
 		<section class="services">
 			<h1>PROFILE</h1>
 			<h3>Welcome back <?php echo $_SESSION['username']; ?></h3>
 			<div class="col">
 				<h3><u>DASHBOARD:</u></h3>
 				<br>
  					<a href="profile.php"></a>
 					<a href="edit.php"></a>
 					<a href="index.php">Home</a>
					<a href="profile.php">Profile</a>
					<a href="rules.php">Exam</a>
					<a href="logout.php">Logout</a>
 			</div>
 		<div class="col1">
 			
 			<p>NAME:- FIRST MIDDLE LAST DATE OF BIRTH:-Year-Month-Year(B.S.)  Year-Month-Year(A.D.)<br><br>
 			PERMANENT ADDRESS:- &nbsp;COUNTRY:NEPAL&nbsp; ZONE:SAGARMATHA &nbsp;DISTRICT:SIRAHA&nbsp; CITY:AAURAHI GAAUNPALIKA&nbsp; TOLE:KARHARWA-01 <br><br>
 			TEMPORARY ADDRESS:- &nbsp;COUNTRY:NEPAL &nbsp;ZONE:SAGARMATHA &nbsp;DISTRICT:SIRAHA &nbsp;CITY:AAURAHI GAAUNPALIKA &nbsp;TOLE:KARHARWA-01 <br><br>
 			CONTACT NO:- +977 9819014565  +977 9808888909 <br><br>
 			USERNAME:- bhubany &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;        EMAIL:- yadav.bhuban.by@gmail.com</p>
 		</div>
 		<div class="col2">
 			<p class="imag"><img src="assests\images\image.jpg"></p>
 		</div>
 		</section>
 	</div>
 </body>
 </html>
 <?php include 'footer.php'; ?>