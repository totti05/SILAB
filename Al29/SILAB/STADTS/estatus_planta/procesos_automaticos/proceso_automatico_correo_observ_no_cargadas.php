<?php

	include 'conectarse.php';
	
	$db								=	conectarse_postgres();

	$sq_m1							=	"SELECT 
										  estatus_planta_observaciones.fecha, 
										  estatus_planta_observaciones.observacion, 
										  estatus_planta_observaciones.turno, 
										  estatus_planta_observaciones.fecha_creacion, 
										  estatus_planta_observaciones.hora_creacion, 
										  estatus_planta_diccionario_sub_area.desc_sub_area, 
										  estatus_planta_diccionario_area.desc_area
										FROM 
										  estatus_planta_observaciones, 
										  estatus_planta_diccionario_sub_area, 
										  estatus_planta_diccionario_area
										WHERE 
										  estatus_planta_observaciones.id_sub_area = estatus_planta_diccionario_sub_area.id_sub_area AND
										  estatus_planta_diccionario_area.id_area = estatus_planta_diccionario_sub_area.id_area AND
										  estatus_planta_observaciones.fecha >= current_date - 7 AND 
										  estatus_planta_observaciones.observacion = 'El responsable del �rea no cargo la informaci�n'
										ORDER BY
										  estatus_planta_observaciones.fecha ASC, 
										  estatus_planta_observaciones.turno ASC;";
	$query_m1						=	mig_query($sq_m1, $db);	
	
	?>
	<style type="text/css">
		.estilo_1{
			text-align:center; background-color:#0066CC; color:#FFFFFF; font-weight:bold; 
		}
	</style>
	<?php
	$incio_tabla	=	"<table style=\"width:70%\" >
							<tr>
								<td style=\"width:20%; text-align:center; background-color:#0066CC; color:#FFFFFF; font-weight:bold;\">Fecha</td>
								<td style=\"width:20%; text-align:center; background-color:#0066CC; color:#FFFFFF; font-weight:bold;\">Turno</td>
								<td style=\"width:30%; text-align:center; background-color:#0066CC; color:#FFFFFF; font-weight:bold;\">Area</td>
								<td style=\"width:30%; text-align:center; background-color:#0066CC; color:#FFFFFF; font-weight:bold;\">Sub Area</td>
							</tr>";
	$num3_fila 					=	0;
	while ($res_m1					=	pg_fetch_array($query_m1))
	{
		list($a, $m, $d)			=	split('-', $res_m1['fecha']);
		$fecha_mostrar				=	"$d/$m/$a";
		if ($num3_fila%2==0){ 
		  $tr_tabla					=	"<tr bgcolor =#AFDDF5>";} //si el resto de la divisi�n es 0 pongo un color 				  
		else {                  
		  $tr_tabla					=	"<tr bgcolor=#AFDDF5>"; } //si el resto de la divisi�n NO es 0 pongo otro color 
		
		$contcatena_tabla_1			= 	"<td style=\"width:20%; text-align:center\">$fecha_mostrar</td>
										<td style=\"width:20%; text-align:center\">$res_m1[turno]</td>
										<td style=\"width:30%; text-align:center\">$res_m1[desc_area]</td>
										<td style=\"width:30%; text-align:center\">$res_m1[desc_sub_area]</td>
									</tr>";
		$linea_tabla				=	$tr_tabla.$contcatena_tabla_1;
		$v1 = $v1.$linea_tabla;
		$num3_fila++;
	}

	$fin_tabla						=	"</table>";

	$tabla_mostrar					=	$incio_tabla.$v1.$fin_tabla;

	//echo $tabla_mostrar;

	$encabezado_correo = 
	"El correo es para informar sobre las �reas de planta que no han cargado las
	observaciones en sus turnos de trabajo respectivos durante la �ltima semana de
	trabajo. 
	<br><br><br>";


	$pie_correo = "
	<br><br>Este correo se genera autom�ticamente, la Superintendencia Control de Procesos no se 
	hace responsable por la carga de datos que cada supervisor de �rea debe hacer <br><br>
	Atentamente,<br><br><br>
	
	SCP";

	$correo_final 				= 	$encabezado_correo.$tabla_mostrar.$pie_correo;
	
//	echo $correo_final;

	$db2						= 	conectarse_postgres1();
	revisa_tabla($db2);
	$sq_mm						= 	"DELETE FROM auxiliar_correo";
	$res_mm						= 	mig_query($sq_mm, $db2);

	$sq_mm						= 	"INSERT INTO auxiliar_correo (id, email, asunto_correo, texto_correo) VALUES ('1', 'miguel.maneiros@venalum.com.ve', 
									'Observaciones Estatus Planta no cargadas', '$correo_final')";
	$res_mm						= 	mig_query($sq_mm, $db2);
//	$sq_mm						= 	"DELETE FROM auxiliar_correo";
//	$res_mm						= 	mig_query($sq_mm, $db2);
/*
	$sq_mm						= 	"INSERT INTO auxiliar_correo (id, email, asunto_correo, texto_correo) VALUES ('1', 'luis.a.martinez@venalum.com.ve', 
									'Observaciones Estatus Planta no cargadas', '$correo_final')";
	$res_mm						= 	mig_query($sq_mm, $db2);
	$sq_mm						= 	"DELETE FROM auxiliar_correo";
	$res_mm						= 	mig_query($sq_mm, $db2);

	$sq_mm						= 	"INSERT INTO auxiliar_correo (id, email, asunto_correo, texto_correo) VALUES ('1', 'pedro.marquez@venalum.com.ve', 
									'Observaciones Estatus Planta no cargadas', '$correo_final')";
	$res_mm						= 	mig_query($sq_mm, $db2);
	$sq_mm						= 	"DELETE FROM auxiliar_correo";
	$res_mm						= 	mig_query($sq_mm, $db2);
*/
	revisa_tabla($db2);
	$sq_mm						= 	"INSERT INTO auxiliar_correo (id, email, asunto_correo, texto_correo) VALUES ('1', 'tulio.reyes@venalum.com.ve', 
									'Observaciones Estatus Planta no cargadas', '$correo_final')";
	$res_mm						= 	mig_query($sq_mm, $db2);
//	$sq_mm						= 	"DELETE FROM auxiliar_correo";
//	$res_mm						= 	mig_query($sq_mm, $db2);

	revisa_tabla($db2);
	$sq_mm						= 	"INSERT INTO auxiliar_correo (id, email, asunto_correo, texto_correo) VALUES ('1', 'luz.renger@venalum.com.ve', 
									'Observaciones Estatus Planta no cargadas', '$correo_final')";
	$res_mm						= 	mig_query($sq_mm, $db2);
//	$sq_mm						= 	"DELETE FROM auxiliar_correo";
//	$res_mm						= 	mig_query($sq_mm, $db2);



	pg_close($db);
	pg_close($db2);
	
	
function revisa_tabla($db)
{
	$sq_revisa_tabla			=	"SELECT * FROM auxiliar_correo;";
	$query_revisa_tabla			=	mig_query($sq_revisa_tabla, $db);
	$n							=	0;
	
	while (pg_num_rows($query_revisa_tabla) > 0)
	{
		$sq_borra_tabla			=	"DELETE FROM auxiliar_correo";
		$query_revisa_tabla		=	mig_query($sq_borra_tabla, $db);
		$sq_revisa_tabla		=	"SELECT * FROM auxiliar_correo;";
		$query_revisa_tabla		=	mig_query($sq_revisa_tabla, $db);
	}
}

?>