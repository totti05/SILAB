<?php 
	# PHP ADODB document - made with PHAkt
	# FileName="Connection_php_adodb.htm"
	# Type="ADODB"
	# HTTP="true"
	# DBTYPE="mssql"
	
	$MM_ODBC_HOSTNAME = "ALUMINIO20\SCP";
	$MM_ODBC_DATABASE = "mssql:INFORMATICA";
	$MM_ODBC_DBTYPE   = preg_replace("/:.*$/", "", $MM_ODBC_DATABASE);
	$MM_ODBC_DATABASE = preg_replace("/^.*?:/", "", $MM_ODBC_DATABASE);
	$MM_ODBC_USERNAME = "XIO";
	$MM_ODBC_PASSWORD = "XIO";
	$MM_ODBC_LOCALE = 'EN';
	$MM_ODBC_MSGLOCALE = "EN";
	$MM_ODBC_CTYPE = "P";
	$KT_locale = $MM_ODBC_MSGLOCALE;
	$KT_dlocale = $MM_ODBC_LOCALE;
	$KT_serverFormat = "%Y-%m-%d %H:%M:%S";
	//$KT_serverFormat = "%d-%m-%Y";
	$QUB_Caching = "false";
	
	switch (strtoupper ($MM_ODBC_LOCALE)) {
		case 'EN':
				$KT_localFormat = "%d-%m-%Y %H:%M:%S";
				//$KT_localFormat = "%d-%m-%Y";
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
				$KT_localFormat = "%d.%m.%Y %H:%M:%S";
		break;
		case 'US':
				$KT_localFormat = "%Y-%m-%d %H:%M:%S";
		break;
		default :
				$KT_localFormat = "none";			
	}


	
	if (!defined('CONN_DIR')) define('CONN_DIR',dirname(__FILE__));
	require_once(CONN_DIR."/../adodb/adodb.inc.php");
	ADOLoadCode($MM_ODBC_DBTYPE);
	$ODBC=&ADONewConnection($MM_ODBC_DBTYPE);

	if($MM_ODBC_DBTYPE == "access" || $MM_ODBC_DBTYPE == "odbc"){
		if($MM_ODBC_CTYPE == "P"){
			$ODBC->PConnect($MM_ODBC_DATABASE, $MM_ODBC_USERNAME,$MM_ODBC_PASSWORD, 
			$MM_ODBC_LOCALE);
		} else $ODBC->Connect($MM_ODBC_DATABASE, $MM_ODBC_USERNAME,$MM_ODBC_PASSWORD, 
			$MM_ODBC_LOCALE);
	} else if (($MM_ODBC_DBTYPE == "ibase") or ($MM_ODBC_DBTYPE == "firebird")) {
		if($MM_ODBC_CTYPE == "P"){
			$ODBC->PConnect($MM_ODBC_HOSTNAME.":".$MM_ODBC_DATABASE,$MM_ODBC_USERNAME,$MM_ODBC_PASSWORD);
		} else $ODBC->Connect($MM_ODBC_HOSTNAME.":".$MM_ODBC_DATABASE,$MM_ODBC_USERNAME,$MM_ODBC_PASSWORD);
	}else {
		if($MM_ODBC_CTYPE == "P"){
			$ODBC->PConnect($MM_ODBC_HOSTNAME,$MM_ODBC_USERNAME,$MM_ODBC_PASSWORD,
   			$MM_ODBC_DATABASE,$MM_ODBC_LOCALE);
		} else $ODBC->Connect($MM_ODBC_HOSTNAME,$MM_ODBC_USERNAME,$MM_ODBC_PASSWORD,
   			$MM_ODBC_DATABASE,$MM_ODBC_LOCALE);
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
