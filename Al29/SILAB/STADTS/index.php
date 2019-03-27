<?php
?>

<html lang="es-ES">
<head>
    <title>STADTS</title>
    <meta charset="utf-8">
    <link href="css/stadts.css" rel="stylesheet" type="text/css">
    <!--[if lte IE 8]><script src="js/html5shiv.js"></script><![endif]-->
    <script language="javascript" type="text/javascript" src="js/jquery.min.js"></script>
	<script language="javascript" type="text/javascript" src="js/script.js" charset="UTF-8"></script>
	<script language="javascript" type="text/javascript" src="js/json3.min.js"></script>
</head>
<body id="cuerpo">
    <header id="header"> <!--Cabecera-->
        <a id="titulo" href="index.php"> <!--título del sitio-->
            <h1>STADTS</h1>
            <h4>Piso de Planta</h4>
        </a>
        <nav> <!--menú de navegación-->
            <ul>
                <a href="historia.php">Historia de Jobs Congelados</a>
            </ul>
        </nav>
    </header>
    <section id=contenido> <!--Contenido-->
        <div id="redvem"> <!--banner red de Venalum-->
            <h3>Red de Venalum</h3>
        </div>
        <div id=layout>
            <ul id="instancias" class="layout pp">
				<li><div id="cargando"></div></li>
            </ul>
        </div>

    </section>
    <div class="push"></div>
    <footer id="pie"> <!--Pie de página-->
    <section id=leyenda instancia> <!--Leyenda-->
        <ul id="serv">
        </ul>
    </section>
    </footer>
</body>
</html>
