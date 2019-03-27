<?php
    // llamada libreria 
    require('fpdf.php');
    // llamada archivo de funciones para conectar a la BD
    require('conexion.php');
    require('clases.php');

    global $conexion;
    
class PDF_IG_020 extendS FPDF{
   
   function Header()
   {
        $reportazo = new report();
        $reportazo->setNmuestra(trim($_POST['nmuestra']));
        $reportazo->setAno(trim($_POST['ano']));  
        $ruta = $_POST['ruta'];
        $conexion = conectar_mssql();
        //conexion a la base de datos para extraer datos de la cabecera.
        //
        
       $vistaforanea = vistaBD($ruta);

            if (isset($conexion)) 
            {
                      $query="SELECT * FROM [dbo].[$vistaforanea] WHERE nmuestra = $reportazo->nmuestra AND ano = $reportazo->ano";
                        
                      $res_query=mssql_query($query, $conexion);
                      //si no hay problema con la consulta
                      if (isset($res_query)) 
                      {

                            while ($consulta = mssql_fetch_object($res_query)){
                                
                                $reportazo->setCmaterial($consulta->cmaterial);
                                $reportazo->setAno($consulta->ano);
                                $reportazo->setNmuestra($consulta->nmuestra);
                                $reportazo->setFecha_recepcion($consulta->fecha_recepcion);
                                $reportazo->setFecha_reporte($consulta->fecha_reporte);
                                $reportazo->setAnalista ($consulta->analista);
                                $reportazo->setFecha_analista($consulta->fecha_analista);
                                $reportazo->setJefe_dpto($consulta->jefe_dpto);
                                $reportazo->setFecha_dpto($consulta->fecha_dpto);
                                $reportazo->setSupte($consulta->supte);
                                $reportazo->setFecha_supte($consulta->fecha_supte);
                                $reportazo->setAprobado_dpto($consulta->aprobado_dpto);
                                $reportazo->setAprobado($consulta->aprobado);
                                $reportazo->setObservaciones($consulta->observaciones);
                                $reportazo->setCproveedor($consulta->cproveedor);
                                $reportazo->setOriginado($consulta->originado);
                                $reportazo->setExtension($consulta->extension);
                                $reportazo->setUnidad($consulta->unidad);
                                $reportazo->setTipoMuestra($consulta->TipoMuestra);
                                $reportazo->setDescripcionProve($consulta->descripcionprove);
                            } 

                      }else{ 

                            echo '<script>alert("error en la consulta(query)")</script>';
                      }
            }  

        //Logos
            $this->Image('../imagenes/LogoLadoIzq.PNG',8,8,30);
            $this->Image('../imagenes/venalum_Nuevo.jpg',179,8,22);
            
        //Título
            $this->SetFont('Arial','B',16);
            $this->text(68,18,"Informe de Ensayo de Laboratorio ");

        // Líneas horizontales
            $this->Line(8,32,205,32);  //Primera
            $this->Line(8,40,205,40);  //Segunda
            $this->Line(8,48,205,48);  //Tercera
            $this->Line(8,56,205,56);  //Cuarta   
     
        // Línes verticales
            $this->Line(165,40,165,48); // der. fila2
            $this->Line(165,48,165,56); // der. fila3
     
        //arriba de la primera linea de membrete
            $this->SetFont('Arial','',9);
            $this->text(102,30,"Nro.: ");
            $this->text(110,30,'0'.$reportazo->nmuestra);
            $this->SetFont('Arial','',9);
            $this->text(135,30,"Fecha:");
            $this->text(145,30,$reportazo->fecha_reporte);
            $this->text(179,30,utf8_decode('Pág. ').$this->PageNo().' de {nb}');

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
            //$this->cell(ancho, altura, texto, borde, línea, alineación, relleno, enlace)
            $this->SetXY(11,36); //cuadro 1
            $this->Cell (3,3, '  ' ,1,1);
            $this->SetXY(66,36); //cuadro 2
            $this->Cell (3,3, '  ' ,1,1);
            $this->SetXY(131,36); //cuadro 3
            $this->Cell (3,3, '  ' ,1,1);
            $this->SetXY(184,36); //cuadro 4
            $this->Cell (3,3, '' ,1,1);
            switch ($reportazo->TipoMuestra) {
                case '1': 
                    $this->SetXY(11,36); //cuadro 1
                    $this->Cell (3,3, 'X' ,1,1,'C'); //posicion de x que rellena el cuadro 1
                    break;
                case '2':
                    $this->SetXY(66,36); //cuadro 2
                    $this->Cell (3,3, 'X' ,1,1,'C');//posicion de x que rellena el cuadro 2
                    break;
                case '3':
                    $this->SetXY(131,36); //cuadro 3
                    $this->Cell (3,3, 'X' ,1,1,'C'); //posicion de x que rellena el cuadro 3
                    break;        
                case '4':
                    $this->SetXY(184,36); //cuadro 4
                    $this->Cell (3,3, 'X' ,1,1,'C');//posicion de x que rellena el cuadro 4
                    break; 
            }
            
        //segunda fila del membrete
            $this->SetFont('Arial','B',9);
            $this->text(10,43,"Solicitante");
            $this->SetFont('Arial','',9);
            $this->text(10,47,$reportazo->originado); //variable
            $this->SetFont('Arial','',9);
            $this->text(168,43,utf8_decode("Ext. Telefónica:"));
            $this->text(178,47,$reportazo->extension); //variable

        //tercera fila del membrete   
            $this->SetFont('Arial','B',9);
            $this->text(10,51,"Muestra");
            $this->SetFont('Arial','',9);
            $this->text(10,55,$reportazo->cmaterial.' - '.$reportazo->descripcionprove); // variable
            $this->SetFont('Arial','',9);
            $this->text(168,51,utf8_decode("Fecha de recepción:")); 
            $this->text(178,55,$reportazo->fecha_recepcion); //Variable
            $this->SetFont('Arial','B',9);
            $this->text(100,61,"Resultados");
        
        //llamado de la funcion que escribe resultados de reporte
        
            $this->Body(); 

    }  // Fin de la función Header

