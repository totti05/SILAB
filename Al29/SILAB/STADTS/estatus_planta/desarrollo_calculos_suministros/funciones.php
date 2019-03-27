<style type="text/css"> n
	.encabezado_formulario{
		text-align:center;
		font-weight:bold;
		}
</style>

<?php
function formulario_ingresa_pantalla_manual_reduccion($tipo_consulta)
{
	$fec1		=	date("d", time())."/".date("m", time())."/".date("Y", time());

	if ($tipo_consulta == 'turno') 	{$variable	=	"visible";		$valor_variable = 1;}
	if ($tipo_consulta == 'dia') 	{$variable	=	"hidden";		$valor_variable = 2;}
	?>
		<div id="encabezado_formulario" class="encabezado_formulario">
			<H3>Sistema Estatus de Planta</H3>
			<h4>Ingreso/Modificación Variables de Reducción</h4>
			Seleccione la modalidad turno/dia de las variables que ingresará/modificará <br><br>
		</div>
		<br/>
		<input type="hidden" id="select_turno_dia" value="<?=$valor_variable?>">
		<center>
			<input type="text" id="fecha_carga_reduccion" value="<?=$fec1?>" size="10" maxlength="10" disabled="disabled"/>
			<input type="button" id="boton_cambia_fecha_2" value="Cambiar Fecha" />
			<br /><br />
			<div id="div_select_turno"  style="visibility:<?=$variable?>">
				<select id="select_turno">
					<option value="1">Turno 1</option>
					<option value="2">Turno 2</option>
					<option value="3">Turno 3</option>
				</select>
			</div>
			<br/>
			<input type="button" id="boton_actualiza_reduccion" onClick="boton_actualiza_reduccion()" value="Actualizar">
		<script language="javascript" type="text/javascript">
			var fecha_carga = new Zapatec.Calendar.setup({
				inputField     :    "fecha_carga_reduccion",     // id of the input field
				ifFormat       :    "%d/%m/%Y",     // format of the input field
				button         :    "boton_cambia_fecha_2",  // What will trigger the popup of the calendar
				timeInterval   :     1,
				showsTime      :     true
				});
			
		</script>
		<div id="formulario_ingresa_datos_reduccion"></div>
		<br/>
		</center>
		<div id="respuesta_ingresa_datos_reduccion"></div>
		<div id="myspan"></div>
	<?php
}

function formulario_ingresa_pantalla_manual_colada()
{
	$fec1		=	date("d", time())."/".date("m", time())."/".date("Y", time());

	?>
		<div id="encabezado_formulario" class="encabezado_formulario">
			<H3>Sistema Estatus de Planta</H3>
			<h4>Ingreso/Modificación Variables de Colada</h4>
			Seleccione la modalidad turno/dia de las variables que ingresará/modificará <br>
		</div>
		<br/>
		<center>
			<input type="text" id="fecha_carga_colada" value="<?=$fec1?>" size="10" maxlength="10" disabled="disabled"/>
			<input type="button" id="boton_cambia_fecha_2" value="Cambiar Fecha" />
			<br /><br />
			<div id="div_select_turno">
				<select id="select_turno">
					<option value="1">Turno 1</option>
					<option value="2">Turno 2</option>
					<option value="3">Turno 3</option>
				</select>
			</div>
			<br/>
			<input type="button" id="boton_actualiza_colada" onClick="boton_actualiza_colada()" value="Actualizar">
		<script language="javascript" type="text/javascript">
			var fecha_carga = new Zapatec.Calendar.setup({
				inputField     :    "fecha_carga_colada",     // id of the input field
				ifFormat       :    "%d/%m/%Y",     // format of the input field
				button         :    "boton_cambia_fecha_2",  // What will trigger the popup of the calendar
				timeInterval   :     1,
				showsTime      :     true
				});
		</script>
		<div id="formulario_ingresa_datos_colada"></div>
		<br/>
	    </center>
		<div id="respuesta_ingresa_datos_colada"></div>
		<div id="myspan"></div>
	<?php
}

