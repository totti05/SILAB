<?php
?>

<html lang="es">
<html lang="es-ES">
<head>
    <title>STADTS</title>
    <meta charset="utf-8">
    <link href="css/stadts.css" rel="stylesheet" type="text/css">
    <link href="css/tablesorter-theme.css" rel="stylesheet" type="text/css">
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
        <table id="tabla">
            <caption><h3>Historia de Jobs Congelados</h3></caption>
            <thead>
                <tr>
                    <th id="nombre" scope="col" >Job</th>
                    <th id="tipo" scope="col">Propietario</th>
                    <th scope="col" ></th>
                    <th id="estatus" scope="col" onclick="set_orden(this.id)">Estatus</th>
                </tr>
            </thead>
            <tbody id="paquetes">
					<tr>
						<th colspan="4"><div id="cargando"></div> </th>
					</tr>
            </tbody>
        </table>
    </section>
    <footer id="pie">
    </footer>
</body>
</html>
