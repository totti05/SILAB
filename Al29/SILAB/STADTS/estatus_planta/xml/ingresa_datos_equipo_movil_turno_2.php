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
	
	$id_area		=	$_GET['id_area'];
	$id_sub_tipo	=	$_GET['id_sub_tipo'];
	
	if ($id_area == 1) 		 ///////////////////////EQUIPOS REDUCCION///////////////////////
	{
		if ($id_sub_tipo == 1)    ///REDUCCION PRODUCCION
		{
			?> 
				<center>
				<table align="center"> 
					<tr>
						<td>
							<div id="tab_datos_igpp" style="width:660px; height:515px;""> 
								  <div id="tab1" width="150" name="Datos Originales" align="center" style="font-family:Verdana, Arial, Helvetica, sans-serif ">
											<br/><br/><h4>&nbsp; &nbsp; &nbsp; EQUIPO MÓVIL REDUCCIÓN LINEA 1</h4>
											<?=informacion_equipo_movil(6, $dia, $turno, $db, 1, $id_sub_tipo)?><br/>
								  </div>
									  <div id="tab2" width="150" name="Datos Originales" align="center" style="font-family:Verdana, Arial, Helvetica, sans-serif ">
											<br/><br/><h4>&nbsp; &nbsp; &nbsp; EQUIPO MÓVIL REDUCCIÓN LINEA 2</h4>
											<?=informacion_equipo_movil(7, $dia, $turno, $db, 1, $id_sub_tipo)?><br/>
								  </div>
								  <div id="tab3" width="150" name="Datos Originales" align="center" style="font-family:Verdana, Arial, Helvetica, sans-serif ">
											<br/><br/><h4>&nbsp; &nbsp; &nbsp; EQUIPO MÓVIL REDUCCIÓN LINEA 3</h4>
											<?=informacion_equipo_movil(8, $dia, $turno, $db, 1, $id_sub_tipo)?><br/>
								  </div>
								  <div id="tab4" width="150" name="Datos Originales" align="center" style="font-family:Verdana, Arial, Helvetica, sans-serif ">
											<br/><br/><h4>&nbsp; &nbsp; &nbsp; EQUIPO MÓVIL REDUCCIÓN LINEA 4</h4>
											<?=informacion_equipo_movil(9, $dia, $turno, $db, 1, $id_sub_tipo)?><br/>
								  </div>
								  <div id="tab5" width="150" name="Datos Originales" align="center" style="font-family:Verdana, Arial, Helvetica, sans-serif ">
											<br/><br/><h4>&nbsp; &nbsp; &nbsp; EQUIPO MÓVIL REDUCCIÓN LINEA 5</h4>
											<?=informacion_equipo_movil(10, $dia, $turno, $db, 1, $id_sub_tipo)?><br/>
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
		}
		if ($id_sub_tipo == 2)    ///REDUCCION MANTENIMIENTO
		{
			?>
				<center>
				<table align="center">  
					<tr>
						<td>
							<div id="tab_datos_igpp" style="width:660px; height:515px;""> 
								<div id="tab1" width="150" name="Datos Originales" align="center" style="font-family:Verdana, Arial, Helvetica, sans-serif ">
										<br/><br/><h4>&nbsp; &nbsp; &nbsp; EQUIPO MÓVIL REDUCCIÓN MENTENIMIENTO 1</h4>
										<?=informacion_equipo_movil(24, $dia, $turno, $db, 1, $id_sub_tipo)?><br/>
								</div>
								<div id="tab2" width="150" name="Datos Originales" align="center" style="font-family:Verdana, Arial, Helvetica, sans-serif ">
										<br/><br/><h4>&nbsp; &nbsp; &nbsp; EQUIPO MÓVIL REDUCCIÓN MENTENIMIENTO 2</h4>
										<?=informacion_equipo_movil(25, $dia, $turno, $db, 1, $id_sub_tipo)?><br/>
								</div>
								<div id="tab3" width="150" name="Datos Originales" align="center" style="font-family:Verdana, Arial, Helvetica, sans-serif ">
										<br/><br/><h4>&nbsp; &nbsp; &nbsp; EQUIPO MÓVIL REDUCCIÓN MENTENIMIENTO 3</h4>
										<?=informacion_equipo_movil(26, $dia, $turno, $db, 1, $id_sub_tipo)?><br/>
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
							tabbar.addTab("ventana1","Mtto. 1","80px");
							tabbar.addTab("ventana2","Mtto 2","80px");
							tabbar.addTab("ventana3","Mtto 3","80px");
							tabbar.setContent("ventana1","tab1");
							tabbar.setContent("ventana2","tab2");
							tabbar.setContent("ventana3","tab3");
							tabbar.setTabActive("ventana1");
				</script>
			<?php
		}
		if ($id_sub_tipo == 3)    ///REDUCCION SERVICIOS
		{
			?>
				<center>
				<table align="center"> 
					<tr>
						<td>
							<div id="tab_datos_igpp" style="width:660px; height:515px;"> 
								<div id="tab1" width="150" name="Datos Originales" align="center" style="font-family:Verdana, Arial, Helvetica, sans-serif ">
										<br/><br/><h4>&nbsp; &nbsp; &nbsp; EQUIPO MÓVIL REDUCCIÓN SERV. ADICIONES</h4>
										<?=informacion_equipo_movil(30, $dia, $turno, $db, 1, $id_sub_tipo)?><br/>
								</div>
								<div id="tab2" width="150" name="Datos Originales" align="center" style="font-family:Verdana, Arial, Helvetica, sans-serif ">
										<br/><br/><h4>&nbsp; &nbsp; &nbsp; EQUIPO MÓVIL REDUCCIÓN SERV. CRISOLES</h4>
										<?=informacion_equipo_movil(31, $dia, $turno, $db, 1, $id_sub_tipo)?><br/>
								</div>
								<div id="tab3" width="150" name="Datos Originales" align="center" style="font-family:Verdana, Arial, Helvetica, sans-serif ">
										<br/><br/><h4>&nbsp; &nbsp; &nbsp; EQUIPO MÓVIL REDUCCIÓN INCORP. CELDAS</h4>
										<?=informacion_equipo_movil(32, $dia, $turno, $db, 1, $id_sub_tipo)?><br/>
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
							tabbar.addTab("ventana1","Incorp.","80px");
							tabbar.addTab("ventana2","Crisoles","80px");
							tabbar.addTab("ventana3","Adiciones","80px");
							tabbar.setContent("ventana1","tab1");
							tabbar.setContent("ventana2","tab2");
							tabbar.setContent("ventana3","tab3");
							tabbar.setTabActive("ventana1");
				</script>
			<?php
		}
	}
	if ($id_area == 2)   ///////////////////////EQUIPOS CARBON///////////////////////
	{
		if ($id_sub_tipo == 1)    ///CARBON PRODUCCION
		{
			?>
				<center>
				<table align="center"> 
					<tr>
						<td>
							<div id="tab_datos_igpp" style="width:660px; height:515px;"> 
								<div id="tab1" width="150" name="Datos Originales" align="center" style="font-family:Verdana, Arial, Helvetica, sans-serif ">
										<br/><br/><h4>&nbsp; &nbsp; &nbsp; EQUIPO MÓVIL CARBON MOLIENDA</h4>
										<?=informacion_equipo_movil(2, $dia, $turno, $db, 2, $id_sub_tipo)?><br/>
								</div>
								<div id="tab2" width="150" name="Datos Originales" align="center" style="font-family:Verdana, Arial, Helvetica, sans-serif ">
										<br/><br/><h4>&nbsp; &nbsp; &nbsp; EQUIPO MÓVIL CARBON HORNOS</h4>
										<?=informacion_equipo_movil(3, $dia, $turno, $db, 2, $id_sub_tipo)?><br/>
								</div>
								<div id="tab3" width="150" name="Datos Originales" align="center" style="font-family:Verdana, Arial, Helvetica, sans-serif ">
										<br/><br/><h4>&nbsp; &nbsp; &nbsp; EQUIPO MÓVIL CARBON ENVARILLADO</h4>
										<?=informacion_equipo_movil(4, $dia, $turno, $db, 2, $id_sub_tipo)?><br/>
								</div>
								<div id="tab4" width="150" name="Datos Originales" align="center" style="font-family:Verdana, Arial, Helvetica, sans-serif ">
										<br/><br/><h4>&nbsp; &nbsp; &nbsp; EQUIPO MÓVIL ESTACION DE BAÑO 1</h4>
										<?=informacion_equipo_movil(16, $dia, $turno, $db, 2, $id_sub_tipo)?><br/>
								</div>
								<div id="tab5" width="150" name="Datos Originales" align="center" style="font-family:Verdana, Arial, Helvetica, sans-serif ">
										<br/><br/><h4>&nbsp; &nbsp; &nbsp; EQUIPO MÓVIL CARBON ESTACION DE BAÑO 2 </h4>
										<?=informacion_equipo_movil(17, $dia, $turno, $db, 2, $id_sub_tipo)?><br/>
								</div>
								<div id="tab6" width="150" name="Datos Originales" align="center" style="font-family:Verdana, Arial, Helvetica, sans-serif ">
										<br/><br/><h4>&nbsp; &nbsp; &nbsp; EQUIPO MÓVIL CARBON REFRACTARIOS Y VARILLAS</h4>
										<?=informacion_equipo_movil(21, $dia, $turno, $db, 2, $id_sub_tipo)?><br/>
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
							tabbar.addTab("ventana1","Molineda.","80px");
							tabbar.addTab("ventana2","Hornos","80px");
							tabbar.addTab("ventana3","Envari","80px");
							tabbar.addTab("ventana4","Est.Baño 1","80px");
							tabbar.addTab("ventana5","Est.Baño 2","80px");
							tabbar.addTab("ventana6","Refract","80px");
							tabbar.setContent("ventana1","tab1");
							tabbar.setContent("ventana2","tab2");
							tabbar.setContent("ventana3","tab3");
							tabbar.setContent("ventana4","tab4");
							tabbar.setContent("ventana5","tab5");
							tabbar.setContent("ventana6","tab6");
							tabbar.setTabActive("ventana1");
				</script>
			<?php
		}
		if ($id_sub_tipo == 2)    ///CARBON MANTENIMIENTO
		{
			?>
				<center>
				<table align="center">  
					<tr>
						<td>
							<div id="tab_datos_igpp" style="width:660px; height:515px;"> 
								<div id="tab1" width="150" name="Datos Originales" align="center" style="font-family:Verdana, Arial, Helvetica, sans-serif ">
										<br/><br/><h4>&nbsp; &nbsp; &nbsp; EQUIPO MÓVIL CARBON MANTENIMIENTO HORNOS</h4>
										<?=informacion_equipo_movil(20, $dia, $turno, $db, 2, $id_sub_tipo)?><br/>
								</div>
								<div id="tab2" width="150" name="Datos Originales" align="center" style="font-family:Verdana, Arial, Helvetica, sans-serif ">
										<br/><br/><h4>&nbsp; &nbsp; &nbsp; EQUIPO MÓVIL CARBON MANTENIMIENTO ENVARILLADO</h4>
										<?=informacion_equipo_movil(19, $dia, $turno, $db, 2, $id_sub_tipo)?><br/>
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
							tabbar.addTab("ventana1","Mtto. 1","80px");
							tabbar.addTab("ventana2","Mtto 2","80px");
							tabbar.setContent("ventana1","tab1");
							tabbar.setContent("ventana2","tab2");
							tabbar.setTabActive("ventana1");
				</script>
			<?php
		}
	}
	if ($id_area == 3)   ///////////////////////EQUIPOS COLADA///////////////////////
	{
		if ($id_sub_tipo == 1)    ///COLADA PRODUCCION
		{
			?>
				<center>
				<table align="center">  
					<tr>
						<td>
							<div id="tab_datos_igpp" style="width:660px; height:515px;"> 
								<div id="tab1" width="150" name="Datos Originales" align="center" style="font-family:Verdana, Arial, Helvetica, sans-serif ">
										<br/><br/><h4>&nbsp; &nbsp; &nbsp; EQUIPO MÓVIL COLADA</h4>
										<?=informacion_equipo_movil(5, $dia, $turno, $db, 3, $id_sub_tipo)?><br/>
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
		}
	}
	if ($id_area == 5)   ///////////////////////EQUIPOS SUMINISTROS INDUSTRIALES///////////////////////
	{
		if ($id_sub_tipo == 1)    ///SUMINISTROS
		{
			?> 
				<center>
				<table align="center"> 
					<tr>
						<td>
							<div id="tab_datos_igpp" style="width:660px; height:515px;"> 
								  <div id="tab1" width="150" name="Datos Originales" align="center" style="font-family:Verdana, Arial, Helvetica, sans-serif ">
											<br/><br/><h4>&nbsp; &nbsp; &nbsp; EQUIPO MÓVIL MANEJO DE MATERIALES</h4>
											<?=informacion_equipo_movil(23, $dia, $turno, $db, 5, $id_sub_tipo)?><br/>
								  </div>
									  <div id="tab2" width="150" name="Datos Originales" align="center" style="font-family:Verdana, Arial, Helvetica, sans-serif ">
											<br/><br/><h4>&nbsp; &nbsp; &nbsp; EQUIPO MÓVIL OPERACIONES MUELLE</h4>
											<?=informacion_equipo_movil(27, $dia, $turno, $db, 5, $id_sub_tipo)?><br/>
								  </div>
								  <div id="tab3" width="150" name="Datos Originales" align="center" style="font-family:Verdana, Arial, Helvetica, sans-serif ">
											<br/><br/><h4>&nbsp; &nbsp; &nbsp; EQUIPO MÓVIL REACONDICIONAMIENTO CATODICO</h4>
											<?=informacion_equipo_movil(29, $dia, $turno, $db, 5, $id_sub_tipo)?><br/>
								  </div>
								  <div id="tab4" width="150" name="Datos Originales" align="center" style="font-family:Verdana, Arial, Helvetica, sans-serif ">
											<br/><br/><h4>&nbsp; &nbsp; &nbsp; EQUIPO MÓVIL SISTEMAS INDUSTRIALES</h4>
											<?=informacion_equipo_movil(33, $dia, $turno, $db, 5, $id_sub_tipo)?><br/>
								  </div>
								  <div id="tab5" width="150" name="Datos Originales" align="center" style="font-family:Verdana, Arial, Helvetica, sans-serif ">
											<br/><br/><h4>&nbsp; &nbsp; &nbsp; EQUIPO MÓVIL RECEPCION Y DESPACHO</h4>
											<?=informacion_equipo_movil(34, $dia, $turno, $db, 5, $id_sub_tipo)?><br/>
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
							tabbar.addTab("ventana2","Oper.Muelle","80px");
							tabbar.addTab("ventana3","Reacond.Cat","80px");
							tabbar.addTab("ventana4","Sist.Indust.","80px");
							tabbar.addTab("ventana5","Recep - Desp.","80px");
							tabbar.setContent("ventana1","tab1");
							tabbar.setContent("ventana2","tab2");
							tabbar.setContent("ventana3","tab3");
							tabbar.setContent("ventana4","tab4");
							tabbar.setContent("ventana5","tab5");
							tabbar.setTabActive("ventana1");
				</script>
			<?php
		}
	}
	if ($id_area == 6)   ///////////////////////EQUIPOS TALLER///////////////////////
	{
		if ($id_sub_tipo == 1)    ///POOL 
		{
			?>
				<center>
				<table align="center">  
					<tr>
						<td>
							<div id="tab_datos_igpp" style="width:660px; height:515px;"> 
								<div id="tab1" width="150" name="Datos Originales" align="center" style="font-family:Verdana, Arial, Helvetica, sans-serif ">
										<br/><br/><h4>&nbsp; &nbsp; &nbsp; EQUIPO MÓVIL POOL</h4>
										<?=informacion_equipo_movil(28, $dia, $turno, $db, 6, $id_sub_tipo)?><br/>
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
							tabbar.addTab("ventana1","Pool","80px");
							tabbar.setContent("ventana1","tab1");
							tabbar.setTabActive("ventana1");
				</script>
			<?php
		}
	}
	
	function informacion_equipo_movil($sub_area, $dia, $turno, $db, $area, $sub_tipo)
	{
		$sq_m1			=	"SELECT * FROM estaus_planta_equipo_movil WHERE fecha = '$dia' AND turno = '$turno' AND sub_area = '$sub_area'";
		$query_m1		=	mig_query($sq_m1, $db);
		while($res_m1	=	pg_fetch_array($query_m1))
		{
			$id			=	$res_m1['tipo_equipo_movil'];
			$arreglo_operativo[$id]		=	$res_m1['cantidad_operativo'];
		}
		
		$sq_m2			=	"SELECT * FROM estatus_planta_diccionario_estandar_equipo_movil_area WHERE id_sub_area = '$sub_area'";
		$query_m2		=	mig_query($sq_m2, $db);
		while ($res_m2	=	pg_fetch_array($query_m2))
		{
			$id			=	$res_m2['id_equipo_movil'];
			$arreglo_estandar[$id]		=	$res_m2['cantidad_estandar'];
		}	
		
		
		?>
			<link rel="STYLESHEET" type="text/css" href="/scp/modules/estatus_planta/estilos1.css">
			<link rel="STYLESHEET" type="text/css" href="../estilos1.css">
			<input type="hidden" id="oculto_fecha" value="<?=$dia?>">
			<input type="hidden" id="oculto_turno" value="<?=$turno?>">
			<input type="hidden" id="oculto_area" value="<?=$area?>">
			<input type="hidden" id="oculto_sub_tipo" value="<?=$sub_tipo?>">
			<div style="width:100%; text-align:center ">
				<table style="width:90%; text-align:center" border="0" cellpadding="0" cellspacing="0">
					<tr>
						<td>&nbsp;</td>
						<td class="encabezado_formulario_ingreso">Montacargas</td>
						<td class="encabezado_formulario_ingreso">Remolcadores</td>
						<td class="encabezado_formulario_ingreso">Skyder</td>
						<td class="encabezado_formulario_ingreso">Payloader</td>
						<td class="encabezado_formulario_ingreso">Camión</td>
						<td class="encabezado_formulario_ingreso">Tractor</td>
					</tr>
					<tr>
						<td class="encabezado_formulario_ingreso">Estándar</td>
						<td class="cuerpo_formulario_ingreso_1"><input type="text" id="estandar_1_sub_area_<?=$sub_area?>" size="2" maxlength="2" value="<?php if ($arreglo_estandar[1] > 0) echo $arreglo_estandar[1]; else echo "0";?>" readonly="yes"></td>
						<td class="cuerpo_formulario_ingreso_1"><input type="text" id="estandar_2_sub_area_<?=$sub_area?>" size="2" maxlength="2" value="<?php if ($arreglo_estandar[2] > 0) echo $arreglo_estandar[2]; else echo "0";?>" readonly="yes"></td>
						<td class="cuerpo_formulario_ingreso_1"><input type="text" id="estandar_3_sub_area_<?=$sub_area?>" size="2" maxlength="2" value="<?php if ($arreglo_estandar[3] > 0) echo $arreglo_estandar[3]; else echo "0";?>" readonly="yes"></td>
						<td class="cuerpo_formulario_ingreso_1"><input type="text" id="estandar_4_sub_area_<?=$sub_area?>" size="2" maxlength="2" value="<?php if ($arreglo_estandar[4] > 0) echo $arreglo_estandar[4]; else echo "0";?>" readonly="yes"></td>
						<td class="cuerpo_formulario_ingreso_1"><input type="text" id="estandar_5_sub_area_<?=$sub_area?>" size="2" maxlength="2" value="<?php if ($arreglo_estandar[5] > 0) echo $arreglo_estandar[5]; else echo "0";?>" readonly="yes"></td>
						<td class="cuerpo_formulario_ingreso_1"><input type="text" id="estandar_6_sub_area_<?=$sub_area?>" size="2" maxlength="2" value="<?php if ($arreglo_estandar[6] > 0) echo $arreglo_estandar[6]; else echo "0";?>" readonly="yes"></td>
					</tr>
					<tr>
						<td class="encabezado_formulario_ingreso">Operativo</td>
						<td class="cuerpo_formulario_ingreso_1"><input type="text" id="operativo_1_sub_area_<?=$sub_area?>" size="2" maxlength="2" value="<?php if ($arreglo_operativo[1] > 0) echo $arreglo_operativo[1]; else echo "0";?>" onKeyPress="javascript:if(event.keyCode<46 || event.keyCode>57){return false;}"></td>
						<td class="cuerpo_formulario_ingreso_1"><input type="text" id="operativo_2_sub_area_<?=$sub_area?>" size="2" maxlength="2" value="<?php if ($arreglo_operativo[2] > 0) echo $arreglo_operativo[2]; else echo "0";?>" onKeyPress="javascript:if(event.keyCode<46 || event.keyCode>57){return false;}"></td>
						<td class="cuerpo_formulario_ingreso_1"><input type="text" id="operativo_3_sub_area_<?=$sub_area?>" size="2" maxlength="2" value="<?php if ($arreglo_operativo[3] > 0) echo $arreglo_operativo[3]; else echo "0";?>" onKeyPress="javascript:if(event.keyCode<46 || event.keyCode>57){return false;}"></td>
						<td class="cuerpo_formulario_ingreso_1"><input type="text" id="operativo_4_sub_area_<?=$sub_area?>" size="2" maxlength="2" value="<?php if ($arreglo_operativo[4] > 0) echo $arreglo_operativo[4]; else echo "0";?>" onKeyPress="javascript:if(event.keyCode<46 || event.keyCode>57){return false;}"></td>
						<td class="cuerpo_formulario_ingreso_1"><input type="text" id="operativo_5_sub_area_<?=$sub_area?>" size="2" maxlength="2" value="<?php if ($arreglo_operativo[5] > 0) echo $arreglo_operativo[5]; else echo "0";?>" onKeyPress="javascript:if(event.keyCode<46 || event.keyCode>57){return false;}"></td>
						<td class="cuerpo_formulario_ingreso_1"><input type="text" id="operativo_6_sub_area_<?=$sub_area?>" size="2" maxlength="2" value="<?php if ($arreglo_operativo[6] > 0) echo $arreglo_operativo[6]; else echo "0";?>" onKeyPress="javascript:if(event.keyCode<46 || event.keyCode>57){return false;}"></td>
					</tr>
					<tr>
						<td>&nbsp;</td>
						<td class="encabezado_formulario_ingreso">Cisterna</td>
						<td class="encabezado_formulario_ingreso">Compresor</td>
						<td class="encabezado_formulario_ingreso">Montacargas (R)</td>
						<td class="encabezado_formulario_ingreso">Plataforma</td>
						<td class="encabezado_formulario_ingreso">Excavadora</td>
						<td class="encabezado_formulario_ingreso">&nbsp;</td>
					</tr>
					<tr>
						<td class="encabezado_formulario_ingreso">Estándar</td>
						<td class="cuerpo_formulario_ingreso_1"><input type="text" id="estandar_7_sub_area_<?=$sub_area?>" size="2" maxlength="2" 	value="<?php if ($arreglo_estandar[7] > 0) echo $arreglo_estandar[7]; else echo "0";?>" readonly="yes"></td>
						<td class="cuerpo_formulario_ingreso_1"><input type="text" id="estandar_8_sub_area_<?=$sub_area?>" size="2" maxlength="2" 	value="<?php if ($arreglo_estandar[8] > 0) echo $arreglo_estandar[8]; else echo "0";?>" readonly="yes"></td>
						<td class="cuerpo_formulario_ingreso_1"><input type="text" id="estandar_9_sub_area_<?=$sub_area?>" size="2" maxlength="2" 	value="<?php if ($arreglo_estandar[9] > 0) echo $arreglo_estandar[9]; else echo "0";?>" readonly="yes"></td>
						<td class="cuerpo_formulario_ingreso_1"><input type="text" id="estandar_10_sub_area_<?=$sub_area?>" size="2" maxlength="2" 	value="<?php if ($arreglo_estandar[10] > 0) echo $arreglo_estandar[10]; else echo "0";?>" readonly="yes"></td>
						<td class="cuerpo_formulario_ingreso_1"><input type="text" id="estandar_11_sub_area_<?=$sub_area?>" size="2" maxlength="2" 	value="<?php if ($arreglo_estandar[11] > 0) echo $arreglo_estandar[11]; else echo "0";?>" readonly="yes"></td>
						<td class="cuerpo_formulario_ingreso_1">&nbsp;</td>
					</tr>
					<tr>
						<td class="encabezado_formulario_ingreso">Operativo</td>
						<td class="cuerpo_formulario_ingreso_1"><input type="text" id="operativo_7_sub_area_<?=$sub_area?>" size="2" maxlength="2" value="<?php if ($arreglo_operativo[7] > 0) echo $arreglo_operativo[7]; else echo "0";?>" onKeyPress="javascript:if(event.keyCode<46 || event.keyCode>57){return false;}"></td>
						<td class="cuerpo_formulario_ingreso_1"><input type="text" id="operativo_8_sub_area_<?=$sub_area?>" size="2" maxlength="2" value="<?php if ($arreglo_operativo[8] > 0) echo $arreglo_operativo[8]; else echo "0";?>" onKeyPress="javascript:if(event.keyCode<46 || event.keyCode>57){return false;}"></td>
						<td class="cuerpo_formulario_ingreso_1"><input type="text" id="operativo_9_sub_area_<?=$sub_area?>" size="2" maxlength="2" value="<?php if ($arreglo_operativo[9] > 0) echo $arreglo_operativo[9]; else echo "0";?>" onKeyPress="javascript:if(event.keyCode<46 || event.keyCode>57){return false;}"></td>
						<td class="cuerpo_formulario_ingreso_1"><input type="text" id="operativo_10_sub_area_<?=$sub_area?>" size="2" maxlength="2" value="<?php if ($arreglo_operativo[10] > 0) echo $arreglo_operativo[10]; else echo "0";?>" onKeyPress="javascript:if(event.keyCode<46 || event.keyCode>57){return false;}"></td>
						<td class="cuerpo_formulario_ingreso_1"><input type="text" id="operativo_11_sub_area_<?=$sub_area?>" size="2" maxlength="2" value="<?php if ($arreglo_operativo[11] > 0) echo $arreglo_operativo[11]; else echo "0";?>" onKeyPress="javascript:if(event.keyCode<46 || event.keyCode>57){return false;}"></td>
						<td class="cuerpo_formulario_ingreso_1">&nbsp;</td>
					</tr>
				</table>
				<br/>
				<input type="button" value="Procesar Area" onClick="guarda_datos_equipo_movil_turno_2(<?=$area?>, <?=$sub_area?>)"/>
			</div>
		<?php
	}
?>
