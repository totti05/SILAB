<?php
    class report {

            var $cmaterial;
            var $ano;
            var $nmuestra;    
            var $fecha_recepcion;
            var $fecha_reporte;
            var $fecha_analista_1;
            var $fecha_analista_2;
            var $fecha_dpto_1;
            var $fecha_dpto_2;
            var $analista;
            var $analista_1;
            var $analista_2;
            var $analista_3;
            var $analista_4;
            var $fecha_analista;
            var $jefe_dpto;
            var $jefe_dpto_1;
            var $jefe_dpto_2;
            var $fecha_dpto;
            var $supte;
            var $fecha_supte;
            var $aprobado_an;
            var $aprobado_dpto;
            var $aprobado;
            var $observaciones;
            var $cproveedor;
            var $originado;
            var $extension;
            var $unidad;
            var $TipoMuestra;
            var $descripcionprove;


            function setCmaterial ($cmaterial){
             $this->cmaterial = $cmaterial;
            }
            
            function setAno ($ano){
                     
             $this->ano = $ano;
            }


            function setNmuestra ($muestra){
                     
             $this->nmuestra = $muestra;
            }
            function setFecha_recepcion ($fecha_recepcion){
                     
             $this->fecha_recepcion = $fecha_recepcion;
            }
            function setFecha_reporte ($fecha_reporte){
                     
             $this->fecha_reporte = $fecha_reporte;
            }

            function setFecha_analista_1 ($fecha_analista_1){
             $this->fecha_analista_1 = $fecha_analista_1;
            }

            function setFecha_analista_2 ($fecha_analista_2){
             $this->fecha_analista_2 = $fecha_analista_2;
            }

            function setFecha_dpto_1 ($fecha_dpto_1){
             $this->fecha_dpto_1 = $fecha_dpto_1;
            }
            function setFecha_dpto_2 ($fecha_dpto_2){
             $this->fecha_dpto_2 = $fecha_dpto_2;
            }

            function setAnalista  ($analista){
                     
             $this->analista = $analista;
            }
            function setAnalista_1  ($analista_1){
                     
             $this->analista_1 = $analista_1;
            }
            function setAnalista_2  ($analista_2){
                     
             $this->analista_2 = $analista_2;
            }
            function setAnalista_3  ($analista_3){
                     
             $this->analista_3 = $analista_3;
            }
            function setAnalista_4  ($analista_4){
                     
             $this->analista_4 = $analista_4;
            }
            function setFecha_analista ($fecha_analista){
                     
             $this->fecha_analista = $fecha_analista;
            }
            function setJefe_dpto  ($jefe_dpto){
                     
             $this->jefe_dpto = $jefe_dpto;
            }
            function setJefe_dpto_1  ($jefe_dpto_1){
                     
             $this->jefe_dpto_1 = $jefe_dpto_1;
            }
            function setJefe_dpto_2  ($jefe_dpto_2){
                     
             $this->jefe_dpto_2 = $jefe_dpto_2;
            }
            function setFecha_dpto ($fecha_dpto){
                     
             $this->fecha_dpto = $fecha_dpto;
            }
            function setSupte  ($supte){
                     
             $this->supte = $supte;
            }
            function setFecha_supte ($fecha_supte){
                     
             $this->fecha_supte = $fecha_supte;
            }
            function setAprobado_an  ($aprobado_an){
                     
             $this->aprobado_an = $aprobado_an;
            }
            function setAprobado_dpto  ($aprobado_dpto){
                     
             $this->aprobado_dpto = $aprobado_dpto;
            }
            function setAprobado ($aprobado){
                     
             $this->aprobado = $aprobado;
            }
            function setObservaciones  ($observaciones){
                     
             $this->observaciones = $observaciones;
            }
            function setCproveedor ($cproveedor){
                     
             $this->cproveedor = $cproveedor;
            }
            function setOriginado  ($originado){
                     
             $this->originado = $originado;
            }
            function setExtension ($extension){
                     
             $this->extension = $extension;
            }
            function setUnidad  ($unidad){
                     
             $this->unidad = $unidad;
            }
            function setTipoMuestra ($TipoMuestra){
                     
             $this->TipoMuestra = $TipoMuestra;
            }
            function setDescripcionProve ($descripcionprove){
                     
             $this->descripcionprove = $descripcionprove;
            }
      }

      class analista {
            var $nombre;
            var $apellido;
            var $ficha;   

            
            

            function setNombre ($nombre){
                     
             $this->nombre = $nombre;
            }
            function setApellido  ($apellido){
                     
             $this->apellido = $apellido;
            }
            function setFicha ($ficha){
                     
             $this->ficha = $ficha;
            } 
            

      }
      class jefe_dpto {
            var $nombre;
            var $apellido;
            var $ficha;   
            
            function setNombre ($nombre){
                     
             $this->nombre = $nombre;
            }
            function setApellido  ($apellido){
                     
             $this->apellido = $apellido;
            }
            function setFicha ($ficha){
                     
             $this->ficha = $ficha;
            }
      }
      class supte {
            var $nombre;
            var $apellido;
            var $ficha;   
            
            function setNombre ($nombre){
                     
             $this->nombre = $nombre;
            }
            function setApellido  ($apellido){
                     
             $this->apellido = $apellido;
            }
            function setFicha ($ficha){
                     
             $this->ficha = $ficha;
            } 
            

      }   

      function vistaReportes($ruta){
            
            switch ($ruta) {
            case 'MuestrasE':
                $nombreVistaBD = 'V_AL20_SCP_SILAB_FORANEOS_muestras_e';
                break;
            
            case 'AguaySedimentales':
                $nombreVistaBD = 'V_AL20_SCP_SILAB_FORANEOS_agua_y_sedimentales';
                break;
                  
            case 'Carbon':
                $nombreVistaBD = 'V_AL20_SCP_SILAB_FORANEOS_carbon';
                break;
                  }

        return ($nombreVistaBD);
      } 

      function vistaResultados($ruta){
            
            switch ($ruta) {
            case 'MuestrasE':
                $nombreVistaBD = 'V_AL20_SCP_SILAB_FORANEOS_resultados_e';
                break;
            
            case 'AguaySedimentales':
                $nombreVistaBD = 'V_AL20_SCP_SILAB_FORANEOS_resultados_agua_y_sedimentales';
                break;
                  }

        return ($nombreVistaBD);
      }   


     

      ?>