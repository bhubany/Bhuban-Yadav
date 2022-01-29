<?php
if(!session_id()){
  session_start();
}?>

<?php 
date_default_timezone_set("Asia/Kathmandu");
$now=date("Y-m-d H:i:s");
$errors=array();
$Sucess='';
$full_name='';
$total_user_count='';
$total_exam_taken="";
$email_sent='';
$i=0;
$feedback_num=0;
require 'admin_database.php';
require 'user_database.php';
require '../includes/functions.php';

//-----For total user
$user_query=@"SELECT * FROM user_information";
$user_res=mysqli_query($con_user,$user_query) or die($con_user);
if (mysqli_num_rows($user_res)>0) {
  $total_user_count=mysqli_num_rows($user_res);
// echo $user_count;
  while ($user_rows=mysqli_fetch_assoc($user_res)) {
    $will_expired = date("Y-m-d H:i:s",strtotime('-7 day +0 hour +0 minutes +0 seconds',strtotime($now)));
  // echo $will_expired;
    if ($will_expired<=$user_rows['created_at']) {
      $i=$i+1;
    }
  }
}
// echo "This is the reply message -> ".$feedback_reply_message;
// echo "Reply message is not set";

//-----------For sending feedback reply----------
if (clean_values($con_admin,isset($_POST['send_feedback_reply']))) {
  // echo "Reply message is set";
  $feedback_reply_message=clean_values($con_admin,$_POST['feedback_reply_message']);
  // echo "This is the reply message -> ".$feedback_reply_message;
  $feedback_reply_id=clean_values($con_admin,$_POST['feedback_reply_id']);

  if (empty($feedback_reply_id)) {
    array_push($errors, "Invalid feedback ID");
  }elseif (!is_numeric($feedback_reply_id)) {
    array_push($errors, "Invalid feedback ID");
  }

  if (empty($feedback_reply_message)) {
    array_push($errors, "Enter valid reply");
  }

  // ----------------EMAIL SENT----------
  $email_sent=1;

  if ($email_sent!=1) {
    array_push($errors, "Error occurs while replying to feedback");
  }

  if (count($errors)==0) {
    $qry_reply_message=@"UPDATE users_feedback SET reply_msg='$feedback_reply_message',is_action_performed=1 WHERE id=$feedback_reply_id";
    $res_reply_message=mysqli_query($con_admin,$qry_reply_message) or die($con_admin);
    if ($res_reply_message==1) {
      $Sucess="Feedback has been sent sucessfully presented on id => ".$feedback_reply_id;
    }else{
      array_push($errors, "Error occurs while replying to feedback");
    }
  }
}

//------for mark as done------
if (clean_values($con_admin,isset($_POST['mark_feedback_is_done']))) {
  $feedback_id=clean_values($con_admin,$_POST['feedback_id']);
  if (empty($feedback_id)) {
    array_push($errors, "Invalid feedback ID");
  }elseif (!is_numeric($feedback_id)) {
    array_push($errors, "Invalid feedback ID");
  }
  // ID exists or not
  $qry_exists_feedback=@"SELECT * FROM users_feedback WHERE id=$feedback_id";
  $res_exists_feedback=mysqli_query($con_admin,$qry_exists_feedback) or die($con_admin);
  if (mysqli_num_rows($res_exists_feedback)>0) {
    if (count($errors)==0) {
      $qry_mark_as_done=@"UPDATE users_feedback SET is_action_performed=1 WHERE id=$feedback_id";
      $res_mark_as_done=mysqli_query($con_admin,$qry_mark_as_done) or die($qry_mark_as_done);
      if ($res_mark_as_done==1) {
        $Sucess="Feedback has been marked as done sucessfully presented on ID => ".$feedback_id;
      }else{
        array_push($errors, "Error occurs while performing mark as done.");
      }
    }
  }else{
    array_push($errors, "Error occurs try again later.");
  }
}

//-------for total test takens-----
$test_query=@"SELECT * FROM user_exam_details";
$test_res=mysqli_query($con_user,$test_query);
if (mysqli_num_rows($test_res)>0) {
  $total_exam_taken=mysqli_num_rows($test_res);
}


//----------------SELECTING IMAGES PRESENT ON THAT ID-----------------
$qry_course_available=@"SELECT * FROM courses_available";
$qry_course_available_execute=mysqli_query($con_admin,$qry_course_available) or die($con_admin);
 ?>

<?php include 'heading.php' ?>
<?php include 'admin_nav.php'; ?>

<head>
  <title>ONLINE ENTRANCE | ADMIN PANEL</title>
 <!--  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script> -->
  <script src="assests/js/functions.js" type="text/javascript"></script>
