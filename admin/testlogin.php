<?php if ($_POST) {
	if ($_POST['uname']=='123' && $_POST['pwd']=='123') {
		$redirect_link=$_REQUEST['url'];
	}
	if ($redirect_link=="") {
		header("Location:test.php");
	}
	else{
		header("Location: ".$redirect_link);
	}
} ?>

<?php include 'testcomm.php'; ?>
<form action="" method="post">
	username: <input type="text" name="uname">
	Pwd: <input type="password" name="pwd">
	<input type="submit" name="login_user" value="login">
</form>