<?php
  /* Funcion para conectar con la base de datos donde se encuentran las vistas con la informacion que se manejara en el sistema */
 function conectar_mssql(){
    //datos para la conexion con la base de datos
    $servername = "ALUMINIO20\SCP";
    $database = "FORANEOS";
    $username = "PORTAL_REPORTES";
    $password = "Reportes";

    
          if (!($enlace=mssql_connect($servername,$username,$password))){ 
               die("Error conectando a la base de datos.");
               exit(); 
              } 
                                                            
          if (!mssql_select_db ($database,$enlace)){ 
                die("Error seleccionando la base de datos."); 
                exit(); 
             } 
      
            
   return $enlace;
}
 
 /*Funcion para el acceso a la bases de datos SILAB donde se encuentran los usuarios que pueden tener acceso al sistema para su debida verificacion*/
  function conectar_mssql_SILAB($user, $passbd){
    //datos para conexion con la base de datos
    $servername = "ALUMINIO20\SCP";
    $database = "SILAB";
    $username = $user;
    $password = $passbd;

      
      if (!($enlace=mssql_connect($servername,$username,$password))){ 
                  

                  die("Error conectando a la base de datos.");

                  exit(); 
               } 
                                                    
      if (!mssql_select_db ($database,$enlace)){ 
            die("Error seleccionando la base de datos."); 
            exit(); 
          } 
    
          
   return $enlace; 
  }

?>