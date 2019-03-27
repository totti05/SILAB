<?php
	include 'conectarse.php';

	$turno_carga					=	1;
	$db								=	conectarse_postgres();

	$sq_m0							=	"SELECT current_date AS fecha";
	$query_m0						=	mig_query($sq_m0, $db);	
	$res_m0							=	pg_fetch_array($query_m0);
	
	$fecha_hoy						=	$res_m0['fecha'];
	list($a, $m, $d)				=	split('-', $fecha_hoy);
 	$fecha							=	"$d/$m/$a";
	
	list($dia, $mes, $año)			=	split('/', $fecha);
	$fec = "$mes/$dia/$año";

	$mes_busc						=	date('M', strtotime($fec));
	$fecha_carga					=	"$fecha";

	$sq_m7				=	"SELECT     TO_CHAR(FECHA_RECEP, 'DD/MM/YYYY') AS DATE_IN, TURNO_RECEP AS ID_TURNO, COUNT(*) AS NUM_CRISOL_RECIB, AVG(TEMP_CRISOL) AS TEMP_CRISOL
							FROM         
								(SELECT     REPLACE (TO_CHAR(A.NRO_SALA, '09') || '-' || TO_CHAR(A.NRO_COL_RED, '099999'), ' ', '') AS COLADA, A.NUM_CRISOL, A.FECHA_RECEP, 
									  A.TURNO_RECEP, A.PESO_TEORICO, A.PESO_VACIADO, B.FECHA_OPER AS FECHA_VACIADO, A.FECHA_SALIDA, 
									  DECODE(B.TIPO_DESPACHO, 'V', B.NEM_DESPACHO, 'E', 'ENVARI', REPLACE (TO_CHAR(B.NUM_HORNO, '09') 
									  || '-' || TO_CHAR(B.NUM_COLADA, '09999'), ' ', '')) AS DESTINO, A.NRO_SALA, 
									  CASE A.NRO_SALA WHEN 1 THEN 1 WHEN 2 THEN 1 WHEN 3 THEN 2 WHEN 4 THEN 2 WHEN 5 THEN 3 WHEN 6 THEN 3 WHEN 7 THEN 4 WHEN
									   8 THEN 4 WHEN 9 THEN 5 WHEN 10 THEN 5 WHEN 11 THEN 6 ELSE 0 END LINEA_RED, TEMP_CRISOL
								FROM          PEXPCO.COLADA_REDUCCION A, PEXPCO.DISTRIBUCION B
								WHERE      B.NRO_SALA (+) = A.NRO_SALA AND B.NRO_COL_RED (+) = A.NRO_COL_RED AND (TO_CHAR(FECHA_RECEP, 'DD/MM/YYYY') = '$fecha_carga') 
								AND (B.TIPO_DESPACHO (+) <> 'D') AND TURNO_RECEP = '$turno_carga') DERIVEDTBL
						GROUP BY TO_CHAR(FECHA_RECEP, 'DD/MM/YYYY'), TURNO_RECEP";

	$sq_m8				=	"SELECT     TO_CHAR(FECHA_RECEP, 'DD/MM/YYYY') AS DATE_IN, TURNO_RECEP AS ID_TURNO, COUNT(*) AS NUM_CRISOL_PROCESADOS
							FROM         
								(SELECT     REPLACE (TO_CHAR(A.NRO_SALA, '09') || '-' || TO_CHAR(A.NRO_COL_RED, '099999'), ' ', '') AS COLADA, A.NUM_CRISOL, A.FECHA_RECEP, 
									  A.TURNO_RECEP, A.PESO_TEORICO, A.PESO_VACIADO, B.FECHA_OPER AS FECHA_VACIADO, A.FECHA_SALIDA, 
									  DECODE(B.TIPO_DESPACHO, 'V', B.NEM_DESPACHO, 'E', 'ENVARI', REPLACE (TO_CHAR(B.NUM_HORNO, '09') 
									  || '-' || TO_CHAR(B.NUM_COLADA, '09999'), ' ', '')) AS DESTINO, A.NRO_SALA, 
									  CASE A.NRO_SALA WHEN 1 THEN 1 WHEN 2 THEN 1 WHEN 3 THEN 2 WHEN 4 THEN 2 WHEN 5 THEN 3 WHEN 6 THEN 3 WHEN 7 THEN 4 WHEN
									   8 THEN 4 WHEN 9 THEN 5 WHEN 10 THEN 5 WHEN 11 THEN 6 ELSE 0 END LINEA_RED
								FROM          PEXPCO.COLADA_REDUCCION A, PEXPCO.DISTRIBUCION B
								WHERE      B.NRO_SALA (+) = A.NRO_SALA AND B.NRO_COL_RED (+) = A.NRO_COL_RED AND (TO_CHAR(FECHA_RECEP, 'DD/MM/YYYY') = '$fecha_carga') 
								AND (B.TIPO_DESPACHO (+) <> 'D') AND TURNO_RECEP = '$turno_carga' ) DERIVEDTBL
							GROUP BY TO_CHAR(FECHA_RECEP, 'DD/MM/YYYY'), TURNO_RECEP";


