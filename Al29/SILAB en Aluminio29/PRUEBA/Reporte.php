<?php

  global $xfechar;
  global $xturno;
  global $xsala;

  $xfechar='xfecha';
  $xturno='xturno';
  $xsala='xsala';
// llamada libreria 
require('fpdf.php');
// llamada archivo de funciones para conectar a la BD
require('conexion.php');
global $conexion;

class PDF extendS FPDF
{
    //http://control/scp/modules/SILAB/PRUEBA/funciones.php
    //Cabecera de página
   function Header(){
        global $xfechar, $xturno, $xsala;
        //Logos
            //Image($file,$x,$y,$w=0,$h=0,$type='',$link='')
            $this->Image('../imagenes/LogoLadoIzq.png',8,8,30);
            $this->Image('../imagenes/venalum_Nuevo.jpg',179,8,22);
            
        //Título
            //SetFont($family,$style='',$size=0)
            $this->SetFont('Arial','B',16); 
            //Text($x,$y,$txt)
            $this->text(68,18,"Informe de Ensayo de Laboratorio");
     

        // Líneas horizontales
            //Line($x1,$y1,$x2,$y2)
            $this->Line(8,32,205,32);  //Primera
            $this->Line(8,40,205,40);  //Segunda
            $this->Line(8,48,205,48);  //Tercera
            $this->Line(8,56,205,56);  //Cuarta   
     

        // Línes verticales
            $this->Line(165,40,165,48); // der. fila2
            $this->Line(165,48,165,56); // der. fila3
     

        //arriba de la primera linea de membrete
            // SetFont($family,$style='',$size=0)
            $this->SetFont('Arial','',9);
            $this->text(102,30,"Nro.: ");
            $this->text(120,30,$xsala);
            $this->SetFont('Arial','',9);
            $this->text(135,30,"Fecha:");
            $this->text(145,30,"dd/mm/aaaa");
            $this->text(179,30,'Pag. '.$this->PageNo().' de {nb}');

        
        //primera fila de membrete
            $this->SetFont('Arial','B',9);
            $this->text(10,35,"Tipo de Muestra ");
            
            $this->SetFont('Arial','',9);
            //etiquetas
            $this->text(15,39,"Materia Prima");
            $this->text(70,39,'De Proceso');
            $this->text(135,39,'Producto');
            $this->text(188,39,'Especial');
            //marca (X) que rellena la casilla
            $this->SetFont('Arial','B',9);
            $this->text(12,39,"X"); //posicion de x que rellena el cuadro
            $this->text(67,39,'X');//posicion de x que rellena el cuadro
            $this->text(132,39,'X'); //posicion de x que rellena el cuadro
            $this->text(185,39,'X');//posicion de x que rellena el cuadro
            
               
        //segunda fila del membrete
            $this->SetFont('Arial','B',9);
            $this->text(10,43,"Solicitante");
            $this->SetFont('Arial','',9);
            $this->text(10,47,"Francisco Bolivar"); //variable
            $this->SetFont('Arial','',9);
            $this->text(168,43,"Ext. Telefonica:");
            $this->text(178,47,"4454"); //variable
        

        //tercera fila del membrete
           // $this->Line(8,48,205,48);  //Tercera
           // $this->Line(8,56,205,56);  //Cuarta   
            $this->SetFont('Arial','B',9);
            $this->text(10,51,"Muestra");
            $this->SetFont('Arial','',9);
            $this->text(10,55,"Alumina primaria - CVG VENALUM"); // variable
            $this->SetFont('Arial','',9);
            $this->text(168,51,"Fecha de recepcion:"); 
            $this->text(178,55,"dd/mm/aa"); //Variable
            $this->SetFont('Arial','B',9);
            $this->text(100,59,"Resultados");
    
            $this->Body(); //llamado de la funcion que escribe resultados de reporte

    }  // Fin de la función Header


