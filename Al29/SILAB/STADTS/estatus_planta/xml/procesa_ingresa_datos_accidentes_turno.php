<?php
	include '../conectarse.php';

	$db							=	conectarse_postgres();
	$fecha_carga				=	$_GET['dia'];
	$turno_carga				=	$_GET['turno'];
	$area						=	$_GET['area'];
	$num_accidentes				=	$_GET['num_accidentes'];
	$num_lesionados				=	$_GET['num_lesionados'];

	if ($area == '1') $desc_area	=	"Reducción";
	if ($area == '2') $desc_area	=	"Carbón";
	if ($area == '3') $desc_area	=	"Colada";

/////////////////////////////////////////////////////////////////////////////////////////	
	$sq_m1						=	"SELECT * FROM estatus_planta_accidentes
										WHERE fecha = '$fecha_carga' AND turno = '$turno_carga' AND area = '$area'";
	$query_m1					=	mig_query($sq_m1, $db);
	if (pg_num_rows($query_m1) > 0)
	{
		$sq_m2					=	"UPDATE estatus_planta_accidentes SET num_accidente = '$num_accidentes', num_lesionados = '$num_lesionados'
										WHERE fecha = '$fecha_carga' AND turno = '$turno_carga' AND area = '$area'";
		$query_m2				=	mig_query($sq_m2, $db);
		echo "La información de Accidentes del área $desc_area ha sido actualizada correctamente";
	}
	else
	{
		$sq_m2					=	"INSERT INTO estatus_planta_accidentes (fecha, turno, area, num_accidente, num_lesionados)
									VALUES ('$fecha_carga', '$turno_carga', '$area', '$num_accidentes', '$num_lesionados')";
		$query_m2				=	mig_query($sq_m2, $db);
		echo "La información de Accidentes del área $desc_area ha sido ingresada correctamente";
	}
	pg_close($db);
?>