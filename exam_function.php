<?php
	if(!session_id()){
	  session_start();
	}
?>

<?php 
	require_once 'secure/exam_database.php';
	require 'includes/functions.php';

	// -----------Cleaning all previously set values and sessions------
	unset($_SESSION['cat_selection']);
	unset($_SESSION['set_selection']);
	unset($_SESSION['exam_start']);
	unset($_SESSION['is_refreshed']);
	unset($_SESSION['view_res']);
	unset($_SESSION['is_res_saved']);
	unset($_SESSION['marks']);
	unset($_SESSION['wright']);
	unset($_SESSION['wrong']);
	unset($_SESSION['no_attempt']);
	unset($_SESSION['total_marks']);
	unset($_SESSION['user_res']);
	unset($_SESSION['save_res']);

if (clean_values($con_exam,isset($_POST['submit']))) {
	$_SESSION['cat_selection']=clean_values($con_exam,$_POST['cat']);
	$_SESSION['cat_selected']=1;
	header("Location:exam_set_selection.php");
}

$query="SELECT * FROM category_name";?>
<?php include 'header.php'; ?>
<?php include 'nav.php'; ?>

<head>
  <title>Taking Exam-Online Entrance</title>
</head>

<style type="text/css">
.mySubRowBorder{
	border: solid #095EA7 2px;
	background-color: white;
}
</style>

<div class="row">
	<div class="col-lg-1 col-md-1"></div>
	<div class="col-lg-10 col-md-10 col-xs-12 myRowBorder">
		<div class="mySubRowBorder">
			<u  style="color: #1222B5;"><h2 class="text-center">RULES AND REGULATIONS</h2></u>
 			<h4 class="text-center text-info">Please read the following informations carefully before starting the exams.</h4>
		</div>

		<div class="row">
			<div class="col-lg-12 col-md-12 col-xs-12">
				<p class="font-weight-bold">1. According to rules prefered on individual fields you cannot use programmable calculators.</p>
		 		<p class="font-weight-bold">2. Exam time will be provided according to the time table provided by individuals fields.</p>
		 		<p class="font-weight-bold">3. You must have to complete all the questions on the prefered time otherwise it will submit automatically.</p>
		 		<p class="font-weight-bold">4. You must be registered users to participate on each and every exams. <a href="register.php">Click here</a> to register.</p>
		 		<p class="font-italic text-center">BEST OF LUCK !!</p>
	 		</div>
		</div>

		<div class="row">
			<!-- -----------Total exam takens---------- -->
			<?php $qry_total_exam_taken=@"SELECT * FROM user_exam_details";
			$res_total_exam_taken=mysqli_query($con,$qry_total_exam_taken) or die($con);
			if (mysqli_num_rows($res_total_exam_taken)>0) {
				$total_exam_taken=mysqli_num_rows($res_total_exam_taken);
			?>
			<div class="col-xs-12 col-lg-12 col-md-12">
				<button type="button" class="btn btn-light border-success"><?php echo "Total exam taken: ".$total_exam_taken; ?></button>
				
			</div>
		<?php }else{echo "<h1 class='text-info'>No one has taken exam till this.</h1>";} ?>
		</div>
	</div>
	<div class="col-lg-1 col-md-1"></div>
</div>


<div class="row">
	<div class="col-lg-1 col-md-1"></div>
	<div class="col-lg-10 col-md-10 col-xs-12 myRowBorder">
		<div class="row">
			<div class="col-lg-4 col-md-4"></div>
			<div class="col-lg-4 col-md-4 col-xs-4 p-1">
				<button class="btn btn-primary btn-lg btn-block" type="button" data-toggle="collapse" data-target="#collapseCategory" aria-expanded="false" aria-controls="collapseCategory">
					TAKE EXAM
				</button>

				<div class="collapse" id="collapseCategory">
				  <div class="card card-body">
				 		<h3 align="center">PLEASE SELECT YOUR SPECIFIED FIELD</h3>
							<?php $result=mysqli_query($con_exam,$query) or die(mysqli_error($con_exam));
								if (mysqli_num_rows($result)>0) { ?>

						<form method="post" action="">
				 		 	<select class="form-control" name="cat">
				 				<?php while($rows=mysqli_fetch_assoc($result)) {?>
				 				<option value="<?php echo $rows['id']; ?>"><?php echo $rows['cat_name']; ?></option	>
				 				<?php } ?>
				 			</select><br>

				 			<center>
				 				<button type="submit" value="submit" name="submit" class="btn btn-default myLoginBtn">SELECT SET</button>
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


<?php include 'footer.php'; ?>