	<link rel="STYLESHEET" type="text/css" href="http://control/scp/includes/dhtmlx/dhtmlxTabbar/codebase/dhtmlxtabbar.css">
	<script  src="http://control/scp/includes/dhtmlx/dhtmlxTabbar/sources/dhtmlxcommon.js"></script>
	<script  src="http://control/scp/includes/dhtmlx/dhtmlxTabbar/sources/dhtmlxtabbar.js"></script>
	<script  src="http://control/scp/includes/dhtmlx/dhtmlxTabbar/sources/dhtmlxtabbar_start.js"></script>
	<script  src="http://control/scp/modules/estatus_planta/funciones_java.js"></script>
	<link rel="STYLESHEET" type="text/css" href="/scp/modules/estatus_planta/estilos1.css">
	<link rel="STYLESHEET" type="text/css" href="../estilos1.css">
<?php
	$dia			=	$_GET['dia'];
	include '../conectarse.php';
	$db				=	conectarse_postgres();

	?><center>
		<table align="center"> 
			<tr>
				<td>
					<div id="tab_datos_igpp" style="width:660px; height:370px;" onMouseOver="limpiar_div(1)"> 
						  <div id="tab1" width="150" name="Datos Originales" align="center" style="font-family:Verdana, Arial, Helvetica, sans-serif ">
									<br/><br/><h4>&nbsp; &nbsp; &nbsp; DATOS DEL ÁREA REDUCCIÓN LINEA 1</h4>
									<?=llenar_informacion_linea(1, $dia, $db)?><br/>
						  </div>
							  <div id="tab2" width="150" name="Datos Originales" align="center" style="font-family:Verdana, Arial, Helvetica, sans-serif ">
									<br/><br/><h4>&nbsp; &nbsp; &nbsp; DATOS DEL ÁREA REDUCCIÓN LINEA 2</h4>
									<?=llenar_informacion_linea(2, $dia, $db)?><br/>
						  </div>
						  <div id="tab3" width="150" name="Datos Originales" align="center" style="font-family:Verdana, Arial, Helvetica, sans-serif ">
									<br/><br/><h4>&nbsp; &nbsp; &nbsp; DATOS DEL ÁREA REDUCCIÓN LINEA 3</h4>
									<?=llenar_informacion_linea(3, $dia, $db)?><br/>
						  </div>
						  <div id="tab4" width="150" name="Datos Originales" align="center" style="font-family:Verdana, Arial, Helvetica, sans-serif ">
									<br/><br/><h4>&nbsp; &nbsp; &nbsp; DATOS DEL ÁREA REDUCCIÓN LINEA 4</h4>
									<?=llenar_informacion_linea(4, $dia, $db)?><br/>
						  </div>
						  <div id="tab5" width="150" name="Datos Originales" align="center" style="font-family:Verdana, Arial, Helvetica, sans-serif ">
									<br/><br/><h4>&nbsp; &nbsp; &nbsp; DATOS DEL ÁREA REDUCCIÓN LINEA 5</h4>
									<?=llenar_informacion_linea(5, $dia, $db)?><br/>
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
	
	
	function llenar_informacion_linea($linea, $dia, $db)
	{
		$sq_m1			=	"SELECT * FROM estatus_planta_reduccion_diario WHERE fecha = '$dia' AND linea = '$linea'";
		$query_m1		=	mig_query($sq_m1, $db); 
		$res_m1			=	pg_fetch_array($query_m1);
		
		if 	($res_m1['prod_neta_plan']			==	"")		$res_m1['prod_neta_plan']			=	0;
		if 	($res_m1['prod_neta_real']			==	"")		$res_m1['prod_neta_real']			=	0;	
		if 	($res_m1['celdas_prod']				==	"")		$res_m1['celdas_prod']				=	0;	
		if 	($res_m1['celdas_conect']			==	"")		$res_m1['celdas_conect']			=	0;	
		if 	($res_m1['celdas_inc']				==	"")		$res_m1['celdas_inc']				=	0;	
		if 	($res_m1['celdas_desinc']			==	"")		$res_m1['celdas_desinc']			=	0;	
		if 	($res_m1['anodos_servidos']			==	"")		$res_m1['anodos_servidos']			=	0;	
		if 	($res_m1['prof_metal']				==	"")		$res_m1['prof_metal']				=	0;	
		if 	($res_m1['prof_baño']				==	"")		$res_m1['prof_baño']				=	0;	
		
		?>
				<link rel="STYLESHEET" type="text/css" href="/scp/modules/estatus_planta/estilos1.css">
				<link rel="STYLESHEET" type="text/css" href="../estilos1.css">
				<input type="hidden" id="fecha" value="<?=$dia?>"><input type="hidden" id="oculto_linea">
				<div style="width:100%; text-align:center ">
					<table style="width:60%; text-align:center" border="0" cellpadding="0" cellspacing="0">
						<tr>
							<td class="encabezado_formulario_ingreso">Variable</td>
							<td class="encabezado_formulario_ingreso">Valor del día</td>
						</tr>
						<tr>
							<td class="encabezado_formulario_ingreso">Plan Producción Neta </td>
							<td class="cuerpo_formulario_ingreso_1"><input type="text" id="plan_prod_neta_linea_<?=$linea?>" value="<?=$res_m1['prod_neta_plan']?>" size="6" maxlength="8" onKeyPress="javascript:if(event.keyCode<46 || event.keyCode>57){return false;}"></td>
						</tr>
						<tr>
							<td class="encabezado_formulario_ingreso">Producción Neta Línea</td>
							<td class="cuerpo_formulario_ingreso_1"><input type="text" id="real_prod_neta_linea_<?=$linea?>" value="<?=$res_m1['prod_neta_real']?>" size="6" maxlength="8" onKeyPress="javascript:if(event.keyCode<46 || event.keyCode>57){return false;}"></td>
						</tr>
						<tr>
							<td class="encabezado_formulario_ingreso">Celdas Conectadas</td>
							<td class="cuerpo_formulario_ingreso_1"><input type="text" id="real_celdas_con_linea_<?=$linea?>" value="<?=$res_m1['celdas_conect']?>" size="6" maxlength="2" onKeyPress="javascript:if(event.keyCode<46 || event.keyCode>57){return false;}"></td>
						</tr>
						<tr>
							<td class="encabezado_formulario_ingreso">Celdas en Produccion</td>
							<td class="cuerpo_formulario_ingreso_1"><input type="text" id="real_celdas_prod_linea_<?=$linea?>" value="<?=$res_m1['celdas_prod']?>" size="6" maxlength="2" onKeyPress="javascript:if(event.keyCode<46 || event.keyCode>57){return false;}"></td>
						</tr>
						<tr>
							<td class="encabezado_formulario_ingreso">Celdas Incorporadas</td>
							<td class="cuerpo_formulario_ingreso_1"><input type="text" id="real_celdas_inc_linea_<?=$linea?>" value="<?=$res_m1['celdas_inc']?>" size="6" maxlength="2" onKeyPress="javascript:if(event.keyCode<46 || event.keyCode>57){return false;}"></td>
						</tr>
						<tr>
							<td class="encabezado_formulario_ingreso">Celdas Desincorporadas</td>
							<td class="cuerpo_formulario_ingreso_1"><input type="text" id="real_celdas_desinc_linea_<?=$linea?>" value="<?=$res_m1['celdas_desinc']?>" size="6" maxlength="2" onKeyPress="javascript:if(event.keyCode<46 || event.keyCode>57){return false;}"></td>
						</tr>
						<tr><td colspan="2">&nbsp;</td></tr>
						<tr><td colspan="2" style="text-align:center"><input type="button" id="procesa_carga_manual_reduccion_l1" onClick="guarda_datos_reduccion_dia(<?=$linea?>)" value="Procesar Línea"></td></tr>
					</table>
				</div>
		<?php
	}
?>