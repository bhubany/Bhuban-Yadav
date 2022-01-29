<?php 
	// $protocol=$_SERVER['SERVER_PROTOCOL'];
	// echo $protocol;
	// if (strpos($protocol, "HTTPS")) {
	// 	$protocol="HTTPS://";
	// }
	// else{
	// 	$protocol="HTTP://";
	// }
	// $redirect_link_var=$protocol.$_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI'];

if (isset($_POST['upload_img'])) { 
	$uploaded_name=$_FILES['user_img']['name'];
	// echo "uploaded_name => ".$uploaded_name;
    $uploaded_ext=substr($uploaded_name, strrpos($uploaded_name, '.') +1);	#strrpos Find the position of the last occurrence of "php" inside the string:
    $system_ext = pathinfo($uploaded_name, PATHINFO_EXTENSION);
    echo "System_extension => ".$system_ext."<br>";
    #The substr() function returns a part of a string.substr(string,start,length)
    /*Parameter	Description
string	Required. Specifies the string to return a part of
start	Required. Specifies where to start in the string
A positive number - Start at a specified position in the string
A negative number - Start at a specified position from the end of the string
0 - Start at the first character in string
length	Optional. Specifies the length of the returned string. Default is to the end of the string.
A positive number - The length to be returned from the start parameter
Negative number - The length to be returned from the end of the string
If the length parameter is 0, NULL, or FALSE - it return an empty string*/
    $uploaded_size=$_FILES['user_img']['size'];
    $uploaded_type=$_FILES['user_img']['type'];
    $uploaded_temp=$_FILES['user_img']['tmp_name'];


    // $uploaded_name=$_FILES['user_img']['name'];
    // $uploaded_ext=substr($uploaded_name, strrpos($uploaded_name, '.') +1);
	$target_path="test_folder/";
    $target_file="onlineEntrance"."bhubany".'.'.$uploaded_ext;#Generate a unique ID:uniqid
    $temp_file=((ini_get('upload_tmp_dir')=='')?(sys_get_temp_dir() ) : (ini_get('upload_tmp_dir') ) );
    $temp_file .=DIRECTORY_SEPARATOR.md5(uniqid(). $uploaded_name).'.'.$uploaded_ext;
    // if ($uploaded_size<=204800) {
        //--------Creating new image by using previous data(i.e Striping metadata by re-encoding)--------
        if ($uploaded_type =='image/jpeg') {
          $img=@imagecreatefromjpeg($uploaded_temp);
          if($img!=""){
          	$is_converted=imagejpeg($img,$temp_file,-1);
          }else{
          	echo "Invalid image format. Try another image.";
          }
    
      }elseif ($uploaded_type=='image/png') {
        $img=@imagecreatefrompng($uploaded_temp);
        if($img!=""){
        	$is_converted=imagepng($img,$temp_file,-1);
        }else{
          	echo "Invalid image format. Try another image.";
          }
 
      }else{
      	echo "Invalid";
      }

    // imagedestroy($img);
    if ($img!="" && $is_converted!="") {
		$ren= rename($temp_file, (getcwd().DIRECTORY_SEPARATOR.$target_path.$target_file));//move the file
		if ($ren) {
			echo "<h1 style'color:red;'>SUCESS";
		}else{
			echo "Error occurs";
		}
	}else{
		echo "Invalid Image types";
	}

          

    echo "<h1>target file => ".$target_file." <br>temp_file => ".$temp_file."<br> uploaded_name => ".$uploaded_name."<br>uploaded_ext => ".$uploaded_ext."<br>Uploaded_ext => ".$uploaded_size."<br>uploaded_type => ".$uploaded_type."<br>uploaded_temp => ".$uploaded_temp."<br>IMG => ".$img."<br>Temp_file => ".$temp_file."<br>Rename => ".$ren."</h1>";
	// }
}
 ?>


<?php include '../header.php'; ?>
<h2>this is test</h2>

<form method="post" action="" enctype="multipart/form-data">
  <div class="form-group">
      <label for="user_img">Select Image:</label>
      <input type="file" class="form-control" id="user_img" name="user_img"><br>
      <label for="text" class="text-warning text-center">Image size must be less than 200 KB</label>
  </div>

  <button type="submit" class="btn btn-primary" name="upload_img">Upload Image</button>

</form>

