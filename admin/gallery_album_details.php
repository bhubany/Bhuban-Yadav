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
require 'admin_database.php';

$album_details_id="";
$album_details_name="";


// -------------GETTING ALBUM DETAILS FROM PREVIOUS PAGE----------
if (isset($_POST['view_album_details'])) {
	$_SESSION['album_details_id']=$_POST['album_id'];
	$_SESSION['album_details_name']=$_POST['album_name'];
}
if (!isset($_SESSION['album_details_id']) or !isset($_SESSION['album_details_name'])){
	header("Location:gallery_album.php");
}

$album_details_id=$_SESSION['album_details_id'];
$album_details_name=$_SESSION['album_details_name'];



//--------------UPDATING ALBUMS DETAILS TAKING NEW INPUTS----------
if (isset($_POST['update_image'])) {
	$update_image_id=$_POST['update_image_id'];
	$update_album_img_name=$_POST['update_img_name'];
	$update_album_img_alt_text=$_POST['update_img_alt_text'];
	$update_album_img_text=$_POST['update_img_text'];
	// $update_album_name=$_POST['update_album_name'];
	$update_extension = pathinfo($_FILES["update_img"]["name"], PATHINFO_EXTENSION);	
	if (empty($update_album_img_alt_text)) {
		array_push($errors, "Please enter alternative text for image while updating");
	}
	if (empty($update_album_img_text)) {
		array_push($errors, "Please enter image details while updating");
	}

	$edit_image_qry=@"SELECT * FROM gallery_images WHERE id='$update_image_id' AND album_id='$album_details_id'";
	$edit_image_execute=mysqli_query($con_admin,$edit_image_qry) or die($con_admin);
	if (mysqli_num_rows($edit_image_execute)==0) {
		array_push($errors, "There is not any images present on the id = ".$update_image_id." on the database");
	}

	if (count($errors)==0) {
		if (empty($update_extension)) {
		$update_image_qry=@"UPDATE gallery_images SET image_alt_text='$update_album_img_alt_text',image_text='$update_album_img_text' WHERE id='$update_image_id'";
		$update_image_result=mysqli_query($con_admin,$update_image_qry) or die($con_admin);
		if ($update_image_result==1) {
			$Sucess="Your album details has been updated sucessfully presented on id ->".$update_image_id;
		}
		else{
			array_push($errors, "Error Occurs while updating your details");
		}
		}
		else{
			if (empty($update_album_img_name)) {
				array_push($errors, "Please try again entering new image name");
				$album_name_err=1;
			}
			else{
			$update_target="../secure/gallery_images/";
			$update_album_img="Online Entrance-".Date('Y_m_d_h_m_s_ms').$album_details_name."-".$update_album_img_name.".".$update_extension;
			move_uploaded_file($_FILES["update_img"]["tmp_name"], $update_target.$update_album_img);
			$update_image_qry=@"UPDATE gallery_images SET image_name='$update_album_img',image_alt_text='$update_album_img_alt_text',image_text='$update_album_img_text' WHERE id='$update_image_id' LIMIT 1";
		$update_image_result=mysqli_query($con_admin,$update_image_qry) or die($con_admin);
		if ($update_image_result==1) {
			$Sucess="Your album details has been updated sucessfully presented on id ->".$update_image_id;
		}
		else{
			array_push($errors, "Error Occurs while updating your details");
		}
	}
		}
	}
}