</head>
<style>

</style>
</head>

<!-- ------------1st main row--------- -->

<div class="row">
  <div class="col-lg-1 col-md-1"></div>
  <div class="col-sm-12 col-lg-10 col-md-10 col-xs-12 myRowBorder">
    <div class="row shadow-lg">
      <div class="col-lg-3 col-6">
        <!-- small box -->
        <div class="small-box bg-info">
          <div class="inner">
            <h3><?php echo $total_user_count; ?></h3>

            <p>User Registered</p>
          </div>
          <div class="icon">
            <i class="ion ion-bag"></i>
          </div>
          <a href="all_users.php" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
        </div>
      </div>
      <!-- ./col -->
      <div class="col-lg-3 col-6">
        <!-- small box -->
        <div class="small-box bg-success">
          <div class="inner">
            <h3><?php echo $total_exam_taken; ?><sup style="font-size: 20px">%</sup></h3>

            <p>Today Visiters</p>
          </div>
          <div class="icon">
            <i class="ion ion-stats-bars"></i>
          </div>
          <a href="#" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
        </div>
      </div>
      <!-- ./col -->
      <div class="col-lg-3 col-6">
        <!-- small box -->
        <div class="small-box bg-warning">
          <div class="inner">
            <h3><?php echo $total_exam_taken; ?></h3>

            <p>Test Takens</p>
          </div>
          <div class="icon">
            <i class="ion ion-person-add"></i>
          </div>
          <a href="test_taken.php" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
        </div>
      </div>
      <!-- ./col -->
      <div class="col-lg-3 col-6">
        <!-- small box -->
        <div class="small-box bg-danger">
          <div class="inner">
            <h3>65</h3>

            <p>Discussed Questions</p>
          </div>
          <div class="icon">
            <i class="ion ion-pie-graph"></i>
          </div>
          <a href="#" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
        </div>
      </div>
      <!-- ./col -->
    </div>
  </div>
  <div class="col-sm-1 col-lg-1 col-md-1"></div>
</div>

<!-- ---------FOR ERROR/SUCCESS MESSAGE----------- -->
<div class="row"><br>
  <div class="col-lg-1 col-md-1"></div>
  <div class="col-sm-12 col-lg-10 col-md-10 col-xs-12 myRowBorder">
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

<?php 
    // -------------For feedbacks------
   if (isset($_GET['feedbackno'])) {
      $feedbackno = $_GET['feedbackno'];
    } else {
        $feedbackno = 1;
    }

    $no_of_records_per_page = 1;
    $starting_from = ($feedbackno-1) * $no_of_records_per_page;

    $total_pages_feedback = @"SELECT * FROM users_feedback WHERE is_action_performed=0";
    $result_feedback = mysqli_query($con_admin,$total_pages_feedback);
    if (mysqli_num_rows($result_feedback)>0) {
      $total_rows_feedback = mysqli_num_rows($result_feedback);
      // echo "Total rows => ".$total_rows;
      $total_pages_feb = ceil($total_rows_feedback / $no_of_records_per_page);
    }else{
      $total_pages_feb=1;
    }
    $total_feedback_qry=@"SELECT * FROM users_feedback WHERE is_action_performed=0";
    $total_feedback_res=mysqli_query($con_admin,$total_feedback_qry) or die($con_admin);
    if (mysqli_num_rows($total_feedback_res)>0) {
          $feedback_num=mysqli_num_rows($total_feedback_res);
    }else{
      $feedback_num=0;
    }
    $sel_feedback_qry=@"SELECT * FROM users_feedback WHERE is_action_performed=0 ORDER BY id DESC LIMIT $starting_from,1";
    $sel_feedback_res=mysqli_query($con_admin,$sel_feedback_qry) or die($con_admin);

 ?>

