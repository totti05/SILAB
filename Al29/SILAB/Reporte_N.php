<?php
//*********************************************
//*********************************************
global $xfechar;
global $xsala;
global $xdomingo;
global $xlunes;

$xfechar=$_GET['id1'];
$xsala=$_GET['sala'];

function separar($xfechar,&$d1,&$m1,&$a1,&$xlunes,&$xdomingo)
{   // fecha 1


function lunes($dia,$mes,$ano){ 
$now =  mktime(0,0,0,$mes,$dia,$ano);
$num = date("w", mktime(0,0,0,$mes,$dia,$ano));
if ($num == 0)
{ $sub = 6; }
else { $sub = ($num-1); }
$WeekMon  = mktime(0, 0, 0, date("m", $now)  , date("d", $now)-$sub, date("Y", $now));    //monday week begin calculation
$todayh = getdate($WeekMon); //monday week begin reconvert
$d = $todayh[mday];
if (strlen(rtrim(ltrim($d )))==1)
	    $d ="0".ltrim($d);
	else	
	    $d =$d;
$m = $todayh[mon];
$y = $todayh[year];
$lunes="$d/$m/$y"; //getdate converted day
return $lunes;
}

function domingo($dia,$mes,$ano){ 
$now =  mktime(0,0,0,$mes,$dia,$ano);
$num = date("w", mktime(0,0,0,$mes,$dia,$ano));
if ($num == 0)
{ $sub = 6; }
else { $sub = ($num-1); }
$WeekMon  = mktime(0, 0, 0, date("m", $now)  , date("d", $now)+(6-$sub), date("Y", $now));    //monday week begin calculation
$todayh = getdate($WeekMon); //monday week begin reconvert
$d = $todayh[mday];
if (strlen(rtrim(ltrim($d )))==1)
	    $d ="0".ltrim($d);
	else	
	    $d =$d;
$m = $todayh[mon];
$y = $todayh[year];
$domingo="$d/$m/$y"; //getdate converted day
return $domingo;
}




  	$d1 = strtok ($xfechar,"/");
	$m1 = strtok ("/");
	$a1 = strtok ("/");
	$xlunes=lunes($d1,$m1,$a1);
	$xdomingo=domingo($d1,$m1,$a1);
	
}

separar($xfechar,$d1,$m1,$a1,$xlunes,$xdomingo);
$xfechar=$xlunes;
//echo $xlunes.".........".$xdomingo;

//exit;

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
//etcetera, tantos selects como sean necesarios
//***************************************************
//BD

 //echo "nada .....................";
 //exit;
if ($xsala=='1')
  $cadena="select n0celda,rtrim(convert(char,fecha,103)) as fecha, Hora, si , fe, al, grado,condicion from V_SCP_FORANEOS_CELDAST_N where fecha>='".$xfechar."'"." and fecha<='".$xdomingo."' and n0celda>100 and n0celda<199";
//echo  $cadena;
//exit;
if ($xsala=='2')
  $cadena="select n0celda,rtrim(convert(char,fecha,103)) as fecha, Hora, si , fe, al, grado,condicion from V_SCP_FORANEOS_CELDAST_N where fecha>='".$xfechar."'"." and fecha<='".$xdomingo."' and n0celda>200 and n0celda<299";
//echo  $cadena;
//exit;
if ($xsala=='3')
  $cadena="select n0celda,rtrim(convert(char,fecha,103)) as fecha, Hora, si , fe, al, grado,condicion from V_SCP_FORANEOS_CELDAST_N where fecha>='".$xfechar."'"." and fecha<='".$xdomingo."' and n0celda>300 and n0celda<399";
if ($xsala=='4')
  $cadena="select n0celda,rtrim(convert(char,fecha,103)) as fecha, Hora, si , fe, al, grado,condicion from V_SCP_FORANEOS_CELDAST_N where fecha>='".$xfechar."'"." and fecha<='".$xdomingo."' and n0celda>400 and n0celda<499";
if ($xsala=='5')
  $cadena="select n0celda,rtrim(convert(char,fecha,103)) as fecha, Hora, si , fe, al, grado,condicion from V_SCP_FORANEOS_CELDAST_N where fecha>='".$xfechar."'"." and fecha<='".$xdomingo."' and n0celda>500 and n0celda<599";
if ($xsala=='6')
  $cadena="select n0celda,rtrim(convert(char,fecha,103)) as fecha, Hora, si , fe, al, grado,condicion from V_SCP_FORANEOS_CELDAST_N where fecha>='".$xfechar."'"." and fecha<='".$xdomingo."' and n0celda>600 and n0celda<699";
if ($xsala=='7')
  $cadena="select n0celda,rtrim(convert(char,fecha,103)) as fecha, Hora, si , fe, al, grado,condicion from V_SCP_FORANEOS_CELDAST_N where fecha>='".$xfechar."'"." and fecha<='".$xdomingo."' and n0celda>701 and n0celda<790";
