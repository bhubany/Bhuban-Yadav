<?php
if(!session_id()){
  session_start();
}?>

<?php 
require 'acess.php';
date_default_timezone_set("Asia/Kathmandu");
$upload_date=Date('Y-m-d h:m:s');
$errors=array();
$Sucess="";
require 'admin_database.php';
require 'exam_database.php';
require 'user_database.php';
require 'discussion_database.php';


// --------------------------FOR UPDATING FAQ----------------

if (isset($_POST['update_id']) && isset($_POST['update_id'])!="") {
	$faq_id=$_POST['update_id'];
	$faq_qry=@"SELECT * FROM faq WHERE id='$faq_id'";
	$faq_result=mysqli_query($con_admin,$faq_qry) or die($con_admin);

	$faq_response=array();

	if (mysqli_num_rows($faq_result)>0) {
		while ($faq_rows=mysqli_fetch_assoc($faq_result)) {
			$faq_response=$faq_rows;
		}
	}else{
		$faq_response['status']= 200;
		$faq_response['message']="Data not Found";
	}

	// -----------------PHP BUILT IN FUNCTION ----------------
	echo json_encode($faq_response);
}else{
	$faq_response['status']=200;
	$faq_response['message']="Invalid Request";
}


// ------------------FOR VIEWING FAQ------------------

if (isset($_POST['view_faq_id']) && isset($_POST['view_faq_id'])!="") {
	$faq_id=$_POST['view_faq_id'];
	$faq_qry=@"SELECT * FROM faq WHERE id='$faq_id'";
	$faq_result=mysqli_query($con_admin,$faq_qry) or die($con_admin);

	$faq_response=array();

	if (mysqli_num_rows($faq_result)>0) {
		while ($faq_rows=mysqli_fetch_assoc($faq_result)) {
			$faq_response=$faq_rows;
		}
	}else{
		$faq_response['status']= 200;
		$faq_response['message']="Data not Found";
	}

	// -----------------PHP BUILT IN FUNCTION ----------------
	echo json_encode($faq_response);
}else{
	$faq_response['status']=200;
	$faq_response['message']="Invalid Request";
}


// --------------------------FOR UPDATING CATEGORY----------------

if (isset($_POST['update_cat_id']) && isset($_POST['update_cat_id'])!="") {
	$cat_id=$_POST['update_cat_id'];
	$cat_qry=@"SELECT * FROM category_name WHERE id='$cat_id'";
	$cat_res=mysqli_query($con_exam,$cat_qry) or die($con_exam);

	$cat_response=array();

	if (mysqli_num_rows($cat_res)>0) {
		while ($cat_rows=mysqli_fetch_assoc($cat_res)) {
			$cat_response=$cat_rows;
		}
	}else{
		$cat_response['status']= 200;
		$cat_response['message']="Data not Found";
	}

	// -----------------PHP BUILT IN FUNCTION ----------------
	echo json_encode($cat_response);
}else{
	$cat_response['status']=200;
	$cat_response['message']="Invalid Request";
}


// --------------------------FOR UPDATING Questions /set details----------------

if (isset($_POST['update_question_id']) && isset($_POST['update_question_id'])!="") {
	$question_id=$_POST['update_question_id'];
	$set_qry=@"SELECT * FROM questions_collections WHERE id='$question_id'";
	$set_res=mysqli_query($con_exam,$set_qry) or die($con_exam);

	$set_response=array();

	if (mysqli_num_rows($set_res)>0) {
		while ($set_rows=mysqli_fetch_assoc($set_res)) {
			$set_response=$set_rows;
		}
	}else{
		$set_response['status']= 200;
		$set_response['message']="Data not Found";
	}

	// -----------------PHP BUILT IN FUNCTION ----------------
	echo json_encode($set_response);
}else{
	$set_response['status']=200;
	$set_response['message']="Invalid Request";
}


// --------------------------FOR Viewing Questions /set details----------------

