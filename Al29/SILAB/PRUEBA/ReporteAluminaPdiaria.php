<?php
    // llamada libreria
    require ('PDF class.php');
    require ('clases.php');
    // llamada archivo de funciones para conectar a la BD
    //require('conexion.php');

 
   
    $conexion = conectar_mssql();
    
    $reportazo = new report();
    
    $reportazo->setNmuestra(trim($_POST['nmuestra']));
    
    if (isset($conexion)) {
         $query="SELECT * FROM [dbo].[V_AL20_SCP_SILAB_FORANEOS_muestras_e] WHERE nmuestra = $reportazo->nmuestra AND ano = '2017' ";
          //enviar query
          //mssql_query($query, $conexion) or die ("<h2>error al enviar datos a la bs</h2>"); 
            
          $res_query=mssql_query($query, $conexion);
          //si no hay problema con la consulta
          if (isset($res_query)) {

            while ($consulta = mssql_fetch_object($res_query)){
                
                $reportazo->setCmaterial($consulta->cmaterial);
                $reportazo->setAno($consulta->ano);
                $reportazo->setNmuestra($consulta->muestra);
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
    
    
    $pdf= new PDF_IG_020('P','mm','A4');
    
    $pdf->AliasNbPages();
    $pdf->AddPage();
    $pdf->Output();

?> 