<?php
if(!session_id()){
  session_start();
}?>

<?php 
require 'acess.php';
require '../includes/functions.php';
date_default_timezone_set("Asia/Kathmandu");
$upload_date=Date('Y-m-d h:m:s:ms');
$errors=array();
$Sucess="";
require 'admin_database.php';

//---------------
$faq_edit_status=0;
$edit_faq_id="";

//-----------
$edit_faq_question="";
$edit_faq_answer="";

// -----------TO EDIT FAQ DETAILS CHECKING EXISTANCE------------------
if (isset($_POST['edit_faq'])) {
	$edit_faq_id=$_POST['edit_faq_id'];

	if (empty($edit_faq_id)) {
		array_push($errors, "FAQ ID is required to edit details");
	}
	if (count($errors)==0) {
		$edit_faq_qry=@"SELECT * FROM faq WHERE id='$edit_faq_id'";
		$edit_faq_execute=mysqli_query($con_admin,$edit_faq_qry) or die($con_admin);
		if (mysqli_num_rows($edit_faq_execute)==0) {
			array_push($errors, "There is not any FAQ present on the id = ".$edit_faq_id." on the database");
		}
		else{
			$faq_edit_status=1;
			$Sucess="Please enter new details in the form below";
			while ($edit_faq_rows=mysqli_fetch_assoc($edit_faq_execute)) {
				$edit_faq_question=$edit_faq_rows['questions'];
				$edit_faq_answer=$edit_faq_rows['answers'];
				$_SESSION['edit_faq_id']=$edit_faq_rows['id'];
			}
		}
	}
}

//--------------UPDATING FAQ DETAILS TAKING NEW INPUTS----------
if (clean_values($con_admin,isset($_POST['update_faq']))) {
	$edit_faq_id=clean_values($con_admin,$_POST['update_faq_id']);
	$update_faq_question=clean_values($con_admin,$_POST['update_faq_question']);
	$update_faq_answer=clean_values($con_admin,$_POST['update_faq_answer']);

	if (empty($update_faq_question)) {
		array_push($errors, "Please enter FAQ question.");
	}
	if (empty($update_faq_answer)) {
		array_push($errors, "Please enter FAQ answer.");
	}

	if (count($errors)==0) {
		$update_faq_qry=@"UPDATE faq SET questions='$update_faq_question',answers='$update_faq_answer' WHERE id='$edit_faq_id'";
		$update_faq_result=mysqli_query($con_admin,$update_faq_qry) or die($con_admin);
		if ($update_faq_result==1) {
			$Sucess="Your FAQ details has been updated sucessfully presented on ID -> ".$edit_faq_id;
		}
		else{
			array_push($errors, "Error Occurs while updating your details");
		}
		
	}
}

// --------------TO ADD NEW FAQ----------------------
if (isset($_POST['add_faq'])) {
	$add_faq_question=$_POST['add_faq_question'];
	$add_faq_answer=$_POST['add_faq_answer'];

	if (empty($add_faq_question)) {
		array_push($errors, "Please enter FAQ question");
	}
	if (empty($add_faq_answer)) {
		array_push($errors, "Please enter FAQ answer");
	}
	if (count($errors)==0) {
		$add_faq_query=@"INSERT INTO faq(questions,answers,is_active,trn_date)
		VALUES('$add_faq_question','$add_faq_answer','1','$upload_date')";
		$add_faq_result=mysqli_query($con_admin,$add_faq_query) or die($con_admin);
		if ($add_faq_result==1) {
			// header("Refresh:3");
				$Sucess="Your faq has been uploaded sucessfully.";
			
		}else{
			array_push($errors, "Error occurs during adding faq");
		}
	}
}


// ---------------DELETE NOTICE-------------------
if (isset($_POST['del_faq'])) {
	$del_faq_id=$_POST['del_faq_id'];
	// echo $del_album_id;
	if (empty($del_faq_id)) {
		array_push($errors, "ID is required to delete faq");
	}
	$qry_exists_faq=@"SELECT * FROM faq WHERE id='$del_faq_id'";
	$qry_exists_faq_execute=mysqli_query($con_admin,$qry_exists_faq) or die($con_admin);
	if (mysqli_num_rows($qry_exists_faq_execute)==0) {
		array_push($errors, "There is not any faq present on id = ".$del_faq_id." . Check ID correctly and try again.");
	}
	if (count($errors)==0) {
		$del_faq_query=@"DELETE FROM faq WHERE id='$del_faq_id'";
		$del_faq_execute=mysqli_query($con_admin,$del_faq_query) or die($con_admin);
		if ($del_faq_execute==1) {
			$Sucess="FAQ has been deleted suscessfully presented on id= ".$del_faq_id;
			// header("Refresh:3");
		}
		else{
			array_push($errors, "Error occurs on deleting category of id= ".$del_faq_id);
		}
	}
}


