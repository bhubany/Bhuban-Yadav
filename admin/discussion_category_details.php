<?php
if(!session_id()){
  session_start();
}?>

<?php 
date_default_timezone_set("Asia/Kathmandu");
$upload_date=Date('Y-m-d h:m:s');
$errors=array();
$Sucess="";
$cat_details_id="";
$cat_details_name="";
require 'discussion_database.php';
require '../includes/functions.php';


// ------------RECEVING ID's FROM PREVIOUS PAGE-------------
if (isset($_SESSION['discussion_cat_details_id']) and isset($_SESSION['discussion_cat_details_name'])) {
	$cat_details_id=$_SESSION['discussion_cat_details_id'];
	$cat_details_name=$_SESSION['discussion_cat_details_name'];
}else{
	header("Location:discussion_category.php");
}


// --------------TO ADD SETS ON THAT CATEGORY----------------------
if (clean_values($con_discussion,isset($_POST['add_subject']))) {
	$add_subject_name=clean_values($con_discussion,$_POST['add_subject_name']);

	if (empty($add_subject_name)) {
		array_push($errors, "Please enter Subject name to add");
	}elseif (!is_string($add_subject_name)) {
		array_push($errors, "Subjects must be of string");
	}
	$subject_exists_qry=@"SELECT * FROM subjects_name WHERE category_id='$cat_details_id'AND subject='$add_subject_name'";
	$subject_exists_execute=mysqli_query($con_discussion,$subject_exists_qry) or die($con_discussion);
	if (mysqli_num_rows($subject_exists_execute)!=0) {
		array_push($errors, "Already exists the subject name ".$add_subject_name." on database in this category");
	}
	if (count($errors)==0) {
		$add_subject_query=@"INSERT INTO subjects_name(category_id,subject,is_active,trn_date)VALUES('$cat_details_id','$add_subject_name',0,'$upload_date')";
		$add_subject_result=mysqli_query($con_discussion,$add_subject_query) or die($con_discussion);
		if ($add_subject_result==1) {
				$Sucess="Your Subject has been added sucessfully";
		}else{
			array_push($errors, "Error occurs during adding SET numbers");
		}
	}
}

// ---------------DELETE CATEGORY details-------------------
if (clean_values($con_discussion,isset($_POST['del_subject']))) {
	$delete_subject_id=clean_values($con_discussion,$_POST['delete_subject_id']);
	$delete_subject_name=clean_values($con_discussion,$_POST['delete_subject_name']);

	if (empty($delete_subject_id)) {
		array_push($errors, "ID is required to delete category");
	}elseif (!is_numeric($delete_subject_id)) {
		array_push($errors, "Invalid ID");
	}

	if (empty($delete_subject_name)) {
		array_push($errors, "Invalid ID");
	}elseif (!is_string($delete_subject_name)) {
		array_push($errors, "Invalid ID");
	}

	if (count($errors)==0) {
		$del_sub_query=@"DELETE FROM subjects_name WHERE (id=$delete_subject_id AND subject='$delete_subject_name') AND category_id=$cat_details_id LIMIT 1";
		$del_sub_res=mysqli_query($con_discussion,$del_sub_query) or die($con_discussion);
		if ($del_sub_res==1) {
			$Sucess="Subject =>".$delete_subject_name." has been deleted suscessfully presented on id= ".$delete_subject_id;
		}
		else{
			array_push($errors, "Error occurs on deleting category of id => ".$delete_subject_id);
		}
	}
}

// -------------UPDATE SUBJECTS--------------------
if (clean_values($con_discussion,isset($_POST['update_subject']))) {
	$update_subject_id=clean_values($con_discussion,$_POST['update_subject_id']);
	$update_subject_name=clean_values($con_discussion,$_POST['update_subject_name']);
	// $update_exam_time=$_POST['update_exam_time'];

	if (empty($update_subject_id)) {
		array_push($errors, "ID is required to update category");
	}elseif (!is_numeric($update_subject_id)) {
		array_push($errors, "Invalid ID");
	}
	if (empty($update_subject_name)) {
		array_push($errors, "Name is required to update subject");
	}elseif (!is_string($update_subject_name)) {
		array_push($errors, "Invalid category name");
	}

	if (count($errors)==0) {
		$update_cat_qry=@"UPDATE subjects_name SET subject='$update_subject_name' WHERE category_id=$cat_details_id AND id=$update_subject_id LIMIT 1";
		$update_cat_execute=mysqli_query($con_discussion,$update_cat_qry) or die($con_discussion);
		if ($update_cat_execute==1) {
			$Sucess="Your category -> '".$update_subject_name."'' has been updated sucessfully presented on id -> '".$update_subject_id."'";
		}
	}
}

