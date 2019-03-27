<?php 
      require_once 'conexion.php';
      $conexion = conectar_mssql();
      class report {
        var $nmuestra;
        var $cmaterial;
        function setNmuestra ($muestra){
                 
         $this->nmuestra = $muestra;
        }
        function setCmaterial ($material){
                 
         $this->cmaterial = $material;
        }
      }

      $reporte = new report();
      $reporte->setNmuestra(trim($_POST['nmuestra']));
      $reporte->setCmaterial('ALUMINA PRIMARIA DIA');
      echo 'numero de muestra introducido:'.$reporte->nmuestra;
      
      // esto consulta informacion del reporte


      if (isset($conexion)) {
         $query="SELECT * FROM [dbo].[V_AL20_SCP_SILAB_FORANEOS_muestras_e] WHERE nmuestra = '".$reporte->nmuestra."'";
          //enviar query
          //mssql_query($query, $conexion) or die ("<h2>error al enviar datos a la bs</h2>"); 

          $res_query=mssql_query($query, $conexion);
          //si no hay problema con la consulta
          if (isset($res_query)) {

            while ($reportazo = mssql_fetch_object($res_query)){



             // echo ''.var_dump(get_object_vars($reportazo));

              echo '<h2>Reporte de Material:</b>'.trim($reportazo->cmaterial).'</h2>';
              echo '<p><b>Material:</b>'.trim($reportazo->cmaterial).'</p>';
              echo '<p><b>a&ntilde;o: NO SE MUESTRA</b>'.trim($reportazo->$ano).'</p>';
              echo '<p><b>numero de muestra:</b>'.trim($reportazo->nmuestra).'</p>';
              echo '<p><b>fecha de recepcion:</b>'.trim($reportazo->fecha_recepcion).'</p>';
              echo '<p><b>fecha de reporte:</b>'.trim($reportazo->fecha_reporte).'</p>';
              echo '<p><b>analista:</b>'.trim($reportazo->analista).'</p>';
              echo '<p><b>fecha de analista:</b>'.trim($reportazo->fecha_analista).'</p>';
              echo '<p><b>jefe de departamento:</b>'.trim($reportazo->jefe_dpto).'</p>';
              echo '<p><b> fecha departamento:</b>'.trim($reportazo->fecha_dpto).'</p>';
              echo '<p><b>superintendente:</b>'.trim($reportazo->supte).'</p>';//10
              echo '<p><b>fecha superintendente:</b>'.trim($reportazo->fecha_supte).'</p>';
              echo '<p><b>aprobado departamento:</b>'.trim($reportazo->aprobado_dpto).'</p>';
              echo '<p><b>aprobado:</b>'.trim($reportazo->aprobado).'</p>';
              echo '<p><b>observaciones:</b>'.trim($reportazo->observaciones).'</p>';
              echo '<p><b>proveedor:</b>'.trim($reportazo->cproveedor).'</p>';
              echo '<p><b>originado:</b>'.trim($reportazo->originado).'</p>';
              echo '<p><b>extension:</b>'.trim($reportazo->extension).'</p>';
              echo '<p><b>unidad:</b>'.trim($reportazo->unidad).'</p>';
              echo '<p><b>Tipo de Muestra:</b>'.trim($reportazo->TipoMuestra).'</p>';//19*/

            } 

          }else{ 

             echo '<script>alert("error en la consulta(query)")</script>';
          }
    }


    // esto consulta los resultados dentro del reporte
     if (isset($conexion)) {
         $query="SELECT * FROM [dbo].[V_AL20_SCP_SILAB_FORANEOS_resultados_e] WHERE nmuestra = '".$reporte->nmuestra."'";
          //enviar query
          //mssql_query($query, $conexion) or die ("<h2>error al enviar datos a la bs</h2>"); 

          $res_query=mssql_query($query, $conexion);
          //si no hay problema con la consulta
          if (isset($res_query)) {

            while ($reportazo = mssql_fetch_object($res_query){

                  

             /* echo '<h2>Reporte de Material:</b>'.trim($reportazo['cmaterial']).'</h2>';
              echo '<p><b>Material:</b>'.trim($reportazo['cmaterial']).'</p>';
              echo '<p><b>a&ntilde;o: </b>'.trim($reportazo[1]).'</p>';
              echo '<p><b>numero de muestra:</b>'.trim($reportazo['nmuestra']).'</p>';
              echo '<p><b>Propiedad:</b>'.trim($reportazo['cpropiedad']).'</p>';
              echo '<p><b>Valor:</b>'.trim($reportazo['valor']).'</p>';
              echo '<p><b>fuera:</b>'.trim($reportazo['fuera']).'</p>';
              /*echo '<p><b>fecha de analista:</b>'.trim($reportazo->fecha_analista).'</p>';
              echo '<p><b>jefe de departamento:</b>'.trim($reportazo->jefe_dpto).'</p>';
              echo '<p><b> fecha departamento:</b>'.trim($reportazo->fecha_dpto).'</p>';
              echo '<p><b>superintendente:</b>'.trim($reportazo->supte).'</p>';//10
              echo '<p><b>fecha superintendente:</b>'.trim($reportazo->fecha_supte).'</p>';
              echo '<p><b>aprobado departamento:</b>'.trim($reportazo->aprobado_dpto).'</p>';
              echo '<p><b>aprobado:</b>'.trim($reportazo->aprobado).'</p>';
              echo '<p><b>observaciones:</b>'.trim($reportazo->observaciones).'</p>';
              echo '<p><b>proveedor:</b>'.trim($reportazo->cproveedor).'</p>';
              echo '<p><b>originado:</b>'.trim($reportazo->originado).'</p>';
              echo '<p><b>extension:</b>'.trim($reportazo->extension).'</p>';
              echo '<p><b>unidad:</b>'.trim($reportazo->unidad).'</p>';
              echo '<p><b>Tipo de Muestra:</b>'.trim($reportazo->TipoMuestra).'</p>';//19*/

            } 

          }else{ 

             echo '<script>alert("error en la consulta(query)")</script>';
          }
    }





?>
