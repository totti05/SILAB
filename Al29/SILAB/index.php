<?php
if (!eregi("modules.php", $PHP_SELF)) {
   die ("Usted no puede accesar esta aplicacion en forma directa.....");
}

require_once("mainfile.php");
$module_name = basename(dirname(__FILE__));
get_lang($module_name);
include("header.php");
include("funciones.php");
include ("libreria/calendario/calendario.php");
include ("libreria/libreria_funciones.php");
include ("libreria/libreria_js.php");



$index = 0;
global $user;

getusrinfo($user);
cookiedecode($user);
$uname = $cookie[1];
$uname = $uname +1;
$uname = $uname -1;

include("validar.php");

global $gadministrador;

function menu(){
  OpenTable();
  
		global $module_name;
		global $usuario;
		$ThemeSel = get_theme();
		echo "<div align='center'>$usuario</div><br>";
		echo "<center><a href =\"modules.php?name=$module_name\"><img src=\"modules/$module_name/images/imagen_membrete.gif\" border=\"0\"       alt=\"\"></a><br><br>";
	
	//	echo "<center><a href=\"modules.php?name=$module_name\"><img src=\"modules/$module_name/imagenes/imagen_tipito.gif\"border=\"0\"            alt=\"\"></a><br<br>";   
		echo "<font class=\"content\">[ ";

		echo "<a href=\"modules.php?name=$module_name&amp;l_op=Opt1\">"."Gestion"."</a>"
		." | <a href=\"modules.php?name=$module_name&amp;l_op=Opt2\">"."Reportes"."</a>".
		" | <a target=\"_blank\" href=\"modules/SILAB/PRUEBA/inicio.php?verificado=1\">"."Prueba"."</a> ]";
		echo "</font></center>";
 
 CloseTable();
}

global $Existe_en_Grupo  ;
if ($Existe_en_Grupo  >0)
{
	switch($l_op) {
	   case "Opt1":
		menu();
		break;
	
		case "Opt2":
		menu();
		 pide_entre_fecha("repo","REPORTE DE GESTION");
		break;
		
		case "repo":
		 menu();
		 mostrar_reporte();
		break;
	
		
		
		default;
		menu();
		break;
	
	}
}
else
 	{   
	    Usuario_Alerta();
    }

include("footer.php");

?>
