<?php
	include '../conectarse.php';

	$db								=	conectarse_postgres();
	$fecha_carga					=	$_GET['fecha'];
	$turno							=	$_GET['turno'];
	$num_crisoles_recibidos			=	$_GET['num_crisoles_recibidos'];
	$num_crisoles_procesados		=	$_GET['num_crisoles_procesados'];
	$temperatura_crisoles_recibidos	=	$_GET['temperatura_crisoles_recibidos'];
	
	 $sq_m1							=	"SELECT * FROM estatus_planta_colada_turno WHERE fecha = '$fecha_carga'  AND turno = '$turno'";
	 $query_m1						=	mig_query($sq_m1, $db);
	 if (pg_num_rows($query_m1) > 0)
	 {
		 $sq_m2						=	"UPDATE estatus_planta_colada_turno SET 
											num_crisoles_recibidos 		 	= '$num_crisoles_recibidos',
											num_crisoles_procesados 		= '$num_crisoles_procesados',
											temperatura_crisoles_recibidos 	= '$temperatura_crisoles_recibidos'
											WHERE fecha = '$fecha_carga'  AND turno = '$turno'";
		$query_m2					=	mig_query($sq_m2, $db);
		echo "Los datos de la fecha=$fecha_carga en turno=$turno fueron actualizados correctamente";
	}
	else
	{
		$sq_m2						=	"INSERT INTO estatus_planta_colada_turno (fecha, turno, num_crisoles_recibidos, num_crisoles_procesados, temperatura_crisoles_recibidos) 
										VALUES ('$fecha_carga', '$turno', '$num_crisoles_recibidos', '$num_crisoles_procesados', '$temperatura_crisoles_recibidos')";
		$query_m2					=	mig_query($sq_m2, $db);
		echo "Los datos de la fecha=$fecha_carga en turno=$turno fueron ingresados correctamente";
	}
	pg_close($db);
?>