//---For Deactivating category details
	if (clean_values($con_discussion,isset($_POST['deactivate_category']))) {
		$activate_deactivate_category_id=clean_values($con_discussion,$_POST['activate_deactivate_category_id']);
		$activate_deactivate_category_name=clean_values($con_discussion,$_POST['activate_deactivate_category_name']);

		if (empty($activate_deactivate_category_id) or !is_numeric($activate_deactivate_category_id) or empty($activate_deactivate_category_name) or !is_string($activate_deactivate_category_name)) {
			array_push($errors, "Invalid ID");
		}
	 if (count($errors)==0) {
		$deactivate_cat_qry=@"UPDATE subjects_name SET is_active=0 WHERE id=$activate_deactivate_category_id LIMIT 1";
	    $deactivate_cat_res=mysqli_query($con_discussion, $deactivate_cat_qry) or die($con_discussion);
	    if ($deactivate_cat_res==1) {
			$Sucess="Subject => ".$activate_deactivate_category_name." has been deactivated sucessfully present on Id => ".$activate_deactivate_category_id;
	    }
	    else{
	      array_push($errors, "Error occurs on updating your name");
	    }
	}
}


	//------For activating category details-----
	if (clean_values($con_discussion,isset($_POST['activate_category']))) {
		$activate_deactivate_category_id=clean_values($con_discussion,$_POST['activate_deactivate_category_id']);
		$activate_deactivate_category_name=clean_values($con_discussion,$_POST['activate_deactivate_category_name']);

		if (empty($activate_deactivate_category_id) or !is_numeric($activate_deactivate_category_id) or empty($activate_deactivate_category_name) or !is_string($activate_deactivate_category_name)) {
			array_push($errors, "Invalid ID");
		}
		if (count($errors)==0) {
			$activate_cat_qry=@"UPDATE subjects_name SET is_active=1 WHERE id='$activate_deactivate_category_id'";
			$activate_cat_res=mysqli_query($con_discussion,$activate_cat_qry) or die($con_discussion);
			if ($activate_cat_res==1) {
				$Sucess="Subject => ".$activate_deactivate_category_name." has been activated sucessfully present on Id => ".$activate_deactivate_category_id;
			}
		}
	}

// ----------Visiting next page----------
if (isset($_POST['view_discussion_subject_questions'])) {
	$_SESSION['discussion_subject_id']=clean_values($con_discussion,$_POST['discussion_subject_id']);
	$_SESSION['discussion_subjects_name']=clean_values($con_discussion,$_POST['discussion_subject_name']);
	header("Location:discussion_subject_questions.php");
}

	// -----------For Pagination----------
	 if (isset($_GET['pageno'])) {
     	$pageno = $_GET['pageno'];
   	} else {
      	$pageno = 1;
    }

  	$no_of_records_per_page = 10;
  	$starting_from = ($pageno-1) * $no_of_records_per_page;

  	$total_pages_sql = "SELECT * FROM subjects_name WHERE category_id='$cat_details_id'";
    $result = mysqli_query($con_discussion,$total_pages_sql);
    if (mysqli_num_rows($result)>0) {
    	$total_rows = mysqli_num_rows($result);
    	$total_pages = ceil($total_rows / $no_of_records_per_page);
    }else{
    	$total_pages=1;
    }

// --------------------GETTING ALL DETAILS----------------------
$cat_details_qry=@"SELECT * FROM subjects_name WHERE category_id='$cat_details_id' LIMIT $starting_from,$no_of_records_per_page";
$cat_details_execute=mysqli_query($con_discussion,$cat_details_qry) or die($con_discussion);
 ?>

<?php include 'heading.php'; ?>
<?php include 'admin_nav.php';?>
<head>
	<title>ONLINE ENTRANCE | sets available</title>
	<script src="assests/js/functions.js" type="text/javascript"></script>
</head>

<style type="text/css">

</style>

<!-- *********************STARTING OF MAIN********************** -->

<div class="row">
	<div class="col-lg-1 col-md-1"></div>
	<div class="col-lg-10 col-md-10 col-xs-12 myRowBorder">

		<!-- ------------------------HEADER---------------------- -->
		<div class="mySubRowBorder">
			<u  style="color: #1222B5;"><h2 class="text-center">Availables Subjects of category ("<?php echo strtoupper($cat_details_name); ?>")</h2></u>
 			<h4 class="text-center text-info">Id of current category is -> <?php echo $cat_details_id; ?>.</h4>
		</div>

			<!-- -------------------------ADD CATEGORY BTN-------------------- -->
		<div class="row">
			<div class="col-lg-4 col-md-4"></div>
			<div class="col-lg-4 col-md-4 col-xs-12 p-2">
					<button type="button" class="btn btn-primary btn-lg btn-block" data-toggle="modal" data-target="#forAddSubject">
					Add Subject
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


