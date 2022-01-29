 <?php
	if(!session_id()){
	  session_start();
	}
?>

<?php 
	require 'discussion_db.php';
	require 'includes/functions.php';
	$errors=array();

	// -----------Checking previous values----------
if (clean_values($con_discussion,isset($_SESSION['discussion_field']))) {
	$field_id=clean_values($con_discussion,$_SESSION['discussion_field']);

}else{
	header("Location:discussion_function.php");
}

		// --------------Getting values from forms of this page-------
if (clean_values($con_discussion,isset($_POST['subject_submit']))) {
	$_SESSION['subject_selection']=clean_values($con_discussion,$_POST['subject']);
	header("Location:discussion_system_main.php");
}

	// ----------------Getting subject names-------
$query=@"SELECT * FROM subjects_name WHERE category_id='$field_id'";
 
 ?>
 
 <head>
  <title>ONLINE ENTRANCE- Discussion System- Subject Selection</title>

</head>
<style type="text/css">
	.mySubRowBorder{
	border: solid #095EA7 2px;
	background-color: white;
}

</style>

<?php include 'header.php'; ?>
<?php //include 'nav.php'; ?>


<div class="row">
	<div class="col-lg-1 col-md-1"></div>
	<div class="col-lg-10 col-md-10 col-xs-12 myRowBorder">
		<div class="mySubRowBorder">
			<u  style="color: #1222B5;"><h2 class="text-center">SUBJECT SELECTION</h2></u>
 			<h4 class="text-center text-info">You must select the categories on selection line by line from previous page.</h4>
 			<p class="font-italic text-center">You can got to the main home page by clicking on header above or <a href="index.php">click here</a></p>
		</div>

		<!-- <div class="row">
			<div class="col-lg-12 col-md-12 col-xs-12">
				<p class="font-weight-bold">1. According to rules prefered on individual fields you cannot use programmable calculators.</p>
		 		<p class="font-weight-bold">2. Exam time will be provided according to the time table provided by individuals fields.</p>
		 		<p class="font-weight-bold">3. You must have to complete all the questions on the prefered time otherwise it will submit automatically.</p>
		 		<p class="font-weight-bold">4. You must be registered users to participate on each and every exams. <a href="register.php">Click here</a> to register.</p>
		 		<p class="font-italic text-center">BEST OF LUCK !!</p>
	 		</div>
		</div> -->
<!-- 	</div>
	<div class="col-lg-1 col-md-1"></div>
</div>

<div class="row">
	<div class="col-lg-1 col-md-1"></div>
	<div class="col-lg-10 col-md-10 col-xs-12 myRowBorder"> -->
		<div class="row">
			<div class="col-lg-4 col-md-4"></div>
			<div class="col-lg-4 col-md-4 col-xs-4">
				<button class="btn btn-default btn-lg btn-block myHeader" style="color: #fff;">PLEASE SELECT SUBJECT FOR DISCUSSION</button>

					<?php $result=mysqli_query($con_discussion,$query) or die(mysqli_error($con_discussion));
							if (mysqli_num_rows($result)>0) { ?>
				<div class="myRowBorder p-2">
	 				<form method="post" action="">
			 			<!-- <input type="hidden" name="exam_time" value="<?php //echo $exam_time; ?>"> -->
			 			<!-- <input type="hidden" name="field_id" value="<?php //echo $field_id; ?>">  -->
			 		 	<select class="form-control" name="subject">
			 		 		<?php while($rows=mysqli_fetch_assoc($result)) {?>
			 				<option value="<?php echo $rows['id']; ?>"><?php echo $rows['subject']; ?></option>
			 				<?php } ?>
			 			</select><br>

			 			<center>
			 				<button type="submit" name="subject_submit" class="btn btn-default myLoginBtn">START DISCUSSION</button>
			 			</center>
			 		</form>
	 			</div>
	 		<?php } else{echo "<h3 class='text-info text-center mySubRowBorder p-2'>Currently not available any subject's in this category try again later.</h3>";} ?>
			</div>
			<div class="col-lg-4 col-md-4"></div>
		</div>
	</div>
	<div class="col-lg-1 col-md-1"></div>
</div>

<?php include 'footer.php'; ?>