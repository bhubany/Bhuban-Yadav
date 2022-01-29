<?php require 'acess.php'; ?>
<?php 
date_default_timezone_set("Asia/Kathmandu");
$uname=$_SESSION["admin_username"];
$now=date("Y-m-d H:i:s");
$full_name='';
$i=0;
require_once 'admin_database.php';
require_once 'user_database.php';
$admin_query=@"SELECT * FROM admin_users WHERE username='$uname' OR email='$uname'LIMIT 1";
$admin_res=mysqli_query($con_admin,$admin_query) or die($con);
while($admin_rows=mysqli_fetch_assoc($admin_res)){
  $admin_full_name=$admin_rows['full_name'];
  $admin_email=$admin_rows['email'];
  $admin_username=$admin_rows['username'];
}
?>
  

<head>
<!-- <meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <title>ONLINE ENTRANCE MODEL TEST | Navbar</title>
  <link rel="stylesheet" type="text/css" href="assests/css/bootstrap.min.css">
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
  <script src="assests/js/jquery.min.js"></script>
  <script src="assests/js/ajax.js"></script>
  <script src="assests/js/bootstrap.min.js"></script>
<link rel="stylesheet" type="text/css" href="assests/css/myStyle.css"> -->
<style type="text/css">
.myNavBtn{
  border-color: #008DBC;
  background-color: #f2f2f2;
  color: black;
  width: 110px;
}
.myNavBtn>a{
  text-decoration: none;
}
.myNavBtn:hover{
  background-color: #09C1FF;
  color: white;
}
</style>
</head>
<body>

<!-- --------------------STARTING OF MAIN ROW FOR NAVBAR-------------------------- -->
  <div class="row">
    <div class="col-lg-1 col-md-1"></div>

    <div class="col-lg-10 col-md-10 col-xs-12 myHeader">

 
      <!-- ----------------STARTING OF NAVBAR--------------- -->
      <nav class="navbar navbar-expand-md navbar-light">  
      
        <a href="#" class="navbar-brand"></a>
      
        <button type="button" class="navbar-toggler" data-toggle="collapse" data-target="#navbarCollapse">
            <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse" id="navbarCollapse">
            <div class="navbar-nav">
                <!-- <a href="moving_image.php" class="nav-item nav-link active"><button class="btn btn-default myNavBtn ">Moving Img</button></a>

                <a href="recent_event.php" class="nav-item nav-link"><button class="btn btn-default myNavBtn">Events</button></a> -->

                <!-- <a href="feedback_admin.php" class="nav-item nav-link"><button class="btn btn-default myNavBtn">feedback</button></a></a> -->

                <a href="download_category.php" class="nav-item nav-link"><button class="btn btn-default myNavBtn">Downloads</button></a></a>

                <a href="notice_admin.php" class="nav-item nav-link active"><button class="btn btn-default myNavBtn ">Notice</button></a>

                <a href="gallery_album.php" class="nav-item nav-link"><button class="btn btn-default myNavBtn">Gallery</button></a>

                <a href="discussion_category.php" class="nav-item nav-link"><button class="btn btn-default myNavBtn">Discussion</button></a></a>

                <a href="courses_availables.php" class="nav-item nav-link"><button class="btn btn-default myNavBtn">Courses</button></a>

                <a href="exam_category.php" class="nav-item nav-link"><button class="btn btn-default myNavBtn">Exam</button></a>

                <a href="faq_admin.php" class="nav-item nav-link"><button class="btn btn-default myNavBtn">FAQ</button></a>

                <a href="admin_logout.php" class="nav-item nav-link" onclick="return confirmBox();"><button class="btn btn-default myNavBtn">Logout</button></a></a>
            </div>
        </div>
      </nav>
      <!-- -----------------------ENDING OF NAVBAR------------------------ -->
  </div>  

  <div class="col-lg-1 col-md-1"></div>

  </div>
  <!-- -------------------------CLOSING OF MAIN ROW-------------------------- -->