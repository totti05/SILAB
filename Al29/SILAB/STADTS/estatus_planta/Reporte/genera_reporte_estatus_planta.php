<?php

//require("html2fpdf.php");
require_once(dirname(__FILE__).'../../../../includes/reportes_pdf/html2pdf.class.php');
//$servidor			=	"http://ve-828/scp";
$servidor     = "http://vem-1868/scp";
$module_name		=	"igpp_mm";

/////// PARAMETROS NECESARIOS PARA FUNCIONAMIENTO DEL REPORTE

//class PDF extends HTML2FPDF
class PDF2 extends HTML2PDF
{                         //Abre la clase  
}

$aleatorio	= rand();
$pdf2=new PDF2('P', 'Letter');
$fecha_reporte					=	$_GET['fecha_reporte'];
$ocultar						=	$_GET['ocultar'];

list($dia, $mes, $año)			=	split('/', $fecha_reporte);
$fecha_guardar					=	$dia."_".$mes."_".$año;
$html = file_get_contents("$servidor/modules/$module_name/reporte_estatus_planta2.php?&numero=$aleatorio&fecha_reporte=$fecha_reporte&ocultar=$ocultar");
$pdf2->AddFont('arialn');
$pdf2->WriteHTML($html);
$pdf2->Output();
?>