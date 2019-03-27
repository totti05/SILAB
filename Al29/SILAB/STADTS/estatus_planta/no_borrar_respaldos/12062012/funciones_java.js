function boton_actualiza_reduccion()	/////probado
{
	tipo_consulta			=	document.getElementById('select_turno_dia').value;

	if (document.getElementById('oculto_modulo')) 	modulo	=	document.getElementById('oculto_modulo').value;
	else											modulo	=	"estatus_planta";

	if (tipo_consulta ==2)
	{
		poststr				=	'dia='+document.getElementById('fecha_carga_reduccion').value;
		var ob_ajax1 		=	null;
		makePOSTRequest(1, 0, 'modules/'+modulo+'/xml/ingresa_datos_reduccion_dia.php?'+poststr, poststr, ob_ajax1, 'tabla_datos_reduccion');
	}
	else
	{
		poststr				=	'dia='+document.getElementById('fecha_carga_reduccion').value+
								'&turno='+document.getElementById('select_turno').value;
		var ob_ajax1 		=	null;
		makePOSTRequest(1, 0, 'modules/'+modulo+'/xml/ingresa_datos_reduccion_turno.php?'+poststr, poststr, ob_ajax1, 'tabla_datos_reduccion');
	}
}


function boton_actualiza_colada()	/////probado
{
	poststr					=	'dia='+document.getElementById('fecha_carga_colada').value+
								'&turno='+document.getElementById('select_turno').value;
	if (document.getElementById('oculto_modulo')) 	modulo	=	document.getElementById('oculto_modulo').value;
	else											modulo	=	"estatus_planta";
	var ob_ajax1 			=	null;
	makePOSTRequest(1, 0, 'modules/'+modulo+'/xml/ingresa_datos_colada_turno.php?'+poststr, poststr, ob_ajax1, 'tabla_datos_colada');
}

function boton_actualiza_carbon()	/////probado
{
	tipo_consulta			=	document.getElementById('select_turno_dia').value;
	if (tipo_consulta ==2)
	{
		poststr				=	'dia='+document.getElementById('fecha_carga_carbon').value;
		modulo				=	document.getElementById('oculto_modulo').value;
		var ob_ajax1 		=	null;
		makePOSTRequest(1, 0, 'modules/'+modulo+'/xml/ingresa_datos_carbon_dia.php?'+poststr, poststr, ob_ajax1, 'tabla_datos_carbon');
	}
	else
	{
		poststr				=	'dia='+document.getElementById('fecha_carga_carbon').value+
								'&turno='+document.getElementById('select_turno').value;
		modulo				=	document.getElementById('oculto_modulo').value;
		var ob_ajax1 		=	null;
		makePOSTRequest(1, 0, 'modules/'+modulo+'/xml/ingresa_datos_carbon_turno.php?'+poststr, poststr, ob_ajax1, 'tabla_datos_carbon');
	}
}

