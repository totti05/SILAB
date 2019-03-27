<?php require '../../clases.php'; ?>


<!DOCTYPE html>
<html>
<head>
  <title>SILAB BREA ALQUITRAN CATODOS</title>



  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <script src="../../bootstrap-4.1.3-dist/jquery-3.3.1.min.js"></script>
  <link rel="stylesheet" href="../../bootstrap-4.1.3-dist/css/bootstrap.css"> 
  <link rel="stylesheet" type="text/css" href="../../estilos2.css">  
  
  <link rel="stylesheet" type="text/css" href="../../daterangepicker-master/daterangepicker-master/daterangepicker.css" />


  <meta charset="UTF-8">

  

</head>
<body id="login" class="bg-dark text-light">
  
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
          <a id="btn_registroLogin" class="btn btn-outline-success active" href="../../MuestrasCarbon.php" role="button">Volver</a>
        </form>
      </div>
    </nav>
  </header> 

<main role="main" class="container">
	<div id="form-signin" class="container-fluid text-center">
		<h2>Solicitud de reporte</h2>
		<h3>Brea de alquitran de catodos</h3>
	<form class="" method="POST" action="../../PDF class.php" target="_blank">
		<label for="nmuestra" class="sr-only">Numero de muestra</label>
		<input class="form-control" name= "nmuestra" placeholder="Numero de muestra" required="" type="text">
    <label for="ano" class="sr-only">A&ntilde;o</label>
    <input type="text" name="ruta" value="Carbon" hidden="">
    <input class="form-control" name= "ano" placeholder="A&ntilde;o" required="" type="text">
		<button class="btn btn-success" id="btn_registroLogin" type="submit">solicitar informacion de muestra</button>
	</form>
</div>
<form id="form-signin" class="container-fluid text-center" method="POST" action="./BreaAlquitranCatodos.php" target="_blank">
  <label for="daterange" class="sr-only">fecha</label>
    <input type="text" name="daterange" class="form-control"> 
	<button class="btn btn-primary" id="btn_registroLogin" type="submit">Solicitar muestras por rango de fecha</button>
</form>

<script type="text/javascript">
  
		$(function() {
      $('input[name="daterange"]').daterangepicker({
        "showDropdowns": true,
        "linkedCalendars": false,
        "autoapply": true,
        "opens": 'rigth',
        "locale": {
          "format": "DD/MM/YYYY",
          "separator" : " - ",
          "applyLabel" : "Seleccionar",
          "cancelLabel" : "Cancelar",
          "daysOfWeek" : [
          "Do",
          "Lu",
          "Ma",
          "Mie",
          "Ju",
          "Vi",
          "Sa"
          ],
          "monthNames": [
          "Enero",
          "Febrero",
          "Marzo",
          "Abril",
          "Mayo",
          "Junio",
          "Julio",
          "Agosto",
          "Septiembre",
          "Octubre",
          "Noviembre",
          "Diciembre"
          ]
        }

  		}, function(start, end, label) {
        start= start.format('DD/MM/YYYY');
        end = end.format('DD/MM/YYYY');
  		console.log("se realizo una nueva seleccion de fecha: " + start + ' a ' + end);
      
		});
		});



   
</script>
</main>

<footer class="text-center footer">
    <div class="container">
      <span class="text-muted">Raul App</span>
    </div>
  </footer>

  
  <script src="../../bootstrap-4.1.3-dist/popper.js"></script>
  <script src="../../bootstrap-4.1.3-dist/js/bootstrap.js"></script> 

  <script type="text/javascript" src="../../daterangepicker-master/daterangepicker-master/moment.min.js"></script>
	<script type="text/javascript" src="../../daterangepicker-master/daterangepicker-master/daterangepicker.js"></script>
  


</body>
</html>