<?php
//*********************************************
//*********************************************

global $xfechar;
global $xlinea;

$xfechar=$_GET['id3'];
$xlinea=$_GET['linea'];

//Parametro de Entrada 
//*********************************************
//*********************************************
 
     //                         servidor       usuario           Clave
 if (!($link=mssql_connect("ALUMINIO20\SCP","Portal_Reportes","Reportes")))
   { 
      echo "Error conectando a la base de datos."; 
      exit(); 
   } 
                          
						 
   if (!mssql_select_db ("Desarrollo",$link))
   { 
      echo "Error seleccionando la base de datos."; 
      exit(); 
   } 
mssql_close($link);

//Select OJO......................................................
//////// select a las vistas de sql //////
//$sq1 = "select No.CELDAS,%CONDICION,%SILICIO,%HIERRO,%ALUMINIO,GRADO,HORA,TIPO, from prueba1 where idlinea = 'l1' or idlinea = 'l3'"; 
$sq2 = "";
$sq2 = "";
//etcetera, tantos selects como sean necesarios
//***************************************************
//BD

 //echo "nada .....................";
 //exit;

// llamada libreria 
require('fpdf.php');


class PDF extendS FPDF
{
//Cabecera de página
function Header(){
    global $xcolada;
	//Logos
	$this->Image('imagenes/CVG_nuevo.jpg',50,8,22);
    $this->Image('imagenes/venalum_Nuevo.jpg',220,8,18);
	$this->SetFont('Arial','B',16);
	//Título	
	$this->Cell(0,20,"Informe de Ensayo de Coladas",0,0,'C');
	$this->Ln(12);
	$this->SetFont('Arial','B',8);
	//Título	imagenes/Cuadro Colada promedios.jpg
	$this->Image('imagenes/Cuadro Colada Diaria.jpg',115,25,135);
    $this->Ln(10);
	$this->Cell(260,8,"Nro. Reporte:'".$xcolada."'",0,0,'R');
	$this->Ln(4);
	$this->Cell(187,10,'Pág. '.$this->PageNo().' de {nb}',0,0,'R');
	
	$fecha1=date("d-m-20y");
	$this->Cell(-45,12,'Fecha: ',0,0,'R');
	$this->Cell(14,12,$fecha1,0,0,'R');
	$this->Cell(-55,12,'.$xfechar.',0,0,'R');
	$this->Ln(11);
	$this->Line(10,44,195,44);
	$this->Cell(33,1,"Solicitante                                                                                                Extensión                   Método de Ensayo                  Fecha de Recepción y análisis",0,0,'J');
	$this->Line(10,57,195,57);
	$this->Ln(7);
	$this->Cell(33,1, "Suptcia. Procesos y Certificación de Calidad Coladas                       4501                             MM-ESQ-001                           '".$xfechar."'",0,0,'J');  
	$this->ln(5);
	$this->Cell(175,5,"Resultados del Ensayo",0,0,'C');
	
	//Título	
	$this->Ln(2);
	$this->SetFont('Arial','B',10);
	$this->Cell(20,05,'',0,0,C);
    $this->Cell(210,05,'',0,1,C);
	$this->Cell(9,05,'',0,0,C);
	$this->Line(10,65,195,65);
	$this->Line(10,72,195,72);
	
	$this->Line(10,65,10,71);
	$this->Line(195,65,195,71);
	
    $this->Line(10,64,195,64);
	$this->Line(10,71,195,71);
	$this->Cell(07,05,'Muestra',0,0,C);
	$this->Cell(15,05,'Aleación',0,0,C); 
	$this->Cell(10,05,'Si',0,0,C);
	$this->Cell(10,05,'Fe',0,0,C); 
	$this->Cell(10,05,'Cu',0,0,C);
	$this->Cell(10,05,'Mn',0,0,C);
	$this->Cell(10,05,'Mg',0,0,C);
	$this->Cell(10,05,'Cr',0,0,C); 
	$this->Cell(10,05,'Ni',0,0,C);
	$this->Cell(10,05,'Zn',0,0,C);
	$this->Cell(10,05,'Ti',0,0,C);
	$this->Cell(10,05,'V',0,0,C); 
	$this->Cell(10,05,'Pb',0,0,C);
	$this->Cell(10,05,'B',0,0,C);
	$this->Cell(10,05,'Ga',0,0,C);
	$this->Cell(10,05,'Be',0,0,C); 
	$this->Cell(10,05,'Bi',0,0,C);
	$this->Cell(10,05,'Ca',0,0,C);
	$this->Cell(10,05,'Cd',0,0,C);
	$this->Cell(10,05,'Li',0,0,C); 
	$this->Cell(10,05,'Na',0,0,C);
	$this->Cell(10,05,'Sn',0,0,C);
	$this->Cell(10,05,'Sr',0,0,C);
	$this->Cell(10,05,'Zr',0,0,C); 
	$this->Cell(10,05,'Al',0,0,C);
	$this->Cell(10,05,'Gºdeg',0,0,C);
	$this->Cell(10,05,'TR',0,0,C);
	$this->Cell(200,02,'',0,1,C);

}

//Pie de página
function Footer(){
	//Posición: a 2,0 cm del final
	$this->SetFont('Arial','B',6);
	$this->ln(33);
	$this->Cell(270,05,'',0,1,C);
	$this->Cell(60,05,'',0,0,C);
	$this->Cell(07,05,"Elem",0,0,C);
	$this->Cell(20,05,"Nivel  /  %",0,0,C);
	$this->Cell(10,05,"U  /  %",0,0,C);
	$this->Cell(2,05,'',0,0,C);
	$this->Cell(07,05,"Elem",0,0,C);
	$this->Cell(20,05,"Nivel  /  %",0,0,C);
	$this->Cell(10,05,"U  /  %",0,0,C);
	$this->Cell(9,05,'',0,0,C);
	$this->Ln(05);
	$this->Cell(60,05,'',0,0,C);
	$this->Cell(07,05,"",0,0,C);
	$this->Cell(20,05,"(0.0018  a 0.25)",0,0,C);
	$this->Cell(10,05," 0.0010 ",0,0,C);
	$this->Cell(2,05,'',0,0,C);
	$this->Cell(07,05,"",0,0,C);
	$this->Cell(20,05,"(0.0044 a 0.29)",0,0,C);
	$this->Cell(10,05," 0.0042 ",0,0,C);
	$this->Cell(9,05,'',0,0,C);
	$this->Ln(05);
	$this->Cell(60,05,'',0,0,C);
	$this->Cell(07,05,"",0,0,C);
	$this->Cell(20,05,"(0.25 a 0.60)",0,0,C);
	$this->Cell(10,05," 0.0098 ",0,0,C);
	$this->Cell(2,05,'',0,0,C);
	$this->Cell(07,05,"",0,0,C);
	$this->Cell(20,05,"(0.29 a 0.52)",0,0,C);
	$this->Cell(10,05," 0.017 ",0,0,C);
	$this->Cell(9,05,'',0,0,C);
	$this->ln(05);
	$this->Cell(60,05,'',0,0,C);
	$this->Cell(07,05,"Si",0,0,C);
	$this->Cell(20,05,"(0.60 a 1.70)",0,0,C);
	$this->Cell(10,05," 0.020 ",0,0,C);
	$this->Cell(2,05,'',0,0,C);
	$this->Cell(07,05,"Fe",0,0,C);
	$this->Cell(20,05,"(0.52 a 1.80)",0,0,C);
	$this->Cell(10,05," 0.028 ",0,0,C);
	$this->Cell(9,05,'',0,0,C);
	$this->Ln(05);
	$this->Cell(60,05,'',0,0,C);
	$this->Cell(07,05,"",0,0,C);
	$this->Cell(20,05,"(1.70 a 6.5)",0,0,C);
	$this->Cell(10,05,"0.048",0,0,C);
	$this->Cell(2,05,'',0,0,C);
	$this->Cell(07,05,"",0,0,C);
	$this->Cell(20,05,"(1.80 a 3.30)",0,0,C);
	$this->Cell(10,05," 0.19 ",0,0,C);
	$this->Cell(9,05,'',0,0,C);
	$this->Ln(05);
	$this->Cell(60,05,'',0,0,C);
	$this->Cell(07,05,"",0,0,C);
	$this->Cell(20,05,"(6.5 a 12.6)",0,0,C);
	$this->Cell(10,05," 0.11 ",0,0,C);
	$this->Cell(2,05,'',0,0,C);
	$this->Cell(07,05,"",0,0,C);
	$this->Cell(20,05,"( 3.30 )",0,0,C);
	$this->Cell(10,05," 0.36 ",0,0,C);
	$this->Cell(9,05,'',0,0,C);
	$this->Ln(05);
	$this->Cell(60,05,'',0,0,C);
	$this->Cell(07,05,"",0,0,C);
	$this->Cell(20,05,"(12.6)",0,0,C);
	$this->Cell(10,05," 0.13 ",0,0,C);
	$this->Cell(2,05,'',0,0,C);
	$this->Cell(07,05,"",0,0,C);
	$this->Cell(20,05,"",0,0,C);
	$this->Cell(10,05,"",0,0,C);
	$this->Cell(9,05,'',0,0,C);
	$this->Line(70,236,106,236);//**1arriba
	$this->Line(109,236,146,236);//**2arriba
	$this->Line(70,241,106,241);//**1media abajo
	$this->Line(109,241,146,241);//**2media abajo
	$this->Line(70,270,106,270);//**1abajo
	$this->Line(109,270,146,270);//**2abajo
	$this->Line(70,236,70,270);//**1.1vertical
	$this->Line(106,236,106,270);//**1.4vertical
	$this->Line(109,236,109,270);//**2.1vertical
	$this->Line(146,236,146,270);//**2.4vertical
	$this->Line(78,236,78,270);//**1.2vertical
	$this->Line(116,236,116,270);//**2.2vertical
	$this->Line(96,236,96,270);//**1.3vertical
	$this->Line(135,236,135,270);//**2.3vertical
 //...................................................................................................................................
	$this->SetY(285);
	$this->SetX(10);
	$this->SetFont('Arial','B',8);
	$this->Cell(0,0,"Analizado:",0,0,L);
	$this->SetY(290);
	$this->SetX(10);
	$this->SetFont('Arial','B',6);
	$this->Cell(0,0,"IG-005(08-08-2007)",0,0,L);
	$this->SetY(232);
	$this->SetX(20);
	$this->SetFont('Arial','B',9);
	$this->Cell(0,0,"Incertidumbre por Nivel de Concentración del Elemento ",0,0,C);
	$this->SetY(275);
	$this->SetX(25);
	$this->SetFont('Arial','B',8);
	$this->Cell(0,0,"''La reproducción de estos resultados debe ser autorizada por el laboratorio'' ",0,0,C);
    $this->SetY(285);
	$this->SetX(20);
	$this->Cell(0,0,"Firma: ",0,0,C);
	
	//..........Arial italic 8
	$this->SetFont('Arial','I',4);
	
}
} //Cierra la clase
//Creación del objeto de la clase heredada
$pdf=new PDF('L','mm','A4');
$pdf->AliasNbPages();
$pdf->AddPage();

