<?php 
if (isset($_POST['submit_answer'])) {
	$question_id=$_REQUEST['question_id'];
	$reply_name=stripslashes($_REQUEST['name']);
	$reply_email=stripslashes($_REQUEST['email']);
	$reply_answer=$_REQUEST['answer'];
	date_default_timezone_set("Asia/Kathmandu");
	$reply_date= Date('Y-m-d-h-m-s-ms');

	if (empty($ask_subject)) 
		 {
    	array_push($errors, "Please specify subject");
  		 }
  	if (empty($ask_name))
  		{
    	array_push($errors, "Please enter your name");
		}
	if (empty($ask_email)) 
		 {
    	array_push($errors, "Please enter your email");
  		 }
  	if (empty($ask_msg))
  		{
    	array_push($errors, "Please enter your questions");
		}

		if (count($errors) == 0) {

	$query=@"INSERT INTO english_answers (name,email,answer,question_id,trn_date)
			VALUES('$reply_name','$reply_email','$reply_answer',$question_id,'$reply_date')";
			$result=mysqli_query($con,$query) or die(mysqli_error($con));
			if ($result=1) {
				echo "Sucess";
			}
			else{
				echo "FAILED";
			}
		}

}
 ?>