<?php
// de la fecha = $res_m1[fecha] linea=$res_m1[linea]
	include '../conectarse.php';

	$db					=	conectarse_postgres();

	$fecha_carga		=	$_GET['fecha_carga'];
	$turno_carga		=	$_GET['turno_carga'];

	list($dia, $mes, $año)	=	split('/', $fecha_carga);
	$fec 					= "$mes/$dia/$año";
	$mes_busc				=	date('M', strtotime($fec));
		
	$fecha_carga2			=	"$dia-$mes_busc-$año";

	$sq_m20					=	"SELECT '$fecha_carga2'::date + 1 AS fecha_programado_celdas";
	$query_m20				=	mig_query($sq_m20, $db);
	$res_m20				=	pg_fetch_array($query_m20);
	$fecha_programado_celdas	=	$res_m20['fecha_programado_celdas'];









	$db1					=	conectarse_aluminio20_dac();
	///CELDAS CON DESV RESISTENCIA >= 0.15
	$tipo_variable		=	5;
	$sq_m2				=	"SELECT DISTINCT CONVERT(nvarchar, DATE_IN, 103) AS DATE_IN,LINEA, ID_TURNO, $tipo_variable AS tipo_campo, ID_CELL, DESV_RESIST AS valor_variable
							FROM V_A20_DHW_CELDAS_STA
							WHERE      DESV_RESIST >= '0.15' AND DATE_IN = '$fecha_carga' AND  ID_TURNO = '$turno_carga'
							ORDER BY DATE_IN, ID_CELL, ID_TURNO;";

	///CELDAS CON MAS DE 1 LUZ EN EL TURNO 
	$tipo_variable		=	2;
 	$sq_m3				=	"SELECT DISTINCT CONVERT(nvarchar, DATE_IN, 103) AS DATE_IN,LINEA, ID_TURNO, $tipo_variable AS tipo_campo, ID_CELL,  LUZ_T".$turno_carga." AS valor_variable
							FROM          V_A20_DHW_CELDAS_STA
							WHERE      LUZ_T".$turno_carga." > '1' AND DATE_IN = '$fecha_carga' AND  ID_TURNO = '$turno_carga'
							ORDER BY DATE_IN, ID_CELL, ID_TURNO;";

	///PRESION DE AIRE DE COMPLEJO 1 PRESION PRINCIPAL
	$tipo_variable		=	6;
	$sq_m6_1			=	"SELECT      CONVERT(nvarchar, fecha, 103) AS DATE_IN, 1 AS LINEA, turno AS ID_TURNO, $tipo_variable AS tipo_campo, 191 AS ID_CELL, AVG(presionc1) AS valor_variable
							FROM         (SELECT     presionc1, fechahora, CONVERT(nvarchar, fechahora, 8) AS hora, CONVERT(nvarchar, fechahora, 103) AS fecha, 
										  CASE WHEN (CONVERT(nvarchar, fechahora, 8) >= '06:30:00' AND CONVERT(nvarchar, fechahora, 8) < '14:30:00') 
										  THEN '2' ELSE CASE WHEN (CONVERT(nvarchar, fechahora, 8) >= '14:30:00' AND CONVERT(nvarchar, fechahora, 8) < '22:30:00') 
										  THEN '3' ELSE '1' END END AS turno
										  FROM          VPRESIONPTA
										  WHERE      (CONVERT(nvarchar, fechahora, 103) = '$fecha_carga')) DERIVEDTBL
							WHERE     (turno = '$turno_carga')
							GROUP BY fecha, turno;";

	///PRESION DE AIRE DE COMPLEJO 2 PRESION PRINCIPAL
	$tipo_variable		=	6;
	$sq_m6_2			=	"SELECT     CONVERT(nvarchar, fecha, 103) AS DATE_IN, 3 AS LINEA, turno AS ID_TURNO, $tipo_variable AS tipo_campo, 591 AS ID_CELL, AVG(presionc2) AS valor_variable
							FROM         (SELECT     presionc2, fechahora, CONVERT(nvarchar, fechahora, 8) AS hora, CONVERT(nvarchar, fechahora, 103) AS fecha, 
										  CASE WHEN (CONVERT(nvarchar, fechahora, 8) >= '06:30:00' AND CONVERT(nvarchar, fechahora, 8) < '14:30:00') 
										  THEN '2' ELSE CASE WHEN (CONVERT(nvarchar, fechahora, 8) >= '14:30:00' AND CONVERT(nvarchar, fechahora, 8) < '22:30:00') 
										  THEN '3' ELSE '1' END END AS turno
										  FROM          VPRESIONPTAC2
										  WHERE      (CONVERT(nvarchar, fechahora, 103) = '$fecha_carga')) DERIVEDTBL
							WHERE     (turno = '$turno_carga')
							GROUP BY fecha, turno;";

	///PRESION DE AIRE DE COMPLEJO 3 PRESION PRINCIPAL
	$tipo_variable		=	6;
	$sq_m6_3			=	"SELECT     CONVERT(nvarchar, fecha, 103) AS DATE_IN, 5 AS LINEA, turno AS ID_TURNO, $tipo_variable AS tipo_campo, 991 AS ID_CELL, AVG(presion5L) AS valor_variable
							FROM         (SELECT     presion5L, fechahora, CONVERT(nvarchar, fechahora, 8) AS hora, CONVERT(nvarchar, fechahora, 103) AS fecha, 
										  CASE WHEN (CONVERT(nvarchar, fechahora, 8) >= '06:30:00' AND CONVERT(nvarchar, fechahora, 8) < '14:30:00') 
										  THEN '2' ELSE CASE WHEN (CONVERT(nvarchar, fechahora, 8) >= '14:30:00' AND CONVERT(nvarchar, fechahora, 8) < '22:30:00') 
										  THEN '3' ELSE '1' END END AS turno
										  FROM           VPRESIONPTA5L
										  WHERE      (CONVERT(nvarchar, fechahora, 103) = '$fecha_carga')) DERIVEDTBL
							WHERE     (turno = '$turno_carga')
							GROUP BY fecha, turno;";

	///PRESION DE AIRE DE COMPLEJO 1 PRESION FAC18
	$tipo_variable		=	9;
	$sq_m9_1			=	"SELECT      CONVERT(nvarchar, fecha, 103) AS DATE_IN, 1 AS LINEA, turno AS ID_TURNO, $tipo_variable AS tipo_campo, 191 AS ID_CELL, AVG(presionfac18) AS valor_variable
							FROM         (SELECT     presionfac18, fechahora, CONVERT(nvarchar, fechahora, 8) AS hora, CONVERT(nvarchar, fechahora, 103) AS fecha, 
										  CASE WHEN (CONVERT(nvarchar, fechahora, 8) >= '06:30:00' AND CONVERT(nvarchar, fechahora, 8) < '14:30:00') 
										  THEN '2' ELSE CASE WHEN (CONVERT(nvarchar, fechahora, 8) >= '14:30:00' AND CONVERT(nvarchar, fechahora, 8) < '22:30:00') 
										  THEN '3' ELSE '1' END END AS turno
										  FROM          VPRESIONPTA
										  WHERE      (CONVERT(nvarchar, fechahora, 103) = '$fecha_carga')) DERIVEDTBL
							WHERE     (turno = '$turno_carga')
							GROUP BY fecha, turno;";

	///PRESION DE AIRE DE COMPLEJO 2 PRESION FAC18
	$tipo_variable		=	9;
	$sq_m9_2			=	"SELECT     CONVERT(nvarchar, fecha, 103) AS DATE_IN, 3 AS LINEA, turno AS ID_TURNO, $tipo_variable AS tipo_campo, 591 AS ID_CELL, AVG(p_fac18_c2) AS valor_variable
							FROM         (SELECT     p_fac18_c2, fechahora, CONVERT(nvarchar, fechahora, 8) AS hora, CONVERT(nvarchar, fechahora, 103) AS fecha, 
										  CASE WHEN (CONVERT(nvarchar, fechahora, 8) >= '06:30:00' AND CONVERT(nvarchar, fechahora, 8) < '14:30:00') 
										  THEN '2' ELSE CASE WHEN (CONVERT(nvarchar, fechahora, 8) >= '14:30:00' AND CONVERT(nvarchar, fechahora, 8) < '22:30:00') 
										  THEN '3' ELSE '1' END END AS turno
										  FROM          DATOSC1
										  WHERE      (CONVERT(nvarchar, fechahora, 103) = '$fecha_carga')) DERIVEDTBL
							WHERE     (turno = '$turno_carga')
							GROUP BY fecha, turno;";

	///ANODOS SUMINISTRADOS A REDUCCION
	$tipo_variable		=	7;
	$sq_m7				=	"SELECT     FECHA AS DATE_IN, CASE WHEN LINEA <= '4' THEN LINEA ELSE '5' END AS LINEA, TURNO AS ID_TURNO, 7 AS TIPO_CAMPO, 
									SUM(CANTIDAD) AS VALOR_VARIABLE, 
								  	CASE WHEN LINEA = '1' THEN 191 ELSE CASE WHEN LINEA = '2' THEN 391 ELSE CASE WHEN LINEA = '3' THEN 591 ELSE CASE WHEN LINEA = '4' THEN
								   	791 ELSE 991 END END END END AS ID_CELL
								FROM         ADMINSICA.RENGLON_INV_FISICO
								WHERE     (FECHA = '$fecha_carga2') 
								AND (TURNO = '$turno_carga') AND (TIPO_TRANSACCION = 'EN CELDAS LINEA' OR
													  TIPO_TRANSACCION = 'CARRETAS V-LINEA' OR
													  TIPO_TRANSACCION = 'CARRETAS V LINEA')
								GROUP BY FECHA, TURNO, LINEA";
	if ($turno_carga == 3)
	{
		///CELDAS CON TEMPERATURA >= 980 Y TEMPERATURA <= 940
		$tipo_variable	=	1;
		$sq_m1			=	"SELECT DISTINCT CONVERT(nvarchar, DATE_IN, 103) AS DATE_IN,LINEA, ID_TURNO, $tipo_variable AS tipo_campo, ID_CELL, TEMP AS valor_variable
							FROM          V_A20_DHW_CELDAS_STA
							WHERE      (TEMP >= '980' OR TEMP <= '940') AND DATE_IN = '$fecha_carga' AND  ID_TURNO = '$turno_carga'
							ORDER BY DATE_IN, ID_CELL, ID_TURNO;";

		///CELDAS CON NIVEL DE METAL >= 29 O NIVEL DE METAL <= 22 P-19
		$tipo_variable	=	3;
		$sq_m4			=	"SELECT DISTINCT CONVERT(nvarchar, DATE_IN, 103) AS DATE_IN,LINEA, ID_TURNO, $tipo_variable AS tipo_campo, ID_CELL,  METAL AS valor_variable
							FROM          V_A20_DHW_CELDAS_STA
							WHERE       (METAL >= '29' OR METAL <= '22') AND DATE_IN = '$fecha_carga' AND  ID_TURNO = '$turno_carga' AND LINEA <= '4'
							ORDER BY DATE_IN, ID_CELL, ID_TURNO;";
		///CELDAS CON NIVEL DE METAL >= 26 O NIVEL DE METAL <= 20 LINEA 5echo "<br>----";
		$sq_m4_2		=	"SELECT DISTINCT CONVERT(nvarchar, DATE_IN, 103) AS DATE_IN,LINEA, ID_TURNO, $tipo_variable AS tipo_campo, ID_CELL,  METAL AS valor_variable
							FROM          V_A20_DHW_CELDAS_STA
							WHERE       (METAL >= '26' OR METAL <= '20') AND DATE_IN = '$fecha_carga' AND  ID_TURNO = '$turno_carga' AND LINEA = '5'
							ORDER BY DATE_IN, ID_CELL, ID_TURNO;";
	
		///CELDAS CON NIVEL DE BAÑO >= 27 O NIVEL DE BAÑO <= 20 P-19
		$tipo_variable	=	4;
		$sq_m5			=	"SELECT DISTINCT CONVERT(nvarchar, DATE_IN, 103) AS DATE_IN,LINEA, ID_TURNO, $tipo_variable AS tipo_campo, ID_CELL,  BANO AS valor_variable
							FROM          V_A20_DHW_CELDAS_STA
							WHERE       (BANO >= '27' OR BANO <= '20') AND DATE_IN = '$fecha_carga' AND  ID_TURNO = '$turno_carga' AND LINEA <= '4'
							ORDER BY DATE_IN, ID_CELL, ID_TURNO;";
		///CELDAS CON NIVEL DE BAÑO >= 23 O NIVEL DE BAÑO <= 16 LINEA 5
		$tipo_variable	=	4;
		$sq_m5_2			=	"SELECT DISTINCT CONVERT(nvarchar, DATE_IN, 103) AS DATE_IN,LINEA, ID_TURNO, $tipo_variable AS tipo_campo, ID_CELL,  BANO AS valor_variable
							FROM          V_A20_DHW_CELDAS_STA
							WHERE       (BANO >= '23' OR BANO <= '16') AND DATE_IN = '$fecha_carga' AND  ID_TURNO = '$turno_carga' AND LINEA = '5'
							ORDER BY DATE_IN, ID_CELL, ID_TURNO;";

		///CELDAS CON %Fe >= 0.5 PARA P-19
		$tipo_variable		=	8;
		$sq_m8_1			=	"SELECT DISTINCT CONVERT(nvarchar, DIA, 103) AS DIA, EDAD,
								CASE WHEN CELDA > '100' AND CELDA < '300' THEN 1 ELSE 
								CASE WHEN  CELDA > '300' AND CELDA < '500' THEN 2 ELSE
								CASE WHEN  CELDA > '500' AND CELDA < '700' THEN 3 ELSE
								CASE WHEN  CELDA > '700' AND CELDA < '900' THEN 4  
								END END END END AS LINEA, 
								3 AS ID_TURNO, $tipo_variable AS tipo_campo, CELDA AS ID_CELL, FE AS valor_variable
								FROM DATA_FINAL_SIN_ERRORES1
								WHERE      FE >= '0.5' AND DIA = '$fecha_carga' AND CELDA < '900'
								ORDER BY DIA, CELDA, ID_TURNO;";

		///CELDAS CON %Fe >= 0.5    PARA LINEA 5
		$tipo_variable		=	8;
		$sq_m8_2			=	"SELECT DISTINCT CONVERT(nvarchar, DIA, 103) AS DIA, EDAD,
								 5 AS LINEA, 
								3 AS ID_TURNO, $tipo_variable AS tipo_campo, CELDA AS ID_CELL, FE AS valor_variable
								FROM DATA_FINAL_SIN_ERRORES1
								WHERE      FE >= '0.3' AND DIA = '$fecha_carga' AND CELDA > '900'
								ORDER BY DIA, CELDA, ID_TURNO;";  

		////CELDAS CON MAS DE 1 EA POR TURNO CALCULADO EN T3 PARA TODO EL DÍA. CON ESTE DATO SE BUSCARÁ LA ULTIMA ACIDEZ
		$sq_m10			=	"SELECT DISTINCT ID_CELL
								FROM         V_A20_DHW_CELDAS_STA
								WHERE      (TEMP >= '980' OR TEMP <= '940') AND DATE_IN = '$fecha_carga' AND  ID_TURNO = '$turno_carga'
								ORDER BY ID_CELL;";


		////CELDAS CON MAS DE 1 EA POR TURNO CALCULADO EN T3 PARA TODO EL DÍA. CON ESTE DATO SE BUSCARÁ LA ULTIMA ACIDEZ
		$sq_m10			=	"SELECT DISTINCT ID_CELL
								FROM         V_A20_DHW_CELDAS_STA
								WHERE      (TEMP >= '980' OR TEMP <= '940') AND DATE_IN = '$fecha_carga' AND  ID_TURNO = '$turno_carga'
								ORDER BY ID_CELL;";


/////////////// EJECUCION DEL LOS QUERY DE LOS DATOS QUE SALEN DE LA BASE DE DATOS DAC DE ALUMINIO20\DHW		
		$query_m1		=	mig_query($sq_m1, $db1, 'mssql');
		$query_m4		=	mig_query($sq_m4, $db1, 'mssql');
		$query_m4_2		=	mig_query($sq_m4_2, $db1, 'mssql');
		$query_m5		=	mig_query($sq_m5, $db1, 'mssql');
		$query_m5_2		=	mig_query($sq_m5_2, $db1, 'mssql');
		
		$query_m8_1		=	mssql_query("SET ANSI_NULLS ON");
		$query_m8_2		=	mssql_query("SET ANSI_NULLS ON");
		$query_m8_1		=	mssql_query("SET ANSI_WARNINGS ON");
		$query_m8_2		=	mssql_query("SET ANSI_WARNINGS ON");
		
		$query_m8_1		=	mig_query($sq_m8_1, $db1, 'mssql');
		$query_m8_2		=	mig_query($sq_m8_2, $db1, 'mssql');
		$query_m10		=	mig_query($sq_m10, $db1, 'mssql');
	}

	$query_m2			=	mig_query($sq_m2, $db1, 'mssql');
	$query_m3			=	mig_query($sq_m3, $db1, 'mssql');