function guarda_datos_reduccion_turno(linea)	/////probado
{
	var arreglo_celdas_alta_temp			=	new Array();
	var arreglo_celdas_desv_resist			=	new Array();
	var arreglo_celdas_ea					=	new Array();
	var arreglo_celdas_niv_metal			=	new Array();
	var arreglo_celdas_niv_baño				=	new Array();
	var arreglo_valor_alta_temp				=	new Array();
	var arreglo_valor_desv_resist			=	new Array();
	var arreglo_valor_ea					=	new Array();
	var arreglo_valor_niv_metal				=	new Array();
	var arreglo_valor_niv_baño				=	new Array();
	var fecha;
	var turno;
	var anodos_servidos						=	"";
	var presion_aire						=	"";

	num_filas_celdas_alta_temp				=	document.getElementById('linea_'+linea+'_registros_celda_alta_temp').value;
	num_filas_celdas_desv_resist			=	document.getElementById('linea_'+linea+'_registros_celda_desv_resist').value;
	num_filas_celdas_ea						=	document.getElementById('linea_'+linea+'_registros_celda_ea').value;
	num_filas_celdas_niv_metal				=	document.getElementById('linea_'+linea+'_registros_niv_metal').value;
	num_filas_celdas_niv_baño				=	document.getElementById('linea_'+linea+'_registros_niv_baño').value;

	n_filas									=	0;
	while(n_filas < num_filas_celdas_alta_temp)
	{
		arreglo_celdas_alta_temp[n_filas]	=	document.getElementById('linea_'+linea+'_celda_alta_temp_'+n_filas).value;
		arreglo_valor_alta_temp[n_filas]	=	document.getElementById('linea_'+linea+'_valor_alta_temp_'+n_filas).value;
		n_filas++;
	}
	
	n_filas							=	0;
	while(n_filas < num_filas_celdas_desv_resist)
	{
		arreglo_celdas_desv_resist[n_filas]	=	document.getElementById('linea_'+linea+'_celda_desv_resist_'+n_filas).value;
		arreglo_valor_desv_resist[n_filas]	=	document.getElementById('linea_'+linea+'_valor_desv_resist_'+n_filas).value;
		n_filas++;
	}
	
	n_filas							=	0;
	while(n_filas < num_filas_celdas_ea)
	{
		arreglo_celdas_ea[n_filas]			=	document.getElementById('linea_'+linea+'_celda_ea_'+n_filas).value;
		arreglo_valor_ea[n_filas]			=	document.getElementById('linea_'+linea+'_valor_ea_'+n_filas).value;
		n_filas++;
	}
	
	n_filas							=	0;
	while(n_filas < num_filas_celdas_niv_metal)
	{
		arreglo_celdas_niv_metal[n_filas]	=	document.getElementById('linea_'+linea+'_celda_niv_metal_'+n_filas).value;
		arreglo_valor_niv_metal[n_filas]	=	document.getElementById('linea_'+linea+'_valor_niv_metal_'+n_filas).value;
		n_filas++;
	}
	
	n_filas							=	0;
	while(n_filas < num_filas_celdas_niv_baño)
	{
		arreglo_celdas_niv_baño[n_filas]	=	document.getElementById('linea_'+linea+'_celda_niv_baño_'+n_filas).value;
		arreglo_valor_niv_baño[n_filas]		=	document.getElementById('linea_'+linea+'_valor_niv_baño_'+n_filas).value;
		n_filas++;
	}
	
	fecha							=	document.getElementById('fecha').value;
	turno							=	document.getElementById('turno').value;
	anodos_servidos					=	document.getElementById('linea_'+linea+'_celda_anodos_servidos_0').value;

	if (linea == 1 || linea == 3 || linea == 5)
	{
		presion_aire				=	document.getElementById('linea_'+linea+'_valor_anodos_servidos_0').value;
	}
	
	poststr							=	"fecha="+fecha+
										"&turno="+turno+
										"&anodos_servidos="+anodos_servidos+
										"&presion_aire="+presion_aire+
										"&linea="+linea+
										"&arreglo_celdas_alta_temp="+arreglo_celdas_alta_temp+
										"&arreglo_valor_alta_temp="+arreglo_valor_alta_temp+
										"&arreglo_celdas_desv_resist="+arreglo_celdas_desv_resist+
										"&arreglo_valor_desv_resist="+arreglo_valor_desv_resist+
										"&arreglo_celdas_ea="+arreglo_celdas_ea+
										"&arreglo_valor_ea="+arreglo_valor_ea+
										"&arreglo_celdas_niv_metal="+arreglo_celdas_niv_metal+
										"&arreglo_valor_niv_metal="+arreglo_valor_niv_metal+
										"&arreglo_celdas_niv_bano="+arreglo_celdas_niv_baño+
										"&arreglo_valor_niv_bano="+arreglo_valor_niv_baño;
	
	var ob_ajax1 = null;
	if (document.getElementById('oculto_modulo')) 	modulo	=	document.getElementById('oculto_modulo').value;
	else											modulo	=	"estatus_planta";
	
	makePOSTRequest(1, 0, 'modules/'+modulo+'/xml/procesa_ingresa_datos_reduccion_turno.php?'+poststr, poststr, ob_ajax1, 'repuesta_servidor_reduccion');
}

function guarda_datos_reduccion_dia(linea)	/////probado
{
	document.getElementById('oculto_linea').value	=	linea;
	valida											=	validar_campos('reduccion_dia');
	if (valida == 1)
	{
		var turno;
		var anodos_servidos							=	"";
		var presion_aire							=	"";
		var plan_prod_neta_linea					=	"";
		var real_prod_neta_linea					=	"";
		var real_celdas_con_linea					=	"";
		var real_celdas_prod_linea					=	"";
		var real_celdas_inc_linea					=	"";
		var real_celdas_desinc_linea				=	"";
	
		var fecha									=	document.getElementById('fecha').value;
		
		
		plan_prod_neta_linea						=	document.getElementById('plan_prod_neta_linea_'+linea).value;
		real_prod_neta_linea						=	document.getElementById('real_prod_neta_linea_'+linea).value;
		real_celdas_con_linea						=	document.getElementById('real_celdas_con_linea_'+linea).value;
		real_celdas_prod_linea						=	document.getElementById('real_celdas_prod_linea_'+linea).value;
		real_celdas_inc_linea						=	document.getElementById('real_celdas_inc_linea_'+linea).value;
		real_celdas_desinc_linea					=	document.getElementById('real_celdas_desinc_linea_'+linea).value;
		
		poststr										=	"fecha="+fecha+
														"&linea="+linea+
														"&plan_prod_neta_linea="+plan_prod_neta_linea+
														"&real_prod_neta_linea="+real_prod_neta_linea+
														"&real_celdas_con_linea="+real_celdas_con_linea+
														"&real_celdas_prod_linea="+real_celdas_prod_linea+
														"&real_celdas_inc_linea="+real_celdas_inc_linea+
														"&real_celdas_desinc_linea="+real_celdas_desinc_linea;
	
		if (document.getElementById('oculto_modulo')) 	modulo	=	document.getElementById('oculto_modulo').value;
		else											modulo	=	"estatus_planta";
		var ob_ajax1 = null;
		makePOSTRequest(1, 0, 'modules/'+modulo+'/xml/procesa_ingresa_datos_reduccion_diario.php?'+poststr, poststr, ob_ajax1, 'repuesta_servidor_reduccion');
	}
	else
		alert('Debe Completar Todos los Campos');
}