<div class="row">
	<div class="col-lg-1 col-md-1"></div>
	<div class="col-lg-10 col-md-10 col-xs-12 myRowBorder">
		<!-- <div class="mySubRowBorder">
			<u  style="color: #1222B5;"><h2 class="text-center">SETS WITH DETAILS</h2></u>
 			<h4 class="text-center text-info">Please check column Action for update and delete .</h4>
		</div> -->

		<div class="row">
			<div class="col-lg-12 col-md-12 col-xs-12">
				<?php if (mysqli_num_rows($cat_details_execute)>0) { ?>
				<table class="table table-striped">
					<thead class="myHeader" style="color: white;">
						<tr>
							<th class="text-center"><strong>ID</strong></th>
							<th class="text-center"><strong>Subject</strong></th>
							<th class="text-center"><strong>Status</strong></th>
							<th class="text-center"><strong>Created_at<strong></th>
							<th class="text-center"><strong>Action</strong></th>
							<th></th>
							<th></th>
						</tr>
					</thead>
					<tbody>
						 <?php while ($subject_rows=mysqli_fetch_assoc($cat_details_execute)) { ?>
						<tr align="center">
							<td><?php echo $subject_rows['id']; ?></td>
							<td>
								<form action="" method="post">
						            <input type="hidden" name="discussion_subject_id" value="<?php echo $subject_rows['id']; ?>">
						            <input type="hidden" name="discussion_subject_name" value="<?php echo $subject_rows['subject']; ?>">
							    	<button type="submit" class="btn btn-default myLoginBtn" name="view_discussion_subject_questions"><?php echo $subject_rows['subject']; ?></button>
							    </form>
							</td>
							<td>
								<form method="post" action="">
						            <input type="hidden" name="activate_deactivate_category_id" value="<?php echo $subject_rows['id']; ?>">
						            <input type="hidden" name="activate_deactivate_category_name" value="<?php echo $subject_rows['subject']; ?>">
						            	<?php if ($subject_rows['is_active']==1) { ?>
				              		<button type="submit" class="btn btn-danger" name="deactivate_category">Deactivate</button>
				              			<?php }else{ ?>
				              		<button type="submit" class="btn btn-success" name="activate_category">Activate</button>
				              			<?php } ?>
				              	</form>
				  			 </td>
							<td><?php echo $subject_rows['trn_date']; ?></td>
							<td>
								<button type="button" class="btn btn-primary" data-toggle="modal" data-target="#forUpdateSubject" onclick="updatesubject('<?php echo $subject_rows['id']; ?>')">Edit</button>
							</td>
							 
							<!-- <td>
								<button type="button" class="btn btn-primary" data-toggle="modal" data-target="#forUpdateSet">Edit</button>
							</td> -->

							<td>
								<form method="post">
						            <input type="hidden" name="delete_subject_id" value="<?php echo $subject_rows['id']; ?>">
						            <input type="hidden" name="delete_subject_name" value="<?php echo $subject_rows['subject']; ?>">
									<button type="submit" class="btn btn-warning" name="del_subject"  onclick="return confirmDel();">Delete</button>
								</form>
							</td>
						</tr>
						<?php }  ?>
					</tbody>
				</table>
				    <?php } else { echo "<h2 class='text-info'>There is not any subjects present on this category.</h2>"; } ?>
				<!-- ----------Pagination-------- -->
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
	function updatesubject(id) {
		$('#update_subject_id').val(id);

		$.post("getDataForModels.php",{
			update_discussion_subject_id:id
		},function(data,status){
			var subject=JSON.parse(data);
			$('#update_subject_name').val(subject.subject);
		}

			);
		$('#forUpdateSubject').modal("show");
	}

</script>

<!-- -----------------FOOTER-------------------- -->
<?php include 'footer.php'; ?>

<!-- ..........for adding Set............ -->

<div class="modal fade" id="forAddSubject" tabindex="-1" role="dialog" aria-labelledby="forAddSubject" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <!-- <h5 class="modal-title" id="forAddSet">Add Set</h5><br> -->
        <h5 class="modal-title text-danger" id="forAddSubject">Please enter subject name carefully</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <div class="myForm">
        <!-- <span class="myFormTitle"><h2>Schools/College Login Form</h2></span> -->
            <form action="" method="post">
              <div class="form-group">
                  <label for="text">Subject Name:</label>
                  <input type="text" class="form-control" id="add_subject_name" placeholder="Enter subject Name" name="add_subject_name">
              </div>
                      <button type="submit" class="btn btn-primary" name="add_subject">Add Set</button>
            </form>
        </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
      </div>
    </div>
  </div>
</div>
<!-- .............adding set finished........... -->


<!-- ..........for updating set............ -->

<div class="modal fade" id="forUpdateSubject" tabindex="-1" role="dialog" aria-labelledby="forUpdateSubject" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="forUpdateSubject">Enter New Subject details</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <div class="myForm">
        <!-- <span class="myFormTitle"><h2>Schools/College Login Form</h2></span> -->
            <form action="" method="post">
              <div class="form-group">
              	<input type="hidden" name="update_subject_id" id="update_subject_id">
                  <label for="text">Subject Name:</label>
                  <input type="text" class="form-control" id="update_subject_name" placeholder="Enter New Set number" name="update_subject_name">
              </div>
                      <button type="submit" class="btn btn-primary" name="update_subject">Update Set</button>
            </form>
        </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
      </div>
    </div>
  </div>
</div>
<!-- .............updating set finished........... -->