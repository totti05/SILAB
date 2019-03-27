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
		<form class="filtro">
			<select id="categoria" name="tipo">
				<option value="Todo">Todo</option>
				<option value="Una vez">Una vez</option>
				<option value="Diario">Diario</option>
				<option value="Semanal">Semanal</option>
				<option value="Mensual">Mensual</option>
				<option value="Mensual relativo">Mensual relativo</option>
				<option value="Cuando SQL Server Agent inicie">Inician con SQL Server Agent</option>
				<option value="Cuando el servidor esté desocupado">Servidor esté desocupado</option>
			</select>
			<select id="filtro" name="tipo">
				<option value="Todo">Todo</option>
				<option value="DTS">DTS</option>
				<option value="Respaldo">Respaldo</option>
				<input type="button" class="boton filtrar" value="[Filtrar]">
			</select>
		</form>
        <table id="tabla">
            <caption><h3>Estatus de la plataforma DTS de <span id="paquete-servidor">-</span></h3></caption>
            <thead>
                <tr>
                    <th id="nombre" class="cabecera" scope="col" onclick="set_orden(this.id)" >Job</th>
                    <th id="tipo" class="cabecera" scope="col" onclick="set_orden(this.id)">Tipo</th>
                    <th scope="col">Horario</th>
                    <th scope="col" ></th>
                    <th id="ultimo_resultado" scope="col" class="cabecera" onclick="set_orden(this.id)">[Resultado</br>Estatus</th>
                    <th id="fecha_ultima_ejecucion, hora_ultima_ejecucion" class="cabecera" scope="col" onclick="set_orden(this.id)">anterior]</br>desde</th>
                    <th id="estatus" scope="col" class="cabecera" onclick="set_orden(this.id)">Estatus</th>
                </tr>
            </thead>
            <tbody id="paquetes">
					<tr>
						<th colspan="6"><div id="cargando"></div> </th>
					</tr>
            </tbody>
        </table>
    </section>
    <footer id="pie">
    </footer>
</body>
</html>
