<?php 
include 'conectarse.php';

$db						=	conectarse_postgres();

$sq_m0					=	"SELECT current_date AS fecha";
$query_m0				=	mig_query($sq_m0, $db);	
$res_m0					=	pg_fetch_array($query_m0);


$fecha_hoy				=	$res_m0['fecha'];
list($a, $m, $d)		=	split('-', $fecha_hoy);
$fecha					=	"$d/$m/$a";

$turno					=	"2";

$sq_redu_observ_1		=	"SELECT * FROM estatus_planta_observaciones WHERE fecha = '$fecha' AND turno = '$turno' AND id_area = '1' AND id_sub_area = '6'";
$sq_redu_observ_2		=	"SELECT * FROM estatus_planta_observaciones WHERE fecha = '$fecha' AND turno = '$turno' AND id_area = '1' AND id_sub_area = '7'";
$sq_redu_observ_3		=	"SELECT * FROM estatus_planta_observaciones WHERE fecha = '$fecha' AND turno = '$turno' AND id_area = '1' AND id_sub_area = '8'";
$sq_redu_observ_4		=	"SELECT * FROM estatus_planta_observaciones WHERE fecha = '$fecha' AND turno = '$turno' AND id_area = '1' AND id_sub_area = '9'";
$sq_redu_observ_5		=	"SELECT * FROM estatus_planta_observaciones WHERE fecha = '$fecha' AND turno = '$turno' AND id_area = '1' AND id_sub_area = '10'";

$sq_carb_observ_1		=	"SELECT * FROM estatus_planta_observaciones WHERE fecha = '$fecha' AND turno = '$turno' AND id_area = '2' AND id_sub_area = '2'";
$sq_carb_observ_2		=	"SELECT * FROM estatus_planta_observaciones WHERE fecha = '$fecha' AND turno = '$turno' AND id_area = '2' AND id_sub_area = '3'";
$sq_carb_observ_3		=	"SELECT * FROM estatus_planta_observaciones WHERE fecha = '$fecha' AND turno = '$turno' AND id_area = '2' AND id_sub_area = '4'";
$sq_carb_observ_4		=	"SELECT * FROM estatus_planta_observaciones WHERE fecha = '$fecha' AND turno = '$turno' AND id_area = '2' AND id_sub_area = '16'";
$sq_carb_observ_5		=	"SELECT * FROM estatus_planta_observaciones WHERE fecha = '$fecha' AND turno = '$turno' AND id_area = '2' AND id_sub_area = '17'";

$sq_cola_observ_1		=	"SELECT * FROM estatus_planta_observaciones WHERE fecha = '$fecha' AND turno = '$turno' AND id_area = '3' AND id_sub_area = '12'";
$sq_cola_observ_2		=	"SELECT * FROM estatus_planta_observaciones WHERE fecha = '$fecha' AND turno = '$turno' AND id_area = '3' AND id_sub_area = '13'";
$sq_cola_observ_3		=	"SELECT * FROM estatus_planta_observaciones WHERE fecha = '$fecha' AND turno = '$turno' AND id_area = '3' AND id_sub_area = '14'";
$sq_cola_observ_4		=	"SELECT * FROM estatus_planta_observaciones WHERE fecha = '$fecha' AND turno = '$turno' AND id_area = '3' AND id_sub_area = '18'";

$sq_scp_observ_1		=	"SELECT * FROM estatus_planta_observaciones WHERE fecha = '$fecha' AND turno = '$turno' AND id_area = '4' AND id_sub_area = '11'";

$sq_mantt_observ_1		=	"SELECT * FROM estatus_planta_observaciones WHERE fecha = '$fecha' AND turno = '$turno' AND id_area = '6' AND id_sub_area = '35'";
$sq_mantt_observ_2		=	"SELECT * FROM estatus_planta_observaciones WHERE fecha = '$fecha' AND turno = '$turno' AND id_area = '6' AND id_sub_area = '36'";
$sq_mantt_observ_3		=	"SELECT * FROM estatus_planta_observaciones WHERE fecha = '$fecha' AND turno = '$turno' AND id_area = '6' AND id_sub_area = '37'";