/*
/////////////////////////BUSQUEDA DE LA PROGRAMACION DE TRAZEGADO DE CELDAS CON N.M.C  /////////////////////////
	$db_oracle			=	conectarse_oracle();
echo "-------".mssql_num_rows($query_m4);
if (mssql_num_rows($query_m4) > 0)
{
	while($res_m4 =	mssql_fetch_array($query_m4))
	{
		echo "<br>";
		echo $sq_mAfe_1		=	"SELECT	FECHA, NRO_CELDA, CANT_PRG FROM	PEXPRE.PROGRAMADOS
							WHERE 	(FECHA = '$fecha_carga2') AND (NRO_CELDA = '$res_m4[ID_CELL]')";
		$query_mAfe_1 	= 	ociparse($db_oracle, $sq_mAfe_1);
		$query_mAfe_11 			= 	ociparse($db_oracle, $sq_mAfe_1);
		ocidefinebyname($query_mAfe_1, 'FECHA', $FECHA);
		ocidefinebyname($query_mAfe_1, 'NRO_CELDA', $NRO_CELDA);
		ocidefinebyname($query_mAfe_1, 'CANT_PRG', $CANT_PRG);
		ociexecute($query_mAfe_1);
		ociexecute($query_mAfe_11);
		ocifetchstatement($query_mAfe_11, $tab_result);  // the result will be fetched in the table $tab_result
		$num_filas1			=	ocirowcount($query_mAfe_11);
		
		if ($num_filas1 > 0)
		{
		
		
		}
	}
}
echo "<br>";

*/   
	mssql_close($db1);

