<?php 
 include_once 'db.php';
 require_once 'auth.php';
 $full_name= $_SESSION['fullname'];
 $errors=array();
 $sucess=0;
 $fname="";
 $mname="";
 $sname="";
 $pcountry="";
 $pzone="";
 $pdistrict="";
 $pcity="";
 $ptole="";
 $tcountry="";
 $tzone="";
 $tdistrict="";
 $tcity="";
 $ttole="";
 $contact1="";
 $contact2="";
 $dob_bs="";
 $username=$_SESSION['username'];
$sel_query="SELECT * FROM user_information WHERE username='$username';";
$result = mysqli_query($con,$sel_query) or die ( mysqli_error());
while($row = mysqli_fetch_assoc($result)) {
		$full_name=$row["firstname"]." ".$row["middlename"]." ".$row["surname"];
 ?>

 

<?php 
if (isset($_POST['update_name'])) {
	$fname=$_POST['fname'];
	$mname=$_POST['mname'];
	$sname=$_POST['sname'];
	// echo $fname.$mname.$sname;
	if (empty($fname)) {
		array_push($errors, "First name is required");
	}
	// if (empty($mname)) {
	// 	array_push($errors, "Middle name is required");
	// }
	if (empty($sname)) {
		array_push($errors, "Sur name is required");
	}
	if (count($errors)==0) {
		$update_name=@"UPDATE user_information SET firstname='$fname',middlename='$mname',surname='$sname' WHERE username='$username' LIMIT 1";
		$update_name_res=mysqli_query($con, $update_name) or die($con);
		if ($update_name_res==1) {
			$sucess=1;
			// exit(1);
		}
		else{
			$sucess=0;
			array_push($errors, "Error occurs on updating your details");
		}
	}
	// print_r($errors);
}

//----------FOR PERMANENT ADDRESS---------
if (isset($_POST['update_paddress'])) {
	$pcountry=$_POST['pcountry'];
	$pzone=$_POST['pzone'];
	$pdistrict=$_POST['pdistrict'];
	$pcity=$_POST['pcity'];
	$ptole=$_POST['ptole'];
	// echo $pcountry.$mname.$sname;
	if (empty($pcountry)) {
		array_push($errors, "Country is required");
	}
	if (empty($pzone)) {
		array_push($errors, "Zone is required");
	}
	if (empty($pdistrict)) {
		array_push($errors, "District is required");
	}
	if (empty($pcity)) {
		array_push($errors, "City is required");
	}
	if (empty($ptole)) {
		array_push($errors, "Tole is required");
	}
	if (count($errors)==0) {
		$update_name=@"UPDATE user_information SET pcountry='$pcountry',pzone='$pzone',pdistrict='$pdistrict',pcity='$pcity',ptole='$ptole' WHERE username='$username' LIMIT 1";
		$update_name_res=mysqli_query($con, $update_name) or die($con);
		if ($update_name_res==1) {
			$sucess=1;
			// exit(1);
		}
		else{
			$sucess=0;
			array_push($errors, "Error occurs on updating your details");
		}
	}
	// print_r($errors);
}
//---------FOR TEMPORARY DETAILS----------
if (isset($_POST['update_taddress'])) {
	$tcountry=$_POST['tcountry'];
	$tzone=$_POST['tzone'];
	$tdistrict=$_POST['tdistrict'];
	$tcity=$_POST['tcity'];
	$ttole=$_POST['ttole'];
	// echo $pcountry.$mname.$sname;
	if (empty($tcountry)) {
		array_push($errors, "Country is required");
	}
	if (empty($tzone)) {
		array_push($errors, "Zone is required");
	}
	if (empty($tdistrict)) {
		array_push($errors, "District is required");
	}
	if (empty($tcity)) {
		array_push($errors, "City is required");
	}
	if (empty($ttole)) {
		array_push($errors, "Tole is required");
	}
	if (count($errors)==0) {
		$update_name=@"UPDATE user_information SET tcountry='$tcountry',tzone='$tzone',tdistrict='$tdistrict',tcity='$tcity',ttole='$ttole' WHERE username='$username' LIMIT 1";
		$update_name_res=mysqli_query($con, $update_name) or die($con);
		if ($update_name_res==1) {
			$sucess=1;
			// exit(1);
		}
		else{
			$sucess=0;
			array_push($errors, "Error occurs on updating your details");
		}
	}
	// print_r($errors);
}
//------FOR CONTACT------
if (isset($_POST['update_contact'])) {
	$contact1=$_POST['contact1'];
	$contact2=$_POST['contact2'];
	// $sname=$_POST['sname'];
	// echo $fname.$mname.$sname;
	if (empty($contact1)) {
		array_push($errors, "Primary contact is required");
	}
	// if (empty($mname)) {
	// 	array_push($errors, "Middle name is required");
	// }
	// if (empty($sname)) {
		// array_push($errors, "Sur name is required");
	// }
	if (count($errors)==0) {
		$update_name=@"UPDATE user_information SET contact1='$contact1',contact2='$contact2' WHERE username='$username' LIMIT 1";
		$update_name_res=mysqli_query($con, $update_name) or die($con);
		if ($update_name_res==1) {
			$sucess=1;
			// exit(1);
		}
		else{
			$sucess=0;
			array_push($errors, "Error occurs on updating your details");
		}
	}
	// print_r($errors);
}

//-----------FOR DOB--------
if (isset($_POST['update_dob'])) {
	$dob_bs=$_POST['dob_bs'];
	if (empty($dob_bs)) {
		array_push($errors, "Enter your dob first.");
	}
	if (count($errors)==0) {
		$update_name=@"UPDATE user_information SET dob_bs='$dob_bs' WHERE username='$username' LIMIT 1";
		$update_name_res=mysqli_query($con, $update_name) or die($con);
		if ($update_name_res==1) {
			$sucess=1;
			// exit(1);
		}
		else{
			$sucess=0;
			array_push($errors, "Error occurs on updating your details");
		}
	}
	
}

 ?>

<head>
	<title>ONLINE ENTRANCE-Updating user details.</title>
</head>
<style type="text/css">
	.h1, .h2, .h3, h1, h2, h3,h4,h5,h6,hr, * {
  margin: 0px;
  padding: 0px;
}
.headerDashboard{
	width: 98%;
	border:solid #EEB5B5 10px;
	text-align: center;
	font-family: Times New Roman;
	background-color: #5F9EA0;
	color: #1222B5;
}
.headerDashboard>h4{
	color: #A94442;
	padding-bottom: 5px;
}
#navigation{
  line-height: 20px;
  font-weight: bold;
  width: 98%;
  /*margin: 0px auto 0px;*/
  background:skyblue;
  text-align: center;
  border:solid #EEB5B5 10px;
  /*border-bottom: none;*/
  border-radius: 0px 0px 0px 0px;
 /*padding: 0 20px;*/
}
#navigation ul li{
  list-style: none;
  display: inline-block;
}
#navigation ul li:hover{
  background-color: grey;
}
#navigation ul li a{
  color:#1222B5;
  padding: 10px;
  font-style: bold;
  font-family: Times New Roman;
  text-decoration: none;
}
.red{
  color: #FA0A2B;
}
.edit_header{
	width: 98%;
	border:solid #EEB5B5 10px;
	background-color: #5F9EA0;
	color: #1222B5;
	text-align: center;
	padding-bottom: 5px;
	padding-top: 5px;
	font-weight: bold;
	font-family: Times New Roman;
}
.edit_form{
	width: 98%;
	border:solid #EEB5B5 10px;
	background-color: #EEB5B5;
}
#edit_form input {
  width: 30%;
  height: 30px;
  margin: 3px 1%;
  font-size: 1.1em;
  padding: 4px;
  font-size: .9em;
}
.update_btn{
	text-align: center;
	/*padding-top: 10px;*/
}
#update_btn:hover{
	background:white;
	color: green;
	font-family: Times New Roman;
	font-weight: bold;
	font-size: 20px;
	cursor: alias;
}
#update_btn{
	height: 30px;
 	width: 30%;
 	color: white;
 	background:green;
 	border:none;
 	border-radius: 10px;	
}
	.error {
	  /*width: 92%; */
	  margin: 0px auto; 
	  padding: 10px; 
	  border: 1px solid #a94442; 
	  color: #a94442; 
	  background: #f2dede; 
	  border-radius: 5px; 
	  /*text-align: left;*/
	}
