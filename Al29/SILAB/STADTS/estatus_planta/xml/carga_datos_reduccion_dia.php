<?php

	include '../conectarse.php';

	$db					=	conectarse_postgres2();
	$fecha_carga		=	$_GET['fecha_carga'];

	$sq_m1				=	"SELECT  fecha, linea, plan_prod_neta_linea, prod_neta_linea, celdas_prod, celdas_con, celdas_inc, celdas_des 
							FROM igpp_vista_reduccion_real
							WHERE fecha = '$fecha_carga';";

	$query_m1			=	mig_query($sq_m1, $db);

	pg_close($db);

	$db2				=	conectarse_postgres();
	while ($res_m1			=	pg_fetch_array($query_m1))
	{
		$sq_m2				=	"SELECT * FROM estatus_planta_reduccion_diario WHERE fecha = '$res_m1[fecha]' AND linea = '$res_m1[linea]'";
		$query_m2			=	mig_query($sq_m2, $db2);
		
		if (pg_num_rows($query_m2) == 0)
		{
			$sq_m3			=	"INSERT INTO estatus_planta_reduccion_diario (fecha, linea, prod_neta_plan, prod_neta_real, celdas_prod, celdas_conect, celdas_inc, celdas_desinc)
								VALUES ('$res_m1[fecha]', '$res_m1[linea]', '$res_m1[plan_prod_neta_linea]', '$res_m1[prod_neta_linea]', '$res_m1[celdas_prod]', '$res_m1[celdas_con]', '$res_m1[celdas_inc]', '$res_m1[celdas_des]');";
			$query_m3		=	mig_query($sq_m3, $db2);	
			echo "Los datos diarios de Reducción de la fecha = $res_m1[fecha] linea=$res_m1[linea] se han cargado correctamente <br>";
		}
		else
		{
			$sq_m3			=	"UPDATE estatus_planta_reduccion_diario SET 
									prod_neta_plan 	= 	'$res_m1[plan_prod_neta_linea]',
									prod_neta_real 	= 	'$res_m1[prod_neta_linea]',
									celdas_prod 	= 	'$res_m1[celdas_prod]', 
									celdas_conect	=	'$res_m1[celdas_con]',
									celdas_inc		=	'$res_m1[celdas_inc]',
									celdas_desinc	=	'$res_m1[celdas_des]'
								WHERE fecha			=	'$res_m1[fecha]' AND linea = '$res_m1[linea]'";
			$query_m3		=	mig_query($sq_m3, $db2);	
			echo "Se detectaron datos de Reducción cargados previamente, se actualizaron a últimos datos de la fecha = $res_m1[fecha] linea=$res_m1[linea]. Se ha procesado correctamente la solicitud<br>";
		}
	}
	pg_close($db2);


?>