 <?php require_once 'secure/admin_database.php'; ?>
<?php
session_start();
$album_name="";
$album_id="";

if (isset($_POST['view_album'])) {
	$_SESSION['album_id']=$_POST['album_id'];
	$_SESSION['album_name']=$_POST['album_name'];
}
if (!isset($_SESSION['album_id']) or !isset($_SESSION['album_name'])) {
	header("Location:gallery.php");
}

$album_name=$_SESSION['album_name'];
$album_id=$_SESSION['album_id'];

$view_images=@"SELECT * FROM gallery_images WHERE album_id='$album_id' AND is_active='1' ORDER BY id DESC ";
$view_res=mysqli_query($con_admin,$view_images) or die($con_admin);
 ?>

<?php include 'header.php';?>
<?php include 'nav.php'; ?>

<head>
  <title>Gallery-Online Entrance</title>
	<link rel="stylesheet" type="text/css" href="assests/css/lightbox.min.css">
	<script type="text/javascript" src="assests/js/lightbox-plus-jquery.min.js"></script>
</head>

<style type="text/css">
		.gallery{
		margin: 10px 50px;
	}
	.gallery img{
		transition: 1s;
		padding: 15px;
		width: 280px;
	}
	.gallery img:hover{
		filter: grayscale(100%);
		transform: scale(1.1);
	}
</style>


<!-- ************GALLERY HEADER***************** -->

<div class="row">
	<div class="col-lg-1 col-md-1"></div>
	<div class="col-lg-10 col-md-10 col-xs-12 mySubRowBorder" style="background-color: #f2f2f2">
		<u  style="color: #1222B5;"><h2 class="text-center"><?php echo $album_name; ?></h2></u>
		<!-- <h4 class="text-center text-info">Please read the following informations carefully before starting the exams.</h4> -->
	</div>
	<div class="col-lg-1 col-md-1"></div>
</div>

<!-- ****************GALERY IMAGES********************** -->

<div class="row">
	<div class="col-lg-1 col-md-1"></div>
	<div class="col-lg-10 col-md-10 col-xs-12 myRowBorder"><br>
		<div class="gallery">
			<?php while ($view_rows=mysqli_fetch_assoc($view_res)) {  ?>
			<a href="secure/gallery_images/<?php echo($view_rows['image_name']); ?>" data-lightbox="mygallery" data-title="<?php echo($view_rows['image_text']); ?>"><img src="secure/gallery_images/<?php echo($view_rows['image_name']); ?>" alt="<?php echo($view_rows['image_alt_text']); ?>">
			</a>
			<?php } ?>
		</div>
	</div>
	<div class="col-lg-1 col-md-1"></div>
</div>


<!-- *****************FOOTER************************ -->
<?php include 'footer.php' ?>