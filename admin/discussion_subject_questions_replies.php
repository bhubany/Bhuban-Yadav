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
$discussion_subject_id="";
$discussion_subjects_name="";
$discussion_subject_question_id="";
$qsn_replies=0;
require 'discussion_database.php';
require '../includes/functions.php';


// ------------RECEVING ID's FROM PREVIOUS PAGE-------------
if (isset($_SESSION['discussion_cat_details_id']) and isset($_SESSION['discussion_cat_details_name']) AND isset($_SESSION['discussion_subject_id']) AND isset($_SESSION['discussion_subjects_name']) AND isset($_SESSION['discussion_subject_question_id'])) {
	$cat_details_id=clean_values($con_discussion,$_SESSION['discussion_cat_details_id']);
	$cat_details_name=clean_values($con_discussion,$_SESSION['discussion_cat_details_name']);
	$discussion_subject_id=clean_values($con_discussion,$_SESSION['discussion_subject_id']);
	$discussion_subjects_name=clean_values($con_discussion,$_SESSION['discussion_subjects_name']);
	$discussion_subject_question_id=clean_values($con_discussion,$_SESSION['discussion_subject_question_id']);
	// echo "question id => ".$discussion_subject_question_id;
}else{
	header("Location:discussion_subject_questions.php");
}


// // --------------TO ADD SETS ON THAT CATEGORY----------------------
// if (clean_values($con_discussion,isset($_POST['add_subject']))) {
// 	$add_subject_name=clean_values($con_discussion,$_POST['add_subject_name']);

// 	if (empty($add_subject_name)) {
// 		array_push($errors, "Please enter Subject name to add");
// 	}elseif (!is_string($add_subject_name)) {
// 		array_push($errors, "Subjects must be of string");
// 	}
// 	$subject_exists_qry=@"SELECT * FROM subjects_name WHERE category_id='$cat_details_id'AND subject='$add_subject_name'";
// 	$subject_exists_execute=mysqli_query($con_discussion,$subject_exists_qry) or die($con_discussion);
// 	if (mysqli_num_rows($subject_exists_execute)!=0) {
// 		array_push($errors, "Already exists the subject name ".$add_subject_name." on database in this category");
// 	}
// 	if (count($errors)==0) {
// 		$add_subject_query=@"INSERT INTO subjects_name(category_id,subject,is_active,trn_date)VALUES('$cat_details_id','$add_subject_name',0,'$upload_date')";
// 		$add_subject_result=mysqli_query($con_discussion,$add_subject_query) or die($con_discussion);
// 		if ($add_subject_result==1) {
// 				$Sucess="Your Subject has been added sucessfully";
// 		}else{
// 			array_push($errors, "Error occurs during adding SET numbers");
// 		}
// 	}
// }

// ---------------DELETE CATEGORY details-------------------
if (clean_values($con_discussion,isset($_POST['del_subject_question_replies']))) {
	$delete_subject_question_replies_id=clean_values($con_discussion,$_POST['delete_subject_question_replies_id']);

	if (empty($delete_subject_question_replies_id)) {
		array_push($errors, "ID is required to delete category");
	}elseif (!is_numeric($delete_subject_question_replies_id)) {
		array_push($errors, "Invalid ID");
	}

	if (count($errors)==0) {
		$del_sub_qsn_rep_query=@"DELETE FROM questions WHERE (category_id=$cat_details_id AND subject_id='$discussion_subject_id') AND (question_id=$discussion_subject_question_id AND id=$delete_subject_question_replies_id) LIMIT 1";
		$del_sub_qsn_rep_res=mysqli_query($con_discussion,$del_sub_qsn_rep_query) or die($con_discussion);
		if ($del_sub_qsn_rep_res==1) {
			$Sucess="Replies of Subject =>".$discussion_subjects_name." has been deleted suscessfully presented on id= ".$delete_subject_question_replies_id;
		}
		else{
			array_push($errors, "Error occurs on deleting category of id => ".$delete_subject_question_replies_id);
		}
	}
}

