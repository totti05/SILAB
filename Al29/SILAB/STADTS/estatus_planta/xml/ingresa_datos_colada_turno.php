	<link rel="STYLESHEET" type="text/css" href="http://control/scp/includes/dhtmlx/dhtmlxTabbar/codebase/dhtmlxtabbar.css">
	<script  src="http://control/scp/includes/dhtmlx/dhtmlxTabbar/sources/dhtmlxcommon.js"></script>
	<script  src="http://control/scp/includes/dhtmlx/dhtmlxTabbar/sources/dhtmlxtabbar.js"></script>
	<script  src="http://control/scp/includes/dhtmlx/dhtmlxTabbar/sources/dhtmlxtabbar_start.js"></script>
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
					<div id="tab_datos_igpp" style="width:660px; height:300px;" onMouseOver="limpiar_div(3)"> 
						  <div id="tab1" width="150" name="Datos Originales" align="center" style="font-family:Verdana, Arial, Helvetica, sans-serif ">
									<br/><br/>
									<h4>&nbsp; &nbsp; &nbsp; DATOS DEL ÁREA COLADA </h4>
									<?=llenar_informacion_colada_turno($dia, $turno, $db)?><br/>
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
				tabbar.addTab("ventana1","Colada","80px");
				tabbar.setContent("ventana1","tab1");
				tabbar.setTabActive("ventana1");
	</script>
<?php
	pg_close($db);
	
	function llenar_informacion_colada_turno($dia, $turno, $db)
	{
		$sq_m1			=	"SELECT * FROM estatus_planta_colada_turno WHERE fecha = '$dia' AND turno = '$turno';";
		$query_m1		=	mig_query($sq_m1, $db);
		$res_m1			=	pg_fetch_array($query_m1);
		?>
				<link rel="STYLESHEET" type="text/css" href="/scp/modules/estatus_planta/estilos1.css">
				<link rel="STYLESHEET" type="text/css" href="../estilos1.css">
				<input type="hidden" id="fecha" value="<?=$dia?>">
				<div style="width:100% ">
					<table style="width:80%" border="0" cellpadding="0" cellspacing="0">
						<tr>
							<td class="encabezado_formulario_ingreso"># CRISOLES RECIBIDOS</td>
							<td class="encabezado_formulario_ingreso"># CRISOLES PROCESADOS</td>
							<td class="encabezado_formulario_ingreso">TEMP. PROM. CRISOLES RECIB.</td>
						</tr>
						<tr>
							<td class="cuerpo_formulario_ingreso_1"><input type="text" id="crisol_recibido_turno" size="2" maxlength="2" value="<?=$res_m1['num_crisoles_recibidos']?>" onKeyPress="javascript:if(event.keyCode<46 || event.keyCode>57){return false;}"></td>
							<td class="cuerpo_formulario_ingreso_1"><input type="text" id="crisol_procesado_turno" size="2" maxlength="2" value="<?=$res_m1['num_crisoles_procesados']?>" onKeyPress="javascript:if(event.keyCode<46 || event.keyCode>57){return false;}"></td>
							<td class="cuerpo_formulario_ingreso_1"><input type="text" id="temperatura_crisol_turno" size="6" maxlength="6" value="<?=round($res_m1['temperatura_crisoles_recibidos'],3)?>" onKeyPress="javascript:if(event.keyCode<46 || event.keyCode>57){return false;}"></td>
						</tr>
					</table><br/>
					<input type="button" value="Procesar Turno" onClick="guarda_datos_colada_turno()">
				</div>
		<?php
	}
?>