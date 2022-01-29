<?php
	if(!session_id()){
	  session_start();
	}
?>

<?php 
	require 'auth.php';
	require 'secure/exam_database.php';
	require 'includes/functions.php';
	$_SESSION['is_refreshed']=$_SESSION['is_refreshed']+1;
	$exam_time="";
	$cat_name="";
	$exam_date=Date('y-m-h-s');
	$errors=array();

	// ------------Preventing from redirect back------
	unset($_SESSION['cat_selected']);

	// ---------CHECKING Values for previous pages----
if (clean_values($con_exam,isset($_SESSION['set_selection'])) and clean_values($con_exam,isset($_SESSION['cat_selection'])) and clean_values($con_exam,isset($_SESSION['exam_start'])) and (clean_values($con_exam,$_SESSION['is_refreshed'])<=1)) {
	$field_id=clean_values($con_exam,$_SESSION['cat_selection']);
	$set_id=clean_values($con_exam,$_SESSION['set_selection']);
	$_SESSION['view_res']=0;
	$_SESSION['is_res_saved']=0;
	$_SESSION['marks']=0;
	$_SESSION['wright']=0;
	$_SESSION['wrong']=0;
	$_SESSION['no_attempt']=0;
	$_SESSION['total_marks']=0;
	$_SESSION['user_res']="";
}else{
	header("Location:exam_function.php");
}

// echo "Field_Id => ".$field_id;
// echo "Set Id => ".$set_id;

// --------------Qry for exam time----------
$query_cat=@"SELECT * FROM category_name WHERE id='$field_id' LIMIT 1";
$result_cat=mysqli_query($con_exam,$query_cat) or die(mysqli_error($con_exam));
if (mysqli_num_rows($result_cat)>0) {
	while($rows_cat=mysqli_fetch_assoc($result_cat)) {
		$exam_time=$rows_cat['exam_time'];
		$_SESSION['cat_name']=$rows_cat['cat_name'];
	}
}else{
	array_push($errors, "Error occurs on category selection");
}

// ---------Qry for user information--
$user_name=clean_values($con,$_SESSION['username']);
$user_qry=@"SELECT * FROM user_information WHERE username='$user_name'LIMIT 1";
$user_result=mysqli_query($con,$user_qry) or die($con);
if (mysqli_num_rows($user_result)>0) {
	while ($row=mysqli_fetch_assoc($user_result)) {
		$full_name=$row["firstname"]." ".$row["middlename"]." ".$row["surname"];;
		$profile_img=$row['image'];
	}
}else{
	array_push($errors, "Error occurs on getting user information");
}

// ------------Getting all the questions present on that set----
$question_query=@"SELECT * FROM questions_collections WHERE field_id='$field_id' AND question_set='$set_id'";
$question_query_result=mysqli_query($con_exam,$question_query) or die(mysqli_error($con_exam));
 ?>

<!DOCTYPE html>
<html lang="en">
<head>
	<title>ONLINE ENTRANCE -EXAM</title>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  	<link rel="stylesheet" type="text/css" href="assests/css/bootstrap.min.css">
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
  	<script src="assests/js/jquery.min.js"></script>
  	<script src="assests/js/ajax.js"></script>
  	<script src="assests/js/bootstrap.min.js"></script>
	<link rel="stylesheet" type="text/css" href="assests/css/myStyle.css">

 <script type="text/javascript">
	function timeout()
	{
		var hours=Math.floor(timeLeft/3600);
		var minute=Math.floor((timeLeft-(hours*60*60)-30)/60);
		if (minute==-1) {
			var minute=0;
		}
		var second=timeLeft%60;
		var hrs=checktime(hours);
		var mint=checktime(minute);
		var sec=checktime(second);
		if(timeLeft<=0)
		{
			clearTimeout(tm);
			document.getElementById("form1").submit();
		}
		else
		{

			document.getElementById("time").innerHTML=hrs+":"+mint+":"+sec;
		}
		timeLeft--;
		var tm= setTimeout(function(){timeout()},1000);
	}
	function checktime(msg)
	{
		if(msg<10)
		{
			msg="0"+msg;
		}
		return msg;
	}
	</script>

	<style type="text/css">
		.mySubRowBorder{
	border: solid #095EA7 2px;
	background-color: white;
}
	</style>
</head>

<body onload="timeout()" >

