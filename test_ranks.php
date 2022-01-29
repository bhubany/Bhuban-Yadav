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
	$errors=array();
	$total_pages="";
	$pageno=1;
	$Sucess="";
	$full_name="";
	$specific_rank=0;
	$actual_rank="";
	$rank_highlite="";
	$username=clean_values($con,$_SESSION['username']);
	$created_at=date("Y-m-d H:i:s");

	//----------Checking Previous value-----------
	if (clean_values($con,isset($_SESSION['check_rank_id'])) && clean_values($con,isset($_SESSION['set_no'])) && clean_values($con,isset($_SESSION['field_name']))) {
		$check_rank_id=clean_values($con,$_SESSION['check_rank_id']);
		$set_no=clean_values($con,$_SESSION['set_no']);
		$field_name=clean_values($con,$_SESSION['field_name']);
	}else{
		header("Location:test_view_full.php");
	}

	//--------for specific ranks----
	$specific_rank_query= @"SELECT * FROM user_exam_details WHERE set_no='$set_no' ORDER BY obtain_marks DESC";
	$specific_rank_query_res=mysqli_query($con,$specific_rank_query) or die($con);
	if (mysqli_num_rows($specific_rank_query_res)>0) {
		while ($specific_row=mysqli_fetch_assoc($specific_rank_query_res)) {
			$specific_rank++;
			if ($specific_row['id']==$check_rank_id) {
				$actual_rank=$specific_rank;
			}
		}
	}

	// echo $actual_rank;

		// -----------For Pagination----------
	if (clean_values($con,isset($_GET['pageno']))) {
     	$received_pageno = clean_values($con,$_GET['pageno']);
   	 
	    if (is_numeric($received_pageno)) {
	     	$pageno=$received_pageno;
	    }else{
	     	$pageno=1;
	    }
	}

  	$no_of_records_per_page = 10;
  	$starting_from = ($pageno-1) * $no_of_records_per_page;
  	$rank_no=$starting_from+1;

  	$total_pages_sql = @"SELECT * FROM user_exam_details WHERE set_no='$set_no'";
    $result = mysqli_query($con,$total_pages_sql);
    if (mysqli_num_rows($result)>0) {
    	$total_rows = mysqli_num_rows($result);
    	$total_pages = ceil($total_rows / $no_of_records_per_page);
    }else{
    	$total_pages=1;
    }

	  //----------------SELECTING IMAGES PRESENT ON THAT ID-----------------
	$qry_test_details=@"SELECT * FROM user_exam_details WHERE set_no='$set_no' ORDER BY obtain_marks DESC LIMIT $starting_from,$no_of_records_per_page";
	$qry_test_details_execute=mysqli_query($con,$qry_test_details) or die($con);

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

		<!-- ------------------------HEADER---------------------- -->
		<div class="row">
			<div class="col-lg-12 col-md-12 col-xs-12 p-4 shadow-lg text-center">
				<span class="bg-success p-2 text-white"><?php echo "Your Rank is: ".$actual_rank." out of ".$specific_rank; ?></span>
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

	        <table class="table table-striped">
	          <thead class="myHeader" style="color: white;">
	            <tr>
	              <th class="text-center"><strong>R.N.</strong></th>
	              <th class="text-center"><strong>Name<strong></th>
	              <th class="text-center"><strong>Obtained marks</strong></th>
	              <th class="text-center"><strong>Remarks</strong></th>
	              <th class="text-center"><strong>Exam Date</strong></th>
	              <th class="text-center"><strong>Profile</strong></th>
	            </tr>
	          </thead>
	          <tbody>
	            <?php  while ($test_details_rows=mysqli_fetch_assoc($qry_test_details_execute)) { 
	            		$temp_username=$test_details_rows["user_name"];
	            	 	$qry_for_name=@"SELECT * FROM user_information WHERE username='$temp_username' LIMIT 1"; 
	            		$qry_for_name_res=mysqli_query($con,$qry_for_name) or die($con);
	            		if (mysqli_num_rows($qry_for_name_res)>0) {
	            			while ($name_row=mysqli_fetch_assoc($qry_for_name_res)) {
	            				$full_name=$name_row['firstname']." ".$name_row['middlename']." ".$name_row['surname'];
	            			}
	            		}						  

						  // ----For highliting------------
						  if ($test_details_rows['id']==$check_rank_id) {
						  	$rank_highlite="bg-secondary text-white";
						  }else{
						  	$rank_highlite="";
						  }

						  // --------For remarks---
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
	              <td class="<?php echo($rank_highlite); ?>"><?php echo $rank_no; ?></td>
	              <td class="<?php echo($rank_highlite); ?>"><?php echo $full_name; ?></td>
	              <td class="<?php echo($rank_highlite); ?>"><?php echo $test_details_rows['obtain_marks']; ?></td>
	              <td class="<?php if($rem=='FAIL'){echo("text-danger");}else{echo("text-success");} ?>"><?php echo $rem ?></td>
	              <td class="<?php echo($rank_highlite); ?>"><?php echo $test_details_rows['trn_date']; ?></td>
	              <td>
	                   <button type="button" class="btn btn-success" data-toggle="modal" data-target="#forUserProfile" onclick="viewUserProfile('<?php echo($temp_username); ?>')">Profile</button>
	              </td>
	            </tr>
	            <?php $rank_no++; }  ?>
	          </tbody>
	        </table>
	    <?php }else{echo "<h2 class='text-info'>You haven't practiced any model sets. <a href='exam.php'>click here</a>to start test.</h2>";} ?>

			<!-- -----------Pagination--------- -->
			<?php if ($total_pages>1){ ?>

		<div class="pager text-center">
	        <a href="?pageno=1" class="btn btn-default myPagerBtn">First</a>
	        <a class="btn btn-default myPagerBtn <?php if($pageno <= 1){ echo 'disabled'; } ?>" href="<?php if($pageno <= 1){ echo '#'; } else { echo "?pageno=".($pageno - 1); } ?>">Prev</a>
	        <a class="btn btn-default myPagerBtn <?php if($pageno >= $total_pages){ echo 'disabled'; } ?>" href="<?php if($pageno > $total_pages){ echo '#'; } else { echo "?pageno=".($pageno + 1); } ?>">Next</a>
	        <a class="btn btn-default myPagerBtn" href="?pageno=<?php echo $total_pages; ?>">Last</a>
	    </div>
	<?php } ?>
      </div>
    </div>
  </div>
  <div class="col-lg-1 col-md-1"></div>
