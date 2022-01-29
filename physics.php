<?php 
// session_start();
require 'discussion_db.php';

// $query_question="SELECT * FROM questions WHERE category_id='$field_id' AND subject_id='$subject_id'";
// $question_result=mysqli_query($con_discussion,$query_question) or die(mysqli_error($con_discussion));
// $number_of_rows=mysqli_num_rows($question_result);
// echo $number_of_rows;
// $limit=$number_of_rows-5;

 ?>
 	<title>Questions and Discussion-Physics-cs</title>
<link rel="stylesheet" type="text/css" href="assests/css/discussion_questions_style.css">
 
 <div>

 	 <div class="subject_name"><?php echo strtoupper($sub_name); ?></div>


 	<?php
 	$i=1;
	// for ($i=$number_of_rows; $i >0 ; $i--) { 
		$question="SELECT * FROM questions WHERE category_id='$field_id' AND subject_id='$subject_id'";
		$question_result=mysqli_query($con_discussion,$question);
		while ($row=mysqli_fetch_assoc($question_result)) {
			$question_id=$i;
			?>

 	<div>
 	<br>
 <div id="physics" class="subject_questions">


	<div style="text-align:right;">

		<span style="font-weight: bold;">
 			<?php echo $row['name']; ?>
 		</span>

 		<span style=" font-style: oblique;">
 			<?php echo $row['trn_date']; ?>
 		</span>

 	</div>

 	<!-- <div> -->

 	<div style="text-align: left;">
 			<span>
 			Q.N:<?php echo $question_id; ?>
 			</span>

 			<span class="profile_img">
 			<img src="assests\icons\profile.png">
 			</span>
	</div>

 	<!-- <div> -->
 	<div style="text-align: center;">
 			<?php echo $row['question']; ?>
 	</div>
 	
<div  style="text-align: right;">

	<form action="discussion_answers.php" method="post">
		<input type="hidden" name="subject" value="p">
		<input type="hidden" name="id" value="<?php echo $question_id ?>">
		<button type="submit" value="" name="goto_replies">REPLIES</button>
	</form> 

	<!-- send id from here and that will shows answers of questions save on that id -->

</div>
 		</div>

 	<!-- </div> -->
 <?php $i++; } ?>
 <!-- </div> -->
 <?php// } ?>
 		
</div>

<!--  <div class="view_all_qsn">
	<h3><a href="aptitude_all.php">VIEW ALL QUESTIONS OF PHYSICS</a></h3>
</div> -->