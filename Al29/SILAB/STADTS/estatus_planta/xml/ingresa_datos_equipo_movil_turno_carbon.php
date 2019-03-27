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
					<div id="tab_datos_igpp" style="width:660px; height:515px;" onMouseOver="limpiar_div(4)"> 
						  <div id="tab1" width="150" name="Datos Originales" align="center" style="font-family:Verdana, Arial, Helvetica, sans-serif ">
									<br/><br/><h4>&nbsp; &nbsp; &nbsp; EQUIPO MÓVIL CARBON - MOLIENDA</h4>
									<?=informacion_equipo_movil(2, $dia, $turno, $db)?><br/>
						  </div>
							  <div id="tab2" width="150" name="Datos Originales" align="center" style="font-family:Verdana, Arial, Helvetica, sans-serif ">
									<br/><br/><h4>&nbsp; &nbsp; &nbsp; EQUIPO MÓVIL CARBON - HORNOS</h4>
									<?=informacion_equipo_movil(3, $dia, $turno, $db)?><br/>
						  </div>
						  <div id="tab3" width="150" name="Datos Originales" align="center" style="font-family:Verdana, Arial, Helvetica, sans-serif ">
									<br/><br/><h4>&nbsp; &nbsp; &nbsp; EQUIPO MÓVIL CARBON - ENVARILLADO</h4>
									<?=informacion_equipo_movil(4, $dia, $turno, $db)?><br/>
						  </div>
						  <div id="tab4" width="150" name="Datos Originales" align="center" style="font-family:Verdana, Arial, Helvetica, sans-serif ">
									<br/><br/><h4>&nbsp; &nbsp; &nbsp; EQUIPO MÓVIL CARBON - ESTACION DE BAÑO 1</h4>
									<?=informacion_equipo_movil(16, $dia, $turno, $db)?><br/>
						  </div>
						  <div id="tab5" width="150" name="Datos Originales" align="center" style="font-family:Verdana, Arial, Helvetica, sans-serif ">
									<br/><br/><h4>&nbsp; &nbsp; &nbsp; EQUIPO MÓVIL CARBON - ESTACION DE BAÑO 2</h4>
									<?=informacion_equipo_movil(17, $dia, $turno, $db)?><br/>
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
				tabbar.addTab("ventana1","Molienda","80px");
				tabbar.addTab("ventana2","Hornos","80px");
				tabbar.addTab("ventana3","Envarillado","80px");
				tabbar.addTab("ventana4","Est. Baño 1","80px");
				tabbar.addTab("ventana5","Est. Baño 2","80px");
				tabbar.setContent("ventana1","tab1");
				tabbar.setContent("ventana2","tab2");
				tabbar.setContent("ventana3","tab3");
				tabbar.setContent("ventana4","tab4");
				tabbar.setContent("ventana5","tab5");
				tabbar.setTabActive("ventana1");
	</script>


