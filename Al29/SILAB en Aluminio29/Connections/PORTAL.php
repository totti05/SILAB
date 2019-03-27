<?php 
	# PHP ADODB document - made with PHAkt
	# FileName="Connection_php_adodb.htm"
	# Type="ADODB"
	# HTTP="true"
	# DBTYPE="mssql"
	
	$MM_PORTAL_HOSTNAME = "ALUMINIO20\DHW";
	$MM_PORTAL_DATABASE = "mssql:PORTAL";
	$MM_PORTAL_DBTYPE   = preg_replace("/:.*$/", "", $MM_PORTAL_DATABASE);
	$MM_PORTAL_DATABASE = preg_replace("/^.*?:/", "", $MM_PORTAL_DATABASE);
	$MM_PORTAL_USERNAME = "PORTAL";
	$MM_PORTAL_PASSWORD = "PORTAL";
	$MM_PORTAL_LOCALE = "ES";
	$MM_PORTAL_LOCALE = "ES";
	$MM_PORTAL_MSGLOCALE = "En";
	$MM_PORTAL_CTYPE = "P";
	$KT_locale = $MM_PORTAL_MSGLOCALE;
	$KT_dlocale = $MM_PORTAL_LOCALE;
	$KT_serverFormat = "%Y-%m-%d %H:%M:%S";
	$QUB_Caching = "false";
	
	switch (strtoupper ($MM_PORTAL_LOCALE)) {
		case 'EN':
				$KT_localFormat = "%d-%m-%Y %H:%M:%S";
		break;
		case 'EUS':
				$KT_localFormat = "%m-%d-%Y %H:%M:%S";
		break;
		case 'FR':
				$KT_localFormat = "%d-%m-%Y %H:%M:%S";
		break;
		case 'RO':
				$KT_localFormat = "%d-%m-%Y %H:%M:%S";
		break;
		case 'IT':
				$KT_localFormat = "%d-%m-%Y %H:%M:%S";
		break;
		case 'GE':
				$KT_localFormat = "%d-%m-%Y %H:%M:%S";
		break;
		case 'US':
				$KT_localFormat = "%Y-%m-%d %H:%M:%S";
		break;
		default :
				$KT_localFormat = "none";			
	}


	
	if (!defined('CONN_DIR')) define('CONN_DIR',dirname(__FILE__));
	require_once(CONN_DIR."/../adodb/adodb.inc.php");
	ADOLoadCode($MM_PORTAL_DBTYPE);
	$PORTAL=&ADONewConnection($MM_PORTAL_DBTYPE);

	if($MM_PORTAL_DBTYPE == "access" || $MM_PORTAL_DBTYPE == "odbc"){
		if($MM_PORTAL_CTYPE == "P"){
			$PORTAL->PConnect($MM_PORTAL_DATABASE, $MM_PORTAL_USERNAME,$MM_PORTAL_PASSWORD, 
			$MM_PORTAL_LOCALE);
		} else $PORTAL->Connect($MM_PORTAL_DATABASE, $MM_PORTAL_USERNAME,$MM_PORTAL_PASSWORD, 
			$MM_PORTAL_LOCALE);
	} else if (($MM_PORTAL_DBTYPE == "ibase") or ($MM_PORTAL_DBTYPE == "firebird")) {
		if($MM_PORTAL_CTYPE == "P"){
			$PORTAL->PConnect($MM_PORTAL_HOSTNAME.":".$MM_PORTAL_DATABASE,$MM_PORTAL_USERNAME,$MM_PORTAL_PASSWORD);
		} else $PORTAL->Connect($MM_PORTAL_HOSTNAME.":".$MM_PORTAL_DATABASE,$MM_PORTAL_USERNAME,$MM_PORTAL_PASSWORD);
	}else {
		if($MM_PORTAL_CTYPE == "P"){
			$PORTAL->PConnect($MM_PORTAL_HOSTNAME,$MM_PORTAL_USERNAME,$MM_PORTAL_PASSWORD,
   			$MM_PORTAL_DATABASE,$MM_PORTAL_LOCALE);
		} else $PORTAL->Connect($MM_PORTAL_HOSTNAME,$MM_PORTAL_USERNAME,$MM_PORTAL_PASSWORD,
   			$MM_PORTAL_DATABASE,$MM_PORTAL_LOCALE);
   }

	if (!function_exists("updateMagicQuotes")) {
		function updateMagicQuotes($HTTP_VARS){
			if (is_array($HTTP_VARS)) {
				foreach ($HTTP_VARS as $name=>$value) {
					if (!is_array($value)) {
						$HTTP_VARS[$name] = addslashes($value);
					} else {
						foreach ($value as $name1=>$value1) {
							if (!is_array($value1)) {
								$HTTP_VARS[$name1][$value1] = addslashes($value1);
							}
						}
						
					}
					global $$name;
					$$name = &$HTTP_VARS[$name];
				}
			}
			return $HTTP_VARS;
		}
		
		if (!get_magic_quotes_gpc()) {
			$HTTP_GET_VARS = updateMagicQuotes($HTTP_GET_VARS);
			$HTTP_POST_VARS = updateMagicQuotes($HTTP_POST_VARS);
			$HTTP_COOKIE_VARS = updateMagicQuotes($HTTP_COOKIE_VARS);
		}
	}
	if (!isset($HTTP_SERVER_VARS['REQUEST_URI'])) {
		$HTTP_SERVER_VARS['REQUEST_URI'] = $HTTP_SERVER_VARS['PHP_SELF'];
	}
?>