<!-- -----------main second row--------- -->
<div class="row"><br>
  <div class="col-lg-1 col-md-1"></div>
  <div class="col-sm-12 col-lg-10 col-md-10 col-xs-12 myRowBorder">
    <div class="row">
    <div class="col-sm-6 col-md-6 col-lg-6 col-xs-6">
      <div class="card">
        <?php if (mysqli_num_rows($sel_feedback_res)>0) {
              while ($fedback_rows=mysqli_fetch_assoc($sel_feedback_res)) { ?>
        <div class="card-header bg-light">
          <form method="post" action="">
            <input type="hidden" name="feedback_id" value="<?php echo($fedback_rows['id']); ?>">
          <h3 class="card-title shadow-lg text-center p-2 text-secondary" style="border-radius: 10px;">Feedbacks / Suggestions / Questions</h3>
          <div class="card-tools">
            <span class="btn btn-outline-dark" title="<?php echo($fedback_rows['feedback_category']); ?>"><span class="font-weight-bold">Category : </span><span class="font-italic"><?php echo $fedback_rows['feedback_category']; ?></span></span>
            <a href="#" class="small-box-footer pull-right btn btn-outline-dark border-light ml-2" style="text-decoration: none;" title="New feedbacks"><i class="fas fa-envelope"></i><sup class="bg-danger text-white pl-1 pr-1 ml-1" style="border-radius: 5px;"><?php echo $feedback_num; ?></sup></a>
            <button type="submit" name="mark_feedback_is_done" class="small-box-footer pull-right btn btn-outline-success border-success" title="mark as done">Mark as done <i class="fas fa-check"></i></button>

              <!-- <button type="button" class="btn btn-tool" data-card-widget="collapse"><i class="fas fa-arrow-alt-circle-left"></i></button> -->
              <!-- <button type="button" class="btn btn-tool" data-toggle="tooltip" title="Contacts" data-widget="chat-pane-toggle"><i class="fas fa-comments"></i></button> -->
              <!-- <button type="button" class="btn btn-tool" data-card-widget="remove"><i class="fas fa-arrow-alt-circle-right"></button> -->
          </div>
          </form>
        </div>
          <!-- /.card-header -->
        <div class="card-body">
           <div class="font-italic text-info font-weight-bold pb-4">
              <sub class="direct-chat-name float-left"><?php echo $fedback_rows['name']; ?></sub>
              <sub class="direct-chat-timestamp float-right"><?php echo $fedback_rows['trn_date']; ?></sub>
              <sub class="direct-chat"><a style="text-decoration: none;padding-left: 150px;" href="tel:<?php echo $fedback_rows['telephone']; ?>"><?php echo $fedback_rows['telephone']; ?></a></sub>
              <sub class="direct-chat"><a style="text-decoration: none;padding-left: 20px;" href="mailto:<?php echo $fedback_rows['email']; ?>"><?php echo $fedback_rows['email']; ?></a></sub>
            </div>

          <div class="p-1 pl-4 text-justify" style="border:solid 1px green;border-radius: 7px;">
            <?php echo $fedback_rows['feedback']; ?>
          </div>
        </div>
        <!-- /.card-body -->
        <div class="card-footer">
          <form action="" method="post">
            <input type="hidden" name="feedback_reply_id" value="<?php echo($fedback_rows['id']); ?>">
            <div class="form-group">
                <!-- <label for="text" class="font-weight-bold">Email or Username:</label> -->
                <input type="text" name="feedback_reply_message" placeholder="Type Message ..." class="form-control">
            </div>
                <center><button type="submit" class="btn btn-success" name="send_feedback_reply">Send</button></center>
          </form>
          <!-- -------viewing full details---- -->
          <div class="pb-2 pt-2">
            <!-- -----------Pagination--------- -->
            <a href="<?php if($feedbackno <= 1){ echo '#'; } else { echo "?feedbackno=".($feedbackno - 1); } ?>" class="small-box-footer btn btn-outline-info border-info <?php if($feedbackno <= 1){ echo 'disabled'; } ?>" style="text-decoration: none;"><i class="fas fa-arrow-circle-left"></i> Previous</a>
            <a href="<?php if($feedbackno > $total_pages_feb){ echo '#'; } else { echo "?feedbackno=".($feedbackno + 1); } ?>" class="small-box-footer btn btn-outline-info border-info pull-right <?php if($feedbackno >= $total_pages_feb){ echo 'disabled'; } ?>" style="text-decoration: none;">Next <i class="fas fa-arrow-circle-right"></i></a>
          </div>
          <div class="small-box bg-info">
            <div class="icon">
              <i class="ion ion-bag"></i>
            </div>
            <a href="all_feedbacks.php" class="small-box-footer">See All <i class="fas fa-arrow-circle-right"></i></a>
          </div>
        </div>
        <!-- /.card-footer-->
      <?php } }else{echo "<h2 class='text-info font-italic'>There is not any new feedbacks / category / questions .</h2>";} ?>
      </div>
    </div>
    <div class="col-sm-6 col-md-6 col-lg-6 col-xs-6">
      <span>This is for calendar</span>
    </div>
  </div>
    <!-- </div> -->
  </div>
  <div class="col-lg-1 col-md-1"></div>
</div>

 <!-- -----------main Third row--------- -->
