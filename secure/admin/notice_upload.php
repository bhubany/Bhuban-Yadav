<?php
// date_default_timezone_get("Asia/Kathmandu");
$con=mysqli_connect("localhost","root","","admin_database"); 
// $msg="";
// $field_id=1;
// $cat_name="Engineering";
if (isset($_POST['upload_notice'])) {
	$title=$_POST['title'];
	$upload_date=Date('Y-m-d-h-m-s-ms');
	echo $upload_date;
	$notice=$_FILES['notice_file'];
	// $answers=$_FILES['answer'];
	
	$target="../notice/";
	$notice_name="ONLINE_ENTRANCE_Notice_".$title."_".$notice['name'];
	move_uploaded_file($notice['tmp_name'], $target.$notice_name);
	// print_r($notice);
	// echo "<br>".$notice['name']."<br>";
	// echo $notice_name;
	// print_r($answers);
	$upload_query=@"INSERT INTO notice(title,file_name,trn_date)VALUES('$title','$notice_name','$upload_date')";
		$res=mysqli_query($con,$upload_query) or die(mysqli_error($con));

}

 ?>

<div>
	<form action="" method="post" enctype="multipart/form-data">
		<input type="text" name="title">
		<input type="file" name="notice_file">
		<!-- <input type="file" name="answer"> -->
		<input type="submit" name="upload_notice">

	</form>
</div>