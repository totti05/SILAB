<?php
	include '../conectarse.php';
	$db						=	conectarse_postgres();

	//////////////////BUSCA LOS NOMBRES DE LOS CAMPOS DE LA VISTA REQUERIDA, LUEGO LOS ALMACENA EN LA VARIABLE $NOMBRE_CAMPOS Y EN $CADENA
	$sq_m1					=	"SELECT DISTINCT column_name FROM information_schema.columns WHERE table_name = 'estatus_planta_vista_diferencias_reduccion_diario'";
	$query_m1				=	mig_query($sq_m1, $db);
	$n						=	0;
	while($res_m1			=	pg_fetch_array($query_m1))
	{
		if (substr($res_m1['column_name'], 0, 2) == "s_")
		{
			$nombre_campos[$n]	=	$res_m1['column_name'];
			$n++;
		}
	}
	$numero_campos			=	$n;
	$n						=	0;
	$cadena = "";
	while($n < $numero_campos)
	{
		if ($cadena == "")		$cadena = $nombre_campos[$n];
		else $cadena 		=	$cadena."+".$nombre_campos[$n];
		$n++;
	}
	
	//////////////////BUSCA EN LA VISTA LOS REGISTROS, DONDE LA SUMA DE LOS CAMPOS SEA <> DE CERO, LUEGO EN CADA REGISTRO BUSCA QUE CAMPO ES <> DE CERO Y
	///////////////// LLAMA A LA FUNCION QUE ACTUALIZA LA TABLA PRINCIPAL DE VALORES
	$sq_m2					=	"SELECT fecha, linea, suma FROM (
										SELECT fecha, linea, SUM($cadena) 
										AS suma FROM estatus_planta_vista_diferencias_reduccion_diario GROUP BY fecha, linea ) DERIVEDTBL WHERE suma <> 0";
	$query_m2				=	mig_query($sq_m2, $db);
	while($res_m2			=	pg_fetch_array($query_m2))
	{
		$sq_m3				=	"SELECT * FROM estatus_planta_vista_diferencias_reduccion_diario WHERE fecha = '$res_m2[fecha]' AND linea = '$res_m2[linea]'";
		$query_m3			=	mig_query($sq_m3, $db);
		$res_m3				=	pg_fetch_array($query_m3);
		$n					=	0;
		while($n < $numero_campos)
		{
			$total_caract	=	strlen($nombre_campos[$n]);
			$nombre_campo2	=	substr($nombre_campos[$n], 2, $total_caract);
			$nombre_campo	=	$nombre_campos[$n];
			if (abs($res_m3[$nombre_campo]) > 0)
			{
				actualiza_tabla($nombre_campo2, $res_m2['fecha'], $res_m2['linea'], $db);
			}
			$n++;
		}		
	}

	pg_close($db);

function actualiza_tabla($nombre_campo, $fecha, $linea, $db)
{
	$sq_m4					=	"UPDATE estatus_planta_reduccion_diario SET $nombre_campo = 
								(SELECT $nombre_campo FROM estatus_planta_respaldo_reduccion_diario WHERE fecha='$fecha' AND linea = '$linea' ) WHERE
								fecha = '$fecha' AND linea = '$linea'";
	$query_m4				=	mig_query($sq_m4, $db);
}
?>