<?php
if(!session_id()){
  session_start();
}?>

<?php 
date_default_timezone_set("Asia/Kathmandu");
$upload_date=Date('Y-m-d h:m:s:ms');
$errors=array();
$Sucess="";
require 'discussion_database.php';
require '../includes/functions.php';

// --------------TO ADD CATEGORY----------------------
if (clean_values($con_discussion,isset($_POST['add_category']))) {
	$add_cat_name=clean_values($con_discussion,$_POST['add_cat_name']);

	if (empty($add_cat_name)) {
		array_push($errors, "Please enter category name");
	}elseif (!is_string($add_cat_name)) {
		array_push($errors, "Please enter valid category name (must be string).");
	}
	if (count($errors)==0) {
		// ----if already exists------
		$exists_cat_qry=@"SELECT * FROM category_name WHERE cat_name='$add_cat_name'";
		$exists_cat_res=mysqli_query($con_discussion,$exists_cat_qry) or die($con_discussion);
		if (mysqli_num_rows($exists_cat_res)>0) {
			array_push($errors, "Category already exists");
		}else{
			$add_category_query=@"INSERT INTO category_name(cat_name,trn_date,is_active)VALUES('$add_cat_name','$upload_date',0)";
			$add_category_result=mysqli_query($con_discussion,$add_category_query) or die($con_discussion);
			if ($add_category_result==1) {
				$Sucess="Your category -> '".$add_cat_name."' has been uploaded sucessfully. Category Name->".$add_cat_name;	
			}else{
				array_push($errors, "Error occurs during adding category");
			}
		}
	}
}

// ---------------DELETE CATEGORY-------------------
if (clean_values($con_discussion,isset($_POST['del_category']))) {
	$delete_category_id=clean_values($con_discussion,$_POST['delete_category_id']);
	$delete_category_name=clean_values($con_discussion,$_POST['delete_category_name']);

	if (empty($delete_category_id)) {
		array_push($errors, "ID is required to delete category");
	}elseif (!is_numeric($delete_category_id)) {
		array_push($errors, "Invalid ID");
	}

	if (empty($delete_category_name)) {
		array_push($errors, "Invalid ID");
	}elseif (!is_string($delete_category_name)) {
		array_push($errors, "Invalid ID");
	}

	if (count($errors)==0) {
		$del_cat_query=@"DELETE FROM category_name WHERE id='$delete_category_id' AND cat_name='$delete_category_name' LIMIT 1";
		$del_cat_execute=mysqli_query($con_discussion,$del_cat_query) or die($con_discussion);
		if ($del_cat_execute==1) {
			$Sucess="Category->".$delete_category_name." has been deleted suscessfully presented on id= ".$delete_category_id;
		}
		else{
			array_push($errors, "Error occurs on deleting category of id= ".$delete_category_id);
		}
	}
}

// -------------UPDATE CATEGORY--------------------
if (clean_values($con_discussion,isset($_POST['update_cat']))) {
	$update_cat_id=clean_values($con_discussion,$_POST['update_cat_id']);
	$update_cat_name=clean_values($con_discussion,$_POST['update_cat_name']);
	// $update_exam_time=$_POST['update_exam_time'];

	if (empty($update_cat_id)) {
		array_push($errors, "ID is required to update category");
	}elseif (!is_numeric($update_cat_id)) {
		array_push($errors, "Invalid ID");
	}
	if (empty($update_cat_name)) {
		array_push($errors, "Name is required to update category");
	}elseif (!is_string($update_cat_name)) {
		array_push($errors, "Invalid category name");
	}

	if (count($errors)==0) {
		$update_cat_qry=@"UPDATE category_name SET cat_name='$update_cat_name' WHERE id=$update_cat_id LIMIT 1";
		$update_cat_execute=mysqli_query($con_discussion,$update_cat_qry) or die($con_discussion);
		if ($update_cat_execute==1) {
			$Sucess="Your category -> '".$update_cat_name."'' has been updated sucessfully presented on id -> '".$update_cat_id."'";
		}
	}
}


// ----------Visiting Next page----------
if (clean_values($con_discussion,isset($_POST['view_cat_details']))) {
	$_SESSION['discussion_cat_details_id']=clean_values($con_discussion,$_POST['cat_details_id']);
	$_SESSION['discussion_cat_details_name']=clean_values($con_discussion,$_POST['cat_details_name']);
	header("Location:discussion_category_details.php");
}

