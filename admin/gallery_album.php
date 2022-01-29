<?php
if(!session_id()){
  session_start();
}?>

<?php 
require 'acess.php';
date_default_timezone_set("Asia/Kathmandu");
$upload_date=Date('Y-m-d h:m:s:ms');
$errors=array();
$Sucess="";
include_once 'admin_database.php';


$album_edit_status=0;
$album_edit_id="";
$extension="";

// -------------CHECKING EXISTANCE DETAILS WHILE UPDATING-------------
$edit_album_cvr_img_name="";
$edit_album_cvr_img_alt_text="";
$edit_album_cvr_text="";
$edit_album_name="";
$edit_extension ="";
$edit_album_cvr_img="";



//--------------UPDATING ALBUMS DETAILS TAKING NEW INPUTS----------
if (isset($_POST['update_album'])) {
	$update_album_id=$_POST['update_album_id'];
	$update_album_cvr_img_name=$_POST['update_album_cvr_img_name'];
	$update_album_cvr_img_alt_text=$_POST['update_album_cvr_img_alt_text'];
	$update_album_cvr_text=$_POST['update_album_cvr_text'];
	$update_album_name=$_POST['update_album_name'];
	$update_extension = pathinfo($_FILES["update_album_cvr_img"]["name"], PATHINFO_EXTENSION);	
	if (empty($update_album_cvr_img_alt_text)) {
		array_push($errors, "Please enter alternative text for cover image while updating");
	}
	if (empty($update_album_cvr_text)) {
		array_push($errors, "Please enter cover image details while updating");
	}
	if (empty($update_album_name)) {
		array_push($errors, "Please enter ALBUM name while updating");
	}

	$edit_album_qry=@"SELECT * FROM gallery_album WHERE id='$update_album_id'";
	$edit_album_execute=mysqli_query($con_admin,$edit_album_qry) or die($con_admin);
		if (mysqli_num_rows($edit_album_execute)==0) {
			array_push($errors, "There is not any albumss present on the id = ".$edit_album_id." on the database");
		}

	if (count($errors)==0) {
		if (empty($update_extension)) {
		$update_album_qry=@"UPDATE gallery_album SET album_name='$update_album_name',album_cover_alt_text='$update_album_cvr_img_alt_text',album_cover_text='$update_album_cvr_text' WHERE id='$update_album_id' LIMIT 1";
		$update_album_result=mysqli_query($con_admin,$update_album_qry) or die($con_admin);
		if ($update_album_result==1) {
			$Sucess="Your album -> '".$update_album_name."' details has been updated sucessfully presented on id-> ".$update_album_id;
		}
		else{
			array_push($errors, "Error Occurs while updating your details");
		}
		}
		else{
			if (empty($update_album_cvr_img_name)) {
				array_push($errors, "Please try again entering new image name");
				$album_name_err=1;
			}
			else{
			$update_target="../secure/gallery_album/";
			$update_album_cvr_img="Online Entrance-".Date('Y_m_d_h_m_s_ms').$update_album_name."-".$update_album_cvr_img_name.".".$update_extension;
			move_uploaded_file($_FILES["update_album_cvr_img"]["tmp_name"], $update_target.$update_album_cvr_img);
			$update_album_qry=@"UPDATE gallery_album SET album_name='$update_album_name',album_cover_image='$update_album_cvr_img',album_cover_alt_text='$update_album_cvr_img_alt_text',album_cover_text='$update_album_cvr_text' WHERE id='$album_edit_id' LIMIT 1";
		$update_album_result=mysqli_query($con_admin,$update_album_qry) or die($con_admin);
		if ($update_album_result==1) {
			$Sucess="Your album -> '".$update_album_name."' details has been updated sucessfully presented on id -> ".$update_album_id;
		}
		else{
			array_push($errors, "Error Occurs while updating your details");
		}
	}
		}
	}
}

