<?php 
include("class_lib.php");
require_once 'conectarse.php';

   // if(isset($_GET['data'])){
        $db=conectar_mssql();
        $query="SELECT * FROM [dbo].[Historia_Job_Congelado]";
        $res_query=mssql_query($query, $db);
        $elementos; $n=1;
        while($consulta=mssql_fetch_array($res_query)) {
			$elemento = new job();
			$elemento->set_job_id($consulta['job_id']);
			$elemento->set_nombre($consulta['nombre']);
			$elemento->set_tipo($consulta['propietario']);
			
			$elemento->set_fecha_ultima_ejecucion($consulta['fecha']);
			$elemento->set_hora_ultima_ejecucion($consulta['hora']);
			
			$elemento->set_estatus('Congelado ');
			$elementos[$n]=$elemento;
			$n++;
        }
        echo json_encode($elementos);    
   // }
    exit();
?>


