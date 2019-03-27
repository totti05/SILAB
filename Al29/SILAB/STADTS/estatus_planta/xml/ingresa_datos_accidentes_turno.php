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
					<div id="tab_datos_igpp" style="width:660px; height:410px;" onMouseOver="limpiar_div(60)"> 
						  <div id="tab1" width="150" name="Datos Originales" align="center" style="font-family:Verdana, Arial, Helvetica, sans-serif ">
									<br/><br/><h4>&nbsp; &nbsp; &nbsp; ACCIDENTES DEL ÁREA REDUCCIÓN</h4>
									<?=información_accidentes(1, $dia, $db, $turno)?><br/>
						  </div>
							  <div id="tab2" width="150" name="Datos Originales" align="center" style="font-family:Verdana, Arial, Helvetica, sans-serif ">
									<br/><br/><h4>&nbsp; &nbsp; &nbsp; ACCIDENTES DEL ÁREA CARBÓN</h4>
									<?=información_accidentes(2, $dia, $db, $turno)?><br/>
						  </div>
						  <div id="tab3" width="150" name="Datos Originales" align="center" style="font-family:Verdana, Arial, Helvetica, sans-serif ">
									<br/><br/><h4>&nbsp; &nbsp; &nbsp; ACCIDENTES DEL ÁREA COLADA</h4>
									<?=información_accidentes(3, $dia, $db, $turno)?><br/>
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
	
	
	function información_accidentes($area, $dia, $db, $turno)	///PARA COLADA Y REDUCCIÓN
	{
		$sq_m1			=	"SELECT * FROM estatus_planta_accidentes WHERE fecha = '$dia' AND turno = '$turno' AND area = '$area';";
		$query_m1		=	mig_query($sq_m1, $db); 
		$res_m1			=	pg_fetch_array($query_m1);		
		?>
			<link rel="STYLESHEET" type="text/css" href="/scp/modules/estatus_planta/estilos1.css">
			<link rel="STYLESHEET" type="text/css" href="../estilos1.css">
			<input type="hidden" id="fecha" value="<?=$dia?>"><input type="hidden" id="oculto_area">
			<div style="width:100%; text-align:center ">
				<table style="width:80%; text-align:center" border="0" cellpadding="0" cellspacing="0">
					<tr>
						<td colspan="6">INFORMACIÓN DE ACCIDENTABILIDAD</td>
					</tr>
					<tr>
						<td>&nbsp;</td>
						<td class="encabezado_formulario_ingreso">Accidentes Laborales </td>
						<td class="encabezado_formulario_ingreso">Lesionados en Accidentes </td>
					</tr>
					<tr>
						<td class="encabezado_formulario_ingreso">Cantidad</td>
						<td class="cuerpo_formulario_ingreso_1"><input type="text" id="num_accidentes_<?=$area?>" size="2" maxlength="2" value="<?=$res_m1['num_accidente']?>" onKeyPress="javascript:if(event.keyCode<46 || event.keyCode>57){return false;}"></td>
						<td class="cuerpo_formulario_ingreso_1"><input type="text" id="num_lesionados_<?=$area?>" size="2" maxlength="2" value="<?=$res_m1['num_lesionados']?>" onKeyPress="javascript:if(event.keyCode<46 || event.keyCode>57){return false;}"></td>
					</tr>
				</table>
				<br/>
				<input type="button" value="Procesar Area" onClick="guarda_datos_accidentes_turno(<?=$area?>)"/>
			</div>
		<?php
	}
?>