<table id="dtHorizontalExample" class="table table-striped table-bordered table-sm" cellspacing="0"
  width="100%">
  <thead>
    <tr>
      <th>First name</th>
      <th>Last name</th>
      <th>Position</th>
      <th>Office</th>
      <th>Age</th>
      <th>Start date</th>
      <th>Salary</th>
      <th>Extn.</th>
      <th>E-mail</th>
    </tr>
  </thead>
  <tbody>
    <tr>
      <td>Tiger</td>
      <td>Nixon</td>
      <td>System Architect</td>
      <td>Edinburgh</td>
      <td>61</td>
      <td>2011/04/25</td>
      <td>$320,800</td>
      <td>5421</td>
      <td>t.nixon@datatables.net</td>
    </tr>
    <tr>
      <td>Garrett</td>
      <td>Winters</td>
      <td>Accountant</td>
      <td>Tokyo</td>
      <td>63</td>
      <td>2011/07/25</td>
      <td>$170,750</td>
      <td>8422</td>
      <td>g.winters@datatables.net</td>
    </tr>
    <tr>
      <td>Ashton</td>
      <td>Cox</td>
      <td>Junior Technical Author</td>
      <td>San Francisco</td>
      <td>66</td>
      <td>2009/01/12</td>
      <td>$86,000</td>
      <td>1562</td>
      <td>a.cox@datatables.net</td>
    </tr>
    <tr>
      <td>Cedric</td>
      <td>Kelly</td>
      <td>Senior Javascript Developer</td>
      <td>Edinburgh</td>
      <td>22</td>
      <td>2012/03/29</td>
      <td>$433,060</td>
      <td>6224</td>
      <td>c.kelly@datatables.net</td>
    </tr>
  </tbody>
</table>

<!--Navigation links with a Smooth Scroll effect-->
<div class="scrollbar scrollbar-primary">
	  <div class="force-overflow">
<ul class="smooth-scroll list-unstyled">
  <li>
    <h5><a href="#test1">Click to scroll to section 1</a></h5>
  </li>
  <br>
  <li>
    <h5><a href="#test2">Click to scroll to section 2</a></h5>
  </li>
  <br>
</ul>

<!--Dummy sections with IDs coressponding with the links above-->
<div id="test1">
  <h3>Section 1</h3>
  <hr>
  <h5>Smooth Scroll Example</h5>
  <h5>Smooth Scroll Example</h5>
  <h5>Smooth Scroll Example</h5>
  <h5>Smooth Scroll Example</h5>
  <h5>Smooth Scroll Example</h5>
  <h5>Smooth Scroll Example</h5>
  <h5>Smooth Scroll Example</h5>
  <h5>Smooth Scroll Example</h5>
</div>


<div id="test2">
  <h3>Section 2</h3>
  <hr>
  <h5>Smooth Scroll Example</h5>
  <h5>Smooth Scroll Example</h5>
  <h5>Smooth Scroll Example</h5>
  <h5>Smooth Scroll Example</h5>
  <h5>Smooth Scroll Example</h5>
  <h5>Smooth Scroll Example</h5>
  <h5>Smooth Scroll Example</h5>
  <h5>Smooth Scroll Example</h5>
</div>


</div>
</div>




<div class="row">
  <div class="col-lg-1 col-md-1"></div>
  <div class="col-lg-4 col-md-4 col-xs-12 mySubROwBorder shadow" style="color: #fff; font-weight: bold;">
	  <div class="table-wrapper-scroll-y my-custom-scrollbar">

  <table class="table table-bordered table-striped mb-0">
    <thead>
      <tr>
        <th scope="col">#</th>
        <th scope="col">First</th>
        <th scope="col">Last</th>
        <th scope="col">Handle</th>
      </tr>
    </thead>
    <tbody>
      <tr>
        <th scope="row">1</th>
        <td>Mark</td>
        <td>Otto</td>
        <td>@mdo</td>
      </tr>
      <tr>
        <th scope="row">2</th>
        <td>Jacob</td>
        <td>Thornton</td>
        <td>@fat</td>
      </tr>
      <tr>
        <th scope="row">3</th>
        <td>Larry</td>
        <td>the Bird</td>
        <td>@twitter</td>
      </tr>
      <tr>
        <th scope="row">4</th>
        <td>Mark</td>
        <td>Otto</td>
        <td>@mdo</td>
      </tr>
      <tr>
        <th scope="row">5</th>
        <td>Jacob</td>
        <td>Thornton</td>
        <td>@fat</td>
      </tr>
      <tr>
        <th scope="row">6</th>
        <td>Larry</td>
        <td>the Bird</td>
        <td>@twitter</td>
      </tr>
    </tbody>
  </table>

</div>	
  </div>
  <div class="col-lg-1 col-md-1"></div>	
</div>


