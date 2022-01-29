<?php 
	$protocol=$_SERVER['SERVER_PROTOCOL'];
	if (strpos($protocol, "HTTPS")) {
		$protocol="HTTPS://";
	}
	else{
		$protocol="HTTP://";
	}
	$redirect_link_var=$protocol.$_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI'];

 ?>
<ul>
	<li><a href="testlogin.php?url=<?php echo $redirect_link_var; ?>">LOGIn</a></li>
	<li><a href="test1.php">page1</a></li>
	<li><a href="test2.php">page2</a></li>
</ul>