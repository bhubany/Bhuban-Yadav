 <?php 
 session_start();
 if (isset($_GET['submit'])) {
 	$get_value=$_GET['one'];
 	$get_values=$_GET['two'];
 	$name=$_REQUEST['name'];
 	echo $name;
 	echo $get_value;
 	echo $get_values;
 }
 // else{
 // 	echo "WE DID NOT GET ANY VALUES";
 // }
  ?>