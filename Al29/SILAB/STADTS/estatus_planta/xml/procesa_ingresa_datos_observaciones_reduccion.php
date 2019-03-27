<?php
	include '../conectarse.php';

	$db								=	conectarse_postgres();
	$fecha_carga					=	$_GET['fecha'];
	$turno_carga					=	$_GET['turno'];
	$linea							=	$_GET['linea'];
	$observacion_linea				=	utf8_decode($_GET['observacion_linea']);

	$arreglo_celdas_casco_rojo		=	explode(',', $_GET['celdas_casco_rojo']);
	$arreglo_celdas_derrame_al		=	explode(',', $_GET['celdas_derrame_alumina']);
	$arreglo_celdas_derrame_fl		=	explode(',', $_GET['celdas_derrame_floruro']);
	$arreglo_celdas_tolva_bloqueada	=	explode(',', $_GET['celdas_tolva_bloqueada']);

	$n_celdas_casco_rojo			=	count($arreglo_celdas_casco_rojo);
	$n_celdas_derrame_al			=	count($arreglo_celdas_derrame_al);
	$n_celdas_derrame_fl			=	count($arreglo_celdas_derrame_fl);
	$n_celdas_tolva_bloqueada		=	count($arreglo_celdas_tolva_bloqueada);
	
	if ($linea == 1)	$sub_area	=	6;
	if ($linea == 2)	$sub_area	=	7;
	if ($linea == 3)	$sub_area	=	8;
	if ($linea == 4)	$sub_area	=	9;
	if ($linea == 5)	$sub_area	=	10;

	$n								=	0;
	$tipo_variable					=	1;
	$sq_m21							=	"SELECT * FROM estatus_planta_observaciones_reduccion_celdas 
											WHERE fecha = '$fecha_carga' AND turno = '$turno_carga' AND tipo_observacion = '$tipo_variable' AND linea = '$linea'";
	$query_m21						=	mig_query($sq_m21, $db);
	if (pg_num_rows($query_m21) > 0)
	{
		$sq_d1						=	"DELETE FROM estatus_planta_observaciones_reduccion_celdas
											WHERE fecha = '$fecha_carga' AND turno = '$turno_carga' AND tipo_observacion = '$tipo_variable' AND linea = '$linea'";
		$query_d1					=	mig_query($sq_d1, $db);
		while($n < $n_celdas_casco_rojo)
		{
			$sq_m1					=	"INSERT INTO estatus_planta_observaciones_reduccion_celdas (fecha, linea, turno, celda, tipo_observacion) VALUES
										('$fecha_carga', '$linea', '$turno_carga', '$arreglo_celdas_casco_rojo[$n]', '$tipo_variable');";
			$query_m1				=	mig_query($sq_m1, $db);
			$n++;
		}
	 	echo "Los datos de Linea $linea de celdas casco rojo se actualizaron correctamente <br>";
	 }
	 else
	 {
		while($n < $n_celdas_casco_rojo)
		{
			if ($arreglo_celdas_casco_rojo[$n] > 0)
			{
				$sq_m1			=	"INSERT INTO estatus_planta_observaciones_reduccion_celdas (fecha, linea, turno, celda, tipo_observacion) VALUES
									('$fecha_carga', '$linea', '$turno_carga', '$arreglo_celdas_casco_rojo[$n]', '$tipo_variable');";
				$query_m1		=	mig_query($sq_m1, $db);
			}
			$n++;
		}
	 	echo "Los datos de Linea $linea de celdas con casco rojo se ingresaron correctamente <br>";
	 }
/////////////////////////////////////////////////////////////////////////////////////////	
	$tipo_variable				=	2;
	$n							=	0;
	$sq_m21						=	"SELECT * FROM estatus_planta_observaciones_reduccion_celdas 
										WHERE fecha = '$fecha_carga' AND turno = '$turno_carga' AND tipo_observacion = '$tipo_variable' AND linea = '$linea'";
	$query_m21					=	mig_query($sq_m21, $db);
	if (pg_num_rows($query_m21) > 0)
	{
		$sq_d1					=	"DELETE FROM estatus_planta_observaciones_reduccion_celdas
										WHERE fecha = '$fecha_carga' AND turno = '$turno_carga' AND tipo_observacion = '$tipo_variable' AND linea = '$linea'";
		$query_d1				=	mig_query($sq_d1, $db);
		while($n < $n_celdas_derrame_fl)
		{
			$sq_m1				=	"INSERT INTO estatus_planta_observaciones_reduccion_celdas (fecha, linea, turno, celda, tipo_observacion) VALUES
									('$fecha_carga', '$linea', '$turno_carga', '$arreglo_celdas_derrame_fl[$n]', '$tipo_variable');";
			$query_m1			=	mig_query($sq_m1, $db);
			$n++;
		}
	 	echo "Los datos de Linea $linea de celdas con derrame de floruro se actualizaron correctamente <br>";
	 }
	 else
	 {
		while($n < $n_celdas_derrame_fl)
		{
			if ($arreglo_celdas_derrame_fl[$n] > 0)
			{
				$sq_m1			=	"INSERT INTO estatus_planta_observaciones_reduccion_celdas (fecha, linea, turno, celda, tipo_observacion) VALUES
									('$fecha_carga', '$linea', '$turno_carga', '$arreglo_celdas_derrame_fl[$n]', '$tipo_variable');";
				$query_m1		=	mig_query($sq_m1, $db);
			}
			$n++;
		}
	 	echo "Los datos de Linea $linea de celdas derrame de floruro ingresaron correctamente <br>";
	 }
