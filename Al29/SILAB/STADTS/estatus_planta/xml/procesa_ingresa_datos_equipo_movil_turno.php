<?php
	include '../conectarse.php';

	$db									=	conectarse_postgres();
	$fecha_carga						=	$_GET['fecha_carga'];
	$turno_carga						=	$_GET['turno'];
	$sub_area							=	$_GET['sub_area'];
	$area								=	$_GET['area'];

	$n									=	0;
	$n_max								=	5;
	$n2									=	1;

	$valores_estandar					=	explode(',', $_GET['valores_estandar']);
	$valores_operativo					=	explode(',', $_GET['valores_operativo']);

	$sq_m2								=	"SELECT estatus_planta_diccionario_area.desc_area, estatus_planta_diccionario_sub_area.desc_sub_area 
											FROM estatus_planta_diccionario_area INNER JOIN estatus_planta_diccionario_sub_area ON
											estatus_planta_diccionario_area.id_area = estatus_planta_diccionario_sub_area.id_area
											WHERE estatus_planta_diccionario_sub_area.id_sub_area = '$sub_area'";
	$query_m2							=	mig_query($sq_m2, $db);
	$res_m2								=	pg_fetch_array($query_m2);
	while ($n < $n_max)
	{
		$sq_m1[$n]						=	"INSERT INTO estaus_planta_equipo_movil (fecha, turno, area, sub_area, tipo_equipo_movil, cantidad_estandar, cantidad_operativo)
											VALUES ('$fecha_carga', '$turno_carga', '$area', '$sub_area', '$n2', '$valores_estandar[$n]', '$valores_operativo[$n]');";
		$n++;
		$n2++;
	}


	$sq_m2								=	"SELECT * FROM estaus_planta_equipo_movil WHERE fecha = '$fecha_carga' AND turno = '$turno_carga' AND sub_area = '$sub_area';";
	$query_m2							=	mig_query($sq_m2, $db);
	
	$n_inserts							=	count($sq_m1);
	$n									=	0;
	if (pg_num_rows($query_m2) == 0)
	{
		while($n < $n_inserts)
		{
			$query_m1					=	mig_query($sq_m1[$n], $db);
			$n++;
		}
		echo "Los datos de equipo móvil de $res_m2[desc_area] - $res_m2[desc_sub_area] se han ingresado correctamente";
	}
	else
	{
		$sq_m2								=	"DELETE FROM estaus_planta_equipo_movil WHERE fecha = '$fecha_carga' AND turno = '$turno_carga' AND sub_area = '$sub_area';";
		$query_m2							=	mig_query($sq_m2, $db);
		while($n < $n_inserts)
		{
			$query_m1					=	mig_query($sq_m1[$n], $db);
			$n++;
		}
		echo "Los datos de equipo móvil de $res_m2[desc_area] - $res_m2[desc_sub_area] se han modificado correctamente";
	}
	pg_close($db);
?>