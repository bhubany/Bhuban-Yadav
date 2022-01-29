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
$qsn_replies=0;
require 'discussion_database.php';
require '../includes/functions.php';


// ------------RECEVING ID's FROM PREVIOUS PAGE-------------
if (isset($_SESSION['discussion_cat_details_id']) and isset($_SESSION['discussion_cat_details_name']) AND isset($_SESSION['discussion_subject_id']) AND isset($_SESSION['discussion_subjects_name'])) {
	$cat_details_id=clean_values($con_discussion,$_SESSION['discussion_cat_details_id']);
	$cat_details_name=clean_values($con_discussion,$_SESSION['discussion_cat_details_name']);
	$discussion_subject_id=clean_values($con_discussion,$_SESSION['discussion_subject_id']);
	$discussion_subjects_name=clean_values($con_discussion,$_SESSION['discussion_subjects_name']);
}else{
	header("Location:discussion_category_details.php");
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
if (clean_values($con_discussion,isset($_POST['del_subject_question']))) {
	$delete_subject_question_id=clean_values($con_discussion,$_POST['delete_subject_question_id']);

	if (empty($delete_subject_question_id)) {
		array_push($errors, "ID is required to delete category");
	}elseif (!is_numeric($delete_subject_question_id)) {
		array_push($errors, "Invalid ID");
	}

	if (count($errors)==0) {
		$del_sub_qsn_query=@"DELETE FROM questions WHERE (id=$delete_subject_question_id AND subject_id='$discussion_subject_id') AND category_id=$cat_details_id LIMIT 1";
		$del_sub_qsn_res=mysqli_query($con_discussion,$del_sub_qsn_query) or die($con_discussion);
		if ($del_sub_qsn_res==1) {
			$Sucess="Questions of Subject =>".$discussion_subjects_name." has been deleted suscessfully presented on id= ".$delete_subject_question_id;
		}
		else{
			array_push($errors, "Error occurs on deleting category of id => ".$delete_subject_question_id);
		}
	}
}

// -------------UPDATE SUBJECTS Questions--------------------
if (clean_values($con_discussion,isset($_POST['update_question']))) {
	$update_discussion_subject_question_id=clean_values($con_discussion,$_POST['update_discussion_subject_question_id']);
	$update_subject_question=clean_values($con_discussion,$_POST['update_subject_question']);

	if (empty($update_discussion_subject_question_id)) {
		array_push($errors, "ID is required to update category");
	}elseif (!is_numeric($update_discussion_subject_question_id)) {
		array_push($errors, "Invalid ID");
	}
	if (empty($update_subject_question)) {
		array_push($errors, "Name is required to update subject");
	}

	if (count($errors)==0) {
		$update_qsn_qry=@"UPDATE questions SET question='$update_subject_question' WHERE (category_id=$cat_details_id AND subject_id=$discussion_subject_id) AND id=$update_discussion_subject_question_id LIMIT 1";
		$update_qsn_res=mysqli_query($con_discussion,$update_qsn_qry) or die($con_discussion);
		if ($update_qsn_res==1) {
			$Sucess="Your Questions of category -> '".$discussion_subjects_name."'' has been updated sucessfully presented on id -> '".$update_discussion_subject_question_id."'";
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
if (clean_values($con_discussion,isset($_POST['view_discussion_subject_question_replies']))) {
	$_SESSION['discussion_subject_question_id']=clean_values($con_discussion,$_POST['view_discussion_subject_question_replies_id']);
	header("Location:discussion_subject_questions_replies.php");
}

	// -----------For Pagination----------
	 if (isset($_GET['pageno'])) {
     	$pageno = $_GET['pageno'];
   	} else {
      	$pageno = 1;
    }

  	$no_of_records_per_page = 10;
  	$starting_from = ($pageno-1) * $no_of_records_per_page;

  	$total_pages_sql = "SELECT * FROM questions WHERE category_id=$cat_details_id AND subject_id=$discussion_subject_id ";
    $result = mysqli_query($con_discussion,$total_pages_sql);
    if (mysqli_num_rows($result)>0) {
    	$total_rows = mysqli_num_rows($result);
    	$total_pages = ceil($total_rows / $no_of_records_per_page);
    }else{
    	$total_pages=1;
    }

// --------------------GETTING ALL DETAILS----------------------
$question_details_qry=@"SELECT * FROM questions WHERE category_id=$cat_details_id AND subject_id=$discussion_subject_id ORDER BY id DESC LIMIT $starting_from,$no_of_records_per_page";
$question_details_res=mysqli_query($con_discussion,$question_details_qry) or die($con_discussion);
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
	<div class="col-lg-10 col-md-10 col-xs-12 myRowBorder" style="border-bottom: none;">

			<!-- -------------------------ADD CATEGORY BTN-------------------- -->
		<div class="row p-2">
			<div class="col-lg-4 col-md-4"></div>
			<div class="col-lg-4 col-md-4 col-xs-12 p-2">
					<button type="button" class="btn btn-primary btn-lg btn-block" data-toggle="modal" data-target="#forAddQuestions">
					Add Questions
				</button>
			</div>
			<div class="col-lg-4 col-md-4"></div>
		</div>

		<!-- ------------------------HEADER---------------------- -->
		<div class="shadow-lg p-1">
			<u  style="color: #1222B5;"><h4 class="text-center">Availables Questions of category ("<?php echo strtoupper($cat_details_name); ?>") and subject ("<?php echo strtoupper($discussion_subjects_name); ?>")</h4></u>
 			<h5 class="text-center text-info">Id of current category is -> <?php echo $cat_details_id; ?> and current subject is -> <?php echo $discussion_subject_id; ?>.</h5>
		</div><br>

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
				<?php if (mysqli_num_rows($question_details_res)>0) { ?>
				<table class="table table-striped">
					<thead class="myHeader" style="color: white;">
						<tr>
							<th class="text-center"><strong>ID</strong></th>
							<th class="text-center"><strong>Questions</strong></th>
							<th class="text-center"><strong>Replies</strong></th>
							<!-- <th class="text-center"><strong>Upload_at<strong></th> -->
							<th></th>
							<th class="text-center"><strong>Action</strong></th>
							<th></th>
						</tr>
					</thead>
					<tbody>
						 <?php while ($question_rows=mysqli_fetch_assoc($question_details_res)) { 
						 	// ----------For Replies------	
						 	$temp_qsn_id=$question_rows['id'];
						 	$replies_qry=@"SELECT * FROM replies WHERE (category_id=$cat_details_id AND subject_id=$discussion_subject_id) AND id=$temp_qsn_id ";
						 	$replies_res=mysqli_query($con_discussion,$replies_qry) or die($con_discussion);
						 	if (mysqli_num_rows($replies_res)>0) {
						 		$qsn_replies=mysqli_num_rows($replies_res);
						 	}else{
						 		$qsn_replies=0;
						 	}

						 	?>
						<tr align="center">
							<td><?php echo $question_rows['id']; ?></td>
							<td><?php echo $question_rows['question']; ?></td>
							<td>
								<form action="" method="post">
						            <input type="hidden" name="view_discussion_subject_question_replies_id" value="<?php echo $question_rows['id']; ?>">
						            <!-- <input type="hidden" name="discussion_subject_name" value="<?php //echo $subject_rows['subject']; ?>"> -->
							    	<button type="submit" class="btn btn-default myLoginBtn" name="view_discussion_subject_question_replies">Replies(<?php echo $qsn_replies; ?>)</button>
							    </form>
							</td>
							<!-- <td><?php //echo $question_rows['trn_date']; ?></td> -->
							<td>
								<button type="button" class="btn btn-primary" data-toggle="modal" data-target="#forUpdateQuestion" onclick="updatequestion('<?php echo $question_rows['id']; ?>')">Edit</button>
							</td>
							 
							<td>
								<button type="button" class="btn btn-info" data-toggle="modal" data-target="#forViewQuestions" onclick="viewquestion('<?php echo $question_rows['id']; ?>')">View</button>
							</td>

							<td>
								<form method="post">
						            <input type="hidden" name="delete_subject_question_id" value="<?php echo $question_rows['id']; ?>">
									<button type="submit" class="btn btn-warning" name="del_subject_question"  onclick="return confirmDel();">Delete</button>
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
	function updatequestion(id) {
		$('#update_discussion_subject_question_id').val(id);

		$.post("getDataForModels.php",{
			update_discussion_subject_question_id:id
		},function(data,status){
			var update_question=JSON.parse(data);
			$('#update_subject_question').val(update_question.question);
		}

			);
		$('#forUpdateQuestion').modal("show");
	}

				// <!-- ------EDITING/UPDATING DETAILS----------- -->
	function viewquestion(id) {
		// $('#view_subject_id').val(id);

		$.post("getDataForModels.php",{
			view_discussion_subject_question_id:id
		},function(data,status){
			var question=JSON.parse(data);
			$('#view_question').html(question.question);
			$('#view_qsn_name').html(question.name);
			$('#view_qsn_email').html(question.email);
			$('#view_qsn_date').html(question.trn_date);
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
        <h5 class="modal-title" id="forUpdateQuestion">Enter New Subject details</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <div class="myForm">
        <!-- <span class="myFormTitle"><h2>Schools/College Login Form</h2></span> -->
            <form action="" method="post">
              <div class="form-group">
              	<input type="hidden" name="update_discussion_subject_question_id" id="update_discussion_subject_question_id">
                  <label for="text">Subject Name:</label>
                  <textarea rows="6" type="text" class="form-control" id="update_subject_question" placeholder="Enter New questions" name="update_subject_question"></textarea>
              </div>
                      <button type="submit" class="btn btn-primary" name="update_question">Update Set</button>
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
			<p><span class="font-weight-bold">Question: </span><span id="view_question" class="font-italic"> Question will be shown here</span></p>
        	<p><span id="" class="font-weight-bold">Name: </span><span id="view_qsn_name" class="font-italic"> Name will be shown here</span></p>
        	<p><span id="" class="font-weight-bold">Email: </span><span id="view_qsn_email" class="font-italic"> Email will be shown here</span></p>
        	<p><span id="" class="font-weight-bold">Upload Date: </span><span id="view_qsn_date" class="font-italic"> Name will be shown here</span></p>
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