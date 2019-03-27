<?php
include 'conectarse.php';
$linea				=	$_GET['linea'];
$tipo_variable		=	$_GET['tipo_variable'];
$fecha_reporte		=	$_GET['fecha_reporte'];
$turno_reporte		=	$_GET['turno_reporte'];
$tipo_consulta		=	$_GET['tipo_consulta'];

if ($tipo_variable ==	13)	{$desc_tipo_variable	=	"ALIMENTADORES BLOQUEADOS";													$encab_tabla	=	"ALIM. BLOQ.";}


if ($tipo_consulta ==	1)	{$tiempo				=	"DIARIO";					}
if ($tipo_consulta ==	2)	{$tiempo				=	"SEMANAL";					}
if ($tipo_consulta ==	3)	{$tiempo				=	"MENSUAL";					}
if ($tipo_consulta ==	4)	{$tiempo				=	"RESUMEN DIARIO";			}
if ($tipo_consulta ==	5)	{$tiempo				=	"DE TURNO";					}


$db					=	conectarse_postgres();

$fecha_reporte_turno							=	$fecha_reporte;
if ($turno_reporte < 3)
{
	$sq_mf										=	"SELECT '$fecha_reporte'::date - 1 AS fecha, date_part('week', '$fecha_reporte'::date-1) AS semana, 
													date_part('month', '$fecha_reporte'::date-1) AS mes, 
													date_part('year', '$fecha_reporte'::date-1) AS año,
													date_part('day', '$fecha_reporte'::date-1) AS dia";
	$query_mf									=	mig_query($sq_mf, $db);
	$res_mf										=	pg_fetch_array($query_mf);
	list($a, $m, $d)							=	split('-', $res_mf['fecha']);
	$fecha_reporte								=	"$d/$m/$a";
}
$fecha_reporte_mostrar							=	$fecha_reporte;
$turno_mostrar									=	3;

$sq_fecha			=	"SELECT date_part('week', '$fecha_reporte'::date) AS fecha_mostrar";
$query_fecha		=	mig_query($sq_fecha, $db);
$res_fecha			=	pg_fetch_array($query_fecha);
$semana_reporte				=	$res_fecha['fecha_mostrar'];
list($dia, $mes, $año)							=	split('/', $fecha_reporte);
$mes_fecha										=	strftime("%m",mktime(0,0,0,$mes,$dia,$año));
$año_fecha										=	strftime("%Y",mktime(0,0,0,$mes,$dia,$año));

if ($semana_reporte >= 52 &&  $mes_fecha == 1)		$año_fecha	=	$año_fecha - 1;
if ($semana_reporte <= 3  &&  $mes_fecha == 12)		$año_fecha	=	$año_fecha + 1;
$rango 											=	RangoSemana($semana_reporte, $año_fecha);

if ($tipo_consulta == 1)
{
	if ($tipo_variable == 13)
	{
		$sq_m1				=	"SELECT DISTINCT num_celda, valor_variable AS valor
								FROM estatus_planta_reduccion_turno
								WHERE tipo_campo = '$tipo_variable' AND fecha = '$fecha_reporte' ORDER BY num_celda";
	}
}
if ($tipo_consulta == 5)
{
	if ($tipo_variable == 13)
	{
		$sq_m1				=	"SELECT DISTINCT num_celda, AVG(valor_variable) AS valor, COUNT(*) AS num_veces 
								FROM estatus_planta_reduccion_turno 
								WHERE tipo_campo = '$tipo_variable' AND fecha = '$fecha_reporte_turno' AND linea = '$linea' AND turno = '$turno_reporte'
								GROUP BY num_celda";
	}
	$fecha_reporte_mostrar	=	$fecha_reporte_turno;
	$turno_mostrar			=	$turno_reporte;
}
$query_m1			=	mig_query($sq_m1, $db);