   //Pie de página
   function Footer()
   {
            $reportazo = new report();
            $analista = new analista();
            $jefe_dpto = new jefe_dpto();
            $supte = new supte();
            $reportazo->setNmuestra(trim($_POST['nmuestra']));
            $reportazo->setAno(trim($_POST['ano']));
            $ruta = $_POST['ruta'];
            $conexion = conectar_mssql();

            //conexion a la base de datos para extraer datos del pie de pagina.
            //
            $vistaforanea = vistaBD($ruta);

                if (isset($conexion)) 
                {
                    $query="SELECT * FROM [dbo].[$vistaforanea] WHERE nmuestra = $reportazo->nmuestra AND ano = $reportazo->ano";
                    //enviar query
                    
                    $res_query=mssql_query($query, $conexion);
                    //si no hay problema con la consulta
                    if (isset($res_query)) 
                    {

                       while ($consulta = mssql_fetch_object($res_query)){
                                    
                            $reportazo->setCmaterial($consulta->cmaterial);
                            $reportazo->setAno($consulta->ano);
                            $reportazo->setNmuestra($consulta->nmuestra);
                            $reportazo->setFecha_recepcion($consulta->fecha_recepcion);
                            $reportazo->setFecha_reporte($consulta->fecha_reporte);
                            $reportazo->setAnalista ($consulta->analista);
                            $reportazo->setFecha_analista($consulta->fecha_analista);
                            $reportazo->setJefe_dpto($consulta->jefe_dpto);
                            $reportazo->setFecha_dpto($consulta->fecha_dpto);
                            $reportazo->setSupte($consulta->supte);
                            $reportazo->setFecha_supte($consulta->fecha_supte);
                            $reportazo->setAprobado_dpto($consulta->aprobado_dpto);
                            $reportazo->setAprobado($consulta->aprobado);
                            $reportazo->setObservaciones($consulta->observaciones);
                            $reportazo->setCproveedor($consulta->cproveedor);
                            $reportazo->setOriginado($consulta->originado);
                            $reportazo->setExtension($consulta->extension);
                            $reportazo->setUnidad($consulta->unidad);
                            $reportazo->setTipoMuestra($consulta->TipoMuestra);

                            
                        } 

                    }else{ 

                            echo '<script>alert("error en la consulta(query)")</script>';
                        }
                    }
                      
                if (isset($conexion)) 
                {

                     //consulta de analistas
                        $query="SELECT * FROM [dbo].[V_AL20_SCP_SILAB_FORANEOS_personal] WHERE ficha = $reportazo->analista";
                        //enviar query

                        $res_query=mssql_query($query, $conexion);
                        //si no hay problema con la consulta
                        if (isset($res_query)) 
                        {

                           while ($consulta = mssql_fetch_object($res_query)){
                                        
                             $analista->setNombre(trim($consulta->nombre));
                             $analista->setApellido(trim($consulta->apellido));
                             $analista->setFicha(trim($consulta->ficha));

                            }
                        }else{ 

                                echo '<script>alert("error en la consulta(query)")</script>';
                            }              
                }

                if (isset($conexion)) 
                {
                    //consulta jefe de departamento
                        $query="SELECT * FROM [dbo].[V_AL20_SCP_SILAB_FORANEOS_personal] WHERE ficha = $reportazo->jefe_dpto";
                        //enviar query
                        
                        $res_query=mssql_query($query, $conexion);
                        //si no hay problema con la consulta
                        if (isset($res_query)) 
                        {

                           while ($consulta = mssql_fetch_object($res_query)){
                                        
                             $jefe_dpto->setNombre(trim($consulta->nombre));
                             $jefe_dpto->setApellido(trim($consulta->apellido));
                             $jefe_dpto->setFicha(trim($consulta->ficha));

                            }
                        }else{ 

                                echo '<script>alert("error en la consulta(query)")</script>';
                            }
                }

                if (isset($conexion)) 
                {
                    //consulta supte

                        $query="SELECT * FROM [dbo].[V_AL20_SCP_SILAB_FORANEOS_personal] WHERE ficha = $reportazo->supte"; 
                        
                        $res_query=mssql_query($query, $conexion);
                        //si no hay problema con la consulta
                        if (isset($res_query)) 
                        {

                           while ($consulta = mssql_fetch_object($res_query)){
                                        
                             $supte->setNombre(trim($consulta->nombre));
                             $supte->setApellido(trim($consulta->apellido));
                             $supte->setFicha(trim($consulta->ficha));

                            }
                        }else{ 
                                echo '<script>alert("error en la consulta(query)")</script>';
                            }
                }
            //fin de los resultados
                $this->SetFont('Arial','',7);
                $this->text(20,215,utf8_decode("Los análisis aquí reportados fueron realizados en la Superintendencia Laboratorio y corresponden única y exclusivamente a la(s) muestra(s) aquí identificadas."));
               
            // Líneas horizontales
                //Line($x1,$y1,$x2,$y2)
                $this->Line(8,216,205,216); //primera
                $this->Line(8,249,205,249); //segunda
                $this->Line(8,284,205,284);  //tercera  
         
            // Línes verticales
                $this->Line(79,249,79,284); // recuadro1 
                $this->Line(157,249,157,284); //recuadro2 

            //opiniones e interpretaciones
                $this->SetFont('Arial','B',9);
                $this->text(8,222,"Opiniones e Interpretaciones:");
                $this->SetFont('Arial','',9);

                $this->SetFont('Arial','',8);
                $this->SetXY(7,223); 
                $this->Multicell(0,3, $reportazo->observaciones);

                $this->SetFont('Arial','B',8); 
                $this->text(42,247,utf8_decode("\"La reproducción de estos resultados debe ser autorizada por la Superintendencia Laboratorio\""));
            
            //Primer recuadro
                $this->SetFont('Arial','B',9);
                $this->text(10,252,utf8_decode("Analizado (Técnico - Analista)"));
                $this->SetFont('Arial','',9);
                $this->text(10,256,"Nombre, Apellido / Nro. Personal"); 

            //Firmas 1er Cuadro
                $this->SetFont('Arial','',6.5); 
                $this->text(10,269,"Firma:");
                //Firma 1
                $this->text(18,259,$analista->nombre.' '.$analista->apellido.' - '.$analista->ficha);
                //Firma 2
                $this->text(50,259,$analista->nombre.' '.$analista->apellido.' - '.$analista->ficha);
                //Firma 3
                $this->text(18,269,$analista->nombre.' '.$analista->apellido.' - '.$analista->ficha);
                //Firma 4
                $this->text(50,269,$analista->nombre.' '.$analista->apellido.' - '.$analista->ficha);

                $this->SetFont('Arial','',9);
                $this->text(10,282,"Fecha:"); 
                $this->text(20,282,"------");
                $this->text(50,282,"Fecha:"); 
                $this->text(60,282,$reportazo->fecha_analista);

            //segundo recuadro
                $this->SetFont('Arial','B',9);
                $this->text(80,252,"Conformado (Jefe de Departamento");
                $this->text(80,255,utf8_decode("(Laboratorio de Materiales - Laboratorio Químico)")); 
                $this->SetFont('Arial','',9);
                $this->text(80,258,"Nombre, Apellido / Nro. Personal");

            //Firmas 2do Cuadro
                $this->SetFont('Arial','',6.5); 
                $this->text(80,265,"Firma:");
                //Firma 1
                $this->text(90,265,$jefe_dpto->nombre.' '.$jefe_dpto->apellido.' - '.$jefe_dpto->ficha);
                //Firma 2
                $this->text(120,265,$jefe_dpto->nombre.' '.$jefe_dpto->apellido.' - '.$jefe_dpto->ficha);       

                $this->SetFont('Arial','',9);
                $this->text(80,282,"Fecha:"); 
                $this->text(90,282,"------");
                $this->text(122,282,"Fecha:"); 
                $this->text(132,282,$reportazo->fecha_dpto);

            //tercer recuadro
                $this->SetFont('Arial','B',9);
                $this->text(159,252,"Aprobado");
                $this->text(159,255,"(Superintendente Laboratorio)"); 
                $this->SetFont('Arial','',9);
                $this->text(159,258,"Nombre, Apellido / Nro. Personal");
            
            //Firma 3er Cuadro
                $this->SetFont('Arial','',6.5);    
                $this->text(159,265,"Firma:");
                //Firma 1
                $this->text(169,265,$supte->nombre.' '.$supte->apellido.' - '.$supte->ficha); //nombre del superintendente

                $this->SetFont('Arial','',9);
                $this->text(159,282,"Fecha:"); 
                $this->text(169,282,$reportazo->fecha_supte);
            //codigo de formulario
                $this->SetFont('Arial','',7);
                $this->text(10,287,"IG-020(17-08-2015)");
        
        } // Fin de la función Footer

