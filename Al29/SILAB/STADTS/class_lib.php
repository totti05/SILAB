<?php 
require_once 'conectarse.php';
 
	class instancia {
        var $nombre;
        var $servidor;
        var $descripcion;
        var $n_jobs;
        var $n_dts;
        var $n_respaldo;
        var $color;
        var $jobs;
        var $dts;
		var $estado;
		
        function set_nombre($nombre) { 
			$this->nombre = $nombre;  
 		}
        function set_servidor($servidor) { 
			$this->servidor = $servidor;  
 		}
 		
 		function set_descripcion($descripcion) { 
			$this->descripcion = $descripcion;  
 		}
 		
 		function set_n_jobs($n_jobs) { 
			$this->n_jobs = $n_jobs;  
 		}
 		
 		function set_n_dts($n_dts) { 
			$this->n_dts = $n_dts;  
 		}
 		function set_n_respaldo($n_respaldo) { 
			$this->n_respaldo = $n_respaldo;  
 		}
 		function set_color($color) { 
			$this->color = $color;  
 		}
 		function set_jobs($jobs) { 
			$this->jobs = $jobs;  
 		}
 		
 		function set_dts($dts) { 
			$this->dts = $dts;  
 		}
 		function set_estado($estado) { 
			$this->estado = $estado;  
 		}

   		function get_nombre() {
			return $this->nombre;
		}
   		function get_servidor() {
			return $this->servidor;
        }
        function get_descripcion() {
			return $this->descripcion;
		}
		function get_n_jobs() {
			return $this->n_jobs;
		}
		function get_n_dts() {
			return $this->n_dts;
		}
		function get_n_respaldo() {
			return $this->n_respaldo;
		}
		function get_color() {
			return $color->color;
        }
        function get_jobs() {
			return $this->jobs;
		}
		function get_dts() {
			return $this->dts;
		}
		function get_estado() {
			return $this->estado;
		}
	}


    class job {
        var $job_id;
        var $nombre;
        var $estatus;
        var $tipo;
        var $descripcion;
        var $ultimo_resultado;
        var $horario;
        var $fecha_ultima_ejecucion;
        var $hora_ultima_ejecucion;
        var $fecha_proxima_ejecucion;
        var $hora_proxima_ejecucion;
        var $tiempo_limite_aproximado;
        
        function set_job_id($job_id) { 
			$this->job_id = $job_id;  
 		}	
        function set_nombre($nombre) { 
			$this->nombre = $nombre;  
 		}	
 		function set_estatus($estatus) { 
			$this->estatus = $estatus;  
 		}
 		function set_tipo($tipo) { 
			$this->tipo = $tipo;  
 		}
 		function set_descripcion($descripcion) { 
			$this->descripcion = $descripcion;  
 		}
 		function set_ultimo_resultado($ultimo_resultado) { 
			$this->ultimo_resultado = $ultimo_resultado;  
 		}
 		function set_horario($horario) { 
			$this->horario = $horario;  
 		}
 		function set_fecha_ultima_ejecucion($fecha_ultima_ejecucion) {
			if ($this->ultimo_resultado!='Desconocido') {
				$this->fecha_ultima_ejecucion = get_fecha($fecha_ultima_ejecucion);
			}  else
				$this->fecha_ultima_ejecucion = '';
 		}
 		function set_hora_ultima_ejecucion($hora_ultima_ejecucion) {
			if ($this->ultimo_resultado!='Desconocido') {
				$this->hora_ultima_ejecucion = get_hora($hora_ultima_ejecucion); 
			} else
				$this->hora_ultima_ejecucion = 'Desconocido';
 		}
 		function set_fecha_proxima_ejecucion($fecha_proxima_ejecucion) { 
			$this->fecha_proxima_ejecucion = $fecha_proxima_ejecucion;  
 		}
 		function set_hora_proxima_ejecucion($hora_proxima_ejecucion) { 
			$this->hora_proxima_ejecucion = $hora_proxima_ejecucion;  
 		}
 		function set_tiempo_limite_aproximado($hora_limite_aproximada) { 
			$this->tiempo_limite_aproximado = sum_hora($this->hora_ultima_ejecucion, $this->fecha_ultima_ejecucion, $hora_limite_aproximada);  
 		}
 		
 		function get_job_id() {
			return $this->job_id;
        }
   		function get_nombre() {
			return $this->nombre;
		}
		function get_estatus() {
			return $this->estatus;
		}
		function get_tipo() {
			return $this->tipo;
		}
        function get_descripcion() {
			return $this->descripcion;
		}
		function get_ultimo_resultado() {
			return $this->ultimo_resultado;
		}
		function get_horario() {
			return $this->horario;
		}
		function get_fecha_ultima_ejecucion() {
			return $this->fecha_ultima_ejecucion;
		}
        function get_hora_ultima_ejecucion() {
			return $this->hora_ultima_ejecucion;
		}
		function get_fecha_proxima_ejecucion() {
			return $this->fecha_proxima_ejecucion;
		}
		function get_hora_proxima_ejecucion() {
			return $this->hora_proxima_ejecucion;
		}
		function get_tiempo_limite_aproximado() {
			return $this->tiempo_limite_aproximado;
		}
    }

    class horario {
		var $ocurrencia;
		var $ocurrencia_detalle;
		var $frecuencia;

		
		function set_ocurrencia($ocurrencia) { 
			$this->ocurrencia = $ocurrencia;  
 		}
		function set_ocurrencia_detalle($ocurrencia_detalle) { 
			$this->ocurrencia_detalle = $ocurrencia_detalle;  
 		}
		function set_frecuencia($frecuencia) { 
			$this->frecuencia = $frecuencia;  
 		}
		
 		
 		function get_ocurrencia() {
			return $this->ocurrencia;
        }
 		function get_ocurrencia_detalle() {
			return $this->ocurrencia_detalle;
        }
 		function get_frecuencia() {
			return $this->frecuencia;
        }
    
    }

    class layout {
        var $elementos;

        function __construct() {
            $db=conectar_mssql();
            $query="SELECT * FROM [dbo].[Servidor_I]";
            $res_query=mssql_query($query, $db);
            $n=1;
            while($consulta=mssql_fetch_array($res_query)) {
                $elemento = new instancia();
                $elemento->set_nombre($consulta['nombre']);
                $elemento->set_servidor($consulta['servidor']);
                $elemento->set_descripcion($consulta['descripcion']);
                $elemento->set_n_jobs($consulta['n_jobs']);
                $elemento->set_n_dts($consulta['n_dts']);
                $elemento->set_n_respaldo($consulta['n_respaldo_job']);
                $elemento->set_estado($consulta['estado']);
                $subquery="SELECT leyenda FROM [dbo].[Servidor] WHERE servidor='".$consulta['servidor']."'";
                $subres_query=mssql_query($subquery, $db);
                $subconsulta=mssql_fetch_array($subres_query);
                $elemento->set_color($subconsulta['leyenda']);                
                $elementos[$n]=$elemento;
                $n++;
            }
            $this->elementos=$elementos;	
        }

        function set_elementos($elementos) { 
			$this->elementos = $elementos;  
 		}
 
   		function get_elementos() {
			return $this->elementos;
		}
    }

	function get_fecha($fecha){
		$yy=substr($fecha, 0, 4);
		$mm=substr($fecha, 4, 2);
		$dd=substr($fecha, 6, 2);
		return $dd.'-'.$mm.'-'.$yy;
	}
	
	function get_hora($hora){
		$hh=round($hora / 10000);
		$mm=round(($hora % 10000)/100);
		$ss=round($hora % 100);
		$dd=mktime($hh, $mm, $ss);
		return date("h:i:sa", $dd);
		date("h:i:sa", $dd);

	}
	
	function sum_hora($hora, $fecha, $tiempo){
		$hh=round($tiempo / 10000) * 3600;
		$mm=round(($tiempo % 10000)/100) * 60;
		$ss=round($tiempo % 100);
		return date("d-m-Y h:i:sa",strtotime('+'.($hh+$mm+$ss).' seconds',strtotime($fecha.' '.$hora)));
	}
?>
