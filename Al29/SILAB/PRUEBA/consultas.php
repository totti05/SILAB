<?php
if(isset($_GET['callback'])){ // Si ha llegado callback
    require('conexion.php');
    require('clases.php');
    require('../JSON.php');
   header("Access-Control-Allow-Origin: *");
    header("Access-Control-Allow-Headers: x-requested-with");
    header("Access-Control-Allow-Origin: http://control/SCP/modules/SILAB/PRUEBA/consultas.php");

/*
        if (isset($_SERVER['HTTP_ORIGIN'])) {  
        header("Access-Control-Allow-Origin: {$_SERVER['HTTP_ORIGIN']}");  
        header('Access-Control-Allow-Credentials: true');  
        header('Access-Control-Max-Age: 86400');   
    }  
      
    if ($_SERVER['REQUEST_METHOD'] == 'OPTIONS') {  
      
        if (isset($_SERVER['HTTP_ACCESS_CONTROL_REQUEST_METHOD']))  
            header("Access-Control-Allow-Methods: GET, POST, PUT, DELETE, OPTIONS");  
      
        if (isset($_SERVER['HTTP_ACCESS_CONTROL_REQUEST_HEADERS']))  
            header("Access-Control-Allow-Headers: {$_SERVER['HTTP_ACCESS_CONTROL_REQUEST_HEADERS']}");  
    }  */
    function consultar()
    {
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

            return $reportazo;
    }
    
$obj = consultar();

  $arrayobj = get_object_vars($obj);
  
  $json = new Services_JSON;
  
  $jsonobj = $json->encode($arrayobj);
  
  
  
  
        
        $array = array("mensaje" => "Hola desde mi otro servidor haciendo cross domain con ajax"); 
         echo $_GET['callback'].'('.$json->encode($array).')'; }
?>

  