<?php
//*********************************************
//*********************************************
global $xfechar;
//global $xlinea;

$xfechar=$_GET['id3'];
//$xlinea=$_GET['linea'];


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
if (strlen(rtrim(ltrim($m )))==1)
	    $m ="0".ltrim($m);
	else	
	    $m =$m;
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
if (strlen(rtrim(ltrim($m )))==1)
	    $m ="0".ltrim($m);
	else	
	    $m =$m;
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

//echo $xfechar.".............".$xlinea."........".$xdomingo;
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
//$sq1 = "select No.CELDAS,%CONDICION,%SILICIO,%HIERRO,%ALUMINIO,GRADO,HORA,TIPO, from prueba1 where idlinea = 'l1' or idlinea = 'l3'"; 
$sq2 = "";
$sq2 = "";
//etcetera, tantos selects como sean necesarios
//***************************************************
//BD

 //echo "nada .....................";
 //exit;


$cadena="select  n0celda,rtrim(convert(char,fecha,103)) as fecha, Hora, si , fe,cu, al, grado,condicion from V_SCP_FORANEOS_CELDAST_DILU_CU where fecha>='".$xfechar."'"." and fecha<='".$xdomingo."'";

//echo  $cadena;
//exit;

global $xpfecha;
$query=mssql_query($cadena,$link);
$reg = mssql_fetch_array ($query);
$xpfecha=$reg['fecha'];
//echo "....".$xpfecha;
//exit;

// llamada libreria 
require('fpdf.php');


