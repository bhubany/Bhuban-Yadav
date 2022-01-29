<?php
require('db.php');
// session_start();
include("auth.php");
require 'getdata.php';
require 'server.php';
$id=$newid;
$query = "SELECT * from user_information where id='$id'"; 
$result = mysqli_query($con, $query) or die ( mysqli_error());
while($row = mysqli_fetch_assoc($result))
{
?>


<!DOCTYPE html>
<html>
<head>
	<link rel="stylesheet" type="text/css" href="update_styles.css">
	<title>Editing your details- Secured Page</title>
</head>
<body>
	<div class="wrapper">

<div class="header">
			<h2><u> DASHBOARD</u></h2>
	<h3>Welcome back <?php echo$row["firstname"]." ".$row["middlename"]." ".$row["surname"]; ?></h3>
</div>
		<header class="header"></header>
		<nav class="nav">
			<!-- <h3><u>DASHBOARD</u></h3> -->
				<ul>
					<li><a href="dashboard.php">Profile</a></li>
					<li><a href="profileEdit.php">Edit</a></li>
					<li><a href="changepwd.php">Password</a></li>
					<li><a href="index.php">Home</a></li>
					<li><a href="rules.php">Exam</a></li>
					<li><a href="logout.php">Logout</a></li>
				</ul>
		</nav>
		<!-- <div class="contents"> -->
			<!-- <h3>Welcome back</h3> -->
			<!-- <aside class="left-sidebar"> -->
				<!-- <h3><u>DASHBOARD</u></h3>
					<ul>
					<li><a href="dashboard.php">Profile</a></li>
					<li><a href="profileEdit.php">Edit</a></li>
					<li><a href="changepwd.php">Password</a></li>
					<li><a href="index.php">Home</a></li>
					<li><a href="rules.php">Exam</a></li>
					<li><a href="logout.php">Logout</a></li>
				</ul> -->
			<!-- </aside> -->
			<!-- <div class="content"> -->
				<!-- <div class="content-left"> -->
					<?php
// $status = "";
// if(isset($_POST['new']) && $_POST['new']==1)
// {
// $id=$_REQUEST['id'];
// $trn_date = Date('Y-m-d-h-m-s-ms');
// $firstName =$_REQUEST['firstname'];
// $middleName =$_REQUEST['middlename'];
// $surName =$_REQUEST['surname'];
// $pCountry=$_REQUEST['pcountry'];
// $pZone=$_REQUEST['pzone'];
// $pDistrict=$_REQUEST['pdistrict'];
// $pCity=$_REQUEST['pcity'];
// $pTole=$_REQUEST['ptole'];
// $tCountry=$_REQUEST['tcountry'];
// $tZone=$_REQUEST['tzone'];
// $tDistrict=$_REQUEST['tdistrict'];
// $tCity=$_REQUEST['tcity'];
// $tTole=$_REQUEST['ttole'];
// $Dob_bs=$_REQUEST['dob_bs'];
// $contact1=$_REQUEST['contact1'];
// $contact2=$_REQUEST['contact2'];
// // $submittedby = $_SESSION["username"];
// $update="update user_information set firstname='".$firstName."',
// middleName='".$middleName."', surname='".$surName."', pcountry='".$pCountry."',pzone='".$pZone."', pdistrict='".$pDistrict."', pcity='".$pCity."', ptole='".$pTole."',tcountry='".$tCountry."',tzone='".$tZone."', tdistrict='".$tDistrict."', tcity='".$tCity."', ttole='".$tTole."', contact1='".$contact1."', contact2='".$contact2."', updated_date='".$trn_date."' where id='".$id."'";
// mysqli_query($con, $update) or die(mysqli_error($con));
// $status = "Record Updated Successfully. </br></br>
// <a href='dashboard.php'>View Updated Record</a>";
// echo '<p style="color:#FF0000;">'.$status.'</p>';
// }else {
?>
<div class="update_form">
<form class="update_form" action="dashboard.php" method="post" id="update_form"> 

		<?php include('errors.php'); ?>

	<!-- <link rel="stylesheet" type="text/css" href="test.css"> -->
	<!-- <input type="hidden" name="new" value="1" /> -->
   		<p><u>NAME:</u></p>
 <div class="editName"> 
	<!-- <input name="id" type="hidden" value="<?php //echo $row['id'];?>" /> -->
	<input type="text" name="firstname" placeholder="First Name" value="<?php echo $row['firstname'];?>">
		<input type="text" name="middlename" placeholder="Middle Name" value="<?php echo $row['middlename'];?>">
	<input type="text" name="surname" placeholder="Sur Name" value="<?php echo $row['surname'];?>" />
</div>
		<p><u>PERMANENT ADDRESS:</u></p>
<!-- <p class="permanent">PERMANENT:</p> -->
<div class="editPAddress">
	<input type="text" name="pcountry" placeholder="Country Name" value="<?php echo $row['pcountry'];?>" >
		<input type="text" name="pzone" placeholder="Zone Name" value="<?php echo $row['pzone'];?>" >
			<input type="text" name="pdistrict" placeholder="District Name" value="<?php echo $row['pdistrict'];?>" >
		<input type="text" name="pcity" placeholder="City Name" value="<?php echo $row['pcity'];?>" >
	<input type="text" name="ptole" placeholder="Tole -ward" value="<?php echo $row['ptole'];?>" >
</div>


		<p><u>TEMPORARY:</u></p>
<div class="editTAddress">
	<input type="text" name="tcountry" placeholder="Country Name" value="<?php echo $row['tcountry'];?>">
		<input type="text" name="tzone" placeholder="Zone Name" value="<?php echo $row['tzone'];?>">
			<input type="text" name="tdistrict" placeholder="District Name" value="<?php echo $row['tdistrict'];?>">
		<input type="text" name="tcity" placeholder="City Name" value="<?php echo $row['tcity'];?>">
	<input type="text" name="ttole" placeholder="Tole-ward" value="<?php echo $row['ttole'];?>">
</div>


		<p><u>CONTACT:</u></p>
<div class="editContact">
	<input type="number" name="contact1" placeholder="contact1" value="<?php echo $row['contact1'];?>">
		<input type="number" name="contact2" placeholder="contact2"  value="<?php echo $row['contact2'];?>">
</div>

		<p><u>ENTER PASSWORD:</u></p>
<div>
		<input type="password" name="oldPassword" placeholder="Enter Password">
</div>

<div class="privacyPolicy">
	<p><span id="checkbox"><input type="checkbox" name="" ></span>I am not a robot.</p>
</div>

<div>
	<button type="submit" class="submit" name="update_user" id="update_btn">Update</button>
</div>
</form>
<?php } ?>
				
				<!-- <aside class="content-right-sidebar">IMAGE</aside>
			</div>
			<aside class="right-sidebar"></aside>
		</div>
		<footer class="footer"></footer> -->
	</div>
</div>
</body>
</html>