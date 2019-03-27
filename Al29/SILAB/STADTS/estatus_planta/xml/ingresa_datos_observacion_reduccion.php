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
									<br/><br/><h4>&nbsp; &nbsp; &nbsp; OBSERVACIÓN REDUCCIÓN LINEA 1</h4>
									<?php
										if ($dpto_observ == 0) 
											llenar_informacion_observacion(6, $dia, $turno, $db)?><br/>
						  </div>
							  <div id="tab2" width="150" name="Datos Originales" align="center" style="font-family:Verdana, Arial, Helvetica, sans-serif ">
									<br/><br/><h4>&nbsp; &nbsp; &nbsp; OBSERVACIÓN REDUCCIÓN LINEA 2</h4>
									<?php
										if ($dpto_observ == 0) 
											llenar_informacion_observacion(7, $dia, $turno, $db)?><br/>
						  </div>
						  <div id="tab3" width="150" name="Datos Originales" align="center" style="font-family:Verdana, Arial, Helvetica, sans-serif ">
									<br/><br/><h4>&nbsp; &nbsp; &nbsp; OBSERVACIÓN REDUCCIÓN LINEA 3</h4>
									<?php
										if ($dpto_observ == 0) 
											llenar_informacion_observacion(8, $dia, $turno, $db)?><br/>
						  </div>
						  <div id="tab4" width="150" name="Datos Originales" align="center" style="font-family:Verdana, Arial, Helvetica, sans-serif ">
									<br/><br/><h4>&nbsp; &nbsp; &nbsp; OBSERVACIÓN REDUCCIÓN LINEA 4</h4>
									<?php
										if ($dpto_observ == 0) 
											llenar_informacion_observacion(9, $dia, $turno, $db)?><br/>
						  </div>
						  <div id="tab5" width="150" name="Datos Originales" align="center" style="font-family:Verdana, Arial, Helvetica, sans-serif ">
									<br/><br/><h4>&nbsp; &nbsp; &nbsp; OBSERVACIÓN REDUCCIÓN LINEA 5</h4>
									<?php
										if ($dpto_observ == 0) 
											llenar_informacion_observacion(10, $dia, $turno, $db)?><br/>
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
				tabbar.addTab("ventana1","Línea 1","80px");
				tabbar.addTab("ventana2","Línea 2","80px");
				tabbar.addTab("ventana3","Línea 3","80px");
				tabbar.addTab("ventana4","Línea 4","80px");
				tabbar.addTab("ventana5","Línea 5","80px");
				tabbar.setContent("ventana1","tab1");
				tabbar.setContent("ventana2","tab2");
				tabbar.setContent("ventana3","tab3");
				tabbar.setContent("ventana4","tab4");
				tabbar.setContent("ventana5","tab5");
				tabbar.setTabActive("ventana1");
	</script>