// --------------TO ADD ALBUMS----------------------
if (isset($_POST['add_album'])) {
	$album_cvr_img_name=$_POST['album_cvr_img_name'];
	$album_cvr_img_alt_text=$_POST['album_cvr_img_alt_text'];
	$album_cvr_text=$_POST['album_cvr_text'];
	$add_album_name=$_POST['add_album_name'];
	$extension = pathinfo($_FILES["album_cvr_img"]["name"], PATHINFO_EXTENSION);
	$target="../secure/gallery_album/";
	$album_cvr_img="Online Entrance-".Date('Y_m_d_h_m_s_ms').$add_album_name."-".$album_cvr_img_name.".".$extension;
	move_uploaded_file($_FILES["album_cvr_img"]["tmp_name"], $target.$album_cvr_img);
	if (empty($album_cvr_img_alt_text)) {
		array_push($errors, "Please enter alternative text for cover image");
	}
	if (empty($album_cvr_text)) {
		array_push($errors, "Please enter cover image details");
	}
	if (empty($add_album_name)) {
		array_push($errors, "Please enter ALBUM name");
	}
	if (empty($album_cvr_img_name)) {
		array_push($errors, "Please enter cover image name of album");
	}
	if (empty($extension)) {
		array_push($errors, "Please select cover image for album");
	}

	$qry_exists_gallery_album=@"SELECT * FROM gallery_album WHERE album_name='$add_album_name'";
	$qry_exists_gallery_album_execute=mysqli_query($con_admin,$qry_exists_gallery_album) or die($con_admin);
	if (mysqli_num_rows($qry_exists_gallery_album_execute)==0) {
		array_push($errors, "There is already albums ->  ".$add_album_name." Check It correctly and try again.");
	}

	if (count($errors)==0) {
	$add_album_query=@"INSERT INTO gallery_album(album_name,album_cover_image,album_cover_alt_text,album_cover_text,trn_date)VALUES('$add_album_name','$album_cvr_img','$album_cvr_img_alt_text','$album_cvr_text','$upload_date')";
	$add_album_result=mysqli_query($con_admin,$add_album_query) or die($con_admin);
	if ($add_album_result==1) {
		// header("Refresh:3");
			$Sucess="Your album -> ".$add_album_name." has been created sucessfully";
			
		}
	else{
		array_push($errors, "Error occurs during adding album");
	}
	}
}


// ---------------DELETE ALBUM-------------------
if (isset($_POST['del_album'])) {
	$del_album_id=$_POST['del_album_id'];
	$del_album_name=$_POST['del_album_name'];

	if (empty($del_album_id)) {
		array_push($errors, "ID is required to delete ALBUM");
	}
	$qry_exists_gallery_album=@"SELECT * FROM gallery_album WHERE id='$del_album_id'";
	$qry_exists_gallery_album_execute=mysqli_query($con_admin,$qry_exists_gallery_album) or die($con_admin);
	if (mysqli_num_rows($qry_exists_gallery_album_execute)==0) {
		array_push($errors, "There is not any albums present on id = ".$del_album_id." . Check ID correctly and try again.");
	}
	if (count($errors)==0) {
		$del_album_query=@"DELETE FROM gallery_album WHERE id='$del_album_id'";
		$del_album_execute=mysqli_query($con_admin,$del_album_query) or die($con_admin);
		if ($del_album_execute==1) {
			$Sucess="Album ->'".$del_album_name."' has been deleted suscessfully presented on id= ".$del_album_id;
			// header("Refresh:3");
		}
		else{
			array_push($errors, "Error occurs on deleting category of id= ".$del_album_id);
		}
	}
}



// -----------ACTIVATE Album----------
if (isset($_POST['activate_album'])) {
	$activate_album_id=$_POST['activate_album_id'];
	$activate_album_name=$_POST['activate_album_name'];
	$activate_gallery_qry=@"UPDATE gallery_album SET is_active='1' WHERE id='$activate_album_id' LIMIT 1";
	$activate_gallery_execute=mysqli_query($con_admin,$activate_gallery_qry) or die($con_admin);
	if ($activate_gallery_execute==1) {
		$Sucess="Image -> '".$activate_album_name."' has been activated suscessfully presented on id= ".$activate_album_id;
			// header("Refresh:3");
	}
	else{
		array_push($errors, "Error occurs on Activating image present on id= ".$activate_album_id);
	}
}


// ------------------DEACTIVATE Album-------------------

