<?php
	include '../conectarse.php';

	$db							=	conectarse_postgres();
	$fecha_carga				=	$_GET['fecha'];
	$linea						=	$_GET['linea'];
	$plan_prod_neta_linea		=	$_GET['plan_prod_neta_linea'];
	$real_prod_neta_linea		=	$_GET['real_prod_neta_linea'];
	$real_celdas_con_linea		=	$_GET['real_celdas_con_linea'];
	$real_celdas_prod_linea		=	$_GET['real_celdas_prod_linea'];
	$real_celdas_inc_linea		=	$_GET['real_celdas_inc_linea'];
	$real_celdas_desinc_linea	=	$_GET['real_celdas_desinc_linea'];
	
	 $sq_m1							=	"SELECT * FROM estatus_planta_reduccion_diario WHERE fecha = '$fecha_carga'  AND linea = '$linea'";
	 $query_m1						=	mig_query($sq_m1, $db);
	 if (pg_num_rows($query_m1) > 0)
	 {
		 $sq_m2						=	"UPDATE estatus_planta_reduccion_diario SET 
											prod_neta_plan 	= '$plan_prod_neta_linea',
											prod_neta_real 	= '$real_prod_neta_linea',
											celdas_conect 	= '$real_celdas_con_linea',
											celdas_prod 	= '$real_celdas_prod_linea',
											celdas_inc 		= '$real_celdas_inc_linea',
											celdas_desinc 	= '$real_celdas_desinc_linea'
											WHERE fecha = '$fecha_carga'  AND linea = '$linea'";
		$query_m2					=	mig_query($sq_m2, $db);
		echo "Los datos de la fecha = $fecha_carga linea=$linea fueron actualizados correctamente";
	}
	else
	{
		$sq_m2						=	"INSERT INTO estatus_planta_reduccion_diario (fecha, linea, prod_neta_plan, prod_neta_real, celdas_conect,
											celdas_prod, celdas_inc, celdas_desinc) 
										VALUES ('$fecha_carga', '$linea', '$plan_prod_neta_linea', '$real_prod_neta_linea', '$real_celdas_con_linea',
											'$real_celdas_prod_linea', '$real_celdas_inc_linea', '$real_celdas_desinc_linea')";
		$query_m2					=	mig_query($sq_m2, $db);
		echo "Los datos de la fecha = $fecha_carga linea=$linea fueron ingresados correctamente";
	}
	pg_close($db);
?>