/////////////// EJECUCION DEL LOS QUERY DE LOS DATOS QUE SALEN DE LA BASE DE DATOS FASE DENSA DE ALUMINIO20\DHW		
	$db2					=	conectarse_aluminio20_fasedensa();
	$query_m6_1			=	mig_query($sq_m6_1, $db2, 'mssql');
	$query_m6_2			=	mig_query($sq_m6_2, $db2, 'mssql');
	$query_m6_3			=	mig_query($sq_m6_3, $db2, 'mssql');
	$query_m9_1			=	mig_query($sq_m9_1, $db2, 'mssql');
	$query_m9_2			=	mig_query($sq_m9_2, $db2, 'mssql');
	mssql_close($db2);

/////////////// EJECUCION DEL LOS QUERY DE LOS DATOS QUE SALEN DEL SICA (ANODOS SUMINISTRADOS A REDUCCION)
	$db_oracle			=	conectarse_oracle();
	$query_m7 			= 	ociparse($db_oracle, $sq_m7);
	$query_m77 			= 	ociparse($db_oracle, $sq_m7);
	ocidefinebyname($query_m7, 'DATE_IN', $DATE_IN);
	ocidefinebyname($query_m7, 'LINEA', $LINEA);
	ocidefinebyname($query_m7, 'ID_TURNO', $ID_TURNO);
	ocidefinebyname($query_m7, 'ID_CELL', $ID_CELL);
	ocidefinebyname($query_m7, 'TIPO_CAMPO', $TIPO_CAMPO);
	ocidefinebyname($query_m7, 'VALOR_VARIABLE', $VALOR_VARIABLE);
	ociexecute($query_m7);
	ociexecute($query_m77);
	ocifetchstatement($query_m77,$tab_result);  // the result will be fetched in the table $tab_result
	$num_filas1			=	ocirowcount($query_m77);


