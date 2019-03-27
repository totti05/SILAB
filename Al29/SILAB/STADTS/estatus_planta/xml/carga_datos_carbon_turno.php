<?php
	include '../conectarse.php';

	$fecha_carga		=	$_GET['fecha_carga'];
	$turno_carga		=	$_GET['turno_carga'];

	list($dia, $mes, $año)	=	split('/', $fecha_carga);
	$fec 					= "$mes/$dia/$año";
	$mes_busc				=	date('M', strtotime($fec));
		
	$fecha_carga			=	"$dia-$mes_busc-$año";

	$sq_m1					=	"SELECT DISTINCT to_date(to_char(g.fecha, 'DDMMYYYY'), 'ddmmyyyy hh24:mi:ss') AS DATE_IN, $turno_carga AS ID_TURNO,
									(SELECT     CASE WHEN NVL(SUM(PRODUCCION_NETA), 0) IS NULL THEN 0 ELSE NVL(SUM(PRODUCCION_NETA), 0) 
															   END AS PRODUCCION_NETA_MOLIENDA
										FROM          PRODUCCION_ANODO_V
										WHERE      FECHA = to_date(to_char(g.fecha, 'DD-MM-YYYY'), 'dd-mm-yyyy') AND TURNO = '$turno_carga') AS PRODUCCION_NETA_MOLIENDA,
									(SELECT     CASE WHEN nvl(SUM(nvl(desc_h481, 0)), 0) + nvl(SUM(nvl(desc_h321, 0)), 0) + nvl(SUM(nvl(desc_h482, 0)), 0) + nvl(SUM(nvl(desc_h322, 
															   0)), 0) IS NULL THEN 0 ELSE nvl(SUM(nvl(desc_h481, 0)), 0) + nvl(SUM(nvl(desc_h321, 0)), 0) + nvl(SUM(nvl(desc_h482, 0)), 0) 
															   + nvl(SUM(nvl(desc_h322, 0)), 0) END AS DESCARGA_ANODOS_COCIDOS
										FROM          inventario_anodo_cocido
										WHERE      FECHA = to_date(to_char(g.fecha, 'DD-MM-YYYY'), 'dd-mm-yyyy') AND (TURNO = '$turno_carga') AND clase_anodo = 1400)  AS DESCARGA_ANODOS_COCIDOS,
									(SELECT     CASE WHEN nvl(SUM(total_rechazo), 0) IS NULL THEN 0 ELSE nvl(SUM(total_rechazo), 0) END AS rechazo_anodo_cocido
										FROM          rechazo_anodo_venalum
										WHERE      hora = to_date(to_char(g.fecha, 'DD-MM-YYYY'), 'dd-mm-yyyy') AND TURNO = '$turno_carga' AND TIPO IN ('COC 1400', 'VEN 1400', 'RRETB1400', 
										'SERVC 1400', 'CARB 1400')) AS rechazo_anodo_cocido,
									(SELECT     CASE WHEN nvl(SUM(nvl(anodo_colado, 0)), 0) - nvl(SUM(nvl(anodo_carbonorca1500, 0)), 0) IS NULL 
															   THEN 0 ELSE nvl(SUM(nvl(anodo_colado, 0)), 0) - nvl(SUM(nvl(anodo_carbonorca1500, 0)), 0) END AS anodos_colados
										FROM          anodo_env
										WHERE      FECHA = to_date(to_char(g.fecha, 'DD-MM-YYYY'), 'dd-mm-yyyy') AND TURNO = '$turno_carga') AS anodos_colados,
									(SELECT     CASE WHEN(SUM(nvl(b.cant_venalum, 0))) IS NULL THEN 0 ELSE (SUM(nvl(b.cant_venalum, 0))) 
															   END AS anodo_env_rechazado_1400
										FROM          rechazo_anodo_env a, renglon_rechazo_anodo_env b
										WHERE      a.FECHA = to_date(to_char(g.fecha, 'DD-MM-YYYY'), 'dd-mm-yyyy') AND b.fecha = a.fecha AND b.turno = a.turno AND b.tipo = a.tipo AND 
															   b.nro_rechazo = 30 AND b.TURNO = '$turno_carga') AS anodo_env_rechazado_1400
								FROM         grupos_S g
								WHERE     g.FECHA = '$fecha_carga'";
