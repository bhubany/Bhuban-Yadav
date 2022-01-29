<?php 
require 'acess.php';
date_default_timezone_set("Asia/Kathmandu");
$upload_date=Date('Y-m-d h:m:s:ms');
$errors=array();
$Sucess="";
require 'admin_database.php';

$album_details_id="";
$album_details_name="";



//--------------UPDATING Notice DETAILS TAKING NEW INPUTS----------
if (isset($_POST['update_notice'])) {
	$update_notice_id=$_POST['update_notice_id'];
	$update_notice_name=$_POST['update_notice_name'];
	$update_notice_title=$_POST['update_notice_title'];
	
	// if (isset($_FILES['update_notice_file'])) {
	$update_extension = pathinfo($_FILES["update_file"]["name"], PATHINFO_EXTENSION);		
	// }
	if (empty($update_notice_title)) {
		array_push($errors, "Please enter title for notice.");
	}

	$edit_notice_qry=@"SELECT * FROM notice WHERE id='$update_notice_id'";
	$edit_notice_execute=mysqli_query($con_admin,$edit_notice_qry) or die($con_admin);
	if (mysqli_num_rows($edit_notice_execute)==0) {
		array_push($errors, "There is not any notice present on the id = ".$update_notice_id." on the database");
	}

	if (count($errors)==0) {
		if (empty($update_extension)) {
		$update_notice_qry=@"UPDATE notice SET notice_title='$update_notice_title' WHERE id='$update_notice_id'";
		$update_notice_result=mysqli_query($con_admin,$update_notice_qry) or die($con_admin);
		if ($update_notice_result==1) {
			// header("Refresh:3");
			$Sucess="Your notice details has been updated sucessfully presented on ID -> ".$update_notice_id;
		}
		else{
			array_push($errors, "Error Occurs while updating your details");
		}
		}
		else{
			if (empty($update_notice_name)) {
				array_push($errors, "Please try again entering new notice name");
				$album_name_err=1;
			}
			else{
			$update_target="../secure/notice/";
			$update_notice_file="Online Entrance-".Date('Y_m_d_h_m_s_ms')."-notice".$update_notice_name.".".$update_extension;
			move_uploaded_file($_FILES["update_file"]["tmp_name"], $update_target.$update_notice_file);
			$update_notice_qry=@"UPDATE notice SET file_name='$update_notice_file',notice_title='$update_notice_title' WHERE id='$update_notice_id' LIMIT 1";
		$update_notice_result=mysqli_query($con_admin,$update_notice_qry) or die($con_admin);
		if ($update_notice_result==1) {
			// header("Refresh:3");
			$Sucess="Your notice details has been updated sucessfully presented on ID -> ".$update_notice_id;
		}
		else{
			array_push($errors, "Error Occurs while updating your details");
		}
	}
		}
	}
}

// --------------TO ADD NOTICE----------------------
if (isset($_POST['add_notice'])) {
	$add_notice_name=$_POST['add_notice_name'];
	$add_notice_title=$_POST['add_notice_title'];
	$extension = pathinfo($_FILES["add_notice_file"]["name"], PATHINFO_EXTENSION);
	$target="../secure/notice/";
	$add_notice="Online Entrance-".Date('Y_m_d_h_m_s_ms').$add_notice_name."-Notice.".$extension;
	move_uploaded_file($_FILES["add_notice_file"]["tmp_name"], $target.$add_notice);

	if (empty($add_notice_name)) {
		array_push($errors, "Please enter notice name");
	}
	if (empty($add_notice_title)) {
		array_push($errors, "Please enter title for this notice");
	}
	if (empty($extension)) {
		array_push($errors, "Please select file to upload.");
	}

	if (count($errors)==0) {
	$add_notice_query=@"INSERT INTO notice(notice_title,file_name,is_active,trn_date)
	VALUES('$add_notice_title','$add_notice','1','$upload_date')";
	$add_notice_result=mysqli_query($con_admin,$add_notice_query) or die($con_admin);
	if ($add_notice_result==1) {
		// header("Refresh:3");
			$Sucess="Your notice -> '".$add_notice_title."' has been uploaded sucessfully";
			
		}
	else{
		array_push($errors, "Error occurs during adding notice");
	}
	}
}