// --------------TO ADD IMAGES ON ALBUMS----------------------
if (isset($_POST['add_image'])) {
	$gallery_img_name=$_POST['gallery_img_name'];
	$gallery_img_alt_text=$_POST['gallery_img_alt_text'];
	$gallery_img_text=$_POST['gallery_img_text'];
	// $add_album_name=$_POST['add_album_name'];
	$extension = pathinfo($_FILES["gallery_img"]["name"], PATHINFO_EXTENSION);
	$target="../secure/gallery_images/";
	$gallery_album_img="Online Entrance-".Date('Y_m_d_h_m_s_ms').$album_details_name."-".$gallery_img_name.".".$extension;
	if (empty($gallery_img_alt_text)) {
		array_push($errors, "Please enter alternative text for image");
	}
	if (empty($gallery_img_text)) {
		array_push($errors, "Please enter image details");
	}
	if (empty($gallery_img_name)) {
		array_push($errors, "Please enter name of image to upload in this album");
	}
	if (empty($extension)) {
		array_push($errors, "Please select image to upload.");
	}
	if (count($errors)==0) {
	$add_image_query=@"INSERT INTO gallery_images(album_id,image_name,image_alt_text,image_text,is_active,trn_date)VALUES('$album_details_id','$gallery_album_img','$gallery_img_alt_text','$gallery_img_text',0,$upload_date')";
	// -- $add_album_query=@"INSERT INTO gallery_album(album_name,album_cover_image,album_cover_alt_text,album_cover_text,trn_date)VALUES('$add_album_name','$album_cvr_img','$album_cvr_img_alt_text','$album_cvr_text','$upload_date')";
	$add_image_result=mysqli_query($con_admin,$add_image_query) or die($con_admin);
	if ($add_image_result==1) {
		move_uploaded_file($_FILES["gallery_img"]["tmp_name"], $target.$gallery_album_img);
		$Sucess="Your image has been added sucessfully on gallery -> ".$album_details_name;
			
		}
	else{
		array_push($errors, "Error occurs during adding images");
	}
	}
}


// ---------------DELETE IMAGES-------------------
if (isset($_POST['del_image'])) {
	$del_image_id=$_POST['del_image_id'];
	$del_image_name=$_POST['del_image_name'];

	if (empty($del_image_id)) {
		array_push($errors, "ID is required to delete IMAGES");
	}
	$qry_exists_gallery_image=@"SELECT * FROM gallery_images WHERE id='$del_image_id'AND album_id='$album_details_id'";
	$qry_exists_gallery_image_execute=mysqli_query($con_admin,$qry_exists_gallery_image) or die($con_admin);
	if (mysqli_num_rows($qry_exists_gallery_image_execute)==0) {
		array_push($errors, "There is not any images present on id = ".$del_image_id." . Check ID correctly and try again.");
	}
	if (count($errors)==0) {
		$del_image_query=@"DELETE FROM gallery_images WHERE id='$del_image_id'AND album_id='$album_details_id'";
		$del_image_execute=mysqli_query($con_admin,$del_image_query) or die($con_admin);
		if ($del_image_execute==1) {
			$Sucess="Image -> '".$del_image_name."' has been deleted suscessfully presented on id= ".$del_image_id;
			// header("Refresh:3");
		}
		else{
			array_push($errors, "Error occurs on deleting category of id= ".$del_image_id);
		}
	}
}


// -----------ACTIVATE IMAGE----------
if (isset($_POST['activate_album_img'])) {
	$activate_album_img_id=$_POST['activate_album_img_id'];
	$activate_album_img_name=$_POST['activate_album_img_name'];
	$activate_gallery_img_qry=@"UPDATE gallery_images SET is_active='1' WHERE id='$activate_album_img_id' LIMIT 1";
	$activate_gallery_img_execute=mysqli_query($con_admin,$activate_gallery_img_qry) or die($con_admin);
	if ($activate_gallery_img_execute==1) {
		$Sucess="Image -> '".$activate_album_img_name."' has been activated suscessfully presented on id= ".$activate_album_img_id;
			// header("Refresh:3");
	}
	else{
		array_push($errors, "Error occurs on Activating image present on id= ".$activate_album_img_id);
	}
}


// ------------------DEACTIVATE IMAGE-------------------

