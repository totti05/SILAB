<?php
require_once('FPDI1/fpdf.php');
require_once('FPDI1/fpdi.php');

// initiate FPDI
$pdf = new FPDI();
$pdf->AliasNbPages();
// add a page
$pdf->AddPage();
// set the source file
$pdf->setSourceFile("plantilla pdf/Carbon/Antracita2.pdf");
// import page 1
$tplIdx = $pdf->importPage(1);
// use the imported page and place it at point 10,10 with a width of 100 mm
$pdf->useTemplate($tplIdx, 0, 5, 208);

// now write some text above the imported page

	//Logos de venalum
	$pdf->Image('imagenes/LogoLadoIzq.PNG',8,8,30);
    $pdf->Image('imagenes/venalum_Nuevo.jpg',179,8,22);
 	
    //primera linea 
 	$pdf->SetFont('Arial','',8);
 	//nro reporte
 	$pdf->text(110,29,'0xxx');
 	//fecha
    $pdf->text(143,29,'22/02/2019');
    //pagina x de x
    $pdf->text(183,29,$pdf->PageNo());  
    $pdf->text(194,29,'{nb}');
    //tipo de muestra
    $pdf->SetFont('Arial','B',8);
    switch (1) {
                case '1': 
                    $pdf->text(14,38,"X");

                    break;
                case '2':
                    $pdf->text(72.5,38,'X');
                    break;
                case '3':
                    $pdf->text(129.5,38,'X');
                    break;        
                case '4':
                    $pdf->text(182.5,38,'X');
                    break; 
            }


$pdf->Output();   