/////////////// INSERCIÓN DE LOS DATOS DE TODOS LOS QUERY AL SERVIDOR POSTGRES EN LA BASE DE DATOS ESTATUS_PLANTA
/////////////// SI DETECTO DATOS PREVIAMENTE GUARDADOS, LOS BORRA Y CARGA LOS NUEVOS, SINO SIMPLEMENTE CARGA TODOS LOS DATOS
/////////////// SE HACE POR TIPO DE CAMPO
	
	if ($turno_carga == 3)
	{
////////////CELDAS CON TEMPERATURA >= 980 Y TEMPERATURA <= 940
		if (mssql_num_rows($query_m1) > 0)
		{
			$tipo_variable		=	1;
			$sq_m21				=	"SELECT * FROM estatus_planta_reduccion_turno WHERE fecha = '$fecha_carga' AND turno = '$turno_carga' AND tipo_campo = '$tipo_variable'";
			$query_m21			=	mig_query($sq_m21, $db);
			if (pg_num_rows($query_m21) == 0)
			{
				while($res_m1 =	mssql_fetch_array($query_m1))
				{
					$sq_m11		=	"INSERT INTO estatus_planta_reduccion_turno (fecha, linea, turno, tipo_campo, num_celda, valor_variable) VALUES
										('$res_m1[DATE_IN]', '$res_m1[LINEA]', '$res_m1[ID_TURNO]', '$res_m1[tipo_campo]', '$res_m1[ID_CELL]', '$res_m1[valor_variable]');";
					$query_m11	=	mig_query($sq_m11, $db);
				}	
				echo "1.- Los datos de celdas con temperatura > 980 se han cargado correctamente <br>";
			}
			else
			{
				$sq_m31			=	"DELETE FROM estatus_planta_reduccion_turno WHERE fecha = '$fecha_carga' AND turno = '$turno_carga' AND tipo_campo = '$tipo_variable'";
				$query_m31		=	mig_query($sq_m31, $db);
				while($res_m1 =	mssql_fetch_array($query_m1))
				{
					$sq_m11		=	"INSERT INTO estatus_planta_reduccion_turno (fecha, linea, turno, tipo_campo, num_celda, valor_variable) VALUES
										('$res_m1[DATE_IN]', '$res_m1[LINEA]', '$res_m1[ID_TURNO]', '$res_m1[tipo_campo]', '$res_m1[ID_CELL]', '$res_m1[valor_variable]');";
					$query_m11	=	mig_query($sq_m11, $db);
				}	
				echo "1.1.- Se detectaron datos de celdas con temperatura > 980 cargados previamente, se actualizaron a últimos datos. Se ha procesado correctamente la solicitud<br>";
			}
		}
		else
		{
			echo "No se encontraron Celdas con temperatura > 980 para el día y turno solicitado <br>";
		}
//////////////CELDAS CON NIVEL DE METAL >= 29 O NIVEL DE METAL <= 22 P-19
		if (mssql_num_rows($query_m4) > 0)
		{
			$tipo_variable		=	3;
			$sq_m21				=	"SELECT * FROM estatus_planta_reduccion_turno WHERE fecha = '$fecha_carga' AND turno = '$turno_carga' AND tipo_campo = '$tipo_variable'
									AND linea <= '4'";
			$query_m21			=	mig_query($sq_m21, $db);
			if (pg_num_rows($query_m21) == 0)
			{
				while($res_m4 =	mssql_fetch_array($query_m4))
				{
					$sq_m14			=	"INSERT INTO estatus_planta_reduccion_turno (fecha, linea, turno, tipo_campo, num_celda, valor_variable) VALUES
										('$res_m4[DATE_IN]', '$res_m4[LINEA]', '$res_m4[ID_TURNO]', '$res_m4[tipo_campo]', '$res_m4[ID_CELL]', '$res_m4[valor_variable]');";
					$query_m14		=	mig_query($sq_m14, $db);
				}	
				echo "2.- Los datos de celdas P-19 con nivel de metal >= 29 O nivel de metal <= 22 se han cargado correctamente <br>";
			}
			else
			{
				$sq_m31			=	"DELETE FROM estatus_planta_reduccion_turno WHERE fecha = '$fecha_carga' AND turno = '$turno_carga' AND tipo_campo = '$tipo_variable'
									AND linea <= '4'";
				$query_m31		=	mig_query($sq_m31, $db);
				while($res_m4 =	mssql_fetch_array($query_m4))
				{
					$sq_m14			=	"INSERT INTO estatus_planta_reduccion_turno (fecha, linea, turno, tipo_campo, num_celda, valor_variable) VALUES
										('$res_m4[DATE_IN]', '$res_m4[LINEA]', '$res_m4[ID_TURNO]', '$res_m4[tipo_campo]', '$res_m4[ID_CELL]', '$res_m4[valor_variable]');";
					$query_m14		=	mig_query($sq_m14, $db);
				}	
				echo "2.1.- Se detectaron datos de celdas P-19 con nivel de metal >= 29 O nivel de metal <= 22 cargados previamente, se actualizaron a últimos datos. Se ha procesado correctamente la solicitud<br>";
			}
		}
		else
		{
			echo "No se encontraron Celdas con nivel de metal >= 30 O nivel de metal <= 19 para el día y turno solicitado <br>";
		}
//////////////CELDAS CON NIVEL DE METAL >= 26 O NIVEL DE METAL <= 20 LINEA 5
		if (mssql_num_rows($query_m4_2) > 0)
		{
			$tipo_variable		=	3;
			$sq_m21				=	"SELECT * FROM estatus_planta_reduccion_turno WHERE fecha = '$fecha_carga' AND turno = '$turno_carga' AND tipo_campo = '$tipo_variable'
									AND linea = '5'";
			$query_m21			=	mig_query($sq_m21, $db);
			if (pg_num_rows($query_m21) == 0)
			{
				while($res_m4_2 =	mssql_fetch_array($query_m4_2))
				{
					$sq_m14			=	"INSERT INTO estatus_planta_reduccion_turno (fecha, linea, turno, tipo_campo, num_celda, valor_variable) VALUES
										('$res_m4_2[DATE_IN]', '$res_m4_2[LINEA]', '$res_m4_2[ID_TURNO]', '$res_m4_2[tipo_campo]', '$res_m4_2[ID_CELL]', '$res_m4_2[valor_variable]');";
					$query_m14		=	mig_query($sq_m14, $db);
				}	
				echo "3.- Los datos de celdas LINEA 5 con nivel de metal >= 26 O nivel de metal <= 20 se han cargado correctamente <br>";
			}
			else
			{
				$sq_m31			=	"DELETE FROM estatus_planta_reduccion_turno WHERE fecha = '$fecha_carga' AND turno = '$turno_carga' AND tipo_campo = '$tipo_variable'
									AND linea = '5'";
				$query_m31		=	mig_query($sq_m31, $db);
				while($res_m4_2 =	mssql_fetch_array($query_m4_2))
				{
					$sq_m14			=	"INSERT INTO estatus_planta_reduccion_turno (fecha, linea, turno, tipo_campo, num_celda, valor_variable) VALUES
										('$res_m4_2[DATE_IN]', '$res_m4_2[LINEA]', '$res_m4_2[ID_TURNO]', '$res_m4_2[tipo_campo]', '$res_m4_2[ID_CELL]', '$res_m4_2[valor_variable]');";
					$query_m14		=	mig_query($sq_m14, $db);
				}	
				echo "3.1.- Se detectaron datos de celdas LINEA 5 con nivel de metal >= 30 O nivel de metal <= 19 cargados previamente, se actualizaron a últimos datos. Se ha procesado correctamente la solicitud<br>";
			}
		}
		else
		{
			echo "No se encontraron Celdas con nivel de metal >= 26 O nivel de metal <= 20 para el día y turno solicitado <br>";
		}
////////////CELDAS CON NIVEL DE BAÑO >= 27 O NIVEL DE BAÑO <= 20 P-19
		if (mssql_num_rows($query_m5) > 0)
		{
			$tipo_variable		=	4;
			$sq_m21				=	"SELECT * FROM estatus_planta_reduccion_turno WHERE fecha = '$fecha_carga' AND turno = '$turno_carga' AND tipo_campo = '$tipo_variable'
									AND linea <= '4'";
			$query_m21			=	mig_query($sq_m21, $db);
			if (pg_num_rows($query_m21) == 0)
			{
				while($res_m5 =	mssql_fetch_array($query_m5))
				{
					$sq_m15			=	"INSERT INTO estatus_planta_reduccion_turno (fecha, linea, turno, tipo_campo, num_celda, valor_variable) VALUES
										('$res_m5[DATE_IN]', '$res_m5[LINEA]', '$res_m5[ID_TURNO]', '$res_m5[tipo_campo]', '$res_m5[ID_CELL]', '$res_m5[valor_variable]');";
					$query_m15		=	mig_query($sq_m15, $db);
				}	
				echo "4.- Los datos de celdas P-19 con nivel de baño >= 27 O nivel de baño <= 20 se han cargado correctamente <br>";
			}
			else
			{
				$sq_m31			=	"DELETE FROM estatus_planta_reduccion_turno WHERE fecha = '$fecha_carga' AND turno = '$turno_carga' AND tipo_campo = '$tipo_variable'
									AND linea <= '4'";
				$query_m31		=	mig_query($sq_m31, $db);
				while($res_m5 =	mssql_fetch_array($query_m5))
				{
					$sq_m15			=	"INSERT INTO estatus_planta_reduccion_turno (fecha, linea, turno, tipo_campo, num_celda, valor_variable) VALUES
										('$res_m5[DATE_IN]', '$res_m5[LINEA]', '$res_m5[ID_TURNO]', '$res_m5[tipo_campo]', '$res_m5[ID_CELL]', '$res_m5[valor_variable]');";
					$query_m15		=	mig_query($sq_m15, $db);
				}	
				echo "4.1.- Se detectaron datos de celdas P-19 con nivel de baño >= 27 O nivel de baño <= 20 cargados previamente, se actualizaron a últimos datos. Se ha procesado correctamente la solicitud<br>";
			}
		}
		else
		{
			echo "No se encontraron Celdas con nivel de baño >= 30 O nivel de baño <= 18 para el día y turno solicitado <br>";
		}
////////////CELDAS CON NIVEL DE BAÑO >= 23 O NIVEL DE BAÑO <= 16 LINEA 5
		if (mssql_num_rows($query_m5_2) > 0)
		{
			$tipo_variable		=	4;
			$sq_m21				=	"SELECT * FROM estatus_planta_reduccion_turno WHERE fecha = '$fecha_carga' AND turno = '$turno_carga' AND tipo_campo = '$tipo_variable'
									AND linea = '5'";
			$query_m21			=	mig_query($sq_m21, $db);
			if (pg_num_rows($query_m21) == 0)
			{
				while($res_m5_2 =	mssql_fetch_array($query_m5_2))
				{
					$sq_m15			=	"INSERT INTO estatus_planta_reduccion_turno (fecha, linea, turno, tipo_campo, num_celda, valor_variable) VALUES
										('$res_m5_2[DATE_IN]', '$res_m5_2[LINEA]', '$res_m5_2[ID_TURNO]', '$res_m5_2[tipo_campo]', '$res_m5_2[ID_CELL]', '$res_m5_2[valor_variable]');";
					$query_m15		=	mig_query($sq_m15, $db);
				}	
				echo "5.- Los datos de celdas LINEA 5 con nivel de baño >= 23 O nivel de baño <= 16 se han cargado correctamente <br>";
			}
			else
			{
				$sq_m31			=	"DELETE FROM estatus_planta_reduccion_turno WHERE fecha = '$fecha_carga' AND turno = '$turno_carga' AND tipo_campo = '$tipo_variable'
									AND linea = '5'";
				$query_m31		=	mig_query($sq_m31, $db);
				while($res_m5_2 =	mssql_fetch_array($query_m5_2))
				{
					$sq_m15			=	"INSERT INTO estatus_planta_reduccion_turno (fecha, linea, turno, tipo_campo, num_celda, valor_variable) VALUES
										('$res_m5_2[DATE_IN]', '$res_m5_2[LINEA]', '$res_m5_2[ID_TURNO]', '$res_m5_2[tipo_campo]', '$res_m5_2[ID_CELL]', '$res_m5_2[valor_variable]');";
					$query_m15		=	mig_query($sq_m15, $db);
				}	
				echo "5.1.- Se detectaron datos de celdas con nivel de baño >= 30 O nivel de baño <= 18 cargados previamente, se actualizaron a últimos datos. Se ha procesado correctamente la solicitud<br>";
			}
		}
		else
		{
			echo "No se encontraron Celdas LINEA 5 con nivel de baño >= 23 O nivel de baño <= 16 para el día y turno solicitado <br>";
		}
//////////////CELDAS CON %Fe >= 0.5 CELDAS P-19
		if (mssql_num_rows($query_m8_1) > 0)
		{
			$tipo_variable		=	8;
			$sq_m21				=	"SELECT * FROM estatus_planta_reduccion_turno WHERE fecha = '$fecha_carga' AND turno = '$turno_carga' AND tipo_campo = '$tipo_variable' AND LINEA <= '4'";
			$query_m21			=	mig_query($sq_m21, $db);
			if (pg_num_rows($query_m21) == 0)
			{
				while($res_m8_1 =	mssql_fetch_array($query_m8_1))
				{
					$sq_m15			=	"INSERT INTO estatus_planta_reduccion_turno (fecha, linea, turno, tipo_campo, num_celda, valor_variable) VALUES
										('$res_m8_1[DIA]', '$res_m8_1[LINEA]', '$res_m8_1[ID_TURNO]', '$res_m8_1[tipo_campo]', '$res_m8_1[ID_CELL]', '$res_m8_1[valor_variable]');";
					$query_m15		=	mig_query($sq_m15, $db);
					$sq_m15_2		=	"INSERT INTO estatus_planta_edad_celdas_alto_fe (fecha, num_celda, edad, linea) VALUES ('$res_m8_1[DIA]', '$res_m8_1[ID_CELL]', '$res_m8_1[EDAD]', '$res_m8_1[LINEA]')";
					$query_m15_2	=	mig_query($sq_m15_2, $db);
				}	
				echo "6.- Los datos de celdas con %Fe > 0.5 celdas P-19 se han cargado correctamente <br>";
			}
			else
			{
				$sq_m31			=	"DELETE FROM estatus_planta_reduccion_turno WHERE fecha = '$fecha_carga' AND turno = '$turno_carga' AND tipo_campo = '$tipo_variable' AND LINEA <= '4'";
				$query_m31		=	mig_query($sq_m31, $db);
				$sq_m31_2		=	"DELETE FROM estatus_planta_edad_celdas_alto_fe WHERE fecha = '$fecha_carga'  AND LINEA <= '4'";
				$query_m31_2	=	mig_query($sq_m31_2, $db);
				while($res_m8_1 =	mssql_fetch_array($query_m8_1))
				{
					$sq_m15			=	"INSERT INTO estatus_planta_reduccion_turno (fecha, linea, turno, tipo_campo, num_celda, valor_variable) VALUES
										('$res_m8_1[DIA]', '$res_m8_1[LINEA]', '$res_m8_1[ID_TURNO]', '$res_m8_1[tipo_campo]', '$res_m8_1[ID_CELL]', '$res_m8_1[valor_variable]');";
					$query_m15		=	mig_query($sq_m15, $db);
					$sq_m15_2		=	"INSERT INTO estatus_planta_edad_celdas_alto_fe (fecha, num_celda, edad, linea) VALUES ('$res_m8_1[DIA]', '$res_m8_1[ID_CELL]', '$res_m8_1[EDAD]', '$res_m8_1[LINEA]')";
					$query_m15_2	=	mig_query($sq_m15_2, $db);
				}	
				echo "6.1.- Se detectaron datos de celdas con %Fe > 0.5 celdas P-19 cargados previamente, se actualizaron a últimos datos. Se ha procesado correctamente la solicitud<br>";
			}
		}
		else
		{
			echo "No se encontraron Celdas con %Fe > 0.5 celdas P-19 para el día y turno solicitado <br>";
		}
//////////////CELDAS CON %Fe >= 0.3 CELDAS LINEA 5
		if (mssql_num_rows($query_m8_2) > 0)
		{
			$tipo_variable		=	8;
			$sq_m21				=	"SELECT * FROM estatus_planta_reduccion_turno WHERE fecha = '$fecha_carga' AND turno = '$turno_carga' AND tipo_campo = '$tipo_variable' AND LINEA = '5'";
			$query_m21			=	mig_query($sq_m21, $db);
			if (pg_num_rows($query_m21) == 0)
			{
				while($res_m8_2 =	mssql_fetch_array($query_m8_2))
				{
					$sq_m15			=	"INSERT INTO estatus_planta_reduccion_turno (fecha, linea, turno, tipo_campo, num_celda, valor_variable) VALUES
										('$res_m8_2[DIA]', '$res_m8_2[LINEA]', '$res_m8_2[ID_TURNO]', '$res_m8_2[tipo_campo]', '$res_m8_2[ID_CELL]', '$res_m8_2[valor_variable]');";
					$query_m15		=	mig_query($sq_m15, $db);
					$sq_m15_2		=	"INSERT INTO estatus_planta_edad_celdas_alto_fe (fecha, num_celda, edad, linea) VALUES ('$res_m8_2[DIA]', '$res_m8_2[ID_CELL]', '$res_m8_2[EDAD]', '$res_m8_2[LINEA]')";
					$query_m15_2	=	mig_query($sq_m15_2, $db);
				}	
				echo "6.- Los datos de celdas con %Fe > 0.3 celdas Linea 5 se han cargado correctamente <br>";
			}
			else
			{
				$sq_m31			=	"DELETE FROM estatus_planta_reduccion_turno WHERE fecha = '$fecha_carga' AND turno = '$turno_carga' AND tipo_campo = '$tipo_variable' AND LINEA = '5'";
				$query_m31		=	mig_query($sq_m31, $db);
				$sq_m31_2		=	"DELETE FROM estatus_planta_edad_celdas_alto_fe WHERE fecha = '$fecha_carga'  AND LINEA = '5'";
				$query_m31_2	=	mig_query($sq_m31_2, $db);
				while($res_m8_2 =	mssql_fetch_array($query_m8_2))
				{
					$sq_m15			=	"INSERT INTO estatus_planta_reduccion_turno (fecha, linea, turno, tipo_campo, num_celda, valor_variable) VALUES
										('$res_m8_2[DIA]', '$res_m8_2[LINEA]', '$res_m8_2[ID_TURNO]', '$res_m8_2[tipo_campo]', '$res_m8_2[ID_CELL]', '$res_m8_2[valor_variable]');";
					$query_m15		=	mig_query($sq_m15, $db);
					$sq_m15_2		=	"INSERT INTO estatus_planta_edad_celdas_alto_fe (fecha, num_celda, edad, linea) VALUES ('$res_m8_2[DIA]', '$res_m8_2[ID_CELL]', '$res_m8_2[EDAD]', '$res_m8_2[LINEA]')";
					$query_m15_2	=	mig_query($sq_m15_2, $db);
				}	
				echo "6.1.- Se detectaron datos de celdas con %Fe > 0.3 celdas linea 5 cargados previamente, se actualizaron a últimos datos. Se ha procesado correctamente la solicitud<br>";
			}
		}
		else
		{
			echo "No se encontraron Celdas con %Fe > 0.3 celdas linea 5  para el día y turno solicitado <br>";
		}
//////////////////////////ACIDEZ DE LAS CELDAS CON TEMPERATURA CRITICA , CAPTURADAS AL FINAL DEL DÍA EN T3
		if (mssql_num_rows($query_m10) > 0)
		{
			$db3					=	conectarse_aluminio20_dac();
			while($res_m10 		=	mssql_fetch_array($query_m10))
			{
				$sq_m10_2		=	"SELECT TOP 1 ACIDEZ, CONVERT(nvarchar, DATE_IN, 103) AS DATE_IN, ID_CELL,
									CASE WHEN ID_CELL > '100' AND ID_CELL < '300' THEN 1 ELSE 
									CASE WHEN  ID_CELL > '300' AND ID_CELL < '500' THEN 2 ELSE
									CASE WHEN  ID_CELL > '500' AND ID_CELL < '700' THEN 3 ELSE
									CASE WHEN  ID_CELL > '700' AND ID_CELL < '900' THEN 4  ELSE 5
									END END END END AS LINEA
									FROM V_A20_DHW_CELDAS_STA
									WHERE     (ID_CELL = '".$res_m10['ID_CELL']."') AND (ACIDEZ > 0) AND ID_TURNO = '3'
									ORDER BY CONVERT(datetime, DATE_IN, 103) DESC;";
				$query_m10_2	=	mig_query($sq_m10_2, $db1, 'mssql');
				$res_m10_2		=	mssql_fetch_array($query_m10_2);
				if (mssql_num_rows($query_m10_2) > 0)
				{
					$sq_m21			=	"SELECT * FROM estatus_planta_acidez_celdas WHERE fecha = '$res_m10_2[DATE_IN]' AND num_celda = '$res_m10_2[ID_CELL]';";
					$query_m21		=	mig_query($sq_m21, $db);
					if (pg_num_rows($query_m21) == 0)
					{
						$sq_m12		=	"INSERT INTO estatus_planta_acidez_celdas (fecha, num_celda, linea, acidez) VALUES 
										('$res_m10_2[DATE_IN]', '$res_m10_2[ID_CELL]', '$res_m10_2[LINEA]', $res_m10_2[ACIDEZ]);";
					}
					else
					{
						 $sq_m12		=	"UPDATE estatus_planta_acidez_celdas SET acidez = '$res_m10_2[ACIDEZ]' 
										WHERE fecha = '$res_m10_2[DATE_IN]' AND num_celda = '$res_m10_2[ID_CELL]';";
					}
					$query_m12		=	mig_query($sq_m12, $db);
				}
			}
			echo "10.- Los datos de acidez de celdas con mas de 1 EA se han cargado correctamente <br>";
			mssql_close($db3);
		}
////////////////////////////////////HASTA AQUÍ DATOS QUE SE CALCULAN EN T3 SOLAMENTE
////////////////////////////////////HASTA AQUÍ DATOS QUE SE CALCULAN EN T3 SOLAMENTE
////////////////////////////////////HASTA AQUÍ DATOS QUE SE CALCULAN EN T3 SOLAMENTE
	}
