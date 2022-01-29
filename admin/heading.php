<!--   <link rel="stylesheet" type="text/css" href="../assests/css/myStyle.css"> -->
<!DOCTYPE html>
<html lang="en">
<head>
  <title>ONLINE ENTRANCE MODEL TEST | Header</title>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <link rel="stylesheet" type="text/css" href="assests/css/bootstrap.min.css">
  <link rel="stylesheet" type="text/css" href="assests/css/bootstrap-grid.css">
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
  <link rel="stylesheet" type="text/css" href="assests/fontawesome-free/css/all.min.css">
  <link rel="stylesheet" type="text/css" href="assests/icheck-bootstrap/icheck-bootstrap.min.css">
  <script src="assests/js/jquery.min.js"></script>
  <script src="assests/js/ajax.js"></script>
  <script src="assests/js/bootstrap.min.js"></script>
  <link rel="stylesheet" type="text/css" href="assests/css/myStyle.css">
</head>
<style type="text/css">
  .small-box {
  border-radius: 0.25rem;
  box-shadow: 0 0 1px rgba(0, 0, 0, 0.125), 0 1px 3px rgba(0, 0, 0, 0.2);
  display: block;
  margin-bottom: 20px;
  position: relative;
}

.small-box > .inner {
  padding: 10px;
}
.inner{
  color: #ffffff;
}
.small-box > .small-box-footer {
  background: rgba(0, 0, 0, 0.1);
  color: rgba(255, 255, 255, 0.8);
  display: block;
  padding: 3px 0;
  position: relative;
  text-align: center;
  text-decoration: none;
  z-index: 10;
}
.tooltip-inner {
  max-width: 200px;
  padding: 0.25rem 0.5rem;
  color: #ffffff;
  text-align: center;
  background-color: #000;
  border-radius: 0.25rem;
}
</style>

<!-- --------------------------------------STARTING MAIN CODING SECTIONS FROM HERE--------------------------------- -->
<body>

<div class="container-fluid">
<!-- <header id="header" class="header"> -->
    <div class="row">
      <div class="col-lg-1 col-md-1"></div>


      <!-- ----------MAIN WORKING DIVISION FOR HEADER-------------- -->
      <div class="col-lg-10 col-md-10 col-xs-12 myHeader">
        <div class="row">
          <div class="col-lg-2 col-md-2 col-xs-2">
            <a href="index.php" title="ONLINE ENTRANCE"><img src="assests/icons/flag.gif" alt="Logo of Team CORONA"  width="70" height="70"></a> 
          </div>

<!-- ---------------------------------TITLE--------------------------- -->
          <div class="col-lg-8 col-md-8 col-xs-8 myTitle p-3">
            <a href="index.php" style="text-decoration: none;color: #fff;"><span class="logo-title">ONLINE ENTRANCE MODEL TEST</span></a>
          </div>
<!-- ------------------------------TITLE ENDING-------------------------------- -->
    <!-- </div> -->
    
          <div class="col-lg-2 col-md-2 col-xs-2">
            <img src="assests/icons/flag.gif" alt="Flag" width="70" height="70" class="pull-right">
          </div>
      </div>
      
      <div class="row p-2">
          <div class="myRowBorder text-info">
              <span class="font-weight-bold" id="clockbox"></span>            
          </div>
        </div>

    </div>
<!-- ------------------------ENDING OF WORKING DIV HEADER---------------- -->

        <div class="col-lg-1 col-md-1"></div>
    </div>
<!-- </header> -->




<!-- ----------------for clock----- -->

<script type="text/javascript">
var tday=["Sunday","Monday","Tuesday","Wednesday","Thursday","Friday","Saturday"];
var tmonth=["January","February","March","April","May","June","July","August","September","October","November","December"];

function GetClock(){
var d=new Date();
var nday=d.getDay(),nmonth=d.getMonth(),ndate=d.getDate(),nyear=d.getFullYear();
var nhour=d.getHours(),nmin=d.getMinutes(),nsec=d.getSeconds();
if(nmin<=9) nmin="0"+nmin;
if(nsec<=9) nsec="0"+nsec;

var clocktext=""+tday[nday]+", "+tmonth[nmonth]+" "+ndate+", "+nyear+" "+nhour+":"+nmin+":"+nsec+"";
document.getElementById('clockbox').innerHTML=clocktext;
}

GetClock();
setInterval(GetClock,1000);
</script>