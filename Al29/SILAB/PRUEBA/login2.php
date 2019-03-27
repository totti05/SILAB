<!DOCTYPE html>
<html>
<head>
  <title>Bienvenido al SILAB</title>
  <meta autor="Raul">
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
          <a id="btn_registro" class="btn btn-outline-success active" href="./cerrarsesion.php" role="button">Cerrar Sesi&otilde;n</a>
        </form>
      </div>
    </nav>
  </header> 
  <main class="">
    
    <?php 
   require 'conexion.php';
   class usuario{

        var $ficha;
        var $pass;
        var $passnuevo;
        function setFicha ($ficha){
                 
         $this->ficha = $ficha;
        }
        function setPass ($pass){
                 
          $this->pass = $pass; 
        }
        function setPassnuevo ($passnuevo){
                 
          $this->passnuevo = $passnuevo; 
        }
     }
     
      $conexion = conectar_mssql() ;



      //guarda los datos del formulario
      $pusuario = new usuario();
      $pusuario->setFicha(trim($_POST['inputficha']));
      $pusuario->setPass(trim($_POST['inputPassword']));
      //echo ''.$pusuario->ficha;
      //echo ''.$pusuario->pass;
      //$pass = md5($password);
      

      $conexionSILAB = conectar_mssql_SILAB($pusuario->ficha, $pusuario->pass);
      // echo '<script>alert("si pertenece al silab")</script>';

      if (isset($conexionSILAB)) {
        session_start();
        $_SESSION['usuario'] = $pusuario->ficha;
        $_SESSION['password'] = $pusuario->pass;
        $_SESSION['verificado'] = 1;
      } else{

        header('location:  sesion.php?error=1');
      }



      if (isset($conexion)) {
         $query="SELECT nombre, apellido FROM [dbo].[V_AL20_SCP_SILAB_FORANEOS_personal] WHERE ficha = '".$pusuario->ficha."'";
          //enviar query
          //mssql_query($query, $conexion) or die ("<h2>error al enviar datos a la bs</h2>"); 

          $res_query=mssql_query($query, $conexion);
          //si no hay problema con la consulta
          if (isset($res_query)) {

            while ($usuario = mssql_fetch_object($res_query)){

              echo '<div id="form-signin" class="text-center">';
              echo '<h2 class="">Bienvenido '.trim($usuario->apellido).' '.trim($usuario->nombre).'</h2>';
              //text-center
              echo '<div class= "row" >';
              //col-4 offset-4
              echo '<div class= "col" >';
              echo '<a href="./menu.php" class="btn btn-menu btn-block btn-outline-primary" role="button">MENU<a>';
              echo '<a href="cambiarclave.php" class="btn btn-menu btn-block btn-outline-primary" role="button">cambiar clave<a>';
              echo '</div>';
              echo '</div>';
              echo '</div>';
              
            } 

          }else{ 

             echo '<script>alert("error en la consulta(query)")</script>';
          }
    }
    mssql_close($conexion);
    exit();
?>


  </main>



  <footer class="text-center footer">
    <div class="container">
      <span class="text-muted">SILAB</span>
    </div>
  </footer>

   <script src="./bootstrap-4.1.3-dist/jquery-3.3.1.min.js"></script>
  <script src="./bootstrap-4.1.3-dist/popper.js"></script>
  <script src="./bootstrap-4.1.3-dist/js/bootstrap.js"></script> 
</body>
</html>