function guarda_datos_carbon_turno()	/////probado
{
	valida										=	validar_campos('carbon_turno');
	if (valida == 1)
	{
		var fecha								=	document.getElementById('fecha_carga_carbon').value;
		var turno								=	document.getElementById('select_turno').value;
		
		produc_anodo_verde						=	document.getElementById('anodo_verde_turno').value;
		produc_anodo_cocido						=	document.getElementById('anodo_cocido_turno').value;
		produc_anodo_envarillado				=	document.getElementById('anodo_envarillado_turno').value;
	
		poststr									=	"fecha="+fecha+
													"&turno="+turno+
													"&produc_anodo_verde="+produc_anodo_verde+
													"&produc_anodo_cocido="+produc_anodo_cocido+
													"&produc_anodo_envarillado="+produc_anodo_envarillado;
	
		if (document.getElementById('oculto_modulo')) 	modulo	=	document.getElementById('oculto_modulo').value;
		else											modulo	=	"estatus_planta";
		var ob_ajax1 = null;
		makePOSTRequest(1, 0, 'modules/'+modulo+'/xml/procesa_ingresa_datos_carbon_turno.php?'+poststr, poststr, ob_ajax1, 'repuesta_servidor_carbon');
	}
	else
		alert('Debe Completar Todos los Campos');
}

function guarda_datos_colada_turno()	/////probado
{
	valida										=	validar_campos('colada_turno');
	if (valida == 1)
	{
		var fecha								=	document.getElementById('fecha_carga_colada').value;
		var turno								=	document.getElementById('select_turno').value;
		
		num_crisoles_recibidos					=	document.getElementById('crisol_recibido_turno').value;
		num_crisoles_procesados					=	document.getElementById('crisol_procesado_turno').value;
		temperatura_crisoles_recibidos			=	document.getElementById('temperatura_crisol_turno').value;
	
		poststr									=	"fecha="+fecha+
													"&turno="+turno+
													"&num_crisoles_recibidos="+num_crisoles_recibidos+
													"&num_crisoles_procesados="+num_crisoles_procesados+
													"&temperatura_crisoles_recibidos="+temperatura_crisoles_recibidos;
	
		if (document.getElementById('oculto_modulo')) 	modulo	=	document.getElementById('oculto_modulo').value;
		else											modulo	=	"estatus_planta";
		var ob_ajax1 = null;
		makePOSTRequest(1, 0, 'modules/'+modulo+'/xml/procesa_ingresa_datos_colada_turno.php?'+poststr, poststr, ob_ajax1, 'repuesta_servidor_colada');
	}
	else
		alert('Debe Completar Todos los Campos');
}

function guarda_datos_carbon_dia()	/////probado
{
	valida										=	validar_campos('carbon_dia');
	if (valida == 1)
	{	
		var fecha								=	document.getElementById('fecha_carga_carbon').value;
		produc_anodo_verde						=	document.getElementById('anodo_verde_dia').value;
		produc_anodo_cocido						=	document.getElementById('anodo_cocido_dia').value;
		produc_anodo_envarillado				=	document.getElementById('anodo_envarillado_dia').value;
	
		inventario_anodo_verde					=	document.getElementById('inventario_anodo_verde_dia').value;
		inventario_anodo_cocido					=	document.getElementById('inventario_anodo_cocido_dia').value;
		inventario_anodo_envarillado			=	document.getElementById('inventario_anodo_envarillado_dia').value;
		
		poststr									=	"&fecha="+fecha+
													"&produc_anodo_verde="+produc_anodo_verde+
													"&produc_anodo_cocido="+produc_anodo_cocido+
													"&produc_anodo_envarillado="+produc_anodo_envarillado+
													"&inventario_anodo_verde="+inventario_anodo_verde+
													"&inventario_anodo_cocido="+inventario_anodo_cocido+
													"&inventario_anodo_envarillado="+inventario_anodo_envarillado;
		
		if (document.getElementById('oculto_modulo')) 	modulo	=	document.getElementById('oculto_modulo').value;
		else											modulo	=	"estatus_planta";
		var ob_ajax1 = null;
		makePOSTRequest(1, 0, 'modules/'+modulo+'/xml/procesa_ingresa_datos_carbon_dia.php?'+poststr, poststr, ob_ajax1, 'repuesta_servidor_carbon');
	}
	else alert('Debe Completar Todos Los Campos');
}

function procesa_carga_datos_turno_automatico()	/////probado
{
	var fecha								=	document.getElementById('cuadro_fecha_carga_datos_turno').value;
	var turno								=	document.getElementById('select_turno').value;
	
	var ob_ajax1 = null;
	var ob_ajax2 = null;
	var ob_ajax3 = null;
	
	if (document.getElementById('oculto_modulo')) 	modulo	=	document.getElementById('oculto_modulo').value;
	else											modulo	=	"estatus_planta";
	
	poststr				=	"fecha_carga="+fecha+
							"&turno_carga="+turno;

	makePOSTRequest(1, 0, 'modules/'+modulo+'/xml/carga_datos_carbon_turno.php?'+poststr, poststr, ob_ajax1, 'respuesta_carga_datos_carbon_turno');
	makePOSTRequest(1, 0, 'modules/'+modulo+'/xml/carga_datos_colada_turno.php?'+poststr, poststr, ob_ajax2, 'respuesta_carga_datos_colada_turno');
	makePOSTRequest(1, 0, 'modules/'+modulo+'/xml/carga_datos_reduccion_turno.php?'+poststr, poststr, ob_ajax3, 'respuesta_carga_datos_reduccion_turno');

}