if (isset($_POST['deactivate_album'])) {
	$deactivate_album_id=$_POST['deactivate_album_id'];
	$deactivate_album_name=$_POST['deactivate_album_name'];
	$deactivate_gallery_qry=@"UPDATE gallery_album SET is_active='0' WHERE id='$deactivate_album_id' LIMIT 1";
	$deactivate_gallery_execute=mysqli_query($con_admin,$deactivate_gallery_qry) or die($con_admin);
	if ($deactivate_gallery_execute==1) {
		$Sucess="Image -> '".$deactivate_album_name."' has been deactivated suscessfully presented on id= ".$deactivate_album_id;
			// header("Refresh:3");
	}
	else{
		array_push($errors, "Error occurs on Activating image present on id= ".$deactivate_album_id);
	}
}

	// -----------For Pagination----------
	 if (isset($_GET['pageno'])) {
     	$pageno = $_GET['pageno'];
   	} else {
      	$pageno = 1;
    }

  	$no_of_records_per_page = 10;
  	$starting_from = ($pageno-1) * $no_of_records_per_page;

  	$total_pages_sql = "SELECT * FROM gallery_album";
    $result = mysqli_query($con_admin,$total_pages_sql);
    if (mysqli_num_rows($result)>0) {
    	$total_rows = mysqli_num_rows($result);
    	// echo "Total rows => ".$total_rows;
    	$total_pages = ceil($total_rows / $no_of_records_per_page);
    }else{
    	$total_pages=1;
    }

// -------------------GETTING ALL DETAILS FROM DATABASE---------------

$qry_gallery_album=@"SELECT * FROM gallery_album LIMIT $starting_from,$no_of_records_per_page";
$qry_gallery_album_execute=mysqli_query($con_admin,$qry_gallery_album) or die($con_admin);


?>

<?php include 'heading.php'; ?>
<?php include 'admin_nav.php'; ?>

<head>
	<title>ONLINE ENTRANCE | Gallery Albums admin section</title>
	<link rel="stylesheet" type="text/css" href="assests/css/lightbox.min.css">
	<script type="text/javascript" src="assests/js/lightbox-plus-jquery.min.js"></script>
	<script src="assests/js/functions.js" type="text/javascript"></script>
</head>
<style type="text/css">
.gallery img{
	transition: 1s;
	padding: 10px;
	width: 280px;
	height: 150px;
}
.gallery img:hover{
	filter: grayscale(100%);
	transform: scale(1.1);
}
</style>

<!-- ************************STARTING OF MAIN SECTIONS**************** -->
<div class="row">
	<div class="col-lg-1 col-md-1"></div>
	<div class="col-lg-10 col-md-10 col-xs-12 myRowBorder">

		<!-- ------------------------HEADER---------------------- -->
		<div class="mySubRowBorder">
			<u  style="color: #1222B5;"><h2 class="text-center">All GALLERY ALBUMS AVAILABLES ON DATABASE</h2></u>
 			<h4 class="text-center text-warning">Moving images album is compulsory do not change or edit it..</h4>
		</div>

			<!-- -------------------------ADD CATEGORY BTN-------------------- -->
		<div class="row">
			<div class="col-lg-4 col-md-4"></div>
			<div class="col-lg-4 col-md-4 col-xs-12 p-2">
					<button type="button" class="btn btn-primary btn-lg btn-block" data-toggle="modal" data-target="#forAddGallery">
					ADD ALBUMS
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


<!-- ----------------------PRINTING ALBUMS WITH DETAILS-------------- -->