    //Funcion que imprime los resultados del reporte en el pdf
   function Body(){
        //global $conexion;
        $conexion = conectar_mssql();
        $muestra = trim($_POST['nmuestra']);
        $ano1 = trim($_POST['ano']);
        $this->SetFont('Arial','B',9);
        $this->text(10,70,utf8_decode("Análisis"));
        $this->text(70,70,"Resultados (%)");
        $this->text(120,70,"Incertidumbre");
        $this->text(174,70,"Norma");
        $this->SetFont('Arial','',9);

        //Para conocer el numero de muestras
        $query="SELECT * FROM [dbo].[V_AL20_SCP_SILAB_FORANEOS_resultados_e] WHERE nmuestra = $muestra AND cmaterial = 'ALUMINA PRIMARIA DIA' AND ano = $ano1";
        $res_query=mssql_query($query, $conexion);
        if (isset($res_query)) {
            $contar=0;
            while ($resultados = mssql_fetch_object($res_query)){$contar=$contar+1;}
            }
        //Para establecer el body de acuerdo a los resultados (alumina primaria diaria)
        switch($contar/2){
            case "1": $y1=80; break;
            case "2": $y1=80; $y4=90; break;
            case "4": $y1=80; $y2=90; $y3=100; $y4=110; break;
        }

        $query="SELECT * FROM [dbo].[V_AL20_SCP_SILAB_FORANEOS_resultados_e] WHERE nmuestra = $muestra AND cmaterial = 'ALUMINA PRIMARIA DIA' AND ano = $ano1";

        $res_query=mssql_query($query, $conexion);
        if (isset($res_query)) {  

            while ($resultados = mssql_fetch_object($res_query)){
            $this->SetFont('Arial','',9);      

              switch (trim($resultados->cpropiedad)) {

                  case "NA2O":
                        $this->text(10,$y1,'Na O');
                        $this->SetXY(13,$y1);
                        $this->subWrite(0,'2','',6,0);
                        $this->SetFont('Arial','B',9);
                        $this->Line(65,$y1+1,97,$y1+1);
                        $this->text(78,$y1,''.trim($resultados->valor));
                        $this->Line(164,$y1+1,196,$y1+1);
                        $this->text(169,$y1,'COVENIN 2898');
                        break;

                  case "INA2O":
                        $y1=80;
                        $this->SetFont('Arial','B',9);
                        $this->Line(115,$y1+1,147,$y1+1);
                        $this->text(126,$y1,html_entity_decode('&plusmn; ').$resultados->valor);
                        break;
                  
                 case 'IGNICION-3':
                        $this->text(10,$y2,'Perdida de masa');
                        $this->text(10,$y2+4,utf8_decode('a 300 ºC'));
                        $this->SetFont('Arial','B',9);
                        $this->Line(65,$y2+1,97,$y2+1);
                        $this->text(78,$y2,''.$resultados->valor);
                        $this->Line(164,$y2+1,196,$y2+1);
                        $this->text(169,$y2,'ISO 806');
                      break; 

                 case "IIGNICIO-3":
                        $this->SetFont('Arial','B',9);
                        $this->Line(115,$y2+1,147,$y2+1);
                        $this->text(126,$y2,html_entity_decode('&plusmn; ').$resultados->valor);
                        break;

                 case 'IGNICION-1':
                        $this->text(10,$y3,utf8_decode('Perdida por ignicion'));
                        $this->text(10,$y3+4,utf8_decode('de 300 ºC a 1000 ºC'));
                        $this->SetFont('Arial','B',9);
                        $this->Line(65,$y3+1,97,$y3+1);
                        $this->text(78,$y3,''.$resultados->valor);
                        $this->Line(164,$y3+1,196,$y3+1);
                        $this->text(169,$y3,'ISO 806');
                      break;

                  case "IIGNICIO-1":
                        $this->SetFont('Arial','B',9);
                        $this->Line(115,$y3+1,147,$y3+1);
                        $this->text(126,$y3,html_entity_decode('&plusmn; ').$resultados->valor);
                        break;

                  case 'MALLA66':
                        $this->text(10,$y4,html_entity_decode('Fracci&oacute;n (-45 &micro;m)'));
                        $this->SetFont('Arial','B',9);
                        $this->Line(65,$y4+1,97,$y4+1);
                        $this->text(78,$y4,''.trim($resultados->valor));
                        $this->Line(164,$y4+1,196,$y4+1);
                        $this->text(169,$y4,'COVENIN 2898');
                        break;

                  case "IMALLA66":
                        $this->SetFont('Arial','B',9);
                        $this->Line(115,$y4+1,147,$y4+1);
                        $this->text(126,$y4,html_entity_decode('&plusmn; ').trim($resultados->valor));
                        break;          
              } 
            } 

          }else{ 
             $this->text(30,68,"error");
          }    
   }

} //Cierra la clase

  //Instanciacion del objeto e impresion del PDF
    $pdf= new PDF_IG_020('P','mm','A4');
    $pdf->AliasNbPages();
    $pdf->AddPage();
    $pdf->Output();

?>

