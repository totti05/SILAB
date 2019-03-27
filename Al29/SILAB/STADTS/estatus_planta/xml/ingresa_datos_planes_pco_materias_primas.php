	<link rel="STYLESHEET" type="text/css" href="http://control/scp/includes/dhtmlx/dhtmlxTabbar/codebase/dhtmlxtabbar.css">
	<script  src="http://control/scp/includes/dhtmlx/dhtmlxTabbar/sources/dhtmlxcommon.js"></script>
	<script  src="http://control/scp/includes/dhtmlx/dhtmlxTabbar/sources/dhtmlxtabbar.js"></script>
	<script  src="http://control/scp/includes/dhtmlx/dhtmlxTabbar/sources/dhtmlxtabbar_start.js"></script>
	<!--script  src="http://control/scp/modules/estatus_planta/funciones_java.js"></script>  -->
	<script  src="funciones_java.js"></script> 
	<link rel="STYLESHEET" type="text/css" href="/scp/modules/estatus_planta/estilos1.css">
<!--			<link rel="STYLESHEET" type="text/css" href="../estilos1.css">  -->
	<?php
	$mes_busc			=	$_GET['mes_busc'];
	$anno_busc			=	$_GET['anno_busc'];
	include '../conectarse.php';
	$db				=	conectarse_postgres();

	?><center>
		<table align="center"> 
			<tr>
				<td>
					<div id="tab_datos_igpp" style="width:660px; height:580px;" onMouseOver="repuesta_servidor_suministros"> 
						<div id="tab1" width="150" name="Datos Originales" align="center" style="font-family:Verdana, Arial, Helvetica, sans-serif ">
							<br/><br/>
							<h4>&nbsp; &nbsp; &nbsp; PLAN PCO MATERIAS PRIMAS DE C.V.G. VENALUM </h4>
							<?=informacion_materia_prima($mes_busc, $anno_busc, $db)?><br/>
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
				tabbar.addTab("ventana1","Materias Primas","120px");
				tabbar.setContent("ventana1","tab1");
				tabbar.setTabActive("ventana1");
	</script>


<?php
	
	
	function informacion_materia_prima($mes_busc, $anno_busc, $db)	///PARA COLADA Y REDUCCIÓN
	{
		$sq_m1			=	"SELECT *  FROM estatus_planta_plan_suministros WHERE mes = '$mes_busc' AND año = '$anno_busc';";
		$query_m1		=	mig_query($sq_m1, $db);
		$res_m1			=	pg_fetch_array($query_m1); 
		?>
			<link rel="STYLESHEET" type="text/css" href="/scp/modules/estatus_planta/estilos1.css">
<!--			<link rel="STYLESHEET" type="text/css" href="../estilos1.css">  -->
			<input type="hidden" id="oculto_mes_busc" value="<?=$mes_busc?>">
			<input type="hidden" id="oculto_anno_busc" value="<?=$anno_busc?>">
			<div style="width:100%; text-align:center ">
				<table style="width:100%; text-align:center" border="0" cellpadding="0" cellspacing="0">
					<tr>
						<td>&nbsp;</td>
						<td class="encabezado_formulario_ingreso">ALUMINA FRESCA</td>
						<td class="encabezado_formulario_ingreso">CRIO LITA</td>
						<td class="encabezado_formulario_ingreso">FLORURO ALUMINIO</td>
						<td class="encabezado_formulario_ingreso">COQUE METALURGICO</td>
						<td class="encabezado_formulario_ingreso">COQUE DE PETROLEO</td>
						<td class="encabezado_formulario_ingreso">ALQUI TRAN</td>
						<td class="encabezado_formulario_ingreso">ARRA BIO</td>
					</tr>
					<tr>
						<td class="encabezado_formulario_ingreso">INVENTARIO</td>
						<td class="cuerpo_formulario_ingreso_1"><input type="text" id="inventarios_1" size="7" maxlength="8" value="<?=$res_m1['plan_alumina']?>" onKeyPress="javascript:if(event.keyCode<46 || event.keyCode>57){return false;}"></td>
						<td class="cuerpo_formulario_ingreso_1"><input type="text" id="inventarios_2" size="6" maxlength="6" value="<?=$res_m1['plan_criolita']?>" onKeyPress="javascript:if(event.keyCode<46 || event.keyCode>57){return false;}"></td>
						<td class="cuerpo_formulario_ingreso_1"><input type="text" id="inventarios_3" size="6" maxlength="6" value="<?=$res_m1['plan_floruro']?>" onKeyPress="javascript:if(event.keyCode<46 || event.keyCode>57){return false;}"></td>
						<td class="cuerpo_formulario_ingreso_1"><input type="text" id="inventarios_4" size="6" maxlength="5" value="<?=$res_m1['plan_coque_met']?>" onKeyPress="javascript:if(event.keyCode<46 || event.keyCode>57){return false;}"></td>
						<td class="cuerpo_formulario_ingreso_1"><input type="text" id="inventarios_5" size="7" maxlength="8" value="<?=$res_m1['plan_coque_pet']?>" onKeyPress="javascript:if(event.keyCode<46 || event.keyCode>57){return false;}"></td>
						<td class="cuerpo_formulario_ingreso_1"><input type="text" id="inventarios_6" size="7" maxlength="7" value="<?=$res_m1['plan_alquitran']?>" onKeyPress="javascript:if(event.keyCode<46 || event.keyCode>57){return false;}"></td>
						<td class="cuerpo_formulario_ingreso_1"><input type="text" id="inventarios_7" size="6" maxlength="5" value="<?=$res_m1['plan_arrabio']?>" onKeyPress="javascript:if(event.keyCode<46 || event.keyCode>57){return false;}"></td>
					</tr>
				</table>
				<br/>
				<input type="button" value="Procesar Area" onClick="procesa_ingresa_datos_plan_pco_materias_primas()"/>
			</div>
		<?php
		pg_close($db);
	}


?>