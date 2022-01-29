<?php
if(!session_id()){
  session_start();
}?>

<?php 
require 'acess.php';
require 'admin_database.php';
require '../includes/functions.php';
date_default_timezone_set("Asia/Kathmandu");
$upload_date=Date('Y-m-d h:m:s:ms');
$errors=array();
$Sucess="";

//----------GETTING VALUES BY SUBMITTING FORM-----------
//------for mark as done------
if (clean_values($con_admin,isset($_POST['mark_as_done']))) {
  $mark_as_done_id=clean_values($con_admin,$_POST['mark_as_done_id']);
  $mark_as_done_name=clean_values($con_admin,$_POST['mark_as_done_name']);

  if (empty($mark_as_done_id) or empty($mark_as_done_name)) {
    array_push($errors, "Invalid feedback ID");
  }elseif (!is_numeric($mark_as_done_id)) {
    array_push($errors, "Invalid feedback ID");
  }
  // ID exists or not
  $qry_exists_feedback=@"SELECT * FROM users_feedback WHERE id=$mark_as_done_id";
  $res_exists_feedback=mysqli_query($con_admin,$qry_exists_feedback) or die($con_admin);
  if (mysqli_num_rows($res_exists_feedback)>0) {
    if (count($errors)==0) {
      $qry_mark_as_done=@"UPDATE users_feedback SET is_action_performed=1 WHERE id=$mark_as_done_id";
      $res_mark_as_done=mysqli_query($con_admin,$qry_mark_as_done) or die($qry_mark_as_done);
      if ($res_mark_as_done==1) {
        $Sucess="Feedback of -> ".$mark_as_done_name." has been marked as done sucessfully presented on ID => ".$mark_as_done_id;
      }else{
        array_push($errors, "Error occurs while performing mark as done.");
      }
    }
  }else{
    array_push($errors, "Error occurs try again later.");
  }
}

