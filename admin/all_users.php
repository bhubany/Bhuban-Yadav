<?php
	if(!session_id()){
	  session_start();
	}
?>

<?php 
	date_default_timezone_set('Asia/Kathmandu');
	require('user_database.php');
	require 'acess.php';
	require '../includes/functions.php';

	$errors=array();
	$total_pages="";
	$pageno=1;
	$Sucess="";
	$wright_per=0;
	$rem="";
	// $username=clean_values($con_user,$_SESSION['username']);
	$created_at=date("Y-m-d H:i:s");

//---For Deactivating acounts
	if (clean_values($con_user,isset($_POST['deactivate_user']))) {
		$activate_deactivate_user_id=clean_values($con_user,$_POST['activate_deactivate_user_id']);

		if (empty($activate_deactivate_user_id) or !is_numeric($activate_deactivate_user_id)) {
			array_push($errors, "Invalid ID");
		}

		$deactivate_user_qry=@"UPDATE user_information SET is_active=0 WHERE id=$activate_deactivate_user_id";
		$deactivate_user_res=mysqli_query($con_user,$deactivate_user_qry) or die($con_user);
		if ($deactivate_user_res==1) {
			$Sucess="Account has been deactivated sucessfully present on Id => ".$activate_deactivate_user_id;
		}
	}

	//------For activating accounts-----
	if (clean_values($con_user,isset($_POST['activate_user']))) {
		$activate_deactivate_user_id=clean_values($con_user,$_POST['activate_deactivate_user_id']);

		if (empty($activate_deactivate_user_id) or !is_numeric($activate_deactivate_user_id)) {
			array_push($errors, "Invalid ID");
		}

		$activate_user_qry=@"UPDATE user_information SET is_active=1 WHERE id=$activate_deactivate_user_id";
		$activate_user_res=mysqli_query($con_user,$activate_user_qry) or die($con_user);
		if ($activate_user_res==1) {
			$Sucess="Account has been activated sucessfully present on Id => ".$activate_deactivate_user_id;
		}
	}

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

  	$total_pages_sql = "SELECT * FROM user_information ";
    $result = mysqli_query($con_user,$total_pages_sql);
    if (mysqli_num_rows($result)>0) {
    	$total_rows = mysqli_num_rows($result);
    	$total_pages = ceil($total_rows / $no_of_records_per_page);
    }else{
    	$total_pages=1;
    }

	  //----------------SELECTING IMAGES PRESENT ON THAT ID-----------------
	$qry_user_details=@"SELECT * FROM user_information ORDER BY id DESC LIMIT $starting_from,$no_of_records_per_page";
	$qry_user_details_execute=mysqli_query($con_user,$qry_user_details) or die($con_user);


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
					<u  style=""><h5 class="text-center">All Registered user present on database</h5></u>
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
      	
      	 <?php if (mysqli_num_rows($qry_user_details_execute)>0){ ?>

	        <table class="table table-striped col">
	          <thead class="myHeader" style="color: white;">
	            <tr>
	              <th class="text-center"><strong>I.D.</strong></th>
	              <th class="text-center"><strong>Full Name</strong></th>
	              <!-- <th class="text-center"><strong>Username<strong></th> -->
	              <th class="text-center"><strong>Email</strong></th>
	              <th class="text-center"><strong>Contact(Primary)</strong></th>
	              <th class="text-center"><strong>Image</strong></th>
	              <th class="text-center"><strong>Registered Date</strong></th>
	              <th></th>
	              <th>Action</th>
	              <th></th>
	            </tr>
	          </thead>
	          <tbody>
	             <?php  while ($user_details_rows=mysqli_fetch_assoc($qry_user_details_execute)) { 	?>

	            <tr align="center">
	              <td><?php echo $user_details_rows['id']; ?></td>
	              <td><?php echo $user_details_rows['firstname']." ".$user_details_rows['middlename']." ".$user_details_rows['surname']; ?></td>
	              <!-- <td><?php //echo $user_details_rows['username']; ?></td> -->
	              <td><a style="text-decoration: none;" onclick="window.alert('hello');" href=""><?php echo $user_details_rows['email']; ?></a></td>
	              <td><a class="#" style="text-decoration: none;" href="tel:<?php echo($user_details_rows['contact1']); ?>"><?php echo $user_details_rows['contact1']; ?></a></td>
	              <td class="gallery">
						<a href="../secure/user_images/<?php echo $user_details_rows['image']; ?>" data-lightbox="mygallery" data-title="<?php echo($user_details_rows['username']); ?>">
							<img height="100" width="100" src="../secure/user_images/<?php echo $user_details_rows['image']; ?>" alt="<?php echo($user_details_rows['username']); ?>">
						</a>
					</td>
	              <td><?php echo $user_details_rows['created_at']; ?></td>
	              <td>
		                <!-- <button type="button" class="btn btn-primary" onclick="viewEditDetails('<?php //echo($user_details_rows['username']); ?>')">Edit</button> -->
		                <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#forUpdateUser" onclick="EditUserDetails('<?php echo($user_details_rows['id']); ?>')">Edit</button>
	              </td>
	              <td>
	              	<button type="button" class="btn btn-info" data-toggle="modal" data-target="#forViewUser" onclick="viewUserDetails('<?php echo($user_details_rows['id']); ?>')">View</button>
	              </td>
	              <td>
              	    <form method="post" action="">
			            <input type="hidden" name="activate_deactivate_user_id" value="<?php echo $user_details_rows['id']; ?>">
			            	<?php if ($user_details_rows['is_active']==1) { ?>
	              		<button type="submit" class="btn btn-danger" name="deactivate_user">Deactivate</button>
	              			<?php }else{ ?>
	              		<button type="submit" class="btn btn-success" name="activate_user">Activate</button>
	              			<?php } ?>
	              	</form>
	              </td>
	            </tr>
	            <?php }  ?>
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


<!-- ------------------------------AJAX CODES-------------------- -->

<script type="text/javascript">

				// <!-- ------EDITING/UPDATING DETAILS----------- -->

	function viewUserDetails(id) {

		$.post("getDataForModels.php",{
			view_user_id:id
		},function(data,status){
			var user=JSON.parse(data);
			$('#view_user_firstname').html(user.firstname);
			$('#view_user_middlename').html(user.middlename);
			$('#view_user_surname').html(user.surname);
			$('#view_user_p_country').html(user.pcountry);
			$('#view_user_p_zone').html(user.pzone);
			$('#view_user_p_district').html(user.pdistrict);
			$('#view_user_p_city').html(user.pcity);
			$('#view_user_p_tole').html(user.ptole);
			$('#view_user_t_country').html(user.tcountry);
			$('#view_user_t_zone').html(user.tzone);
			$('#view_user_t_district').html(user.tdistrict);
			$('#view_user_t_city').html(user.tcity);
			$('#view_user_t_tole').html(user.ttole);
			$('#view_user_dob_bs').html(user.dob_bs);
			$('#view_user_dob_ad').html(user.dob_ad);
			$('#view_user_about_me').html(user.about_me);
			$('#view_user_ip_address').html(user.user_ip);
			$('#view_user_is_active').html(user.is_active);
			$('#view_user_is_email_verified').html(user.is_email_verified);
			$('#view_user_is_profile_verified').html(user.verified);
		}

			);
		$('#forViewUser').modal("show");
	}
     

</script>

<?php include 'footer.php'; ?>

<!-- *****************ENDING OF MAIN SECTIONS************** -->

<!-- ..........for adding New Notice............ -->

<div class="modal fade" id="forViewUser" tabindex="-1" role="dialog" aria-labelledby="forViewUser" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="forViewUser">User Full Details</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <div class="myRowBorder" style="padding-left: 10px;">
        	<!-- <p class="font-weight-bold"></p> -->
			<p ><span class="font-weight-bold">First Name : </span><span id="view_user_firstname" class="font-italic text-info"> Firstname will be shown here</span></p>
			<p ><span class="font-weight-bold">Middle Name : </span><span id="view_user_middlename" class="font-italic text-info"> middlename will be shown here</span></p>
        	<p ><span class="font-weight-bold">Last Name : </span><span id="view_user_surname" class="font-italic text-info"> surname will be shown here</span></p>

        	<u><h2 class="text-center">Permanent Address</h2></u>
        	<p ><span class="font-weight-bold">Country : </span><span id="view_user_p_country" class="font-italic text-info"> surname will be shown here</span></p>
        	<p ><span class="font-weight-bold">Zone : </span><span id="view_user_p_zone" class="font-italic text-info"> surname will be shown here</span></p>
        	<p ><span class="font-weight-bold">District : </span><span id="view_user_p_district" class="font-italic text-info"> surname will be shown here</span></p>
        	<p ><span class="font-weight-bold">City : </span><span id="view_user_p_city" class="font-italic text-info"> surname will be shown here</span></p>
        	<p ><span class="font-weight-bold">Tole : </span><span id="view_user_p_tole" class="font-italic text-info"> Question will be shown here</span></p>

        	<u><h2 class="text-center">Temporary Address</h2></u>
        	<p ><span class="font-weight-bold">Country : </span><span id="view_user_t_country" class="font-italic text-info"> surname will be shown here</span></p>
        	<p ><span class="font-weight-bold">Zone : </span><span id="view_user_t_zone" class="font-italic text-info"> surname will be shown here</span></p>
        	<p ><span class="font-weight-bold">District : </span><span id="view_user_t_district" class="font-italic text-info"> surname will be shown here</span></p>
        	<p ><span class="font-weight-bold">City : </span><span id="view_user_t_city" class="font-italic text-info"> surname will be shown here</span></p>
        	<p ><span class="font-weight-bold">Tole : </span><span id="view_user_t_tole" class="font-italic text-info"> Question will be shown here</span></p>

        	<u><h2 class="text-center">Date of Birth (DOB)</h2></u>
        	<p ><span class="font-weight-bold">B.S. : </span><span id="view_user_dob_bs" class="font-italic text-info"> surname will be shown here</span></p>
        	<p ><span class="font-weight-bold">A.D. : </span><span id="view_user_dob_ad" class="font-italic text-info"> surname will be shown here</span></p>

        	<u><h2 class="text-center">About me</h2></u>
        	<p ><span class="font-weight-bold">About me : </span><span id="view_user_about_me" class="font-italic text-info"> surname will be shown here</span></p>

        	<u><h2 class="text-center">User Ip Address</h2></u>
        	<p ><span class="font-weight-bold">Ip : </span><span id="view_user_ip_address" class="font-italic text-info"> surname will be shown here</span></p>

        	<u><h2 class="text-center">Other Details</h2></u>
        	<p ><span class="font-weight-bold">Is Active : </span><span id="view_user_is_active" class="font-italic text-info"> surname will be shown here</span></p>
        	<p ><span class="font-weight-bold">Is Email Verified : </span><span id="view_user_is_email_verified" class="font-italic text-info"> surname will be shown here</span></p>
        	<p ><span class="font-weight-bold">Is Profile Verified : </span><span id="view_user_is_profile_verified" class="font-italic text-info"> surname will be shown here</span></p>
        </div><br>
        <button class="btn btn-primary">Print</button>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
      </div>
    </div>
  </div>
</div>
<!-- .............adding NOTICE finished........... -->