if ($xsala=='8')
  $cadena="select n0celda,rtrim(convert(char,fecha,103)) as fecha, Hora, si , fe, al, grado,condicion from V_SCP_FORANEOS_CELDAST_N where fecha>='".$xfechar."'"." and fecha<='".$xdomingo."' and nOcelda>800 and nOcceoda<899";
if ($xsala=='9')
  $cadena="select n0celda,rtrim(convert(char,fecha,103)) as fecha, Hora, si , fe, al, grado,condicion from V_SCP_FORANEOS_CELDAST_N where fecha>='".$xfechar."'"." and fecha<='".$xdomingo."' and n0celda>900 and n0celda<998";
if ($xsala=='10')
  $cadena="select n0celda,rtrim(convert(char,fecha,103)) as fecha, Hora, si , fe, al, grado,condicion from V_SCP_FORANEOS_CELDAST_N where fecha>='".$xfechar."'"." and fecha<='".$xdomingo."' and n0celda>1000 and n0celda<1091";
if ($xsala=='11')
  $cadena="select n0celda,rtrim(convert(char,fecha,103)) as fecha, Hora, si , fe, al, grado,condicion from V_SCP_FORANEOS_CELDAST_N where fecha>='".$xfechar."'"." and fecha<='".$xdomingo."' and n0celda>1100 and n0celda<1106";
   
global $xpfecha;
$query=mssql_query($cadena,$link);
$reg = mssql_fetch_array ($query);
$xpfecha=$reg['fecha'];


// llamada libreria 
require('fpdf.php');