?>
	<div style="width:100%; text-align:center ">
		<h5>
		DETALLE <?=$tiempo?> DE CONDICIONES DE CELDAS <br/>
		CELDAS CON <?=$desc_tipo_variable?> <br/>
						Fecha: <?=$fecha_reporte_mostrar?> Turno: <?=$turno_mostrar?>
						<br>
						Semana Nº <?=$semana_reporte?>: del <?=date('d/m/Y', $rango[0])?> al <?=date('d/m/Y', $rango[6])?>
		</h5>
		<table style="width:320px">
			<tr style="background-color:#0066CC; color:#FFFFFF; text-align:center; font-weight:bold ">
				<td style="width:20%; font-family:arialn; font-size:12px; height:8px">Celda</td>
				<td style="width:27%; font-family:arialn; font-size:12px; height:8px"><?=$encab_tabla?></td>
				<?php
				if ($tipo_variable == 13)
				{
					?>
					<td style="width:27%; font-family:arialn; font-size:12px; height:8px">Temperatura</td>
					<td style="width:27%; font-family:arialn; font-size:12px; height:8px">Acidez</td>
					<?php
				}
				?>
			</tr>
		<?php
		while($res_m1		=	pg_fetch_array($query_m1))
		{
				$titulo		=	"";
				if ($tipo_variable == 13)
				{
					$num_carac	=	strlen($res_m1['valor']);
					$compl_carc	=	6 - $num_carac;
					if ($compl_carc == 1)	$comple_ceros	=	"0";	if ($compl_carc == 2)	$comple_ceros	=	"00";	if ($compl_carc == 3)	$comple_ceros	=	"000";
					if ($compl_carc == 4)	$comple_ceros	=	"0000";	if ($compl_carc == 5)	$comple_ceros	=	"00000";
					
					$buscar_tolvas		=	$comple_ceros.$res_m1['valor'];
										
					$cad_1				=	substr($buscar_tolvas, 0, 1);
					$cad_2				=	substr($buscar_tolvas, 1, 1);
					$cad_3				=	substr($buscar_tolvas, 2, 1);
					$cad_4				=	substr($buscar_tolvas, 3, 1);
					$cad_5				=	substr($buscar_tolvas, 4, 1);
					$cad_6				=	substr($buscar_tolvas, 5, 1);
					
					if ($linea == 5)
					{
						if ($cad_1 == 1)		$cad_1		=	"Al_1  ";	else	$cad_1	=	"";
						if ($cad_2 == 1)		$cad_2		=	"Al_2  ";	else	$cad_2	=	"";
						if ($cad_3 == 1)		$cad_3		=	"Al_3  ";	else	$cad_3	=	"";
						if ($cad_4 == 1)		$cad_4		=	"Al_4  ";	else	$cad_4	=	"";
						if ($cad_5 == 1)		$cad_5		=	"Al_5  ";	else	$cad_5	=	"";
						if ($cad_6 == 1)		$cad_6		=	" Fl ";		else	$cad_6	=	"";
					
						$res_m1['valor']	=	"$cad_1$cad_2$cad_3$cad_4$cad_5$cad_6";
					}
					else
					{
						//if ($cad_1 == 1)		$cad_1		=	"Al_1  ";	else	$cad_1	=	"";
						if ($cad_2 == 1)		$cad_2		=	"Al_1  ";	else	$cad_2	=	"";
						if ($cad_3 == 1)		$cad_3		=	"Al_2  ";	else	$cad_3	=	"";
						if ($cad_4 == 1)		$cad_4		=	"Al_3  ";	else	$cad_4	=	"";
						if ($cad_5 == 1)		$cad_5		=	"Al_4  ";	else	$cad_5	=	"";
						if ($cad_6 == 1)		$cad_6		=	" Fl ";		else	$cad_6	=	"";

						$res_m1['valor']	=	"$cad_2$cad_3$cad_4$cad_5$cad_6";
					}
					
				
				}
				echo "<tr ";
				if ($num_fila%2==0){ 
					echo "bgcolor = 00CABF"; } //si el resto de la división es 0 pongo un color 				  
				else {                  
					echo "bgcolor= 99DDFF"; } //si el resto de la división NO es 0 pongo otro color 
				echo ">"; ?> 
				<td style="text-align:center; font-family:arialn; font-size:12px; height:8px"><?=$res_m1['num_celda']?></td>
				<td style="text-align:center; font-family:arialn; font-size:12px; height:8px"><?php if ($tipo_variable == 13) echo $res_m1['valor']; else echo round($res_m1['valor'], 2)?></td>
				<?php 
				if ($tipo_variable == 13)
				{
					$detalle_mostrar		=	busca_detalles($res_m1['num_celda'], $fecha_reporte);
					?>
					<td style="text-align:center; font-family:arialn; font-size:12px; height:8px" title="<?=$fecha_reporte?>"><?php valida_dato2($detalle_mostrar['TEMPE'])?></td>
					<td style="text-align:center; font-family:arialn; font-size:12px; height:8px" title="<?=$fecha_reporte?>"><?php valida_dato2($detalle_mostrar['ALF3'])?></td>
					<?php
				}
				?>
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

function busca_detalles($num_celda, $fecha)
{
	$db_detalles				=	conectarse_aluminio20_dac();
	$sq_detalles				=	"SELECT * FROM DATA_FINAL_SIN_ERRORES1 WHERE DIA = '$fecha' AND CELDA = '$num_celda'";
	$query_detalles				=	mig_query($sq_detalles, $db_detalles, 'mssql');
	$res_detalles				=	mssql_fetch_array($query_detalles);
	mssql_close($db_detalles);
	return $res_detalles;	
}

function valida_dato2($dato)
{
	if ($dato == "")
		echo "----";
	else
	{		
		if (abs($dato) >= 0) echo round($dato, 2);
		else echo "---";
	}
}

?>