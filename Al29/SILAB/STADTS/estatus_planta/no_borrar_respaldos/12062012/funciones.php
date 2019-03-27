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

?>