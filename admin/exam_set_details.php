<?php
if(!session_id()){
  session_start();
}?>

<?php 
// require 'acess.php';
date_default_timezone_set("Asia/Kathmandu");
$upload_date=Date('Y-m-d h:m:s:ms');
$errors=array();
$Sucess="";
$set_number="";
$cat_details_id="";
$cat_details_name="";

$edit_status=0;
$edit_qsn_id='';

//----------GETTING VALUES BY SUBMITTING FORM-----------
$qsn_num="";
$question="";
$option_a="";
$option_b="";
$option_c="";
$option_d="";
$answer="";
$cntng_marks="";


require 'exam_database.php';

// --------------RECEIVING SET ID FROM PREVIOUS PAGES------------
if (isset($_SESSION['cat_details_id']) and isset($_SESSION['cat_details_name']) and isset($_SESSION['set_number'])) {
	$set_number=$_SESSION['set_number'];
	$cat_details_id=$_SESSION['cat_details_id'];
	$cat_details_name=$_SESSION['cat_details_name'];
}else{
	header("Location: exam_category_details.php");
}


//---------------GETTING DETAILS FROM FORM TO UPDATE QUESTIONS---------
if (isset($_POST['update_questions'])) {
	$update_question_id=$_POST['update_question_id'];
	$update_qsn_num=$_POST['update_qsn_num'];
	$update_question_header=$_POST['update_question_header'];
	$update_question_details=$_POST['update_question_details'];
	$update_question=$_POST['update_question'];
	$update_question_footer=$_POST['update_question_footer'];
	$update_option_a=$_POST['update_optn_a'];
	$update_option_b=$_POST['update_optn_b'];
	$update_option_c=$_POST['update_optn_c'];
	$update_option_d=$_POST['update_optn_d'];
	$update_answer=$_POST['update_answer'];
	$update_answer_details=$_POST['update_answer_details'];
	$update_cntng_marks=$_POST['update_cntng_marks'];
	if (empty($update_qsn_num)) {
		array_push($errors, "Please enter question number. It can't be empty while updat");
	}
	if (empty($update_question)) {
		array_push($errors, "Please enter question. It can't be empty while updat");
	}
	if (empty($update_option_a)) {
		array_push($errors, "Please enter option_a. It can't be empty while updat");
	}
	if (empty($update_option_b)) {
		array_push($errors, "Please enter option_b. It can't be empty while updat");
	}
	if (empty($update_option_c)) {
		array_push($errors, "Please enter option_c. It can't be empty while updat");
	}
	if (empty($update_option_d)) {
		array_push($errors, "Please enter option_d. It can't be empty while updat");
	}
	if (empty($update_answer)) {
		array_push($errors, "Please enter answer. It can't be empty while updat");
	}
	if (empty($update_cntng_marks)) {
		array_push($errors, "Please enter containing marks. It can't be empty while updat");
	}

// -----------TO EDIT QUESTION DETAILS CHECKING EXISTANCE------------------
	$edit_qsn_qry=@"SELECT * FROM questions_collections WHERE id='$update_question_id' AND field_id='$cat_details_id' AND question_set='$set_number'";
	$edit_qsn_execute=mysqli_query($con_exam,$edit_qsn_qry) or die($con_exam);
		if (mysqli_num_rows($edit_qsn_execute)==0) {
			array_push($errors, "There is not any questions present on the id = ".$edit_qsn_id." on this set in this category");
		}

	if (count($errors)==0) {
	$update_question_query=@"UPDATE questions_collections SET question_no='$update_qsn_num',question_header='$update_question_header',question_details='$update_question_details',question_footer='$update_question_footer',option_a='update_option_a',option_b='$update_option_b', option_c='$update_option_c', option_d='$update_option_d', answer='$update_answer', answer_details='$update_answer_details', containing_marks='$update_cntng_marks' WHERE id='$update_question_id' ";

	// -------------WHEN WE TRY TO UPDATE question then fatal error occurs others are working fine---
	$update_question_result=mysqli_query($con_exam,$update_question_query) or die($con_exam);
	if ($update_question_result==1) {
			$Sucess="Your Question has been UPDATED sucessfully presented on id ->".$update_question_id;
			
		}
	else{
		array_push($errors, "Error occurs during updating Questions");
	}
	}
}

