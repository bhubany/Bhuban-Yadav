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


//--------------GETTING DETAILS FROM PREVIOUS PAGES------------------
if (isset($_POST['view_cat_details'])) {
 	$_SESSION['download_cat_details_name']=$_POST['download_cat_details_name'];
 	$_SESSION['download_cat_details_id']=$_POST['download_cat_details_id'];
 }
 if (!isset($_SESSION['download_cat_details_name']) or !isset($_SESSION['download_cat_details_id'])) {
	header("Location:download_category.php");
}
$download_cat_details_name=$_SESSION['download_cat_details_name'];
$download_cat_details_id=$_SESSION['download_cat_details_id'];



// update_download_cat_details_question update_download_cat_details_answer update_download_cat_details_question_name update_download_cat_details_answer_name update_download_cat_details_set update_download_cat_details_id update_download_cat_details

//--------------UPDATING ALBUMS DETAILS TAKING NEW INPUTS----------
if (isset($_POST['update_download_cat_details'])) {
	$update_download_cat_details_id=$_POST['update_download_cat_details_id'];
	$update_download_cat_details_set=$_POST['update_download_cat_details_set'];
	$update_download_cat_details_answer_name=$_POST['update_download_cat_details_answer_name'];
	$update_download_cat_details_question_name=$_POST['update_download_cat_details_question_name'];
	// $update_album_name=$_POST['update_album_name'];
	$update_extension_question = pathinfo($_FILES["update_download_cat_details_question"]["name"], PATHINFO_EXTENSION);	
	$update_extension_answer = pathinfo($_FILES["update_download_cat_details_answer"]["name"], PATHINFO_EXTENSION);

	$target="../secure/downloads/";	

	$update_download_question="Online Entrance-".Date('Y_m_d_h_m_s_ms').$update_download_cat_details_question_name."-".$download_cat_details_name.".".$update_extension_question;
	$update_download_answer="Online Entrance-".Date('Y_m_d_h_m_s_ms').$update_download_cat_details_answer_name."-".$download_cat_details_name.".".$update_extension_answer;

	if (empty($update_download_cat_details_set)) {
		array_push($errors, "Please enter set number.");
	}

	$edit_download_qry=@"SELECT * FROM downloads WHERE id='$update_download_cat_details_id'";
	$edit_download_execute=mysqli_query($con_admin,$edit_download_qry) or die($con_admin);
	if (mysqli_num_rows($edit_download_execute)==0) {
		array_push($errors, "There is not any downloadable files present on the id = ".$update_download_cat_details_id." on the database");
	}


	if (count($errors)==0) {

		if (empty($update_extension_question) && empty($update_extension_answer)) {
		$update_download_qry=@"UPDATE downloads SET question_set='$update_download_cat_details_set' WHERE id='$update_download_cat_details_id'";
		$update_download_result=mysqli_query($con_admin,$update_download_qry) or die($con_admin);
			if ($update_download_result==1) {
			// header("Refresh:3");
			$Sucess="Your download SET -> '".$update_download_cat_details_set."' details has been updated sucessfully presented on ID -> ".$update_download_cat_details_id;
			}
		}
		elseif (!empty($update_extension_question) && empty($update_extension_answer)) {
			$update_download_qry=@"UPDATE downloads SET questions='$update_download_question',question_set='$update_download_cat_details_set' WHERE id='$update_download_cat_details_id'";
			$update_download_result=mysqli_query($con_admin,$update_download_qry) or die($con_admin);
			if ($update_download_result==1) {
				move_uploaded_file($_FILES["update_download_cat_details_question"]["tmp_name"], $target.$update_download_question);
				// header("Refresh:3");
				$Sucess="Your download SET -> '".$update_download_cat_details_set."' details has been updated sucessfully presented on ID -> ".$update_download_cat_details_id;
			}
		}
		elseif (empty($update_extension_question) && !empty($update_extension_answer)) {
			$update_download_qry=@"UPDATE downloads SET answers='$update_download_answer',question_set='$update_download_cat_details_set' WHERE id='$update_download_cat_details_id'";
			$update_download_result=mysqli_query($con_admin,$update_download_qry) or die($con_admin);
			if ($update_download_result==1) {
				move_uploaded_file($_FILES["update_download_cat_details_answer"]["tmp_name"], $target.$update_download_answer);
				// header("Refresh:3");
				$Sucess="Your download SET -> '".$update_download_cat_details_set."' details has been updated sucessfully presented on ID -> ".$update_download_cat_details_id;
			}
		}
		elseif (!empty($update_extension_question) && !empty($update_extension_answer)) {
			$update_download_qry=@"UPDATE downloads SET questions='$update_download_question',answers='$update_download_answer',question_set='$update_download_cat_details_set' WHERE id='$update_download_cat_details_id'";
			$update_download_result=mysqli_query($con_admin,$update_download_qry) or die($con_admin);
			if ($update_download_result==1) {
				move_uploaded_file($_FILES["update_download_cat_details_question"]["tmp_name"], $target.$update_download_question);
				move_uploaded_file($_FILES["update_download_cat_details_answer"]["tmp_name"], $target.$update_download_answer);
				// header("Refresh:3");
				$Sucess="Your download SET -> '".$update_download_cat_details_set."' details has been updated sucessfully presented on ID -> ".$update_download_cat_details_id;
			}
		}
		else{
			array_push($errors, "Error Occurs while updating your details");
		}
	}
}
		

