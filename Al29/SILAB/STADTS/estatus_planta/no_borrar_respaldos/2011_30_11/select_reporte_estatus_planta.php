<?php
include 'conectarse.php';

$fecha_reporte									=	$_GET['fecha_reporte'];
$turno_reporte									=	$_GET['turno_reporte'];
$db												=	conectarse_postgres();
$n												=	1;

$sq_fechas										=	"SELECT date_part('week', '$fecha_reporte'::date) AS semana, 
													date_part('month', '$fecha_reporte'::date) AS mes, 
													date_part('year', '$fecha_reporte'::date) AS a�o,
													date_part('day', '$fecha_reporte'::date) AS dia";
$query_fechas									=	mig_query($sq_fechas, $db);
$res_fechas										=	pg_fetch_array($query_fechas);
$semana_reporte 								=	$res_fechas['semana']; 
$mes_reporte									=	$res_fechas['mes'];
$a�o_reporte									=	$res_fechas['a�o'];
$dia_reporte									=	$res_fechas['dia'];

$fecha_reporte_dia								=	$fecha_reporte;
$fecha_reduccion_dia							=	$fecha_reporte;
$reduccion_semana_reporte 						=	$semana_reporte; 
$reduccion_mes_reporte							=	$mes_reporte;
$reduccion_a�o_reporte							=	$a�o_reporte;
$reduccion_dia_reporte							=	$dia_reporte;
$titulo_tabla_reduccion_dia						=	"Datos del $fecha_reduccion_dia, turno $turno_reporte";

if ($turno_reporte < 3)
{
	$sq_mf										=	"SELECT '$fecha_reporte'::date-1  AS fecha, date_part('week', '$fecha_reporte'::date-1) AS semana, 
													date_part('month', '$fecha_reporte'::date-1) AS mes, 
													date_part('year', '$fecha_reporte'::date-1) AS a�o,
													date_part('day', '$fecha_reporte'::date-1) AS dia";
	$query_mf									=	mig_query($sq_mf, $db);
	$res_mf										=	pg_fetch_array($query_mf);
	$fecha_reduccion_dia						=	$res_mf['fecha'];
	$reduccion_semana_reporte 					=	$res_mf['semana']; 
	$reduccion_mes_reporte						=	$res_mf['mes'];
	$reduccion_a�o_reporte						=	$res_mf['a�o'];
	$reduccion_dia_reporte						=	$res_mf['dia'];
	$titulo_tabla_reduccion_dia					=	"Datos del $fecha_reduccion_dia, turno 3";
}

