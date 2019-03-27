<?php
include 'conectarse.php';
$tipo_variable									=	$_GET['tipo_variable'];
$fecha_reporte									=	$_GET['fecha_reporte'];
$turno_reporte									=	$_GET['turno_reporte'];

$db												=	conectarse_postgres();

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


$sq_m1											=	"SELECT 	estatus_planta_diccionario_estandar_equipo_movil_area.cantidad_estandar,
														estatus_planta_diccionario_estandar_equipo_movil_area.id_sub_area, 
														estatus_planta_diccionario_estandar_equipo_movil_area.id_equipo_movil,
														estatus_planta_diccionario_sub_area.desc_sub_area,
														estatus_planta_diccionario_tipo_equipo_movil.desc_equipo_movil,
														estatus_planta_diccionario_area.desc_area
													FROM 	estatus_planta_diccionario_estandar_equipo_movil_area
													INNER JOIN
														estatus_planta_diccionario_sub_area
													ON	estatus_planta_diccionario_estandar_equipo_movil_area.id_sub_area = estatus_planta_diccionario_sub_area.id_sub_area
													INNER JOIN
														estatus_planta_diccionario_tipo_equipo_movil
													ON
														estatus_planta_diccionario_estandar_equipo_movil_area.id_equipo_movil = estatus_planta_diccionario_tipo_equipo_movil.id_equipo_movil
													INNER JOIN
														estatus_planta_diccionario_area
													ON
														estatus_planta_diccionario_sub_area.id_area = estatus_planta_diccionario_area.id_area
													
													WHERE estatus_planta_diccionario_estandar_equipo_movil_area.id_equipo_movil = '$tipo_variable'
													ORDER BY estatus_planta_diccionario_area.desc_area, estatus_planta_diccionario_sub_area.desc_sub_area";
$query_m1										=	mig_query($sq_m1, $db);

$sq_m3											=	"SELECT desc_equipo_movil FROM estatus_planta_diccionario_tipo_equipo_movil WHERE
													id_equipo_movil =  '$tipo_variable'";
$query_m3										=	mig_query($sq_m3, $db);
$res_m3											=	pg_fetch_array($query_m3);

?>
	<div style="width:100%; text-align:center ">
		<h5>
		DETALLE DE EQUIPO MOVIL DE PLANTA <br> EQUIPO: <?=$res_m3['desc_equipo_movil']?><br>
						Fecha: <?=$fecha_reporte_turno?> Turno: <?=$turno_reporte?>
						<br>
						Semana Nº <?=$semana_reporte?>: del <?=date('d/m/Y', $rango[0])?> al <?=date('d/m/Y', $rango[6])?>
		</h5>
		<table style="width:320px">
			<tr style="background-color:#0066CC; color:#FFFFFF; text-align:center; font-weight:bold ">
				<td style="width:20%; font-family:arialn; font-size:12px; height:8px">Gerencia</td>
				<td style="width:26%; font-family:arialn; font-size:12px; height:8px">Area Operativa </td>
				<td style="width:24%; font-family:arialn; font-size:12px; height:8px">Cant. Estandar </td>
				<td style="width:24%; font-family:arialn; font-size:12px; height:8px">Cant. Operativo </td>
			</tr>
				<?php
				$cadena_sub_areas	=	"";
				while($res_m1		=	pg_fetch_array($query_m1))
				{
						$sub_area		=	$res_m1['id_sub_area'];
						echo "<tr ";
						if ($num_fila%2==0){ 
							echo "bgcolor = 00CABF"; } //si el resto de la división es 0 pongo un color 				  
						else {                  
							echo "bgcolor= 99DDFF"; } //si el resto de la división NO es 0 pongo otro color 
						echo ">"; 
						$sq_m2		=	"SELECT cantidad_operativo FROM estaus_planta_equipo_movil 
										WHERE	
											fecha	 			= '$fecha_reporte_turno' AND
											turno 				= '$turno_reporte' AND
											sub_area 			= '$sub_area' AND
											tipo_equipo_movil	= '$tipo_variable'; ";
						if ($cadena_sub_areas == "") 	$cadena_sub_areas 	= 	$sub_area;
						else							$cadena_sub_areas	=	$cadena_sub_areas.", ".$sub_area;
						$query_m2	=	mig_query($sq_m2, $db);
						$res_m2		=	pg_fetch_array($query_m2);
						?> 
						<td style="text-align:center; font-family:arialn; font-size:12px; height:8px"><?=$res_m1['desc_area']?></td>
						<td style="text-align:center; font-family:arialn; font-size:12px; height:8px"><?=$res_m1['desc_sub_area']?></td>
						<td style="text-align:center; font-family:arialn; font-size:12px; height:8px"><?=$res_m1['cantidad_estandar']?></td>
						<td style="text-align:center; font-family:arialn; font-size:12px; height:8px"><?=$res_m2['cantidad_operativo']?></td>
					</tr>
					<?php
					$num_fila++;
				}
				$sq_m3					=	"SELECT 	estaus_planta_equipo_movil.*, estatus_planta_diccionario_area.desc_area, estatus_planta_diccionario_sub_area.desc_sub_area, 
												estatus_planta_diccionario_tipo_equipo_movil.desc_equipo_movil
											FROM estaus_planta_equipo_movil
												INNER JOIN estatus_planta_diccionario_area
													ON estaus_planta_equipo_movil.area = estatus_planta_diccionario_area.id_area
												INNER JOIN estatus_planta_diccionario_sub_area
													ON estaus_planta_equipo_movil.sub_area = estatus_planta_diccionario_sub_area.id_sub_area
												INNER JOIN estatus_planta_diccionario_tipo_equipo_movil
													ON estaus_planta_equipo_movil.tipo_equipo_movil = estatus_planta_diccionario_tipo_equipo_movil.id_equipo_movil
											WHERE sub_area NOT IN ($cadena_sub_areas)	 
											AND estaus_planta_equipo_movil.fecha = '$fecha_reporte_turno' 
											AND (estaus_planta_equipo_movil.cantidad_estandar = 0 AND estaus_planta_equipo_movil.cantidad_operativo > 0) 
											AND estaus_planta_equipo_movil.turno = '$turno_reporte' AND estaus_planta_equipo_movil.tipo_equipo_movil = '$tipo_variable';";
				$query_m3	=	mig_query($sq_m3, $db);
				while($res_m3		=	pg_fetch_array($query_m3))
				{
						echo "<tr ";
						if ($num_fila%2==0){ 
							echo "bgcolor = 00CABF"; } //si el resto de la división es 0 pongo un color 				  
						else {                  
							echo "bgcolor= 99DDFF"; } //si el resto de la división NO es 0 pongo otro color 
						echo ">"; 
						?> 
						<td style="text-align:center; font-family:arialn; font-size:12px; height:8px"><?=$res_m3['desc_area']?></td>
						<td style="text-align:center; font-family:arialn; font-size:12px; height:8px"><?=$res_m3['desc_sub_area']?></td>
						<td style="text-align:center; font-family:arialn; font-size:12px; height:8px"><?=$res_m3['cantidad_estandar']?></td>
						<td style="text-align:center; font-family:arialn; font-size:12px; height:8px"><?=$res_m3['cantidad_operativo']?></td>
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