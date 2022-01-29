<?php
if(!session_id()){
  session_start();
}?>

<?php 
date_default_timezone_set("Asia/Kathmandu");
$upload_date=Date('Y-m-d h:m:s:ms');
$errors=array();
$Sucess="";
$cat_details_id="";
$cat_details_name="";
require 'exam_database.php';


// ------------RECEVING ID's FROM PREVIOUS PAGE-------------
if (isset($_SESSION['cat_details_id']) and isset($_SESSION['cat_details_name'])) {
	$cat_details_id=$_SESSION['cat_details_id'];
	$cat_details_name=$_SESSION['cat_details_name'];
}else{
	header("Location:exam_category.php");
}


// --------------TO ADD SETS ON THAT CATEGORY----------------------
if (isset($_POST['add_sets'])) {
	$add_sets_number=$_POST['add_sets_number'];

	if (empty($add_sets_number)) {
		array_push($errors, "Please enter SET number to add");
	}
	$sets_exists_qry=@"SELECT * FROM question_sets WHERE category_id='$cat_details_id'AND set_id='$add_sets_number'";
	$sets_exists_execute=mysqli_query($con_exam,$sets_exists_qry) or die($con_exam);
	if (mysqli_num_rows($sets_exists_execute)!=0) {
		array_push($errors, "Already exists the set number ".$add_sets_number." on database in this category");
	}
	if (count($errors)==0) {
	$add_sets_query=@"INSERT INTO question_sets(category_id,set_id,is_active,trn_date)VALUES('$cat_details_id','$add_sets_number','0','$upload_date')";
	$add_sets_result=mysqli_query($con_exam,$add_sets_query) or die($con_exam);
	if ($add_sets_result==1) {
			$Sucess="Your SET number has been uploaded sucessfully";
			
		}
	else{
		array_push($errors, "Error occurs during adding SET numbers");
	}
	}
}

// ---------------DELETE SET NUMBER-------------------
if (isset($_POST['del_sets'])) {
	$del_set_id=$_POST['del_set_id'];
	$del_set_name=$_POST['del_set_name'];
	if (empty($del_set_id)) {
		array_push($errors, "SET ID is required to delete SETS");
	}
	$set_exists_qry=@"SELECT * FROM question_sets WHERE id='$del_set_id' AND category_id='$cat_details_id'";
	$set_exists_execute=mysqli_query($con_exam,$set_exists_qry) or die($con_exam);
	if (mysqli_num_rows($set_exists_execute)==0) {
		array_push($errors, "There is not any SETS on database belongings to id= ".$del_set_id." on this category.");
	}
	if (count($errors)==0) {
		$del_set_query=@"DELETE FROM question_sets WHERE id='$del_set_id'";
		$del_set_execute=mysqli_query($con_exam,$del_set_query) or die($con_exam);
		if ($del_set_execute==1) {
			$Sucess="Set ->".$del_set_name." has been deleted suscessfully presented on id -> ".$del_set_id;
			// header("Refresh:3");
		}
		else{
			array_push($errors, "Error occurs on deleting Set ->".$del_set_name."preaented on id -> ".$del_set_id);
		}
	}
}

// -----------ACTIVATE SET----------
if (isset($_POST['activate_set'])) {
	$activate_set_id=$_POST['activate_set_id'];
	$activate_set_name=$_POST['activate_set_name'];
	$activate_set_qry=@"UPDATE question_sets SET is_active='1' WHERE id='$activate_set_id' LIMIT 1";
	$activate_set_execute=mysqli_query($con_exam,$activate_set_qry) or die($con_exam);
	if ($activate_set_execute==1) {
		$Sucess="SET -> '".$activate_set_name."' has been activated suscessfully presented on id= ".$activate_set_id;
			// header("Refresh:3");
	}
	else{
		array_push($errors, "Error occurs on Activating SET present on id= ".$activate_set_id);
	}
}


// ------------------DEACTIVATE SET-------------------

if (isset($_POST['deactivate_set'])) {
	$deactivate_set_id=$_POST['deactivate_set_id'];
	$deactivate_set_name=$_POST['deactivate_set_name'];
	$deactivate_set_qry=@"UPDATE question_sets SET is_active='0' WHERE id='$deactivate_set_id' LIMIT 1";
	$deactivate_set_execute=mysqli_query($con_exam,$deactivate_set_qry) or die($con_exam);
	if ($deactivate_set_execute==1) {
		$Sucess="SET -> '".$deactivate_set_name."' has been deactivated suscessfully presented on id= ".$deactivate_set_id;
			// header("Refresh:3");
	}
	else{
		array_push($errors, "Error occurs on Activating SET present on id= ".$deactivate_set_id);
	}
}

// ----------Visiting next page----------
if (isset($_POST['view_set_details'])) {
	$_SESSION['set_number']=$_POST['set_number'];
	header("Location:exam_set_details.php");
}

	// -----------For Pagination----------
	 if (isset($_GET['pageno'])) {
     	$pageno = $_GET['pageno'];
   	} else {
      	$pageno = 1;
    }

  	$no_of_records_per_page = 10;
  	$starting_from = ($pageno-1) * $no_of_records_per_page;

  	$total_pages_sql = "SELECT * FROM question_sets WHERE category_id='$cat_details_id'";
    $result = mysqli_query($con_exam,$total_pages_sql);
    if (mysqli_num_rows($result)>0) {
    	$total_rows = mysqli_num_rows($result);
    	// echo "Total rows => ".$total_rows;
    	$total_pages = ceil($total_rows / $no_of_records_per_page);
    }else{
    	$total_pages=1;
    }