// --------------TO ADD ----------------------
if (isset($_POST['add_download_cat_details'])) {
	$add_download_cat_details_question_name=$_POST['add_download_cat_details_question_name'];
	$add_download_cat_details_answer_name=$_POST['add_download_cat_details_answer_name'];
	$add_download_cat_details_set=$_POST['add_download_cat_details_set'];

	$extension_question = pathinfo($_FILES["add_download_cat_details_question"]["name"], PATHINFO_EXTENSION);
	$extension_answer = pathinfo($_FILES["add_download_cat_details_answer"]["name"], PATHINFO_EXTENSION);

	$target="../secure/downloads/";

	$add_download_question="Online Entrance-".Date('Y_m_d_h_m_s_ms').$add_download_cat_details_question_name."-".$download_cat_details_name.".".$extension_question;
	$add_download_answer="Online Entrance-".Date('Y_m_d_h_m_s_ms').$add_download_cat_details_answer_name."-".$download_cat_details_name.".".$extension_answer;

	move_uploaded_file($_FILES["add_download_cat_details_question"]["tmp_name"], $target.$add_download_question);
	move_uploaded_file($_FILES["add_download_cat_details_answer"]["tmp_name"], $target.$add_download_answer);

	if (empty($add_download_cat_details_question_name)) {
		array_push($errors, "Please enter file name containing question");
	}
	if (empty($add_download_cat_details_answer_name)) {
		array_push($errors, "Please enter file name containing answer");
	}
	if (empty($add_download_cat_details_set)) {
		array_push($errors, "Please enter set number");
	}
	if (empty($extension_question)) {
		array_push($errors, "Please select question file to upload.");
	}
	if (empty($extension_answer)) {
		array_push($errors, "Please select answer file to upload.");
	}

	if (count($errors)==0) {
	$add_download_cat_details_query=@"INSERT INTO downloads(field_id,questions,question_set,answers,is_active,trn_date)
	VALUES('$download_cat_details_id','$add_download_question','$add_download_cat_details_set','$add_download_answer','1','$upload_date')";
	$add_download_cat_details_result=mysqli_query($con_admin,$add_download_cat_details_query) or die($con_admin);
	if ($add_download_cat_details_result==1) {
			$Sucess="Your question and answer file of SET -> '".$add_download_cat_details_set."' has been uploaded sucessfully";
			
		}
	else{
		array_push($errors, "Error occurs during adding file");
	}
	}
}


