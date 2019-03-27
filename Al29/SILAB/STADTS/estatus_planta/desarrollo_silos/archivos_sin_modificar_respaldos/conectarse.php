<?php

////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
function mig_query($sq, $db, $tipo_bd='pgsql')
{
	//$tipo_bd = 'mssql';
	//$tipo_bd = 'pgsql';
	if ($tipo_bd == 'mssql')
	{
		$query = mssql_query($sq, $db);
	}
	if ($tipo_bd == 'pgsql')
	{
		$num_errores = 0;
		//echo "<br>".$sq;
		$query = pg_query($db, $sq);
	}
	//$retorna_query = $query;
	return $query;
}
/////////////////////////////////FUNCION CONECTARSE A BASE DE DATOS SQL ///////////////////////
function conectarse_postgres() 
{ 
 if (!($link=pg_connect("host=vem-1868 port=5432 dbname=estatus_planta user=ssp password=ssp")))
   	{ 
      echo "Error conectando a la base de datos."; 
      exit(); 
   } 
//	pg_set_client_encoding($link, LATIN1);
   return $link; 
} 
/////////////////////////////////FUNCION CONECTARSE A BASE DE DATOS SQL ///////////////////////
function conectarse_postgres2() 
{ 
 if (!($link=pg_connect("host=vem-1868 port=5432 dbname=igpp user=ssp password=ssp")))
   	{ 
      echo "Error conectando a la base de datos."; 
      exit(); 
   } 
//	pg_set_client_encoding($link, LATIN1);
   return $link; 
} 

/////////////////////////////////FUNCION CONECTARSE A BASE DE DATOS SQL ///////////////////////
function conectarse_aluminio20_dac() 
{ 
 if (!($link=mssql_connect("ALUMINIO20\DHW","6102","070")))
   	{ 
      echo "Error conectando a la base de datos."; 
      exit(); 
   } 
   if (!mssql_select_db("DAC",$link))
   { 
      echo "Error seleccionando la base de datos.2"; 
      exit(); 
   }
   return $link; 
} 
/////////////////////////////////FUNCION CONECTARSE A BASE DE DATOS SQL ///////////////////////
function conectarse_aluminio20_fasedensa() 
{ 
 if (!($link=mssql_connect("ALUMINIO20\DHW","6102","070")))
   	{ 
      echo "Error conectando a la base de datos."; 
      exit(); 
   } 
   if (!mssql_select_db("fasedensa",$link))
   { 
      echo "Error seleccionando la base de datos.2"; 
      exit(); 
   }
   return $link; 
} 

/////////////////////////////////FUNCION CONECTARSE A BASE DE DATOS SQL ///////////////////////
function conectarse_oracle() 
{ 
//putenv("NLS_LANG=AMERICAN_AMERICA.WE8ISO8859P1");
 if (!($link=ocilogon("userctrolp", "userctrol", "SPROD.VENALUM.COM.VE:1521/SPROD")))
   	{ 
      echo "Error conectando a la base de datos."; 
      exit(); 
   } 
   return $link; 
} 

function conectarse_aluminio20_scp_silabm() 
{ 
 if (!($link=mssql_connect("ALUMINIO20\SCP","6102","070")))
   	{ 
      echo "Error conectando a la base de datos."; 
      exit(); 
   } 
   if (!mssql_select_db("SILABM",$link))
   { 
      echo "Error seleccionando la base de datos.2"; 
      exit(); 
   }
   return $link; 
} 

function conectarse_mysql_scp() {
	 if (!($link=mysql_connect("localhost","root","root2004")))
   	{ 
      echo "Error conectando a la base de datos."; 
      exit(); 
   } 
   if (!mysql_select_db("scp",$link))
   { 
      echo "Error seleccionando la base de datos.2"; 
      exit(); 
   }
   return $link; 
}

/////////////////////////////////FUNCION CONECTARSE A BASE DE DATOS SQL ///////////////////////
function conectarse_aluminio20_PORTAL() 
{ 
 if (!($link=mssql_connect("ALUMINIO20\DHW","6102","070")))
   	{ 
      echo "Error conectando a la base de datos."; 
      exit(); 
   } 
   if (!mssql_select_db("PORTAL",$link))
   { 
      echo "Error seleccionando la base de datos.2"; 
      exit(); 
   }
   return $link; 
} 

/////////////////////////////////FUNCION CONECTARSE A BASE DE DATOS SQL ///////////////////////
function conectarse_aluminio20_foraneos() 
{ 
 if (!($link=mssql_connect("ALUMINIO20\DHW","6102","070")))
   	{ 
      echo "Error conectando a la base de datos."; 
      exit(); 
   } 
   if (!mssql_select_db("FORANEOS",$link))
   { 
      echo "Error seleccionando la base de datos.2"; 
      exit(); 
   }
   return $link; 
} 


function conectarse_aluminio30_ssp() 
{ 
 if (!($link=mssql_connect("ALUMINIO30\SSP","ssp","ssp")))
   	{ 
      echo "Error conectando a la base de datos."; 
      exit(); 
   } 
   if (!mssql_select_db("PRODUCCION",$link))
   { 
      echo "Error seleccionando la base de datos.2"; 
      exit(); 
   }
   return $link; 
} 


function conectarse_postgres_taller_autom() 
{ 
 if (!($link=pg_connect("host=vem-1868 port=5432 dbname=taller_automotriz user=ssp password=ssp")))
   	{ 
      echo "Error conectando a la base de datos."; 
      exit(); 
   } 
//	pg_set_client_encoding($link, LATIN1);
   return $link; 
} 


?>