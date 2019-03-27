<?php 
    include("class_lib.php");
   if(isset($_POST['data'])){
	  $layout=new layout();
      $elementos=$layout->get_elementos();
      echo json_encode($layout);
    } 
    exit();
?>