//////////////////CELDAS CON DESV RESISTENCIA >= 0.15
	if (mssql_num_rows($query_m2) > 0)
	{
		$tipo_variable		=	5;
		$sq_m21				=	"SELECT * FROM estatus_planta_reduccion_turno WHERE fecha = '$fecha_carga' AND turno = '$turno_carga' AND tipo_campo = '$tipo_variable'";
		$query_m21			=	mig_query($sq_m21, $db);
		if (pg_num_rows($query_m21) == 0)
		{
			while($res_m2 =	mssql_fetch_array($query_m2))
			{
				$sq_m12			=	"INSERT INTO estatus_planta_reduccion_turno (fecha, linea, turno, tipo_campo, num_celda, valor_variable) VALUES
									('$res_m2[DATE_IN]', '$res_m2[LINEA]', '$res_m2[ID_TURNO]', '$res_m2[tipo_campo]', '$res_m2[ID_CELL]', '$res_m2[valor_variable]');";
				$query_m12		=	mig_query($sq_m12, $db);
			}	
			echo "7.- Los datos de celdas con desviación de resistencia > 0.15 se han cargado correctamente <br>";
		}
		else
		{
			$sq_m31			=	"DELETE FROM estatus_planta_reduccion_turno WHERE fecha = '$fecha_carga' AND turno = '$turno_carga' AND tipo_campo = '$tipo_variable'";
			$query_m31		=	mig_query($sq_m31, $db);
			while($res_m2 =	mssql_fetch_array($query_m2))
			{
				$sq_m12			=	"INSERT INTO estatus_planta_reduccion_turno (fecha, linea, turno, tipo_campo, num_celda, valor_variable) VALUES
									('$res_m2[DATE_IN]', '$res_m2[LINEA]', '$res_m2[ID_TURNO]', '$res_m2[tipo_campo]', '$res_m2[ID_CELL]', '$res_m2[valor_variable]');";
				$query_m12		=	mig_query($sq_m12, $db);
			}	
			echo "7.1.- Se detectaron datos de celdas con desviación de resistencia > 0.15 cargados previamente, se actualizaron a últimos datos. Se ha procesado correctamente la solicitud<br>";
		}
	}
	else
	{
		echo "No se encontraron Celdas con desviación de resistencia > 0.15 para el día y turno solicitado <br>";
	}
