<?php
	include '../conectarse.php';

	$db							=	conectarse_postgres();
	$fecha_carga				=	$_GET['fecha'];
	$turno_carga				=	$_GET['turno'];
	$linea						=	$_GET['linea'];
	$anodos_servidos			=	$_GET['anodos_servidos'];
	$presion_aire				=	$_GET['presion_aire'];

	$arreglo_celdas_alta_temp	=	explode(',', $_GET['arreglo_celdas_alta_temp']);
	$arreglo_valor_alta_temp	=	explode(',', $_GET['arreglo_valor_alta_temp']);
	$arreglo_celdas_desv_resist	=	explode(',', $_GET['arreglo_celdas_desv_resist']);
	$arreglo_valor_desv_resist	=	explode(',', $_GET['arreglo_valor_desv_resist']);
	$arreglo_celdas_ea			=	explode(',', $_GET['arreglo_celdas_ea']);
	$arreglo_valor_ea			=	explode(',', $_GET['arreglo_valor_ea']);
	$arreglo_celdas_niv_metal	=	explode(',', $_GET['arreglo_celdas_niv_metal']);
	$arreglo_valor_niv_metal	=	explode(',', $_GET['arreglo_valor_niv_metal']);
	$arreglo_celdas_niv_baño	=	explode(',', $_GET['arreglo_celdas_niv_bano']);
	$arreglo_valor_niv_baño		=	explode(',', $_GET['arreglo_valor_niv_bano']);

	$n_celdas_alta_temp			=	count($arreglo_celdas_alta_temp);
	$n_celdas_desv_resist		=	count($arreglo_celdas_desv_resist);
	$n_celdas_celdas_ea			=	count($arreglo_celdas_ea);
	$n_celdas_niv_metal			=	count($arreglo_celdas_niv_metal);
	$n_celdas_niv_baño			=	count($arreglo_celdas_niv_baño);
	

	if ($linea == 1)				$celda_especial = '191';
	if ($linea == 2)				$celda_especial = '391';
	if ($linea == 3)				$celda_especial = '591';
	if ($linea == 4)				$celda_especial = '791';
	if ($linea == 5)				$celda_especial = '991';

	$n							=	0;
	$tipo_variable				=	1;
	$sq_m21						=	"SELECT * FROM estatus_planta_reduccion_turno WHERE fecha = '$fecha_carga' AND turno = '$turno_carga' 
									AND tipo_campo = '$tipo_variable' AND linea = '$linea'";
	$query_m21					=	mig_query($sq_m21, $db);
	if (pg_num_rows($query_m21) > 0)
	{
		$sq_d1					=	"DELETE FROM estatus_planta_reduccion_turno WHERE fecha = '$fecha_carga' AND turno = '$turno_carga' 
									AND tipo_campo = '$tipo_variable' AND linea = '$linea'";
		$query_d1				=	mig_query($sq_d1, $db);
		while($n < $n_celdas_alta_temp)
		{
			if ($arreglo_celdas_alta_temp[$n] > 0 && $arreglo_valor_alta_temp[$n] > 0)
			{
				$sq_m1				=	"INSERT INTO estatus_planta_reduccion_turno (fecha, linea, turno, tipo_campo, num_celda, valor_variable) VALUES
										('$fecha_carga', '$linea', '$turno_carga', '$tipo_variable', '$arreglo_celdas_alta_temp[$n]', '$arreglo_valor_alta_temp[$n]');";
				$query_m1			=	mig_query($sq_m1, $db);
			}
			$n++;
		}
	 	echo "Los datos de celdas con temperatura > 980º se actualizaron correctamente <br>";
	 }
	 else
	 {
		while($n < $n_celdas_alta_temp)
		{
			if ($arreglo_celdas_alta_temp[$n] > 0 && $arreglo_valor_alta_temp[$n] > 0)
			{
				$sq_m1				=	"INSERT INTO estatus_planta_reduccion_turno (fecha, linea, turno, tipo_campo, num_celda, valor_variable) VALUES
										('$fecha_carga', '$linea', '$turno_carga', '$tipo_variable', '$arreglo_celdas_alta_temp[$n]', '$arreglo_valor_alta_temp[$n]');";
				$query_m1			=	mig_query($sq_m1, $db);
			}
			$n++;
		}
	 	echo "Los datos de eldas con temperatura > 980º se ingresaron correctamente <br>";
	 }
