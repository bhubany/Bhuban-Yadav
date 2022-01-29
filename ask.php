<?php 
require 'discussion_db.php';
// session_start();
require 'discussion_server.php';
 ?>


	<link rel="stylesheet" type="text/css" href="assests/css/ask_style.css">
	<title>Ask questions</title>

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
				
			
<?php include 'footer.php'; ?>