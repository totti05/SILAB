<?php
include 'select_reporte_estatus_planta.php';
global $titulo_tabla_reduccion_dia;
ini_set('display_errors', false);  	

?>
<page orientation="paysage">
		<link href="http://control/scp/modules/estatus_planta/desarrollo_silos/estilos1.css" rel="stylesheet" type="text/css" />
		<link href="estilos1.css" rel="stylesheet" type="text/css" />
		<table style="width:100%" cellpadding="0" cellspacing="0">
			<tr style="height:30px">
				<td colspan="2">
					<div id="encabezado_reporte" style="height:30px; width:100%"><?=encabezado_reporte()?></div>
				</td>
			</tr>
			<tr style="height:135px">
				<td colspan="2">
					<div id="tabla_reduccion_1" style="height:130px; width:100%"><?=tabla_reduccion_dia()?></div>
				</td>
			</tr>
			<tr style="height:105px">
				<td colspan="2" style="width:100% ">
					<div id="tabla_reduccion_2" style="height:105px; width:100%"><?=tabla_areas_turno()?></div>
				</td>
			</tr>
			<tr style="height:175px">
				<td style="width:64%; text-align:center ">
					<div id="tabla_reduccion_1" style="height:175px; width:100%; text-align:center"><?=tabla_reduccion_turno()?></div>
				</td>
				<td style="width:36% ">
					<div id="tabla_reduccion_1" style="height:175px; width:100%; text-align:center"><?=tabla_equipo_movil_materia_prima()?></div>
				</td>
			</tr>
			<tr style="height:115px">
				<td colspan="2" style="width:100% ">
					<div id="tabla_reduccion_1" style="height:115px; overflow:auto; width:100%"><?=tabla_observaciones()?></div>
				</td>
			</tr>
		</table>
</page>
<?php

