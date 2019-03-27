<?php

include 'conectarse.php';

$db				=	conectarse_aluminio20_dac();
$sq_m1			=	"SELECT     CONVERT(NVARCHAR, V_A20_DHW_CELDAS_STA.DATE_IN, 103) AS DIA, V_A20_DHW_CELDAS_STA.ID_CELL, V_A20_DHW_CELDAS_STA.EDAD_CELDA AS EDAD, VCELDAST_1.fe AS valor_variable, 
													  CASE WHEN ID_CELL > '100' AND ID_CELL < '300' THEN 1 ELSE CASE WHEN ID_CELL > '300' AND 
													  ID_CELL < '500' THEN 2 ELSE CASE WHEN ID_CELL > '500' AND ID_CELL < '700' THEN 3 ELSE CASE WHEN ID_CELL > '700' AND 
													  ID_CELL < '900' THEN 4 END END END END AS LINEA, 3 AS ID_TURNO, 8 AS tipo_campo
								FROM         [ALUMINIO20 SCP SILABM].SILABM.dbo.celdast VCELDAST_1 INNER JOIN
													  V_A20_DHW_CELDAS_STA ON VCELDAST_1.fecha = V_A20_DHW_CELDAS_STA.DATE_IN AND 
													  VCELDAST_1.n0celda = V_A20_DHW_CELDAS_STA.ID_CELL
								WHERE     (CONVERT(NVARCHAR, V_A20_DHW_CELDAS_STA.DATE_IN, 103) = '18/01/2011') AND (VCELDAST_1.fe >= '0.5') AND 
													  (V_A20_DHW_CELDAS_STA.ID_CELL < '900') AND (V_A20_DHW_CELDAS_STA.ID_TURNO = '3')
								ORDER BY V_A20_DHW_CELDAS_STA.ID_CELL";

$query_m1		=	mssql_query("SET ANSI_NULLS ON") ;
$query_m1		=	mssql_query("SET ANSI_WARNINGS ON") ;
$query_m1		=	mig_query($sq_m1, $db, 'mssql');
//$query_m1		=	mssql_query("SET ANSI_NULLS OFF") ;
//$query_m1		=	mssql_query("SET ANSI_WARNINGS OFF") ;
while ($res_m1 	=	mssql_fetch_array($query_m1))
{
	echo "<br>";
	print_r($res_m1);
}
mssql_close($db);
?>