<?php
include 'select_reporte_estatus_planta.php';
global $titulo_tabla_reduccion_dia;

?>
<script src="funciones_java.js"></script>
<page orientation="paysage">
		<!--- <link href="http://ve-828/scp/modules/estatus_planta/estilos2.css" rel="stylesheet" type="text/css" /> -->
		<link href="http://vem-1868/scp/modules/estatus_planta/estilos2.css" rel="stylesheet" type="text/css" />
		<link href="estilos2.css" rel="stylesheet" type="text/css" />
		<table style="width:100%" cellpadding="0" cellspacing="0">
			<tr style="height:50px">
				<td colspan="2">
					<div id="encabezado_reporte" style="height:50px; width:100%"><?=encabezado_reporte()?></div>
				</td>
			</tr>
			<tr style="height:150px">
				<td colspan="2">
					<div id="tabla_reduccion_1" style="height:150px; width:100%" title="<?=$titulo_tabla_reduccion_dia?>"><?=tabla_reduccion_dia()?></div>
				</td>
			</tr>
			<tr style="height:130px">
				<td colspan="2" style="width:100% ">
					<div id="tabla_reduccion_2" style="height:130px; overflow:auto; width:100%"><?=tabla_areas_turno()?></div>
				</td>
			</tr>
			<tr style="height:180px">
				<td style="width:58%; text-align:left ">
					<div id="tabla_reduccion_1" style="height:180px; overflow:auto; width:99%; text-align:left"><?=tabla_reduccion_turno()?></div>
				</td>
				<td style="width:42% ">
					<div id="tabla_reduccion_1" style="height:180px; overflow:auto; width:99%; text-align:right"><?=tabla_equipo_movil_materia_prima()?></div>
				</td>
			</tr>
			<tr style="height:250px">
				<td colspan="2" style="width:100% ">
					<div id="tabla_reduccion_1" style="height:300px; overflow:auto; width:100%"><?=tabla_observaciones()?></div>
				</td>
			</tr>
		</table>
		<?php
			if ($ocultar == 0)
			{
			?>
				<!--- <a style="text-align:center " href="http://ve-828/reportes_php5/estatus_planta/genera_reporte_estatus_planta.php?fecha_reporte=<?=$fecha_reporte?>&turno_reporte=<?=$turno_reporte?>&ocultar=1">Ver Para Imprimir</a> -->
				<a style="text-align:center " href="http://vem-1868/reportes_php5/estatus_planta/genera_reporte_estatus_planta.php?fecha_reporte=<?=$fecha_reporte?>&turno_reporte=<?=$turno_reporte?>&ocultar=1">Ver Para Imprimir</a>
				<?php
			}
			?>
		</page>

<?php

function encabezado_reporte()
{
	global $fecha_reporte, $semana_reporte, $turno_reporte;
	list($dia, $mes, $año)							=	split('/', $fecha_reporte);
	$mes_fecha										=	strftime("%m",mktime(0,0,0,$mes,$dia,$año));
	$año_fecha										=	strftime("%Y",mktime(0,0,0,$mes,$dia,$año));
	$titulo = "REPORTE IGPP";
	if ($semana_reporte >= 52 &&  $mes_fecha == 1)		$año_fecha	=	$año_fecha - 1;
	if ($semana_reporte <= 3  &&  $mes_fecha == 12)		$año_fecha	=	$año_fecha + 1;
	$rango 											=	RangoSemana($semana_reporte, $año_fecha) 
	?>
		<table style="width:100%" cellpadding="0" cellspacing="0">
			<tr>
				<td style="width:20%"><img src="http://control/scp/includes/reportes_pdf/CVG_Reporte.JPG"/></td>
				<td style="width:60%" align="center">
					<h5>INFORME GERENCIAL DE PRODUCCIÓN ÁREAS OPERATIVAS
						<br>
						Fecha: <?=$fecha_reporte?>  Turno: <?=$turno_reporte?>
						<br>
						Semana Nº <?=$semana_reporte?>: del <?=date('d/m/Y', $rango[0])?> al <?=date('d/m/Y', $rango[6])?>
					</h5>
				</td>
				<td style="width:20%" align="right"><img src="http://control/scp/includes/reportes_pdf/Venalum_Reporte.JPG" /></td>
			</tr>
		</table>
	<?php
}
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

