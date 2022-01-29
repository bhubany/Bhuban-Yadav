<script type="text/javascript">
  	function timeout(){
  		var minute=Math.floor(timeLeft/60);
  		var second=timeLeft%60;
  		if (timeLeft<=0) {
  			// clearTimeout(tm);
  			document.getElementById('form1').submit();
  		}
  		else{
  			document.getElementById("time").innerHTML=minute+":"+second;
  		}
  		timeLeft--;
  		var tm= setTimeout(function() {timeout()}, 1000);
  	}
  </script>

</head>
<body onload="timeout()" >

	<div class="container">
		<div class="col-sm-2"></div>
	<div class="col-sm-8">
  		<h2>Table</h2> 

			<script type="text/javascript">
		 		 var timeLeft=1*10;
			</script>

      <div id="time" style="float: right;">timeout</div>

  <p>The .table-bordered class adds border on all sides of the table and cells:</p>  
  

  <form  method="post" id="form1" action="answer.php">
<input type="name" name="name">
<input type="submit" name="">
</form>
</div>
</div>
</body>