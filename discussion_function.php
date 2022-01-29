<?php
	if(!session_id()){
	  session_start();
	}
?>

<?php 
require 'secure/discussion_db.php';
require 'includes/functions.php';
$errors=array();

// -----------Cleaning all previously set values and sessions------
	unset($_SESSION['discussion_field']);
	unset($_SESSION['subject_selection']);
	unset($_SESSION['question_id']);
	unset($_SESSION['question_num']);
	unset($_SESSION['sub_name']);

if (clean_values($con_discussion,isset($_POST['category_submit']))) {
	$_SESSION['discussion_field']=clean_values($con_discussion,$_POST['cat']);
	header("Location:discussion_subject_selection.php");
	
}else{
	array_push($errors, "Error occurs try agai later");
}

$query="SELECT * FROM category_name";

?>

<head>
  <title>Online Entrance-Discussion</title>
</head>
<style type="text/css">
	.mySubRowBorder{
	border: solid #095EA7 2px;
	background-color: white;
}

</style>

<?php include 'header.php'; ?>
<?php include 'nav.php'; ?>


<div class="row">
	<div class="col-lg-1 col-md-1"></div>
	<div class="col-lg-10 col-md-10 col-xs-12 myRowBorder">
		<div class="mySubRowBorder">
			<u  style="color: #1222B5;"><h2 class="text-center">START DISCUSSION</h2></u>
			<h4 class="text-center text-info">Not necessary to register for discuss and view the questions.</h4>
		</div>

		<div class="row">
			<div class="col-lg-12 col-md-12 col-xs-12">
				<p class="font-weight-bold">1. According to rules prefered on individual fields you cannot use programmable calculators.</p>
		 		<p class="font-weight-bold">2. Exam time will be provided according to the time table provided by individuals fields.</p>
		 		<p class="font-weight-bold">3. You must have to complete all the questions on the prefered time otherwise it will submit automatically.</p>
		 		<p class="font-weight-bold">4. You must be registered users to participate on each and every exams. <a href="register.php">Click here</a> to register.</p>
		 		<p class="font-italic text-center">THANK YOU !!</p>
	 		</div>
		</div>
	</div>
	<div class="col-lg-1 col-md-1"></div>
</div>


<div class="row">
	<div class="col-lg-1 col-md-1"></div>
	<div class="col-lg-10 col-md-10 col-xs-12 myRowBorder">
		<div class="row">
			<div class="col-lg-4 col-md-4"></div>
			<div class="col-lg-4 col-md-4 col-xs-4">
				<button class="btn btn-primary btn-lg btn-block" type="button" data-toggle="collapse" data-target="#collapseCategory" aria-expanded="false" aria-controls="collapseCategory">
					START DISCUSSION
				</button>

				<div class="collapse" id="collapseCategory">
				  <div class="card card-body">
				 		<h3 align="center">PLEASE SELECT YOUR SPECIFIED FIELD</h3>
						<?php
							$result=mysqli_query($con_discussion,$query) or die(mysqli_error($con_discussion)); 
							if (mysqli_num_rows($result)>0) { ?>
						<form method="post" action="">
				 			 <select class="form-control" name="cat">
				 				<?php while($rows=mysqli_fetch_assoc($result)) {?>
				 				<option value="<?php echo $rows['id']; ?>"><?php echo $rows['cat_name']; ?></option	>
				 				<?php } ?>
				 			  </select><br>

				 			  <center>
				 				<button type="submit" value="submit" name="category_submit" class="btn btn-default myLoginBtn">SELECT SUBJECT</button>
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

<!-- ------------FOOTER----------------- -->
<?php include 'footer.php'; ?>