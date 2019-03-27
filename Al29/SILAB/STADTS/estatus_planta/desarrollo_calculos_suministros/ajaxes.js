// JavaScript Document
function crea_objeto_ajax()
{
	http_request = false;
	if (window.XMLHttpRequest) 
	{ // Mozilla, Safari,...
		http_request = new XMLHttpRequest();
	} else 
	{
		http_request=new ActiveXObject("Microsoft.XMLHTTP");
		} 
	if (!http_request) {
		alert('Cannot create XMLHTTP instance');
		return false;
	}
	return http_request;
}

function makePOSTRequest(tipo_ajax, control, url, parameters, objetoajax, cual_ajax)
{ // funcion generica, utilizada principalmente para crear listas dependientes
	objetoajax=crea_objeto_ajax();
	if (control == 0)	control	=	'aviso_ajax_cargando';
	objetoajax.open('GET', url, true);
	//objetoajax.setRequestHeader("Cache-Control", "no-cache"); //Agregado por: Sergio Hernández el 10/08/2013 a las 21:04,
	objetoajax.setRequestHeader( "Cache-Control", "max-age=0,no-cache,no-store,post-check=0,pre-check=0"); //Agregado por: Sergio Hernández el 12/08/2013 a las 08:04,
															  //se coloca como solución a falla reportada por los usuarios
															  //en lo referente a desaparicion de informacion.
	objetoajax.onreadystatechange=function()
	{ 
		if (objetoajax.readyState==1)
		{
			document.getElementById(control).innerHTML = " Aguarde por favor...";
		}
	
		if (objetoajax.readyState==4)
		{
			if (objetoajax.status == 200) //200: OK
			{
				if (tipo_ajax == 1)  /// ajax html
				{
					result = objetoajax.responseText;
				}
				if (tipo_ajax == 2)  //// ajax xml
				{
					result = objetoajax.responseXML;
				}
				verificar_cual_ajax(result, cual_ajax);
				document.getElementById(control).innerHTML = "";
			}
			else //Se produjo un error
			{
				alert("No se pudo recuperar la información: " + objetoajax.statusText);
			} 
		} 
	}
	objetoajax.send(parameters);
}

function verificar_cual_ajax(result, cual_ajax)
{
	if (cual_ajax == 'respuesta_carga_datos_carbon_turno')			recibe_xml_respuesta_carga_datos_carbon_turno(result);
	if (cual_ajax == 'respuesta_carga_datos_colada_turno')			recibe_xml_respuesta_carga_datos_colada_turno(result);
	if (cual_ajax == 'respuesta_carga_datos_reduccion_turno')		recibe_xml_respuesta_carga_datos_reduccion_turno(result);
	if (cual_ajax == 'tabla_datos_reduccion')						recibe_xml_tabla_datos_reduccion(result);
	if (cual_ajax == 'repuesta_servidor_reduccion')					recibe_xml_repuesta_servidor_reduccion(result);
	if (cual_ajax == 'tabla_datos_colada')							recibe_xml_tabla_datos_colada(result);
	if (cual_ajax == 'repuesta_servidor_colada')					recibe_xml_repuesta_servidor_colada(result);
	if (cual_ajax == 'tabla_datos_carbon')							recibe_xml_tabla_datos_carbon(result);
	if (cual_ajax == 'repuesta_servidor_carbon')					recibe_xml_repuesta_servidor_carbon(result);
	if (cual_ajax == 'respuesta_carga_datos_carbon_dia')			recibe_xml_respuesta_carga_datos_carbon_dia(result);
	if (cual_ajax == 'respuesta_carga_datos_reduccion_dia')			recibe_xml_respuesta_carga_datos_reduccion_dia(result);
	if (cual_ajax == 'tabla_datos_equipo_movil')					recibe_xml_tabla_datos_equipo_movil(result);
	if (cual_ajax == 'respuesta_carga_datos_equipo_movil_turno_1')	recibe_xml_respuesta_carga_datos_equipo_movil_turno_1(result);
	if (cual_ajax == 'respuesta_carga_datos_equipo_movil_turno_2')	recibe_xml_respuesta_carga_datos_equipo_movil_turno_2(result);
	if (cual_ajax == 'respuesta_carga_datos_equipo_movil_turno_3')	recibe_xml_respuesta_carga_datos_equipo_movil_turno_3(result);
	if (cual_ajax == 'tabla_datos_materias_primas')					recibe_xml_tabla_datos_materias_primas(result);
	if (cual_ajax == 'repuesta_servidor_materias_primas')			recibe_xml_repuesta_servidor_materias_primas(result);
	if (cual_ajax == 'tabla_datos_observacion')						recibe_xml_tabla_datos_observacion(result);
	if (cual_ajax == 'repuesta_servidor_observ')					recibe_xml_repuesta_servidor_observ(result);
	if (cual_ajax == 'tabla_datos_accidentes')						recibe_xml_tabla_datos_accidentes(result);
	if (cual_ajax == 'repuesta_servidor_accidentes')				recibe_xml_repuesta_servidor_accidentes(result);
	if (cual_ajax == 'respuesta_carga_datos_muelle_dia')			recibe_xml_respuesta_carga_datos_muelle_dia(result);
	if (cual_ajax == 'reinicia_clave')								recibe_text_reinicia_clave(result);
	if (cual_ajax == 'tabla_datos_auxiliares')						recibe_xml_tabla_datos_auxiliares(result);
	if (cual_ajax == 'repuesta_servidor_auxiliares')				recibe_xml_repuesta_servidor_auxiliares(result);
	if (cual_ajax == 'tabla_datos_plan_pco_suministros')			recibe_xml_tabla_datos_plan_pco_suministros(result);
	if (cual_ajax == 'ingresa_db_datos_plan_pco_suministros')		recibe_xml_ingresa_db_datos_plan_pco_suministros(result);
}

