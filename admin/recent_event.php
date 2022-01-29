<?php 
require 'acess.php';
date_default_timezone_set("Asia/Kathmandu");
$upload_date=Date('Y-m-d h:m:s:ms');
$errors=array();
$Sucess="";
require 'admin_database.php';


//----------------SELECTING IMAGES PRESENT ON THAT ID-----------------
$qry_recent_event=@"SELECT * FROM recent_event";
$qry_recent_event_execute=mysqli_query($con_admin,$qry_recent_event) or die($con_admin);

//---------------
$recent_event_edit_status=0;
$edit_recent_event_id="";

//-----------
$edit_event_details="";

// -----------TO EDIT FAQ DETAILS CHECKING EXISTANCE------------------
if (isset($_POST['edit_recent_event'])) {
	$edit_recent_event_id=$_POST['edit_recent_event_id'];

	if (empty($edit_recent_event_id)) {
		array_push($errors, "recent_event ID is required to edit details");
	}
	if (count($errors)==0) {
		$edit_recent_event_qry=@"SELECT * FROM recent_event WHERE id='$edit_recent_event_id'";
		$edit_recent_event_execute=mysqli_query($con_admin,$edit_recent_event_qry) or die($con_admin);
		if (mysqli_num_rows($edit_recent_event_execute)==0) {
			array_push($errors, "There is not any recent_event present on the id = ".$edit_recent_event_id." on the database");
		}
		else{
			$recent_event_edit_status=1;
			$Sucess="Please enter new details in the form below";
			while ($edit_recent_event_rows=mysqli_fetch_assoc($edit_recent_event_execute)) {
				$edit_event_details=$edit_recent_event_rows['event_details'];
				// $edit_faq_answer=$edit_faq_rows['answers'];
				$_SESSION['edit_recent_event_id']=$edit_recent_event_rows['id'];
			}
		}
	}
}

//--------------UPDATING FAQ DETAILS TAKING NEW INPUTS----------
if (isset($_POST['update_recent_event'])) {
	$edit_recent_event_id=$_SESSION['edit_recent_event_id'];
	$update_event_details=$_POST['update_event_details'];
	// $update_faq_answer=$_POST['update_faq_answer'];

	if (empty($update_event_details)) {
		array_push($errors, "Please enter recent_event details.");
	}
	// if (empty($update_faq_answer)) {
	// 	array_push($errors, "Please enter FAQ answer.");
	// }

	if (count($errors)==0) {
		$update_recent_event_qry=@"UPDATE recent_event SET event_details='$update_event_details' WHERE id='$edit_recent_event_id'";
		$update_recent_event_result=mysqli_query($con_admin,$update_recent_event_qry) or die($con_admin);
		if ($update_recent_event_result==1) {
			header("Refresh:3");
			$Sucess="Your recent_event details has been updated sucessfully";
		}
		else{
			array_push($errors, "Error Occurs while updating your details");
		}
		
	}
}

// --------------TO ADD recent_event----------------------
if (isset($_POST['add_recent_event'])) {
	$add_event_details=$_POST['add_event_details'];
	// $add_faq_answer=$_POST['add_faq_answer'];
	// $extension = pathinfo($_FILES["add_notice_file"]["name"], PATHINFO_EXTENSION);
	// $target="../secure/notice/";
	// $add_notice="Online Entrance-".Date('Y_m_d_h_m_s_ms').$add_notice_name."-Notice.".$extension;
	// move_uploaded_file($_FILES["add_notice_file"]["tmp_name"], $target.$add_notice);

	if (empty($add_event_details)) {
		array_push($errors, "Please enter Event with details");
	}
	// if (empty($add_faq_answer)) {
	// 	array_push($errors, "Please enter FAQ answer");
	// }
	// if (empty($extension)) {
	// 	array_push($errors, "Please select file to upload.");
	// }

	if (count($errors)==0) {
	$add_recent_event_query=@"INSERT INTO recent_event(event_details,is_active,trn_date)
	VALUES('$add_event_details','1','$upload_date')";
	$add_recent_event_result=mysqli_query($con_admin,$add_recent_event_query) or die($con_admin);
	if ($add_recent_event_result==1) {
		header("Refresh:3");
			$Sucess="Your recent_event has been uploaded sucessfully. Wait till this disappear.";
			
		}
	else{
		array_push($errors, "Error occurs during adding recent_event");
	}
	}
}