// -------------UPDATE SUBJECTS Questions replies--------------------
if (clean_values($con_discussion,isset($_POST['update_question_replies']))) {
	$update_discussion_subject_question_replies_id=clean_values($con_discussion,$_POST['update_discussion_subject_question_replies_id']);
	$update_subject_question_replies=clean_values($con_discussion,$_POST['update_subject_question_replies']);

	if (empty($update_discussion_subject_question_replies_id)) {
		array_push($errors, "ID is required to update category");
	}elseif (!is_numeric($update_discussion_subject_question_replies_id)) {
		array_push($errors, "Invalid ID");
	}
	if (empty($update_subject_question_replies)) {
		array_push($errors, "Details is required to update.");
	}

	if (count($errors)==0) {
		$update_qsn_rep_qry=@"UPDATE questions SET question='$update_subject_question' WHERE (category_id=$cat_details_id AND subject_id=$discussion_subject_id) AND id=$update_discussion_subject_question_replies_id LIMIT 1";
		$update_qsn_rep_res=mysqli_query($con_discussion,$update_qsn_rep_qry) or die($con_discussion);
		if ($update_qsn_rep_res==1) {
			$Sucess="Your replies of category -> '".$discussion_subjects_name."'' has been updated sucessfully presented on id -> '".$update_discussion_subject_question_replies_id."'";
		}else{
			array_push($errors, "Error occurs try again later");
		}
	}
}

// //---For Deactivating category details
// 	if (clean_values($con_discussion,isset($_POST['deactivate_category']))) {
// 		$activate_deactivate_category_id=clean_values($con_discussion,$_POST['activate_deactivate_category_id']);
// 		$activate_deactivate_category_name=clean_values($con_discussion,$_POST['activate_deactivate_category_name']);

// 		if (empty($activate_deactivate_category_id) or !is_numeric($activate_deactivate_category_id) or empty($activate_deactivate_category_name) or !is_string($activate_deactivate_category_name)) {
// 			array_push($errors, "Invalid ID");
// 		}
// 	 if (count($errors)==0) {
// 		$deactivate_cat_qry=@"UPDATE subjects_name SET is_active=0 WHERE id=$activate_deactivate_category_id LIMIT 1";
// 	    $deactivate_cat_res=mysqli_query($con_discussion, $deactivate_cat_qry) or die($con_discussion);
// 	    if ($deactivate_cat_res==1) {
// 			$Sucess="Subject => ".$activate_deactivate_category_name." has been deactivated sucessfully present on Id => ".$activate_deactivate_category_id;
// 	    }
// 	    else{
// 	      array_push($errors, "Error occurs on updating your name");
// 	    }
// 	}
// }


// 	//------For activating category details-----
// 	if (clean_values($con_discussion,isset($_POST['activate_category']))) {
// 		$activate_deactivate_category_id=clean_values($con_discussion,$_POST['activate_deactivate_category_id']);
// 		$activate_deactivate_category_name=clean_values($con_discussion,$_POST['activate_deactivate_category_name']);

// 		if (empty($activate_deactivate_category_id) or !is_numeric($activate_deactivate_category_id) or empty($activate_deactivate_category_name) or !is_string($activate_deactivate_category_name)) {
// 			array_push($errors, "Invalid ID");
// 		}
// 		if (count($errors)==0) {
// 			$activate_cat_qry=@"UPDATE subjects_name SET is_active=1 WHERE id='$activate_deactivate_category_id'";
// 			$activate_cat_res=mysqli_query($con_discussion,$activate_cat_qry) or die($con_discussion);
// 			if ($activate_cat_res==1) {
// 				$Sucess="Subject => ".$activate_deactivate_category_name." has been activated sucessfully present on Id => ".$activate_deactivate_category_id;
// 			}
// 		}
// 	}

// ----------Visiting next page----------
// if (clean_values($con_discussion,isset($_POST['view_discussion_subject_question_replies']))) {
// 	$_SESSION['discussion_subject_question_id']=clean_values($con_discussion,$_POST['view_discussion_subject_question_replies']);
// 	header("Location:exam_set_details.php");
// }

	// -----------For Pagination----------
	 if (isset($_GET['pageno'])) {
     	$pageno = $_GET['pageno'];
   	} else {
      	$pageno = 1;
    }

  	$no_of_records_per_page = 10;
  	$starting_from = ($pageno-1) * $no_of_records_per_page;

  	$total_pages_sql = "SELECT * FROM replies WHERE (category_id=$cat_details_id AND subject_id=$discussion_subject_id) AND question_id=$discussion_subject_question_id";
    $result = mysqli_query($con_discussion,$total_pages_sql) or die($con_discussion);
    if (mysqli_num_rows($result)>0) {
    	$total_rows = mysqli_num_rows($result);
    	$total_pages = ceil($total_rows / $no_of_records_per_page);
    }else{
    	$total_pages=1;
    }

