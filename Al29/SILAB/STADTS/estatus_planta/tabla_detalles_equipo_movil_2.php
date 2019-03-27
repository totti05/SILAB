<?php
include 'conectarse.php';
$tipo_equipo									=	$_GET['tipo_equipo'];
$fecha_reporte									=	$_GET['fecha'];
$turno_reporte									=	$_GET['turno'];
$id_sub_area									=	$_GET['id_sub_area'];
$id_area										=	$_GET['id_area'];


$db												=	conectarse_postgres_taller_autom();

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


$sq_m1											=	"SELECT * FROM taller_automotriz_principal WHERE fecha = '$fecha_reporte' AND turno = '$turno_reporte'";
$query_m1										=	mig_query($sq_m1, $db);
$res_m1											=	pg_fetch_array($query_m1);
$id_registro									=	$res_m1['id_registro'];
$id_ficha										=	$res_m1['id_personal'];
$grupo_reporte									=	$res_m1['grupo'];
if ($grupo_reporte == 1)			$grupo = "A";	
if ($grupo_reporte == 2)			$grupo = "B";	
if ($grupo_reporte == 3)			$grupo = "C";	
if ($grupo_reporte == 4)			$grupo = "D";


$arreglo_tipos_equipos							=	explode(',', $tipo_equipo);
$n1												=	0;
$n_max											=	count($arreglo_tipos_equipos);

$cadena_condicional								=	"";
while($n1 < $n_max)
{
	if ($cadena_condicional == "")					$cadena_condicional	=	"taller_automotriz_diccionario_tipo_equipo_movil.id_tipo_equipo_movil = '".$arreglo_tipos_equipos[$n1]."'";
	else											$cadena_condicional	=	$cadena_condicional." OR taller_automotriz_diccionario_tipo_equipo_movil.id_tipo_equipo_movil = '".$arreglo_tipos_equipos[$n1]."'";
	$n1++;
}



$sq_m1										=	"SELECT 	taller_automotriz_diccionario_equipo.cod_equipo, 
														taller_automotriz_diccionario_equipo.id_equipo, 
														taller_automotriz_diccionario_loc_equipo.id_loc, 
														taller_automotriz_diccionario_tipo_equipo_movil.desc_tipo_equipo_movil,
														taller_automotriz_equipo_turno.operatividad_turno,
														taller_automotriz_equipo_turno.estatus_equipo_fin_turno,
														taller_automotriz_equipo_turno.prestamo_equipo, 
														taller_automotriz_equipo_turno.observacion_equipo 
													FROM 	
														taller_automotriz_diccionario_equipo, 
														taller_automotriz_diccionario_localizaciones, 
														taller_automotriz_diccionario_loc_equipo, 
														taller_automotriz_diccionario_tipo_equipo_movil,
														taller_automotriz_equipo_turno 
													WHERE 	
														taller_automotriz_diccionario_equipo.id_equipo = taller_automotriz_diccionario_loc_equipo.id_equipo AND 
														taller_automotriz_diccionario_equipo.id_tipo_equipo = taller_automotriz_diccionario_tipo_equipo_movil.id_tipo_equipo_movil AND 
														taller_automotriz_diccionario_loc_equipo.id_loc = taller_automotriz_diccionario_localizaciones.id_loc AND
														taller_automotriz_diccionario_equipo.id_equipo = taller_automotriz_equipo_turno.id_equipo AND 
														taller_automotriz_diccionario_loc_equipo.id_loc = $id_sub_area AND taller_automotriz_equipo_turno.id_registro = '$id_registro'
														AND ($cadena_condicional)";
						
