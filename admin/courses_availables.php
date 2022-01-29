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
$course_edit_status=0;
$edit_moving_img_id="";
// $album_details_extension="";

// -------------CHECKING EXISTANCE DETAILS WHILE UPDATING-------------
$edit_img_alt_text="";
$edit_image_text="";
$edit_image_name="";

// -----------TO EDIT ALBUMS DETAILS CHECKING EXISTANCE------------------
if (isset($_POST['edit_course'])) {
	$edit_course_id=$_POST['edit_course_id'];

	if (empty($edit_course_id)) {
		array_push($errors, "Course ID is required to edit details");
	}
	if (count($errors)==0) {
		$edit_course_qry=@"SELECT * FROM courses_available WHERE id='$edit_course_id'";
		$edit_course_execute=mysqli_query($con_admin,$edit_course_qry) or die($con_admin);
		if (mysqli_num_rows($edit_course_execute)==0) {
			array_push($errors, "There is not any course present on the id = ".$edit_course_id." on the database");
		}
		else{
			$course_edit_status=1;
			$Sucess="Please enter new details in the form below";
			while ($edit_course_rows=mysqli_fetch_assoc($edit_course_execute)) {
				$edit_course_img_alt_text=$edit_course_rows['img_alt_text'];
				$edit_course_img_details=$edit_course_rows['img_details'];
				$edit_course_img_name=$edit_course_rows['img_name'];
				$_SESSION['edit_course_id']=$edit_course_rows['id'];
				$edit_course_header=$edit_course_rows['course_header'];
				$edit_course_details=$edit_course_rows['course_details'];
				$edit_course_footer=$edit_course_rows['extra_notes'];
			}
		}
	}
}

//--------------UPDATING ALBUMS DETAILS TAKING NEW INPUTS----------
if (isset($_POST['update_course'])) {
	$update_course_id=$_POST['update_course_id'];
	$update_course_img_name=$_POST['update_course_img_name'];
	$update_course_img_alt_text=$_POST['update_course_img_alt_text'];
	$update_course_img_details=$_POST['update_course_img_details'];
	$update_course_header=$_POST['update_course_header'];
	$update_course_details=$_POST['update_course_details'];
	$update_course_footer=$_POST['update_course_footer'];
	$update_extension = pathinfo($_FILES["update_course_img"]["name"], PATHINFO_EXTENSION);	
	if (empty($update_course_img_alt_text)) {
		array_push($errors, "Please enter alternative text for image while updating");
	}
	if (empty($update_course_img_details)) {
		$update_course_img_details="NA";
	}
	if (empty($update_course_header)) {
		array_push($errors, "Please enter Course header/course name while updating");
	}
	if (empty($update_course_details)) {
		array_push($errors, "Please enter course details while updating");
	}
	if (empty($update_course_footer)) {
		array_push($errors, "Please course footer while updating");
	}

	if (count($errors)==0) {
		if (empty($update_extension)) {
		$update_course_qry=@"UPDATE courses_available SET img_alt_text='$update_course_img_alt_text',img_details='$update_course_img_details',course_header='$update_course_header',course_details='$update_course_details',extra_notes='$update_course_footer' WHERE id='$update_course_id'";
		$update_course_result=mysqli_query($con_admin,$update_course_qry) or die($con_admin);
		if ($update_course_result==1) {
			$Sucess="Your course -> '".$update_course_header."' details has been updated sucessfully presented on ID ->".$update_course_id;
		}
		else{
			array_push($errors, "Error Occurs while updating your details");
		}
		}
		else{
			if (empty($update_course_img_name)) {
				array_push($errors, "Please try again entering new image name");
				$album_name_err=1;
			}
			else{
			$update_target="../secure/courses_available/";
			$update_course_img="Online Entrance-".Date('Y_m_d_h_m_s_ms')."-".$course_header.$update_course_img_name.".".$update_extension;
			move_uploaded_file($_FILES["update_course_img"]["tmp_name"], $update_target.$update_course_img);
			$update_course_qry=@"UPDATE courses_available SET img_name='$update_course_img',img_alt_text='$update_course_img_alt_text',img_details='$update_course_img_details',course_header='$update_course_header',course_details='$update_course_details',extra_notes='$update_course_footer' WHERE id='$edit_moving_img_id' LIMIT 1";
		$update_course_result=mysqli_query($con_admin,$update_course_qry) or die($con_admin);
		if ($update_course_result==1) {
			$Sucess="Your course -> '".$update_course_header."' details has been updated sucessfully presentedon ID ->".$update_course_id;
		}
		else{
			array_push($errors, "Error Occurs while updating your details");
		}
	}
		}
	}
}