function validar_color()
{
	echo "black";
}
function tabla_reduccion_dia()
{
	global $reduccion_diario, $reduccion_total_dia_turno, $acum_mes_reduccion, $acum_sem_reduccion, $acum_dia_reduccion, $fecha_reporte,
			$titulo_reduccion_dia_c1, $titulo_reduccion_dia_c3_1, $titulo_reduccion_dia_c3_2, $titulo_reduccion_dia_c4_1, $titulo_reduccion_dia_c4_2,
			$titulo_reduccion_dia_c5_1, $titulo_reduccion_dia_c5_2;
	list($dia, $mes, $año)	= split('/', $fecha_reporte);
	
	?>
		<table style="width:100%" cellpadding="0" cellspacing="0">
			<tr>
				<td style="width:100%" class="bordesLineaPrincipal" colspan="17">AREA DE REDUCCION </td>
			</tr>
			<tr>
				<td class="bordesLinea1Ancho1">ACUMULADOS</td>
				<td colspan="3" class="bordesLinea1">PRODUCCIÓN ALUMINIO NETO</td>
				<td colspan="4" class="bordesLinea1">CELDAS</td>
				<td class="bordesLinea1Ancho2">ANODOS</td>
				<td class="bordesLinea1Ancho2"># CELDAS</td>
				<td class="bordesLinea1Ancho2" title="<?=$titulo_reduccion_dia_c3?>"># CELDAS </td>
				<td class="bordesLinea1Ancho2" title="<?=$titulo_reduccion_dia_c4?>"># CELDAS </td>
				<td class="bordesLinea1Ancho2" title="<?=$titulo_reduccion_dia_c1?>"># CELDAS </td>
				<td class="bordesLinea1Ancho2"># CELDAS </td>
				<td class="bordesLinea1Ancho2"># CELDAS</td>
				<td class="bordesLinea1Ancho2UltimaColumna" colspan="2">PRESIÓN AIRE (BAR)</td>
			</tr>
			<tr>
				<td class="bordesLinea2Ancho1">LÍNEA</td>
				<td class="bordesLinea2Ancho2">PLAN</td>
				<td class="bordesLinea2Ancho2">REAL</td>
				<td class="bordesLinea2Ancho2">DIF R - P </td>
				<td class="bordesLinea2Ancho2">CON.</td>
				<td class="bordesLinea2Ancho2">PROD.</td>
				<td class="bordesLinea2Ancho2">INC.</td>
				<td class="bordesLinea2Ancho2">DESINC.</td>
				<td class="bordesLinea2Ancho2">SERVIDOS</td>
				<td class="bordesLinea2Ancho2">&gt; 1 EA/D </td>
				<td class="bordesLinea2Ancho2" title="<?=$titulo_reduccion_dia_c3_1?>">N.M.C.</td>
				<td class="bordesLinea2Ancho2">N.B.C.</td>
				<td class="bordesLinea2Ancho2" title="<?=$titulo_reduccion_dia_c1?>">TEMP.CRIT.</td>
				<td class="bordesLinea2Ancho2">DESV>0.15</td>
				<td class="bordesLinea2Ancho2">ALTO %Fe</td>
				<td class="bordesLinea2Ancho2">PRINC.</td>
				<td class="TreduccionAncho2UltimaColumna">FACILD18</td>
			</tr>
			<?php
			$n = 1;
			while ($n <= 6)
			{
				$titulo_reduccion_dia_c3 = "";
				$titulo_reduccion_dia_c4 = "";
				if ($n <= 4) 
				{
					$titulo_reduccion_dia_c3 = $titulo_reduccion_dia_c3_1;
					$titulo_reduccion_dia_c4 = $titulo_reduccion_dia_c4_1;
					$titulo_reduccion_dia_c5 = $titulo_reduccion_dia_c5_1;
				}
				if ($n == 5) 
				{
					$titulo_reduccion_dia_c3 = $titulo_reduccion_dia_c3_2;
					$titulo_reduccion_dia_c4 = $titulo_reduccion_dia_c4_2;
					$titulo_reduccion_dia_c5 = $titulo_reduccion_dia_c5_2;
				}
				?>
				<tr>
					<td class="TreduccionAncho2"><?=$n?></td>
					<td class="TreduccionAncho2" style="color:#0000FF"><?=valida_dato2($reduccion_diario[$n]['prod_neta_plan'])?></td>
					<td class="TreduccionAncho2"><?=valida_dato2($reduccion_diario[$n]['prod_neta_real'])?></td>
					<td class="TreduccionAncho2"><?=valida_dato2($reduccion_diario[$n]['diff_prod'])?></td>
					<td class="TreduccionAncho2"><?=valida_dato2($reduccion_diario[$n]['celdas_conect'])?></td>
					<td class="TreduccionAncho2"><?=valida_dato2($reduccion_diario[$n]['celdas_prod'])?></td>
					<td class="TreduccionAncho2" style="color:#0000FF"><?=valida_dato2($reduccion_diario[$n]['celdas_inc'])?></td>
					<td class="TreduccionAncho2"><?=valida_dato2($reduccion_diario[$n]['celdas_desinc'])?></td>
					<td class="TreduccionAncho2"><?=$reduccion_total_dia_turno[7][$n]?></td>
					<td class="TreduccionAncho2"><div style="width:100%" onDblClick='ventana_detalles_1(2, 1, <?=$dia?>, <?=$mes?>, <?=$año?> ,<?=$n?>, 0)'><?=$reduccion_total_dia_turno[2][$n]?></div></td>
					<td class="TreduccionAncho2"><div style="width:100%" onDblClick='ventana_detalles_1(3, 1, <?=$dia?>, <?=$mes?>, <?=$año?> ,<?=$n?>, 0)' title="<?=$titulo_reduccion_dia_c3?>"><?=$reduccion_total_dia_turno[3][$n]?></div></td>
					<td class="TreduccionAncho2"><div style="width:100%" onDblClick='ventana_detalles_1(4, 1, <?=$dia?>, <?=$mes?>, <?=$año?> ,<?=$n?>, 0)' title="<?=$titulo_reduccion_dia_c4?>"><?=$reduccion_total_dia_turno[4][$n]?></div></td>
					<td class="TreduccionAncho2"><div style="width:100%" onDblClick='ventana_detalles_1(1, 1, <?=$dia?>, <?=$mes?>, <?=$año?> ,<?=$n?>, 0)' title="<?=$titulo_reduccion_dia_c1?>"><?=$reduccion_total_dia_turno[1][$n]?></div></td>
					<td class="TreduccionAncho2"><div style="width:100%" onDblClick='ventana_detalles_1(5, 1, <?=$dia?>, <?=$mes?>, <?=$año?> ,<?=$n?>, 0)'><?=$reduccion_total_dia_turno[5][$n]?></div></td>
					<td class="TreduccionAncho2"><div style="width:100%" onDblClick='ventana_detalles_1(8, 1, <?=$dia?>, <?=$mes?>, <?=$año?> ,<?=$n?>, 0)' title="<?=$titulo_reduccion_dia_c5?>"><?=$reduccion_total_dia_turno[8][$n]?></div></td>
					<td class="TreduccionAncho2"><div style="width:100%; color:<?php if ($reduccion_total_dia_turno[6][$n] != "") {if ($reduccion_total_dia_turno[6][$n] < 6.8 && $reduccion_total_dia_turno[6][$n] >= 0) echo "red";}?>"><?=valida_dato2($reduccion_total_dia_turno[6][$n])?></div></td>
					<td class="TreduccionAncho2UltimaColumna"><div style="width:100%; color:<?php if ($reduccion_total_dia_turno[9][$n] != "") {if ($reduccion_total_dia_turno[9][$n] < 3.8 && $reduccion_total_dia_turno[9][$n] >= 0) echo "red";}?>"><?=valida_dato2($reduccion_total_dia_turno[9][$n])?></div></td>
				</tr>
				<?php
				$n++;
			}
			?>
			<tr>
				<td class="TreduccionAncho1FondoAmarillo">DÍA PLANTA </td>
				<td class="TreduccionAncho2FondoAmarillo"><?=valida_dato2($acum_dia_reduccion[0]['prod_neta_plan'])?></td>
				<td class="TreduccionAncho2FondoAmarillo"><?=valida_dato2($acum_dia_reduccion[0]['prod_neta_real'])?></td>
				<td class="TreduccionAncho2FondoAmarillo"><?=valida_dato2($acum_dia_reduccion[0]['diff_prod'])?></td>
				<td class="TreduccionAncho2FondoAmarillo"><?=valida_dato2($acum_dia_reduccion[0]['celdas_conect'])?></td>
				<td class="TreduccionAncho2FondoAmarillo"><?=valida_dato2($acum_dia_reduccion[0]['celdas_prod'])?></td>
				<td class="TreduccionAncho2FondoAmarillo"><?=valida_dato2($acum_dia_reduccion[0]['celdas_inc'])?></td>
				<td class="TreduccionAncho2FondoAmarillo"><?=valida_dato2($acum_dia_reduccion[0]['celdas_desinc'])?></td>
				<td class="TreduccionAncho2FondoAmarillo"><?=valida_dato2($acum_dia_reduccion[7])?></td>
				<td class="TreduccionAncho2FondoAmarillo"><div style="width:100%" onDblClick='ventana_detalles_1(2, 4, <?=$dia?>, <?=$mes?>, <?=$año?> , 0, 0)'><?=$acum_dia_reduccion[2]?></div></td>
				<td class="TreduccionAncho2FondoAmarillo"><div style="width:100%" onDblClick='ventana_detalles_1(3, 4, <?=$dia?>, <?=$mes?>, <?=$año?> , 0, 0)' title="<?=$titulo_reduccion_dia_c3_1?>"><?=$acum_dia_reduccion[3]?></div></td>
				<td class="TreduccionAncho2FondoAmarillo"><div style="width:100%" onDblClick='ventana_detalles_1(4, 4, <?=$dia?>, <?=$mes?>, <?=$año?> , 0, 0)'><?=$acum_dia_reduccion[4]?></div></td>
				<td class="TreduccionAncho2FondoAmarillo"><div style="width:100%" onDblClick='ventana_detalles_1(1, 4, <?=$dia?>, <?=$mes?>, <?=$año?> , 0, 0)' title="<?=$titulo_reduccion_dia_c1?>"><?=$acum_dia_reduccion[1]?></div></td>
				<td class="TreduccionAncho2FondoAmarillo"><div style="width:100%" onDblClick='ventana_detalles_1(5, 4, <?=$dia?>, <?=$mes?>, <?=$año?> , 0, 0)'><?=$acum_dia_reduccion[5]?></div></td>
				<td class="TreduccionAncho2FondoAmarillo"><div style="width:100%" onDblClick='ventana_detalles_1(8, 4, <?=$dia?>, <?=$mes?>, <?=$año?> , 0, 0)' title="<?=$titulo_reduccion_dia_c5?>"><?=$acum_dia_reduccion[8]?></div></td>
				<td class="TreduccionAncho2FondoAmarillo"><div style="width:100%; color:<?php if ($acum_dia_reduccion[6] != "") {if ($acum_dia_reduccion[6] < 6.8 && $acum_dia_reduccion[6] >= 0) echo "red";}?>"><?=valida_dato2($acum_dia_reduccion[6])?></div></td>
				<td class="TreduccionAncho2FondoAmarilloUltimaColumna"><div style="width:100%; color:<?php if ($acum_dia_reduccion[9] != "") {if ($acum_dia_reduccion[9] < 3.8 && $acum_dia_reduccion[9] >= 0) echo "red";}?>"><?=valida_dato2($acum_dia_reduccion[9])?></div></td>
			</tr>
			<tr>
				<td class="TreduccionAncho1FondoGris">SEM. PLANTA</td>
				<td class="TreduccionAncho2FondoGris"><?=valida_dato2($acum_sem_reduccion[0]['prod_neta_plan'])?></td>
				<td class="TreduccionAncho2FondoGris"><?=valida_dato2($acum_sem_reduccion[0]['prod_neta_real'])?></td>
				<td class="TreduccionAncho2FondoGris"><?=valida_dato2($acum_sem_reduccion[0]['diff_prod'])?></td>
				<td class="TreduccionAncho2FondoGris"><?=valida_dato2($acum_sem_reduccion[0]['celdas_conect'])?></td>
				<td class="TreduccionAncho2FondoGris"><?=valida_dato2($acum_sem_reduccion[0]['celdas_prod'])?></td>
				<td class="TreduccionAncho2FondoGris"><?=valida_dato2($acum_sem_reduccion[0]['celdas_inc'])?></td>
				<td class="TreduccionAncho2FondoGris"><?=valida_dato2($acum_sem_reduccion[0]['celdas_desinc'])?></td>
				<td class="TreduccionAncho2FondoGris"><?=valida_dato2($acum_sem_reduccion[7])?></td>
				<td class="TreduccionAncho2FondoGris"><div style="width:100%" onDblClick='ventana_detalles_1(2, 2, <?=$dia?>, <?=$mes?>, <?=$año?> , 0, 0)'><?=$acum_sem_reduccion[2]?></div></td>
				<td class="TreduccionAncho2FondoGris"><div style="width:100%" onDblClick='ventana_detalles_1(3, 2, <?=$dia?>, <?=$mes?>, <?=$año?> , 0, 0)' title="<?=$titulo_reduccion_dia_c3_1?>"><?=$acum_sem_reduccion[3]?></div></td>
				<td class="TreduccionAncho2FondoGris"><div style="width:100%" onDblClick='ventana_detalles_1(4, 2, <?=$dia?>, <?=$mes?>, <?=$año?> , 0, 0)'><?=$acum_sem_reduccion[4]?></div></td>
				<td class="TreduccionAncho2FondoGris"><div style="width:100%" onDblClick='ventana_detalles_1(1, 2, <?=$dia?>, <?=$mes?>, <?=$año?> , 0, 0)' title="<?=$titulo_reduccion_dia_c1?>"><?=$acum_sem_reduccion[1]?></div></td>
				<td class="TreduccionAncho2FondoGris"><div style="width:100%" onDblClick='ventana_detalles_1(5, 2, <?=$dia?>, <?=$mes?>, <?=$año?> , 0, 0)'><?=$acum_sem_reduccion[5]?></div></td>
				<td class="TreduccionAncho2FondoGris"><div style="width:100%" onDblClick='ventana_detalles_1(8, 2, <?=$dia?>, <?=$mes?>, <?=$año?> , 0, 0)' title="<?=$titulo_reduccion_dia_c5?>"><?=$acum_sem_reduccion[8]?></div></td>
				<td class="TreduccionAncho2FondoGris"><div style="width:100%; color:<?php if ($acum_sem_reduccion[6] != "") {if ($acum_sem_reduccion[6] < 6.8 && $acum_sem_reduccion[6] >= 0) echo "red";}?>"><?=valida_dato2($acum_sem_reduccion[6])?></div></td>
				<td class="TreduccionAncho2FondoGrisUltimaColumna"><div style="width:100%; color:<?php if ($acum_sem_reduccion[9] != "") {if ($acum_sem_reduccion[9] < 3.8 && $acum_sem_reduccion[9] >= 0) echo "red";}?>"><?=valida_dato2($acum_sem_reduccion[9])?></div></td>
			</tr>
			<tr>
				<td class="TreduccionAncho1FondoAzul">MES PLANTA</td>
				<td class="TreduccionAncho2FondoAzul"><?=valida_dato2($acum_mes_reduccion[0]['prod_neta_plan'])?></td>
				<td class="TreduccionAncho2FondoAzul"><?=valida_dato2($acum_mes_reduccion[0]['prod_neta_real'])?></td>
				<td class="TreduccionAncho2FondoAzul"><?=valida_dato2($acum_mes_reduccion[0]['diff_prod'])?></td>
				<td class="TreduccionAncho2FondoAzul"><?=valida_dato2($acum_mes_reduccion[0]['celdas_conect'])?></td>
				<td class="TreduccionAncho2FondoAzul"><?=valida_dato2($acum_mes_reduccion[0]['celdas_prod'])?></td>
				<td class="TreduccionAncho2FondoAzul"><?=valida_dato2($acum_mes_reduccion[0]['celdas_inc'])?></td>
				<td class="TreduccionAncho2FondoAzul"><?=valida_dato2($acum_mes_reduccion[0]['celdas_desinc'])?></td>
				<td class="TreduccionAncho2FondoAzul"><?=valida_dato2($acum_mes_reduccion[7])?></td>
				<td class="TreduccionAncho2FondoAzul"><div style="width:100%" onDblClick='ventana_detalles_1(2, 3, <?=$dia?>, <?=$mes?>, <?=$año?> , 0, 0)'><?=$acum_mes_reduccion[2]?></div></td>
				<td class="TreduccionAncho2FondoAzul"><div style="width:100%" onDblClick='ventana_detalles_1(3, 3, <?=$dia?>, <?=$mes?>, <?=$año?> , 0, 0)' title="<?=$titulo_reduccion_dia_c3_1?>"><?=$acum_mes_reduccion[3]?></div></td>
				<td class="TreduccionAncho2FondoAzul"><div style="width:100%" onDblClick='ventana_detalles_1(4, 3, <?=$dia?>, <?=$mes?>, <?=$año?> , 0, 0)'><?=$acum_mes_reduccion[4]?></div></td>
				<td class="TreduccionAncho2FondoAzul"><div style="width:100%" onDblClick='ventana_detalles_1(1, 3, <?=$dia?>, <?=$mes?>, <?=$año?> , 0, 0)' title="<?=$titulo_reduccion_dia_c1?>"><?=$acum_mes_reduccion[1]?></div></td>
				<td class="TreduccionAncho2FondoAzul"><div style="width:100%" onDblClick='ventana_detalles_1(5, 3, <?=$dia?>, <?=$mes?>, <?=$año?> , 0, 0)'><?=$acum_mes_reduccion[5]?></div></td>
				<td class="TreduccionAncho2FondoAzul"><div style="width:100%" onDblClick='ventana_detalles_1(8, 3, <?=$dia?>, <?=$mes?>, <?=$año?> , 0, 0)' title="<?=$titulo_reduccion_dia_c5?>"><?=$acum_mes_reduccion[8]?></div></td>
				<td class="TreduccionAncho2FondoAzul"><div style="width:100%; color:<?php if ($acum_mes_reduccion[6] != "") {if ($acum_mes_reduccion[6] < 6.8 && $acum_mes_reduccion[6] >= 0) echo "red";}?>"><?=valida_dato2($acum_mes_reduccion[6])?></div></td>
				<td class="TreduccionAncho2FondoAzulUltimaColumna"><div style="width:100%; color:<?php if ($acum_mes_reduccion[9] != "") {if ($acum_mes_reduccion[9] < 3.8 && $acum_mes_reduccion[9] >= 0) echo "red";}?>"><?=valida_dato2($acum_mes_reduccion[9])?></div></td>
			</tr>
		</table><div style="height:5px"></div>
	<?php
}
function tabla_areas_turno()
{
	global $carbon_diario, $carbon_turno, $acum_sem_carbon, $acum_mes_carbon, $colada_turno, $colada_diario, $acum_sem_colada, 
	$acum_mes_colada, $turno_reporte, $carbon_diario_2, $titulo_carbon_acum, $titulo_carbon_produc_ant1, $titulo_carbon_produc_ant2,
	$titulo_carbon_produc_ant3, $accidentes_turno, $titulo_accidentes_turno, $acum_sem_accidentes, $acum_mes_accidentes, $acum_dia_accidentes,$mat_recep, $carbon_turno_2,
	$carbon_diario_3, $acum_sem_carbon_2, $acum_mes_carbon_2;

	?>
	<table width="100%"  border="0" cellspacing="0" cellpadding="0">
		<tr>
			<td class="bordesLineaPrincipalOtrasAreasPrimeraLinea">&nbsp;</td>
			<td colspan="5" class="bordesLineaPrincipalOtrasAreas">AREA CARBÓN </td>
			<td class="bordesLineaPrincipalOtrasAreas">INF. ADICIONAL</td>
			<td colspan="3" class="bordesLineaPrincipalOtrasAreas">AREA COLADA </td>
		</tr>
		<tr>
			<td class="bordesLinea3">&nbsp;</td>
			<td colspan="3" class="bordesLinea1">PRODUCCION NETA ANODOS</td>
			<td colspan="2" class="bordesLinea1">INF. ESTACIONES DE BAÑO</td>
			<td class="bordesLinea1">&nbsp;</td>
			<td colspan="3" class="bordesLinea1">CRISOLES</td>
		</tr>
		<tr>
			<td class="bordesLinea4">&nbsp;</td>
			<td class="TrOtrasAreasAncho2">VERDES</td>
			<td class="TrOtrasAreasAncho2">COCIDOS</td>
			<td class="TrOtrasAreasAncho2">ENVARILLADOS</td>
			<td class="TrOtrasAreasAncho2">CABO ENVIADO </td>
			<td class="TrOtrasAreasAncho2">BAÑO ENVIADO</td>
			<td class="TrOtrasAreasAncho2">ACCIDENTES</td>
			<td class="TrOtrasAreasAncho2">RECIBIDOS</td>
			<td class="TrOtrasAreasAncho2">PROCESADOS</td>
			<td class="TrOtrasAreasAncho2UltimaColumna">TEMPERATURA</td>
		</tr>
		<tr>
			<td class="TrOtrasAreasAncho1">TURNO (T<?=$turno_reporte?>)</td>
			<td class="TrOtrasAreasAncho2" title="<?=$titulo_carbon_produc_ant1?>"><?=valida_dato2($carbon_turno['produc_anodo_verde'])?></td>
			<td class="TrOtrasAreasAncho2" title="<?=$titulo_carbon_produc_ant2?>"><?php if ($carbon_turno['produc_anodo_cocido'] >0) valida_dato2($carbon_turno['produc_anodo_cocido']); else echo "0";?></td>
			<td class="TrOtrasAreasAncho2" title="<?=$titulo_carbon_produc_ant3?>"><?=valida_dato2($carbon_turno['produc_anodo_envarillado'])?></td>
			<td class="TrOtrasAreasAncho2" title="Complejo 1 / Complejo 2"><?=valida_dato2($carbon_turno_2[0][0])?> / <?=valida_dato2($carbon_turno_2[0][1])?></td>
			<td class="TrOtrasAreasAncho2" title="Complejo 1 / Complejo 2"><?=valida_dato2($carbon_turno_2[1][0])?> / <?=valida_dato2($carbon_turno_2[1][1])?></td>
			<td class="TrOtrasAreasAncho2"><?=valida_dato2($accidentes_turno['num_accidente'])?></td>
			<td class="TrOtrasAreasAncho2"><?=valida_dato2($colada_turno['num_crisoles_recibidos'])?></td>
			<td class="TrOtrasAreasAncho2" title="Falta: <?=$mat_recep['faltante_descargar']?>TM"><?=valida_dato2($colada_turno['num_crisoles_procesados'])?></td>
			<td class="TrOtrasAreasAncho2UltimaColumna" title="<?=$titulo_accidentes_turno?>"><?=valida_dato2($colada_turno['temperatura_crisoles_recibidos']);?></td>
		</tr>
		<tr>
			<td class="TreduccionAncho1FondoAmarillo">ACUM. DÍA </td>
			<td class="TrOtrasAreasAncho2FondoAmarillo"><?=valida_dato2($carbon_diario_2['produc_anodo_verde'])?></td>
			<td class="TrOtrasAreasAncho2FondoAmarillo"><?php if ($carbon_diario_2['produc_anodo_cocido'] > 0) valida_dato2($carbon_diario_2['produc_anodo_cocido']); else echo "0";?></td>
			<td class="TrOtrasAreasAncho2FondoAmarillo"><?=valida_dato2($carbon_diario_2['produc_anodo_envarillado'])?></td>
			<td class="TrOtrasAreasAncho2FondoAmarillo" title="Complejo 1 / Complejo 2"><?=valida_dato2($carbon_diario_3[17][1])?> / <?=valida_dato2($carbon_diario_3[17][2])?></td>
			<td class="TrOtrasAreasAncho2FondoAmarillo" title="Complejo 1 / Complejo 2"><?=valida_dato2($carbon_diario_3[19][1])?> / <?=valida_dato2($carbon_diario_3[19][2])?></td>
			<td class="TrOtrasAreasAncho2FondoAmarillo"><?=valida_dato2($acum_dia_accidentes['num_accidente'])?></td>
			<td class="TrOtrasAreasAncho2FondoAmarillo"><?=valida_dato2($colada_diario['num_crisoles_recibidos'])?></td>
			<td class="TrOtrasAreasAncho2FondoAmarillo"><?=valida_dato2($colada_diario['num_crisoles_procesados'])?></td>
			<td class="TrOtrasAreasAncho2FondoAmarilloUltimaColumna"><?=valida_dato2($colada_diario['temperatura_crisoles_recibidos']);?></td>
		</tr>
		<tr>
			<td class="TreduccionAncho1FondoGris">ACUM. SEM.</td>
			<td class="TrOtrasAreasAncho2FondoGris" title="<?=$titulo_carbon_acum?>"><?=valida_dato2($acum_sem_carbon['produc_anodo_verde'])?></td>
			<td class="TrOtrasAreasAncho2FondoGris" title="<?=$titulo_carbon_acum?>"><?=valida_dato2($acum_sem_carbon['produc_anodo_cocido'])?></td>
			<td class="TrOtrasAreasAncho2FondoGris" title="<?=$titulo_carbon_acum?>"><?=valida_dato2($acum_sem_carbon['produc_anodo_envarillado'])?></td>
			<td class="TrOtrasAreasAncho2FondoGris" title="Complejo 1 / Complejo 2"><?=valida_dato2($acum_sem_carbon_2[17][1])?> / <?=valida_dato2($acum_sem_carbon_2[17][2])?></td>
			<td class="TrOtrasAreasAncho2FondoGris" title="Complejo 1 / Complejo 2"><?=valida_dato2($acum_sem_carbon_2[19][1])?> / <?=valida_dato2($acum_sem_carbon_2[19][2])?></td>
			<td class="TrOtrasAreasAncho2FondoGris"><?=valida_dato2($acum_sem_accidentes['num_accidente'])?></td>
			<td class="TrOtrasAreasAncho2FondoGris"><?=valida_dato2($acum_sem_colada['num_crisoles_recibidos'])?></td>
			<td class="TrOtrasAreasAncho2FondoGris"><?=valida_dato2($acum_sem_colada['num_crisoles_procesados'])?></td>
			<td class="TrOtrasAreasAncho2FondoGrisUltimaColumna"><?=valida_dato2($acum_sem_colada['temperatura_crisoles_recibidos']);?></td>
	  </tr>
		<tr>
			<td class="TreduccionAncho1FondoAzul">ACUM. MES </td>
			<td class="TrOtrasAreasAncho2FondoAzul" title="<?=$titulo_carbon_acum?>"><?=valida_dato2($acum_mes_carbon['produc_anodo_verde'])?></td>
			<td class="TrOtrasAreasAncho2FondoAzul" title="<?=$titulo_carbon_acum?>"><?=valida_dato2($acum_mes_carbon['produc_anodo_cocido'])?></td>
			<td class="TrOtrasAreasAncho2FondoAzul" title="<?=$titulo_carbon_acum?>"><?=valida_dato2($acum_mes_carbon['produc_anodo_envarillado'])?></td>
			<td class="TrOtrasAreasAncho2FondoAzul" title="Complejo 1 / Complejo 2"><?=valida_dato2($acum_mes_carbon_2[17][1])?> / <?=valida_dato2($acum_mes_carbon_2[17][2])?></td>
			<td class="TrOtrasAreasAncho2FondoAzul" title="Complejo 1 / Complejo 2"><?=valida_dato2($acum_mes_carbon_2[19][1])?> / <?=valida_dato2($acum_mes_carbon_2[19][2])?></td>
			<td class="TrOtrasAreasAncho2FondoAzul"><?=valida_dato2($acum_mes_accidentes['num_accidente'])?></td>
			<td class="TrOtrasAreasAncho2FondoAzul"><?=valida_dato2($acum_mes_colada['num_crisoles_recibidos'])?></td>
			<td class="TrOtrasAreasAncho2FondoAzul"><?=valida_dato2($acum_mes_colada['num_crisoles_procesados'])?></td>
			<td class="TrOtrasAreasAncho2FondoAzulUltimaColumna"><?=valida_dato2($acum_mes_colada['temperatura_crisoles_recibidos']);?></td>
		</tr>
		<tr>
			<td class="TrOtrasAreasAncho1">INVENTARIO</td>
			<td class="TrOtrasAreasAncho2" title="<?=$titulo_carbon_acum?>"><?=valida_dato2($carbon_diario['inventario_anodo_verde'])?></td>
			<td class="TrOtrasAreasAncho2" title="<?=$titulo_carbon_acum?>"><?=valida_dato2($carbon_diario['inventario_anodo_cocido'])?></td>
			<td class="TrOtrasAreasAncho2" title="<?=$titulo_carbon_acum?>"><?=valida_dato2($carbon_diario['inventario_anodo_envarillado'])?></td>
			<td class="bordesLinea3">&nbsp;</td>
			<td class="TrOtrasAreasNoBordes">&nbsp;</td>
			<td class="TrOtrasAreasNoBordes">&nbsp;</td>
			<td class="TrOtrasAreasNoBordes">&nbsp;</td>
			<td class="TrOtrasAreasNoBordes">&nbsp;</td>
			<td class="TrOtrasAreasNoBordes">&nbsp;</td>
		</tr>
	</table>
	<?php
}
function tabla_reduccion_turno()
{
	$n			=	1;
	global $reduccion_turno, $fecha_reporte, $turno_reporte, $res_observ_4, $cantidad_celdas;
	list($dia, $mes, $año)	= split('/', $fecha_reporte);
	?>
	<table style="width:100%; text-align:left	" border="0" cellspacing="0" cellpadding="0">
		<tr>
			<td colspan="11" class="bordesLineaPrincipal">AREA REDUCCIÓN TURNO (T<?=$turno_reporte?>)</td>
		</tr>
		<tr>
			<td class="bordesLinea1">&nbsp;</td>
			<td style="font-size:8px" class="bordesLinea1"># CELDAS</td>
			<td style="font-size:8px" class="bordesLinea1"># CELDAS</td>
			<td style="font-size:8px" class="bordesLinea1"># CELDAS</td>
			<td style="font-size:8px" class="bordesLinea1">ANODOS</td>
			<td style="font-size:8px" class="bordesLinea1">CRISOLES</td>
			<td style="font-size:8px" class="bordesLinea1" colspan="2">PRESIÓN AIRE (BAR)</td>
			<td style="font-size:8px" class="bordesLinea1"># CELDAS</td>
			<td style="font-size:8px" class="bordesLinea1"># CELDAS</td>
			<td style="font-size:8px" class="bordesLinea1Ancho2UltimaColumna"># CELDAS</td>
		</tr>
		<tr>
			<td style="font-size:8px" class="TrOtrasAreasAncho1">LINEA</td>
			<td style="font-size:8px" class="TrReduccionTurnoAreasAncho2">MAS DE 1 EA </td>
			<td style="font-size:8px" class="TrReduccionTurnoAreasAncho2">DESV. > 0.15</td>
			<td style="font-size:8px" class="TrReduccionTurnoAreasAncho2">FALLA TOLVAS </td>
			<td style="font-size:8px" class="TrReduccionTurnoAreasAncho2">SERVIDOS</td>
			<td style="font-size:8px" class="TrReduccionTurnoAreasAncho2">ASIGNADOS</td>
			<td style="font-size:8px" class="TrReduccionTurnoAreasAncho2">PRINC.</td>
			<td style="font-size:8px" class="TrReduccionTurnoAreasAncho2">FACILID18</td>
			<td style="font-size:8px" class="TrReduccionTurnoAreasAncho2">CASC.ROJO</td>
			<td style="font-size:8px" class="TrReduccionTurnoAreasAncho2">DERRAM Fl</td>
			<td style="font-size:8px" class="TrReduccioTrunosAncho2UltimaColumna">DERRAM Al</td>
		</tr>
		<?php
			while ($n <= 5)
			{
			?>
				<tr>
					<td class="TrOtrasAreasAncho1"><?=$n?></td>
					<td class="TrReduccionTurnoAreasAncho2"><div style="width:100%" onDblClick='ventana_detalles_1(2, 5, <?=$dia?>, <?=$mes?>, <?=$año?>, <?=$n?>, <?=$turno_reporte?>)'><?=$reduccion_turno[3][$n]?></div></td>
					<td class="TrReduccionTurnoAreasAncho2"><div style="width:100%" onDblClick='ventana_detalles_1(5, 5, <?=$dia?>, <?=$mes?>, <?=$año?>, <?=$n?>, <?=$turno_reporte?>)'><?=$reduccion_turno[4][$n]?></div></td>
					<td class="TrReduccionTurnoAreasAncho2"><div style="width:100%" onDblClick='ventana_detalles_1(13, 5, <?=$dia?>, <?=$mes?>, <?=$año?>, <?=$n?>, <?=$turno_reporte?>)'><?=$reduccion_turno[7][$n]?></div></td>
					<td class="TrReduccionTurnoAreasAncho2"><div style="width:100%"><?=$reduccion_turno[2][$n]?></div></td>
					<td class="TrReduccionTurnoAreasAncho2"><div style="width:100%" onDblClick='ventana_detalles_4(11, 5, <?=$dia?>, <?=$mes?>, <?=$año?>, <?=$n?>, <?=$turno_reporte?>)'><?=$reduccion_turno[6][$n]?></div></td>
					<td class="TrReduccionTurnoAreasAncho2"><div style="width:100%; color:<?php if ($reduccion_turno[1][$n] != "") {if ($reduccion_turno[1][$n] < 6.8 && $reduccion_turno[1][$n] >= 0) echo "red";}?>"><?=valida_dato2($reduccion_turno[1][$n])?></div></td>
					<td class="TrReduccionTurnoAreasAncho2"><div style="width:100%; color:<?php if ($reduccion_turno[5][$n] != "") {if ($reduccion_turno[5][$n] < 3.8 && $reduccion_turno[5][$n] >= 0) echo "red";}?>"><?=valida_dato2($reduccion_turno[5][$n])?></div></td>
					<td class="TrReduccionTurnoAreasAncho2"><div style="width:100%" onDblClick='ventana_detalles_5(1, <?=$dia?>, <?=$mes?>, <?=$año?>, <?=$n?>, <?=$turno_reporte?>)'><?=$cantidad_celdas[1][$n]?></div></td>
					<td class="TrReduccionTurnoAreasAncho2"><div style="width:100%" onDblClick='ventana_detalles_5(2, <?=$dia?>, <?=$mes?>, <?=$año?>, <?=$n?>, <?=$turno_reporte?>)'><?=$cantidad_celdas[2][$n]?></div></td>
					<td class="TrReduccioTrunosAncho2UltimaColumna"><div style="width:100%" onDblClick='ventana_detalles_5(3, <?=$dia?>, <?=$mes?>, <?=$año?>, <?=$n?>, <?=$turno_reporte?>)'><?=$cantidad_celdas[3][$n]?></div></td>
				</tr>
			<?php
				$n++;
			}
			?>
	</table>
	
	<?php
}

