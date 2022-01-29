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


//--------------UPDATING ALBUMS DETAILS TAKING NEW INPUTS----------
if (isset($_POST['update_category'])) {
	$update_download_cat_id=$_POST['update_download_cat_id'];
	$update_download_cat_name=$_POST['update_download_cat_name'];

	if (empty($update_download_cat_name)) {
		array_push($errors, "Please enter category name.");
	}

	$edit_download_cat_qry=@"SELECT * FROM category_name WHERE id='$update_download_cat_id'";
	$edit_download_cat_execute=mysqli_query($con_admin,$edit_download_cat_qry) or die($con_admin);
	if (mysqli_num_rows($edit_download_cat_execute)==0) {
		array_push($errors, "There is not any category present on the id = ".$update_download_cat_id." on the database");
	}

	if (count($errors)==0) {
		$update_download_cat_qry=@"UPDATE category_name SET cat_name='$update_download_cat_name' WHERE id='$update_download_cat_id'";
		$update_download_cat_result=mysqli_query($con_admin,$update_download_cat_qry) or die($con_admin);
		if ($update_download_cat_result==1) {
			$Sucess="Your category -> '".$update_download_cat_name."' details has been updated sucessfully presented on ID -> ".$update_download_cat_id;
		}
		else{
			array_push($errors, "Error Occurs while updating your details");
		}
		
	}
}

// --------------TO ADD NEW DOWNLOAD CATEGORY----------------------
if (isset($_POST['add_download_cat'])) {
	$add_download_cat_name=$_POST['add_download_cat_name'];

	if (empty($add_download_cat_name)) {
		array_push($errors, "Please enter category name");
	}

	if (count($errors)==0) {
	$add_download_cat_query=@"INSERT INTO category_name(cat_name,is_active,trn_date)
	VALUES('$add_download_cat_name','0','$upload_date')";
	$add_download_cat_result=mysqli_query($con_admin,$add_download_cat_query) or die($con_admin);
	if ($add_download_cat_result==1) {
			$Sucess="Your category has been uploaded sucessfully.";
			
		}
	else{
		array_push($errors, "Error occurs during adding category");
	}
	}
}


// ---------------DELETE NOTICE-------------------
if (isset($_POST['del_download_cat'])) {
	$del_download_cat_id=$_POST['del_download_cat_id'];
	$del_download_cat_name=$_POST['del_download_cat_name'];
	if (empty($del_download_cat_id)) {
		array_push($errors, "ID is required to delete category");
	}
	$qry_exists_download_cat=@"SELECT * FROM category_name WHERE id='$del_download_cat_id'";
	$qry_exists_download_cat_execute=mysqli_query($con_admin,$qry_exists_download_cat) or die($con_admin);
	if (mysqli_num_rows($qry_exists_download_cat_execute)==0) {
		array_push($errors, "There is not any category present on id = ".$del_download_cat_id." . Check ID correctly and try again.");
	}
	if (count($errors)==0) {
		$del_download_cat_query=@"DELETE FROM category_name WHERE id='$del_download_cat_id'";
		$del_download_cat_execute=mysqli_query($con_admin,$del_download_cat_query) or die($con_admin);
		if ($del_download_cat_execute==1) {
			$Sucess="Category -> '".$del_download_cat_name."' has been deleted suscessfully presented on id= ".$del_download_cat_id;
		}
		else{
			array_push($errors, "Error occurs on deleting category of id= ".$del_download_cat_id);
		}
	}
}


// -----------ACTIVATE NOTICE----------
if (isset($_POST['activate_download_cat'])) {
	$activate_download_cat_id=$_POST['activate_download_cat_id'];
	$activate_download_cat_name=$_POST['activate_download_cat_name'];
	$activate_download_cat=@"UPDATE category_name SET is_active='1' WHERE id='$activate_download_cat_id' LIMIT 1";
	$activate_download_cat_execute=mysqli_query($con_admin,$activate_download_cat) or die($con_admin);
	if ($activate_download_cat_execute==1) {
		$Sucess="Category -> '".$activate_download_cat_name."' has been activated suscessfully presented on id= ".$activate_download_cat_id;
	}
	else{
		array_push($errors, "Error occurs on Activating Category present on id= ".$activate_download_cat_id);
	}
}


