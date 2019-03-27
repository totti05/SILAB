<?php
require_once('FPDI1/fpdf.php');
require_once('FPDI1/fpdi.php');
require('conexion.php');
require('clases.php');
header('Access-Control-Allow-Origin: *');
/*header('Access-Control-Allow-Origin: *');
header("Access-Control-Allow-Headers: x-requested-with");
header("Access-Control-Allow-Origin: {$_SERVER['HTTP_ORIGIN']}");*/

/*añadir para personalizar nombre plantilla y reporte generado
$reporte = {$_GET['callback']}($json);
$pdf->setSourceFile('plantilla pdf/'.$reporte.'.pdf');
$pdf->Output(trim($filePath).$reporte.'.pdf',"F");
*/


class PDF_IG_020 extendS Fpdi
{

   public function establecerPlantilla($material)
    {
            switch ($material) {

                //////////////////////////////
                //Modulo Muestras Especiales//
                //////////////////////////////
                case 'AluminaPDiaria':
                    $this->setSourceFile('plantilla pdf/Alumina Primaria Diaria 4.pdf');
                    $tplIdx = $this->importPage(1);
                    $this->useTemplate($tplIdx,0, 6, 210,270, true);
                    break;
                
                /////////////////
                //Modulo Carbon//
                /////////////////
                case 'Antracita':
                    $this->setSourceFile('plantilla pdf/Carbon/Antracita2.pdf');
                    $tplIdx = $this->importPage(1);
                    $this->useTemplate($tplIdx, 0, 10, 210,270, true);
                     break; 

                case 'BreaAlquitranAnodos':
                    $this->setSourceFile('plantilla pdf/Carbon/Brea de Alquitran Anodos2.pdf');
                    $tplIdx = $this->importPage(1);
                    $this->useTemplate($tplIdx, 0, 10, 210,270, true);
                     break; 

                case 'BreaAlquitranCatodos':
                    $this->setSourceFile('plantilla pdf/Carbon/Brea de Alquitran Catodos2.pdf');
                    $tplIdx = $this->importPage(1);
                    $this->useTemplate($tplIdx, 0, 10, 210,270, true);
                     break; 

                case 'CoqueCalcinado':
                    $this->setSourceFile('plantilla pdf/Carbon/Coque Calcinado2.pdf');
                    $tplIdx = $this->importPage(1);
                    $this->useTemplate($tplIdx, 0, 10, 210,270, true);
                     break; 

                case 'CoqueMetalurgico':
                    $this->setSourceFile('plantilla pdf/Carbon/Coque Metalurgico2.pdf');
                    $tplIdx = $this->importPage(1);
                    $this->useTemplate($tplIdx, 0, 10, 210,270, true);
                     break; 

                case 'LoteSemanalMolienda':
                    $this->setSourceFile('plantilla pdf/Carbon/Lote Semanal Molienda2.pdf');
                    $tplIdx = $this->importPage(1);
                    $this->useTemplate($tplIdx, 0, 10, 210,270, true);
                     break;                    

                //////////////////////////////////////////
                //Modulo Agua y Particulas Sedimentables//
                //////////////////////////////////////////
                case 'AguaPTermo':
                    $this->setSourceFile('plantilla pdf/Agua y Particulas Sedimentales/Agua Potable Termo Final.pdf');
                    $tplIdx = $this->importPage(1);
                    $this->useTemplate($tplIdx, 0, 6, 210,270, true);
                     break;

                case 'AguaAmbiental':
                    $this->setSourceFile('plantilla pdf/Agua y Particulas Sedimentales/Agua Ambiental Final.pdf');
                    $tplIdx = $this->importPage(1);
                    $this->useTemplate($tplIdx, 0, 6, 210,270, true);
                     break;
                
                case 'AguaIndustrial':
                    $this->setSourceFile('plantilla pdf/Agua y Particulas Sedimentales/Agua Industrial Final.pdf');
                    $tplIdx = $this->importPage(1);
                    $this->useTemplate($tplIdx, 0, 6, 210,270, true);
                     break;
                case 'AguaPHielo':
                    $this->setSourceFile('plantilla pdf/Agua y Particulas Sedimentales/Agua Potable e Hielo Final.pdf');
                    $tplIdx = $this->importPage(1);
                    $this->useTemplate($tplIdx, 0, 6, 210,270, true);
                break;
            }
    } 