function encabezado_reporte()
{
	global $fecha_reporte, $semana_reporte, $turno_reporte;
	list($dia, $mes, $a�o)							=	split('/', $fecha_reporte);
	$mes_fecha										=	strftime("%m",mktime(0,0,0,$mes,$dia,$a�o));
	$a�o_fecha										=	strftime("%Y",mktime(0,0,0,$mes,$dia,$a�o));
	$titulo = "REPORTE IGPP";
	if ($semana_reporte >= 52 &&  $mes_fecha == 1)		$a�o_fecha	=	$a�o_fecha - 1;
	if ($semana_reporte <= 3  &&  $mes_fecha == 12)		$a�o_fecha	=	$a�o_fecha + 1;
	$rango 											=	RangoSemana($semana_reporte, $a�o_fecha);
	$hoy											=	getdate();
	$hora											=	$hoy['hours'].":".$hoy['minutes'];
	?>
		<table style="width:100%" cellpadding="0" cellspacing="0">
			<tr>
				<td style="width:20%"><img src="http://control/scp/includes/logos/CVG_Reporte.JPG"/></td>
				<td style="width:60%" align="center" class="encabezado_reporte">INFORME GERENCIAL ESTATUS DE PLANTA <br>
						Fecha: <?=$fecha_reporte?>-<?=$hora?>  Turno: <?=$turno_reporte?>
						<br>
						Semana N� <?=$semana_reporte?>: del <?=date('d/m/Y', $rango[0])?> al <?=date('d/m/Y', $rango[6])?>
					</td>
				<td style="width:20%" align="right"><img src="http://control/scp/includes/logos/Venalum_Reporte.JPG" /></td>
			</tr>
		</table><?php
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
			$titulo_reduccion_dia_c1, $titulo_reduccion_dia_c3_1, $titulo_reduccion_dia_c3_2, $titulo_reduccion_dia_c4_1, $titulo_reduccion_dia_c4_2, $fecha_reduccion_dia;
	list($dia, $mes, $a�o)	= split('/', $fecha_reporte);
	
		list($a�o_red_dia, $mes_red_dia, $dia_red_dia)	=	split('-', $fecha_reduccion_dia);
		$fecha_reduccion_dia_mostrar					=	"$dia_red_dia/$mes_red_dia/$a�o_red_dia";
	?>
		<table style="width:100%" cellpadding="0" cellspacing="0">
			<tr>
				<td style="width:100%" class="bordesLineaPrincipal" colspan="17">AREA DE REDUCCION DATOS DIARIOS DEL <?=$fecha_reduccion_dia_mostrar?></td>
			</tr>
			<tr>
				<td class="bordesLinea1Ancho1">ACUM.</td>
				<td colspan="3" class="bordesLinea1">PRODUCCI�N AL. NETO</td>
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
				<td class="bordesLinea2Ancho1">L�NEA</td>
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
					<td class="TreduccionAncho2" style="color:<?php if ($reduccion_total_dia_turno[6][$n] != "") {if ($reduccion_total_dia_turno[6][$n] < 6.8 && $reduccion_total_dia_turno[6][$n] >= 0) echo "red";}?>"><?=valida_dato2($reduccion_total_dia_turno[6][$n])?></td>
					<td class="TreduccionAncho2UltimaColumna" style="color:<?php if ($reduccion_total_dia_turno[9][$n] != "") {if ($reduccion_total_dia_turno[9][$n] < 3.8 && $reduccion_total_dia_turno[9][$n] >= 0) echo "red";}?>"><?=valida_dato2($reduccion_total_dia_turno[9][$n])?></td>
				</tr>
				<?php
				$n++;
			}
			?>
			<tr>
				<td class="TreduccionAncho1FondoAmarillo">D�A PLANTA </td>
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
				<td class="TreduccionAncho2FondoAmarillo" style="color:<?php if ($acum_dia_reduccion[6] != "") {if ($acum_dia_reduccion[6] < 6.8 && $acum_dia_reduccion[6] >= 0) echo "red";}?>"><?=valida_dato2($acum_dia_reduccion[6])?></td>
				<td class="TreduccionAncho2FondoAmarilloUltimaColumna" style="color:<?php if ($acum_dia_reduccion[9] != "") {if ($acum_dia_reduccion[9] < 3.8 && $acum_dia_reduccion[9] >= 0) echo "red";}?>"><?=valida_dato2($acum_dia_reduccion[9])?></td>
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
				<td class="TreduccionAncho2FondoGris" style="color:<?php if ($acum_sem_reduccion[6] != "") {if ($acum_sem_reduccion[6] < 6.8 && $acum_sem_reduccion[6] >= 0) echo "red";}?>"><?=valida_dato2($acum_sem_reduccion[6])?></td>
				<td class="TreduccionAncho2FondoGrisUltimaColumna" style="color:<?php if ($acum_sem_reduccion[9] != "") {if ($acum_sem_reduccion[9] < 3.8 && $acum_sem_reduccion[9] >= 0) echo "red";}?>"><?=valida_dato2($acum_sem_reduccion[9])?></td>
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
				<td class="TreduccionAncho2FondoAzul" style="color:<?php if ($acum_mes_reduccion[6] != "") {if ($acum_mes_reduccion[6] < 6.8 && $acum_mes_reduccion[6] >= 0) echo "red";}?>"><?=valida_dato2($acum_mes_reduccion[6])?></td>
				<td class="TreduccionAncho2FondoAzulUltimaColumna" style="color:<?php if ($acum_mes_reduccion[9] != "") {if ($acum_mes_reduccion[9] < 3.8 && $acum_mes_reduccion[9] >= 0) echo "red";}?>"><?=valida_dato2($acum_mes_reduccion[9])?></td>
			</tr>
		</table><div style="height:5px"></div>
	<?php
}
function tabla_areas_turno()
{
	global $carbon_diario, $carbon_diario_2, $carbon_turno, $acum_sem_carbon, $acum_mes_carbon, $colada_turno, $colada_diario, $acum_sem_colada, $acum_mes_colada, $turno_reporte, $mat_recep,
	$carbon_turno_2, $carbon_diario_3, $acum_sem_carbon_2, $acum_mes_carbon_2;;
	?>
	<table width="100%"  border="0" cellspacing="0" cellpadding="0">
		<tr>
			<td class="bordesLineaPrincipalOtrasAreasPrimeraLinea">&nbsp;</td>
			<td colspan="5" class="bordesLineaPrincipalOtrasAreas">AREA CARB�N </td>
			<td class="bordesLineaPrincipalOtrasAreas">INF. ADICIONAL</td>
			<td colspan="3" class="bordesLineaPrincipalOtrasAreas">AREA COLADA</td>
		</tr>
		<tr>
			<td class="bordesLinea3">&nbsp;</td>
			<td colspan="3" class="bordesLinea1">PRODUCCION NETA ANODOS</td>
			<td colspan="2" class="bordesLinea1">INF. ESTACIONES DE BA&Ntilde;O</td>
			<td class="bordesLinea1">&nbsp;</td>
			<td colspan="3" class="bordesLinea1">CRISOLES</td>
		</tr>
		<tr>
			<td class="bordesLinea4">&nbsp;</td>
			<td class="TrOtrasAreasAncho2">VERDES</td>
			<td class="TrOtrasAreasAncho2">COCIDOS</td>
			<td class="TrOtrasAreasAncho2">ENVARILLADOS</td>
			<td class="TrOtrasAreasAncho2">CABO ENVIADO</td>
			<td class="TrOtrasAreasAncho2">BA�O ENVIADO</td>
			<td class="TrOtrasAreasAncho2">ACCIDENTES</td>
			<td class="TrOtrasAreasAncho2">RECIBIDOS</td>
			<td class="TrOtrasAreasAncho2">PROCESADOS</td>
			<td class="TrOtrasAreasAncho2UltimaColumna">TEMPERATURA</td>
		</tr>
		<tr>
			<td class="TrOtrasAreasAncho1">TURNO (T<?=$turno_reporte?>)</td>
			<td class="TrOtrasAreasAncho2"><?=valida_dato2($carbon_turno['produc_anodo_verde'])?></td>
			<td class="TrOtrasAreasAncho2"><?php if ($carbon_turno['produc_anodo_cocido'] >0) valida_dato2($carbon_turno['produc_anodo_cocido']); else echo "0";?></td>
			<td class="TrOtrasAreasAncho2"><?=valida_dato2($carbon_turno['produc_anodo_envarillado'])?></td>
			<td class="TrOtrasAreasAncho2"><?=valida_dato2($carbon_turno_2[0][0])?> / <?=valida_dato2($carbon_turno_2[0][1])?></td>
			<td class="TrOtrasAreasAncho2"><?=valida_dato2($carbon_turno_2[1][0])?> / <?=valida_dato2($carbon_turno_2[1][1])?></td>
			<td class="TrOtrasAreasAncho2"><?=valida_dato2($accidentes_turno['num_accidente'])?></td>
			<td class="TrOtrasAreasAncho2"><?=valida_dato2($colada_turno['num_crisoles_recibidos'])?></td>
			<td class="TrOtrasAreasAncho2"><?=valida_dato2($colada_turno['num_crisoles_procesados'])?></td>
			<td class="TrOtrasAreasAncho2UltimaColumna"><?=valida_dato2($colada_turno['temperatura_crisoles_recibidos']);?></td>
		</tr>
		<tr>
			<td class="TreduccionAncho1FondoAmarillo">ACUM. D�A </td>
			<td class="TrOtrasAreasAncho2FondoAmarillo"><?=valida_dato2($carbon_diario_2['produc_anodo_verde'])?></td>
			<td class="TrOtrasAreasAncho2FondoAmarillo"><?php if ($carbon_diario_2['produc_anodo_cocido'] > 0) valida_dato2($carbon_diario_2['produc_anodo_cocido']); else echo "0";?></td>
			<td class="TrOtrasAreasAncho2FondoAmarillo"><?=valida_dato2($carbon_diario_2['produc_anodo_envarillado'])?></td>
			<td class="TrOtrasAreasAncho2FondoAmarillo"><?=valida_dato2($carbon_diario_3[17][1])?> / <?=valida_dato2($carbon_diario_3[17][2])?></td>
			<td class="TrOtrasAreasAncho2FondoAmarillo"><?=valida_dato2($carbon_diario_3[19][1])?> / <?=valida_dato2($carbon_diario_3[19][2])?></td>
			<td class="TrOtrasAreasAncho2FondoAmarillo"><?=valida_dato2($acum_dia_accidentes['num_accidente'])?></td>
			<td class="TrOtrasAreasAncho2FondoAmarillo"><?=valida_dato2($colada_diario['num_crisoles_recibidos'])?></td>
			<td class="TrOtrasAreasAncho2FondoAmarillo"><?=valida_dato2($colada_diario['num_crisoles_procesados'])?></td>
			<td class="TrOtrasAreasAncho2FondoAmarilloUltimaColumna"><?=valida_dato2($colada_diario['temperatura_crisoles_recibidos']);?></td>
		</tr>
		<tr>
			<td class="TreduccionAncho1FondoGris">ACUM. SEMANA </td>
			<td class="TrOtrasAreasAncho2FondoGris"><?=valida_dato2($acum_sem_carbon['produc_anodo_verde'])?></td>
			<td class="TrOtrasAreasAncho2FondoGris"><?=valida_dato2($acum_sem_carbon['produc_anodo_cocido'])?></td>
			<td class="TrOtrasAreasAncho2FondoGris"><?=valida_dato2($acum_sem_carbon['produc_anodo_envarillado'])?></td>
			<td class="TrOtrasAreasAncho2FondoGris"><?=valida_dato2($acum_sem_carbon_2[17][1])?> / <?=valida_dato2($acum_sem_carbon_2[17][2])?></td>
			<td class="TrOtrasAreasAncho2FondoGris"><?=valida_dato2($acum_sem_carbon_2[19][1])?> / <?=valida_dato2($acum_sem_carbon_2[19][2])?></td>
			<td class="TrOtrasAreasAncho2FondoGris"><?=valida_dato2($acum_sem_accidentes['num_accidente'])?></td>
			<td class="TrOtrasAreasAncho2FondoGris"><?=valida_dato2($acum_sem_colada['num_crisoles_recibidos'])?></td>
			<td class="TrOtrasAreasAncho2FondoGris"><?=valida_dato2($acum_sem_colada['num_crisoles_procesados'])?></td>
			<td class="TrOtrasAreasAncho2FondoGrisUltimaColumna"><?=valida_dato2($acum_sem_colada['temperatura_crisoles_recibidos']);?></td>
	  </tr>
		<tr>
			<td class="TreduccionAncho1FondoAzul">ACUM. MES </td>
			<td class="TrOtrasAreasAncho2FondoAzul"><?=valida_dato2($acum_mes_carbon['produc_anodo_verde'])?></td>
			<td class="TrOtrasAreasAncho2FondoAzul"><?=valida_dato2($acum_mes_carbon['produc_anodo_cocido'])?></td>
			<td class="TrOtrasAreasAncho2FondoAzul"><?=valida_dato2($acum_mes_carbon['produc_anodo_envarillado'])?></td>
			<td class="TrOtrasAreasAncho2FondoAzul"><?=valida_dato2($acum_mes_carbon_2[17][1])?> / <?=valida_dato2($acum_mes_carbon_2[17][2])?></td>
			<td class="TrOtrasAreasAncho2FondoAzul"><?=valida_dato2($acum_mes_carbon_2[19][1])?> / <?=valida_dato2($acum_mes_carbon_2[19][2])?></td>
			<td class="TrOtrasAreasAncho2FondoAzul"><?=valida_dato2($acum_mes_accidentes['num_accidente'])?></td>
			<td class="TrOtrasAreasAncho2FondoAzul"><?=valida_dato2($acum_mes_colada['num_crisoles_recibidos'])?></td>
			<td class="TrOtrasAreasAncho2FondoAzul"><?=valida_dato2($acum_mes_colada['num_crisoles_procesados'])?></td>
			<td class="TrOtrasAreasAncho2FondoAzulUltimaColumna"><?=valida_dato2($acum_mes_colada['temperatura_crisoles_recibidos']);?> </td>
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
	global $reduccion_turno, $fecha_reporte, $turno_reporte, $res_observ_4, $cantidad_celdas, $total_reduccion_turno, $equipo_movil_turno, $autonomia_operativa_planta, $prom_lineal_auto_oper_linea;
	list($dia, $mes, $a�o)	= split('/', $fecha_reporte);
	?>
	<table style="width:100%; text-align:center	" border="0" cellspacing="0" cellpadding="0">
		<tr>
			<td colspan="15" class="bordesLineaPrincipal">AREA REDUCCI�N TURNO (T<?=$turno_reporte?>)</td>
		</tr>
		<tr>
			<td class="bordesLinea1">&nbsp;</td>
			<td class="bordesLinea1"># CELDAS</td>
			<td class="bordesLinea1"># CELDAS</td>
			<td class="bordesLinea1"># CELDAS</td>
			<td class="bordesLinea1">ANODOS</td>
			<td class="bordesLinea1">CRISOLES</td>
			<td class="bordesLinea1" colspan="2">PRESI�N AIRE (BAR)</td>
			<td class="bordesLinea1"># CELDAS</td>
			<td class="bordesLinea1"># CELDAS</td>
			<td class="bordesLinea1"># CELDAS</td>
			<td class="bordesLinea1Ancho2UltimaColumna" colspan="4">NIVEL SILOS</td>
		</tr>
		<tr>
			<td class="TrOtrasAreasAncho1">LINEA</td>
			<td class="silos_TrReduccionTurnoAreasAncho2"> >1 EA</td>
			<td class="silos_TrReduccionTurnoAreasAncho2">DES > 0.15</td>
			<td class="silos_TrReduccionTurnoAreasAncho2" >T.BLOQ</td>
			<td class="silos_TrReduccionTurnoAreasAncho2">SERVIDOS</td>
			<td class="silos_TrReduccionTurnoAreasAncho2">ASIGNADOS</td>
			<td class="silos_TrReduccionTurnoAreasAncho2">PRINC.</td>
			<td class="silos_TrReduccionTurnoAreasAncho2">FACILID18</td>
			<td class="silos_TrReduccionTurnoAreasAncho2">CASC.ROJO</td>
			<td class="silos_TrReduccionTurnoAreasAncho2">DERRA.Fl</td>
			<td class="silos_TrReduccionTurnoAreasAncho2">DERRA.Al</td>
			<td class="silos_TrReduccionTurnoAreasAncho3">PRIM.Al(%)</td>
			<td class="silos_TrReduccionTurnoAreasAncho3">SEC.Al(%)</td>
			<td class="silos_TrReduccionTurnoAreasAncho3">BA�O (%) </td>
			<td class="TrReduccioTrunosAncho2UltimaColumna">Inv.Op(Dia)</td>
		</tr>
		<?php
			while ($n <= 5)
			{
			?>
				<tr>
					<td class="TrOtrasAreasAncho1"><?=$n?></td>
					<td class="silos_TrReduccionTurnoAreasAncho2"><?=$reduccion_turno[3][$n]?></td>
					<td class="silos_TrReduccionTurnoAreasAncho2"><?=$reduccion_turno[4][$n]?></td>
					<td class="silos_TrReduccionTurnoAreasAncho2"><?=$reduccion_turno[7][$n]?></td>
					<td class="silos_TrReduccionTurnoAreasAncho2"><?=$reduccion_turno[2][$n]?></td>
					<td class="silos_TrReduccionTurnoAreasAncho2"><?=$reduccion_turno[6][$n]?></td>
					<td class="silos_TrReduccionTurnoAreasAncho2" style="color:<?php if ($reduccion_turno[1][$n] != "") {if ($reduccion_turno[1][$n] < 6.8 && $reduccion_turno[1][$n] >= 0) echo "red";}?>"><?=valida_dato2($reduccion_turno[1][$n])?></td>
					<td class="silos_TrReduccionTurnoAreasAncho2" style="color:<?php if ($reduccion_turno[5][$n] != "") {if ($reduccion_turno[5][$n] < 3.8 && $reduccion_turno[5][$n] >= 0) echo "red";}?>"><?=valida_dato2($reduccion_turno[5][$n])?></td>
					<td class="silos_TrReduccionTurnoAreasAncho2"><?=$cantidad_celdas[1][$n]?></td>
					<td class="silos_TrReduccionTurnoAreasAncho2"><?=$cantidad_celdas[2][$n]?></td>
					<td class="silos_TrReduccionTurnoAreasAncho2"><?=$cantidad_celdas[3][$n]?></td>
					<td class="silos_TrReduccionTurnoAreasAncho2"><?php if ($n == 5 ) echo $reduccion_turno[17][$n]."/".$reduccion_turno[17][6]."/".$reduccion_turno[30][6]; else echo $reduccion_turno[17][$n];?></td>
					<td class="silos_TrReduccionTurnoAreasAncho2"><?php if ($n == 5 ) echo $reduccion_turno[18][$n]."/".$reduccion_turno[18][6]; else echo $reduccion_turno[18][$n];?></td>
					<td class="silos_TrReduccionTurnoAreasAncho2"><?php echo $reduccion_turno[19][$n]?></td>
					<td class="TrReduccioTrunosAncho2UltimaColumna"><?php echo $reduccion_turno[21][$n] ?></td>
				</tr>
			<?php
				$n++;
			}
			?>
		<tr>
			<td class="TrOtrasAreasAncho1">Total</td>
			<td class="silos_TrReduccionTurnoAreasAncho2"><?=$total_reduccion_turno[3]?></td>
			<td class="silos_TrReduccionTurnoAreasAncho2"><?=$total_reduccion_turno[4]?></td>
			<td class="silos_TrReduccionTurnoAreasAncho2"><?=$total_reduccion_turno[7]?></td>
			<td class="silos_TrReduccionTurnoAreasAncho2"><?=$total_reduccion_turno[2]?></td>
			<td class="silos_TrReduccionTurnoAreasAncho2"><?=$total_reduccion_turno[6]?></td>
			<td class="silos_TrReduccionTurnoAreasAncho2"><?=$total_reduccion_turno[1]?></td>
			<td class="silos_TrReduccionTurnoAreasAncho2"><?=$total_reduccion_turno[5]?></td>
			<td class="silos_TrReduccionTurnoAreasAncho2"><?=$total_reduccion_turno[8]?></td>
			<td class="silos_TrReduccionTurnoAreasAncho2"><?=$total_reduccion_turno[9]?></td>
			<td class="silos_TrReduccionTurnoAreasAncho2"><?=$total_reduccion_turno[10]?></td>
			<td class="silos_TrReduccionTurnoAreasAncho3"><?=$total_reduccion_turno[17]?></td>
			<td class="silos_TrReduccionTurnoAreasAncho3"><?=$total_reduccion_turno[18]?></td>
			<td class="silos_TrReduccionTurnoAreasAncho3"><?=$total_reduccion_turno[19]?></td>
			<td class="TrReduccioTrunosAncho2UltimaColumna"><?=$autonomia_operativa_planta?></td>
		</tr>
	</table>
	<table style="width:100%" border="0" cellspacing="0" cellpadding="0">
		<tr>
			<td colspan="7" class="bordesLineaPrincipal">EQUIPOS MOVILES EN PLANTA</td>
		</tr>
		<tr>
			<td class="TrOtrasAreasAncho1_2">&nbsp;</td>
			<td class="TrEquipoMovilTurnoAreasAncho2">MONTACARGA</td>
			<td class="TrEquipoMovilTurnoAreasAncho2">REMOLCADOR</td>
			<td class="TrEquipoMovilTurnoAreasAncho2">SKYDER</td>
			<td class="TrEquipoMovilTurnoAreasAncho2">PAYLOADER</td>
			<td class="TrEquipoMovilTurnoAreasAncho2">CAMI�N</td>
			<td class="TrEquipoMovilAncho2UltimaColumna">TRACTOR</td>
		</tr>
		<tr>
			<td class="TrOtrasAreasAncho1_2">ESTANDAR</td>
			<td class="TrEquipoMovilTurnoAreasAncho2"><?=$equipo_movil_turno[1]['estandar']?></td>
			<td class="TrEquipoMovilTurnoAreasAncho2"><?=$equipo_movil_turno[2]['estandar']?></td>
			<td class="TrEquipoMovilTurnoAreasAncho2"><?=$equipo_movil_turno[3]['estandar']?></td>
			<td class="TrEquipoMovilTurnoAreasAncho2"><?=$equipo_movil_turno[4]['estandar']?></td>
			<td class="TrEquipoMovilTurnoAreasAncho2"><?=$equipo_movil_turno[5]['estandar']?></td>
			<td class="TrEquipoMovilAncho2UltimaColumna"><?=$equipo_movil_turno[6]['estandar']?></td>
		</tr>
		<tr>
			<td class="TrOtrasAreasAncho1_2">OPERATIVO</td>
			<td class="TrEquipoMovilTurnoAreasAncho2"><?=$equipo_movil_turno[1]['operativo']?></td>
			<td class="TrEquipoMovilTurnoAreasAncho2"><?=$equipo_movil_turno[2]['operativo']?></td>
			<td class="TrEquipoMovilTurnoAreasAncho2"><?=$equipo_movil_turno[3]['operativo']?></td>
			<td class="TrEquipoMovilTurnoAreasAncho2"><?=$equipo_movil_turno[4]['operativo']?></td>
			<td class="TrEquipoMovilTurnoAreasAncho2"><?=$equipo_movil_turno[5]['operativo']?></td>
			<td class="TrEquipoMovilAncho2UltimaColumna"><?=$equipo_movil_turno[6]['operativo']?></td>
		</tr>
		<tr>
			<td class="TrOtrasAreasAncho1_2">&nbsp;</td>
			<td class="TrEquipoMovilTurnoAreasAncho2">CISTERNA</td>
			<td class="TrEquipoMovilTurnoAreasAncho2">COMPRESOR</td>
			<td class="TrEquipoMovilTurnoAreasAncho2">MONTACARGA(R)</td>
			<td class="TrEquipoMovilTurnoAreasAncho2">PLATAFORMA</td>
			<td class="TrEquipoMovilTurnoAreasAncho2">EXCAVADORA</td>
			<td class="TrEquipoMovilAncho2UltimaColumna">&nbsp;</td>
		</tr>
		<tr>
			<td class="TrOtrasAreasAncho1_2">ESTANDAR</td>
			<td class="TrEquipoMovilTurnoAreasAncho2"><?=$equipo_movil_turno[7]['estandar']?></td>
			<td class="TrEquipoMovilTurnoAreasAncho2"><?=$equipo_movil_turno[8]['estandar']?></td>
			<td class="TrEquipoMovilTurnoAreasAncho2"><?=$equipo_movil_turno[9]['estandar']?></td>
			<td class="TrEquipoMovilTurnoAreasAncho2"><?=$equipo_movil_turno[10]['estandar']?></td>
			<td class="TrEquipoMovilTurnoAreasAncho2"><?=$equipo_movil_turno[11]['estandar']?></td>
			<td class="TrEquipoMovilAncho2UltimaColumna">&nbsp;</td>
		</tr>
		<tr>
			<td class="TrOtrasAreasAncho1_2">OPERATIVO</td>
			<td class="TrEquipoMovilTurnoAreasAncho2"><?=$equipo_movil_turno[7]['operativo']?></td>
			<td class="TrEquipoMovilTurnoAreasAncho2"><?=$equipo_movil_turno[8]['operativo']?></td>
			<td class="TrEquipoMovilTurnoAreasAncho2"><?=$equipo_movil_turno[9]['operativo']?></td>
			<td class="TrEquipoMovilTurnoAreasAncho2"><?=$equipo_movil_turno[10]['operativo']?></td>
			<td class="TrEquipoMovilTurnoAreasAncho2"><?=$equipo_movil_turno[11]['operativo']?></td>
			<td class="TrEquipoMovilAncho2UltimaColumna">&nbsp;</td>
		</tr>
	</table>
	<?php
}