/////////////////////////////////////////////////////////////////////////////////////////	
	$tipo_variable				=	5;
	$n							=	0;
	$sq_m21						=	"SELECT * FROM estatus_planta_reduccion_turno WHERE fecha = '$fecha_carga' AND turno = '$turno_carga' AND tipo_campo = '$tipo_variable'";
	$query_m21					=	mig_query($sq_m21, $db);
	if (pg_num_rows($query_m21) > 0)
	{
		$sq_d1					=	"DELETE FROM estatus_planta_reduccion_turno WHERE fecha = '$fecha_carga' AND turno = '$turno_carga' 
									AND tipo_campo = '$tipo_variable' AND linea = '$linea'";
		$query_d1				=	mig_query($sq_d1, $db);
		while($n < $n_celdas_desv_resist)
		{
			if ($arreglo_celdas_desv_resist[$n] > 0 && $arreglo_valor_desv_resist[$n] > 0)
			{
				$sq_m2				=	"INSERT INTO estatus_planta_reduccion_turno (fecha, linea, turno, tipo_campo, num_celda, valor_variable) VALUES
										('$fecha_carga', '$linea', '$turno_carga', '$tipo_variable', '$arreglo_celdas_desv_resist[$n]', '$arreglo_valor_desv_resist[$n]');";
			$query_m2			=	mig_query($sq_m2, $db);
			}
			$n++;
		}
	 	echo "Los datos de celdas con desv > 0.15 se actualizaron correctamente <br>";
	 }
	 else
	 {
		while($n < $n_celdas_desv_resist)
		{
			if ($arreglo_celdas_desv_resist[$n] > 0 && $arreglo_valor_desv_resist[$n] > 0)
			{
				$sq_m2				=	"INSERT INTO estatus_planta_reduccion_turno (fecha, linea, turno, tipo_campo, num_celda, valor_variable) VALUES
										('$fecha_carga', '$linea', '$turno_carga', '$tipo_variable', '$arreglo_celdas_desv_resist[$n]', '$arreglo_valor_desv_resist[$n]');";
			$query_m2			=	mig_query($sq_m2, $db);
			}
			$n++;
		}
	 	echo "Los datos de celdas con desv > 0.15 se ingresaron correctamente <br>";
	 }
/////////////////////////////////////////////////////////////////////////////////////////	
	$tipo_variable				=	2;
	$n							=	0;
	$sq_m21						=	"SELECT * FROM estatus_planta_reduccion_turno WHERE fecha = '$fecha_carga' AND turno = '$turno_carga' AND tipo_campo = '$tipo_variable'";
	$query_m21					=	mig_query($sq_m21, $db);
	if (pg_num_rows($query_m21) > 0)
	{
		$sq_d1					=	"DELETE FROM estatus_planta_reduccion_turno WHERE fecha = '$fecha_carga' AND turno = '$turno_carga' 
									AND tipo_campo = '$tipo_variable' AND linea = '$linea'";
		$query_d1				=	mig_query($sq_d1, $db);
		while($n < $n_celdas_celdas_ea)
		{
			if ($arreglo_celdas_ea[$n] > 0 && $arreglo_valor_ea[$n] > 0)
			{
				$sq_m3				=	"INSERT INTO estatus_planta_reduccion_turno (fecha, linea, turno, tipo_campo, num_celda, valor_variable) VALUES
										('$fecha_carga', '$linea', '$turno_carga', '$tipo_variable', '$arreglo_celdas_ea[$n]', '$arreglo_valor_ea[$n]');";
				$query_m3			=	mig_query($sq_m3, $db);
			}
			$n++;
		}
	 	echo "Los datos de celdas con mas de 1 EA se actualizaron correctamente <br>";
	 }
	 else
	 {
		while($n < $n_celdas_celdas_ea)
		{
			if ($arreglo_celdas_ea[$n] > 0 && $arreglo_valor_ea[$n] > 0)
			{
				$sq_m3				=	"INSERT INTO estatus_planta_reduccion_turno (fecha, linea, turno, tipo_campo, num_celda, valor_variable) VALUES
										('$fecha_carga', '$linea', '$turno_carga', '$tipo_variable', '$arreglo_celdas_ea[$n]', '$arreglo_valor_ea[$n]');";
				$query_m3			=	mig_query($sq_m3, $db);
			}
			$n++;
		}
	 	echo "Los datos de celdas con mas de 1 EA se ingresaron correctamente <br>";
	 }
