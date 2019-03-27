	<link rel="STYLESHEET" type="text/css" href="http://control/scp/includes/dhtmlx/dhtmlxTabbar/codebase/dhtmlxtabbar.css">
	<script  src="http://control/scp/includes/dhtmlx/dhtmlxTabbar/sources/dhtmlxcommon.js"></script>
	<script  src="http://control/scp/includes/dhtmlx/dhtmlxTabbar/sources/dhtmlxtabbar.js"></script>
	<script  src="http://control/scp/includes/dhtmlx/dhtmlxTabbar/sources/dhtmlxtabbar_start.js"></script>
	<link rel="STYLESHEET" type="text/css" href="/scp/modules/estatus_planta/estilos1.css">
	<link rel="STYLESHEET" type="text/css" href="../estilos1.css">

<?php
	$dia			=	$_GET['dia'];
	include '../conectarse.php';
	$db				=	conectarse_postgres();
	
	?>
		<center>
		<table align="center"> 
			<tr>
				<td>
					<div id="tab_datos_igpp" style="width:660px; height:300px;" onMouseOver="limpiar_div(2)"> 
						  <div id="tab1" width="150" name="Datos Originales" align="center" style="font-family:Verdana, Arial, Helvetica, sans-serif ">
									<br/><br/><h4>&nbsp; &nbsp; &nbsp; DATOS DEL ÁREA CARBÓN</h4>
									<?=llenar_informacion_carbon_turno($dia, $db)?><br/>
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
				tabbar.addTab("ventana1","Carbón","80px");
				tabbar.setContent("ventana1","tab1");
				tabbar.setTabActive("ventana1");
	</script>


<?php
	
	
	function llenar_informacion_carbon_turno($dia,  $db)
	{
		$sq_m1			=	"SELECT * FROM estatus_planta_carbon_diario WHERE fecha = '$dia' ;";
		$query_m1		=	mig_query($sq_m1, $db);
		$res_m1			=	pg_fetch_array($query_m1);
		?>
				<link rel="STYLESHEET" type="text/css" href="/scp/modules/estatus_planta/estilos1.css">
				<link rel="STYLESHEET" type="text/css" href="../estilos1.css">
				<input type="hidden" id="fecha" value="<?=$dia?>">
				<div style="width:100% ">
					<table style="width:80%" border="0" cellpadding="0" cellspacing="0">
						<tr>
							<td colspan="3" style="text-align:center ">PRODUCCIÓN DE CARBÓN</td>
						</tr>
						<tr>
							<td class="encabezado_formulario_ingreso"># ANODOS VERDES</td>
							<td class="encabezado_formulario_ingreso"># ANODOS COCIDOS</td>
							<td class="encabezado_formulario_ingreso"># ANODOS ENVARILLADOS</td>
						</tr>
						<tr>
							<td class="cuerpo_formulario_ingreso_1"><input type="text" id="anodo_verde_dia" size="3" maxlength="4" value="<?=$res_m1['produc_anodo_verde']?>" onKeyPress="javascript:if(event.keyCode<46 || event.keyCode>57){return false;}"></td>
							<td class="cuerpo_formulario_ingreso_1"><input type="text" id="anodo_cocido_dia" size="3" maxlength="4" value="<?=$res_m1['produc_anodo_cocido']?>" onKeyPress="javascript:if(event.keyCode<46 || event.keyCode>57){return false;}"></td>
							<td class="cuerpo_formulario_ingreso_1"><input type="text" id="anodo_envarillado_dia" size="3" maxlength="4" value="<?=$res_m1['produc_anodo_envarillado']?>" onKeyPress="javascript:if(event.keyCode<46 || event.keyCode>57){return false;}"></td>
						</tr>
						<tr>
							<td colspan="3" style="text-align:center ">INVENTARIOS DE CARBÓN</td>
						</tr>
						<tr>
							<td class="encabezado_formulario_ingreso">ANODOS VERDES</td>
							<td class="encabezado_formulario_ingreso">ANODOS COCIDOS</td>
							<td class="encabezado_formulario_ingreso">ANODOS ENVARILLADOS</td>
						</tr>
						<tr>
							<td class="cuerpo_formulario_ingreso_1"><input type="text" id="inventario_anodo_verde_dia" size="3" maxlength="4" value="<?=$res_m1['inventario_anodo_verde']?>" onKeyPress="javascript:if(event.keyCode<46 || event.keyCode>57){return false;}"></td>
							<td class="cuerpo_formulario_ingreso_1"><input type="text" id="inventario_anodo_cocido_dia" size="3" maxlength="4" value="<?=$res_m1['inventario_anodo_cocido']?>" onKeyPress="javascript:if(event.keyCode<46 || event.keyCode>57){return false;}"></td>
							<td class="cuerpo_formulario_ingreso_1"><input type="text" id="inventario_anodo_envarillado_dia" size="3" maxlength="4" value="<?=$res_m1['inventario_anodo_envarillado']?>" onKeyPress="javascript:if(event.keyCode<46 || event.keyCode>57){return false;}"></td>
						</tr>
					</table>
					<br/>
					<input type="button" value="Procesar Turno" onClick="guarda_datos_carbon_dia()">
				</div>
		<?php
	}
?>