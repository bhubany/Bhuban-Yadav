<?php
	if(!session_id()){
	  session_start();
	}
?>

<?php 
	require 'secure/admin_database.php';
	require 'db.php'; 
	require 'includes/functions.php';

// echo (4/2).(4%2);
$errors=array(); 
$Sucess="";
$full_name="";
$email="";
$telephone="";
$feedback_inquiry="";
// echo $_SESSION['username'];
if (clean_values($con_admin ,isset($_POST['submit_inquiry']))) {
	$full_name=clean_values($con_admin,$_POST['full_name']);
	$email=clean_values($con_admin ,$_POST['email']);
	$telephone=clean_values($con_admin,$_POST['telephone']);
	$feedback_inquiry=clean_values($con_admin,$_POST['feedback_inquiry']);
	$trn_date=clean_values($con_admin,Date('Y-m-d-h-m-s-ms'));
	$feedback_category=clean_values($con_admin,$_POST['qry_cat']);

		// -----------Validating name--------
	if (empty($full_name)) {
		array_push($errors, "Full name is required.");
	}elseif (strlen($full_name)>50) {
		array_push($errors,"Please enter valid name, it can't be more than 50 characters");
	}elseif (!is_string($full_name) or is_numeric($full_name)) {
		array_push($errors, "Please enter your valid name");
	}elseif (!preg_match("/^[a-zA-Z ]*$/",$full_name)){
		array_push($errors, "Please enter your valid name");
	}

		// -------------Email validation---------
	if (empty($email)) {
		array_push($errors, "Email is required");
	}elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
		array_push($errors, "Enter valid Email");
	}elseif (strlen($email)<8 or strlen($email)>50) {
    	array_push($errors, "Please enter valid email");
  	}

		// ----------contact validation----------
	if (empty($telephone)) {
		array_push($errors, "Telephone is required");
	}elseif (!is_numeric($telephone)) {
		array_push($errors,"Please enter your valid contact number.");
	}elseif (strlen($telephone)<9 or strlen($telephone)>15) {
		array_push($errors,"Please enter your valid contact number.");
	}

	if (empty($feedback_category)) {
		array_push($errors, "Please select query category");
	}elseif (strlen($feedback_category)<5 or strlen($feedback_category)>50 or is_numeric($feedback_category)) {
		array_push($errors, "Select valid category");
	}

	if (empty($feedback_inquiry)) {
		array_push($errors, "Feedback cannot be empty it is required");
	}

	if (count($errors) == 0) {
		$query_insert=@"INSERT INTO users_feedback(name,email,telephone,feedback_category,feedback,trn_date) VALUES('$full_name','$email','$telephone','$feedback_category','$feedback_inquiry','$trn_date')";
		$query_insert_result=mysqli_query($con_admin,$query_insert) or die($con_admin);
		if ($query_insert_result==1) {
			$Sucess="Thanks for your feedback/inquiries we will check your feedback/inquiries shortly and reply soon (if necessary).";
		}
		else {
			array_push($errors, "Temporary error occurs submitting your inquiry/feedback try later.");
		}
	}
}
 ?>

<head>
	<title>online entrance model test-main home page</title>
</head>

<?php include("header.php") ?>
<?php include("nav.php")?>

<style type="text/css">
*{
	margin: 0px;
	padding: 0px;
	box-sizing: border-box;
}

.connected{
	text-align: center;
}
.connected>ul{
	list-style: none;
	/*border:solid #EEB5B5 5px;*/
	/*background-color: #EEB5B5;*/
}
.connected>ul>li{
	display: inline-block;
	padding: 5px;
}
.connected>ul>li>a>img{
	height: 35px;
	width: auto;
}

.error {
  width: 92%; 
  margin: 0px auto; 
  padding: 10px; 
  border: 1px solid #a94442; 
  color: #a94442; 
  background: #f2dede; 
  border-radius: 5px; 
  text-align: left;
}
.success {
  color: #3c763d; 
  background: #dff0d8; 
  border: 1px solid #3c763d;
  margin-bottom: 20px;
}
a{
	text-decoration: none;
}
.movingImg{
	height: 500px;
	width: auto;
}
.courseImg{
	height: 500px;
	width: 600px;
}
.mySubRowBorder{
	border: solid #095EA7 2px;
	background-color: white;
}
</style>


