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
					<div id="tab_datos_igpp" style="width:660px; height:580px;" onMouseOver="limpiar_div(5)"> 
						<div id="tab1" width="150" name="Datos Originales" align="center" style="font-family:Verdana, Arial, Helvetica, sans-serif ">
							<br/><br/>
							<h4>&nbsp; &nbsp; &nbsp; MATERIAS PRIMAS DE C.V.G. VENALUM </h4>
							<?=informacion_materia_prima($dia, $db)?><br/>
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
	
	
	function informacion_materia_prima($dia, $db)	///PARA COLADA Y REDUCCIÓN
	{
		$sq_m1			=	"SELECT *  FROM estatus_planta_inventario_materiales_diario WHERE fecha = '$dia';";
		$query_m1		=	mig_query($sq_m1, $db);
		$res_m1			=	pg_fetch_array($query_m1); 
		?>
			<link rel="STYLESHEET" type="text/css" href="/scp/modules/estatus_planta/estilos1.css">
			<link rel="STYLESHEET" type="text/css" href="../estilos1.css">
			<input type="hidden" id="fecha" value="<?=$dia?>">
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
						<td class="cuerpo_formulario_ingreso_1"><input type="text" id="inventarios_1" size="4" maxlength="5" value="<?=$res_m1['tm_alumina_fresca']?>" onKeyPress="javascript:if(event.keyCode<46 || event.keyCode>57){return false;}"></td>
						<td class="cuerpo_formulario_ingreso_1"><input type="text" id="inventarios_2" size="4" maxlength="5" value="<?=$res_m1['tm_criolita']?>" onKeyPress="javascript:if(event.keyCode<46 || event.keyCode>57){return false;}"></td>
						<td class="cuerpo_formulario_ingreso_1"><input type="text" id="inventarios_3" size="4" maxlength="5" value="<?=$res_m1['tm_floruro']?>" onKeyPress="javascript:if(event.keyCode<46 || event.keyCode>57){return false;}"></td>
						<td class="cuerpo_formulario_ingreso_1"><input type="text" id="inventarios_4" size="4" maxlength="5" value="<?=$res_m1['tm_coque_met']?>" onKeyPress="javascript:if(event.keyCode<46 || event.keyCode>57){return false;}"></td>
						<td class="cuerpo_formulario_ingreso_1"><input type="text" id="inventarios_5" size="4" maxlength="5" value="<?=$res_m1['tm_coque_petroleo']?>" onKeyPress="javascript:if(event.keyCode<46 || event.keyCode>57){return false;}"></td>
						<td class="cuerpo_formulario_ingreso_1"><input type="text" id="inventarios_6" size="4" maxlength="5" value="<?=$res_m1['tm_alquitran']?>" onKeyPress="javascript:if(event.keyCode<46 || event.keyCode>57){return false;}"></td>
						<td class="cuerpo_formulario_ingreso_1"><input type="text" id="inventarios_7" size="4" maxlength="5" value="<?=$res_m1['tm_arrabio']?>" onKeyPress="javascript:if(event.keyCode<46 || event.keyCode>57){return false;}"></td>
					</tr>
					<tr>
						<td class="encabezado_formulario_ingreso">DIAS CONSUMO</td>
						<td class="cuerpo_formulario_ingreso_1"><input type="text" id="dias_consumo_1" size="4" maxlength="5" value="<?=$res_m1['dias_conumo_alumina_fresca']?>" onKeyPress="javascript:if(event.keyCode<46 || event.keyCode>57){return false;}"></td>
						<td class="cuerpo_formulario_ingreso_1"><input type="text" id="dias_consumo_2" size="4" maxlength="5" value="<?=$res_m1['dias_consumo_criolita']?>" onKeyPress="javascript:if(event.keyCode<46 || event.keyCode>57){return false;}"></td>
						<td class="cuerpo_formulario_ingreso_1"><input type="text" id="dias_consumo_3" size="4" maxlength="5" value="<?=$res_m1['dias_consumo_floruro']?>" onKeyPress="javascript:if(event.keyCode<46 || event.keyCode>57){return false;}"></td>
						<td class="cuerpo_formulario_ingreso_1"><input type="text" id="dias_consumo_4" size="4" maxlength="5" value="<?=$res_m1['dias_consumo_coque_met']?>" onKeyPress="javascript:if(event.keyCode<46 || event.keyCode>57){return false;}"></td>
						<td class="cuerpo_formulario_ingreso_1"><input type="text" id="dias_consumo_5" size="4" maxlength="5" value="<?=$res_m1['dias_consumo_coque_petroleo']?>" onKeyPress="javascript:if(event.keyCode<46 || event.keyCode>57){return false;}"></td>
						<td class="cuerpo_formulario_ingreso_1"><input type="text" id="dias_consumo_6" size="4" maxlength="5" value="<?=$res_m1['dias_consumo_alquitran']?>" onKeyPress="javascript:if(event.keyCode<46 || event.keyCode>57){return false;}"></td>
						<td class="cuerpo_formulario_ingreso_1"><input type="text" id="dias_consumo_7" size="4" maxlength="5" value="<?=$res_m1['dias_consumo_arrabio']?>" onKeyPress="javascript:if(event.keyCode<46 || event.keyCode>57){return false;}"></td>
					</tr>
				</table>
				<br/><br/><?=materia_prima_transito($db);?><br/>
				<input type="button" value="Procesar Area" onClick="procesa_ingresa_datos_materias_primas()"/>
			</div>
		<?php
		pg_close($db);
	}