// id field_id question_set question_no question option_a option_b option_c option_d answer answer_details containing_marks

// --------------TO ADD QUESTIONS ON THAT SETS OF CATEGORY----------------
if (isset($_POST['add_questions'])) {
	$qsn_num=$_POST['qsn_num'];
	$question_header=$_POST['question_header'];
	$question_details=$_POST['question_details'];
	$question=$_POST['question'];
	$question_footer=$_POST['question_footer'];
	$option_a=$_POST['optn_a'];
	$option_b=$_POST['optn_b'];
	$option_c=$_POST['optn_c'];
	$option_d=$_POST['optn_d'];
	$answer=$_POST['answer'];
	$answer_details=$_POST['add_answer_details'];
	$cntng_marks=$_POST['cntng_marks'];
	if (empty($answer_details)) {
		$answer_details="NA";
	}

	if (empty($qsn_num)) {
		array_push($errors, "Please enter question number to add");
	}
	if (empty($question)) {
		array_push($errors, "Please enter question to add");
	}
	if (empty($option_a)) {
		array_push($errors, "Please enter option_a to add");
	}
	if (empty($option_b)) {
		array_push($errors, "Please enter option_b to add");
	}
	if (empty($option_c)) {
		array_push($errors, "Please enter option_c to add");
	}
	if (empty($option_d)) {
		array_push($errors, "Please enter option_d to add");
	}
	if (empty($answer)) {
		array_push($errors, "Please enter answer to add");
	}
	if (empty($cntng_marks)) {
		array_push($errors, "Please enter containing marks to add");
	}

	if (count($errors)==0) {
	$add_question_query=@"INSERT INTO questions_collections(field_id,question_set,question_no,question_header,question_details,question,question_footer,option_a,option_b,option_c,option_d,answer,answer_details,containing_marks)VALUES('$cat_details_id','$set_number','$qsn_num','$question_header','$question_details','$question',question_footer,'$option_a','$option_b','$option_c','$option_d','$answer','$answer_details','$cntng_marks')";
	$add_question_result=mysqli_query($con_exam,$add_question_query) or die($con_exam);
	if ($add_question_result==1) {
			$Sucess="Your Question has been uploaded sucessfully on question no-> ".$qsn_num;
			
		}
	else{
		array_push($errors, "Error occurs during adding Questions");
	}
	}
}

// ---------------DELETE QUESTION-------------------
if (isset($_POST['del_question'])) {
	$del_qsn_id=$_POST['del_qsn_id'];
	if (empty($del_qsn_id)) {
		array_push($errors, "QUESTION ID is required to delete QUESTION");
	}
	$question_exists_qry=@"SELECT * FROM questions_collections WHERE id='$del_qsn_id' AND field_id='$cat_details_id' AND question_set='$set_number'";
	$question_exists_execute=mysqli_query($con_exam,$question_exists_qry) or die($con_exam);
	if (mysqli_num_rows($question_exists_execute)==0) {
		array_push($errors, "There is not any questions on database belongings to id= ".$del_qsn_id." on this category.");
	}
	if (count($errors)==0) {
		$del_qsn_query=@"DELETE FROM questions_collections WHERE id='$del_qsn_id'";
		$del_qsn_execute=mysqli_query($con_exam,$del_qsn_query) or die($con_exam);
		if ($del_qsn_execute==1) {
			$Sucess="Question has been deleted suscessfully presented on category ->".$cat_details_name." of SET -> ".$set_number." of id -> ".$del_qsn_id;
			// header("Refresh:3");
		}
		else{
			array_push($errors, "Error occurs on deleting category of id = ".$del_qsn_id);
		}
	}
}

	// -----------For Pagination----------
	 if (isset($_GET['pageno'])) {
     	$pageno = $_GET['pageno'];
   	} else {
      	$pageno = 1;
    }

  	$no_of_records_per_page = 10;
  	$starting_from = ($pageno-1) * $no_of_records_per_page;

  	$total_pages_sql = "SELECT * FROM questions_collections WHERE field_id='$cat_details_id' AND question_set='$set_number'";
    $result = mysqli_query($con_exam,$total_pages_sql);
    if (mysqli_num_rows($result)>0) {
    	$total_rows = mysqli_num_rows($result);
    	// echo "Total rows => ".$total_rows;
    	$total_pages = ceil($total_rows / $no_of_records_per_page);
    }else{
    	$total_pages=1;
    }

