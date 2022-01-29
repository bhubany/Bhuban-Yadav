<?php  
$sucess=array();
// $sucess="";
if (count($sucess) > 0) : ?>
  <div class="error">
  	<?php foreach ($sucess as $sucesses) : ?>
  	  <p><?php echo $sucesses ?></p>
  	<?php endforeach ?>
  </div>
<?php  endif ?>