   function Header()
   {        
            //se selecciona la plantilla a utilizar en el PDF de acuerdo al 
            $material = (trim($_POST['material']));
            $this->establecerPlantilla($material);
            $reportazo = new report();
            $reportazo->setNmuestra(trim($_POST['nmuestra']));
            $reportazo->setAno(trim($_POST['ano']));  
            $ruta = $_POST['ruta'];
            $conexion = conectar_mssql();
            //conexion a la base de datos para extraer datos de la cabecera.
            
           $vistaforanea = vistaReportes($ruta);

            if (isset($conexion)) 
            {
                $query="SELECT * FROM [dbo].[$vistaforanea] WHERE nmuestra = $reportazo->nmuestra AND ano = $reportazo->ano";
                        
                $res_query=mssql_query($query, $conexion);
                      //si no hay problema con la consulta
                if (isset($res_query)) 
                {
                    while ($consulta = mssql_fetch_object($res_query))
                    {
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

                }else
                { 
                    echo '<script>alert("error en la consulta(query)")</script>';
                }
            } 
            //Logos
            $this->Image('imagenes/LogoLadoIzq.PNG',11,12,30);
            $this->Image('imagenes/venalum_Nuevo.jpg',177,12,25);
            //Primera fila                
            $this->SetFont('Arial','',9);
            //nro reporte    
            $this->text(110,35,$reportazo->nmuestra);
            //fecha
            $this->text(143,35,$reportazo->fecha_reporte);
            //pagina x de x
            $this->text(185,35,$this->PageNo());  
            $this->text(196,35,'{nb}');
            //tipo de muestra
            $this->SetFont('Arial','B',8);
            switch ($reportazo->TipoMuestra) 
            {
                //cuadro Materia prima
                case '1': 
                $this->text(14,43,"X");
                break;

                //cuadro De Proceso
                case '2':
                $this->text(73,43,'X');
                break;

                //cuadro Producto
                case '4':
                $this->text(130.5,43,'X');
                break;        

                //cuadro Especial
                case '3':
                $this->text(184.3,43,'X');
                break; 
            }

            
            //segunda fila del membrete
            //"Solicitante"
            $this->SetFont('Arial','',9);
            $this->text(12,50,trim($reportazo->originado)); //variable
            //"Ext. Telefónica:"            
            $this->SetFont('Arial','',9);
            $this->text(178,50,$reportazo->extension); //variable

            //tercera fila del membrete   
            //"Muestra"
            $this->SetFont('Arial','',9);

            switch ($material) {

                //////////////////////////////
                //Modulo Muestras Especiales//
                //////////////////////////////
                case 'AluminaPDiaria':
                    $this->SetFont('Arial','B',9);
                    $this->text(50,60,'hola'.$reportazo->descripcionprove);
                    break;

                /////////////////
                //Modulo Carbon//
                /////////////////
                case 'Antracita':
                    $this->SetFont('Arial','B',9);
                    $this->text(50,60,'hola'.$reportazo->descripcionprove); 
                    break;

                //////////////////////////////////////////
                //Modulo Agua y Particulas Sedimentables//
                //////////////////////////////////////////
                case 'AguaPTermo':
                    $this->text(40,60,$reportazo->unidad); 
                    break;
                
                case 'AguaAmbiental':
                    $this->text(115,60,' - '.$reportazo->descripcionprove);
                    $this->SetFont('Arial','B',9);
                    switch (trim($reportazo->cmaterial)) {
                        case 'GRUPO R - MOLIENDA':
                            $this->text(12,60,'F4: Aguas del Grupo R de Molienda');
                        break;
                        case 'SISTEMA LURGI I':
                            $this->text(12,60,'F1: Aguas del Sistema Lurgi I');
                        break;
                        case 'TRAMPA ACEITE TALLER AUT.':
                            $this->text(12,60,'F11: Trampa de Aceite Taller Automotriz');
                        break;
                        case 'TORRE ENFRIA. COLADA 2':
                            $this->text(12,60,'Torre de Enfriamiento de Colada CTM - 1001 A');
                        break;
                        case 'PLANTA A. RESIDUAL MUELLE':
                            $this->text(12,60,'E4: Planta de Tratamiento de Aguas Residuales Muelle');
                        break;
                        case 'COL. MACANILLAL - GALP. 8':
                            $this->text(12,60,'E7-B: Colector Macanillal Diagonal al Galpon 8');
                        break;
                        case 'LIXIVIADO VERTEDERO IND.':
                            $this->text(12,60,'Lixiviado Vertedero Industrial');
                        break;
                        case 'CANAL PERIMETRAL - VL':
                            $this->text(12,60,'E12: Descarga de Aguas del Canal Perimetral - Rectif. VL');
                        break;
                        case 'CANAL PERIMETRAL - PORT 3':
                            $this->text(12,60,'E11: Descarga de Aguas del Canal Perimetral - Porton 3');
                        break;
                        case 'EFLUENTE LAGUNA CARRIZOS':
                            $this->text(12,60,'E10: Efluente Dirigido a la Laguna Carrizos');
                        break;
                        case 'CANAL DESECHO CATODICO':
                            $this->text(12,60,'E7-A: Canal de Aguas Antiguo Patio Almacenamiento Desecho Catodico'); 
                        break;
                        case 'COL. MACANILLAL - PATIO 5':
                            $this->text(12,60,'E7-B: Colector de Aguas que Desemboca en Laguna Macanillal - Patio 5');
                        break;
                        case 'COL. MACANILLAL - GALP. 4':
                            $this->text(12,60,'E6: Colector de Aguas que Desemboca en Laguna Macanillal - Galpon 4');
                        break;
                        case 'PLANTA TRA. AGUA RESIDUAL':
                            $this->text(12,60,'E5: Planta de Tratamiento de Aguas Residuales');
                        break;
                        case 'ALTO VOLTAJE':
                            $this->text(12,60,'F10: Aguas de Alto Voltaje');
                        break;
                        case 'TORRE ENFRIA. V LINEA':
                            $this->text(12,60,'F9: Aguas de la Torre de Enfriamiento de V Linea');
                        break;
                        case 'TORRE ENFRIA. COMPLEJO II':
                            $this->text(12,60,'F9: Aguas de la Torre de Enfriamiento de Complejo II');
                        break;
                        case 'TORRE ENFRIA. COMPLEJO I':
                            $this->text(12,60,'F9: Aguas de la Torre de Enfriamiento de Complejo I');
                        break;
                        case 'TORRE ENFRIA. COMPRESORES':
                            $this->text(12,60,'F8: Aguas de la Torre de Enfriamiento de Compresores');
                        break;
                        case 'TORRE ENFRIA. ENVARILLADO':
                            $this->text(12,60,'F7: Aguas de la Torre de Enfriamiento de Envarillado');
                        break;
                        case 'TORRE ENFRIAMIENTO COLADA':
                            $this->text(12,60,'F6: Aguas de la Torre de Enfriamiento de Colada');
                        break;
                        case 'TUNEL ENFRIAMIENTO ANODOS':
                            $this->text(12,60,'F3: Aguas del Tunel de Enfriamiento de Anodos');
                        break;
                        case 'SISTEMA LURGI II':
                            $this->text(12,60,'F2: Aguas del Sistema Lurgi II');
                        break;
                    }
                
                case 'AguaIndustrial':
                    $this->text(82,60,' - '.$reportazo->descripcionprove); 
                    $this->SetFont('Arial','B',9);
                    switch (trim($reportazo->cmaterial)) {
                        case 'COMPRESOR CENTAC SECA':
                            $this->text(12,60,'Unidad de Enfriamiento Compresores CENTAC');
                        break;
                        case 'TORRE ENFR. COLADA 2':
                            $this->text(12,60,'Torre de Enfriamiento de Colada CTM - 1001 A');
                        break;
                        case 'ENVARILL. TORRE 2-3':
                            $this->text(12,60,'Torre de Enfriamiento de Envarillado Torre II y III');
                        break;
                        case 'ENVARILLADO TORRE 1':
                            $this->text(12,60,'Torre de Enfriamiento de Envarillado Torre I');
                        break;
                        case 'TORRE ENFRIA. CARBON':
                            $this->text(12,60,'Torre de Enfriamiento de Carbon');
                        break;
                        case 'TORRE ENFRIA. COLADA':
                            $this->text(12,60,'Torre de Enfriamiento de Colada');
                        break;
                        case 'COMPRESORES FAC-18':
                            $this->text(12,60,'Torre de Enfriamiento de Compresores FAC-18');
                        break;
                        
                    }
                break;

                case 'AguaPHielo':
                    $this->text(36,60,$reportazo->descripcionprove); 
                    break;

            }
            
            $this->SetFont('Arial','',9);
            //"Fecha de recepción:" 
            $this->text(178,60,$reportazo->fecha_recepcion); //Variable
            //llamado de la funcion que escribe resultados de reporte
            switch ($material) {

                    //////////////////////////////
                    //Modulo Muestras Especiales//
                    //////////////////////////////
                    case 'AluminaPDiaria':
                        $this->BodyAluminaPDiaria();
                        break;

                    /////////////////
                    //Modulo Carbon//
                    /////////////////
                    case 'Antracita':
                        //$this->BodyAntracita();
                         break; 

                    //////////////////////////////////////////
                    //Modulo Agua y Particulas Sedimentables//
                    //////////////////////////////////////////
                    case 'AguaPTermo':
                        $this->BodyAguaPTermo();
                         break; 
                   
                    case 'AguaAmbiental':
                        $this->BodyAguaAmbiental();
                         break; 
                   
                    case 'AguaIndustrial':
                        $this->BodyAguaIndustrial();
                         break; 

                    /*case 'AguaPHielo':
                        $this->BodyAguaPHielo();
                         break; */

                   
                }
        
    } //Fin de la función Header
/*
   function Footer(){
            $reportazo = new report();
            $supte = new supte();
            $reportazo->setNmuestra(trim($_POST['nmuestra']));
            $reportazo->setAno(trim($_POST['ano']));
            $ruta = $_POST['ruta'];
            $conexion = conectar_mssql();

            //conexion a la base de datos para extraer datos del pie de pagina.
            //
            $vistaforanea = vistaReportes($ruta);

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

                            if(isset($consulta->analista)){
                            $reportazo->setAnalista ($consulta->analista);
                            }        
                            if (isset($consulta->analista_1)){
                            $reportazo->setAnalista_1($consulta->analista_1);
                            }
                            if (isset($consulta->analista_2)){
                            $reportazo->setAnalista_2($consulta->analista_2);
                            }
                            if (isset($consulta->analista_3)){
                            $reportazo->setAnalista_3($consulta->analista_3);
                            }
                            if (isset($consulta->analista_4)){
                            $reportazo->setAnalista_4($consulta->analista_4);
                            }

                            $reportazo->setFecha_analista($consulta->fecha_analista);

                            if (isset($consulta->jefe_dpto)){
                            $reportazo->setJefe_dpto($consulta->jefe_dpto);
                            }
                            if (isset($consulta->jefe_dpto_1)){
                            $reportazo->setJefe_dpto_1($consulta->jefe_dpto_1);
                            }
                            if (isset($consulta->jefe_dpto_2)){
                            $reportazo->setJefe_dpto_2($consulta->jefe_dpto_2);
                            }

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

                        //si existe un analista
                        //
                        if($reportazo->analista){
                        $analista = new analista();
                        $query="SELECT * FROM [dbo].[V_AL20_SCP_SILAB_FORANEOS_personal] WHERE ficha = $reportazo->analista";
                        //enviar query
                        $res_query=mssql_query($query, $conexion);

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
                    
                        //si existen 4 analistas
                        //
                        if($reportazo->analista_1){
                        $analista_uno = new analista();
                        $query="SELECT * FROM [dbo].[V_AL20_SCP_SILAB_FORANEOS_personal] WHERE ficha = $reportazo->analista_1";
                        //enviar query
                        $res_query=mssql_query($query, $conexion);

                        if (isset($res_query)) {
                           while ($consulta = mssql_fetch_object($res_query)){
                             $analista_uno->setNombre(trim($consulta->nombre));
                             $analista_uno->setApellido(trim($consulta->apellido));
                             $analista_uno->setFicha(trim($consulta->ficha));
                            }
                        }else{ 
                                echo '<script>alert("error en la consulta(query)")</script>';
                             }   
                        }

                        if($reportazo->analista_2){
                        $analista_dos = new analista();
                        $query="SELECT * FROM [dbo].[V_AL20_SCP_SILAB_FORANEOS_personal] WHERE ficha = $reportazo->analista_2";
                        //enviar query
                        $res_query=mssql_query($query, $conexion);

                        if (isset($res_query)) 
                        {
                           while ($consulta = mssql_fetch_object($res_query)){
                             $analista_dos->setNombre(trim($consulta->nombre));
                             $analista_dos->setApellido(trim($consulta->apellido));
                             $analista_dos->setFicha(trim($consulta->ficha));
                            }
                        }else{ 
                                echo '<script>alert("error en la consulta(query)")</script>';
                             } 
                        }

                        if($reportazo->analista_3){
                        $analista_tres = new analista();
                        $query="SELECT * FROM [dbo].[V_AL20_SCP_SILAB_FORANEOS_personal] WHERE ficha = $reportazo->analista_3";
                        //enviar query
                        $res_query=mssql_query($query, $conexion);

                        if (isset($res_query)) 
                        {
                           while ($consulta = mssql_fetch_object($res_query)){
                             $analista_tres->setNombre(trim($consulta->nombre));
                             $analista_tres->setApellido(trim($consulta->apellido));
                             $analista_tres->setFicha(trim($consulta->ficha));
                            }
                        }else{ 
                                echo '<script>alert("error en la consulta(query)")</script>';
                             } 
                        }

                        if($reportazo->analista_4){
                        $analista_cuatro = new analista();
                        $query="SELECT * FROM [dbo].[V_AL20_SCP_SILAB_FORANEOS_personal] WHERE ficha = $reportazo->analista_4";
                        //enviar query
                        $res_query=mssql_query($query, $conexion);

                        if (isset($res_query)) 
                        {
                           while ($consulta = mssql_fetch_object($res_query)){
                             $analista_cuatro->setNombre(trim($consulta->nombre));
                             $analista_cuatro->setApellido(trim($consulta->apellido));
                             $analista_cuatro->setFicha(trim($consulta->ficha));
                            }
                        }else{ 
                                echo '<script>alert("error en la consulta(query)")</script>';
                             }  
                        }
                    }


                if (isset($conexion)) 
                {
                    //consulta jefe de departamento
                        if ($reportazo->jefe_dpto) {
                        $jefe_dpto = new jefe_dpto();
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

                        if ($reportazo->jefe_dpto_1) {
                        $jefe_dpto_uno = new jefe_dpto();
                        $query="SELECT * FROM [dbo].[V_AL20_SCP_SILAB_FORANEOS_personal] WHERE ficha = $reportazo->jefe_dpto_1";
                        //enviar query
                        $res_query=mssql_query($query, $conexion);
                        //si no hay problema con la consulta
                        if (isset($res_query)) 
                        {
                           while ($consulta = mssql_fetch_object($res_query)){               
                             $jefe_dpto_uno->setNombre(trim($consulta->nombre));
                             $jefe_dpto_uno->setApellido(trim($consulta->apellido));
                             $jefe_dpto_uno->setFicha(trim($consulta->ficha));
                            }
                        }else{ 
                                echo '<script>alert("error en la consulta(query)")</script>';
                            }
                        }

                        if ($reportazo->jefe_dpto_2) {
                        $jefe_dpto_dos = new jefe_dpto();
                        $query="SELECT * FROM [dbo].[V_AL20_SCP_SILAB_FORANEOS_personal] WHERE ficha = $reportazo->jefe_dpto_2";
                        //enviar query
                        $res_query=mssql_query($query, $conexion);
                        //si no hay problema con la consulta
                        if (isset($res_query)) 
                        {
                           while ($consulta = mssql_fetch_object($res_query)){               
                             $jefe_dpto_dos->setNombre(trim($consulta->nombre));
                             $jefe_dpto_dos->setApellido(trim($consulta->apellido));
                             $jefe_dpto_dos->setFicha(trim($consulta->ficha));
                            }
                        }else{ 
                                echo '<script>alert("error en la consulta(query)")</script>';
                            }
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

            //opiniones e interpretaciones
                $this->SetFont('Arial','',8);
                $this->SetXY(11,197); 
                $this->Multicell(0,3, $reportazo->observaciones);
            
            //Primer recuadro
            //Firmas 1er Cuadro
                $this->SetFont('Arial','',6.5); 
                
                //Firma 1
                if(isset($reportazo->analista)){
                $this->text(18,232,$analista->nombre.' '.$analista->apellido.' - '.$analista->ficha);
                }else{
                    if (isset($reportazo->analista_1)){
                      $this->text(18,232,$analista_uno->nombre.' '.$analista_uno->apellido.' - '.$analista_uno->ficha);  
                    }
                }
                //Firma 2
                if($reportazo->analista_2){
                $this->text(50,232,$analista_dos->nombre.' '.$analista_dos->apellido.' - '.$analista_dos->ficha);
                }
                //Firma 3
                if($reportazo->analista_3){
                $this->text(18,243,$analista_tres->nombre.' '.$analista_tres->apellido.' - '.$analista_tres->ficha);
                }
                //Firma 4
                if($reportazo->analista_4){
                $this->text(50,243,$analista_cuatro->nombre.' '.$analista_cuatro->apellido.' - '.$analista_cuatro->ficha);
                }
 
                //$this->text(60,282,$reportazo->fecha_analista);

            //segundo recuadro
            //Firmas 2do Cuadro
                $this->SetFont('Arial','',6.5); 

                //Firma 1
                if(isset($reportazo->jefe_dpto)){
                $this->text(94,236,$jefe_dpto->nombre.' '.$jefe_dpto->apellido.' - '.$jefe_dpto->ficha);
                }else{
                    if(isset($reportazo->jefe_dpto_1)){
                       $this->text(94,236,$jefe_dpto_uno->nombre.' '.$jefe_dpto_uno->apellido.' - '.$jefe_dpto_uno->ficha); 
                    }
                }
                //Firma 2
                if(isset($reportazo->jefe_dpto_2)){
                $this->text(124,236,$jefe_dpto_dos->nombre.' '.$jefe_dpto_dos->apellido.' - '.$jefe_dpto_dos->ficha);  
                }     

                //$this->text(132,282,$reportazo->fecha_dpto);

            //tercer recuadro         
            //Firma 3er Cuadro
                $this->SetFont('Arial','',6.5);    
                //Firma 1
                $this->text(169,236,$supte->nombre.' '.$supte->apellido.' - '.$supte->ficha); //nombre del superintendente
                //fecha
                $this->text(169.3,257,$reportazo->fecha_supte);
               
   }//Fin de la función Footer
*/

function Footer(){
            $reportazo = new report();
            $supte = new supte();
            $reportazo->setNmuestra(trim($_POST['nmuestra']));
            $reportazo->setAno(trim($_POST['ano']));
            $ruta = $_POST['ruta'];
            $conexion = conectar_mssql();

            //conexion a la base de datos para extraer datos del pie de pagina.
            //
            $vistaforanea = vistaReportes($ruta);

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

                            if(isset($consulta->analista)){
                            $reportazo->setAnalista ($consulta->analista);
                            }        
                            if (isset($consulta->analista_1)){
                            $reportazo->setAnalista_1($consulta->analista_1);
                            }
                            if (isset($consulta->analista_2)){
                            $reportazo->setAnalista_2($consulta->analista_2);
                            }
                            if (isset($consulta->analista_3)){
                            $reportazo->setAnalista_3($consulta->analista_3);
                            }
                            if (isset($consulta->analista_4)){
                            $reportazo->setAnalista_4($consulta->analista_4);
                            }

                            $reportazo->setFecha_analista($consulta->fecha_analista);

                            //Para Jefe Dpto
                            if (isset($consulta->jefe_dpto)){
                            $reportazo->setJefe_dpto($consulta->jefe_dpto);
                            }
                            if (isset($consulta->jefe_dpto_1)){
                            $reportazo->setJefe_dpto_1($consulta->jefe_dpto_1);
                            }
                            if (isset($consulta->jefe_dpto_2)){
                            $reportazo->setJefe_dpto_2($consulta->jefe_dpto_2);
                            }

                            //para la Fecha
                            if (isset($consulta->fecha_analista_1)){
                            $reportazo->setFecha_analista_1($consulta->fecha_analista_1);
                            $reportazo->setFecha_analista_2($consulta->fecha_analista_2);
                            }
                            if (isset($consulta->fecha_dpto_1)){
                            $reportazo->setFecha_dpto_1($consulta->fecha_dpto_1);
                            $reportazo->setFecha_dpto_2($consulta->fecha_dpto_2);
                            }
                           

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

                        //si existe un analista
                        //
                        if($reportazo->analista){
                        $analista = new analista();
                        $query="SELECT * FROM [dbo].[V_AL20_SCP_SILAB_FORANEOS_personal] WHERE ficha = $reportazo->analista";
                        //enviar query
                        $res_query=mssql_query($query, $conexion);

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
                    
                        //si existen 4 analistas
                        //
                        if($reportazo->analista_1){
                        $analista_uno = new analista();
                        $query="SELECT * FROM [dbo].[V_AL20_SCP_SILAB_FORANEOS_personal] WHERE ficha = $reportazo->analista_1";
                        //enviar query
                        $res_query=mssql_query($query, $conexion);

                        if (isset($res_query)) {
                           while ($consulta = mssql_fetch_object($res_query)){
                             $analista_uno->setNombre(trim($consulta->nombre));
                             $analista_uno->setApellido(trim($consulta->apellido));
                             $analista_uno->setFicha(trim($consulta->ficha));
                            }
                        }else{ 
                                echo '<script>alert("error en la consulta(query)")</script>';
                             }   
                        }

                        if($reportazo->analista_2){
                        $analista_dos = new analista();
                        $query="SELECT * FROM [dbo].[V_AL20_SCP_SILAB_FORANEOS_personal] WHERE ficha = $reportazo->analista_2";
                        //enviar query
                        $res_query=mssql_query($query, $conexion);

                        if (isset($res_query)) 
                        {
                           while ($consulta = mssql_fetch_object($res_query)){
                             $analista_dos->setNombre(trim($consulta->nombre));
                             $analista_dos->setApellido(trim($consulta->apellido));
                             $analista_dos->setFicha(trim($consulta->ficha));
                            }
                        }else{ 
                                echo '<script>alert("error en la consulta(query)")</script>';
                             } 
                        }

                        if($reportazo->analista_3){
                        $analista_tres = new analista();
                        $query="SELECT * FROM [dbo].[V_AL20_SCP_SILAB_FORANEOS_personal] WHERE ficha = $reportazo->analista_3";
                        //enviar query
                        $res_query=mssql_query($query, $conexion);

                        if (isset($res_query)) 
                        {
                           while ($consulta = mssql_fetch_object($res_query)){
                             $analista_tres->setNombre(trim($consulta->nombre));
                             $analista_tres->setApellido(trim($consulta->apellido));
                             $analista_tres->setFicha(trim($consulta->ficha));
                            }
                        }else{ 
                                echo '<script>alert("error en la consulta(query)")</script>';
                             } 
                        }

                        if($reportazo->analista_4){
                        $analista_cuatro = new analista();
                        $query="SELECT * FROM [dbo].[V_AL20_SCP_SILAB_FORANEOS_personal] WHERE ficha = $reportazo->analista_4";
                        //enviar query
                        $res_query=mssql_query($query, $conexion);

                        if (isset($res_query)) 
                        {
                           while ($consulta = mssql_fetch_object($res_query)){
                             $analista_cuatro->setNombre(trim($consulta->nombre));
                             $analista_cuatro->setApellido(trim($consulta->apellido));
                             $analista_cuatro->setFicha(trim($consulta->ficha));
                            }
                        }else{ 
                                echo '<script>alert("error en la consulta(query)")</script>';
                             }  
                        }
                    }


                if (isset($conexion)) 
                {
                    //consulta jefe de departamento
                        if ($reportazo->jefe_dpto) {
                        $jefe_dpto = new jefe_dpto();
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

                        if ($reportazo->jefe_dpto_1) {
                        $jefe_dpto_uno = new jefe_dpto();
                        $query="SELECT * FROM [dbo].[V_AL20_SCP_SILAB_FORANEOS_personal] WHERE ficha = $reportazo->jefe_dpto_1";
                        //enviar query
                        $res_query=mssql_query($query, $conexion);
                        //si no hay problema con la consulta
                        if (isset($res_query)) 
                        {
                           while ($consulta = mssql_fetch_object($res_query)){               
                             $jefe_dpto_uno->setNombre(trim($consulta->nombre));
                             $jefe_dpto_uno->setApellido(trim($consulta->apellido));
                             $jefe_dpto_uno->setFicha(trim($consulta->ficha));
                            }
                        }else{ 
                                echo '<script>alert("error en la consulta(query)")</script>';
                            }
                        }

                        if ($reportazo->jefe_dpto_2) {
                        $jefe_dpto_dos = new jefe_dpto();
                        $query="SELECT * FROM [dbo].[V_AL20_SCP_SILAB_FORANEOS_personal] WHERE ficha = $reportazo->jefe_dpto_2";
                        //enviar query
                        $res_query=mssql_query($query, $conexion);
                        //si no hay problema con la consulta
                        if (isset($res_query)) 
                        {
                           while ($consulta = mssql_fetch_object($res_query)){               
                             $jefe_dpto_dos->setNombre(trim($consulta->nombre));
                             $jefe_dpto_dos->setApellido(trim($consulta->apellido));
                             $jefe_dpto_dos->setFicha(trim($consulta->ficha));
                            }
                        }else{ 
                                echo '<script>alert("error en la consulta(query)")</script>';
                            }
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
                $this->SetFont('Arial','',6);
               
               
            // Líneas horizontales
                //Line($x1,$y1,$x2,$y2)
                $this->Line(11,205,202,205); //primera
                $this->Line(11,239,202,239); //segunda
                $this->Line(11,274,202,274);  //tercera  
         
            // Línes verticales
                $this->Line(85,239,85,274); // recuadro1 
                $this->Line(161,239,161,274); //recuadro2 

            //opiniones e interpretaciones
                $this->SetFont('Arial','B',8);
                $this->text(11,208,"Observaciones:");
                $this->SetFont('Arial','',8);

                $this->SetFont('Arial','',8);
                $this->SetXY(9.5,209); 
                $this->Multicell(0,3, $reportazo->observaciones);

                $this->SetFont('Arial','B',8); 
                $this->text(20,235,utf8_decode("Los análisis aquí reportados corresponden a la(s) muestra(s) aquí identificada(s). La reproducción de estos resultados debe ser"));
                $this->text(79,238,utf8_decode("autorizada por la División de Laboratorio."));
            
            //Primer recuadro
                $this->SetFont('Arial','B',8);
                $this->text(11,242,utf8_decode("Analizado (Técnico - Analista)"));
                $this->SetFont('Arial','',8);
                $this->text(11,246,"Nombre, Apellido/ Nro. Personal"); 

                //Firmas 1er Cuadro
                
                
                //Firma 1 
                $this->text(11,260,"Firma:");
                $this->text(86,260,"Firma:");
                $this->text(162,260,"Firma:");  


                $this->SetFont('Arial','',6.5); 
                if(isset($reportazo->analista)){
                $this->text(20,250,$analista->nombre.' '.$analista->apellido.' - '.$analista->ficha);
                }else{
                    if (isset($reportazo->analista_1)){
                      $this->text(20,250,$analista_uno->nombre.' '.$analista_uno->apellido.' - '.$analista_uno->ficha);  
                    }
                }
                //Firma 2
                if($reportazo->analista_2){
                $this->text(50,250,$analista_dos->nombre.' '.$analista_dos->apellido.' - '.$analista_dos->ficha);
                }
                //Firma 3
                if($reportazo->analista_3){
                $this->text(20,260,$analista_tres->nombre.' '.$analista_tres->apellido.' - '.$analista_tres->ficha);
                }
                //Firma 4
                if($reportazo->analista_4){
                $this->text(50,260,$analista_cuatro->nombre.' '.$analista_cuatro->apellido.' - '.$analista_cuatro->ficha);
                }

                //Firmas 2do Cuadro
                $this->SetFont('Arial','',6.5); 

                //Firma 1
                if(isset($reportazo->jefe_dpto)){
                $this->text(95,253,$jefe_dpto->nombre.' '.$jefe_dpto->apellido.' - '.$jefe_dpto->ficha);
                }else{
                    if(isset($reportazo->jefe_dpto_1)){
                       $this->text(95,253,$jefe_dpto_uno->nombre.' '.$jefe_dpto_uno->apellido.' - '.$jefe_dpto_uno->ficha); 
                    }
                }
                //Firma 2
                if(isset($reportazo->jefe_dpto_2)){
                $this->text(126,253,$jefe_dpto_dos->nombre.' '.$jefe_dpto_dos->apellido.' - '.$jefe_dpto_dos->ficha);  
                }     

            //tercer recuadro         
            //Firma 3er Cuadro
                $this->SetFont('Arial','',6.5);    
                //Firma 1
                $this->text(170,253,$supte->nombre.' '.$supte->apellido.' - '.$supte->ficha); //nombre del superintendente
            
                //Fecha Cuadro 1
                $this->SetFont('Arial','',8);
                $this->text(11,272,"Fecha:"); 
                $this->text(50,272,"Fecha:"); 
                if(isset($reportazo->fecha_analista_1)){
                    $this->text(21,272,$reportazo->fecha_analista_1);
                    $this->text(60,272,$reportazo->fecha_analista_2);
                }else{
                if (isset($reportazo->fecha_analista)){
                    $this->text(21,272,$reportazo->fecha_analista);
                }
                }

                //Fecha Cuadro 2
                $this->SetFont('Arial','',8);
                $this->text(86,272,"Fecha:"); 
                $this->text(125,272,"Fecha:"); 
                if(isset($reportazo->fecha_dpto_1)){
                    $this->text(95,272,$reportazo->fecha_dpto_1);
                    $this->text(135,272,$reportazo->fecha_dpto_2);
                }else{
                if (isset($reportazo->fecha_dpto)){
                    $this->text(95,272,$reportazo->fecha_dpto);
                }
                }

            //segundo recuadro
                $this->SetFont('Arial','B',8);
                $this->text(86,242,"Conformado (Jefe de Departamento");
                $this->text(86,245,utf8_decode("(Laboratorio de Materiales - Laboratorio Químico)")); 
                $this->SetFont('Arial','',8);
                $this->text(86,248,"Nombre, Apellido/ Nro. Personal");

            //tercer recuadro
                $this->SetFont('Arial','B',8);
                $this->text(162,242,"Aprobado");
                $this->text(162,245,utf8_decode("(Jefe División Laboratorio)")); 
                $this->SetFont('Arial','',8);
                $this->text(162,248,"Nombre, Apellido/ Nro. Personal");
            
            //Firma 3er Cuadro
                $this->SetFont('Arial','',8);
                $this->text(162,272,"Fecha:"); 
                $this->text(172,272,$reportazo->fecha_supte);
            //codigo de formulario
                $this->SetFont('Arial','',5);
                $this->text(11,276,"I G - 0 2 0 (1 7 - 0 8 - 2 0 1 5)");     
   }//Fin de la función Footer

    //////////////////////////////
    //Modulo Muestras Especiales//
    //////////////////////////////
    function BodyAluminaPDiaria(){
        //global $conexion;
        $conexion = conectar_mssql();
        $muestra = trim($_POST['nmuestra']);
        $ano1 = trim($_POST['ano']);
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
            
              switch (trim($resultados->cpropiedad)) {

                  case "NA2O":
                        $this->SetFont('Arial','B',9);
                        $this->text(78,$y1,''.trim($resultados->valor));
                        break;

                  case "INA2O":
                        $y1=80;
                        $this->SetFont('Arial','B',9);
                        $this->text(126,$y1,html_entity_decode('&plusmn; ').$resultados->valor);
                        break;
                  
                 case 'IGNICION-3':
                        $this->SetFont('Arial','B',9);
                        $this->text(78,$y2,''.$resultados->valor);
                        

                 case "IIGNICIO-3":
                        $this->SetFont('Arial','B',9);
                        $this->text(126,$y2,html_entity_decode('&plusmn; ').$resultados->valor);
                        break;

                 case 'IGNICION-1':
                        $this->SetFont('Arial','B',9);
                        $this->text(78,$y3,''.$resultados->valor);
                      break;

                  case "IIGNICIO-1":
                        $this->SetFont('Arial','B',9);
                        $this->text(126,$y3,html_entity_decode('&plusmn; ').$resultados->valor);
                        break;

                  case 'MALLA66':
                        $this->SetFont('Arial','B',9);
                        $this->text(78,$y4,''.trim($resultados->valor));
                        break;

                  case "IMALLA66":
                        $this->SetFont('Arial','B',9);
                        $this->text(126,$y4,html_entity_decode('&plusmn; ').trim($resultados->valor));
                        break;          
              } 
            } 

          }else{ 
             $this->text(30,68,"error");
          }    
    }//Cierre de la funcion BodyAluminaPDiaria 

    /////////////////
    //Modulo Carbon//
    /////////////////
    function BodyAntracita(){
            //global $conexion;
            $conexion = conectar_mssql();
            $muestra = trim($_POST['nmuestra']);
            $ano1 = trim($_POST['ano']);
            $this->SetFont('Arial','',9);

            //Para conocer el numero de muestras
            $query="SELECT * FROM [dbo].[V_AL20_SCP_SILAB_FORANEOS_resultados_e] WHERE nmuestra = $muestra AND cmaterial = 'Antracita' AND ano = $ano1";
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
    }//Cierre de la funcion BodyAntracita

    //////////////////////////////////////////
    //Modulo Agua y Particulas Sedimentables//
    //////////////////////////////////////////
    function BodyAguaPTermo(){
            //global $conexion;
            $conexion = conectar_mssql();
            $muestra = trim($_POST['nmuestra']);
            $ano1 = trim($_POST['ano']);
            $this->SetFont('Arial','',9);

            $query="SELECT * FROM [dbo].[V_AL20_SCP_SILAB_FORANEOS_resultados_agua_y_sedimentales] WHERE nmuestra = $muestra AND cmaterial = 'AGUA POTABLE T           ' AND ano = $ano1";

            $res_query=mssql_query($query, $conexion);
            if (isset($res_query)) {  

                while ($resultados = mssql_fetch_object($res_query)){
                
                  switch (trim($resultados->cpropiedad)) {

                      case "COLOR":
                            if (trim($resultados->valor) < 5)
                                $this->text(127,90,'< 5');
                            else
                                if (trim($resultados->valor) >= 5)
                                    $this->text(127,90,str_replace('.', ',',trim($resultados->valor)));
                            break;

                      case "UNT":
                            if (trim($resultados->valor) <= 0.1)
                                $this->text(127,96,'< 0,1');
                            else
                                if (trim($resultados->valor) > 0.1)
                                    $this->text(127,96,str_replace('.', ',',trim($resultados->valor)));
                            break;
                      
                     case "PH":
                            if (trim($resultados->valor) <= 0.1)
                                $this->text(127,102,'0,1');
                            else
                                if (trim($resultados->valor) > 0.1)
                                    $this->text(127,102,str_replace('.', ',',trim($resultados->valor)));
                            break;
                            
                     case "CL2":
                            if (trim($resultados->valor) <= 0.1)
                                $this->text(127,108,'< 0,1');
                            else
                                if (trim($resultados->valor) > 0.1)
                                    $this->text(127,108,str_replace('.', ',',trim($resultados->valor)));
                            break;

                     case "CL-":
                            if (trim($resultados->valor) <= 0.1)
                                $this->text(127,115,'< 0,1');
                            else
                                if (trim($resultados->valor) > 0.1)
                                    $this->text(127,115,str_replace('.', ',',trim($resultados->valor)));
                            break;

                      case "STDISUELTO":
                            if (trim($resultados->valor) <= 0.1)
                                $this->text(127,121,'< 0,1');
                            else
                                if (trim($resultados->valor) > 0.1)
                                    $this->text(127,121,str_replace('.', ',',trim($resultados->valor)));
                            break;

                      case "CACO3 TOT":
                            if (trim($resultados->valor) <= 0.1)
                                $this->text(127,127,'< 0,1');
                            else
                                if (trim($resultados->valor) > 0.1)
                                    $this->text(127,127,str_replace('.', ',',trim($resultados->valor)));
                            break;

                      case "CACO3 CALC":
                            if (trim($resultados->valor) <= 0.1)
                                $this->text(127,133,'< 0,1');
                            else
                                if (trim($resultados->valor) > 0.1)
                                    $this->text(127,133,str_replace('.', ',',trim($resultados->valor)));
                            break;   
                      case "SO4":
                            if (trim($resultados->valor) <= 0.1)
                                $this->text(127,139,'< 0,1');
                            else
                                if (trim($resultados->valor) > 0.1)
                                    $this->text(127,139,str_replace('.', ',',trim($resultados->valor)));
                            break; 
                      case "AL RESD":
                            if (trim($resultados->valor) <= 0.1)
                                $this->text(127,145,'< 0,1');
                            else
                                if (trim($resultados->valor) > 0.1)
                                    $this->text(127,145,str_replace('.', ',',trim($resultados->valor)));
                            break; 
                      case "FE TOTAL":
                            if (trim($resultados->valor) <= 0.1)
                                $this->text(127,151,'< 0,1');
                            else
                                if (trim($resultados->valor) > 0.1)
                                    $this->text(127,151,str_replace('.', ',',trim($resultados->valor)));
                            break;
                      case "NO2-":
                            if (trim($resultados->valor) <= 0.01)
                                $this->text(127,158,'< 0,01');
                            else
                                if (trim($resultados->valor) > 0.01)
                                    $this->text(127,158,str_replace('.', ',',trim($resultados->valor)));
                            break;
                      case "NO3-":
                            if (trim($resultados->valor) <= 0.1)
                                $this->text(127,164,'< 0,01');
                            else
                                if (trim($resultados->valor) > 0.1)
                                    $this->text(127,164,str_replace('.', ',',trim($resultados->valor)));
                            break;
                      case "F-   AGUA":
                            if (trim($resultados->valor) <= 0.1)
                                $this->text(127,170,'< 0,01');
                            else
                                if (trim($resultados->valor) > 0.1)
                                    $this->text(127,170,str_replace('.', ',',trim($resultados->valor)));
                            break;
                      case "MPN":
                            if (trim($resultados->valor) <= 0.1)
                                $this->text(127,176,'Ausentes');
                            else
                                if (trim($resultados->valor) > 0.1)
                                    $this->text(127,176,str_replace('.', ',',trim($resultados->valor)));
                            break;
                  } 
                } 

              }else{ 
                 $this->text(30,68,"error");
              }    
            
    }//Cierre de la funcion BodyAguaPTermo

    function BodyAguaAmbiental(){
            //global $conexion;
            $conexion = conectar_mssql();
            $muestra = trim($_POST['nmuestra']);
            $ano1 = trim($_POST['ano']);
            $this->SetFont('Arial','',9);

            $query="SELECT * FROM [dbo].[V_AL20_SCP_SILAB_FORANEOS_resultados_agua_y_sedimentales] WHERE nmuestra = $muestra AND cmaterial = 'CANAL DESECHO CATODICO   ' AND ano = $ano1";

            $res_query=mssql_query($query, $conexion);
            if (isset($res_query)) {  

                while ($resultados = mssql_fetch_object($res_query)){
                
                  switch (trim($resultados->cpropiedad)) {

                      case "TEMP":
                            if (round(trim($resultados->valor)) < 5)
                                $this->text(127,88,'< 5');
                            else
                                if (round(trim($resultados->valor)) >= 5)
                                    $this->text(127,88,str_replace('.', ',',round(trim($resultados->valor))));
                            break;

                      case "PH":
                            if (round(trim($resultados->valor)) <= 0.1)
                                $this->text(127,94,'< 0,1');
                            else
                                if (round(trim($resultados->valor)) > 0.1)
                                    $this->text(127,94,str_replace('.', ',',round(trim($resultados->valor))));
                            break;
                      
                     case "CL-":
                            if (round(trim($resultados->valor)) <= 0.1)
                                $this->text(127,100,'< 0,1');
                            else
                                if (round(trim($resultados->valor)) > 0.1)
                                    $this->text(127,100,str_replace('.', ',',round(trim($resultados->valor))));
                            break;
                            
                     case "DBO5":
                            if (round(trim($resultados->valor)) <= 0.1)
                                $this->text(127,106,'< 0,1');
                            else
                                if (round(trim($resultados->valor)) > 0.1)
                                    $this->text(127,106,str_replace('.', ',',round(trim($resultados->valor))));
                            break;

                     case "DQO":
                            if (round(trim($resultados->valor)) <= 0.1)
                                $this->text(127,113,'< 0,1');
                            else
                                if (trim($resultados->valor) > 0.1)
                                    $this->text(127,113,str_replace('.', ',',round(trim($resultados->valor))));
                            break;

                      case "FE":
                            if (trim($resultados->valor) <= 0.1)
                                $this->text(127,119,'< 0,1');
                            else
                                if (trim($resultados->valor) > 0.1)
                                    $this->text(127,119,str_replace('.', ',',round(trim($resultados->valor))));
                            break;

                      case "F-   AGUA":
                            if (trim($resultados->valor) <= 0.1)
                                $this->text(127,125,'< 0,1');
                            else
                                if (round(trim($resultados->valor)) > 0.1)
                                    $this->text(127,125,str_replace('.', ',',round(trim($resultados->valor))));
                            break;

                      case "SO4":
                            if (round(trim($resultados->valor)) <= 0.1)
                                $this->text(127,131,'< 0,1');
                            else
                                if (round(trim($resultados->valor)) > 0.1)
                                    $this->text(127,131,str_replace('.', ',',round(trim($resultados->valor))));
                            break;   
                      case "SOL_SUSP":
                            if (round(trim($resultados->valor)) <= 0.1)
                                $this->text(127,137,'< 0,1');
                            else
                                if (round(trim($resultados->valor)) > 0.1)
                                    $this->text(127,137,str_replace('.', ',',round(trim($resultados->valor))));
                            break; 
                      case "SOL_SEDIME":
                            if (round(trim($resultados->valor)) <= 0.1)
                                $this->text(127,143,'< 0,1');
                            else
                                if (round(trim($resultados->valor)) > 0.1)
                                    $this->text(127,143,str_replace('.', ',',round(trim($resultados->valor))));
                            break; 
                      case "ACE_GRASAS":
                            if (round(trim($resultados->valor)) <= 0.1)
                                $this->text(127,149,'< 0,1');
                            else
                                if (round(trim($resultados->valor)) > 0.1)
                                    $this->text(127,149,str_replace('.', ',',round(trim($resultados->valor))));
                            break;
                      case "AL RESD":
                            if (round(trim($resultados->valor)) <= 0.01)
                                $this->text(127,156,'< 0,01');
                            else
                                if (round(trim($resultados->valor)) > 0.01)
                                    $this->text(127,156,str_replace('.', ',',round(trim($resultados->valor))));
                            break;
                      case "N":
                            if (round(trim($resultados->valor)) <= 0.1)
                                $this->text(127,162,'< 0,01');
                            else
                                if (round(trim($resultados->valor)) > 0.1)
                                    $this->text(127,162,str_replace('.', ',',round(trim($resultados->valor))));
                            break;
                      case "P":
                            if (round(trim($resultados->valor)) <= 0.1)
                                $this->text(127,168,'< 0,1');
                            else
                                if (round(trim($resultados->valor)) > 0.1)
                                    $this->text(127,168,str_replace('.', ',',round(trim($resultados->valor))));
                            break;
                      case "FENOLES":
                            if (round(trim($resultados->valor)) <= 0.01)
                                $this->text(127,174,'< 0,01');
                            else
                                if (round(trim($resultados->valor)) > 0.01)
                                    $this->text(127,174,str_replace('.', ',',round(trim($resultados->valor))));
                            break;
                      case "MPN":
                            if (round(trim($resultados->valor)) <= 0.1)
                                $this->text(127,181,'Ausentes');
                            else
                                if (round(trim($resultados->valor)) > 0.1)
                                    $this->text(127,181,str_replace('.', ',',round(trim($resultados->valor))));
                            break;
                  } 
                } 

              }else{ 
                 $this->text(30,68,"error");
              }    
            
    }//Cierre de la funcion BodyAguaAmbiental

    function BodyAguaIndustrial(){
            //global $conexion;
            $conexion = conectar_mssql();
            $muestra = trim($_POST['nmuestra']);
            $ano1 = trim($_POST['ano']);
            $this->SetFont('Arial','',9);


            //Para conocer el numero de muestras
            $query="SELECT * FROM [dbo].[V_AL20_SCP_SILAB_FORANEOS_resultados_agua_y_sedimentales] WHERE nmuestra = $muestra AND ano = $ano1";
            $res_query=mssql_query($query, $conexion);
            if (isset($res_query)) {
                
                while ($resultados = mssql_fetch_object($res_query)){

                    if ((trim($resultados->cmaterial)!='COMPRESOR CENTAC CIRC') && (trim($resultados->cmaterial)!='COMPRESOR CENTAC SECA')) {
                        $material_1='REPOSICION';
                        $material_2='RECIRCULACION';
                    }else{
                        if (trim($resultados->cmaterial)=='COMPRESOR CENTAC CIRC'){
                            $material_1='CIRC. ABIERTO';
                            $material_2='CIRC. CERRADO';
                        }else{
                            $material_1='AIRE G7';
                            $material_2='UNID. CENTRAC';
                        }
                    }

                }
            }

            //para conocer el titulo de la columna 4
            //REVISAR
            $query="SELECT * FROM [dbo].[V_AL20_SCP_SILAB_FORANEOS_resultados_agua_y_sedimentales] WHERE nmuestra = $muestra AND RTRIM(cmaterial) = '$material_1'  AND ano = $ano1";
            $res_query=mssql_query($query, $conexion);
            if (isset($res_query)) {   
             $this->SetFont('Arial','B',9);
                    if (trim($resultados->cmaterial) == 'COMPRESOR CENTAC SECA') {
                        $this->text(101,74, 'Secadora');
                        $this->text(101,78, 'Aire G7');
                    }
                    
                    if (trim($resultados->cmaterial) == 'ENVARILL. TORRE 2-3'){
                        $this->text(101,74, 'Torre II');
                    }
                    
                    if ((trim($resultados->cmaterial) != 'ENVARILLADO TORRE 1') && (trim($resultados->cmaterial) !=  'ENVARILL. TORRE 2-3') && (trim($resultados->cmaterial) != 'COMPRESOR CENTAC SECA')){
                                $this->text(101,74, 'Reposicion');
                    }
                    if (trim($resultados->cmaterial) == 'ENVARILLADO TORRE 1'){
                        $this->text(101,74, 'Recirculacion');
                        $this->text(101,78, 'Externa');
                    }


                }
            
            //para conocer el titulo de la columna 5
            //REVISAR
            $query="SELECT * FROM [dbo].[V_AL20_SCP_SILAB_FORANEOS_resultados_agua_y_sedimentales] WHERE nmuestra = $muestra AND RTRIM(cmaterial) = '$material_2'  AND ano = $ano1";
            $res_query=mssql_query($query, $conexion);
            if (isset($res_query)) {   
             $this->SetFont('Arial','B',9);
                    if (trim($resultados->cmaterial) == 'COMPRESOR CENTAC SECA') {
                        $this->text(126,74, 'Unidad');
                        $this->text(126,78, 'Centac');
                    }
                    
                    if (trim($resultados->cmaterial) == 'ENVARILL. TORRE 2-3'){
                        $this->text(126,74, 'Torre III');
                    }
                    
                    if ((trim($resultados->cmaterial) != 'ENVARILLADO TORRE 1') && (trim($resultados->cmaterial) !=  'ENVARILL. TORRE 2-3') && (trim($resultados->cmaterial) != 'COMPRESOR CENTAC SECA')){
                                $this->text(126,74, 'Recirculacion');
                    }
                    if (trim($resultados->cmaterial) == 'ENVARILLADO TORRE 1'){
                        $this->text(126,74, 'Recirculacion');
                        $this->text(126,78, 'Interna');
                    }


                }
            
            
            //Datos Columna 4
            $query="SELECT * FROM [dbo].[V_AL20_SCP_SILAB_FORANEOS_resultados_agua_y_sedimentales] WHERE nmuestra = $muestra AND RTRIM(cmaterial) = '$material_1'  AND ano = $ano1";

            $res_query=mssql_query($query, $conexion);
            if (isset($res_query)) {  
                $this->SetFont('Arial','',9);
                while ($resultados = mssql_fetch_object($res_query)){
                
                  switch (trim($resultados->cpropiedad)) {

                      case "TEMP":
                            if (round(trim($resultados->valor)) < 0.01)
                                $this->text(110,86,'< 0,01');
                            else
                                if (round(trim($resultados->valor)) > 0.01)
                                    $this->text(110,86,str_replace('.', ',',round(trim($resultados->valor))));
                            break;

                      case "PH":
                            if (round(trim($resultados->valor)) <= 0.01)
                                $this->text(110,92,'< 0,01');
                            else
                                if (round(trim($resultados->valor)) > 0.01)
                                    $this->text(110,92,str_replace('.', ',',round(trim($resultados->valor))));
                            break;
                      
                     case "CM-1":
                            if (round(trim($resultados->valor)) <= 0.01)
                                $this->text(110,98,'< 0,01');
                            else
                                if (round(trim($resultados->valor)) > 0.01)
                                    $this->text(110,98,str_replace('.', ',',round(trim($resultados->valor))));
                            break;
                            
                     case "CL-":
                            if (round(trim($resultados->valor)) <= 0.01)
                                $this->text(110,104,'< 0,01');
                            else
                                if (round(trim($resultados->valor)) > 0.01)
                                    $this->text(110,104,str_replace('.', ',',round(trim($resultados->valor))));
                            break;

                     case "CAC03 ALC":
                            if (round(trim($resultados->valor)) <= 0.01)
                                $this->text(110,111,'< 0,01');
                            else
                                if (trim($resultados->valor) > 0.01)
                                    $this->text(110,111,str_replace('.', ',',round(trim($resultados->valor))));
                            break;

                      case "CACO3 TOT":
                            if (trim($resultados->valor) <= 0.01)
                                $this->text(110,117,'< 0,01');
                            else
                                if (trim($resultados->valor) > 0.01)
                                    $this->text(110,117,str_replace('.', ',',round(trim($resultados->valor))));
                            break;

                      case "CACO3 CALC":
                            if (trim($resultados->valor) <= 0.01)
                                $this->text(110,123,'< 0,01');
                            else
                                if (round(trim($resultados->valor)) > 0.01)
                                    $this->text(110,123,str_replace('.', ',',round(trim($resultados->valor))));
                            break;

                      case "SIO2 - H2O":
                            if (round(trim($resultados->valor)) <= 0.01)
                                $this->text(110,129,'< 0,01');
                            else
                                if (round(trim($resultados->valor)) > 0.01)
                                    $this->text(110,129,str_replace('.', ',',round(trim($resultados->valor))));
                            break;   
                      case "SO4":
                            if (round(trim($resultados->valor)) <= 1)
                                $this->text(110,135,'< 1');
                            else
                                if (round(trim($resultados->valor)) > 1)
                                    $this->text(110,135,str_replace('.', ',',round(trim($resultados->valor))));
                            break; 
                      case "F-   AGUA":
                            if (round(trim($resultados->valor)) <= 0.1)
                                $this->text(110,141,'< 0,1');
                            else
                                if (round(trim($resultados->valor)) > 0.1)
                                    $this->text(110,141,str_replace('.', ',',round(trim($resultados->valor))));
                            break; 
                      case "N":
                            if (round(trim($resultados->valor)) <= 0.01)
                                $this->text(110,147,'< 0,01');
                            else
                                if (round(trim($resultados->valor)) > 0.01)
                                    $this->text(110,147,str_replace('.', ',',round(trim($resultados->valor))));
                            break;
                      case "ACE_GRASAS":
                            if (round(trim($resultados->valor)) <= 0.1)
                                $this->text(110,154,'< 0,1');
                            else
                                if (round(trim($resultados->valor)) > 0.1)
                                    $this->text(110,154,str_replace('.', ',',round(trim($resultados->valor))));
                            break;
                      case "FE TOTAL":
                            if (round(trim($resultados->valor)) <= 0.1)
                                $this->text(110,160,'< 0,1');
                            else
                                if (round(trim($resultados->valor)) > 0.1)
                                    $this->text(110,160,str_replace('.', ',',round(trim($resultados->valor))));
                            break;
                      case "SOL_TOTAL":
                            if (round(trim($resultados->valor)) <= 0.01)
                                $this->text(110,166,'< 0,01');
                            else
                                if (round(trim($resultados->valor)) > 0.01)
                                    $this->text(110,166,str_replace('.', ',',round(trim($resultados->valor))));
                            break;
                      case "SOL_SUSPEN":
                            if (round(trim($resultados->valor)) <= 0.01)
                                $this->text(110,172,'< 0,01');
                            else
                                if (round(trim($resultados->valor)) > 0.01)
                                    $this->text(110,172,str_replace('.', ',',round(trim($resultados->valor))));
                            break;
                      case "SOL_VOLAT":
                            if (round(trim($resultados->valor)) <= 0.01)
                                $this->text(110,179,'< 0,01');
                            else
                                if (round(trim($resultados->valor)) > 0.01)
                                    $this->text(110,179,str_replace('.', ',',round(trim($resultados->valor))));
                            break;
                      case "STDISUELTO":
                            if (round(trim($resultados->valor)) <= 0.01)
                                $this->text(110,184,'< 0,01');
                            else
                                if (round(trim($resultados->valor)) > 0.01)
                                    $this->text(110,184,str_replace('.', ',',round(trim($resultados->valor))));
                            break;
                  } 

                } 

              }else{ 
                 $this->text(30,68,"error");
              }    

            //Datos Columna 5   
            $query="SELECT * FROM [dbo].[V_AL20_SCP_SILAB_FORANEOS_resultados_agua_y_sedimentales] WHERE nmuestra = $muestra AND RTRIM(cmaterial) = '$material_2'  AND ano = $ano1";

            $res_query=mssql_query($query, $conexion);
            if (isset($res_query)) {  
                $this->SetFont('Arial','',9);
                while ($resultados = mssql_fetch_object($res_query)){
                
                  switch (trim($resultados->cpropiedad)) {

                      case "TEMP":
                            if (round(trim($resultados->valor)) < 0.01)
                                $this->text(134,86,'< 0,01');
                            else
                                if (round(trim($resultados->valor)) > 0.01)
                                    $this->text(134,86,str_replace('.', ',',round(trim($resultados->valor))));
                            break;

                      case "PH":
                            if (round(trim($resultados->valor)) <= 0.01)
                                $this->text(134,92,'< 0,01');
                            else
                                if (round(trim($resultados->valor)) > 0.01)
                                    $this->text(134,92,str_replace('.', ',',round(trim($resultados->valor))));
                            break;
                      
                     case "CM-1":
                            if (round(trim($resultados->valor)) <= 0.01)
                                $this->text(134,98,'< 0,01');
                            else
                                if (round(trim($resultados->valor)) > 0.01)
                                    $this->text(134,98,str_replace('.', ',',round(trim($resultados->valor))));
                            break;
                            
                     case "CL-":
                            if (round(trim($resultados->valor)) <= 0.01)
                                $this->text(134,104,'< 0,01');
                            else
                                if (round(trim($resultados->valor)) > 0.01)
                                    $this->text(134,104,str_replace('.', ',',round(trim($resultados->valor))));
                            break;

                     case "CAC03 ALC":
                            if (round(trim($resultados->valor)) <= 0.01)
                                $this->text(134,111,'< 0,01');
                            else
                                if (trim($resultados->valor) > 0.01)
                                    $this->text(134,111,str_replace('.', ',',round(trim($resultados->valor))));
                            break;

                      case "CACO3 TOT":
                            if (trim($resultados->valor) <= 0.01)
                                $this->text(134,117,'< 0,01');
                            else
                                if (trim($resultados->valor) > 0.01)
                                    $this->text(134,117,str_replace('.', ',',round(trim($resultados->valor))));
                            break;

                      case "CACO3 CALC":
                            if (trim($resultados->valor) <= 0.01)
                                $this->text(134,123,'< 0,01');
                            else
                                if (round(trim($resultados->valor)) > 0.01)
                                    $this->text(134,123,str_replace('.', ',',round(trim($resultados->valor))));
                            break;

                      case "SIO2 - H2O":
                            if (round(trim($resultados->valor)) <= 0.01)
                                $this->text(134,129,'< 0,01');
                            else
                                if (round(trim($resultados->valor)) > 0.01)
                                    $this->text(134,129,str_replace('.', ',',round(trim($resultados->valor))));
                            break;   
                      case "SO4":
                            if (round(trim($resultados->valor)) <= 1)
                                $this->text(134,135,'< 1');
                            else
                                if (round(trim($resultados->valor)) > 1)
                                    $this->text(134,135,str_replace('.', ',',round(trim($resultados->valor))));
                            break; 
                      case "F-   AGUA":
                            if (round(trim($resultados->valor)) <= 0.1)
                                $this->text(134,141,'< 0,1');
                            else
                                if (round(trim($resultados->valor)) > 0.1)
                                    $this->text(134,141,str_replace('.', ',',round(trim($resultados->valor))));
                            break; 
                      case "N":
                            if (round(trim($resultados->valor)) <= 0.01)
                                $this->text(134,147,'< 0,01');
                            else
                                if (round(trim($resultados->valor)) > 0.01)
                                    $this->text(134,147,str_replace('.', ',',round(trim($resultados->valor))));
                            break;
                      case "ACE_GRASAS":
                            if (round(trim($resultados->valor)) <= 0.1)
                                $this->text(134,154,'< 0,1');
                            else
                                if (round(trim($resultados->valor)) > 0.1)
                                    $this->text(134,154,str_replace('.', ',',round(trim($resultados->valor))));
                            break;
                      case "FE TOTAL":
                            if (round(trim($resultados->valor)) <= 0.1)
                                $this->text(134,160,'< 0,1');
                            else
                                if (round(trim($resultados->valor)) > 0.1)
                                    $this->text(134,160,str_replace('.', ',',round(trim($resultados->valor))));
                            break;
                      case "SOL_TOTAL":
                            if (round(trim($resultados->valor)) <= 0.01)
                                $this->text(134,166,'< 0,01');
                            else
                                if (round(trim($resultados->valor)) > 0.01)
                                    $this->text(134,166,str_replace('.', ',',round(trim($resultados->valor))));
                            break;
                      case "SOL_SUSPEN":
                            if (round(trim($resultados->valor)) <= 0.01)
                                $this->text(134,172,'< 0,01');
                            else
                                if (round(trim($resultados->valor)) > 0.01)
                                    $this->text(134,172,str_replace('.', ',',round(trim($resultados->valor))));
                            break;
                      case "SOL_VOLAT":
                            if (round(trim($resultados->valor)) <= 0.01)
                                $this->text(134,179,'< 0,01');
                            else
                                if (round(trim($resultados->valor)) > 0.01)
                                    $this->text(134,179,str_replace('.', ',',round(trim($resultados->valor))));
                            break;
                      case "STDISUELTO":
                            if (round(trim($resultados->valor)) <= 0.01)
                                $this->text(134,184,'< 0,01');
                            else
                                if (round(trim($resultados->valor)) > 0.01)
                                    $this->text(134,184,str_replace('.', ',',round(trim($resultados->valor))));
                            break;
                  } 

                } 

              }else{ 
                 $this->text(30,68,"error");
              } 

    }//Cierre de la funcion BodyAguaIndustrial

    /*function BodyAguaPHielo(){
            //global $conexion;
            $conexion = conectar_mssql();
            $muestra = trim($_POST['nmuestra']);
            $ano1 = trim($_POST['ano']);
            $this->SetFont('Arial','',9);

            $query="SELECT * FROM [dbo].[V_AL20_SCP_SILAB_FORANEOS_resultados_agua_y_sedimentales] WHERE nmuestra = $muestra AND cmaterial = 'AGUA POTABLE T           ' AND ano = $ano1";

            $res_query=mssql_query($query, $conexion);
            if (isset($res_query)) {  

                while ($resultados = mssql_fetch_object($res_query)){
                
                  switch (trim($resultados->cpropiedad)) {

                      case "COLOR":
                            if (trim($resultados->valor) < 5)
                                $this->text(127,90,'< 5');
                            else
                                if (trim($resultados->valor) >= 5)
                                    $this->text(127,90,str_replace('.', ',',trim($resultados->valor)));
                            break;

                      case "UNT":
                            if (trim($resultados->valor) <= 0.1)
                                $this->text(127,96,'< 0,1');
                            else
                                if (trim($resultados->valor) > 0.1)
                                    $this->text(127,96,str_replace('.', ',',trim($resultados->valor)));
                            break;
                      
                     case "PH":
                            if (trim($resultados->valor) <= 0.1)
                                $this->text(127,102,'0,1');
                            else
                                if (trim($resultados->valor) > 0.1)
                                    $this->text(127,102,str_replace('.', ',',trim($resultados->valor)));
                            break;
                            
                     case "CL2":
                            if (trim($resultados->valor) <= 0.1)
                                $this->text(127,108,'< 0,1');
                            else
                                if (trim($resultados->valor) > 0.1)
                                    $this->text(127,108,str_replace('.', ',',trim($resultados->valor)));
                            break;

                     case "CL-":
                            if (trim($resultados->valor) <= 0.1)
                                $this->text(127,115,'< 0,1');
                            else
                                if (trim($resultados->valor) > 0.1)
                                    $this->text(127,115,str_replace('.', ',',trim($resultados->valor)));
                            break;

                      case "STDISUELTO":
                            if (trim($resultados->valor) <= 0.1)
                                $this->text(127,121,'< 0,1');
                            else
                                if (trim($resultados->valor) > 0.1)
                                    $this->text(127,121,str_replace('.', ',',trim($resultados->valor)));
                            break;

                      case "CACO3 TOT":
                            if (trim($resultados->valor) <= 0.1)
                                $this->text(127,127,'< 0,1');
                            else
                                if (trim($resultados->valor) > 0.1)
                                    $this->text(127,127,str_replace('.', ',',trim($resultados->valor)));
                            break;

                      case "CACO3 CALC":
                            if (trim($resultados->valor) <= 0.1)
                                $this->text(127,133,'< 0,1');
                            else
                                if (trim($resultados->valor) > 0.1)
                                    $this->text(127,133,str_replace('.', ',',trim($resultados->valor)));
                            break;   
                      case "SO4":
                            if (trim($resultados->valor) <= 0.1)
                                $this->text(127,139,'< 0,1');
                            else
                                if (trim($resultados->valor) > 0.1)
                                    $this->text(127,139,str_replace('.', ',',trim($resultados->valor)));
                            break; 
                      case "AL RESD":
                            if (trim($resultados->valor) <= 0.1)
                                $this->text(127,145,'< 0,1');
                            else
                                if (trim($resultados->valor) > 0.1)
                                    $this->text(127,145,str_replace('.', ',',trim($resultados->valor)));
                            break; 
                      case "FE TOTAL":
                            if (trim($resultados->valor) <= 0.1)
                                $this->text(127,151,'< 0,1');
                            else
                                if (trim($resultados->valor) > 0.1)
                                    $this->text(127,151,str_replace('.', ',',trim($resultados->valor)));
                            break;
                      case "NO2-":
                            if (trim($resultados->valor) <= 0.01)
                                $this->text(127,158,'< 0,01');
                            else
                                if (trim($resultados->valor) > 0.01)
                                    $this->text(127,158,str_replace('.', ',',trim($resultados->valor)));
                            break;
                      case "NO3-":
                            if (trim($resultados->valor) <= 0.1)
                                $this->text(127,164,'< 0,01');
                            else
                                if (trim($resultados->valor) > 0.1)
                                    $this->text(127,164,str_replace('.', ',',trim($resultados->valor)));
                            break;
                      case "F-   AGUA":
                            if (trim($resultados->valor) <= 0.1)
                                $this->text(127,170,'< 0,01');
                            else
                                if (trim($resultados->valor) > 0.1)
                                    $this->text(127,170,str_replace('.', ',',trim($resultados->valor)));
                            break;
                      case "MPN":
                            if (trim($resultados->valor) <= 0.1)
                                $this->text(127,176,'Ausentes');
                            else
                                if (trim($resultados->valor) > 0.1)
                                    $this->text(127,176,str_replace('.', ',',trim($resultados->valor)));
                            break;
                  } 
                } 

              }else{ 
                 $this->text(30,68,"error");
              }    
            
    }//Cierre de la funcion BodyAguaPHielo
    */
}

// initiate FPDI
    $pdf = new PDF_IG_020('P','mm','A4');
    $pdf->AliasNbPages();
// add a page
   
    $pdf->AddPage();
//asigna el nombre al pdf generado
    $material = (trim($_POST['material']));
    switch ($material) 
    {
        //////////////////////////////
        //Modulo Muestras Especiales//
        //////////////////////////////
        case 'AluminaPDiaria':
            $doc = 'Alumina Primaria Diaria';
            break;

        /////////////////
        //Modulo Carbon//
        /////////////////
        case 'Antracita':
            $doc = 'Antracita';
            break; 

        //////////////////////////////////////////
        //Modulo Agua y Particulas Sedimentables//
        //////////////////////////////////////////
        case 'AguaPTermo':
            $doc = 'AguaPTermo';
            break; 
        case 'AguaAmbiental':
            $doc = 'AguaAmbiental';
            break; 
        case 'AguaIndustrial':
            $doc = 'AguaIndustrial';
            break; 
        case 'AguaPHielo':
            $doc = 'AguaPHielo';
            break; 
    }
// crea el archivo pdf en la ruta especificada y muestra en pantalla el pdf
    $filePath = 'E:\web\SILAB\Temp7\ ';
    $pdf->Output(trim($filePath).$doc.'.pdf',"F");
    $pdf->Output();

?>