function procesa_carga_datos_dia_automatico()	/////probado
{
	var fecha								=	document.getElementById('cuadro_fecha_carga_datos_dia').value;
	
	var ob_ajax1 = null;
	var ob_ajax2 = null;
	var ob_ajax3 = null;
	
	if (document.getElementById('oculto_modulo')) 	modulo	=	document.getElementById('oculto_modulo').value;
	else											modulo	=	"estatus_planta";
	
	poststr				=	"fecha_carga="+fecha;

	makePOSTRequest(1, 0, 'modules/'+modulo+'/xml/carga_datos_carbon_dia.php?'+poststr, poststr, ob_ajax1, 'respuesta_carga_datos_carbon_dia');
	makePOSTRequest(1, 0, 'modules/'+modulo+'/xml/carga_datos_reduccion_dia.php?'+poststr, poststr, ob_ajax2, 'respuesta_carga_datos_reduccion_dia');
	makePOSTRequest(1, 0, 'modules/'+modulo+'/xml/carga_datos_reduccion_dia.php?'+poststr, poststr, ob_ajax3, 'respuesta_carga_datos_muelle_dia');

}

function boton_actualiza_equipo_movil()	/////probado
{
	var area_equipo_movil		=	document.getElementById('oculto_area_equipo_movil').value;
	var sub_tipo_equipo_movil	=	document.getElementById('oculto_sub_tipo_equipo_movil').value;
	poststr						=	'dia='+document.getElementById('cuadro_fecha_carga_datos_turno').value+
									'&turno='+document.getElementById('select_turno').value+
									'&id_area='+area_equipo_movil+
									'&id_sub_tipo='+sub_tipo_equipo_movil;
	if (document.getElementById('oculto_modulo')) 	modulo	=	document.getElementById('oculto_modulo').value;
	else											modulo	=	"estatus_planta";
	var ob_ajax1 				=	null;
	makePOSTRequest(1, 0, 'modules/'+modulo+'/xml/ingresa_datos_equipo_movil_turno_2.php?'+poststr, poststr, ob_ajax1, 'tabla_datos_equipo_movil');
}

function guarda_datos_equipo_movil_turno(sub_area, area)	/////probado
{
	document.getElementById('oculto_sub_area').value	=	sub_area;
	valida												=	validar_campos('equipo_movil');
	if (valida == 1)
	{	
		if (document.getElementById('oculto_modulo')) 	modulo	=	document.getElementById('oculto_modulo').value;
		else											modulo	=	"estatus_planta";
	
		var valores_estandar							=	new Array();
		var valores_operativo							=	new Array();
		///(montacargas, remolcadores, skyper, payloader, camion) == (n=1, n=2, n=3, n=4, n=5)
		n												=	0;
		n2												=	1;
		n_max											=	5;
	
		while(n < n_max)
		{
			valores_estandar[n]							=	document.getElementById('estandar_'+n2+'_sub_area_'+sub_area).value;
			valores_operativo[n]						=	document.getElementById('operativo_'+n2+'_sub_area_'+sub_area).value;
			n++;
			n2++;
		}

		turno											=	document.getElementById('select_turno').value;
		fecha											=	document.getElementById('cuadro_fecha_carga_datos_turno').value;
		poststr											=	'fecha_carga='+fecha+
															'&turno='+turno+
															'&area='+area+
															'&sub_area='+sub_area+
															'&valores_estandar='+valores_estandar+
															'&valores_operativo='+valores_operativo;
		respuesta_servidor								=	'respuesta_carga_datos_equipo_movil_turno_1';
		
		var ob_ajax1 		=	null;
		makePOSTRequest(1, 0, 'modules/'+modulo+'/xml/procesa_ingresa_datos_equipo_movil_turno.php?'+poststr, poststr, ob_ajax1, respuesta_servidor);
	}
	else 
		alert('Debe Completar Todos Los Campos');
}