//******************************
//titulo 

//***************************
// DETALLE 
$pdf->SetFont('Arial','B',10);
$query=mssql_query("select condicion,el10,el11,el12,el13,el14,el15,el16,el17,el18,el19,el20,el21,el22,be,bi,ca,cd,li,na,sn,sr,fecha,hora,grado,el23, zr from V_SCP_FORANEOS_Col_Dia where n0_colada=".$xcolada,$link);
$i=0;
$acum=0;
while($reg = mssql_fetch_array ($query)){
$silico=$row["si"];
$acum= $acum + $silicio;
	$pdf->Cell(9,05,'',0,0,C);
	$pdf->Cell(15,05,$reg['condicion'],0,0,C);
	$pdf->Cell(10,05,$reg['el10'],0,0,C);
	$pdf->Cell(10,05,$reg['el11'],0,0,C);
	$pdf->Cell(10,05,$reg['el12'],0,0,C);
	$pdf->Cell(10,05,$reg['el13'],0,0,C);
	$pdf->Cell(10,05,$reg['el14'],0,0,C);
	$pdf->Cell(10,05,$reg['el15'],0,0,C);
	$pdf->Cell(10,05,$reg['el16'],0,0,C);
	$pdf->Cell(10,05,$reg['el17'],0,0,C);
	$pdf->Cell(10,05,$reg['el18'],0,0,C);
	$pdf->Cell(10,05,$reg['el19'],0,0,C);
	$pdf->Cell(10,05,$reg['el20'],0,0,C);
	$pdf->Cell(10,05,$reg['el21'],0,0,C);
	$pdf->Cell(10,05,$reg['el22'],0,0,C);
	$pdf->Cell(10,05,$reg['be'],0,0,C);
	$pdf->Cell(10,05,$reg['bi'],0,0,C);
	$pdf->Cell(10,05,$reg['ca'],0,0,C);
	$pdf->Cell(10,05,$reg['cd'],0,0,C);
	$pdf->Cell(10,05,$reg['li'],0,0,C);
	$pdf->Cell(10,05,$reg['na'],0,0,C);
	$pdf->Cell(10,05,$reg['sn'],0,0,C);
	$pdf->Cell(10,05,$reg['sr'],0,0,C);
	$pdf->Cell(10,05,$reg['nota'],0,0,C);
	$pdf->Cell(10,05,$reg['zr'],0,0,C);
	$pdf->Cell(10,05,$reg['fecha'],0,0,C);
	$pdf->Cell(10,05,$reg['hora'],0,0,C);
	$pdf->Cell(10,05,$reg['grado'],0,0,C);
	$pdf->Cell(10,05,$reg['el23'],0,1,C);
	
	
	$i=$i+1;
	if ($i==25)  
	   { $i=0;
	     $pdf->AddPage(); }
}
$pdf->Output();
 mssql_close($link);
?> 
