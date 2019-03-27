<?php
include 'conectarse.php';
$tipo_variable									=	$_GET['tipo_variable'];
$fecha_reporte									=	$_GET['fecha_reporte'];
$turno_reporte									=	$_GET['turno_reporte'];

$db												=	conectarse_postgres();

$fecha_reporte_turno							=	$fecha_reporte;
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

$sq_m1											=	"SELECT 	estaus_planta_equipo_movil.cantidad_estandar, 
														estaus_planta_equipo_movil.cantidad_operativo,
														estaus_planta_equipo_movil.cantidad_prestamo,  
														estaus_planta_equipo_movil.sub_area, 
														estaus_planta_equipo_movil.tipo_equipo_movil,
														estatus_planta_diccionario_sub_area.desc_sub_area,
														estatus_planta_diccionario_area.desc_area,
														estatus_planta_diccionario_sub_area_estatus_planta_taller.id_sub_area_taller_automotriz,
														estatus_planta_diccionario_sub_area_estatus_planta_taller.id_area_taller_automotriz
													FROM 
														estaus_planta_equipo_movil,
														estatus_planta_diccionario_sub_area,
														estatus_planta_diccionario_area,
														estatus_planta_diccionario_sub_area_estatus_planta_taller
													WHERE
														estaus_planta_equipo_movil.sub_area			=	estatus_planta_diccionario_sub_area.id_sub_area	AND
														estatus_planta_diccionario_sub_area.id_area	=	estatus_planta_diccionario_area.id_area		 AND
														estaus_planta_equipo_movil.sub_area		=	estatus_planta_diccionario_sub_area_estatus_planta_taller.id_sub_area_estatus_planta AND
														fecha = '$fecha_reporte' AND turno = '$turno_reporte' AND tipo_equipo_movil = '$tipo_variable' 
														
													ORDER BY 
														estatus_planta_diccionario_sub_area.id_area,
														estaus_planta_equipo_movil.sub_area;";
$query_m1										=	mig_query($sq_m1, $db);

$sq_m3											=	"SELECT desc_equipo_movil FROM estatus_planta_diccionario_tipo_equipo_movil WHERE
													id_equipo_movil =  '$tipo_variable'";
$query_m3										=	mig_query($sq_m3, $db);
$res_m3											=	pg_fetch_array($query_m3);

$sq_m4											=	"SELECT id_tipo_equipo_taller FROM estatus_planta_diccionario_tipo_equipo_estatus_planta_taller 
													WHERE id_tipo_equipo_estatus_planta = '$tipo_variable';";
$query_m4										=	mig_query($sq_m4, $db);
$cadena_tipo_equipo_taller						=	"";
while($res_m4	=	pg_fetch_array($query_m4))	
{
	if ($cadena_tipo_equipo_taller == "")	$cadena_tipo_equipo_taller 	=	$res_m4['id_tipo_equipo_taller'];
	else									$cadena_tipo_equipo_taller 	=	$cadena_tipo_equipo_taller.",".$res_m4['id_tipo_equipo_taller'];
}
$cadena_tipo_equipo = $cadena_tipo_equipo_taller;
?>
	<div style="width:100%; text-align:center ">
		<h5>
		DETALLE DE EQUIPO MOVIL DE PLANTA <br> EQUIPO: <?=$res_m3['desc_equipo_movil']?><br>
						Fecha: <?=$fecha_reporte_turno?> Turno: <?=$turno_reporte?>
						<br>
						Semana Nº <?=$semana_reporte?>: del <?=date('d/m/Y', $rango[0])?> al <?=date('d/m/Y', $rango[6])?>
		</h5>
		<table style="width:420px">
			<tr style="background-color:#0066CC; color:#FFFFFF; text-align:center; font-weight:bold ">
				<td style="width:20%; font-family:arialn; font-size:12px; height:8px">Gerencia</td>
				<td style="width:26%; font-family:arialn; font-size:12px; height:8px">Area Operativa </td>
				<td style="width:24%; font-family:arialn; font-size:12px; height:8px">Cant. Estandar </td>
				<td style="width:24%; font-family:arialn; font-size:12px; height:8px">Cant. Operativo </td>
				<td style="width:24%; font-family:arialn; font-size:12px; height:8px">Cant. Prestamos </td>
				<td style="width:24%; font-family:arialn; font-size:12px; height:8px">Ver Sist.Taller </td>
			</tr>
				<?php
				$cadena_sub_areas	=	"";
				while($res_m1		=	pg_fetch_array($query_m1))
				{
						echo "<tr ";
						if ($num_fila%2==0){ 
							echo "bgcolor = 00CABF"; } //si el resto de la división es 0 pongo un color 				  
						else {                  
							echo "bgcolor= 99DDFF"; } //si el resto de la división NO es 0 pongo otro color 
						echo ">"; 
						$id_sub_area		=	$res_m1['id_sub_area_taller_automotriz'];
						$id_area			=	$res_m1['id_area_taller_automotriz'];
						?> 
						<td style="text-align:center; font-family:arialn; font-size:12px; height:8px"><?=$res_m1['desc_area']?></td>
						<td style="text-align:center; font-family:arialn; font-size:12px; height:8px"><?=$res_m1['desc_sub_area']?></td>
						<td style="text-align:center; font-family:arialn; font-size:12px; height:8px"><?=$res_m1['cantidad_estandar']?></td>
						<td style="text-align:center; font-family:arialn; font-size:12px; height:8px"><?=$res_m1['cantidad_operativo']?></td>
						<td style="text-align:center; font-family:arialn; font-size:12px; height:8px"><?=$res_m1['cantidad_prestamo']?></td>
						<td style="text-align:center; font-family:arialn; font-size:12px; height:8px">
							<a href="tabla_detalles_equipo_movil_2.php?id_sub_area=<?=$id_sub_area?>&fecha=<?=$fecha_reporte?>&turno=<?=$turno_reporte?>&tipo_equipo=<?php echo $cadena_tipo_equipo?>">Ver Detalle</a>
						</td>
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