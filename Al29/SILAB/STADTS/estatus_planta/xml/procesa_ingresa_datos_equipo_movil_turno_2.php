<?php
	include '../conectarse.php';

	$db									=	conectarse_postgres();
	$fecha_carga						=	$_GET['fecha_carga'];
	$turno_carga						=	$_GET['turno'];
	$sub_area							=	$_GET['sub_area'];
	$area								=	$_GET['area'];
	$n									=	0;
	$n_max								=	10;
	
	$ind								=	0;
	$ind_max							=	count($sub_area);

	$valores_estandar					=	explode(',', $_GET['valores_estandar']);
	$valores_operativo					=	explode(',', $_GET['valores_operativo']);

	$ind2								=	1;
	while($ind < $ind_max)
	{
		$n2								=	0;
		while ($n <= $n_max)
		{
			$valores_estandar2[$ind][$n2]			=	$valores_estandar[$n];
			$valores_operativo2[$ind][$n2]			=	$valores_operativo[$n];
			$n++;
			$n2++;
		}
		$ind++;
		$ind2++;
		$n_max							=	(10 * $ind2) + $ind2 - 1;
	}
	
	$sq_m1								=	"SELECT * FROM estaus_planta_equipo_movil WHERE fecha = '$fecha_carga' AND turno = '$turno_carga' AND sub_area = '$sub_area'";
	$query_m1							=	mig_query($sq_m1, $db);
	
	if (pg_num_rows($query_m1) == 0)
	{
		$tabla								=	"estaus_planta_equipo_movil";
		$campos								=	"fecha, turno, area, sub_area, tipo_equipo_movil, cantidad_estandar, cantidad_operativo";
		$n									=	0;
		while ($n < $ind_max)
		{
			$n2								=	0;
			$n3								=	1;
			while ($n2 <= 10)
			{
				echo "<br>";
				echo $sq_m2						=	"INSERT INTO $tabla ($campos) VALUES ('$fecha_carga', '$turno_carga', '$area', '$sub_area','".$n3."', '".$valores_estandar2[$n][$n2]."', '".$valores_operativo2[$n][$n2]."')";
				$query_m2					=	mig_query($sq_m2, $db);
				$n2++;
				$n3++;
			}
			$n++;
		}
		echo "Los datos de equipo móvil se han ingresado correctamente";
	}
	else
	{
		$sq_m1								=	"DELETE FROM estaus_planta_equipo_movil WHERE fecha = '$fecha_carga' AND turno = '$turno_carga' AND sub_area = '$sub_area'";
		$query_m1							=	mig_query($sq_m1, $db);
		$tabla								=	"estaus_planta_equipo_movil";
		$campos								=	"fecha, turno, area, sub_area, tipo_equipo_movil, cantidad_estandar, cantidad_operativo";
		$n									=	0;
		while ($n < $ind_max)
		{
			$n2								=	0;
			$n3								=	1;
			while ($n2 <= 10)
			{
				$sq_m1						=	"INSERT INTO $tabla ($campos) VALUES ('$fecha_carga', '$turno_carga', '$area', '$sub_area[$n]','".$n3."', '".$valores_estandar2[$n][$n2]."', '".$valores_operativo2[$n][$n2]."')";
				$query_m2					=	mig_query($sq_m1, $db);
				$n2++;
				$n3++;
			}
			$n++;
		}
		echo "Los datos de equipo móvil se han ingresado correctamente";
	}
	

	pg_close($db);
?>