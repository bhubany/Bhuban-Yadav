<?php
	if(!session_id()){
	  session_start();
	}
?>
<?php 
date_default_timezone_set("Asia/Kathmandu");
require 'secure/discussion_db.php';
require 'db.php';
require 'includes/functions.php';

$Sucess="";
$question_num="";
$errors=array();
$field_id=0;
$subject_id="";
$question_id="";
$reply_name="";
$reply_email="";
$reply_answer="";
$subject_name="";
$num="";
$reply_date= clean_values($con_discussion,Date('Y-m-d h:i:s'));

// --------------Checking previous page values---------------
if (clean_values($con_discussion,isset($_SESSION['discussion_field'])) and clean_values($con_discussion,isset($_SESSION['subject_selection'])) and clean_values($con_discussion,isset($_SESSION['sub_name'])) and clean_values($con_discussion,isset($_SESSION['question_id'])) and clean_values($con_discussion,isset($_SESSION['question_num']))) {
	$field_id=clean_values($con_discussion,$_SESSION['discussion_field']);
	$subject_id=clean_values($con_discussion,$_SESSION['subject_selection']);
	$subject_name=clean_values($con_discussion,$_SESSION['sub_name']);
	$question_id=clean_values($con_discussion,$_SESSION['question_id']);
	$question_num=clean_values($con_discussion,$_SESSION['question_num']);
}else{
	header("Location:discussion_system_main.php");
}


if (clean_values($con_discussion,isset($_POST['submit_answer']))) {
	$reply_name=clean_values($con_discussion,$_REQUEST['name']);
	$reply_email=clean_values($con_discussion,$_REQUEST['email']);
	$reply_answer=clean_values($con_discussion,$_POST['answer']);

  	if (empty($reply_name)){
    	array_push($errors, "Please enter your name");
	}elseif (strlen($reply_name)>50) {
		array_push($errors,"Please enter valid name, it can't be more than 50 characters");
	
	}elseif (!is_string($reply_name) or is_numeric($reply_name)) {
		array_push($errors, "Please enter your valid name");
	}

	if (empty($reply_email)){
    	array_push($errors, "Please enter your email");
  	}

  	if (empty($reply_answer)){
    	array_push($errors, "Please enter your answers");
	}

		// ------------Checking if already submitted----------
	$qry=@"SELECT * FROM replies WHERE category_id='$field_id' AND subject_id='$subject_id' AND question_id='$question_id'";
	$res=mysqli_query($con_discussion,$qry) or die(mysqli_error($con_discussion));
	if (mysqli_num_rows($res)>0) {	
		while ($row=mysqli_fetch_assoc($res)) {
			if ($reply_name==$row['name'] && $reply_email==$row['email'] && $reply_answer==$row['replies']) {
				array_push($errors, "You have already submitted this question for discussion");
			}
		}
	}

		// ------------Submitting replies to database-----------
	if (count($errors) == 0) {
		$query=@"INSERT INTO replies (name,email,category_id,subject_id,question_id,replies,trn_date)
			VALUES('$reply_name','$reply_email','$field_id',$subject_id,'$question_id','$reply_answer','$reply_date')";
		$result=mysqli_query($con_discussion,$query) or die(mysqli_error($con_discussion));
		if ($result=1) {
			$Sucess="Your Answer has been uploaded sucessfully.";
		}else{
			array_push($errors, "Failed to upload your answer try again later.");
		}
	}
}


 ?>

<head>
 	<title>Showing qll answers of that questions -discussion system</title>
 </head>

<style type="text/css">

.myDiscussionBorder{
	border: solid #1222B5 2px;
	border-radius: 10px;
}
.mySubRowBorder{
	border: solid #095EA7 2px;
	background-color: white;
}

</style>

<?php include 'header.php'; ?>

<!-- ----------------FORM FOR SUBMITTING ANSWERS------------------ -->