// ---------------DELETE NOTICE-------------------
if (isset($_POST['del_download_cat_details'])) {
	$del_download_cat_details_id=$_POST['del_download_cat_details_id'];
	$del_download_cat_details_name=$_POST['del_download_cat_details_name'];
	if (empty($del_download_cat_details_id)) {
		array_push($errors, "ID is required to delete doqnloads.");
	}
	$qry_exists_download_cat_details=@"SELECT * FROM downloads WHERE id='$del_download_cat_details_id' AND field_id='$download_cat_details_id'";
	$qry_exists_download_cat_details_execute=mysqli_query($con_admin,$qry_exists_download_cat_details) or die($con_admin);
	if (mysqli_num_rows($qry_exists_download_cat_details_execute)==0) {
		array_push($errors, "There is not any downloads present on id = ".$del_download_cat_details_id." . Check ID correctly and try again.");
	}
	if (count($errors)==0) {
		$del_download_cat_details_query=@"DELETE FROM downloads WHERE id='$del_download_cat_details_id' AND field_id='$download_cat_details_id'";
		$del_download_cat_details_execute=mysqli_query($con_admin,$del_download_cat_details_query) or die($con_admin);
		if ($del_download_cat_details_execute==1) {
			$Sucess="SET -> '".$del_download_cat_details_name."' has been deleted suscessfully presented on id= ".$del_download_cat_details_id;
		}
		else{
			array_push($errors, "Error occurs on deleting category of id= ".$del_download_cat_details_id);
		}
	}
}


// -----------ACTIVATE NOTICE----------
if (isset($_POST['activate_download_cat_details'])) {
	$activate_download_cat_details_id=$_POST['activate_download_cat_details_id'];
	$activate_download_cat_details_name=$_POST['activate_download_cat_details_name'];
	$activate_download_cat_details_qry=@"UPDATE downloads SET is_active='1' WHERE id='$activate_download_cat_details_id' LIMIT 1";
	$activate_download_cat_details_execute=mysqli_query($con_admin,$activate_download_cat_details_qry) or die($con_admin);
	if ($activate_download_cat_details_execute==1) {
		$Sucess ="SET -> '".$activate_download_cat_details_name."' has been activated suscessfully presented on id= ".$activate_download_cat_details_id;
	}
	else{
		array_push($errors, "Error occurs on Activating image present on id= ".$activate_download_cat_details_id);
	}
}


// ------------------DEACTIVATE NOTICE-------------------

