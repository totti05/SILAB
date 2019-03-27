<?php

if (!eregi("modules.php", $PHP_SELF)) {
   die ("Usted no puede accesar esta aplicacion en forma directa...");
}
require_once("mainfile.php");
$module_name = basename(dirname(__FILE__));
get_lang($module_name);
include("header.php");
include ("libreria/libreria_funciones.php");
include "funciones.php";
include 'conectarse.php';

$index = 0;
global $user, $f1, $tipo_menu1;
getusrinfo($user);
cookiedecode($user);

$uname = $cookie[1];
$uname = $uname +1;
$uname = $uname -1;

include("validar.php");

if ($gadministrador1 == 1) $menu_mostrar = "data_menu.xml";
else $menu_mostrar = "data_menu2.xml";
//------------------------MENU DE ACTUALIZACION

?>

	<link rel="STYLESHEET" type="text/css" href="/scp/includes/dhtmlx/dhtmlxMenu/codebase/dhtmlxmenu.css">
	<link rel="STYLESHEET" type="text/css" href="/scp/includes/dhtmlx/dhtmlxMenu/samples/common/dhtmlxmenu_alter.css">
	<script language="JavaScript" src="/scp/includes/dhtmlx/dhtmlxMenu/codebase/dhtmlxprotobar.js"></script>
	<script language="JavaScript" src="/scp/includes/dhtmlx/dhtmlxMenu/codebase/dhtmlxmenubar.js"></script>
	<script language="JavaScript" src="/scp/includes/dhtmlx/dhtmlxMenu/codebase/dhtmlxcommon.js"></script>

	<link rel="STYLESHEET" type="text/css" href="/scp/includes/dhtmlx/dhtmlxTabbar/codebase/dhtmlxtabbar.css">
	<script  src="/scp/includes/dhtmlx/dhtmlxTabbar/sources/dhtmlxcommon.js"></script>
	<script  src="/scp/includes/dhtmlx/dhtmlxTabbar/sources/dhtmlxtabbar.js"></script>
	<script  src="/scp/includes/dhtmlx/dhtmlxTabbar/sources/dhtmlxtabbar_start.js"></script>

	<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
    <script type='text/javascript' src='/scp/includes/zapatec/utils/zapatec.js'></script>
	<script type="text/javascript" src="/scp/includes/zapatec/zpcal/src/calendar.js"></script>
	<script type="text/javascript" src="/scp/includes/zapatec/zpcal/lang/calendar-es.js"></script>
	
	<link href="/scp/includes/zapatec/website/css/zpcal.css" rel="stylesheet" type="text/css">

	<!-- Theme css -->
	<link href="/scp/includes/zapatec/zpcal/themes/fancyblue.css" rel="stylesheet" type="text/css">
	<script type="text/javascript" src="/scp/modules/estatus_planta/funciones_java.js"></script>
	<script type="text/javascript" src="/scp/modules/estatus_planta/ajaxes.js"></script>

<?php



function menu_s200(){
	
  OpenTable();  
		global $module_name;
		global $usuario;
		$ThemeSel = get_theme();
		echo "<CENTER><B></B>MODIFICAR OBSERVACIONES DE AREAS </CENTER><BR> <font class=\"content\"><center>[ ";
		echo "<a href=\"modules.php?name=$module_name&amp;funcion=Opt1\">"."REDUCCION"."</a>"
		." | <a href=\"modules.php?name=$module_name&amp;funcion=Opt3\">"."COLADA"."</a>"
		." | <a href=\"modules.php?name=$module_name&amp;funcion=Opt2\">"."CARBON"."</a>"
		." | <a href=\"modules.php?name=$module_name&amp;funcion=Opt4\">"."SCP"."</a>"
		." | <a href=\"modules.php?name=$module_name&amp;funcion=Opt6\">"."MANTENIMIENTO"."</a> ]";
		echo "</font></center>";
 
 CloseTable();
}

function menu() {
 	global $module_name, $usuario, $menu_mostrar;
	$ThemeSel = get_theme();
	list($nombre, $ficha)		=	split(':', $usuario);
	$usuario					=	$ficha;
?>
  <table align="center">
  	<tr>
  		<td>
		<table>
			<tr>
				<td align><?=OpenTable()?>
					<center><?=$usuario?><br/><br/><a style="text-align:center " href="modules.php?name=<?=$module_name?>"><img align="middle" src="modules/<?=$module_name?>/imagenes/estatus_planta.png" border="0" alt="Ir a pag. principal"></a><br><br></center>
					<?=CloseTable()?>
				</td>
			</tr>
			<tr><td>&nbsp;</td></tr>
			<tr>
				<td>
					<div id="altermenu" style="width:610px;"></div>
				</td>
			</tr>
		</table>
		<br><br>
		<div id="icono_espera_ajax"  style="visibility:hidden"><img src="/scp/modules/<?=$module_name?>/imagenes/cargando.gif"></div>
		<script>
			function onButtonClick(itemId,itemValue) {
				
			};
			
				aMenuBar2=new dhtmlXMenuBarObject(document.getElementById('altermenu'),'600px',30,"");
				aMenuBar2.setGfxPath("/scp/includes/dhtmlx/dhtmlxMenu/codebase/imgs/");
				aMenuBar2.loadXML("modules/<?=$module_name?>/xml/<?=$menu_mostrar?>");
				aMenuBar2.showBar();
		</script>
		</td>
	</tr>
</table>
<br/>
<div id="aviso_ajax_cargando"></div>
<input type="hidden" id="oculto_modulo" value="<?=$module_name?>">
<input type="hidden" id="usuario_modulo" value="<?=$usuario?>">
<?php
}
//------------------------MENU DE ACTUALIZACION
global $Existe_en_Grupo, $gadministrador, $gadministrador1, $gadministrador2, $tipo_usuario_1, $tipo_usuario_2;
if ($tipo_usuario_1 == 1	) $area_usuario = 1;  //REDUCCION
if ($tipo_usuario_1 == 3	) $area_usuario = 3;  //COLADA
if ($tipo_usuario_1 == 2	) $area_usuario = 2;  //CARBON
if ($tipo_usuario_1 == 4	) $area_usuario = 4;  //CCYP
if ($tipo_usuario_1 == 6	) $area_usuario = 6;  //MANTENIMIENTO
if ($tipo_usuario_2 == 7	) $area_usuario = 7;  //SUPERVISOR