<!-- ---------STARTING OF MAIN ROWS FOR NOTICE OR RECENT EVENTS----------- -->
<div class="row">
	<div class="col-lg-1 col-md-1"></div>

    <div class="col-lg-10 col-md-10 col-xs-12 myRowBorder">
		<marquee onmouseover="this.stop();" onmouseout="this.start();">
			<ul style="list-style-type: none; display: inline;">
				
						<?php
						$recent_event_qry=@"SELECT * FROM recent_event WHERE is_active='1'";
						$recent_event_res=mysqli_query($con_admin,$recent_event_qry) or die($con_admin);
						while($recent_event_rows=mysqli_fetch_assoc($recent_event_res)){?>
				<li style="margin-right: 30px; display: inline-block;">

					<a href="<?php echo("Link"); ?>" style="text-decoration: none; font-size:14px; font-weight: bold; color: #1222B5; padding: 5px;"><?php echo $recent_event_rows['event_details']; ?></a>
				</li>
						<?php } ?>

			</ul>
		</marquee>
	
	</div>
	
	<div class="col-lg-1 col-md-1"></div>

</div>
<!-- --------------------------CLOSING OF MAIN ROWS FOR NOTICE---------------------- -->



<!-- -----------------***--------STARTING OF MAIN ROWS FOR MOVING IMAGES---***---------------------------- -->
<div class="row">
	<div class="col-lg-1 col-md-1"></div>

    <div class="col-lg-10 col-md-10 col-xs-12 myRowBorder">

					<?php
					$mov_img_qry=@"SELECT * FROM gallery_images WHERE album_id='8' AND is_active='1'";
					$mov_res=mysqli_query($con_admin,$mov_img_qry) or die($con_admin);
					  ?>

					<!-- ----------------------------STARTING OF MOVING IMAGES--------------------------- -->

	    <div id="carouselExampleIndicators" class="carousel slide" data-ride="carousel">

	    	<!-- ----------------------------------STARTING OF IMAGE SELECTION DIV--------------------------- -->
 			<div class="carousel-inner">
    
			    <div class="carousel-item active">
			      	<img class="rounded mx-auto d-block movingImg" src="assests/images/OEMT.jpg" alt="Default image of online entrance model test">
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

			<!-- ====================================ENDING OF IMAGE SELECTION DIV======================== -->


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

<!-- ------------------CLOSING OF ROW================ -->




<!-- -----------------****-----WELCOME MESSAGE---------*****---------------------- -->
<div class="row">
	<div class="col-lg-1 col-md-1"></div>

    <div class="col-lg-10 col-md-10 col-xs-12 myRowBorder" style="color: #1222B5;background-color: #f2f2f2;font-weight: bold;">
    	<h1 class="text-left">YOU ARE STRONGLY WELCOME</h1>
 
		<h4 class="text-center">Sucess doesn't just find you, You have to go out and get it. <br>

			It's going to be hard, But hard does not mean impossible. <br>

			Sometimes we are tested, Not to show our weakness, But to discover our strengths. <br>

			The key to sucess is to Focus on Goals, Not obstacles. <br>
		</h4>
		<h1 class="text-right">LET'S CREATE FUTURE TOGETHER.</h1>

    </div>

    <div class="col-lg-1 col-md-1"></div>
</div>

<!-- ---------------------------------------------- -->


<!-- **********************************STARTING OF COURSES AVAILABLES************************************ -->
<!-- ----------------HEADER-------------- -->
<div  class="row">
	<div class="col-lg-1 col-md-1"></div>
	
	<div class="col-lg-10 col-md-10 col-xs-12 myHeader">
		<h3 class="text-center" style="color:#fff;font-weight: bold;text-decoration: underline;font-size: 40px;padding-top: 5px;">COURSES AVAILABLES FOR TESTS</h3><br>
	</div>

	<div class="col-lg-1 col-md-1"></div>
</div>


