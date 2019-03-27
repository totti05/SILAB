<?php
    session_start();
    if (isset($_SESSION['verificado'])) {
     
    

?><!DOCTYPE hmtl>
  <head>
    <title>Menu SILAB</title>
    <meta autor="">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <link rel="stylesheet" href="./bootstrap-4.1.3-dist/css/bootstrap.css"> 
    <link rel="stylesheet" type="text/css" href="./estilos2.css"> 
  </head>

  <body>
    <header>
        <nav class="navbar fixed-top navbar-expand-md navbar-light bg-light">
          <a class="navbar-brand" href="./login.php">SILAB PRUEBA</a>
          <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent"
           aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
          </button>

          <div class="collapse navbar-collapse" id="navbarSupportedContent">
            <ul class="navbar-nav mr-auto">
              <li class="nav-item active">
                <a class="nav-link" href="./acercade.php">Acerca de <span class="sr-only">(current)</span></a>
              </li>
              
            </ul>
            <form class="form-inline my-2 my-lg-0">
              <a id="btn_registro" class="btn btn-outline-success active" href="./cerrarsesion.php" role="button">Cerrar sesi&oacute;n</a>
            </form>
          </div>
        </nav>
      </header>     
    <main>
      <div class="container-fluid pt-5">
        <div class="row ">
          <div class="col-12 offset-2 offset-md-2 col-md-4 col-sm-6 offset-sm-0 ">
            <a href="./MuestrasCarbon.php" class="btn btn-menuP btn-block btn-outline-primary " role="button">Analisis Fisico Quimico de Carbon</a>
            <a href="./MuestrasE.php" class="btn btn-menuP btn-block btn-outline-primary" role="button" >Muestras especiales</a>
            
            <a href="./LotesFisico.php" class="btn btn-menuP btn-block btn-outline-primary" role="button">Analisis fisico de anodos cocido (Lote fisico)</a>

          </div>
          <div class=" col-12 offset-2 col-sm-6 offset-sm-0 col-md-4 offset-md-0 ">
            <a href="./AguaySedimentales.php" class="btn btn-menuP btn-block btn-outline-primary" role="button">Analisis de agua y particulas sedimentales</a>

            <a href="./LotesQuimicos.php" class="btn btn-menuP btn-block btn-outline-primary" role="button">Analisis Quimico de Anodos Cocidos (lotes quimicos)</a>
            <a href="./Flakt.php" class="btn btn-menuP btn-block btn-outline-primary" role="button">Planta Flakt</a>

          </div>
        </div>
      </div>
    
    </main>
    <footer class="text-center footer">
        <div class="container">
          <span class="text-muted">Raul App</span>
        </div>
    </footer>

    <script src="./bootstrap-4.1.3-dist/jquery-3.3.1.min.js"></script>
    <script src="./bootstrap-4.1.3-dist/popper.js"></script>
    <script src="./bootstrap-4.1.3-dist/js/bootstrap.js"></script> 
  </body>
 

</html>
<?php 
}else
echo "usted no puede entrar aca directamente";
?>