function guarda_datos_equipo_movil_turno_2(area, sub_area)
{
/*	var fecha 						=	document.getElementById('oculto_fecha').value;
	var turno 						=	document.getElementById('oculto_turno').value;
	var area 						=	document.getElementById('oculto_area').value;
	var sub_tipo					=	 document.getElementById('oculto_sub_tipo').value;
	
	var arreglo_estandar 			= 	new Array();
	var arreglo_operativo			=	new Array();
	
	var ind;
	var ind2;
	var ind_max;
	var sub_areas					=	new Array();
	
	if (area == 1)
	{
		if (sub_tipo == 1)
		{
			sub_areas				=	 [6, 7, 8, 9, 10];
		}
		if (sub_tipo == 2)
		{
			sub_areas				=	 [24, 25, 26];
		}
		if (sub_tipo == 3)
		{
			sub_areas				=	 [30, 31, 32];
		}
	}
	if (area == 2)
	{
		if (sub_tipo == 1)
		{
			sub_areas				=	 [2, 3, 4, 16, 17, 21];
		}
		if (sub_tipo == 2)
		{
			sub_areas				=	 [20, 19];
		}
	}
	if (area == 3)
	{
		if (sub_tipo == 1)
		{
			sub_areas				=	 [5];
		}
	}
	if (area == 5)
	{
		if (sub_tipo == 1)
		{
			sub_areas				=	 [23, 27, 29, 33, 34];
		}
	}
	if (area == 6)
	{
		if (sub_tipo == 1)
		{
			sub_areas				=	 [28];
		}
	}
	var apunt						=	0;
	var apunt_max					=	sub_areas.length;
	while (apunt < apunt_max)
	{
		arreglo_estandar[apunt]		=	new Array();
		arreglo_operativo[apunt]	=	new Array();
		ind							=	0;
		ind2						=	1;
		ind_max						=	11;
		while (ind < ind_max)
		{
			ii						=	ind*1+1;
			arreglo_estandar[apunt][ind]	=	document.getElementById('estandar_'+ii+'_sub_area_'+sub_areas[apunt]).value;
			arreglo_operativo[apunt][ind]	=	document.getElementById('operativo_'+ii+'_sub_area_'+sub_areas[apunt]).value;
			ind++;
		}
		apunt++;
	}*/
	/*------------------------------------------------------------------------------------------------------------*/
	var fecha 						=	document.getElementById('oculto_fecha').value;
	var turno 						=	document.getElementById('oculto_turno').value;	
	var arreglo_estandar 			= 	new Array();
	var arreglo_operativo			=	new Array();
	
	ind							=	0;
	ind2						=	1;
	ind_max						=	11;
	while (ind < ind_max)
	{
		ii						=	ind*1+1;
		arreglo_estandar[ind]	=	document.getElementById('estandar_'+ii+'_sub_area_'+sub_area).value;
		arreglo_operativo[ind]	=	document.getElementById('operativo_'+ii+'_sub_area_'+sub_area).value;
		ind++;
	}
	
	/*-------------------------------------------------------------------------------------------------------------*/
	
		poststr											=	'fecha_carga='+fecha+
															'&turno='+turno+
															'&area='+area+
															'&sub_area='+sub_area+
															'&valores_estandar='+arreglo_estandar+
															'&valores_operativo='+arreglo_operativo;
		respuesta_servidor								=	'respuesta_carga_datos_equipo_movil_turno_1';
		
	if (document.getElementById('oculto_modulo')) 	modulo	=	document.getElementById('oculto_modulo').value;
	else											modulo	=	"estatus_planta";
	var ob_ajax1 		=	null;
	//document.getElementById('myspan').innerHTML =	'modules/'+modulo+'/xml/procesa_ingresa_datos_equipo_movil_turno_2.php?'+poststr;
	makePOSTRequest(1, 0, 'modules/'+modulo+'/xml/procesa_ingresa_datos_equipo_movil_turno_2.php?'+poststr, poststr, ob_ajax1, respuesta_servidor);

}


function limpiar_div(cual_div)	/////probado
{
	if (cual_div == 1)
	{
		document.getElementById('respuesta_ingresa_datos_reduccion').innerHTML			=	"";
	}
	if (cual_div == 2)
	{
		document.getElementById('respuesta_ingresa_datos_carbon').innerHTML				=	"";
	}
	if (cual_div == 3)
	{
		document.getElementById('respuesta_ingresa_datos_colada').innerHTML				=	"";
	}
	if (cual_div == 4)
	{
		document.getElementById('respuesta_carga_datos_equipo_movil_turno_1').innerHTML	=	"";
	}
	if (cual_div == 5)
	{
		document.getElementById('respuesta_carga_datos_materias_primas_dia').innerHTML				=	"";
	}
	if (cual_div == 6)
	{
		document.getElementById('respuesta_carga_datos_observ').innerHTML				=	"";
	}
	if (cual_div == 20)
	{
		if (document.getElementById('respuesta_carga_datos_turno1').innerHTML > "") document.getElementById('respuesta_carga_datos_turno1').innerHTML = "";
		if (document.getElementById('respuesta_carga_datos_turno2').innerHTML > "") document.getElementById('respuesta_carga_datos_turno2').innerHTML = "";
		if (document.getElementById('respuesta_carga_datos_turno3').innerHTML > "") document.getElementById('respuesta_carga_datos_turno3').innerHTML = "";
	}
	if (cual_div == 21)
	{
		if (document.getElementById('respuesta_carga_datos_dia1').innerHTML > "") document.getElementById('respuesta_carga_datos_dia1').innerHTML = "";
		if (document.getElementById('respuesta_carga_datos_dia2').innerHTML > "") document.getElementById('respuesta_carga_datos_dia2').innerHTML = "";
	}
}

function boton_actualiza_materias_primas()	/////probado
{
	poststr					=	'dia='+document.getElementById('cuadro_fecha_carga_datos_turno').value;
	if (document.getElementById('oculto_modulo')) 	modulo	=	document.getElementById('oculto_modulo').value;
	else											modulo	=	"estatus_planta";
	var ob_ajax1 			=	null;
	makePOSTRequest(1, 0, 'modules/'+modulo+'/xml/ingresa_datos_materias_primas.php?'+poststr, poststr, ob_ajax1, 'tabla_datos_materias_primas');
}