//////////////////////// SELECT DE LOS DATOS DE ESTACIONES DE BAÑO
//////////////////////// 30-11-2011 SE CREA NUEVA TABLA PARA CARBON TURNO, SIMILAR A REDUCCION
//////////////////////// CON TIPO DE VARIABLE (BUSCAR DICCIONARIO DE VARIABLES REDUCCION

///////// CABO RECUPERADO Y ENVIADO
	$sq_m2					=	"SELECT to_char(fecha, 'DD-MM-YYYY') AS DATE_IN, TURNO AS ID_TURNO, NRO_COMPLEJO AS ID_COMPLEJO, ENVIADO AS CABO_ENVIADO, PROCESADO AS CABO_PROCESADO 
								FROM CABO_REC_BANO WHERE FECHA = '$fecha_carga' AND turno = '$turno_carga'";

///////// BAÑO ENVIADO 
	$sq_m3					=	"SELECT to_char(fecha, 'DD-MM-YYYY') AS DATE_IN, TURNO AS ID_TURNO, NRO_COMPLEJO AS ID_COMPLEJO, SUM(CANTIDAD_8C + CANTIDAD_9C + CANTIDAD_13C) AS TOTAL_BANO_ENVIADO 
								FROM BANO_ELECTROLITICO_REC WHERE FECHA = '$fecha_carga' AND turno = '$turno_carga' GROUP BY FECHA, TURNO, NRO_COMPLEJO";





/////////////// EJECUCION DEL LOS QUERY DE LOS DATOS 
	$db_oracle			=	conectarse_oracle();
	$query_m1 			= 	ociparse($db_oracle, $sq_m1);
	$query_m11 			= 	ociparse($db_oracle, $sq_m1);
	ocidefinebyname($query_m1, 'DATE_IN', $DATE_IN);
	ocidefinebyname($query_m1, 'ID_TURNO', $ID_TURNO);
	ocidefinebyname($query_m1, 'PRODUCCION_NETA_MOLIENDA', $PROD_NETA_MOLIENDA);
	ocidefinebyname($query_m1, 'DESCARGA_ANODOS_COCIDOS', $DESCARGA_ANODOS_COCIDOS);
	ocidefinebyname($query_m1, 'RECHAZO_ANODO_COCIDO', $RECHAZO_ANODO_COCIDO);
	ocidefinebyname($query_m1, 'ANODOS_COLADOS', $ANODOS_COLADOS);
	ocidefinebyname($query_m1, 'ANODO_ENV_RECHAZO_1400', $ANODO_ENV_RECHAZO_1400);
	ociexecute($query_m1);
	ociexecute($query_m11);
	ocifetchstatement($query_m11,$tab_result);  // the result will be fetched in the table $tab_result
	$num_filas1			=	ocirowcount($query_m11);
	ocifetch($query_m1);
///////// CABO RECUPERADO Y ENVIADO
	$query_m2				=	ociparse($db_oracle, $sq_m2);
	$query_m12 				= 	ociparse($db_oracle, $sq_m2);
	ocidefinebyname($query_m2, 'DATE_IN', $DATE_IN2);
	ocidefinebyname($query_m2, 'ID_TURNO', $ID_TURNO2);
	ocidefinebyname($query_m2, 'ID_COMPLEJO', $ID_COMPLEJO);
	ocidefinebyname($query_m2, 'CABO_ENVIADO', $CABO_ENVIADO);
	ocidefinebyname($query_m2, 'CABO_PROCESADO', $CABO_PROCESADO);
	ociexecute($query_m2);
	ociexecute($query_m12);
	ocifetchstatement($query_m12,$tab_result2);  // the result will be fetched in the table $tab_result
	$num_filas2				=	ocirowcount($query_m12);

	ocifetch($query_m2);
	$CABO_ENVIADO_C1		=	$CABO_ENVIADO;
	$CABO_PROCESADO_C1		=	$CABO_PROCESADO;

	ocifetch($query_m2);
	$CABO_ENVIADO_C2		=	$CABO_ENVIADO;
	$CABO_PROCESADO_C2		=	$CABO_PROCESADO;