<div class="row">
	<div class="col-lg-1 col-md-1"></div>
	<div class="col-lg-10 col-md-10 col-xs-12 myRowBorder">
		<div class="mySubRowBorder">
			<u  style="color: #1222B5;"><h2 class="text-center">CATEGORIES WITH DETAILS</h2></u>
 			<h4 class="text-center text-info">Please check column Action for update and delete .</h4>
		</div>

		<div class="row">
			<div class="col-lg-12 col-md-12 col-xs-12">
				<table class="table table-striped">
					<thead class="myHeader" style="color: white;">
						<tr>
							<th class="text-center"><strong>ID</strong></th>
							<th class="text-center"><strong>Name<strong></th>
							<th class="text-center"><strong>Alt_Text</strong></th>
							<th class="text-center"><strong>Cover_Img</strong></th>
							<th class="text-center"><strong>Status</strong></th>
							<th class="text-center"><strong>Created_at</strong></th>
							<th class="text-center"><strong>Actions</strong></th>
							<th></th>
						</tr>
					</thead>
					<tbody>
						<?php while ($album_rows=mysqli_fetch_assoc($qry_gallery_album_execute)) { ?>
						<tr align="center">
							<td><?php echo $album_rows['id']; ?></td>
							
							<td>
								<form action="gallery_album_details.php" method="post">
							      <input type="hidden" name="album_id" value="<?php echo($album_rows['id']); ?>">
							      <input type="hidden" name="album_name" value="<?php echo($album_rows['album_name']); ?>">
							      <button type="submit" class="btn btn-default myLoginBtn" name="view_album_details"><?php echo $album_rows['album_name']; ?></button>
							    </form>
							</td>

						    <td><?php echo $album_rows['album_cover_text']; ?></td>

							<td class="gallery">
						      <a href="../secure/gallery_album/<?php echo $album_rows['album_cover_image']; ?>" data-lightbox="mygallery" data-title="<?php echo($album_rows['album_cover_text']); ?>">
						  		<img src="../secure/gallery_album/<?php echo $album_rows['album_cover_image']; ?>" alt="<?php echo($album_rows['album_cover_alt_text']); ?>"></a>
						  	</td>

						  	<td>
									<?php if ($album_rows['is_active']==1) {?>
								<form action="" method="post">
                					<input type="hidden" name="deactivate_album_id" value="<?php echo $album_rows['id']; ?>">
                					<input type="hidden" name="deactivate_album_name" value="<?php echo $album_rows['album_name']; ?>">
									<button type="submit" class="btn btn-danger" name="deactivate_album">Deactivate</button>
								</form>
									<?php }else{ ?>
								<form action="" method="post">
                					<input type="hidden" name="activate_album_id" value="<?php echo $album_rows['id']; ?>">
                					<input type="hidden" name="activate_album_name" value="<?php echo $album_rows['album_name']; ?>">
									<button type="submit" class="btn btn-success" name="activate_album">Activate</button>
								</form>
									<?php } ?>
									
							</td>

							<td><?php echo $album_rows['trn_date']; ?></td>
							<td>
								<button type="button" class="btn btn-primary" data-toggle="modal" data-target="#forUpdateGallery" onclick="updateGallery('<?php echo($album_rows['id']); ?>')">Edit</button>
							</td>

							<td>
								<form method="post">
									<input type="hidden" name="del_album_id" value="<?php echo $album_rows['id']; ?>">
									<input type="hidden" name="del_album_name" value="<?php echo $album_rows['album_name']; ?>">
									<button type="submit" class="btn btn-danger" name="del_album"  onclick="return confirmDel();">Delete</button>
								</form>
							</td>
						</tr>
						<?php }  ?>
					</tbody>
				</table>
			</div>
		</div>
	</div>
	<div class="col-lg-1 col-md-1"></div>
</div>

<!-- -----------------FOR PAGINATION------------------ -->
<div class="row">
	<div class="col-lg-1 col-md-1"></div>
	<div class="col-lg-10 col-md-10 col-xs-12 myRowBorder">
		<div class="row">
		<div class="col-lg-4 col-md-4"></div>
		<div class="col-lg-4 col-md-4 col-xs-12 text-center">
			<!-- -----------Pagination--------- -->
			<div class="pager text-center">
		        <a href="?pageno=1" class="btn btn-default myPagerBtn">First</a>
		        <a class="btn btn-default myPagerBtn <?php if($pageno <= 1){ echo 'disabled'; } ?>" href="<?php if($pageno <= 1){ echo '#'; } else { echo "?pageno=".($pageno - 1); } ?>">Prev</a>
		        <a class="btn btn-default myPagerBtn <?php if($pageno >= $total_pages){ echo 'disabled'; } ?>" href="<?php if($pageno > $total_pages){ echo '#'; } else { echo "?pageno=".($pageno + 1); } ?>">Next</a>
		        <a class="btn btn-default myPagerBtn" href="?pageno=<?php echo $total_pages; ?>">Last</a>
		    </div>
		</div>
		<div class="col-lg-4 col-md-4"></div>
	</div>
	</div>
	<div class="col-lg-1 col-md-1"></div>
</div>

<!-- ------------------------------AJAX CODES-------------------- -->

<script type="text/javascript">

				// <!-- ------EDITING/UPDATING DETAILS----------- -->
	function updateGallery(id) {
		$('#update_gallery_id').val(id);

		$.post("getDataForModels.php",{
			update_gallery_id:id
		},function(data,status){
			var gallery=JSON.parse(data);
			$('#update_album_cvr_img_alt_text').val(gallery.album_cover_alt_text);
			$('#update_album_cvr_text').val(gallery.album_cover_text);
			$('#update_album_name').val(gallery.album_name);
		}

			);
		$('#forUpdateGallery').modal("show");
	}
              // update_album_cvr_img update_album_cvr_img_name update_album_cvr_img_alt_text update_album_cvr_text update_album_name update_album update_album_id

</script>

<!-- -----------------FOOTER--------------- -->
<?php include 'footer.php'; ?>

<!-- *******************ENDING OF MAIN SECTIONS*************** -->



<!-- ..........for adding New Albums............ -->