</div>

<!-- -------------------AJAX CODES--------------------- -->

<script type="text/javascript">

        // ------------NAME OF USER-------
    //    function viewUserProfile(username) {
    //   // $('#update_download_cat_details_id').val(id);

    //   $.post("getDataForUserModels.php",{
    //     view_user_profile_username:username
    //   },function(data,status){
    //     var user_name=JSON.parse(data);
    //     $('#fname').html(user_name.firstname);
    //     $('#mname').html(user_name.middlename);
    //     $('#sname').html(user_name.surname);
    //     // $('first').val(user_name.firstna me);
    //   }

    //     );
    //   $('#forUserProfile').modal("show");
    // }

     function viewUserProfile(username) {
      // $('#update_download_cat_details_id').val(id);

      $.post("getDataForUserModels.php",{
        view_user_profile_username:username
      },function(data,status){
        var user_name=JSON.parse(data);
        $('#fname').html(user_name.firstname);
        $('#mname').html(user_name.middlename);
        $('#sname').html(user_name.surname);
      }

        );
      $('#forUserProfile').modal("show");
    }

</script>





<?php include 'footer.php'; ?>



<!-- ------------------User Profile----------------- -->

<div class="modal fade" id="forUserProfile" tabindex="-1" role="dialog" aria-labelledby="forUserProfile" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="forUserProfile">User Ddetails</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <p class="text">Basic information</p>
        <div class="myForm">
            <h4><span class="font-weight-bold">Name:</span><span id="#fname" class="text-info font-italic"></span><span id="#mname" class="text-info font-italic"></span><span id="#sname" class="text-info font-italic"></span></h4>
            <!-- <input type="text" name="" id="first" readonly="on"> -->
        </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
      </div>
    </div>
  </div>
</div>
<!-- ----------------User profile FINISHED---------------- -->