////////////CELDAS CON MAS DE 1 LUZ EN EL TURNO 
	if (mssql_num_rows($query_m3) > 0)
	{
		$tipo_variable		=	2;
		$sq_m21				=	"SELECT * FROM estatus_planta_reduccion_turno WHERE fecha = '$fecha_carga' AND turno = '$turno_carga' AND tipo_campo = '$tipo_variable'";
		$query_m21			=	mig_query($sq_m21, $db);
		if (pg_num_rows($query_m21) == 0)
		{
			while($res_m3 =	mssql_fetch_array($query_m3))
			{
				$sq_m13			=	"INSERT INTO estatus_planta_reduccion_turno (fecha, linea, turno, tipo_campo, num_celda, valor_variable) VALUES
									('$res_m3[DATE_IN]', '$res_m3[LINEA]', '$res_m3[ID_TURNO]', '$res_m3[tipo_campo]', '$res_m3[ID_CELL]', '$res_m3[valor_variable]');";
				$query_m13		=	mig_query($sq_m13, $db);
			}	
			echo "8.- Los datos de celdas con mas de 1 EA se han cargado correctamente <br>";
		}
		else
		{
			$sq_m31			=	"DELETE FROM estatus_planta_reduccion_turno WHERE fecha = '$fecha_carga' AND turno = '$turno_carga' AND tipo_campo = '$tipo_variable'";
			$query_m31		=	mig_query($sq_m31, $db);
			while($res_m3 =	mssql_fetch_array($query_m3))
			{
				$sq_m13			=	"INSERT INTO estatus_planta_reduccion_turno (fecha, linea, turno, tipo_campo, num_celda, valor_variable) VALUES
									('$res_m3[DATE_IN]', '$res_m3[LINEA]', '$res_m3[ID_TURNO]', '$res_m3[tipo_campo]', '$res_m3[ID_CELL]', '$res_m3[valor_variable]');";
				$query_m13		=	mig_query($sq_m13, $db);
			}	
			echo "8.1.- Se detectaron datos de celdas con mas de 1 EA cargados previamente, se actualizaron a últimos datos. Se ha procesado correctamente la solicitud<br>";
		}
	}
	else
	{
		echo "No se encontraron Celdas con mas de 1 EA para el día y turno solicitado <br>";
	}
