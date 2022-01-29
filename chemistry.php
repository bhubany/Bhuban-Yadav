<?php 
// session_start();
require 'discussion_db.php';

$query_question="SELECT * FROM chemistry";
$question_result=mysqli_query($con,$query_question) or die(mysqli_error($con));
$number_of_rows=mysqli_num_rows($question_result);
$limit=$number_of_rows-5;

 ?>


 	<title>Questions and Discussion-Chemistry-cs</title>
 	<link rel="stylesheet" type="text/css" href="assests/css/discussion_questions_style.css">
 <div>

 	 <div class="subject_name">CHEMISTRY</div>


 	<?php
	for ($i=$number_of_rows; $i >$limit ; $i--) { 
		$question="SELECT * FROM chemistry WHERE id=$i LIMIT 1";
		$question_result=mysqli_query($con,$question);
		while ($row=mysqli_fetch_assoc($question_result)) {
			$question_id=$i;
			?>

 	<div>
 	<br>
 <div id="chemistry" class="subject_questions">


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

 			<span>
 			<img  style="height: 80px; width: auto; border-radius: 60px;" src="assests\icons\profile.png">
 			</span>
	</div>

 	<!-- <div> -->
 	<div style="text-align: center;">
 			<?php echo $row['question']; ?>
 	</div>
 	
<div  style="text-align: right;">

	<form action="discussion_answers.php" method="post">
		<input type="hidden" name="subject" value="c">
		<input type="hidden" name="id" value="<?php echo $question_id ?>">
		<button type="submit" value="" name="goto_replies">REPLIES</button>
	</form> 

	<!-- send id from here and that will shows answers of questions save on that id -->

</div>
 		</div>

 	<!-- </div> -->
 <?php  } ?>
 <!-- </div> -->
 <?php } ?>
 </div>

 <div class="view_all">
	<h3><a href="aptitude_all.php">VIEW ALL QUESTIONS OF CHEMISTRY</a></h3>
</div>