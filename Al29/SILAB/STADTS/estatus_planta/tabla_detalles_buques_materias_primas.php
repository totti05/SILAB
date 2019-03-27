<?php
include 'conectarse.php';
$tipo_variable		=	$_GET['tipo_variable'];

$db					=	conectarse_postgres();

$sq_m1				=	"SELECT * FROM estatus_planta_buques_transito WHERE tipo_material = '$tipo_variable'";
$query_m1			=	mig_query($sq_m1, $db);
$res_m1				=	pg_fetch_array($query_m1);
if  ($tipo_variable == 2) $materia_prima = "CRIOLITA";
if  ($tipo_variable == 3) $materia_prima = "FLORURO DE ALUMINIO";
if  ($tipo_variable == 4) $materia_prima = "COQUE METALÚRGIO";
if  ($tipo_variable == 5) $materia_prima = "COQUE DE PETRÓLEO";
if  ($tipo_variable == 6) $materia_prima = "BREA DE ALQUITRÁN";
if  ($tipo_variable == 7) $materia_prima = "ARRABIO";

?>
	<div style="width:100%; text-align:center ">
		<h5>
		DETALLE DE BUQUES EN TRÁNSITO DE MATERIAS PRIMAS <br> MATERIAL: <?=$materia_prima?><br>
		</h5>
		<?php
		if ($res_m1['cantidad_material'] > 0)
		{
			?>
				<table style="width:320px">
					<tr style="background-color:#0066CC; color:#FFFFFF; text-align:center; font-weight:bold ">
						<td style="width:20%; font-family:arialn; font-size:12px; height:8px">Nombre Buque </td>
						<td style="width:27%; font-family:arialn; font-size:12px; height:8px">Fecha Atraque </td>
						<td style="width:27%; font-family:arialn; font-size:12px; height:8px">Cantidad Material </td>
					</tr>
					<tr style="background-color:#99DDFF; text-align:center; ">
						<td style="width:20%; font-family:arialn; font-size:12px; height:8px"><?=$res_m1['nombre_buque']?></td>
						<td style="width:27%; font-family:arialn; font-size:12px; height:8px"><?=$res_m1['fecha_atraque']?></td>
						<td style="width:27%; font-family:arialn; font-size:12px; height:8px"><?=$res_m1['cantidad_material']?></td>
					</tr>
					<tr style="background-color:#0066CC; color:#FFFFFF; text-align:center; font-weight:bold ">
						<td style="width:20%; font-family:arialn; font-size:12px; height:8px" colspan="3">Observación</td>
					</tr>
					<tr style="background-color:#99DDFF; text-align:center;">
						<td style="width:20%; font-family:arialn; font-size:12px; height:8px" colspan="3"><?=$res_m1['observacion_registro']?></td>
					</tr>
				</table>
			<?php
		}
		else
			echo "<h5>No se Encontraron valores Solicitados</h5>"
		?>
	</div>
<?php
pg_close($db);

?>