// ------------------DEACTIVATE NOTICE-------------------

if (isset($_POST['deactivate_download_cat'])) {
	$deactivate_download_cat_id=$_POST['deactivate_download_cat_id'];
	$deactivate_download_cat_name=$_POST['deactivate_download_cat_name'];
	$deactivate_download_cat_qry=@"UPDATE category_name SET is_active='0' WHERE id='$deactivate_download_cat_id' LIMIT 1";
	$deactivate_download_cat_execute=mysqli_query($con_admin,$deactivate_download_cat_qry) or die($con_admin);
	if ($deactivate_download_cat_execute==1) {
		$Sucess="Category -> '".$deactivate_download_cat_name."' has been deactivated suscessfully presented on id= ".$deactivate_download_cat_id;
	}
	else{
		array_push($errors, "Error occurs on Activating category present on id= ".$deactivate_download_cat_id);
	}
}

	// -----------For Pagination----------
	 if (isset($_GET['pageno'])) {
	 	settype($pageno, 'integer');
     	$pageno = $_GET['pageno'];
   	} else {
      	$pageno = 1;
    }

  	$no_of_records_per_page = 10;
  	$starting_from = ($pageno-1) * $no_of_records_per_page;

  	$total_pages_sql = "SELECT * FROM category_name";
    $result = mysqli_query($con_admin,$total_pages_sql);
    if (mysqli_num_rows($result)>0) {
    	$total_rows = mysqli_num_rows($result);
    	// echo "Total rows => ".$total_rows;
    	$total_pages = ceil($total_rows / $no_of_records_per_page);
    }else{
    	$total_pages=1;
    }

//----------------SELECTING IMAGES PRESENT ON THAT ID-----------------
$qry_download_cat=@"SELECT * FROM category_name LIMIT $starting_from,$no_of_records_per_page";
$qry_download_cat_execute=mysqli_query($con_admin,$qry_download_cat) or die($con_admin);

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

</style>

<!-- ************************STARTING OF MAIN SECTIONS**************** -->
<div class="row">
	<div class="col-lg-1 col-md-1"></div>
	<div class="col-lg-10 col-md-10 col-xs-12 myRowBorder">

		<!-- ------------------------HEADER---------------------- -->
		<div class="mySubRowBorder">
			<u  style="color: #1222B5;"><h2 class="text-center">All category present on the database download</h2></u>
 			<!-- <h4 class="text-center text-warning">Moving images album is compulsory do not change or edit it..</h4> -->
		</div>

			<!-- -------------------------ADD CATEGORY BTN-------------------- -->
		<div class="row">
			<div class="col-lg-4 col-md-4"></div>
			<div class="col-lg-4 col-md-4 col-xs-12 p-2">
					<button type="button" class="btn btn-primary btn-lg btn-block" data-toggle="modal" data-target="#forAddCat">
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