<div class="container-fluid">
	<div class="row">
		<div class="col-lg-1 col-md-1"></div>

		<div class="col-lg-10 col-md-10 col-xs-12 myHeader">
			<div class="row">
	            <div class="col-lg-2 col-md-2 col-xs-2">
	                <a href="index.php" title="ONLINE ENTRANCE"><img src="assests/icons/flag.gif" alt="Logo of Team CORONA"  width="70" height="70"></a> 
	            </div>

					<!-- ---------------------TITLE--------------------------- -->
	            <div class="col-lg-6 col-md-6 col-xs-8 myTitle">
	            	<div>
	                	<span class="logo-title">ONLINE ENTRANCE MODEL TEST</span>
	            	</div>

	            	<div>
						<p class="text-center">MODEL QUESTIONS FOR "<?php echo $_SESSION['cat_name']; ?>"</p>
						<p class="text-center">Hey, "<?php echo $full_name; ?>" be patience and solve all the questions.</p>
						<p >BEST OF LUCK!!</p>
					</div>

					<div class="nav-exam-condition" style="color: #1222B5;">
				    	 <span class="pull-left"> SET: <?php echo $set_id; ?></span>
				    	 <span class="pull-myCentre">TIME: <?php echo $exam_time; ?>&nbsp;hrs</span>
				    	<span class="pull-right">DATE: <?php echo $exam_date; ?></span>

					</div>

					<div>
						Extra Notes
					</div>

	            </div>

	            <div class="col-lg-2 col-md-2 col-xs-12">
					<table style="color: #fff;">
						<tr>
							<th style="text-align: center;"><br>
								<img src="secure/user_images/<?php echo($profile_img); ?>" alt="<?php echo($row['username']); ?>" style="height: 200px;width: 200px;">

							</th>
						</tr>

					 	<tr>
					 		<th style="text-align: center;"><?php echo $user_name; ?></th>
					 	</tr>
					  	<tr>
					    	<th style="text-align: center;">Time Remaining:</th>
					 	</tr>

					  	<tr>
					    	<td><div id="time" style="text-align: center;">Remaining Time</div></td>
					  	</tr>
					</table>
				</div>

	            <div class="col-lg-2 col-md-2 col-xs-2">
	                <img src="assests/icons/flag.gif" alt="Flag" width="70" height="70" class="pull-right">
	            </div>
      		</div>
		</div>
		<div class="col-lg-1 col-md-1"></div>
	</div>

	<!-- ------------------ENDING OF HEADER------------------------- -->


	<script type="text/javascript">
		 var timeLeft=60*60*<?php echo $exam_time ?>+(5);
	</script>



	<!-- -------------------------SHORT NOTICE------------------------- -->
	<div class="row">
		<div class="col-lg-1 col-md-1"></div>

	    <div class="col-lg-10 col-md-10 col-xs-12 myRowBorder">
			<marquee onmouseover="this.stop();" onmouseout="this.start();">
				<ul style="list-style-type: none; display: inline;">
					<li style="margin-right: 30px; display: inline-block;">

						<p style="text-decoration: none; font-size:14px; font-weight: bold; color: #1222B5;">THIS IS FOR SHORT NOTICE</p>
					</li>
				</ul>
			</marquee>
		
		</div>
		
		<div class="col-lg-1 col-md-1"></div>

	</div>



	<!-- -----------------STARTING QUESTIONS AND OPTIONS DIVISION--------------------- -->

	<div class="row">
		<div class="col-lg-1 col-md-1"></div>

		<div class="col-lg-10 col-md-10 col-xs-12 mySubRowBorder">

				<?php if (mysqli_num_rows($question_query_result)>0) { ?>

			<form  method="post" id="form1" action="exam_results.php">

			  	<input type="hidden" name="field_id" value="<?php echo $field_id; ?>">
			  	<input type="hidden" name="set_id" value="<?php echo $set_id; ?>"><br>

						<?php $i=0;	while ($rows=mysqli_fetch_assoc($question_query_result)) { ?> 

							<?php if (!empty($rows['question_header'])) {?>
			        			<h5 class="font-italic font-weight-bold bg-light"><?php echo nl2br($rows['question_header']); ?></h5>
			        		<?php  }  ?>

				<table class="">

			    	<thead>
			      		<tr class="question_header">
			        		<th><?php
			        		if (empty($rows['question_details'])) {
			        			 echo $rows['question_no'].". ".nl2br($rows['question']);
			        			}else{
			        			  echo $rows['question_details']."</br></br>".$rows['question_no'].". ".nl2br($rows['question']);
			        			} 

			        		if (!empty($rows['question_footer'])) {
			        			echo $rows['question_footer'];
			        		}
			        			?></th>
			      		</tr>
			    	</thead>

			    	<tbody>
				      	<?php if (isset($rows['option_a'])) { ?>
				      	<tr class="question_option">
				        	<td>&nbsp;a.&emsp;<input type="radio" name="<?php echo $rows['question_no']; ?>" value="a">&nbsp;<?php echo nl2br($rows['option_a']); ?></td>
				      	</tr>
				      	<?php } ?>
				      	<?php if (isset($rows['option_a'])) { ?>
				      	<tr class="question_option">
				        	<td>&nbsp;b.&emsp;<input type="radio" name="<?php echo $rows['question_no']; ?>" value="b">&nbsp;<?php echo nl2br($rows['option_b']); ?></td>
				      	</tr>
				       	<?php } ?>
				      	<?php if (isset($rows['option_a'])) { ?>
				      	<tr class="question_option">
				        	<td>&nbsp;c.&emsp;<input type="radio" name="<?php echo $rows['question_no']; ?>" value="c">&nbsp;<?php echo nl2br($rows['option_c']); ?></td>
				      	</tr>
				       	<?php } ?>
				      	<?php if (isset($rows['option_a'])) { ?>
				      	<tr class="question_option">
				        	<td>&nbsp;d.&emsp;<input type="radio" name="<?php echo $rows['question_no']; ?>" value="d">&nbsp;<?php echo nl2br($rows['option_d']); ?></td>
				      	</tr>
				       	<?php } ?>
				      	<?php if (isset($rows['option_a'])) { ?>
				      	<tr class="question_option">
				        	<td>&nbsp;&emsp;<input type="radio" checked="checked" style="display: none;" name="<?php echo $rows['question_no']; ?>" value="no_attempt"></td>
				      	</tr>
				      	<?php } ?>
			    	</tbody>
			  	</table>
				<?php $i++;	} ?>
				<input type="hidden" name="total_question" value="<?php echo $i; ?>">
				<center><button type="submit" class="btn btn-default myLoginBtn" name="completed_submit">SUBMIT ANSWER</button></center><br>
			</form>
		<?php } else {echo "<h2 class='text-info'>Not any questions availables in this set try again later.</h2>";} ?>
		</div>
		<div class="col-lg-1 col-md-1"></div>
	</div>
	<div>
		<button class="btn btn-primary" id="nextBtn">Next</button>
	</div>
</div>
<script type="text/javascript">
	$(document).ready(function(){
		$("#nextBtn").click(function(){
			
		});
	});
</script>

<?php include 'footer.php'; ?>