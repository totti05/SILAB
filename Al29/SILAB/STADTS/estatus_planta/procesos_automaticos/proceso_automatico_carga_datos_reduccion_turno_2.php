<?php
	include 'conectarse.php';
	$turno_carga					=	2;
	$db								=	conectarse_postgres();

	$sq_m0							=	"SELECT current_date AS fecha";
	$query_m0						=	mig_query($sq_m0, $db);	
	$res_m0							=	pg_fetch_array($query_m0);
	
	$fecha_hoy						=	$res_m0['fecha'];
	list($a, $m, $d)				=	split('-', $fecha_hoy);
 	$fecha							=	"$d/$m/$a";
	$fecha_carga					=	$fecha;
	
	list($dia, $mes, $año)			=	split('/', $fecha);
	$fec = "$mes/$dia/$año";

	$mes_busc						=	date('M', strtotime($fec));
	$mes_reporte					=	$mes;		
	$ano_reporte					=	$año;
	$fecha_carga2					=	"$dia-$mes_busc-$año";

	$sq_m20						=	"SELECT '$fecha_carga2'::date + 1 AS fecha_programado_celdas";
	$query_m20					=	mig_query($sq_m20, $db);
	$res_m20					=	pg_fetch_array($query_m20);
	$fecha_prog					=	$res_m20['fecha_programado_celdas'];

	list($año2, $mes2, $dia2)	=	split('-', $fecha_prog);
	$fec2 						= 	"$mes2/$dia2/$año2";
	$mes_busc2					=	date('M', strtotime($fec2));
	$fecha_programado_celdas	=	"$dia2-$mes_busc2-$año2";

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
	
	/// CRISOLES ASIGNADOS POR LINEA
	$tipo_variable		=	11;
	$sq_m22				=	"SELECT     FECHA AS DATE_IN, TURNO AS ID_TURNO, COD_AREA, COD01 AS COD1, COD02 AS COD2, COD03 AS COD3, COD04 AS COD4, COD05 AS COD5, 
								COD06 AS COD6, COD07 AS COD7, COD08 AS COD8, COD09 AS COD9, COD10, COD11, 
                      			COD12, COD13, COD14, COD15, 11 AS TIPO_CAMPO, CASE WHEN COD_AREA = 'L1' THEN 1 ELSE CASE WHEN COD_AREA = 'L2' THEN 2 ELSE 
								CASE WHEN COD_AREA = 'L3' THEN 3 ELSE CASE WHEN COD_AREA = 'L4' THEN 4 ELSE 5 END END END END AS LINEA, 
                      			CASE WHEN COD_AREA = 'L1' THEN 191 ELSE CASE WHEN COD_AREA = 'L2' THEN 391 ELSE CASE WHEN COD_AREA = 'L3' THEN 591 ELSE CASE WHEN
                       			COD_AREA = 'L4' THEN 791 ELSE 991 END END END END AS ID_CELL
							FROM         PEXPCR.ASIGNACION_EQUIPOS
							WHERE (FECHA = '$fecha_carga2') AND (TURNO = '$turno_carga') AND (COD_AREA = 'L1' OR
												  COD_AREA = 'L2' OR
												  COD_AREA = 'L3' OR
												  COD_AREA = 'L4' OR
												  COD_AREA = 'L5') ORDER BY COD_AREA";

	////// CELDAS CON TOLVAS BLOQUEADAS
	$tipo_variable		=	13;
	$sq_m30_1			=	"SELECT  '$fecha_carga' AS DATE_IN, celda AS ID_CELL, 1 AS LINEA, $turno_carga AS ID_TURNO, 
								$tipo_variable AS tipo_campo,  CONVERT(CHAR(1), al1) + '' + CONVERT(CHAR(1), al2) + '' + CONVERT(CHAR(1), al3) + '' 
								+ CONVERT(CHAR(1), al4) + '' + CONVERT(CHAR(1), alF1) AS valor_variable FROM V_AL20_DHW_FORANEOS_ALIMENTADORES_B_L1";
	$sq_m30_2			=	"SELECT  '$fecha_carga' AS DATE_IN, celda AS ID_CELL, 2 AS LINEA, $turno_carga AS ID_TURNO, 
								$tipo_variable AS tipo_campo,  CONVERT(CHAR(1), al1) + '' + CONVERT(CHAR(1), al2) + '' + CONVERT(CHAR(1), al3) + '' 
								+ CONVERT(CHAR(1), al4) + '' + CONVERT(CHAR(1), alF1) AS valor_variable FROM V_AL20_DHW_FORANEOS_ALIMENTADORES_B_L2";
	$sq_m30_3			=	"SELECT  '$fecha_carga' AS DATE_IN, celda AS ID_CELL, 3 AS LINEA, $turno_carga AS ID_TURNO, 
								$tipo_variable AS tipo_campo,  CONVERT(CHAR(1), al1) + '' + CONVERT(CHAR(1), al2) + '' + CONVERT(CHAR(1), al3) + '' 
								+ CONVERT(CHAR(1), al4) + '' + CONVERT(CHAR(1), alFl) AS valor_variable FROM V_AL20_DHW_FORANEOS_ALIMENTADORES_B_L3";
	$sq_m30_4			=	"SELECT  '$fecha_carga' AS DATE_IN, celda AS ID_CELL, 4 AS LINEA, $turno_carga AS ID_TURNO, 
								$tipo_variable AS tipo_campo,  CONVERT(CHAR(1), al1) + '' + CONVERT(CHAR(1), al2) + '' + CONVERT(CHAR(1), al3) + '' 
								+ CONVERT(CHAR(1), al4) + '' + CONVERT(CHAR(1), alF1) AS valor_variable FROM V_AL20_DHW_FORANEOS_ALIMENTADORES_B_L4";
	$sq_m30_5			=	"SELECT  '$fecha_carga' AS DATE_IN, celda AS ID_CELL, 5 AS LINEA, $turno_carga AS ID_TURNO, 
								$tipo_variable AS tipo_campo,  CONVERT(CHAR(1), al1) + '' + CONVERT(CHAR(1), al2) + '' + CONVERT(CHAR(1), al3) + '' 
								+ CONVERT(CHAR(1), al4) + '' + CONVERT(CHAR(1), al5) + '' + CONVERT(CHAR(1), alF1) AS valor_variable FROM V_AL20_DHW_FORANEOS_ALIMENTADORES_B_L5";


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
		/*$sq_m8_1			=	"SELECT DISTINCT CONVERT(nvarchar, DIA, 103) AS DIA, EDAD,
								CASE WHEN CELDA > '100' AND CELDA < '300' THEN 1 ELSE 
								CASE WHEN  CELDA > '300' AND CELDA < '500' THEN 2 ELSE
								CASE WHEN  CELDA > '500' AND CELDA < '700' THEN 3 ELSE
								CASE WHEN  CELDA > '700' AND CELDA < '900' THEN 4  
								END END END END AS LINEA, 
								3 AS ID_TURNO, $tipo_variable AS tipo_campo, CELDA AS ID_CELL, FE AS valor_variable
								FROM DATA_FINAL_SIN_ERRORES1
								WHERE      FE >= '0.5' AND DIA = '$fecha_carga' AND CELDA < '900'
								ORDER BY DIA, CELDA, ID_TURNO;";*/
		$sq_m8_1			=	"SELECT	DISTINCT CONVERT(nvarchar, DIA, 103) AS DIA, CONVERT(integer, ID_CELL2) AS ID_CELL, valor_variable, LINEA, CASE WHEN edad > 0 THEN CONVERT(integer, edad) ELSE
										(SELECT 	CONVERT(integer, EDAD_CELDA) AS EDAD_CELDA
										 FROM	V_A20_DHW_CELDAS_STA
										 WHERE 	V_A20_DHW_CELDAS_STA.DATE_IN = '$fecha_carga' AND V_A20_DHW_CELDAS_STA.ID_TURNO = '1' AND  V_A20_DHW_CELDAS_STA.ID_CELL = ID_CELL2) END AS EDAD,
										 $tipo_variable AS tipo_campo, 3 AS ID_TURNO
								FROM         
											(SELECT fecha AS DIA, n0celda AS ID_CELL2, edad, CASE WHEN fe_lab > 0 THEN fe_lab ELSE fe_ivc END AS valor_variable, 
												CASE WHEN n0celda > '100' AND n0celda < '300' THEN 1 ELSE CASE WHEN n0celda > '300' AND 
												n0celda < '500' THEN 2 ELSE CASE WHEN n0celda > '500' AND n0celda < '700' THEN 3 ELSE CASE WHEN n0celda > '700' AND 
												n0celda < '900' THEN 4 END END END END AS LINEA
										FROM          
												(SELECT	fecha, n0celda, SUM(edad) AS edad, SUM(fe_ivc) AS fe_ivc, SUM(fe_lab) AS fe_lab
												 FROM
														(SELECT 	fecha, n0celda, edad, CASE WHEN control = 1 THEN fe ELSE 0 END AS fe_ivc, CASE WHEN control = 0 THEN fe ELSE 0 END AS fe_lab
														 FROM          
																(SELECT	DIA AS fecha, CELDA AS n0celda, fe, edad, 1 AS control
																 FROM 	DATA_FINAL_SIN_ERRORES1
																 WHERE      (CONVERT(nvarchar, DIA, 103) = '$fecha_carga')
																 UNION ALL
																 SELECT	TOP 100 PERCENT fecha, n0celda, CASE WHEN fe_t3 > 0 THEN fe_t3 ELSE CASE WHEN fe_t2 > 0 THEN fe_t2 ELSE fe_t1 END END AS fe_dia_celda,
																	 0 AS edad, 0 AS control
																 FROM         
																		(SELECT	fecha, n0celda, SUM(fe1) AS fe_t3, SUM(fe2) AS fe_t2, SUM(fe3) AS fe_t1
																		 FROM
																				(SELECT	fecha, turno, n0celda, AVG(fe) AS porcent_Fe, CASE WHEN turno = 3 THEN AVG(fe) ELSE 0 END AS fe1, CASE WHEN turno = 2 THEN AVG(fe) ELSE 0 END AS fe2, 
																					CASE WHEN turno = 1 THEN AVG(fe) ELSE 0 END AS fe3
																				 FROM          
																						(SELECT	fecha, turno, n0celda, fe FROM [ALUMINIO20 SCP SILABM].SILABM.dbo.anch_ang WHERE (CONVERT(nvarchar, fecha, 103) = '$fecha_carga')
																						UNION ALL
																						SELECT     fecha, turno, n0celda, fe  FROM [ALUMINIO20 SCP SILABM].SILABM.dbo.celdast WHERE (CONVERT(nvarchar, fecha, 103) = '$fecha_carga')
																						 ) DERIVEDTBL
																				 GROUP BY fecha, turno, n0celda
																				 ) DERIVEDTBL
																		GROUP BY fecha, n0celda
																		) DERIVEDTBL
																) DERIVEDTBL
														) DERIVEDTBL
												GROUP BY fecha, n0celda
												) DERIVEDTBL
										WHERE      (n0celda < 900)
										) DERIVEDTBL
								WHERE     (valor_variable >= '0.5')
								ORDER BY CONVERT(integer, ID_CELL2);";

		///CELDAS CON %Fe >= 0.5    PARA LINEA 5
		$tipo_variable		=	8;
		/*$sq_m8_2			=	"SELECT DISTINCT CONVERT(nvarchar, DIA, 103) AS DIA, EDAD,
								 5 AS LINEA, 
								3 AS ID_TURNO, $tipo_variable AS tipo_campo, CELDA AS ID_CELL, FE AS valor_variable
								FROM DATA_FINAL_SIN_ERRORES1
								WHERE      FE >= '0.3' AND DIA = '$fecha_carga' AND CELDA > '900'
								ORDER BY DIA, CELDA, ID_TURNO;";  */

		$sq_m8_2			=	"SELECT	DISTINCT CONVERT(nvarchar, DIA, 103) AS DIA, CONVERT(integer, ID_CELL2) AS ID_CELL, valor_variable, LINEA, CASE WHEN edad > 0 THEN CONVERT(integer, edad) ELSE
										(SELECT 	CONVERT(integer, EDAD_CELDA) AS EDAD_CELDA
										 FROM	V_A20_DHW_CELDAS_STA
										 WHERE 	V_A20_DHW_CELDAS_STA.DATE_IN = '$fecha_carga' AND V_A20_DHW_CELDAS_STA.ID_TURNO = '1' AND  V_A20_DHW_CELDAS_STA.ID_CELL = ID_CELL2) END AS EDAD,
										 $tipo_variable AS tipo_campo, 3 AS ID_TURNO
								FROM         
											(SELECT fecha AS DIA, n0celda AS ID_CELL2, edad, CASE WHEN fe_lab > 0 THEN fe_lab ELSE fe_ivc END AS valor_variable, 
												5 AS LINEA
										FROM          
												(SELECT	fecha, n0celda, SUM(edad) AS edad, SUM(fe_ivc) AS fe_ivc, SUM(fe_lab) AS fe_lab
												 FROM
														(SELECT 	fecha, n0celda, edad, CASE WHEN control = 1 THEN fe ELSE 0 END AS fe_ivc, CASE WHEN control = 0 THEN fe ELSE 0 END AS fe_lab
														 FROM          
																(SELECT	DIA AS fecha, CELDA AS n0celda, fe, edad, 1 AS control
																 FROM 	DATA_FINAL_SIN_ERRORES1
																 WHERE      (CONVERT(nvarchar, DIA, 103) = '$fecha_carga')
																 UNION ALL
																 SELECT	TOP 100 PERCENT fecha, n0celda, CASE WHEN fe_t3 > 0 THEN fe_t3 ELSE CASE WHEN fe_t2 > 0 THEN fe_t2 ELSE fe_t1 END END AS fe_dia_celda,
																	 0 AS edad, 0 AS control
																 FROM         
																		(SELECT	fecha, n0celda, SUM(fe1) AS fe_t3, SUM(fe2) AS fe_t2, SUM(fe3) AS fe_t1
																		 FROM
																				(SELECT	fecha, turno, n0celda, AVG(fe) AS porcent_Fe, CASE WHEN turno = 3 THEN AVG(fe) ELSE 0 END AS fe1, CASE WHEN turno = 2 THEN AVG(fe) ELSE 0 END AS fe2, 
																					CASE WHEN turno = 1 THEN AVG(fe) ELSE 0 END AS fe3
																				 FROM          
																						(SELECT	fecha, turno, n0celda, fe FROM [ALUMINIO20 SCP SILABM].SILABM.dbo.anch_ang WHERE (CONVERT(nvarchar, fecha, 103) = '$fecha_carga')
																						UNION ALL
																						SELECT     fecha, turno, n0celda, fe  FROM [ALUMINIO20 SCP SILABM].SILABM.dbo.celdast WHERE (CONVERT(nvarchar, fecha, 103) = '$fecha_carga')
																						 ) DERIVEDTBL
																				 GROUP BY fecha, turno, n0celda
																				 ) DERIVEDTBL
																		GROUP BY fecha, n0celda
																		) DERIVEDTBL
																) DERIVEDTBL
														) DERIVEDTBL
												GROUP BY fecha, n0celda
												) DERIVEDTBL
										WHERE      (n0celda > 900)
										) DERIVEDTBL
								WHERE     (valor_variable >= '0.3')
								ORDER BY CONVERT(integer, ID_CELL2);";
		
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


		///CELDAS >= 2 LUZ EN EL DIA 
		$tipo_variable		=	12;
		$sq_m23				=	"SELECT DISTINCT CONVERT(nvarchar, DATE_IN, 103) AS DATE_IN,LINEA, ID_TURNO, $tipo_variable AS tipo_campo, ID_CELL, (LUZ_T1 + LUZ_T2 + LUZ_T3) AS valor_variable
								FROM          V_A20_DHW_CELDAS_STA
								WHERE      (LUZ_T1 + LUZ_T2 + LUZ_T3) > '1' AND DATE_IN = '$fecha_carga' AND  ID_TURNO = '$turno_carga'
								ORDER BY DATE_IN, ID_CELL, ID_TURNO;";

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
		$query_m23		=	mig_query($sq_m23, $db1, 'mssql');
	}

	$query_m2			=	mig_query($sq_m2, $db1, 'mssql');
	$query_m3			=	mig_query($sq_m3, $db1, 'mssql');
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

