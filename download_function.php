 <?php 
	require 'secure/admin_database.php';
	require 'includes/functions.php';
	$query="SELECT * FROM category_name WHERE is_active='1' ";
 ?>

<?php include 'header.php'; ?>
<?php include 'nav.php'; ?>


<head>
  <title>Taking Exam-Online Entrance</title>
</head>

<div class="row">
	<div class="col-lg-1 col-md-1"></div>
	<div class="col-lg-10 col-md-10 col-xs-12 myRowBorder">
		<div class="mySubRowBorder">
			<u  style="color: #1222B5;"><h2 class="text-center">RULES AND REGULATIONS</h2></u>
 			<h4 class="text-center text-info">You must be registered users to download the answer and questions. <a href="login.php" style="color: #1222B5;text-decoration: none;">Click here</a> to login.</h4>
		</div>

		<div class="row">
			<div class="col-lg-12 col-md-12 col-xs-12">
				<p class="font-weight-bold">1. You must be registered users to download.</p>
		 		<p class="font-weight-bold">2. Exam time will be provided according to the time table provided by individuals fields.</p>
		 		<p class="font-weight-bold">3. You must have to complete all the questions on the prefered time otherwise it will submit automatically.</p>
		 		<p class="font-weight-bold">4. You must be registered users to participate on each and every exams. <a href="register.php">Click here</a> to register.</p>
		 		<p class="font-italic text-center">BEST OF LUCK !!</p>
	 		</div>
		</div>
	</div>
	<div class="col-lg-1 col-md-1"></div>
</div>

<!-- *************************CATEGORY*************************** -->
 
<div class="row">
	<div class="col-lg-1 col-md-1"></div>
	<div class="col-lg-10 col-md-10 col-xs-12 myRowBorder">
		<div class="row">
			<div class="col-lg-4 col-md-4"></div>
			<div class="col-lg-4 col-md-4 col-xs-4">
				<button class="btn btn-primary btn-lg btn-block" type="button" data-toggle="collapse" data-target="#collapseCategory" aria-expanded="false" aria-controls="collapseCategory">
					SELECT CATEGORY
				</button>

				<div class="collapse" id="collapseCategory">
				  <div class="card card-body">
				 		<h3 align="center">PLEASE SELECT YOUR SPECIFIED FIELD</h3>
				 		<?php $result=mysqli_query($con_admin,$query) or die(mysqli_error($con_admin));
								if (mysqli_num_rows($result)>0) { ?>
						
						<form method="post" action="downloads.php">
				 		 	<select class="form-control" name="cat">
				 				<?php while($rows=mysqli_fetch_assoc($result)) {?>
				 				<option value="<?php echo $rows['id']; ?>"><?php echo $rows['cat_name']; ?></option	>
				 				<?php } ?>
				 			</select><br>

				 			<center>
				 				<button type="submit" value="submit" name="submit" class="btn btn-default myLoginBtn">DOWNLOAD SECTION</button>
				 			</center>
				 		</form>
				 		<?php } else{
				 		echo "<h2 class='text-info text-center mySubRowBorder p-2'>There is not any available fields. Try again later.</h2>";
				 	} ?>
				 	</div>
				</div>
			</div>
			<div class="col-lg-4 col-md-4"></div>
		</div>
	</div>
	<div class="col-lg-1 col-md-1"></div>
</div>

<!-- *************************FOOTER*************************** -->
<?php include 'footer.php'; ?>