<div class="row">
	<div class="col-lg-1 col-md-1"></div>
	<div class="col-lg-10 col-md-10 col-xs-12 myContainer">
		<div class="row">
			<div class="col-lg-2 col-md-2"></div>
			<div class="col-lg-8 col-md-8 col-xs-12">
				<div class="myForm">
		  			<div class="myFormTitle mySubRowBorder">
						<u  style="color: #1222B5; font-weight: bold;"><h2 class="text-center">SUBMIT YOUR ANSWERS</h2></u>
			 			<h4 class="text-center text-info">Please provide correct replies only.</h4>
					</div>


						<?php if (clean_values($con,isset($_SESSION['username']))){
						$username=clean_values($con,$_SESSION['username']);
						$user_qry=@"SELECT * FROM user_information WHERE username='$username' ";
						$user_qry_res=mysqli_query($con,$user_qry) or die($con);
					 ?>		

						<!-- -----------------SUBMITTING QUESTION FORMS------------ -->
					<form action="" method="post" onsubmit="return submitQuestion();">
						<div class="" style="padding-top: 5px;padding-bottom: 5px;">
						      <?php include 'errors.php'; ?>
						      <?php if ($Sucess!="") {?>
						   <div class="mySuccess"><?php echo $Sucess; ?></div>
						      <?php } ?>
				    	</div>

				    		<?php 
								if (mysqli_num_rows($user_qry_res)>0) {
								//echo $num;	
								while ($user_row=mysqli_fetch_assoc($user_qry_res)) {
						 	?>

						<div class="form-group">
			      			<label for="text" class="font-weight-bold">FULL NAME:<span class="text-danger">*</span></label>
			      			<input type="text" class="form-control text-info" name="name" id="name" autocomplete="on" placeholder="Enter Your Full Name" value="<?php echo($user_row['firstname']." ".$user_row['middlename']." ".$user_row['surname']); ?>" readonly="on">
			    		</div>

						<div class="form-group">
			      			<label for="email" class="font-weight-bold">EMAIL:<span class="text-danger">*</span></label>
			      			<input type="email" class="form-control text-info" id="email" name="email" autocomplete="on" placeholder="Enter your email" value="<?php echo($user_row['email']); ?>" readonly="on"><br>
			      			<!-- <label for="email" class="text-warning font-weight-bold">We will not share your email with anyone</label> -->
			    		</div>


						<div class="form-group">
			      			<label for="text" class="font-weight-bold">ANSWER:<span class="text-danger">*</span></label>
			      			<textarea type="text" class="form-control text-info" id="answer" placeholder="Enter your answer" name="answer" value="<?php echo $reply_answer; ?>" rows="5"></textarea>
			    		</div>

			    		<div class="custom-control custom-checkbox mb-3 was-validated">
						    <input type="checkbox" class="custom-control-input" id="customControlValidation2" name="robot" required value="1">
						    <label class="custom-control-label" for="customControlValidation2">I Am not a Robot?</label>
						    <!-- <div class="invalid-feedback">Example invalid feedback text</div> -->
						</div>

						<div class="form-group">
							<button type="submit" class="btn btn-default myLoginBtn" name="submit_answer">SUBMIT</button>
						</div>
					
					</form>	

						<?php } } } else{ ?>

					<form action="" method="post" onsubmit="return submitQuestion();">
						<div class="" style="padding-top: 5px;padding-bottom: 5px;">
						      <?php include 'errors.php'; ?>
						      <?php if ($Sucess!="") {?>
						   <div class="mySuccess"><?php echo $Sucess; ?></div>
						      <?php } ?>
				    	</div>

						<div class="form-group">
			      			<label for="text" class="font-weight-bold">FULL NAME:<span class="text-danger">*</span></label>
			      			<input type="text" class="form-control text-info" name="name" id="name" autocomplete="on" placeholder="Enter Your Full Name" value="<?php echo $reply_name;  ?>">
			    		</div>

						<div class="form-group">
			      			<label for="email" class="font-weight-bold">EMAIL:<span class="text-danger">*</span></label>
			      			<input type="email" class="form-control text-info" id="email" name="email" autocomplete="on" placeholder="Enter your email" value="<?php echo $reply_email; ?>"><br>
			      			<!-- <label for="email" class="text-warning font-weight-bold">We will not share your email with anyone</label> -->
			    		</div>


						<div class="form-group">
			      			<label for="text" class="font-weight-bold">ANSWER:<span class="text-danger">*</span></label>
			      			<textarea type="text" class="form-control text-info" id="answer" placeholder="Enter your answer" name="answer" value="<?php echo $reply_answer; ?>" rows="5"></textarea>
			    		</div>

			    		<div class="custom-control custom-checkbox mb-3 was-validated">
						    <input type="checkbox" class="custom-control-input" id="customControlValidation2" name="robot" required value="1">
						    <label class="custom-control-label" for="customControlValidation2">I Am not a Robot?</label>
						    <!-- <div class="invalid-feedback">Example invalid feedback text</div> -->
						</div>

						<div class="form-group">
							<button type="submit" class="btn btn-default myLoginBtn" name="submit_answer">SUBMIT</button>
						</div>
					
					</form>	
				<?php } ?>
				</div>
			</div>
		</div>
		<div class="col-lg-2 col-md-2"></div>
	</div>
	<div class="col-lg-1 col-md-1"></div>
