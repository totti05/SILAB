<?php
include 'conectarse.php';
$linea											=	$_GET['linea'];
$tipo_variable									=	$_GET['tipo_variable'];
$fecha_reporte									=	$_GET['fecha_reporte'];
$turno_reporte									=	$_GET['turno_reporte'];

if ($tipo_variable ==	11)	{$desc_tipo_variable	=	"CRISOLES ASIGNADOS";		$encab_tabla	=	"NUM CRISOL";}
if ($tipo_variable ==	13)	{$desc_tipo_variable	=	"TOLVAS CON FALLAS";		$encab_tabla	=	"NUM CELDA";}

if ($linea < 5) $asig_estandar					=	5;
else			$asig_estandar					=	12;

$tiempo											=	"DE TURNO";	
$db												=	conectarse_postgres();
$fecha_reporte_turno							=	$fecha_reporte;
$sq_mf											=	"SELECT '$fecha_reporte'::date - 1 AS fecha, date_part('week', '$fecha_reporte'::date-1) AS semana, 
													date_part('month', '$fecha_reporte'::date-1) AS mes, 
													date_part('year', '$fecha_reporte'::date-1) AS año,
													date_part('day', '$fecha_reporte'::date-1) AS dia";
$query_mf										=	mig_query($sq_mf, $db);
$res_mf											=	pg_fetch_array($query_mf);
list($a, $m, $d)								=	split('-', $res_mf['fecha']);
$fecha_reporte									=	"$d/$m/$a";

$fecha_reporte_mostrar							=	$fecha_reporte;

$sq_fecha										=	"SELECT date_part('week', '$fecha_reporte'::date) AS fecha_mostrar";
$query_fecha									=	mig_query($sq_fecha, $db);
$res_fecha										=	pg_fetch_array($query_fecha);
$semana_reporte									=	$res_fecha['fecha_mostrar'];
list($dia, $mes, $año)							=	split('/', $fecha_reporte);
$mes_fecha										=	strftime("%m",mktime(0,0,0,$mes,$dia,$año));
$año_fecha										=	strftime("%Y",mktime(0,0,0,$mes,$dia,$año));

if ($semana_reporte >= 52 &&  $mes_fecha == 1)		$año_fecha	=	$año_fecha - 1;
if ($semana_reporte <= 3  &&  $mes_fecha == 12)		$año_fecha	=	$año_fecha + 1;
$rango 											=	RangoSemana($semana_reporte, $año_fecha);

if ($tipo_variable == 11)
{
	$sq_m1										=	"SELECT valor_variable AS num_celda FROM estatus_planta_reduccion_turno WHERE tipo_campo = '$tipo_variable' 
													AND fecha = '$fecha_reporte_turno' AND turno = '$turno_reporte' AND linea = '$linea'";
}
if ($tipo_variable == 13)
{
	$sq_m1										=	"SELECT celda AS num_celda FROM estatus_planta_observaciones_reduccion_celdas 
													WHERE fecha = '$fecha_reporte_turno' AND turno = '$turno_reporte' AND tipo_observacion = '4' AND linea = '$linea'";
}
$query_m1										=	mig_query($sq_m1, $db);


?>
	<div style="width:100%; text-align:center ">
		<h5>
		DETALLE <?=$tiempo?> DE CONDICIONES DE CELDAS <br/>
		CELDAS CON <?=$desc_tipo_variable?> <br/>
						Fecha: <?=$fecha_reporte_mostrar?> Turno: <?=$turno_mostrar?>
						<br>
						Semana Nº <?=$semana_reporte?>: del <?=date('d/m/Y', $rango[0])?> al <?=date('d/m/Y', $rango[6])?>
						<br>Linea: <?=$linea?>
		
		<?php
		if ($tipo_variable == 11)
		{
			echo "<br>Crisoles Estandar: $asig_estandar<br>";
		}
		?>
		</h5>
		<table style="width:320px">
			<tr style="background-color:#0066CC; color:#FFFFFF; text-align:center; font-weight:bold ">
				<td style="width:27%; font-family:arialn; font-size:12px; height:8px"><?=$encab_tabla?></td>
			</tr>
		<?php
		while($res_m1		=	pg_fetch_array($query_m1))
		{
				echo "<tr ";
				if ($num_fila%2==0){ 
					echo "bgcolor = 00CABF"; } //si el resto de la división es 0 pongo un color 				  
				else {                  
					echo "bgcolor= 99DDFF"; } //si el resto de la división NO es 0 pongo otro color 
				echo ">"; ?> 
				<td style="text-align:center; font-family:arialn; font-size:12px; height:8px"><?=round($res_m1['num_celda'], 2)?></td>
			</tr>
			<?php
			$num_fila++;
		}
		?>
		</table>
	</div>
<?php
pg_close($db);
function RangoSemana($sem, $ano) 
{
	$i=1;
	$offset = date('w', mktime(0,0,0,1,1,$ano));
	$offset = ($offset < 5) ? 1-$offset : 8-$offset;
	$monday = mktime(0,0,0,1,1+$offset,$ano);
	$tstampLunes = strtotime('+'.($sem-1).' weeks',$monday);
	$fecha[0] = $tstampLunes;
	while ($i<7) {
			   $fecha[$i] = $fecha[$i-1] + 86400;
			   $i++;
	}
	return $fecha;
}
?>