// -----------ACTIVATE NOTICE----------
if (isset($_POST['activate_faq'])) {
	$activate_faq_id=$_POST['activate_faq_id'];
	$activate_faq_qry=@"UPDATE faq SET is_active='1' WHERE id='$activate_faq_id' LIMIT 1";
	$activate_faq_execute=mysqli_query($con_admin,$activate_faq_qry) or die($con_admin);
	if ($activate_faq_execute==1) {
		$Sucess="FAQ has been activated suscessfully presented on id= ".$activate_faq_id;
			// header("Refresh:3");
	}
	else{
		array_push($errors, "Error occurs on Activating faq present on id= ".$activate_faq_id);
	}
}


// ------------------DEACTIVATE NOTICE-------------------

if (isset($_POST['deactivate_faq'])) {
	$deactivate_faq_id=$_POST['deactivate_faq_id'];
	$deactivate_faq_qry=@"UPDATE faq SET is_active='0' WHERE id='$deactivate_faq_id' LIMIT 1";
	$deactivate_faq_execute=mysqli_query($con_admin,$deactivate_faq_qry) or die($con_admin);
	if ($deactivate_faq_execute==1) {
		$Sucess="FAQ has been deactivated suscessfully presented on id= ".$deactivate_faq_id;
			// header("Refresh:3");
	}
	else{
		array_push($errors, "Error occurs on Activating faq present on id= ".$deactivate_faq_id);
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

  	$total_pages_sql = "SELECT * FROM faq";
    $result = mysqli_query($con_admin,$total_pages_sql);
    if (mysqli_num_rows($result)>0) {
    	$total_rows = mysqli_num_rows($result);
    	// echo "Total rows => ".$total_rows;
    	$total_pages = ceil($total_rows / $no_of_records_per_page);
    }else{
    	$total_pages=1;
    }

//----------------SELECTING FAQ PRESENT ON DATABASE-----------------
$qry_faq=@"SELECT * FROM faq LIMIT $starting_from,$no_of_records_per_page";
$qry_faq_execute=mysqli_query($con_admin,$qry_faq) or die($con_admin);

?>

<?php include 'heading.php'; ?>
<?php include 'admin_nav.php'; ?>

<head>
	<title>ONLINE ENTRANCE | Gallery Albums admin section</title>
	<script src="assests/js/functions.js" type="text/javascript"></script>
</head>

<style type="text/css">

</style>

<!-- ************************STARTING OF MAIN SECTIONS*********************** -->
<div class="row">
	<div class="col-lg-1 col-md-1"></div>
	<div class="col-lg-10 col-md-10 col-xs-12 myRowBorder">

		<!-- ------------------------HEADER---------------------- -->
		<div class="mySubRowBorder">
			<u  style="color: #1222B5;"><h2 class="text-center">FAQ PRESENT ON DATABASE</h2></u>
 			<h4 class="text-center text-info">FAQ -> Frequently Asked Questions.</h4>
		</div>

			<!-- -------------------------ADD CATEGORY BTN-------------------- -->
		<div class="row">
			<div class="col-lg-4 col-md-4"></div>
			<div class="col-lg-4 col-md-4 col-xs-12 p-2">
					<button type="button" class="btn btn-primary btn-lg btn-block" data-toggle="modal" data-target="#forAddFaq">
					ADD FAQ
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
			<u  style="color: #1222B5;"><h2 class="text-center">FAQ WITH DETAILS</h2></u>
 			<h4 class="text-center text-info">Please check column Action for update and delete .</h4>
		</div>

		<div class="row">
			<div class="col-lg-12 col-md-12 col-xs-12">
				<table class="table table-striped">
					<thead class="myHeader" style="color: white;">
						<tr>
							<th scope="col" class="text-center"><strong>ID</strong></th>
							<th scope="col" class="text-center"><strong>Question<strong></th>
							<th scope="col" class="text-center"><strong>Status</strong></th>
							<th scope="col" class="text-center"><strong>Upload_at</strong></th>
							<th scope="col" class="text-center"></th>
							<th scope="col" class="text-center"><strong>Action</strong></th>
							<th scope="col" class="text-center"></th>
						</tr>
					</thead>
					<tbody>
						 <?php while ($faq_rows=mysqli_fetch_assoc($qry_faq_execute)) { ?>
						<tr align="center">
							<td scope="col"><?php echo $faq_rows['id']; ?></td>
							<td scope="col"><?php echo $faq_rows['questions']; ?></td>

							<td scope="col">
									<?php if($faq_rows['is_active']==1){ ?>
								<form method="post">
							      <input type="hidden" name="deactivate_faq_id" value="<?php echo($faq_rows['id']); ?>">
							      <button type="submit" class="btn btn-danger" name="deactivate_faq">Deactivate</button>
							    </form>	
							    	<?php }else{ ?>
							    <form method="post">
							      <input type="hidden" name="activate_faq_id" value="<?php echo($faq_rows['id']); ?>">
							      <button type="submit" class="btn btn-success" name="activate_faq">Activate</button>
							    </form>
							    	<?php } ?>
								</td>

							<td scope="col"><?php echo $faq_rows['trn_date']; ?></td>
							<td scope="col">
								<button type="button" class="btn btn-primary" data-toggle="modal" data-target="#forUpdateFaq" onclick="editfaq('<?php echo $faq_rows['id']; ?>')">Edit</button>
							</td>

							<td scope="col">
								<button type="button" class="btn btn-info" data-toggle="modal" data-target="#forViewFaq" onclick="viewfaq('<?php echo $faq_rows['id']; ?>')">View</button>
							</td>

							<td scope="col">
								<form method="post">
									<input type="hidden" name="del_faq_id" value="<?php echo $faq_rows['id']; ?>">
									<button type="submit" class="btn btn-warning" name="del_faq"  onclick="return confirmDel();">Delete</button>
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
	function editfaq(id) {
		$('#update_faq_id').val(id);

		$.post("getDataForModels.php",{
			update_id:id
		},function(data,status){
			var faq=JSON.parse(data);
			$('#update_faq_question').val(faq.questions);
			$('#update_faq_answer').val(faq.answers);
		}

			);
		$('#forUpdateFaq').modal("show");
	}


	// ----------VIEWING DETAILS-----------------

	function viewfaq(faq_id){
			// $('#view_faq_id').val(id);

		$.post("getDataForModels.php",{
			view_faq_id:faq_id
		},function(data,status){
			var faq=JSON.parse(data);
			$('#view_faq_question').html(faq.questions);
			$('#view_faq_answer').html(faq.answers);
			$('#view_faq_date').html(faq.trn_date);
		}

			);
		$('#forViewFaq').modal("show");
	}
</script>


<!-- ------------------------FOOTER-------------- -->
<?php include 'footer.php'; ?>

<!-- *****************************ENDING OF MAIN SECTIONS************************* -->

<!-- ..........for adding faq............ -->

<div class="modal fade" id="forAddFaq" tabindex="-1" role="dialog" aria-labelledby="forAddFaq" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="forAddFaq">Adding Frequently Asked Questions </h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <div class="myForm">
        <!-- <span class="myFormTitle"><h2>Schools/College Login Form</h2></span> -->
            <form action="" method="post">
              <div class="form-group">
                  <label for="text">Question:</label>
                  <textarea type="text" class="form-control" id="text" placeholder="Enter Question" name="add_faq_question"></textarea>
              </div>
              <div class="form-group">
                  <label for="text">Answer:</label>
                  <textarea type="text" class="form-control" id="text" placeholder="Enter answer" name="add_faq_answer"></textarea>
              </div>
                      <button type="submit" class="btn btn-primary" name="add_faq">Add Faq</button>
            </form>
        </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
      </div>
    </div>
  </div>
</div>
<!-- .............adding faq finished........... -->


<!-- ..........for updating faq............ -->

<div class="modal fade" id="forUpdateFaq" tabindex="-1" role="dialog" aria-labelledby="forUpdateFaq" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="forUpdateFaq">Updating Frequently Asked Questions</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <div class="myForm">
        <!-- <span class="myFormTitle"><h2>Schools/College Login Form</h2></span> -->
            <form action="" method="post">
              <div class="form-group">
                  <label for="update_faq_question">Question:</label>
                  <textarea type="text" class="form-control" id="update_faq_question" placeholder="Enter Question" name="update_faq_question"></textarea>
              </div>
              <div class="form-group">
                  <label for="update_faq_answer">Answer:</label>
                  <textarea type="text" class="form-control" id="update_faq_answer" placeholder="Enter answer" name="update_faq_answer"></textarea>
              </div>
              <input type="hidden" name="update_faq_id" id="update_faq_id">
                      <button type="submit" class="btn btn-primary" name="update_faq">Update Category</button>
                  
            </form>
        </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
      </div>
    </div>
  </div>
</div>
<!-- .............updating faq finished........... -->

<!-- ..........for viewing faq............ -->

<div class="modal fade" id="forViewFaq" tabindex="-1" role="dialog" aria-labelledby="forViewFaq" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="forViewFaq">Viewing Frequently Asked Questions</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <div class="myRowBorder" style="padding-left: 10px;border-radius: 7px;">
        	<h5 class="text-muted">Question:</h5>
        	<p id="view_faq_question" class="text-info font-italic"> Question will be shown here</p>
        	<h5 class="text-muted">Answer:</h5>
        	<p id="view_faq_answer" class="text-info font-italic">Answer will be shown here</p>
        	<h5 class="text-muted">Upload Date: </h5>
        	<p id="view_faq_date" class="text-info font-italic">2020-3-30</p>
        </div><br>
        <button class="btn btn-primary">Print</button>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
      </div>
    </div>
  </div>
</div>
<!-- .............viewing faq finished........... -->