// --------------------GETTING ALL DETAILS----------------------
$cat_details_qry=@"SELECT * FROM question_sets WHERE category_id='$cat_details_id' LIMIT $starting_from,$no_of_records_per_page";
$cat_details_execute=mysqli_query($con_exam,$cat_details_qry) or die($con_exam);
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
	<div class="col-lg-10 col-md-10 col-xs-12 myRowBorder">

		<!-- ------------------------HEADER---------------------- -->
		<div class="mySubRowBorder">
			<u  style="color: #1222B5;"><h2 class="text-center">AVAILABLES SETS OF CATEGORY ("<?php echo strtoupper($cat_details_name); ?>")</h2></u>
 			<h4 class="text-center text-info">Id of current category is -> <?php echo $cat_details_id; ?>.</h4>
		</div>

			<!-- -------------------------ADD CATEGORY BTN-------------------- -->
		<div class="row">
			<div class="col-lg-4 col-md-4"></div>
			<div class="col-lg-4 col-md-4 col-xs-12 p-2">
					<button type="button" class="btn btn-primary btn-lg btn-block" data-toggle="modal" data-target="#forAddSet">
					ADD SET
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


<div class="row">
	<div class="col-lg-1 col-md-1"></div>
	<div class="col-lg-10 col-md-10 col-xs-12 myRowBorder">
		<div class="mySubRowBorder">
			<u  style="color: #1222B5;"><h2 class="text-center">SETS WITH DETAILS</h2></u>
 			<h4 class="text-center text-info">Please check column Action for update and delete .</h4>
		</div>

		<div class="row">
			<div class="col-lg-12 col-md-12 col-xs-12">
				<table class="table table-striped">
					<thead class="myHeader" style="color: white;">
						<tr>
							<th class="text-center"><strong>Set_ID</strong></th>
							<th class="text-center"><strong>Set</strong></th>
							<th class="text-center"><strong>Created_at</strong></th>
							<th class="text-center"><strong>Status<strong></th>
							<th class="text-center"><strong>Action</strong></th>
							<th></th>
						</tr>
					</thead>
					<tbody>
						 <?php while ($set_rows=mysqli_fetch_assoc($cat_details_execute)) { ?>
						<tr align="center">
							<td><?php echo $set_rows['id']; ?></td>
							<td>
								<form action="" method="post">
							    	<input type="hidden" name="set_number" value="<?php echo($set_rows['set_id']); ?>">
							    	<button type="submit" class="btn btn-default myLoginBtn" name="view_set_details">SET <?php echo $set_rows['set_id']; ?></button>
							    </form>
							</td>
							<td><?php echo $set_rows['trn_date']; ?></td>

							<td>
									<?php if ($set_rows['is_active']==1) {?>
								<form method="post">
				                    <input type="hidden" name="deactivate_set_id" value="<?php echo($set_rows['id']); ?>">
				                    <input type="hidden" name="deactivate_set_name" value="<?php echo($set_rows['set_id']); ?>">
				                    <button type="submit" class="btn btn-danger" name="deactivate_set">Deactivate</button>
				                </form> 
				                    <?php }else{ ?>
				                <form method="post">
				                    <input type="hidden" name="activate_set_id" value="<?php echo($set_rows['id']); ?>">
				                    <input type="hidden" name="activate_set_name" value="<?php echo($set_rows['set_id']); ?>">
				                    <button type="submit" class="btn btn-success" name="activate_set">Activate</button>
				                </form>
				                    <?php } ?>
							</td>
							 
							<!-- <td>
								<button type="button" class="btn btn-primary" data-toggle="modal" data-target="#forUpdateSet">Edit</button>
							</td> -->

							<td>
								<form method="post">
									<input type="hidden" name="del_set_id" value="<?php echo $set_rows['id']; ?>">
									<input type="hidden" name="del_set_name" value="<?php echo $set_rows['set_id']; ?>">
									<button type="submit" class="btn btn-warning" name="del_sets"  onclick="return confirmDel();">Delete</button>
								</form>
							</td>
						</tr>
						<?php }  ?>
					</tbody>
				</table>
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

<!-- -----------------FOOTER-------------------- -->
<?php include 'footer.php'; ?>

<!-- ..........for adding Set............ -->

<div class="modal fade" id="forAddSet" tabindex="-1" role="dialog" aria-labelledby="forAddSet" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <!-- <h5 class="modal-title" id="forAddSet">Add Set</h5><br> -->
        <h5 class="modal-title text-danger" id="forAddSet">Please check previous set number before adding New one</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <div class="myForm">
        <!-- <span class="myFormTitle"><h2>Schools/College Login Form</h2></span> -->
            <form action="" method="post">
              <div class="form-group">
                  <label for="number">SET Number:</label>
                  <input type="number" class="form-control" id="number" placeholder="Enter Set Number" name="add_sets_number">
              </div>
                      <button type="submit" class="btn btn-primary" name="add_sets">Add Set</button>
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

<div class="modal fade" id="forUpdateSet" tabindex="-1" role="dialog" aria-labelledby="forUpdateSet" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="forUpdateSet">Enter New Set details</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <div class="myForm">
        <!-- <span class="myFormTitle"><h2>Schools/College Login Form</h2></span> -->
            <form action="" method="post">
              <div class="form-group">
                  <label for="number">Set Number:</label>
                  <input type="number" class="form-control" id="text" placeholder="Enter New Set number" name="add_exam_time">
              </div>
                      <button type="submit" class="btn btn-primary" name="add_category">Update Set</button>
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