/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
//////////////////////////////////////////   DATOS AREA REDUCCION DIA Y TURNO ///////////////////////////////////////////////////////////////
/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
$sq_m9											=	"SELECT * FROM estatus_planta_reduccion_diario WHERE fecha = '$fecha_reduccion_dia' ORDER BY linea";
$query_m9										=	mig_query($sq_m9, $db);
while ($n <= 6)
{
	$sq_m1										=	"SELECT fecha, linea, tipo_campo, CASE WHEN count(*) > 0 THEN count(*) ELSE 0 END AS num_celdas_desv_temp 
													FROM 	(SELECT DISTINCT fecha, linea, tipo_campo, num_celda
															FROM estatus_planta_reduccion_turno WHERE fecha = '$fecha_reduccion_dia' AND tipo_campo = '1' AND linea = '$n') DERIVEDTBL
													GROUP BY fecha, linea, tipo_campo
													ORDER BY linea";
	$query_m1									=	mig_query($sq_m1, $db);
	
	$sq_m2										=	"SELECT fecha, linea, CASE WHEN count(*) > 0 THEN count(*) ELSE 0 END AS num_celdas_desv_ea 
													FROM 	(SELECT DISTINCT fecha, linea, num_celda
															FROM estatus_planta_reduccion_turno WHERE fecha = '$fecha_reduccion_dia' AND (tipo_campo = '2' OR tipo_campo = '12') AND linea = '$n') DERIVEDTBL
													GROUP BY fecha, linea
													ORDER BY linea";
	$query_m2									=	mig_query($sq_m2, $db);
	
	$sq_m3										=	"SELECT fecha, linea, tipo_campo, CASE WHEN count(*) > 0 THEN count(*) ELSE 0 END AS num_celdas_desv_niv_metal 
													FROM 	(SELECT DISTINCT fecha, linea, tipo_campo, num_celda
															FROM estatus_planta_reduccion_turno WHERE fecha = '$fecha_reduccion_dia' AND tipo_campo = '3' AND linea = '$n') DERIVEDTBL
													GROUP BY fecha, linea, tipo_campo
													ORDER BY linea";
	$query_m3									=	mig_query($sq_m3, $db);
	
	$sq_m4										=	"SELECT fecha, linea, tipo_campo, CASE WHEN count(*) > 0 THEN count(*) ELSE 0 END AS num_celdas_desv_niv_ba�o 
													FROM 	(SELECT DISTINCT fecha, linea, tipo_campo, num_celda
															FROM estatus_planta_reduccion_turno WHERE fecha = '$fecha_reduccion_dia' AND tipo_campo = '4' AND linea = '$n') DERIVEDTBL
													GROUP BY fecha, linea, tipo_campo
													ORDER BY linea";
	$query_m4									=	mig_query($sq_m4, $db);
	
	$sq_m5										=	"SELECT fecha, linea, tipo_campo, CASE WHEN count(*) > 0 THEN count(*) ELSE 0 END AS num_celdas_desv_resist 
													FROM 	(SELECT DISTINCT fecha, linea, tipo_campo, num_celda
															FROM estatus_planta_reduccion_turno WHERE fecha = '$fecha_reduccion_dia' AND tipo_campo = '5' AND linea = '$n') DERIVEDTBL
													GROUP BY fecha, linea, tipo_campo
													ORDER BY linea";
	$query_m5									=	mig_query($sq_m5, $db);

	$sq_m6										=	"SELECT fecha, linea, tipo_campo, CASE WHEN AVG(valor_variable) > 0 THEN AVG(valor_variable) ELSE 0 END AS presion_aire 
													FROM 	(SELECT DISTINCT fecha, linea, tipo_campo, num_celda, valor_variable::double precision
															FROM estatus_planta_reduccion_turno WHERE fecha = '$fecha_reduccion_dia' AND tipo_campo = '6' AND linea = '$n') DERIVEDTBL
													GROUP BY fecha, linea, tipo_campo
													ORDER BY linea";
	$query_m6									=	mig_query($sq_m6, $db);

	$sq_m7										=	"SELECT fecha, linea, tipo_campo, CASE WHEN SUM(valor_variable) > 0 THEN SUM(valor_variable) ELSE 0 END AS anodos_servidos
													FROM 	(SELECT DISTINCT fecha, linea, tipo_campo, num_celda, valor_variable
															FROM estatus_planta_reduccion_turno WHERE fecha = '$fecha_reduccion_dia' AND tipo_campo = '7' AND linea = '$n' AND TURNO = '3') DERIVEDTBL
													GROUP BY fecha, linea, tipo_campo
													ORDER BY linea;";
	$query_m7									=	mig_query($sq_m7, $db);

	$sq_m8										=	"SELECT fecha, linea, tipo_campo, CASE WHEN count(*) > 0 THEN count(*) ELSE 0 END AS num_celdas_alto_hierro
													FROM 	(SELECT DISTINCT fecha, linea, tipo_campo, num_celda
																FROM estatus_planta_reduccion_turno WHERE fecha = '$fecha_reduccion_dia' AND tipo_campo = '8' AND linea = '$n') DERIVEDTBL
														GROUP BY fecha, linea, tipo_campo
														ORDER BY linea";
	$query_m8									=	mig_query($sq_m8, $db);

	$sq_m6_2									=	"SELECT fecha, linea, tipo_campo, CASE WHEN AVG(valor_variable) > 0 THEN AVG(valor_variable) ELSE 0 END AS presion_aire_fac18 
													FROM 	(SELECT DISTINCT fecha, linea, tipo_campo, num_celda, valor_variable::double precision
															FROM estatus_planta_reduccion_turno WHERE fecha = '$fecha_reduccion_dia' AND tipo_campo = '9' AND linea = '$n') DERIVEDTBL
													GROUP BY fecha, linea, tipo_campo
													ORDER BY linea";
	$query_m6_2									=	mig_query($sq_m6_2, $db);

//////////////////////////////////////////////////////////////////////////////////////////////////
//////////////SELECT DATOS POR TURNO REDUCCION
	$sq_m10										=	"SELECT fecha, linea, tipo_campo, CASE WHEN SUM(valor_variable) > 0 THEN SUM(valor_variable) ELSE 0 END AS presion_aire 
													FROM 	(SELECT DISTINCT fecha, linea, tipo_campo, num_celda, valor_variable
															FROM estatus_planta_reduccion_turno WHERE fecha = '$fecha_reporte' AND tipo_campo = '6' AND linea = '$n' AND TURNO = '$turno_reporte') 
													DERIVEDTBL
													GROUP BY fecha, linea, tipo_campo
													ORDER BY linea;";
	$query_m10									=	mig_query($sq_m10, $db);
	
	$sq_m10_2									=	"SELECT fecha, linea, tipo_campo, CASE WHEN SUM(valor_variable) > 0 THEN SUM(valor_variable) ELSE 0 END AS presion_aire_fac18 
													FROM 	(SELECT DISTINCT fecha, linea, tipo_campo, num_celda, valor_variable
															FROM estatus_planta_reduccion_turno WHERE fecha = '$fecha_reporte' AND tipo_campo = '9' AND linea = '$n' AND TURNO = '$turno_reporte') 
													DERIVEDTBL
													GROUP BY fecha, linea, tipo_campo
													ORDER BY linea;";
	$query_m10_2								=	mig_query($sq_m10_2, $db);
	
	$sq_m11										=	"SELECT fecha, linea, tipo_campo, CASE WHEN SUM(valor_variable) > 0 THEN SUM(valor_variable) ELSE 0 END AS anodos_servidos
													FROM 	(SELECT DISTINCT fecha, linea, tipo_campo, num_celda, valor_variable
															FROM estatus_planta_reduccion_turno WHERE fecha = '$fecha_reporte' AND tipo_campo = '7' AND linea = '$n' AND TURNO = '$turno_reporte') 
													DERIVEDTBL
													GROUP BY fecha, linea, tipo_campo
													ORDER BY linea;";
	$query_m11									=	mig_query($sq_m11, $db);
	
	$sq_m12										=	"SELECT fecha, linea, tipo_campo, CASE WHEN count(*) > 0 THEN count(*) ELSE 0 END AS num_celdas_desv_ea 
													FROM 	(SELECT DISTINCT fecha, linea, tipo_campo, num_celda
															FROM estatus_planta_reduccion_turno WHERE fecha = '$fecha_reporte' AND tipo_campo = '2' AND linea = '$n' AND TURNO = '$turno_reporte') DERIVEDTBL
													GROUP BY fecha, linea, tipo_campo
													ORDER BY linea;";
	$query_m12									=	mig_query($sq_m12, $db);
	
	$sq_m13										=	"SELECT fecha, linea, tipo_campo, CASE WHEN count(*) > 0 THEN count(*) ELSE 0 END AS num_celdas_desv_resist 
													FROM 	(SELECT DISTINCT fecha, linea, tipo_campo, num_celda
															FROM estatus_planta_reduccion_turno WHERE fecha = '$fecha_reporte' AND tipo_campo = '5' AND linea = '$n' AND TURNO = '$turno_reporte') DERIVEDTBL
													GROUP BY fecha, linea, tipo_campo
													ORDER BY linea;";
	$query_m13									=	mig_query($sq_m13, $db);

	$sq_m31										=	"SELECT fecha, linea, tipo_campo, CASE WHEN count(*) > 0 THEN count(*) ELSE 0 END AS crisol_asignado_linea 
													FROM 	(SELECT fecha, linea, tipo_campo, num_celda
															FROM estatus_planta_reduccion_turno WHERE fecha = '$fecha_reporte' AND tipo_campo = '11' AND linea = '$n' AND TURNO = '$turno_reporte') DERIVEDTBL
													GROUP BY fecha, linea, tipo_campo
													ORDER BY linea;";
	$query_m31									=	mig_query($sq_m31, $db);

	$sq_m32										=	"SELECT fecha, linea, tipo_campo, CASE WHEN count(*) > 0 THEN count(*) ELSE 0 END AS falla_tolva 
													FROM 	(SELECT fecha, linea, tipo_campo, num_celda
															FROM estatus_planta_reduccion_turno WHERE fecha = '$fecha_reporte' AND tipo_campo = '13' AND linea = '$n' AND TURNO = '$turno_reporte') DERIVEDTBL
													GROUP BY fecha, linea, tipo_campo
													ORDER BY linea;";
	$query_m32									=	mig_query($sq_m32, $db);

	if (pg_num_rows($query_m1) > 0)
	{
		$res_m1									=	pg_fetch_array($query_m1);
		$reduccion_total_dia_turno[1][$n]			=	$res_m1['num_celdas_desv_temp'];
	}
	else
		$reduccion_total_dia_turno[1][$n]			=	0;

	if (pg_num_rows($query_m2) > 0)
	{
		$res_m2									=	pg_fetch_array($query_m2);
		$reduccion_total_dia_turno[2][$n]			=	$res_m2['num_celdas_desv_ea'];
	}
	else
		$reduccion_total_dia_turno[2][$n]			=	0;

	if (pg_num_rows($query_m3) > 0)
	{
		$res_m3									=	pg_fetch_array($query_m3);
		$reduccion_total_dia_turno[3][$n]			=	$res_m3['num_celdas_desv_niv_metal'];
	}
	else
		$reduccion_total_dia_turno[3][$n]			=	0;

	if (pg_num_rows($query_m4) > 0)
	{
		$res_m4									=	pg_fetch_array($query_m4);
		$reduccion_total_dia_turno[4][$n]			=	$res_m4['num_celdas_desv_niv_ba�o'];
	}
	else
		$reduccion_total_dia_turno[4][$n]			=	0;

	if (pg_num_rows($query_m5) > 0)
	{
		$res_m5									=	pg_fetch_array($query_m5);
		$reduccion_total_dia_turno[5][$n]			=	$res_m5['num_celdas_desv_resist'];
	}
	else
		$reduccion_total_dia_turno[5][$n]			=	0;

	if (pg_num_rows($query_m6) > 0)
	{
		$res_m6									=	pg_fetch_array($query_m6);
		$reduccion_total_dia_turno[6][$n]			=	$res_m6['presion_aire'];
	}
	else
		$reduccion_total_dia_turno[6][$n]			=	0;

	if (pg_num_rows($query_m7) > 0)
	{
		$res_m7									=	pg_fetch_array($query_m7);
		$reduccion_total_dia_turno[7][$n]			=	$res_m7['anodos_servidos'];
	}
	else
		$reduccion_total_dia_turno[7][$n]			=	0;

	if (pg_num_rows($query_m8) > 0)
	{
		$res_m8									=	pg_fetch_array($query_m8);
		$reduccion_total_dia_turno[8][$n]			=	$res_m8['num_celdas_alto_hierro'];
	}
	else
		$reduccion_total_dia_turno[8][$n]			=	0;

	if (pg_num_rows($query_m6_2) > 0)
	{
		$res_m6_2								=	pg_fetch_array($query_m6_2);
		$reduccion_total_dia_turno[9][$n]			=	$res_m6_2['presion_aire_fac18'];
	}
	else
		$reduccion_total_dia_turno[9][$n]			=	0;

	if (pg_num_rows($query_m10) > 0)
	{
		$res_m10								=	pg_fetch_array($query_m10);
		$reduccion_turno[1][$n]					=	$res_m10['presion_aire'];
	}
	else
		$reduccion_turno[1][$n]					=	0;

	if (pg_num_rows($query_m11) > 0)
	{
		$res_m11								=	pg_fetch_array($query_m11);
		$reduccion_turno[2][$n]					=	$res_m11['anodos_servidos'];
	}
	else
		$reduccion_turno[2][$n]					=	0;

	if (pg_num_rows($query_m12) > 0)
	{
		$res_m12								=	pg_fetch_array($query_m12);
		$reduccion_turno[3][$n]					=	$res_m12['num_celdas_desv_ea'];
	}
	else
		$reduccion_turno[3][$n]					=	0;

	if (pg_num_rows($query_m13) > 0)
	{
		$res_m13								=	pg_fetch_array($query_m13);
		$reduccion_turno[4][$n]					=	$res_m13['num_celdas_desv_resist'];
	}
	else
		$reduccion_turno[4][$n]					=	0;


	if (pg_num_rows($query_m10_2) > 0)
	{
		$res_m10_2								=	pg_fetch_array($query_m10_2);
		$reduccion_turno[5][$n]					=	$res_m10_2['presion_aire_fac18'];
	}
	else
		$reduccion_turno[5][$n]					=	0;

	if (pg_num_rows($query_m31) > 0)
	{
		$res_m31								=	pg_fetch_array($query_m31);
		$reduccion_turno[6][$n]					=	$res_m31['crisol_asignado_linea'];
	}
	else
		$reduccion_turno[6][$n]					=	0;

	if (pg_num_rows($query_m32) > 0)
	{
		$res_m32								=	pg_fetch_array($query_m32);
		$reduccion_turno[7][$n]					=	$res_m32['falla_tolva'];
	}
	else
		$reduccion_turno[7][$n]					=	0;


	$res_m9										=	pg_fetch_array($query_m9);
	$reduccion_diario[$n]['prod_neta_real']		= 	$res_m9['prod_neta_real'];
	$reduccion_diario[$n]['prod_neta_plan']		= 	$res_m9['prod_neta_plan'];
	$reduccion_diario[$n]['diff_prod']			= 	$res_m9['prod_neta_real'] - $res_m9['prod_neta_plan'];
	$reduccion_diario[$n]['celdas_prod']		= 	$res_m9['celdas_prod'];
	$reduccion_diario[$n]['celdas_conect']		= 	$res_m9['celdas_conect'];
	$reduccion_diario[$n]['celdas_inc']			= 	$res_m9['celdas_inc'];
	$reduccion_diario[$n]['celdas_desinc']		= 	$res_m9['celdas_desinc'];
	$n++;
}
/////////////////////////////////////////////////////////////ACUMULADOS SEMANALES REDUCCION////////////////////////////////////////////////////////
$sq_m14											=	"SELECT SUM(prod_neta_plan) AS prod_neta_plan, SUM(prod_neta_real) AS prod_neta_real, AVG(celdas_prod::real) AS celdas_prod,
													AVG(celdas_conect::real) AS celdas_conect, SUM(celdas_inc) AS celdas_inc, SUM(celdas_desinc) AS celdas_desinc FROM estatus_planta_reduccion_diario
													WHERE date_part('week'::text, fecha) = '$reduccion_semana_reporte' AND date_part('year'::text, fecha) = '$reduccion_a�o_reporte' AND fecha <= '$fecha_reduccion_dia'
													GROUP BY date_part('week', fecha::date), date_part('year', fecha::date)";			
