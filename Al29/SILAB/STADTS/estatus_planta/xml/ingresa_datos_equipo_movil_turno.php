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

	?><center>
		<table align="center"> 
			<tr>
				<td>
					<div id="tab_datos_igpp" style="width:660px; height:410px;" onMouseOver="limpiar_div(4)"> 
						  <div id="tab1" width="150" name="Datos Originales" align="center" style="font-family:Verdana, Arial, Helvetica, sans-serif ">
									<br/><br/><h4>&nbsp; &nbsp; &nbsp; EQUIPO MOVIL DEL ÁREA REDUCCIÓN</h4>
									<?=informacion_equipo_movil(1, $dia, $db, 1, $turno, "REDUCCION")?><br/>
						  </div>
							  <div id="tab2" width="150" name="Datos Originales" align="center" style="font-family:Verdana, Arial, Helvetica, sans-serif ">
									<br/><br/><h4>&nbsp; &nbsp; &nbsp; EQUIPO MOVIL DEL ÁREA CARBÓN</h4>
									<?=informacion_equipo_movil(2, $dia, $db, 1, $turno, "CARBON - MOLIENDA")?><br/>
						  </div>
						  <div id="tab3" width="150" name="Datos Originales" align="center" style="font-family:Verdana, Arial, Helvetica, sans-serif ">
									<br/><br/><h4>&nbsp; &nbsp; &nbsp; EQUIPO MOVIL DEL ÁREA COLADA</h4>
									<?=informacion_equipo_movil(3, $dia, $db, 2, $turno, "COLADA")?><br/>
						  </div>
				</div>
				</td>
			</tr>
		</table>
		<div id="letrero_avisos"></div>
		<div id="myspan"></div>

	<script id='evaluar_javascript'>
				tabbar=new dhtmlXTabBar("tab_datos_igpp","top");
				tabbar.setImagePath("http://control/scp/includes/dhtmlx/dhtmlxTabbar/codebase/imgs/");
				tabbar.addTab("ventana1","Reducción","80px");
				tabbar.addTab("ventana2","Carbón","80px");
				tabbar.addTab("ventana3","Colada","80px");
				tabbar.setContent("ventana1","tab1");
				tabbar.setContent("ventana2","tab2");
				tabbar.setContent("ventana3","tab3");
				tabbar.setTabActive("ventana1");
	</script>


