<?php
	include '../conectarse.php';

	$db							=	conectarse_postgres();
	$fecha_carga				=	$_GET['fecha'];
	$turno_carga				=	$_GET['turno'];
	$sub_area					=	$_GET['sub_area'];
	$observacion_colada			=	utf8_decode($_GET['observacion_colada']);
	
	/*if ($linea == 1)	$sub_area	=	11; 	//sub area CCYP
	if ($linea == 2)	$sub_area	=	12;		//sub area verticales
	if ($linea == 3)	$sub_area	=	13;		//sub area horizontales*/

/////////////////////////////////////////////////////////////////////////////////////////	
	$sq_m1						=	"SELECT * FROM estatus_planta_observaciones
										WHERE fecha = '$fecha_carga' AND turno = '$turno_carga' AND id_area = '3' AND id_sub_area = '$sub_area'";
	$query_m1					=	mig_query($sq_m1, $db);
	if (pg_num_rows($query_m1) > 0)
	{
		$sq_m2					=	"UPDATE estatus_planta_observaciones SET observacion = '$observacion_colada'
										WHERE fecha = '$fecha_carga' AND turno = '$turno_carga' AND id_area = '3' AND id_sub_area = '$sub_area'";
		$query_m2				=	mig_query($sq_m2, $db);
		echo "La observacion del supervisor del área Colada - $sub_area ha sido actualizada correctamente";
	}
	else
	{
		echo $sq_m2					=	"INSERT INTO estatus_planta_observaciones (fecha, observacion, id_area, id_sub_area, num_observacion, turno)
									VALUES ('$fecha_carga', '$observacion_colada', '3', '$sub_area', '1', '$turno_carga')";
		$query_m2				=	mig_query($sq_m2, $db);
		echo "La observacion del supervisor del area Colada - $sub_area ha sido ingresada correctamente";
	}
?>