// ___-------------------GETTING ALL DETAILS----------------------
$question_details_qry=@"SELECT * FROM questions_collections WHERE field_id='$cat_details_id' AND question_set='$set_number'  LIMIT $starting_from, $no_of_records_per_page";

// $question_details_qry=@"SELECT * FROM questions_collections WHERE field_id='$cat_details_id' AND question_set='$set_number'";
$question_details_execute=mysqli_query($con_exam,$question_details_qry) or die($con_exam);
?>

<?php include 'heading.php'; ?>
<?php include 'admin_nav.php';?>

<head>
	<title>ONLINE ENTRANCE | Categories Available for exam</title>
	<script src="assests/js/functions.js" type="text/javascript"></script>
</head>

<style type="text/css">
	.myPagerBtn{
	border-color: #008DBC;
	background-color: #f2f2f2;
	color: black;
	width: 60px;
}
.myPagerBtn>a{
	text-decoration: none;
}
.myPagerBtn:hover{
	background-color: #09C1FF;
	color: white;
}
</style>

<!-- ********************************STARTING OF MAIN SECTIONS************************************ -->

<div class="row">
	<div class="col-lg-1 col-md-1"></div>
	<div class="col-lg-10 col-md-10 col-xs-12 myRowBorder">

		<!-- ------------------------HEADER---------------------- -->
		<div class="mySubRowBorder">
			<u  style="color: #1222B5;"><h2 class="text-center">QUESTIONS PRESENTS ON SET -> <?php echo $set_number ?>, CATEGORY -> <?php echo strtoupper($cat_details_name); ?></h2></u>
 			<!-- <h4 class="text-center text-info">Please read the following informations carefully before starting the exams.</h4> -->
		</div>

			<!-- -------------------------ADD CATEGORY BTN-------------------- -->
		<div class="row">
			<div class="col-lg-4 col-md-4"></div>
			<div class="col-lg-4 col-md-4 col-xs-12 p-2">
					<button type="button" class="btn btn-primary btn-lg btn-block" data-toggle="modal" data-target="#forAddQuestion">
					ADD QUESTIONS
				</button>
			</div>
			<div class="col-lg-4 col-md-4 p-2">
				<button type="button" class="btn btn-info btn-lg btn-block">
					PRINT SET
				</button>
			</div>
		</div>

			<!-- -----------------FOR SUCESS MESSAGE_----------- -->
		<div class="row">
			<div class="col-lg-12 col-md-12 col-xs-12">
					<?php include('errors.php');?>
							<?php if ($Sucess!="") {?>
				<div class="success">
					<?php echo $Sucess; ?>
				</div>
						<?php  } ?>
			</div>
		</div>
	</div>
	<div class="col-lg-1 col-md-1"></div>
</div>


<!-- ----------SHOWING ALL THE QUESTIONS ON TABLES------------- -->

