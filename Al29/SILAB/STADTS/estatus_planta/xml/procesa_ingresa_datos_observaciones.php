<?php
	include '../conectarse.php';

	$db							=	conectarse_postgres();
	$fecha_carga				=	$_GET['fecha'];
	$turno_carga				=	$_GET['turno'];
	$sub_area					=	$_GET['sub_area'];
	$area						=	$_GET['area'];
	$observacion_sub_area		=	utf8_decode($_GET['observacion_sub_area']);
	$ficha_usuario				=	$_GET['usuario'];

	$hora_act				=	date("H", time()).":".date("i", time()).":".date("s", time());
	$sq_m0					=	"SELECT current_date AS fecha";
	$query_m0				=	mig_query($sq_m0, $db);	
	$res_m0					=	pg_fetch_array($query_m0);
	$fecha_hoy				=	$res_m0['fecha'];
	list($a, $m, $d)		=	split('-', $fecha_hoy);
	$fecha					=	"$d/$m/$a";
	
	$sq_m2								=	"SELECT estatus_planta_diccionario_area.desc_area, estatus_planta_diccionario_sub_area.desc_sub_area 
											FROM estatus_planta_diccionario_area INNER JOIN estatus_planta_diccionario_sub_area ON
											estatus_planta_diccionario_area.id_area = estatus_planta_diccionario_sub_area.id_area
											WHERE estatus_planta_diccionario_sub_area.id_sub_area = '$sub_area'";
	$query_m2							=	mig_query($sq_m2, $db);
	$res_m2								=	pg_fetch_array($query_m2);
/////////////////////////////////////////////////////////////////////////////////////////	
	$sq_m1						=	"SELECT * FROM estatus_planta_observaciones WHERE
										fecha = '$fecha_carga' AND turno = '$turno_carga' AND id_sub_area = '$sub_area'";
	$query_m1					=	mig_query($sq_m1, $db);
	if (pg_num_rows($query_m1) > 0)
	{
		$sq_m2					=	"UPDATE estatus_planta_observaciones SET observacion = '$observacion_sub_area',
									fecha_creacion = '$fecha', hora_creacion = '$hora_act', ficha_usuario = '$ficha_usuario'
										WHERE fecha = '$fecha_carga' AND turno = '$turno_carga'  AND id_sub_area = '$sub_area'";
		$query_m2				=	mig_query($sq_m2, $db);
		echo "La observacion del supervisor de  de $res_m2[desc_area] - $res_m2[desc_sub_area] ha sido actualizada correctamente <br>";
	}
	else
	{
		$sq_m2					=	"INSERT INTO estatus_planta_observaciones (fecha, observacion, id_area, id_sub_area, num_observacion, turno,
									fecha_creacion, hora_creacion, ficha_usuario)
									VALUES ('$fecha_carga', '$observacion_sub_area', '$area', '$sub_area', '1', '$turno_carga', 
									'$fecha', '$hora_act', '$ficha_usuario')";
		$query_m2				=	mig_query($sq_m2, $db);
		echo "La observacion del supervisor de $res_m2[desc_area] - $res_m2[desc_sub_area] ha sido ingresada correctamente <br>";
	}

////////////////////////////////////////////////////////////////////////////////////////////////

	if ($sub_area >= 6 && $sub_area <= 10)
	{
		$arreglo_celdas_casco_rojo		=	explode(',', $_GET['celdas_casco_rojo']);
		$arreglo_celdas_derrame_al		=	explode(',', $_GET['celdas_derrame_alumina']);
		$arreglo_celdas_derrame_fl		=	explode(',', $_GET['celdas_derrame_floruro']);
		$arreglo_celdas_tolva_bloqueada	=	explode(',', $_GET['celdas_tolva_bloqueada']);
	
		$n_celdas_casco_rojo			=	count($arreglo_celdas_casco_rojo);
		$n_celdas_derrame_al			=	count($arreglo_celdas_derrame_al);
		$n_celdas_derrame_fl			=	count($arreglo_celdas_derrame_fl);
		$n_celdas_tolva_bloqueada		=	count($arreglo_celdas_tolva_bloqueada);
		
		if ($sub_area == 6)				$linea	=	1;
		if ($sub_area == 7)				$linea	=	2;
		if ($sub_area == 8)				$linea	=	3;
		if ($sub_area == 9)				$linea	=	4;
		if ($sub_area == 10)			$linea	=	5;
	
	/////////////////////////////////////////////////////////////////////////////////////////	
		$n							=	0;
		$tipo_variable				=	1;
		$sq_m21						=	"SELECT * FROM estatus_planta_observaciones_reduccion_celdas 
											WHERE fecha = '$fecha_carga' AND turno = '$turno_carga' AND tipo_observacion = '$tipo_variable' AND linea = '$linea'";
		$query_m21					=	mig_query($sq_m21, $db);
		if (pg_num_rows($query_m21) > 0)
		{
			$sq_d1					=	"DELETE FROM estatus_planta_observaciones_reduccion_celdas
											WHERE fecha = '$fecha_carga' AND turno = '$turno_carga' AND tipo_observacion = '$tipo_variable' AND linea = '$linea'";
			$query_d1				=	mig_query($sq_d1, $db);
			while($n < $n_celdas_casco_rojo)
			{
				$sq_m1				=	"INSERT INTO estatus_planta_observaciones_reduccion_celdas (fecha, linea, turno, celda, tipo_observacion) VALUES
										('$fecha_carga', '$linea', '$turno_carga', '$arreglo_celdas_casco_rojo[$n]', '$tipo_variable');";
				$query_m1			=	mig_query($sq_m1, $db);
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
			echo "Los datos de Linea $linea de celdas derrame de alúmina se ingresaron correctamente <br>";
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
	}
?>