$query_m14										=	mig_query($sq_m14, $db);
/////////
$sq_m1_1										=	"SELECT CASE WHEN count(*) > 0 THEN count(*) ELSE 0 END AS num_celdas_desv_temp 
													FROM 	(SELECT DISTINCT linea, tipo_campo, num_celda
															FROM estatus_planta_reduccion_turno WHERE date_part('week'::text, fecha) = '$reduccion_semana_reporte' AND date_part('year'::text, fecha) = '$reduccion_a�o_reporte' 
															AND tipo_campo = '1' AND fecha <= '$fecha_reduccion_dia') DERIVEDTBL";
$query_m1_1										=	mig_query($sq_m1_1, $db);

$sq_m1_2										=	"SELECT CASE WHEN count(*) > 0 THEN count(*) ELSE 0 END AS num_celdas_desv_ea 
													FROM 	(SELECT DISTINCT linea, tipo_campo, num_celda
															FROM estatus_planta_reduccion_turno WHERE date_part('week'::text, fecha) = '$reduccion_semana_reporte' AND date_part('year'::text, fecha) = '$reduccion_a�o_reporte' 
															AND tipo_campo = '2' AND fecha <= '$fecha_reduccion_dia') DERIVEDTBL";
$query_m1_2										=	mig_query($sq_m1_2, $db);

$sq_m1_3										=	"SELECT CASE WHEN count(*) > 0 THEN count(*) ELSE 0 END AS num_celdas_desv_niv_metal 
													FROM 	(SELECT DISTINCT linea, tipo_campo, num_celda
															FROM estatus_planta_reduccion_turno WHERE date_part('week'::text, fecha) = '$reduccion_semana_reporte' AND date_part('year'::text, fecha) = '$reduccion_a�o_reporte' 
															AND tipo_campo = '3' AND fecha <= '$fecha_reduccion_dia') DERIVEDTBL";
$query_m1_3										=	mig_query($sq_m1_3, $db);

$sq_m1_4										=	"SELECT CASE WHEN count(*) > 0 THEN count(*) ELSE 0 END AS num_celdas_desv_niv_ba�o 
													FROM 	(SELECT DISTINCT linea, tipo_campo, num_celda
															FROM estatus_planta_reduccion_turno WHERE date_part('week'::text, fecha) = '$reduccion_semana_reporte' AND date_part('year'::text, fecha) = '$reduccion_a�o_reporte' 
															AND tipo_campo = '4' AND fecha <= '$fecha_reduccion_dia') DERIVEDTBL";
$query_m1_4										=	mig_query($sq_m1_4, $db);

$sq_m1_5										=	"SELECT CASE WHEN count(*) > 0 THEN count(*) ELSE 0 END AS num_celdas_desv_resist 
													FROM 	(SELECT DISTINCT linea, tipo_campo, num_celda
															FROM estatus_planta_reduccion_turno WHERE date_part('week'::text, fecha) = '$reduccion_semana_reporte' AND date_part('year'::text, fecha) = '$reduccion_a�o_reporte' 
															AND tipo_campo = '5' AND fecha <= '$fecha_reduccion_dia') DERIVEDTBL";
$query_m1_5										=	mig_query($sq_m1_5, $db);

$sq_m1_6										=	"SELECT CASE WHEN AVG(valor_variable) > 0 THEN AVG(valor_variable) ELSE 0 END AS presion_aire 
													FROM 	(SELECT DISTINCT linea, tipo_campo, num_celda, valor_variable::double precision
															FROM estatus_planta_reduccion_turno WHERE date_part('week'::text, fecha) = '$reduccion_semana_reporte' AND date_part('year'::text, fecha) = '$reduccion_a�o_reporte' 
															AND tipo_campo = '6' AND fecha <= '$fecha_reduccion_dia') DERIVEDTBL";
$query_m1_6										=	mig_query($sq_m1_6, $db);

$sq_m1_7										=	"SELECT CASE WHEN SUM(valor_variable) > 0 THEN SUM(valor_variable) ELSE 0 END AS anodos_servidos
													FROM 	(SELECT DISTINCT linea, tipo_campo, num_celda, valor_variable
															FROM estatus_planta_reduccion_turno WHERE date_part('week'::text, fecha) = '$reduccion_semana_reporte' AND date_part('year'::text, fecha) = '$reduccion_a�o_reporte' 
															AND tipo_campo = '7' AND TURNO = '3' AND fecha <= '$fecha_reduccion_dia') DERIVEDTBL;";
$query_m1_7										=	mig_query($sq_m1_7, $db);

$sq_m1_8										=	"SELECT CASE WHEN count(*) > 0 THEN count(*) ELSE 0 END AS num_celdas_alto_hierro
													FROM 	(SELECT DISTINCT linea, tipo_campo, num_celda
																FROM estatus_planta_reduccion_turno WHERE date_part('week'::text, fecha) = '$reduccion_semana_reporte' AND date_part('year'::text, fecha) = '$reduccion_a�o_reporte' 
																AND tipo_campo = '8' AND fecha <= '$fecha_reduccion_dia') DERIVEDTBL";
$query_m1_8										=	mig_query($sq_m1_8, $db);

$sq_m1_9										=	"SELECT CASE WHEN AVG(valor_variable) > 0 THEN AVG(valor_variable) ELSE 0 END AS presion_aire_fac18 
													FROM 	(SELECT DISTINCT linea, tipo_campo, num_celda, valor_variable::double precision
															FROM estatus_planta_reduccion_turno WHERE date_part('week'::text, fecha) = '$reduccion_semana_reporte' AND date_part('year'::text, fecha) = '$reduccion_a�o_reporte' 
															AND tipo_campo = '9' AND fecha <= '$fecha_reduccion_dia') DERIVEDTBL";
$query_m1_9										=	mig_query($sq_m1_9, $db);

$res_m14										=	pg_fetch_array($query_m14);
$res_m1_1										=	pg_fetch_array($query_m1_1);
$res_m1_2										=	pg_fetch_array($query_m1_2);
$res_m1_3										=	pg_fetch_array($query_m1_3);
$res_m1_4										=	pg_fetch_array($query_m1_4);
$res_m1_5										=	pg_fetch_array($query_m1_5);
$res_m1_6										=	pg_fetch_array($query_m1_6);
$res_m1_7										=	pg_fetch_array($query_m1_7);
$res_m1_8										=	pg_fetch_array($query_m1_8);
$res_m1_9										=	pg_fetch_array($query_m1_9);

$acum_sem_reduccion[0]['prod_neta_plan']		=	$res_m14['prod_neta_plan'];
$acum_sem_reduccion[0]['prod_neta_real']		=	$res_m14['prod_neta_real'];
$acum_sem_reduccion[0]['diff_prod']				= 	$res_m14['prod_neta_real'] - $res_m14['prod_neta_plan'];
$acum_sem_reduccion[0]['celdas_prod']			=	$res_m14['celdas_prod'];
$acum_sem_reduccion[0]['celdas_inc']			=	$res_m14['celdas_inc'];
$acum_sem_reduccion[0]['celdas_conect']			=	$res_m14['celdas_conect'];
$acum_sem_reduccion[0]['celdas_desinc']			=	$res_m14['celdas_desinc'];
$acum_sem_reduccion[1]							=	$res_m1_1['num_celdas_desv_temp'];
$acum_sem_reduccion[2]							=	$res_m1_2['num_celdas_desv_ea'];
$acum_sem_reduccion[3]							=	$res_m1_3['num_celdas_desv_niv_metal'];
$acum_sem_reduccion[4]							=	$res_m1_4['num_celdas_desv_niv_ba�o'];
$acum_sem_reduccion[5]							=	$res_m1_5['num_celdas_desv_resist'];
$acum_sem_reduccion[6]							=	$res_m1_6['presion_aire'];
$acum_sem_reduccion[7]							=	$res_m1_7['anodos_servidos'];
$acum_sem_reduccion[8]							=	$res_m1_8['num_celdas_alto_hierro'];
$acum_sem_reduccion[9]							=	$res_m1_9['presion_aire_fac18'];

/////////////////////////////////////////////////////////////ACUMULADOS MENSUALES REDUCCION////////////////////////////////////////////////////////
$sq_m15											=	"SELECT SUM(prod_neta_plan) AS prod_neta_plan, SUM(prod_neta_real) AS prod_neta_real, AVG(celdas_prod::real) AS celdas_prod,
													AVG(celdas_conect::real) AS celdas_conect, SUM(celdas_inc) AS celdas_inc, SUM(celdas_desinc) AS celdas_desinc FROM estatus_planta_reduccion_diario
													WHERE date_part('month'::text, fecha) = '$reduccion_mes_reporte' AND date_part('year'::text, fecha) = '$reduccion_a�o_reporte' AND fecha <= '$fecha_reduccion_dia'
													GROUP BY date_part('month', fecha::date), date_part('year', fecha::date)";