// --------------TO ADD NEW AVAILABLE COURSE FOR PRACTICE----------------------
if (isset($_POST['add_course'])) {
	$add_course_img_name=$_POST['add_course_img_name'];
	$add_course_img_alt_text=$_POST['add_course_img_alt_text'];
	$add_course_img_details=$_POST['add_course_img_details'];
	$add_course_header=$_POST['add_course_header'];
	$add_course_details=$_POST['add_course_details'];
	$add_course_footer=$_POST['add_course_footer'];
	$extension = pathinfo($_FILES["add_course_img"]["name"], PATHINFO_EXTENSION);
	$target="../secure/courses_available/";
	$add_course_img="Online Entrance-".Date('Y_m_d_h_m_s_ms').$add_course_img_name."-".$add_course_header.$extension;
	move_uploaded_file($_FILES["add_course_img"]["tmp_name"], $target.$add_course_img);
	if (empty($add_course_img_alt_text)) {
		array_push($errors, "Please enter alternative text for image");
	}
	if (empty($add_course_img_details)) {
		array_push($errors, "Please enter image details");
	}
	if (empty($add_course_img_name)) {
		array_push($errors, "Please enter name of image to upload in this album");
	}
	if (empty($extension)) {
		array_push($errors, "Please select image to upload.");
	}
	if (empty($add_course_header)) {
		array_push($errors, "Please enter header for the course");
	}
	if (empty($add_course_details)) {
		array_push($errors, "Please enter course details");
	}
	if (empty($add_course_footer)) {
		array_push($errors, "Please enter footer of the course");
	}
	if (count($errors)==0) {
	$add_course_query=@"INSERT INTO courses_available(course_header,course_details,extra_notes,img_name,img_alt_text,img_details,is_active,trn_date)
	VALUES('$add_course_header','$add_course_details','$add_course_footer','$add_course_img','$add_course_img_alt_text','$add_course_img_details','1','$upload_date')";
	$add_course_query_result=mysqli_query($con_admin,$add_course_query) or die($con_admin);
	if ($add_course_query_result==1) {
		// header("Refresh:3");
			$Sucess="Your course ->'".$add_course_header."' has been uploaded sucessfully";
			
		}
	else{
		array_push($errors, "Error occurs during adding course");
	}
	}
}


// ---------------DELETE IMAGES-------------------
if (isset($_POST['del_course'])) {
	$del_course_id=$_POST['del_course_id'];
	$del_course_name=$_POST['del_course_name'];
	// echo $del_album_id;
	if (empty($del_course_id)) {
		array_push($errors, "ID is required to delete COURSE");
	}
	$qry_exists_course=@"SELECT * FROM courses_available WHERE id='$del_course_id'";
	$qry_exists_course_execute=mysqli_query($con_admin,$qry_exists_course) or die($con_admin);
	if (mysqli_num_rows($qry_exists_course_execute)==0) {
		array_push($errors, "There is not any course present on id = ".$del_course_id." . Check ID correctly and try again.");
	}
	if (count($errors)==0) {
		$del_course_query=@"DELETE FROM courses_available WHERE id='$del_course_id'";
		$del_course_execute=mysqli_query($con_admin,$del_course_query) or die($con_admin);
		if ($del_course_execute==1) {
			$Sucess="Course -> '".$del_course_name."' has been deleted suscessfully presented on id= ".$del_course_id;
			header("Refresh:3");
		}
		else{
			array_push($errors, "Error occurs on deleting category of id= ".$del_course_id);
		}
	}
}


// -----------ACTIVATE COURSE----------
if (isset($_POST['activate_course'])) {
	$activate_course_id=$_POST['activate_course_id'];
	$activate_course_name=$_POST['activate_course_name'];
	$activate_course_qry=@"UPDATE courses_available SET is_active='1' WHERE id='$activate_course_id' LIMIT 1";
	$activate_course_execute=mysqli_query($con_admin,$activate_course_qry) or die($con_admin);
	if ($activate_course_execute==1) {
		$Sucess="Course -> '".$activate_course_name."' has been activated suscessfully presented on id= ".$activate_course_id;
			// header("Refresh:3");
	}
	else{
		array_push($errors, "Error occurs on Activating course present on id= ".$activate_course_id);
	}
}


