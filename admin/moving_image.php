<?php 
require 'acess.php';
date_default_timezone_set("Asia/Kathmandu");
$upload_date=Date('Y-m-d h:m:s:ms');
$errors=array();
$Sucess="";
require 'admin_database.php';

$album_details_id="";
$album_details_name="";

//---------------
$moving_img_edit_status=0;
$edit_moving_img_id="";

// -----------TO EDIT ALBUMS DETAILS CHECKING EXISTANCE------------------
if (isset($_POST['edit_moving_img'])) {
	$edit_moving_img_id=$_POST['edit_moving_img_id'];

	if (empty($edit_moving_img_id)) {
		array_push($errors, "Image ID is required to edit details");
	}
	if (count($errors)==0) {
		$edit_moving_img_qry=@"SELECT * FROM moving_img WHERE id='$edit_moving_img_id'";
		$edit_moving_img_execute=mysqli_query($con_admin,$edit_moving_img_qry) or die($con_admin);
		if (mysqli_num_rows($edit_moving_img_execute)==0) {
			array_push($errors, "There is not any images present on the id = ".$edit_moving_img_id." on the database");
		}
		else{
			$moving_img_edit_status=1;
			$Sucess="Please enter new details in the form below";
			while ($edit_moving_img_rows=mysqli_fetch_assoc($edit_moving_img_execute)) {
				$edit_moving_img_alt_text=$edit_moving_img_rows['img_alt_text'];
				$edit_moving_img_details=$edit_moving_img_rows['img_details'];
				$edit_moving_img_name=$edit_moving_img_rows['img_name'];
				$_SESSION['edit_moving_img_id']=$edit_moving_img_rows['id'];
			}
		}
	}
}

//--------------UPDATING ALBUMS DETAILS TAKING NEW INPUTS----------
if (isset($_POST['update_moving_img'])) {
	$edit_moving_img_id=$_SESSION['edit_moving_img_id'];
	$update_moving_img_name=$_POST['update_moving_img_name'];
	$update_moving_img_alt_text=$_POST['update_moving_img_alt_text'];
	$update_moving_img_details=$_POST['update_moving_img_details'];
	// $update_album_name=$_POST['update_album_name'];
	$update_extension = pathinfo($_FILES["update_moving_img_file"]["name"], PATHINFO_EXTENSION);	
	if (empty($update_moving_img_alt_text)) {
		array_push($errors, "Please enter alternative text for image while updating");
	}
	if (empty($update_moving_img_details)) {
		array_push($errors, "Please enter image details while updating");
	}

	if (count($errors)==0) {
		if (empty($update_extension)) {
		$update_moving_img_qry=@"UPDATE moving_img SET img_alt_text='$update_moving_img_alt_text',img_details='$update_moving_img_details' WHERE id='$edit_moving_img_id'";
		$update_moving_img_result=mysqli_query($con_admin,$update_moving_img_qry) or die($con_admin);
		if ($update_moving_img_result==1) {
			header("Refresh:3");
			$Sucess="Your image details has been updated sucessfully";
		}
		else{
			array_push($errors, "Error Occurs while updating your details");
		}
		}
		else{
			if (empty($update_moving_img_name)) {
				array_push($errors, "Please try again entering new image name");
				$album_name_err=1;
			}
			else{
			$update_target="../secure/moving_image/";
			$update_moving_img="Online Entrance-".Date('Y_m_d_h_m_s_ms')."-MOVING_IMAGE".$update_moving_img_name.".".$update_extension;
			move_uploaded_file($_FILES["update_moving_img_file"]["tmp_name"], $update_target.$update_moving_img);
			$update_image_qry=@"UPDATE moving_img SET img_name='$update_moving_img',img_alt_text='$update_moving_img_alt_text',img_details='$update_moving_img_details' WHERE id='$edit_moving_img_id' LIMIT 1";
		$update_moving_img_result=mysqli_query($con_admin,$update_moving_img_qry) or die($con_admin);
		if ($update_moving_img_result==1) {
			header("Refresh:3");
			$Sucess="Your image details has been updated sucessfully";
		}
		else{
			array_push($errors, "Error Occurs while updating your details");
		}
	}
		}
	}
}