function tabla_equipo_movil_materia_prima()
{
	global $equipo_movil_turno, $materias_primas, $dias_consumo, $turno_reporte, $fecha_reporte;
	list($dia, $mes, $año)	= split('/', $fecha_reporte);
	?>
		<table style="width:100%" border="0" cellspacing="0" cellpadding="0">
			<tr>
				<td style="width:100%">
					<table style="width:100%" border="0" cellspacing="0" cellpadding="0">
						<tr>
							<td colspan="7" class="bordesLineaPrincipal">EQUIPOS MOVILES EN PLANTA</td>
						</tr>
						<tr>
							<td class="TrOtrasAreasAncho1_2">&nbsp;</td>
							<td style="font-size:8px" class="TrEquipoMovilTurnoAreasAncho2"><div style="width:100%" onDblClick="ventana_detalles_2(1, 1, <?=$dia?>, <?=$mes?>, <?=$año?>, <?=$turno_reporte?>)">MONTACARGA</div></td>
							<td style="font-size:8px" class="TrEquipoMovilTurnoAreasAncho2"><div style="width:100%" onDblClick="ventana_detalles_2(2, 1, <?=$dia?>, <?=$mes?>, <?=$año?>, <?=$turno_reporte?>)">REMOLCADOR</div></td>
							<td style="font-size:8px" class="TrEquipoMovilTurnoAreasAncho2"><div style="width:100%" onDblClick="ventana_detalles_2(3, 1, <?=$dia?>, <?=$mes?>, <?=$año?>, <?=$turno_reporte?>)">SKYDER</div></td>
							<td style="font-size:8px" class="TrEquipoMovilTurnoAreasAncho2"><div style="width:100%" onDblClick="ventana_detalles_2(4, 1, <?=$dia?>, <?=$mes?>, <?=$año?>, <?=$turno_reporte?>)">PAYLOADER</div></td>
							<td style="font-size:8px" class="TrEquipoMovilTurnoAreasAncho2"><div style="width:100%" onDblClick="ventana_detalles_2(5, 1, <?=$dia?>, <?=$mes?>, <?=$año?>, <?=$turno_reporte?>)">CAMIÓN</div></td>
							<td style="font-size:8px" class="TrEquipoMovilAncho2UltimaColumna"><div style="width:90%" onDblClick="ventana_detalles_2(6, 1, <?=$dia?>, <?=$mes?>, <?=$año?>, <?=$turno_reporte?>)">TRACTOR&nbsp;</div></td>
						</tr>
						<tr>
							<td style="font-size:8px" class="TrOtrasAreasAncho1_2">ESTANDAR</td>
							<td class="TrEquipoMovilTurnoAreasAncho2"><div style="width:100%" onDblClick="ventana_detalles_2(1, 1, <?=$dia?>, <?=$mes?>, <?=$año?>, <?=$turno_reporte?>)"><?=$equipo_movil_turno[1]['estandar']?></div></td>
							<td class="TrEquipoMovilTurnoAreasAncho2"><div style="width:100%" onDblClick="ventana_detalles_2(2, 1, <?=$dia?>, <?=$mes?>, <?=$año?>, <?=$turno_reporte?>)"><?=$equipo_movil_turno[2]['estandar']?></div></td>
							<td class="TrEquipoMovilTurnoAreasAncho2"><div style="width:100%" onDblClick="ventana_detalles_2(3, 1, <?=$dia?>, <?=$mes?>, <?=$año?>, <?=$turno_reporte?>)"><?=$equipo_movil_turno[3]['estandar']?></div></td>
							<td class="TrEquipoMovilTurnoAreasAncho2"><div style="width:100%" onDblClick="ventana_detalles_2(4, 1, <?=$dia?>, <?=$mes?>, <?=$año?>, <?=$turno_reporte?>)"><?=$equipo_movil_turno[4]['estandar']?></div></td>
							<td class="TrEquipoMovilTurnoAreasAncho2"><div style="width:100%" onDblClick="ventana_detalles_2(5, 1, <?=$dia?>, <?=$mes?>, <?=$año?>, <?=$turno_reporte?>)"><?=$equipo_movil_turno[5]['estandar']?></div></td>
							<td class="TrEquipoMovilAncho2UltimaColumna"><div style="width:90%" onDblClick="ventana_detalles_2(6, 1, <?=$dia?>, <?=$mes?>, <?=$año?>, <?=$turno_reporte?>)"><?=$equipo_movil_turno[6]['estandar']?></div></td>
						</tr>
						<tr>
							<td style="font-size:8px" class="TrOtrasAreasAncho1_2">OPERATIVO</td>
							<td class="TrEquipoMovilTurnoAreasAncho2"><div style="width:100%" onDblClick="ventana_detalles_2(1, 1, <?=$dia?>, <?=$mes?>, <?=$año?>, <?=$turno_reporte?>)"><?=$equipo_movil_turno[1]['operativo']?></div></td>
							<td class="TrEquipoMovilTurnoAreasAncho2"><div style="width:100%" onDblClick="ventana_detalles_2(2, 1, <?=$dia?>, <?=$mes?>, <?=$año?>, <?=$turno_reporte?>)"><?=$equipo_movil_turno[2]['operativo']?></div></td>
							<td class="TrEquipoMovilTurnoAreasAncho2"><div style="width:100%" onDblClick="ventana_detalles_2(3, 1, <?=$dia?>, <?=$mes?>, <?=$año?>, <?=$turno_reporte?>)"><?=$equipo_movil_turno[3]['operativo']?></div></td>
							<td class="TrEquipoMovilTurnoAreasAncho2"><div style="width:100%" onDblClick="ventana_detalles_2(4, 1, <?=$dia?>, <?=$mes?>, <?=$año?>, <?=$turno_reporte?>)"><?=$equipo_movil_turno[4]['operativo']?></div></td>
							<td class="TrEquipoMovilTurnoAreasAncho2"><div style="width:100%" onDblClick="ventana_detalles_2(5, 1, <?=$dia?>, <?=$mes?>, <?=$año?>, <?=$turno_reporte?>)"><?=$equipo_movil_turno[5]['operativo']?></div></td>
							<td class="TrEquipoMovilAncho2UltimaColumna"><div style="width:90%" onDblClick="ventana_detalles_2(6, 1, <?=$dia?>, <?=$mes?>, <?=$año?>, <?=$turno_reporte?>)"><?=$equipo_movil_turno[6]['operativo']?></div></td>
						</tr>
						<tr>
							<td class="TrOtrasAreasAncho1_2">&nbsp;</td>
							<td style="font-size:8px" class="TrEquipoMovilTurnoAreasAncho2"><div style="width:100%" onDblClick="ventana_detalles_2(7, 1, <?=$dia?>, <?=$mes?>, <?=$año?>, <?=$turno_reporte?>)">CISTERNA</div></td>
							<td style="font-size:8px" class="TrEquipoMovilTurnoAreasAncho2"><div style="width:100%" onDblClick="ventana_detalles_2(8, 1, <?=$dia?>, <?=$mes?>, <?=$año?>, <?=$turno_reporte?>)">COMPRESOR</div></td>
							<td style="font-size:8px" class="TrEquipoMovilTurnoAreasAncho2"><div style="width:100%" onDblClick="ventana_detalles_2(9, 1, <?=$dia?>, <?=$mes?>, <?=$año?>, <?=$turno_reporte?>)">MONT.(R)</div></td>
							<td style="font-size:8px" class="TrEquipoMovilTurnoAreasAncho2"><div style="width:100%" onDblClick="ventana_detalles_2(10, 1, <?=$dia?>, <?=$mes?>, <?=$año?>, <?=$turno_reporte?>)">PLATAFORMA</div></td>
							<td style="font-size:8px" class="TrEquipoMovilTurnoAreasAncho2"><div style="width:100%" onDblClick="ventana_detalles_2(11, 1, <?=$dia?>, <?=$mes?>, <?=$año?>, <?=$turno_reporte?>)">EXCAVADORA</div></td>
							<td style="font-size:8px" class="TrEquipoMovilAncho2UltimaColumna">&nbsp;</td>
						</tr>
						<tr>
							<td style="font-size:8px" class="TrOtrasAreasAncho1_2">ESTANDAR</td>
							<td class="TrEquipoMovilTurnoAreasAncho2"><div style="width:100%" onDblClick="ventana_detalles_2(7, 1, <?=$dia?>, <?=$mes?>, <?=$año?>, <?=$turno_reporte?>)"><?=$equipo_movil_turno[7]['estandar']?></div></td>
							<td class="TrEquipoMovilTurnoAreasAncho2"><div style="width:100%" onDblClick="ventana_detalles_2(8, 1, <?=$dia?>, <?=$mes?>, <?=$año?>, <?=$turno_reporte?>)"><?=$equipo_movil_turno[8]['estandar']?></div></td>
							<td class="TrEquipoMovilTurnoAreasAncho2"><div style="width:100%" onDblClick="ventana_detalles_2(9, 1, <?=$dia?>, <?=$mes?>, <?=$año?>, <?=$turno_reporte?>)"><?=$equipo_movil_turno[9]['estandar']?></div></td>
							<td class="TrEquipoMovilTurnoAreasAncho2"><div style="width:100%" onDblClick="ventana_detalles_2(10, 1, <?=$dia?>, <?=$mes?>, <?=$año?>, <?=$turno_reporte?>)"><?=$equipo_movil_turno[10]['estandar']?></div></td>
							<td class="TrEquipoMovilTurnoAreasAncho2"><div style="width:100%" onDblClick="ventana_detalles_2(11, 1, <?=$dia?>, <?=$mes?>, <?=$año?>, <?=$turno_reporte?>)"><?=$equipo_movil_turno[11]['estandar']?></div></td>
							<td class="TrEquipoMovilAncho2UltimaColumna">&nbsp;</td>
						</tr>
						<tr>
							<td style="font-size:8px" class="TrOtrasAreasAncho1_2">OPERATIVO</td>
							<td class="TrEquipoMovilTurnoAreasAncho2"><div style="width:100%" onDblClick="ventana_detalles_2(7, 1, <?=$dia?>, <?=$mes?>, <?=$año?>, <?=$turno_reporte?>)"><?=$equipo_movil_turno[7]['operativo']?></div></td>
							<td class="TrEquipoMovilTurnoAreasAncho2"><div style="width:100%" onDblClick="ventana_detalles_2(8, 1, <?=$dia?>, <?=$mes?>, <?=$año?>, <?=$turno_reporte?>)"><?=$equipo_movil_turno[8]['operativo']?></div></td>
							<td class="TrEquipoMovilTurnoAreasAncho2"><div style="width:100%" onDblClick="ventana_detalles_2(9, 1, <?=$dia?>, <?=$mes?>, <?=$año?>, <?=$turno_reporte?>)"><?=$equipo_movil_turno[9]['operativo']?></div></td>
							<td class="TrEquipoMovilTurnoAreasAncho2"><div style="width:100%" onDblClick="ventana_detalles_2(10, 1, <?=$dia?>, <?=$mes?>, <?=$año?>, <?=$turno_reporte?>)"><?=$equipo_movil_turno[10]['operativo']?></div></td>
							<td class="TrEquipoMovilTurnoAreasAncho2"><div style="width:100%" onDblClick="ventana_detalles_2(11, 1, <?=$dia?>, <?=$mes?>, <?=$año?>, <?=$turno_reporte?>)"><?=$equipo_movil_turno[11]['operativo']?></div></td>
							<td class="TrEquipoMovilAncho2UltimaColumna">&nbsp;</td>
						</tr>
					</table><br/>
				</td>
			</tr>
			<tr>
				<td style="width:100%">
					<table style="width:100%" border="0" cellspacing="0" cellpadding="0">
						<tr>
							<td colspan="8" class="bordesLineaPrincipal">INVENTARIO DE MATERIAS PRIMAS EN PLANTA </td>
						</tr>
						<tr>
							<td class="bordesLinea1">&nbsp;</td>
							<td style="font-size:8px" class="bordesLinea1">ALUMINIA</td>
							<td style="font-size:8px" class="bordesLinea1">CRIOLITA</td>
							<td style="font-size:8px" class="bordesLinea1">FLORURO</td>
							<td style="font-size:8px" class="bordesLinea1">COQUE</td>
							<td style="font-size:8px" class="bordesLinea1">COQUE</td>
							<td style="font-size:8px" class="bordesLinea1">ALQUITRAN</td>
							<td style="font-size:8px" class="bordesLinea1Ancho2UltimaColumna">ARRABIO</td>
						</tr>
						<tr>
							<td class="TrOtrasAreasAncho1_2">&nbsp;</td>
							<td style="font-size:8px" class="TrMateriaPrimaTurnoAreasAncho2">FRESCA</td>
							<td class="TrMateriaPrimaTurnoAreasAncho2">&nbsp;</td>
							<td style="font-size:8px" class="TrMateriaPrimaTurnoAreasAncho2"> ALUMINIO </td>
							<td style="font-size:8px" class="TrMateriaPrimaTurnoAreasAncho2">METALUR.</td>
							<td style="font-size:8px" class="TrMateriaPrimaTurnoAreasAncho2"> PETROLEO </td>
							<td class="TrMateriaPrimaTurnoAreasAncho2">&nbsp;</td>
							<td class="TrMateriaPrimaAncho2UltimaColumna">&nbsp;</td>
						</tr>
						<tr>
							<td style="font-size:8px" class="TrOtrasAreasAncho1_2">INVENTARIO</td>
							<td class="TrMateriaPrimaTurnoAreasAncho2"><?=$materias_primas[1]?></td>
							<td class="TrMateriaPrimaTurnoAreasAncho2" onDblClick="ventana_detalles_3(2)"><?=$materias_primas[2]?></td>
							<td class="TrMateriaPrimaTurnoAreasAncho2" onDblClick="ventana_detalles_3(3)"><?=$materias_primas[3]?></td>
							<td class="TrMateriaPrimaTurnoAreasAncho2" onDblClick="ventana_detalles_3(4)"><?=$materias_primas[4]?></td>
							<td class="TrMateriaPrimaTurnoAreasAncho2" onDblClick="ventana_detalles_3(5)"><?=$materias_primas[5]?></td>
							<td class="TrMateriaPrimaTurnoAreasAncho2" onDblClick="ventana_detalles_3(6)"><?=$materias_primas[6]?></td>
							<td class="TrMateriaPrimaAncho2UltimaColumna" onDblClick="ventana_detalles_3(7)"><?=$materias_primas[7]?></td>
						</tr>
						<tr>
							<td style="font-size:8px" class="TrOtrasAreasAncho1_2">D. CONSUM</td>
							<td class="TrMateriaPrimaTurnoAreasAncho2"><?=$dias_consumo[1]?></td>
							<td class="TrMateriaPrimaTurnoAreasAncho2" onDblClick="ventana_detalles_3(2)"><?=$dias_consumo[2]?></td>
							<td class="TrMateriaPrimaTurnoAreasAncho2" onDblClick="ventana_detalles_3(3)"><?=$dias_consumo[3]?></td>
							<td class="TrMateriaPrimaTurnoAreasAncho2" onDblClick="ventana_detalles_3(4)"><?=$dias_consumo[4]?></td>
							<td class="TrMateriaPrimaTurnoAreasAncho2" onDblClick="ventana_detalles_3(5)"><?=$dias_consumo[5]?></td>
							<td class="TrMateriaPrimaTurnoAreasAncho2" onDblClick="ventana_detalles_3(6)"><?=$dias_consumo[6]?></td>
							<td class="TrMateriaPrimaAncho2UltimaColumna" onDblClick="ventana_detalles_3(7)"><?=$dias_consumo[7]?></td>
						</tr>
					</table>
				</td>
			</tr>
		</table>
	<?php
}
function tabla_observaciones()
{
	global $cadena_observ_1, $cadena_observ_2, $cadena_observ_3, $observ_redu_sup_1, $observ_redu_sup_2, $observ_redu_sup_3, $observ_redu_sup_4, $observ_redu_sup_5,
			$observ_carb_sup_1, $observ_carb_sup_2, $observ_carb_sup_3, $observ_carb_sup_4, $observ_carb_sup_5, $observ_col_sup_1, $observ_col_sup_2, $observ_col_sup_3, $observ_col_sup_4,
			$observ_scp_sup_1;
	
	?>
	<table style="width:100% " cellpadding="0" cellspacing="0">
		<tr>
			<td style="width:100% ">
				<table style="width:100% " cellpadding="0" cellspacing="0" border="0">
					<tr>
						<td colspan="2" class="bordesLineaPrincipal">OBSERVACIONES REDUCCION</td>
					</tr>
					<tr>
						<td class="TrOtrasObservAncho1">Observación L1</td>
						<td class="TrObservAncho2UltimaColumna"><?=$observ_redu_sup_1?></td>
					</tr>
					<tr>
						<td class="TrOtrasObservAncho1">Observación L2</td>
						<td class="TrObservAncho2UltimaColumna"><?=$observ_redu_sup_2?></td>
					</tr>
					<tr>
						<td class="TrOtrasObservAncho1">Observación L3</td>
						<td class="TrObservAncho2UltimaColumna"><?=$observ_redu_sup_3?></td>
					</tr>
					<tr>
						<td class="TrOtrasObservAncho1">Observación L4</td>
						<td class="TrObservAncho2UltimaColumna"><?=$observ_redu_sup_4?></td>
					</tr>
					<tr>
						<td class="TrOtrasObservAncho1">Observación L5</td>
						<td class="TrObservAncho2UltimaColumna"><?=$observ_redu_sup_5?></td>
					</tr>
				</table>
			</td>
		</tr>
		<tr>
			<td style="width:100%; vertical-align:top ">
				<table style="width:100% " cellpadding="0" cellspacing="0" border="0">
					<tr>
						<td colspan="2" class="bordesLineaPrincipal">OBSERVACIONES CARBON </td>
					</tr>
					<tr>
						<td class="TrOtrasObservAncho1">Molienda</td>
						<td class="TrObservAncho2UltimaColumna"><?=$observ_carb_sup_1?></td>
					</tr>
					<tr>
						<td class="TrOtrasObservAncho1">Hornos</td>
						<td class="TrObservAncho2UltimaColumna"><?=$observ_carb_sup_2?></td>
					</tr>
					<tr>
						<td class="TrOtrasObservAncho1">Envarillado</td>
						<td class="TrObservAncho2UltimaColumna"><?=$observ_carb_sup_3?></td>
					</tr>
					<tr>
						<td class="TrOtrasObservAncho1">Estación de Baño 1</td>
						<td class="TrObservAncho2UltimaColumna"><?=$observ_carb_sup_4?></td>
					</tr>
					<tr>
						<td class="TrOtrasObservAncho1">Estación de Baño 2</td>
						<td class="TrObservAncho2UltimaColumna"><?=$observ_carb_sup_5?></td>
					</tr>
				</table>
			</td>
		</tr>
		<tr>
			<td style="width:100%; vertical-align:top  " >
				<table style="width:100% " cellpadding="0" cellspacing="0" border="0">
					<tr>
						<td colspan="2" class="bordesLineaPrincipal">OBSERVACIONES COLADA </td>
					</tr>
					<tr>
						<td class="TrOtrasObservAncho1">DPM</td>
						<td class="TrObservAncho2UltimaColumna"><?=$observ_col_sup_1?></td>
					</tr>
					<tr>
						<td class="TrOtrasObservAncho1">Verticales</td>
						<td class="TrObservAncho2UltimaColumna"><?=$observ_col_sup_2?></td>
					</tr>
					<tr>
						<td class="TrOtrasObservAncho1">Horizontales</td>
						<td class="TrObservAncho2UltimaColumna"><?=$observ_col_sup_3?></td>
					</tr>
					<tr>
						<td class="TrOtrasObservAncho1">Inv. y Desp.</td>
						<td class="TrObservAncho2UltimaColumna"><?=$observ_col_sup_4?></td>
					</tr>
				</table>
			</td>
		</tr>
		<tr>
			<td style="width:100%; vertical-align:top  " >
				<table style="width:100% " cellpadding="0" cellspacing="0" border="0">
					<tr>
						<td colspan="2" class="bordesLineaPrincipal">OBSERVACIONES CONTROL DE PROCESOS </td>
					</tr>
					<tr>
						<td class="TrOtrasObservAncho1">SCP</td>
						<td class="TrObservAncho2UltimaColumna"><?=$observ_scp_sup_1?></td>
					</tr>
				</table>
			</td>
		</tr>
	</table>
	<?php
}

?>