///////// BAÑO ENVIADO 
	$query_m3				=	ociparse($db_oracle, $sq_m3);
	$query_m13 				= 	ociparse($db_oracle, $sq_m3);
	ocidefinebyname($query_m3, 'DATE_IN', $DATE_IN3);
	ocidefinebyname($query_m3, 'ID_TURNO', $ID_TURNO3);
	ocidefinebyname($query_m3, 'ID_COMPLEJO', $ID_COMPLEJO2);
	ocidefinebyname($query_m3, 'TOTAL_BANO_ENVIADO', $TOTAL_BANO_ENVIADO);
	ociexecute($query_m3);
	ociexecute($query_m13);
	ocifetchstatement($query_m13,$tab_result3);  // the result will be fetched in the table $tab_result
	$num_filas3				=	ocirowcount($query_m13);

	ocifetch($query_m3);
	$TOTAL_BANO_ENVIADO_C1	=	$TOTAL_BANO_ENVIADO;

	ocifetch($query_m3);
	$TOTAL_BANO_ENVIADO_C2	=	$TOTAL_BANO_ENVIADO;
	
	$PROD_NETA_HORNOS	=	$DESCARGA_ANODOS_COCIDOS - $RECHAZO_ANODO_COCIDO;
	$PROD_NETA_ENV		=	$ANODOS_COLADOS - $ANODO_ENV_RECHAZO_1400;
	$db					=	conectarse_postgres();

	if ($num_filas1 > 0)
	{
		$sq_m2				=	"SELECT * FROM estatus_planta_carbon_turno WHERE fecha = '$fecha_carga' AND turno = '$turno_carga'";
		$query_m2			=	mig_query($sq_m2, $db);
		
		if (pg_num_rows($query_m2) == 0)
		{
			echo $sq_m3				=	"INSERT INTO estatus_planta_carbon_turno (fecha, turno, produc_anodo_verde, produc_anodo_cocido, produc_anodo_envarillado) VALUES
									('$DATE_IN', '$ID_TURNO', '$PROD_NETA_MOLIENDA', '$PROD_NETA_HORNOS', '$PROD_NETA_ENV')";
			$query_m3			=	mig_query($sq_m3, $db);
			echo "Los datos por turno de Carbón de la fecha=$DATE_IN en turno=3 se han cargado correctamente <br>";
		}
		else
		{
			$sq_m4				=	"UPDATE estatus_planta_carbon_turno SET	produc_anodo_verde			=	'$PROD_NETA_MOLIENDA', 
																			produc_anodo_cocido			=	'$PROD_NETA_HORNOS', 
																			produc_anodo_envarillado 	=	'$PROD_NETA_ENV'
									WHERE fecha = '$DATE_IN' AND turno = '$ID_TURNO'";
			$query_m4			=	mig_query($sq_m4, $db);
			echo "Se detectaron datos de carbón cargados previamente, se actualizaron a últimos datos de la fecha=$DATE_IN en turno=3. Se ha procesado correctamente la solicitud<br>";
		}
	}
	else
	{
		echo "No se encontraron datos de carbon para el día y turno seleccionado <br>";
	}
//////INSERT DE CABOS ENVIADOS C1
	$tipo_variable				=	17;
	$tabla						=	"estatus_planta_carbon_turno_2";	
	$campos						=	"(fecha, complejo, turno, tipo_campo, valor_variable)";
	if ($num_filas2 > 0)
	{
		$sq_m5					=	"SELECT * FROM estatus_planta_carbon_turno_2 WHERE fecha = '$fecha_carga' AND turno = '$turno_carga' AND tipo_campo = '$tipo_variable' AND complejo = '1'";
		$query_m5				=	mig_query($sq_m5, $db);
		
		if (pg_num_rows($query_m5) == 0)
		{
			$valores_1			=	"('$DATE_IN2', '1', '$ID_TURNO2', '$tipo_variable', '$CABO_ENVIADO_C1')";
			$sq_m7_1			=	"INSERT INTO $tabla $campos VALUES $valores_1";
			$query_m7_1			=	mig_query($sq_m7_1, $db);
			echo "Los datos de Cabo Enviado C1 de la fecha = $DATE_IN2 en turno = $turno_carga se han cargado correctamente <br>";
		}
		else
		{
			$sq_m7_1			=	"UPDATE $tabla SET valor_variable = '$CABO_ENVIADO_C1' WHERE fecha = '$fecha_carga' AND turno = '$turno_carga' AND tipo_campo = '$tipo_variable' AND complejo = '1'";
			$query_m7_1			=	mig_query($sq_m7_1, $db);
			echo "Los datos de Cabo Enviado C1 de la fecha = $DATE_IN2 en turno = $turno_carga se han actualizado correctamente <br>";
		}
	}
	else
	{
		echo "No se encontraron datos de cabos para el día y turno seleccionado";
	}
