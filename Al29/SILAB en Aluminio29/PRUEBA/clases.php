<?php
    class report {

            var $cmaterial;
            var $ano;
            var $nmuestra;    
            var $fecha_recepcion;
            var $fecha_reporte;
            var $analista;
            var $fecha_analista;
            var $jefe_dpto;
            var $fecha_dpto;
            var $supte;
            var $fecha_supte;
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
            function setAnalista  ($analista){
                     
             $this->analista = $analista;
            }
            function setFecha_analista ($fecha_analista){
                     
             $this->fecha_analista = $fecha_analista;
            }
            function setJefe_dpto  ($jefe_dpto){
                     
             $this->jefe_dpto = $jefe_dpto;
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
         
      function vistaBD($ruta){
            
            switch ($ruta) {
            case 'MuestrasE':
                $nombreVistaBD = 'V_AL20_SCP_SILAB_FORANEOS_muestras_e';
                break;
            
            case 'AguaySedimentales':
                $nombreVistaBD = 'V_AL20_SCP_SILAB_FORANEOS_agua_y_sedimentales';
                break;
                  }

        return ($nombreVistaBD);
      }   

      ?>