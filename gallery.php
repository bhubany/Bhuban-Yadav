<?php require_once 'secure/admin_database.php'; ?>
<?php include 'header.php';?>
<?php include 'nav.php'; ?>

<head>
  <title>Gallery-Online Entrance</title>
	<link rel="stylesheet" type="text/css" href="assests/css/gallery_style.css">
</head>

<style type="text/css">

	.album_div>ul>li{
		list-style: none;
	}
	.album_div>ul>li{
		display: inline-block;
		line-height: 25px;
		padding: 0px 20px;	
	}
	.album_div>ul>li>form>p>img{
		height: 150px;
		width: 150px;
		transition: 1s;
	}
	.album_div>ul>li>form>p>img:hover{
		filter: grayscale(100%);
		transform: scale(1.1);
	}
	.movingImg{
	height: 500px;
	width: auto;
}
</style>



<div class="row">
	<div class="col-lg-1 col-md-1"></div>

    <div class="col-lg-10 col-md-10 col-xs-12 myRowBorder">

					<?php
					$mov_img_qry=@"SELECT * FROM gallery_images WHERE album_id='8' AND is_active='1'";
					$mov_res=mysqli_query($con_admin,$mov_img_qry) or die($con_admin);
					  ?>

					<!-- ----------------STARTING OF MOVING IMAGES-------------- -->

	    <div id="carouselExampleIndicators" class="carousel slide" data-ride="carousel">

	    	<!-- ---------------STARTING OF IMAGE SELECTION DIV------------- -->
 			<div class="carousel-inner">
    
			    <div class="carousel-item active">
			      	<img class="rounded mx-auto d-block movingImg" src="secure/gallery_images/welcome_img.jpg" alt="Default image of online entrance model test">
			    </div>
			    				  	
			    	<?php $i=1; while($mov_rows=mysqli_fetch_assoc($mov_res)){?>

			    <div class="carousel-item text-center">
			      	<img class="rounded mx-auto d-block movingImg" src="secure/gallery_images/<?php echo($mov_rows['image_name']); ?>" alt="<?php echo($mov_rows['image_alt_text']); ?>">

			  		<div class="carousel-caption d-none d-md-block">
			    		<h5><?php echo $mov_rows['image_text']; ?></h5>
			  		</div>

				</div>

			     <?php $i=$i+1;} ?>
			</div>

			<!-- ==============ENDING OF IMAGE SELECTION DIV=================== -->


	 		<!-- ------------------------STARTING OF IMAGE INDICATOR----------------------------- -->
		    <ol class="carousel-indicators">
			    <li data-target="#carouselExampleIndicators" data-slide-to="0" class="active"></li>
			    	
			    		<?php for ($j=1; $j <$i ; $j++) { ?> 
			    <li data-target="#carouselExampleIndicators" data-slide-to="<?php echo($j); ?>"></li>
			  			<?php } ?>
			</ol>
		 	<!-- ------------------------ENDING OF IMAGE INDICATOR----------------------------- -->

			<!-- -----------------------------PREVIOUS NEXT ICON------------------------ -->
		   <a class="carousel-control-prev" href="#carouselExampleIndicators" role="button" data-slide="prev">
		    	<span class="carousel-control-prev-icon" aria-hidden="true"></span>
		    	<span class="fa fa-arrow-circle-left" style="color: black; font-size: 40px;"></span>
		  </a>

		  <a class="carousel-control-next" href="#carouselExampleIndicators" role="button" data-slide="next">
		    	<span class="carousel-control-next-icon" aria-hidden="true"></span>
		    	<span class="fa fa-arrow-circle-right" style="color: black; font-size: 40px;"></span>
		  </a>

 		 <!-- -----------------------CLOSING OF PREVIOUS NEXT ICONS-------------------------- -->
		</div>	<!-- ---------------CLOSING OF MOVING IMAGE -->
	</div>

	<div class="col-lg-1 col-md-1"></div>
</div>

<!-- *********************HEADER********************** -->

<div class="row">
	<div class="col-lg-1 col-md-1"></div>
	<div class="col-lg-10 col-md-10 col-xs-12 mySubRowBorder" style="background-color: #f2f2f2">
		<u  style="color: #1222B5;"><h2 class="text-center">ALBUMS</h2></u>
		<h4 class="text-center text-info">Please read the following informations carefully before starting the exams.</h4>
	</div>
	<div class="col-lg-1 col-md-1"></div>
</div>


<!-- ***********************ALBUM NAMES*********************** -->

<div class="row">
	<div class="col-lg-1 col-md-1"></div>
	<div class="col-lg-10 col-md-10 col-xs-12 myRowBorder"><br>
				<?php 
					$img_view=@"SELECT * FROM gallery_album WHERE is_active='1'";
					$img_res=mysqli_query($con_admin,$img_view) or die(mysqli_error($con_admin));
					 ?>
 		<div class="album_div">
		 	<ul>
		 		<?php while ($img_rows=mysqli_fetch_assoc($img_res)) { ?>
		 		<li>
		 			<form action="gallery_main.php" method="post" enctype="multipart/form-data">
		 				<p>
		 					<img class="img-thumbnail" src="secure/gallery_album/<?php echo($img_rows['album_cover_image']); ?>" alt="<?php echo($img_rows['album_cover_alt_text']); ?>">
		 				</p>

		 				<input type="hidden" name="album_name" value="<?php echo($img_rows['album_name']); ?>">

		 				<input type="hidden" name="album_id" value="<?php echo($img_rows['id']); ?>"><br>

		 				<p>
		 					<button type="submit" class="btn btn-default myLoginBtn" name="view_album"  id="view_album"><?php echo($img_rows['album_name']); ?>
		 					</button>
		 				</p>
		 				
		 			</form>
		 		</li>
		 		<?php } ?>
		 	</ul>
 		</div>
	</div>
	<div class="col-lg-1 col-md-1"></div>
</div>


<!-- ****************FOOTER*************** -->
<?php include 'footer.php' ?>