function recibe_text_reinicia_clave(result) {
	document.getElementById('mensaje_reset_clave').innerHTML = result;
}

function recibe_xml_tabla_datos_reduccion(result)
{
	document.getElementById('formulario_ingresa_datos_reduccion').innerHTML				=	result;
	eval(document.getElementById('evaluar_javascript').innerHTML)
}

function	recibe_xml_respuesta_carga_datos_carbon_turno(result)
{
	document.getElementById('respuesta_carga_datos_turno1').innerHTML					=	result;
}

function recibe_xml_respuesta_carga_datos_colada_turno(result)
{
	document.getElementById('respuesta_carga_datos_turno2').innerHTML					=	result;
}

function recibe_xml_respuesta_carga_datos_reduccion_turno(result)
{
	document.getElementById('respuesta_carga_datos_turno3').innerHTML					=	result;
}

function recibe_xml_repuesta_servidor_reduccion(result)
{
	document.getElementById('respuesta_ingresa_datos_reduccion').innerHTML				=	result;
}

function recibe_xml_tabla_datos_colada(result)
{
	document.getElementById('formulario_ingresa_datos_colada').innerHTML				=	result;
	eval(document.getElementById('evaluar_javascript').innerHTML)
}

function recibe_xml_tabla_datos_auxiliares(result)
{
//	document.getElementById('formulario_ingresa_datos_reduccion').innerHTML					=	"";    /////	FALTA COLOCAR LO QUE RESPONDE CUANDO PROCESA EL TURNO
	document.getElementById('formulario_ingresa_datos_auxiliares').innerHTML					=	result;
	eval(document.getElementById('evaluar_javascript').innerHTML)
}

function recibe_xml_repuesta_servidor_auxiliares(result)
{
//	document.getElementById('formulario_ingresa_datos_reduccion').innerHTML					=	"";    /////	FALTA COLOCAR LO QUE RESPONDE CUANDO PROCESA EL TURNO
	document.getElementById('respuesta_ingresa_datos_auxiliares').innerHTML					=	result;
}

function recibe_xml_tabla_datos_carbon(result)
{
	document.getElementById('formulario_ingresa_datos_carbon').innerHTML				=	result;
	eval(document.getElementById('evaluar_javascript').innerHTML)
}

function recibe_xml_repuesta_servidor_carbon(result)
{
//	document.getElementById('formulario_ingresa_datos_reduccion').innerHTML					=	"";    /////	FALTA COLOCAR LO QUE RESPONDE CUANDO PROCESA EL TURNO
	document.getElementById('respuesta_ingresa_datos_carbon').innerHTML					=	result;
}

function	recibe_xml_respuesta_carga_datos_carbon_dia(result)
{
	document.getElementById('respuesta_carga_datos_dia1').innerHTML						=	result;
}

function recibe_xml_respuesta_carga_datos_reduccion_dia(result)
{
	document.getElementById('respuesta_carga_datos_dia2').innerHTML						=	result;
}

function recibe_xml_tabla_datos_equipo_movil(result)
{
	document.getElementById('formulario_ingresa_datos_equipo_movil').innerHTML			=	result;
	eval(document.getElementById('evaluar_javascript').innerHTML)
}

function	recibe_xml_respuesta_carga_datos_equipo_movil_turno_1(result)
{
	document.getElementById('respuesta_carga_datos_equipo_movil_turno_1').innerHTML		=	result;
}

function	recibe_xml_respuesta_carga_datos_equipo_movil_turno_2(result)
{
	document.getElementById('respuesta_carga_datos_equipo_movil_turno_2').innerHTML		=	result;
}

function	recibe_xml_respuesta_carga_datos_equipo_movil_turno_3(result)
{
	document.getElementById('respuesta_carga_datos_equipo_movil_turno_3').innerHTML		=	result;
}

function recibe_xml_tabla_datos_materias_primas(result)
{
	document.getElementById('formulario_ingresa_datos_materias_primas').innerHTML		=	result;
	eval(document.getElementById('evaluar_javascript').innerHTML);
	eval(document.getElementById('fechas_java').innerHTML);
}

function	recibe_xml_repuesta_servidor_materias_primas(result)
{
	document.getElementById('respuesta_carga_datos_materias_primas_dia').innerHTML		=	result;
}

function recibe_xml_tabla_datos_observacion(result)
{
	document.getElementById('formulario_ingresa_datos_observaciones').innerHTML			=	result;
	eval(document.getElementById('evaluar_javascript').innerHTML)
}

function	recibe_xml_repuesta_servidor_observ(result)
{
	document.getElementById('respuesta_carga_datos_observ').innerHTML					=	result;
}

function recibe_xml_tabla_datos_accidentes(result)
{
	document.getElementById('formulario_ingresa_datos_accidentes').innerHTML			=	result;
	eval(document.getElementById('evaluar_javascript').innerHTML)
}

function	recibe_xml_repuesta_servidor_accidentes(result)
{
	document.getElementById('repuesta_servidor_accidentes').innerHTML					=	result;
}

function  recibe_xml_respuesta_carga_datos_muelle_dia(result)
{
	document.getElementById('respuesta_carga_datos_dia3').innerHTML						=	result;
}

function  recibe_xml_tabla_datos_plan_pco_suministros(result)
{
	document.getElementById('formulario_ingresa_datos_pco_suministros').innerHTML		=	result;
}

function  recibe_xml_ingresa_db_datos_plan_pco_suministros(result)
{
	document.getElementById('repuesta_servidor_suministros').innerHTML					=	result;
	document.getElementById('formulario_ingresa_datos_pco_suministros').innerHTML		=	"";
}

