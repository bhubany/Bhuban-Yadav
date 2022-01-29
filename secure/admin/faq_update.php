<?php 
$con=mysqli_connect("localhost","root","","admin_database"); 
if (isset($_POST['update'])) {
	$questions=$_POST['questions'];
	$answers=$_POST['answers'];
	$upload_date=Date('Y-m-d-h-m-s-ms');
$query=@"INSERT INTO faq (questions,answers,trn_date) VALUES ('$questions','$answers','$upload_date')";
$res=mysqli_query($con,$query) or die(mysqli_error($con));
}
 ?>

<div>
	<form action="#" method="POST">
		<input type="text" name="questions" placeholder="Enter questions">
		<input type="text" name="answers" placeholder="Enter answers">
		<input type="submit" name="update" value="update">
	</form>
</div>