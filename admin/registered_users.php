<?php 
require 'acess.php';
date_default_timezone_set("Asia/Kathmandu");
$upload_date=Date('Y-m-d h:m:s:ms');
$errors=array();
$Sucess="";
require 'admin_database.php';
require 'user_database.php';


//----------------SELECTING IMAGES PRESENT ON THAT ID-----------------
$qry_registered_users=@"SELECT * FROM user_information ORDER BY id DESC";
$qry_registered_users_execute=mysqli_query($con_user,$qry_registered_users) or die($con_user);

//---------------
// $faq_edit_status=0;
// $edit_faq_id="";

// //-----------
// $edit_faq_question="";
// $edit_faq_answer="";

// -----------TO EDIT FAQ DETAILS CHECKING EXISTANCE------------------
// if (isset($_POST['edit_faq'])) {
// 	$edit_faq_id=$_POST['edit_faq_id'];

// 	if (empty($edit_faq_id)) {
// 		array_push($errors, "FAQ ID is required to edit details");
// 	}
// 	if (count($errors)==0) {
// 		$edit_faq_qry=@"SELECT * FROM faq WHERE id='$edit_faq_id'";
// 		$edit_faq_execute=mysqli_query($con_admin,$edit_faq_qry) or die($con_admin);
// 		if (mysqli_num_rows($edit_faq_execute)==0) {
// 			array_push($errors, "There is not any FAQ present on the id = ".$edit_faq_id." on the database");
// 		}
// 		else{
// 			$faq_edit_status=1;
// 			$Sucess="Please enter new details in the form below";
// 			while ($edit_faq_rows=mysqli_fetch_assoc($edit_faq_execute)) {
// 				$edit_faq_question=$edit_faq_rows['questions'];
// 				$edit_faq_answer=$edit_faq_rows['answers'];
// 				$_SESSION['edit_faq_id']=$edit_faq_rows['id'];
// 			}
// 		}
// 	}
// }

//--------------UPDATING FAQ DETAILS TAKING NEW INPUTS----------
// if (isset($_POST['update_faq'])) {
// 	$edit_faq_id=$_SESSION['edit_faq_id'];
// 	$update_faq_question=$_POST['update_faq_question'];
// 	$update_faq_answer=$_POST['update_faq_answer'];

// 	if (empty($update_faq_question)) {
// 		array_push($errors, "Please enter FAQ question.");
// 	}
// 	if (empty($update_faq_answer)) {
// 		array_push($errors, "Please enter FAQ answer.");
// 	}

// 	if (count($errors)==0) {
// 		$update_faq_qry=@"UPDATE faq SET questions='$update_faq_question',answers='$update_faq_answer' WHERE id='$edit_faq_id'";
// 		$update_faq_result=mysqli_query($con_admin,$update_faq_qry) or die($con_admin);
// 		if ($update_faq_result==1) {
// 			header("Refresh:3");
// 			$Sucess="Your FAQ details has been updated sucessfully";
// 		}
// 		else{
// 			array_push($errors, "Error Occurs while updating your details");
// 		}
		
// 	}
// }

// --------------REPLYING MESSAGE TO USERS ON FEEDBACK----------------------
if (isset($_POST['send_reply'])) {
	$feedback_reply_msg=$_POST['feedback_reply_msg'];
	$feedback_reply_id=$_POST['feedback_reply_id'];

	if (empty($feedback_reply_msg)) {
		array_push($errors, "Empty message can't be replied");
	}
	

	//----------SEND MAIL-----------

	$email_sent=1;

	if (count($errors)==0 and $email_sent==1) {
	$update_feedback_reply_query=@"UPDATE users_feedback SET reply_msg='$feedback_reply_msg', is_action_performed='1'WHERE id='$feedback_reply_id' LIMIT 1";
	$update_feedback_reply_result=mysqli_query($con_admin,$update_feedback_reply_query) or die($con_admin);
	if ($update_feedback_reply_result==1) {
		header("Refresh:3");
			$Sucess="Your repply message has been send sucessfully. Wait till this disappear.";
			
		}
	else{
		array_push($errors, "Error occurs while relying to feedback");
	}
	}
}