function procesa_ingresa_datos_materias_primas()
{
	valida											=	validar_campos('materias_primas');
	if (valida == 1)
	{	
		if (document.getElementById('oculto_modulo')) 	modulo	=	document.getElementById('oculto_modulo').value;
		else											modulo	=	"estatus_planta";
		
		var valores_inventarios				=	new Array();
		var dias_consumo					=	new Array();
		fecha								=	document.getElementById('cuadro_fecha_carga_datos_turno').value;
		n									=	0;
		n2									=	1;
		while (n < 7)
		{
			valores_inventarios[n]			=	document.getElementById('inventarios_'+n2).value;
			dias_consumo[n]					=	document.getElementById('dias_consumo_'+n2).value;
			n++;
			n2++;
		}
		
		var fechas_materias_primas			=	new Array();
		var cant_materias_primas			=	new Array();
		var buques_materias_primas			=	new Array();
		var observ_materias_primas			=	new Array();

		if (document.getElementById('fecha_material_2'))
		{
			m2									=	0;
			m1									=	2;
			while(m1 <= 7)
			{
				fechas_materias_primas[m2]		=	document.getElementById('fecha_material_'+m1).value;
				cant_materias_primas[m2]		=	document.getElementById('cantidad_material_'+m1).value;
				buques_materias_primas[m2]		=	encodeURI(document.getElementById('barco_material_'+m1).value);
				observ_materias_primas[m2]		=	encodeURI(document.getElementById('observacion_material_'+m1).value);
				m1++;
				m2++;
			}
		}

		poststr								=	"fecha="+fecha+
												"&valores_inventarios="+valores_inventarios+
												"&dias_consumo="+dias_consumo+
												"&fechas_materias_primas="+fechas_materias_primas+
												"&cant_materias_primas="+cant_materias_primas+
												"&buques_materias_primas="+buques_materias_primas+
												"&observ_materias_primas="+observ_materias_primas;
		var ob_ajax1 						=	null;
		makePOSTRequest(1, 0, 'modules/'+modulo+'/xml/procesa_ingresa_datos_materias_primas_dia.php?'+poststr, poststr, ob_ajax1, 'repuesta_servidor_materias_primas'); 
	}
	else 
		alert('Debe Completar Todos Los Campos');
}

function validar_campos(formulario_validar)
{
	if (formulario_validar == 'carbon_dia')
	{
		t1								=	document.getElementById('anodo_verde_dia').value;
		t2								=	document.getElementById('anodo_cocido_dia').value;
		t3								=	document.getElementById('anodo_envarillado_dia').value;
		t4								=	document.getElementById('inventario_anodo_verde_dia').value;
		t5								=	document.getElementById('inventario_anodo_cocido_dia').value;
		t6								=	document.getElementById('inventario_anodo_envarillado_dia').value;
		if (t1 == "" || t2 == "" || t3 == "" || t4 == "" || t5 == ""|| t6 == "")
			return 0;
		else return 1;
	}
	if (formulario_validar == 'carbon_turno')
	{
		t1								=	document.getElementById('anodo_verde_turno').value;
		t2								=	document.getElementById('anodo_cocido_turno').value;
		t3								=	document.getElementById('anodo_envarillado_turno').value;
		if (t1 == "" || t2 == "" || t3 == "")
			return 0;
		else return 1;
	}
	if (formulario_validar == 'colada_turno')
	{
		t1								=	document.getElementById('crisol_recibido_turno').value;
		t2								=	document.getElementById('crisol_procesado_turno').value;
		t3								=	document.getElementById('temperatura_crisol_turno').value;
		if (t1 == "" || t2 == "" || t3 == "")
			return 0;
		else return 1;
	}
	if (formulario_validar == 'equipo_movil')
	{
		sub_area						=	document.getElementById('oculto_sub_area').value;
		t1								=	document.getElementById('estandar_1_sub_area_'+sub_area).value;
		t2								=	document.getElementById('estandar_2_sub_area_'+sub_area).value;
		t3								=	document.getElementById('estandar_3_sub_area_'+sub_area).value;
		t4								=	document.getElementById('estandar_4_sub_area_'+sub_area).value;
		t5								=	document.getElementById('estandar_5_sub_area_'+sub_area).value;
		t6								=	document.getElementById('operativo_1_sub_area_'+sub_area).value;
		t7								=	document.getElementById('operativo_2_sub_area_'+sub_area).value;
		t8								=	document.getElementById('operativo_3_sub_area_'+sub_area).value;
		t9								=	document.getElementById('operativo_4_sub_area_'+sub_area).value;
		t10								=	document.getElementById('operativo_5_sub_area_'+sub_area).value;
		if (t1 == "" || t2 == "" || t3 == "" || t4 == "" || t5 == "" || t6 == "" || t7 == "" || t8 == "" || t9 == "" || t10 == "")
			return 0;
		else return 1;
	}
	if (formulario_validar == 'materias_primas')
	{
		t1								=	document.getElementById('inventarios_1').value;
		t2								=	document.getElementById('inventarios_2').value;
		t3								=	document.getElementById('inventarios_3').value;
		t4								=	document.getElementById('inventarios_4').value;
		t5								=	document.getElementById('inventarios_5').value;
		t6								=	document.getElementById('inventarios_6').value;
		t7								=	document.getElementById('inventarios_7').value;
		t8								=	document.getElementById('dias_consumo_1').value;
		t9								=	document.getElementById('dias_consumo_2').value;
		t10								=	document.getElementById('dias_consumo_3').value;
		t11								=	document.getElementById('dias_consumo_4').value;
		t12								=	document.getElementById('dias_consumo_5').value;
		t13								=	document.getElementById('dias_consumo_6').value;
		t14								=	document.getElementById('dias_consumo_7').value;
		if (t1 == ""  || t2 == ""  || t3 == ""  || t4 == ""  || t5 == ""  || t6 == ""  || t7 == ""  || t8 == ""  || t9 == ""  || t10 == ""  ||
			t11 == "" || t12 == "" || t13 == "" || t14 == "")
			return 0;
		else return 1;
	}
	if (formulario_validar == 'reduccion_dia')
	{
		linea							=	document.getElementById('oculto_linea').value;
		t1								=	document.getElementById('plan_prod_neta_linea_'+linea).value;
		t2								=	document.getElementById('real_prod_neta_linea_'+linea).value;
		t3								=	document.getElementById('real_celdas_con_linea_'+linea).value;
		t4								=	document.getElementById('real_celdas_prod_linea_'+linea).value;
		t5								=	document.getElementById('real_celdas_inc_linea_'+linea).value;
		t6								=	document.getElementById('real_celdas_desinc_linea_'+linea).value;
		if (t1 == "" || t2 == "" || t3 == "" || t4 == "" || t5 == ""|| t6 == "")
			return 0;
		else return 1;
	}
	if (formulario_validar == 'accidentes')
	{
		area							=	document.getElementById('oculto_area').value;
		t1								=	document.getElementById('num_accidentes_'+area).value;
		t2								=	document.getElementById('num_lesionados_'+area).value;
		if (t1 == "" || t2 == "")
			return 0;
		else return 1;
	}
}