<div class="row">
	<div class="col-lg-1 col-md-1"></div>
	<div class="col-lg-10 col-md-10 col-xs-12 myRowBorder">
		<div class="mySubRowBorder">
			<u  style="color: #1222B5;"><h2 class="text-center">CATEGORIES WITH DETAILS</h2></u>
 			<h4 class="text-center text-info">Please check column Action for update and delete .</h4>
		</div>

		<div class="row">
			<div class="col-lg-12 col-md-12 col-xs-12">
				<table class="table table-striped">
					<thead class="myHeader" style="color: white;">
						<tr>
							<th class="text-center"><strong>Qsn_ID</strong></th>
							<th class="text-center"><strong>Qsn_No<strong></th>
							<th class="text-center"><strong>Question</strong></th>
							<th class="text-center"><strong>Answer</strong></th>
							<th class="text-center"><strong>Cntng_Marks</strong></th>							
							<th></th>
							<th class="text-center"><strong>Action</strong></th>
							<th></th>
						</tr>
					</thead>
					<tbody>
						 <?php while ($question_rows=mysqli_fetch_assoc($question_details_execute)) { ?>
						<tr align="center">
							<td><?php echo $question_rows['id']; ?></td>
							<td><?php echo $question_rows['question_no']; ?></td>
							<td><?php echo $question_rows['question']; ?></td>
							<td><?php echo $question_rows['answer']; ?></td>
							<td><?php echo $question_rows['containing_marks']; ?></td>
							<td>
								<!-- <button type="submit" class="btn btn-primary" name="view_cat_details">Edit</button> -->
								<button type="button" class="btn btn-primary" data-toggle="modal" data-target="#forUpdateQuestion" onclick="updateQuestion('<?php echo $question_rows['id']; ?>')">Edit</button>
							</td>

							<td>
								<button type="button" class="btn btn-info" data-toggle="modal" data-target="#forViewingQuestion" onclick="viewQuestion('<?php echo $question_rows['id']; ?>')">View</button>
							</td>

							<td>
								<form method="post">
									<input type="hidden" name="del_qsn_id" value="<?php echo $question_rows['id']; ?>">
									<button type="submit" class="btn btn-warning" name="del_question"  onclick="return confirmDel();">Delete</button>
								</form>
							</td>
						</tr>
						<?php }  ?>
					</tbody>
				</table>
					<!-- -----------Pagination--------- -->
				<div class="pager text-center">
			        <a href="?pageno=1" class="btn btn-default myPagerBtn">First</a>
			        <a class="btn btn-default myPagerBtn <?php if($pageno <= 1){ echo 'disabled'; } ?>" href="<?php if($pageno <= 1){ echo '#'; } else { echo "?pageno=".($pageno - 1); } ?>">Prev</a>
			        <a class="btn btn-default myPagerBtn <?php if($pageno >= $total_pages){ echo 'disabled'; } ?>" href="<?php if($pageno > $total_pages){ echo '#'; } else { echo "?pageno=".($pageno + 1); } ?>">Next</a>
			        <a class="btn btn-default myPagerBtn" href="?pageno=<?php echo $total_pages; ?>">Last</a>
			    </div>
			    <!-- <button class="disable">Button</button><button class="active">Button</button> -->
			</div>
		</div>
	</div>
	<div class="col-lg-1 col-md-1"></div>
</div>

<!-- -----------------AJAX CODES---------------- -->

<script type="text/javascript">

				// <!-- ------EDITING/UPDATING DETAILS----------- -->
	function updateQuestion(id) {
		$('#update_question_id').val(id);

		$.post("getDataForModels.php",{
			update_question_id:id
		},function(data,status){
			var set=JSON.parse(data);
			$('#update_qsn_num').val(set.question_no);
			$('#update_question_header').val(set.question_header);
			$('#update_question_details').val(set.question_details);
			$('#update_question').val(set.question);
			$('#update_question_footer').val(set.question_footer);
			$('#update_optn_a').val(set.option_a);
			$('#update_optn_b').val(set.option_b);
			$('#update_optn_c').val(set.option_c);
			$('#update_optn_d').val(set.option_d);
			$('#update_answer').val(set.answer);
			$('#update_answer_details').val(set.answer_details);
			$('#update_cntng_marks').val(set.containing_marks);
		}

			);
		$('#forUpdateQuestion').modal("show");
	}


	// ----------VIEWING DETAILS-----------------
