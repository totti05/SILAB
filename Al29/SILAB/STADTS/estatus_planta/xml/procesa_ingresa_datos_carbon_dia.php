<?php
	include '../conectarse.php';

	$db								=	conectarse_postgres();
	$fecha_carga					=	$_GET['fecha'];
	$produc_anodo_verde				=	$_GET['produc_anodo_verde'];
	$produc_anodo_cocido			=	$_GET['produc_anodo_cocido'];
	$produc_anodo_envarillado		=	$_GET['produc_anodo_envarillado'];

	$inventario_anodo_verde			=	$_GET['inventario_anodo_verde'];
	$inventario_anodo_cocido		=	$_GET['inventario_anodo_cocido'];
	$inventario_anodo_envarillado	=	$_GET['inventario_anodo_envarillado'];
	
	 $sq_m1							=	"SELECT * FROM estatus_planta_carbon_diario WHERE fecha = '$fecha_carga'";
	 $query_m1						=	mig_query($sq_m1, $db);
	 if (pg_num_rows($query_m1) > 0)
	 {
		$sq_m2						=	"UPDATE estatus_planta_carbon_diario SET 
											produc_anodo_verde 				= '$produc_anodo_verde',
											produc_anodo_cocido 			= '$produc_anodo_cocido',
											produc_anodo_envarillado 		= '$produc_anodo_envarillado',
											inventario_anodo_verde 			= '$inventario_anodo_verde',
											inventario_anodo_cocido			= '$inventario_anodo_cocido',
											inventario_anodo_envarillado 	= '$inventario_anodo_envarillado'
											WHERE fecha = '$fecha_carga'";
		$query_m2					=	mig_query($sq_m2, $db);
		echo "Los datos de la fecha = $fecha_carga fueron actualizados correctamente";
	}
	else
	{
		$sq_m2						=	"INSERT INTO estatus_planta_carbon_diario (fecha, produc_anodo_verde, 
											inventario_anodo_verde, produc_anodo_cocido, inventario_anodo_cocido, produc_anodo_envarillado, inventario_anodo_envarillado) 
										VALUES ('$fecha_carga', '$produc_anodo_verde', '$inventario_anodo_verde', '$produc_anodo_cocido', 
											'$inventario_anodo_cocido', '$produc_anodo_envarillado', '$inventario_anodo_envarillado')";
		$query_m2					=	mig_query($sq_m2, $db);
		echo "Los datos de la fecha = $fecha_carga fueron ingresados correctamente";
	}
	pg_close($db);
?>