<div class="row"><div class="col-lg-4"><div class="social-wrap"><div><div class="fb-page fb_iframe_widget" data-tabs="timeline" data-href="https://www.facebook.com/mohpnep/?__xts__[0]=68.ARDSZI0xq0Ic7KCcvrhgnxtyxcz5_C2Fe_wz65FGwOpq-8KZLO0blsx2Be7rZSqK3DNT2h3ZuH4Xkx4NOlXQ_IHkq0xB8lUQk-io1Vh4WOdiwiB9iFXxhpV9w1R3E8OATavOgQAiUnMnq3-_PgLutmL5MEGZR2FLjhv7hvX8BsYdHukFtZvKHzSwEa5cp5jJnlwi8YeHh4IqoGFgE-6oIYhNkK-sLNu2sQNHc7VTkcxK-xCzfr4Dersh-3t9BX24Jw2JnI9m_qtd04xdWKASxi-WXMycu9suR7kMX8o0NjCJt0Ndo73HDNZ_0xBYCVW_lC_hQrXmpbALMVP9thDXbycGJWBM" fb-xfbml-state="rendered" fb-iframe-plugin-query="app_id=1272671949596431&amp;container_width=394&amp;href=https%3A%2F%2Fwww.facebook.com%2Fmohpnep%2F%3F__xts__%5B0%5D%3D68.ARDSZI0xq0Ic7KCcvrhgnxtyxcz5_C2Fe_wz65FGwOpq-8KZLO0blsx2Be7rZSqK3DNT2h3ZuH4Xkx4NOlXQ_IHkq0xB8lUQk-io1Vh4WOdiwiB9iFXxhpV9w1R3E8OATavOgQAiUnMnq3-_PgLutmL5MEGZR2FLjhv7hvX8BsYdHukFtZvKHzSwEa5cp5jJnlwi8YeHh4IqoGFgE-6oIYhNkK-sLNu2sQNHc7VTkcxK-xCzfr4Dersh-3t9BX24Jw2JnI9m_qtd04xdWKASxi-WXMycu9suR7kMX8o0NjCJt0Ndo73HDNZ_0xBYCVW_lC_hQrXmpbALMVP9thDXbycGJWBM&amp;locale=en_US&amp;sdk=joey&amp;tabs=timeline"><span style="vertical-align: bottom; width: 340px; height: 500px;"><iframe name="f28a477131852f8" width="1000px" height="1000px" data-testid="fb:page Facebook Social Plugin" title="fb:page Facebook Social Plugin" frameborder="0" allowtransparency="true" allowfullscreen="true" scrolling="no" allow="encrypted-media" src="https://www.facebook.com/v3.1/plugins/page.php?app_id=1272671949596431&amp;channel=https%3A%2F%2Fstaticxx.facebook.com%2Fconnect%2Fxd_arbiter.php%3Fversion%3D46%23cb%3Df3bfb003420891%26domain%3Dcovid19.mohp.gov.np%26origin%3Dhttps%253A%252F%252Fcovid19.mohp.gov.np%252Ff1ad34ec171cc24%26relation%3Dparent.parent&amp;container_width=394&amp;href=https%3A%2F%2Fwww.facebook.com%2Fmohpnep%2F%3F__xts__%5B0%5D%3D68.ARDSZI0xq0Ic7KCcvrhgnxtyxcz5_C2Fe_wz65FGwOpq-8KZLO0blsx2Be7rZSqK3DNT2h3ZuH4Xkx4NOlXQ_IHkq0xB8lUQk-io1Vh4WOdiwiB9iFXxhpV9w1R3E8OATavOgQAiUnMnq3-_PgLutmL5MEGZR2FLjhv7hvX8BsYdHukFtZvKHzSwEa5cp5jJnlwi8YeHh4IqoGFgE-6oIYhNkK-sLNu2sQNHc7VTkcxK-xCzfr4Dersh-3t9BX24Jw2JnI9m_qtd04xdWKASxi-WXMycu9suR7kMX8o0NjCJt0Ndo73HDNZ_0xBYCVW_lC_hQrXmpbALMVP9thDXbycGJWBM&amp;locale=en_US&amp;sdk=joey&amp;tabs=timeline" style="border: none; visibility: visible; width: 340px; height: 500px;" __idm_frm__="225" class=""></iframe></span></div></div></div></div><div class="col-lg-4"><div class="social-wrap"><div class="twitter-wrap"><div><iframe id="twitter-widget-0" scrolling="no" frameborder="0" allowtransparency="true" allowfullscreen="true" class="twitter-timeline twitter-timeline-rendered" style="position: static; visibility: visible; display: inline-block; width: 100%; height: 900px; padding: 0px; border: none; max-width: 100%; min-width: 180px; margin-top: 0px; margin-bottom: 0px; min-height: 200px;" __idm_frm__="226" data-widget-id="profile:mohpnep" title="Twitter Timeline"></iframe></div></div></div></div><div class="col-lg-4"><div class="social-wrap"><div class="embed-responsive embed-responsive-16by9"><iframe class="embed-responsive-item" src="https://www.youtube.com/embed/-sExYoXmhF4?rel=0" allowfullscreen=""></iframe></div><div class="embed-responsive embed-responsive-16by9"><iframe class="embed-responsive-item" src="https://www.youtube.com/embed/qA5uggiPOzM?rel=0" allowfullscreen=""></iframe></div></div></div></div>