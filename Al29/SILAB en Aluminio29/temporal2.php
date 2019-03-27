<form id="celdas" name="celdas" action="Reporte_E.php"><table id="form"><tr><td><br /><label for="fecha">Fecha:</label></td><td><br /><input name="id1" type="textarea" /> &nbsp;<input type="button" onclick="c1.popup(\'id1\');" value="..." /></td></tr><tr><td><br /><label for="complejo">Complejo:</label></td><td style="text-align:left"><br /><select id="complejo" name="complejo"><option value="1" selected="selected">1</option><option value="2">2</option><option value="3">3</option><option value="T">T (Todos los complejos)</option></select></td></tr><tr><td colspan="2" style="text-align:center"><br /><input  type="submit" value="Entrar" />&nbsp;<input type="button" value="Salir" onclick="window.location=\'index.html\'" /></td></tr></table></form>
<form id="celdas" name="celdas"><table id="form"><tr><td><br /><label for="semana">Semana:</label></td><td style="text-align:left"><br /><select id="semana" name="semana"><option value="1" selected="selected">De Lunes a Domingo</option></select></td></tr><tr><td><br /><label for="sala">Sala:</label></td><td style="text-align:left"><br /><select id="sala" name="sala"><option value="1" selected="selected">Desde la 1 a la 11</option></select></td></tr><tr><td colspan="2" style="text-align:center"><br /><input type="button" value="Entrar" />&nbsp;<input type="button" value="Salir" onclick="window.location=\'index.html\'" /></td></tr></table></form>

<?PHP






//-----------------------------
function lunes($dia,$mes,$ano){ 
$now = time();
$num = date("w", mktime(0,0,0,$mes,$dia,$ano));
echo $num."<br>";
if ($num == 0)
{ $sub = 6; }
else { $sub = ($num-1); }
$WeekMon  = mktime(0, 0, 0, date("m", $now)  , date("d", $now)-$sub, date("Y", $now));    //monday week begin calculation
$todayh = getdate($WeekMon); //monday week begin reconvert
$d = $todayh[mday];
$m = $todayh[mon];
$y = $todayh[year];
$lunes="$d/$m/$y"; //getdate converted day
return $lunes;
}

echo lunes('04','10','2007');
?> 
