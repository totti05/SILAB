<?php
	include '../conectarse.php';

	$db							=	conectarse_postgres();
	$fecha_carga				=	$_GET['fecha'];
	$turno_carga				=	$_GET['turno'];
	$linea						=	$_GET['linea'];
	$observacion_carbon			=	utf8_decode($_GET['observacion_carbon']);
	
	if ($linea == 1)	$sub_area	=	2; 	//sub area molienda
	if ($linea == 2)	$sub_area	=	3;		//sub area horno
	if ($linea == 3)	$sub_area	=	4;		//sub area envarillado

/////////////////////////////////////////////////////////////////////////////////////////	
	$sq_m1						=	"SELECT * FROM estatus_planta_observaciones
										WHERE fecha = '$fecha_carga' AND turno = '$turno_carga' AND id_area = '3' AND id_sub_area = '$sub_area'";
	$query_m1					=	mig_query($sq_m1, $db);
	if (pg_num_rows($query_m1) > 0)
	{
		$sq_m2					=	"UPDATE estatus_planta_observaciones SET observacion = '$observacion_carbon'
										WHERE fecha = '$fecha_carga' AND turno = '$turno_carga' AND id_area = '3' AND id_sub_area = '$sub_area'";
		$query_m2				=	mig_query($sq_m2, $db);
		echo "La observacion del supervisor del área Carbón - $linea ha sido actualizada correctamente";
	}
	else
	{
		$sq_m2					=	"INSERT INTO estatus_planta_observaciones (fecha, observacion, id_area, id_sub_area, num_observacion, turno)
									VALUES ('$fecha_carga', '$observacion_carbon', '3', '$sub_area', '1', '$turno_carga')";
		$query_m2				=	mig_query($sq_m2, $db);
		echo "La observacion del supervisor del area Carbón - $linea ha sido ingresada correctamente";
	}
?>