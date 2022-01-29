<?php 
	require 'auth.php';
	require 'secure/admin_database.php';
	require 'includes/functions.php';
?>
<?php 

$i=1;
$field_id="";



if (clean_values($con_admin,isset($_POST['submit']))) {
	$_SESSION['field_id']=clean_values($con_admin,$_POST['cat']);
}
 if (!isset($_SESSION['field_id'])) {
	header("Location:download_function.php");
}
$field_id=clean_values($con_admin,$_SESSION['field_id']);
$download_query=@"SELECT * FROM downloads WHERE field_id='$field_id' AND is_active='1' ORDER BY id DESC ";
$download_res=mysqli_query($con_admin,$download_query) or die(mysqli_error($con_admin));
 ?>


<?php include("header.php") ?>
<?php include("nav.php") ?>



<head>
	<title>ONLINE ENTRANCE-download section</title>
</head>


<div class="row">
	<div class="col-lg-1 col-md-1"></div>
	<div class="col-lg-10 col-md-10 col-xs-12 myRowBorder">
		<div class="mySubRowBorder">
			<u  style="color: #1222B5;"><h2 class="text-center">DOWNLOAD SECTIONS</h2></u>
 			<h4 class="text-center text-info">Click on the sets to download that question and answer presents on that columns</h4>
		</div>


		<div class="row">
			<div class="col-lg-12 col-md-12 col-xs-12">
				<button class="btn btn-default btn-lg btn-block myHeader" style="color: #fff;">PLEASE SELECT QUESTIONS SET</button>
			</div>
		</div>

			<div class="row">
				<div class="col-lg-12 col-md-12 col-xs-12">
	 				<table class="table table-striped">
						<thead>
							<tr>
								<th class="text-center"><strong>S.N.</strong></th>
								<th class="text-center"><strong>Questi<span class="red">o</span>ns</strong></th>
								<th class="text-center"><strong>Answers</strong></th>
								<th class="text-center"><strong>Upl<span class="red">o</span>ad date</strong></th>
							</tr>
						</thead>
						<tbody>
							<?php
								if (mysqli_num_rows($download_res)>0) { 
									while ($download_rows=mysqli_fetch_assoc($download_res)) { ?>
							<tr align="center">
								<td><?php echo $i; ?></td>
								<td>
									<a download="" href="secure/downloads/<?php echo $download_rows['questions'];?>">
				 						<button type="submit" value="submit" name="submit" class="btn btn-default myLoginBtn">SET <?php echo $download_rows['question_set']; ?>
				 							
				 						</button>
				 					</a>
								</td>

								<td>
									<a download="" href="secure/downloads/<?php echo $download_rows['answers'];?>">
										<button type="submit" value="submit" name="submit" class="btn btn-default myLoginBtn">SET <?php echo $download_rows['question_set']; ?>
										</button>
									</a>
								</td>
								
								<td>
									<?php echo $download_rows['trn_date']; ?>
								</td>
							</tr>
						<?php $i=$i+1; } ?>
						</tbody>
					<?php	}else{?> <h2 class='align-center alert alert-warning'>Not any files are availables for downloads. Try again later.</h2><?php } ?>
					</table>
				</div>
 			</div>
		</div>
	</div>
	<div class="col-lg-1 col-md-1"></div>
</div>



<?php include("footer.php") ?>