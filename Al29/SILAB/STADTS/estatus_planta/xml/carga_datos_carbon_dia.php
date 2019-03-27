<?php
	include '../conectarse.php';

	$fecha_carga		=	$_GET['fecha_carga'];

	list($dia, $mes, $año)	=	split('/', $fecha_carga);
	$fec 					= "$mes/$dia/$año";
	$mes_busc				=	date('M', strtotime($fec));
		
	$fecha_carga			=	"$dia-$mes_busc-$año";

	$sq_m1					=	"SELECT DISTINCT to_date(to_char(g.fecha, 'DDMMYYYY'), 'ddmmyyyy hh24:mi:ss') AS DATE_IN, 2 AS ID_TURNO,
									(SELECT     CASE WHEN NVL(SUM(PRODUCCION_NETA), 0) IS NULL THEN 0 ELSE NVL(SUM(PRODUCCION_NETA), 0) 
															   END AS PRODUCCION_NETA_MOLIENDA
										FROM          PRODUCCION_ANODO_V
										WHERE      FECHA = to_date(to_char(g.fecha, 'DD-MM-YYYY'), 'dd-mm-yyyy')) AS PRODUCCION_NETA_MOLIENDA,
									(SELECT     CASE WHEN nvl(SUM(nvl(desc_h481, 0)), 0) + nvl(SUM(nvl(desc_h321, 0)), 0) + nvl(SUM(nvl(desc_h482, 0)), 0) + nvl(SUM(nvl(desc_h322, 
															   0)), 0) IS NULL THEN 0 ELSE nvl(SUM(nvl(desc_h481, 0)), 0) + nvl(SUM(nvl(desc_h321, 0)), 0) + nvl(SUM(nvl(desc_h482, 0)), 0) 
															   + nvl(SUM(nvl(desc_h322, 0)), 0) END AS DESCARGA_ANODOS_COCIDOS
										FROM          inventario_anodo_cocido
										WHERE      FECHA = to_date(to_char(g.fecha, 'DD-MM-YYYY'), 'dd-mm-yyyy') AND clase_anodo = 1400)  AS DESCARGA_ANODOS_COCIDOS,
									(SELECT     CASE WHEN nvl(SUM(total_rechazo), 0) IS NULL THEN 0 ELSE nvl(SUM(total_rechazo), 0) END AS rechazo_anodo_cocido
										FROM          rechazo_anodo_venalum
										WHERE      hora = to_date(to_char(g.fecha, 'DD-MM-YYYY'), 'dd-mm-yyyy') AND TIPO IN ('COC 1400', 'VEN 1400', 'RRETB1400', 
										'SERVC 1400', 'CARB 1400')) AS rechazo_anodo_cocido,
									(SELECT     CASE WHEN nvl(SUM(nvl(anodo_colado, 0)), 0) - nvl(SUM(nvl(anodo_carbonorca1500, 0)), 0) IS NULL 
															   THEN 0 ELSE nvl(SUM(nvl(anodo_colado, 0)), 0) - nvl(SUM(nvl(anodo_carbonorca1500, 0)), 0) END AS anodos_colados
										FROM          anodo_env
										WHERE      FECHA = to_date(to_char(g.fecha, 'DD-MM-YYYY'), 'dd-mm-yyyy')) AS anodos_colados,
									(SELECT     CASE WHEN(SUM(nvl(b.cant_venalum, 0))) IS NULL THEN 0 ELSE (SUM(nvl(b.cant_venalum, 0))) 
															   END AS anodo_env_rechazado_1400
										FROM          rechazo_anodo_env a, renglon_rechazo_anodo_env b
										WHERE      a.FECHA = to_date(to_char(g.fecha, 'DD-MM-YYYY'), 'dd-mm-yyyy') AND b.fecha = a.fecha AND b.turno = a.turno AND b.tipo = a.tipo AND 
															   b.nro_rechazo = 30) AS anodo_env_rechazado_1400,
									(SELECT	CASE WHEN nvl(SUM(inv_final_limpio), 0) + nvl(SUM(inv_final_sucio), 0) + nvl(SUM(inv_final_maq_coc), 0)  IS NULL THEN 0 ELSE 
																nvl(SUM(inv_final_limpio), 0) + nvl(SUM(inv_final_sucio), 0) + nvl(SUM(inv_final_maq_coc), 0) END 
																				   AS inventario_anodos_cocidos
														FROM	inventario_anodo_cocido
														WHERE	FECHA = to_date(to_char(g.fecha, 'DD-MM-YYYY'), 'dd-mm-yyyy') AND turno = 3 AND clase_anodo = 1400) AS inventario_anodos_cocidos,
									(SELECT	CASE WHEN NVL(SUM(NVL(CANTIDAD, 0)), 0) IS NULL THEN 0 ELSE NVL(SUM(NVL(CANTIDAD, 0)), 0) END AS INVENTARIO_ANODOS_ENVARILLADOS
														FROM	ADMINSICA.RENGLON_INV_FISICO
														WHERE	FECHA = to_date(to_char(g.fecha, 'DD-MM-YYYY'), 'dd-mm-yyyy') AND (TURNO = 3)) AS INVENTARIO_ANODOS_ENVARILLADOS,
									(SELECT	CASE WHEN nvl(SUM(INV_FINAL_MAQ_COC), 0) IS NULL THEN 0 ELSE nvl(SUM(INV_FINAL_MAQ_COC), 0) END AS inventario_anodos_cocidos_1500
														FROM	inventario_anodo_cocido
														WHERE	FECHA = to_date(to_char(g.fecha, 'DD-MM-YYYY'), 'dd-mm-yyyy') AND turno = 3 AND clase_anodo = 1500) 
																AS inventario_anodos_cocidos_1500,
									(SELECT	CASE WHEN  nvl(SUM(nvl(inv_anodo_verde, 0)), 0) IS NULL THEN 0 ELSE  nvl(SUM(nvl(inv_anodo_verde, 0)), 0) END AS inventario_anodos_verdes
														FROM	inventario_anodo_cocido
														WHERE	FECHA = to_date(to_char(g.fecha, 'DD-MM-YYYY'), 'dd-mm-yyyy') AND turno = 3 AND clase_anodo = 1400) AS inventario_anodos_verdes
								FROM         grupos_S g
								WHERE     g.FECHA = '$fecha_carga'";