function tabla_equipo_movil_materia_prima()
{
	global $prod_reduc_turno, $color_tabla_reduccion, $materias_primas, $dias_consumo, $auto_oper_suministros, $materias_primas_1;
	?>
		<table style="width:98%" border="0" cellspacing="0" cellpadding="0">
			<tr>
			  <td style="width:100%">
					<table style="width:100%; text-align:left	" border="0" cellspacing="0" cellpadding="0">
						<tr>
							<td colspan="4" style="font-size:8px; text-align:center"  class="bordesLineaPrincipal">PRODUCCION DE ALUMINIO (t) POR TURNO</td>
						</tr>
						<tr>
							<td style="width:25%; font-size:8px; text-align:center" class="TrOtrasAreasAncho1">TURNO 1</td>
							<td style="width:25%; font-size:8px; text-align:center" class="TrReduccionTurnoAreasAncho2">TURNO 2</td>
							<td style="width:25%; font-size:8px; text-align:center" class="TrReduccionTurnoAreasAncho2">TURNO 3</td>
							<td style="width:25%; font-size:8px; text-align:center" class="TrReduccioTrunosAncho2UltimaColumna">TOTAL DIA</td>
						</tr>
						<tr>
							<td style="width:25%; font-size:8px; text-align:center; color:<?=$color_tabla_reduccion[1]?>" class="TrOtrasAreasAncho1"><?=$prod_reduc_turno[1]?></td>
							<td style="width:25%; font-size:8px; text-align:center; color:<?=$color_tabla_reduccion[2]?>" class="TrReduccionTurnoAreasAncho2"><?=$prod_reduc_turno[2]?></td>
							<td style="width:25%; font-size:8px; text-align:center; color:<?=$color_tabla_reduccion[3]?>" class="TrReduccionTurnoAreasAncho2"><?=$prod_reduc_turno[3]?></td>
							<td style="width:25%; font-size:8px; text-align:center; color:<?=$color_tabla_reduccion[4]?>" class="TrReduccioTrunosAncho2UltimaColumna"><?=$prod_reduc_turno[4]?></td>
						</tr>
					</table>
				</td>
			</tr>
			<tr>
				<td style="width:100%">
					<table style="width:100%" border="0" cellspacing="0" cellpadding="0">
						<tr>
							<td colspan="8" class="bordesLineaPrincipal">AREA SUMINISTROS INDUSTRIALES </td>
						</tr>
						<tr>
							<td colspan="8" class="bordesLinea1Ancho2UltimaColumna">INVENTARIO DE MATERIAS PRIMAS EN PLANTA </td>
						</tr>
						<tr>
							<td class="bordesLinea1">&nbsp;</td>
							<td class="bordesLinea1">ALUMINA</td>
							<td class="bordesLinea1">CRIOLITA</td>
							<td class="bordesLinea1">FLUORURO</td>
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
							<td class="TrMateriaPrimaTurnoAreasAncho2"><?=$materias_primas_1?></td>
							<td class="TrMateriaPrimaTurnoAreasAncho2"><?=$materias_primas[2]?></td>
							<td class="TrMateriaPrimaTurnoAreasAncho2"><?=$materias_primas[3]?></td>
							<td class="TrMateriaPrimaTurnoAreasAncho2"><?=$materias_primas[4]?></td>
							<td class="TrMateriaPrimaTurnoAreasAncho2"><?=$materias_primas[5]?></td>
							<td class="TrMateriaPrimaTurnoAreasAncho2"><?=$materias_primas[6]?></td>
							<td class="TrMateriaPrimaAncho2UltimaColumna"><?=$materias_primas[7]?></td>
						</tr>
						<tr>
							<td class="TrOtrasAreasAncho1_2">INVENT(dias)</td>
							<td class="TrMateriaPrimaTurnoAreasAncho2"><?=$auto_oper_suministros[1]?></td>
							<td class="TrMateriaPrimaTurnoAreasAncho2"><?=$auto_oper_suministros[2]?></td>
							<td class="TrMateriaPrimaTurnoAreasAncho2"><?=$auto_oper_suministros[3]?></td>
							<td class="TrMateriaPrimaTurnoAreasAncho2"><?=$auto_oper_suministros[4]?></td>
							<td class="TrMateriaPrimaTurnoAreasAncho2"><?=$auto_oper_suministros[5]?></td>
							<td class="TrMateriaPrimaTurnoAreasAncho2"><?=$auto_oper_suministros[6]?></td>
							<td class="TrMateriaPrimaAncho2UltimaColumna"><?=$auto_oper_suministros[7]?></td>
						</tr>
						<tr>
							<td colspan="8" class="TrOtrasAreasAncho1_2">&nbsp;</td>
						</tr>
						<tr>
							<td class="bordesLinea1">INV.GENERAL</td>
							<td rowspan="2" class="TrMateriaPrimaTurnoAreasAncho2"><?=$auto_oper_suministros[12]?></td>
							<td class="TrMateriaPrimaTurnoAreasAncho2">Defict.Alum.P19</td>
							<td class="TrMateriaPrimaTurnoAreasAncho2"><?=$auto_oper_suministros[21]?></td>
							<td class="bordesLinea1Ancho2UltimaColumna" colspan="4">&nbsp;</td>
						</tr>
						<tr>
							<td class="TrOtrasAreasAncho1_2">PLANTA(DIAS)</td>
							<td class="TrMateriaPrimaTurnoAreasAncho2">Defict.Alum.VL</td>
							<td class="TrMateriaPrimaTurnoAreasAncho2"><?=$auto_oper_suministros[22]?></td>
							<td class="TrMateriaPrimaAncho2UltimaColumna" colspan="4">&nbsp;</td>
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
			$observ_scp_sup_1, $observ_mtto_sup_1, $observ_mtto_sup_2, $observ_mtto_sup_3;
	
	?>
	<table style="width:100% " cellpadding="0" cellspacing="0">
		<tr>
			<td style="width:100% ">
				<table style="width:100% " cellpadding="0" cellspacing="0" border="0">
					<tr>
						<td colspan="2" class="bordesLineaPrincipal">OBSERVACIONES REDUCCION</td>
						<td style="width:18%; text-align:center" class="bordesLineaPrincipal">OBSERV. TALLER AUTOMOTRIZ</td>
					</tr>
					<tr>
						<td style="width:8%" class="TrOtrasObservAncho1">Observaci�n L1</td>
						<td style="width:74%" class="TrObservAncho2UltimaColumna"><?php if ($observ_redu_sup_1 == "&nbsp;") echo "&nbsp;"; else echo strtoupper($observ_redu_sup_1);?></td>
						<td rowspan="5" class="TrObservAncho2UltimaColumna" style="width:18%"><?php if ($observ_mtto_sup_1 == "&nbsp;") echo "&nbsp;"; else echo strtoupper($observ_mtto_sup_1);?></td>
					</tr>
					<tr>
						<td style="width:8%" class="TrOtrasObservAncho1">Observaci�n L2</td>
						<td style="width:74%" class="TrObservAncho2UltimaColumna"><?php if ($observ_redu_sup_2 == "&nbsp;") echo "&nbsp;"; else echo strtoupper($observ_redu_sup_2);?></td>
					</tr>
					<tr>
						<td style="width:8%" class="TrOtrasObservAncho1">Observaci�n L3</td>
						<td style="width:74%" class="TrObservAncho2UltimaColumna"><?php if ($observ_redu_sup_3 == "&nbsp;") echo "&nbsp;"; else echo strtoupper($observ_redu_sup_3);?></td>
					</tr>
					<tr>
						<td style="width:8%" class="TrOtrasObservAncho1">Observaci�n L4</td>
						<td style="width:74%" class="TrObservAncho2UltimaColumna"><?php if ($observ_redu_sup_4 == "&nbsp;") echo "&nbsp;"; else echo strtoupper($observ_redu_sup_4);?></td>
					</tr>
					<tr>
						<td style="width:8%" class="TrOtrasObservAncho1">Observaci�n L5</td>
						<td style="width:74%" class="TrObservAncho2UltimaColumna"><?php if ($observ_redu_sup_5 == "&nbsp;") echo "&nbsp;"; else echo strtoupper($observ_redu_sup_5);?></td>
					</tr>
				</table>
			</td>
		</tr>
		<tr>
			<td style="width:100%; vertical-align:top ">
				<table style="width:100% " cellpadding="0" cellspacing="0" border="0">
					<tr>
						<td colspan="2" class="bordesLineaPrincipal">OBSERVACIONES CARBON </td>
						<td style="width:18%; text-align:center" class="bordesLineaPrincipal">OBSERV. OPER. ALTO VOLTAJE</td>
					</tr>
					<tr>
						<td style="width:8%" class="TrOtrasObservAncho1">Molienda</td>
						<td class="TrObservAncho2UltimaColumna" style="width:74%"><?php if ($observ_carb_sup_1 == "&nbsp;") echo "&nbsp;"; else echo strtoupper($observ_carb_sup_1);?></td>
						<td rowspan="5" class="TrObservAncho2UltimaColumna" style="width:18%"><?php if ($observ_mtto_sup_2 == "&nbsp;") echo "&nbsp;"; else echo strtoupper($observ_mtto_sup_2);?></td>
					</tr>
					<tr>
						<td style="width:8%" class="TrOtrasObservAncho1">Hornos</td>
						<td class="TrObservAncho2UltimaColumna" style="width:74%"><?php if ($observ_carb_sup_2 == "&nbsp;") echo "&nbsp;"; else echo strtoupper($observ_carb_sup_2);?></td>
					</tr>
					<tr>
						<td style="width:8%" class="TrOtrasObservAncho1">Envarillado</td>
						<td class="TrObservAncho2UltimaColumna" style="width:74%"><?php if ($observ_carb_sup_3 == "&nbsp;") echo "&nbsp;"; else echo strtoupper($observ_carb_sup_3);?></td>
					</tr>
					<tr>
						<td style="width:8%" class="TrOtrasObservAncho1">Estaci�n de Ba�o 1</td>
						<td class="TrObservAncho2UltimaColumna" style="width:74%"><?php if ($observ_carb_sup_4 == "&nbsp;") echo "&nbsp;"; else echo strtoupper($observ_carb_sup_4);?></td>
					</tr>
					<tr>
						<td style="width:8%" class="TrOtrasObservAncho1">Estaci�n de Ba�o 2</td>
						<td class="TrObservAncho2UltimaColumna" style="width:74%"><?php if ($observ_carb_sup_5 == "&nbsp;") echo "&nbsp;"; else echo strtoupper($observ_carb_sup_5);?></td>
					</tr>
				</table>
			</td>
		</tr>
		<tr>
			<td style="width:100%; vertical-align:top  " >
				<table style="width:100% " cellpadding="0" cellspacing="0" border="0">
					<tr>
						<td colspan="2" class="bordesLineaPrincipal">OBSERVACIONES COLADA </td>
						<td style="width:18%; text-align:center" class="bordesLineaPrincipal">OBSERV. OPER. SIST. INDUST.</td>
					</tr>
					<tr>
						<td class="TrOtrasObservAncho1" style="width:8%">DPM</td>
						<td class="TrObservAncho2UltimaColumna" style="width:74%"><?php if ($observ_col_sup_1 == "&nbsp;") echo "&nbsp;"; else echo strtoupper($observ_col_sup_1);?></td>
						<td rowspan="4" class="TrObservAncho2UltimaColumna" style="width:18%"><?php if ($observ_mtto_sup_3 == "&nbsp;") echo "&nbsp;"; else echo strtoupper($observ_mtto_sup_3);?></td>
					</tr>
					<tr>
						<td class="TrOtrasObservAncho1" style="width:8%">Verticales</td>
						<td class="TrObservAncho2UltimaColumna" style="width:74%"><?php if ($observ_col_sup_2 == "&nbsp;") echo "&nbsp;"; else echo strtoupper($observ_col_sup_2);?></td>
					</tr>
					<tr>
						<td class="TrOtrasObservAncho1" style="width:8%">Horizontales</td>
						<td class="TrObservAncho2UltimaColumna" style="width:74%"><?php if ($observ_col_sup_3 == "&nbsp;") echo "&nbsp;"; else echo strtoupper($observ_col_sup_3);?></td>
					</tr>
					<tr>
						<td class="TrOtrasObservAncho1" style="width:8%">Inv. y Desp.</td>
						<td class="TrObservAncho2UltimaColumna" style="width:74%"><?php if ($observ_col_sup_4 == "&nbsp;") echo "&nbsp;"; else echo strtoupper($observ_col_sup_4);?></td>
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
						<td style="width:8%" class="TrOtrasObservAncho1">SCP</td>
						<td style="width:92%" class="TrObservAncho2UltimaColumna"><?php if ($observ_scp_sup_1 == "&nbsp;") echo "&nbsp;"; else echo strtoupper($observ_scp_sup_1);?></td>
					</tr>
				</table>
			</td>
		</tr>
	</table>
	<?php
}
ini_set('display_errors', true); 
?>