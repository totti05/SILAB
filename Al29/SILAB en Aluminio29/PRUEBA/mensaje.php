<?php 
	if(isset($_GET['callback'])){ // Si ha llegado callback
        $array = array("mensaje" => "Hola desde mi otro servidor haciendo cross domain con ajax"); 
         echo $_GET['callback'].'('.json_encode($array).')'; }

 ?>