/////////////// EJECUCION DEL LOS QUERY DE LOS DATOS 
	$db_oracle			=	conectarse_oracle();
	$query_m1 			= 	ociparse($db_oracle, $sq_m1);
	ocidefinebyname($query_m1, 'DATE_IN', $DATE_IN);
	ocidefinebyname($query_m1, 'PRODUCCION_NETA_MOLIENDA', $PROD_NETA_MOLIENDA);
	ocidefinebyname($query_m1, 'DESCARGA_ANODOS_COCIDOS', $DESCARGA_ANODOS_COCIDOS);
	ocidefinebyname($query_m1, 'RECHAZO_ANODO_COCIDO', $RECHAZO_ANODO_COCIDO);
	ocidefinebyname($query_m1, 'ANODOS_COLADOS', $ANODOS_COLADOS);
	ocidefinebyname($query_m1, 'ANODO_ENV_RECHAZO_1400', $ANODO_ENV_RECHAZO_1400);
	ocidefinebyname($query_m1, 'INVENTARIO_ANODOS_COCIDOS', $INVENTARIO_ANODOS_COCIDOS_1400);
	ocidefinebyname($query_m1, 'INVENTARIO_ANODOS_ENVARILLADOS', $INVENTARIO_ANODOS_ENVARILLADOS);
	ocidefinebyname($query_m1, 'INVENTARIO_ANODOS_COCIDOS_1500', $INVENTARIO_ANODOS_COCIDOS_1500);
	ocidefinebyname($query_m1, 'INVENTARIO_ANODOS_VERDES', $INVENTARIO_ANODOS_VERDES);
	ociexecute($query_m1);

	ocifetch($query_m1, OCI_ASSOC);
	
	$PROD_NETA_HORNOS	=	$DESCARGA_ANODOS_COCIDOS - $RECHAZO_ANODO_COCIDO;
	$PROD_NETA_ENV		=	$ANODOS_COLADOS - $ANODO_ENV_RECHAZO_1400;
	$INV_ANODOS_COCIDOS	=	$INVENTARIO_ANODOS_COCIDOS_1400 + $INVENTARIO_ANODOS_COCIDOS_1500;
	$db					=	conectarse_postgres();
	
	$sq_m2				=	"SELECT * FROM estatus_planta_carbon_diario WHERE fecha = '$fecha_carga'";
	$query_m2			=	mig_query($sq_m2, $db);
	
	if (pg_num_rows($query_m2) == 0)
	{
		$sq_m3						=	"INSERT INTO estatus_planta_carbon_diario (fecha, produc_anodo_verde, 
											inventario_anodo_verde, produc_anodo_cocido, inventario_anodo_cocido, produc_anodo_envarillado, inventario_anodo_envarillado) 
										VALUES ('$fecha_carga', '$PROD_NETA_MOLIENDA', '$INVENTARIO_ANODOS_VERDES', '$PROD_NETA_HORNOS', 
											'$INV_ANODOS_COCIDOS', '$PROD_NETA_ENV', '$INVENTARIO_ANODOS_ENVARILLADOS')";
		$query_m3					=	mig_query($sq_m3, $db);
		echo "Los datos diarios de Carbón de la fecha = $DATE_IN se han cargado correctamente <br>";
	}
	else
	{
		$sq_m4						=	"UPDATE estatus_planta_carbon_diario SET 
											produc_anodo_verde 				= '$PROD_NETA_MOLIENDA',
											produc_anodo_cocido 			= '$PROD_NETA_HORNOS',
											produc_anodo_envarillado 		= '$PROD_NETA_ENV',
											inventario_anodo_verde 			= '$INVENTARIO_ANODOS_VERDES',
											inventario_anodo_cocido			= '$INV_ANODOS_COCIDOS',
											inventario_anodo_envarillado 	= '$INVENTARIO_ANODOS_ENVARILLADOS'
											WHERE fecha = '$fecha_carga'";
		$query_m4					=	mig_query($sq_m4, $db);
		echo "Se detectaron datos de carbón cargados previamente, se actualizaron a últimos datos de la fecha = $DATE_IN. Se ha procesado correctamente la solicitud<br>";
	}
	pg_close($db);
	ocilogoff($db_oracle);

?>