////////////PRESION DE AIRE PRESION PRINCIPAL 
	$tipo_variable		=	6;
	$sq_m21				=	"SELECT * FROM estatus_planta_reduccion_turno WHERE fecha = '$fecha_carga' AND turno = '$turno_carga' AND tipo_campo = '$tipo_variable'";
	$query_m21			=	mig_query($sq_m21, $db);
	if (pg_num_rows($query_m21) == 0)
	{
		if (mssql_num_rows($query_m6_1) > 0)
		{
			$res_m6_1 		=	mssql_fetch_array($query_m6_1);
			$sq_m16_1		=	"INSERT INTO estatus_planta_reduccion_turno (fecha, linea, turno, tipo_campo, num_celda, valor_variable) VALUES
								('$res_m6_1[DATE_IN]', '$res_m6_1[LINEA]', '$res_m6_1[ID_TURNO]', '$res_m6_1[tipo_campo]', '$res_m6_1[ID_CELL]', '$res_m6_1[valor_variable]');";
			$query_m15_1	=	mig_query($sq_m16_1, $db);
		}
		else
		{
			echo "No se encontró datos de presión de Aire de C1 para el día y turno solicitado <br>";
		}
		if (mssql_num_rows($query_m6_2) > 0)
		{
			$res_m6_2 		=	mssql_fetch_array($query_m6_2);
			$sq_m16_2		=	"INSERT INTO estatus_planta_reduccion_turno (fecha, linea, turno, tipo_campo, num_celda, valor_variable) VALUES
								('$res_m6_2[DATE_IN]', '$res_m6_2[LINEA]', '$res_m6_2[ID_TURNO]', '$res_m6_2[tipo_campo]', '$res_m6_2[ID_CELL]', '$res_m6_2[valor_variable]');";
			$query_m15_2	=	mig_query($sq_m16_2, $db);
		}
		else
		{
			echo "No se encontró datos de presión de Aire de C2 para el día y turno solicitado <br>";
		}
		if (mssql_num_rows($query_m6_3) > 0)
		{
			$res_m6_3 		=	mssql_fetch_array($query_m6_3);
			$sq_m16_3		=	"INSERT INTO estatus_planta_reduccion_turno (fecha, linea, turno, tipo_campo, num_celda, valor_variable) VALUES
								('$res_m6_3[DATE_IN]', '$res_m6_3[LINEA]', '$res_m6_3[ID_TURNO]', '$res_m6_3[tipo_campo]', '$res_m6_3[ID_CELL]', '$res_m6_3[valor_variable]');";
			$query_m15_3	=	mig_query($sq_m16_3, $db);
		}
		else
		{
			echo "No se encontró datos de presión de Aire de VL para el día y turno solicitado <br>";
		}
		echo "Los datos de presión de aire se han cargado correctamente <br>";
	}
	else
	{
		if (mssql_num_rows($query_m6_1) > 0)
		{
			$res_m6_1 		=	mssql_fetch_array($query_m6_1);
			$sq_m31			=	"DELETE FROM estatus_planta_reduccion_turno WHERE fecha = '$fecha_carga' AND turno = '$turno_carga' AND tipo_campo = '$tipo_variable'
								AND linea = '$res_m6_1[LINEA]'";
			$query_m31		=	mig_query($sq_m31, $db);
			$sq_m16_1		=	"INSERT INTO estatus_planta_reduccion_turno (fecha, linea, turno, tipo_campo, num_celda, valor_variable) VALUES
								('$res_m6_1[DATE_IN]', '$res_m6_1[LINEA]', '$res_m6_1[ID_TURNO]', '$res_m6_1[tipo_campo]', '$res_m6_1[ID_CELL]', '$res_m6_1[valor_variable]');";

			$query_m15_1	=	mig_query($sq_m16_1, $db);
		}
		else
		{
			echo "No se encontró datos de presión de Aire de C1 para el día y turno solicitado <br>";
		}
		if (mssql_num_rows($query_m6_2) > 0)
		{
			$res_m6_2 		=	mssql_fetch_array($query_m6_2);
 		$sq_m31			=	"DELETE FROM estatus_planta_reduccion_turno WHERE fecha = '$fecha_carga' AND turno = '$turno_carga' AND tipo_campo = '$tipo_variable'
								AND linea = '$res_m6_2[LINEA]'";
			$query_m31		=	mig_query($sq_m31, $db);
 			$sq_m16_2		=	"INSERT INTO estatus_planta_reduccion_turno (fecha, linea, turno, tipo_campo, num_celda, valor_variable) VALUES
								('$res_m6_2[DATE_IN]', '$res_m6_2[LINEA]', '$res_m6_2[ID_TURNO]', '$res_m6_2[tipo_campo]', '$res_m6_2[ID_CELL]', '$res_m6_2[valor_variable]');";
			$query_m15_2	=	mig_query($sq_m16_2, $db);
		}
		else
		{
			echo "No se encontró datos de presión de Aire de C2 para el día y turno solicitado <br>";
		}
		if (mssql_num_rows($query_m6_3) > 0)
		{
			$res_m6_3 		=	mssql_fetch_array($query_m6_3);
			$sq_m31			=	"DELETE FROM estatus_planta_reduccion_turno WHERE fecha = '$fecha_carga' AND turno = '$turno_carga' AND tipo_campo = '$tipo_variable'
								AND linea = '$res_m6_3[LINEA]'";
			$query_m31		=	mig_query($sq_m31, $db);
 			$sq_m16_3		=	"INSERT INTO estatus_planta_reduccion_turno (fecha, linea, turno, tipo_campo, num_celda, valor_variable) VALUES
								('$res_m6_3[DATE_IN]', '$res_m6_3[LINEA]', '$res_m6_3[ID_TURNO]', '$res_m6_3[tipo_campo]', '$res_m6_3[ID_CELL]', '$res_m6_3[valor_variable]');";
			$query_m15_3	=	mig_query($sq_m16_3, $db);
		}
		else
		{
			echo "No se encontró datos de presión de Aire de VL para el día y turno solicitado <br>";
		}
		echo "Se detectaron datos presión de aire cargados previamente, se actualizaron a últimos datos. Se ha procesado correctamente la solicitud<br>";
	}