function formulario_ingresa_pantalla_manual_fase_densa_turno()
{
	$fec1		=	date("d", time())."/".date("m", time())."/".date("Y", time());

	?>
		<div id="encabezado_formulario" class="encabezado_formulario">
			<H3>Sistema Estatus de Planta</H3>
			<h4>Ingreso/Modificación Variables de Niveles de Silos en Complejo</h4>
			Seleccione la modalidad turno/dia de las variables que ingresará/modificará <br>
		</div>
		<br/>
		<center>
			<input type="text" id="fecha_carga_auxiliares" value="<?=$fec1?>" size="10" maxlength="10" disabled="disabled"/>
			<input type="button" id="boton_cambia_fecha_2" value="Cambiar Fecha" />
			<br /><br />
			<div id="div_select_turno">
				<select id="select_turno">
					<option value="1">Turno 1</option>
					<option value="2">Turno 2</option>
					<option value="3">Turno 3</option>
				</select>
			</div>
			<br/>
			<input type="button" id="boton_actualiza_auxiliares" onClick="boton_actualiza_auxiliares(1)" value="Actualizar">
		<script language="javascript" type="text/javascript">
			var fecha_carga = new Zapatec.Calendar.setup({
				inputField     :    "fecha_carga_auxiliares",     // id of the input field
				ifFormat       :    "%d/%m/%Y",     // format of the input field
				button         :    "boton_cambia_fecha_2",  // What will trigger the popup of the calendar
				timeInterval   :     1,
				showsTime      :     true
				});
		</script>
		<div id="formulario_ingresa_datos_auxiliares"></div>
		<br/>
	    </center>
		<div id="respuesta_ingresa_datos_auxiliares"></div>
		<div id="myspan"></div>
	<?php
}

function formulario_ingresa_pantalla_manual_manejo_mat_turno()
{
	$fec1		=	date("d", time())."/".date("m", time())."/".date("Y", time());

	?>
		<div id="encabezado_formulario" class="encabezado_formulario">
			<H3>Sistema Estatus de Planta</H3>
			<h4>Ingreso/Modificación Variables de Niveles de Silos en Complejo</h4>
			Seleccione la modalidad turno/dia de las variables que ingresará/modificará <br>
		</div>
		<br/>
		<center>
			<input type="text" id="fecha_carga_auxiliares" value="<?=$fec1?>" size="10" maxlength="10" disabled="disabled"/>
			<input type="button" id="boton_cambia_fecha_2" value="Cambiar Fecha" />
			<br /><br />
			<div id="div_select_turno">
				<select id="select_turno">
					<option value="1">Turno 1</option>
					<option value="2">Turno 2</option>
					<option value="3">Turno 3</option>
				</select>
			</div>
			<br/>
			<input type="button" id="boton_actualiza_auxiliares" onClick="boton_actualiza_auxiliares(2)" value="Actualizar">
		<script language="javascript" type="text/javascript">
			var fecha_carga = new Zapatec.Calendar.setup({
				inputField     :    "fecha_carga_auxiliares",     // id of the input field
				ifFormat       :    "%d/%m/%Y",     // format of the input field
				button         :    "boton_cambia_fecha_2",  // What will trigger the popup of the calendar
				timeInterval   :     1,
				showsTime      :     true
				});
		</script>
		<div id="formulario_ingresa_datos_auxiliares"></div>
		<br/>
	    </center>
		<div id="respuesta_ingresa_datos_auxiliares"></div>
		<div id="myspan"></div>
	<?php
}