// --------------------GETTING ALL DETAILS----------------------
$question_replies_qry=@"SELECT * FROM replies WHERE (category_id=$cat_details_id AND subject_id=$discussion_subject_id) AND question_id=$discussion_subject_question_id ORDER BY id DESC LIMIT $starting_from,$no_of_records_per_page";
$question_replies_res=mysqli_query($con_discussion,$question_replies_qry) or die($con_discussion);
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
	<div class="col-lg-10 col-md-10 col-xs-12 myRowBorder" style="border-bottom: none;"><br>

		<!-- ------------------------HEADER---------------------- -->
		<div class="shadow">
			<u  style="color: #1222B5;"><h5 class="text-center">Availables Questions of category ("<?php echo strtoupper($cat_details_name); ?>") and subject ("<?php echo strtoupper($discussion_subjects_name); ?>")</h5></u>
 			<p class="text-center text-info">Id of current category is -> <?php echo $cat_details_id; ?> and current subject is -> <?php echo $discussion_subject_id; ?> ,question is -> <?php echo $discussion_subject_id; ?> .</p>
 			<?php 
 				$sel_qsn_qry=@"SELECT question FROM questions WHERE (category_id=$cat_details_id AND subject_id=$discussion_subject_id) AND id=$discussion_subject_question_id LIMIT 1";
 				$sel_qsn_qry_res=mysqli_query($con_discussion,$sel_qsn_qry) or die($con_discussion);
 				if (mysqli_num_rows($sel_qsn_qry_res)>0) { 
 				while($question_rows=mysqli_fetch_assoc($sel_qsn_qry_res)){ ?>
 			<p class="p-1"><span class="font-weight-bold">Questions: </span><span class="font-italic"><?php echo $question_rows['question']; ?></span></p>
 			<?php } } else{ echo "<h5 class='alert alert-danger text-center'>Error occurs on rendering questions</h5>"; } ?>
		</div>

			<!-- -------------------------ADD CATEGORY BTN-------------------- -->
		<!-- <div class="row">
			<div class="col-lg-4 col-md-4"></div>
			<div class="col-lg-4 col-md-4 col-xs-12 p-2">
					<button type="button" class="btn btn-primary btn-lg btn-block" data-toggle="modal" data-target="#forAddQuestions">
					Add Replies
				</button>
			</div>
			<div class="col-lg-4 col-md-4"></div>
		</div> -->

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
	<div class="col-lg-10 col-md-10 col-xs-12 myRowBorder" style="border-top: none;">
		<!-- <div class="mySubRowBorder">
			<u  style="color: #1222B5;"><h2 class="text-center">SETS WITH DETAILS</h2></u>
 			<h4 class="text-center text-info">Please check column Action for update and delete .</h4>
		</div> -->

		<div class="row">
			<div class="col-lg-12 col-md-12 col-xs-12">
				<?php if (mysqli_num_rows($question_replies_res)>0) { ?>
				<table class="table table-striped">
					<thead class="myHeader" style="color: white;">
						<tr>
							<th class="text-center"><strong>ID</strong></th>
							<th class="text-center"><strong>By</strong></th>
							<th class="text-center"><strong>Replies</strong></th>
							<th class="text-center"><strong>Upload_at<strong></th>
							<th></th>
							<th class="text-center"><strong>Action</strong></th>
							<th></th>
						</tr>
					</thead>
					<tbody>
						 <?php while ($replies_rows=mysqli_fetch_assoc($question_replies_res)) { 
						 	// ----------For Replies------	
						 	// $temp_qsn_id=$replies_rows['id'];
						 	// $replies_qry=@"SELECT * FROM replies WHERE (category_id=$cat_details_id AND subject_id=$discussion_subject_id) AND id=$temp_qsn_id ";
						 	// $replies_res=mysqli_query($con_discussion,$replies_qry) or die($con_discussion);
						 	// if (mysqli_num_rows($replies_res)>0) {
						 	// 	$qsn_replies=mysqli_num_rows($replies_res);
						 	// }else{
						 	// 	$qsn_replies=0;
						 	// }

						 	?>
						<tr align="center">
							<td><?php echo $replies_rows['id']; ?></td>
							<td><?php echo $replies_rows['name']; ?></td>
							<td><?php echo $replies_rows['replies']; ?></td>
							<td><?php echo $replies_rows['trn_date']; ?></td>
							<td>
								<button type="button" class="btn btn-primary" data-toggle="modal" data-target="#forUpdateQuestionReplies" onclick="updatereplies('<?php echo $replies_rows['id']; ?>')">Edit</button>
							</td>
							 
							<td>
								<button type="button" class="btn btn-info" data-toggle="modal" data-target="#forViewQuestionsReplies" onclick="viewreplies('<?php echo $replies_rows['id']; ?>')">View</button>
							</td>

							<td>
								<form method="post">
						            <input type="hidden" name="delete_subject_question_replies_id" value="<?php echo $replies_rows['id']; ?>">
									<button type="submit" class="btn btn-warning" name="del_subject_question_replies"  onclick="return confirmDel();">Delete</button>
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
	function updatereplies(id) {
		$('#update_discussion_subject_question_replies_id').val(id);

		$.post("getDataForModels.php",{
			update_discussion_subject_question_replies_id:id
		},function(data,status){
			var update_question_replies=JSON.parse(data);
			$('#update_subject_question_replies').val(update_question_replies.replies);
		}

			);
		$('#forUpdateQuestion').modal("show");
	}

				// <!-- ------EDITING/UPDATING DETAILS----------- -->
	function viewreplies(id) {
		// $('#view_subject_id').val(id);

		$.post("getDataForModels.php",{
			view_discussion_subject_question_replies_id:id
		},function(data,status){
			var replies=JSON.parse(data);
			$('#view_question_replies').html(replies.replies);
			$('#view_qsn_rep_name').html(replies.name);
			$('#view_qsn_rep_email').html(replies.email);
			$('#view_qsn_rep_date').html(replies.trn_date);
		}

			);
		$('#forViewQuestions').modal("show");
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

<div class="modal fade" id="forUpdateQuestion" tabindex="-1" role="dialog" aria-labelledby="forUpdateQuestion" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="forUpdateQuestion">Enter New Replies details</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <div class="myForm">
        <!-- <span class="myFormTitle"><h2>Schools/College Login Form</h2></span> -->
            <form action="" method="post">
              <div class="form-group">
              	<input type="hidden" name="update_discussion_subject_question_replies_id" id="update_discussion_subject_question_replies_id">
                  <label for="text">Qestion replies:</label>
                  <textarea rows="6" type="text" class="form-control" id="update_subject_question_replies" placeholder="Enter New replies" name="update_subject_question_replies"></textarea>
              </div>
                      <button type="submit" class="btn btn-primary" name="update_question_replies">Update Set</button>
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

<!-- ------------------------VIEWING QUESTION DETAILS FULLY-------------- -->
<div class="modal fade" id="forViewQuestions" tabindex="-1" role="dialog" aria-labelledby="forViewQuestions" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title bg-light font-weight-bold text-primary" id="forViewQuestions">Here is the full details of question:</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
		<div class="myRowBorder" style="padding-left: 10px;">
			<p><span class="font-weight-bold">Replies: </span><span id="view_question_replies" class="font-italic"> Question will be shown here</span></p>
        	<p><span id="" class="font-weight-bold">Name: </span><span id="view_qsn_rep_name" class="font-italic"> Name will be shown here</span></p>
        	<p><span id="" class="font-weight-bold">Email: </span><span id="view_qsn_rep_email" class="font-italic"> Email will be shown here</span></p>
        	<p><span id="" class="font-weight-bold">Upload Date: </span><span id="view_qsn_rep_date" class="font-italic"> Name will be shown here</span></p>
        </div><br>
        <button class="btn btn-primary">Print</button>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
      </div>
    </div>
  </div>
</div>

<!-- ---------------------------VIEWING QSN FINISHED---------------- -->