<!-- --------------SHOWING ALL THE IMAGES PRESENT ON THAT ALBUM----------- -->
<div class="row">
  <div class="col-lg-1 col-md-1"></div>
  <div class="col-lg-10 col-md-10 col-xs-12 myRowBorder">
    <div class="mySubRowBorder">
      <u  style="color: #1222B5;"><h2 class="text-center">CATEGORY WITH DETAILS</h2></u>
      <h4 class="text-center text-info">Please check column Action for update and delete .</h4>
    </div>

    <div class="row">
      <div class="col-lg-12 col-md-12 col-xs-12">
        <table class="table table-striped">
          <thead class="myHeader" style="color: white;">
            <tr>
              <th class="text-center"><strong>ID</strong></th>
              <th class="text-center"><strong>Name<strong></th>
              <th class="text-center"><strong>Status</strong></th>
              <th class="text-center"><strong>Upload_at</strong></th>
              <th class="text-center"><strong>Action</strong></th>
              <th></th>
            </tr>
          </thead>
          <tbody>
             <?php while ($download_cat_rows=mysqli_fetch_assoc($qry_download_cat_execute)) { ?>
            <tr align="center">
              <td><?php echo $download_cat_rows['id']; ?></td>
              <td>
              	<form action="download_category_details.php" method="post">
			      <input type="hidden" name="download_cat_details_name" value="<?php echo($download_cat_rows['cat_name']); ?>">
			      <input type="hidden" name="download_cat_details_id" value="<?php echo($download_cat_rows['id']); ?>">
			      <button type="submit" class="btn btn-default myLoginBtn" name="view_cat_details"><?php echo $download_cat_rows['cat_name']; ?></button>
			    </form>
              </td>

              <td>
                  <?php if($download_cat_rows['is_active']==1){ ?>
                <form method="post">
                    <input type="hidden" name="deactivate_download_cat_id" value="<?php echo($download_cat_rows['id']); ?>">
                    <input type="hidden" name="deactivate_download_cat_name" value="<?php echo($download_cat_rows['cat_name']); ?>">
                    <button type="submit" class="btn btn-danger" name="deactivate_download_cat">Deactivate</button>
                  </form> 
                    <?php }else{ ?>
                  <form method="post">
                    <input type="hidden" name="activate_download_cat_id" value="<?php echo($download_cat_rows['id']); ?>">
                    <input type="hidden" name="activate_download_cat_name" value="<?php echo($download_cat_rows['cat_name']); ?>">
                    <button type="submit" class="btn btn-success" name="activate_download_cat">Activate</button>
                  </form>
                    <?php } ?>
                </td>

              <td><?php echo $download_cat_rows['trn_date']; ?></td>
              <td>
                <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#forUpdateCat" onclick="updateDownloadCat('<?php echo $download_cat_rows['id']; ?>')">Edit</button>
              </td>

              <td>
                <form method="post">
                  <input type="hidden" name="del_download_cat_id" value="<?php echo $download_cat_rows['id']; ?>">
                  <input type="hidden" name="del_download_cat_name" value="<?php echo $download_cat_rows['cat_name']; ?>">
                  <button type="submit" class="btn btn-danger" name="del_download_cat"  onclick="return confirmDel();">Delete</button>
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
	function updateDownloadCat(id) {
		$('#update_download_cat_id').val(id);

		$.post("getDataForModels.php",{
			update_download_cat_id:id
		},function(data,status){
			var download_cat=JSON.parse(data);
			$('#update_download_cat_name').val(download_cat.cat_name);
		}

			);
		$('#forUpdateCat').modal("show");
	}
     

// --------------------------------------------------------------

 //     function updateNotice(id) {
	// 	$('#update_notice_id').val(id);

	// 	$.post("getDataForModels.php",{
	// 		update_notice_id:id
	// 	},function(data,status){
	// 		var notice=JSON.parse(data);
	// 		$('#update_notice_title').val(notice.notice_title);
	// 	}

	// 		);
	// 	$('#forUpdateNotice').modal("show");
	// }

</script>


<?php include 'footer.php'; ?>

<!-- *****************ENDING OF MAIN SECTIONS************** -->

<!-- ..........for adding New Notice............ -->

<div class="modal fade" id="forAddCat" tabindex="-1" role="dialog" aria-labelledby="forAddCat" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="forAddCat">Adding New Category</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <div class="myForm">
            <form method="post" action="">
              <div class="form-group">
                  <label for="text">Category Name:</label>
                  <input type="text" class="form-control" id="file" name="add_download_cat_name">
              </div>
                      <button type="submit" class="btn btn-primary" name="add_download_cat">Add Category</button>
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

<div class="modal fade" id="forUpdateCat" tabindex="-1" role="dialog" aria-labelledby="forUpdateCat" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="forUpdateCat">Updating Category Details</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <div class="myForm">
            <form action="" method="post">
              <div class="form-group">
                  <label for="update_download_cat_name">Category Name:</label>
                  <input type="text" class="form-control text-warning" id="update_download_cat_name" placeholder="Enter New Category Name" name="update_download_cat_name">
              </div>
              		<input type="hidden" name="update_download_cat_id" id="update_download_cat_id">
                    <button type="submit" class="btn btn-primary" name="update_category">Update Category</button>
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