$query_redu_observ_1	=	mig_query($sq_redu_observ_1, $db);
$query_redu_observ_2	=	mig_query($sq_redu_observ_2, $db);
$query_redu_observ_3	=	mig_query($sq_redu_observ_3, $db);
$query_redu_observ_4	=	mig_query($sq_redu_observ_4, $db);
$query_redu_observ_5	=	mig_query($sq_redu_observ_5, $db);

$query_carb_observ_1	=	mig_query($sq_carb_observ_1, $db);
$query_carb_observ_2	=	mig_query($sq_carb_observ_2, $db);
$query_carb_observ_3	=	mig_query($sq_carb_observ_3, $db);
$query_carb_observ_4	=	mig_query($sq_carb_observ_4, $db);
$query_carb_observ_5	=	mig_query($sq_carb_observ_5, $db);

$query_cola_observ_1	=	mig_query($sq_cola_observ_1, $db);
$query_cola_observ_2	=	mig_query($sq_cola_observ_2, $db);
$query_cola_observ_3	=	mig_query($sq_cola_observ_3, $db);
$query_cola_observ_4	=	mig_query($sq_cola_observ_4, $db);

$query_scp_observ_1		=	mig_query($sq_scp_observ_1, $db);

$query_mantt_observ_1	=	mig_query($sq_mantt_observ_1, $db);
$query_mantt_observ_2	=	mig_query($sq_mantt_observ_2, $db);
$query_mantt_observ_3	=	mig_query($sq_mantt_observ_3, $db);

$res_redu_observ_1		=	pg_fetch_array($query_redu_observ_1);
$res_redu_observ_2		=	pg_fetch_array($query_redu_observ_2);
$res_redu_observ_3		=	pg_fetch_array($query_redu_observ_3);
$res_redu_observ_4		=	pg_fetch_array($query_redu_observ_4);
$res_redu_observ_5		=	pg_fetch_array($query_redu_observ_5);

$res_carb_observ_1		=	pg_fetch_array($query_carb_observ_1);
$res_carb_observ_2		=	pg_fetch_array($query_carb_observ_2);
$res_carb_observ_3		=	pg_fetch_array($query_carb_observ_3);
$res_carb_observ_4		=	pg_fetch_array($query_carb_observ_4);
$res_carb_observ_5		=	pg_fetch_array($query_carb_observ_5);

$res_cola_observ_1		=	pg_fetch_array($query_cola_observ_1);
$res_cola_observ_2		=	pg_fetch_array($query_cola_observ_2);
$res_cola_observ_3		=	pg_fetch_array($query_cola_observ_3);
$res_cola_observ_4		=	pg_fetch_array($query_cola_observ_4);

$res_mantt_observ_1		=	pg_fetch_array($query_mantt_observ_1);
$res_mantt_observ_2		=	pg_fetch_array($query_mantt_observ_2);
$res_mantt_observ_3		=	pg_fetch_array($query_mantt_observ_3);



$hora_act				=	date("H", time()).":".date("i", time()).":".date("s", time());
$observ_estandar		=	"El responsable del área no cargo la información";
////////////////////////////////////////////////observaciones reduccion