// --------------TO ADD IMAGES ON MOVING IMAGES GALLERY----------------------
if (isset($_POST['add_moving_img'])) {
	$add_moving_img_name=$_POST['add_moving_img_name'];
	$add_moving_img_alt_text=$_POST['add_moving_img_alt_text'];
	$add_moving_img_details=$_POST['add_moving_img_details'];
	// $add_album_name=$_POST['add_album_name'];
	$extension = pathinfo($_FILES["add_moving_img_file"]["name"], PATHINFO_EXTENSION);
	$target="../secure/moving_image/";
	$add_moving_img="Online Entrance-".Date('Y_m_d_h_m_s_ms').$add_moving_img_name."-MOVING_IMAGE".$extension;
	move_uploaded_file($_FILES["add_moving_img_file"]["tmp_name"], $target.$add_moving_img);
	if (empty($add_moving_img_alt_text)) {
		array_push($errors, "Please enter alternative text for image");
	}
	if (empty($add_moving_img_details)) {
		array_push($errors, "Please enter image details");
	}
	if (empty($add_moving_img_name)) {
		array_push($errors, "Please enter name of image to upload in this album");
	}
	if (empty($extension)) {
		array_push($errors, "Please select image to upload.");
	}
	if (count($errors)==0) {
	$add_moving_img_query=@"INSERT INTO moving_img(img_details,img_name,img_alt_text,is_active,trn_date)
	VALUES('$add_moving_img_details','$add_moving_img','$add_moving_img_alt_text','1','$upload_date')";
	$add_moving_img_result=mysqli_query($con_admin,$add_moving_img_query) or die($con_admin);
	if ($add_moving_img_result==1) {
		header("Refresh:3");
			$Sucess="Your image has been uploaded sucessfully";
			
		}
	else{
		array_push($errors, "Error occurs during adding images");
	}
	}
}


// ---------------DELETE IMAGES-------------------
if (isset($_POST['del_moving_img'])) {
	$del_moving_img_id=$_POST['del_moving_img_id'];
	// echo $del_album_id;
	if (empty($del_moving_img_id)) {
		array_push($errors, "ID is required to delete IMAGES");
	}
	$qry_exists_moving_img=@"SELECT * FROM moving_img WHERE id='$del_moving_img_id'";
	$qry_exists_moving_img_execute=mysqli_query($con_admin,$qry_exists_moving_img) or die($con_admin);
	if (mysqli_num_rows($qry_exists_moving_img_execute)==0) {
		array_push($errors, "There is not any images present on id = ".$del_moving_img_id." . Check ID correctly and try again.");
	}
	if (count($errors)==0) {
		$del_moving_img_query=@"DELETE FROM moving_img WHERE id='$del_moving_img_id'";
		$del_moving_img_execute=mysqli_query($con_admin,$del_moving_img_query) or die($con_admin);
		if ($del_moving_img_execute==1) {
			$Sucess="IMAGE has been deleted suscessfully presented on id= ".$del_moving_img_id;
			header("Refresh:3");
		}
		else{
			array_push($errors, "Error occurs on deleting category of id= ".$del_moving_img_id);
		}
	}
}


// -----------ACTIVATE IMAGE----------
if (isset($_POST['activate_img'])) {
	$activate_img_id=$_POST['activate_img_id'];
	$activate_img_qry=@"UPDATE moving_img SET is_active='1' WHERE id='$activate_img_id' LIMIT 1";
	$activate_img_execute=mysqli_query($con_admin,$activate_img_qry) or die($con_admin);
	if ($activate_img_execute==1) {
		$Sucess="IMAGE has been activated suscessfully presented on id= ".$activate_img_id;
			header("Refresh:3");
	}
	else{
		array_push($errors, "Error occurs on Activating image present on id= ".$activate_img_id);
	}
}


