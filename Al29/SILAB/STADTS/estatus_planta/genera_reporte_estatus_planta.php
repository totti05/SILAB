<?php

//require("html2fpdf.php");
require_once(dirname(__FILE__).'../../../scp/includes/reportes_pdf/html2pdf.class.php');
$servidor			=	"http://control/scp";
$module_name		=	"estatus_planta";

/////// PARAMETROS NECESARIOS PARA FUNCIONAMIENTO DEL REPORTE

//class PDF extends HTML2FPDF
class PDF2 extends HTML2PDF
{                         //Abre la clase  
}

$aleatorio	= rand();
$pdf2=new PDF2('P', 'Letter');
$fecha_reporte					=	$_GET['fecha_reporte'];
$turno_reporte					=	$_GET['turno_reporte'];
$ocultar						=	$_GET['ocultar'];
//$pdf2->AddFont('arialn');
$pdf2->AddFont('arialn','','arialn.php');
list($dia, $mes, $año)			=	split('/', $fecha_reporte);
$fecha_guardar					=	$dia."_".$mes."_".$año;
$html = file_get_contents("$servidor/modules/$module_name/reporte_estatus_planta.php?&numero=$aleatorio&fecha_reporte=$fecha_reporte&turno_reporte=$turno_reporte&ocultar=$ocultar");
$pdf2->WriteHTML($html);
$pdf2->Output();
?>