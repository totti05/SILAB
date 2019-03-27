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
					<div id="tab_datos_igpp" style="width:660px; height:515px;" onMouseOver="limpiar_div(1)"> 
						  <div id="tab1" width="150" name="Datos Originales" align="center" style="font-family:Verdana, Arial, Helvetica, sans-serif ">
									<br/><br/><h4>&nbsp; &nbsp; &nbsp; DATOS DEL ÁREA REDUCCIÓN LINEA 1</h4>
									<?=llenar_informacion_linea(1, $dia, $turno, $db)?><br/>
						  </div>
							  <div id="tab2" width="150" name="Datos Originales" align="center" style="font-family:Verdana, Arial, Helvetica, sans-serif ">
									<br/><br/><h4>&nbsp; &nbsp; &nbsp; DATOS DEL ÁREA REDUCCIÓN LINEA 2</h4>
									<?=llenar_informacion_linea(2, $dia, $turno, $db)?><br/>
						  </div>
						  <div id="tab3" width="150" name="Datos Originales" align="center" style="font-family:Verdana, Arial, Helvetica, sans-serif ">
									<br/><br/><h4>&nbsp; &nbsp; &nbsp; DATOS DEL ÁREA REDUCCIÓN LINEA 3</h4>
									<?=llenar_informacion_linea(3, $dia, $turno, $db)?><br/>
						  </div>
						  <div id="tab4" width="150" name="Datos Originales" align="center" style="font-family:Verdana, Arial, Helvetica, sans-serif ">
									<br/><br/><h4>&nbsp; &nbsp; &nbsp; DATOS DEL ÁREA REDUCCIÓN LINEA 4</h4>
									<?=llenar_informacion_linea(4, $dia, $turno, $db)?><br/>
						  </div>
						  <div id="tab5" width="150" name="Datos Originales" align="center" style="font-family:Verdana, Arial, Helvetica, sans-serif ">
									<br/><br/><h4>&nbsp; &nbsp; &nbsp; DATOS DEL ÁREA REDUCCIÓN LINEA 5</h4>
									<?=llenar_informacion_linea(5, $dia, $turno, $db)?><br/>
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
	
	function llenar_informacion_linea($linea, $dia, $turno, $db)
	{
		$sq_m1			=	"SELECT * FROM estatus_planta_reduccion_turno WHERE fecha = '$dia' AND turno = '$turno' AND tipo_campo = '1' AND linea = '$linea'";
		$query_m1		=	mig_query($sq_m1, $db);
		$n_max1			=	pg_num_rows($query_m1);
		if($n_max1 == 0)	$n_max1			=	25;

		$sq_m2			=	"SELECT * FROM estatus_planta_reduccion_turno WHERE fecha = '$dia' AND turno = '$turno' AND tipo_campo = '2' AND linea = '$linea'";
		$query_m2		=	mig_query($sq_m2, $db);
		$n_max2			=	pg_num_rows($query_m2);
		if($n_max2 == 0)	$n_max2			=	5;

		$sq_m3			=	"SELECT * FROM estatus_planta_reduccion_turno WHERE fecha = '$dia' AND turno = '$turno' AND tipo_campo = '3' AND linea = '$linea'";
		$query_m3		=	mig_query($sq_m3, $db);
		$n_max3			=	pg_num_rows($query_m3);
		if($n_max3 == 0)	$n_max3			=	25;

		$sq_m4			=	"SELECT * FROM estatus_planta_reduccion_turno WHERE fecha = '$dia' AND turno = '$turno' AND tipo_campo = '4' AND linea = '$linea'";
		$query_m4		=	mig_query($sq_m4, $db);
		$n_max4			=	pg_num_rows($query_m4);
		if($n_max4 == 0)	$n_max4			=	25;

		$sq_m5			=	"SELECT * FROM estatus_planta_reduccion_turno WHERE fecha = '$dia' AND turno = '$turno' AND tipo_campo = '5' AND linea = '$linea'";
		$query_m5		=	mig_query($sq_m5, $db);
		$n_max5			=	pg_num_rows($query_m5);
		if($n_max5 == 0)	$n_max5			=	25;
		
		$sq_m6			=	"SELECT * FROM estatus_planta_reduccion_turno WHERE fecha = '$dia' AND turno = '$turno' AND tipo_campo = '6' AND linea = '$linea'";
		$query_m6		=	mig_query($sq_m6, $db);
		$n_max6			=	pg_num_rows($query_m6);
		if($n_max6 == 0)	$n_max6			=	1;
		
		$sq_m7			=	"SELECT * FROM estatus_planta_reduccion_turno WHERE fecha = '$dia' AND turno = '$turno' AND tipo_campo = '7' AND linea = '$linea'";
		$query_m7		=	mig_query($sq_m7, $db);
		$n_max7			=	pg_num_rows($query_m7);
		if($n_max7 == 0)	$n_max7			=	1;

		$n1				=	0;
		$n2				=	0;
		$n3				=	0;
		$n4				=	0;
		$n5				=	0;
		$n6				=	0;
		$n7				=	0;
		?>
				<link rel="STYLESHEET" type="text/css" href="/scp/modules/estatus_planta/estilos1.css">
				<link rel="STYLESHEET" type="text/css" href="../estilos1.css">
				<input type="hidden" id="fecha" value="<?=$dia?>">
				<input type="hidden" id="turno" value="<?=$turno?>">
				<div style="width:100% ">
					<table style="width:100%" border="0" cellpadding="0" cellspacing="0">
						<tr>
							<td style="text-align:center; width:25%; height:185px">
								<div id="celdas_alta_temperatura" style="overflow:auto; height:160px">
									<table style="width:80%;" cellpadding="0" cellspacing="0" border="0">
										<tr>
											<td colspan="2" class="encabezado_formulario_ingreso">CELDAS ALTA TEMP.</td>
										</tr>
										<tr>
											<td class="encabezado_formulario_ingreso">Celda</td>
											<td class="encabezado_formulario_ingreso">ºC</td>
										</tr>
										<?php
										while($n1 < $n_max1)
										{
											$res_m1		=	pg_fetch_array($query_m1);
										?>
											<tr>
												<td class="cuerpo_formulario_ingreso_1"><input type="text" id="linea_<?=$linea?>_celda_alta_temp_<?=$n1?>" size="3" maxlength="4" value="<?=$res_m1['num_celda']?>" onKeyPress="javascript:if(event.keyCode<46 || event.keyCode>57){return false;}"></td>
												<td class="cuerpo_formulario_ingreso_1"><input type="text" id="linea_<?=$linea?>_valor_alta_temp_<?=$n1?>" size="3" maxlength="4" value="<?=$res_m1['valor_variable']?>" onKeyPress="javascript:if(event.keyCode<46 || event.keyCode>57){return false;}"></td>
											</tr>
										<?php
											$n1++;
										}
										?><input type="hidden" id="linea_<?=$linea?>_registros_celda_alta_temp" value="<?=$n1?>">
									</table>
								</div>
							</td>
							<td style="text-align:center; width:25%; height:185px">
								<div id="celdas_inestables" style="overflow:auto; height:160px">
									<table style="width:80%;" cellpadding="0" cellspacing="0" border="0">
										<tr>
											<td colspan="2" class="encabezado_formulario_ingreso">DESVIACIÓN DE CELDAS</td>
										</tr>
										<tr>
											<td class="encabezado_formulario_ingreso">Celda</td>
											<td class="encabezado_formulario_ingreso">Desv.</td>
										</tr>
										<?php
										while($n5 < $n_max5)
										{
											$res_m5		=	pg_fetch_array($query_m5);
										?>
											<tr>
												<td class="cuerpo_formulario_ingreso_1"><input type="text" id="linea_<?=$linea?>_celda_desv_resist_<?=$n5?>" size="3" maxlength="4" value="<?=$res_m5['num_celda']?>" onKeyPress="javascript:if(event.keyCode<46 || event.keyCode>57){return false;}"></td>
												<td class="cuerpo_formulario_ingreso_1"><input type="text" id="linea_<?=$linea?>_valor_desv_resist_<?=$n5?>" size="3" maxlength="4" value="<?=$res_m5['valor_variable']?>" onKeyPress="javascript:if(event.keyCode<46 || event.keyCode>57){return false;}"></td>
											</tr>
										<?php
											$n5++;
										}
										?><input type="hidden" id="linea_<?=$linea?>_registros_celda_desv_resist" value="<?=$n5?>">
									</table>
								</div>
							</td>
							<td style="text-align:center; width:25%; height:185px">
								<div id="celdas_alto_ea" style="overflow:auto; height:160px">
									<table style="width:80%;" cellpadding="0" cellspacing="0" border="0">
										<tr>
											<td colspan="2" class="encabezado_formulario_ingreso">CELDAS EA > 1</td>
										</tr>
										<tr>
											<td class="encabezado_formulario_ingreso">Celda</td>
											<td class="encabezado_formulario_ingreso"># EA</td>
										</tr>
										<?php
										while($n2 < $n_max2)
										{
											$res_m2		=	pg_fetch_array($query_m2);
										?>
											<tr>
												<td class="cuerpo_formulario_ingreso_1"><input type="text" id="linea_<?=$linea?>_celda_ea_<?=$n2?>" size="3" maxlength="4" value="<?=$res_m2['num_celda']?>" onKeyPress="javascript:if(event.keyCode<46 || event.keyCode>57){return false;}"></td>
												<td class="cuerpo_formulario_ingreso_1"><input type="text" id="linea_<?=$linea?>_valor_ea_<?=$n2?>" size="3" maxlength="2" value="<?=$res_m2['valor_variable']?>" onKeyPress="javascript:if(event.keyCode<46 || event.keyCode>57){return false;}"></td>
											</tr>
										<?php
											$n2++;
										}
										?><input type="hidden" id="linea_<?=$linea?>_registros_celda_ea" value="<?=$n2?>">
									</table>
								</div>
							</td>
						</tr>
						<tr>
							<td style="text-align:center; width:25%; height:185px">
								<div id="celdas_alta_temperatura" style="overflow:auto; height:160px">
									<table style="width:80%;" cellpadding="0" cellspacing="0" border="0">
										<tr>
											<td colspan="2" class="encabezado_formulario_ingreso">CELDAS NIVEL METAL CRITICO </td>
										</tr>
										<tr>
											<td class="encabezado_formulario_ingreso">Celda</td>
											<td class="encabezado_formulario_ingreso">NIV MET </td>
										</tr>
										<?php
										while($n3 < $n_max3)
										{
											$res_m3		=	pg_fetch_array($query_m3);
										?>
											<tr>
												<td class="cuerpo_formulario_ingreso_1"><input type="text" id="linea_<?=$linea?>_celda_niv_metal_<?=$n3?>" size="3" maxlength="4" value="<?=$res_m3['num_celda']?>" onKeyPress="javascript:if(event.keyCode<46 || event.keyCode>57){return false;}"></td>
												<td class="cuerpo_formulario_ingreso_1"><input type="text" id="linea_<?=$linea?>_valor_niv_metal_<?=$n3?>" size="3" maxlength="2" value="<?=$res_m3['valor_variable']?>" onKeyPress="javascript:if(event.keyCode<46 || event.keyCode>57){return false;}"></td>
											</tr>
										<?php
											$n3++;
										}
										?><input type="hidden" id="linea_<?=$linea?>_registros_niv_metal" value="<?=$n3?>">
									</table>
								</div>
							</td>
							<td style="text-align:center; width:25%; height:185px">
								<div id="celdas_inestables" style="overflow:auto; height:160px">
									<table style="width:80%;" cellpadding="0" cellspacing="0" border="0">
										<tr>
											<td colspan="2" class="encabezado_formulario_ingreso">CELDAS NIVEL BAÑO CRITICO</td>
										</tr>
										<tr>
											<td class="encabezado_formulario_ingreso">Celda</td>
											<td class="encabezado_formulario_ingreso">NIV BAN </td>
										</tr>
										<?php
										while($n4 < $n_max4)
										{
											$res_m4		=	pg_fetch_array($query_m4);
										?>
											<tr>
												<td class="cuerpo_formulario_ingreso_1"><input type="text" id="linea_<?=$linea?>_celda_niv_baño_<?=$n4?>" size="3" maxlength="4" value="<?=$res_m4['num_celda']?>" onKeyPress="javascript:if(event.keyCode<46 || event.keyCode>57){return false;}"></td>
												<td class="cuerpo_formulario_ingreso_1"><input type="text" id="linea_<?=$linea?>_valor_niv_baño_<?=$n4?>" size="3" maxlength="2" value="<?=$res_m4['valor_variable']?>" onKeyPress="javascript:if(event.keyCode<46 || event.keyCode>57){return false;}"></td>
											</tr>
										<?php
											$n4++;
										}
										?><input type="hidden" id="linea_<?=$linea?>_registros_niv_baño" value="<?=$n4?>">
									</table>
								</div>
							</td>
							<td style="text-align:center; width:25%; height:185px">
								<div id="celdas_alto_ea" style="overflow:auto; height:160px">
									<table style="width:80%;" cellpadding="0" cellspacing="0" border="0">
										<tr>
											<td colspan="2" class="encabezado_formulario_ingreso">PRESION AIRE</td>
										</tr>
										<tr>
											<td class="encabezado_formulario_ingreso">Celda</td>
											<td class="encabezado_formulario_ingreso">PSI</td>
										</tr>
										<?php
										while($n6 < $n_max6)
										{
											$res_m6		=	pg_fetch_array($query_m6);
										?>
											<tr>
												<td class="cuerpo_formulario_ingreso_1"><input type="text" id="linea_<?=$linea?>_celda_presion_aire_<?=$n6?>" size="3" maxlength="4" value="<?=$res_m6['num_celda']?>" onKeyPress="javascript:if(event.keyCode<46 || event.keyCode>57){return false;}"></td>
												<td class="cuerpo_formulario_ingreso_1"><input type="text" id="linea_<?=$linea?>_valor_presion_aire_<?=$n6?>" size="3" maxlength="3" value="<?=$res_m6['valor_variable']?>" onKeyPress="javascript:if(event.keyCode<46 || event.keyCode>57){return false;}"></td>
											</tr>
										<?php
											$n6++;
										}
										?>
										<tr>
											<td colspan="2" class="encabezado_formulario_ingreso">ANODOS SERVIDOS</td>
										</tr>
										<tr>
											<td class="encabezado_formulario_ingreso">Celda</td>
											<td class="encabezado_formulario_ingreso"># ANODOS</td>
										</tr>
										<?php
										while($n7 < $n_max7)
										{
											$res_m7		=	pg_fetch_array($query_m7);
										?>
											<tr>
												<td class="cuerpo_formulario_ingreso_1"><input type="text" id="linea_<?=$linea?>_celda_anodos_servidos_<?=$n7?>" size="3" maxlength="4" value="<?=$res_m7['num_celda']?>" onKeyPress="javascript:if(event.keyCode<46 || event.keyCode>57){return false;}"></td>
												<td class="cuerpo_formulario_ingreso_1"><input type="text" id="linea_<?=$linea?>_valor_anodos_servidos_<?=$n7?>" size="3" maxlength="4" value="<?=$res_m7['valor_variable']?>" onKeyPress="javascript:if(event.keyCode<46 || event.keyCode>57){return false;}"></td>
											</tr>
										<?php
											$n7++;
										}
										?>
									</table>
								</div>
							</td>
						</tr>
					</table>
				<input type="button" value="Procesar Linea" onClick="guarda_datos_reduccion_turno(<?=$linea?>)">
				</div>
		<?php
	}
?>