// ---------------DELETE NOTICE-------------------
if (isset($_POST['del_notice'])) {
	$del_notice_id=$_POST['del_notice_id'];
	$del_notice_name=$_POST['del_notice_name'];
	if (empty($del_notice_id)) {
		array_push($errors, "ID is required to delete NOTICE");
	}
	$qry_exists_notice=@"SELECT * FROM notice WHERE id='$del_notice_id'";
	$qry_exists_notice_execute=mysqli_query($con_admin,$qry_exists_notice) or die($con_admin);
	if (mysqli_num_rows($qry_exists_notice_execute)==0) {
		array_push($errors, "There is not any images present on id = ".$del_notice_id." . Check ID correctly and try again.");
	}
	if (count($errors)==0) {
		$del_notice_query=@"DELETE FROM notice WHERE id='$del_notice_id'";
		$del_notice_execute=mysqli_query($con_admin,$del_notice_query) or die($con_admin);
		if ($del_notice_execute==1) {
			$Sucess="Notice -> '".$del_notice_name."' has been deleted suscessfully presented on id= ".$del_notice_id;
		}
		else{
			array_push($errors, "Error occurs on deleting category of id= ".$del_notice_id);
		}
	}
}


// -----------ACTIVATE NOTICE----------
if (isset($_POST['activate_notice'])) {
	$activate_notice_id=$_POST['activate_notice_id'];
	$activate_notice_name=$_POST['activate_notice_name'];
	$activate_notice_qry=@"UPDATE notice SET is_active='1' WHERE id='$activate_notice_id' LIMIT 1";
	$activate_notice_execute=mysqli_query($con_admin,$activate_notice_qry) or die($con_admin);
	if ($activate_notice_execute==1) {
		$Sucess="Notice -> '".$activate_notice_name."' has been activated suscessfully presented on id= ".$activate_notice_id;
	}
	else{
		array_push($errors, "Error occurs on Activating image present on id= ".$activate_notice_id);
	}
}


// ------------------DEACTIVATE NOTICE-------------------

if (isset($_POST['deactivate_notice'])) {
	$deactivate_notice_id=$_POST['deactivate_notice_id'];
	$deactivate_notice_name=$_POST['deactivate_notice_name'];
	$deactivate_notice_qry=@"UPDATE notice SET is_active='0' WHERE id='$deactivate_notice_id' LIMIT 1";
	$deactivate_notice_execute=mysqli_query($con_admin,$deactivate_notice_qry) or die($con_admin);
	if ($deactivate_notice_execute==1) {
		$Sucess="Notice -> '".$deactivate_notice_name."' has been deactivated suscessfully presented on id= ".$deactivate_notice_id;
	}
	else{
		array_push($errors, "Error occurs on Activating image present on id= ".$deactivate_notice_id);
	}
}

// -----------For Pagination (Notice)----------
	 if (isset($_GET['pageno_n'])) {
     	$pageno_n = $_GET['pageno_n'];
   	} else {
      	$pageno_n = 1;
    }

  	$no_of_records_per_page_n = 10;
  	$starting_from_n = ($pageno_n-1) * $no_of_records_per_page_n;

  	$total_pages_sql_n = "SELECT * FROM notice ";
    $result_n = mysqli_query($con_admin,$total_pages_sql_n);
    if (mysqli_num_rows($result_n)>0) {
    	$total_rows_n = mysqli_num_rows($result_n);
    	// echo "Total rows => ".$total_rows;
    	$total_pages_n = ceil($total_rows_n / $no_of_records_per_page_n);
    }else{
    	$total_pages_n=1;
    }

//----------------SELECTING IMAGES PRESENT ON THAT ID-----------------
$qry_notice=@"SELECT * FROM notice LIMIT $starting_from_n,$no_of_records_per_page_n";
$qry_notice_execute=mysqli_query($con_admin,$qry_notice) or die($con_admin);

?>



<!-- ******************FOR MOVING NOTICE OR RECENT EVENTS******************* -->


<?php 

//--------------UPDATING Event DETAILS TAKING NEW INPUTS----------
if (isset($_POST['update_event'])) {
	$update_event_id=$_POST['update_event_id'];
	$update_event_details=$_POST['update_event_details'];
	// $update_faq_answer=$_POST['update_faq_answer'];

	if (empty($update_event_details)) {
		array_push($errors, "Please enter recent_event details.");
	}

	$edit_recent_event_qry=@"SELECT * FROM recent_event WHERE id='$update_event_id'";
	$edit_recent_event_execute=mysqli_query($con_admin,$edit_recent_event_qry) or die($con_admin);
	if (mysqli_num_rows($edit_recent_event_execute)==0) {
			array_push($errors, "There is not any recent_event present on the id = ".$update_event_id." on the database");
	}

	if (count($errors)==0) {
		$update_recent_event_qry=@"UPDATE recent_event SET event_details='$update_event_details' WHERE id='$update_event_id'";
		$update_recent_event_result=mysqli_query($con_admin,$update_recent_event_qry) or die($con_admin);
		if ($update_recent_event_result==1) {
			$Sucess="Your recent_event details has been updated sucessfully presented on ID ->".$update_event_id;
		}
		else{
			array_push($errors, "Error Occurs while updating your details");
		}
		
	}
}

