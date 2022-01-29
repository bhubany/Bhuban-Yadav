<?php 
session_start();
require 'discussion_db.php';

$query_question="SELECT * FROM physics";
$question_result=mysqli_query($con,$query_question) or die(mysqli_error($con));
$number_of_rows=mysqli_num_rows($question_result);
$limit=$number_of_rows-5;

 ?>

 <head>
 	<link rel="stylesheet" type="text/css" href="assests/css/subject_all_questions_style.css">
	<link rel="stylesheet" type="text/css" href="assests/css/ask_style.css">
 	<title>Questions and Discussion-physics-cs</title>
 </head>

<div>
	<?php 
require 'discussion_db.php';
// session_start();
require 'discussion_server.php';
 ?>


<div><?php include 'header.php'; ?></div>

		<div class="discussion_header">
			<h2>Discuss Questi<span class="red">o</span>ns</h2>
			<h5>Please enter your details correctly on input field for discussion.</h5>
		</div>

<div class="ask_form" id="ask_qsn">
	<form action="ask.php" method="post" class="ask_form" id="ask_form">
	
	<?php  include 'errors.php'; ?>

<div class="subject_opion">
	<p>Please select subject name</p>
		<select name="subject" value="<?php echo $ask_subject ?>">
			<option value=""></option>
				<option value="physics">Physics</option>
				<option value="math">Math</option>
				<option value="english">English</option>
			<option value="chemistry">Chemistry</option>
		<option value="aptitude">Aptitude</option>
	</select>
</div>
	
	<div>
		<p>NAME:</p>
		<input type="text" name="name" autocomplete="on" placeholder="Enter Your Full Name" value="<?php echo $ask_name ?>">
	</div>

	<div>
		<p>Email:</p>
		<input type="email" name="email" autocomplete="on" placeholder="Enter your email" value="<?php echo $ask_email ?>">
		<p>We will n<span class="red">o</span>t share y<span class="red">o</span>ur email with any<span class="red">o</span>ne</p>
	</div>

	<div>
		<p>Questi<span class="red">o</span>ns:</p>
		<textarea rows="6" cols="30" name="msg" placeholder="Enter your questions" value="<?php echo $ask_msg ?>"></textarea>
	</div>

	<div>
		<button type="submit" id="ask_btn" class="qsn_btn" name="ask">SUBMIT</button>
	</div>
	</form>
		</div>

	<div class="ask_goto">
		<ul>
		<li><a href="discussion_system_main.php">G<span class="red">O</span> T<span class="red">O</span> MAIN DISCUSSI<span class="red">O</span>N SECTI<span class="red">O</span>N</a></li>
		<li><a href="physics_all.php">VIEW ALL DISCUSSI<span class="red">O</span>N <span class="red">O</span>F PHYSICS</a></li>
		<li><a href="math_all.php">VIEW ALL DISCUSSI<span class="red">O</span>N <span class="red">O</span>F MATH</a></li>
		<li><a href="english_all.php">VIEW ALL DISCUSSI<span class="red">O</span>N <span class="red">O</span>F ENGLISH</a></li>
		<li><a href="chemistry_all.php">VIEW ALL DISCUSSI<span class="red">O</span>N <span class="red">O</span>F CHEMISTRY</a></li>
		<li><a href="aptitude_all.php">VIEW ALL DISCUSSI<span class="red">O</span>N <span class="red">O</span>F APTITUDE</a></li>
		</ul>
	</div>
			
</div>

 <div>

 	 <div class="subject_name">PHYSICS</div>


 	<?php

	for ($i=$number_of_rows; $i >=1 ; $i--) { 
		$question="SELECT * FROM physics WHERE id=$i LIMIT 1";
		$question_result=mysqli_query($con,$question);
		while ($row=mysqli_fetch_assoc($question_result)) {
			$question_id=$i;
			?>

 	<div class="background">
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
 <?php  } ?>
 <!-- </div> -->
 <?php } ?>

 	</div>
 		<div class="goto_top">
			<h3><a href="#top">G<span class="red">O</span> T<span class="red">O</span> T<span class="red">O</span>P</a></h3>
		</div>	
<div>
	<?php include 'footer.php'; ?>
</div>