class PDF extendS FPDF
{
//Cabecera de página
function Header(){
     global $xfechar;
	 global $xsala;
	 global $xpfecha;
	 
	//Logos
	$this->Image('imagenes/CVG_nuevo.jpg',8,8,25);
    $this->Image('imagenes/venalum_Nuevo.jpg',175,8,20);
	$this->SetFont('Arial','B',16);
	//Título	
	$this->Cell(0,14,"Informe de Ensayo Metal de Celdas",0,0,'C');
	$this->Ln(12);
	$this->SetFont('Arial','',9);
	//Título	
	$this->Image('imagenes/cuadro normal.jpg',48,25,110);
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
	$this->Cell(21,12,' '.$xfechar.'-'.$xsala,0,0,'R');
	$this->Ln(11);
	$this->Line(10,44,195,44);
	$this->SetFont('Arial','',10);
	$this->Cell(33,1,"Solicitante                                                                             Extensión          Método de Ensayo      Fecha Recepción",0,0,'J');
	$this->Line(10,57,195,57);
	$this->Ln(7);
	$this->Cell(33,1, "Suptcia. Procesos y Certificación de Calidad Reducción        4431                MM-ESQ-001                 ".$xpfecha,0,0,'J');  
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
	$this->Line(10,64,195,64);
	$this->Line(10,71,195,71);
	$this->Cell(20,05,'      Número Celda',0,0,C);
	$this->Cell(30,05,'      Fecha',0,0,C);
	$this->Cell(20,05,'      Hora',0,0,C); 
	$this->Cell(20,05,'       %Si',0,0,C);
	$this->Cell(25,05,'      %Fe',0,0,C); 
	$this->Cell(15,05,'      %Al',0,0,C);
	$this->Cell(25,05,'      Grado',0,0,C);
	$this->Cell(10,05,'      Tipo',0,1,C);
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
	$this->SetFont('Arial','',10);
	$this->Cell(0,0,"Firma: ",0,0,C);
	
	//..........Arial italic 8
	$this->SetFont('Arial','I',4);
	
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
if ($xsala=='1')
  $cadena="select n0celda,rtrim(convert(char,fecha,103)) as fecha, Hora, si , fe, al, grado,condicion from V_SCP_FORANEOS_CELDAST_N where fecha>='".$xfechar."'"." and fecha<='".$xdomingo."' and n0celda>100 and n0celda<199";
//echo  $cadena;
//exit;
if ($xsala=='2')
  $cadena="select n0celda,rtrim(convert(char,fecha,103)) as fecha, Hora, si , fe, al, grado,condicion from V_SCP_FORANEOS_CELDAST_N where fecha>='".$xfechar."'"." and fecha<='".$xdomingo."' and n0celda>200 and n0celda<299";
//echo  $cadena;
//exit;
if ($xsala=='3')
  $cadena="select n0celda,rtrim(convert(char,fecha,103)) as fecha, Hora, si , fe, al, grado,condicion from V_SCP_FORANEOS_CELDAST_N where fecha>='".$xfechar."'"." and fecha<='".$xdomingo."' and n0celda>300 and n0celda<399";
if ($xsala=='4')
  $cadena="select n0celda,rtrim(convert(char,fecha,103)) as fecha, Hora, si , fe, al, grado,condicion from V_SCP_FORANEOS_CELDAST_N where fecha>='".$xfechar."'"." and fecha<='".$xdomingo."' and n0celda>400 and n0celda<499";
if ($xsala=='5')
  $cadena="select n0celda,rtrim(convert(char,fecha,103)) as fecha, Hora, si , fe, al, grado,condicion from V_SCP_FORANEOS_CELDAST_N where fecha>='".$xfechar."'"." and fecha<='".$xdomingo."' and n0celda>500 and n0celda<599";
if ($xsala=='6')
  $cadena="select n0celda,rtrim(convert(char,fecha,103)) as fecha, Hora, si , fe, al, grado,condicion from V_SCP_FORANEOS_CELDAST_N where fecha>='".$xfechar."'"." and fecha<='".$xdomingo."' and n0celda>600 and n0celda<699";
if ($xsala=='7')
  $cadena="select n0celda,rtrim(convert(char,fecha,103)) as fecha, Hora, si , fe, al, grado,condicion from V_SCP_FORANEOS_CELDAST_N where fecha>='".$xfechar."'"." and fecha<='".$xdomingo."' and n0celda>701 and n0celda<790";
if ($xsala=='8')
  $cadena="select n0celda,rtrim(convert(char,fecha,103)) as fecha, Hora, si , fe, al, grado,condicion from V_SCP_FORANEOS_CELDAST_N where fecha>='".$xfechar."'"." and fecha<='".$xdomingo."' and nOcelda>800 and nOcceoda<899";
if ($xsala=='9')
  $cadena="select n0celda,rtrim(convert(char,fecha,103)) as fecha, Hora, si , fe, al, grado,condicion from V_SCP_FORANEOS_CELDAST_N where fecha>='".$xfechar."'"." and fecha<='".$xdomingo."' and n0celda>900 and n0celda<998";
if ($xsala=='10')
  $cadena="select n0celda,rtrim(convert(char,fecha,103)) as fecha, Hora, si , fe, al, grado,condicion from V_SCP_FORANEOS_CELDAST_N where fecha>='".$xfechar."'"." and fecha<='".$xdomingo."' and n0celda>1000 and n0celda<1091";
if ($xsala=='11')
  $cadena="select n0celda,rtrim(convert(char,fecha,103)) as fecha, Hora, si , fe, al, grado,condicion from V_SCP_FORANEOS_CELDAST_N where fecha>='".$xfechar."'"." and fecha<='".$xdomingo."' and n0celda>1100 and n0celda<1106";
   

$query=mssql_query($cadena,$link);
$i=0;
$acum=0;
$axx=1;
while($reg = mssql_fetch_array ($query)){   
$silico=$row["si"];
$acum= $acum + $silicio;
$pdf->Cell(9,05,'',0,0,C);
    

	if (($reg['si'] > 1.00) || ($reg['si'] < 0.005) || ($reg['fe'] > 1.00) || ($reg['fe'] < 0.005))
	{
		$pdf->Cell(1,05,"*",0,0,L);
	}

    $factor = pow(10, 3); 
    $si_redondeado=round($reg['si']*$factor)/$factor;   
    $fe_redondeado=round($reg['fe']*$factor)/$factor;  
	
	$pdf->Cell(20,05,$reg['n0celda'],0,0,C);
	$pdf->Cell(35,05,$reg['fecha'],0,0,C);
	$pdf->Cell(20,05,$reg['Hora'],0,0,C);
	//------------------------------
	if (strlen(rtrim(ltrim($si_redondeado)))==4)
	    $si_redondeado=ltrim($si_redondeado)."0";
	else	
	    $si_redondeado=$si_redondeado;
		
    if (strlen(rtrim(ltrim($si_redondeado)))==3)
	    $si_redondeado=ltrim($si_redondeado)."00";
	else	
	    $si_redondeado=$si_redondeado;
	//------------------------------------------
		
	$pdf->Cell(20,05,$si_redondeado,0,0,C);
	
	//------------------------
	if (strlen(rtrim(ltrim($fe_redondeado)))==4)
	    $fe_redondeado=ltrim($fe_redondeado)."0";
	else	
	   $fe_redondeado=$fe_redondeado;
	
	if (strlen(rtrim(ltrim($fe_redondeado)))==3)
	    $fe_redondeado=ltrim($fe_redondeado)."00";
	else	
	   $fe_redondeado=$fe_redondeado;   
    //--------------------------  
	   
	$pdf->Cell(20,05,$fe_redondeado,0,0,C);
	$pdf->Cell(20,05,$reg['al'],0,0,C);
	$pdf->Cell(20,05,$reg['grado'],0,0,C);
	$pdf->Cell(20,05,$reg['condicion'],0,1,C);
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