if ($gadministrador  > 0 || $gadministrador2  > 0)
//if ($gadministrador  > 0 )
{	
	menu();
	if ($gadministrador  > 0)
	{
		   if ($tipo_usuario_2 == 7) 
		      { 
  			    menu_s200();
			  }
			  
		switch($funcion) 
		{
			
			case "Opt1":
			  $Area=1;
			  formulario_ingresa_pantalla_manual_observaciones($Area);
			break;	
			
			case "Opt2":
			  $Area=2;
			  formulario_ingresa_pantalla_manual_observaciones($Area);
			break;	
			
			case "Opt3":
			  $Area=3;
			  formulario_ingresa_pantalla_manual_observaciones($Area);
			break;		
			
			case "Opt4":
			  $Area=4;
			  formulario_ingresa_pantalla_manual_observaciones($Area);
			break;	
			
			case "Opt6":
			  $Area=6;
			  formulario_ingresa_pantalla_manual_observaciones($Area);
			break;	
														
			
			case "formulario_cargar_datos_por_turno":
			formulario_cargar_datos_por_turno();
			break;
			
			case "formulario_cargar_datos_por_dia":
			formulario_cargar_datos_por_dia();
			break;
			
			case "formulario_ingresa_pantalla_manual_reduccion_turno":
			formulario_ingresa_pantalla_manual_reduccion('turno');
			break;

			case "formulario_ingresa_pantalla_manual_colada_turno":
			formulario_ingresa_pantalla_manual_colada();
			break;

			case "formulario_ingresa_pantalla_manual_carbon_turno":
			formulario_ingresa_pantalla_manual_carbon('turno');
			break;
			
			case "formulario_ingresa_pantalla_manual_reduccion_dia":
			formulario_ingresa_pantalla_manual_reduccion('dia');
			break;

			case "formulario_ingresa_pantalla_manual_carbon_dia":
			formulario_ingresa_pantalla_manual_carbon('dia');
			break;
			
			//observaciones			

			case "formulario_ingresa_pantalla_manual_observaciones_1":
//			formulario_ingresa_pantalla_manual_observaciones(1);area_usuario
             if ($tipo_usuario_2 != 7) 
		      { 
			    formulario_ingresa_pantalla_manual_observaciones($area_usuario);
			  }
			break;
	
			case "formulario_ingresa_pantalla_manual_observaciones_3":
			//formulario_ingresa_pantalla_manual_observaciones(3);
			if ($tipo_usuario_2 != 7) 
		      { 
			    formulario_ingresa_pantalla_manual_observaciones($area_usuario);
		      }
			break;

			case "formulario_ingresa_pantalla_manual_observaciones_2":
			//formulario_ingresa_pantalla_manual_observaciones(2);
			if ($tipo_usuario_2 != 7) 
		      { 
			    formulario_ingresa_pantalla_manual_observaciones($area_usuario);
			  }
			break;

			case "formulario_ingresa_pantalla_manual_observaciones_4":
			//formulario_ingresa_pantalla_manual_observaciones(4);
			if ($tipo_usuario_2 != 7) 
		      { 
			    formulario_ingresa_pantalla_manual_observaciones($area_usuario);
			  }
			break;

			case "formulario_ingresa_pantalla_manual_observaciones_6":
			//formulario_ingresa_pantalla_manual_observaciones(6);
			if ($tipo_usuario_2 != 7) 
		      { 
			    formulario_ingresa_pantalla_manual_observaciones($area_usuario);
			  }
			break;
		   

			case "formulario_ingresa_pantalla_manual_accidentes":
			formulario_ingresa_pantalla_manual_accidentes('turno');
			break;

			case "formulario_ingresa_pantalla_manual_equipo_movil_turno_1":
			$area		=	$_GET['area'];
			$sub_tipo	=	$_GET['sub_tipo'];
				formulario_ingresa_pantalla_manual_equipo_movil_turno($area, $sub_tipo);
			break;

			case "formulario_ingresa_pantalla_manual_fase_densa_turno":   ///
			formulario_ingresa_pantalla_manual_fase_densa_turno();
			break;

			case "formulario_ingresa_pantalla_manual_manejo_mat_turno":   ////
			formulario_ingresa_pantalla_manual_manejo_mat_turno();
			break;

			case "formulario_ingresa_pantalla_manual_materias_primas_dia":   ///
			formulario_ingresa_pantalla_manual_materias_primas_dia();
			break;

			case "formulario_select_usuario_clave":
			formulario_select_usuario_clave();
			break;

			case "formulario_select_plan_pco_suministros":
			formulario_select_plan_pco_suministros();
			break;
		}
	}
	if ($gadministrador2 > 0)
	{
		switch($funcion) 
		{
			case "pide_reporte_estatus_planta":
			formulario_genera_reporte_estatus_planta();
			break;
		}
	}
}
else  	
{   
    Usuario_Alerta();
}

include("footer.php");

?>