// ------------------DEACTIVATE IMAGE-------------------

if (isset($_POST['deactivate_course'])) {
	$deactivate_course_id=$_POST['deactivate_course_id'];
	$deactivate_course_name=$_POST['deactivate_course_name'];
	$deactivate_course_qry=@"UPDATE courses_available SET is_active='0' WHERE id='$deactivate_course_id' LIMIT 1";
	$deactivate_course_execute=mysqli_query($con_admin,$deactivate_course_qry) or die($con_admin);
	if ($deactivate_course_execute==1) {
		$Sucess="Course ->'".$deactivate_course_name."' has been deactivated suscessfully presented on id= ".$deactivate_course_id;
			// header("Refresh:3");
	}
	else{
		array_push($errors, "Error occurs on Activating Course present on id= ".$deactivate_img_id);
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

  	$total_pages_sql = "SELECT * FROM courses_available";
    $result = mysqli_query($con_admin,$total_pages_sql);
    if (mysqli_num_rows($result)>0) {
    	$total_rows = mysqli_num_rows($result);
    	// echo "Total rows => ".$total_rows;
    	$total_pages = ceil($total_rows / $no_of_records_per_page);
    }else{
    	$total_pages=1;
    }


//----------------SELECTING IMAGES PRESENT ON THAT ID-----------------
$qry_course_available=@"SELECT * FROM courses_available";
$qry_course_available_execute=mysqli_query($con_admin,$qry_course_available) or die($con_admin);

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
		.gallery{
		margin: 10px 50px;
	}
	.gallery img{
		transition: 1s;
		padding: 15px;
		width: 250px;
		height: 150px;
	}
	.gallery img:hover{
		filter: grayscale(100%);
		transform: scale(1.1);
	}
</style>

<!-- *********************STARTING OF MAIN SECTIONS********************* -->
<div class="row">
	<div class="col-lg-1 col-md-1"></div>
	<div class="col-lg-10 col-md-10 col-xs-12 myRowBorder">

		<!-- ------------------------HEADER---------------------- -->
		<div class="mySubRowBorder">
			<u  style="color: #1222B5;"><h2 class="text-center">COURSES AVAILABLES FOR PRACTICING</h2></u>
 			<!-- <h4 class="text-center text-info">Please read the following informations carefully before starting the exams.</h4> -->
		</div>

			<!-- -------------------------ADD CATEGORY BTN-------------------- -->
		<div class="row">
			<div class="col-lg-4 col-md-4"></div>
			<div class="col-lg-4 col-md-4 col-xs-12 p-2">
					<button type="button" class="btn btn-primary btn-lg btn-block" data-toggle="modal" data-target="#forAddCourse">
					ADD COURSE
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
			<u  style="color: #1222B5;"><h2 class="text-center">AVAILABLE COURSES WITH DETAILS</h2></u>
 			<h4 class="text-center text-info">Please check column Action for update and delete .</h4>
		</div>

		<div class="row">
			<div class="col-lg-12 col-md-12 col-xs-12">
				<table class="table table-striped">
					<thead class="myHeader" style="color: white;">
						<tr>
							<th class="text-center"><strong>ID</strong></th>
							<th class="text-center"><strong>Header<strong></th>
							<th class="text-center"><strong>Image</strong></th>
							<th class="text-center"><strong>Status</strong></th>
							<th class="text-center"><strong>Upload_at</strong></th>
							<th></th>
							<th class="text-center"><strong>Action</strong></th>
							<th></th>
						</tr>
					</thead>
					<tbody>
						 <?php while ($course_available_rows=mysqli_fetch_assoc($qry_course_available_execute)) { ?>
						<tr align="center">
							<td><?php echo $course_available_rows['id']; ?></td>
							<td><?php echo $course_available_rows['course_header']; ?></td>
							<td class="gallery">
						      <a href="../secure/courses_available/<?php echo $course_available_rows['img_name']; ?>" data-lightbox="mygallery" data-title="<?php echo($course_available_rows['img_details']); ?>">
								  <img src="../secure/courses_available/<?php echo $course_available_rows['img_name']; ?>" alt="<?php echo($course_available_rows['img_alt_text']); ?>"></a>
							</td>

							<td>
									<?php if($course_available_rows['is_active']==1){ ?>
								<form method="post">
							      <input type="hidden" name="deactivate_course_id" value="<?php echo($course_available_rows['id']); ?>">
							      <input type="hidden" name="deactivate_course_name" value="<?php echo($course_available_rows['course_header']); ?>">
							      <button type="submit" class="btn btn-danger" name="deactivate_course">Deactivate</button>
							    </form>	
							    	<?php }else{ ?>
							    <form method="post">
							      <input type="hidden" name="activate_course_id" value="<?php echo($course_available_rows['id']); ?>">
							      <input type="hidden" name="activate_course_name" value="<?php echo($course_available_rows['course_header']); ?>">
							      <button type="submit" class="btn btn-success" name="activate_course">Activate</button>
							    </form>
							    	<?php } ?>
								</td>

							<td><?php echo $course_available_rows['trn_date']; ?></td>
							<td>
								<button type="button" class="btn btn-primary" data-toggle="modal" data-target="#forUpdateCourse" onclick="updateCourses('<?php echo $course_available_rows['id']; ?>')">Edit</button>
							</td>

							<td>
								<button type="button" class="btn btn-info" data-toggle="modal" data-target="#forViewCourse" onclick="viewCourse('<?php echo $course_available_rows['id']; ?>')">View</button>
							</td>

							<td>
								<form method="post">
									<input type="hidden" name="del_course_id" value="<?php echo $course_available_rows['id']; ?>">
									<input type="hidden" name="del_course_name" value="<?php echo $course_available_rows['course_header']; ?>">
									<button type="submit" class="btn btn-warning" name="del_course"  onclick="return confirmDel();">Delete</button>
								</form>
							</td>
						</tr>
						<?php }  ?>
					</tbody>
				</table>
						<!-- -----------Pagination--------- -->
				<div class="pager text-center">
			        <a href="?pageno=1" class="btn btn-default myPagerBtn">First</a>
			        <a class="btn btn-default myPagerBtn <?php if($pageno <= 1){ echo 'disabled'; } ?>" href="<?php if($pageno <= 1){ echo '#'; } else { echo "?pageno=".($pageno - 1); } ?>">Prev</a>
			        <a class="btn btn-default myPagerBtn <?php if($pageno >= $total_pages){ echo 'disabled'; } ?>" href="<?php if($pageno > $total_pages){ echo '#'; } else { echo "?pageno=".($pageno + 1); } ?>">Next</a>
			        <a class="btn btn-default myPagerBtn" href="?pageno=<?php echo $total_pages; ?>">Last</a>
			    </div>
			</div>
		</div>
	</div>
	<div class="col-lg-1 col-md-1"></div>
</div>

<!-- ------------------------------AJAX CODES-------------------- -->

<script type="text/javascript">

				// <!-- ------EDITING/UPDATING DETAILS----------- -->
	function updateCourses(id) {
		$('#update_course_id').val(id);
		var f=id;
		$.post("getDataForModels.php",{
			update_course_id:id
		},function(data,status){
			var course=JSON.parse(data);
			$('#update_course_img_alt_text').val(course.img_alt_text);
			$('#update_course_img_details').val(course.img_details);
			$('#update_course_header').val(course.course_header);
			$('#update_course_details').val(course.course_details);
			$('#update_course_footer').val(course.extra_notes);
		}
			);
		$('#forUpdateCourse').modal("show");
	}


	// ----------VIEWING DETAILS-----------------

	function viewCourse(course_id){
			// $('#view_faq_id').val(id);

		$.post("getDataForModels.php",{
			view_course_id:course_id
		},function(data,status){
			var course=JSON.parse(data);
			$('#view_course_img_alt_text').html(course.img_alt_text);
			$('#view_course_img_details').html(course.img_details);
			$('#view_course_header').html(course.course_header);
			$('#view_course_details').html(course.course_details);
			$('#view_course_footer').html(course.extra_notes);
		}

			);
		$('#forViewFaq').modal("show");
	}
</script>


<!-- ----------------FOOTER-------------- -->
<?php include 'footer.php'; ?>

<!-- ***************************ENDING OF MAIN SECTIONS*********************** -->

<!-- ..........for adding category............ -->

<div class="modal fade" id="forAddCourse" tabindex="-1" role="dialog" aria-labelledby="forAddCourse" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="forAddCourse">Add New Course Available for Practice</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <div class="myForm">
            <form method="post" action="" enctype="multipart/form-data">
              <div class="form-group">
                  <label for="text">Select Image:</label>
                  <input type="file" class="form-control" id="file" name="add_course_img">
              </div>

              <div class="form-group">
                  <label for="text">Image Name:</label>
                  <input type="text" class="form-control" id="text" placeholder="Enter Image Name" name="add_course_img_name">
              </div>

              <div class="form-group">
                  <label for="text">Image Alt_Text:</label>
                  <input type="text" class="form-control" id="text" placeholder="Enter Image Alt_Text" name="add_course_img_alt_text">
              </div>

              <div class="form-group">
                  <label for="text">Image Details:</label>
                  <input type="text" class="form-control" id="text" placeholder="Enter Image Details" name="add_course_img_details">
              </div>

              <div class="form-group">
                  <label for="text">Course Header:</label>
                  <input type="text" class="form-control" id="text" placeholder="Enter Course Header" name="add_course_header">
              </div>

              <div class="form-group">
                  <label for="text">Course Details:</label>
                  <textarea type="text" class="form-control" id="text" placeholder="Enter Course Details" name="add_course_details"></textarea>
              </div>

              <div class="form-group">
                  <label for="text">Course Footer:</label>
                  <textarea type="text" class="form-control" id="text" placeholder="Enter Course Footer" name="add_course_footer"></textarea>
              </div>
                    <button type="submit" class="btn btn-primary" name="add_course">Add Course</button>
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

<div class="modal fade" id="forUpdateCourse" tabindex="-1" role="dialog" aria-labelledby="forUpdateCourse" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="forUpdateCourse">Update Courses Available for Practice</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <div class="myForm">
            <form method="post" action="" enctype="multipart/form-data">
              <div class="form-group">
                  <label for="update_course_img">Select Image:</label>
                  <input type="file" class="form-control" id="update_course_img" name="update_course_img">
              </div>

              <div class="form-group">
                  <label for="update_course_img_name">Image Name:</label>
                  <input type="text" class="form-control" id="update_course_img_name" placeholder="Enter Image Name" name="update_course_img_name">
              </div>

              <div class="form-group">
                  <label for="update_course_img_alt_text">Image Alt_Text:</label>
                  <input type="text" class="form-control" id="update_course_img_alt_text" placeholder="Enter Image Alt_Text" name="update_course_img_alt_text">
              </div>

              <div class="form-group">
                  <label for="update_course_img_details">Image Details:</label>
                  <textarea type="text" class="form-control" id="update_course_img_details" placeholder="Enter Image Details" name="update_course_img_details"></textarea>
              </div>

              <div class="form-group">
                  <label for="update_course_header">Course Header:</label>
                  <input type="text" class="form-control" id="update_course_header" placeholder="Enter Course Header" name="update_course_header">
              </div>

              <div class="form-group">
                  <label for="update_course_details">Course Details:</label>
                  <textarea type="text" class="form-control" id="update_course_details" placeholder="Enter Course Details" name="update_course_details"></textarea>
              </div>

              <div class="form-group">
                  <label for="update_course_footer">Course Footer:</label>
                  <textarea type="text" class="form-control" id="update_course_footer" placeholder="Enter Course Footer" name="update_course_footer"></textarea>
              </div>
              		<input type="hidden" name="update_course_id" id="update_course_id">
                    <button type="submit" class="btn btn-primary" name="update_course">Update Course</button>
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

<!-- -----------------vIEWING DETAILS---------------- -->
<div class="modal fade" id="forViewCourse" tabindex="-1" role="dialog" aria-labelledby="forViewCourse" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="forViewCourse">Viewing Available Courses With Details</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <div class="myRowBorder" style="padding-left: 10px;">
        	<p class="text-muted font-weight-bold">Image Alt_ Text: <span class="text-info text-italic" id="view_course_img_alt_text">alt text</span></p><hr>
        	<p class="text-muted text-justify"><span class="font-weight-bold">Image Details: </span> <span class="text-info text-italic" id="view_course_img_details">Img Details</span></p><hr>
        	<h5 class="text-muted font-weight-bold text-center" id="view_course_header"><u>Header:</u></h5><br>
        	<p id="view_course_details" class="text-info font-italic text-justify"> Question will be shown here</p><br>
        	<!-- <h5 class="text-muted">Answer:</h5> -->
        	<p id="view_course_footer" class="text-info font-italic text-justify">Answer will be shown here</p>
        </div><br>
        <button class="btn btn-primary">Print</button>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
      </div>
    </div>
  </div>
</div>

<!-- // update_course_img update_course_img_name update_course_img_alt_text update_course_img_details update_course_header update_course_details update_course_footer update_course
	
// id course_header course_details extra_notes img_name img_alt_text img_details is_active trn_date -->