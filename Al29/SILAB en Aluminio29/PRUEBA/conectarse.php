<?php
function conectar_mssql() 
{ 
$hostname="ALUMINIO29\DHW";
$username="ESTATUS_DTS";
$password="ESTATUS_DTS";
$dbname="ESTATUS_DTS";
    $enlace=mssql_connect($hostname, $username, $password);
    if (!$enlace) { 
      return null;
      exit(); 
    } 
    if (!mssql_select_db($dbname, $enlace)) { 
      exit(); 
    }
   return $enlace; 
}  

function conectar_servidor ($host) 
{ 
$hostname=$host;
$username="Job";
$password="jobjob";
$dbname="msdb";
    $enlace=mssql_connect($hostname, $username, $password);
    if (!$enlace) { 
		return null;
      header('Location: error.php'); //Error conectando a la base de datos.
      exit(); 
    } 
    if (!mssql_select_db($dbname, $enlace)) { 
      header('Location: error.php'); //Error seleccionando la base de datos. 
      exit(); 
    }
   return $enlace; 
} 

conectar_mssql();

?>
