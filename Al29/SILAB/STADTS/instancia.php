<?php 
include("class_lib.php");
require_once 'conectarse.php';
$data=str_replace("\\\\","\\",$_GET['data']);
$orden=$_GET['orden'];
$direccion=$_GET['direccion'];
	if($_GET['tipo']!="Todo")
		$filtro=" and tipo='".$_GET['tipo']."'";
	if($_GET['ocurrencia']!="Todo")
		$subfiltro=" and ocurrencia='".$_GET['ocurrencia']."'";

    if(isset($data)){
        $instancia = new instancia(); 
        list($servidor, $nombre)=explode(":",str_replace("\\",":\\",$data));
        $instancia->set_nombre($nombre);            
        $instancia->set_servidor($servidor);

        $db=conectar_mssql();
        if (isset($db)) {
        $query="SELECT * FROM [dbo].[Job] WHERE propietario='".$data."'".$filtro." ORDER BY ".$orden." ".$direccion;
        $res_query=mssql_query($query, $db);
        $elementos; $n=1;
        while($consulta=mssql_fetch_array($res_query)) {
			
			$subquery="SELECT * FROM [dbo].[Horario] WHERE job_nombre='".$consulta['nombre']."'";
			$subres_query=mssql_query($subquery, $db);
			$subconsulta=mssql_fetch_array($subres_query); 
			
			
			if ($_GET['ocurrencia']=="Todo" || $_GET['ocurrencia']==$subconsulta['ocurrencia']){
			$elemento = new job();
			$subelemento = new horario();
			$elemento->set_job_id($consulta['job_id']);
			$elemento->set_nombre($consulta['nombre']);
			$elemento->set_tipo($consulta['tipo']);
			
			switch ($consulta['ultimo_resultado']) { 
				case 0: $elemento->set_ultimo_resultado('Fallido'); break;
				case 1: $elemento->set_ultimo_resultado('Exitoso'); break;
				case 3: $elemento->set_ultimo_resultado('Cancelado'); break;
				case 5: $elemento->set_ultimo_resultado('Desconocido'); break;
			}
			
			$elemento->set_fecha_ultima_ejecucion($consulta['fecha_ultima_ejecucion']);
			$elemento->set_hora_ultima_ejecucion($consulta['hora_ultima_ejecucion']);
			$elemento->set_fecha_proxima_ejecucion($consulta['fecha_proxima_ejecucion']);
			$elemento->set_hora_proxima_ejecucion($consulta['hora_proxima_ejecucion']);
			$elemento->set_tiempo_limite_aproximado($consulta['aproximado']);
			
			$limite=$elemento->get_tiempo_limite_aproximado();
			$actual=date("d-m-Y h:i:sa", strtotime ( "-1 hour" ));
			
			$subsubquery="SELECT * FROM [dbo].[Historia_Job_Congelado] WHERE job_nombre='".$consulta['nombre']."' and propietario='".$data."'";
			$subsubres_query=mssql_query($subquery, $db);
			$subsubconsulta=mssql_fetch_array($subres_query); 
			
			switch ($consulta['estatus']) { 
				case 0: $elemento->set_estatus(''); break;
				case 1: if ($subsubconsulta=mssql_fetch_array($subres_query)) 
							$elemento->set_estatus('Congelado '.$limite); 
						else $elemento->set_estatus('Ejecutando'); 
						break;
				case 2: $elemento->set_estatus('Esperando'); break;
				case 3: $elemento->set_estatus('Reintentando'); break;
				case 4: $elemento->set_estatus('Inactivo'); break;
				case 5: $elemento->set_estatus('Suspendido'); break;
				case 7: $elemento->set_estatus('Culminando'); break;
			}
			$descripcion=" ";
			if ($consulta['tipo']=='DTS'){
				$descripcion=str_replace("Execute package:","Ejecutar el paquete",$consulta['descripcion']);
			} else {
				$descripcion=str_replace("BACKUP DATABASE [","Respaldar BD ",$consulta['descripcion']);
				$descripcion=str_replace("] TO  DISK = N'"," en ",$descripcion);
				$descripcion=str_replace("' WITH  NOINIT ,  NOUNLOAD ,  NAME = N'"," con el nombre ",$descripcion);
				$descripcion=str_replace("' WITH  INIT ,  NOUNLOAD ,  NAME = N'"," con el nombre ",$descripcion);
				$descripcion=str_replace("',  NOSKIP ,  STATS = 10,  NOFORMAT","",$descripcion);
				$descripcion=str_replace("', NOSKIP , STATS = 10, NOFORM","",$descripcion);
			}
			$elemento->set_descripcion($descripcion);
			
			

			$subelemento->set_ocurrencia($subconsulta['ocurrencia']);
			$subelemento->set_ocurrencia_detalle($subconsulta['ocurrencia_detalle']);
			$subelemento->set_frecuencia($subconsulta['frecuencia']);
			$elemento->set_horario($subelemento);
			
				$elementos[$n]=$elemento;
				$n++;
			}
        }
        $instancia->set_jobs($elementos);
        }
        echo json_encode($instancia);    
    } else echo null;
    exit();
?>


