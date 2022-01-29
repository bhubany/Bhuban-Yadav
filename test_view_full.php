<?php
	if(!session_id()){
	  session_start();
	}
?>

<?php 
	date_default_timezone_set('Asia/Kathmandu');
	require('db.php');
	require ("auth.php");
	require 'includes/functions.php';
	$_SESSION['user_full_name']="";
	$errors=array();
	$total_pages="";
	$pageno=1;
	$Sucess="";
	$_SESSION['is_row_present']="";
	$field_name="";
	$set_no="";
	$submitted_answer="";
	$wright_per='';
	$total_marks=0;
	$total_right=0;
	$total_wrong=0;
	$no_attempt=0;
	$obtained_marks=0;
	$test_date="";
	$total_qsn="";
	$total_attempt=0;
	$remarks="";
	$username=clean_values($con,$_SESSION['username']);
	$created_at=date("Y-m-d H:i:s");

	//------checking is value set or not---
	if (clean_values($con,isset($_SESSION['username'])) && clean_values($con,isset($_SESSION['view_full_id']))) {
		$view_full_id=clean_values($con,$_SESSION['view_full_id']);
	}else{
		header("Location:test_details.php");
	}

	//------------For checking rank---------
	if (clean_values($con,isset($_POST['check_rank']))) {
		$_SESSION['check_rank_id']=clean_values($con,$_POST['check_rank_id']);
		$_SESSION['set_no']=clean_values($con,$_POST['check_rank_set_no']);
		$_SESSION['field_name']=clean_values($con,$_POST['check_rank_field_name']);
		header("Location:test_ranks.php");
	}

	// ------------Selecting User Details-------------
	$select_user=@"SELECT * FROM user_information where username ='$username' LIMIT 1";
	$select_user_res=mysqli_query($con,$select_user) or die($con);
	if (mysqli_num_rows($select_user_res)>0) {
		while ($user_row=mysqli_fetch_assoc($select_user_res)) {
			$_SESSION['user_full_name']=$user_row['firstname']." ".$user_row['middlename']." ".$user_row['surname'];
		}
		
	}
	  //----------------SELECTING IMAGES PRESENT ON THAT ID-----------------
	$qry_test_details=@"SELECT * FROM user_exam_details WHERE user_name='$username' AND id=$view_full_id";
	$qry_test_details_execute=mysqli_query($con,$qry_test_details) or die($con);
	if (mysqli_num_rows($qry_test_details_execute)>0){
		$_SESSION['is_row_present']=mysqli_num_rows($qry_test_details_execute);
		while($test_rows=mysqli_fetch_assoc($qry_test_details_execute)){ 
			$field_name=$test_rows['field_name'];
			$set_no=$test_rows['set_no'];
			$submitted_answer=$test_rows['submitted_answers'];
			$total_marks=$test_rows['total_marks'];
			$total_right=$test_rows['right_answer'];
			$total_wrong=$test_rows['wrong_answer'];
			$no_attempt=$test_rows['no_attempt'];
			$obtained_marks=$test_rows['obtain_marks'];
			$test_date=$test_rows['trn_date'];
		}
		  $total_qsn=$total_right+$total_wrong+$no_attempt;
		  if ($total_marks!=0) {
		  $wright_per=($obtained_marks*100)/($total_marks);
		  }

		  $total_attempt=$total_right+$total_wrong;
		  // if ($total_qsn!=0) {
		  // $obtained_per=($total_attempt*100)/$total_qsn;
		  // }
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
	}

  ?>

<?php include 'header.php'; ?>
<?php include 'dashboard_nav.php'; ?>

<head>
	<title>ONLINE ENTRANCE | test details</title>
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

    	<div class="row">
        	<div class="col-md-2 col-lg-2"></div>
        	<div class="col-lg-8 col-md-8 col-xs-12 shadow-lg">
      		<div class="text-justify"><br><br>	
      			<br>
      			<div class="ml-4">
	      			<span class="font-weight-bold">Name: <span class="font-italic text-info"><?php echo $_SESSION['user_full_name']; ?></span></span>
	      			<span class="pull-right font-weight-bold">Exam Date: <span class="font-italic text-info"><?php echo $test_date; ?></span></span><br>
	      			<span class="font-weight-bold">Category: <span class="font-italic text-info"><?php echo $field_name; ?></span></span><br>
	      			<span class="font-weight-bold">SET: <span class="font-italic text-info">Set <?php echo $set_no; ?></span></span><br>
	      		</div>
      		</div>
      		<?php  ?>
      			
      		<?php ?>
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
                    <td><?php echo $total_marks; ?></td>
                  </tr>
                  <tr class="">
                    <td>Attempted Questions</td>
                    <td><?php echo $total_attempt; ?></td>
                  </tr>
                  <tr class="">
                    <td>Right Answers</td>
                    <td><?php echo $total_right; ?></td>
                  </tr>
                  <tr class="">
                    <td>Wrong Answers</td>
                    <td><?php echo $total_wrong; ?></td>
                  </tr>
                   <tr class="">
                    <td>No Attempted</td>
                    <td><?php echo $no_attempt; ?></td>
                  </tr>
                   <tr class="">
                    <td >Obtained Marks</td>
                    <td><?php echo $obtained_marks; ?></td>
                  </tr>
                   <tr class="">
                    <td>Your result </td>
                    <td><?php echo $wright_per."%"; ?></td>
                  </tr>
                   <tr class="success">
                    <th>REMARKS</th>
                    <th class="<?php if($rem=='FAIL'){echo("alert alert-danger");}else{echo("text-success");} ?>"><?php echo $rem; ?></th>
                  </tr>
                </tbody>
              </table>
      				<?php ?>

      			<div class="myHeader p-2 text-center" style="color: #fff;border-top-right-radius: 10px;border-top-left-radius: 10px;">
      				<u><h5>Your Submitted results for this Set:</h5></u>
	      		</div>
	      		<div class="myRowBorder p-2">
      				<ul style="list-style: none;display: inline;">
      					<?php
	      				 	$res_len=strlen($submitted_answer);
	      				 	for ($x = 0; $x < $res_len; $x++) {
	      				 		$res=substr($submitted_answer, $x,1);
	      				 		if ($res=='n') {
	      				 			$res="no-attempt";
	      				 	}
      				 	?>
      				<li style="display: inline;"><?php echo ($x+1).". ".$res."&nbsp;&nbsp;&nbsp;&nbsp;"; ?></li>
      					<?php } ?>
      				</ul>
      			</div><br>
      			<div class="p-2 text-center">
      				<form action="" method="post">
      					<input type="hidden" name="check_rank_id" value="<?php echo($view_full_id); ?>">
      					<input type="hidden" name="check_rank_field_name" value="<?php echo($field_name); ?>">
      					<input type="hidden" name="check_rank_set_no" value="<?php echo($set_no); ?>">
      					<button type="submit" class="btn btn-success" name="check_rank">Check rank</button>
      					<button type="button" class="btn btn-info">Print result <i class="fa fa-print"></i></button>
      				</form>
      			</div>
      		</div>
      		<div class="col-md-4 col-lg-4"></div>
    	</div>
  </div>
  <div class="col-lg-1 col-md-1"></div>
</div>







<?php include 'footer.php'; ?>