// ---------------DELETE NOTICE-------------------
if (isset($_POST['del_recent_event'])) {
	$del_recent_event_id=$_POST['del_recent_event_id'];
	// echo $del_album_id;
	if (empty($del_recent_event_id)) {
		array_push($errors, "ID is required to delete recent_event");
	}
	$qry_exists_recent_event=@"SELECT * FROM recent_event WHERE id='$del_recent_event_id'";
	$qry_exists_recent_event_execute=mysqli_query($con_admin,$qry_exists_recent_event) or die($con_admin);
	if (mysqli_num_rows($qry_exists_recent_event_execute)==0) {
		array_push($errors, "There is not any faq present on id = ".$del_recent_event_id." . Check ID correctly and try again.");
	}
	if (count($errors)==0) {
		$del_recent_event_query=@"DELETE FROM recent_event WHERE id='$del_recent_event_id'";
		$del_recent_event_execute=mysqli_query($con_admin,$del_recent_event_query) or die($con_admin);
		if ($del_recent_event_execute==1) {
			$Sucess="recent_event has been deleted suscessfully presented on id= ".$del_recent_event_id;
			header("Refresh:3");
		}
		else{
			array_push($errors, "Error occurs on deleting recent_event of id= ".$del_recent_event_id);
		}
	}
}


// -----------ACTIVATE NOTICE----------
if (isset($_POST['activate_recent_event'])) {
	$activate_recent_event_id=$_POST['activate_recent_event_id'];
	$activate_recent_event_qry=@"UPDATE recent_event SET is_active='1' WHERE id='$activate_recent_event_id' LIMIT 1";
	$activate_recent_event_execute=mysqli_query($con_admin,$activate_recent_event_qry) or die($con_admin);
	if ($activate_recent_event_execute==1) {
		$Sucess="recent_event has been activated suscessfully presented on id= ".$activate_recent_event_id;
			header("Refresh:3");
	}
	else{
		array_push($errors, "Error occurs on Activating recent_event present on id= ".$activate_recent_event_id);
	}
}


// ------------------DEACTIVATE NOTICE-------------------

if (isset($_POST['deactivate_recent_event'])) {
	$deactivate_recent_event_id=$_POST['deactivate_recent_event_id'];
	$deactivate_recent_event_qry=@"UPDATE recent_event SET is_active='0' WHERE id='$deactivate_recent_event_id' LIMIT 1";
	$deactivate_recent_event_execute=mysqli_query($con_admin,$deactivate_recent_event_qry) or die($con_admin);
	if ($deactivate_recent_event_execute==1) {
		$Sucess="recent_event has been deactivated suscessfully presented on id= ".$deactivate_recent_event_id;
			header("Refresh:3");
	}
	else{
		array_push($errors, "Error occurs on deactivating recent event present on id= ".$deactivate_recent_event_id);
	}
}

?>
<?php include 'admin_nav.php'; ?>
<?php include 'heading.php'; ?>
<head>
	<title>ONLINE ENTRANCE | Gallery Albums admin section</title>
	<script src="assests/js/functions.js" type="text/javascript"></script>
	<link rel="stylesheet" type="text/css" href="assests/css/lightbox.min.css">
	<script type="text/javascript" src="assests/js/lightbox-plus-jquery.min.js"></script>
</head>
<style type="text/css">
hr,*,p{
	margin: 0px;
	padding: 0px;
}
.category_heading{
	font-family: Times New Roman;
	text-align: center;
	border: solid #EEB5B5 10px;
	color: #1222B5;
	background-color: #5F9EA0;
}
.category_perform_action{
	font-family: Times New Roman;
	text-align: center;
	border: solid #EEB5B5 10px;
	background-color: skyblue;
}
.category_perform_action>p{
	padding-top: 10px;
}
.category_perform_action>p>button{
	padding-left: 20px;
}
.category_details{
	border: solid #EEB5B5 10px;
	background-color: #EEB5B5;
	text-align: center;
	color: #1222B5;
}
.error {
  width: 92%; 
  margin: 0px auto;
  padding: 10px; 
  border: 1px solid #a94442; 
  color: #a94442; 
  background: #f2dede; 
  border-radius: 5px; 
  text-align: center;
}
.success {
  color: #3c763d; 
  background: #dff0d8; 
  /*border: 1px solid #3c763d;*/
  margin-bottom: 20px;
  /*padding: 5px;*/
}
.category_division{
	padding: 5px;
	padding-bottom: 30px;
}
table, td, th {
  border: 1px solid black;
}

table {
  border-collapse: collapse;
  width: 100%;
  color: #1222B5;
  text-align: center;
}