if (isset($_POST['deactivate_album_img'])) {
	$deactivate_album_img_id=$_POST['deactivate_album_img_id'];
	$deactivate_album_img_name=$_POST['deactivate_album_img_name'];
	$deactivate_gallery_img_qry=@"UPDATE gallery_images SET is_active='0' WHERE id='$deactivate_album_img_id' LIMIT 1";
	$deactivate_gallery_img_execute=mysqli_query($con_admin,$deactivate_gallery_img_qry) or die($con_admin);
	if ($deactivate_gallery_img_execute==1) {
		$Sucess="Image -> '".$deactivate_album_img_name."' has been deactivated suscessfully presented on id= ".$deactivate_album_img_id;
			// header("Refresh:3");
	}
	else{
		array_push($errors, "Error occurs on Activating image present on id= ".$deactivate_album_img_id);
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

  	$total_pages_sql = "SELECT * FROM gallery_images WHERE album_id='$album_details_id'";
    $result = mysqli_query($con_admin,$total_pages_sql);
    if (mysqli_num_rows($result)>0) {
    	$total_rows = mysqli_num_rows($result);
    	// echo "Total rows => ".$total_rows;
    	$total_pages = ceil($total_rows / $no_of_records_per_page);
    }else{
    	$total_pages=1;
    }

//----------------SELECTING IMAGES PRESENT ON THAT ID-----------------
$qry_album_details=@"SELECT * FROM gallery_images WHERE album_id='$album_details_id' LIMIT $starting_from,$no_of_records_per_page";
$qry_album_details_execute=mysqli_query($con_admin,$qry_album_details) or die($con_admin);


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
.gallery img{
	transition: 1s;
	padding: 15px;
	width: 250px;
}
.gallery img:hover{
	filter: grayscale(100%);
	transform: scale(1.1);
}
</style>

<!-- *******************************STARTING OF MAIN SECTIONS******************* -->
<div class="row">
	<div class="col-lg-1 col-md-1"></div>
	<div class="col-lg-10 col-md-10 col-xs-12 myRowBorder">

		<!-- ------------------------HEADER---------------------- -->
		<div class="mySubRowBorder">
			<u  style="color: #1222B5;"><h2 class="text-center">Images availables on albums -> '<?php echo $album_details_name; ?>'</h2></u>
 			<h4 class="text-center text-info">Database unique ID for this album is -> <?php echo "$album_details_id"; ?>.</h4>
		</div>

			<!-- -------------------------ADD CATEGORY BTN-------------------- -->
		<div class="row">
			<div class="col-lg-4 col-md-4"></div>
			<div class="col-lg-4 col-md-4 col-xs-12 p-2">
				<!-- <button class="btn btn-primary btn-lg btn-block" type="button" data-toggle="collapse" data-target="#collapseCategory" aria-expanded="false" aria-controls="collapseCategory"> -->
					<button type="button" class="btn btn-primary btn-lg btn-block" data-toggle="modal" data-target="#forAddImage">
					ADD IMAGES
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



<!-- --------------SHOWING ALL THE IMAGES PRESENT ON THAT ALBUM----------- -->

<div class="row">
	<div class="col-lg-1 col-md-1"></div>
	<div class="col-lg-10 col-md-10 col-xs-12 myRowBorder">
		<div class="mySubRowBorder">
			<u  style="color: #1222B5;"><h2 class="text-center">IMAGES WITH DETAILS</h2></u>
 			<h4 class="text-center text-info">Please check column Action for update and delete .<br>Activate ->currently deactive , Deactivate ->currently active</h4>
		</div>

		<div class="row">
			<div class="col-lg-12 col-md-12 col-xs-12">
				<table class="table table-striped">
					<thead class="myHeader" style="color: white;">
						<tr>
							<th class="text-center"><strong>ID</strong></th>
							<th class="text-center"><strong>Image<strong></th>
							<th class="text-center"><strong>Alt_Text</strong></th>
							<th class="text-center"><strong>Details</strong></th>
							<th class="text-center"><strong>Status</strong></th>
							<th class="text-center"><strong>Upload_at</strong></th>
							<th class="text-center"><strong>Action</strong></th>
							<th></th>
						</tr>
					</thead>
					<tbody>
						 <?php while ($album_details_rows=mysqli_fetch_assoc($qry_album_details_execute)) { ?>
						<tr align="center">
							<td><?php echo $album_details_rows['id']; ?></td>
							
							<td class="gallery">
      							<a href="../secure/gallery_images/<?php echo $album_details_rows['image_name']; ?>" data-lightbox="mygallery" data-title="<?php echo($album_details_rows['image_alt_text']); ?>">
  									<img src="../secure/gallery_images/<?php echo $album_details_rows['image_name']; ?>" alt="<?php echo($album_details_rows['image_alt_text']); ?>">
  								</a>
  							</td>

							<td><?php echo $album_details_rows['image_alt_text']; ?></td>
  							<td><?php echo $album_details_rows['image_text']; ?></td>

							<td>
									<?php if ($album_details_rows['is_active']==1) {?>
								<form action="" method="post">
                					<input type="hidden" name="deactivate_album_img_id" value="<?php echo $album_details_rows['id']; ?>">
                					<input type="hidden" name="deactivate_album_img_name" value="<?php echo $album_details_rows['image_name']; ?>">
									<button type="submit" class="btn btn-danger" name="deactivate_album_img">Deactivate</button>
								</form>
									<?php }else{ ?>
								<form action="" method="post">
                					<input type="hidden" name="activate_album_img_id" value="<?php echo $album_details_rows['id']; ?>">
                					<input type="hidden" name="activate_album_img_name" value="<?php echo $album_details_rows['image_name']; ?>">
									<button type="submit" class="btn btn-success" name="activate_album_img">Activate</button>
								</form>
									<?php } ?>
									
							</td>

							<td><?php echo $album_details_rows['trn_date']; ?></td>
							<td>
								<button type="button" class="btn btn-primary" data-toggle="modal" data-target="#forUpdateImage" onclick="updateImage('<?php echo $album_details_rows['id']; ?>')">Edit</button>
							</td>

							<td>
								<form method="post">
									<input type="hidden" name="del_image_id" value="<?php echo $album_details_rows['id']; ?>">
									<input type="hidden" name="del_image_name" value="<?php echo $album_details_rows['image_name']; ?>">
									<button type="submit" class="btn btn-danger" name="del_image"  onclick="return confirmDel();">Delete</button>
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
	function updateImage(id) {
		$('#update_image_id').val(id);

		$.post("getDataForModels.php",{
			update_image_id:id
		},function(data,status){
			var image=JSON.parse(data);
			$('#update_img_alt_text').val(image.image_alt_text);
			$('#update_img_text').val(image.image_text);
		}

			);
		$('#forUpdateImage').modal("show");
	}
              // update_img  update_img_name  update_img_alt_text update_img_text update_image update_image_id

</script>


<!-- -----------------FOOTER-------------- -->
<?php include 'footer.php'; ?>


<!-- **********************ENDING OF MAIN SECTIONS************** -->

<!-- ..........for adding New Albums............ -->

<div class="modal fade" id="forAddImage" tabindex="-1" role="dialog" aria-labelledby="forAddImage" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="forAddImage">Adding New Images</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <div class="myForm">
        <!-- <span class="myFormTitle"><h2>Schools/College Login Form</h2></span> -->
            <form method="post" action="" enctype="multipart/form-data">
              <div class="form-group">
                  <label for="text">Select Gallery Image:</label>
                  <input type="file" class="form-control" id="file" name="gallery_img">
              </div>
              <div class="form-group">
                  <label for="text">Image Name:</label>
                  <input type="text" class="form-control" id="text" placeholder="Enter Image name" name="gallery_img_name">
              </div>
              <div class="form-group">
                  <label for="text">Image Alt_text:</label>
                  <input type="text" class="form-control" id="text" placeholder="Enter Image Alt_text" name="gallery_img_alt_text">
              </div>
              <div class="form-group">
                  <label for="text">Image Details:</label>
                  <input type="text" class="form-control" id="text" placeholder="Enter Image Details" name="gallery_img_text">
              </div>
                      <button type="submit" class="btn btn-primary" name="add_image">Add Images</button>
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

<div class="modal fade" id="forUpdateImage" tabindex="-1" role="dialog" aria-labelledby="forUpdateImage" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="forUpdateImage">Updating Images Details</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <div class="myForm">
            <form method="post" action="" enctype="multipart/form-data">
              <div class="form-group">
                  <label for="update_img">Select Gallery Image:</label>
                  <input type="file" class="form-control" id="update_img" name="update_img">
              </div>
              <div class="form-group">
                  <label for="update_img_name">Image Name:</label>
                  <input type="text" class="form-control" id="update_img_name" placeholder="Enter Image name" name="update_img_name">
              </div>
              <div class="form-group">
                  <label for="update_img_alt_text">Image Alt_text:</label>
                  <input type="text" class="form-control" id="update_img_alt_text" placeholder="Enter Image Alt_text" name="update_img_alt_text">
              </div>
              <div class="form-group">
                  <label for="update_img_text">Image Details:</label>
                  <textarea type="text" class="form-control" id="update_img_text" placeholder="Enter Image Details" name="update_img_text"></textarea>
              </div>
              		<input type="hidden" name="update_image_id" id="update_image_id">
                    <button type="submit" class="btn btn-primary" name="update_image">Update Images</button>
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