function formulario_ingresa_pantalla_manual_carbon($tipo_consulta)
{
	$fec1		=	date("d", time())."/".date("m", time())."/".date("Y", time());

	if ($tipo_consulta == 'turno') 	{$variable	=	"visible";		$valor_variable = 1;}
	if ($tipo_consulta == 'dia') 	{$variable	=	"hidden";		$valor_variable = 2;}
	?>
		<div id="encabezado_formulario" class="encabezado_formulario">
			<H3>Sistema Estatus de Planta</H3>
			<h4>Ingreso/Modificación Variables de Carbón</h4>
			Seleccione la modalidad turno/dia de las variables que ingresará/modificará <br><br>
		</div>
		<br/>
		<input type="hidden" id="select_turno_dia" value="<?=$valor_variable?>">
		<center>
			<input type="text" id="fecha_carga_carbon" value="<?=$fec1?>" size="10" maxlength="10" disabled="disabled"/>
			<input type="button" id="boton_cambia_fecha_2" value="Cambiar Fecha" />
			<br /><br />
			<div id="div_select_turno"  style="visibility:<?=$variable?>">
				<select id="select_turno">
					<option value="1">Turno 1</option>
					<option value="2">Turno 2</option>
					<option value="3">Turno 3</option>
				</select>
			</div>
			<br/>
			<input type="button" id="boton_actualiza_carbon" onClick="boton_actualiza_carbon()" value="Actualizar">
		<script language="javascript" type="text/javascript">
			var fecha_carga = new Zapatec.Calendar.setup({
				inputField     :    "fecha_carga_carbon",     // id of the input field
				ifFormat       :    "%d/%m/%Y",     // format of the input field
				button         :    "boton_cambia_fecha_2",  // What will trigger the popup of the calendar
				timeInterval   :     1,
				showsTime      :     true
				});
		</script>
		<div id="formulario_ingresa_datos_carbon"></div>
		<br/>
	    </center>
		<div id="respuesta_ingresa_datos_carbon"></div>
		<div id="myspan"></div>
	<?php
}

function formulario_cargar_datos_por_turno()
{
	$fec1		=	date("d", time())."/".date("m", time())."/".date("Y", time());
	?>
		<form onMouseOver="limpiar_div(20)">
		<center>
			<h3>Sistema Reporte Estatus de Planta</h3>
			<br />
			<h4>Proceso de Carga de Datos Automática</h4>
			<br />
			<h5 style="color:red; font-weight:bold">PRIMERO Seleccione la fecha y el turno que desea cargar al sistema</h5>
			<br />
			<input type="text" id="cuadro_fecha_carga_datos_turno" value="<?=$fec1?>" size="10" maxlength="10" disabled="disabled"/>
			<input type="button" id="boton_cambia_fecha_1" value="Cambiar Fecha" />
			<br /><br />
			<div id="div_select_turno">
				<select id="select_turno">
					<option value="1">Turno 1</option>
					<option value="2">Turno 2</option>
					<option value="3">Turno 3</option>
				</select>
			</div>
			<br/>
			<input type="button" id="boton_procesa_carga_igpp_automatico" value="Cargar Información" onclick="javascript:procesa_carga_datos_turno_automatico()" />
		</center>
		<div id="letrero_avisos"></div>
		<div id="myspan"></div>
		</form>
		<script language="javascript" type="text/javascript">
			var fecha_carga = new Zapatec.Calendar.setup({
				inputField     :    "cuadro_fecha_carga_datos_turno",     // id of the input field
				ifFormat       :    "%d/%m/%Y",     // format of the input field
				button         :    "boton_cambia_fecha_1",  // What will trigger the popup of the calendar
				timeInterval   :     1,
				showsTime      :     true
				});
			
		</script>
		<br/>
		<div id="respuesta_carga_datos_turno1"></div>
		<div id="respuesta_carga_datos_turno2"></div>
		<div id="respuesta_carga_datos_turno3"></div>
	<?php
}