////////////PRESION DE AIRE PRESION FACILIDAD 18 
	$tipo_variable		=	9;
	$sq_m21				=	"SELECT * FROM estatus_planta_reduccion_turno WHERE fecha = '$fecha_carga' AND turno = '$turno_carga' AND tipo_campo = '$tipo_variable'";
	$query_m21			=	mig_query($sq_m21, $db);
	if (pg_num_rows($query_m21) == 0)
	{
		if (mssql_num_rows($query_m9_1) > 0)
		{
			$res_m9_1 		=	mssql_fetch_array($query_m9_1);
			$sq_m16_1		=	"INSERT INTO estatus_planta_reduccion_turno (fecha, linea, turno, tipo_campo, num_celda, valor_variable) VALUES
								('$res_m9_1[DATE_IN]', '$res_m9_1[LINEA]', '$res_m9_1[ID_TURNO]', '$res_m9_1[tipo_campo]', '$res_m9_1[ID_CELL]', '$res_m9_1[valor_variable]');";
			$query_m15_1	=	mig_query($sq_m16_1, $db);
		}
		else
		{
			echo "-----No se encontró datos de presión de Aire de C1 para el día y turno solicitado <br>";
		}
		if (mssql_num_rows($query_m9_2) > 0)
		{
			$res_m9_2 		=	mssql_fetch_array($query_m9_2);
			$sq_m16_2		=	"INSERT INTO estatus_planta_reduccion_turno (fecha, linea, turno, tipo_campo, num_celda, valor_variable) VALUES
								('$res_m9_2[DATE_IN]', '$res_m9_2[LINEA]', '$res_m9_2[ID_TURNO]', '$res_m9_2[tipo_campo]', '$res_m9_2[ID_CELL]', '$res_m9_2[valor_variable]');";
			$query_m15_2	=	mig_query($sq_m16_2, $db);
		}
		else
		{
			echo "-----No se encontró datos de presión de Aire de C2 para el día y turno solicitado <br>";
		}
		echo "-----Los datos de presión de aire se han cargado correctamente <br>";
	}
	else
	{
		if (mssql_num_rows($query_m9_1) > 0)
		{
			$res_m9_1 		=	mssql_fetch_array($query_m9_1);
			$sq_m31			=	"DELETE FROM estatus_planta_reduccion_turno WHERE fecha = '$fecha_carga' AND turno = '$turno_carga' AND tipo_campo = '$tipo_variable'
								AND linea = '$res_m9_1[LINEA]'";
			$query_m31		=	mig_query($sq_m31, $db);
			$sq_m16_1		=	"INSERT INTO estatus_planta_reduccion_turno (fecha, linea, turno, tipo_campo, num_celda, valor_variable) VALUES
								('$res_m9_1[DATE_IN]', '$res_m9_1[LINEA]', '$res_m9_1[ID_TURNO]', '$res_m9_1[tipo_campo]', '$res_m9_1[ID_CELL]', '$res_m9_1[valor_variable]');";
			$query_m15_1	=	mig_query($sq_m16_1, $db);
		}
		else
		{
			echo "-----No se encontró datos de presión de Aire de C1 para el día y turno solicitado <br>";
		}
		if (mssql_num_rows($query_m9_2) > 0)
		{
			$res_m9_2 		=	mssql_fetch_array($query_m9_2);
 		$sq_m31			=	"DELETE FROM estatus_planta_reduccion_turno WHERE fecha = '$fecha_carga' AND turno = '$turno_carga' AND tipo_campo = '$tipo_variable'
								AND linea = '$res_m9_2[LINEA]'";
			$query_m31		=	mig_query($sq_m31, $db);
 			$sq_m16_2		=	"INSERT INTO estatus_planta_reduccion_turno (fecha, linea, turno, tipo_campo, num_celda, valor_variable) VALUES
								('$res_m9_2[DATE_IN]', '$res_m9_2[LINEA]', '$res_m9_2[ID_TURNO]', '$res_m9_2[tipo_campo]', '$res_m9_2[ID_CELL]', '$res_m9_2[valor_variable]');";
			$query_m15_2	=	mig_query($sq_m16_2, $db);
		}
		else
		{
			echo "-----No se encontró datos de presión de Aire de C2 para el día y turno solicitado <br>";
		}
		echo "-----Se detectaron datos presión de aire cargados previamente, se actualizaron a últimos datos. Se ha procesado correctamente la solicitud<br>";
	}
//////////////ANODOS SUMINISTRADOS A REDUCCION
	if ($num_filas1 > 0)
	{
		$tipo_variable		=	7;
		$sq_m21				=	"SELECT * FROM estatus_planta_reduccion_turno WHERE fecha = '$fecha_carga' AND turno = '$turno_carga' AND tipo_campo = '$tipo_variable'";
		$query_m21			=	mig_query($sq_m21, $db);
		if (pg_num_rows($query_m21) == 0)
		{
			while (ocifetch($query_m7, OCI_ASSOC))
			{
				$sq_m17			=	"INSERT INTO estatus_planta_reduccion_turno (fecha, linea, turno, tipo_campo, num_celda, valor_variable) VALUES
									('$DATE_IN', '$LINEA', '$ID_TURNO', '$TIPO_CAMPO', '$ID_CELL', '$VALOR_VARIABLE');";
				$query_m17		=	mig_query($sq_m17, $db);
			}
			echo "Los datos de anodos suministrados a celdas se han cargado correctamente <br>";
		}
		else
		{
			$sq_m31			=	"DELETE FROM estatus_planta_reduccion_turno WHERE fecha = '$fecha_carga' AND turno = '$turno_carga' AND tipo_campo = '$tipo_variable'";
			$query_m31		=	mig_query($sq_m31, $db);
			while (ocifetch($query_m7, OCI_ASSOC))
			{
				$sq_m17			=	"INSERT INTO estatus_planta_reduccion_turno (fecha, linea, turno, tipo_campo, num_celda, valor_variable) VALUES
									('$DATE_IN', '$LINEA', '$ID_TURNO', '$TIPO_CAMPO', '$ID_CELL', '$VALOR_VARIABLE');";
				$query_m17		=	mig_query($sq_m17, $db);
			}
			echo "Se detectaron datos de anodos suministrados a celdas cargados previamente, se actualizaron a últimos datos. Se ha procesado correctamente la solicitud<br>";
		}
	}
	else
	{
		echo "No se encontraron datos de anodos suministrados a celdas para el día y turno solicitado <br>";
	}
//////////////
	pg_close($db);
	ocilogoff($db_oracle);

///////////////IMPLEMENTAR MODIFICACIÓN PARA QUE TOME LOS VALORES DIRECTAMENTE DE LABORATORIO/////////
/*
		///CELDAS CON %Fe >= 0.5    PARA P-19
		$tipo_variable		=	8;
		$sq_m8_1			=	"SELECT CONVERT(NVARCHAR, V_A20_DHW_CELDAS_STA.DATE_IN, 103) AS DIA, V_A20_DHW_CELDAS_STA.ID_CELL, V_A20_DHW_CELDAS_STA.EDAD_CELDA AS EDAD, 
										VCELDAST_1.fe AS valor_variable, CASE WHEN ID_CELL > '100' AND ID_CELL < '300' THEN 1 ELSE CASE WHEN ID_CELL > '300' AND 
										ID_CELL < '500' THEN 2 ELSE CASE WHEN ID_CELL > '500' AND ID_CELL < '700' THEN 3 ELSE CASE WHEN ID_CELL > '700' AND 
										ID_CELL < '900' THEN 4 END END END END AS LINEA, 3 AS ID_TURNO, $tipo_variable AS tipo_campo
								FROM  VCELDAST_ESTATUS_PLANTA VCELDAST_1 INNER JOIN
									  V_A20_DHW_CELDAS_STA ON VCELDAST_1.fecha = V_A20_DHW_CELDAS_STA.DATE_IN AND 
									  VCELDAST_1.n0celda = V_A20_DHW_CELDAS_STA.ID_CELL
								WHERE (CONVERT(NVARCHAR, V_A20_DHW_CELDAS_STA.DATE_IN, 103) = '$fecha_carga') AND (VCELDAST_1.fe >= '0.5') AND 
									  (V_A20_DHW_CELDAS_STA.ID_CELL < '900') AND (V_A20_DHW_CELDAS_STA.ID_TURNO = '3')
								ORDER BY V_A20_DHW_CELDAS_STA.ID_CELL";

		///CELDAS CON %Fe >= 0.3    PARA LINEA 5
		$tipo_variable		=	8;
		$sq_m8_2			=	"SELECT     CONVERT(NVARCHAR, V_A20_DHW_CELDAS_STA.DATE_IN, 103) AS DIA, V_A20_DHW_CELDAS_STA.ID_CELL, V_A20_DHW_CELDAS_STA.EDAD_CELDA AS EDAD, VCELDAST_1.fe AS valor_variable, 
											5 AS LINEA, 3 AS ID_TURNO, $tipo_variable AS tipo_campo
								FROM          VCELDAST_ESTATUS_PLANTA VCELDAST_1 INNER JOIN
													  V_A20_DHW_CELDAS_STA ON VCELDAST_1.fecha = V_A20_DHW_CELDAS_STA.DATE_IN AND 
													  VCELDAST_1.n0celda = V_A20_DHW_CELDAS_STA.ID_CELL
								WHERE     (CONVERT(NVARCHAR, V_A20_DHW_CELDAS_STA.DATE_IN, 103) = '$fecha_carga') AND (V_A20_DHW_CELDAS_STA.ID_CELL > '900') AND 
													  (VCELDAST_1.fe >= 0.3) AND (V_A20_DHW_CELDAS_STA.ID_TURNO = 3)
								ORDER BY V_A20_DHW_CELDAS_STA.ID_CELL";  
	*/

/////////////////////////
?>