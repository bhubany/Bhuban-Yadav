<?php
	if(!session_id()){
	  session_start();
	}
?>

<?php 
	require 'secure/exam_database.php';
	require 'auth.php';
	require 'includes/functions.php';

	// ---------CHECKING Values for previous pages----
if (clean_values($con_exam,isset($_SESSION['cat_selection'])) and clean_values($con_exam,isset($_SESSION['cat_selected']))) {
	$field_id=clean_values($con_exam,$_SESSION['cat_selection']);
}else{
	header("Location:exam_function.php");
}

// -------------Taking values from form of this page-------------
if (clean_values($con_exam,isset($_POST['start_exam']))) {
	$_SESSION['set_selection']=clean_values($con_exam,$_POST['set']);
	$_SESSION['exam_start']=1;
	$_SESSION['is_refreshed']=0;
	header("Location:exam_start.php");
}

// ---------------Selecting all sets present on that categories------
$query=@"SELECT * FROM question_sets WHERE category_id=$field_id AND is_active='1'";

?>

<?php include 'header.php'; ?>
<head>
  <title>ONLINE ENTRANCE- Set selection</title>
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
			<u  style="color: #1222B5;"><h2 class="text-center">SELECT QUESTIONS SET</h2></u>
 			<h4 class="text-center text-info">You must select the categories on selection line by line from previous page.</h4>
 			<p class="font-italic text-center">You can got to the main home page by clicking on header above or <a href="index.php">click here</a></p>
		</div>


		<div class="row">
			<div class="col-lg-4 col-md-4"></div>
			<div class="col-lg-4 col-md-4 col-xs-4">
				<button class="btn btn-default btn-lg btn-block myHeader" style="color: #fff;">PLEASE SELECT QUESTIONS SET</button>
					<?php $result=mysqli_query($con_exam,$query) or die(mysqli_error($con_exam));
							if (mysqli_num_rows($result)>0) { ?>
				<div class="myRowBorder p-2">
	 				<form method="post" action="">
	 					<!-- <input type="hidden" name="exam_time" value="<?php //echo $exam_time; ?>"> -->
	 					<!-- <input type="hidden" name="field_id" value="<?php //echo $field_id; ?>">  -->
	 		 			<select class="form-control" name="set">
	 		 	
	 					<?php while($rows=mysqli_fetch_assoc($result)) {?>
	 					<option value="<?php echo $rows['set_id']; ?>"><?php echo "SET ".$rows['set_id']; ?></option>
	 					<?php } ?>
	 					</select><br>

	 					<center>
	 						<button type="submit" name="start_exam" class="btn btn-default myLoginBtn">START EXAM</button>
	 					</center>
	 				</form>
	 			</div>
	 		<?php }else { echo "<h3 class='text-info text-center mySubRowBorder p-2'>Currently not available any SET's in this category try again later.</h3>";} ?>
			</div>
			<div class="col-lg-4 col-md-4"></div>
		</div>
	</div>
</div>



<?php include 'footer.php'; ?>