if (isset($_POST['deactivate_download_cat_details'])) {
	$deactivate_download_cat_details_id=$_POST['deactivate_download_cat_details_id'];
	$deactivate_download_cat_details_name=$_POST['deactivate_download_cat_details_name'];
	$deactivate_download_cat_details_qry=@"UPDATE downloads SET is_active='0' WHERE id='$deactivate_download_cat_details_id' LIMIT 1";
	$deactivate_download_cat_details_execute=mysqli_query($con_admin,$deactivate_download_cat_details_qry) or die($con_admin);
	if ($deactivate_download_cat_details_execute==1) {
		$Sucess="SET -> '".$deactivate_download_cat_details_name."' has been deactivated suscessfully presented on id= ".$deactivate_download_cat_details_id;
	}
	else{
		array_push($errors, "Error occurs on Activating image present on id= ".$deactivate_download_cat_details_id);
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

  	$total_pages_sql = "SELECT * FROM downloads WHERE field_id='$download_cat_details_id'";
    $result = mysqli_query($con_admin,$total_pages_sql);
    if (mysqli_num_rows($result)>0) {
    	$total_rows = mysqli_num_rows($result);
    	// echo "Total rows => ".$total_rows;
    	$total_pages = ceil($total_rows / $no_of_records_per_page);
    }else{
    	$total_pages=1;
    }

//----------------SELECTING IMAGES PRESENT ON THAT ID-----------------
$qry_download_cat_details=@"SELECT * FROM downloads WHERE field_id='$download_cat_details_id'";
$qry_download_cat_details_execute=mysqli_query($con_admin,$qry_download_cat_details) or die($con_admin);


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
	width: 200px;
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
			<u  style="color: #1222B5;"><h2 class="text-center">All QUESTIONS AND ANSWERS PRESENT ON CATEGORY '<?php echo strtoupper($download_cat_details_name); ?>'</h2></u>
 			<h4 class="text-center text-warning">Unique ID for this category is -> <?php echo $download_cat_details_id; ?></h4>
		</div>

			<!-- -------------------------ADD CATEGORY BTN-------------------- -->
		<div class="row">
			<div class="col-lg-4 col-md-4"></div>
			<div class="col-lg-4 col-md-4 col-xs-12 p-2">
					<button type="button" class="btn btn-primary btn-lg btn-block" data-toggle="modal" data-target="#forAddDownload">
					UPLOAD FILES
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


<!-- --------------SHOWING ALL THE DETAILS PRESENT ON THAT ALBUM----------- -->
<div class="row">
  <div class="col-lg-1 col-md-1"></div>
  <div class="col-lg-10 col-md-10 col-xs-12 myRowBorder">
    <!-- <div class="mySubRowBorder">
      <u  style="color: #1222B5;"><h2 class="text-center">FAQ WITH DETAILS</h2></u>
      <h4 class="text-center text-info">Please check column Action for update and delete .</h4>
    </div> -->

    <div class="row">
      <div class="col-lg-12 col-md-12 col-xs-12">
        <table class="table table-striped">
          <thead class="myHeader" style="color: white;">
            <tr>
              <th class="text-center"><strong>ID</strong></th>
              <th class="text-center"><strong>Question<strong></th>
              <th class="text-center"><strong>Answer</strong></th>
              <th class="text-center"><strong>Set</strong></th>
              <th class="text-center"><strong>Status</strong></th>
              <th class="text-center"><strong>Upload_at</strong></th>
              <th class="text-center"><strong>Actions</strong></th>
              <th></th>
            </tr>
          </thead>
          <tbody>
             <?php while ($download_cat_details_rows=mysqli_fetch_assoc($qry_download_cat_details_execute)) { ?>
            <tr align="center">
              <td><?php echo $download_cat_details_rows['id']; ?></td>
              <td><a download="" href="../secure/downloads/<?php echo($download_cat_details_rows['questions']);?>"><?php echo $download_cat_details_rows['questions']; ?></a></td>
  			  <td><a download="" href="../secure/downloads/<?php echo($download_cat_details_rows['answers']);?>"><?php echo $download_cat_details_rows['answers']; ?></a></td>
  			  <td>SET <?php echo $download_cat_details_rows['question_set']; ?></td>
  			  <td>
  			  		<?php if($download_cat_details_rows['is_active']){ ?>
  			  	<form method="post">
                    <input type="hidden" name="deactivate_download_cat_details_id" value="<?php echo($download_cat_details_rows['id']); ?>">
                    <input type="hidden" name="deactivate_download_cat_details_name" value="<?php echo($download_cat_details_rows['question_set']); ?>">
                    <button type="submit" class="btn btn-danger" name="deactivate_download_cat_details">Deactivate</button>
                  </form> 

                    <?php }else{ ?>

                  <form method="post">
                    <input type="hidden" name="activate_download_cat_details_id" value="<?php echo($download_cat_details_rows['id']); ?>">
                    <input type="hidden" name="activate_download_cat_details_name" value="<?php echo($download_cat_details_rows['question_set']); ?>">
                    <button type="submit" class="btn btn-success" name="activate_download_cat_details">Activate</button>
                  </form>
                    <?php } ?>
  			  </td>
              <td><?php echo $download_cat_details_rows['trn_date']; ?></td>
              <td>
                <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#forUpdateDownload" onclick="updateDownload('<?php echo $download_cat_details_rows['id']; ?>')">Edit</button>
              </td>

              <td>
                <form method="post">
                  <input type="hidden" name="del_download_cat_details_id" value="<?php echo $download_cat_details_rows['id']; ?>">
                  <input type="hidden" name="del_download_cat_details_name" value="<?php echo $download_cat_details_rows['question_set']; ?>">
                  <button type="submit" class="btn btn-danger" name="del_download_cat_details"  onclick="return confirmDel();">Delete</button>
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

<!-- ---------------------------AJAX CODES------------------ -->
<script type="text/javascript">

				// <!-- ------EDITING/UPDATING DETAILS----------- -->
	function updateDownload(id) {
		$('#update_download_cat_details_id').val(id);

		$.post("getDataForModels.php",{
			update_download_id:id
		},function(data,status){
			var download=JSON.parse(data);
			$('#update_download_cat_details_set').val(download.question_set);
		}

			);
		$('#forUpdateDownload').modal("show");
	}
     
</script>

<?php include 'footer.php'; ?>

<!-- *****************ENDING OF MAIN SECTIONS************** -->

<!-- ..........for adding New Notice............ -->

<div class="modal fade" id="forAddDownload" tabindex="-1" role="dialog" aria-labelledby="forAddDownload" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="forAddDownload">Adding New Question And Answer Files</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <div class="myForm">
            <form method="post" action="" enctype="multipart/form-data">
              <div class="form-group">
                  <label for="text">Select Question File:</label>
                  <input type="file" class="form-control" id="file" name="add_download_cat_details_question">
              </div>
              <div class="form-group">
                  <label for="text">Select Answer File:</label>
                  <input type="file" class="form-control" id="file" name="add_download_cat_details_answer">
              </div>
              <div class="form-group">
                  <label for="text">Question File Name:</label>
                  <input type="text" class="form-control" id="file" name="add_download_cat_details_question_name" placeholder="Enter file name for question">
              </div>
              <div class="form-group">
                  <label for="text">Answer File Name:</label>
                  <input type="text" class="form-control" id="file" name="add_download_cat_details_answer_name" placeholder="Enter file name for answer">
              </div>
              <div class="form-group">
                  <label for="text">SET Number:</label>
                  <input type="number" class="form-control" id="file" name="add_download_cat_details_set" placeholder="Enter Set number">
              </div>
                      <button type="submit" class="btn btn-primary" name="add_download_cat_details">Upload Downloads</button>
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

<div class="modal fade" id="forUpdateDownload" tabindex="-1" role="dialog" aria-labelledby="forUpdateDownload" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="forUpdateDownload">Enter New Customer Name</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <div class="myForm">
        	<form method="post" action="" enctype="multipart/form-data">
              <div class="form-group">
                  <label for="update_download_cat_details_question">Select Question File:</label>
                  <input type="file" class="form-control" id="update_download_cat_details_question" name="update_download_cat_details_question">
              </div>
              <div class="form-group">
                  <label for="update_download_cat_details_answer">Select Answer File:</label>
                  <input type="file" class="form-control" id="update_download_cat_details_answer" name="update_download_cat_details_answer">
              </div>
              <div class="form-group">
                  <label for="update_download_cat_details_question_name">Question File Name:</label>
                  <input type="text" class="form-control" id="update_download_cat_details_question_name" name="update_download_cat_details_question_name" placeholder="Enter file name for question">
              </div>
              <div class="form-group">
                  <label for="update_download_cat_details_answer_name">Answer File Name:</label>
                  <input type="text" class="form-control" id="update_download_cat_details_answer_name" name="update_download_cat_details_answer_name" placeholder="Enter file name for answer">
              </div>
              <div class="form-group">
                  <label for="update_download_cat_details_set">SET Number:</label>
                  <input type="number" class="form-control" id="update_download_cat_details_set" name="update_download_cat_details_set" placeholder="Enter Set number">
              </div>
              		<input type="hidden" name="update_download_cat_details_id" id="update_download_cat_details_id">
                    <button type="submit" class="btn btn-primary" name="update_download_cat_details">Upload Downloads</button>
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