// update_qsn_num update_question update_optn_a update_optn_b update_optn_c update_optn_d update_answer update_cntng_marks update_answer_details
	
// id
// field_id
// question_set
// question_no
// question
// option_a
// option_b
// option_c
// option_d
// answer
// answer_details
// containing_marks
	function viewQuestion(id){

		$.post("getDataForModels.php",{
			view_question_id:id
		},function(data,status){
			var set=JSON.parse(data);
			$('#view_qsn_num').html(set.question_no);
			$('#view_question_header').html(set.question_header);
			$('#view_question_details').html(set.question_details);
			$('#view_question').html(set.question);
			$('#view_question_footer').html(set.question_footer);
			$('#view_optn_a').html(set.option_a);
			$('#view_optn_b').html(set.option_b);
			$('#view_optn_c').html(set.option_c);
			$('#view_optn_d').html(set.option_d);
			$('#view_answer').html(set.answer);
			$('#view_answer_details').html(set.answer_details);
			$('#view_cntng_marks').html(set.containing_marks);
		}

			);
		$('#forViewingQuestion').modal("show");
	}
</script>


<!-- ---------------------FOOTER-------------- -->
<?php include 'footer.php'; ?>


<!-- *************************ENDING OF MAIN SECTIONS******************** -->


<!-- ..........for adding Set............ -->

<div class="modal fade" id="forAddQuestion" tabindex="-1" role="dialog" aria-labelledby="forAddQuestion" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <!-- <h5 class="modal-title" id="forAddSet">Add Set</h5><br> -->
        <h5 class="modal-title text-danger" id="forAddQuestion">Please Insert question carefully</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <div class="myForm">
            <form action="" method="post">
              <div class="form-group">
                  <label for="text" class="bg-white"><span class="text-danger font-weight-bold">* </span>Represents Required field is compulsory</label>
              </div>

              <div class="form-group">
                  <label for="number">Question Number:<span class="text-danger">*</span></label>
                  <input type="number" class="form-control" id="number" placeholder="Enter Question Number" name="qsn_num" value="<?php echo($qsn_num); ?>">
              </div>

              <div class="form-group">
                  <label for="question_header">Question Header (<span class="text-warning">Only if header is necessary</span>):</label>
                  <textarea type="text" class="form-control" id="question_header" placeholder="Enter Question Header" name="question_header"></textarea>
              </div>

              <div class="form-group">
                  <label for="question_details">Question Details (<span class="text-warning">Only if relation with question <span class="text-muted">eg: paragraph</span></span>):</label>
                  <textarea type="text" class="form-control" id="question_details" placeholder="Enter Question details" name="question_details"></textarea>
              </div>

              <div class="form-group">
                  <label for="text">Question:<span class="text-danger">*</span></label>
                  <textarea type="text" class="form-control" id="question" placeholder="Enter Question" name="question"></textarea>
              </div>

              <div class="form-group">
                  <label for="question_footer">Question Footer (<span class="text-warning">Only if footer is necessary</span>):</label>
                  <textarea type="text" class="form-control" id="question_footer" placeholder="Enter Question footer" name="question_footer"></textarea>
              </div>

              <div class="form-group">
                  <label for="text">Option a:<span class="text-danger">*</span></label>
                  <textarea type="text" class="form-control" id="text" placeholder="Enter option a" name="optn_a" value="<?php echo($optn_a); ?>"></textarea>
              </div>

              <div class="form-group">
                  <label for="text">Option b:<span class="text-danger">*</span></label>
                  <textarea type="text" class="form-control" id="text" placeholder="Enter option b" name="optn_b" value="<?php echo($optn_b); ?>"></textarea>
              </div>

              <div class="form-group">
                  <label for="text">Option c:<span class="text-danger">*</span></label>
                  <textarea type="text" class="form-control" id="text" placeholder="Enter option c" name="optn_c" value="<?php echo($optn_c); ?>"></textarea>
              </div>

              <div class="form-group">
                  <label for="text">Option d:<span class="text-danger">*</span></label>
                  <textarea type="text" class="form-control" id="text" placeholder="Enter option d" name="optn_d" value="<?php echo($optn_d); ?>"></textarea>
              </div>

				<div class="form-group">
                  <label for="text">Correct Option:<span class="text-danger">*</span></label>
                  <input type="text" class="form-control" id="text" placeholder="Enter Correct answer as a,b,c,d" name="answer" value="<?php echo($answer); ?>">
              </div> 

              <div class="form-group">
                  <label for="update_answer">Answer Details:</label>
                  <textarea type="text" class="form-control" id="add_answer_details" placeholder="Ente Answer Details" name="add_answer_details"></textarea>
              </div>               

              <div class="form-group">
                  <label for="number">Marks:<span class="text-danger">*</span></label>
                  <input type="number" class="form-control" id="number" placeholder="Enter Question Marks" name="cntng_marks" value="<?php echo($cntng_marks); ?>">
              </div>
                      <button type="submit" class="btn btn-primary" name="add_questions">Add Question</button>
            </form>
        </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
      </div>
    </div>
  </div>