.success {
	width: 98%;
	border:solid #EEB5B5 10px;
	color: #3c763d; 
	background: #dff0d8; 
	/*border: 1px solid #3c763d;*/
	text-align: center;
	padding-top: 20px;
	padding-bottom: 20px;
	/*width: 98%;*/
	font-weight: bold;
	font-family: Times New Roman;
	}
	.error_occur{
		width: 98%;
		border:solid #EEB5B5 10px;
		text-align: center;
	}
</style>

<?php include 'header.php'; ?>

<div class="headerDashboard">
	<h2><u> UPDATE DETAILS</u></h2>
	<h4>Please use your original details only.</h4>			
</div>

<div class="navigation" id="navigation">
  <ul>
	<li><a href="dashboard.php">PR<span class="red">O</span>FILE</a></li>
	<li><a href="index.php">H<span class="red">O</span>ME</a></li>
	<li><a href="exam_function.php">EXAM</a></li>
	<li><a href="edit.php">EDIT</a></li>
	<li><a href="changepwd.php">PASSW<span class="red">O</span>RD</a></li>
	<li><a href="deleteacnt.php">UNSUBSCRIBE</a></li>
	<li><a href="logout.php">LOG<span class="red">O</span>UT</a></li>
  </ul>
</div>


<?php if ($sucess==1) { ?>
<div class="success">
	<?php echo "Your details hasbeen updated sucessfully"; ?>	
</div>
<?php $sucess=0;} ?>
<div class="error_occur">
	<?php include 'errors.php'; ?>