if (isset($_POST['view_question_id']) && isset($_POST['view_question_id'])!="") {
	$question_id=$_POST['view_question_id'];
	$set_qry=@"SELECT * FROM questions_collections WHERE id='$question_id'";
	$set_res=mysqli_query($con_exam,$set_qry) or die($con_exam);

	$set_response=array();

	if (mysqli_num_rows($set_res)>0) {
		while ($set_rows=mysqli_fetch_assoc($set_res)) {
			$set_response=$set_rows;
		}
	}else{
		$set_response['status']= 200;
		$set_response['message']="Data not Found";
	}

	// -----------------PHP BUILT IN FUNCTION ----------------
	echo json_encode($set_response);
}else{
	$set_response['status']=200;
	$set_response['message']="Invalid Request";
}

// $question_details_qry=@"SELECT * FROM questions_collections WHERE field_id='$cat_details_id' AND question_set='$set_number'";
// $question_details_execute=mysqli_query($con_exam,$question_details_qry) or die($con_exam);


// --------------------------FOR UPDATING Course availables----------------

if (isset($_POST['update_course_id']) && isset($_POST['update_course_id'])!="") {
	$course_id=$_POST['update_course_id'];
	$course_qry=@"SELECT * FROM courses_available WHERE id='$course_id'";
	$course_result=mysqli_query($con_admin,$course_qry) or die($con_admin);

	$course_response=array();

	if (mysqli_num_rows($course_result)>0) {
		while ($course_rows=mysqli_fetch_assoc($course_result)) {
			$course_response=$course_rows;
		}
	}else{
		$course_response['status']= 200;
		$course_response['message']="Data not Found";
	}

	// -----------------PHP BUILT IN FUNCTION ----------------
	echo json_encode($course_response);
}else{
	$course_response['status']=200;
	$course_response['message']="Invalid Request";
}


// ------------------FOR VIEWING Courses avilables------------------

if (isset($_POST['view_course_id']) && isset($_POST['view_course_id'])!="") {
	$course_id=$_POST['view_course_id'];
	$course_qry=@"SELECT * FROM courses_available WHERE id='$course_id'";
	$course_result=mysqli_query($con_admin,$course_qry) or die($con_admin);



	$course_response=array();

	if (mysqli_num_rows($course_result)>0) {
		while ($course_rows=mysqli_fetch_assoc($course_result)) {
			$course_response=$course_rows;
		}
	}else{
		$course_response['status']= 200;
		$course_response['message']="Data not Found";
	}

	// -----------------PHP BUILT IN FUNCTION ----------------
	echo json_encode($course_response);
}else{
	$course_response['status']=200;
	$course_response['message']="Invalid Request";
}

// ----------------------UPDATING GALLERY ALBUMS--------------------
if (isset($_POST['update_gallery_id']) && isset($_POST['update_gallery_id'])!="") {
	$gallery_id=$_POST['update_gallery_id'];
	$gallery_qry=@"SELECT * FROM gallery_album WHERE id='$gallery_id'";
	$gallery_result=mysqli_query($con_admin,$gallery_qry) or die($con_admin);

	$gallery_response=array();

	if (mysqli_num_rows($gallery_result)>0) {
		while ($gallery_rows=mysqli_fetch_assoc($gallery_result)) {
			$gallery_response=$gallery_rows;
		}
	}else{
		$gallery_response['status']= 200;
		$gallery_response['message']="Data not Found";
	}

	// -----------------PHP BUILT IN FUNCTION ----------------
	echo json_encode($gallery_response);
}else{
	$gallery_response['status']=200;
	$gallery_response['message']="Invalid Request";
}


// ----------------------UPDATING Image of ALBUMS--------------------
if (isset($_POST['update_image_id']) && isset($_POST['update_image_id'])!="") {
	$image_id=$_POST['update_image_id'];
	$image_qry=@"SELECT * FROM gallery_images WHERE id='$image_id'";
	$image_result=mysqli_query($con_admin,$image_qry) or die($con_admin);

	$image_response=array();

	if (mysqli_num_rows($image_result)>0) {
		while ($image_rows=mysqli_fetch_assoc($image_result)) {
			$image_response=$image_rows;
		}
	}else{
		$image_response['status']= 200;
		$image_response['message']="Data not Found";
	}

	// -----------------PHP BUILT IN FUNCTION ----------------
	echo json_encode($image_response);
}else{
	$image_response['status']=200;
	$image_response['message']="Invalid Request";
}