   //Pie de página
   function Footer(){
        //fin de los resultados
            $this->SetFont('Arial','',7);
            $this->text(20,198,"Los analisis aqui reportados fueron realizadosen la Superintendencia Laboratorio y corresponden unica y exclusivamente a la(s) muestra(s) aqui identificadas.");
           

        // Líneas horizontales
            //Line($x1,$y1,$x2,$y2)
            $this->Line(8,200,205,200); //primera
            $this->Line(8,230,205,230); //segunda
            $this->Line(8,270,205,270);  //tercera  
     
        // Línes verticales
            $this->Line(80,230,80,270); // recuadro1 
            $this->Line(158,230,158,270); //recuadro2 

        //opiniones e interpretaciones
            $this->SetFont('Arial','B',9);
            $this->text(8,203,"Opiniones e interpretaciones:");
            $this->SetFont('Arial','',9);
            $this->text(8,206,"texto de la bd"); //variable
            $this->SetFont('Arial','B',9); 
            $this->text(40,228," \"La reproduccion de estos resultados debe ser autorizada por la Superintendencia Laboratorio\"");
        //primer recuadro
            $this->SetFont('Arial','B',9);
            $this->text(10,233,"Analizado (Tecnico - Analista)");
            $this->SetFont('Arial','',9);
            $this->text(10,236,"Nombre, Apellido / Nro. Personal"); 

            
            $this->text(10,250,"Firma:");

            $this->SetFont('Arial','',9);
            $this->text(10,263,"Fecha:"); 
            $this->text(20,263,"dd/mm/aa");
            $this->text(50,263,"Fecha:"); 
            $this->text(60,263,"dd/mm/aa");

        //segundo recuadro
            $this->SetFont('Arial','B',9);
            $this->text(82,233,"Conformado (jefe de Departamento");
            $this->text(82,236,"(Laboratorio de Materiales - Laboratorio Quimico)"); 
            $this->SetFont('Arial','',9);
            $this->text(82,239,"Nombre, Apellido / Nro. Personal");

            
            $this->text(82,250,"Firma:");

            $this->SetFont('Arial','',9);
            $this->text(82,263,"Fecha:"); 
            $this->text(92,263,"dd/mm/aa");
            $this->text(122,263,"Fecha:"); 
            $this->text(132,263,"dd/mm/aa");

        //tercer recuadro
            $this->SetFont('Arial','B',9);
            $this->text(160,233,"Aprobado");
            $this->text(160,236,"(Superintendente Laboratorio)"); 
            $this->SetFont('Arial','',9);
            $this->text(160,239,"Nombre, Apellido / Nro. Personal");

            
            $this->text(160,250,"Firma:");

            $this->SetFont('Arial','',9);
            $this->text(160,263,"Fecha:"); 
            $this->text(170,263,"dd/mm/aa");
        //codigo de formulario
            $this->SetFont('Arial','',7);
            $this->text(10,273,"IG-020(17-08-2015");
      

   } // Fin de la función Footer

    //Funcion que imprime los resultados del reporte en el pdf
   function Body(){
        global $conexion;
        $conexion = conectar_mssql();
        $muestra = trim($_POST['nmuestra']);
        //$anio = trim($_POST['anio']);
        //$material = trim($_POST['material']);
        // SetXY($x,$y)
        //$this->SetXY(10,62);
        $this->SetFont('Arial','B',9);
        $this->text(30,65,"Analisis");
        $this->text(80,65,"Resultados");
        $this->text(120,65,"Incertidumbre");
        $this->text(160,65,"Norma");
        $this->SetFont('Arial','',9);
        $query="SELECT * FROM [dbo].[V_AL20_SCP_SILAB_FORANEOS_resultados_e] WHERE nmuestra = $muestra AND cmaterial = 'ALUMINA PRIMARIA DIA' AND ano = '2017'";

        $res_query=mssql_query($query, $conexion);
        if (isset($res_query)) {
            $y=70;
            $y1=70;

            while ($resultados = mssql_fetch_array($res_query)){

              $separar=explode("I",$resultados['cpropiedad']);

              if ((($separar[1]&& !$separar[4] )||($separar[4])) && ($resultados['cpropiedad'] != 'IGNICION-1' && $resultados['cpropiedad'] != 'IGNICION-3')) {
                $this->text(125,$y1,''.$resultados['valor']);
                //$this->text(30,$y1,''.$resultados['cpropiedad']);
                $y1=$y1+10;    
                }else{
                    
                $this->text(30,$y,''.$resultados['cpropiedad']);
                $this->text(85,$y,''.trim($resultados['valor']));
                $this->text(160,$y,'norma etiqueta');
                $y=$y+10; 
                }  
                 
              
              
              

            } 

          }else{ 

             $this->text(30,68,"error");
          }


   }

} //Cierra la clase


//Creación del objeto de la clase heredada
$pdf=new PDF('P','mm','A4');
$pdf->AliasNbPages();
$pdf->AddPage();
$pdf->Output();

?> 