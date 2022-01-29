<?php require_once 'secure/admin_database.php'; ?>
<?php 


$notice_query=@"SELECT * FROM notice WHERE is_active='1' ORDER BY id DESC";
$notice_res=mysqli_query($con_admin,$notice_query) or die(mysqli_error($con_admin));
// $total_num_notice=mysqli_num_rows($notice_res);
// echo $total_num_notice;
 ?>



<?php include("header.php") ?>
<?php include("nav.php") ?>

<head>
	<!-- <link rel="stylesheet" type="text/css" href="assests\css\downloads_style.css"> -->
	<title>ONLINE ENTRANCE-notice section</title>
</head>


<div class="row">
	<div class="col-lg-1 col-md-1"></div>
	<div class="col-lg-10 col-md-10 col-xs-12 myRowBorder">
		<div class="mySubRowBorder">
			<u  style="color: #1222B5;"><h2 class="text-center">NOTICE SECTIONS</h2></u>
 			<h4 class="text-center text-info">Please check column Action to downloading</h4>
		</div>

		<div class="row">
			<div class="col-lg-12 col-md-12 col-xs-12">
				<table class="table table-striped">
					<thead>
						<tr>
							<th class="text-center"><strong>S.N.</strong></th>
							<th class="text-center"><strong>Title<strong></th>
							<th class="text-center"><strong>Upload date</strong></th>
							<th class="text-center"><strong>Action</strong></th>
						</tr>
					</thead>
					<tbody>
						<?php  $j=1; 

							while ($notice_rows=mysqli_fetch_assoc($notice_res)) {?>
						<tr align="center">
							<td><?php echo $j; ?></td>
							<td><?php echo $notice_rows['notice_title']; ?></td>
							<td><?php echo $notice_rows['trn_date'] ?></td>
							<td><a href="secure/notice/<?php echo($notice_rows['file_name']);?>" download><button class="btn btn-default myLoginBtn">download</button></a></td>
						</tr>
						<?php $j=$j+1; }  ?>
					</tbody>
				</table>
			</div>
		</div>
	</div>
	<div class="col-lg-1 col-md-1"></div>
</div>

<?php include("footer.php") ?>