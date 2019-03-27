<?php
include 'select_reporte_estatus_planta.php';
global $titulo_tabla_reduccion_dia;

?>
<page orientation="paysage">
		<link href="http://control/scp/modules/estatus_planta/estilos1.css" rel="stylesheet" type="text/css" />
		<link href="estilos1.css" rel="stylesheet" type="text/css" />
		<table style="width:100%" cellpadding="0" cellspacing="0">
			<tr style="height:50px">
				<td colspan="2">
					<div id="encabezado_reporte" style="height:50px; width:100%"><?=encabezado_reporte()?></div>
				</td>
			</tr>
			<tr style="height:140px">
				<td colspan="2">
					<div id="tabla_reduccion_1" style="height:140px; width:100%"><?=tabla_reduccion_dia()?></div>
				</td>
			</tr>
			<tr style="height:110px">
				<td colspan="2" style="width:100% ">
					<div id="tabla_reduccion_2" style="height:110px; width:100%"><?=tabla_areas_turno()?></div>
				</td>
			</tr>
			<tr style="height:140px">
				<td style="width:50%; text-align:center ">
					<div id="tabla_reduccion_1" style="height:140px; width:90%; text-align:center"><?=tabla_reduccion_turno()?></div>
				</td>
				<td style="width:50% ">
					<div id="tabla_reduccion_1" style="height:140px; width:80%; text-align:center"><?=tabla_equipo_movil_materia_prima()?></div>
				</td>
			</tr>
			<tr style="height:120px">
				<td colspan="2" style="width:100% ">
					<div id="tabla_reduccion_1" style="height:220px; overflow:auto; width:100%"><?=tabla_observaciones()?></div>
				</td>
			</tr>
		</table>
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
			$titulo_reduccion_dia_c1, $titulo_reduccion_dia_c3_1, $titulo_reduccion_dia_c3_2, $titulo_reduccion_dia_c4_1, $titulo_reduccion_dia_c4_2;
	list($dia, $mes, $año)	= split('/', $fecha_reporte);
	
	?>
		<table style="width:100%" cellpadding="0" cellspacing="0">
			<tr>
				<td style="width:100%" class="bordesLineaPrincipal" colspan="17">AREA DE REDUCCION </td>
			</tr>
			<tr>
				<td class="bordesLinea1Ancho1">ACUM.</td>
				<td colspan="3" class="bordesLinea1">PRODUCCIÓN AL. NETO</td>
				<td colspan="4" class="bordesLinea1">CELDAS</td>
				<td class="bordesLinea1Ancho2">ANODOS</td>
				<td class="bordesLinea1Ancho2">CELDAS</td>
				<td class="bordesLinea1Ancho2">CELDAS</td>
				<td class="bordesLinea1Ancho2">CELDAS</td>
				<td class="bordesLinea1Ancho2">CELDAS</td>
				<td class="bordesLinea1Ancho2">CELDAS</td>
				<td class="bordesLinea1Ancho2"> CELDAS</td>
				<td class="bordesLinea1Ancho2UltimaColumna" colspan="2">PRES. AIRE (BAR)</td>
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
				<td class="bordesLinea2Ancho2">&gt;1 EA </td>
				<td class="bordesLinea2Ancho2">N.M.C.</td>
				<td class="bordesLinea2Ancho2">N.B.C.</td>
				<td class="bordesLinea2Ancho2">TEMP.CRIT.</td>
				<td class="bordesLinea2Ancho2">DESV. > 0.15</td>
				<td class="bordesLinea2Ancho2">%Fe > 0.5 </td>
				<td class="bordesLinea2Ancho2">PRINC.</td>
				<td class="TreduccionAncho2UltimaColumna">FAC18</td>
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
				}
				if ($n == 5) 
				{
					$titulo_reduccion_dia_c3 = $titulo_reduccion_dia_c3_2;
					$titulo_reduccion_dia_c4 = $titulo_reduccion_dia_c4_2;
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
					<td class="TreduccionAncho2"><?=$reduccion_total_dia_turno[2][$n]?></td>
					<td class="TreduccionAncho2"><?=$reduccion_total_dia_turno[3][$n]?></td>
					<td class="TreduccionAncho2"><?=$reduccion_total_dia_turno[4][$n]?></td>
					<td class="TreduccionAncho2"><?=$reduccion_total_dia_turno[1][$n]?></td>
					<td class="TreduccionAncho2"><?=$reduccion_total_dia_turno[5][$n]?></td>
					<td class="TreduccionAncho2"><?=$reduccion_total_dia_turno[8][$n]?></td>
					<td class="TreduccionAncho2"><?=valida_dato2($reduccion_total_dia_turno[6][$n])?></td>
					<td class="TreduccionAncho2UltimaColumna"><?=valida_dato2($reduccion_total_dia_turno[9][$n])?></td>
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
				<td class="TreduccionAncho2FondoAmarillo"><?=$acum_dia_reduccion[2]?></td>
				<td class="TreduccionAncho2FondoAmarillo"><?=$acum_dia_reduccion[3]?></td>
				<td class="TreduccionAncho2FondoAmarillo"><?=$acum_dia_reduccion[4]?></td>
				<td class="TreduccionAncho2FondoAmarillo"><?=$acum_dia_reduccion[1]?></td>
				<td class="TreduccionAncho2FondoAmarillo"><?=$acum_dia_reduccion[5]?></td>
				<td class="TreduccionAncho2FondoAmarillo"><?=$acum_dia_reduccion[8]?></td>
				<td class="TreduccionAncho2FondoAmarillo"><?=valida_dato2($acum_dia_reduccion[6])?></td>
				<td class="TreduccionAncho2FondoAmarilloUltimaColumna"><?=valida_dato2($acum_dia_reduccion[9])?></td>
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
				<td class="TreduccionAncho2FondoGris"><?=$acum_sem_reduccion[2]?></td>
				<td class="TreduccionAncho2FondoGris"><?=$acum_sem_reduccion[3]?></td>
				<td class="TreduccionAncho2FondoGris"><?=$acum_sem_reduccion[4]?></td>
				<td class="TreduccionAncho2FondoGris"><?=$acum_sem_reduccion[1]?></td>
				<td class="TreduccionAncho2FondoGris"><?=$acum_sem_reduccion[5]?></td>
				<td class="TreduccionAncho2FondoGris"><?=$acum_sem_reduccion[8]?></td>
				<td class="TreduccionAncho2FondoGris"><?=valida_dato2($acum_sem_reduccion[6])?></td>
				<td class="TreduccionAncho2FondoGrisUltimaColumna"><?=valida_dato2($acum_sem_reduccion[9])?></td>
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
				<td class="TreduccionAncho2FondoAzul"><?=$acum_mes_reduccion[2]?></td>
				<td class="TreduccionAncho2FondoAzul"><?=$acum_mes_reduccion[3]?></td>
				<td class="TreduccionAncho2FondoAzul"><?=$acum_mes_reduccion[4]?></td>
				<td class="TreduccionAncho2FondoAzul"><?=$acum_mes_reduccion[1]?></td>
				<td class="TreduccionAncho2FondoAzul"><?=$acum_mes_reduccion[5]?></td>
				<td class="TreduccionAncho2FondoAzul"><?=$acum_mes_reduccion[8]?></td>
				<td class="TreduccionAncho2FondoAzul"><?=valida_dato2($acum_mes_reduccion[6])?></td>
				<td class="TreduccionAncho2FondoAzulUltimaColumna"><?=valida_dato2($acum_mes_reduccion[9])?></td>
			</tr>
		</table><div style="height:5px"></div>
	<?php
}
function tabla_areas_turno()
{
	global $carbon_diario, $carbon_diario_2, $carbon_turno, $acum_sem_carbon, $acum_mes_carbon, $colada_turno, $colada_diario, $acum_sem_colada, $acum_mes_colada, $turno_reporte, $mat_recep;
	?>
	<table width="100%"  border="0" cellspacing="0" cellpadding="0">
		<tr>
			<td class="bordesLineaPrincipalOtrasAreasPrimeraLinea">&nbsp;</td>
			<td colspan="3" class="bordesLineaPrincipalOtrasAreas">AREA CARBÓN </td>
			<td colspan="3" class="bordesLineaPrincipalOtrasAreas">AREA COLADA </td>
			<td colspan="2" class="bordesLineaPrincipalOtrasAreas">INFORMACIÓN MUELLE</td>
			<td class="bordesLineaPrincipalOtrasAreasUltimaLinea">INFORMACIÓN ADICIONAL</td>
		</tr>
		<tr>
			<td class="bordesLinea3">&nbsp;</td>
			<td colspan="3" class="bordesLinea1">PRODUCCION NETA ANODOS</td>
			<td colspan="3" class="bordesLinea1">CRISOLES</td>
			<td class="bordesLinea1">DESPACHO</td>
			<td class="bordesLinea1"><div style="font-size:8px">RECEPCION: <?php if($mat_recep['acum_buque_dia']>0) echo "$mat_recep[fecha_atraque]"; ?></div></td>
			<td class="bordesLinea1Ancho2UltimaColumnaOtrasAreas">&nbsp;</td>
		</tr>
		<tr>
			<td class="bordesLinea4">&nbsp;</td>
			<td class="TrOtrasAreasAncho2">VERDES</td>
			<td class="TrOtrasAreasAncho2">COCIDOS</td>
			<td class="TrOtrasAreasAncho2">ENVARILLADOS</td>
			<td class="TrOtrasAreasAncho2">RECIBIDOS</td>
			<td class="TrOtrasAreasAncho2">PROCESADOS</td>
			<td class="TrOtrasAreasAncho2">TEMPERATURA</td>
			<td class="TrOtrasAreasAncho2">BUQUE:</td>
			<td class="TrOtrasAreasAncho2"><div style="font-size:8px"><?php if($mat_recep['acum_buque_dia']>0) echo "$mat_recep[nombre_buque]"; else echo "&nbsp;";?></div></td>
			<td class="TrOtrasAreasAncho2UltimaColumna">ACCIDENTES</td>
		</tr>
		<tr>
			<td class="TrOtrasAreasAncho1">TURNO (T<?=$turno_reporte?>)</td>
			<td class="TrOtrasAreasAncho2"><?=valida_dato2($carbon_turno['produc_anodo_verde'])?></td>
			<td class="TrOtrasAreasAncho2"><?php if ($carbon_turno['produc_anodo_cocido'] >0) valida_dato2($carbon_turno['produc_anodo_cocido']); else echo "0";?></td>
			<td class="TrOtrasAreasAncho2"><?=valida_dato2($carbon_turno['produc_anodo_envarillado'])?></td>
			<td class="TrOtrasAreasAncho2"><?=valida_dato2($colada_turno['num_crisoles_recibidos'])?></td>
			<td class="TrOtrasAreasAncho2"><?=valida_dato2($colada_turno['num_crisoles_procesados'])?></td>
			<td class="TrOtrasAreasAncho2"><?=valida_dato2($colada_turno['temperatura_crisoles_recibidos']);?></td>
			<td class="TrOtrasAreasAncho2">&nbsp;</td>
			<td class="TrOtrasAreasAncho2"><?php if($mat_recep['acum_buque_dia']>0) echo $mat_recep['cantidad_material_dia']." TM (".$mat_recep['acum_buque_dia']." TM)"; else echo "&nbsp;";?></td>
			<td class="TrOtrasAreasAncho2UltimaColumna">&nbsp;</td>
		</tr>
		<tr>
			<td class="TreduccionAncho1FondoAmarillo">ACUM. DÍA </td>
			<td class="TrOtrasAreasAncho2FondoAmarillo"><?=valida_dato2($carbon_diario_2['produc_anodo_verde'])?></td>
			<td class="TrOtrasAreasAncho2FondoAmarillo"><?php if ($carbon_diario_2['produc_anodo_cocido'] > 0) valida_dato2($carbon_diario_2['produc_anodo_cocido']); else echo "0";?></td>
			<td class="TrOtrasAreasAncho2FondoAmarillo"><?=valida_dato2($carbon_diario_2['produc_anodo_envarillado'])?></td>
			<td class="TrOtrasAreasAncho2FondoAmarillo"><?=valida_dato2($colada_diario['num_crisoles_recibidos'])?></td>
			<td class="TrOtrasAreasAncho2FondoAmarillo"><?=valida_dato2($colada_diario['num_crisoles_procesados'])?></td>
			<td class="TrOtrasAreasAncho2FondoAmarillo"><?=valida_dato2($colada_diario['temperatura_crisoles_recibidos']);?></td>
			<td class="TrOtrasAreasAncho2FondoAmarillo">&nbsp;</td>
			<td class="TrOtrasAreasAncho2FondoAmarillo">&nbsp;</td>
			<td class="TrOtrasAreasAncho2FondoAmarilloUltimaColumna">&nbsp;</td>
		</tr>
		<tr>
			<td class="TreduccionAncho1FondoGris">ACUM. SEMANA </td>
			<td class="TrOtrasAreasAncho2FondoGris"><?=valida_dato2($acum_sem_carbon['produc_anodo_verde'])?></td>
			<td class="TrOtrasAreasAncho2FondoGris"><?=valida_dato2($acum_sem_carbon['produc_anodo_cocido'])?></td>
			<td class="TrOtrasAreasAncho2FondoGris"><?=valida_dato2($acum_sem_carbon['produc_anodo_envarillado'])?></td>
			<td class="TrOtrasAreasAncho2FondoGris"><?=valida_dato2($acum_sem_colada['num_crisoles_recibidos'])?></td>
			<td class="TrOtrasAreasAncho2FondoGris"><?=valida_dato2($acum_sem_colada['num_crisoles_procesados'])?></td>
			<td class="TrOtrasAreasAncho2FondoGris"><?=valida_dato2($acum_sem_colada['temperatura_crisoles_recibidos']);?></td>
			<td class="TrOtrasAreasAncho2FondoGris">&nbsp;</td>
			<td class="TrOtrasAreasAncho2FondoGris">&nbsp;</td>
			<td class="TrOtrasAreasAncho2FondoGrisUltimaColumna">&nbsp;</td>
	  </tr>
		<tr>
			<td class="TreduccionAncho1FondoAzul">ACUM. MES </td>
			<td class="TrOtrasAreasAncho2FondoAzul"><?=valida_dato2($acum_mes_carbon['produc_anodo_verde'])?></td>
			<td class="TrOtrasAreasAncho2FondoAzul"><?=valida_dato2($acum_mes_carbon['produc_anodo_cocido'])?></td>
			<td class="TrOtrasAreasAncho2FondoAzul"><?=valida_dato2($acum_mes_carbon['produc_anodo_envarillado'])?></td>
			<td class="TrOtrasAreasAncho2FondoAzul"><?=valida_dato2($acum_mes_colada['num_crisoles_recibidos'])?></td>
			<td class="TrOtrasAreasAncho2FondoAzul"><?=valida_dato2($acum_mes_colada['num_crisoles_procesados'])?></td>
			<td class="TrOtrasAreasAncho2FondoAzul"><?=valida_dato2($acum_mes_colada['temperatura_crisoles_recibidos']);?></td>
			<td class="TrOtrasAreasAncho2FondoAzul">&nbsp;</td>
			<td class="TrOtrasAreasAncho2FondoAzul">&nbsp;</td>
			<td class="TrOtrasAreasAncho2FondoAzulUltimaColumna">&nbsp;</td>
		</tr>
		<tr>
			<td class="TrOtrasAreasAncho1">INVENTARIO</td>
			<td class="TrOtrasAreasAncho2"><?=valida_dato2($carbon_diario['inventario_anodo_verde'])?></td>
			<td class="TrOtrasAreasAncho2"><?=valida_dato2($carbon_diario['inventario_anodo_cocido'])?></td>
			<td class="TrOtrasAreasAncho2"><?=valida_dato2($carbon_diario['inventario_anodo_envarillado'])?></td>
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
	global $reduccion_turno, $fecha_reporte, $turno_reporte, $res_observ_4;
	list($dia, $mes, $año)	= split('/', $fecha_reporte);
	?>
	<table style="width:100%; text-align:center	" border="0" cellspacing="0" cellpadding="0">
		<tr>
			<td colspan="8" class="bordesLineaPrincipal">AREA REDUCCIÓN TURNO (T<?=$turno_reporte?>)</td>
		</tr>
		<tr>
			<td class="bordesLinea1">&nbsp;</td>
			<td class="bordesLinea1"># CELDAS</td>
			<td class="bordesLinea1"># CELDAS</td>
			<td class="bordesLinea1"># CELDAS</td>
			<td class="bordesLinea1">ANODOS</td>
			<td class="bordesLinea1">CRISOLES</td>
			<td class="bordesLinea1Ancho2UltimaColumna" colspan="2">PRESIÓN AIRE (BAR)</td>
		</tr>
		<tr>
			<td class="TrOtrasAreasAncho1">LINEA</td>
			<td class="TrReduccionTurnoAreasAncho2">MAS DE 1 EA </td>
			<td class="TrReduccionTurnoAreasAncho2">DESV. > 0.15</td>
			<td class="TrReduccionTurnoAreasAncho2" style="font-size:8px ">FALLA TOLVAS </td>
			<td class="TrReduccionTurnoAreasAncho2">SERVIDOS</td>
			<td class="TrReduccionTurnoAreasAncho2">ASIGNADOS</td>
			<td class="TrReduccionTurnoAreasAncho2">PRINC.</td>
			<td class="TrReduccioTrunosAncho2UltimaColumna">FACILID18</td>
		</tr>
		<?php
			while ($n <= 5)
			{
			?>
				<tr>
					<td class="TrOtrasAreasAncho1"><?=$n?></td>
					<td class="TrReduccionTurnoAreasAncho2"><?=$reduccion_turno[3][$n]?></td>
					<td class="TrReduccionTurnoAreasAncho2"><?=$reduccion_turno[4][$n]?></td>
					<td class="TrReduccionTurnoAreasAncho2"><?=$res_observ_4[$n]['num_celdas_tolv_bloq']?></td>
					<td class="TrReduccionTurnoAreasAncho2"><?=$reduccion_turno[2][$n]?></td>
					<td class="TrReduccionTurnoAreasAncho2"><?=$reduccion_turno[6][$n]?></td>
					<td class="TrReduccionTurnoAreasAncho2"><?=valida_dato2($reduccion_turno[1][$n])?></td>
					<td class="TrReduccioTrunosAncho2UltimaColumna"><?=valida_dato2($reduccion_turno[5][$n])?></td>
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
	global $equipo_movil_turno, $materias_primas, $dias_consumo;
	?>
		<table style="width:100%" border="0" cellspacing="0" cellpadding="0">
			<tr>
				<td style="width:100%">
					<table style="width:100%" border="0" cellspacing="0" cellpadding="0">
						<tr>
							<td colspan="6" class="bordesLineaPrincipal">EQUIPOS MOVILES EN PLANTA</td>
						</tr>
						<tr>
							<td class="TrOtrasAreasAncho1_2">&nbsp;</td>
							<td class="TrEquipoMovilTurnoAreasAncho2">MONTACARGA</td>
							<td class="TrEquipoMovilTurnoAreasAncho2">REMOLCADOR</td>
							<td class="TrEquipoMovilTurnoAreasAncho2">SKYDER</td>
							<td class="TrEquipoMovilTurnoAreasAncho2">PAYLOADER</td>
							<td class="TrEquipoMovilAncho2UltimaColumna">CAMION</td>
						</tr>
						<tr>
							<td class="TrOtrasAreasAncho1_2">ESTANDAR</td>
							<td class="TrEquipoMovilTurnoAreasAncho2"><?=$equipo_movil_turno[1]['estandar']?></td>
							<td class="TrEquipoMovilTurnoAreasAncho2"><?=$equipo_movil_turno[2]['estandar']?></td>
							<td class="TrEquipoMovilTurnoAreasAncho2"><?=$equipo_movil_turno[3]['estandar']?></td>
							<td class="TrEquipoMovilTurnoAreasAncho2"><?=$equipo_movil_turno[4]['estandar']?></td>
							<td class="TrEquipoMovilAncho2UltimaColumna"><?=$equipo_movil_turno[5]['estandar']?></td>
						</tr>
						<tr>
							<td class="TrOtrasAreasAncho1_2">OPERATIVO</td>
							<td class="TrEquipoMovilTurnoAreasAncho2"><?=$equipo_movil_turno[1]['operativo']?></td>
							<td class="TrEquipoMovilTurnoAreasAncho2"><?=$equipo_movil_turno[2]['operativo']?></td>
							<td class="TrEquipoMovilTurnoAreasAncho2"><?=$equipo_movil_turno[3]['operativo']?></td>
							<td class="TrEquipoMovilTurnoAreasAncho2"><?=$equipo_movil_turno[4]['operativo']?></td>
							<td class="TrEquipoMovilAncho2UltimaColumna"><?=$equipo_movil_turno[5]['operativo']?></td>
						</tr>
					</table>
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
							<td class="bordesLinea1">ALUMINIA</td>
							<td class="bordesLinea1">CRIOLITA</td>
							<td class="bordesLinea1">FLORURO</td>
							<td class="bordesLinea1">COQUE</td>
							<td class="bordesLinea1">COQUE</td>
							<td class="bordesLinea1">ALQUITRAN</td>
							<td class="bordesLinea1Ancho2UltimaColumna">ARRABIO</td>
						</tr>
						<tr>
							<td class="TrOtrasAreasAncho1_2">&nbsp;</td>
							<td class="TrMateriaPrimaTurnoAreasAncho2">FRESCA</td>
							<td class="TrMateriaPrimaTurnoAreasAncho2">&nbsp;</td>
							<td class="TrMateriaPrimaTurnoAreasAncho2"> ALUMINIO </td>
							<td class="TrMateriaPrimaTurnoAreasAncho2">METALUR.</td>
							<td class="TrMateriaPrimaTurnoAreasAncho2"> PETROLEO </td>
							<td class="TrMateriaPrimaTurnoAreasAncho2">&nbsp;</td>
							<td class="TrMateriaPrimaAncho2UltimaColumna">&nbsp;</td>
						</tr>
						<tr>
							<td class="TrOtrasAreasAncho1_2">INVENTARIO</td>
							<td class="TrMateriaPrimaTurnoAreasAncho2"><?=$materias_primas[1]?></td>
							<td class="TrMateriaPrimaTurnoAreasAncho2"><?=$materias_primas[2]?></td>
							<td class="TrMateriaPrimaTurnoAreasAncho2"><?=$materias_primas[3]?></td>
							<td class="TrMateriaPrimaTurnoAreasAncho2"><?=$materias_primas[4]?></td>
							<td class="TrMateriaPrimaTurnoAreasAncho2"><?=$materias_primas[5]?></td>
							<td class="TrMateriaPrimaTurnoAreasAncho2"><?=$materias_primas[6]?></td>
							<td class="TrMateriaPrimaAncho2UltimaColumna"><?=$materias_primas[7]?></td>
						</tr>
						<tr>
							<td class="TrOtrasAreasAncho1_2">DIAS CONSUM</td>
							<td class="TrMateriaPrimaTurnoAreasAncho2"><?=$dias_consumo[1]?></td>
							<td class="TrMateriaPrimaTurnoAreasAncho2"><?=$dias_consumo[2]?></td>
							<td class="TrMateriaPrimaTurnoAreasAncho2"><?=$dias_consumo[3]?></td>
							<td class="TrMateriaPrimaTurnoAreasAncho2"><?=$dias_consumo[4]?></td>
							<td class="TrMateriaPrimaTurnoAreasAncho2"><?=$dias_consumo[5]?></td>
							<td class="TrMateriaPrimaTurnoAreasAncho2"><?=$dias_consumo[6]?></td>
							<td class="TrMateriaPrimaAncho2UltimaColumna"><?=$dias_consumo[7]?></td>
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
						<td class="TrOtrasObservAncho1">Celdas con Casco Rojo</td>
						<td class="TrObservAncho2UltimaColumna"><?=$cadena_observ_1?></td>
					</tr>
					<tr>
						<td class="TrOtrasObservAncho1">Celdas con Derrame Fl</td>
						<td class="TrObservAncho2UltimaColumna"><?=$cadena_observ_2?></td>
					</tr>
					<tr>
						<td class="TrOtrasObservAncho1">Celdas con Derrame Al</td>
						<td class="TrObservAncho2UltimaColumna"><?=$cadena_observ_3?></td>
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