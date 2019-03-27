<?php
?>

<!DOCTYPE html>
<html lang="en">

<head>
	<title> SILAB Iniciar Sesion</title>
	<meta autor="Raul">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <link rel="stylesheet" href="./bootstrap-4.1.3-dist/css/bootstrap.css"> 
	<link rel="stylesheet" type="text/css" href="./estilos2.css">  
	<!-- <script type="text/javascript" src="./bootstrap-3.3.7-dist/respond.min.js"> </script> -->
</head>



	<body id="login" class="">
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
					<a id="btn_login" class="btn btn-outline-success" href="./login.php" role="button">Iniciar Sesion</a>
				</form>
			</div>
		</nav>
	</header> 
	<!-- 
	<nav class="navbar navbar-default navbar-fixed-top">
	      <div class="container">
	        <div class="">
	          <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar" aria-expanded="false" aria-controls="navbar">
	            <span class="sr-only">Toggle navigation</span>
	            <span class="icon-bar"></span>
	            <span class="icon-bar"></span>
	            <span class="icon-bar"></span>
	          </button>
	          <a class="navbar-brand" href="#">Project name</a>
	        </div>
	        <div id="navbar" class="navbar-collapse collapse">
	          <ul class="nav navbar-nav">
	            <li class="active"><a href="#">Home</a></li>
	            <li><a href="#about">About</a></li>
	            <li><a href="#contact">Contact</a></li>
	            <li class="dropdown">
	              <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">Dropdown <span class="caret"></span></a>
	              <ul class="dropdown-menu">
	                <li><a href="#">Action</a></li>
	                <li><a href="#">Another action</a></li>
	                <li><a href="#">Something else here</a></li>
	                <li role="separator" class="divider"></li>
	                <li class="dropdown-header">Nav header</li>
	                <li><a href="#">Separated link</a></li>
	                <li><a href="#">One more separated link</a></li>
	              </ul>
	            </li>
	          </ul>
	          <ul class="nav navbar-nav navbar-right">
	            <li><a href="">Default</a></li>
	            <li><a href="">Static top</a></li>
	            <li class="active"><a href="./">Fixed top <span class="sr-only">(current)</span></a></li>
	          </ul>
	        </div><!-/.nav-collapse ->
	      </div>
	  </nav>
  -->

 <!--    <div class="nav">
      <div class="">
        <a class="navbar-brand" href="#">Title</a>
        <ul class="">
          <li class="active"><a href="#">Home</a></li>
          <li><a href="#">Link</a></li>
          <li><a href="#">Link</a></li>
        </ul>
      </div>
    </div>
 -->




	<main>
	
	<!-- 	<script type="text/javascript">
		alert("ESTA PAGINA ESTA EN VERSION DE PRUEBA");
	</script>
	 -->
	 
	 	 <div id="inicio" class= "row" >
	 	 	<div class= "col-4 offset-3" >
	 	 		 <a href= "login.php" class= "thumbnail"><img src= "../imagenes/CVG.jpg"> </a> 
	 	  	</div> 
	 	 	<div class="col-3">
	 	  		<a href= "login.php" class= "thumbnail" ><img src= "../imagenes/venalum_Nuevo.jpg"> </a> 
	 	  	</div>
	 	  </div>
	 	
	 




		<!-- <div id="login" class="container-fluid">

			<h1>Iniciar sesion</h1>
			<form id="form-signin" method="POST" action="login.php">
				<label for="inputEmail" class="sr-only ">FICHA</label>
				<input type="email" id="inputEmail" class="form-control" placeholder="Ficha" required autofocus>
				<label for="inputPassword" class="sr-only">Contraseña</label>
				<input type="password" id="inputPassword" class="form-control" placeholder="Contrasena" required>
				<div class="checkbox mb-3 text-center">
					<label>
						<input type="checkbox" value="remember-me"> Recuerdame
					</label>
				</div>
				<button class="btn btn-lg btn-primary btn-block" type="submit">Iniciar sesion</button>
			</form>
		</div>-->
	</main>

	<footer class="text-center footer">
		<div class="container">
			<span class="text-muted">SILAB</span>
		</div>
	</footer>

	 <script src="./bootstrap-4.1.3-dist/jquery-3.3.1.min.js"></script>
	<script src="./bootstrap-4.1.3-dist/popper.js"></script>
	<script src="./bootstrap-4.1.3-dist/js/bootstrap.js"></script> 
</html>