$query_m15										=	mig_query($sq_m15, $db);
/////////
$sq_m2_1										=	"SELECT CASE WHEN count(*) > 0 THEN count(*) ELSE 0 END AS num_celdas_desv_temp 
													FROM 	(SELECT DISTINCT linea, tipo_campo, num_celda
															FROM estatus_planta_reduccion_turno WHERE date_part('month', fecha::date) = '$reduccion_mes_reporte' AND date_part('year'::text, fecha) = '$reduccion_a�o_reporte' 
															AND tipo_campo = '1' AND fecha <= '$fecha_reduccion_dia') DERIVEDTBL";
$query_m2_1										=	mig_query($sq_m2_1, $db);

$sq_m2_2										=	"SELECT CASE WHEN count(*) > 0 THEN count(*) ELSE 0 END AS num_celdas_desv_ea 
													FROM 	(SELECT DISTINCT linea, tipo_campo, num_celda
															FROM estatus_planta_reduccion_turno WHERE date_part('month', fecha::date) = '$reduccion_mes_reporte' AND date_part('year'::text, fecha) = '$reduccion_a�o_reporte' 
															AND tipo_campo = '2' AND fecha <= '$fecha_reduccion_dia') DERIVEDTBL";
$query_m2_2										=	mig_query($sq_m2_2, $db);

$sq_m2_3										=	"SELECT CASE WHEN count(*) > 0 THEN count(*) ELSE 0 END AS num_celdas_desv_niv_metal 
													FROM 	(SELECT DISTINCT  linea, tipo_campo, num_celda
															FROM estatus_planta_reduccion_turno WHERE date_part('month', fecha::date) = '$reduccion_mes_reporte' AND date_part('year'::text, fecha) = '$reduccion_a�o_reporte' 
															AND tipo_campo = '3' AND fecha <= '$fecha_reduccion_dia') DERIVEDTBL";
$query_m2_3										=	mig_query($sq_m2_3, $db);

$sq_m2_4										=	"SELECT CASE WHEN count(*) > 0 THEN count(*) ELSE 0 END AS num_celdas_desv_niv_ba�o 
													FROM 	(SELECT DISTINCT linea, tipo_campo, num_celda
															FROM estatus_planta_reduccion_turno WHERE date_part('month', fecha::date) = '$reduccion_mes_reporte' AND date_part('year'::text, fecha) = '$reduccion_a�o_reporte' 
															AND tipo_campo = '4' AND fecha <= '$fecha_reduccion_dia') DERIVEDTBL";
$query_m2_4										=	mig_query($sq_m2_4, $db);

$sq_m2_5										=	"SELECT CASE WHEN count(*) > 0 THEN count(*) ELSE 0 END AS num_celdas_desv_resist 
													FROM 	(SELECT DISTINCT linea, tipo_campo, num_celda
															FROM estatus_planta_reduccion_turno WHERE date_part('month', fecha::date) = '$reduccion_mes_reporte' AND date_part('year'::text, fecha) = '$reduccion_a�o_reporte' 
															AND tipo_campo = '5' AND fecha <= '$fecha_reduccion_dia') DERIVEDTBL";
$query_m2_5										=	mig_query($sq_m2_5, $db);

$sq_m2_6										=	"SELECT CASE WHEN AVG(valor_variable) > 0 THEN AVG(valor_variable) ELSE 0 END AS presion_aire 
													FROM 	(SELECT DISTINCT linea, tipo_campo, num_celda, valor_variable::double precision
															FROM estatus_planta_reduccion_turno WHERE date_part('month', fecha::date) = '$reduccion_mes_reporte' AND date_part('year'::text, fecha) = '$reduccion_a�o_reporte' 
															AND tipo_campo = '6' AND fecha <= '$fecha_reduccion_dia') DERIVEDTBL";
$query_m2_6										=	mig_query($sq_m2_6, $db);

$sq_m2_7										=	"SELECT CASE WHEN SUM(valor_variable) > 0 THEN SUM(valor_variable) ELSE 0 END AS anodos_servidos
													FROM 	(SELECT DISTINCT linea, tipo_campo, num_celda, valor_variable
															FROM estatus_planta_reduccion_turno WHERE date_part('month', fecha::date) = '$reduccion_mes_reporte' AND date_part('year'::text, fecha) = '$reduccion_a�o_reporte' 
															AND tipo_campo = '7' AND TURNO = '3' AND fecha <= '$fecha_reduccion_dia') DERIVEDTBL;";
$query_m2_7										=	mig_query($sq_m2_7, $db);

$sq_m2_8										=	"SELECT CASE WHEN count(*) > 0 THEN count(*) ELSE 0 END AS num_celdas_alto_hierro
													FROM 	(SELECT DISTINCT linea, tipo_campo, num_celda
																FROM estatus_planta_reduccion_turno WHERE date_part('month', fecha::date) = '$reduccion_mes_reporte' AND date_part('year'::text, fecha) = '$reduccion_a�o_reporte' 
																AND tipo_campo = '8' AND fecha <= '$fecha_reduccion_dia') DERIVEDTBL";
$query_m2_8										=	mig_query($sq_m2_8, $db);

$sq_m2_9										=	"SELECT CASE WHEN AVG(valor_variable) > 0 THEN AVG(valor_variable) ELSE 0 END AS presion_aire_fac18 
													FROM 	(SELECT DISTINCT linea, tipo_campo, num_celda, valor_variable::double precision
															FROM estatus_planta_reduccion_turno WHERE date_part('month', fecha::date) = '$reduccion_mes_reporte' AND date_part('year'::text, fecha) = '$reduccion_a�o_reporte' 
															AND tipo_campo = '9' AND fecha <= '$fecha_reduccion_dia') DERIVEDTBL";
$query_m2_9										=	mig_query($sq_m2_9, $db);

$res_m15										=	pg_fetch_array($query_m15);
$res_m2_1										=	pg_fetch_array($query_m2_1);
$res_m2_2										=	pg_fetch_array($query_m2_2);
$res_m2_3										=	pg_fetch_array($query_m2_3);
$res_m2_4										=	pg_fetch_array($query_m2_4);
$res_m2_5										=	pg_fetch_array($query_m2_5);
$res_m2_6										=	pg_fetch_array($query_m2_6);
$res_m2_7										=	pg_fetch_array($query_m2_7);
$res_m2_8										=	pg_fetch_array($query_m2_8);
$res_m2_9										=	pg_fetch_array($query_m2_9);

$acum_mes_reduccion[0]['prod_neta_plan']		=	$res_m15['prod_neta_plan'];
$acum_mes_reduccion[0]['prod_neta_real']		=	$res_m15['prod_neta_real'];
$acum_mes_reduccion[0]['diff_prod']				= 	$res_m15['prod_neta_real'] - $res_m15['prod_neta_plan'];
$acum_mes_reduccion[0]['celdas_prod']			=	$res_m15['celdas_prod'];
$acum_mes_reduccion[0]['celdas_inc']			=	$res_m15['celdas_inc'];
$acum_mes_reduccion[0]['celdas_conect']			=	$res_m15['celdas_conect'];
$acum_mes_reduccion[0]['celdas_desinc']			=	$res_m15['celdas_desinc'];
$acum_mes_reduccion[1]							=	$res_m2_1['num_celdas_desv_temp'];
$acum_mes_reduccion[2]							=	$res_m2_2['num_celdas_desv_ea'];
$acum_mes_reduccion[3]							=	$res_m2_3['num_celdas_desv_niv_metal'];
$acum_mes_reduccion[4]							=	$res_m2_4['num_celdas_desv_niv_ba�o'];
$acum_mes_reduccion[5]							=	$res_m2_5['num_celdas_desv_resist'];
$acum_mes_reduccion[6]							=	$res_m2_6['presion_aire'];
$acum_mes_reduccion[7]							=	$res_m2_7['anodos_servidos'];
$acum_mes_reduccion[8]							=	$res_m2_8['num_celdas_alto_hierro'];
$acum_mes_reduccion[9]							=	$res_m2_9['presion_aire_fac18'];

/////////////////////////////////////////////////////////////ACUMULADOS DIARIO REDUCCION////////////////////////////////////////////////////////
$sq_m16											=	"SELECT SUM(prod_neta_plan) AS prod_neta_plan, SUM(prod_neta_real) AS prod_neta_real, SUM(celdas_prod::real) AS celdas_prod,
													SUM(celdas_conect::real) AS celdas_conect, SUM(celdas_inc) AS celdas_inc, SUM(celdas_desinc) AS celdas_desinc FROM estatus_planta_reduccion_diario
													WHERE  fecha = '$fecha_reduccion_dia'
													GROUP BY fecha";			
$query_m16										=	mig_query($sq_m16, $db);
/////////
$sq_m3_1										=	"SELECT CASE WHEN count(*) > 0 THEN count(*) ELSE 0 END AS num_celdas_desv_temp 
													FROM 	(SELECT DISTINCT fecha, linea, tipo_campo, num_celda
															FROM estatus_planta_reduccion_turno WHERE fecha = '$fecha_reduccion_dia' 
															AND tipo_campo = '1') DERIVEDTBL";
$query_m3_1										=	mig_query($sq_m3_1, $db);

$sq_m3_2										=	"SELECT CASE WHEN count(*) > 0 THEN count(*) ELSE 0 END AS num_celdas_desv_ea 
													FROM 	(SELECT DISTINCT fecha, linea, tipo_campo, num_celda
															FROM estatus_planta_reduccion_turno WHERE fecha = '$fecha_reduccion_dia' 
															AND tipo_campo = '2') DERIVEDTBL";
$query_m3_2										=	mig_query($sq_m3_2, $db);

