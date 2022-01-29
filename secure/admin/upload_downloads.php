<?php
// date_default_timezone_get("Asia/Kathmandu");
$con=mysqli_connect("localhost","root","","admin_database"); 
$msg="";
// $qry=@"SELECT * FROM category_name WHERE id='$field_id'";
$field_id=1;
$cat_name="Engineering";
if (isset($_POST['upload_file'])) {
	$set_id=$_POST['set_id'];
	$upload_date=Date('Y-m-d-h-m-s-ms');
	echo $upload_date;
	$questions=$_FILES['question'];
	$answers=$_FILES['answer'];
	// $questions['name']="ONLINE_ENTRANCE_".$cat_name."_QUESTIONS-SET_".$set_id.".pdf";
	// $answers['name']="ONLINE_ENTRANCE_".$cat_name."_ANSWERS_SET_".$set_id.".pdf";
	$target="../downloads/";
	$qsn_name="ONLINE_ENTRANCE_".$cat_name."_QUESTIONS_SET_".$set_id.$questions['name'];
	$ans_name="ONLINE_ENTRANCE_".$cat_name."_QUESTIONS_SET_".$set_id.$answers['name'];
	move_uploaded_file($questions['tmp_name'], $target.$qsn_name);
	move_uploaded_file($answers['tmp_name'], $target.$ans_name);
	print_r($questions);
	echo "<br>".$questions['name']."<br>";
	print_r($answers);
	$upload_query=@"INSERT INTO downloads(questions,answers,question_set,field_id,trn_date)
		VALUES('$qsn_name','$ans_name','$set_id','$field_id','$upload_date')";
		$res=mysqli_query($con,$upload_query) or die(mysqli_error($con));

}

 ?>

<div>
	<form action="" method="post" enctype="multipart/form-data">
		<input type="text" name="set_id">
		<input type="file" name="question">
		<input type="file" name="answer">
		<input type="submit" name="upload_file">

	</form>
</div>