//////INSERT DE CABOS ENVIADOS C2
	$tipo_variable				=	17;
	$tabla						=	"estatus_planta_carbon_turno_2";	
	$campos						=	"(fecha, complejo, turno, tipo_campo, valor_variable)";
	if ($num_filas2 > 0)
	{
		$sq_m5					=	"SELECT * FROM estatus_planta_carbon_turno_2 WHERE fecha = '$fecha_carga' AND turno = '$turno_carga' AND tipo_campo = '$tipo_variable' AND complejo = '2'";
		$query_m5				=	mig_query($sq_m5, $db);
		
		if (pg_num_rows($query_m5) == 0)
		{
			$valores_1			=	"('$DATE_IN2', '2', '$ID_TURNO2', '$tipo_variable', '$CABO_ENVIADO_C2')";
			$sq_m7_1			=	"INSERT INTO $tabla $campos VALUES $valores_1";
			$query_m7_1			=	mig_query($sq_m7_1, $db);
			echo "Los datos de Cabo Enviado C2 de la fecha = $DATE_IN2 en turno = $turno_carga se han cargado correctamente <br>";
		}
		else
		{
			$sq_m7_1			=	"UPDATE $tabla SET valor_variable = '$CABO_ENVIADO_C2' WHERE fecha = '$fecha_carga' AND turno = '$turno_carga' AND tipo_campo = '$tipo_variable' AND complejo = '2'";
			$query_m7_1			=	mig_query($sq_m7_1, $db);
			echo "Los datos de Cabo Enviado C2 de la fecha = $DATE_IN2 en turno = $turno_carga se han actualizado correctamente <br>";
		}
	}
	else
	{
		echo "No se encontraron datos de cabos para el día y turno seleccionado";
	}
	
//////INSERT DE CABOS PROCESADOS C1
	$tipo_variable				=	18;
	$tabla						=	"estatus_planta_carbon_turno_2";	
	$campos						=	"(fecha, complejo, turno, tipo_campo, valor_variable)";
	if ($num_filas2 > 0)
	{
		$sq_m5					=	"SELECT * FROM estatus_planta_carbon_turno_2 WHERE fecha = '$fecha_carga' AND turno = '$turno_carga' AND tipo_campo = '$tipo_variable' AND complejo = '1'";
		$query_m5				=	mig_query($sq_m5, $db);
		
		if (pg_num_rows($query_m5) == 0)
		{
			$valores_1			=	"('$DATE_IN2', '1', '$ID_TURNO2', '$tipo_variable', '$CABO_PROCESADO_C1')";
			$sq_m7_1			=	"INSERT INTO $tabla $campos VALUES $valores_1";
			$query_m7_1			=	mig_query($sq_m7_1, $db);
			echo "Los datos de Cabo Procesado C1 de la fecha = $DATE_IN2 en turno = $turno_carga se han cargado correctamente <br>";
		}
		else
		{
			$sq_m7_1			=	"UPDATE $tabla SET valor_variable = '$CABO_PROCESADO_C1' WHERE fecha = '$fecha_carga' AND turno = '$turno_carga' AND tipo_campo = '$tipo_variable' AND complejo = '1'";
			$query_m7_1			=	mig_query($sq_m7_1, $db);
			echo "Los datos de Cabo Procesado C1 de la fecha = $DATE_IN2 en turno = $turno_carga se han actualizado correctamente <br>";
		}
	}
	else
	{
		echo "No se encontraron datos de cabos para el día y turno seleccionado";
	}
//////INSERT DE CABOS PROCESADOS C2
	$tipo_variable				=	18;
	$tabla						=	"estatus_planta_carbon_turno_2";	
	$campos						=	"(fecha, complejo, turno, tipo_campo, valor_variable)";
	if ($num_filas2 > 0)
	{
		$sq_m5					=	"SELECT * FROM estatus_planta_carbon_turno_2 WHERE fecha = '$fecha_carga' AND turno = '$turno_carga' AND tipo_campo = '$tipo_variable' AND complejo = '2'";
		$query_m5				=	mig_query($sq_m5, $db);
		
		if (pg_num_rows($query_m5) == 0)
		{
			$valores_1			=	"('$DATE_IN2', '2', '$ID_TURNO2', '$tipo_variable', '$CABO_PROCESADO_C2')";
			$sq_m7_1			=	"INSERT INTO $tabla $campos VALUES $valores_1";
			$query_m7_1			=	mig_query($sq_m7_1, $db);
			echo "Los datos de Cabo Procesado C1 de la fecha = $DATE_IN2 en turno = $turno_carga se han cargado correctamente <br>";
		}
		else
		{
			$sq_m7_1			=	"UPDATE $tabla SET valor_variable = '$CABO_PROCESADO_C2' WHERE fecha = '$fecha_carga' AND turno = '$turno_carga' AND tipo_campo = '$tipo_variable' AND complejo = '2'";
			$query_m7_1			=	mig_query($sq_m7_1, $db);
			echo "Los datos de Cabo Procesado C1 de la fecha = $DATE_IN2 en turno = $turno_carga se han actualizado correctamente <br>";
		}
	}
	else
	{
		echo "No se encontraron datos de cabos para el día y turno seleccionado";
	}