$sq_m3_3										=	"SELECT CASE WHEN count(*) > 0 THEN count(*) ELSE 0 END AS num_celdas_desv_niv_metal 
													FROM 	(SELECT DISTINCT fecha, linea, tipo_campo, num_celda
															FROM estatus_planta_reduccion_turno WHERE fecha = '$fecha_reduccion_dia' 
															AND tipo_campo = '3') DERIVEDTBL";
$query_m3_3										=	mig_query($sq_m3_3, $db);

$sq_m3_4										=	"SELECT CASE WHEN count(*) > 0 THEN count(*) ELSE 0 END AS num_celdas_desv_niv_ba�o 
													FROM 	(SELECT DISTINCT fecha, linea, tipo_campo, num_celda
															FROM estatus_planta_reduccion_turno WHERE fecha = '$fecha_reduccion_dia' 
															AND tipo_campo = '4') DERIVEDTBL";
$query_m3_4										=	mig_query($sq_m3_4, $db);

$sq_m3_5										=	"SELECT CASE WHEN count(*) > 0 THEN count(*) ELSE 0 END AS num_celdas_desv_resist 
													FROM 	(SELECT DISTINCT fecha, linea, tipo_campo, num_celda
															FROM estatus_planta_reduccion_turno WHERE fecha = '$fecha_reduccion_dia' 
															AND tipo_campo = '5') DERIVEDTBL";
$query_m3_5										=	mig_query($sq_m3_5, $db);

$sq_m3_6										=	"SELECT CASE WHEN AVG(valor_variable) > 0 THEN AVG(valor_variable) ELSE 0 END AS presion_aire 
													FROM 	(SELECT DISTINCT fecha, linea, tipo_campo, num_celda, valor_variable::double precision
															FROM estatus_planta_reduccion_turno WHERE fecha = '$fecha_reduccion_dia' 
															AND tipo_campo = '6') DERIVEDTBL";
$query_m3_6										=	mig_query($sq_m3_6, $db);

$sq_m3_7										=	"SELECT CASE WHEN SUM(valor_variable) > 0 THEN SUM(valor_variable) ELSE 0 END AS anodos_servidos
													FROM 	(SELECT DISTINCT fecha, linea, tipo_campo, num_celda, valor_variable
															FROM estatus_planta_reduccion_turno WHERE fecha = '$fecha_reduccion_dia' 
															AND tipo_campo = '7' AND TURNO = '3') DERIVEDTBL;";
$query_m3_7										=	mig_query($sq_m3_7, $db);

$sq_m3_8										=	"SELECT CASE WHEN count(*) > 0 THEN count(*) ELSE 0 END AS num_celdas_alto_hierro
													FROM 	(SELECT DISTINCT fecha, linea, tipo_campo, num_celda
																FROM estatus_planta_reduccion_turno WHERE fecha = '$fecha_reduccion_dia' 
																AND tipo_campo = '8') DERIVEDTBL";
$query_m3_8										=	mig_query($sq_m3_8, $db);

$sq_m3_9										=	"SELECT CASE WHEN AVG(valor_variable) > 0 THEN AVG(valor_variable) ELSE 0 END AS presion_aire_fac18 
													FROM 	(SELECT DISTINCT fecha, linea, tipo_campo, num_celda, valor_variable::double precision
															FROM estatus_planta_reduccion_turno WHERE fecha = '$fecha_reduccion_dia' 
															AND tipo_campo = '9') DERIVEDTBL";
$query_m3_9										=	mig_query($sq_m3_9, $db);

$res_m16										=	pg_fetch_array($query_m16);
$res_m3_1										=	pg_fetch_array($query_m3_1);
$res_m3_2										=	pg_fetch_array($query_m3_2);
$res_m3_3										=	pg_fetch_array($query_m3_3);
$res_m3_4										=	pg_fetch_array($query_m3_4);
$res_m3_5										=	pg_fetch_array($query_m3_5);
$res_m3_6										=	pg_fetch_array($query_m3_6);
$res_m3_7										=	pg_fetch_array($query_m3_7);
$res_m3_8										=	pg_fetch_array($query_m3_8);
$res_m3_9										=	pg_fetch_array($query_m3_9);

$acum_dia_reduccion[0]['prod_neta_plan']		=	$res_m16['prod_neta_plan'];
$acum_dia_reduccion[0]['prod_neta_real']		=	$res_m16['prod_neta_real'];
$acum_dia_reduccion[0]['diff_prod']				= 	$res_m16['prod_neta_real'] - $res_m16['prod_neta_plan'];
$acum_dia_reduccion[0]['celdas_prod']			=	$res_m16['celdas_prod'];
$acum_dia_reduccion[0]['celdas_inc']			=	$res_m16['celdas_inc'];
$acum_dia_reduccion[0]['celdas_conect']			=	$res_m16['celdas_conect'];
$acum_dia_reduccion[0]['celdas_desinc']			=	$res_m16['celdas_desinc'];
$acum_dia_reduccion[1]							=	$res_m3_1['num_celdas_desv_temp'];
$acum_dia_reduccion[2]							=	$res_m3_2['num_celdas_desv_ea'];
$acum_dia_reduccion[3]							=	$res_m3_3['num_celdas_desv_niv_metal'];
$acum_dia_reduccion[4]							=	$res_m3_4['num_celdas_desv_niv_ba�o'];
$acum_dia_reduccion[5]							=	$res_m3_5['num_celdas_desv_resist'];
$acum_dia_reduccion[6]							=	$res_m3_6['presion_aire'];
$acum_dia_reduccion[7]							=	$res_m3_7['anodos_servidos'];
$acum_dia_reduccion[8]							=	$res_m3_8['num_celdas_alto_hierro'];
$acum_dia_reduccion[9]							=	$res_m3_9['presion_aire_fac18'];

/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
//////////////////////////////////////////   DATOS AREA CARBON DIA Y TURNO ///////////////////////////////////////////////////////////////
/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
$sq_m17											=	"SELECT * FROM estatus_planta_carbon_diario WHERE fecha = '$fecha_reduccion_dia'";
$query_m17										=	mig_query($sq_m17, $db);
$carbon_diario									=	pg_fetch_array($query_m17);

$sq_m18											=	"SELECT * FROM estatus_planta_carbon_turno WHERE fecha = '$fecha_reporte' AND turno = '$turno_reporte'";
$query_m18										=	mig_query($sq_m18, $db);
$carbon_turno									=	pg_fetch_array($query_m18);

$sq_m17_2										=	"SELECT SUM(produc_anodo_verde) AS produc_anodo_verde, SUM(produc_anodo_cocido) AS produc_anodo_cocido,
													SUM(produc_anodo_envarillado) AS produc_anodo_envarillado FROM estatus_planta_carbon_turno 
													WHERE fecha = '$fecha_reporte_dia' AND turno <= '$turno_reporte'";
$query_m17_2									=	mig_query($sq_m17_2, $db);
$carbon_diario_2								=	pg_fetch_array($query_m17_2);

/////////////////////////////////////////////////////////////ACUMULADOS SEMANALES CARB�N////////////////////////////////////////////////////////
$sq_m19											=	"SELECT SUM(produc_anodo_verde) AS produc_anodo_verde, SUM(produc_anodo_cocido) AS produc_anodo_cocido, 
													SUM(produc_anodo_envarillado) AS produc_anodo_envarillado FROM estatus_planta_carbon_diario 
													WHERE date_part('week'::text, fecha) = '$reduccion_semana_reporte' AND date_part('year'::text, fecha) = '$reduccion_a�o_reporte'
													GROUP BY date_part('week', fecha::date), date_part('year', fecha::date)";
$query_m19										=	mig_query($sq_m19, $db);
$acum_sem_carbon								=	pg_fetch_array($query_m19);

/////////////////////////////////////////////////////////////ACUMULADOS MENSUALES CARB�N////////////////////////////////////////////////////////
$sq_m20											=	"SELECT SUM(produc_anodo_verde) AS produc_anodo_verde, SUM(produc_anodo_cocido) AS produc_anodo_cocido, 
													SUM(produc_anodo_envarillado) AS produc_anodo_envarillado FROM estatus_planta_carbon_diario 
													WHERE date_part('month'::text, fecha) = '$reduccion_mes_reporte' AND date_part('year'::text, fecha) = '$reduccion_a�o_reporte'
													GROUP BY date_part('month', fecha::date), date_part('year', fecha::date)";
$query_m20										=	mig_query($sq_m20, $db);
$acum_mes_carbon								=	pg_fetch_array($query_m20);

/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
//////////////////////////////////////////   DATOS AREA COLADA DIA Y TURNO ///////////////////////////////////////////////////////////////
/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
$sq_m21											=	"SELECT SUM(num_crisoles_recibidos) AS num_crisoles_recibidos, SUM(num_crisoles_procesados) AS num_crisoles_procesados, 
													AVG(temperatura_crisoles_recibidos) AS temperatura_crisoles_recibidos 
													FROM estatus_planta_colada_turno WHERE fecha = '$fecha_reporte_dia' AND turno <= '$turno_reporte';";
$query_m21										=	mig_query($sq_m21, $db);
$colada_diario									=	pg_fetch_array($query_m21);

$sq_m22											=	"SELECT SUM(num_crisoles_recibidos) AS num_crisoles_recibidos, SUM(num_crisoles_procesados) AS num_crisoles_procesados, 
													AVG(temperatura_crisoles_recibidos) AS temperatura_crisoles_recibidos 
													FROM estatus_planta_colada_turno WHERE fecha = '$fecha_reporte_dia' AND turno = '$turno_reporte';";