</div>


<div class="edit_header">
	<h3>UPDATE NAME</h3>
	<!-- <h5>Please use your original details only.</h5> -->
</div>
<div class="edit_form">
	<form action="" class="edit_form" id="edit_form" method="post">
		<input type="text" name="fname" placeholder="First name" value="<?php echo($fname); ?>">
		<input type="text" name="mname" placeholder="Middle name" value="<?php echo($mname); ?>">
		<input type="text" name="sname" placeholder="Sur name" value="<?php echo($sname); ?>">
		<div class="update_btn">
			<input type="submit" name="update_name" value="UPDATE" id="update_btn">
		</div>		
	</form>
</div>

<div class="edit_header">
	<h3>UPDATE PERMANENT ADDRESS</h3>
</div>
<div class="edit_form">
	<form class="edit_form" id="edit_form" method="post">
		<input type="text" name="pcountry" placeholder="Country name" value="<?php echo($pcountry); ?>">
		<input type="text" name="pzone" placeholder="Zone name" value="<?php echo($pzone); ?>">
		<input type="text" name="pdistrict" placeholder="District name" value="<?php echo($pdistrict); ?>">
		<input type="text" name="pcity" placeholder="City name" value="<?php echo($pcity); ?>">
		<input type="text" name="ptole" placeholder="Tole name- ward" value="<?php echo($ptole); ?>">
		<div class="update_btn">
			<input type="submit" name="update_paddress" value="UPDATE" id="update_btn">
		</div>
	</form>
</div>

<div class="edit_header">
	<h3>UPDATE TEMPORARY ADDRESS</h3>
</div>
<div class="edit_form">
	<form class="edit_form" id="edit_form" method="post">
		<input type="text" name="tcountry" placeholder="Country name"  value="<?php echo($tcountry); ?>">
		<input type="text" name="tzone" placeholder="Zone name" value="<?php echo($tdistrict); ?>">
		<input type="text" name="tdistrict" placeholder="District name" value="<?php echo($tdistrict); ?>">
		<input type="text" name="tcity" placeholder="City name" value="<?php echo($tcity); ?>">
		<input type="text" name="ttole" placeholder="Tole name- ward" value="<?php echo($ttole); ?>">
		<div class="update_btn">
			<input type="submit" name="update_taddress" value="UPDATE" id="update_btn">
		</div>
	</form>
</div>

<div class="edit_header">
	<h3>UPDATE CONTACT DETAILS</h3>
</div>
<div class="edit_form">
	<form class="edit_form" id="edit_form" method="post">
		<input type="number" name="contact1" placeholder="98##########" value="<?php echo($contact1); ?>">
		<input type="number" name="contact2" placeholder="98########" value="<?php echo($contact2); ?>">
		<div class="update_btn">
			<input type="submit" name="update_contact" value="UPDATE" id="update_btn">
		</div>
	</form>
</div>

<div class="edit_header">
	<h3>UPDATE DATE OF BIRTH (DOB)</h3>
</div>
<div class="edit_form">
	<form class="edit_form" id="edit_form" method="post">
		<input type="date" name="dob_bs" placeholder="" value="<?php echo($dob_bs); ?>">
		<div class="update_btn">
			<input type="submit" name="update_dob" value="UPDATE" id="update_btn">
		</div>
	</form>
</div>
<?php } include 'footer.php'; ?>