<?php
	pg_close($db);
	
	function llenar_informacion_observacion($sub_area, $dia, $turno, $db)
	{
		if ($sub_area == 6) 	$linea	=	1;
		if ($sub_area == 7) 	$linea	=	2;
		if ($sub_area == 8) 	$linea	=	3;
		if ($sub_area == 9) 	$linea	=	4;
		if ($sub_area == 10) 	$linea	=	5;

		$sq_m1			=	"SELECT * FROM estatus_planta_observaciones WHERE fecha = '$dia' AND id_area = '1' 
							AND turno = '$turno' AND id_sub_area = '$sub_area' ORDER BY num_observacion;";
		$query_m1		=	mig_query($sq_m1, $db);
		$res_m1			=	pg_fetch_array($query_m1);
		$observ_linea	=	$res_m1['observacion'];
		
		$sq_m2_1		=	"SELECT * FROM estatus_planta_observaciones_reduccion_celdas WHERE fecha = '$dia' AND turno = '$turno' AND linea  = '$linea'
							AND tipo_observacion = '1'ORDER BY celda;";
		$query_m2_1		=	mig_query($sq_m2_1, $db);

		$sq_m2_2		=	"SELECT * FROM estatus_planta_observaciones_reduccion_celdas WHERE fecha = '$dia' AND turno = '$turno' AND linea  = '$linea'
							AND tipo_observacion = '2'ORDER BY celda;";
		$query_m2_2		=	mig_query($sq_m2_2, $db);

		$sq_m2_3		=	"SELECT * FROM estatus_planta_observaciones_reduccion_celdas WHERE fecha = '$dia' AND turno = '$turno' AND linea  = '$linea'
							AND tipo_observacion = '3'ORDER BY celda;";
		$query_m2_3		=	mig_query($sq_m2_3, $db);

		$sq_m2_4		=	"SELECT * FROM estatus_planta_observaciones_reduccion_celdas WHERE fecha = '$dia' AND turno = '$turno' AND linea  = '$linea'
							AND tipo_observacion = '4'ORDER BY celda;";
		$query_m2_4		=	mig_query($sq_m2_4, $db);

		while($res_m2_1	=	pg_fetch_array($query_m2_1))
		{
			if ($c1 == "")	$c1	=	$res_m2_1['celda'];
			else			$c1	=	$c1.", ".$res_m2_1['celda'];
		}
		while($res_m2_2	=	pg_fetch_array($query_m2_2))
		{
			if ($c2 == "")	$c2	=	$res_m2_2['celda'];
			else			$c2	=	$c2.", ".$res_m2_2['celda'];
		}
		while($res_m2_3	=	pg_fetch_array($query_m2_3))
		{
			if ($c3 == "")	$c3	=	$res_m2_3['celda'];
			else			$c3	=	$c3.", ".$res_m2_3['celda'];
		}
		while($res_m2_4	=	pg_fetch_array($query_m2_4))
		{
			if ($c4 == "")	$c4	=	$res_m2_4['celda'];
			else			$c4	=	$c4.", ".$res_m2_4['celda'];
		}
		?>
			<link rel="STYLESHEET" type="text/css" href="/scp/modules/estatus_planta/estilos1.css">
			<link rel="STYLESHEET" type="text/css" href="../estilos1.css">
			<input type="hidden" id="fecha" value="<?=$dia?>">
			<input type="hidden" id="turno" value="<?=$turno?>">
			<div style="width:100% ">
				<table cellpadding="0" cellspacing="0" border="0" style="width:75% ">
					<tr>
						<td class="encabezado_formulario_ingreso">Celdas Casco Rojo</td>
						<td class="encabezado_formulario_ingreso"><textarea id="celdas_casco_rojo_<?=$linea?>" cols="50" onKeyPress="javascript:if (event.keyCode > 47 && event.keyCode < 58) return true; else{if (event.keyCode == 44) return true;else return false;}"><?=$c1?></textarea></td>
					</tr>
					<tr>
						<td class="encabezado_formulario_ingreso">Celdas Derrame Floruro</td>
						<td class="encabezado_formulario_ingreso"><textarea id="celdas_derrame_floruro_<?=$linea?>" cols="50" onKeyPress="javascript:if (event.keyCode > 47 && event.keyCode < 58) return true; else{if (event.keyCode == 44) return true;else return false;}"><?=$c2?></textarea></td>
					</tr>
					<tr>
						<td class="encabezado_formulario_ingreso">Celdas Derrame Alúmina</td>
						<td class="encabezado_formulario_ingreso"><textarea id="celdas_derrame_alumina_<?=$linea?>" cols="50" onKeyPress="javascript:if (event.keyCode > 47 && event.keyCode < 58) return true; else{if (event.keyCode == 44) return true;else return false;}"><?=$c3?></textarea></td>
					</tr>
					<tr>
						<td class="encabezado_formulario_ingreso">Celdas con Falla Tolvas</td>
						<td class="encabezado_formulario_ingreso"><textarea id="celdas_tolva_bloqueada_<?=$linea?>" cols="50" onKeyPress="javascript:if (event.keyCode > 47 && event.keyCode < 58) return true; else{if (event.keyCode == 44) return true;else return false;}"><?=$c4?></textarea></td>
					</tr>
					<tr>
						<td class="encabezado_formulario_ingreso">Observación Supervisión Línea</td>
						<td class="encabezado_formulario_ingreso"><textarea id="observacion_sub_area_<?=$sub_area?>" cols="50" onKeyDown="limitText('observacion_sub_area_'+<?=$sub_area?>);"  onKeyUp="limitText('observacion_sub_area_'+<?=$sub_area?>);" onClick="limitText('observacion_sub_area_'+<?=$sub_area?>);"" ><?=$observ_linea?></textarea></td>
					</tr>
				</table>
				<br/><br/>
				<input type="button" value="Procesar Linea" onClick="guarda_datos_observaciones(<?=$sub_area?>, 1)">
			</div>
		<?php
	}
?>