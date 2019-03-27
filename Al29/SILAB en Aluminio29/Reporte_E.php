<?php
//*********************************************
//*********************************************
global $xfechar;
global $xcomplejo;

$xfechar=$_GET['id1'];
$xcomplejo=$_GET['complejo'];


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

$sq2 = "";
$sq2 = "";

//***************************************************

// llamada libreria 
require('fpdf.php');


class PDF extendS FPDF
{
//Cabecera de página
function Header(){
    global $xfechar;
    global $xcomplejo;
	//Logos 
	$this->Image('imagenes/CVG_nuevo.jpg',8,8,25);
    $this->Image('imagenes/venalum_Nuevo.jpg',175,8,20);
	$this->SetFont('Arial','B',16);
	//Título	
	$this->Cell(0,14,"Informe de Ensayo Metal de Celdas",0,0,'C');
	$this->Ln(12);
	$this->SetFont('Arial','',10);
	//Título	
	$this->Image('imagenes/cuadro especial.jpg',52,26,110);
    $this->Ln(10);
	$this->Cell(185,6,"Nro. Reporte: SILE-RM1003",0,0,'R');
	$this->Ln(4);
	$this->Cell(181,12,'Pág.  '.$this->PageNo().'  de  {nb}',0,0,'R');
	$this->SetFont('Arial','B',10);
	$fecha1=date("d/m/20y");
	$this->SetFont('Arial','',10);
	$this->Cell(-50,12,'Fecha:  ',0,0,'R');
	$this->SetFont('Arial','B',10);
	$this->Cell(18,12,$fecha1,0,0,'R');
	$this->SetFont('Arial','',10);
	$this->Cell(-55,12,'Nro. Informe: ',0,0,'R');
	$this->SetFont('Arial','B',10);
	$this->Cell(21,12,' '.$xfechar.'-'.$xcomplejo,0,0,'R');
	$this->Ln(11);
	$this->Line(10,44,195,44);
	$this->SetFont('Arial','',10);
	$this->Cell(33,1,"Solicitante                                                                             Extensión          Método de Ensayo      Fecha Recepción",0,0,'J');
	$this->Line(10,57,195,57);
	$this->Ln(7);
	$this->Cell(33,1, "Suptcia. Procesos y Certificación de Calidad Reducción        4431                MM-ESQ-001                 ".$xfechar,0,0,'J');  
	$this->SetFont('Arial','B',10);
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
	$this->Cell(12,05,'   No. CELDA',0,0,C);
	$this->Cell(35,05,'HORA',0,0,C); 
	$this->Cell(23,05,'%SILICIO',0,0,C);
	$this->Cell(35,05,'%HIERRO',0,0,C); 
	$this->Cell(33,05,'%ALUMINIO',0,0,C);
	$this->Cell(30,05,'GRADO ALEACION',0,1,C);
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
	$this->SetFont('Arial','B',10);
	$this->Cell(0,0,"Analizado:",0,0,L);
	$this->SetY(290);
	$this->SetX(10);
	$this->SetFont('Arial','',7);
	$this->Cell(0,0,"IG-005(08-08-2007)",0,0,L);
	$this->SetY(232);
	$this->SetX(20);
	$this->SetFont('Arial','B',10);
	$this->Cell(0,0,"Incertidumbre por Nivel de Concentración del Elemento ",0,0,C);
	$this->SetY(275);
	$this->SetX(25);
	$this->SetFont('Arial','B',10);
	$this->Cell(0,0,"''La reproducción de estos resultados debe ser autorizada por el laboratorio'' ",0,0,C);
    $this->SetY(285);
	$this->SetX(-225);
	$this->SetFont('Arial','',8);
	$this->Cell(0,0,"Firma: ",0,0,C);
	
	
}
} //Cierra la clase
//Creación del objeto de la clase heredada

$pdf=new PDF();
$pdf->AliasNbPages();
$pdf->AddPage();

//******************************
//titulo 

//***************************
// DETALLE 
$pdf->SetFont('Arial','',10);
if ($xcomplejo=='1')
  $cadena="select n0celda, Hora, si , fe, al, grado  from V_SCP_FORANEOS_CELDAST_E where fecha='".$xfechar."'"." and n0celda>100 and n0celda<499";
if ($xcomplejo=='2')
  $cadena="select n0celda, Hora, si , fe, al, grado from V_SCP_FORANEOS_CELDAST_E where fecha='".$xfechar."'"." and n0celda>500 and n0celda<899";
if ($xcomplejo=='3')
  $cadena="select n0celda, Hora, si , fe, al, grado  from V_SCP_FORANEOS_CELDAST_E where fecha='".$xfechar."'"." and n0celda>901 and n0celda<1090";
if ($xcomplejo=='T')
  $cadena="select n0celda, Hora, si , fe, al, grado  from V_SCP_FORANEOS_CELDAST_E where fecha='".$xfechar."'";    
$query=mssql_query($cadena,$link);
$i=0;
$acum=0;
while($reg = mssql_fetch_array ($query)){
$silico=$row["si"];
$acum= $acum + $silicio;
	$pdf->Cell(9,05,'',0,0,C);
	$pdf->Cell(10,05,$reg['n0celda'],0,0,R);
	$pdf->Cell(30,05,$reg['Hora'],0,0,R);
	$factor = pow(10, 3); 
//	$fe_redondeado=round($reg['fe']*$factor)/$factor; 
	$fe_redondeado=$reg['fe']; 
	$al_redondeado=round($reg['al']*$factor)/$factor; 
	//**************
	if (strlen(rtrim(ltrim($reg['si'])))==5)
	    $temposi=ltrim($reg['si'])."0";
	else	
	    $temposi=$reg['si'];
	//********************	
	$pdf->Cell(25,05,$temposi,0,0,R);
	//$pdf->Cell(25,05,$si_redondeado,0,0,R);
	
	//**************
	
	if (strlen(rtrim(ltrim($fe_redondeado)))==5)
	    $fe_redondeado=ltrim($fe_redondeado)."0";
	else	
	    $fe_redondeado=$fe_redondeado;
	 if (strlen(rtrim(ltrim($fe_redondeado)))==4)
	    $fe_redondeado=ltrim($fe_redondeado)."00";
	else	
	    $fe_redondeado=$fe_redondeado;
	 if (strlen(rtrim(ltrim($fe_redondeado)))==3)
	    $fe_redondeado=ltrim($fe_redondeado)."00";
	else	
	    $fe_redondeado=$fe_redondeado;
	//********************	
	
	$pdf->Cell(30,05,$fe_redondeado,0,0,R);

	//**************
	
	if (strlen(rtrim(ltrim($al_redondeado)))==4)
	    $al_redondeado=ltrim($al_redondeado)."0";
	else	
	    $al_redondeado=$al_redondeado;
	//*****************************************
	$pdf->Cell(30,05,$al_redondeado,0,0,R);
	
	//********************	
	$pdf->Cell(50,05,$reg['grado'],0,1,C);
$i=$i+1;
	if ($i==25)  
	   { $i=0;
	     $pdf->AddPage(); }
}
$x=1;
while($x<26-$i){
$pdf->Cell(9,05,' ',0,1,C);
$x=$x+1;
}
$pdf->Output();
 mssql_close($link);
?> 