// ---------------DELETE NOTICE-------------------
// if (isset($_POST['del_faq'])) {
// 	$del_faq_id=$_POST['del_faq_id'];
// 	// echo $del_album_id;
// 	if (empty($del_faq_id)) {
// 		array_push($errors, "ID is required to delete faq");
// 	}
// 	$qry_exists_faq=@"SELECT * FROM faq WHERE id='$del_faq_id'";
// 	$qry_exists_faq_execute=mysqli_query($con_admin,$qry_exists_faq) or die($con_admin);
// 	if (mysqli_num_rows($qry_exists_faq_execute)==0) {
// 		array_push($errors, "There is not any faq present on id = ".$del_faq_id." . Check ID correctly and try again.");
// 	}
// 	if (count($errors)==0) {
// 		$del_faq_query=@"DELETE FROM faq WHERE id='$del_faq_id'";
// 		$del_faq_execute=mysqli_query($con_admin,$del_faq_query) or die($con_admin);
// 		if ($del_faq_execute==1) {
// 			$Sucess="Category has been deleted suscessfully presented on id= ".$del_faq_id;
// 			header("Refresh:3");
// 		}
// 		else{
// 			array_push($errors, "Error occurs on deleting category of id= ".$del_faq_id);
// 		}
// 	}
// }


// -----------ACTIVATE NOTICE----------
if (isset($_POST['mark_feedback'])) {
	$feedback_id=$_POST['feedback_id'];
	$activate_feedback_qry=@"UPDATE users_feedback SET is_action_performed='1' WHERE id='$feedback_id' LIMIT 1";
	$activate_feedback_execute=mysqli_query($con_admin,$activate_feedback_qry) or die($con_admin);
	if ($activate_feedback_execute==1) {
		$Sucess="Feedback has been marked as done presented on id= ".$feedback_id;
			header("Refresh:3");
	}
	else{
		array_push($errors, "Error occurs on marking reply as done present on id= ".$feedback_id);
	}
}


// ------------------DEACTIVATE NOTICE-------------------

// if (isset($_POST['deactivate_faq'])) {
// 	$deactivate_faq_id=$_POST['deactivate_faq_id'];
// 	$deactivate_faq_qry=@"UPDATE faq SET is_active='0' WHERE id='$deactivate_faq_id' LIMIT 1";
// 	$deactivate_faq_execute=mysqli_query($con_admin,$deactivate_faq_qry) or die($con_admin);
// 	if ($deactivate_faq_execute==1) {
// 		$Sucess="FAQ has been deactivated suscessfully presented on id= ".$deactivate_faq_id;
// 			header("Refresh:3");
// 	}
// 	else{
// 		array_push($errors, "Error occurs on Activating faq present on id= ".$deactivate_faq_id);
// 	}
// }

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
	<h2>ALL FEEDBACKS PROVIDED BY USERS</h2>
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
<?php// if ($faq_edit_status==0) {?>
<!-- <div class="category_division">
	<form method="post">
		<input type="number" name="edit_faq_id" placeholder="Enter faq ID.">
		<button type="submit" name="edit_faq">EDIT FAQ</button>
	</form>
</div> -->
<?php //} ?>


<!-- -----------------TAKING NEW INPUTS TO UPDATE--------------------- -->
<?php //if ($faq_edit_status==1) {?>
		<!-- <div class="category_division">
			<div style="border: solid #FA0A2B 2px; padding-top: 5px;padding-bottom: 5px; text-align: center;">
				<p><h2 style="color: #1222B5;text-decoration: underline;">ENTER NEW DETAILS TO UPDATE FAQ</h2></p>
			<form method="post" action="">
				<input type="text" name="update_faq_question" placeholder="Enter FAQ question" value="<?php //echo($edit_faq_answer); ?>">
				<input type="text" name="update_faq_answer" placeholder="Enter FAQ answer" value="<?php //echo($edit_faq_answer); ?>">
				<button type="submit" name="update_faq">UPDATE FAQ</button>
			</form>
			</div>
		</div> -->
