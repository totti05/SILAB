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
					<div id="tab_datos_igpp" style="width:660px; height:300px;" onMouseOver="limpiar_div(22)"> 
						  <div id="tab1" width="150" name="Datos Originales" align="center" style="font-family:Verdana, Arial, Helvetica, sans-serif ">
									<br/><br/>
									<h4>&nbsp; &nbsp; &nbsp; DATOS DEL ÁREA SERV. A CELDAS / FASE DENSA RD-III </h4>
									<?=llenar_informacion_auxiliares_turno($dia, $turno, $db)?><br/>
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
				tabbar.addTab("ventana1","Serv.Celdas/FaseDensa","80px");
				tabbar.setContent("ventana1","tab1");
				tabbar.setTabActive("ventana1");
	</script>


<?php
	
	
	function llenar_informacion_auxiliares_turno($dia, $turno, $db)
	{
		$sq_m1							=	"SELECT * FROM estatus_planta_reduccion_turno WHERE fecha = '$dia' AND turno = '$turno' AND tipo_campo = '17' AND linea = '5' ORDER BY linea;";
		$query_m1						=	mig_query($sq_m1, $db);

		$sq_m12							=	"SELECT * FROM estatus_planta_reduccion_turno WHERE fecha = '$dia' AND turno = '$turno' AND tipo_campo = '17' AND linea = '6' ORDER BY linea;";
		$query_m12						=	mig_query($sq_m12, $db);
		
		$res_m1							=	pg_fetch_array($query_m1);
		if ($res_m1)
			$silo_prim_alumina[4]		=	$res_m1['valor_variable'];
		else
			$silo_prim_alumina[4]		=	0;
		
		$res_m12							=	pg_fetch_array($query_m12);
		if ($res_m12)
			$silo_prim_alumina[5]		=	$res_m12['valor_variable'];
		else
			$silo_prim_alumina[5]		=	0;
	

		$sq_m2							=	"SELECT * FROM estatus_planta_reduccion_turno WHERE fecha = '$dia' AND turno = '$turno' AND tipo_campo = '18' ORDER BY linea;";
		$query_m2						=	mig_query($sq_m2, $db);
		
		$n								=	1;
		
		while ($res_m2 = pg_fetch_array($query_m2))
		{
				$linea					=	$res_m2['linea'];
				$silo_sec_alumina[$linea]	=	$res_m2['valor_variable'];
		}

		$sq_m3							=	"SELECT * FROM estatus_planta_reduccion_turno WHERE fecha = '$dia' AND turno = '$turno' AND tipo_campo = '19' ORDER BY linea;";
		$query_m3						=	mig_query($sq_m3, $db);
		
		$n								=	0;

		while ($res_m3 = pg_fetch_array($query_m3))
		{
				$linea						=	$res_m3['linea'];				
				$silo_bano[$linea]			=	$res_m3['valor_variable'];
		}
		?>
				<link rel="STYLESHEET" type="text/css" href="/scp/modules/estatus_planta/estilos1.css">
				<link rel="STYLESHEET" type="text/css" href="../estilos1.css">
				<input type="hidden" id="fecha" value="<?=$dia?>">
				<div style="width:100% ">
					<table style="width:80%" border="0" cellpadding="0" cellspacing="0">
						<tr>
							<td class="encabezado_formulario_ingreso">Tipo Silo</td>
							<td class="encabezado_formulario_ingreso">Línea 1</td>
							<td class="encabezado_formulario_ingreso">Línea 2</td>
							<td class="encabezado_formulario_ingreso">Línea 3</td>
							<td class="encabezado_formulario_ingreso">Línea 4</td>
							<td class="encabezado_formulario_ingreso">Línea 5</td>
						</tr>
						<tr>
							<td class="encabezado_formulario_ingreso">Alúmina Secundario</td>
							<td class="cuerpo_formulario_ingreso_1"><input type="text" id="silo_sec_alum_1" size="4" maxlength="3" value="<?php if ($silo_sec_alumina['1'] > 0) echo $silo_sec_alumina['1']; else echo "0";?>" onKeyPress="javascript:if(event.keyCode<46 || event.keyCode>57){return false;}"></td>
							<td class="cuerpo_formulario_ingreso_1"><input type="text" id="silo_sec_alum_2" size="4" maxlength="3" value="<?php if ($silo_sec_alumina['2'] > 0) echo $silo_sec_alumina['2']; else echo "0";?>" onKeyPress="javascript:if(event.keyCode<46 || event.keyCode>57){return false;}"></td>
							<td class="cuerpo_formulario_ingreso_1"><input type="text" id="silo_sec_alum_3" size="4" maxlength="3" value="<?php if ($silo_sec_alumina['3'] > 0) echo $silo_sec_alumina['3']; else echo "0";?>" onKeyPress="javascript:if(event.keyCode<46 || event.keyCode>57){return false;}"></td>
							<td class="cuerpo_formulario_ingreso_1"><input type="text" id="silo_sec_alum_4" size="4" maxlength="3" value="<?php if ($silo_sec_alumina['4'] > 0) echo $silo_sec_alumina['4']; else echo "0";?>" onKeyPress="javascript:if(event.keyCode<46 || event.keyCode>57){return false;}"></td>
							<td class="cuerpo_formulario_ingreso_1"><input type="text" id="silo_sec_alum_5" size="4" maxlength="3" value="<?php if ($silo_sec_alumina['5'] > 0) echo $silo_sec_alumina['5']; else echo "0";?>" onKeyPress="javascript:if(event.keyCode<46 || event.keyCode>57){return false;}"> 
							/ 
						    										<input type="text" id="silo_sec_alum_6" size="4" maxlength="3" value="<?php if ($silo_sec_alumina['6'] > 0) echo $silo_sec_alumina['6']; else echo "0";?>" onKeyPress="javascript:if(event.keyCode<46 || event.keyCode>57){return false;}"></td>
						</tr>
						<tr>
							<td class="encabezado_formulario_ingreso">Baño Molido</td>
							<td class="cuerpo_formulario_ingreso_1"><input type="text" id="silo_prim_bano_1" size="4" maxlength="3" value="<?php if ($silo_bano['1'] > 0) echo $silo_bano['1']; else echo "0";?>" onKeyPress="javascript:if(event.keyCode<46 || event.keyCode>57){return false;}"></td>
							<td class="cuerpo_formulario_ingreso_1"><input type="text" id="silo_prim_bano_2" size="4" maxlength="3" value="<?php if ($silo_bano['2'] > 0) echo $silo_bano['2']; else echo "0";?>" onKeyPress="javascript:if(event.keyCode<46 || event.keyCode>57){return false;}"></td>
							<td class="cuerpo_formulario_ingreso_1"><input type="text" id="silo_prim_bano_3" size="4" maxlength="3" value="<?php if ($silo_bano['3'] > 0) echo $silo_bano['3']; else echo "0";?>" onKeyPress="javascript:if(event.keyCode<46 || event.keyCode>57){return false;}"></td>
							<td class="cuerpo_formulario_ingreso_1"><input type="text" id="silo_prim_bano_4" size="4" maxlength="3" value="<?php if ($silo_bano['4'] > 0) echo $silo_bano['4']; else echo "0";?>" onKeyPress="javascript:if(event.keyCode<46 || event.keyCode>57){return false;}"></td>
							<td class="cuerpo_formulario_ingreso_1"><input type="text" id="silo_prim_bano_5" size="4" maxlength="3" value="<?php if ($silo_bano['5'] > 0) echo $silo_bano['5']; else echo "0";?>" onKeyPress="javascript:if(event.keyCode<46 || event.keyCode>57){return false;}"></td>
						</tr>
						<tr>
						  <td class="encabezado_formulario_ingreso">Alúmina Primario</td>
						  <td class="cuerpo_formulario_ingreso_1">&nbsp;</td>
						  <td class="cuerpo_formulario_ingreso_1">&nbsp;</td>
						  <td class="cuerpo_formulario_ingreso_1">&nbsp;</td>
						  <td class="cuerpo_formulario_ingreso_1">&nbsp;</td>
						  <td class="cuerpo_formulario_ingreso_1"><input type="text" id="silo_prim_alum_5" size="4" maxlength="4" value="<?=$silo_prim_alumina['4']?>" onKeyPress="javascript:if(event.keyCode<46 || event.keyCode>57){return false;}"> 
							/ 
						    										<input type="text" id="silo_prim_alum_6" size="4" maxlength="3" value="<?=$silo_prim_alumina['5']?>" onKeyPress="javascript:if(event.keyCode<46 || event.keyCode>57){return false;}"></td>
					  </tr>
					</table>
					<br/>
					<input type="button" value="Procesar Turno" onClick="guarda_datos_nivel_silos_turno(2)">
				</div>
		<?php
	}
pg_close($db);
?>