$query_m22										=	mig_query($sq_m22, $db);
$colada_turno									=	pg_fetch_array($query_m22);

/////////////////////////////////////////////////////////////ACUMULADOS SEMANALES COLADA////////////////////////////////////////////////////////
$sq_m23											=	"SELECT SUM(num_crisoles_recibidos) AS num_crisoles_recibidos, SUM(num_crisoles_procesados) AS num_crisoles_procesados, 
													AVG(temperatura_crisoles_recibidos) AS temperatura_crisoles_recibidos 
													FROM estatus_planta_colada_turno 
													WHERE date_part('week'::text, fecha) = '$reduccion_semana_reporte' AND date_part('year'::text, fecha) = '$reduccion_a�o_reporte'
													AND fecha <= '$fecha_reduccion_dia'
													GROUP BY date_part('week', fecha::date), date_part('year', fecha::date)";
$query_m23										=	mig_query($sq_m23, $db);
$acum_sem_colada								=	pg_fetch_array($query_m23);

/////////////////////////////////////////////////////////////ACUMULADOS MENSUALES COLADA////////////////////////////////////////////////////////
$sq_m24											=	"SELECT SUM(num_crisoles_recibidos) AS num_crisoles_recibidos, SUM(num_crisoles_procesados) AS num_crisoles_procesados, 
													AVG(temperatura_crisoles_recibidos) AS temperatura_crisoles_recibidos 
													FROM estatus_planta_colada_turno  
													WHERE date_part('month'::text, fecha) = '$reduccion_mes_reporte' AND date_part('year'::text, fecha) = '$reduccion_a�o_reporte'
													AND fecha <= '$fecha_reduccion_dia'
													GROUP BY date_part('month', fecha::date), date_part('year', fecha::date)";
$query_m24										=	mig_query($sq_m24, $db);
$acum_mes_colada								=	pg_fetch_array($query_m24);

/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
//////////////////////////////////////////   DATOS EQUIPO MOVIL DE PLANTA TURNO ///////////////////////////////////////////////////////////////
/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
$n												=	1;
while($n <= 11)
{
	$sq_m25										=	"SELECT CASE WHEN SUM(cantidad_estandar) > 0 THEN SUM(cantidad_estandar) ELSE 0 END AS cantidad_estandar, 
													CASE WHEN SUM(cantidad_operativo) > 0 THEN SUM(cantidad_operativo) ELSE 0 END AS cantidad_operativo, tipo_equipo_movil 
													FROM estaus_planta_equipo_movil WHERE fecha = '$fecha_reporte_dia' AND turno = '$turno_reporte' 
													AND tipo_equipo_movil = '$n' GROUP BY tipo_equipo_movil;";
	$query_m25									=	mig_query($sq_m25, $db);
	$sq_m25_2									=	"SELECT CASE WHEN SUM(cantidad_estandar) > 0 THEN SUM(cantidad_estandar) ELSE 0 END AS cantidad_estandar 
													 FROM estatus_planta_diccionario_estandar_equipo_movil_area WHERE id_equipo_movil = '$n';";
	$query_m25_2								=	mig_query($sq_m25_2, $db);
	$res_m25_2									=	pg_fetch_array($query_m25_2);
	if (pg_num_rows($query_m25) > 0)
	{
		$res_m25								=	pg_fetch_array($query_m25);
		$equipo_movil_turno[$n]['estandar']		=	$res_m25_2['cantidad_estandar'];
		$equipo_movil_turno[$n]['operativo']	=	$res_m25['cantidad_operativo'];
	}	
	else
	{
		$equipo_movil_turno[$n]['estandar']		=	$res_m25_2['cantidad_estandar'];
		$equipo_movil_turno[$n]['operativo']	=	0;
	}
	$n++;
}

/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
//////////////////////////////////////////   DATOS MATERIAS PRIMAS DE PLANTA DIA/////////////////////////////////////////////////////////////
/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
$n												=	1;
$sq_m26										=	"SELECT * FROM estatus_planta_inventario_materiales_diario WHERE fecha = '$fecha_reporte';";
$query_m26									=	mig_query($sq_m26, $db);	
if (pg_num_rows($query_m26) > 0)
{
	$res_m26								=	pg_fetch_array($query_m26);
	if ($res_m26['tm_alumina_fresca'] > 0)				$materias_primas[1]		=	$res_m26['tm_alumina_fresca'];				else	$materias_primas[1]		=	0;
	if ($res_m26['tm_criolita'] > 0)					$materias_primas[2]		=	$res_m26['tm_criolita'];					else	$materias_primas[2]		=	0;
	if ($res_m26['tm_floruro'] > 0)						$materias_primas[3]		=	$res_m26['tm_floruro'];						else	$materias_primas[3]		=	0;
	if ($res_m26['tm_coque_met'] > 0)					$materias_primas[4]		=	$res_m26['tm_coque_met'];					else	$materias_primas[4]		=	0;
	if ($res_m26['tm_coque_petroleo'] > 0)				$materias_primas[5]		=	$res_m26['tm_coque_petroleo'];				else	$materias_primas[5]		=	0;
	if ($res_m26['tm_alquitran'] > 0)					$materias_primas[6]		=	$res_m26['tm_alquitran'];					else	$materias_primas[6]		=	0;
	if ($res_m26['tm_arrabio'] > 0)						$materias_primas[7]		=	$res_m26['tm_arrabio'];						else	$materias_primas[7]		=	0;

	if ($res_m26['dias_conumo_alumina_fresca'] > 0)		$dias_consumo[1]		=	$res_m26['dias_conumo_alumina_fresca'];		else	$dias_consumo[1]		=	0;
	if ($res_m26['dias_consumo_criolita'] > 0)			$dias_consumo[2]		=	$res_m26['dias_consumo_criolita'];			else	$dias_consumo[2]		=	0;
	if ($res_m26['dias_consumo_floruro'] > 0)			$dias_consumo[3]		=	$res_m26['dias_consumo_floruro'];			else	$dias_consumo[3]		=	0;
	if ($res_m26['dias_consumo_coque_met'] > 0)			$dias_consumo[4]		=	$res_m26['dias_consumo_coque_met'];			else	$dias_consumo[4]		=	0;
	if ($res_m26['dias_consumo_coque_petroleo'] > 0)	$dias_consumo[5]		=	$res_m26['dias_consumo_coque_petroleo'];	else	$dias_consumo[5]		=	0;
	if ($res_m26['dias_consumo_alquitran'] > 0)			$dias_consumo[6]		=	$res_m26['dias_consumo_alquitran'];			else	$dias_consumo[6]		=	0;
	if ($res_m26['dias_consumo_arrabio'] > 0)			$dias_consumo[7]		=	$res_m26['dias_consumo_arrabio'];			else	$dias_consumo[7]		=	0;
}	
else
{
	$materias_primas[1]		=	0;
	$materias_primas[2]		=	0;
	$materias_primas[3]		=	0;
	$materias_primas[4]		=	0;
	$materias_primas[5]		=	0;
	$materias_primas[6]		=	0;
	$materias_primas[7]		=	0;

	$dias_consumo[1]		=	0;
	$dias_consumo[2]		=	0;
	$dias_consumo[3]		=	0;
	$dias_consumo[4]		=	0;
	$dias_consumo[5]		=	0;
	$dias_consumo[6]		=	0;
	$dias_consumo[7]		=	0;
}
///////////////////////////////////////////////////////////////////////////////////////////////////////////////////
///////////////////////////////DATOS DE MATERIAL RECEPCIONADO EN MUELLE////////////////////////////////////////////
///////////////////////////////////////////////////////////////////////////////////////////////////////////////////

$sq_recep_1					=	"SELECT * FROM estatus_planta_recep_desp_materiales WHERE fecha = '$fecha_reporte' AND tipo_movimiento = '1';";
$query_recep_1				=	mig_query($sq_recep_1, $db);
$res_recep_1				= 	pg_fetch_array($query_recep_1);

if ($res_recep_1['tipo_material']	==	1) $desc_material	=	"COQUE METALURGICO";
if ($res_recep_1['tipo_material']	==	2) $desc_material	=	"COQUE PETROLEO CALCINADO";
if ($res_recep_1['tipo_material']	==	3) $desc_material	=	"BREA DE ALQUITRAN";

$mat_recep['tipo_material']			=	$desc_material;
$mat_recep['cantidad_material_dia']	=	$res_recep_1['cantidad_material_dia'];
$mat_recep['nombre_buque']			=	$res_recep_1['nombre_buque'];
$mat_recep['fecha_atraque']			=	$res_recep_1['fecha_atraque'];
$mat_recep['total_material_buque']	=	$res_recep_1['total_material_buque'];
$mat_recep['acum_buque_dia']		=	$res_recep_1['acum_buque_dia'];
if (($res_recep_1['total_material_buque'] - $res_recep_1['acum_buque_dia']) > 0) 
	$mat_recep['faltante_descargar']	=	round($res_recep_1['total_material_buque'] - $res_recep_1['acum_buque_dia'], 2);
else 
	$mat_recep['faltante_descargar']	=	0;
///////////////////////////////////////////////////////////////////////////////////////////////////////////////////
////////////////////OBSERVACIONES DEL REPORTE/////////////////////////////////////////////////
///////////////////////////////////////////////////////////////////////////////////////////////////////////////////

$sq_observ_1				=	"SELECT celda FROM estatus_planta_observaciones_reduccion_celdas WHERE fecha = '$fecha_reporte' AND turno = '$turno_reporte'
								AND tipo_observacion = '1' ORDER BY celda";