<?php
	
	
	function informacion_equipo_movil($sub_area, $dia, $turno, $db)	///PARA COLADA Y REDUCCIÓN
	{
		$sq_m1				=	"SELECT tipo_equipo_movil, SUM(cantidad_estandar) AS cantidad_estandar, SUM(cantidad_operativo) AS cantidad_operativo, sub_area
									FROM estaus_planta_equipo_movil WHERE fecha = '$dia' AND sub_area = '$sub_area' AND turno = '$turno'
									GROUP BY sub_area, tipo_equipo_movil ORDER BY sub_area, tipo_equipo_movil;";
		$query_m1				=	mig_query($sq_m1, $db);
		
		if ($sub_area == 4)							$arreglo_datos[0][1]	=	6;
		elseif ($sub_area == 2)						$arreglo_datos[0][1]	=	2;
		else										$arreglo_datos[0][1]	=	0;
		
		if ($sub_area == 4)							$arreglo_datos[0][2]	=	3;
		else										$arreglo_datos[0][2]	=	0;
		
		if ($sub_area == 4 || $sub_area == 2)		$arreglo_datos[0][4]	=	1;
		else										$arreglo_datos[0][4]	=	0;
		
													$arreglo_datos[1][1]	=	0;
													$arreglo_datos[1][2]	=	0;
		$arreglo_datos[0][3]	=	0;				$arreglo_datos[1][3]	=	0;
													$arreglo_datos[1][4]	=	0;
		$arreglo_datos[0][5]	=	0;				$arreglo_datos[1][5]	=	0;

		if ($sub_area == 3)					{		$arreglo_datos[0][1]	=	2;	$arreglo_datos[0][2]	=	2;		}		
		while($res_m1			=	pg_fetch_array($query_m1))
		{
			if ($res_m1['tipo_equipo_movil'] == 1)
			{
				if ($res_m1['cantidad_estandar'] > 0)	$arreglo_datos[0][1]	=	$res_m1['cantidad_estandar'];
				if ($res_m1['cantidad_operativo'] > 0)	$arreglo_datos[1][1]	=	$res_m1['cantidad_operativo'];
			}
			if ($res_m1['tipo_equipo_movil'] == 2)
			{
				if ($res_m1['cantidad_estandar'] > 0)	$arreglo_datos[0][2]	=	$res_m1['cantidad_estandar'];
				if ($res_m1['cantidad_operativo'] > 0)	$arreglo_datos[1][2]	=	$res_m1['cantidad_operativo'];
			}
			if ($res_m1['tipo_equipo_movil'] == 3)
			{
				if ($res_m1['cantidad_estandar'] > 0)	$arreglo_datos[0][3]	=	$res_m1['cantidad_estandar'];
				if ($res_m1['cantidad_operativo'] > 0)	$arreglo_datos[1][3]	=	$res_m1['cantidad_operativo'];
			}
			if ($res_m1['tipo_equipo_movil'] == 4)
			{
				if ($res_m1['cantidad_estandar'] > 0)	$arreglo_datos[0][4]	=	$res_m1['cantidad_estandar'];
				if ($res_m1['cantidad_operativo'] > 0)	$arreglo_datos[1][4]	=	$res_m1['cantidad_operativo'];
			}
			if ($res_m1['tipo_equipo_movil'] == 5)
			{
				if ($res_m1['cantidad_estandar'] > 0)	$arreglo_datos[0][5]	=	$res_m1['cantidad_estandar'];
				if ($res_m1['cantidad_operativo'] > 0)	$arreglo_datos[1][5]	=	$res_m1['cantidad_operativo'];
			}
		}
		
		?>
			<link rel="STYLESHEET" type="text/css" href="/scp/modules/estatus_planta/estilos1.css">
			<link rel="STYLESHEET" type="text/css" href="../estilos1.css">
			<input type="hidden" id="fecha" value="<?=$dia?>"><input type="hidden" id="oculto_sub_area">
			<div style="width:100%; text-align:center ">
				<table style="width:80%; text-align:center" border="0" cellpadding="0" cellspacing="0">
					<tr>
						<td colspan="6">INFORMACIÓN EQUIPO MOVIL AREA <?=$area_equipo?></td>
					</tr>
					<tr>
						<td>&nbsp;</td>
						<td class="encabezado_formulario_ingreso">Montacargas</td>
						<td class="encabezado_formulario_ingreso">Remolcadores</td>
						<td class="encabezado_formulario_ingreso">Skyder</td>
						<td class="encabezado_formulario_ingreso">Payloader</td>
						<td class="encabezado_formulario_ingreso">Camión</td>
					</tr>
					<tr>
						<td class="encabezado_formulario_ingreso">Estándar</td>
						<td class="cuerpo_formulario_ingreso_1"><input type="text" id="estandar_1_sub_area_<?=$sub_area?>" size="2" maxlength="2" value="<?=$arreglo_datos[0][1]?>" onKeyPress="javascript:if(event.keyCode<46 || event.keyCode>57){return false;}"></td>
						<td class="cuerpo_formulario_ingreso_1"><input type="text" id="estandar_2_sub_area_<?=$sub_area?>" size="2" maxlength="2" value="<?=$arreglo_datos[0][2]?>" onKeyPress="javascript:if(event.keyCode<46 || event.keyCode>57){return false;}"></td>
						<td class="cuerpo_formulario_ingreso_1"><input type="text" id="estandar_3_sub_area_<?=$sub_area?>" size="2" maxlength="2" value="<?=$arreglo_datos[0][3]?>" onKeyPress="javascript:if(event.keyCode<46 || event.keyCode>57){return false;}"></td>
						<td class="cuerpo_formulario_ingreso_1"><input type="text" id="estandar_4_sub_area_<?=$sub_area?>" size="2" maxlength="2" value="<?=$arreglo_datos[0][4]?>" onKeyPress="javascript:if(event.keyCode<46 || event.keyCode>57){return false;}"></td>
						<td class="cuerpo_formulario_ingreso_1"><input type="text" id="estandar_5_sub_area_<?=$sub_area?>" size="2" maxlength="2" value="<?=$arreglo_datos[0][5]?>" onKeyPress="javascript:if(event.keyCode<46 || event.keyCode>57){return false;}"></td>
					</tr>
					<tr>
						<td class="encabezado_formulario_ingreso">Operativo</td>
						<td class="cuerpo_formulario_ingreso_1"><input type="text" id="operativo_1_sub_area_<?=$sub_area?>" size="2" maxlength="2" value="<?=$arreglo_datos[1][1]?>" onKeyPress="javascript:if(event.keyCode<46 || event.keyCode>57){return false;}"></td>
						<td class="cuerpo_formulario_ingreso_1"><input type="text" id="operativo_2_sub_area_<?=$sub_area?>" size="2" maxlength="2" value="<?=$arreglo_datos[1][2]?>" onKeyPress="javascript:if(event.keyCode<46 || event.keyCode>57){return false;}"></td>
						<td class="cuerpo_formulario_ingreso_1"><input type="text" id="operativo_3_sub_area_<?=$sub_area?>" size="2" maxlength="2" value="<?=$arreglo_datos[1][3]?>" onKeyPress="javascript:if(event.keyCode<46 || event.keyCode>57){return false;}"></td>
						<td class="cuerpo_formulario_ingreso_1"><input type="text" id="operativo_4_sub_area_<?=$sub_area?>" size="2" maxlength="2" value="<?=$arreglo_datos[1][4]?>" onKeyPress="javascript:if(event.keyCode<46 || event.keyCode>57){return false;}"></td>
						<td class="cuerpo_formulario_ingreso_1"><input type="text" id="operativo_5_sub_area_<?=$sub_area?>" size="2" maxlength="2" value="<?=$arreglo_datos[1][5]?>" onKeyPress="javascript:if(event.keyCode<46 || event.keyCode>57){return false;}"></td>
					</tr>
				</table>
				<br/>
				<input type="button" value="Procesar Area" onClick="guarda_datos_equipo_movil_turno(<?=$sub_area?>, 2)"/>
			</div>
		<?php
	}
?>