// ----------------------UPDATING Notice--------------------
if (isset($_POST['update_notice_id']) && isset($_POST['update_notice_id'])!="") {
	$notice_id=$_POST['update_notice_id'];
	$notice_qry=@"SELECT * FROM notice WHERE id='$notice_id'";
	$notice_result=mysqli_query($con_admin,$notice_qry) or die($con_admin);

	$notice_response=array();

	if (mysqli_num_rows($notice_result)>0) {
		while ($notice_rows=mysqli_fetch_assoc($notice_result)) {
			$notice_response=$notice_rows;
		}
	}else{
		$notice_response['status']= 200;
		$notice_response['message']="Data not Found";
	}

	// -----------------PHP BUILT IN FUNCTION ----------------
	echo json_encode($notice_response);
}else{
	$notice_response['status']=200;
	$notice_response['message']="Invalid Request";
}


// ----------------------UPDATING Recent Events From Notice--------------------
if (isset($_POST['update_event_id']) && isset($_POST['update_event_id'])!="") {
	$event_id=$_POST['update_event_id'];
	$event_qry=@"SELECT * FROM recent_event WHERE id='$event_id'";
	$event_result=mysqli_query($con_admin,$event_qry) or die($con_admin);

	$event_response=array();

	if (mysqli_num_rows($event_result)>0) {
		while ($event_rows=mysqli_fetch_assoc($event_result)) {
			$event_response=$event_rows;
		}
	}else{
		$event_response['status']= 200;
		$event_response['message']="Data not Found";
	}

	// -----------------PHP BUILT IN FUNCTION ----------------
	echo json_encode($event_response);
}else{
	$event_response['status']=200;
	$event_response['message']="Invalid Request";
}



// ----------------------UPDATING Download Category--------------------
if (isset($_POST['update_download_cat_id']) && isset($_POST['update_download_cat_id'])!="") {
	$cat_id=$_POST['update_download_cat_id'];
	$cat_qry=@"SELECT * FROM category_name WHERE id='$cat_id'";
	$cat_result=mysqli_query($con_admin,$cat_qry) or die($con_admin);

	$cat_response=array();

	if (mysqli_num_rows($cat_result)>0) {
		while ($cat_rows=mysqli_fetch_assoc($cat_result)) {
			$cat_response=$cat_rows;
		}
	}else{
		$cat_response['status']= 200;
		$cat_response['message']="Data not Found";
	}

	// -----------------PHP BUILT IN FUNCTION ----------------
	echo json_encode($cat_response);
}else{
	$cat_response['status']=200;
	$cat_response['message']="Invalid Request";
}


// ----------------------UPDATING SETS OF Download Category--------------------
if (isset($_POST['update_download_id']) && isset($_POST['update_download_id'])!="") {
	$download_id=$_POST['update_download_id'];
	$download_qry=@"SELECT * FROM downloads WHERE id='$download_id'";
	$download_result=mysqli_query($con_admin,$download_qry) or die($con_admin);

	$download_response=array();

	if (mysqli_num_rows($download_result)>0) {
		while ($download_rows=mysqli_fetch_assoc($download_result)) {
			$download_response=$download_rows;
		}
	}else{
		$download_response['status']= 200;
		$download_response['message']="Data not Found";
	}

	// -----------------PHP BUILT IN FUNCTION ----------------
	echo json_encode($download_response);
}else{
	$download_response['status']=200;
	$download_response['message']="Invalid Request";
}