// --------------TO ADD recent_event----------------------
if (isset($_POST['add_recent_event'])) {
	$add_event_details=$_POST['add_event_details'];

	if (empty($add_event_details)) {
		array_push($errors, "Please enter Event with details");
	}

	if (count($errors)==0) {
	$add_recent_event_query=@"INSERT INTO recent_event(event_details,is_active,trn_date)
	VALUES('$add_event_details','1','$upload_date')";
	$add_recent_event_result=mysqli_query($con_admin,$add_recent_event_query) or die($con_admin);
	if ($add_recent_event_result==1) {
		// header("Refresh:3");
			$Sucess="Your recent_event has been uploaded sucessfully.";
			
		}
	else{
		array_push($errors, "Error occurs during adding recent_event");
	}
	}
}


// ---------------DELETE Event-------------------
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
			// header("Refresh:3");
		}
		else{
			array_push($errors, "Error occurs on deleting recent_event of id= ".$del_recent_event_id);
		}
	}
}


// -----------ACTIVATE Event----------
if (isset($_POST['activate_recent_event'])) {
	$activate_recent_event_id=$_POST['activate_recent_event_id'];
	$activate_recent_event_qry=@"UPDATE recent_event SET is_active='1' WHERE id='$activate_recent_event_id' LIMIT 1";
	$activate_recent_event_execute=mysqli_query($con_admin,$activate_recent_event_qry) or die($con_admin);
	if ($activate_recent_event_execute==1) {
		$Sucess="recent_event has been activated suscessfully presented on id= ".$activate_recent_event_id;
	}
	else{
		array_push($errors, "Error occurs on Activating recent_event present on id= ".$activate_recent_event_id);
	}
}


// ------------------DEACTIVATE Event-------------------

if (isset($_POST['deactivate_recent_event'])) {
	$deactivate_recent_event_id=$_POST['deactivate_recent_event_id'];
	$deactivate_recent_event_qry=@"UPDATE recent_event SET is_active='0' WHERE id='$deactivate_recent_event_id' LIMIT 1";
	$deactivate_recent_event_execute=mysqli_query($con_admin,$deactivate_recent_event_qry) or die($con_admin);
	if ($deactivate_recent_event_execute==1) {
		$Sucess="recent_event has been deactivated suscessfully presented on id= ".$deactivate_recent_event_id;
	}
	else{
		array_push($errors, "Error occurs on deactivating recent event present on id= ".$deactivate_recent_event_id);
	}
}


	// -----------For Pagination (Notice)----------
	 if (isset($_GET['pageno_p'])) {
     	$pageno_p = $_GET['pageno_p'];
   	} else {
      	$pageno_p = 1;
    }

  	$no_of_records_per_page_p = 10;
  	$starting_from_p = ($pageno_p-1) * $no_of_records_per_page_p;

  	$total_pages_sql_p = "SELECT * FROM recent_event ";
    $result_p = mysqli_query($con_admin,$total_pages_sql_p);
    if (mysqli_num_rows($result_p)>0) {
    	$total_rows_p = mysqli_num_rows($result_p);
    	// echo "Total rows => ".$total_rows;
    	$total_pages_p = ceil($total_rows_p / $no_of_records_per_page_p);
    }else{
    	$total_pages_p=1;
    }

//----------------SELECTING Event PRESENT ON THAT ID-----------------
$qry_recent_event=@"SELECT * FROM recent_event LIMIT $starting_from_p,$no_of_records_per_page_p";
$qry_recent_event_execute=mysqli_query($con_admin,$qry_recent_event) or die($con_admin);



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