<!-- ---------------------COURSES-------------------------- -->
<div class="row">
	<div class="col-lg-1 col-md-1"></div>

    <div class="col-lg-10 col-md-10 col-xs-12">

    		<!-- -----------------IMAGE RIGHT SIDE-------------------- -->

    	<div class="row">
    		<div class="col-lg-6 col-md-6 col-xs-12 myRowBorder" style="background-color: #f2f2f2;">
   				<h3 class="text-center" style="color: #1222B5;font-weight: bold;text-decoration: underline;font-size: 35px;"><?php //echo $courses_rows['course_header']; ?>COURSE HEADER</h3><br>
   				<h5 class="text-right font-italic"><?php //echo $courses_rows['trn_date']; ?>DATE</h5>
   				<h4><?php //echo $courses_rows['course_details']; ?>DETAILS</h4><br>
   				<h4><?php //echo $courses_rows['extra_notes']; ?>EXTRA</h4>
   			</div>
   			<div class="col-lg-6 col-md-6 col-xs-12 myRowBorder"><img class="courseImg" src="assests/images/engineering.jpg"></div>
	    </div>

	    			
	    			<!-- -----------------IMAGE LEFT SIDE------------------ -->
	    <div class="row">
    		<div class="col-lg-6 col-md-6 col-xs-12 myRowBorder"><img class="courseImg" src="assests/images/engineering.jpg"></div>

    		<div class="col-lg-6 col-md-6 col-xs-12 myRowBorder" style="background-color: #f2f2f2;">
   				<h3 class="text-center" style="color: #1222B5;font-weight: bold;text-decoration: underline;font-size: 35px;"><?php //echo $courses_rows['course_header']; ?>COURSE HEADER</h3><br>
   				<h5 class="text-right font-italic"><?php //echo $courses_rows['trn_date']; ?>DATE</h5>
   				<h4><?php// echo $courses_rows['course_details']; ?>DETAILS</h4><br>
   				<h4><?php //echo $courses_rows['extra_notes']; ?>EXTRA</h4>
   			</div>
	    </div>

	</div>

    <div class="col-lg-1 col-md-1"></div>
</div>
<!-- ----------------------------------------------------------------- -->



	<!-- START TEST NOW BUTTON DIV -->
<div class="row">
	<div class="col-lg-1 col-md-1"></div>

    <div class="col-lg-10 col-md-10 col-xs-12 myRowBorder">
		<br>
		<a style="text-decoration: none;" href="exam_function.php" class="mySection"><button class="btn btn-primary btn-lg btn-block">START TEST NOW</button></a><br>
	</div>

	<div class="col-lg-1 col-md-1"></div>
</div>


		<!-- ***********************-----MAIN DIV STARTS FROM HERE FOR THREE COLUMNS___________---- -->

