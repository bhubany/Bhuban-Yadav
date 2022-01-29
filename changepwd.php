<?php 
require('db.php');
include 'auth.php';
$Sucess="";
$id=$newid;
include 'server.php'; ?>

<?php include 'header.php'; ?>
<head>
	<link rel="stylesheet" type="text/css" href="assests/css/change_pwd-style.css">
	<title>ONLINE ENTRANCE - Changing Password</title>
</head>
<style type="text/css">
	.success {
  color: #3c763d; 
  background: #dff0d8; 
  margin-bottom: 20px;
}
</style>

<div class="change_pwd_header">
	<h3><u> DASHB<span class="red">O</span>ARD</u></h3>
	<h4>This is secured pages</h4>
</div>

<div class="navigation" id="navigation">
	  <ul>
		<li><a href="dashboard.php">PR<span class="red">O</span>FILE</a></li>
		<li><a href="index.php">H<span class="red">O</span>ME</a></li>
		<li><a href="rules.php">EXAM</a></li>
		<li><a href="edit.php">EDIT</a></li>
		<li><a href="changepwd.php">PASSW<span class="red">O</span>RD</a></li>
		<li><a href="deleteacnt.php">UNSUBSCRIBE</a></li>
		<li><a href="logout.php">LOG<span class="red">O</span>UT</a></li>
	  </ul>
</div>

<div class="changepwd_form">

	<form action="changepwd.php" class="changepwd_form" id="changepwd_form" method="post">
	<div class="success">
		<?php echo $Sucess; ?>
	</div>
	<div>
		<?php include('errors.php'); ?>
	</div>
<div>
	<p>ENTER <span class="red">O</span>LD PASSWORD:</p>
		<input type="password" name="oldpassword" placeholder="old Password">
</div>


<div>
	<p>ENTER NEW PASSW<span class="red">O</span>RD:</p>
		<input type="password" name="newpassword" placeholder="new Password">
</div>


<div>
	<p>CONFORM NEW PASSW<span class="red">O</span>RD:</p>
		<input type="password" name="conformpwd" placeholder="conform Password">
</div>

<div>
	<button type="submit" name="change_pwd" id="changepwd_btn" class="change_pwd">CHANGE</button>
</div>

	
	</form>
				</div>
				<?php// } ?>
	</div>
	<?php include 'footer.php'; ?>