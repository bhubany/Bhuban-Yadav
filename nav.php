<?php require 'db.php'; ?>
	

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
    .bs-example{
        margin: 20px;
    }
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

        <div class="collapse navbar-collapse text-center" id="navbarCollapse">
            <div class="navbar-nav">
                <a href="index.php" class="nav-item nav-link active"><button class="btn btn-default myNavBtn ">Home</button></a>
                <a href="exam_function.php" class="nav-item nav-link"><button class="btn btn-default myNavBtn">Exam</button></a>
                <a href="download_function.php" class="nav-item nav-link"><button class="btn btn-default myNavBtn">Downloads</button></a></a>
                <a href="notice.php" class="nav-item nav-link"><button class="btn btn-default myNavBtn">Notice</button></a></a>
                <a href="discussion_function.php" class="nav-item nav-link active"><button class="btn btn-default myNavBtn ">Discussion</button></a>
                <a href="gallery.php" class="nav-item nav-link"><button class="btn btn-default myNavBtn">Gallery</button></a>
                <a href="about.php" class="nav-item nav-link"><button class="btn btn-default myNavBtn">About us</button></a></a>
                <a href="faq.php" class="nav-item nav-link"><button class="btn btn-default myNavBtn">FAQ</button></a></a>
                <?php if (isset($_SESSION['username'])) { ?>
                  <a class="nav-item nav-link" href="login.php"><button class="btn btn-default myNavBtn">Profile</button></a>
                  <?php }else{ ?>
                <a class="nav-item nav-link" href="login.php"><button class="btn btn-default myNavBtn">Login</button></a>
              <?php } ?>
            </div>


            <!-- ---------------------DROP DOWN MENU ON NAVBAR---------------------------->
           <!--  <div class="navbar-nav ml-auto nav-item dropdown">
                
                <a class="nav-link dropdown-toggle" href="" id="navbarDropdownMenuLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                  <button class="btn btn-default myNavBtn">Login</button>
                </a>
                
                <div class="dropdown-menu" aria-labelledby="navbarDropdownMenuLink">
                    <a class="dropdown-item" href="admin/"><button class="btn btn-default myNavBtn">Admin</button></a>
                    <a class="dropdown-item" href="login.php"><button class="btn btn-default myNavBtn">Website</button></a>
                    <a class="dropdown-item" href="#"><button class="btn btn-default myNavBtn">Instutions</button></a>
                </div>

            </div> -->
            <!-- -------------------------ENDING OF DROP DOWN MENU------------------------->
        </div>
      <!-- ------------------------ENDING OF COLLAPSE NAVBAR COLLAPSE------------------- -->
      </nav>
      <!-- -----------------------ENDING OF NAVBAR------------------------ -->
  </div>  

  <div class="col-lg-1 col-md-1"></div>

  </div>
  <!-- -------------------------CLOSING OF MAIN ROW-------------------------- -->