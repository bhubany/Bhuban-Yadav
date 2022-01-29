<?php require_once 'secure/admin_database.php'; ?>
<?php $faq_query=@"SELECT * FROM faq WHERE is_active='1' ";
$faq_res=mysqli_query($con_admin,$faq_query) or die(mysqli_error($con_admin));
 $i=1;
 ?>


<?php include 'header.php'; ?>
<?php include 'nav.php'; ?>

<head>
	<title>Frequently Asked Questions-Online Entrance</title>
</head>

<div class="row">
	<div class="col-lg-1 col-md-1"></div>
	<div class="col-lg-10 col-md-10 col-xs-12 myRowBorder" style="background-color: #f2f2f2">
		<div class="mySubRowBorder">
			<u  style="color: #1222B5;"><h2 class="text-center">FREQUENTLY ASKED QUESTIONS (FAQ)</h2></u>
 			<h4 class="text-center text-info">Here you can find out frequently asked questions and answers.</h4>
		</div>

				<!-- **************************FAQ LISTS******************** -->

		<div class="row">
			<div class="col-lg-12 col-md-12 col-xs-12">
				<p><b>1. What is this?</b></p>
				<p><i>This is the place where you can practice and check your entrance preparation online.</i></p>
				<p><b>2. How it works?</b></p>
				<p><i>It works</i></p>
				<p><b>3. Is it useful or not?</b></p>
				<p><i>Yes, it is so useful for those who want's to score better marks on entrance and get admitted on good colleges</i></p>
				<p><b>4. Does it works on cellphone or not?</b></p>
				<p><i>Yes, you can use this website from any devices by using this websites (www.onlineentrance.com) url on browesers like chrome,opera etc.<i></p>
				<p><b>5. Does it work offline or not?</b></p>
				<p><i>No, it does not work offline. You must have proper internet connections for acess this website.</i></p>
				<p><b>6. Do you have any mobile Applications?</b></p>
				<p><i>No, Currently we don't have any mobile applications but we are working on it and will be published soon</i></p>
				<p><b>7. You provides entrance preparations questions for practice only or others also?</b></p>
				<p><i>Mainly we provides entrance preparations but also PUBLIC SERVICE COMISSONS (PSC) multiple choice questions (MCQ)</i></p>

				<?php while ($faq_rows=mysqli_fetch_assoc($faq_res)) { ?>
					<p><b><?php echo $i.". ".$faq_rows['questions']; ?></b></p>
				<p><i><?php echo $faq_rows['answers']; ?></i></p>
					<?php $i=$i+1; } ?>
	 		</div>
		</div>
	</div>
	<div class="col-lg-1 col-md-1"></div>
</div>


<!-- *************************FOOTER*************************** -->
<?php include 'footer.php'; ?>