<div class="row"><br>
  <div class="col-lg-1 col-md-1"></div>
  <div class="col-sm-12 col-lg-10 col-md-10 col-xs-12 myRowBorder">
    <div class="row">
      <div class="col-sm-6 col-md-6 col-lg-6 col-xs-6 myRowBorder">
        <div class="card">
        <div class="card-header bg-light">
          <form method="post" action="">
            <input type="hidden" name="feedback_id" value="<?php //echo($fedback_rows['id']); ?>">
          <h3 class="card-title shadow-lg text-center p-2 text-secondary" style="border-radius: 10px;">To do Lists</h3>
          <div class="card-tools">
            <span class="btn btn-outline-dark" title="<?php //echo($fedback_rows['feedback_category']); ?>"><span class="font-weight-bold">Category : </span><span class="font-italic"><?php //echo $fedback_rows['feedback_category']; ?></span></span>
            <a href="#" class="small-box-footer pull-right btn btn-outline-dark border-light ml-2" style="text-decoration: none;" title="New feedbacks"><i class="fas fa-envelope"></i><sup class="bg-danger text-white pl-1 pr-1 ml-1" style="border-radius: 5px;"><?php //echo $feedback_num; ?></sup></a>
            <button type="submit" name="mark_feedback_is_done" class="small-box-footer pull-right btn btn-outline-success border-success" title="mark as done">Mark as done <i class="fas fa-check"></i></button>

              <!-- <button type="button" class="btn btn-tool" data-card-widget="collapse"><i class="fas fa-arrow-alt-circle-left"></i></button> -->
              <!-- <button type="button" class="btn btn-tool" data-toggle="tooltip" title="Contacts" data-widget="chat-pane-toggle"><i class="fas fa-comments"></i></button> -->
              <!-- <button type="button" class="btn btn-tool" data-card-widget="remove"><i class="fas fa-arrow-alt-circle-right"></button> -->
          </div>
          </form>
        </div>
          <!-- /.card-header -->
        <div class="card-body">
           <div class="font-italic text-info font-weight-bold pb-4">
              <sub class="direct-chat-name float-left"><?php //echo $fedback_rows['name']; ?></sub>
              <sub class="direct-chat-timestamp float-right"><?php //echo $fedback_rows['trn_date']; ?></sub>
              <sub class="direct-chat"><a style="text-decoration: none;padding-left: 150px;" href="tel:<?php //echo $fedback_rows['telephone']; ?>"><?php //echo $fedback_rows['telephone']; ?></a></sub>
              <sub class="direct-chat"><a style="text-decoration: none;padding-left: 20px;" href="mailto:<?php //echo $fedback_rows['email']; ?>"><?php //echo $fedback_rows['email']; ?></a></sub>
            </div>

          <div class="p-1 pl-4 text-justify" style="border:solid 1px green;border-radius: 7px;">
            <?php //echo $fedback_rows['feedback']; ?>
          </div>
        </div>
        <!-- /.card-body -->
        <div class="card-footer">
          <form action="" method="post">
            <input type="hidden" name="feedback_reply_id" value="<?php //echo($fedback_rows['id']); ?>">
            <div class="form-group">
                <!-- <label for="text" class="font-weight-bold">Email or Username:</label> -->
                <input type="text" name="feedback_reply_message" placeholder="Type Message ..." class="form-control">
            </div>
                <center><button type="submit" class="btn btn-success" name="send_feedback_reply">Send</button></center>
          </form>
          <!-- -------viewing full details---- -->
          <div class="pb-2 pt-2">
            <!-- -----------Pagination--------- -->
            <a href="<?php //if($feedbackno <= 1){ echo '#'; } else { echo "?feedbackno=".($feedbackno - 1); } ?>" class="small-box-footer btn btn-outline-info border-info <?php //if($feedbackno <= 1){ echo 'disabled'; } ?>" style="text-decoration: none;"><i class="fas fa-arrow-circle-left"></i> Previous</a>
            <a href="<?php //if($feedbackno > $total_pages_feb){ echo '#'; } else { echo "?feedbackno=".($feedbackno + 1); } ?>" class="small-box-footer btn btn-outline-info border-info pull-right <?php// if($feedbackno >= $total_pages_feb){ echo 'disabled'; } ?>" style="text-decoration: none;">Next <i class="fas fa-arrow-circle-right"></i></a>
          </div>
          <div class="small-box bg-info">
            <div class="icon">
              <i class="ion ion-bag"></i>
            </div>
            <a href="all_feedbacks.php" class="small-box-footer">See All <i class="fas fa-arrow-circle-right"></i></a>
          </div>
        </div>
        <!-- /.card-footer-->
      </div>
      </div>
      <div class="col-sm-6 col-md-6 col-lg-6 col-xs-6 myRowBorder">
          <span>THIS IS FOR graph</span>
      </div>
    </div>
  </div>
  <div class="col-lg-1 col-md-1"></div>
</div>


<?php include 'footer.php'; ?>