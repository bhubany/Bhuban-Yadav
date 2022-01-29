<?php
$errors=array();
 $log_uname='bhubany';
 // $log_pwd=md5('bhubany');
 $log_pwd='bhubany';
if (isset($_REQUEST['log_admin'])) {
	$adm_username=stripslashes($_REQUEST['username']);
	// $adm_username=mysqli_real_escape_string($admin_con,$adm_username);
	$adm_password=stripslashes($_REQUEST['password']);
	// $adm_password=mysqli_real_escape_string($admin_con,$adm_password);
	if (isset($_POST['robot'])) {
		$log_robot=1;
		}
		else{
			$log_robot=0;
		}
	if (empty($adm_username)) 
		 {
    	array_push($errors, "Username is required");
  		 }
  	if (empty($adm_password))
  		{
    	array_push($errors, "Password is required");
		}
	if ($log_robot!=1)
  		{
    	array_push($errors, "Check I am not a Robot.");
		}

		if (count($errors) == 0) {
			// $adm_password=md5($adm_password);
	// 		$query="SELECT * FROM admin_users WHERE (username='$adm_username' or email='$adm_username') and password='$adm_password' ";
	// 	$result=mysqli_query($admin_con,$query) or die(mysqli_error($admin_con));
		
	// while($rows=mysqli_fetch_assoc($result)) {
	// 		$log_uname=$rows['username'];
	// 		$log_pwd=$rows['password'];
	// 		$log_eml=$rows['email'];
	// 		$log_id=$rows['id'];
	// 		// $active=$rows['is_active'];
	// 	}
		if ($log_uname===$adm_username || $log_eml===$adm_username) 
			{
				if ($adm_password===$log_pwd)
					{			
							$_SESSION['admin_username']=$log_uname;
							
	 						#redirect to index.php
							header("Location:index.php");
						}
				else
					{
					array_push($errors, "Wrong username/password combination");
					#-------------TRACK IP AND INSERT INTO ADMIN LOGIN ERRORS------------
					}

			}
		else
			{
			array_push($errors, "Wrong username/password combination");
			}
		}
	}
	?>