<div class="modal fade" id="forAddGallery" tabindex="-1" role="dialog" aria-labelledby="forAddGallery" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="forAddGallery">Adding New Albums</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <div class="myForm">
            <form method="post" action="" enctype="multipart/form-data">
              <div class="form-group">
                  <label for="text">Select Cover Image:</label>
                  <input type="file" class="form-control" id="file" name="album_cvr_img">
              </div>
              <div class="form-group">
                  <label for="text">Image Name:</label>
                  <input type="text" class="form-control" id="text" placeholder="Enter Image name" name="album_cvr_img_name">
              </div>
              <div class="form-group">
                  <label for="text">Image Alt_text:</label>
                  <input type="text" class="form-control" id="text" placeholder="Enter Image Alt_text" name="album_cvr_img_alt_text">
              </div>
              <div class="form-group">
                  <label for="text">Image Details:</label>
                  <input type="text" class="form-control" id="text" placeholder="Enter Image Details" name="album_cvr_text">
              </div>
              <div class="form-group">
                  <label for="text">Album Name:</label>
                  <input type="text" class="form-control" id="text" placeholder="Enter Album Name" name="add_album_name">
              </div>
                      <button type="submit" class="btn btn-primary" name="add_album">Add Album</button>
            </form>
        </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
      </div>
    </div>
  </div>
</div>
<!-- .............adding category finished........... -->


<!-- ..........for updating category............ -->

<div class="modal fade" id="forUpdateGallery" tabindex="-1" role="dialog" aria-labelledby="forUpdateGallery" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="forUpdateGallery">Adding New Albums</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <div class="myForm">
            <form method="post" action="" enctype="multipart/form-data">
              <div class="form-group">
                  <label for="update_album_cvr_img">Select Cover Image:</label>
                  <input type="file" class="form-control" id="update_album_cvr_img" name="update_album_cvr_img">
              </div>
              <div class="form-group">
                  <label for="update_album_cvr_img_name">Image Name:</label>
                  <input type="text" class="form-control" id="update_album_cvr_img_name" placeholder="Enter Image name" name="update_album_cvr_img_name">
              </div>
              <div class="form-group">
                  <label for="update_album_cvr_img_alt_text">Image Alt_text:</label>
                  <input type="text" class="form-control" id="update_album_cvr_img_alt_text" placeholder="Enter Image Alt_text" name="update_album_cvr_img_alt_text">
              </div>
              <div class="form-group">
                  <label for="update_album_cvr_text">Image Details:</label>
                  <input type="text" class="form-control" id="update_album_cvr_text" placeholder="Enter Image Details" name="update_album_cvr_text">
              </div>

              <div class="form-group">
                  <label for="update_album_name">Album Name:</label>
                  <input type="text" class="form-control" id="update_album_name" placeholder="Enter Album Name" name="update_album_name">
              </div>
              		<input type="hidden" name="update_album_id" id="update_gallery_id">
                   <button type="submit" class="btn btn-primary" name="update_album">Update Album</button>
            </form>
        </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
      </div>
    </div>
  </div>
</div>


<!-- .............updating category finished........... -->



<!-- -----------------TAKING NEW INPUTS TO UPDATE--------------------- -->
<?php if ($album_edit_status==1) {?>
		<div class="category_division">
			<div style="border: solid #FA0A2B 2px; padding-top: 5px;padding-bottom: 5px; text-align: center;">
				<p><h2 style="color: #1222B5;text-decoration: underline;">ENTER NEW DETAILS TO UPDATE ALBUMS</h2></p>
			<form method="post" action="" enctype="multipart/form-data">
				<input type="file" name="update_album_cvr_img" placeholder="Select cover image">
				<input type="text" name="update_album_cvr_img_name" placeholder="Enter Cover image name" value="<?php //echo($edit_album_cvr_img); ?>">
				<input type="text" name="update_album_cvr_img_alt_text" placeholder="Enter Cover image alt text" value="<?php echo($edit_album_cvr_img_alt_text); ?>">
				<input type="text" name="update_album_cvr_text" placeholder="Enter image details" value="<?php echo($edit_album_cvr_text); ?>">
				<input type="text" name="update_album_name" placeholder="Enter ALBUM name" value="<?php echo($edit_album_name); ?>">
				<button type="submit" name="update_album">UPDATE ALBUMS</button>
			</form>
			</div>
		</div>
<?php } ?>


<!-- update_album_cvr_img update_album_cvr_img_name update_album_cvr_img_alt_text update_album_cvr_text update_album_name update_album -->