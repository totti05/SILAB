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


function menu() {
 	global $module_name, $usuario, $menu_mostrar;
	$ThemeSel = get_theme();
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
<?php
}
//------------------------MENU DE ACTUALIZACION
global $Existe_en_Grupo, $gadministrador;
if ($gadministrador  > 0 || $Existe_en_Grupo >= 0)
{	
	menu();
	if ($gadministrador  > 0)
	{
		switch($funcion) 
		{
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

			case "formulario_ingresa_pantalla_manual_materias_primas_dia":
			formulario_ingresa_pantalla_manual_materias_primas_dia();
			break;

			case "formulario_ingresa_pantalla_manual_observaciones_1":
			formulario_ingresa_pantalla_manual_observaciones(1);
			break;
	
			case "formulario_ingresa_pantalla_manual_observaciones_3":
			formulario_ingresa_pantalla_manual_observaciones(3);
			break;

			case "formulario_ingresa_pantalla_manual_observaciones_2":
			formulario_ingresa_pantalla_manual_observaciones(2);
			break;

			case "formulario_ingresa_pantalla_manual_observaciones_4":
			formulario_ingresa_pantalla_manual_observaciones(4);
			break;

			case "formulario_ingresa_pantalla_manual_accidentes":
			formulario_ingresa_pantalla_manual_accidentes('turno');
			break;

			case "formulario_ingresa_pantalla_manual_equipo_movil_turno_1":
			$area		=	$_GET['area'];
			$sub_tipo	=	$_GET['sub_tipo'];
				formulario_ingresa_pantalla_manual_equipo_movil_turno($area, $sub_tipo);
			break;

			case "formulario_select_usuario_clave":
			formulario_select_usuario_clave();
			break;
		}
	}
	if ($Existe_en_Grupo  >= 0)
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