<?php
	include '../conectarse.php';

	$db								=	conectarse_postgres();
	$fecha_carga					=	$_GET['fecha'];
	$valores_inventarios			=	explode(',', $_GET['valores_inventarios']);
	$dias_consumo					=	explode(',', $_GET['dias_consumo']);
	
	
	$fechas_materias_primas			=	explode(',', $_GET['fechas_materias_primas']);
	$cant_materias_primas			=	explode(',', $_GET['cant_materias_primas']);
	$buques_materias_primas			=	explode(',', $_GET['buques_materias_primas']);
	$observ_materias_primas			=	explode(',', $_GET['observ_materias_primas']);
	
	
	
	$tm_alumina_fresca				=	$valores_inventarios[0];
	$dias_conumo_alumina_fresca		=	$dias_consumo[0];
	$tm_criolita					=	$valores_inventarios[1];
	$dias_consumo_criolita			=	$dias_consumo[1];
	$tm_floruro						=	$valores_inventarios[2];
	$dias_consumo_floruro			=	$dias_consumo[2];
	$tm_coque_met					=	$valores_inventarios[3];
	$dias_consumo_coque_met			=	$dias_consumo[3];
	$tm_coque_petroleo				=	$valores_inventarios[4];
	$dias_consumo_coque_petroleo	=	$dias_consumo[4];
	$tm_alquitran					=	$valores_inventarios[5];
	$dias_consumo_alquitran			=	$dias_consumo[5];
	$tm_arrabio						=	$valores_inventarios[6];
	$dias_consumo_arrabio			=	$dias_consumo[6];
	
	 $sq_m1							=	"SELECT * FROM estatus_planta_inventario_materiales_diario WHERE fecha = '$fecha_carga'";
	 $query_m1						=	mig_query($sq_m1, $db);
	 if (pg_num_rows($query_m1) > 0)
	 {
		$sq_m2						=	"UPDATE estatus_planta_inventario_materiales_diario SET 
											tm_alumina_fresca 				= '$tm_alumina_fresca',
											dias_conumo_alumina_fresca 		= '$dias_conumo_alumina_fresca',
											tm_criolita 					= '$tm_criolita',
											dias_consumo_criolita 			= '$dias_consumo_criolita',
											tm_floruro						= '$tm_floruro',
											dias_consumo_floruro 			= '$dias_consumo_floruro',
											tm_coque_met 					= '$tm_coque_met',
											dias_consumo_coque_met 			= '$dias_consumo_coque_met',
											tm_coque_petroleo 				= '$tm_coque_petroleo',
											dias_consumo_coque_petroleo 	= '$dias_consumo_coque_petroleo',
											tm_alquitran					= '$tm_alquitran',
											dias_consumo_alquitran 			= '$dias_consumo_alquitran',
											tm_arrabio 						= '$tm_arrabio',
											dias_consumo_arrabio 			= '$dias_consumo_arrabio'
											WHERE fecha = '$fecha_carga'";
		$query_m2					=	mig_query($sq_m2, $db);
		echo "Los datos fueron actualizados correctamente";
	}
	else
	{
		$sq_m2						=	"INSERT INTO estatus_planta_inventario_materiales_diario (fecha, tm_alumina_fresca, dias_conumo_alumina_fresca, tm_criolita, 
											dias_consumo_criolita, tm_floruro, dias_consumo_floruro, tm_coque_met, dias_consumo_coque_met, tm_coque_petroleo, 
											dias_consumo_coque_petroleo, tm_alquitran, dias_consumo_alquitran, tm_arrabio, dias_consumo_arrabio) 
										VALUES ('$fecha_carga', '$tm_alumina_fresca', '$dias_conumo_alumina_fresca', '$tm_criolita', 
											'$dias_consumo_criolita', '$tm_floruro', '$dias_consumo_floruro', '$tm_coque_met', '$dias_consumo_coque_met', '$tm_coque_petroleo',
											'$dias_consumo_coque_petroleo', '$tm_alquitran', '$dias_consumo_alquitran', '$tm_arrabio', '$dias_consumo_arrabio')";
		$query_m2					=	mig_query($sq_m2, $db);
		echo "Los datos fueron ingresados correctamente";
	}
	
	$m1								=	0;
	$m2								=	2;
	
	while($m1 <= 5)
	{
		$nombre_buque				=	utf8_decode($buques_materias_primas[$m1]);
		$observacion_buque			=	utf8_decode($observ_materias_primas[$m1]);
		if ($fechas_materias_primas[$m1] == "" || $cant_materias_primas[$m1] == "") 
		{
			$sq_m3						=	"UPDATE estatus_planta_buques_transito SET
												fecha_actualizacion		=	current_date,
												nombre_buque			=	'$nombre_buque',
												fecha_atraque			=	NULL,
												cantidad_material		=	NULL,
												observacion_registro	=	'$observacion_buque'
											WHERE tipo_material = '$m2'";
		}	
		else
		{
			$sq_m3						=	"UPDATE estatus_planta_buques_transito SET
												fecha_actualizacion		=	current_date,
												nombre_buque			=	'$nombre_buque',
												fecha_atraque			=	'$fechas_materias_primas[$m1]',
												cantidad_material		=	'$cant_materias_primas[$m1]',
												observacion_registro	=	'$observacion_buque'
											WHERE tipo_material = '$m2'";
		}
		$query_m3					=	mig_query($sq_m3, $db);
		$m1++;
		$m2++;
	}
	pg_close($db);
?>