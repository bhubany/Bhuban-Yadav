<?php 
function answer($data)
{
	$ans=implode(" ", $data);
	print_r($ans);
	// echo $_POST[$rows['question_no']];

	$wright=0;
$wrong=0;
$no_attempt=0;
require_once 'exam_database.php';
$query=@"SELECT question_no,answer,containing_marks FROM engineering_questions WHERE field_id=$field_id AND question_set=$set_id";
$result=mysqli_query($con_exam,$query) or die(mysqli_error($con_exam));
while ($rows=mysqli_fetch_assoc($result)) {
	if ($rows['answer']==$_POST) {
		# code...
	}
}
}
 ?>