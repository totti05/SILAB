<!DOCTYPE html>
<html>
<head>
  <title>SILAB ALUMINA PRIMARIA DIARIA</title>
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <script src="../../bootstrap-4.1.3-dist/jquery-3.3.1.min.js"></script>
  <link rel="stylesheet" href="../../bootstrap-4.1.3-dist/css/bootstrap.css"> 
  <link rel="stylesheet" type="text/css" href="../../estilos2.css">  
  <meta charset="UTF-8">
</head>
<body id="login">
  
<header>
    <nav class="navbar fixed-top navbar-expand-md navbar-light bg-light">
      <a class="navbar-brand" href="../../login.php">SILAB PRUEBA</a>
      <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent"
       aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
      </button>

      <div class="collapse navbar-collapse" id="navbarSupportedContent">
        <ul class="navbar-nav mr-auto">
          <li class="nav-item active">
            <a class="nav-link" href="../../acercade.php">Acerca de <span class="sr-only">(current)</span></a> 
          </li>
          
        </ul>
        <form class="form-inline my-2 my-lg-0">
          <a id="btn_registro" class="btn btn-outline-success " href="../../menu.php" role="button"> Menu </a>
          <a id="btn_registroLogin" class="btn btn-outline-success active" href="./aluminaPDiaria.php" role="button">Volver</a>
        </form>
      </div>
    </nav>
  </header> 

  <main>
	<!-- > '05/05/2017' AND < '05/05/2018'-->
	
	<div class="container-fluid row pb-5" id="info">
		<div class="col-md-10 offset-md-1 table-responsive  text-center">
		  <h2>Listado de reportes EJEMPLO</h2> 
			
			<table id="tablaReportes"  class=" table table-responsive table-hover table-bordered text-center ">
			  <thead class="thead-dark">
				  	<tr>
					    <th>Material</th> <!-- cabeceras -->
					    <th>A&ntilde;o</th> 
					    <th>Muestra</th>
					    <th>Fecha de recepcion</th>
					    <th>fecha de reporte</th>
					    <th>Aprobado Analista</th>
					    <th>Aprobado Jefe Departamento</th>
					    <th>Aprobado Superintendente</th>
					</tr>
			 </thead>
			 <tbody>
			 	 	  
					<?php 
						require('../../conexion.php');
    					require('../../clases.php');
					    $reportazo = new report();
			           
			            $fecha = trim($_POST['daterange']);
			            echo  ' $fecha '.$fecha.'<br>';
			           
			            $fechaInicio = substr($fecha, 0, 10); 
			            echo  ' $fechaInicio '.$fechaInicio.'<br>';
			            
			            $fechaFin = substr($fecha, 11); 
			            echo  ' $fechaFin '.$fechaFin.'<br>';
			            

							            
						$fechaInicio = strtotime($fechaInicio);
						echo  ' $fechaInicio1 '.$fechaInicio.'<br>';
							            
						$fechaFin = strtotime($fechaFin);
						echo  ' $fechaFin1 '.$fechaFin.'<br>';
			            
			            $fechaInicio = date ( "Y\-d\-m H:i:s", $fechaInicio );
			            echo  ' $fechaInicio2 '.$fechaInicio.'<br>';
			            
			            $fechaFin = date ( "Y\-d\-m H:i:s", $fechaFin );
			            echo  ' $fechaFin2 '.$fechaFin.'<br>';



			            $conexion = conectar_mssql();

			            //conexion a la base de datos para extraer datos del pie de pagina.
			            //

			                if (isset($conexion)) 
			                {
			                	$query="SELECT * FROM [dbo].[V_AL20_SCP_SILAB_FORANEOS_muestras_e] WHERE cmaterial = 'ALUMINA PRIMARIA DIA' AND (fechaDate >= CONVERT(DATETIME,'$fechaInicio',102) AND fechaDate <=CONVERT(DATETIME, '$fechaFin',102)) ORDER BY fechaDate";
			                    //enviar query
			                    echo $query;
			                    $res_query=mssql_query($query, $conexion);
			                    //si no hay problema con la consulta
			                    if (isset($res_query)) 
			                    {



			                       while ($consulta = mssql_fetch_object($res_query)){

			                                    
			                            $reportazo->setCmaterial($consulta->cmaterial);
			                            $reportazo->setAno($consulta->ano);
			                            $reportazo->setNmuestra($consulta->nmuestra);
			                            $reportazo->setFecha_recepcion($consulta->fecha_recepcion);
			                            $reportazo->setFecha_reporte($consulta->fecha_reporte);
			                            
			                            $reportazo->setAprobado_dpto($consulta->aprobado_dpto);
			                            $reportazo->setAprobado($consulta->aprobado);
			                            echo '<tr onclick="ver_id()">';
			                            echo '<td id="'.$reportazo->cmaterial.'">'.$reportazo->cmaterial.'</td>';
			                            echo '<td id="'.$reportazo->ano.'">'.$reportazo->ano.'</td>';
			                            
			                            /*echo '<input type="text" name="nmuestra" value="'.$reportazo->nmuestra.'" hidden="">';
			                            echo '<input type="text" name="ano" value="'.$reportazo->ano.'" hidden="">';
			                            echo '<input type="text" name="ruta" value="MuestrasE" hidden="">';*/
			                            
			                            
			                            echo '<td class="btn-link" style="cursor: pointer" id="'.$reportazo->nmuestra.'"  >'.$reportazo->nmuestra.'</td>';
			                            echo '<td>'.$reportazo->fecha_recepcion.'</td>';
			                            echo '<td>'.$reportazo->fecha_reporte.'</td>';
			                            echo '<td>'.$reportazo->aprobado_dpto.'</td>';
			                            echo '<td>'.$reportazo->aprobado_dpto.'</td>';
			                            echo '<td>'.$reportazo->aprobado.'</td>';
			                            echo '</tr>';


			                                                        
			                        } 

			                    }else{ 

			                            echo '<script>alert("error en la consulta(query)")</script>';
			                        }
			                    }
			                    		 
				 	?>

					

			 </tbody>  	
				  
			  
			</table>
		</div>
			
			<span id="PDF" class=""></span>

		<script type = "text/javascript"> 

		    function ver_id() {

				    var rows = document.getElementById('tablaReportes').getElementsByTagName('tr');

				    for (i = 0; i < rows.length; i++) {

				        rows[i].onclick = function() {

						var nmuestra = this.getElementsByTagName('td')[2].innerHTML;
						var ano = this.getElementsByTagName('td')[1].innerHTML;
						var cmaterial = this.getElementsByTagName('td')[0].innerHTML;

						var apro1= this.getElementsByTagName('td')[5].innerHTML;
						var apro2= this.getElementsByTagName('td')[6].innerHTML;
						var apro3= this.getElementsByTagName('td')[7].innerHTML;

						var apro_total=apro1+apro2+apro3;

				        console.log(nmuestra + '-' +ano+ '-' +cmaterial);
				        console.log(apro1+ '-' +apro2+ '-' +apro3);
				        console.log(apro_total);


				        var ruta = "MuestrasE";
				        var material = 'AluminaPDiaria';

				        $.ajax(
				        { 
							data: {
								nmuestra, ano, cmaterial, ruta, apro1, material
							}, /*datos que se envian a traves de ajax */
							url: 'http://Aluminio30/SILAB/PDF7.php', /*archivo que recibe la peticion*/
							type: 'POST', /*método de envio*/
							beforeSend: function () 
							{ 
								console.log("Procesando, espere por favor...");
								var url=window.document.URL;
								$('#tablaReportes').hide();

							}, 
							success: function (response) 
							{   
								 /*una vez que el archivo recibe el request lo procesa y lo devuelve*/ 
								//document.location = "http://control/scp/modules/SILAB/PRUEBA/PDF class.php";
								
								//http://aluminio30/SILAB/Temp7/Alumina Primaria Diaria.pdf
								//http://control/SCP/modules/SILAB/PRUEBA/Temp/doc.pdf
								switch(material) 
								{
								  case 'AluminaPDiaria':
								    	document.location = "http://aluminio30/SILAB/Temp7/Alumina Primaria Diaria.pdf" ;
								    break;
								  case 'NULL':
								    // code block
								    break;
								} 
							} 
						}); 
				        }

				    }
				}

	    </script> 
	</div>
				
 </main>

<footer class="text-center footer">
    <div class="container">
      <span class="text-muted">Raul App</span>
    </div>
  </footer>

  
  <script src="../../bootstrap-4.1.3-dist/popper.js"></script>
  <script src="../../bootstrap-4.1.3-dist/js/bootstrap.js"></script> 

</body>

</html>