function boton_actualiza_observaciones(area)	/////probado
{
	if (document.getElementById('oculto_modulo')) 	modulo	=	document.getElementById('oculto_modulo').value;
	else											modulo	=	"estatus_planta";
	poststr				=	'dia='+document.getElementById('cuadro_fecha_carga_datos_turno').value+
							'&turno='+document.getElementById('select_turno').value;
	var ob_ajax1 		=	null;
	if (area == 1) makePOSTRequest(1, 0, 'modules/'+modulo+'/xml/ingresa_datos_observacion_reduccion.php?'+poststr, poststr, ob_ajax1, 'tabla_datos_observacion');
	if (area == 2) makePOSTRequest(1, 0, 'modules/'+modulo+'/xml/ingresa_datos_observacion_carbon.php?'+poststr, poststr, ob_ajax1, 'tabla_datos_observacion');
	if (area == 3) makePOSTRequest(1, 0, 'modules/'+modulo+'/xml/ingresa_datos_observacion_colada.php?'+poststr, poststr, ob_ajax1, 'tabla_datos_observacion');
	if (area == 4) makePOSTRequest(1, 0, 'modules/'+modulo+'/xml/ingresa_datos_observacion_ccyp.php?'+poststr, poststr, ob_ajax1, 'tabla_datos_observacion');
}


function guarda_datos_observaciones(sub_area, area)
{
	var fecha							=	document.getElementById('cuadro_fecha_carga_datos_turno').value;
	var turno							=	document.getElementById('select_turno').value;
	var observacion_sub_area			=	document.getElementById('observacion_sub_area_'+sub_area).value;
	var poststr2						=	"";
	if (sub_area >= 6 && sub_area <= 10)
	{
		if (sub_area == 6)	linea = 1;
		if (sub_area == 7)	linea = 2;
		if (sub_area == 8)	linea = 3;
		if (sub_area == 9)	linea = 4;
		if (sub_area == 10)	linea = 5;
		celdas_casco_rojo				=	document.getElementById('celdas_casco_rojo_'+linea).value;
		celdas_derrame_floruro			=	document.getElementById('celdas_derrame_floruro_'+linea).value;
		celdas_derrame_alumina			=	document.getElementById('celdas_derrame_alumina_'+linea).value;
		celdas_tolva_bloqueada			=	document.getElementById('celdas_tolva_bloqueada_'+linea).value;
		
		poststr2						=	"&celdas_casco_rojo="+celdas_casco_rojo+
											"&celdas_derrame_floruro="+celdas_derrame_floruro+
											"&celdas_derrame_alumina="+celdas_derrame_alumina+
											"&celdas_tolva_bloqueada="+celdas_tolva_bloqueada;
	}
	poststr								=	"fecha="+fecha+
											"&sub_area="+sub_area+
											"&area="+area+
											"&turno="+turno+
											"&observacion_sub_area="+encodeURI(observacion_sub_area)+poststr2;
											
	
	if (document.getElementById('oculto_modulo')) 	modulo	=	document.getElementById('oculto_modulo').value;
	else											modulo	=	"estatus_planta";
	var ob_ajax1 						=	null;
	makePOSTRequest(1, 0, 'modules/'+modulo+'/xml/procesa_ingresa_datos_observaciones.php?'+poststr, poststr, ob_ajax1, 'repuesta_servidor_observ'); 
}


function ventana_detalles_1(tipo_variable, tipo_consulta, dia, mes, ano, linea, turno_reporte)
{
		var poststr 						=	"tipo_variable="+tipo_variable+
											"&linea="+linea+
											"&turno_reporte="+turno_reporte+
											"&tipo_consulta="+tipo_consulta+
											"&fecha_reporte="+dia+'/'+mes+'/'+ano;
		window.open('tabla_detalles_celdas.php?'+poststr, "_blank","status=0, toolbar=0, width=360, height=450, scrollbars=1");
}