class PDF extendS FPDF
{
//Cabecera de página
   function Header(){
    global $xfechar;
	global $xdomingo;
	global $xlinea;
	global $xpfecha;
	//Logos
	$this->Image('imagenes/CVG_nuevo.jpg',8,8,25);
    $this->Image('imagenes/venalum_Nuevo.jpg',175,8,20);
	$this->SetFont('Arial','B',16);
	//Título	
	$this->Cell(0,14,"Informe de Ensayo Prueba de Dilución de Cobre",0,0,'C');
	$this->Ln(12);
	$this->SetFont('Arial','',10);
	//Título	
     $this->Ln(10);
	$this->Cell(185,6,"Nro. Reporte: SILE-RM0010",0,0,'R');
	$this->Ln(4);
	$this->Cell(181,12,'Pág.  '.$this->PageNo().'  de  {nb}',0,0,'R');
	$this->SetFont('Arial','B',10);
	$fecha1=date("d/m/20y");
	$this->SetFont('Arial','',10);
	$this->Cell(-50,12,'Fecha:  ',0,0,'R');
	$this->SetFont('Arial','B',10);
	$this->Cell(18,12,$xdomingo,0,0,'R');
	$this->SetFont('Arial','',10);
	$this->Cell(-55,12,'Nro. Informe: ',0,0,'R');
	$this->SetFont('Arial','B',10);
	$this->Cell(18,12,' '.$xfechar,0,0,'R');
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
	
	$this->Line(10,65,10,71);
	$this->Line(195,65,195,71);
	
    $this->Line(10,64,195,64);
	$this->Line(10,71,195,71);
	$this->Cell(20,05,'      No. CELDA',0,0,C);
	$this->Cell(30,05,'      CONDICION',0,0,C);
	$this->Cell(30,05,'      %SILICIO',0,0,C);
	$this->Cell(30,05,'      %HIERRO',0,0,C); 
	$this->Cell(30,05,'      %COBRE',0,0,C);
	$this->Cell(30,05,'      %ALUMINIO',0,1,C);
	$this->Cell(200,02,'',0,1,C);

}

//Pie de página
function Footer(){
	//Posición: a 2,0 cm del final
	$this->SetFont('Arial','B',6);
	$this->ln(25);
	$this->Cell(270,05,'',0,1,C);
	$this->Cell(40,05,'',0,0,C);
	$this->Cell(07,05,"Elem",0,0,C);
	$this->Cell(20,05,"Nivel  /  %",0,0,C);
	$this->Cell(10,05,"U  /  %",0,0,C);
	$this->Cell(2,05,'',0,0,C);
	$this->Cell(07,05,"Elem",0,0,C);
	$this->Cell(20,05,"Nivel  /  %",0,0,C);
	$this->Cell(10,05,"U  /  %",0,0,C);
	$this->Cell(2,05,'',0,0,C);
	$this->Cell(07,05,"Elem",0,0,C);
	$this->Cell(20,05,"Nivel  /  %",0,0,C);
	$this->Cell(10,05,"U  /  %",0,0,C);
	$this->Cell(2,05,'',0,0,C);
	$this->Cell(9,05,'',0,0,C);
	$this->Ln(05);
	$this->Cell(40,05,'',0,0,C);
	$this->Cell(07,05,"",0,0,C);
	$this->Cell(20,05,"(0.0018  a 0.25)",0,0,C);
	$this->Cell(10,05," 0.0010 ",0,0,C);
	$this->Cell(2,05,'',0,0,C);
	$this->Cell(07,05,"",0,0,C);
	$this->Cell(20,05,"(0.0044 a 0.29)",0,0,C);
	$this->Cell(10,05," 0.0042 ",0,0,C);
	$this->Cell(2,05,'',0,0,C);
	$this->Cell(07,05,"",0,0,C);
	$this->Cell(20,05,"(0.00092 a 0.25)",0,0,C);
	$this->Cell(10,05," 0.0028 ",0,0,C);
	$this->Cell(9,05,'',0,0,C);
	$this->Ln(05);
	$this->Cell(40,05,'',0,0,C);
	$this->Cell(07,05,"",0,0,C);
	$this->Cell(20,05,"(0.25 a 0.60)",0,0,C);
	$this->Cell(10,05," 0.0098 ",0,0,C);
	$this->Cell(2,05,'',0,0,C);
	$this->Cell(07,05,"",0,0,C);
	$this->Cell(20,05,"(0.29 a 0.52)",0,0,C);
	$this->Cell(10,05," 0.017 ",0,0,C);
	$this->Cell(2,05,'',0,0,C);
	$this->Cell(07,05,"",0,0,C);
	$this->Cell(20,05,"(0.25 a 0.30)",0,0,C);
	$this->Cell(10,05," 0.036 ",0,0,C);
	$this->Cell(9,05,'',0,0,C);
	$this->ln(05);
	$this->Cell(40,05,'',0,0,C);
	$this->Cell(07,05,"Si",0,0,C);
	$this->Cell(20,05,"(0.60 a 1.70)",0,0,C);
	$this->Cell(10,05," 0.020 ",0,0,C);
	$this->Cell(2,05,'',0,0,C);
	$this->Cell(07,05,"Fe",0,0,C);
	$this->Cell(20,05,"(0.52 a 1.80)",0,0,C);
	$this->Cell(10,05," 0.028 ",0,0,C);
	$this->Cell(2,05,'',0,0,C);
	$this->Cell(07,05,"Cu",0,0,C);
	$this->Cell(20,05,"(0.30 a 0.93)",0,0,C);
	$this->Cell(10,05," 0.044 ",0,0,C);
	$this->Cell(9,05,'',0,0,C);
	$this->Ln(05);
	$this->Cell(40,05,'',0,0,C);
	$this->Cell(07,05,"",0,0,C);
	$this->Cell(20,05,"(1.70 a 6.5)",0,0,C);
	$this->Cell(10,05,"0.048",0,0,C);
	$this->Cell(2,05,'',0,0,C);
	$this->Cell(07,05,"",0,0,C);
	$this->Cell(20,05,"(1.80 a 3.30)",0,0,C);
	$this->Cell(10,05," 0.19 ",0,0,C);
	$this->Cell(2,05,'',0,0,C);
	$this->Cell(07,05,"",0,0,C);
	$this->Cell(20,05,"(0.93)",0,0,C);
	$this->Cell(10,05," 0.094 ",0,0,C);
	$this->Cell(9,05,'',0,0,C);
	$this->Ln(05);
	$this->Cell(40,05,'',0,0,C);
	$this->Cell(07,05,"",0,0,C);
	$this->Cell(20,05,"(6.5 a 12.6)",0,0,C);
	$this->Cell(10,05," 0.11 ",0,0,C);
	$this->Cell(2,05,'',0,0,C);
	$this->Cell(07,05,"",0,0,C);
	$this->Cell(20,05,"( 3.30 )",0,0,C);
	$this->Cell(10,05," 0.36 ",0,0,C);
	$this->Cell(9,05,'',0,0,C);
	$this->Ln(05);
	$this->Cell(40,05,'',0,0,C);
	$this->Cell(07,05,"",0,0,C);
	$this->Cell(20,05,"(12.6)",0,0,C);
	$this->Cell(10,05," 0.13 ",0,0,C);
	$this->Cell(2,05,'',0,0,C);
	$this->Cell(07,05,"",0,0,C);
	$this->Cell(20,05,"",0,0,C);
	$this->Cell(10,05,"",0,0,C);
	$this->Cell(9,05,'',0,0,C);
	$this->Line(50,228,87,228);//**1arriba
	$this->Line(89,228,125,228);//**2arriba
	$this->Line(128,228,164,228);//**3arriba
	$this->Line(50,232,87,232);//**1media abajo
	$this->Line(89,232,125,232);//**2media abajo
	$this->Line(128,232,164,232);//**3media abajo
	$this->Line(50,263,87,263);//**1abajo
	$this->Line(89,263,125,263);//**2abajo
	$this->Line(128,255,164,255);//**3abajo
	$this->Line(50,228,50,263);//**1.1vertical
	$this->Line(87,228,87,263);//**1.4vertical
	$this->Line(89,228,89,263);//**2.1vertical
	$this->Line(125,228,125,263);//**2.4vertical
	$this->Line(128,228,128,255);//**3.1vertical
	$this->Line(164,228,164,255);//**3.4vertical
	$this->Line(57,228,57,263);//**1.2vertical
	$this->Line(96,228,96,263);//**2.2vertical
	$this->Line(135,228,135,255);//**3.2vertical
	$this->Line(78,228,78,263);//**1.3vertical
	$this->Line(116,228,116,263);//**2.3vertical
	$this->Line(156,228,156,255);//**3.3vertical

    //...................................................................................................................................
	$this->SetY(275);
	$this->SetX(10);
	$this->SetFont('Arial','B',9);
	$this->Line(10,272,195,272);
	$this->Cell(0,0,"Analizado:",0,0,L);
	$this->SetY(280);
	$this->SetX(10);
    $this->Cell(0,0,"Nombre y Apellido:",0,0,L);
	$this->SetY(285);
	$this->SetX(10);
	$this->Cell(0,0,"Firma:",0,0,L);
	$this->Line(10,71,195,71);
	$this->SetY(290);
	$this->SetX(10);
	$this->SetFont('Arial','B',7);
	$this->Cell(0,0,"IG-010(08-08-2007)",0,0,L);
	$this->SetY(223);
	$this->SetX(25);
	$this->SetFont('Arial','B',10);
	$this->Cell(0,0,"Incertidumbre por Nivel de Concentración del Elemento ",0,0,C);
	$this->SetY(268);
	$this->SetX(25);
	$this->SetFont('Arial','B',10);
	$this->Cell(0,0,"''La reproducción de estos resultados debe ser autorizada por el laboratorio'' ",0,0,C);
	$this->SetFont('Arial','B',9);
	$this->SetY(275);
	$this->SetX(70);
	$this->Cell(0,0,"   Conforme:",0,0,C);
	$this->SetY(280);
	$this->SetX(70);
	$this->Cell(0,0,"                   Nombre y Apellido: ",0,0,C);
    $this->SetY(285);
	$this->SetX(70);
	$this->Cell(0,0," Firma:     ",0,0,C);
	$this->Line(10,288,195,288);
	
	
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
//if ($xsemana=='1')
 // $cadena="select n0celda,condicion, si , fe, cu, al from V_SCP_FORANEOS_CELDAST_DILU_CU where fecha>='".$xfechar."'";


$cadena="select n0celda,rtrim(convert(char,fecha,103)) as fecha, Hora, si , fe,cu, al, grado,condicion from V_SCP_FORANEOS_CELDAST_DILU_CU where fecha>='".$xfechar."'"." and fecha<='".$xdomingo."'";

//echo  $cadena;
//exit;


$query=mssql_query($cadena,$link);
$i=0;
$acum=0;
while($reg = mssql_fetch_array ($query)){
$silico=$row["si"];
$acum= $acum + $silicio;
	$pdf->Cell(9,05,'',0,0,C);
	$pdf->Cell(20,05,$reg['n0celda'],0,0,C);
	$pdf->Cell(36,05,$reg['condicion'],0,0,C);
    $factor = pow(10, 4); 
    $si_redondeado=round($reg['si']*$factor)/$factor;   
    $fe_redondeado=round($reg['fe']*$factor)/$factor;  
    $cu_redondeado=round($reg['cu']*$factor)/$factor;
    $al_redondeado=round($reg['al']*$factor)/$factor;
////////////////////////////////////////////////////
    if (strlen(rtrim(ltrim($reg['si'])))==5)
	    $si_redondeado=ltrim($si_redondeado)."0";
	else	
	    $si_redondeado=$si_redondeado;
	 if (strlen(rtrim(ltrim($reg['si'])))==4)
	    $si_redondeado=ltrim($si_redondeado)."00";
	else	
	    $si_redondeado=$si_redondeado;
	 if (strlen(rtrim(ltrim($reg['si'])))==3)
	    $si_redondeado=ltrim($si_redondeado)."00";
	else	
	    $si_redondeado=$si_redondeado;
		
//////////////////////////////////////////////
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
///////////////////////////////////////////////			
  if (strlen(rtrim(ltrim($cu_redondeado)))==5)
	    $cu_redondeado=ltrim($cu_redondeado)."0";
	else	
	    $cu_redondeado=$cu_redondeado;
	 if (strlen(rtrim(ltrim($cu_redondeado)))==4)
	    $cu_redondeado=ltrim($cu_redondeado)."00";
	else	
	    $cu_redondeado=$cu_redondeado;
	 if (strlen(rtrim(ltrim($cu_redondeado)))==3)
	    $cu_redondeado=ltrim($cu_redondeado)."00";
	else	
	    $cu_redondeado=$cu_redondeado;
/////////////////////////////////////////////
		
	if (strlen(rtrim(ltrim($al_redondeado)))==4)
	    $al_redondeado=ltrim($al_redondeado)."0";
		
	$pdf->Cell(27,05,$si_redondeado,0,0,C);
	$pdf->Cell(33,05,$fe_redondeado,0,0,C);
	$pdf->Cell(28,05,$cu_redondeado,0,0,C);
	$pdf->Cell(30,05,$al_redondeado,0,1,C);

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