 <?php
	if(!session_id()){
	  session_start();
	}
?>

<?php 
	date_default_timezone_set("Asia/Kathmandu");
	require 'discussion_db.php';
	require 'db.php';
	require 'includes/functions.php';

	$field_id=0;
	$subject_id="";
	$sub_name="";
	$ask_name="";
	$ask_email="";
	$ask_msg="";
	$Sucess="";
	$errors=array();
	$ask_date = Date('Y-m-d H:i:s');


	// -----------CHecking is previous values set or not-----
if (clean_values($con_discussion,isset($_SESSION['discussion_field'])) and clean_values($con_discussion,isset($_SESSION['subject_selection']))) {
	$field_id=clean_values($con_discussion,$_SESSION['discussion_field']);
	$subject_id=clean_values($con_discussion,$_SESSION['subject_selection']);
}else{
	header("Location:discussion_subject_selection.php");
}


// ------------Getting question and details from this page forms----------
if (clean_values($con_discussion,isset($_POST['ask']))) {
	$ask_name=clean_values($con_discussion,$_REQUEST['name']);
	$ask_email=clean_values($con_discussion,$_REQUEST['email']);
	$ask_msg=clean_values($con_discussion,$_POST['qsn']);

  	if (empty($ask_name)){
    	array_push($errors, "Please enter your name");
	
	}elseif (strlen($ask_name)>50) {
		array_push($errors,"Please enter valid name, it can't be more than 50 characters");
	
	}elseif (!is_string($ask_name) or is_numeric($ask_name)) {
		array_push($errors, "Please enter your valid name");
	}

	if (empty($ask_email)) {
    	array_push($errors, "Please enter your email");
  	}

  	if (empty($ask_msg)){
    	array_push($errors, "Please enter your questions");
	}

		// ----------Checking if already submitted-----------
	$qry=@"SELECT * FROM questions WHERE category_id='$field_id' AND subject_id='$subject_id'";
	$res=mysqli_query($con_discussion,$qry) or die(mysqli_error($con_discussion));
	if (mysqli_num_rows($res)>0) {	
		while ($row=mysqli_fetch_assoc($res)) {
			if ($ask_name==$row['name'] && $ask_email==$row['email'] && $ask_msg==$row['question']) {
				array_push($errors, "You have already submitted this question for discussion");
			}
		}
	}
		// -------------Inserting to database----------
	if (count($errors) == 0) {
				
		$ask_query=@"INSERT INTO questions (name,email,category_id,subject_id,question,trn_date )
			VALUES ('$ask_name','$ask_email','$field_id','$subject_id','$ask_msg','$ask_date')";
		$ask_result=mysqli_query($con_discussion,$ask_query) or die(mysqli_error($con_discussion));
		if ($ask_result=1){
			$Sucess="Your question has been uploaded sucessfully";
		}else{
		array_push($errors, "Faild to Submit Your Questions.");
		}
	}
}

// ---------------Viewing replies of that questions-----------

if (clean_values($con_discussion,isset($_POST['goto_replies']))) {
	$_SESSION['question_id']=clean_values($con_discussion,$_POST['question_id']);
	$_SESSION['question_num']=clean_values($con_discussion,$_POST['question_num']);
	header("Location:discussion_answers.php");
}

	// -----Selecting Subject name----------
$subject_query=@"SELECT subject FROM subjects_name WHERE id='$subject_id'";
$result=mysqli_query($con_discussion,$subject_query) or die(mysqli_error($con_discussion));
	while ($subject_rows=mysqli_fetch_assoc($result)) {
 		$_SESSION['sub_name']=$subject_rows['subject'];
 	}
 ?>

 <?php include 'header.php';?>
 <?php //include 'nav.php'; ?>

 <head>
	<title>ONLINE ENTRANCE-Share and discuss questions</title>
	<script src="assests/js/discussion_validate.js" type="text/javascript"></script>
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