function ventana_detalles_2(tipo_variable, tipo_consulta, dia, mes, ano, turno_reporte)
{
		var poststr 						=	"tipo_variable="+tipo_variable+
											"&turno_reporte="+turno_reporte+
											"&tipo_consulta="+tipo_consulta+
											"&fecha_reporte="+dia+'/'+mes+'/'+ano;
		window.open('desarrollo_tabla_detalles_equipo_movil.php?'+poststr, "REPORTE_IGPP2","status=0, toolbar=0, width=360, height=300, scrollbars=1");
}

function genera_reporte_estatus_planta()
{
	poststr					=	'fecha_reporte='+document.getElementById('fecha_carga_reporte').value+
								'&turno_reporte='+document.getElementById('select_turno').value;
	if (document.getElementById('oculto_modulo')) 	modulo	=	document.getElementById('oculto_modulo').value;
	else											modulo	=	"estatus_planta";

	window.open('modules/'+modulo+'/reporte_estatus_planta2.php?'+poststr, "_blank", "height=700, width=1024, status=1, toolbar=0, scrollbars=1, resizable=yes");
}

function boton_actualiza_accidentes()	/////probado
{
	poststr					=	'dia='+document.getElementById('fecha_carga').value+
								'&turno='+document.getElementById('select_turno').value;
	if (document.getElementById('oculto_modulo')) 	modulo	=	document.getElementById('oculto_modulo').value;
	else											modulo	=	"estatus_planta";
	var ob_ajax1 			=	null;
	makePOSTRequest(1, 0, 'modules/'+modulo+'/xml/ingresa_datos_accidentes_turno.php?'+poststr, poststr, ob_ajax1, 'tabla_datos_accidentes');
}

function guarda_datos_accidentes_turno(area)	/////probado
{
	document.getElementById('oculto_area').value	=	area;
	valida											=	validar_campos('accidentes');
	if (valida == 1)
	{	
		poststr					=	'dia='+document.getElementById('fecha_carga').value+
									'&turno='+document.getElementById('select_turno').value+
									'&area='+area+
									'&num_accidentes='+document.getElementById('num_accidentes_'+area).value+
									'&num_lesionados='+document.getElementById('num_lesionados_'+area).value;
		if (document.getElementById('oculto_modulo')) 	modulo	=	document.getElementById('oculto_modulo').value;
		else											modulo	=	"estatus_planta";
		var ob_ajax1 			=	null;
		makePOSTRequest(1, 0, 'modules/'+modulo+'/xml/procesa_ingresa_datos_accidentes_turno.php?'+poststr, poststr, ob_ajax1, 'repuesta_servidor_accidentes');
	}
	else 
		alert('Debe Completar Todos Los Campos');

}

function ventana_detalles_3(tipo_variable)
{
		var poststr 						=	"tipo_variable="+tipo_variable;
		window.open('tabla_detalles_buques_materias_primas.php?'+poststr, "REPORTE_IGPP2","status=0, toolbar=0, width=360, height=300, scrollbars=1");
}

function ventana_detalles_4(tipo_variable, tipo_consulta, dia, mes, ano, linea, turno_reporte)
{
		var poststr 					=	"tipo_variable="+tipo_variable+
											"&linea="+linea+
											"&turno_reporte="+turno_reporte+
											"&tipo_consulta="+tipo_consulta+
											"&fecha_reporte="+dia+'/'+mes+'/'+ano;
		window.open('tabla_detalles_otras_variables.php?'+poststr, "REPORTE_IGPP2","status=0, toolbar=0, width=360, height=300, scrollbars=1");
}

function ventana_detalles_5(tipo_variable, dia, mes, ano, linea, turno_reporte)
{
		var poststr 					=	"tipo_variable="+tipo_variable+
											"&linea="+linea+
											"&turno_reporte="+turno_reporte+
											"&fecha_reporte="+dia+'/'+mes+'/'+ano;
		window.open('tabla_detalles_celdas_observ.php?'+poststr, "REPORTE_IGPP2","status=0, toolbar=0, width=360, height=300, scrollbars=1");
}
/////////////////////////////////
//////////////////////////////////////
function limitText(campo) 
{
	limitField	=	document.getElementById(campo);
	limitNum	=	120;
	
	if (limitField.value.length > limitNum) {
		limitField.value = limitField.value.substring(0, limitNum);
	} else {
	}
}


		function borra_buque_mat_prima(materia_prima)
		{
			document.getElementById('fecha_material_'+materia_prima).value				=	"";
			document.getElementById('cantidad_material_'+materia_prima).value			=	"";
			document.getElementById('barco_material_'+materia_prima).value				=	"";
			document.getElementById('observacion_material_'+materia_prima).value		=	"";
		}

function resetearClave(){
	var poststr = "ficha="+document.getElementById('ficha_reset').value;
	var ficha = document.getElementById('ficha_reset').value;
	var ob_ajax_resetClave = null;
	var modulo;
	if (document.getElementById('oculto_modulo')) 	modulo	=	document.getElementById('oculto_modulo').value;
	else											modulo	=	"estatus_planta";
	var respuesta = confirm("¿Desea reiniciar la clave del usuario cuya ficha es "+ficha+" al valor 123456?");
	if(respuesta == true){
		makePOSTRequest(1, 0, 'modules/'+modulo+'/xml/reinicia_clave.php?'+poststr, poststr, ob_ajax_resetClave, 'reinicia_clave');
	}
}