$query_m1 										= 	mig_query($sq_m1, $db);



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
				<th width="19" height="31" style="width:20%; font-family:arialn; font-size:12px; height:8px">#</th>
				<th width="130" height="31" style="width:20%; font-family:arialn; font-size:12px; height:8px">Descripcion</th>
				<th width="37" style="width:20%; font-family:arialn; font-size:12px; height:8px">Estado</th>
				<th width="195" style="width:20%; font-family:arialn; font-size:12px; height:8px">Horas Uso </th>
				<th width="61" style="width:20%; font-family:arialn; font-size:12px; height:8px">Reparacion</th>
				<th width="50" style="width:20%; font-family:arialn; font-size:12px; height:8px">Sustituto</th>
				<th width="54" style="width:20%; font-family:arialn; font-size:12px; height:8px">ODT</th>
				<th width="115" style="width:20%; font-family:arialn; font-size:12px; height:8px">Observacion</th>
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
	
						$arreglo_operatividad_equipo		=	array(); 
						for ($i=0;$i<8;$i++) 
						{ 
							$arreglo_operatividad_equipo[]	=	$res_m1['operatividad_turno']{$i}; 
						} 	
						if ($res_m1['prestamo_equipo']  == 1)
						{
							$sq_m2							=	"SELECT 
																	taller_automotriz_prestamo_equipo.id_registro, 
																	taller_automotriz_prestamo_equipo.id_equipo, 
																	taller_automotriz_prestamo_equipo.id_equipo_remplazo, 
																	taller_automotriz_diccionario_equipo.cod_equipo AS cod_equipo_sustituto
																FROM 
																	taller_automotriz_prestamo_equipo, 
																	taller_automotriz_diccionario_equipo
																WHERE 
																	taller_automotriz_prestamo_equipo.id_equipo_remplazo = taller_automotriz_diccionario_equipo.id_equipo 
																	AND id_registro = '$id_registro' AND taller_automotriz_prestamo_equipo.id_equipo = '$res_m1[id_equipo]';";
							$query_m2						=	mig_query($sq_m2, $db);
							$res_m2							=	pg_fetch_array($query_m2);
							$cod_equipo_sustituto			=	$res_m2['cod_equipo_sustituto'];
							$id_equipo_sustituto			=	$res_m2['id_equipo_remplazo'];
						}
						if ($res_m1['estatus_equipo_fin_turno'] == 0)
						{
							$sq_m3							=	"SELECT 
																	taller_automotriz_equipo_reparacion.tipo_reparacion, 
																	taller_automotriz_equipo_reparacion.cod_odt_sima, 
																	taller_automotriz_equipo_reparacion.estatus_odt_sima
																FROM 
																	taller_automotriz_equipo_reparacion
																WHERE 
																	taller_automotriz_equipo_reparacion.id_registro = '$id_registro' AND 
																	taller_automotriz_equipo_reparacion.id_equipo = '$res_m1[id_equipo]';";
							$query_m3						=	mig_query($sq_m3, $db);
							$res_m3							=	pg_fetch_array($query_m3);
							$tip_reparac					=	$res_m3['tipo_reparacion'];
							$odt_sima						=	$res_m3['cod_odt_sima'];
							
							$tipo_rep	=	"-----";
							if ($tip_reparac == 1) 		$tipo_rep	=	"Mayor";
							if ($tip_reparac == 2) 		$tipo_rep	=	"Menor";
						}
						else
						{
							$tipo_rep	=	"-----";
						}
						?> 
							<td height="22" style="text-align:center; font-family:arialn; font-size:10px; height:8px"><?=$res_m1['cod_equipo']?></td>
							<td style="text-align:center; font-family:arialn; font-size:10px; height:8px"><?=$res_m1['desc_tipo_equipo_movil']?></td>
							<td style="text-align:center; font-family:arialn; font-size:10px; height:8px" >
								<?php 
									echo coloca_dibjuo_checkbox($res_m1['estatus_equipo_fin_turno']);
								?>
							</td>
							<td style="text-align:center; font-family:arialn; font-size:10px; height:8px">
								<?php
									echo coloca_dibjuo_checkbox($arreglo_operatividad_equipo[0]);
									echo "&nbsp;&nbsp;";
									echo coloca_dibjuo_checkbox($arreglo_operatividad_equipo[1]);
									echo "&nbsp;&nbsp;";
									echo coloca_dibjuo_checkbox($arreglo_operatividad_equipo[2]);
									echo "&nbsp;&nbsp;";
									echo coloca_dibjuo_checkbox($arreglo_operatividad_equipo[3]);
									echo "&nbsp;&nbsp;";
									echo coloca_dibjuo_checkbox($arreglo_operatividad_equipo[4]);
									echo "&nbsp;&nbsp;";
									echo coloca_dibjuo_checkbox($arreglo_operatividad_equipo[5]);
									echo "&nbsp;&nbsp;";
									echo coloca_dibjuo_checkbox($arreglo_operatividad_equipo[6]);
									echo "&nbsp;&nbsp;";
									echo coloca_dibjuo_checkbox($arreglo_operatividad_equipo[7]);
									echo "&nbsp;&nbsp;";
								?>
							</td>							
							<td style="text-align:center; font-family:arialn; font-size:10px; height:8px" ><?php if ($tipo_rep == "") echo "-----"; else echo $tipo_rep;?></td>
							<td style="text-align:center; font-family:arialn; font-size:10px; height:8px" ><?php if ($cod_equipo_sustituto == "") echo "-----"; else echo $cod_equipo_sustituto;?></td>
							<td style="text-align:center; font-family:arialn; font-size:10px; height:8px" ><?php if ($odt_sima == "") echo "-----"; else echo $odt_sima;?></td>
							<td style="text-align:center; font-family:arialn; font-size:10px; height:8px"><?php if ($res_m1['observacion_equipo'] == "") echo "-----"; else echo $res_m1['observacion_equipo'];?></td>
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

function coloca_dibjuo_checkbox($variable_control)
{
	if ($variable_control == 1)	$resultado	=	"<img src='http://control/scp/modules/taller_automotriz/imagenes/casilla_cheq.JPG'/>";
	if ($variable_control == 0)	$resultado	=	"<img src='http://control/scp/modules/taller_automotriz/imagenes/casilla_no_cheq.JPG'/>";
	return $resultado;
}


?>