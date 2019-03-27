<?php 
  require_once 'conexion.php';
   class usuario{

        var $ficha;
        var $pass;
        var $passnuevo;
        function setFicha ($ficha){
                 
         $this->ficha = $ficha;
        }
        function setPass ($pass){
                 
          $this->pass = $pass; 
        }
        function setPassnuevo ($passnuevo){
                 
          $this->passnuevo = $passnuevo; 
        }
     }




      //guarda los datos del formulario
      $pusuario = new usuario();
      $pusuario->setFicha(trim($_POST['inputficha']));
      $pusuario->setPass(trim($_POST['inputPassword']));
      $pusuario->setPassnuevo(trim($_POST['inputPassword2']));

      $conexionSILAB = conectar_mssql_SILAB($pusuario->ficha, $pusuario->pass);
      
      //Pendiente del beta (cambio de clave)
      $query='EXEC sp_password("'.$pusuario->pass.'",'".$pusuario->passnuevo"',"'.$pusuario->ficha.'")';
      $res_query=mssql_query($query, $conexion);
      echo $res_query;
      
      /*mssql_bind($stmt, '@author',    'Felipe Pena',  SQLVARCHAR,     false,  false,   60);*/
      
 ?>