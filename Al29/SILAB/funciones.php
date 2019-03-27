
<?php


function mostrar_reporte(){
global $f1;
global $f2;
OpenTable();
//echo $f1."     ";
//echo $f2;
header("location: http://control/scp/modules/gestion/funciones_r.php?f1=$f1");
CloseTable();
}


function pide_entre_fecha($xmenu,$titulo){
	global $module_name;
	
	OpenTable();
	$ThemeSel = get_theme();
	$tiempo_actual = time(); 
	$d = date("j", $tiempo_actual); 
	$m = date("n", $tiempo_actual); 
	$a = date("Y", $tiempo_actual);
	$fecha1 = "$d/$m/$a";
	$fecha2 = "$d/$m/$a";
	$f1 = "$d/$m/$a";
	$f2 = "$d/$m/$a";
 ?>
	<link href="ESTILO.css" rel="stylesheet" type="text/css" class="ESTILO2">

	<table border="1">
 	            <tr>
				<td align="center"  bgcolor="#66CCFF"><?php echo $titulo; ?></td>
				</tr>
		<tr><td>
			<table bordercolor="#000000" bgcolor="#CCFFFF"> 
				<form name="fcalen" method="POST" action="modules.php?name=<? echo $module_name; ?>&l_op=<?php echo $xmenu;?>&f1=<?php echo $fecha1; ?>&f2=<?php echo $fecha2; ?>">		
<?php   		/* Enlace al calendario permitira seleccionar una fecha de inicio q servira como filtro para mostrar las solicitudes por status*/ ?>
	    		
				<tr>
					<td width="100">&nbsp;</td>
					<td width="150"><font color="#000000"><?php echo "Fecha Inicio"; ?></font></td>
					<td width="50"><?php escribe_formulario_fecha_novacio("f1","fcalen",$f1);?></td>
					<td width="100">&nbsp;</td>
					<td width="150"><font color="#000000"><?php echo "Fecha Final"; ?></font></td>
					<td width="50"><?php escribe_formulario_fecha_novacio("f2","fcalen",$f2);?></td>
					<td width="100">&nbsp;</td>
					<td width="150"><div align="center"><input name="acep" type="submit" value="CONSULTAR"></div></td>
	    		</tr>
				</form>
			</table>
		</td></tr>
	</table> 
<?php 

	CloseTable();
}


function Inluir_opciones(){
OpenTable();
       global $module_name;
?>
     
<div align="center" class="Estilo1">Incluir opciones</div>
<form name="form1" action="modules.php?name=<?php echo $module_name?>&amp;l_op=Graba" method="POST">
		<table width="200" title="Grupos" align="center" border="1">
	  <tr>
		<td align="right">Grupo:</td>
		<td><input name="Grupo" type="text" value="0" size="3" maxlength="3"  type_letra=E onChange="MM_validateForm('Grupo','','NinRange0:999');return document.MM_returnValue"></td>
	  </tr>
	  <tr>
		<td align="right">Descripcion: </td>
		<td><input name="Descripcion" type="text" size="20" maxlength="20" type_letra=L ></td>
	  </tr>
	   <tr>
	   <td> </td>
		<td align="center"><input type="submit" name="Submit" value="Enviar"></td>
	   </tr>
	</table>
	<input type="hidden" name="MM_insert" value="form1">
</form>

<?php
CloseTable();
}

//***********************************************************?>

<?php
function Grabar(){
	
	OpenTable();
       global $xfecha;
	   global $xficha;
	   
				if (!($link=mssql_connect("ALUMINIO20\DHW","COMIDA","COMIDA")))
		   { 
			  echo "Error conectando a la base de datos."; 
			  exit(); 
		   } 
								  
								 
		   if (!mssql_select_db ("COMIDA",$link))
		   { 
			  echo "Error seleccionando la base de datos."; 
			  exit(); 
		   } 
		   mssql_close($link);
	   
     
   
   
    CloseTable();
}
?>