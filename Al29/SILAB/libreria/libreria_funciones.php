<?php 

function Mensaje($mensa)
{ // Mensaje de aleerta de usuario no autorizado
echo "<h3><strong>".$mensa."</strong></h3>" ;
echo "<img src='/scp/images/modulos/cara4.gif' align='right'>";
}

function Usuario_Alerta()
{ // Mensaje de aleerta de usuario no autorizado
echo "<h3><strong>Usuario no registrado..... </strong></h3>" ;
echo "<img src='/scp/images/modulos/candado.gif' align='right'>";
}

function grabar_ok()
{ // Mensaje de aleerta de usuario no autorizado
echo "<h4><strong>Actualizacion realizada con éxito......</strong></h4>" ;
echo "<img src='/scp/images/modulos/grabar_ok.gif' align='right'>";
}

function Grabar_Error(){
    OpenTable();
 // Mensaje de aleerta de usuario no autorizado
		echo "<h3><strong>Registro Duplicado o Error en BD...</strong></h3>" ;
		echo "<img src='/scp/images/modulos/stop.jpg' align='right'>";
	CloseTable();
}

function Borrar_Error(){
    OpenTable();
 // Mensaje de aleerta de usuario no autorizado
		echo "<h3><strong>Registro no existe o Error en BD...</strong></h3>" ;
		echo "<img src='/scp/images/modulos/stop.jpg' align='right'>";
	CloseTable();
}

function Borrar_ok()
{ // Mensaje de aleerta de usuario no autorizado
echo "<h4><strong>Borrado realizado con éxito......</strong></h4>" ;
echo "<img src='/scp/images/modulos/grabar_ok.gif' align='right'>";
}


// Funcion para obtener fecha

function fecha_actual()
{ // se usa en los formularios de modificacion de las noticias
// Obtiene el dia actual
	$tiempo_actual = time(); 
    $dia = date("j", $tiempo_actual); 
    $mes = date("n", $tiempo_actual); 
    $ano = date("Y", $tiempo_actual);
	$fecha_actual = "$dia-$mes-$ano";// se debe utilizar - (guion) porque aunque en la bd esta con 
									 // / (slash) php no lo toma asi.
	return $fecha_actual;
}

function nombre_diadesemana($num_dia){
	 switch ($num_dia){
	 	case 1:
			$nombre_dia="Lunes";
			break;
	 	case 2:
			$nombre_dia="Martes";
			break;
	 	case 3:
			$nombre_dia="Miércoles";
			break;
	 	case 4:
			$nombre_dia="Jueves";
			break;
	 	case 5:
			$nombre_dia="Viernes";
			break;
	 	case 6:
			$nombre_dia="Sábado";
			break;
	 	case 7:
			$nombre_dia="Domingo";
			break;
	}	
	return $nombre_dia;
}
?>