$query_observ_1				=	mig_query($sq_observ_1, $db);
if (pg_num_rows($query_observ_1) > 0)
{
	while ($res_observ_1		=	pg_fetch_array($query_observ_1))
	{
		if ($cadena_observ_1 == "") $cadena_observ_1 = $res_observ_1['celda'];
		else $cadena_observ_1 		=	$cadena_observ_1.",".$res_observ_1['celda'];
	}
}
else	$cadena_observ_1	=	"&nbsp;";
$sq_observ_2				=	"SELECT celda FROM estatus_planta_observaciones_reduccion_celdas WHERE fecha = '$fecha_reporte' AND turno = '$turno_reporte'
								AND tipo_observacion = '2' ORDER BY celda";
$query_observ_2				=	mig_query($sq_observ_2, $db);
if (pg_num_rows($query_observ_2) > 0)
{
	while ($res_observ_2		=	pg_fetch_array($query_observ_2))
	{
		if ($cadena_observ_2 == "") $cadena_observ_2 = $res_observ_2['celda'];
		else $cadena_observ_2 		=	$cadena_observ_2.",".$res_observ_2['celda'];
	}
}
else	$cadena_observ_2	=	"&nbsp;";
$sq_observ_3				=	"SELECT celda FROM estatus_planta_observaciones_reduccion_celdas WHERE fecha = '$fecha_reporte' AND turno = '$turno_reporte'
								AND tipo_observacion = '3' ORDER BY celda";
$query_observ_3				=	mig_query($sq_observ_3, $db);
if (pg_num_rows($query_observ_3) > 0)
{
	while ($res_observ_3		=	pg_fetch_array($query_observ_3))
	{
		if ($cadena_observ_3 == "") $cadena_observ_3 = $res_observ_3['celda'];
		else $cadena_observ_3 		=	$cadena_observ_3.",".$res_observ_3['celda'];
	}
}
else	$cadena_observ_3	=	"&nbsp;";
////////////////////////////////////////////////
///FALTA TERMINAR ----- CELDAS CON TOLVAS BLOQUEADAS.
////////////////////////////////////////////////
$n1							=	1;
while ($n1 <= 5)
{
	$sq_observ_4[$n1]		=	"SELECT COUNT(*) AS num_celdas_tolv_bloq, linea  FROM estatus_planta_observaciones_reduccion_celdas
								WHERE fecha = '$fecha_reporte' AND turno = '$turno_reporte' AND tipo_observacion = '4' AND linea = '$n1'
								GROUP BY linea ORDER BY linea;";
	$query_observ_4[$n1]	=	mig_query($sq_observ_4[$n1], $db);
	
	if (pg_num_rows($query_observ_4[$n1]) > 0)
		$res_observ_4[$n1]		=	pg_fetch_array($query_observ_4[$n1]);
	else
		$res_observ_4[$n1]['num_celdas_tolv_bloq']		=	0;

	$sq_observ_5[$n1]		=	"SELECT COUNT(*) AS num_celdas_tolv_bloq, linea FROM 
									(SELECT * FROM 
									estatus_planta_observaciones_reduccion_celdas WHERE fecha = '$fecha_reduccion_dia' AND tipo_observacion = '4' AND linea = '$n1'
								) DERIVEDTBL GROUP BY linea ORDER BY linea;";
	$query_observ_5[$n1]	=	mig_query($sq_observ_5[$n1], $db);
	
	if (pg_num_rows($query_observ_5[$n1]) > 0)
		$res_observ_5[$n1]		=	pg_fetch_array($query_observ_5[$n1]);
	else
		$res_observ_5[$n1]['num_celdas_tolv_bloq']		=	0;
	$n1++;


}
///////////////////////////////////////////////////////////////////////////////////////////////////////////////////
////////////////////CELDAS CASCO ROJO, DERRAME Al, DERRAME Fl/////////////////////////////////////////////////
///////////////////////////////////////////////////////////////////////////////////////////////////////////////////
$n2							=	1;
while ($n2 <= 5)
{

	$sq_observ_1				=	"SELECT COUNT(*) AS total_casco_rojo FROM estatus_planta_observaciones_reduccion_celdas WHERE fecha = '$fecha_reporte' AND turno = '$turno_reporte'
									AND tipo_observacion = '1' AND linea = '$n2'";    		//CASCO ROJO
	$query_observ_1				=	mig_query($sq_observ_1, $db);
	$res_observ_1				=	pg_fetch_array($query_observ_1);
	$cantidad_celdas[1][$n2]	=	$res_observ_1['total_casco_rojo'];
	$sq_observ_2				=	"SELECT COUNT(*) AS total_derrame_fl FROM estatus_planta_observaciones_reduccion_celdas WHERE fecha = '$fecha_reporte' AND turno = '$turno_reporte'
									AND tipo_observacion = '2' AND linea = '$n2'";     	//DERRAME FLORURO
	$query_observ_2				=	mig_query($sq_observ_2, $db);
	$res_observ_2				=	pg_fetch_array($query_observ_2);
	$cantidad_celdas[2][$n2]	=	$res_observ_2['total_derrame_fl'];
	$sq_observ_3				=	"SELECT COUNT(*) AS total_derrame_al FROM estatus_planta_observaciones_reduccion_celdas WHERE fecha = '$fecha_reporte' AND turno = '$turno_reporte'
									AND tipo_observacion = '3' AND linea = '$n2'";			//DERRAME ALUMINA
	$query_observ_3				=	mig_query($sq_observ_3, $db);
	$res_observ_3				=	pg_fetch_array($query_observ_3);
	$cantidad_celdas[3][$n2]	=	$res_observ_3['total_derrame_al'];
	$n2++;
}


////////////////////////////////////////////////
$sq_redu_observ_sup_1		=	"SELECT * FROM estatus_planta_observaciones WHERE id_sub_area = '6' AND fecha = '$fecha_reporte' AND turno = '$turno_reporte'";
$query_redu_observ_sup_1	=	mig_query($sq_redu_observ_sup_1, $db);
$res_redu_observ_sup_1		=	pg_fetch_array($query_redu_observ_sup_1);
if ($res_redu_observ_sup_1['observacion'] == "")	$observ_redu_sup_1 			= 	"&nbsp;";
else												$observ_redu_sup_1			=	$res_redu_observ_sup_1['observacion'];

$sq_redu_observ_sup_2		=	"SELECT * FROM estatus_planta_observaciones WHERE id_sub_area = '7' AND fecha = '$fecha_reporte' AND turno = '$turno_reporte'";
$query_redu_observ_sup_2	=	mig_query($sq_redu_observ_sup_2, $db);
$res_redu_observ_sup_2		=	pg_fetch_array($query_redu_observ_sup_2);
if ($res_redu_observ_sup_2['observacion'] == "")	$observ_redu_sup_2 			= 	"&nbsp;";
else												$observ_redu_sup_2			=	$res_redu_observ_sup_2['observacion'];

$sq_redu_observ_sup_3		=	"SELECT * FROM estatus_planta_observaciones WHERE id_sub_area = '8' AND fecha = '$fecha_reporte' AND turno = '$turno_reporte'";
$query_redu_observ_sup_3	=	mig_query($sq_redu_observ_sup_3, $db);
$res_redu_observ_sup_3		=	pg_fetch_array($query_redu_observ_sup_3);
if ($res_redu_observ_sup_3['observacion'] == "")	$observ_redu_sup_3 			= 	"&nbsp;";
else												$observ_redu_sup_3			=	$res_redu_observ_sup_3['observacion'];

$sq_redu_observ_sup_4		=	"SELECT * FROM estatus_planta_observaciones WHERE id_sub_area = '9' AND fecha = '$fecha_reporte' AND turno = '$turno_reporte'";
$query_redu_observ_sup_4	=	mig_query($sq_redu_observ_sup_4, $db);
$res_redu_observ_sup_4		=	pg_fetch_array($query_redu_observ_sup_4);
if ($res_redu_observ_sup_4['observacion'] == "")	$observ_redu_sup_4 			= 	"&nbsp;";
else												$observ_redu_sup_4			=	$res_redu_observ_sup_4['observacion'];

$sq_redu_observ_sup_5		=	"SELECT * FROM estatus_planta_observaciones WHERE id_sub_area = '10' AND fecha = '$fecha_reporte' AND turno = '$turno_reporte'";
$query_redu_observ_sup_5	=	mig_query($sq_redu_observ_sup_5, $db);
$res_redu_observ_sup_5		=	pg_fetch_array($query_redu_observ_sup_5);
if ($res_redu_observ_sup_5['observacion'] == "")	$observ_redu_sup_5 			= 	"&nbsp;";
else												$observ_redu_sup_5			=	$res_redu_observ_sup_5['observacion'];

////////////////////////////////////////////////
$sq_carb_observ_sup_1		=	"SELECT * FROM estatus_planta_observaciones WHERE id_sub_area = '2' AND fecha = '$fecha_reporte' AND turno = '$turno_reporte'";
$query_carb_observ_sup_1	=	mig_query($sq_carb_observ_sup_1, $db);
$res_carb_observ_sup_1		=	pg_fetch_array($query_carb_observ_sup_1);
if ($res_carb_observ_sup_1['observacion'] == "")	$observ_carb_sup_1			=	"&nbsp;";
else												$observ_carb_sup_1			=	$res_carb_observ_sup_1['observacion'];