//--------For Viewing User Details on all_users.php-----------
if (isset($_POST['view_user_id']) && isset($_POST['view_user_id'])!="") {
	$user_id=$_POST['view_user_id'];
	$user_qry=@"SELECT * FROM user_information WHERE id=$user_id LIMIT 1";
	$user_result=mysqli_query($con_user,$user_qry) or die($con_user);

	$user_response=array();

	if (mysqli_num_rows($user_result)>0) {
		while ($user_rows=mysqli_fetch_assoc($user_result)) {
			$user_response=$user_rows;
		}
	}else{
		$user_response['status']= 200;
		$user_response['message']="Data not Found";
	}

	// -----------------PHP BUILT IN FUNCTION ----------------
	echo json_encode($user_response);
}else{
	$user_response['status']=200;
	$user_response['message']="Invalid Request";
}


//--------For Updating discussion category-----------
if (isset($_POST['update_discussion_cat_id']) && isset($_POST['update_discussion_cat_id'])!="") {
	$cat_id=$_POST['update_discussion_cat_id'];
	$cat_qry=@"SELECT * FROM category_name WHERE id=$cat_id LIMIT 1";
	$cat_result=mysqli_query($con_discussion,$cat_qry) or die($con_discussion);

	$cat_discussion_response=array();

	if (mysqli_num_rows($cat_result)>0) {
		while ($cat_rows=mysqli_fetch_assoc($cat_result)) {
			$cat_discussion_response=$cat_rows;
		}
	}else{
		$cat_discussion_response['status']= 200;
		$cat_discussion_response['message']="Data not Found";
	}

	// -----------------PHP BUILT IN FUNCTION ----------------
	echo json_encode($cat_discussion_response);
}else{
	$cat_discussion_response['status']=200;
	$cat_discussion_response['message']="Invalid Request";
}

//--------For Updating discussion category details-----------
if (isset($_POST['update_discussion_subject_id']) && isset($_POST['update_discussion_subject_id'])!="") {
	$subject_id=$_POST['update_discussion_subject_id'];
	$subject_qry=@"SELECT * FROM subjects_name WHERE id=$subject_id LIMIT 1";
	$subject_result=mysqli_query($con_discussion,$subject_qry) or die($con_discussion);

	$subject_discussion_response=array();

	if (mysqli_num_rows($subject_result)>0) {
		while ($subject_rows=mysqli_fetch_assoc($subject_result)) {
			$subject_discussion_response=$subject_rows;
		}
	}else{
		$subject_discussion_response['status']= 200;
		$subject_discussion_response['message']="Data not Found";
	}

	// -----------------PHP BUILT IN FUNCTION ----------------
	echo json_encode($subject_discussion_response);
}else{
	$subject_discussion_response['status']=200;
	$subject_discussion_response['message']="Invalid Request";
}

//--------For Updating discussion subject question category details-----------
if (isset($_POST['update_discussion_subject_question_id']) && isset($_POST['update_discussion_subject_question_id'])!="") {
	$update_dis_question_id=$_POST['update_discussion_subject_question_id'];
	$update_question_qry=@"SELECT * FROM questions WHERE id=$update_dis_question_id LIMIT 1";
	$update_question_result=mysqli_query($con_discussion,$update_question_qry) or die($con_discussion);

	$update_question_subject_discussion_response=array();

	if (mysqli_num_rows($update_question_result)>0) {
		while ($update_question_rows=mysqli_fetch_assoc($update_question_result)) {
			$update_question_subject_discussion_response=$update_question_rows;
		}
	}else{
		$update_question_subject_discussion_response['status']= 200;
		$update_question_subject_discussion_response['message']="Data not Found";
	}

	// -----------------PHP BUILT IN FUNCTION ----------------
	echo json_encode($update_question_subject_discussion_response);
}else{
	$update_question_subject_discussion_response['status']=200;
	$update_question_subject_discussion_response['message']="Invalid Request";
}


