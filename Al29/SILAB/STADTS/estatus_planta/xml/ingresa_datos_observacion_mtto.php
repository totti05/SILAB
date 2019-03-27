	<link rel="STYLESHEET" type="text/css" href="http://control/scp/includes/dhtmlx/dhtmlxTabbar/codebase/dhtmlxtabbar.css">
	<script  src="http://control/scp/includes/dhtmlx/dhtmlxTabbar/sources/dhtmlxcommon.js"></script>
	<script  src="http://control/scp/includes/dhtmlx/dhtmlxTabbar/sources/dhtmlxtabbar.js"></script>
	<script  src="http://control/scp/includes/dhtmlx/dhtmlxTabbar/sources/dhtmlxtabbar_start.js"></script>
	<script  src="http://control/scp/modules/estatus_planta/funciones_java.js"></script>
	<link rel="STYLESHEET" type="text/css" href="/scp/modules/estatus_planta/estilos1.css">
	<link rel="STYLESHEET" type="text/css" href="../estilos1.css">
<?php
	$dia			=	$_GET['dia'];
	$turno			=	$_GET['turno'];
	include '../conectarse.php';
	$db				=	conectarse_postgres();
	
	?>
		<center>
		<table align="center"> 
			<tr>
				<td>
					<div id="tab_datos_igpp" style="width:660px; height:300px;" onMouseOver="limpiar_div(6)"> 
						  <div id="tab1" width="150" name="Datos Originales" align="center" style="font-family:Verdana, Arial, Helvetica, sans-serif ">
									<br/><br/>
									<h4>&nbsp; &nbsp; &nbsp; OBSERVACIÓN MANTENIMIENTO - TALLER AUTOMOTRIZ</h4>
									<?php
										if ($dpto_observ == 0) 
											llenar_informacion_observacion(35, $dia, $turno, $db)?><br/>
						  </div>
							  <div id="tab2" width="150" name="Datos Originales" align="center" style="font-family:Verdana, Arial, Helvetica, sans-serif ">
									<br/><br/><h4>&nbsp; &nbsp; &nbsp; OBSERVACIÓN MANTENIMIENTO - ALTO VOLTAJE</h4>
									<?php
										if ($dpto_observ == 0) 
											llenar_informacion_observacion(36, $dia, $turno, $db)?><br/>
						  </div>
						  <div id="tab3" width="150" name="Datos Originales" align="center" style="font-family:Verdana, Arial, Helvetica, sans-serif ">
									<br/><br/><h4>&nbsp; &nbsp; &nbsp; OBSERVACIÓN MANTENIMIENTO - SERVICIOS INDUSTRIALES</h4>
									<?php
										if ($dpto_observ == 0) 
											llenar_informacion_observacion(37, $dia, $turno, $db)?><br/>
						  </div>
				</div>
				</td>
			</tr>
		</table>
		<div id="letrero_avisos"></div>
		<div id="myspan"></div>
		<div id="myspan2"></div>

	<script id='evaluar_javascript'>
				tabbar=new dhtmlXTabBar("tab_datos_igpp","top");
				tabbar.setImagePath("http://control/scp/includes/dhtmlx/dhtmlxTabbar/codebase/imgs/");
				tabbar.addTab("ventana1","Taller Autom.","80px");
				tabbar.addTab("ventana2","Oper. Alto Volt.","120px");
				tabbar.addTab("ventana3","Oper. Sist.Ind.","120px");
				tabbar.setContent("ventana1","tab1");
				tabbar.setContent("ventana2","tab2");
				tabbar.setContent("ventana3","tab3");
				tabbar.setTabActive("ventana1");
	</script>


<?php
	pg_close($db);
	
	function llenar_informacion_observacion($sub_area, $dia, $turno, $db)
	{

		$sq_m1			=	"SELECT * FROM estatus_planta_observaciones WHERE fecha = '$dia' AND id_area = '6' 
							AND turno = '$turno' AND id_sub_area = '$sub_area' ORDER BY num_observacion;";
		$query_m1		=	mig_query($sq_m1, $db);
		$res_m1			=	pg_fetch_array($query_m1);
		$observ_linea	=	$res_m1['observacion'];

		$sq_m2			=	"SELECT * FROM estatus_planta_diccionario_sub_area WHERE id_sub_area  = '$sub_area'";
		$query_m2		=	mig_query($sq_m2, $db);
		$res_m2			=	pg_fetch_array($query_m2);
		$d_sub_area		=	$res_m2['desc_sub_area'];
		?>
			<link rel="STYLESHEET" type="text/css" href="/scp/modules/estatus_planta/estilos1.css">
			<link rel="STYLESHEET" type="text/css" href="../estilos1.css">
			<input type="hidden" id="fecha" value="<?=$dia?>">
			<input type="hidden" id="turno" value="<?=$turno?>">
			<div style="width:100% ">
				<table cellpadding="0" cellspacing="0" border="0" style="width:85% ">
					<tr>
						<td class="encabezado_formulario_ingreso" style="width:30% ">Observación <?=$d_sub_area?></td>
						<td class="cuerpo_formulario_ingreso_1"><textarea cols="50" rows="5" id="observacion_sub_area_<?=$sub_area?>"  onKeyDown="limitText('observacion_sub_area_'+<?=$sub_area?>);"  onKeyUp="limitText('observacion_sub_area_'+<?=$sub_area?>);"><?=$observ_linea?></textarea></td>
					</tr>
				</table>
				<br/><br/>
				<input type="button" value="Procesar Observacion" onClick="guarda_datos_observaciones(<?=$sub_area?>, 6)">
			</div>
		<?php
	}
?>