function formulario_cargar_datos_por_dia()
{
	$fec1		=	date("d", time())."/".date("m", time())."/".date("Y", time());
	?>
		<form onMouseOver="limpiar_div(21)">
		<center>
			<h3>Sistema Reporte Estatus de Planta</h3>
			<br />
			<h4>Proceso de Carga de Datos Automática</h4>
			<br />
			<h5 style="color:red; font-weight:bold">PRIMERO Seleccione la fecha que desea cargar al sistema</h5>
			<br />
			<input type="text" id="cuadro_fecha_carga_datos_dia" value="<?=$fec1?>" size="10" maxlength="10" disabled="disabled"/>
			<input type="button" id="boton_cambia_fecha_1" value="Cambiar Fecha" />
			<br /><br />
			<br/>
			<input type="button" id="boton_procesa_carga_igpp_automatico" value="Cargar Información" onclick="javascript:procesa_carga_datos_dia_automatico()" />
		</center>
		<div id="letrero_avisos"></div>
		<div id="myspan"></div>
		</form>
		<script language="javascript" type="text/javascript">
			var fecha_carga = new Zapatec.Calendar.setup({
				inputField     :    "cuadro_fecha_carga_datos_dia",     // id of the input field
				ifFormat       :    "%d/%m/%Y",     // format of the input field
				button         :    "boton_cambia_fecha_1",  // What will trigger the popup of the calendar
				timeInterval   :     1,
				showsTime      :     true
				});
			
		</script>
		<br/>
		<div id="respuesta_carga_datos_dia1"></div>
		<div id="respuesta_carga_datos_dia2"></div>
		<div id="respuesta_carga_datos_dia3"></div>
	<?php
}
function formulario_ingresa_pantalla_manual_equipo_movil_turno($area, $sub_tipo)
{
	$fec1		=	date("d", time())."/".date("m", time())."/".date("Y", time());
	?>
		<form>
		<center>
			<h3>Sistema Reporte Estatus de Planta</h3>
			<br />
			<h4>Proceso de Carga de Datos de los Equipos Móviles</h4>
			<br />
			<h5 style="color:red; font-weight:bold">PRIMERO Seleccione la fecha y el turno que desea cargar al sistema</h5>
			<br />
			<input type="hidden" id="oculto_area_equipo_movil" value="<?=$area?>">
			<input type="hidden" id="oculto_sub_tipo_equipo_movil" value="<?=$sub_tipo?>">
			<input type="text" id="cuadro_fecha_carga_datos_turno" value="<?=$fec1?>" size="10" maxlength="10" disabled="disabled"/>
			<input type="button" id="boton_cambia_fecha_1" value="Cambiar Fecha" />
			<br /><br />
			<div id="div_select_turno">
				<select id="select_turno">
					<option value="1">Turno 1</option>
					<option value="2">Turno 2</option>
					<option value="3">Turno 3</option>
				</select>
			</div>
			<br/>
			<input type="button" id="boton_procesa_carga_igpp_automatico" value="Cargar Información" onclick="javascript:boton_actualiza_equipo_movil()" />
		</center>
		<div id="formulario_ingresa_datos_equipo_movil"></div>
		<div id="letrero_avisos"></div>
		<div id="myspan"></div>
		</form>
		<script language="javascript" type="text/javascript">
			var fecha_carga = new Zapatec.Calendar.setup({
				inputField     :    "cuadro_fecha_carga_datos_turno",     // id of the input field
				ifFormat       :    "%d/%m/%Y",     // format of the input field
				button         :    "boton_cambia_fecha_1",  // What will trigger the popup of the calendar
				timeInterval   :     1,
				showsTime      :     true
				});
			
		</script>
		<br/>
		<div id="respuesta_carga_datos_equipo_movil_turno_1"></div>
	<?php
}
function formulario_ingresa_pantalla_manual_materias_primas_dia()
{
	$fec1		=	date("d", time())."/".date("m", time())."/".date("Y", time());
	?>
		<form>
		<center>
			<h3>Sistema Reporte Estatus de Planta</h3>
			<br />
			<h4>Proceso de Carga de Datos de las Materias Primas de Planta</h4>
			<br />
			<h5 style="color:red; font-weight:bold">PRIMERO Seleccione la fecha y el turno que desea cargar al sistema</h5>
			<br />
			<input type="text" id="cuadro_fecha_carga_datos_turno" value="<?=$fec1?>" size="10" maxlength="10" disabled="disabled"/>
			<input type="button" id="boton_cambia_fecha_1" value="Cambiar Fecha" />
			<br /><br />
			<input type="button" id="boton_procesa_carga_igpp_automatico" value="Cargar Información" onclick="javascript:boton_actualiza_materias_primas()" />
		</center>
		<div id="formulario_ingresa_datos_materias_primas"></div>
		<div id="letrero_avisos"></div>
		<div id="myspan"></div>
		</form>
		<script language="javascript" type="text/javascript">
			var fecha_carga = new Zapatec.Calendar.setup({
				inputField     :    "cuadro_fecha_carga_datos_turno",     // id of the input field
				ifFormat       :    "%d/%m/%Y",     // format of the input field
				button         :    "boton_cambia_fecha_1",  // What will trigger the popup of the calendar
				timeInterval   :     1,
				showsTime      :     true
				});
			
		</script>
		<br/>
		<div id="respuesta_carga_datos_materias_primas_dia"></div>
	<?php
}
function formulario_ingresa_pantalla_manual_observaciones($area)
{
	$fec1		=	date("d", time())."/".date("m", time())."/".date("Y", time());
	if ($area == 1) 	$d_area	=	"Reducción";
	if ($area == 2) 	$d_area	=	"Carbón";
	if ($area == 3) 	$d_area	=	"Colada";
	if ($area == 4) 	$d_area	=	"CCYP";
	if ($area == 6) 	$d_area	=	"Mantenimiento";
	global $dpto_observ_usuario;
	?>
		<form>
		<center>
			<h3>Sistema Reporte Estatus de Planta</h3>
			<br />
			<h4>Proceso de Carga de Datos de las Observaciones de <?=$d_area?></h4>
			<br />
			<h5 style="color:red; font-weight:bold">PRIMERO Seleccione la fecha y el turno que desea cargar al sistema</h5>
			<br />
			<input type="text" id="cuadro_fecha_carga_datos_turno" value="<?=$fec1?>" size="10" maxlength="10" disabled="disabled"/>
			<input type="button" id="boton_cambia_fecha_1" value="Cambiar Fecha" />
			<br /><br />
			<div id="div_select_turno">
				<select id="select_turno">
					<option value="1">Turno 1</option>
					<option value="2">Turno 2</option>
					<option value="3">Turno 3</option>
				</select>
			</div>
			<br/>
			<input type="button" id="boton_procesa_carga_igpp_automatico" value="Cargar Información" onclick="javascript:boton_actualiza_observaciones(<?=$area?>)" />
		</center><br/><br/>
		<div id="formulario_ingresa_datos_observaciones"></div>
		<div id="letrero_avisos"></div>
		<div id="myspan"></div>
		<input type="hidden" id="dpto_observ_usuario" value="<?=$dpto_observ_usuario?>">
		</form>
		<script language="javascript" type="text/javascript">
			var fecha_carga = new Zapatec.Calendar.setup({
				inputField     :    "cuadro_fecha_carga_datos_turno",     // id of the input field
				ifFormat       :    "%d/%m/%Y",     // format of the input field
				button         :    "boton_cambia_fecha_1",  // What will trigger the popup of the calendar
				timeInterval   :     1,
				showsTime      :     true
				});
		</script>
		<br/>
		<div id="respuesta_carga_datos_observ"></div>
	<?php
}