//--------For viewing discussion subject question category details-----------
if (isset($_POST['view_discussion_subject_question_id']) && isset($_POST['view_discussion_subject_question_id'])!="") {
	$question_id=$_POST['view_discussion_subject_question_id'];
	$question_qry=@"SELECT * FROM questions WHERE id=$question_id LIMIT 1";
	$question_result=mysqli_query($con_discussion,$question_qry) or die($con_discussion);

	$question_subject_discussion_response=array();

	if (mysqli_num_rows($question_result)>0) {
		while ($question_rows=mysqli_fetch_assoc($question_result)) {
			$question_subject_discussion_response=$question_rows;
		}
	}else{
		$question_subject_discussion_response['status']= 200;
		$question_subject_discussion_response['message']="Data not Found";
	}

	// -----------------PHP BUILT IN FUNCTION ----------------
	echo json_encode($question_subject_discussion_response);
}else{
	$question_subject_discussion_response['status']=200;
	$question_subject_discussion_response['message']="Invalid Request";
}

//--------For Updating discussion subject question replies category details-----------
if (isset($_POST['update_discussion_subject_question_replies_id']) && isset($_POST['update_discussion_subject_question_replies_id'])!="") {
	$replies_id=$_POST['update_discussion_subject_question_replies_id'];
	$question_replies_qry=@"SELECT * FROM replies WHERE id=$replies_id LIMIT 1";
	$question_replies_result=mysqli_query($con_discussion,$question_replies_qry) or die($con_discussion);

	$question_subject_discussion_replies_response=array();

	if (mysqli_num_rows($question_replies_result)>0) {
		while ($question_replies_rows=mysqli_fetch_assoc($question_replies_result)) {
			$question_subject_discussion_replies_response=$question_replies_rows;
		}
	}else{
		$question_subject_discussion_replies_response['status']= 200;
		$question_subject_discussion_replies_response['message']="Data not Found";
	}

	// -----------------PHP BUILT IN FUNCTION ----------------
	echo json_encode($question_subject_discussion_replies_response);
}else{
	$question_subject_discussion_replies_response['status']=200;
	$question_subject_discussion_replies_response['message']="Invalid Request";
}

//--------For Viewing discussion subject question replies category details-----------
if (isset($_POST['view_discussion_subject_question_replies_id']) && isset($_POST['view_discussion_subject_question_replies_id'])!="") {
	$view_replies_id=$_POST['view_discussion_subject_question_replies_id'];
	$view_question_replies_qry=@"SELECT * FROM replies WHERE id=$view_replies_id LIMIT 1";
	$view_question_replies_result=mysqli_query($con_discussion,$view_question_replies_qry) or die($con_discussion);

	$view_question_subject_discussion_replies_response=array();

	if (mysqli_num_rows($view_question_replies_result)>0) {
		while ($view_question_replies_rows=mysqli_fetch_assoc($view_question_replies_result)) {
			$view_question_subject_discussion_replies_response=$view_question_replies_rows;
		}
	}else{
		$view_question_subject_discussion_replies_response['status']= 200;
		$view_question_subject_discussion_replies_response['message']="Data not Found";
	}

	// -----------------PHP BUILT IN FUNCTION ----------------
	echo json_encode($view_question_subject_discussion_replies_response);
}else{
	$view_question_subject_discussion_replies_response['status']=200;
	$view_question_subject_discussion_replies_response['message']="Invalid Request";
}



//--------For Viewing users feedback on all feedbacks-----------
if (isset($_POST['view_user_feedback_id']) && isset($_POST['view_user_feedback_id'])!="") {
	$view_user_feedback_id=$_POST['view_user_feedback_id'];
	$view_user_feedback_qry=@"SELECT * FROM users_feedback WHERE id=$view_user_feedback_id LIMIT 1";
	$view_user_feedback_result=mysqli_query($con_admin,$view_user_feedback_qry) or die($con_admin);

	$view_user_feedback_response=array();

	if (mysqli_num_rows($view_user_feedback_result)>0) {
		while ($view_user_feedback_rows=mysqli_fetch_assoc($view_user_feedback_result)) {
			$view_user_feedback_response=$view_user_feedback_rows;
		}
	}else{
		$view_user_feedback_response['status']= 200;
		$view_user_feedback_response['message']="Data not Found";
	}

	// -----------------PHP BUILT IN FUNCTION ----------------
	echo json_encode($view_user_feedback_response);
}else{
	$view_user_feedback_response['status']=200;
	$view_user_feedback_response['message']="Invalid Request";
}



?>


