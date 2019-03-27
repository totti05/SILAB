<?php 
include("class_lib.php");
require_once 'conectarse.php';
//$data=str_replace("\\\\","\\",$_GET['data']);
$nombre=$_GET['nombre'];
$propietario=str_replace("\\\\","\\",$_GET['propietario']);
$opcion=$_GET['opcion'];
    if(isset($nombre) && isset($propietario)){
		$subdb=conectar_servidor($propietario);
        if(isset($subdb)){
			$msj="";
			switch ($opcion) { 
			case 1: $subquery="EXEC msdb.dbo.sp_start_job @job_name='".$nombre."'";
					$subres_query=mssql_query($subquery, $subdb);
					$msj="Ejecutando job...";
					break;
			case 2: $subquery="EXEC msdb.dbo.sp_stop_job @job_name='".$nombre."'";
					$subres_query=mssql_query($subquery, $subdb);
					sleep(1);
					$subquery="EXEC msdb.dbo.sp_start_job @job_name='".$nombre."'";
					$subres_query=mssql_query($subquery, $subdb);
					$msj="Descongelando job...";
					break;
			}
			
			echo $msj;
		} else echo 'Error, no se pudo realizar la solicitud.';
    }
    exit();
?>


