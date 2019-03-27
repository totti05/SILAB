<?php 
function conectarse() 
{ 
   if (!($link=mssql_connect("ALUMINIO20\SCP","PORTAL_REPORTES","REPORTES")))
   { 
      echo "Error conectando a la base de datos."; 
      exit(); 
   } 
   if (!mssql_select_db("Solicitud_Servicio",$link)) 
   { 
      echo "Error seleccionando la base de datos."; 
      exit(); 
   } 
   return $link; 
} 
?>