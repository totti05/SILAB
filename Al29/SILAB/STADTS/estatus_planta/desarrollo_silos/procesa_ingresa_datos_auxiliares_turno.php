<?php
	include '../conectarse.php';

	$db										=	conectarse_postgres();
	$fecha_carga							=	$_GET['fecha'];
	$turno_carga							=	$_GET['turno'];
	$control								=	$_GET['control'];

	$arreglo_nivel_silo_pirm_alumina_linea	=	explode(',', $_GET['arreglo_nivel_silo_pirm_alumina_linea']);
	$arreglo_nivel_silo_sec_alumina_linea	=	explode(',', $_GET['arreglo_nivel_silo_sec_alumina_linea']);
	$arreglo_nivel_silo_bano_linea			=	explode(',', $_GET['arreglo_nivel_silo_bano_linea']);

	$celda_especial[0] 						= '191';
	$celda_especial[1] 						= '391';
	$celda_especial[2] 						= '591';
	$celda_especial[3] 						= '791';
	$celda_especial[4] 						= '991';
	$celda_especial[5] 						= '1091';


	if ($control == 1)
	{
		$n										=	0;
		$tipo_variable							=	17;
		$sq_m21									=	"SELECT * FROM estatus_planta_reduccion_turno WHERE fecha = '$fecha_carga' AND turno = '$turno_carga' 
													AND (tipo_campo = '$tipo_variable' OR tipo_campo = '20')";
		$query_m21								=	mig_query($sq_m21, $db);
		if (pg_num_rows($query_m21) > 0)
		{
			$sq_d1								=	"DELETE FROM estatus_planta_reduccion_turno WHERE fecha = '$fecha_carga' AND turno = '$turno_carga' 
													AND (tipo_campo = '$tipo_variable' OR tipo_campo = '20')";
			$query_d1							=	mig_query($sq_d1, $db);
			$n2									=	1;
			while($n < 4)
			{
				if ($arreglo_nivel_silo_pirm_alumina_linea[$n] > 0)
				{
					$sq_m1						=	"INSERT INTO estatus_planta_reduccion_turno (fecha, linea, turno, tipo_campo, num_celda, valor_variable) VALUES
													('$fecha_carga', '$n2', '$turno_carga', '$tipo_variable', '$celda_especial[$n]', '$arreglo_nivel_silo_pirm_alumina_linea[$n]');";
					$query_m1					=	mig_query($sq_m1, $db);
				}
				$n++;
				$n2++;
			}
			echo "Los datos nivel de silo de alumina primario de las lineas se actualizaron correctamente <br>";
		 }
		 else
		 {
			$n2									=	1;
			while($n < 4)
			{
				if ($arreglo_nivel_silo_pirm_alumina_linea[$n] > 0)
				{
					$sq_m1					=	"INSERT INTO estatus_planta_reduccion_turno (fecha, linea, turno, tipo_campo, num_celda, valor_variable) VALUES
													('$fecha_carga', '$n2', '$turno_carga', '$tipo_variable', '$celda_especial[$n]', '$arreglo_nivel_silo_pirm_alumina_linea[$n]');";
					$query_m1					=	mig_query($sq_m1, $db);
				}
				$n++;
				$n2++;
			}
			echo "Los datos nivel de silo de alumina primario de las lineas se ingresaron correctamente <br>";
		 }
	}