<div class="row"><br>
	<div class="col-lg-1 col-md-1"></div>

	<div class="col-lg-10 col-md-10 col-xs-12" style="background-color: #f2f2f2;">
		<div class="row">
			<div class="col-sm-4 col-lg-4 col-md-4 col-xs-12 myRowBorder">
				<button class="btn btn-default btn-lg btn-block myHeader" style="color: #fff;">ONLINE ENTRANCE MODEL TEST</button>
				<div class="mySubRowBorder">
					<p class="text-justify" style="padding: 0px 5px 5px 5px;">We have started this websites from 2019 with the objective to provides our users different sets of questions for practice each day which make them qualified and proficent compitents on their carriers with the new way according to modern era, where Science and Technology are dominating every fields of our life.</p>
					<p class="text-center"><a href="about.php"><button style="border-width: 3px;border-color: red;">See more</button></a></p><br>
				</div>
			</div>

			<div class="col-sm-4 col-lg-4 col-md-4 col-xs-12 myRowBorder">
				<button class="btn btn-default btn-lg btn-block myHeader" style="color: #fff;">STAY CONNECTED WITH US</button>

				<div class="mySubRowBorder">
					<h5 class="text-justify" style="padding: 0px 5px 5px 5px;">You can also connect with us from below social media links</h5>
					<p class="text-justify" style="padding: 0px 5px 5px 5px;">We are also availables on social medai's. If you have any inquiry/feedback then you can share to us using the social media which are provided below.</p>
				</div>

				<div class="connected mySubRowBorder">
					<ul class="mySubRowBorder">
						<li>
							<a href=""><img src="assests/icons/visit.png"></a>
						</li>
						<li>
							<a href="www.facebook.com/onlineentrance" target="blank" title="visit facebook"><img src="assests/icons/facebook.png"></a>
						</li>
						<li>
							<a href="www.facebook.com/onlineentrance" target="blank" title="visit twitter"><img src="assests/icons/twitter.png"></a>
						</li>
						<li>
							<a href="www.facebook.com/onlineentrance" target="blank" title="visit linkedin"><img src="assests/icons/linkedin.png"></a>
						</li>
						<li>
							<a href="www.facebook.com/onlineentrance" target="blank" title="visit instagram"><img src="assests/icons/instagram.png"></a>
						</li>
						<li>
							<a href="www.facebook.com/onlineentrance" target="blank" title="contact through email"><img src="assests/icons/email.png"></a>
						</li>
					</ul>
				</div>

				<!-- -------------------------FOLLOW---------------- -->
				<div class="connected mySubRowBorder">
					<ul>
						<p>Like, follow us on social media from below.</p>
						<li>
							<div class="fb-like" data-href="http://kec.edu.np/" data-width="" data-layout="box_count" data-action="like" data-size="small" data-show-faces="false" data-share="false"></div>
						</li>
						<li>
							<a href="https://twitter.com/OnlineEntrance?ref_src=twsrc%5Etfw" class="twitter-follow-button" data-size="large" data-show-screen-name="false" data-dnt="true" data-show-count="false">Follow @OnlineEntrance</a><script async src="https://platform.twitter.com/widgets.js" charset="utf-8"></script>
						</li>
						<li>
							<script src="https://platform.linkedin.com/in.js" type="text/javascript"> lang: en_US</script>
							<script type="IN/FollowCompany" data-id="1337" data-counter="bottom"></script>
						</li>
						<li>
							
						</li>
					</ul>
				</div>

				<!-- -----------------------SHARE------------------ -->
				<div class="connected mySubRowBorder">
					<p>Also share with your frinds from below.</p>
					<ul>
						<li>
							<script src="https://platform.linkedin.com/in.js" type="text/javascript">lang: en_US</script>
							<script type="IN/Share" data-url="https://www.linkedin.com"></script>
						</li>

						<li>
							<div class="fb-share-button" data-href="http://kec.edu.np/" data-layout="box_count" data-size="small"><a target="_blank" href="https://www.facebook.com/sharer/sharer.php?u=http%3A%2F%2Fkec.edu.np%2F&amp;src=sdkpreparse" class="fb-xfbml-parse-ignore">Share</a></div>
						</li>
						<li>
							<a href="https://twitter.com/share?ref_src=twsrc%5Etfw" class="twitter-share-button" data-size="large" data-dnt="true" data-show-count="false">Tweet</a><script async src="https://platform.twitter.com/widgets.js" charset="utf-8"></script>
						</li>
					</ul>
				</div>
			</div>

			<div class="col-lg-4 col-md-4 col-xs-12 myRowBorder">

				<button class="btn btn-default btn-lg btn-block myHeader" style="color: #fff;">
					<h2>INQUIRY/FEEDBACK</h2>
					<h5>If you have any inquiry/feedback then ask/provide us from below.</h5>
				</button>

				<div class="mySubRowBorder myForm">
					<?php if (clean_values($con,isset($_SESSION['username']))){
						$username=clean_values($con,$_SESSION['username']);
						// echo "<br>".$username;
						$user_qry=@"SELECT * FROM user_information WHERE username='$username' ";
						$user_qry_res=mysqli_query($con,$user_qry) or die($con);
					 ?>
					<form method="post" onsubmit="return validatefeedback();">

						<div class="" style="padding-top: 5px;padding-bottom: 5px;">
						      <?php include 'errors.php'; ?>
						      <?php if ($Sucess!="") {?>
						    <div class="mySuccess"><?php echo $Sucess; ?></div>
						      <?php } ?>
				    	</div>
						
				    		<?php 
						if (mysqli_num_rows($user_qry_res)>0) {
							//echo $num;	
							while ($user_row=mysqli_fetch_assoc($user_qry_res)) {
						 ?>
						<div class="form-group">
			      			<label for="text">FULL NAME:<span class="text-danger">*</span></label>
			      			<input type="text" class="form-control" id="full_name" placeholder="Enter your full name" name="full_name" value="<?php echo($user_row['firstname']." ".$user_row['middlename']." ".$user_row['surname']); ?>" minlength="5" maxlength="50" readonly="on">
			    		</div>

						<div class="form-group">
			      			<label for="email">EMAIL:<span class="text-danger">*</span></label>
			      			<input type="email" class="form-control" id="email" placeholder="someone@gmail.com" name="email" value="<?php echo($user_row['email']); ?>" maxlength="50" readonly="on">
			    		</div>

						<div class="form-group">
			      			<label for="contact">CONTACT NUMBER:<span class="text-danger">*</span></label>
			      			<input type="tel" class="form-control" id="contact" placeholder="98XXXXXXXX" name="telephone" value="<?php echo($user_row['contact1']); ?>" minlength="9" maxlength="15" readonly="on">
			    		</div>

			    		<div class="form-group">
			    			<label for="contact">SELECT CATEGORY:<span class="text-danger">*</span></label>
			    			<select class="form-control" name="qry_cat">
			    				<option value="feedback">Feedback</option>
			    				<option value="query">Query</option>
			    				<option value="suggestion">Suggestion</option>
			    			</select>
			    		</div>

						<div class="form-group">
			      			<label for="text">FEEDBACK/INQUIRIES:<span class="text-danger">*</span></label>
			      			<textarea type="text" class="form-control text-info" id="feedback" placeholder="Enter your questions/inquiries related to us here." name="feedback_inquiry" value="<?php echo($feedback_inquiry); ?>" rows="5"></textarea>
			    		</div>

						<div>
							<button type="submit" class="btn btn-default myLoginBtn" name="submit_inquiry"  id="inquiry_btn">SUBMIT</button>
						</div>
					
					</form>	
						<?php } } } else{ ?>
					<form method="post" onsubmit="return validatefeedback();">

						<div class="" style="padding-top: 5px;padding-bottom: 5px;">
						      <?php include 'errors.php'; ?>
						      <?php if ($Sucess!="") {?>
						    <div class="mySuccess"><?php echo $Sucess; ?></div>
						      <?php } ?>
				    	</div>
						

						<div class="form-group">
			      			<label for="text">FULL NAME:<span class="text-danger">*</span></label>
			      			<input type="text" class="form-control" id="full_name" placeholder="Enter your full name" name="full_name" value="<?php echo($full_name); ?>" minlength="5" maxlength="50">
			    		</div>

						<div class="form-group">
			      			<label for="email">EMAIL:<span class="text-danger">*</span></label>
			      			<input type="email" class="form-control" id="email" placeholder="someone@gmail.com" name="email" value="<?php echo($email); ?>" maxlength="50">
			    		</div>

						<div class="form-group">
			      			<label for="contact">CONTACT NUMBER:<span class="text-danger">*</span></label>
			      			<input type="tel" class="form-control" id="contact" placeholder="98XXXXXXXX" name="telephone" value="<?php echo($telephone); ?>" minlength="9" maxlength="15">
			    		</div>

			    		<div class="form-group">
			    			<label for="contact">SELECT CATEGORY:<span class="text-danger">*</span></label>
			    			<select class="form-control" name="qry_cat">
			    				<option value="feedback">Feedback</option>
			    				<option value="query">Query</option>
			    				<option value="suggestion">Suggestion</option>
			    			</select>
			    		</div>

						<div class="form-group">
			      			<label for="text">FEEDBACK/INQUIRIES:<span class="text-danger">*</span></label>
			      			<textarea type="text" class="form-control text-info" id="feedback" placeholder="Enter your questions/inquiries related to us here." name="feedback_inquiry" value="<?php echo($feedback_inquiry); ?>" rows="5"></textarea>
			    		</div>

						<div>
							<button type="submit" class="btn btn-default myLoginBtn" name="submit_inquiry"  id="inquiry_btn">SUBMIT</button>
						</div>
					
					</form>	
				<?php } ?>
				</div>
			</div>
		</div>
		<div class="col-lg-1 col-md-1"></div>
	</div>
</div>



<?php include("footer.php");
	  include 'cookies.php'; ?>