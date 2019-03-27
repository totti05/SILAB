<?php
	include '../conectarse.php';

	$db								=	conectarse_postgres();
	$mes_carga						=	$_GET['oculto_mes_busc'];
	$anno_carga						=	$_GET['oculto_anno_busc'];
	$inventarios_1					=	$_GET['inventarios_1'];
	$inventarios_2					=	$_GET['inventarios_2'];
	$inventarios_3					=	$_GET['inventarios_3'];
	$inventarios_4					=	$_GET['inventarios_4'];
	$inventarios_5					=	$_GET['inventarios_5'];
	$inventarios_6					=	$_GET['inventarios_6'];
	$inventarios_7					=	$_GET['inventarios_7'];
	
	
	
	
	 $sq_m1							=	"SELECT * FROM estatus_planta_plan_suministros WHERE mes = '$mes_carga' AND año = '$anno_carga';";
	 $query_m1						=	mig_query($sq_m1, $db);
	 if (pg_num_rows($query_m1) > 0)
	 {
		echo $sq_m2						=	"UPDATE estatus_planta_plan_suministros SET 
											plan_alumina 				= '$inventarios_1',
											plan_criolita 				= '$inventarios_2',
											plan_floruro 				= '$inventarios_3',
											plan_coque_met 				= '$inventarios_4',
											plan_coque_pet 				= '$inventarios_5',
											plan_alquitran 				= '$inventarios_6',
											plan_arrabio 				= '$inventarios_7'
											WHERE mes = '$mes_carga' AND año = '$anno_carga';";
		$query_m2					=	mig_query($sq_m2, $db);
		echo "Los datos fueron actualizados correctamente";
	}
	else
	{
		$sq_m2						=	"INSERT INTO estatus_planta_plan_suministros (año, mes, plan_alumina, plan_criolita, plan_floruro, plan_coque_met, plan_coque_pet, plan_alquitran, plan_arrabio) 
										VALUES ('$anno_carga', '$mes_carga', '$inventarios_1', '$inventarios_2', '$inventarios_3', '$inventarios_4', '$inventarios_5', '$inventarios_6', '$inventarios_5');"; 
		$query_m2					=	mig_query($sq_m2, $db);
		echo "Los datos fueron ingresados correctamente";
	}
	
	pg_close($db);
?>