<div class="row">
	<div class="col-lg-1 col-md-1"></div>
	<div class="col-lg-10 col-md-10 col-xs-12 myContainer">
		<div class="row">
			<div class="col-lg-2 col-md-2"></div>
			<div class="col-lg-8 col-md-8 col-xs-12">
				<div class="myForm">
		  			<div class="myFormTitle mySubRowBorder">
						<u  style="color: #1222B5; font-weight: bold;"><h2 class="text-center">DISCUSS QUESTIONS</h2></u>
						<h4 class="text-center text-info">You are currently on  discussion of "<?php echo strtoupper($_SESSION['sub_name']);  ?>"</h4>
			 			<h4 class="text-center text-info">Please enter your details correctly on input field for discussion.</h4>
					</div>


						<!-- -----------------SUBMITTING QUESTION FORMS------------ -->

						<?php if (clean_values($con,isset($_SESSION['username']))){
						$username=clean_values($con,$_SESSION['username']);
						$user_qry=@"SELECT * FROM user_information WHERE username='$username' ";
						$user_qry_res=mysqli_query($con,$user_qry) or die($con);
					 ?>

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
			      			<label for="text" class="font-weight-bold">QUESTIONS:<span class="text-danger">*</span></label>
			      			<textarea type="text" class="form-control text-info" id="qsn" placeholder="Enter your questions" name="qsn" value="<?php echo($ask_qsn); ?>" rows="5"></textarea>
			    		</div>

			    		<div class="custom-control custom-checkbox mb-3 was-validated">
						    <input type="checkbox" class="custom-control-input" id="customControlValidation2" name="robot" required value="1">
						    <label class="custom-control-label" for="customControlValidation2">I Am not a Robot?</label>
						    <!-- <div class="invalid-feedback">Example invalid feedback text</div> -->
						</div>

						<div class="form-group">
							<button type="submit" class="btn btn-default myLoginBtn" name="ask"  id="ask_btn">SUBMIT</button>
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
			      			<input type="text" class="form-control" name="name" id="name" autocomplete="on" placeholder="Enter Your Full Name" value="<?php echo $ask_name ?>">
			    		</div>

						<div class="form-group">
			      			<label for="email" class="font-weight-bold">EMAIL:<span class="text-danger">*</span></label>
			      			<input type="email" class="form-control" id="email" name="email" autocomplete="on" placeholder="Enter your email" value="<?php echo $ask_email ?>"><br>
			      			<!-- <label for="email" class="text-warning font-weight-bold">We will not share your email with anyone</label> -->
			    		</div>


						<div class="form-group">
			      			<label for="text" class="font-weight-bold">QUESTIONS:<span class="text-danger">*</span></label>
			      			<textarea type="text" class="form-control" id="qsn" placeholder="Enter your questions" name="qsn" value="<?php echo($ask_qsn); ?>" rows="5"></textarea>
			    		</div>

			    		<div class="custom-control custom-checkbox mb-3 was-validated">
						    <input type="checkbox" class="custom-control-input" id="customControlValidation2" name="robot" required="on" value="1">
						    <label class="custom-control-label" for="customControlValidation2">I Am not a Robot?</label>
						    <!-- <div class="invalid-feedback">Example invalid feedback text</div> -->
						</div>

						<div class="form-group">
							<button type="submit" class="btn btn-default myLoginBtn" name="ask"  id="ask_btn">SUBMIT</button>
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




<!-- ----------------------STARTING OF DISCUSSION MAIN CONTENT---------------- -->
<div class="row">
	<div class="col-lg-1 col-md-1"></div>
	<div class="col-lg-10 col-md-10 col-xs-12 myContainer">

		<?php 

					$question="SELECT * FROM questions WHERE category_id='$field_id' AND subject_id='$subject_id'";
					$question_result=mysqli_query($con_discussion,$question);
					if (mysqli_num_rows($question_result)>0) {
						$total_qsn=mysqli_num_rows($question_result);
		 ?>
		
		<div class="row">
			<div class="col-lg-12 col-md-12 col-xs-12 myHeader">
				<h2 class="text-center font-weight-bold" style="color: #fff;">Total Question => <?php echo $total_qsn; ?> </h2>
			</div>
		</div>
				<?php	$i=1;
						while ($question_row=mysqli_fetch_assoc($question_result)) {
							$question_id=$question_row["id"];
				?>

		<div class="row myDiscussionBorder" style="padding: 10px;background-color: #f5f5f5;">
			<div class="col-lg-4 col-md-4 col-xs-12">
				<div class="row">
					<div class="col-lg-3 col-md-3 col-xs-3"><br><br>
						<h2 class="font-weight-bold">Q.N:<?php echo $i; ?></h2>
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

				<span style="text-align: right;">
					<form action="" method="post">
						<input type="hidden" name="question_id" value="<?php echo $question_id; ?>">
						<input type="hidden" name="question_num" value="<?php echo($i); ?>">
						<?php 
							$answer_query=@"SELECT * FROM replies WHERE category_id='$field_id' AND subject_id='$subject_id' AND question_id='$question_id'";
							$answer_result=mysqli_query($con_discussion,$answer_query);
							if (mysqli_num_rows($answer_result)>0) {
								$num=mysqli_num_rows($answer_result);
							}else{
								$num=0;
							}
						?>
						<button type="submit" name="goto_replies" class="btn btn-default myLoginBtn">REPLIES(<?php echo $num; ?>)</button>
					</form> 
				</span>
			</div>
		</div>				<br>
				 <?php 
				 $i++; 
				}
			}else{ echo "<h3 class='alert-danger text-center mySubRowBorder p-2'>Currently not available any Questions in this subject for this category. Try again later.</h3>";} ?>		<!-- CLOSING OF 1 QUESTIONS -->
	</div>
	<div class="col-lg-1 col-md-1"></div>
</div>



<div class="row">
	<div class="col-lg-1 col-md-1"></div>
	<div class="col-lg-10 col-md-10 col-xs-12 myContainer">
		<div class="row mySubRowBorder">
			<div class="col-lg-4 col-md-4"></div>

			<div class="col-lg-4 col-md-4 col-xs-9" style="background-color: #f5f5f5;overflow: hidden;">
				<p style="padding-top: 10px;">THIS SECTION IS FOR PAGINATION</p>
			</div>

			<div class="col-lg-4 col-md-4 col-xs-3">
				<a href="#top"><i class="fa fa-arrow-circle-up pull-right" style="font-size:48px;color:black"></i></a>
			</div>
		</div>

	</div>
	<div class="col-lg-1 col-md-1"></div>
</div>



<?php include 'footer.php'; ?>