/////////////// EJECUCION DEL LOS QUERY DE LOS DATOS QUE SALEN DE CRISOLES  (CRISOLES ASIGNADOS POR LINEA)
	$query_m22 			= 	ociparse($db_oracle, $sq_m22);
	$query_m222			= 	ociparse($db_oracle, $sq_m22);
	ocidefinebyname($query_m22, 'FECHA', $DATE_IN);
	ocidefinebyname($query_m22, 'LINEA', $LINEA);
	ocidefinebyname($query_m22, 'TURNO', $ID_TURNO);
	ocidefinebyname($query_m22, 'COD_AREA', $COD_AREA);
	ocidefinebyname($query_m22, 'TIPO_CAMPO', $TIPO_CAMPO);
	ocidefinebyname($query_m22, 'ID_CELL', $ID_CELL);
	$n = 1;
	while ($n <= 15)
	{
		ocidefinebyname($query_m22, "COD$n", $COD[$n]);
		$n++;
	}
	ociexecute($query_m22);
	ociexecute($query_m222);
	ocifetchstatement($query_m222,$tab_result);  // the result will be fetched in the table $tab_result
	$num_filas2			=	ocirowcount($query_m222);

/////////////EJECUCIÓN DE LOS QUERY DE DATOS DE TOLVAS BLOQUEADAS //////////////////////////////////////
	$db3					=	conectarse_aluminio20_foraneos();
	$sq_nulls_1				=	"SET ANSI_NULLS ON";
	$sq_nulls_2				=	"SET ANSI_WARNINGS ON";
	mssql_query($sq_nulls_1, $db3);
	mssql_query($sq_nulls_2, $db3);
	$query_m30_1			=	mig_query($sq_m30_1, $db3, 'mssql');
	$query_m30_2			=	mig_query($sq_m30_2, $db3, 'mssql');
	$query_m30_3			=	mig_query($sq_m30_3, $db3, 'mssql');
	$query_m30_4			=	mig_query($sq_m30_4, $db3, 'mssql');
	$query_m30_5			=	mig_query($sq_m30_5, $db3, 'mssql');


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
				$sq_c_NMC_2		=	"DELETE FROM estatus_planta_celdas_nivel_metal_critico WHERE fecha = '$fecha_programado_celdas' AND linea < '5';";
				$query_cNMC_2	=	mig_query($sq_c_NMC_2, $db);
				while($res_m4 =	mssql_fetch_array($query_m4))
				{
					$programados	=	busca_programado($res_m4['ID_CELL'], $fecha_programado_celdas, $db_oracle, $db);
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
				$sq_c_NMC_2		=	"DELETE FROM estatus_planta_celdas_nivel_metal_critico WHERE fecha = '$fecha_programado_celdas' AND linea < '5';";
				$query_cNMC_2	=	mig_query($sq_c_NMC_2, $db);
				while($res_m4 =	mssql_fetch_array($query_m4))
				{
					$programados	=	busca_programado($res_m4['ID_CELL'], $fecha_programado_celdas, $db_oracle, $db);
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
				$sq_c_NMC_2		=	"DELETE FROM estatus_planta_celdas_nivel_metal_critico WHERE fecha = '$fecha_programado_celdas' AND linea = '5';";
				$query_cNMC_2	=	mig_query($sq_c_NMC_2, $db);
				while($res_m4_2 =	mssql_fetch_array($query_m4_2))
				{
					$programados	=	busca_programado($res_m4_2['ID_CELL'], $fecha_programado_celdas, $db_oracle, $db);
					$sq_m14			=	"INSERT INTO estatus_planta_reduccion_turno (fecha, linea, turno, tipo_campo, num_celda, valor_variable) VALUES
										('$res_m4_2[DATE_IN]', '$res_m4_2[LINEA]', '$res_m4_2[ID_TURNO]', '$res_m4_2[tipo_campo]', '$res_m4_2[ID_CELL]', '$res_m4_2[valor_variable]');";
					$query_m14		=	mig_query($sq_m14, $db);
				}	
				echo "3.- Los datos de celdas LINEA 5 con nivel de metal >= 26 O nivel de metal <= 20 se han cargado correctamente <br>";
			}
			else
			{
				$sq_c_NMC_2		=	"DELETE FROM estatus_planta_celdas_nivel_metal_critico WHERE fecha = '$fecha_programado_celdas' AND linea = '5';";
				$query_cNMC_2	=	mig_query($sq_c_NMC_2, $db);
				$sq_m31			=	"DELETE FROM estatus_planta_reduccion_turno WHERE fecha = '$fecha_carga' AND turno = '$turno_carga' AND tipo_campo = '$tipo_variable'
									AND linea = '5'";
				$query_m31		=	mig_query($sq_m31, $db);
				while($res_m4_2 =	mssql_fetch_array($query_m4_2))
				{
					$programados	=	busca_programado($res_m4_2['ID_CELL'], $fecha_programado_celdas, $db_oracle, $db);
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
			$sq_m31_2		=	"DELETE FROM estatus_planta_edad_celdas_alto_fe WHERE fecha = '$fecha_carga'  AND LINEA <= '4'";
			$query_m31_2	=	mig_query($sq_m31_2, $db);
			if (pg_num_rows($query_m21) == 0)
			{
				while($res_m8_1 =	mssql_fetch_array($query_m8_1))
				{
					if ($res_m8_1['EDAD'] == '') $res_m8_1['EDAD'] = 0;
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
					if ($res_m8_1['EDAD'] == '') $res_m8_1['EDAD'] = 0;
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
			$sq_m31_2		=	"DELETE FROM estatus_planta_edad_celdas_alto_fe WHERE fecha = '$fecha_carga'  AND LINEA = '5'";
			$query_m31_2	=	mig_query($sq_m31_2, $db);
			if (pg_num_rows($query_m21) == 0)
			{
				while($res_m8_2 =	mssql_fetch_array($query_m8_2))
				{
					if ($res_m8_2['EDAD'] == '') $res_m8_2['EDAD'] = 0;
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
					if ($res_m8_2['EDAD'] == '') $res_m8_2['EDAD'] = 0;
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
		}///
//////////////CELDAS >= 2 EA EN EL DÍA
		if (mssql_num_rows($query_m23) > 0)
		{
			$tipo_variable		=	12;
			$sq_m21				=	"SELECT * FROM estatus_planta_reduccion_turno WHERE fecha = '$fecha_carga' AND turno = '$turno_carga' AND tipo_campo = '$tipo_variable'";
			$query_m21			=	mig_query($sq_m21, $db);
			if (pg_num_rows($query_m21) == 0)
			{
				while($res_m23 =	mssql_fetch_array($query_m23))
				{
					$sq_m15			=	"INSERT INTO estatus_planta_reduccion_turno (fecha, linea, turno, tipo_campo, num_celda, valor_variable) VALUES
										('$res_m23[DATE_IN]', '$res_m23[LINEA]', '$res_m23[ID_TURNO]', '$res_m23[tipo_campo]', '$res_m23[ID_CELL]', '$res_m23[valor_variable]');";
					$query_m15		=	mig_query($sq_m15, $db);
				}	
				echo "11.- Los datos de celdas con 2 o mas EA en el día se han cargado correctamente <br>";
			}
			else
			{
				$sq_m31			=	"DELETE FROM estatus_planta_reduccion_turno WHERE fecha = '$fecha_carga' AND turno = '$turno_carga' AND tipo_campo = '$tipo_variable'";
				$query_m31		=	mig_query($sq_m31, $db);
				while($res_m23 =	mssql_fetch_array($query_m23))
				{
					$sq_m15			=	"INSERT INTO estatus_planta_reduccion_turno (fecha, linea, turno, tipo_campo, num_celda, valor_variable) VALUES
										('$res_m23[DATE_IN]', '$res_m23[LINEA]', '$res_m23[ID_TURNO]', '$res_m23[tipo_campo]', '$res_m23[ID_CELL]', '$res_m23[valor_variable]');";
					$query_m15		=	mig_query($sq_m15, $db);
				}	
				echo "11.1- Se detectaron datos de celdas con 2 o mas EA en el día cargados previamente, se actualizaron a últimos datos. Se ha procesado correctamente la solicitud<br>";
			}
		}
		else
		{
			echo "No se encontraron Celdas mas 2 EA para el día y turno solicitado <br>";
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
			while (ocifetch($query_m7))
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
			while (ocifetch($query_m7))
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
//////////////CRISOLES ASIGNADOS POR LINEAS
	if ($num_filas2 > 0)
	{
		$tipo_variable		=	11;
		$sq_m21				=	"SELECT * FROM estatus_planta_reduccion_turno WHERE fecha = '$fecha_carga' AND turno = '$turno_carga' AND tipo_campo = '$tipo_variable'";
		$query_m21			=	mig_query($sq_m21, $db);
		if (pg_num_rows($query_m21) == 0)
		{
			while (ocifetch($query_m22))
			{
				$n			=	1;
				while ($n <= 15)
				{
					if ($COD[$n] > 0)
					{
						$VALOR_VARIABLE	=	$COD[$n];
						$sq_m17			=	"INSERT INTO estatus_planta_reduccion_turno (fecha, linea, turno, tipo_campo, num_celda, valor_variable) VALUES
											('$DATE_IN', '$LINEA', '$ID_TURNO', '$TIPO_CAMPO', '$ID_CELL', '$VALOR_VARIABLE');";
						$query_m17		=	mig_query($sq_m17, $db);
					}
					$n++;
				}
			}
			echo "Los datos de crisoles asignados se han cargado correctamente <br>";
		}
		else
		{
			$sq_m31			=	"DELETE FROM estatus_planta_reduccion_turno WHERE fecha = '$fecha_carga' AND turno = '$turno_carga' AND tipo_campo = '$tipo_variable'";
			$query_m31		=	mig_query($sq_m31, $db);
			while (ocifetch($query_m22))
			{
				$n			=	1;
				while ($n <= 15)
				{
					if ($COD[$n] > 0)
					{
						$VALOR_VARIABLE	=	$COD[$n];
						$sq_m17			=	"INSERT INTO estatus_planta_reduccion_turno (fecha, linea, turno, tipo_campo, num_celda, valor_variable) VALUES
											('$DATE_IN', '$LINEA', '$ID_TURNO', '$TIPO_CAMPO', '$ID_CELL', '$VALOR_VARIABLE');";
						$query_m17		=	mig_query($sq_m17, $db);
					}
					$n++;
				}
			}
			echo "Se detectaron datos de crisoles asignados cargados previamente, se actualizaron a últimos datos. Se ha procesado correctamente la solicitud<br>";
		}
	}
	
//////////////INSERT ALIMENTADORES BLOQUEADOS LINEA 1
	if (mssql_num_rows($query_m30_1) > 0)
	{
		$tipo_variable		=	13;
		$sq_m21				=	"SELECT * FROM estatus_planta_reduccion_turno WHERE fecha = '$fecha_carga' AND turno = '$turno_carga' AND tipo_campo = '$tipo_variable' AND linea = '1'";
		$query_m21			=	mig_query($sq_m21, $db);
		if (pg_num_rows($query_m21) == 0)
		{
			while($res_m30_1 =	mssql_fetch_array($query_m30_1))
			{
				$sq_m13			=	"INSERT INTO estatus_planta_reduccion_turno (fecha, linea, turno, tipo_campo, num_celda, valor_variable) VALUES
									('$res_m30_1[DATE_IN]', '$res_m30_1[LINEA]', '$res_m30_1[ID_TURNO]', '$res_m30_1[tipo_campo]', '$res_m30_1[ID_CELL]', '$res_m30_1[valor_variable]');";
				$query_m13		=	mig_query($sq_m13, $db);
			}	
			echo "Los datos de celdas con Alimentadores Bloqueados de Línea 1 se han cargado correctamente <br>";
		}
		else
		{
			$sq_m31			=	"DELETE FROM estatus_planta_reduccion_turno WHERE fecha = '$fecha_carga' AND turno = '$turno_carga' AND tipo_campo = '$tipo_variable' AND linea = '1'";
			$query_m31		=	mig_query($sq_m31, $db);
			while($res_m30_1 =	mssql_fetch_array($query_m30_1))
			{
				$sq_m13			=	"INSERT INTO estatus_planta_reduccion_turno (fecha, linea, turno, tipo_campo, num_celda, valor_variable) VALUES
									('$res_m30_1[DATE_IN]', '$res_m30_1[LINEA]', '$res_m30_1[ID_TURNO]', '$res_m30_1[tipo_campo]', '$res_m30_1[ID_CELL]', '$res_m30_1[valor_variable]');";
				$query_m13		=	mig_query($sq_m13, $db);
			}	
			echo "Se detectaron datos de celdas con Alimentadores Bloqueados de Línea 1 previamente, se actualizaron a últimos datos. Se ha procesado correctamente la solicitud<br>";
		}
	}
	else
	{
		echo "No se encontraron Celdas con Alimentadores Bloqueados de Línea 1 para el día y turno solicitado <br>";
	}
	
//////////////INSERT ALIMENTADORES BLOQUEADOS LINEA 2
	if (mssql_num_rows($query_m30_2) > 0)
	{
		$tipo_variable		=	13;
		$sq_m21				=	"SELECT * FROM estatus_planta_reduccion_turno WHERE fecha = '$fecha_carga' AND turno = '$turno_carga' AND tipo_campo = '$tipo_variable' AND linea = '2'";
		$query_m21			=	mig_query($sq_m21, $db);
		if (pg_num_rows($query_m21) == 0)
		{
			while($res_m30_2 =	mssql_fetch_array($query_m30_2))
			{
				$sq_m13			=	"INSERT INTO estatus_planta_reduccion_turno (fecha, linea, turno, tipo_campo, num_celda, valor_variable) VALUES
									('$res_m30_2[DATE_IN]', '$res_m30_2[LINEA]', '$res_m30_2[ID_TURNO]', '$res_m30_2[tipo_campo]', '$res_m30_2[ID_CELL]', '$res_m30_2[valor_variable]');";
				$query_m13		=	mig_query($sq_m13, $db);
			}	
			echo "Los datos de celdas con Alimentadores Bloqueados de Línea 2 se han cargado correctamente <br>";
		}
		else
		{
			$sq_m31			=	"DELETE FROM estatus_planta_reduccion_turno WHERE fecha = '$fecha_carga' AND turno = '$turno_carga' AND tipo_campo = '$tipo_variable' AND linea = '2'";
			$query_m31		=	mig_query($sq_m31, $db);
			while($res_m30_2 =	mssql_fetch_array($query_m30_2))
			{
				$sq_m13			=	"INSERT INTO estatus_planta_reduccion_turno (fecha, linea, turno, tipo_campo, num_celda, valor_variable) VALUES
									('$res_m30_2[DATE_IN]', '$res_m30_2[LINEA]', '$res_m30_2[ID_TURNO]', '$res_m30_2[tipo_campo]', '$res_m30_2[ID_CELL]', '$res_m30_2[valor_variable]');";
				$query_m13		=	mig_query($sq_m13, $db);
			}	
			echo "Se detectaron datos de celdas con Alimentadores Bloqueados de Línea 2 previamente, se actualizaron a últimos datos. Se ha procesado correctamente la solicitud<br>";
		}
	}
	else
	{
		echo "No se encontraron Celdas con Alimentadores Bloqueados de Línea 2 para el día y turno solicitado <br>";
	}
//////////////INSERT ALIMENTADORES BLOQUEADOS LINEA 3
	if (mssql_num_rows($query_m30_3) > 0)
	{
		$tipo_variable		=	13;
		$sq_m21				=	"SELECT * FROM estatus_planta_reduccion_turno WHERE fecha = '$fecha_carga' AND turno = '$turno_carga' AND tipo_campo = '$tipo_variable' AND linea = '3'";
		$query_m21			=	mig_query($sq_m21, $db);
		if (pg_num_rows($query_m21) == 0)
		{
			while($res_m30_3 =	mssql_fetch_array($query_m30_3))
			{
				$sq_m13			=	"INSERT INTO estatus_planta_reduccion_turno (fecha, linea, turno, tipo_campo, num_celda, valor_variable) VALUES
									('$res_m30_3[DATE_IN]', '$res_m30_3[LINEA]', '$res_m30_3[ID_TURNO]', '$res_m30_3[tipo_campo]', '$res_m30_3[ID_CELL]', '$res_m30_3[valor_variable]');";
				$query_m13		=	mig_query($sq_m13, $db);
			}	
			echo "Los datos de celdas con Alimentadores Bloqueados de Línea 3 se han cargado correctamente <br>";
		}
		else
		{
			$sq_m31			=	"DELETE FROM estatus_planta_reduccion_turno WHERE fecha = '$fecha_carga' AND turno = '$turno_carga' AND tipo_campo = '$tipo_variable' AND linea = '3'";
			$query_m31		=	mig_query($sq_m31, $db);
			while($res_m30_3 =	mssql_fetch_array($query_m30_3))
			{
				$sq_m13			=	"INSERT INTO estatus_planta_reduccion_turno (fecha, linea, turno, tipo_campo, num_celda, valor_variable) VALUES
									('$res_m30_3[DATE_IN]', '$res_m30_3[LINEA]', '$res_m30_3[ID_TURNO]', '$res_m30_3[tipo_campo]', '$res_m30_3[ID_CELL]', '$res_m30_3[valor_variable]');";
				$query_m13		=	mig_query($sq_m13, $db);
			}	
			echo "Se detectaron datos de celdas con Alimentadores Bloqueados de Línea 3 previamente, se actualizaron a últimos datos. Se ha procesado correctamente la solicitud<br>";
		}
	}
	else
	{
		echo "No se encontraron Celdas con Alimentadores Bloqueados de Línea 3 para el día y turno solicitado <br>";
	}
//////////////INSERT ALIMENTADORES BLOQUEADOS LINEA 4
	if (mssql_num_rows($query_m30_4) > 0)
	{
		$tipo_variable		=	13;
		$sq_m21				=	"SELECT * FROM estatus_planta_reduccion_turno WHERE fecha = '$fecha_carga' AND turno = '$turno_carga' AND tipo_campo = '$tipo_variable' AND linea = '4'";
		$query_m21			=	mig_query($sq_m21, $db);
		if (pg_num_rows($query_m21) == 0)
		{
			while($res_m30_4 =	mssql_fetch_array($query_m30_4))
			{
				$sq_m13			=	"INSERT INTO estatus_planta_reduccion_turno (fecha, linea, turno, tipo_campo, num_celda, valor_variable) VALUES
									('$res_m30_4[DATE_IN]', '$res_m30_4[LINEA]', '$res_m30_4[ID_TURNO]', '$res_m30_4[tipo_campo]', '$res_m30_4[ID_CELL]', '$res_m30_4[valor_variable]');";
				$query_m13		=	mig_query($sq_m13, $db);
			}	
			echo "Los datos de celdas con Alimentadores Bloqueados de Línea 4 se han cargado correctamente <br>";
		}
		else
		{
			$sq_m31			=	"DELETE FROM estatus_planta_reduccion_turno WHERE fecha = '$fecha_carga' AND turno = '$turno_carga' AND tipo_campo = '$tipo_variable' AND linea = '4'";
			$query_m31		=	mig_query($sq_m31, $db);
			while($res_m30_4 =	mssql_fetch_array($query_m30_4))
			{
				$sq_m13			=	"INSERT INTO estatus_planta_reduccion_turno (fecha, linea, turno, tipo_campo, num_celda, valor_variable) VALUES
									('$res_m30_4[DATE_IN]', '$res_m30_4[LINEA]', '$res_m30_4[ID_TURNO]', '$res_m30_4[tipo_campo]', '$res_m30_4[ID_CELL]', '$res_m30_4[valor_variable]');";
				$query_m13		=	mig_query($sq_m13, $db);
			}	
			echo "Se detectaron datos de celdas con Alimentadores Bloqueados de Línea 4 previamente, se actualizaron a últimos datos. Se ha procesado correctamente la solicitud<br>";
		}
	}
	else
	{
		echo "No se encontraron Celdas con Alimentadores Bloqueados de Línea 4 para el día y turno solicitado <br>";
	}
//////////////INSERT ALIMENTADORES BLOQUEADOS LINEA 5
	if (mssql_num_rows($query_m30_5) > 0)
	{
		$tipo_variable		=	13;
		$sq_m21				=	"SELECT * FROM estatus_planta_reduccion_turno WHERE fecha = '$fecha_carga' AND turno = '$turno_carga' AND tipo_campo = '$tipo_variable' AND linea = '5'";
		$query_m21			=	mig_query($sq_m21, $db);
		if (pg_num_rows($query_m21) == 0)
		{
			while($res_m30_5 =	mssql_fetch_array($query_m30_5))
			{
				$sq_m13			=	"INSERT INTO estatus_planta_reduccion_turno (fecha, linea, turno, tipo_campo, num_celda, valor_variable) VALUES
									('$res_m30_5[DATE_IN]', '$res_m30_5[LINEA]', '$res_m30_5[ID_TURNO]', '$res_m30_5[tipo_campo]', '$res_m30_5[ID_CELL]', '$res_m30_5[valor_variable]');";
				$query_m13		=	mig_query($sq_m13, $db);
			}	
			echo "Los datos de celdas con Alimentadores Bloqueados de Línea 5 se han cargado correctamente <br>";
		}

		else
		{
			$sq_m31			=	"DELETE FROM estatus_planta_reduccion_turno WHERE fecha = '$fecha_carga' AND turno = '$turno_carga' AND tipo_campo = '$tipo_variable' AND linea = '5'";
			$query_m31		=	mig_query($sq_m31, $db);
			while($res_m30_5 =	mssql_fetch_array($query_m30_5))
			{
				$sq_m13			=	"INSERT INTO estatus_planta_reduccion_turno (fecha, linea, turno, tipo_campo, num_celda, valor_variable) VALUES
									('$res_m30_5[DATE_IN]', '$res_m30_5[LINEA]', '$res_m30_5[ID_TURNO]', '$res_m30_5[tipo_campo]', '$res_m30_5[ID_CELL]', '$res_m30_5[valor_variable]');";
				$query_m13		=	mig_query($sq_m13, $db);
			}	
			echo "Se detectaron datos de celdas con Alimentadores Bloqueados de Línea 5 previamente, se actualizaron a últimos datos. Se ha procesado correctamente la solicitud<br>";
		}
	}
	else
	{
		echo "No se encontraron Celdas con Alimentadores Bloqueados de Línea 5 para el día y turno solicitado <br>";
	}


//////////////
	mssql_close($db3);
	pg_close($db);
	ocilogoff($db_oracle);

////////////////////////////////////////////////////////////////////////////////////////////////////////////////
/////////////////////////BUSQUEDA DE LA PROGRAMACION DE TRAZEGADO DE CELDAS CON N.M.C  /////////////////////////
////////////////////////////////////////////////////////////////////////////////////////////////////////////////
function busca_programado($celda, $fecha_programado, $db_oracle, $db)
{
 	$sq_m21		=	"SELECT	FECHA, NRO_CELDA, CANT_PRG,
								CASE WHEN NRO_CELDA > '100' AND NRO_CELDA < '300' THEN 1 ELSE 
								CASE WHEN  NRO_CELDA > '300' AND NRO_CELDA < '500' THEN 2 ELSE
								CASE WHEN  NRO_CELDA > '500' AND NRO_CELDA < '700' THEN 3 ELSE
								CASE WHEN  NRO_CELDA > '700' AND NRO_CELDA < '900' THEN 4 ELSE 5 
								END END END END AS LINEA, 3 AS ID_TURNO
							FROM	PEXPRE.PROGRAMADOS
							WHERE 	(FECHA = '$fecha_programado') AND (NRO_CELDA = '$celda')";
	$query_m21 			= 	ociparse($db_oracle, $sq_m21);
	$query_m22 			= 	ociparse($db_oracle, $sq_m21);
	ocidefinebyname($query_m21, 'FECHA', 		$FECHA1);
	ocidefinebyname($query_m21, 'NRO_CELDA', 	$NRO_CELDA1);
	ocidefinebyname($query_m21, 'CANT_PRG', 	$CANT_PRG1);
	ocidefinebyname($query_m21, 'LINEA', 		$LINEA1);
	ocidefinebyname($query_m21, 'ID_TURNO', 	$ID_TURNO1);
	ociexecute($query_m21);
	ociexecute($query_m22);
	ocifetchstatement($query_m22,$tab_result);  // the result will be fetched in the table $tab_result
	$num_filas1			=	ocirowcount($query_m22);
	ocifetch($query_m21);
	
	if ($num_filas1 > 0)
	{
		$sq_c_NMC_3		=	"INSERT INTO estatus_planta_celdas_nivel_metal_critico (fecha, linea, num_celda, programado) VALUES
									('$FECHA1', '$LINEA1', '$NRO_CELDA1', '$CANT_PRG1');";
		$query_cNMC_3	=	mig_query($sq_c_NMC_3, $db);
	}
}

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