//////INSERT DE BAÑO ENVIADO C1
	$tipo_variable				=	19;
	$tabla						=	"estatus_planta_carbon_turno_2";	
	$campos						=	"(fecha, complejo, turno, tipo_campo, valor_variable)";
	if ($num_filas3 > 0)
	{
		$sq_m5					=	"SELECT * FROM estatus_planta_carbon_turno_2 WHERE fecha = '$fecha_carga' AND turno = '$turno_carga' AND tipo_campo = '$tipo_variable' AND complejo = '1'";
		$query_m5				=	mig_query($sq_m5, $db);
		
		if (pg_num_rows($query_m5) == 0)
		{
			$valores_1			=	"('$DATE_IN2', '1', '$ID_TURNO2', '$tipo_variable', '$TOTAL_BANO_ENVIADO_C1')";
			$sq_m7_1			=	"INSERT INTO $tabla $campos VALUES $valores_1";
			$query_m7_1			=	mig_query($sq_m7_1, $db);
			echo "Los datos de Baño Enviado C1 de la fecha = $DATE_IN2 en turno = $turno_carga se han cargado correctamente <br>";
		}
		else
		{
			$sq_m7_1			=	"UPDATE $tabla SET valor_variable = '$TOTAL_BANO_ENVIADO_C1' WHERE fecha = '$fecha_carga' AND turno = '$turno_carga' AND tipo_campo = '$tipo_variable' AND complejo = '1'";
			$query_m7_1			=	mig_query($sq_m7_1, $db);
			echo "Los datos de Baño Enviado C1 de la fecha = $DATE_IN2 en turno = $turno_carga se han actualizado correctamente <br>";
		}
	}
	else
	{
		echo "No se encontraron datos de cabos para el día y turno seleccionado";
	}
//////INSERT DE BAÑO ENVIADO C2
	$tipo_variable				=	19;
	$tabla						=	"estatus_planta_carbon_turno_2";	
	$campos						=	"(fecha, complejo, turno, tipo_campo, valor_variable)";
	if ($num_filas3 > 0)
	{
		$sq_m5					=	"SELECT * FROM estatus_planta_carbon_turno_2 WHERE fecha = '$fecha_carga' AND turno = '$turno_carga' AND tipo_campo = '$tipo_variable' AND complejo = '2'";
		$query_m5				=	mig_query($sq_m5, $db);
		
		if (pg_num_rows($query_m5) == 0)
		{
			$valores_1			=	"('$DATE_IN2', '2', '$ID_TURNO2', '$tipo_variable', '$TOTAL_BANO_ENVIADO_C2')";
			$sq_m7_1			=	"INSERT INTO $tabla $campos VALUES $valores_1";
			$query_m7_1			=	mig_query($sq_m7_1, $db);
			echo "Los datos de Baño Enviado C1 de la fecha = $DATE_IN2 en turno = $turno_carga se han cargado correctamente <br>";
		}
		else
		{
			$sq_m7_1			=	"UPDATE $tabla SET valor_variable = '$TOTAL_BANO_ENVIADO_C2' WHERE fecha = '$fecha_carga' AND turno = '$turno_carga' AND tipo_campo = '$tipo_variable' AND complejo = '2'";
			$query_m7_1			=	mig_query($sq_m7_1, $db);
			echo "Los datos de Baño Enviado C2 de la fecha = $DATE_IN2 en turno = $turno_carga se han actualizado correctamente <br>";
		}
	}
	else
	{
		echo "No se encontraron datos de cabos para el día y turno seleccionado";
	}
	pg_close($db);
	ocilogoff($db_oracle);

?>