<?php
	
	
	function informacion_equipo_movil($area, $dia, $db, $ind, $turno, $area_equipo)	///PARA COLADA Y REDUCCIÓN
	{
		$sq_m1			=	"SELECT tipo_equipo_movil, SUM(cantidad_estandar) AS cantidad_estandar, SUM(cantidad_operativo) AS cantidad_operativo, sub_area
							FROM estaus_planta_equipo_movil WHERE fecha = '$dia' AND area = '$area' AND turno = '$turno'
							GROUP BY sub_area, tipo_equipo_movil ORDER BY sub_area, tipo_equipo_movil;";
		$query_m1		=	mig_query($sq_m1, $db); 
		
		$arreglo_datos[1][1]['estandar']		=	0;		$arreglo_datos[1][1]['operativo']		=	0;
		$arreglo_datos[1][2]['estandar']		=	0;		$arreglo_datos[1][2]['operativo']		=	0;
		$arreglo_datos[1][3]['estandar']		=	0;		$arreglo_datos[1][3]['operativo']		=	0;
		$arreglo_datos[1][4]['estandar']		=	0;		$arreglo_datos[1][4]['operativo']		=	0;
		$arreglo_datos[1][5]['estandar']		=	0;		$arreglo_datos[1][5]['operativo']		=	0;

		$arreglo_datos[2][1]['estandar']		=	0;		$arreglo_datos[2][1]['operativo']		=	0;
		$arreglo_datos[2][2]['estandar']		=	0;		$arreglo_datos[2][2]['operativo']		=	0;
		$arreglo_datos[2][3]['estandar']		=	0;		$arreglo_datos[2][3]['operativo']		=	0;
		$arreglo_datos[2][4]['estandar']		=	0;		$arreglo_datos[2][4]['operativo']		=	0;
		$arreglo_datos[2][5]['estandar']		=	0;		$arreglo_datos[2][5]['operativo']		=	0;

		$arreglo_datos[3][1]['estandar']		=	0;		$arreglo_datos[3][1]['operativo']		=	0;
		$arreglo_datos[3][2]['estandar']		=	0;		$arreglo_datos[3][2]['operativo']		=	0;
		$arreglo_datos[3][3]['estandar']		=	0;		$arreglo_datos[3][3]['operativo']		=	0;
		$arreglo_datos[3][4]['estandar']		=	0;		$arreglo_datos[3][4]['operativo']		=	0;
		$arreglo_datos[3][5]['estandar']		=	0;		$arreglo_datos[3][5]['operativo']		=	0;

		while($res_m1	=	pg_fetch_array($query_m1))
		{
			if ($area == 2)
			{	
				if ($res_m1['sub_area']	==	2)
				{
					$num								=	$res_m1['tipo_equipo_movil'];
					if ($res_m1['cantidad_estandar'] > 0) 	$arreglo_datos[1][$num]['estandar']		=	$res_m1['cantidad_estandar'];
					if ($res_m1['cantidad_operativo'] > 0) $arreglo_datos[1][$num]['operativo']	=	$res_m1['cantidad_operativo'];
				}
				if ($res_m1['sub_area']	==	3)
				{
					$num								=	$res_m1['tipo_equipo_movil'];
					if ($res_m1['cantidad_estandar'] > 0) 	$arreglo_datos[2][$num]['estandar']		=	$res_m1['cantidad_estandar'];
					if ($res_m1['cantidad_operativo'] > 0) $arreglo_datos[2][$num]['operativo']	=	$res_m1['cantidad_operativo'];
				}
				if ($res_m1['sub_area']	==	4)
				{
					$num								=	$res_m1['tipo_equipo_movil'];
					if ($res_m1['cantidad_estandar'] > 0) 	$arreglo_datos[3][$num]['estandar']		=	$res_m1['cantidad_estandar'];
					if ($res_m1['cantidad_operativo'] > 0) $arreglo_datos[3][$num]['operativo']	=	$res_m1['cantidad_operativo'];
				}
			}
			else
			{
				$num								=	$res_m1['tipo_equipo_movil'];
				if ($res_m1['cantidad_estandar'] > 0) 	$arreglo_datos[1][$num]['estandar']	=	$res_m1['cantidad_estandar'];
				if ($res_m1['cantidad_operativo'] > 0) $arreglo_datos[1][$num]['operativo']	=	$res_m1['cantidad_operativo'];
			}
		}
		?>
			<link rel="STYLESHEET" type="text/css" href="/scp/modules/estatus_planta/estilos1.css">
			<link rel="STYLESHEET" type="text/css" href="../estilos1.css">
			<input type="hidden" id="fecha" value="<?=$dia?>"><input type="hidden" id="oculto_area">
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
						<td class="cuerpo_formulario_ingreso_1"><input type="text" id="estandar_1_<?=$ind?>_area_<?=$area?>" size="2" maxlength="2" value="<?=$arreglo_datos[1][1]['estandar']?>" onKeyPress="javascript:if(event.keyCode<46 || event.keyCode>57){return false;}"></td>
						<td class="cuerpo_formulario_ingreso_1"><input type="text" id="estandar_2_<?=$ind?>_area_<?=$area?>" size="2" maxlength="2" value="<?=$arreglo_datos[1][2]['estandar']?>" onKeyPress="javascript:if(event.keyCode<46 || event.keyCode>57){return false;}"></td>
						<td class="cuerpo_formulario_ingreso_1"><input type="text" id="estandar_3_<?=$ind?>_area_<?=$area?>" size="2" maxlength="2" value="<?=$arreglo_datos[1][3]['estandar']?>" onKeyPress="javascript:if(event.keyCode<46 || event.keyCode>57){return false;}"></td>
						<td class="cuerpo_formulario_ingreso_1"><input type="text" id="estandar_4_<?=$ind?>_area_<?=$area?>" size="2" maxlength="2" value="<?=$arreglo_datos[1][4]['estandar']?>" onKeyPress="javascript:if(event.keyCode<46 || event.keyCode>57){return false;}"></td>
						<td class="cuerpo_formulario_ingreso_1"><input type="text" id="estandar_5_<?=$ind?>_area_<?=$area?>" size="2" maxlength="2" value="<?=$arreglo_datos[1][5]['estandar']?>" onKeyPress="javascript:if(event.keyCode<46 || event.keyCode>57){return false;}"></td>
					</tr>
					<tr>
						<td class="encabezado_formulario_ingreso">Operativo</td>
						<td class="cuerpo_formulario_ingreso_1"><input type="text" id="operativo_1_<?=$ind?>_area_<?=$area?>" size="2" maxlength="2" value="<?=$arreglo_datos[1][1]['operativo']?>" onKeyPress="javascript:if(event.keyCode<46 || event.keyCode>57){return false;}"></td>
						<td class="cuerpo_formulario_ingreso_1"><input type="text" id="operativo_2_<?=$ind?>_area_<?=$area?>" size="2" maxlength="2" value="<?=$arreglo_datos[1][2]['operativo']?>" onKeyPress="javascript:if(event.keyCode<46 || event.keyCode>57){return false;}"></td>
						<td class="cuerpo_formulario_ingreso_1"><input type="text" id="operativo_3_<?=$ind?>_area_<?=$area?>" size="2" maxlength="2" value="<?=$arreglo_datos[1][3]['operativo']?>" onKeyPress="javascript:if(event.keyCode<46 || event.keyCode>57){return false;}"></td>
						<td class="cuerpo_formulario_ingreso_1"><input type="text" id="operativo_4_<?=$ind?>_area_<?=$area?>" size="2" maxlength="2" value="<?=$arreglo_datos[1][4]['operativo']?>" onKeyPress="javascript:if(event.keyCode<46 || event.keyCode>57){return false;}"></td>
						<td class="cuerpo_formulario_ingreso_1"><input type="text" id="operativo_5_<?=$ind?>_area_<?=$area?>" size="2" maxlength="2" value="<?=$arreglo_datos[1][5]['operativo']?>" onKeyPress="javascript:if(event.keyCode<46 || event.keyCode>57){return false;}"></td>
					</tr>
					<?php
						if ($area == 2)
						{
						?>
							<tr>
								<td colspan="6">INFORMACIÓN EQUIPO MOVIL CARBON - HORNOS</td>
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
								<td class="cuerpo_formulario_ingreso_1"><input type="text" id="estandar_1_2_area_<?=$area?>" size="2" maxlength="2" value="<?=$arreglo_datos[2][1]['estandar']?>" onKeyPress="javascript:if(event.keyCode<46 || event.keyCode>57){return false;}"></td>
								<td class="cuerpo_formulario_ingreso_1"><input type="text" id="estandar_2_2_area_<?=$area?>" size="2" maxlength="2" value="<?=$arreglo_datos[2][2]['estandar']?>" onKeyPress="javascript:if(event.keyCode<46 || event.keyCode>57){return false;}"></td>
								<td class="cuerpo_formulario_ingreso_1"><input type="text" id="estandar_3_2_area_<?=$area?>" size="2" maxlength="2" value="<?=$arreglo_datos[2][3]['estandar']?>" onKeyPress="javascript:if(event.keyCode<46 || event.keyCode>57){return false;}"></td>
								<td class="cuerpo_formulario_ingreso_1"><input type="text" id="estandar_4_2_area_<?=$area?>" size="2" maxlength="2" value="<?=$arreglo_datos[2][4]['estandar']?>" onKeyPress="javascript:if(event.keyCode<46 || event.keyCode>57){return false;}"></td>
								<td class="cuerpo_formulario_ingreso_1"><input type="text" id="estandar_5_2_area_<?=$area?>" size="2" maxlength="2" value="<?=$arreglo_datos[2][5]['estandar']?>" onKeyPress="javascript:if(event.keyCode<46 || event.keyCode>57){return false;}"></td>
							</tr>
							<tr>
								<td class="encabezado_formulario_ingreso">Operativo</td>
								<td class="cuerpo_formulario_ingreso_1"><input type="text" id="operativo_1_2_area_<?=$area?>" size="2" maxlength="2" value="<?=$arreglo_datos[2][1]['operativo']?>" onKeyPress="javascript:if(event.keyCode<46 || event.keyCode>57){return false;}"></td>
								<td class="cuerpo_formulario_ingreso_1"><input type="text" id="operativo_2_2_area_<?=$area?>" size="2" maxlength="2" value="<?=$arreglo_datos[2][2]['operativo']?>" onKeyPress="javascript:if(event.keyCode<46 || event.keyCode>57){return false;}"></td>
								<td class="cuerpo_formulario_ingreso_1"><input type="text" id="operativo_3_2_area_<?=$area?>" size="2" maxlength="2" value="<?=$arreglo_datos[2][3]['operativo']?>" onKeyPress="javascript:if(event.keyCode<46 || event.keyCode>57){return false;}"></td>
								<td class="cuerpo_formulario_ingreso_1"><input type="text" id="operativo_4_2_area_<?=$area?>" size="2" maxlength="2" value="<?=$arreglo_datos[2][4]['operativo']?>" onKeyPress="javascript:if(event.keyCode<46 || event.keyCode>57){return false;}"></td>
								<td class="cuerpo_formulario_ingreso_1"><input type="text" id="operativo_5_2_area_<?=$area?>" size="2" maxlength="2" value="<?=$arreglo_datos[2][5]['operativo']?>" onKeyPress="javascript:if(event.keyCode<46 || event.keyCode>57){return false;}"></td>
							</tr>
							<tr>
								<td colspan="6">INFORMACIÓN EQUIPO MOVIL CARBON - ENVARILLADO</td>
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
								<td class="cuerpo_formulario_ingreso_1"><input type="text" id="estandar_1_3_area_<?=$area?>" size="2" maxlength="2" value="<?=$arreglo_datos[3][1]['estandar']?>"></td>
								<td class="cuerpo_formulario_ingreso_1"><input type="text" id="estandar_2_3_area_<?=$area?>" size="2" maxlength="2" value="<?=$arreglo_datos[3][2]['estandar']?>"></td>
								<td class="cuerpo_formulario_ingreso_1"><input type="text" id="estandar_3_3_area_<?=$area?>" size="2" maxlength="2" value="<?=$arreglo_datos[3][3]['estandar']?>"></td>
								<td class="cuerpo_formulario_ingreso_1"><input type="text" id="estandar_4_3_area_<?=$area?>" size="2" maxlength="2" value="<?=$arreglo_datos[3][4]['estandar']?>"></td>
								<td class="cuerpo_formulario_ingreso_1"><input type="text" id="estandar_5_3_area_<?=$area?>" size="2" maxlength="2" value="<?=$arreglo_datos[3][5]['estandar']?>"></td>
							</tr>
							<tr>
								<td class="encabezado_formulario_ingreso">Operativo</td>
								<td class="cuerpo_formulario_ingreso_1"><input type="text" id="operativo_1_3_area_<?=$area?>" size="2" maxlength="2" value="<?=$arreglo_datos[3][1]['operativo']?>"></td>
								<td class="cuerpo_formulario_ingreso_1"><input type="text" id="operativo_2_3_area_<?=$area?>" size="2" maxlength="2" value="<?=$arreglo_datos[3][2]['operativo']?>"></td>
								<td class="cuerpo_formulario_ingreso_1"><input type="text" id="operativo_3_3_area_<?=$area?>" size="2" maxlength="2" value="<?=$arreglo_datos[3][3]['operativo']?>"></td>
								<td class="cuerpo_formulario_ingreso_1"><input type="text" id="operativo_4_3_area_<?=$area?>" size="2" maxlength="2" value="<?=$arreglo_datos[3][4]['operativo']?>"></td>
								<td class="cuerpo_formulario_ingreso_1"><input type="text" id="operativo_5_3_area_<?=$area?>" size="2" maxlength="2" value="<?=$arreglo_datos[3][5]['operativo']?>"></td>
							</tr>
						<?php
						}
					?>
				</table>
				<br/>
				<input type="button" value="Procesar Area" onClick="guarda_datos_equipo_movil_turno(<?=$area?>)"/>
			</div>
		<?php
	}
?>