//-----------For sending feedback reply----------
if (clean_values($con_admin,isset($_POST['send_user_feedback_reply']))) {
  // echo "Reply message is set";
  $view_user_feedback_reply_message=clean_values($con_admin,$_POST['view_user_feedback_reply_message']);
  // echo "This is the reply message -> ".$feedback_reply_message;
  $view_user_feedback_reply_id=clean_values($con_admin,$_POST['view_user_feedback_reply_id']);

  if (empty($view_user_feedback_reply_id)) {
    array_push($errors, "Invalid feedback ID");
  }elseif (!is_numeric($view_user_feedback_reply_id)) {
    array_push($errors, "Invalid feedback ID");
  }

  if (empty($view_user_feedback_reply_message)) {
    array_push($errors, "Enter valid reply");
  }

  // ----------------EMAIL SENT----------
  $email_sent=1;

  if ($email_sent!=1) {
    array_push($errors, "Error occurs while replying to feedback");
  }

  if (count($errors)==0) {
    $qry_reply_message=@"UPDATE users_feedback SET reply_msg='$view_user_feedback_reply_message',is_action_performed=1 WHERE id=$view_user_feedback_reply_id";
    $res_reply_message=mysqli_query($con_admin,$qry_reply_message) or die($con_admin);
    if ($res_reply_message==1) {
      $Sucess="Reply has been sent sucessfully for feedback presented on id => ".$view_user_feedback_reply_id;
    }else{
      array_push($errors, "Error occurs while replying to feedback");
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

  	$total_pages_sql = "SELECT * FROM users_feedback";
    $result = mysqli_query($con_admin,$total_pages_sql);
    if (mysqli_num_rows($result)>0) {
    	$total_rows = mysqli_num_rows($result);
    	// echo "Total rows => ".$total_rows;
    	$total_pages = ceil($total_rows / $no_of_records_per_page);
    }else{
    	$total_pages=1;
    }

// ___-------------------GETTING ALL DETAILS----------------------
$user_feedbak_qry=@"SELECT * FROM users_feedback ORDER BY id DESC LIMIT $starting_from, $no_of_records_per_page";

// $question_details_qry=@"SELECT * FROM questions_collections WHERE field_id='$cat_details_id' AND question_set='$set_number'";
$user_feedback_execute=mysqli_query($con_admin,$user_feedbak_qry) or die($con_admin);
?>

<?php include 'heading.php'; ?>
<?php include 'admin_nav.php';?>

<head>
	<title>ONLINE ENTRANCE | Categories Available for exam</title>
	<script src="assests/js/functions.js" type="text/javascript"></script>
</head>

<style type="text/css">
	.myPagerBtn{
	border-color: #008DBC;
	background-color: #f2f2f2;
	color: black;
	width: 60px;
}
.myPagerBtn>a{
	text-decoration: none;
}
.myPagerBtn:hover{
	background-color: #09C1FF;
	color: white;
}
</style>

<!-- ********************************STARTING OF MAIN SECTIONS************************************ -->

<div class="row">
	<div class="col-lg-1 col-md-1"></div>
	<div class="col-lg-10 col-md-10 col-xs-12 myRowBorder">

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


<!-- ----------SHOWING ALL THE QUESTIONS ON TABLES------------- -->

<div class="row">
	<div class="col-lg-1 col-md-1"></div>
	<div class="col-lg-10 col-md-10 col-xs-12 myRowBorder">
		<div class="mySubRowBorder">
			<u  style="color: #1222B5;"><h2 class="text-center">Feedbacks / Suggestions / Questions</h2></u>
 			<h4 class="text-center text-info">Please check column Action for update and delete .</h4>
		</div>

		<div class="row">
			<div class="col-lg-12 col-md-12 col-xs-12">
					<?php if (mysqli_num_rows($user_feedback_execute)>0){ ?>
				<table class="table table-striped">
				
					<thead class="myHeader" style="color: white;">
						<tr>
							<th class="text-center"><strong>ID</strong></th>
							<th class="text-center"><strong>Name<strong></th>
							<th class="text-center"><strong>Email</strong></th>	
							<th class="text-center"><strong>Message</strong></th>
							<th class="text-center"><strong>Category</strong></th>	
							<th class="text-center"><strong>Send_at</strong></th>					
							<th></th>
							<th class="text-center"><strong>Action</strong></th>
							<th></th>
						</tr>
					</thead>
					<tbody>
						 <?php while ($feedback_rows=mysqli_fetch_assoc($user_feedback_execute)) { ?>
						<tr align="center">
							<td><?php echo $feedback_rows['id']; ?></td>
							<td><?php echo $feedback_rows['name']; ?></td>
							<td><?php echo $feedback_rows['email']; ?></td>
							<td><?php echo $feedback_rows['feedback']; ?></td>
							<td><?php echo $feedback_rows['feedback_category']; ?></td>
							<td><?php echo $feedback_rows['trn_date']; ?></td>

							<td><?php if ($feedback_rows['is_action_performed']!=1) { ?>
								<form method="post" action="">
									<input type="hidden" name="mark_as_done_id" value="<?php echo($feedback_rows['id']); ?>">
									<input type="hidden" name="mark_as_done_name" value="<?php echo($feedback_rows['name']); ?>">
									<button type="submit" class="btn btn-outline-success border-danger" name="mark_as_done" title="mark message as done">Mark_as_done</button>
								</form>
							<?php }else{ echo "<span class='text-success font-weight-bold'>Done</span>"; }?>
							</td>
							<td>
								<!-- <button type="submit" class="btn btn-primary" name="view_cat_details">Edit</button> -->
								<button type="button" class="btn btn-success" data-toggle="modal" data-target="#forViewFeedback" onclick="viewFeedback('<?php echo $feedback_rows['id']; ?>')">View/Reply</button>
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
			    <!-- <button class="disable">Button</button><button class="active">Button</button> -->

				<?php }else{echo "<h2 class=' alert text-info'>There is not any recent messages.</h2>";} ?>
			</div>
		</div>
	</div>
	<div class="col-lg-1 col-md-1"></div>
</div>

<!-- -----------------AJAX CODES---------------- -->

<script type="text/javascript">

				// <!-- ------EDITING/UPDATING DETAILS----------- -->
	function viewFeedback(id) {
		$('#view_user_feedback_id').val(id);

		$.post("getDataForModels.php",{
			view_user_feedback_id:id
		},function(data,status){
			var view_feedback_details=JSON.parse(data);
			$('#view_user_feedback_category').html(view_feedback_details.feedback_category);
			$('#view_user_feedback_name').html(view_feedback_details.name);
			$('#view_user_feedback_email').html(view_feedback_details.email);
			$('#view_user_feedback_telephone').html(view_feedback_details.telephone);
			$('#view_user_feedback_date').html(view_feedback_details.trn_date);
			$('#view_user_feedback').html(view_feedback_details.feedback);
			$('#view_user_feedback_reply').html(view_feedback_details.reply_msg);
		}

			);
		$('#forViewFeedback').modal("show");
	}
</script>


<!-- ---------------------FOOTER-------------- -->
<?php include 'footer.php'; ?>


<!-- *************************ENDING OF MAIN SECTIONS******************** -->
<!-- ..........for updating Question............ -->

<div class="modal fade" id="forViewFeedback" tabindex="-1" role="dialog" aria-labelledby="forViewFeedback" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <!-- <h5 class="modal-title" id="forAddSet">Add Set</h5><br> -->
        <h5 class="modal-title text-danger" id="forViewFeedback">Please reply to users carefully</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
       <div class="card">
        <div class="card-body">
           <div class="font-italic text-info font-weight-bold pb-4">
           	  <span class="float-left" id="view_user_feedback_category">users category</span><br>
              <span class="float-left" id="view_user_feedback_name">users name</span>
              <span class="float-right" id="view_user_feedback_email">view user email</span><br>
              <span class="float-left" id="view_user_feedback_telephone">View user telephone</span>
              <span class="float-right" id="view_user_feedback_date">users feedback date</span><br>
            </div>

          <div class="p-1 pl-4 text-justify text-info" style="border:solid 1px green;border-radius: 7px;" id="view_user_feedback">View user feedbacks</div><br>
          <div class="p-1 pr-4 text-justify text-right font-italic text-success" style="border:solid 1px blue;border-radius: 7px;" id="view_user_feedback_reply">View feedbacks reply</div>
        </div>
        <!-- /.card-body -->
        <div class="card-footer">
          <form action="" method="post">
            <input type="hidden" name="view_user_feedback_reply_id" id="view_user_feedback_id">
            <div class="form-group">
                <input type="text" name="view_user_feedback_reply_message" placeholder="Type Message ..." class="form-control">
            </div>
                <center><button type="submit" class="btn btn-success" name="send_user_feedback_reply">Send</button></center>
          </form>
        </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
      </div>
    </div>
  </div>
</div>
<!-- .............updating Question finished........... -->