/////////////////////////////////////////////////////////////////////////////////////////	
	$tipo_variable				=	3;
	$n							=	0;
	$sq_m21						=	"SELECT * FROM estatus_planta_reduccion_turno WHERE fecha = '$fecha_carga' AND turno = '$turno_carga' AND tipo_campo = '$tipo_variable'";
	$query_m21					=	mig_query($sq_m21, $db);
	if (pg_num_rows($query_m21) > 0)
	{
		$sq_d1					=	"DELETE FROM estatus_planta_reduccion_turno WHERE fecha = '$fecha_carga' AND turno = '$turno_carga' 
									AND tipo_campo = '$tipo_variable' AND linea = '$linea'";
		$query_d1				=	mig_query($sq_d1, $db);
		while($n < $n_celdas_niv_metal)
		{
			if ($arreglo_celdas_niv_metal[$n] > 0 && $arreglo_valor_niv_metal[$n] > 0)
			{
				$sq_m1				=	"INSERT INTO estatus_planta_reduccion_turno (fecha, linea, turno, tipo_campo, num_celda, valor_variable) VALUES
										('$fecha_carga', '$linea', '$turno_carga', '$tipo_variable', '$arreglo_celdas_niv_metal[$n]', '$arreglo_valor_niv_metal[$n]');";
				$query_m1			=	mig_query($sq_m1, $db);
			}
			$n++;
		}
	 	echo "Los datos de celdas con nivel de metal >= 30 O nivel de metal <= 19 se actualizaron correctamente <br>";
	 }
	 else
	 {
		while($n < $n_celdas_niv_metal)
		{
			if ($arreglo_celdas_niv_metal[$n] > 0 && $arreglo_valor_niv_metal[$n] > 0)
			{
				$sq_m1				=	"INSERT INTO estatus_planta_reduccion_turno (fecha, linea, turno, tipo_campo, num_celda, valor_variable) VALUES
										('$fecha_carga', '$linea', '$turno_carga', '$tipo_variable', '$arreglo_celdas_niv_metal[$n]', '$arreglo_valor_niv_metal[$n]');";
				$query_m1			=	mig_query($sq_m1, $db);
			}
			$n++;
		}
	 	echo "Los datos de celdas con nivel de metal >= 30 O nivel de metal <= 19 se ingresaron correctamente <br>";
	 }