//---For Deactivating category
	if (clean_values($con_discussion,isset($_POST['deactivate_category']))) {
		$activate_deactivate_category_id=clean_values($con_discussion,$_POST['activate_deactivate_category_id']);
		$activate_deactivate_category_name=clean_values($con_discussion,$_POST['activate_deactivate_category_name']);

		if (empty($activate_deactivate_category_id) or !is_numeric($activate_deactivate_category_id) or empty($activate_deactivate_category_name) or !is_string($activate_deactivate_category_name)) {
			array_push($errors, "Invalid ID");
		}
	 if (count($errors)==0) {
		$deactivate_cat_qry=@"UPDATE category_name SET is_active=0 WHERE id=$activate_deactivate_category_id LIMIT 1";
	    $deactivate_cat_res=mysqli_query($con_discussion, $deactivate_cat_qry) or die($con_discussion);
	    if ($deactivate_cat_res==1) {
			$Sucess="Category => ".$activate_deactivate_category_name." has been deactivated sucessfully present on Id => ".$activate_deactivate_category_id;
	    }
	    else{
	      array_push($errors, "Error occurs on updating your name");
	    }
	}
}


	//------For activating category-----
	if (clean_values($con_discussion,isset($_POST['activate_category']))) {
		$activate_deactivate_category_id=clean_values($con_discussion,$_POST['activate_deactivate_category_id']);
		$activate_deactivate_category_name=clean_values($con_discussion,$_POST['activate_deactivate_category_name']);

		if (empty($activate_deactivate_category_id) or !is_numeric($activate_deactivate_category_id) or empty($activate_deactivate_category_name) or !is_string($activate_deactivate_category_name)) {
			array_push($errors, "Invalid ID");
		}
		if (count($errors)==0) {
			$activate_cat_qry=@"UPDATE category_name SET is_active=1 WHERE id='$activate_deactivate_category_id'";
			$activate_cat_res=mysqli_query($con_discussion,$activate_cat_qry) or die($con_discussion);
			if ($activate_cat_res==1) {
				$Sucess="Category => ".$activate_deactivate_category_name." has been activated sucessfully present on Id => ".$activate_deactivate_category_id;
			}
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

  	$total_pages_sql = "SELECT * FROM category_name ";
    $result = mysqli_query($con_discussion,$total_pages_sql);
    if (mysqli_num_rows($result)>0) {
    	$total_rows = mysqli_num_rows($result);
    	// echo "Total rows => ".$total_rows;
    	$total_pages = ceil($total_rows / $no_of_records_per_page);
    }else{
    	$total_pages=1;
    }

// ---------------------------VIEWING ALL CATEGORIES-----------------------

$qry_category=@"SELECT * FROM category_name LIMIT $starting_from,$no_of_records_per_page";
$qry_category_execute=mysqli_query($con_discussion,$qry_category) or die($con_discussion);
?>




<?php include 'heading.php'; ?>
<?php include 'admin_nav.php';?>
<head>
	<title>ONLINE ENTRANCE | Categories Available for exam</title>
	<script src="assests/js/functions.js" type="text/javascript"></script>
</head>
<style type="text/css">

</style>

<!-- *********************STARTING OF MAIN SECTIONS********************* -->
<div class="row">
	<div class="col-lg-1 col-md-1"></div>
	<div class="col-lg-10 col-md-10 col-xs-12 myRowBorder">

		<!-- ------------------------HEADER---------------------- -->
		<div class="mySubRowBorder">
			<u  style="color: #1222B5;"><h2 class="text-center">FIELDS AVAILABLES FOR DISCUSSIoN</h2></u>
 			<h4 class="text-center text-warning">Please donot delete any category unnecessarily. There may be category containing questions which will also lost.</h4>
		</div>

			<!-- -------------------------ADD CATEGORY BTN-------------------- -->
		<div class="row">
			<div class="col-lg-4 col-md-4"></div>
			<div class="col-lg-4 col-md-4 col-xs-12 p-2">
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



<!-- -------------------------SHOWING DETAILS---------------------- -->

<div class="row">
	<div class="col-lg-1 col-md-1"></div>
	<div class="col-lg-10 col-md-10 col-xs-12 myRowBorder">
		<!-- <div class="mySubRowBorder">
			<u  style="color: #1222B5;"><h2 class="text-center">CATEGORIES WITH DETAILS</h2></u>
 			<h4 class="text-center text-info">Please check column Action for update and delete .</h4>
		</div> -->

		<div class="row">
			<div class="col-lg-12 col-md-12 col-xs-12">
				<?php if (mysqli_num_rows($qry_category_execute)>0) { ?>
				<table class="table table-striped">
					<thead class="myHeader" style="color: white;">
						<tr>
							<th class="text-center"><strong>ID</strong></th>
							<th class="text-center"><strong>Name<strong></th>
							<th class="text-center"><strong>Status</strong></th>
							<th class="text-center"><strong>Created_at</strong></th>
							<th class="text-center"><strong>Action</strong></th>
							<th></th>
						</tr>
					</thead>
					<tbody>
						 <?php while ($category_rows=mysqli_fetch_assoc($qry_category_execute)) { ?>
						<tr align="center">
    						<td><?php echo $category_rows['id']; ?></td>
							<td>
								<form action="" method="post">
	    							<input type="hidden" name="cat_details_id" value="<?php echo($category_rows['id']); ?>">
	    							<input type="hidden" name="cat_details_name" value="<?php echo($category_rows['cat_name']); ?>">
	    							<button type="submit" class="btn btn-default myLoginBtn" name="view_cat_details"><?php echo $category_rows['cat_name']; ?></button>
    							</form>
							</td>
							<td>
								<form method="post" action="">
						            <input type="hidden" name="activate_deactivate_category_id" value="<?php echo $category_rows['id']; ?>">
						            <input type="hidden" name="activate_deactivate_category_name" value="<?php echo $category_rows['cat_name']; ?>">
						            	<?php if ($category_rows['is_active']==1) { ?>
				              		<button type="submit" class="btn btn-danger" name="deactivate_category">Deactivate</button>
				              			<?php }else{ ?>
				              		<button type="submit" class="btn btn-success" name="activate_category">Activate</button>
				              			<?php } ?>
				              	</form>
				  			 </td>
							<td><?php echo $category_rows['trn_date']; ?></td>
							<td>
								<button type="button" class="btn btn-primary" data-toggle="modal" data-target="#forUpdateCategory" onclick="updatecategory('<?php echo $category_rows['id']; ?>')">Edit</button>
							</td>

							<td>
								<form method="post">
						            <input type="hidden" name="delete_category_id" value="<?php echo $category_rows['id']; ?>">
						            <input type="hidden" name="delete_category_name" value="<?php echo $category_rows['cat_name']; ?>">
									<button type="submit" class="btn btn-warning" name="del_category"  onclick="return confirmDel();">Delete</button>
								</form>
							</td>
						</tr>
						<?php }  ?>
					</tbody>
				</table>
			<?php }else{echo "<h2 class='text-info'>There is not any discussion category, try Again later.</h2>";} ?>
						<!-- ------------Pagination----------- -->
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
	function updatecategory(id) {
		$('#update_cat_id').val(id);

		$.post("getDataForModels.php",{
			update_discussion_cat_id:id
		},function(data,status){
			var cat=JSON.parse(data);
			$('#update_cat_name').val(cat.cat_name);
		}

			);
		$('#forUpdateCategory').modal("show");
	}

</script>

<!-- ----------------FOOTER------------------ -->

<?php include 'footer.php'; ?>

<!-- **************************ENDING OF MAIN SECTIONS**************************** -->


<!-- ..........for adding category............ -->

<div class="modal fade" id="forAddCategory" tabindex="-1" role="dialog" aria-labelledby="forAddCategory" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="forAddCategory">Enter New Category Name</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <div class="myForm">
        <!-- <span class="myFormTitle"><h2>Schools/College Login Form</h2></span> -->
            <form action="" method="post">
              <div class="form-group">
                  <label for="text">Category Name:</label>
                  <input type="text" class="form-control" id="text" placeholder="Enter Category Name" name="add_cat_name">
              </div>
                    <button type="submit" class="btn btn-primary" name="add_category">Add Category</button>
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

<div class="modal fade" id="forUpdateCategory" tabindex="-1" role="dialog" aria-labelledby="forUpdateCategory" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="forUpdateCategory">Update Category Details</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <div class="myForm">
        <!-- <span class="myFormTitle"><h2>Schools/College Login Form</h2></span> -->
            <form action="" method="post">
              <div class="form-group">
                  <label for="update_cat_name">Category Name:</label>
                  <input type="text" class="form-control" id="update_cat_name" placeholder="Enter New Category Name" name="update_cat_name">
              </div>
              		<input type="hidden" name="update_cat_id" id="update_cat_id">
                    <button type="submit" class="btn btn-primary" name="update_cat">Update Category</button>
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