</div>



<div class="row">
	<div class="col-lg-1 col-md-1"></div>
	<div class="col-lg-10 col-md-10 col-xs-12 myContainer">

	<?php 
		$qsn_query=@"SELECT * FROM questions WHERE id=$question_id";
 	 	$question_result=mysqli_query($con_discussion,$qsn_query) or die (mysqli_error($con_discussion));
 	 	if (mysqli_num_rows($question_result)>0) { ?>

		<div class="row">
			<div class="col-lg-12 col-md-12 col-xs-12 myHeader">
				<h3 class="text-center font-weight-bold" style="color: #fff;">Question (Subject =><?php echo $subject_name; ?>) </h3>
			</div>
		</div>

 	 <!-- ********Starting divison of Question******** -->
	<?php while ($question_row=mysqli_fetch_assoc($question_result)) {	?>


 			<!-- ----------------------THIS IS FOR QUESTION----------------- -->
		<div class="row myDiscussionBorder" style="padding: 10px;font-weight: bold;">
			<div class="col-lg-4 col-md-4 col-xs-12">
				<div class="row">
					<div class="col-lg-3 col-md-3 col-xs-3"><br><br>
						<h5 class="font-weight-bold">Q.N:<?php echo $question_num; ?></h5>
					</div>

					<div class="col-lg-9 col-md-9 col-xs-9">
						<img src="assests\icons\profile.png" width="150" height="150">
					</div>
				</div>
			</div>

			<div class="col-lg-8 col-md-8 col-xs-12">
				<span class="pull-right font-italic"><?php echo $question_row['trn_date']; ?></span>
				<span class="pull-right font-weight-bold" style="color: #1222B5;"><h5 style="padding-right: 50px;"><?php echo $question_row['name']; ?></h5></span><br>
				<span class="font-weight-bold"><h4><?php echo $question_row['question']; ?></h4></span>

			</div>
		</div>				<br>

					<?php	}
				}else{echo "<h3 class='alert-danger text-center mySubRowBorder p-2'>Currently not available any Questions in this subject for this category. Try again later.</h3>";} ?>


			<!-- ----------------------STARTING OF REPLIES------------------- -->
			<?php  $i=1;
			 		$answer_query=@"SELECT * FROM replies WHERE category_id='$field_id' AND subject_id='$subject_id' AND question_id='$question_id'";
					$answer_result=mysqli_query($con_discussion,$answer_query);
					if (mysqli_num_rows($answer_result)>0) {
						$num=mysqli_num_rows($answer_result)?>

						<!-- -------------Replies header-------------- -->
		<div class="row">
			<div class="col-lg-12 col-md-12 col-xs-12 myHeader">
				<h3 class="text-center font-weight-bold" style="color: #fff;">Replies (<?php echo $num; ?>)</h3>
			</div>
		</div>

			<?php while ($row=mysqli_fetch_assoc($answer_result)) { 	$answer_id=$i; ?>

			<!-- ------------------Main reply Section------------ -->
		<div class="row myDiscussionBorder" style="padding: 10px;background-color: #f5f5f5;">
			<div class="col-lg-4 col-md-4 col-xs-12">
				<div class="row">
					<div class="col-lg-3 col-md-3 col-xs-3"><br><br>
						<h5 class="font-weight-bold">R.N:<?php echo $answer_id; ?></h5>
					</div>

					<div class="col-lg-9 col-md-9 col-xs-9">
						<img src="assests\icons\profile.png" width="150" height="150">
					</div>
				</div>
			</div>

			<div class="col-lg-8 col-md-8 col-xs-12">
				<span class="pull-right font-italic"><?php echo $row['trn_date']; ?></span>
				<span class="pull-right font-weight-bold" style="color: #1222B5;"><h5 style="padding-right: 50px;"><?php echo $row['name']; ?></h5></span><br>
				<span class="font-weight-bold font-italic"><p><?php echo $row['replies']; ?></p></span>
			</div>
		</div>				<br>
			<?php 
			$i++;}
			}else{echo "<h3 class='alert-danger text-center mySubRowBorder p-2'>Currently not available any replies for this question. Try again later.</h3>";}
			 
			 ?>
	</div>
	<div class="col-lg-1 col-md-1"></div>
</div>


<!-- ----------------Closing of Discussion main cntnt division----- -->

<?php include 'footer.php'; ?>