/////////////////////////////////////////////////////////////////////////////////////////	
	$tipo_variable				=	3;
	$n							=	0;
	$sq_m21						=	"SELECT * FROM estatus_planta_observaciones_reduccion_celdas 
										WHERE fecha = '$fecha_carga' AND turno = '$turno_carga' AND tipo_observacion = '$tipo_variable' AND linea = '$linea'";
	$query_m21					=	mig_query($sq_m21, $db);
	if (pg_num_rows($query_m21) > 0)
	{
		$sq_d1					=	"DELETE FROM estatus_planta_observaciones_reduccion_celdas
										WHERE fecha = '$fecha_carga' AND turno = '$turno_carga' AND tipo_observacion = '$tipo_variable' AND linea = '$linea'";
		$query_d1				=	mig_query($sq_d1, $db);
		while($n < $n_celdas_derrame_al)
		{
			$sq_m1				=	"INSERT INTO estatus_planta_observaciones_reduccion_celdas (fecha, linea, turno, celda, tipo_observacion) VALUES
									('$fecha_carga', '$linea', '$turno_carga', '$arreglo_celdas_derrame_al[$n]', '$tipo_variable');";
			$query_m1			=	mig_query($sq_m1, $db);
			$n++;
		}
	 	echo "Los datos de Linea $linea de celdas con derrame de alúmina se actualizaron correctamente <br>";
	 }
	 else
	 {
		while($n < $n_celdas_derrame_al)
		{
			if ($arreglo_celdas_derrame_al[$n] > 0)
			{
				$sq_m1			=	"INSERT INTO estatus_planta_observaciones_reduccion_celdas (fecha, linea, turno, celda, tipo_observacion) VALUES
									('$fecha_carga', '$linea', '$turno_carga', '$arreglo_celdas_derrame_al[$n]', '$tipo_variable');";
				$query_m1		=	mig_query($sq_m1, $db);
			}
			$n++;
		}
	 	echo "Los datos de Linea $linea de celdas derrame de alúmina ingresaron correctamente <br>";
	 }
/////////////////////////////////////////////////////////////////////////////////////////	
	$tipo_variable				=	4;
	$n							=	0;
	$sq_m21						=	"SELECT * FROM estatus_planta_observaciones_reduccion_celdas 
										WHERE fecha = '$fecha_carga' AND turno = '$turno_carga' AND tipo_observacion = '$tipo_variable' AND linea = '$linea'";
	$query_m21					=	mig_query($sq_m21, $db);
	if (pg_num_rows($query_m21) > 0)
	{
		$sq_d1					=	"DELETE FROM estatus_planta_observaciones_reduccion_celdas
										WHERE fecha = '$fecha_carga' AND turno = '$turno_carga' AND tipo_observacion = '$tipo_variable' AND linea = '$linea'";
		$query_d1				=	mig_query($sq_d1, $db);
		while($n < $n_celdas_tolva_bloqueada)
		{
			if ($arreglo_celdas_tolva_bloqueada[$n] > 0)
			{
				$sq_m1				=	"INSERT INTO estatus_planta_observaciones_reduccion_celdas (fecha, linea, turno, celda, tipo_observacion) VALUES
										('$fecha_carga', '$linea', '$turno_carga', '$arreglo_celdas_tolva_bloqueada[$n]', '$tipo_variable');";
				$query_m1			=	mig_query($sq_m1, $db);
			}
			$n++;
		}
	 	echo "Los datos de Linea $linea de celdas con Tolva(s) Bloqueada(s) se actualizaron correctamente <br>";
	 }
	 else
	 {
		while($n < $n_celdas_tolva_bloqueada)
		{
			if ($arreglo_celdas_tolva_bloqueada[$n] > 0)
			{
				$sq_m1			=	"INSERT INTO estatus_planta_observaciones_reduccion_celdas (fecha, linea, turno, celda, tipo_observacion) VALUES
									('$fecha_carga', '$linea', '$turno_carga', '$arreglo_celdas_tolva_bloqueada[$n]', '$tipo_variable');";
				$query_m1		=	mig_query($sq_m1, $db);
			}
			$n++;
		}
	 	echo "Los datos de Linea $linea de celdas con Tolva(s) Bloqueada(s) se ingresaron correctamente <br>";
	 }
/////////////////////////////////////////////////////////////////////////////////////////	
	$sq_m1						=	"SELECT * FROM estatus_planta_observaciones WHERE
										fecha = '$fecha_carga' AND turno = '$turno_carga' AND id_area = '1' AND id_sub_area = '$sub_area'";
	$query_m1					=	mig_query($sq_m1, $db);
	if (pg_num_rows($query_m1) > 0)
	{
		$sq_m2					=	"UPDATE estatus_planta_observaciones SET observacion = '$observacion_linea'
										WHERE fecha = '$fecha_carga' AND turno = '$turno_carga' AND id_area = '1' AND id_sub_area = '$sub_area'";
		$query_m2				=	mig_query($sq_m2, $db);
		echo "La observacion del supervisor de linea $linea ha sido actualizada correctamente";
	}
	else
	{
		echo $sq_m2					=	"INSERT INTO estatus_planta_observaciones (fecha, observacion, id_area, id_sub_area, num_observacion, turno)
									VALUES ('$fecha_carga', '$observacion_linea', '1', '$sub_area', '1', '$turno_carga')";
		$query_m2				=	mig_query($sq_m2, $db);
		echo "La observacion del supervisor de linea $linea ha sido ingresada correctamente";
	}

////////////////////////////////////////////////////////////////////////////////////////////////
?>