// ------------------DEACTIVATE IMAGE-------------------

if (isset($_POST['deactivate_img'])) {
	$deactivate_img_id=$_POST['deactivate_img_id'];
	$deactivate_img_qry=@"UPDATE moving_img SET is_active='0' WHERE id='$deactivate_img_id' LIMIT 1";
	$deactivate_img_execute=mysqli_query($con_admin,$deactivate_img_qry) or die($con_admin);
	if ($deactivate_img_execute==1) {
		$Sucess="IMAGE has been deactivated suscessfully presented on id= ".$deactivate_img_id;
			header("Refresh:3");
	}
	else{
		array_push($errors, "Error occurs on Activating image present on id= ".$deactivate_img_id);
	}
}

//----------------SELECTING IMAGES PRESENT ON THAT ID-----------------
$qry_moving_img=@"SELECT * FROM moving_img";
$qry_moving_img_execute=mysqli_query($con_admin,$qry_moving_img) or die($con_admin);

?>

<?php include 'heading.php'; ?>
<?php include 'admin_nav.php'; ?>

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
  font-size: 30px;
}
td{
	font-family: Times New Roman;
	font-size: 20px;
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


<!-- ***********************STARTING OF MAIN SECTIONS************************ -->

<div class="row">
	<div class="col-lg-1 col-md-1"></div>
	<div class="col-lg-10 col-md-10 col-xs-12 myRowBorder">

		<!-- ------------------------HEADER---------------------- -->
		<div class="mySubRowBorder">
			<u  style="color: #1222B5;"><h2 class="text-center">FIELDS AVAILABLES FOR EXAM</h2></u>
 			<!-- <h4 class="text-center text-info">Please read the following informations carefully before starting the exams.</h4> -->
		</div>

			<!-- -------------------------ADD CATEGORY BTN-------------------- -->
		<div class="row">
			<div class="col-lg-4 col-md-4"></div>
			<div class="col-lg-4 col-md-4 col-xs-12">
				<!-- <button class="btn btn-primary btn-lg btn-block" type="button" data-toggle="collapse" data-target="#collapseCategory" aria-expanded="false" aria-controls="collapseCategory"> -->
					<button type="button" class="btn btn-primary btn-lg btn-block" data-toggle="modal" data-target="#forAddCategory">
					ADD CATEGORY
				</button>
			</div>
			<div class="col-lg-4 col-md-4"></div>
		</div>

			<!-- -----------------FOR SUCESS MESSAGE_----------- -->
		<div class="row">
			<div class="col-lg-12 col-md-12 col-xs-12">
					<?php include('errors.php');?>
							<?php if ($Sucess!="") {?>
				<div class="success">
					<?php echo $Sucess; ?>
				</div>
						<?php  } ?>
			</div>
		</div>
	</div>
	<div class="col-lg-1 col-md-1"></div>
</div>


<div class="category_heading">
	<h2>All images present on moving_image gallery</h2>
	<h4></h4>
</div>

<div class="category_perform_action">
	<div style="padding-top: 10px">
		<div class="success">
			<?php echo $Sucess; ?>
		</div>
		<?php include 'errors.php'; ?>
	</div>
<!-- -----------TO UPDATE/EDIT Albums DETAILS------------------ -->
<?php if ($moving_img_edit_status==0) {?>
<div class="category_division">
	<form method="post">
		<input type="number" name="edit_moving_img_id" placeholder="Enter image ID ">
		<button type="submit" name="edit_moving_img">EDIT IMAGE</button>
	</form>
</div>
<?php } ?>


<!-- -----------------TAKING NEW INPUTS TO UPDATE--------------------- -->
<?php if ($moving_img_edit_status==1) {?>
		<div class="category_division">
			<div style="border: solid #FA0A2B 2px; padding-top: 5px;padding-bottom: 5px; text-align: center;">
				<p><h2 style="color: #1222B5;text-decoration: underline;">ENTER NEW DETAILS TO UPDATE IMAGE</h2></p>
			<form method="post" action="" enctype="multipart/form-data">
				<input type="file" name="update_moving_img_file" placeholder="Select moving image">
				<input type="text" name="update_moving_img_name" placeholder="Enter image name" value="<?php //echo($edit_album_cvr_img); ?>">
				<input type="text" name="update_moving_img_alt_text" placeholder="Enter image alt text" value="<?php echo($edit_moving_img_alt_text); ?>">
				<input type="text" name="update_moving_img_details" placeholder="Enter image details" value="<?php echo($edit_moving_img_details); ?>">
				<!-- <input type="text" name="update_album_name" placeholder="Enter ALBUM name" value="<?php //echo($edit_album_name); ?>"> -->
				<button type="submit" name="update_moving_img">UPDATE IMAGES</button>
			</form>
			</div>
		</div>
<?php } ?>

<!-- ---------------TO ADD NEW IMAGES ON MOVING_IMAGE GALLERY---------------- -->
		<div class="category_division">
			<div style="border: solid #1222B5 2px; padding-top: 5px;padding-bottom: 5px; text-align: center;">
				<p><h2 style="color: #1222B5;text-decoration: underline;">ADD NEW IMAGES</h2></p>
			<form method="post" action="" enctype="multipart/form-data">
				<input type="file" name="add_moving_img_file" placeholder="Select image">
				<input type="text" name="add_moving_img_name" placeholder="Enter image name">
				<input type="text" name="add_moving_img_alt_text" placeholder="Enter image alt text">
				<input type="text" name="add_moving_img_details" placeholder="Enter image details">
				<button type="submit" name="add_moving_img">ADD IMAGES</button>
			</form>
			</div>
		</div>

<!-- -----------------DELETE OR REMOVEIMAGE ------------------- -->
		<div class="category_division">
			<form method="post">
				<input type="number" name="del_moving_img_id" placeholder="Enter image ID">
				<button type="submit" name="del_moving_img"  onclick="return confirmDel();">DELETE IMAGES</button>
			</form>
		</div>
</div>


<!-- --------------SHOWING ALL THE IMAGES PRESENT ON THAT ALBUM----------- -->
<div class="category_details">
	<table>
  <tr>
  	<th>Image_ID</th>
    <th>Moving_Image</th>
    <th>Image_alt_text</th>
    <th>Image_details</th>
    <th>Is_active</th>
    <th>Uploaded_at</th>
    <th>Action</th>
  </tr>
  <?php while ($moving_img_rows=mysqli_fetch_assoc($qry_moving_img_execute)) { ?>
  <tr>
    <td><?php echo $moving_img_rows['id']; ?></td>
    <td class="gallery">
    	<a href="../secure/moving_image/<?php echo $moving_img_rows['img_name']; ?>" data-lightbox="mygallery" data-title="<?php echo($moving_img_rows['img_details']); ?>">
	<img src="../secure/moving_image/<?php echo $moving_img_rows['img_name']; ?>" alt="<?php echo($moving_img_rows['img_alt_text']); ?>"></a></td>
	<td><?php echo $moving_img_rows['img_alt_text']; ?></td>
	<td><?php echo $moving_img_rows['img_details']; ?></td>
	<td><?php echo $moving_img_rows['is_active']; ?></td>
	<td><?php echo $moving_img_rows['trn_date']; ?></td>
	<td><?php if (($moving_img_rows['is_active'])==0) {?>
		<form method="post">
			<input type="hidden" name="activate_img_id" value="<?php echo($moving_img_rows['id']); ?>">
			<button type="submit" name="activate_img">ACTIVATE IMAGE</button>
		</form>
	<?php }else{ ?>
		<form method="post">
			<input type="hidden" name="deactivate_img_id" value="<?php echo($moving_img_rows['id']); ?>">
			<button type="submit" name="deactivate_img">DEACTIVATE IMAGE</button>
		</form>
	<?php } ?>
	</td>
  </tr>
  <?php } ?>
</table>
</div>






<?php include 'footer.php'; ?>