<?php
	include 'conectarse.php';
	$turno							=	3;
	$db								=	conectarse_postgres_taller_autom();
	$sq_m0							=	"SELECT current_date  AS fecha";
	$query_m0						=	mig_query($sq_m0, $db);	
	$res_m0							=	pg_fetch_array($query_m0);
	
	$fecha_hoy						=	$res_m0['fecha'];
	list($a, $m, $d)				=	split('-', $fecha_hoy);
 	$fecha							=	"$d/$m/$a";
	
	$sq_m1							=	"SELECT id_registro FROM taller_automotriz_principal WHERE fecha = '$fecha' AND turno = '$turno';";
	$query_m1						=	mig_query($sq_m1, $db);
	
	/*if (pg_num_rows($query_m1) == 0)
	{
		$sq_m1						=	"SELECT id_registro FROM taller_automotriz_principal ORDER BY id_registro DESC LIMIT 1";
		$query_m1					=	mig_query($sq_m1, $db);
	}*/
	
	$res_m1							=	pg_fetch_array($query_m1);
	$id_reg							=	$res_m1['id_registro'];

	pg_close($db);
	if (pg_num_rows($query_m1) > 0)
	{
		$db2							=	conectarse_postgres();
		$sq_m2							=	"SELECT 	id_sub_area_estatus_planta, id_area_estatus_planta, 
												SUM(total_equipos_dpto_turno) AS total_estandar, 
												SUM(total_equipos_operativos_dpto_turno) AS total_operativo,
												SUM(total_equipos_prestamo) AS total_prestamo, 
												id_tipo_equipo_estatus_planta,
												desc_sub_area_estatus,
												desc_equipo_movil_estatus
											FROM(
												SELECT 	estatus_planta_diccionario_sub_area_estatus_planta_taller.id_sub_area_estatus_planta, 
													estatus_planta_diccionario_sub_area_estatus_planta_taller.id_area_estatus_planta,
													taller.total_equipos_dpto_turno, 
													taller.total_equipos_operativos_dpto_turno,
													taller.total_equipos_prestamo,
													taller.id_gerencia,
													taller.id_loc,
													taller.desc_loc,
													estatus_planta_diccionario_sub_area.desc_sub_area AS desc_sub_area_estatus,
													taller.id_tipo_equipo AS id_tipo_equipo_taller,
													taller.desc_tipo_equipo_movil AS desc_tipo_equipo_taller,
													estatus_planta_diccionario_tipo_equipo_estatus_planta_taller.id_tipo_equipo_estatus_planta,
													estatus_planta_diccionario_tipo_equipo_movil.desc_equipo_movil AS desc_equipo_movil_estatus
											
												FROM estatus_planta_diccionario_sub_area_estatus_planta_taller INNER JOIN
													dblink ('dbname=taller_automotriz port=5432 host=vem-1868 
														user=postgres password=123dacdac',
														'SELECT id_registro, COUNT(*) AS total_equipos_dpto_turno, SUM(estatus_equipo_fin_turno) AS total_equipos_operativos_dpto_turno, 
															SUM(prestamo_equipo) AS total_equipos_prestamo, id_gerencia, id_loc, desc_loc, id_tipo_equipo, desc_tipo_equipo_movil
																						FROM
																						(
																									SELECT 
																									  taller_automotriz_equipo_turno.id_registro, 
																									  taller_automotriz_equipo_turno.id_equipo,
																									  taller_automotriz_equipo_turno.prestamo_equipo::integer, 
																									  taller_automotriz_equipo_turno.estatus_equipo_fin_turno, 
																									  taller_automotriz_diccionario_localizaciones.desc_loc, 
																									  taller_automotriz_diccionario_localizaciones.id_gerencia, 
																									  taller_automotriz_equipo_turno.observacion_equipo, 
																									  taller_automotriz_diccionario_loc_equipo.id_loc,
																									  taller_automotriz_diccionario_equipo.id_tipo_equipo,
																									  taller_automotriz_diccionario_tipo_equipo_movil.desc_tipo_equipo_movil
																									  
																									FROM 
																									  taller_automotriz_equipo_turno, 
																									  taller_automotriz_diccionario_loc_equipo, 
																									  taller_automotriz_diccionario_localizaciones,
																									  taller_automotriz_diccionario_equipo,
																									  taller_automotriz_diccionario_tipo_equipo_movil
																									WHERE 
																									  taller_automotriz_equipo_turno.id_equipo 		= 	taller_automotriz_diccionario_loc_equipo.id_equipo 	AND
																									  taller_automotriz_diccionario_loc_equipo.id_loc 	= 	taller_automotriz_diccionario_localizaciones.id_loc 	AND
																									  taller_automotriz_equipo_turno.id_equipo		=	taller_automotriz_diccionario_equipo.id_equipo		AND
																									  taller_automotriz_diccionario_equipo.id_tipo_equipo	=	taller_automotriz_diccionario_tipo_equipo_movil.id_tipo_equipo_movil	AND
																									  id_registro = $id_reg
																						)
																						DERIVEDTBL
																						GROUP BY id_registro, id_gerencia, id_loc, desc_loc, id_tipo_equipo, desc_tipo_equipo_movil
																						ORDER BY id_gerencia, id_loc;
														')
													AS taller(id_registro integer, total_equipos_dpto_turno integer, total_equipos_operativos_dpto_turno integer, total_equipos_prestamo integer, 
													id_gerencia integer, id_loc integer, desc_loc character(50), id_tipo_equipo integer, desc_tipo_equipo_movil character(80))
												ON	
													estatus_planta_diccionario_sub_area_estatus_planta_taller.id_sub_area_taller_automotriz = taller.id_loc
												INNER JOIN estatus_planta_diccionario_sub_area
												ON 
													estatus_planta_diccionario_sub_area_estatus_planta_taller.id_sub_area_estatus_planta = estatus_planta_diccionario_sub_area.id_sub_area
												INNER JOIN estatus_planta_diccionario_tipo_equipo_estatus_planta_taller
												ON	
													estatus_planta_diccionario_tipo_equipo_estatus_planta_taller.id_tipo_equipo_taller = taller.id_tipo_equipo
												INNER JOIN estatus_planta_diccionario_tipo_equipo_movil
												ON
													estatus_planta_diccionario_tipo_equipo_movil.id_equipo_movil = estatus_planta_diccionario_tipo_equipo_estatus_planta_taller.id_tipo_equipo_estatus_planta
											)
											DERIVEDTBL
											GROUP BY id_sub_area_estatus_planta, id_area_estatus_planta, id_tipo_equipo_estatus_planta, desc_sub_area_estatus,  desc_equipo_movil_estatus
											ORDER BY id_sub_area_estatus_planta;";
											
		$tabla					=	"estaus_planta_equipo_movil";
		$campos					=	"fecha, turno, area, sub_area, tipo_equipo_movil, cantidad_estandar, cantidad_operativo, cantidad_prestamo";
		
		$sq_m3					=	"SELECT * FROM estaus_planta_equipo_movil WHERE fecha = '$fecha' AND turno = '$turno'";
		$query_m3				=	mig_query($sq_m3, $db2);
			
		if (pg_num_rows($query_m3) == 0)
		{
			$query_m2			=	mig_query($sq_m2, $db2);
			while ($res_m2		=	pg_fetch_array($query_m2))
			{
				$sq_m4			=	"INSERT INTO $tabla ($campos) VALUES 
									('$fecha', '$turno', 
									'$res_m2[id_area_estatus_planta]', 
									'$res_m2[id_sub_area_estatus_planta]', 
									'$res_m2[id_tipo_equipo_estatus_planta]', 
									'$res_m2[total_estandar]',
									'$res_m2[total_operativo]',
									'$res_m2[total_prestamo]');";
				$query_m4		=	mig_query($sq_m4, $db2);	
			}
				echo "Los datos de equipos moviles para el turno se han CARGADO correctamente <br>";
		}
		else
		{
			$sq_m3				=	"DELETE FROM estaus_planta_equipo_movil WHERE fecha = '$fecha' AND turno = '$turno'";
			$query_m3			=	mig_query($sq_m3, $db2);
	
			$query_m2			=	mig_query($sq_m2, $db2);
			while ($res_m2		=	pg_fetch_array($query_m2))
			{
				$sq_m4			=	"INSERT INTO $tabla ($campos) VALUES 
									('$fecha', '$turno', 
									'$res_m2[id_area_estatus_planta]', 
									'$res_m2[id_sub_area_estatus_planta]', 
									'$res_m2[id_tipo_equipo_estatus_planta]', 
									'$res_m2[total_estandar]',
									'$res_m2[total_operativo]',
									'$res_m2[total_prestamo]');";
				$query_m4		=	mig_query($sq_m4, $db2);	
			}
				echo "Los datos de equipos moviles para el turno se han MODIFICADO correctamente <br>";
		}
		pg_close($db2);
	}

?>