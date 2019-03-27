<?php

	include 'conectarse.php';
	
	$db								=	conectarse_postgres();

	$sq_m0							=	"SELECT current_date - 1 AS fecha";
	$query_m0						=	mig_query($sq_m0, $db);	
	$res_m0							=	pg_fetch_array($query_m0);
	
	$fecha_hoy						=	$res_m0['fecha'];
	list($a, $m, $d)				=	split('-', $fecha_hoy);
 	$fecha							=	"$d/$m/$a";
	
	list($dia, $mes, $año)			=	split('/', $fecha);
	$fec = "$mes/$dia/$año";

	$mes_busc						=	date('M', strtotime($fec));
	$fecha_carga					=	"$dia-$mes_busc-$año";

	$db_oracle			=	conectarse_oracle();

	$sq_m1				=	"SELECT DISTINCT COD_MATERIAL, COD_BUQUE, FECHA_PROD, SUM((PESO_B - PESO_T) / 1000) AS VALOR_VARIABLE, FECHA_ATRAQUE
							FROM         ADMINSICA.CONTROL_PESO
							WHERE     (PESO_B IS NOT NULL) AND (PESO_T IS NOT NULL) AND (FECHA_PROD IS NOT NULL) AND (COD_MATERIAL = '5800000013' OR
												  COD_MATERIAL = 7000000009 OR
												  COD_MATERIAL = '7000000001') AND (COD_BUQUE IS NOT NULL) AND (FECHA_PROD = '$fecha_carga')
							GROUP BY COD_MATERIAL, COD_BUQUE, FECHA_PROD, FECHA_ATRAQUE";
	
	$query_m1 			= 	ociparse($db_oracle, $sq_m1);
	$query_m11 			= 	ociparse($db_oracle, $sq_m1);
	ocidefinebyname($query_m1, 'COD_MATERIAL', $COD_MATERIAL);
	ocidefinebyname($query_m1, 'COD_BUQUE', $COD_BUQUE);
	ocidefinebyname($query_m1, 'FECHA_PROD', $FECHA_PROD);
	ocidefinebyname($query_m1, 'VALOR_VARIABLE', $VALOR_VARIABLE);
	ocidefinebyname($query_m1, 'FECHA_ATRAQUE', $FECHA_ATRAQUE);
	ociexecute($query_m1);
	ociexecute($query_m11);
	ocifetchstatement($query_m11,$tab_result);  // the result will be fetched in the table $tab_result
	$num_filas1			=	ocirowcount($query_m11);

	if ($num_filas1 > 0)
	{
		ocifetch($query_m1, OCI_ASSOC);
		$sq_m2			=	"SELECT     ADMINSICA.BL_BUQUE.COD_BUQUE, ADMINSICA.BL_BUQUE.FECHA_ATRAQUE, 
							 CASE WHEN ADMINSICA.BL_BUQUE.COD_MATERIAL = '5800000013' THEN 1 ELSE
							 CASE WHEN ADMINSICA.BL_BUQUE.COD_MATERIAL = '7000000009' THEN 2 ELSE
							 CASE WHEN  ADMINSICA.BL_BUQUE.COD_MATERIAL = '7000000001' THEN 3 END END END AS COD_MATERIAL, 
												  SUM(ADMINSICA.BL_BUQUE.CANT_TN) AS CANT_IN, ADMINSICA.BUQUES.NOMBRE_DEL_BUQUE
							FROM         ADMINSICA.BL_BUQUE, ADMINSICA.BUQUES
							WHERE     ADMINSICA.BL_BUQUE.COD_BUQUE = ADMINSICA.BUQUES.COD_BUQUE AND (ADMINSICA.BL_BUQUE.COD_BUQUE = '$COD_BUQUE') AND 
												  (ADMINSICA.BL_BUQUE.FECHA_ATRAQUE = '$FECHA_ATRAQUE')
							GROUP BY ADMINSICA.BL_BUQUE.COD_BUQUE, ADMINSICA.BL_BUQUE.FECHA_ATRAQUE, ADMINSICA.BL_BUQUE.COD_MATERIAL, 
												  ADMINSICA.BUQUES.NOMBRE_DEL_BUQUE";

		$query_m2 		= 	ociparse($db_oracle, $sq_m2);
		ocidefinebyname($query_m2, 'COD_BUQUE', $COD_BUQUE);
		ocidefinebyname($query_m2, 'FECHA_ATRAQUE', $FECHA_ATRAQUE);
		ocidefinebyname($query_m2, 'COD_MATERIAL', $COD_MATERIAL);
		ocidefinebyname($query_m2, 'CANT_IN', $CANT_IN);
		ocidefinebyname($query_m2, 'NOMBRE_DEL_BUQUE', $NOMBRE_DEL_BUQUE);
		ociexecute($query_m2);
		ocifetch($query_m2, OCI_ASSOC);

		$sq_m3				=	"SELECT     SUM((PESO_B - PESO_T) / 1000) AS TOTAL_BUQUE
								FROM         ADMINSICA.CONTROL_PESO
								WHERE     (COD_BUQUE IS NOT NULL) AND (PESO_B IS NOT NULL) AND (PESO_T IS NOT NULL) AND (FECHA_PROD IS NOT NULL) AND 
													  (COD_MATERIAL = '5800000013' OR
													  COD_MATERIAL = '7000000009' OR
													  COD_MATERIAL = '7000000001') AND (COD_BUQUE = '$COD_BUQUE') AND (FECHA_ATRAQUE = '$FECHA_ATRAQUE')
													   AND (FECHA_PROD <= '$fecha_carga')";
		$query_m3 			= 	ociparse($db_oracle, $sq_m3);
		ocidefinebyname($query_m3, 'TOTAL_BUQUE', $TOTAL_BUQUE);
		ociexecute($query_m3);
		ocifetch($query_m3, OCI_ASSOC);
		
		$db					=	conectarse_postgres();
		
		$sq_m5				=	"SELECT * FROM estatus_planta_recep_desp_materiales WHERE fecha = '$fecha_carga'";
		$query_m5			=	mig_query($sq_m5, $db);
		if (pg_num_rows($query_m5) == 0)
		{
			if ($COD_MATERIAL == "" || $VALOR_VARIABLE == "" || $NOMBRE_DEL_BUQUE == "" || $FECHA_ATRAQUE == "" || $CANT_IN == "" || $TOTAL_BUQUE == "")
			{
				echo "Falla de la información de material recepcionado";
			}
			else
			{
				$sq_m4			=	"INSERT INTO estatus_planta_recep_desp_materiales 
									(fecha, tipo_movimiento, tipo_material, cantidad_material_dia, nombre_buque, fecha_atraque, total_material_buque, acum_buque_dia)
									VALUES
									('$fecha_carga', '1', '$COD_MATERIAL', '$VALOR_VARIABLE', '$NOMBRE_DEL_BUQUE', '$FECHA_ATRAQUE', '$CANT_IN', '$TOTAL_BUQUE')";
				$query_m4		=	mig_query($sq_m4, $db);
				echo "Se ha ingresado correctamente la información de material recepcionado en muelle";
			}
		}
		else
		{
			$sq_m4			=	"UPDATE estatus_planta_recep_desp_materiales SET
								tipo_movimiento = 1, tipo_material = '$COD_MATERIAL', cantidad_material_dia = '$VALOR_VARIABLE', 
								fecha_atraque = '$FECHA_ATRAQUE', total_material_buque = '$CANT_IN', acum_buque_dia = '$TOTAL_BUQUE'
								WHERE fecha = '$fecha_carga'";
			$query_m4		=	mig_query($sq_m4, $db);
			echo "Se ha modificado correctamente la información de material recepcionado en muelle";
		}
		pg_close($db);
	}
	else
	{
		echo "No se encontró data de Material Recepcionado en Muelle para el día";
	}
	ocilogoff($db_oracle);
?>