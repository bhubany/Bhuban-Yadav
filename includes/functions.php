<?php 
// require '../db.php';


// ---------Cleaning values preventing SQL Injections---------

function clean_values($connection,$value){
	$cleaned_value=stripcslashes($value);
	$cleaned_value=stripslashes($cleaned_value);
	$cleaned_value=mysqli_real_escape_string($connection,$cleaned_value);
	return $cleaned_value;
}

// $value=clean_values($con,"SELECT * FROM user_info WHERE username='bhubany'");

// echo $value;

//Website visitors counter-----------

// function is_unique_view($conn, $visitor_ip, $page)
// {
//   $query = "SELECT * FROM page_views WHERE visitor_ip='$visitor_ip' AND page_id='$page_id'";
//   $result = mysqli_query($conn, $query);
  
//   if(mysqli_num_rows($result) > 0)
//   {
//     return false;
//   }
//   else
//   {
//     return true;
//   }
// }
// function add_view($conn, $visitor_ip, $page_id)
// {
//   if(is_unique_view($conn, $visitor_ip, $page_id) === true)
//   {
//     // insert unique visitor record for checking whether the visit is unique or not in future.
//     $query = "INSERT INTO page_views (visitor_ip, page_id) VALUES ('$visitor_ip', '$page_id')";
    
//     if(mysqli_query($conn, $query))
//     {
//       // At this point unique visitor record is created successfully. Now update total_views of specific page.
//       $query = "UPDATE pages SET total_views = total_views + 1 WHERE id='$page_id'";
      
//       if(!mysqli_query($conn, $query))
//       {
//         echo "Error updating record: " . mysqli_error($conn);
//       }
//     }
//     else
//     {
//       echo "Error inserting record: " . mysqli_error($conn);
//     }
//   }
// }

 ?>