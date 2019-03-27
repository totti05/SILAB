<?php
include 'conectarse.php';
$linea				=	$_GET['linea'];
$tipo_variable		=	$_GET['tipo_variable'];
$fecha_reporte		=	$_GET['fecha_reporte'];
$turno_reporte		=	$_GET['turno_reporte'];
$tipo_consulta		=	$_GET['tipo_consulta'];

if ($tipo_variable ==	2)	{$desc_tipo_variable	=	"MAS DE 1 EA";																$encab_tabla	=	"NUMERO EA (ACUM)";}
if ($tipo_variable ==	1)	{$desc_tipo_variable	=	"TEMPERATURA CRÍTICA<br> 980 < T.C. < 940";									$encab_tabla	=	"TEMPERATURA ºC (PROM)";}
if ($tipo_variable ==	3)	{$desc_tipo_variable	=	"NIVEL DE METAL CRÍTICO<br>P-19: 29 < N.M.C. < 22<br>VL: 26 < N.M.C. < 20";	$encab_tabla	=	"NIVEL DE METAL (PROM)";}
if ($tipo_variable ==	4)	{$desc_tipo_variable	=	"NIVEL DE BAÑO CRÍTICO<br>P-19: 27 < N.B.C. < 20<br>VL: 23 < N.B.C. < 16";	$encab_tabla	=	"NIVEL DE BAÑO (PROM)";}
if ($tipo_variable ==	5)	{$desc_tipo_variable	=	"DESV. RESIST > 0.15";														$encab_tabla	=	"DESV. RESIST (PROM)";}
if ($tipo_variable ==	8)	{$desc_tipo_variable	=	"ALTO HIERRO<br>P-19: 0.5%<br>VL: 0.3%";									$encab_tabla	=	"%Fe (PROM)";}
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
	if ($tipo_variable == 2)
	{
		$sq_m1				=	"SELECT DISTINCT num_celda, SUM(valor_variable) AS valor, COUNT(*) AS num_veces 
								FROM estatus_planta_reduccion_turno 
								WHERE (tipo_campo = '12') AND fecha = '$fecha_reporte' AND linea = '$linea'
								GROUP BY num_celda";
	}
	else
	{
		$sq_m1				=	"SELECT DISTINCT num_celda, AVG(valor_variable) AS valor, COUNT(*) AS num_veces 
								FROM estatus_planta_reduccion_turno 
								WHERE tipo_campo = '$tipo_variable' AND fecha = '$fecha_reporte' AND linea = '$linea'
								GROUP BY num_celda";
	}
	if ($tipo_variable == 13)
	{
		$sq_m1				=	"SELECT DISTINCT num_celda, valor_variable AS valor
								FROM estatus_planta_reduccion_turno
								WHERE tipo_campo = '$tipo_variable' AND fecha = '$fecha_reporte' AND linea = '$linea'";
	}
}
if ($tipo_consulta == 2)
{
	if ($tipo_variable == 2)
	{
		$sq_m1				=	"SELECT DISTINCT num_celda, SUM(valor_variable) AS valor, COUNT(*) AS num_veces 
								FROM 
									(SELECT *,  date_part('week'::text, fecha) AS semana, date_part('month'::text, fecha) AS mes, date_part('year'::text, fecha) AS año 
										FROM estatus_planta_reduccion_turno) DERIVEDTBL
								WHERE tipo_campo = '$tipo_variable' AND semana = '$semana_reporte' AND año = '$año_fecha' AND fecha <= '$fecha_reporte'
								GROUP BY num_celda";
	}
	else
	{
		$sq_m1				=	"SELECT DISTINCT num_celda, AVG(valor_variable) AS valor, COUNT(*) AS num_veces 
								FROM 
									(SELECT *,  date_part('week'::text, fecha) AS semana, date_part('month'::text, fecha) AS mes, date_part('year'::text, fecha) AS año 
										FROM estatus_planta_reduccion_turno) DERIVEDTBL
								WHERE tipo_campo = '$tipo_variable' AND semana = '$semana_reporte' AND año = '$año_fecha' AND fecha <= '$fecha_reporte'
								GROUP BY num_celda";
	}
}
if ($tipo_consulta == 3)
{
	if ($tipo_variable == 2)
	{
		$sq_m1				=	"SELECT DISTINCT num_celda, SUM(valor_variable) AS valor, COUNT(*) AS num_veces 
								FROM 
									(SELECT *,  date_part('week'::text, fecha) AS semana, date_part('month'::text, fecha) AS mes, date_part('year'::text, fecha) AS año 
										FROM estatus_planta_reduccion_turno) DERIVEDTBL
								WHERE tipo_campo = '$tipo_variable' AND mes = '$mes_fecha' AND año = '$año_fecha' AND fecha <= '$fecha_reporte'
								GROUP BY num_celda";
	}
	else
	{
		$sq_m1				=	"SELECT DISTINCT num_celda, AVG(valor_variable) AS valor, COUNT(*) AS num_veces 
								FROM 
									(SELECT *,  date_part('week'::text, fecha) AS semana, date_part('month'::text, fecha) AS mes, date_part('year'::text, fecha) AS año 
										FROM estatus_planta_reduccion_turno) DERIVEDTBL
								WHERE tipo_campo = '$tipo_variable' AND mes = '$mes_fecha' AND año = '$año_fecha' AND fecha <= '$fecha_reporte'
								GROUP BY num_celda";
	}
}
if ($tipo_consulta == 4)
{
	if ($tipo_variable == 2)
	{
		$sq_m1				=	"SELECT DISTINCT num_celda, SUM(valor_variable) AS valor, COUNT(*) AS num_veces 
								FROM estatus_planta_reduccion_turno 
								WHERE tipo_campo = '$tipo_variable' AND fecha = '$fecha_reporte'
								GROUP BY num_celda";
	}
	else
	{
		$sq_m1				=	"SELECT DISTINCT num_celda, AVG(valor_variable) AS valor, COUNT(*) AS num_veces 
								FROM estatus_planta_reduccion_turno 
								WHERE tipo_campo = '$tipo_variable' AND fecha = '$fecha_reporte'
								GROUP BY num_celda";
	}
}
if ($tipo_consulta == 5)
{
	if ($tipo_variable == 2)
	{
		$sq_m1				=	"SELECT DISTINCT num_celda, SUM(valor_variable) AS valor, COUNT(*) AS num_veces 
								FROM estatus_planta_reduccion_turno 
								WHERE tipo_campo = '$tipo_variable' AND fecha = '$fecha_reporte_turno' AND linea = '$linea' AND turno = '$turno_reporte'
								GROUP BY num_celda";
	}
	else
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
				<td style="width:33%; font-family:arialn; font-size:12px; height:8px">
				<?php 
					if ($tipo_variable == 8) echo "Edad"; 
					elseif (($tipo_consulta ==	1 || $tipo_consulta == 4) && $tipo_variable == 1) echo "Acidez";
					elseif ($tipo_consulta == 1 && $tipo_variable == 3) echo "Programado (Kgs)";
					else echo "Num. Ocurrencia";
				?></td>
			</tr>
		<?php
		while($res_m1		=	pg_fetch_array($query_m1))
		{
				$titulo		=	"";
				if ($tipo_consulta ==	2)
				{
					$sq_m20		=	"SELECT DISTINCT date_part('day', fecha) AS dia
									FROM estatus_planta_reduccion_turno
									WHERE tipo_campo = '$tipo_variable' AND date_part('week', fecha) = '$semana_reporte' 
									AND date_part('year', fecha) = '$año_fecha' AND fecha <= '$fecha_reporte'
									AND num_celda = '$res_m1[num_celda]'";
					$query_m20	=	mig_query($sq_m20, $db);
					while($res_m20 = pg_fetch_array($query_m20))
					{
						if($titulo	== "")	$titulo	=	"dias: ".$res_m20['dia'];
						else				$titulo	=	$titulo.",".$res_m20['dia'];
					}
				}
				if ($tipo_consulta ==	3)
				{
					$sq_m20		=	"SELECT DISTINCT date_part('day', fecha) AS dia
									FROM estatus_planta_reduccion_turno
									WHERE tipo_campo = '$tipo_variable' AND date_part('month', fecha) = '$mes_fecha' 
									AND date_part('year', fecha) = '$año_fecha' AND fecha <= '$fecha_reporte'
									AND num_celda = '$res_m1[num_celda]'";
					$query_m20	=	mig_query($sq_m20, $db);
					while($res_m20 = pg_fetch_array($query_m20))
					{
						if($titulo	== "")	$titulo	=	"dias: ".$res_m20['dia'];
						else				$titulo	=	$titulo.",".$res_m20['dia'];
					}
				}
				if ($tipo_variable == 8)
				{
					$sq_m21		=	"SELECT edad FROM estatus_planta_edad_celdas_alto_fe WHERE num_celda = '$res_m1[num_celda]' ORDER BY fecha DESC LIMIT 2";
					$query_m21	=	mig_query($sq_m21, $db);
					$res_m21	=	pg_fetch_array($query_m21);
					
					if ($tipo_consulta == 1)
					{
						$sq_m24		=	"SELECT fecha, valor_variable FROM estatus_planta_reduccion_turno WHERE fecha <= '$fecha_reporte' AND tipo_campo = '8' 
										AND num_celda = '$res_m1[num_celda]' ORDER BY fecha DESC LIMIT 2";	
						$query_m24	=	mig_query($sq_m24, $db);
						$res_m24	=	pg_fetch_array($query_m24);
						$var_alto_fe[1]['fecha']				=	$res_m24['fecha'];
						$var_alto_fe[1]['valor_variable']		=	$res_m24['valor_variable'];
						$res_m24	=	pg_fetch_array($query_m24);
						$var_alto_fe[2]['fecha']				=	$res_m24['fecha'];
						$var_alto_fe[2]['valor_variable']		=	$res_m24['valor_variable'];
						$var_alto_fe['delta_fe']				=	$var_alto_fe[1]['valor_variable'] - $var_alto_fe[2]['valor_variable'];
						$titulo									=	$var_alto_fe[1]['fecha'].": ".$var_alto_fe[1]['valor_variable']."%\n".
																	$var_alto_fe[2]['fecha'].": ".$var_alto_fe[2]['valor_variable']."%\n".
																	"Delta %Fe: ".$var_alto_fe['delta_fe'];
					}
				}
				if (($tipo_consulta ==	1 || $tipo_consulta == 4) && $tipo_variable == 1)
				{
					$sq_m22		=	"SELECT * FROM estatus_planta_acidez_celdas WHERE num_celda = '$res_m1[num_celda]' ORDER BY fecha DESC LIMIT 1";
					$query_m22	=	mig_query($sq_m22, $db);
					$res_m22	=	pg_fetch_array($query_m22);
					$titulo		=	$res_m22['fecha'];
				}
				if ($tipo_consulta ==	1 || $tipo_variable == 3)
				{
					$sq_m23		=	"SELECT * FROM estatus_planta_celdas_nivel_metal_critico WHERE num_celda = '$res_m1[num_celda]' ORDER BY fecha DESC LIMIT 1";
					$query_m23	=	mig_query($sq_m23, $db);
					$res_m23	=	pg_fetch_array($query_m23);
				}
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
					
					if ($cad_1 == 1)		$cad_1		=	"Al_1  ";	else	$cad_1	=	"";
					if ($cad_2 == 1)		$cad_2		=	"Al_2  ";	else	$cad_2	=	"";
					if ($cad_3 == 1)		$cad_3		=	"Al_3  ";	else	$cad_3	=	"";
					if ($cad_4 == 1)		$cad_4		=	"Al_4  ";	else	$cad_4	=	"";
					if ($cad_5 == 1)		$cad_5		=	"Al_5  ";	else	$cad_5	=	"";
					if ($cad_6 == 1)		$cad_6		=	" Fl ";	else	$cad_6	=	"";
					
					$res_m1['valor']	=	"$cad_1$cad_2$cad_3$cad_4$cad_5$cad_6";
				
				}
				echo "<tr ";
				if ($num_fila%2==0){ 
					echo "bgcolor = 00CABF"; } //si el resto de la división es 0 pongo un color 				  
				else {                  
					echo "bgcolor= 99DDFF"; } //si el resto de la división NO es 0 pongo otro color 
				echo ">"; ?> 
				<td style="text-align:center; font-family:arialn; font-size:12px; height:8px"><?=$res_m1['num_celda']?></td>
				<td style="text-align:center; font-family:arialn; font-size:12px; height:8px"><?php if ($tipo_variable == 13) echo $res_m1['valor']; else echo round($res_m1['valor'], 2)?></td>
				<td style="text-align:center; font-family:arialn; font-size:12px; height:8px" title="<?=$titulo?>">
				<?php 
					if ($tipo_variable == 8) echo $res_m21['edad']; 
					elseif (($tipo_consulta ==	1 || $tipo_consulta == 4) && $tipo_variable == 1) echo $res_m22['acidez'];
					elseif ($tipo_consulta == 1 && $tipo_variable == 3) echo $res_m23['programado'];
					else echo $res_m1['num_veces'];
				?></td>
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