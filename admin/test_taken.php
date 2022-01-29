<?php
	if(!session_id()){
	  session_start();
	}
?>

<?php 
	date_default_timezone_set('Asia/Kathmandu');
	require('user_database.php');
	require ("acess.php");
	require '../includes/functions.php';
	$errors=array();
	$total_pages="";
	$pageno=1;
	$Sucess="";
	$wright_per=0;
	$rem="";
	// $username=clean_values($con_user,$_SESSION['username']);
	$created_at=date("Y-m-d H:i:s");

	//------------clearing all sessions values-----
	// unset($_SESSION['view_full_id']);
	// unset($_SESSION['check_rank_id']);
	// unset($_SESSION['set_no']);
	// unset($_SESSION['field_name']);
	// $_SESSION['view_full_id']="";


	//------------For checking rank---------
	// if (clean_values($con,isset($_POST['checks_rank']))) {
	// 	$_SESSION['check_rank_id']=clean_values($con,$_POST['check_rank_id']);
	// 	$_SESSION['set_no']=clean_values($con,$_POST['check_rank_set_no']);
	// 	$_SESSION['field_name']=clean_values($con,$_POST['check_rank_field_name']);
	// 	header("Location:test_ranks.php");
	// }

	//---------------View full-----------
	// if (clean_values($con,isset($_POST['view_full']))) {
	// 	$_SESSION['view_full_id']=clean_values($con,$_POST['view_full_id']);
	// 	if (is_numeric($_SESSION['view_full_id'])) {
	//     	header("Location:test_view_full.php");
	//     }else{
	//      	array_push($errors, "Error occurs try again later.");
	//     }
	// }
		// -----------For Pagination----------
	if (clean_values($con_user,isset($_GET['pageno']))) {
     	$received_pageno = clean_values($con_user,$_GET['pageno']);
   	 
	    if (is_numeric($received_pageno)) {
	     	$pageno=$received_pageno;
	    }else{
	     	$pageno=1;
	    }
	}

  	$no_of_records_per_page = 10;
  	$starting_from = ($pageno-1) * $no_of_records_per_page;
  	$serial_number=$starting_from+1;

  	$total_pages_sql = "SELECT * FROM user_exam_details ";
    $result = mysqli_query($con_user,$total_pages_sql);
    if (mysqli_num_rows($result)>0) {
    	$total_rows = mysqli_num_rows($result);
    	$total_pages = ceil($total_rows / $no_of_records_per_page);
    }else{
    	$total_pages=1;
    }

	  //----------------SELECTING IMAGES PRESENT ON THAT ID-----------------
	$qry_test_details=@"SELECT * FROM user_exam_details ORDER BY id DESC LIMIT $starting_from,$no_of_records_per_page";
	$qry_test_details_execute=mysqli_query($con_user,$qry_test_details) or die($con_user);

  ?>

<?php include 'heading.php'; ?>
<?php include 'admin_nav.php'; ?>

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

		<!-- ------------------------HEADER---------------------- -->
		<div class="row">
			<div class="col-lg-12 col-md-12 col-xs-12 p-2 shadow-lg">
					<u  style=""><h5 class="text-center">All Tests Performed by Users</h5></u>
				</button>
			</div>
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

    <div class="row">
      <div class="col-lg-12 col-md-12 col-xs-12 shadow-lg">
      	
      	 <?php if (mysqli_num_rows($qry_test_details_execute)>0){ ?>

	        <table class="table table-striped col">
	          <thead class="myHeader" style="color: white;">
	            <tr>
	              <th class="text-center"><strong>S.N.</strong></th>
	              <th class="text-center"><strong>Username.</strong></th>
	              <th class="text-center"><strong>Category<strong></th>
	              <th class="text-center"><strong>SET</strong></th>
	              <th class="text-center"><strong>Obtained marks</strong></th>
	              <th class="text-center"><strong>Remarks</strong></th>
	              <th class="text-center"><strong>Exam date</strong></th>
	              <!-- <th></th> -->
	              <th>Action</th>
	            </tr>
	          </thead>
	          <tbody>
	             <?php  while ($test_details_rows=mysqli_fetch_assoc($qry_test_details_execute)) { 

	             if ($test_details_rows['total_marks']!=0) {
		  			$wright_per=($test_details_rows['obtain_marks']*100)/($test_details_rows['total_marks']);
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

	            <tr align="center">
	              <td><?php echo $serial_number; ?></td>
	              <td><?php echo $test_details_rows['user_name']; ?></td>
	              <td><?php echo $test_details_rows['field_name']; ?></td>
	              <td><?php echo $test_details_rows['set_no']; ?></td>
	              <td><?php echo $test_details_rows['obtain_marks']; ?></td>
	              <td class="<?php if($rem=='FAIL'){echo("text-danger");}else{echo("text-success");} ?>"><?php echo $rem; ?></td>
	              <td><?php echo $test_details_rows['trn_date']; ?></td>
	              <td>
	              	    <form method="post" action="">
				            <input type="hidden" name="view_full_id" value="<?php echo $test_details_rows['id']; ?>">
			                <button type="submit" class="btn btn-primary" name="view_full">Full</button>
	              	    </form>
	              </td>
	            </tr>
	            <?php $serial_number++; }  ?>
	          </tbody>
	        </table>
	    <?php }else{echo "<h2 class='text-info'>You haven't practiced any model sets. <a href='exam_function.php'>click here</a>to start test.</h2>";} ?>

			<!-- -----------Pagination--------- -->
			<?php if ($total_pages>1){ ?>

		<div class="pager text-center">
	        <a href="?pageno=1" class="btn btn-default myPagerBtn">First</a>
	        <a class="btn btn-default previous myPagerBtn <?php if($pageno <= 1){ echo 'disabled'; } ?>" href="<?php if($pageno <= 1){ echo '#'; } else { echo "?pageno=".($pageno - 1); } ?>">Prev</a>
	        <a class="btn btn-default next myPagerBtn <?php if($pageno >= $total_pages){ echo 'disabled'; } ?>" href="<?php if($pageno > $total_pages){ echo '#'; } else { echo "?pageno=".($pageno + 1); } ?>">Next</a>
	        <a class="btn btn-default myPagerBtn" href="?pageno=<?php echo $total_pages; ?>">Last</a>
	    </div>
	<?php } ?>
      </div>
    </div>
  </div>
  <div class="col-lg-1 col-md-1"></div>
</div>







<?php include 'footer.php'; ?>