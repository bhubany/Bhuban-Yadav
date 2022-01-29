<?php
  if(!session_id()){
    session_start();
  }
?>

<?php 
date_default_timezone_set("Asia/Kathmandu");
require 'auth.php';
require 'db.php';
require 'secure/exam_database.php';
require 'secure/admin_database.php';
require 'includes/functions.php';

  // ---------CHECKING Values for previous pages----
if (clean_values($con_exam,isset($_SESSION['set_selection'])) and clean_values($con_exam,isset($_SESSION['cat_selection'])) and clean_values($con_exam,isset($_SESSION['view_res']))) {
  $field_id=clean_values($con_exam,$_SESSION['cat_selection']);
  $set_id=clean_values($con_exam,isset($_SESSION['set_selection']));
  $_SESSION['view_res']=1;
}else{
  header("Location:exam_function.php");
}


$field_id=0;
$field_name=clean_values($con,$_SESSION['cat_name']);
$user_res="";
$marks=0;
$wright=0;
$wrong=0;
$no_attempt=0;
$total_marks=0;
$wright_per='';
$errors=array();
$Sucess="";
$total_question="";
$submitted_at=Date('Y-m-d H:i:s');

$username=$_SESSION['username'];
$user_qry=@"SELECT * FROM user_information WHERE username='$username'LIMIT 1";
$user_result=mysqli_query($con,$user_qry) or die($con);
if (mysqli_num_rows($user_result)>0) {
  while ($row=mysqli_fetch_assoc($user_result)) {
  $full_name=$row["firstname"]." ".$row["middlename"]." ".$row["surname"];
  $user_email=$row['email'];
  $user_telephone=$row['contact1'];
  }
}else{
  array_push($errors, "Error occurs on processing your details.");
}


// -------------------FEEDBACK BLOCK------------------------
if (clean_values($con_admin,isset($_POST['submit_feedback']))) {
  $user_feedback=clean_values($con_admin,$_POST['user_feedback']);

  if (empty($user_feedback)){
    array_push($errors, "Enter your essential feedback");
  }

  if (count($errors)==0) {
    $feedback_qry=@"INSERT INTO users_feedback (name,email,feedback_category,feedback,telephone,trn_date) VALUES ('$full_name','$user_email','feedback','$user_feedback','$user_telephone','$submitted_at')";
    $feedback_result=mysqli_query($con_admin,$feedback_qry) or die($con_admin);
    if ($feedback_result==1) {
      $Sucess="Thank for your essential feedback";
    }else{
    array_push($errors, "Error occurs while submitting your feedback.");
   }
  }
}

// ----------------------------PREVIOUS SUBMISSION BLOCK--------------------

if (isset($_POST['completed_submit'])) {
  unset($_SESSION['exam_start']);
  unset($_SESSION['is_refreshed']);
  $_SESSION['exam_ended']=1;
	$field_id=$_POST['field_id'];
	$set_id=$_POST['set_id'];
	$total_question=$_POST['total_question'];

  $query=@"SELECT question_no,answer,containing_marks FROM questions_collections WHERE field_id='$field_id' AND question_set='$set_id'";
  $result=mysqli_query($con_exam,$query) or die(mysqli_error($con_exam));
  if (mysqli_num_rows($result)>0) {
    while ($rows=mysqli_fetch_assoc($result)) {
    	$_SESSION['total_marks']=$_SESSION['total_marks']+$rows['containing_marks'];

    	if ($rows['answer']==$_POST[$rows['question_no']]) {
    		$_SESSION['wright']=$_SESSION['wright']+1;
        $_SESSION['user_res']=$_SESSION['user_res'].$_POST[$rows['question_no']];
    		$_SESSION['marks']=$_SESSION['marks']+(1*$rows['containing_marks']);
    	
      }else if ($_POST[$rows['question_no']]=="no_attempt") {
    		$_SESSION['no_attempt']=$_SESSION['no_attempt']+1;
        $_SESSION['user_res']=$_SESSION['user_res'].'n';
    	
      }	else {
    		$_SESSION['wrong']=$_SESSION['wrong']+1;
        $_SESSION['user_res']=$_SESSION['user_res'].$_POST[$rows['question_no']];
    	}
    }
  }else{
    array_push($errors, "Error occurs while processing your results");
  }
}
  $total_qsn=$_SESSION['wright']+$_SESSION['wrong']+$_SESSION['no_attempt'];
  if ($_SESSION['total_marks']!=0) {
  $wright_per=($_SESSION['marks']*100)/($_SESSION['total_marks']);
  }

  $attempt=$_SESSION['wright']+$_SESSION['wrong'];
  if ($total_qsn!=0) {
  $attempt_perc=($attempt*100)/$total_qsn;
  }
  if ($wright_per>=90) {
  	$rem="OUTSTANDING";
  }
  elseif ($wright_per>=80 && $wright_per<90) {
  	$rem="VERY GOOD";
  }
  elseif ($wright_per>=70 && $wright_per<80) {
  	$rem="GOOD";
  }
  elseif ($wright_per>=60 && $wright_per<70) {
  	$rem="FAIR";
  }
  elseif ($wright_per>=50 && $wright_per<60) {
  	$rem="AVERAGE";
  }
  elseif ($wright_per>=40 && $wright_per<50) {
  	$rem="BELOW AVERAGE";
  }
  else{
  	$rem="FAIL";
  }
?>

<?php include 'header.php'; ?>

<head>
  <title>ONLINE ENTRANCE-Viewing result</title>
</head>



<style type="text/css">

.mySubRowBorder{
  border: solid #095EA7 2px;
  background-color: white;
}
</style>

