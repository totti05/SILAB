<?PHP

require_once('Connections/PORTAL.php');
  
$query_Recordset1 = "SELECT N_FICHA, NOMBRE, APELLIDOS FROM VPERSONAL WHERE N_FICHA='".$uname."'";
$Recordset1 = $PORTAL->SelectLimit($query_Recordset1) or die($PORTAL->ErrorMsg());
$Existe_usuario = $Recordset1->RecordCount();
$usuario= $Recordset1->Fields('nombre')." ".$Recordset1->Fields('apellidos')."   Ficha: ".$Recordset1->Fields('N_FICHA');
// define si >0 el usuario existe
 
 
//AQUI SE DETERMINA LOS GRUPOS VALIDOS
$GRUPO=" ((GRUPO >= 200 AND GRUPO <= 208) OR GRUPO = 13)";
$query_Recordset2 = "SELECT N_FICHA, GRUPO FROM VGRUPO WHERE N_FICHA='".$uname."'"." AND ".$GRUPO ;
$Recordset2 = $PORTAL->SelectLimit($query_Recordset2) or die($PORTAL->ErrorMsg());
$gadministrador = $Recordset2->RecordCount();

//AQUI SE DETERMINA LOS GRUPOS VALIDOS
$GRUPO=" GRUPO = 200 ";
$query_Recordset2 = "SELECT N_FICHA, GRUPO FROM VGRUPO WHERE N_FICHA='".$uname."'"." AND ".$GRUPO ;
$Recordset2 = $PORTAL->SelectLimit($query_Recordset2) or die($PORTAL->ErrorMsg());
$gadministrador1 = $Recordset2->RecordCount();
//if ($gadministrador1 > 0) $tipo_usuario_1 = 4;

//AQUI SE DETERMINA LOS GRUPOS VALIDOS
$GRUPO=" (GRUPO = 200 OR GRUPO=13 OR GRUPO=203)";
$query_Recordset2 = "SELECT N_FICHA, GRUPO FROM VGRUPO WHERE N_FICHA='".$uname."'"." AND ".$GRUPO ;
$Recordset2 = $PORTAL->SelectLimit($query_Recordset2) or die($PORTAL->ErrorMsg());
$gadministrador2 = $Recordset2->RecordCount();

//AQUI SE DETERMINA SI ES DE REDUCCION
$GRUPO=" (GRUPO = 204)";
$query_Recordset2 = "SELECT N_FICHA, GRUPO FROM VGRUPO WHERE N_FICHA='".$uname."'"." AND ".$GRUPO ;
$Recordset5 = $PORTAL->SelectLimit($query_Recordset2) or die($PORTAL->ErrorMsg());
$gadministrador5 = $Recordset5->RecordCount();
if ($gadministrador5 > 0) $tipo_usuario_1 = 1;

//AQUI SE DETERMINA SI ES DE CARBON
$GRUPO=" (GRUPO = 205)";
$query_Recordset2 = "SELECT N_FICHA, GRUPO FROM VGRUPO WHERE N_FICHA='".$uname."'"." AND ".$GRUPO ;
$Recordset5 = $PORTAL->SelectLimit($query_Recordset2) or die($PORTAL->ErrorMsg());
$gadministrador5 = $Recordset5->RecordCount();
if ($gadministrador5 > 0) $tipo_usuario_1 = 2;

//AQUI SE DETERMINA SI ES DE COLADA
$GRUPO=" (GRUPO = 206)";
$query_Recordset2 = "SELECT N_FICHA, GRUPO FROM VGRUPO WHERE N_FICHA='".$uname."'"." AND ".$GRUPO ;
$Recordset5 = $PORTAL->SelectLimit($query_Recordset2) or die($PORTAL->ErrorMsg());
$gadministrador5 = $Recordset5->RecordCount();
if ($gadministrador5 > 0) $tipo_usuario_1 = 3;

//AQUI SE DETERMINA SI ES DE CCYP
$GRUPO=" (GRUPO = 208)";
$query_Recordset2 = "SELECT N_FICHA, GRUPO FROM VGRUPO WHERE N_FICHA='".$uname."'"." AND ".$GRUPO ;
$Recordset5 = $PORTAL->SelectLimit($query_Recordset2) or die($PORTAL->ErrorMsg());
$gadministrador5 = $Recordset5->RecordCount();
if ($gadministrador5 > 0) $tipo_usuario_1 = 4;

//AQUI SE DETERMINA SI ES DE MANTENIMIENTO
$GRUPO=" (GRUPO = 207)";
$query_Recordset2 = "SELECT N_FICHA, GRUPO FROM VGRUPO WHERE N_FICHA='".$uname."'"." AND ".$GRUPO ;
$Recordset5 = $PORTAL->SelectLimit($query_Recordset2) or die($PORTAL->ErrorMsg());
$gadministrador5 = $Recordset5->RecordCount();
if ($gadministrador5 > 0) $tipo_usuario_1 = 6;

//AQUI SE DETERMINA SI ES DE SUPERVISORES
$GRUPO=" (GRUPO = 200)";
$query_Recordset2 = "SELECT N_FICHA, GRUPO FROM VGRUPO WHERE N_FICHA='".$uname."'"." AND ".$GRUPO ;
$Recordset5 = $PORTAL->SelectLimit($query_Recordset2) or die($PORTAL->ErrorMsg());
$gadministrador5 = $Recordset5->RecordCount();
if ($gadministrador5 > 0) $tipo_usuario_2 = 7;


//AQUI SE DETERMINA SI ES DE MANTENIMIENTO
$GRUPO=" (GRUPO = 199)";
$query_Recordset2 = "SELECT N_FICHA, GRUPO FROM VGRUPO WHERE N_FICHA='".$uname."'"." AND ".$GRUPO ;
$Recordset5 = $PORTAL->SelectLimit($query_Recordset2) or die($PORTAL->ErrorMsg());
$gadministrador5 = $Recordset5->RecordCount();
if ($gadministrador5 > 0) $dpto_observ_usuario = 1;

//AQUI SE DETERMINA SI ES DE PCO PARA CARGAR PLAN SUMINISTROS
$GRUPO=" (GRUPO = 212)";
$query_Recordset2 = "SELECT N_FICHA, GRUPO FROM VGRUPO WHERE N_FICHA='".$uname."'"." AND ".$GRUPO ;
$Recordset5 = $PORTAL->SelectLimit($query_Recordset2) or die($PORTAL->ErrorMsg());
$gadministrador5 = $Recordset5->RecordCount();
if ($gadministrador5 > 0) $tipo_usuario_2 = 8;