if (pg_num_rows($query_redu_observ_1) == 0)
{
	$sq_m1				=	"INSERT INTO estatus_planta_observaciones (fecha, observacion, id_area, id_sub_area, num_observacion, turno, fecha_creacion, hora_creacion)
							VALUES
							('$fecha', '$observ_estandar', '1', '6', '1', '$turno', '$fecha', '$hora_act')";
	$query_m1			=	mig_query($sq_m1, $db);
}
if ($res_redu_observ_1['observacion'] == "")
{
	$sq_m1				=	"UPDATE estatus_planta_observaciones SET observacion = '$observ_estandar', fecha_creacion = '$fecha', hora_creacion = '$hora_act', num_observacion = '1'
							WHERE fecha = '$fecha' AND id_area = '1' AND id_sub_area = '6' AND turno = '$turno';";
	$query_m1			=	mig_query($sq_m1, $db);
}
/////////
if (pg_num_rows($query_redu_observ_2) == 0)
{
	$sq_m1				=	"INSERT INTO estatus_planta_observaciones (fecha, observacion, id_area, id_sub_area, num_observacion, turno, fecha_creacion, hora_creacion)
							VALUES
							('$fecha', '$observ_estandar', '1', '7', '1', '$turno', '$fecha', '$hora_act')";
	$query_m1			=	mig_query($sq_m1, $db);
}
if ($res_redu_observ_2['observacion'] == "")
{
	$sq_m1				=	"UPDATE estatus_planta_observaciones SET observacion = '$observ_estandar', fecha_creacion = '$fecha', hora_creacion = '$hora_act', num_observacion = '1'
							WHERE fecha = '$fecha' AND id_area = '1' AND id_sub_area = '7' AND turno = '$turno';";
	$query_m1			=	mig_query($sq_m1, $db);
}
////////
if (pg_num_rows($query_redu_observ_3) == 0)
{
	$sq_m1				=	"INSERT INTO estatus_planta_observaciones (fecha, observacion, id_area, id_sub_area, num_observacion, turno, fecha_creacion, hora_creacion)
							VALUES
							('$fecha', '$observ_estandar', '1', '8', '1', '$turno', '$fecha', '$hora_act')";
	$query_m1			=	mig_query($sq_m1, $db);
}
if ($res_redu_observ_3['observacion'] == "")
{
	$sq_m1				=	"UPDATE estatus_planta_observaciones SET observacion = '$observ_estandar', fecha_creacion = '$fecha', hora_creacion = '$hora_act', num_observacion = '1'
							WHERE fecha = '$fecha' AND id_area = '1' AND id_sub_area = '8' AND turno = '$turno';";
	$query_m1			=	mig_query($sq_m1, $db);
}
////////
if (pg_num_rows($query_redu_observ_4) == 0)
{
	$sq_m1				=	"INSERT INTO estatus_planta_observaciones (fecha, observacion, id_area, id_sub_area, num_observacion, turno, fecha_creacion, hora_creacion)
							VALUES
							('$fecha', '$observ_estandar', '1', '9', '1', '$turno', '$fecha', '$hora_act')";
	$query_m1			=	mig_query($sq_m1, $db);
}
if ($res_redu_observ_4['observacion'] == "")
{
	$sq_m1				=	"UPDATE estatus_planta_observaciones SET observacion = '$observ_estandar', fecha_creacion = '$fecha', hora_creacion = '$hora_act', num_observacion = '1'
							WHERE fecha = '$fecha' AND id_area = '1' AND id_sub_area = '9' AND turno = '$turno';";
	$query_m1			=	mig_query($sq_m1, $db);
}
////////
if (pg_num_rows($query_redu_observ_5) == 0)
{
	$sq_m1				=	"INSERT INTO estatus_planta_observaciones (fecha, observacion, id_area, id_sub_area, num_observacion, turno, fecha_creacion, hora_creacion)
							VALUES
							('$fecha', '$observ_estandar', '1', '10', '1', '$turno', '$fecha', '$hora_act')";
	$query_m1			=	mig_query($sq_m1, $db);
}
if ($res_redu_observ_5['observacion'] == "")
{
	$sq_m1				=	"UPDATE estatus_planta_observaciones SET observacion = '$observ_estandar', fecha_creacion = '$fecha', hora_creacion = '$hora_act', num_observacion = '1'
							WHERE fecha = '$fecha' AND id_area = '1' AND id_sub_area = '10' AND turno = '$turno';";
	$query_m1			=	mig_query($sq_m1, $db);
}
////////////////////////////////////////////////observaciones carbon
if (pg_num_rows($query_carb_observ_1) == 0)
{
	$sq_m1				=	"INSERT INTO estatus_planta_observaciones (fecha, observacion, id_area, id_sub_area, num_observacion, turno, fecha_creacion, hora_creacion)
							VALUES
							('$fecha', '$observ_estandar', '2', '2', '1', '$turno', '$fecha', '$hora_act')";
	$query_m1			=	mig_query($sq_m1, $db);
}
if ($res_carb_observ_1['observacion'] == "")
{
	$sq_m1				=	"UPDATE estatus_planta_observaciones SET observacion = '$observ_estandar', fecha_creacion = '$fecha', hora_creacion = '$hora_act', num_observacion = '1'
							WHERE fecha = '$fecha' AND id_area = '2' AND id_sub_area = '2' AND turno = '$turno';";
	$query_m1			=	mig_query($sq_m1, $db);
}
////////
if (pg_num_rows($query_carb_observ_2) == 0)
{
	$sq_m1				=	"INSERT INTO estatus_planta_observaciones (fecha, observacion, id_area, id_sub_area, num_observacion, turno, fecha_creacion, hora_creacion)
							VALUES
							('$fecha', '$observ_estandar', '2', '3', '1', '$turno', '$fecha', '$hora_act')";
	$query_m1			=	mig_query($sq_m1, $db);
}
if ($res_carb_observ_2['observacion'] == "")
{
	$sq_m1				=	"UPDATE estatus_planta_observaciones SET observacion = '$observ_estandar', fecha_creacion = '$fecha', hora_creacion = '$hora_act', num_observacion = '1'
							WHERE fecha = '$fecha' AND id_area = '2' AND id_sub_area = '3' AND turno = '$turno';";
	$query_m1			=	mig_query($sq_m1, $db);
}
////////
if (pg_num_rows($query_carb_observ_3) == 0)
{
	$sq_m1				=	"INSERT INTO estatus_planta_observaciones (fecha, observacion, id_area, id_sub_area, num_observacion, turno, fecha_creacion, hora_creacion)
							VALUES
							('$fecha', '$observ_estandar', '2', '4', '1', '$turno', '$fecha', '$hora_act')";
	$query_m1			=	mig_query($sq_m1, $db);
}
if ($res_carb_observ_3['observacion'] == "")
{
	$sq_m1				=	"UPDATE estatus_planta_observaciones SET observacion = '$observ_estandar', fecha_creacion = '$fecha', hora_creacion = '$hora_act', num_observacion = '1'
							WHERE fecha = '$fecha' AND id_area = '2' AND id_sub_area = '4' AND turno = '$turno';";
	$query_m1			=	mig_query($sq_m1, $db);
}
////////
if (pg_num_rows($query_carb_observ_4) == 0)
{
	$sq_m1				=	"INSERT INTO estatus_planta_observaciones (fecha, observacion, id_area, id_sub_area, num_observacion, turno, fecha_creacion, hora_creacion)
							VALUES
							('$fecha', '$observ_estandar', '2', '16', '1', '$turno', '$fecha', '$hora_act')";
	$query_m1			=	mig_query($sq_m1, $db);
}
if ($res_carb_observ_4['observacion'] == "")
{
	$sq_m1				=	"UPDATE estatus_planta_observaciones SET observacion = '$observ_estandar', fecha_creacion = '$fecha', hora_creacion = '$hora_act', num_observacion = '1'
							WHERE fecha = '$fecha' AND id_area = '2' AND id_sub_area = '16' AND turno = '$turno';";
	$query_m1			=	mig_query($sq_m1, $db);
}
////////
if (pg_num_rows($query_carb_observ_5) == 0)
{
	$sq_m1				=	"INSERT INTO estatus_planta_observaciones (fecha, observacion, id_area, id_sub_area, num_observacion, turno, fecha_creacion, hora_creacion)
							VALUES
							('$fecha', '$observ_estandar', '2', '17', '1', '$turno', '$fecha', '$hora_act')";
	$query_m1			=	mig_query($sq_m1, $db);
}
if ($res_carb_observ_5['observacion'] == "")
{
	$sq_m1				=	"UPDATE estatus_planta_observaciones SET observacion = '$observ_estandar', fecha_creacion = '$fecha', hora_creacion = '$hora_act', num_observacion = '1'
							WHERE fecha = '$fecha' AND id_area = '2' AND id_sub_area = '17' AND turno = '$turno';";
	$query_m1			=	mig_query($sq_m1, $db);
}
////////////////////////////////////////////////observaciones colada
if (pg_num_rows($query_cola_observ_1) == 0)
{
	$sq_m1				=	"INSERT INTO estatus_planta_observaciones (fecha, observacion, id_area, id_sub_area, num_observacion, turno, fecha_creacion, hora_creacion)
							VALUES
							('$fecha', '$observ_estandar', '3', '12', '1', '$turno', '$fecha', '$hora_act')";
	$query_m1			=	mig_query($sq_m1, $db);
}
if ($res_cola_observ_1['observacion'] == "")
{
	$sq_m1				=	"UPDATE estatus_planta_observaciones SET observacion = '$observ_estandar', fecha_creacion = '$fecha', hora_creacion = '$hora_act', num_observacion = '1'
							WHERE fecha = '$fecha' AND id_area = '3' AND id_sub_area = '12' AND turno = '$turno';";
	$query_m1			=	mig_query($sq_m1, $db);
}
////////
if (pg_num_rows($query_cola_observ_2) == 0)
{
	$sq_m1				=	"INSERT INTO estatus_planta_observaciones (fecha, observacion, id_area, id_sub_area, num_observacion, turno, fecha_creacion, hora_creacion)
							VALUES
							('$fecha', '$observ_estandar', '3', '13', '1', '$turno', '$fecha', '$hora_act')";
	$query_m1			=	mig_query($sq_m1, $db);
}
if ($res_cola_observ_2['observacion'] == "")
{
	$sq_m1				=	"UPDATE estatus_planta_observaciones SET observacion = '$observ_estandar', fecha_creacion = '$fecha', hora_creacion = '$hora_act', num_observacion = '1'
							WHERE fecha = '$fecha' AND id_area = '3' AND id_sub_area = '13' AND turno = '$turno';";
	$query_m1			=	mig_query($sq_m1, $db);
}
////////
if (pg_num_rows($query_cola_observ_3) == 0)
{
	$sq_m1				=	"INSERT INTO estatus_planta_observaciones (fecha, observacion, id_area, id_sub_area, num_observacion, turno, fecha_creacion, hora_creacion)
							VALUES
							('$fecha', '$observ_estandar', '3', '14', '1', '$turno', '$fecha', '$hora_act')";
	$query_m1			=	mig_query($sq_m1, $db);
}
if ($res_cola_observ_3['observacion'] == "")
{
	$sq_m1				=	"UPDATE estatus_planta_observaciones SET observacion = '$observ_estandar', fecha_creacion = '$fecha', hora_creacion = '$hora_act', num_observacion = '1'
							WHERE fecha = '$fecha' AND id_area = '3' AND id_sub_area = '14' AND turno = '$turno';";
	$query_m1			=	mig_query($sq_m1, $db);
}
////////
if (pg_num_rows($query_cola_observ_4) == 0)
{
	$sq_m1				=	"INSERT INTO estatus_planta_observaciones (fecha, observacion, id_area, id_sub_area, num_observacion, turno, fecha_creacion, hora_creacion)
							VALUES
							('$fecha', '$observ_estandar', '3', '18', '1', '$turno', '$fecha', '$hora_act')";
	$query_m1			=	mig_query($sq_m1, $db);
}
if ($res_cola_observ_4['observacion'] == "")
{
	$sq_m1				=	"UPDATE estatus_planta_observaciones SET observacion = '$observ_estandar', fecha_creacion = '$fecha', hora_creacion = '$hora_act', num_observacion = '1'
							WHERE fecha = '$fecha' AND id_area = '3' AND id_sub_area = '18' AND turno = '$turno';";
	$query_m1			=	mig_query($sq_m1, $db);
}
////////
if (pg_num_rows($query_scp_observ_1) == 0)
{
	$sq_m1				=	"INSERT INTO estatus_planta_observaciones (fecha, observacion, id_area, id_sub_area, num_observacion, turno, fecha_creacion, hora_creacion)
							VALUES
							('$fecha', 'SISTEMAS DE SUPERVISION Y CONTROL EN OPERACION NORMAL', '4', '11', '1', '$turno', '$fecha', '$hora_act')";
	$query_m1			=	mig_query($sq_m1, $db);
}
////////////////////////////////////////////////observaciones mantenimiento
if (pg_num_rows($query_mantt_observ_1) == 0)
{
	$sq_m1				=	"INSERT INTO estatus_planta_observaciones (fecha, observacion, id_area, id_sub_area, num_observacion, turno, fecha_creacion, hora_creacion)
							VALUES
							('$fecha', '$observ_estandar', '6', '35', '1', '$turno', '$fecha', '$hora_act')";
	$query_m1			=	mig_query($sq_m1, $db);
}
if ($res_mantt_observ_1['observacion'] == "")
{
	$sq_m1				=	"UPDATE estatus_planta_observaciones SET observacion = '$observ_estandar', fecha_creacion = '$fecha', hora_creacion = '$hora_act', num_observacion = '1'
							WHERE fecha = '$fecha' AND id_area = '6' AND id_sub_area = '35' AND turno = '$turno';";
	$query_m1			=	mig_query($sq_m1, $db);
}
////////
if (pg_num_rows($query_mantt_observ_2) == 0)
{
	$sq_m1				=	"INSERT INTO estatus_planta_observaciones (fecha, observacion, id_area, id_sub_area, num_observacion, turno, fecha_creacion, hora_creacion)
							VALUES
							('$fecha', '$observ_estandar', '6', '36', '1', '$turno', '$fecha', '$hora_act')";
	$query_m1			=	mig_query($sq_m1, $db);
}
if ($res_mantt_observ_2['observacion'] == "")
{
	$sq_m1				=	"UPDATE estatus_planta_observaciones SET observacion = '$observ_estandar', fecha_creacion = '$fecha', hora_creacion = '$hora_act', num_observacion = '1'
							WHERE fecha = '$fecha' AND id_area = '6' AND id_sub_area = '36' AND turno = '$turno';";
	$query_m1			=	mig_query($sq_m1, $db);
}
////////
if (pg_num_rows($query_mantt_observ_3) == 0)
{
	$sq_m1				=	"INSERT INTO estatus_planta_observaciones (fecha, observacion, id_area, id_sub_area, num_observacion, turno, fecha_creacion, hora_creacion)
							VALUES
							('$fecha', '$observ_estandar', '6', '37', '1', '$turno', '$fecha', '$hora_act')";
	$query_m1			=	mig_query($sq_m1, $db);
}
if ($res_mantt_observ_3['observacion'] == "")
{
	$sq_m1				=	"UPDATE estatus_planta_observaciones SET observacion = '$observ_estandar', fecha_creacion = '$fecha', hora_creacion = '$hora_act', num_observacion = '1'
							WHERE fecha = '$fecha' AND id_area = '6' AND id_sub_area = '37' AND turno = '$turno';";
	$query_m1			=	mig_query($sq_m1, $db);
}
////////

pg_close($db);
?>


