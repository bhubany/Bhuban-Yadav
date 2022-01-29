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
  width: 150px;
}
.myNavBtn>a{
  text-decoration: none;
}
.myNavBtn:hover{
  background-color: #09C1FF;
  color: white;
}
  .mySubRowBorder{
  border: solid #095EA7 2px;
  background-color: white;
}
</style>
</head>
<body>

<!-- --------------------STARTING OF MAIN ROW FOR NAVBAR-------------------------- -->
<div class="row">
  <div class="col-lg-1 col-md-1"></div>
  <div class="col-lg-10 col-md-10 col-xs-12 mySubRowBorder">
    <!-- ----------------STARTING OF NAVBAR--------------- -->
    <nav class="navbar navbar-expand-md navbar-light">  
    
      <a href="#" class="navbar-brand"></a>
    
      <button type="button" class="navbar-toggler" data-toggle="collapse" data-target="#navbarCollapse">
          <span class="navbar-toggler-icon"></span>
      </button>

      <div class="collapse navbar-collapse" id="navbarCollapse">
          <div class="navbar-nav text-center">
              <!-- <a href="index.php" class="nav-item nav-link active"><button class="btn btn-default myNavBtn ">PROFILE</button></a> -->
              <a href="index.php" class="nav-item nav-link"><button class="btn btn-default myNavBtn">Home</button></a>
              <a href="exam_function.php" class="nav-item nav-link"><button class="btn btn-default myNavBtn">Exam</button></a></a>
              <a href="dashboard.php" class="nav-item nav-link"><button class="btn btn-default myNavBtn">Dashboard</button></a></a>
              <a href="test_details.php" class="nav-item nav-link active"><button class="btn btn-default myNavBtn ">Test Details</button></a>
              <a href="deleteacnt.php" class="nav-item nav-link"><button class="btn btn-default myNavBtn">Unsubscribe</button></a>
              <a href="logout.php" class="nav-item nav-link"><button class="btn btn-default myNavBtn" onclick="return confirmBox();">Logout</button></a></a>
          </div>
          <!-- -------------------------ENDING OF DROP DOWN MENU------------------------->
      </div>
      <!-- ------------------------ENDING OF COLLAPSE NAVBAR COLLAPSE------------------- -->
    </nav>
    <!-- -----------------------ENDING OF NAVBAR------------------------ -->
  </div>
  <div class="col-lg-1 col-md-1"></div>
</div>
  <!-- -------------------------CLOSING OF MAIN ROW-------------------------- -->