<div class="row">
  <div class="col-lg-1 col-md-1"></div>
  <div class="col-lg-10 col-md-10 col-xs-12 myRowBorder">
    <div class="mySubRowBorder">
      <h2 class="text-center">THANK YOU !</h2>
      <h3 class="text-center">YOUR ANSWER HAS BEEN SUBMITTED.</h3>
      <h4 class="text-center">CLICK THE BELOW BUTTON TO VIEW YOUR RESULTS.</h4>
      <h3 class="text-center"><?php echo $Sucess; ?></h3>
    </div>


    <div class="row">
      <div class="col-lg-4 col-md-4"></div>
      <div class="col-lg-4 col-md-4 col-xs-8"><br>
          <button class="btn btn-primary btn-lg btn-block" type="button" data-toggle="collapse" data-target="#collapseCategory" aria-expanded="false" aria-controls="collapseCategory">
            VIEW RESULT
          </button><br>
      </div>
      <div class="col-lg-4 col-md-4"></div>
    </div>


    <div class="row">
      <div class="col-lg-4 col-md-4"></div>
      <div class="col-lg-4 col-md-4 col-xs-12">

        <div class="collapse" id="collapseCategory">
          <div class="mySubRowBorder">
            <table class="table table-bordered">
                <thead>
                  <tr class="">
                    <th>TOTAL NUMBER OF QUESTIONS</th>
                    <th><?php echo $total_qsn; ?></th>
                  </tr>
                </thead>
                <tbody>
                   <tr class="">
                    <td>Total Marks</td>
                    <td><?php echo $_SESSION['total_marks']; ?></td>
                  </tr>
                  <tr class="">
                    <td>Attempted Questions</td>
                    <td><?php echo $attempt; ?></td>
                  </tr>
                  <tr class="">
                    <td>Right Answers</td>
                    <td><?php echo $_SESSION['wright']; ?></td>
                  </tr>
                  <tr class="">
                    <td>Wrong Answers</td>
                    <td><?php echo $_SESSION['wrong']; ?></td>
                  </tr>
                   <tr class="">
                    <td>No Attempted</td>
                    <td><?php echo $_SESSION['no_attempt']; ?></td>
                  </tr>
                   <tr class="">
                    <td >Obtained Marks</td>
                    <td><?php echo $_SESSION['marks']; ?></td>
                  </tr>
                   <tr class="">
                    <td>Your result </td>
                    <td><?php echo $wright_per."%"; ?></td>
                  </tr>
                   <tr class="">
                    <th>REMARKS</th>
                    <th><?php echo $rem; ?></th>
                  </tr>
                </tbody>
              </table>
              <button class="btn btn-primary btn-lg btn-block" type="button"> PRINT/SAVE RESULT</button>
          </div>
        </div>
      </div>
      <div class="col-lg-4 col-md-4"></div>
    </div>
  </div>
</div>



<!-- ------------------------MAIN DIVISION OF RESULTS-------------------- -->


<div class="row">

  <div class="col-lg-1 col-md-1"></div>

  <div class="col-lg-10 col-md-10 col-xs-12 myRowBorder">

    <div class="row">
      <div class="col-lg-12 col-md-12 col-xs-12 myHeader" style="color: #fff">
            <u><h3 class="text-center">Please provide us your essential feedback about website and questions:</h3></u>
            <h5 class="text-center"><a href="exam_function.php" class="text-warning">Click here</a> to redirect to exam section.</h5>
      </div>
    </div>

    <div class="row">
      <div class="col-lg-3 col-md-3"></div>
      <div class="col-lg-6 col-md-6 col-xs-12">
        <div class="myForm">
          <form method="post" id="feedback_form" action="">  

                  <?php include('errors.php');?>
                  <?php if ($Sucess!="") {?>
                <div class="success">
                  <?php echo $Sucess; ?>
                </div>
                  <?php  } ?>

            <div class="form-group">
                  <label for="text" class="font-weight-bold">FEEDBACK:</label>
                  <textarea type="text" class="form-control" id="full_name" placeholder="Enter your feedback" name="user_feedback" ></textarea>
              </div>

            <div>
              <center>
              <button type="submit" class="btn btn-default myLoginBtn" name="submit_feedback">SUBMIT FEEDBACK</button>
              </center>
            </div>
          </form>
        </div>
      </div>
      <div class="col-lg-3 col-md-3"></div>
    </div>
  </div>
  <div class="col-lg-1 col-md-1"></div>
</div>


<!-- ============================================= -->

<?php include 'footer.php'; ?>




<?php
if (clean_values($con,isset($_SESSION['is_res_saved']))) {
  $user_res=clean_values($con,$_SESSION['user_res']);
  $total_marks=clean_values($con,$_SESSION['total_marks']);
  $wright=clean_values($con,$_SESSION['wright']);
  $wrong=clean_values($con,$_SESSION['wrong']);
  $no_attempt=clean_values($con,$_SESSION['no_attempt']);
  $marks=clean_values($con,$_SESSION['marks']);

  $insert_res=@"INSERT INTO user_exam_details(user_name,field_name,set_no,submitted_answers,total_marks,right_answer,wrong_answer,no_attempt,obtain_marks,trn_date)
  VALUES('$username','$field_name','$set_id','$user_res','$total_marks','$wright','$wrong','$no_attempt','$marks','$submitted_at') LIMIT 1";
  $result_insert_res=mysqli_query($con,$insert_res) or die (mysqli_error($con));
    if ($result_insert_res==1) {
      unset($_SESSION['is_res_saved']);
    }else{
      array_push($errors,"error occur while submitting results to the database");
    }

}
 ?>