function formulario_genera_reporte_estatus_planta()
{
	$fec1		=	date("d", time())."/".date("m", time())."/".date("Y", time());

	?>
		<div id="encabezado_formulario" class="encabezado_formulario" style="text-align:center ">
			<H3>Sistema Estatus de Planta</H3>
			<h4>Generación del Reporte de Estatus de Planta</h4>
		</div>
		<br/>
		<input type="hidden" id="select_turno_dia" value="<?=$valor_variable?>">
		<center>
			<input type="text" id="fecha_carga_reporte" value="<?=$fec1?>" size="10" maxlength="10" disabled="disabled"/>
			<input type="button" id="boton_cambia_fecha_2" value="Cambiar Fecha" />
			<br /><br />
			<div id="div_select_turno" >
				<select id="select_turno">
					<option value="1">Turno 1</option>
					<option value="2">Turno 2</option>
					<option value="3">Turno 3</option>
				</select>
			</div>
			<br/>
			<input type="button" id="boton_actualiza_reduccion" onClick="genera_reporte_estatus_planta()" value="Actualizar">
		<script language="javascript" type="text/javascript">
			var fecha_carga = new Zapatec.Calendar.setup({
				inputField     :    "fecha_carga_reporte",     // id of the input field
				ifFormat       :    "%d/%m/%Y",     // format of the input field
				button         :    "boton_cambia_fecha_2",  // What will trigger the popup of the calendar
				timeInterval   :     1,
				showsTime      :     true
				});
			
		</script>
		<br/>
		</center>
		<div id="respuesta_ingresa_datos_reduccion"></div>
	<?php
}

