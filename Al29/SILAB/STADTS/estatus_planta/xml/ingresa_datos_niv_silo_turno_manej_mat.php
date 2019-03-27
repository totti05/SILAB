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
									<h4>&nbsp; &nbsp; &nbsp; DATOS DEL ÁREA MANEJO DE MATERIALES </h4>
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
				tabbar.addTab("ventana1","Man.Mat","80px");
				tabbar.setContent("ventana1","tab1");
				tabbar.setTabActive("ventana1");
	</script>


<?php
	
	
	function llenar_informacion_auxiliares_turno($dia, $turno, $db)
	{
		$sq_m1							=	"SELECT * FROM estatus_planta_reduccion_turno WHERE 
											(fecha = '$dia' AND turno = '$turno' AND ((tipo_campo = '17' AND linea <= 4) OR tipo_campo = '20')) ORDER BY linea;";
		$query_m1						=	mig_query($sq_m1, $db);
		
		$n								=	0;
		/*while ($n < 6)
		{
			$res_m1						=	pg_fetch_array($query_m1);
			if ($res_m1)
				$silo_prim_alumina[$n]	=	$res_m1['valor_variable'];
			else
				$silo_prim_alumina[$n]	= 0;
			$n++;
		}*/
		while ($res_m1						=	pg_fetch_array($query_m1))
		{
			$linea						=	$res_m1['linea'];
			$silo_prim_alumina[$linea]	=	$res_m1['valor_variable'];
		}
		
		?>
				<link rel="STYLESHEET" type="text/css" href="/scp/modules/estatus_planta/estilos1.css">
				<!-- <link rel="STYLESHEET" type="text/css" href="../estilos1.css">  -->
				<input type="hidden" id="fecha" value="<?=$dia?>">
				<div style="width:100% ">
					<table style="width:80%" border="0" cellpadding="0" cellspacing="0">
						<tr>
							<td class="encabezado_formulario_ingreso">Tipo Silo</td>
							<td class="encabezado_formulario_ingreso">Línea 1</td>
							<td class="encabezado_formulario_ingreso">Línea 2</td>
							<td class="encabezado_formulario_ingreso">Línea 3</td>
							<td class="encabezado_formulario_ingreso">Línea 4</td>
							<td class="encabezado_formulario_ingreso">Torre 5 (ton)</td>
						</tr>
						<tr>
							<td class="encabezado_formulario_ingreso">Alúmina Primario</td>
							<td class="cuerpo_formulario_ingreso_1"><input type="text" id="silo_prim_alum_1" size="4" maxlength="4" value="<?php if ($silo_prim_alumina['1'] > 0) echo $silo_prim_alumina['1']; else echo "0";?>" onKeyPress="javascript:if(event.keyCode<46 || event.keyCode>57){return false;}"></td>
							<td class="cuerpo_formulario_ingreso_1"><input type="text" id="silo_prim_alum_2" size="4" maxlength="4" value="<?php if ($silo_prim_alumina['2'] > 0) echo $silo_prim_alumina['2']; else echo "0";?>" onKeyPress="javascript:if(event.keyCode<46 || event.keyCode>57){return false;}"></td>
							<td class="cuerpo_formulario_ingreso_1"><input type="text" id="silo_prim_alum_3" size="4" maxlength="4" value="<?php if ($silo_prim_alumina['3'] > 0) echo $silo_prim_alumina['3']; else echo "0";?>" onKeyPress="javascript:if(event.keyCode<46 || event.keyCode>57){return false;}"></td>
							<td class="cuerpo_formulario_ingreso_1"><input type="text" id="silo_prim_alum_4" size="4" maxlength="4" value="<?php if ($silo_prim_alumina['4'] > 0) echo $silo_prim_alumina['4']; else echo "0";?>" onKeyPress="javascript:if(event.keyCode<46 || event.keyCode>57){return false;}"></td>
							<td class="cuerpo_formulario_ingreso_1"><input type="text" id="silo_prim_alum_5" size="4" maxlength="4" value="<?php if ($silo_prim_alumina['5'] > 0) echo $silo_prim_alumina['5']; else echo "0";?>" onKeyPress="javascript:if(event.keyCode<46 || event.keyCode>57){return false;}"></td>
					 	</tr>
					</table>
					<br/>
					<input type="button" value="Procesar Turno" onClick="guarda_datos_nivel_silos_turno(1)">
				</div>
		<?php
	}
pg_close($db);
?>