<?php
	include('../conectarse.php');
	$ficha = $_GET['ficha'];
	
	$conectarse_aluminio20_PORTAL = conectarse_aluminio20_PORTAL();
	$consult_aluminio20_PORTAL = "SELECT *
								  FROM GRUPO
								  WHERE (GRUPO = 202) AND (N_FICHA = '$ficha')";
	$query_aluminio20_PORTAL = mssql_query($consult_aluminio20_PORTAL, $conectarse_aluminio20_PORTAL);
	
	if(mssql_num_rows($query_aluminio20_PORTAL)>0){
		
		$conectNukeDB = conectarse_mysql_scp();
		$consultNUKEDB = "SELECT * FROM nuke_users WHERE username = '$ficha'";
		$queryNUKEDB = mysql_query($consultNUKEDB, $conectNukeDB);
		
		if(mysql_num_rows($queryNUKEDB)>0) {
			
			$conectNukeDB = conectarse_mysql_scp();
			$consultNUKEDB = "UPDATE nuke_users SET user_password = 'e10adc3949ba59abbe56e057f20f883e' WHERE username = '$ficha'";
			$queryNUKEDB = mysql_query($consultNUKEDB, $conectNukeDB);
			echo "Ficha reiniciada con exito.";
		
		}
		else {
			echo "La ficha seleccionada no pertenece a un usuario registrado en el portal";
		}
	}
	else {
		echo "El usuario no pertenece al módulo Estatus de Planta";
	}
?>