</div>
<!-- .............adding set finished........... -->


<!-- ..........for updating Question............ -->

<div class="modal fade" id="forUpdateQuestion" tabindex="-1" role="dialog" aria-labelledby="forUpdateQuestion" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <!-- <h5 class="modal-title" id="forAddSet">Add Set</h5><br> -->
        <h5 class="modal-title text-danger" id="forUpdateQuestion">Please update question details carefully</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <div class="myForm">
            <form action="" method="post">

              <div class="form-group">
                  <label for="text" class="bg-white"><span class="text-danger font-weight-bold">* </span>Represents Required field is compulsory</label>
              </div>

              <div class="form-group">
                  <label for="update_qsn_num">Question Number:<span class="text-danger font-weight-bold">*</span></label>
                  <input type="number" class="form-control" id="update_qsn_num" placeholder="Enter Question Number" name="update_qsn_num">
              </div>

              <div class="form-group">
                  <label for="update_question">Question Header (<span class="text-warning">Only if header is necessary</span>):</label>
                  <textarea type="text" class="form-control" id="update_question_header" placeholder="Enter Question details" name="update_question_header"></textarea>
              </div>

              <div class="form-group">
                  <label for="update_question">Question Details (<span class="text-warning">Only if relation with question (<span class="text-muted">eg: paragraph</span></span>):</label>
                  <textarea type="text" class="form-control" id="update_question_details" placeholder="Enter Question details" name="update_question_details"></textarea>
              </div>

              <div class="form-group">
                  <label for="update_question">Question:<span class="text-danger font-weight-bold">*</span></label>
                  <textarea type="text" class="form-control" id="update_question" placeholder="Enter Question" name="update_question"></textarea>
              </div>

              <div class="form-group">
                  <label for="update_question_footer">Question Footer (<span class="text-warning">Only if footer is necessary</span>):</label>
                  <textarea type="text" class="form-control" id="update_question_footer" placeholder="Enter Question footer" name="update_question_footer"></textarea>
              </div>

              <div class="form-group">
                  <label for="update_optn_a">Option a:<span class="text-danger font-weight-bold">*</span></label>
                  <textarea type="text" class="form-control" id="update_optn_a" placeholder="Enter option a" name="update_optn_a"></textarea>
              </div>

              <div class="form-group">
                  <label for="update_optn_b">Option b:<span class="text-danger font-weight-bold">*</span></label>
                  <textarea type="update_optn_b" class="form-control" id="update_optn_b" placeholder="Enter option b" name="update_optn_b"></textarea>
              </div>

              <div class="form-group">
                  <label for="update_optn_c">Option c:<span class="text-danger font-weight-bold">*</span></label>
                  <textarea type="text" class="form-control" id="update_optn_c" placeholder="Enter option c" name="update_optn_c"></textarea>
              </div>

              <div class="form-group">
                  <label for="update_optn_d">Option d:<span class="text-danger font-weight-bold">*</span></label>
                  <textarea type="text" class="form-control" id="update_optn_d" placeholder="Enter option d" name="update_optn_d"></textarea>
              </div>

			  <div class="form-group">
                  <label for="update_answer">Correct Option:<span class="text-danger font-weight-bold">*</span></label>
                  <input type="text" class="form-control" id="update_answer" placeholder="Enter Correct answer as a,b,c,d" name="update_answer">
              </div> 

              <div class="form-group">
                  <label for="update_answer">Answer Details:</label>
                  <textarea type="text" class="form-control" id="update_answer_details" placeholder="Enter Answer Details" name="update_answer_details"></textarea>
              </div>              

              <div class="form-group">
                  <label for="update_cntng_marks">Marks:<span class="text-danger font-weight-bold">*</span></label>
                  <input type="number" class="form-control" id="update_cntng_marks" placeholder="Enter Question Marks" name="update_cntng_marks">
              </div>
              		<input type="hidden" name="update_question_id" id="update_question_id">
                    <button type="submit" class="btn btn-primary" name="update_questions">Update Question</button>
            </form>
        </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
      </div>
    </div>
  </div>
</div>
<!-- .............updating Question finished........... -->


<!-- ------------------------VIEWING QUESTION DETAILS FULLY-------------- -->
<div class="modal fade" id="forViewingQuestion" tabindex="-1" role="dialog" aria-labelledby="forViewingQuestion" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title bg-light font-weight-bold text-primary" id="forViewingQuestion">Here is the full details of question and answer:</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
		<div class="myRowBorder" style="padding-left: 10px;">
			<p class="font-weight-bold">HEADER: <span id="view_question_header"> Question will be shown here</span></p>
			<p class="font-weight-bold">==><span id="view_question_details"> Question will be shown here</span></p>
        	<h5 class="font-weight-bold"><span id="view_qsn_num">qsn no.</span>. <span id="view_question"> Question will be shown here</span></h5>
        	<p class="font-weight-bold">FOOTER: <span id="view_question_footer"> Question will be shown here</span></p><br>
        	<p>a. <span id="view_optn_a" class="text-info font-italic"> Question will be shown here</span></p>
        	<p>b. <span id="view_optn_b" class="text-info font-italic"> Question will be shown here</span></p>
        	<p>c. <span id="view_optn_c" class="text-info font-italic"> Question will be shown here</span></p>
        	<p>d. <span id="view_optn_d" class="text-info font-italic"> Question will be shown here</span></p><br>
        	<p class="font-weight-bold">Correct Option : <span id="view_answer" class="text-info font-italic"> Question will be shown here</span></p>
        	<p class="font-weight-bold">Containing Marks : <span id="view_cntng_marks" class="text-info font-italic"> Question will be shown here</span></p>
        	<h3 class="text-light font-weight-bold bg-dark text-center"><u>Answer Details:</u></h3>
        	<p id="view_answer_details" class="text-info font-italic">Answer will be shown here</p>
        </div><br>
        <button class="btn btn-primary">Print</button>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
      </div>
    </div>
  </div>
</div>

<!-- ---------------------------VIEWING QSN FINISHED---------------- -->




