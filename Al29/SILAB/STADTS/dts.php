<?php 
include("class_lib.php");
require_once 'conectarse.php';
    if(isset($data)){
		list($nombre, $propietario)=explode("-",$data);
        $db=conectar_mssql();
        $query="EXEC msdb.dbo.sp_start_job @dts_name='STADTS'";
        $res_query=mssql_query($query, $db);
    }
    exit();
?>


