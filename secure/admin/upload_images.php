<?php 
$album_name="";
$con=mysqli_connect("localhost","root","","admin_database"); 
if (isset($_POST['upload_img'])) {
	$album_name=$_POST['album_name'];
	$cover_img=$_FILES['cover_img'];
	$img_alt_text=$_POST['img_alt_text'];
	$upload_date=Date('Y-m-d-h-m-s-ms');
print_r($cover_img);
	$target="../gallery_album/";
	$img_name="ONLINE_ENTRANCE_GALLERY_".$album_name."_".$cover_img['name'];
	move_uploaded_file($cover_img['tmp_name'], $target.$img_name);

	$upload_query=@"INSERT INTO gallery_album(album_name,album_cover_image,album_cover_text,trn_date)VALUES('$album_name','$img_name','$img_alt_text','$upload_date')";
	$res=mysqli_query($con,$upload_query) or die(mysqli_error($con));
	if ($res==1) {
		print_r($cover_img);
		echo " UPLOAD SUCESS";
	}
	else{
		echo "FAILED TO UPLOAD";
	}
}


if (isset($_POST['upload_gallery_img'])) {
	$album_id=$_POST['album_id'];
	$gallery_img=$_FILES['gallery_img'];
	$img_alt_text=$_POST['img_alt_text'];
	$upload_date=Date('Y-m-d h:m:s');
// print_r($cover_img);
	$target="../gallery_images/";
	$img_name="ONLINE_ENTRANCE_GALLERY_".$album_name."_".$gallery_img['name'];
	move_uploaded_file($gallery_img['tmp_name'], $target.$img_name);

	$upload_query=@"INSERT INTO gallery_images(album_id,image_name,image_alt_text,trn_date)VALUES('$album_id','$img_name','$img_alt_text','$upload_date')";
	$res=mysqli_query($con,$upload_query) or die(mysqli_error($con));
	if ($res==1) {
		print_r($gallery_img);
		echo " UPLOAD SUCESS";
	}
	else{
		echo "FAILED TO UPLOAD";
	}
}
 
if (isset($_POST['upload_mov_img'])) {
	$mov_image=$_FILES['mov_img'];
	$mov_img_desc=$_POST['desc'];
	$mov_img_alt_text=$_POST['alt_text'];
	$upload_date=Date('Y-m-d h:m:s:ms');
	// echo (isset($_POST['submit']));
	echo $mov_image['name'];
	$target="../moving_image/";
	$img_name="ONLINE_ENTRANCE_MOVING_IMAGE".$mov_image['name'];
	move_uploaded_file($mov_image['tmp_name'], $target.$img_name);
	$upload_qry=@"INSERT INTO moving_img(img_details,img_name,img_alt_text,trn_date) VALUES('$mov_img_desc','$img_name','$mov_img_alt_text','$upload_date')";
	$res=mysqli_query($con,$upload_qry) or die(mysqli_error($con));
	if ($res==1) {
		print_r($mov_image);
		echo " UPLOAD SUCESS";
	}
	else{
		echo "FAILED TO UPLOAD";
	}

}

if (isset($_POST['upload_course'])) {
	$course_img=$_FILES['course_img'];
	$course_img_alt_text=$_POST['course_img_alt_text'];
	$course_header=$_POST['course_header'];
	$course_details=$_POST['course_details'];
	$extra_notes=$_POST['extra_notes'];
	$upload_date=Date('Y-m-d-h-m-s-ms');

	echo $course_img['name'];
	$target="../courses_available/";
	$img_name="ONLINE_ENTRANCE_COURSES_AVAILABLE".$course_img['name'];
	move_uploaded_file($course_img['tmp_name'], $target.$img_name);
	$submit_course_qry=@"INSERT INTO courses_available(course_header,course_details,extra_notes,img_name,img_alt_text,trn_date)VALUES('$course_header','$course_details','$extra_notes','$img_name','$course_img_alt_text','$upload_date')";
	$res=mysqli_query($con,$submit_course_qry) or die(mysqli_error($con));
	if ($res==1) {
		print_r($course_img);
		echo " UPLOAD SUCESS";
	}
	else{
		echo "FAILED TO UPLOAD";
	}

}


 ?>

<div>
	<p> CREATE ALBUM</p>
	<form action="" method="post" enctype="multipart/form-data">
		<input type="text" name="album_name" placeholder="Enter album name">
		<input type="file" name="cover_img" placeholder="Select cover img">
		<input type="text" name="img_alt_text" placeholder="Image alt text">
		<input type="submit" name="upload_img">
	</form>
</div>

<div>
	<p> UPLOAD GALLERY IMAGES</p>
	<form action="" method="post" enctype="multipart/form-data">
		<input type="number" name="album_id" placeholder="Enter album id">
		<input type="file" name="gallery_img" placeholder="Select cover img">
		<input type="text" name="img_alt_text" placeholder="Image alt text">
		<input type="submit" name="upload_gallery_img">
	</form>
</div>



 <div>
 	<p>MOVING IMG</p>
 	<form method="POST" action="" enctype="multipart/form-data">
 		<input type="file" name="mov_img">
 		<input type="text" name="alt_text">
 		<textarea placeholder="DESCRIPTION" name="desc"></textarea>
 		<input type="submit" name="upload_mov_img" value="upload">
 	</form>
 </div>

 <div>
 	<p>COURSES AVAILABLES</p>
 	<form method="post" action="" enctype="multipart/form-data">
 		<input type="file" name="course_img">
 		<input type="text" name="course_img_alt_text" placeholder="alternate text for image">
 		<input type="text" name="course_header" placeholder="Course header">
 		<input type="text" name="course_details" placeholder="Courses details">
 		<input type="text" name="extra_notes" placeholder="extra notes">
 		<input type="submit" name="upload_course" value="submit_course">
 	</form>
 </div>