/////////////////////////////////////////////////////////////////
	if ($control == 2)
	{
		$n										=	0;
		$tipo_variable							=	17;
		$sq_m21									=	"SELECT * FROM estatus_planta_reduccion_turno WHERE fecha = '$fecha_carga' AND turno = '$turno_carga' 
													AND tipo_campo = '$tipo_variable' AND linea >= '5'";
		$query_m21								=	mig_query($sq_m21, $db);
		if (pg_num_rows($query_m21) > 0)
		{
			$sq_d1								=	"DELETE FROM estatus_planta_reduccion_turno WHERE fecha = '$fecha_carga' AND turno = '$turno_carga' 
													AND tipo_campo = '$tipo_variable' AND linea >= '5'";
			$query_d1							=	mig_query($sq_d1, $db);

			$sq_m1								=	"INSERT INTO estatus_planta_reduccion_turno (fecha, linea, turno, tipo_campo, num_celda, valor_variable) VALUES
													('$fecha_carga', '5', '$turno_carga', '$tipo_variable', '$celda_especial[4]', '$arreglo_nivel_silo_pirm_alumina_linea[0]');";
			$query_m1							=	mig_query($sq_m1, $db);

			$sq_m12								=	"INSERT INTO estatus_planta_reduccion_turno (fecha, linea, turno, tipo_campo, num_celda, valor_variable) VALUES
													('$fecha_carga', '6', '$turno_carga', '$tipo_variable', '$celda_especial[5]', '$arreglo_nivel_silo_pirm_alumina_linea[1]');";
			$query_m12							=	mig_query($sq_m12, $db);
			echo "Los datos nivel de silo de alumina primario de las lineas se actualizaron correctamente <br>";
		}
		else
		{

			$sq_m1								=	"INSERT INTO estatus_planta_reduccion_turno (fecha, linea, turno, tipo_campo, num_celda, valor_variable) VALUES
													('$fecha_carga', '5', '$turno_carga', '$tipo_variable', '$celda_especial[4]', '$arreglo_nivel_silo_pirm_alumina_linea[0]');";
			$query_m1							=	mig_query($sq_m1, $db);

			$sq_m12								=	"INSERT INTO estatus_planta_reduccion_turno (fecha, linea, turno, tipo_campo, num_celda, valor_variable) VALUES
													('$fecha_carga', '6', '$turno_carga', '$tipo_variable', '$celda_especial[5]', '$arreglo_nivel_silo_pirm_alumina_linea[1]');";
			$query_m12							=	mig_query($sq_m12, $db);
			echo "Los datos nivel de silo de alumina primario de las lineas se ingresaron correctamente <br>";
		}

		$n										=	0;
		$tipo_variable							=	18;
		$sq_m21									=	"SELECT * FROM estatus_planta_reduccion_turno WHERE fecha = '$fecha_carga' AND turno = '$turno_carga' 
													AND tipo_campo = '$tipo_variable'";
		$query_m21								=	mig_query($sq_m21, $db);
		if (pg_num_rows($query_m21) > 0)
		{
			$sq_d1								=	"DELETE FROM estatus_planta_reduccion_turno WHERE fecha = '$fecha_carga' AND turno = '$turno_carga' 
													AND tipo_campo = '$tipo_variable'";
			$query_d1							=	mig_query($sq_d1, $db);
			$n2									=	1;
			while($n < 6)
			{
				if ($arreglo_nivel_silo_sec_alumina_linea[$n] > 0)
				{
					$sq_m1						=	"INSERT INTO estatus_planta_reduccion_turno (fecha, linea, turno, tipo_campo, num_celda, valor_variable) VALUES
													('$fecha_carga', '$n2', '$turno_carga', '$tipo_variable', '$celda_especial[$n]', '$arreglo_nivel_silo_sec_alumina_linea[$n]');";
					$query_m1					=	mig_query($sq_m1, $db);
				}
				$n++;
				$n2++;
			}
			echo "Los datos nivel de silo de alúmina secundario de las lineas se actualizaron correctamente <br>";
		 }
		 else
		 {
			$n2									=	1;
			while($n < 6)
			{
				if ($arreglo_nivel_silo_sec_alumina_linea[$n] > 0)
				{
					$sq_m1					=	"INSERT INTO estatus_planta_reduccion_turno (fecha, linea, turno, tipo_campo, num_celda, valor_variable) VALUES
													('$fecha_carga', '$n2', '$turno_carga', '$tipo_variable', '$celda_especial[$n]', '$arreglo_nivel_silo_sec_alumina_linea[$n]');";
					$query_m1					=	mig_query($sq_m1, $db);
				}
				$n++;
				$n2++;
			}
			echo "Los datos nivel de silo de alúmina secundario de las lineas se ingresaron correctamente <br>";
		 }
	
	/////////////////////////////////////////////////////////////////
	
		$n										=	0;
		$tipo_variable							=	19;
		$sq_m21									=	"SELECT * FROM estatus_planta_reduccion_turno WHERE fecha = '$fecha_carga' AND turno = '$turno_carga' 
													AND tipo_campo = '$tipo_variable'";
		$query_m21								=	mig_query($sq_m21, $db);
		if (pg_num_rows($query_m21) > 0)
		{
			$sq_d1								=	"DELETE FROM estatus_planta_reduccion_turno WHERE fecha = '$fecha_carga' AND turno = '$turno_carga' 
													AND tipo_campo = '$tipo_variable'";
			$query_d1							=	mig_query($sq_d1, $db);
			$n2									=	1;
			while($n < 5)
			{
				if ($arreglo_nivel_silo_bano_linea[$n] > 0)
				{
					$sq_m1						=	"INSERT INTO estatus_planta_reduccion_turno (fecha, linea, turno, tipo_campo, num_celda, valor_variable) VALUES
													('$fecha_carga', '$n2', '$turno_carga', '$tipo_variable', '$celda_especial[$n]', '$arreglo_nivel_silo_bano_linea[$n]');";
					$query_m1					=	mig_query($sq_m1, $db);
				}
				$n++;
				$n2++;
			}
			echo "Los datos nivel de silo de baño primario de las lineas se actualizaron correctamente <br>";
		 }
		 else
		 {
			$n2									=	1;
			while($n < 5)
			{
				if ($arreglo_nivel_silo_bano_linea[$n] > 0)
				{
					$sq_m1					=	"INSERT INTO estatus_planta_reduccion_turno (fecha, linea, turno, tipo_campo, num_celda, valor_variable) VALUES
													('$fecha_carga', '$n2', '$turno_carga', '$tipo_variable', '$celda_especial[$n]', '$arreglo_nivel_silo_bano_linea[$n]');";
					$query_m1					=	mig_query($sq_m1, $db);
				}
				$n++;
				$n2++;
			}
			echo "Los datos nivel de silo de baño primario de las lineas se ingresaron correctamente <br>";
		 }
	}
?>