th {
  height: 50px;
  text-align: center;
  font-weight: bold;
  font-size: 20px;
}
td{
	font-family: Times New Roman;
	/*font-size: 20px;*/
}
.gallery{
	margin: 10px 50px;
}
.gallery img{
	transition: 1s;
	padding: 15px;
	width: 200px;
}
.gallery img:hover{
	filter: grayscale(100%);
	transform: scale(1.1);
}
</style>

<div class="category_heading">
	<h2>All category present on the database download</h2>
	<h4></h4>
</div>

<div class="category_perform_action">
	<div style="padding-top: 10px">
		<div class="success">
			<?php echo $Sucess; ?>
		</div>
		<?php include 'errors.php'; ?>
	</div>


<!-- -----------TO UPDATE/EDIT NOTICE DETAILS------------------ -->
<?php if ($recent_event_edit_status==0) {?>
<div class="category_division">
	<form method="post">
		<input type="number" name="edit_recent_event_id" placeholder="Enter recent_event ID.">
		<button type="submit" name="edit_recent_event">EDIT RECENT EVENT</button>
	</form>
</div>
<?php } ?>


<!-- -----------------TAKING NEW INPUTS TO UPDATE--------------------- -->
<?php if ($recent_event_edit_status==1) {?>
		<div class="category_division">
			<div style="border: solid #FA0A2B 2px; padding-top: 5px;padding-bottom: 5px; text-align: center;">
				<p><h2 style="color: #1222B5;text-decoration: underline;">ENTER NEW DETAILS TO UPDATE RECENT EVENTS</h2></p>
			<form method="post" action="">
				<input type="text" name="update_event_details" placeholder="Enter event details" value="<?php echo($edit_event_details); ?>">
				<!-- <input type="text" name="update_faq_answer" placeholder="Enter FAQ answer" value="<?php echo($edit_faq_answer); ?>"> -->
				<button type="submit" name="update_recent_event">UPDATE RECENT_EVENT</button>
			</form>
			</div>
		</div>
<?php } ?>

<!-- ---------------TO ADD NEW RECENT EVENTS---------------- -->
		<div class="category_division">
			<div style="border: solid #1222B5 2px; padding-top: 5px;padding-bottom: 5px; text-align: center;">
				<p><h2 style="color: #1222B5;text-decoration: underline;">ADD NEW RECENT EVENTS</h2></p>
			<form method="post" action="">
				<input type="text" name="add_event_details" placeholder="Enter Recent event with details">
				<!-- <input type="text" name="add_faq_answer" placeholder="Enter FAQ answer"> -->
				<button type="submit" name="add_recent_event">ADD RECENT EVENT</button>
			</form>
			</div>
		</div>

<!-- -----------------DELETE OR REMOVE NOTICE ------------------- -->
		<div class="category_division">
			<form method="post">
				<input type="number" name="del_recent_event_id" placeholder="Enter recent_event ID">
				<button type="submit" name="del_recent_event"  onclick="return confirmDel();">DELETE RECENT EVENT</button>
			</form>
		</div>
</div>


<!-- --------------SHOWING ALL THE RECENT EVENTS PRESENT ON THAT ALBUM----------- -->
<div class="category_details">
	<table>
  <tr>
  	<th>R.E._ID</th>
    <th>event_details</th>
    <th>IS_ACTIVE</th>
     <th>UPLOAD_AT</th>
    <th>ACTION</th>
  </tr>
  <?php while ($recent_event_rows=mysqli_fetch_assoc($qry_recent_event_execute)) { ?>
  <tr>
    <td><?php echo $recent_event_rows['id']; ?></td>
	<td><?php echo $recent_event_rows['event_details']; ?></td>
	<td><?php echo $recent_event_rows['is_active']; ?></td>
	<td><?php echo $recent_event_rows['trn_date']; ?></td>
	<td><?php if (($recent_event_rows['is_active'])==0) {?>
		<form method="post">
			<input type="hidden" name="activate_recent_event_id" value="<?php echo($recent_event_rows['id']); ?>">
			<button type="submit" name="activate_recent_event">ACTIVATE FAQ</button>
		</form>
	<?php }else{ ?>
		<form method="post">
			<input type="hidden" name="deactivate_recent_event_id" value="<?php echo($recent_event_rows['id']); ?>">
			<button type="submit" name="deactivate_recent_event">DEACTIVATE FAQ</button>
		</form>
	<?php } ?>
	</td>
  </tr>
  <?php } ?>
</table>
</div>



<?php include 'footer.php'; ?>