function formulario_ingresa_pantalla_manual_accidentes()
{
	$fec1		=	date("d", time())."/".date("m", time())."/".date("Y", time());

	?>
		<div id="encabezado_formulario" class="encabezado_formulario">
			<H3>Sistema Estatus de Planta</H3>
			<h4>Ingreso/Modificación de Accidentes de Planta</h4>
			Seleccione el turno y dia que ingresará/modificará <br>
			<br>
		</div>
		<br/>
		<input type="hidden" id="select_turno_dia" value="<?=$valor_variable?>">
		<center>
			<input type="text" id="fecha_carga" value="<?=$fec1?>" size="10" maxlength="10" disabled="disabled"/>
			<input type="button" id="boton_cambia_fecha_2" value="Cambiar Fecha" />
			<br /><br />
			<div id="div_select_turno"  style="visibility:<?=$variable?>">
				<select id="select_turno">
					<option value="1">Turno 1</option>
					<option value="2">Turno 2</option>
					<option value="3">Turno 3</option>
				</select>
			</div>
			<br/>
			<input type="button" id="boton_actualiza_accidentes" onClick="boton_actualiza_accidentes()" value="Actualizar">
		<script language="javascript" type="text/javascript">
			var fecha_carga = new Zapatec.Calendar.setup({
				inputField     :    "fecha_carga",     // id of the input field
				ifFormat       :    "%d/%m/%Y",     // format of the input field
				button         :    "boton_cambia_fecha_2",  // What will trigger the popup of the calendar
				timeInterval   :     1,
				showsTime      :     true
				});
			
		</script>
		<div id="formulario_ingresa_datos_accidentes"></div>
		<br/>
		</center>
		<div id="repuesta_servidor_accidentes"></div>
		<div id="myspan"></div>
	<?php
}

function formulario_select_usuario_clave() {
	?>
		<table width="50%" align="center" border="0" cellpadding="0" cellspacing="0">
			<tr>
				<td align="center" width="100%" style="font-weight:bold; font-size:14px" height="40">
				Ingrese la ficha del usuario al que desea inicializar la clave:
				</td>
			</tr>
			<tr>
				<td align="center" width="100%" style="font-weight:bold; font-size:14px" height="40">
				<input type="text" size="7" id="ficha_reset"/><button onclick="resetearClave()">Resetear</button>
				<div style="height:20px" id="mensaje_reset_clave"></div>
				</td>
			</tr>
		</table>
		<script type="text/javascript">
			document.getElementById('ficha_reset').focus();
		</script>
	<?php
}