function materia_prima_transito($db)
{
	$sq_m1					=	"SELECT * FROM estatus_planta_buques_transito WHERE tipo_material >= '2' ORDER BY tipo_material";
	$query_m1				=	mig_query($sq_m1, $db);
	while($res_m1			=	pg_fetch_array($query_m1))
	{
		$ind				=	$res_m1['tipo_material'];
		list($a, $m, $d)	=	split('-', $res_m1['fecha_atraque']);
		if ($res_m1['fecha_atraque'] != "") $fecha_buque[$ind]	=	"$d/$m/$a";
		$cant_buque[$ind]	=	$res_m1['cantidad_material'];
		$nombre_buque[$ind]	=	$res_m1['nombre_buque'];
		$observ_buque[$ind]	=	$res_m1['observacion_registro'];
	
	}

	?>
    <script type='text/javascript' src='http://control//scp/includes/zapatec/utils/zapatec.js'></script>
	<script type="text/javascript" src="http://control//scp/includes/zapatec/zpcal/src/calendar.js"></script>
	<script type="text/javascript" src="http://control//scp/includes/zapatec/zpcal/lang/calendar-es.js"></script>
	
	<link href="http://control//scp/includes/zapatec/website/css/zpcal.css" rel="stylesheet" type="text/css">

	<!-- Theme css -->
	<link href="http://control//scp/includes/zapatec/zpcal/themes/fancyblue.css" rel="stylesheet" type="text/css">

		<link rel="STYLESHEET" type="text/css" href="/scp/modules/estatus_planta/estilos1.css">
		<link rel="STYLESHEET" type="text/css" href="../estilos1.css">
		<table style="width:100% " border="0" cellpadding="0" cellspacing="0">
			<tr>
				<td style="width:15%" class="EncabezadoMaTransito">Material</td>
				<td style="width:15%" class="EncabezadoMaTransito">Fecha Atraque</td>
				<td style="width:15%" class="EncabezadoMaTransito">Cantidad Material</td>
				<td style="width:18%" class="EncabezadoMaTransito">Nombre del Barco</td>
				<td style="width:45%" class="EncabezadoMaTransito">Observacion</td>
			</tr>
			<tr>
				<td style="width:15%" class="CuerpoMaTransito1">Criolita</td>
				<td style="width:15%" class="CuerpoMaTransito1"><input type="text" id="fecha_material_2" size="10" readonly="yes" value="<?=$fecha_buque[2]?>"></td>
				<td style="width:15%" class="CuerpoMaTransito1"><input type="text" id="cantidad_material_2" size="6" maxlength="6" onKeyPress="javascript:if(event.keyCode<46 || event.keyCode>57){return false;}" value="<?=$cant_buque[2]?>"></td>
				<td style="width:18%" class="CuerpoMaTransito1"><input type="text" id="barco_material_2" size="20" maxlength="17" value="<?=$nombre_buque[2]?>"></td>
				<td style="width:45%" class="CuerpoMaTransito1"><textarea id="observacion_material_2" cols="40" rows="2"><?=$observ_buque[2]?></textarea></td>
			</tr>
			<tr>
				<td style="width:15%" class="CuerpoMaTransito2">Floruro de Aluminio</td>
				<td style="width:15%" class="CuerpoMaTransito2"><input type="text" id="fecha_material_3" size="10"  readonly="yes" value="<?=$fecha_buque[3]?>"></td>
				<td style="width:15%" class="CuerpoMaTransito2"><input name="text" type="text" id="cantidad_material_3" size="6" maxlength="6" onKeyPress="javascript:if(event.keyCode<46 || event.keyCode>57){return false;}" value="<?=$cant_buque[3]?>"></td>
				<td style="width:18%" class="CuerpoMaTransito2"><input type="text" id="barco_material_3" size="20" maxlength="17" value="<?=$nombre_buque[3]?>"></td>
				<td style="width:45%" class="CuerpoMaTransito2"><textarea id="observacion_material_3" cols="40" rows="2"><?=$observ_buque[3]?></textarea></td>
			</tr>
			<tr>
				<td style="width:15%" class="CuerpoMaTransito1">Coque Metalúrgio</td>
				<td style="width:15%" class="CuerpoMaTransito1"><input type="text" id="fecha_material_4" size="10"  readonly="yes" value="<?=$fecha_buque[4]?>"></td>
				<td style="width:15%" class="CuerpoMaTransito1"><input name="text" type="text" id="cantidad_material_4" size="6" maxlength="6" onKeyPress="javascript:if(event.keyCode<46 || event.keyCode>57){return false;}" value="<?=$cant_buque[4]?>"></td>
				<td style="width:18%" class="CuerpoMaTransito1"><input type="text" id="barco_material_4" size="20" maxlength="17" value="<?=$nombre_buque[4]?>"></td>
				<td style="width:45%" class="CuerpoMaTransito1"><textarea id="observacion_material_4" cols="40" rows="2"><?=$observ_buque[4]?></textarea></td>
			</tr>
			<tr>
				<td style="width:15%" class="CuerpoMaTransito2">Coque de Petróleo</td>
				<td style="width:15%" class="CuerpoMaTransito2"><input type="text" id="fecha_material_5" size="10"  readonly="yes" value="<?=$fecha_buque[5]?>"></td>
				<td style="width:15%" class="CuerpoMaTransito2"><input name="text" type="text" id="cantidad_material_5" size="6" maxlength="6" onKeyPress="javascript:if(event.keyCode<46 || event.keyCode>57){return false;}" value="<?=$cant_buque[5]?>"></td>
			 	<td style="width:18%" class="CuerpoMaTransito2"><input type="text" id="barco_material_5" size="20" maxlength="17" value="<?=$nombre_buque[5]?>"></td>
				<td style="width:45%" class="CuerpoMaTransito2"><textarea id="observacion_material_5" cols="40" rows="2"><?=$observ_buque[5]?></textarea></td>
			</tr>
			<tr>
				<td style="width:15%" class="CuerpoMaTransito1">Brea de Alquitrán</td>
				<td style="width:15%" class="CuerpoMaTransito1"><input type="text" id="fecha_material_6" size="10"  readonly="yes" value="<?=$fecha_buque[6]?>"></td>
				<td style="width:15%" class="CuerpoMaTransito1"><input name="text" type="text" id="cantidad_material_6" size="6" maxlength="6" onKeyPress="javascript:if(event.keyCode<46 || event.keyCode>57){return false;}" value="<?=$cant_buque[6]?>"></td>
				<td style="width:18%" class="CuerpoMaTransito1"><input type="text" id="barco_material_6" size="20" maxlength="17" value="<?=$nombre_buque[6]?>"></td>
				<td style="width:45%" class="CuerpoMaTransito1"><textarea id="observacion_material_6" cols="40" rows="2"><?=$observ_buque[6]?></textarea></td>
			</tr>
			<tr>
				<td style="width:15%" class="CuerpoMaTransito2">Arrabio</td>
				<td style="width:15%" class="CuerpoMaTransito2"><input type="text" id="fecha_material_7" size="10"  readonly="yes" value="<?=$fecha_buque[7]?>"></td>
				<td style="width:15%" class="CuerpoMaTransito2"><input name="text" type="text" id="cantidad_material_7" size="6" maxlength="6" onKeyPress="javascript:if(event.keyCode<46 || event.keyCode>57){return false;}" value="<?=$cant_buque[7]?>"></td>
				<td style="width:18%" class="CuerpoMaTransito2"><input type="text" id="barco_material_7" size="20" maxlength="17" value="<?=$nombre_buque[7]?>"></td>
				<td style="width:45%" class="CuerpoMaTransito2"><textarea id="observacion_material_7" cols="40" rows="2"><?=$observ_buque[7]?></textarea></td>
			</tr>
		</table>
		<br/>
		<input type="button" value="Borrar Criolita" onClick="borra_buque_mat_prima(2)"/>&nbsp;
		<input type="button" value="Borrar Floruro" onClick="borra_buque_mat_prima(3)"/>&nbsp;
		<input type="button" value="Borrar Coque Metalúrgico" onClick="borra_buque_mat_prima(4)"/>&nbsp;
		<input type="button" value="Borrar Coque Petroleo" onClick="borra_buque_mat_prima(5)"/>&nbsp;
		<input type="button" value="Borrar Alquitran" onClick="borra_buque_mat_prima(6)"/>&nbsp;
		<input type="button" value="Borrar Arrabio" onClick="borra_buque_mat_prima(7)"/>&nbsp;
		<br/><br/>
		<hr><br/>
		<script language="javascript" type="text/javascript" id="fechas_java">
			var fecha_carga = new Zapatec.Calendar.setup({
				inputField     :    "fecha_material_2",     // id of the input field
				ifFormat       :    "%d/%m/%Y",     // format of the input field
				button         :    "fecha_material_2",  // What will trigger the popup of the calendar
				timeInterval   :     1,
				showsTime      :     false
				});
			
			var fecha_carga = new Zapatec.Calendar.setup({
				inputField     :    "fecha_material_3",     // id of the input field
				ifFormat       :    "%d/%m/%Y",     // format of the input field
				button         :    "fecha_material_3",  // What will trigger the popup of the calendar
				timeInterval   :     1,
				showsTime      :     false
				});
			
			var fecha_carga = new Zapatec.Calendar.setup({
				inputField     :    "fecha_material_4",     // id of the input field
				ifFormat       :    "%d/%m/%Y",     // format of the input field
				button         :    "fecha_material_4",  // What will trigger the popup of the calendar
				timeInterval   :     1,
				showsTime      :     false
				});
			
			var fecha_carga = new Zapatec.Calendar.setup({
				inputField     :    "fecha_material_5",     // id of the input field
				ifFormat       :    "%d/%m/%Y",     // format of the input field
				button         :    "fecha_material_5",  // What will trigger the popup of the calendar
				timeInterval   :     1,
				showsTime      :     false
				});
			
			var fecha_carga = new Zapatec.Calendar.setup({
				inputField     :    "fecha_material_6",     // id of the input field
				ifFormat       :    "%d/%m/%Y",     // format of the input field
				button         :    "fecha_material_6",  // What will trigger the popup of the calendar
				timeInterval   :     1,
				showsTime      :     false
				});
			
			var fecha_carga = new Zapatec.Calendar.setup({
				inputField     :    "fecha_material_7",     // id of the input field
				ifFormat       :    "%d/%m/%Y",     // format of the input field
				button         :    "fecha_material_7",  // What will trigger the popup of the calendar
				timeInterval   :     1,
				showsTime      :     false
				});

		</script>
	<?php
}

?>