$sq_carb_observ_sup_2		=	"SELECT * FROM estatus_planta_observaciones WHERE id_sub_area = '3' AND fecha = '$fecha_reporte' AND turno = '$turno_reporte'";
$query_carb_observ_sup_2	=	mig_query($sq_carb_observ_sup_2, $db);
$res_carb_observ_sup_2		=	pg_fetch_array($query_carb_observ_sup_2);
if ($res_carb_observ_sup_2['observacion'] == "")	$observ_carb_sup_2			=	"&nbsp;";
else												$observ_carb_sup_2			=	$res_carb_observ_sup_2['observacion'];

$sq_carb_observ_sup_3		=	"SELECT * FROM estatus_planta_observaciones WHERE id_sub_area = '4' AND fecha = '$fecha_reporte' AND turno = '$turno_reporte'";
$query_carb_observ_sup_3	=	mig_query($sq_carb_observ_sup_3, $db);
$res_carb_observ_sup_3		=	pg_fetch_array($query_carb_observ_sup_3);
if ($res_carb_observ_sup_3['observacion'] == "")	$observ_carb_sup_3			=	"&nbsp;";
else												$observ_carb_sup_3			=	$res_carb_observ_sup_3['observacion'];

$sq_carb_observ_sup_4		=	"SELECT * FROM estatus_planta_observaciones WHERE id_sub_area = '16' AND fecha = '$fecha_reporte' AND turno = '$turno_reporte'";
$query_carb_observ_sup_4	=	mig_query($sq_carb_observ_sup_4, $db);
$res_carb_observ_sup_4		=	pg_fetch_array($query_carb_observ_sup_4);
if ($res_carb_observ_sup_4['observacion'] == "")	$observ_carb_sup_4			=	"&nbsp;";
else												$observ_carb_sup_4			=	$res_carb_observ_sup_4['observacion'];

$sq_carb_observ_sup_5		=	"SELECT * FROM estatus_planta_observaciones WHERE id_sub_area = '17' AND fecha = '$fecha_reporte' AND turno = '$turno_reporte'";
$query_carb_observ_sup_5	=	mig_query($sq_carb_observ_sup_5, $db);
$res_carb_observ_sup_5		=	pg_fetch_array($query_carb_observ_sup_5);
if ($res_carb_observ_sup_5['observacion'] == "")	$observ_carb_sup_5			=	"&nbsp;";
else												$observ_carb_sup_5			=	$res_carb_observ_sup_5['observacion'];

////////////////////////////////////////////////
$sq_col_observ_sup_1		=	"SELECT * FROM estatus_planta_observaciones WHERE id_sub_area = '14' AND fecha = '$fecha_reporte' AND turno = '$turno_reporte'";
$query_col_observ_sup_1	=	mig_query($sq_col_observ_sup_1, $db);
$res_col_observ_sup_1		=	pg_fetch_array($query_col_observ_sup_1);
if ($res_col_observ_sup_1['observacion'] == "")		$observ_col_sup_1			=	"&nbsp;";
else												$observ_col_sup_1			=	$res_col_observ_sup_1['observacion'];

$sq_col_observ_sup_2		=	"SELECT * FROM estatus_planta_observaciones WHERE id_sub_area = '12' AND fecha = '$fecha_reporte' AND turno = '$turno_reporte'";
$query_col_observ_sup_2	=	mig_query($sq_col_observ_sup_2, $db);
$res_col_observ_sup_2		=	pg_fetch_array($query_col_observ_sup_2);
if ($res_col_observ_sup_2['observacion'] == "")		$observ_col_sup_2			=	"&nbsp;";
else												$observ_col_sup_2			=	$res_col_observ_sup_2['observacion'];

$sq_col_observ_sup_3		=	"SELECT * FROM estatus_planta_observaciones WHERE id_sub_area = '13' AND fecha = '$fecha_reporte' AND turno = '$turno_reporte'";
$query_col_observ_sup_3	=	mig_query($sq_col_observ_sup_3, $db);
$res_col_observ_sup_3		=	pg_fetch_array($query_col_observ_sup_3);
if ($res_col_observ_sup_3['observacion'] == "")		$observ_col_sup_3			=	"&nbsp;";
else												$observ_col_sup_3			=	$res_col_observ_sup_3['observacion'];

$sq_col_observ_sup_4		=	"SELECT * FROM estatus_planta_observaciones WHERE id_sub_area = '18' AND fecha = '$fecha_reporte' AND turno = '$turno_reporte'";
$query_col_observ_sup_4	=	mig_query($sq_col_observ_sup_4, $db);
$res_col_observ_sup_4		=	pg_fetch_array($query_col_observ_sup_4);
if ($res_col_observ_sup_4['observacion'] == "")		$observ_col_sup_4			=	"&nbsp;";
else												$observ_col_sup_4			=	$res_col_observ_sup_4['observacion'];
////////////////////////////////////////////////
$sq_scp_observ_sup_1		=	"SELECT * FROM estatus_planta_observaciones WHERE id_sub_area = '11' AND fecha = '$fecha_reporte' AND turno = '$turno_reporte'";
$query_scp_observ_sup_1	=	mig_query($sq_scp_observ_sup_1, $db);
$res_scp_observ_sup_1		=	pg_fetch_array($query_scp_observ_sup_1);
if ($res_scp_observ_sup_1['observacion'] == "")		$observ_scp_sup_1			=	"&nbsp;";
else												$observ_scp_sup_1			=	$res_scp_observ_sup_1['observacion'];
///////////////////////////////////////////////////////////////////////////////////////////////////////////////////
////////////////////DATOS DE ACCIDENTES
///////////////////////////////////////////////////////////////////////////////////////////////////////////////////
////////////////////DATOS DE ACCIDENTES DATOS TURNO////////////////////////
$sq_m27						=	"SELECT SUM(num_accidente) AS num_accidente, SUM(num_lesionados) AS num_lesionados 
								FROM estatus_planta_accidentes WHERE fecha = '$fecha_reporte' AND turno = '$turno_reporte'";
$query_m27					=	mig_query($sq_m27, $db);
$accidentes_turno			=	pg_fetch_array($query_m27);
///////////////////////ACUMULADOS SEMANALES DE ACCIDENTES//////////////////////////
$sq_m28											=	"SELECT SUM(num_accidente) AS num_accidente, SUM(num_lesionados) AS num_lesionados
													FROM estatus_planta_accidentes 
													WHERE date_part('week'::text, fecha) = '$reduccion_semana_reporte' AND date_part('year'::text, fecha) = '$reduccion_a�o_reporte'
													AND fecha <= '$fecha_reduccion_dia'
													GROUP BY date_part('week', fecha::date), date_part('year', fecha::date)";
$query_m28										=	mig_query($sq_m28, $db);
$acum_sem_accidentes							=	pg_fetch_array($query_m28);

////////////////////////////ACUMULADOS MENSUALES DE ACCIDENTES/////////////////////////////
$sq_m29											=	"SELECT SUM(num_accidente) AS num_accidente, SUM(num_lesionados) AS num_lesionados
													FROM estatus_planta_accidentes  
													WHERE date_part('month'::text, fecha) = '$reduccion_mes_reporte' AND date_part('year'::text, fecha) = '$reduccion_a�o_reporte'
													AND fecha <= '$fecha_reduccion_dia'
													GROUP BY date_part('month', fecha::date), date_part('year', fecha::date)";
$query_m29										=	mig_query($sq_m29, $db);
$acum_mes_accidentes							=	pg_fetch_array($query_m29);

//////////////////////////////ACUMULADOS DIARIOS DE ACCIDENTES//////////////////////////
$sq_m30											=	"SELECT SUM(num_accidente) AS num_accidente, SUM(num_lesionados) AS num_lesionados
													FROM estatus_planta_accidentes 
													WHERE fecha = '$fecha_reporte_dia' AND turno <= '$turno_reporte'";
$query_m30										=	mig_query($sq_m30, $db);
$acum_dia_accidentes							=	pg_fetch_array($query_m30);
////////////////////////////////////////////////////////////////////////////////////////////////////////////

////////////////////TEXTO POPUP CON DATOS DE FECHA, TURNO, SIGNIFICADO DEL CAMPO
$titulo_reduccion_dia_c1	=	"Temp. Critica: 980 < T.C < 940";
$titulo_reduccion_dia_c3_1	=	"Niv.Met.Critico: 29 < N.M.C < 22";
$titulo_reduccion_dia_c3_2	=	"Niv.Met.Critico: 26 < N.M.C < 20";
$titulo_reduccion_dia_c4_1	=	"Niv.Ban.Critico: 27 < N.B.C < 20";
$titulo_reduccion_dia_c4_2	=	"Niv.Ban.Critico: 23 < N.B.C < 16";
$titulo_reduccion_dia_c5_1	=	"%Fe > 0.5";
$titulo_reduccion_dia_c5_2	=	"%Fe > 0.3";
$titulo_carbon_acum			=	"Hasta el $fecha_reduccion_dia, turno 3";
$titulo_carbon_produc_ant1	=	"Total $fecha_reduccion_dia: $carbon_diario[produc_anodo_verde]";
$titulo_carbon_produc_ant2	=	"Total $fecha_reduccion_dia: $carbon_diario[produc_anodo_cocido]";
$titulo_carbon_produc_ant3	=	"Total $fecha_reduccion_dia: $carbon_diario[produc_anodo_envarillado]";

$titulo_accidentes_turno	=	"Lesionados: $accidentes_turno[num_lesionados]";

pg_close($db);
?>