function formulario_select_plan_pco_suministros()
{
	$fec1 = date("j", time())."/".date("n", time())."/".date("Y", time());
	$mes_actual	=	date("n", time());
	$año_actual	=	date("Y", time());
	?>
		<div id="encabezado_formulario" class="encabezado_formulario" align="center">
			<H3>Sistema Estatus de Planta</H3>
			<h4>Ingreso/Modificación del Plan Anual Suministros de Materias Primas</h4>
			Seleccione el mes y año ingresará/modificará <br>
			<br>
		</div>
		<br/>
		<input type="hidden" id="select_turno_dia" value="<?=$valor_variable?>">
		<table border="0" cellpadding="0" cellspacing="0" align="center">
			<tr>
				<td style="width:150px; text-align:center">Seleccione Mes</td>
				<td style="width:150px; text-align:center">Seleccione Año</td>
			</tr>
			<tr>
				<td style="width:150px; text-align:center">
					<select name="select"  id="select_mes_ajuste">
					  <option id="mes_ajuste_1" value="1">Enero</option>
					  <option id="mes_ajuste_2" value="2">Febrero</option>
					  <option id="mes_ajuste_3" value="3">Marzo</option>
					  <option id="mes_ajuste_4" value="4">Abril</option>
					  <option id="mes_ajuste_5" value="5">Mayo</option>
					  <option id="mes_ajuste_6" value="6">Junio</option>
					  <option id="mes_ajuste_7" value="7">Julio</option>
					  <option id="mes_ajuste_8" value="8">Agosto</option>
					  <option id="mes_ajuste_9" value="9">Septiembre</option>
					  <option id="mes_ajuste_10" value="10">Octubre</option>
					  <option id="mes_ajuste_11" value="11">Noviembre</option>
					  <option id="mes_ajuste_12" value="12">Diciembre</option>
					</select>
				</td>
				<td style="width:150px; text-align:center">
					<select name="select"  id="select_año_ajuste">
					  <option id="año_ajuste_2010" value="2010">2010</option>
					  <option id="año_ajuste_2011" value="2011">2011</option>
					  <option id="año_ajuste_2012" value="2012">2012</option>
					  <option id="año_ajuste_2013" value="2013">2013</option>
					  <option id="año_ajuste_2014" value="2014">2014</option>
					  <option id="año_ajuste_2015" value="2015">2015</option>
					  <option id="año_ajuste_2016" value="2016">2016</option>
					  <option id="año_ajuste_2017" value="2017">2017</option>
					  <option id="año_ajuste_2018" value="2018">2018</option>
					  <option id="año_ajuste_2019" value="2019">2019</option>
					  <option id="año_ajuste_2020" value="2020">2020</option>
					  <option id="año_ajuste_2021" value="2021">2021</option>
					  <option id="año_ajuste_2022" value="2022">2022</option>
					</select>
				</td>
			</tr>
			<tr>
				<td colspan="2">&nbsp;</td>
			</tr>
			<tr>
				<td colspan="2" style="text-align:center "><input type="button" id="boton_actualiza_accidentes" onClick="boton_actualiza_plan_pco_suministros()" value="Actualizar" ></td>
			</tr>
		</table>
		
		<div id="formulario_ingresa_datos_pco_suministros"></div>
		<br/>
		<div id="repuesta_servidor_suministros"></div>
		<div id="myspan"></div>
		<script language="javascript">
			var	hoy			=	new Date();
			var este_mes	=	hoy.getMonth();
			var este_anno	=	hoy.getFullYear();

			document.getElementById("mes_ajuste_"+este_mes).selected = true;
			document.getElementById("año_ajuste_"+este_anno).selected = true;

		</script>
	<?php
}

?>