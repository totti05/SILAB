<?php
include 'conectarse.php';
$tipo_variable		=	$_GET['tipo_variable'];
$fecha_reporte		=	$_GET['fecha_reporte'];
$turno_reporte		=	$_GET['turno_reporte'];
$tipo_consulta		=	$_GET['tipo_consulta'];

$db					=	conectarse_postgres();

$sq_m1				=	"SELECT estaus_planta_equipo_movil.*, estatus_planta_diccionario_sub_area.desc_sub_area 
						FROM estaus_planta_equipo_movil INNER JOIN estatus_planta_diccionario_sub_area 
						ON estaus_planta_equipo_movil.sub_area = estatus_planta_diccionario_sub_area.id_sub_area
						WHERE estaus_planta_equipo_movil.fecha = '$fecha_reporte' AND estaus_planta_equipo_movil.turno = '$turno_reporte' 
						AND estaus_planta_equipo_movil.tipo_equipo_movil = '$tipo_variable' AND estaus_planta_equipo_movil.area = '1'";
$sq_m2				=	"SELECT estaus_planta_equipo_movil.*, estatus_planta_diccionario_sub_area.desc_sub_area 
						FROM estaus_planta_equipo_movil INNER JOIN estatus_planta_diccionario_sub_area 
						ON estaus_planta_equipo_movil.sub_area = estatus_planta_diccionario_sub_area.id_sub_area
						WHERE estaus_planta_equipo_movil.fecha = '$fecha_reporte' AND estaus_planta_equipo_movil.turno = '$turno_reporte' 
						AND estaus_planta_equipo_movil.tipo_equipo_movil = '$tipo_variable' AND estaus_planta_equipo_movil.area = '2'";
$sq_m3				=	"SELECT estaus_planta_equipo_movil.*, estatus_planta_diccionario_sub_area.desc_sub_area 
						FROM estaus_planta_equipo_movil INNER JOIN estatus_planta_diccionario_sub_area 
						ON estaus_planta_equipo_movil.sub_area = estatus_planta_diccionario_sub_area.id_sub_area
						WHERE estaus_planta_equipo_movil.fecha = '$fecha_reporte' AND estaus_planta_equipo_movil.turno = '$turno_reporte' 
						AND estaus_planta_equipo_movil.tipo_equipo_movil = '$tipo_variable' AND estaus_planta_equipo_movil.area = '3'";
$query_m1			=	mig_query($sq_m1, $db);
$query_m2			=	mig_query($sq_m2, $db);
$query_m3			=	mig_query($sq_m3, $db);

if  ($tipo_variable == 1) $titulo_equipo_movil = "MONTACARGA";
if  ($tipo_variable == 2) $titulo_equipo_movil = "REMOLCADOR";
if  ($tipo_variable == 3) $titulo_equipo_movil = "SKYPER";
if  ($tipo_variable == 4) $titulo_equipo_movil = "PAYLOADER";
if  ($tipo_variable == 5) $titulo_equipo_movil = "CAMION";

?>
	<div style="width:100%; text-align:center ">
		<h5>
		DETALLE DE EQUIPO MOVIL DE PLANTA <br> EQUIPO: <?=$titulo_equipo_movil?><br>
						Fecha: <?=$fecha_reporte?> Turno: <?=$turno_reporte?>
						<br>
						Semana Nº <?=$semana_reporte?>: del <?=date('d/m/Y', $rango[0])?> al <?=date('d/m/Y', $rango[6])?>
		</h5>
		<table style="width:320px">
			<tr style="background-color:#0066CC; color:#FFFFFF; text-align:center; font-weight:bold ">
				<td style="width:20%; font-family:arialn; font-size:12px; height:8px">Area Operativa </td>
				<td style="width:27%; font-family:arialn; font-size:12px; height:8px">Cantidad Estandar </td>
				<td style="width:27%; font-family:arialn; font-size:12px; height:8px">Cantidad Operativo </td>
				<?php
				while($res_m1		=	pg_fetch_array($query_m1))
				{
						echo "<tr ";
						if ($num_fila%2==0){ 
							echo "bgcolor = 00CABF"; } //si el resto de la división es 0 pongo un color 				  
						else {                  
							echo "bgcolor= 99DDFF"; } //si el resto de la división NO es 0 pongo otro color 
						echo ">"; ?> 
						<td style="text-align:center; font-family:arialn; font-size:12px; height:8px"><?=$res_m1['desc_sub_area']?></td>
						<td style="text-align:center; font-family:arialn; font-size:12px; height:8px"><?=$res_m1['cantidad_estandar']?></td>
						<td style="text-align:center; font-family:arialn; font-size:12px; height:8px"><?=$res_m1['cantidad_operativo']?></td>
					</tr>
					<?php
					$num_fila++;
				}
				?>
				<?php
				while($res_m2		=	pg_fetch_array($query_m2))
				{
						echo "<tr ";
						if ($num_fila%2==0){ 
							echo "bgcolor = 00CABF"; } //si el resto de la división es 0 pongo un color 				  
						else {                  
							echo "bgcolor= 99DDFF"; } //si el resto de la división NO es 0 pongo otro color 
						echo ">"; ?> 
						<td style="text-align:center; font-family:arialn; font-size:12px; height:8px"><?=$res_m2['desc_sub_area']?></td>
						<td style="text-align:center; font-family:arialn; font-size:12px; height:8px"><?=$res_m2['cantidad_estandar']?></td>
						<td style="text-align:center; font-family:arialn; font-size:12px; height:8px"><?=$res_m2['cantidad_operativo']?></td>
					</tr>
					<?php
					$num_fila++;
				}
				?>
				<?php
				while($res_m3		=	pg_fetch_array($query_m3))
				{
						echo "<tr ";
						if ($num_fila%2==0){ 
							echo "bgcolor = 00CABF"; } //si el resto de la división es 0 pongo un color 				  
						else {                  
							echo "bgcolor= 99DDFF"; } //si el resto de la división NO es 0 pongo otro color 
						echo ">"; ?> 
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