<!-- ************************STARTING OF MAIN SECTIONS**************** -->
<div class="row">
	<div class="col-lg-1 col-md-1"></div>
	<div class="col-lg-10 col-md-10 col-xs-12 myRowBorder">

		<!-- ------------------------HEADER---------------------- -->
		<div class="mySubRowBorder">
			<u  style="color: #1222B5;"><h2 class="text-center">All notice present on the database</h2></u>
 			<!-- <h4 class="text-center text-warning">Moving images album is compulsory do not change or edit it..</h4> -->
		</div>

			<!-- -------------------------ADD CATEGORY BTN-------------------- -->
		<div class="row">
			<div class="col-lg-4 col-md-4"></div>
			<div class="col-lg-4 col-md-4 col-xs-12 p-2">
					<button type="button" class="btn btn-primary btn-lg btn-block" data-toggle="modal" data-target="#forAddNotice">
					UPLOAD NOTICE
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


<!-- --------------SHOWING ALL THE Notice PRESENT ON THE Database----------- -->
<div class="row">
	<div class="col-lg-1 col-md-1"></div>
	<div class="col-lg-10 col-md-10 col-xs-12 myRowBorder">
		<!-- <div class="mySubRowBorder">
			<u  style="color: #1222B5;"><h2 class="text-center">CATEGORIES WITH DETAILS</h2></u>
 			<h4 class="text-center text-info">Please check column Action for update and delete .</h4>
		</div> -->

		<div class="row">
			<div class="col-lg-12 col-md-12 col-xs-12">
				<table class="table table-striped">
					<thead class="myHeader" style="color: white;">
						<tr>
							<th class="text-center"><strong>ID</strong></th>
							<th class="text-center"><strong>Title<strong></th>
							<th class="text-center"><strong>File</strong></th>
							<th class="text-center"><strong>Status</strong></th>
							<th class="text-center"><strong>Uploaded_at</strong></th>
							<th class="text-center"><strong>Actions</strong></th>
							<th></th>
						</tr>
					</thead>
					<tbody>
						<?php while ($notice_rows=mysqli_fetch_assoc($qry_notice_execute)) { ?>
						<tr align="center">
							<td><?php echo $notice_rows['id']; ?></td>
							<td><?php echo $notice_rows['notice_title']; ?></td>
							<td>
								<a download="" href="../secure/notice/<?php echo($notice_rows['file_name']);?>"><?php echo $notice_rows['file_name']; ?>
									
								</a>
							</td>

						    <td>
						    		<?php if($notice_rows['is_active']){ ?>
						    	<form method="post">
				                    <input type="hidden" name="deactivate_notice_id" value="<?php echo($notice_rows['id']); ?>">
				                    <input type="hidden" name="deactivate_notice_name" value="<?php echo($notice_rows['notice_title']); ?>">
				                    <button type="submit" class="btn btn-danger" name="deactivate_notice">Deactivate</button>
				                </form> 
				                	<?php }else{ ?>
			                   <form method="post">
			                    	<input type="hidden" name="activate_notice_id" value="<?php echo($notice_rows['id']); ?>">
			                    	<input type="hidden" name="activate_notice_name" value="<?php echo($notice_rows['notice_title']); ?>">
			                    	<button type="submit" class="btn btn-success" name="activate_notice">Activate</button>
			                  </form>
			                    	<?php } ?>
						    </td>
							<td><?php echo $notice_rows['trn_date']; ?></td>
							<td>
								<button type="button" class="btn btn-primary" data-toggle="modal" data-target="#forUpdateNotice" onclick="updateNotice('<?php echo($notice_rows['id']); ?>')">Edit</button>
							</td>

							<td>
								<form method="post">
									<input type="hidden" name="del_notice_id" value="<?php echo $notice_rows['id']; ?>">
									<input type="hidden" name="del_notice_name" value="<?php echo $notice_rows['notice_title']; ?>">
									<button type="submit" class="btn btn-danger" name="del_notice"  onclick="return confirmDel();">Delete</button>
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
		        <a href="?pageno_n=1" class="btn btn-default myPagerBtn">First</a>
		        <a class="btn btn-default myPagerBtn <?php if($pageno_n <= 1){ echo 'disabled'; } ?>" href="<?php if($pageno_n <= 1){ echo '#'; } else { echo "?pageno_n=".($pageno_n - 1); } ?>">Prev</a>
		        <a class="btn btn-default myPagerBtn <?php if($pageno_n >= $total_pages_n){ echo 'disabled'; } ?>" href="<?php if($pageno_n > $total_pages_n){ echo '#'; } else { echo "?pageno_n=".($pageno_n + 1); } ?>">Next</a>
		        <a class="btn btn-default myPagerBtn" href="?pageno_n=<?php echo $total_pages_n; ?>">Last</a>
		    </div>
		</div>
		<div class="col-lg-4 col-md-4"></div>
	</div>
	</div>
	<div class="col-lg-1 col-md-1"></div>
</div>




<!-- ******************FOR MOVING NOTICE OR RECENT EVENTS******************* -->






<div class="row">
	<div class="col-lg-1 col-md-1"></div>
	<div class="col-lg-10 col-md-10 col-xs-12 myRowBorder">

		<!-- ------------------------HEADER---------------------- -->
		<div class="mySubRowBorder">
			<u  style="color: #1222B5;"><h2 class="text-center">MOVING NOTICE/RECENT EVENTS</h2></u>
 			<!-- <h4 class="text-center text-warning">Moving images album is compulsory do not change or edit it..</h4> -->
		</div>

			<!-- -------------------------ADD CATEGORY BTN-------------------- -->
		<div class="row">
			<div class="col-lg-4 col-md-4"></div>
			<div class="col-lg-4 col-md-4 col-xs-12 p-2">
					<button type="button" class="btn btn-primary btn-lg btn-block" data-toggle="modal" data-target="#forAddEvent">
					UPLOAD EVENTS
				</button>
			</div>
			<div class="col-lg-4 col-md-4"></div>
		</div>
	</div>
	<div class="col-lg-1 col-md-1"></div>
</div>




<!-- -----------------SHOWING ALL DETAILS-------------- -->
<div class="row">
  <div class="col-lg-1 col-md-1"></div>
  <div class="col-lg-10 col-md-10 col-xs-12 myRowBorder">
   <!--  <div class="mySubRowBorder">
      <u  style="color: #1222B5;"><h2 class="text-center">FAQ WITH DETAILS</h2></u>
      <h4 class="text-center text-info">Please check column Action for update and delete .</h4>
    </div> -->

    <div class="row">
      <div class="col-lg-12 col-md-12 col-xs-12">
        <table class="table table-striped">
          <thead class="myHeader" style="color: white;">
            <tr>
              <th class="text-center"><strong>ID</strong></th>
              <th class="text-center"><strong>Events<strong></th>
              <th class="text-center"><strong>Status</strong></th>
              <th class="text-center"><strong>Upload_at</strong></th>
              <th class="text-center"><strong>Action</strong></th>
              <th></th>
            </tr>
          </thead>
          <tbody>
               <?php while ($recent_event_rows=mysqli_fetch_assoc($qry_recent_event_execute)) { ?>
            <tr align="center">
              <td><?php echo $recent_event_rows['id']; ?></td>
              <td><?php echo $recent_event_rows['event_details']; ?></td>

              <td>
                  <?php if($recent_event_rows['is_active']==1){ ?>
                <form method="post">
                    <input type="hidden" name="deactivate_recent_event_id" value="<?php echo $recent_event_rows['id']; ?>">
                    <button type="submit" class="btn btn-danger" name="deactivate_recent_event">Deactivate</button>
                  </form> 
                    <?php }else{ ?>
                  <form method="post">
                    <input type="hidden" name="activate_recent_event_id" value="<?php echo $recent_event_rows['id']; ?>">
                    <button type="submit" class="btn btn-success" name="activate_recent_event">Activate</button>
                  </form>
                    <?php } ?>
                </td>

              <td><?php echo $recent_event_rows['trn_date']; ?></td>
              <td>
                <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#forUpdateEvent" onclick="updateEvents('<?php echo $recent_event_rows['id']; ?>')">Edit</button>
              </td>

              <td>
                <form method="post">
                  <input type="hidden" name="del_recent_event_id" value="<?php echo $recent_event_rows['id']; ?>">
                  <button type="submit" class="btn btn-danger" name="del_recent_event"  onclick="return confirmDel();">Delete</button>
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
	        <a href="?pageno_p=1" class="btn btn-default myPagerBtn">First</a>
	        <a class="btn btn-default myPagerBtn <?php if($pageno_p <= 1){ echo 'disabled'; } ?>" href="<?php if($pageno_p <= 1){ echo '#'; } else { echo "?pageno_p=".($pageno_p - 1); } ?>">Prev</a>
	        <a class="btn btn-default myPagerBtn <?php if($pageno_p >= $total_pages_p){ echo 'disabled'; } ?>" href="<?php if($pageno_p > $total_pages_p){ echo '#'; } else { echo "?pageno_p=".($pageno_p + 1); } ?>">Next</a>
	        <a class="btn btn-default myPagerBtn" href="?pageno_p=<?php echo $total_pages_p; ?>">Last</a>
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
	function updateEvents(id) {
		$('#update_event_id').val(id);

		$.post("getDataForModels.php",{
			update_event_id:id
		},function(data,status){
			var event=JSON.parse(data);
			$('#update_event_details').val(event.event_details);
		}

			);
		$('#forUpdateEvent').modal("show");
	}
     
     function updateNotice(id) {
		$('#update_notice_id').val(id);

		$.post("getDataForModels.php",{
			update_notice_id:id
		},function(data,status){
			var notice=JSON.parse(data);
			$('#update_notice_title').val(notice.notice_title);
		}

			);
		$('#forUpdateNotice').modal("show");
	}

</script>


<!-- --------------FOOTER----------------- -->

<?php include 'footer.php'; ?>

<!-- *****************ENDING OF MAIN SECTIONS************** -->

<!-- ..........for adding New Notice............ -->

<div class="modal fade" id="forAddNotice" tabindex="-1" role="dialog" aria-labelledby="forAddNotice" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="forAddNotice">Adding New Notice</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <div class="myForm">
            <form method="post" action="" enctype="multipart/form-data">
              <div class="form-group">
                  <label for="text">Select File:</label>
                  <input type="file" class="form-control" id="file" name="add_notice_file">
              </div>
              <div class="form-group">
                  <label for="text">Notice Name:</label>
                  <input type="text" class="form-control" id="text" placeholder="Enter Notice name" name="add_notice_name">
              </div>
              <div class="form-group">
                  <label for="text">Notice Title:</label>
                  <input type="text" class="form-control" id="text" placeholder="Enter Notice Title" name="add_notice_title">
              </div>
                      <button type="submit" class="btn btn-primary" name="add_notice">Add Notice</button>
            </form>
        </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
      </div>
    </div>
  </div>
</div>
<!-- .............adding NOTICE finished........... -->


<!-- ..........for updating NOTICE............ -->

<div class="modal fade" id="forUpdateNotice" tabindex="-1" role="dialog" aria-labelledby="forUpdateNotice" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="forUpdateNotice">Enter Notice Details</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <div class="myForm">
            <form method="post" action="" enctype="multipart/form-data">
              <div class="form-group">
                  <label for="text">Select File:</label>
                  <input type="file" class="form-control" id="file" name="update_file">
              </div>
              <div class="form-group">
                  <label for="update_notice_name">Notice Name:</label>
                  <input type="text" class="form-control" id="update_notice_name" placeholder="Enter Notice name" name="update_notice_name">
              </div>
              <div class="form-group">
                  <label for="update_notice_title">Notice Title:</label>
                  <textarea type="text" class="form-control" id="update_notice_title" placeholder="Enter Notice Title" name="update_notice_title"></textarea>
              </div>
              		<input type="hidden" name="update_notice_id" id="update_notice_id">
                    <button type="submit" class="btn btn-primary" name="update_notice">Update Notice</button>
            </form>
        </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
      </div>
    </div>
  </div>
</div>
<!-- .............updating NOTICE finished........... -->





<!-- ..........for adding New Recent Events............ -->

<div class="modal fade" id="forAddEvent" tabindex="-1" role="dialog" aria-labelledby="forAddEvent" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="forAddEvent">Adding New Recent Events</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <div class="myForm">
        	<form method="post" action="">
              <div class="form-group">
                  <label for="text">Events with details:</label>
                  <input type="text" class="form-control" id="text" placeholder="Enter Events with details" name="add_event_details">
              </div>
                      <button type="submit" class="btn btn-primary" name="add_recent_event">Add Events</button>
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


<!-- ..........for updating Events............ -->

<div class="modal fade" id="forUpdateEvent" tabindex="-1" role="dialog" aria-labelledby="forUpdateEvent" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="forUpdateEvent">Updating Events</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <div class="myForm">
            <form action="" method="post">
              <div class="form-group">
                  <label for="update_event_details">Update Events:</label>
                  <textarea type="text" class="form-control" id="update_event_details" placeholder="Enter New event details" name="update_event_details"></textarea>
              </div>
              		<input type="hidden" name="update_event_id" id="update_event_id">
                    <button type="submit" class="btn btn-primary" name="update_event">Update Events</button>
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