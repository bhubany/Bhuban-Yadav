<?php 
	$sucess=array();
	$errors=array();
if (isset($_REQUEST['submit_answer'])) {
	$subject_name=$_REQUEST['subject'];
	$question_id=$_REQUEST['qsn_id'];
	$answer_name=$_REQUEST['name'];
	$answer_email=$_REQUEST['email'];
	$answer=$_REQUEST['answer'];
	date_default_timezone_set("Asia/Kathmandu");
	$answer_date = Date('Y-m-d-h-m-s-ms');

	if (empty($answer_name)) 
		 {
    	array_push($errors, "Please Enter Your Name");
  		 }
  	if (empty($answer_email))
  		{
    	array_push($errors, "Please Enter Your Email");
		}
	if (empty($answer)) {
		array_push($errors, "Please Enter Your Result");
	}

	if (count($errors) == 0) {


 				if ($subject_name=='a') {
 	 				$query="INSERT INTO aptitude_answers (name,email,answer,question_id,trn_date)
							VALUES('$answer_name','$answer_email','$answer','$question_id','$answer_date')";

				}
				else if ($subject_name=='c') {
					$query="INSERT INTO chemistry_answers (name,email,answer,question_id,trn_date)
							VALUES('$answer_name','$answer_email','$answer','$question_id','$answer_date')";
				}
				else if ($subject_name=='e') {
					$query="INSERT INTO english_answers (name,email,answer,question_id,trn_date)
							VALUES('$answer_name','$answer_email','$answer','$question_id','$answer_date')";
				}
				else if ($subject_name=='m') {
					$query="INSERT INTO math_answers (name,email,answer,question_id,trn_date)
							VALUES('$answer_name','$answer_email','$answer','$question_id','$answer_date')";
				}
				else if ($subject_name=='p') {
					$query="INSERT INTO physics_answers (name,email,answer,question_id,trn_date)
							VALUES('$answer_name','$answer_email','$answer','$question_id','$answer_date')";
				}

				else{
					echo "FAILED";
				}

				$result=mysqli_query($con,$query) or die(mysqli_error($con));
			if ($result=1) {
					array_push($sucess, "Your answer has been submitted sucessfully go and check on answers.");
			}
			else
			{
				array_push($errors, "Faild to Submit Your Answers");
			}

	}
}
 ?>