<?php //} ?>

<!-- ---------------TO ADD NEW FAQ ---------------- -->
	<!-- 	<div class="category_division">
			<div style="border: solid #1222B5 2px; padding-top: 5px;padding-bottom: 5px; text-align: center;">
				<p><h2 style="color: #1222B5;text-decoration: underline;">ADD NEW FAQ</h2></p>
			<form method="post" action="">
				<input type="text" name="add_faq_question" placeholder="Enter FAQ question">
				<input type="text" name="add_faq_answer" placeholder="Enter FAQ answer">
				<button type="submit" name="add_faq">ADD FAQ</button>
			</form>
			</div>
		</div> -->

<!-- -----------------DELETE OR REMOVE NOTICE ------------------- -->
<!-- 		<div class="category_division">
			<form method="post">
				<input type="number" name="del_faq_id" placeholder="Enter category ID">
				<button type="submit" name="del_faq"  onclick="return confirmDel();">DELETE FAQ</button>
			</form>
		</div>
</div>
 -->

<!-- --------------SHOWING ALL THE IMAGES PRESENT ON THAT ALBUM----------- -->
<div class="category_details">
	<table>
  <tr>
  	<th>USER_ID</th>
    <th>F.Name</th>
    <th>M. NAME</th>
    <th>S. NAME</th>
     <th>P. COUNTRY</th>
     <th>P. ZONE</th>
     <th>P. DISTRICT</th>
     <th>P. CITY</th>
     <th>P. TOLE</th>
      <th>T. COUNTRY</th>
     <th>T. ZONE</th>
     <th>T. DISTRICT</th>
     <th>T. CITY</th>
     <th>T. TOLE</th>
    <th>USERNAME</th>
     <th>EMAIL</th>
      <th>CONTACT1</th>
     <th>CONTACT2</th>
    <th>DOB_BS</th>
    <th>USERNAME</th>
     <th>EMAIL</th>
      <th>CONTACT1</th>
     <th>CONTACT2</th>
    <th>DOB_BS</th>
  </tr>
  <?php while ($feedback_rows=mysqli_fetch_assoc($qry_feedback_execute)) { ?>
  <tr>
    <td><?php echo $feedback_rows['id']; ?></td>
	<td><?php echo $feedback_rows['name']; ?></td>
	<td><?php echo $feedback_rows['email']; ?></td>
	<td><?php echo $feedback_rows['feedback']; ?></td>
	<td><?php echo $feedback_rows['telephone']; ?></td>
	<td><?php echo $feedback_rows['is_action_performed']; ?></td>
	<td>
		<?php
		if ($feedback_rows['is_action_performed']==1) {
		 echo $feedback_rows['reply_msg']; }
		 else{?>
		 	<form action="" method="post">
		 		<input type="hidden" name="feedback_reply_id" value="<?php echo($feedback_rows['id']); ?>">
		 		<input type="text" name="feedback_reply_msg" placeholder="Enter reply message">
		 		<button type="submit" name="send_reply">Send reply</button>
		 	</form>
			<?php } ?>
	</td>
	<td><?php echo $feedback_rows['trn_date']; ?></td>
	<td><?php if (($feedback_rows['is_action_performed'])==0) {?>
		<form method="post">
			<input type="hidden" name="feedback_id" value="<?php echo($feedback_rows['id']); ?>">
			<button type="submit" name="mark_feedback">MARK AS DONE</button>
		</form>
	<?php }else{ ?>
		<h2>ACTION PERFORMED</h2>
	<?php } ?>
	</td>
  </tr>
  <?php } ?>
</table>
</div>



<?php include 'footer.php'; ?>