/////////////// EJECUCION DEL LOS QUERY DE LOS DATOS 
	$db_oracle			=	conectarse_oracle();
	$query_m7 			= 	ociparse($db_oracle, $sq_m7);
	$query_m77			=	ociparse($db_oracle, $sq_m7);
	ocidefinebyname($query_m7, 'DATE_IN', $DATE_IN);
	ocidefinebyname($query_m7, 'ID_TURNO', $ID_TURNO);
	ocidefinebyname($query_m7, 'NUM_CRISOL_RECIB', $NUM_CRISOL_RECIB);
	ocidefinebyname($query_m7, 'TEMP_CRISOL', $TEMP_CRISOL);
	ociexecute($query_m7);
	ocifetch($query_m7);
	
	$query_m8 			= 	ociparse($db_oracle, $sq_m8);
	ocidefinebyname($query_m8, 'DATE_IN', $DATE_IN2);
	ocidefinebyname($query_m8, 'ID_TURNO', $ID_TURNO2);
	ocidefinebyname($query_m8, 'NUM_CRISOL_PROCESADOS', $NUM_CRISOL_PROCESADOS);
	ociexecute($query_m8);
	ocifetch($query_m8);

	ociexecute($query_m77);
	ocifetchstatement($query_m77,$tab_result);  // the result will be fetched in the table $tab_result
	$num_filas1			=	ocirowcount($query_m77);
	
	$db					=	conectarse_postgres();

	if ($num_filas1 > 0)
	{
		$sq_m9				=	"SELECT * FROM estatus_planta_colada_turno WHERE fecha = '$fecha_carga' AND turno = '$turno_carga'";
		$query_m9			=	mig_query($sq_m9, $db);
		if (pg_num_rows($query_m9) == 0)
		{
			$sq_m10			=	"INSERT INTO estatus_planta_colada_turno (fecha, turno, num_crisoles_recibidos, num_crisoles_procesados, temperatura_crisoles_recibidos) VALUES
									('$DATE_IN', '$ID_TURNO', '$NUM_CRISOL_RECIB', '$NUM_CRISOL_PROCESADOS', '$TEMP_CRISOL');";
			$query_m10		=	mig_query($sq_m10, $db);
			echo "Los datos por turno de Colada de la fecha=$DATE_IN en turno=$ID_TURNO se han cargado correctamente <br>";
		}
		else
		{
			$sq_m11			=	"UPDATE estatus_planta_colada_turno SET	num_crisoles_recibidos 			= 	'$NUM_CRISOL_RECIB', 
																		num_crisoles_procesados			= 	'$NUM_CRISOL_PROCESADOS', 
																		temperatura_crisoles_recibidos	=	'$TEMP_CRISOL'
								WHERE fecha = '$DATE_IN' AND turno = '$ID_TURNO'";
			$query_m11		=	mig_query($sq_m11, $db);
			echo "Se detectaron datos de colada cargados previamente, se actualizaron a últimos datos de la fecha=$DATE_IN en turno=$ID_TURNO. Se ha procesado correctamente la solicitud<br>";
		}
	}
	else
	{
		echo "No se encontraron datos de colada para el día y turno seleccionado <br>";
	}
	pg_close($db);
	ocilogoff($db_oracle);


?>