/////////////////////////////////////////////////////////////////////////////////////////	
	$tipo_variable				=	4;
	$n							=	0;
	$sq_m21						=	"SELECT * FROM estatus_planta_reduccion_turno WHERE fecha = '$fecha_carga' AND turno = '$turno_carga' AND tipo_campo = '$tipo_variable'";
	$query_m21					=	mig_query($sq_m21, $db);
	if (pg_num_rows($query_m21) > 0)
	{
		$sq_d1					=	"DELETE FROM estatus_planta_reduccion_turno WHERE fecha = '$fecha_carga' AND turno = '$turno_carga' 
									AND tipo_campo = '$tipo_variable' AND linea = '$linea'";
		$query_d1				=	mig_query($sq_d1, $db);
		while($n < $n_celdas_niv_baño)
		{
			if ($arreglo_celdas_niv_baño[$n] > 0 && $arreglo_valor_niv_baño[$n] > 0)
			{
				$sq_m1				=	"INSERT INTO estatus_planta_reduccion_turno (fecha, linea, turno, tipo_campo, num_celda, valor_variable) VALUES
										('$fecha_carga', '$linea', '$turno_carga', '$tipo_variable', '$arreglo_celdas_niv_baño[$n]', '$arreglo_valor_niv_baño[$n]');";
				$query_m1			=	mig_query($sq_m1, $db);
			}
			$n++;
		}
	 	echo "Los datos de celdas con nivel de baño >= 30 O nivel de baño <= 18 se actualizaron correctamente <br>";
	 }
	 else
	 {
		while($n < $n_celdas_niv_baño)
		{
			if ($arreglo_celdas_niv_baño[$n] > 0 && $arreglo_valor_niv_baño[$n] > 0)
			{
				$sq_m1				=	"INSERT INTO estatus_planta_reduccion_turno (fecha, linea, turno, tipo_campo, num_celda, valor_variable) VALUES
										('$fecha_carga', '$linea', '$turno_carga', '$tipo_variable', '$arreglo_celdas_niv_baño[$n]', '$arreglo_valor_niv_baño[$n]');";
				$query_m1			=	mig_query($sq_m1, $db);
			}
			$n++;
		}
	 	echo "Los datos de celdas con nivel de baño >= 30 O nivel de baño <= 18 se ingresaron correctamente <br>";
	 }
/////////////////////////////////////////////////////////////////////////////////////////	
	$tipo_variable				=	7;
	$sq_m21						=	"SELECT * FROM estatus_planta_reduccion_turno WHERE fecha = '$fecha_carga' AND turno = '$turno_carga' AND tipo_campo = '$tipo_variable'";
	$query_m21					=	mig_query($sq_m21, $db);
	if (pg_num_rows($query_m21) > 0)
	{
		$sq_m6					=	"UPDATE estatus_planta_reduccion_turno SET valor_variable = '$presion_aire'
									WHERE fecha = '$fecha_carga' AND turno = '$turno_carga' AND tipo_campo = '$tipo_variable' 
									AND linea = '$linea' ";
		$query_m6				=	mig_query($sq_m6, $db);
	 	echo "Los datos de anodos suministrados a reduccion se actualizaron correctamente <br>";
	 }
	 else
	 {
		$sq_m6					=	"INSERT INTO estatus_planta_reduccion_turno (fecha, linea, turno, tipo_campo, num_celda, valor_variable) VALUES
									('$fecha_carga', '$linea', '$turno_carga', '$tipo_variable', '$celda_especial', '$anodos_servidos');";
		$query_m6				=	mig_query($sq_m6, $db);
	 	echo "Los datos de anodos suministrados a reduccion se ingresaron correctamente <br>";
	 }
/////////////////////////////////////////////////////////////////////////////////////////	
	if ($linea == 1 OR $linea == 3 OR $linea == 5)
	{
		$tipo_variable			=	6;
		$sq_m21					=	"SELECT * FROM estatus_planta_reduccion_turno WHERE fecha = '$fecha_carga' AND turno = '$turno_carga' AND tipo_campo = '$tipo_variable'";
		$query_m21				=	mig_query($sq_m21, $db);
		if (pg_num_rows($query_m21) > 0)
		{
			$sq_m7				=	"UPDATE estatus_planta_reduccion_turno SET valor_variable = '$presion_aire'
									WHERE fecha = '$fecha_carga' AND turno = '$turno_carga' AND tipo_campo = '$tipo_variable' 
									AND linea = '$linea' ";
			$query_m7			=	mig_query($sq_m7, $db);
	 		echo "Los datos presión de aire se actualizaron correctamente <br>";
		 }
		 else
		 {
			$sq_m7				=	"INSERT INTO estatus_planta_reduccion_turno (fecha, linea, turno, tipo_campo, num_celda, valor_variable) VALUES
									('$fecha_carga', '$linea', '$turno_carga', '$tipo_variable', '$celda_especial', '$presion_aire');";
			$query_m7			=	mig_query($sq_m7, $db);
	 		echo "Los datos de presión de aire se ingresaron correctamente <br>";
		 }
	}	
?>