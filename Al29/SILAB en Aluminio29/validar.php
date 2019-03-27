<?PHP

require_once('Connections/PORTAL.php');
  
$query_Recordset1 = "SELECT N_FICHA, NOMBRE, APELLIDOS FROM VPERSONAL WHERE N_FICHA='".$uname."'";
$Recordset1 = $PORTAL->SelectLimit($query_Recordset1) or die($PORTAL->ErrorMsg());
$Existe_usuario = $Recordset1->RecordCount();
$usuario= $Recordset1->Fields('nombre')." ".$Recordset1->Fields('apellidos')."   Ficha: ".$Recordset1->Fields('N_FICHA');

 
 
//AQUI SE DETERMINA LOS GRUPOS VALIDOS
$GRUPO=" (GRUPO=213 OR GRUPO= 213)";
$query_Recordset2 = "SELECT N_FICHA, GRUPO FROM VGRUPO WHERE N_FICHA='".$uname."'"." AND ".$GRUPO ;
$Recordset2 = $PORTAL->SelectLimit($query_Recordset2) or die($PORTAL->ErrorMsg());
$Existe_en_Grupo = $Recordset2->RecordCount();


//AQUI SE DETERMINA GRUPO ADMINISTRADORES 1
$GRUPO=" (GRUPO=213)";
$query_Recordset3 = "SELECT N_FICHA, GRUPO FROM VGRUPO WHERE N_FICHA='".$uname."'"." AND ".$GRUPO ;
$Recordset3 = $PORTAL->SelectLimit($query_Recordset3) or die($PORTAL->ErrorMsg());
$totalRows_Recordset3 = $Recordset3->RecordCount();
$gadministrador = $Recordset3->RecordCount();


//AQUI SE DETERMINA El GRUPO USUARIO
$GRUPO=" (GRUPO=213)";
$query_Recordset5 = "SELECT N_FICHA, GRUPO FROM VGRUPO WHERE N_FICHA='".$uname."'"." AND ".$GRUPO ;
$Recordset5 = $PORTAL->SelectLimit($query_Recordset5) or die($PORTAL->ErrorMsg());
$totalRows_Recordset5 = $Recordset5->RecordCount();
$gusuario = $Recordset5->RecordCount();



