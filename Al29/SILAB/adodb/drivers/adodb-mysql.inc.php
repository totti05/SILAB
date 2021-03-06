<?php

if (! defined("_ADODB_MYSQL_LAYER")) {
 define("_ADODB_MYSQL_LAYER", 1 );

class ADODB_mysql extends ADOConnection {
	var $databaseType = 'mysql';
	var $dataProvider = 'mysql';
	var $hasInsertID = true;
	var $hasAffectedRows = true;	
	var $metaTablesSQL = "SHOW TABLES";	
	var $metaColumnsSQL = "SHOW COLUMNS FROM %s";
	var $fmtTimeStamp = "'Y-m-d H:i:s'";
	var $hasLimit = true;
	var $hasMoveFirst = true;
	var $hasGenID = true;
	var $upperCase = 'upper';
	var $isoDates = true; // accepts dates in ISO format
	var $sysDate = 'CURDATE()';
	var $sysTimeStamp = 'NOW()';
	var $hasTransactions = false;
	var $forceNewConnect = false;
	var $poorAffectedRows = true;
	var $clientFlags = 0;
	
	function ADODB_mysql() 
	{			
	}
	
	function ServerInfo()
	{
		$arr['description'] = $this->GetOne("select version()");
		$arr['version'] = ADOConnection::_findvers($arr['description']);
		return $arr;
	}
	
	
	function _insertid()
	{
			return mysql_insert_id($this->_connectionID);
	}
	
	function _affectedrows()
	{
			return mysql_affected_rows($this->_connectionID);
	}
  
 	var $_genIDSQL = "update %s set id=LAST_INSERT_ID(id+1);";
	var $_genSeqSQL = "create table %s (id int not null)";
	var $_genSeq2SQL = "insert into %s values (%s)";
	var $_dropSeqSQL = "drop table %s";
	
	function CreateSequence($seqname='adodbseq',$startID=1)
	{
		if (empty($this->_genSeqSQL)) return false;
		$u = strtoupper($seqname);
		
		$ok = $this->Execute(sprintf($this->_genSeqSQL,$seqname));
		if (!$ok) return false;
		return $this->Execute(sprintf($this->_genSeq2SQL,$seqname,$startID-1));
	}
	
	function GenID($seqname='adodbseq',$startID=1)
	{
		if (!$this->hasGenID) return false;
		
		$getnext = sprintf($this->_genIDSQL,$seqname);
		$rs = @$this->Execute($getnext);
		if (!$rs) {
			$u = strtoupper($seqname);
			$this->Execute(sprintf($this->_genSeqSQL,$seqname));
			$this->Execute(sprintf($this->_genSeq2SQL,$seqname,$startID-1));
			$rs = $this->Execute($getnext);
		}
		$this->genID = mysql_insert_id($this->_connectionID);
		
		if ($rs) $rs->Close();
		
		return $this->genID;
	}
	
  	function &MetaDatabases()
	{
		$qid = mysql_list_dbs($this->_connectionID);
		$arr = array();
		$i = 0;
		$max = mysql_num_rows($qid);
		while ($i < $max) {
			$arr[] = mysql_tablename($qid,$i);
			$i += 1;
		}
		return $arr;
	}
	
	function SQLDate($fmt, $col=false)
	{	
		if (!$col) $col = $this->sysDate;
		$s = 'DATE_FORMAT('.$col.",'";
		$concat = false;
		$len = strlen($fmt);
		for ($i=0; $i < $len; $i++) {
			$ch = $fmt[$i];
			switch($ch) {
			case 'Y':
			case 'y':
				$s .= '%Y';
				break;
			case 'Q':
			case 'q':
				$s .= "'),Quarter($col)";
				
				if ($len > $i+1) $s .= ",DATE_FORMAT($col,'";
				else $s .= ",('";
				$concat = true;
				break;
			case 'M':
			case 'm':
				$s .= '%m';
				break;
			case 'D':
			case 'd':
				$s .= '%d';
				break;
			default:
				
				if ($ch == '\\') {
					$i++;
					$ch = substr($fmt,$i,1);
				}
				$s .= $ch;
				break;
			}
		}
		$s.="')";
		if ($concat) $s = "CONCAT($s)";
		return $s;
	}
	function Concat()
	{
		$s = "";
		$arr = func_get_args();
		$first = true;
		$s = implode(',',$arr); 
		if (strlen($s) > 0) return "CONCAT($s)";
		else return '';
	}
	
	function OffsetDate($dayFraction,$date=false)
	{		
		if (!$date) $date = $this->sysDate;
		return "from_unixtime(unix_timestamp($date)+($dayFraction)*24*3600)";
	}
	
	// returns true or false
	function _connect($argHostname, $argUsername, $argPassword, $argDatabasename, $locale='')
	{
	global $ADODB_PHPVER;
		if ($ADODB_PHPVER >= 0x4300)
			$this->_connectionID = mysql_connect($argHostname,$argUsername,$argPassword,
												$this->forceNewConnect,$this->clientFlags);
		else if ($ADODB_PHPVER >= 0x4200)
			$this->_connectionID = mysql_connect($argHostname,$argUsername,$argPassword,
												$this->forceNewConnect);
		else
			$this->_connectionID = mysql_connect($argHostname,$argUsername,$argPassword);
	
		if ($this->_connectionID === false) return false;
		// Interakt
		$this->_setDateLocale($locale);
		// Interakt
		if ($argDatabasename) return $this->SelectDB($argDatabasename);
		return true;	
	}
	
	// returns true or false
	function _pconnect($argHostname, $argUsername, $argPassword, $argDatabasename, $locale='')
	{
	global $ADODB_PHPVER;
		if ($ADODB_PHPVER >= 0x4300)
			$this->_connectionID = mysql_pconnect($argHostname,$argUsername,$argPassword,$this->clientFlags);
		else
			$this->_connectionID = mysql_pconnect($argHostname,$argUsername,$argPassword);
		if ($this->_connectionID === false) return false;
		// Interakt
		$this->_setDateLocale($locale);
		// Interakt
		if ($this->autoRollback) $this->RollbackTrans();
		if ($argDatabasename) return $this->SelectDB($argDatabasename);
		return true;	
	}
/** InterAKT
	 *
	 * Specifies if the db server supports LOCALES
	 *
	 * @return false (MySQL does not support locales
	 */
	function HasLocale() {
	  return false;
	}
	// InterAKT
		
	function _nconnect($argHostname, $argUsername, $argPassword, $argDatabasename, $locale='')
	{
		$this->forceNewConnect = true;
		$this->_connect($argHostname, $argUsername, $argPassword, $argDatabasename,$locale);
	}
	
 	function &MetaColumns($table) 
	{
	
		if ($this->metaColumnsSQL) {
		global $ADODB_FETCH_MODE;
		
			$save = $ADODB_FETCH_MODE;
			$ADODB_FETCH_MODE = ADODB_FETCH_NUM;
			
			$rs = $this->Execute(sprintf($this->metaColumnsSQL,$table));
			
			$ADODB_FETCH_MODE = $save;
			
			if ($rs === false) return false;
			
			$retarr = array();
			while (!$rs->EOF){
				$fld = new ADOFieldObject();
				$fld->name = $rs->fields[0];
				$fld->type = $rs->fields[1];
				$fld->type = preg_replace("/,.*\)/", ")", $fld->type);
				if (preg_match("/^(.+)\((\d+)\)$/", $fld->type, $query_array)) {
					$fld->type = $query_array[1];
					$fld->max_length = $query_array[2];
				} else {
					$fld->type = preg_replace("/\(.*\)/", "", $fld->type);
					$fld->max_length = -1;
				}
				$fld->not_null = ($rs->fields[2] != 'YES');
				$fld->primary_key = ($rs->fields[3] == 'PRI');
				$fld->auto_increment = (strpos($rs->fields[5], 'auto_increment') !== false);
				$fld->binary = (strpos($fld->type,'blob') !== false);
				if (!$fld->binary) {
					$d = $rs->fields[4];
					if ($d != "" && $d != "NULL") {
						$fld->has_default = true;
						$fld->default_value = $d;
					} else {
						$fld->has_default = false;
					}
				}
				
				$retarr[($fld->name)] = $fld;	//Interakt
				$rs->MoveNext();
			}
			$rs->Close();
			return $retarr;	
		}
		return false;
	}
	function SelectDB($dbName) 
	{
		$this->databaseName = $dbName;
		if ($this->_connectionID) {
			return @mysql_select_db($dbName,$this->_connectionID);		
		}
		else return false;	
	}
	function &SelectLimit($sql,$nrows=-1,$offset=-1,$inputarr=false, $arg3=false,$secs=0)
	{
		$offsetStr =($offset>=0) ? "$offset," : '';
		
		return ($secs) ? $this->CacheExecute($secs,$sql." LIMIT $offsetStr$nrows",$inputarr,$arg3)
			: $this->Execute($sql." LIMIT $offsetStr$nrows",$inputarr,$arg3);
		
	}
	function _query($sql,$inputarr)
	{
	global $ADODB_COUNTRECS;
		if($ADODB_COUNTRECS) return mysql_query($sql,$this->_connectionID);
		else return mysql_unbuffered_query($sql,$this->_connectionID); // requires PHP >= 4.0.6
	}
	function ErrorMsg() 
	{
		if (empty($this->_connectionID)) $this->_errorMsg = @mysql_error();
		else $this->_errorMsg = @mysql_error($this->_connectionID);
		return $this->_errorMsg;
	}
	function ErrorNo() 
	{
			if (empty($this->_connectionID))  return @mysql_errno();
			else return @mysql_errno($this->_connectionID);
	}
	
	function _close()
	{
		@mysql_close($this->_connectionID);
		$this->_connectionID = false;
	}

	 function ActualType($meta)
	{
		switch($meta) {
		case 'C': return 'VARCHAR';
		case 'X': return 'LONGTEXT';
		
		case 'C2': return 'VARCHAR';
		case 'X2': return 'LONGTEXT';
		
		case 'B': return 'LONGBLOB';
			
		case 'D': return 'DATE';
		case 'T': return 'DATETIME';
		case 'L': return 'TINYINT';
		case 'R': return 'INTEGER NOT NULL AUTO_INCREMENT';
		case 'I': return 'INTEGER';  // enough for 9 petabytes!
		
		case 'F': return 'DOUBLE';
		case 'N': return 'NUMERIC';
		default:
			return false;
		}
	}
	function CharMax()
	{
		return 255; 
	}
	function TextMax()
	{
		return 4294967295; 
	}
	
}

class ADORecordSet_mysql extends ADORecordSet{	
	
	var $databaseType = "mysql";
	var $canSeek = true;
	
	function ADORecordSet_mysql($queryID, $locale='',$mode=false) 
	{
		if ($mode === false) { 
			global $ADODB_FETCH_MODE;
			$mode = $ADODB_FETCH_MODE;
		}
		switch ($mode)
		{
		case ADODB_FETCH_NUM: $this->fetchMode = MYSQL_NUM; break;
		case ADODB_FETCH_ASSOC:$this->fetchMode = MYSQL_ASSOC; break;
		default:
		case ADODB_FETCH_DEFAULT:
		case ADODB_FETCH_BOTH:$this->fetchMode = MYSQL_BOTH; break;
		}
	
		$this->ADORecordSet($queryID);	
		$this->_setLocale($locale);
	}
	
		/** Interakt
	*  Change the SQL connection locale to a specified locale.
	*  This is used to get the date formats written depending on the client locale.
	*/
	function _setLocale($locale = 'Us')
	{
		$this->locale = $locale;
		switch (strtoupper ($locale))
		{
			case 'US':
				$this->fmtDate="%Y-%m-%d";
				$this->fmtTimeStamp = "%Y-%m-%d %H:%M:%S";
				break;
			case 'EN':
				$this->fmtDate="%d-%m-%Y";
				$this->fmtTimeStamp = "%d-%m-%Y %H:%M:%S";
				break;
			case 'EUS':
				$this->fmtDate="%m-%d-%Y";
				$this->fmtTimeStamp = "%m-%d-%Y %H:%M:%S";
				break;
			case 'FR':
				$this->fmtDate="%d-%m-%Y";
				$this->fmtTimeStamp = "%d-%m-%Y %H:%M:%S";
				break;
			case 'RO':
				$this->fmtDate="%d-%m-%Y";
				$this->fmtTimeStamp = "%d-%m-%Y %H:%M:%S";
				break;
			case 'IT':
				$this->fmtDate="%d-%m-%Y";
				$this->fmtTimeStamp = "%d-%m-%Y %H:%M:%S";
				break;
			case 'GE':
				$this->fmtDate="%d.%m.%Y";
				$this->fmtTimeStamp = "%d.%m.%Y %H:%M:%S";
				break;
			default :
				$this->fmtDate="%Y-%m-%d";
				$this->fmtTimeStamp = "%Y-%m-%d %H:%M:%S";
			
		}
	}
	// Interakt
	function _initrs()
	{
	GLOBAL $ADODB_COUNTRECS;
		$this->_numOfRows = ($ADODB_COUNTRECS) ? @mysql_num_rows($this->_queryID):-1;
		$this->_numOfFields = @mysql_num_fields($this->_queryID);
	}
	
	function &FetchField($fieldOffset = -1) 
	{	
	
		if ($fieldOffset != -1) {
			$o = @mysql_fetch_field($this->_queryID, $fieldOffset);
			$f = @mysql_field_flags($this->_queryID,$fieldOffset);
			$o->max_length = @mysql_field_len($this->_queryID,$fieldOffset); // suggested by: Jim Nicholson (jnich@att.com)
			$o->binary = (strpos($f,'binary')!== false);
		}
		else if ($fieldOffset == -1) {	/*	The $fieldOffset argument is not provided thus its -1 	*/
			$o = @mysql_fetch_field($this->_queryID);
			$o->max_length = @mysql_field_len($this->_queryID); // suggested by: Jim Nicholson (jnich@att.com)
		}
			
		return $o;
	}

	function &GetRowAssoc($upper=true)
	{
		if ($this->fetchMode == MYSQL_ASSOC && !$upper) return $rs->fields;
		return ADORecordSet::GetRowAssoc($upper);
	}
	function Fields($colname)
	{	
	if ($this->fetchMode != MYSQL_NUM) {
		// Interakt
		if ($this->locale != "none") {
			setlocale (LC_TIME, $this->locale);
			if ($this->types[$colname]=="datetime") {
				return KT_ADOconvertDate($this->fields[$colname],"%Y-%m-%d %H:%M:%S", $this->fmtTimeStamp);
			} else if ($this->types[$colname]=="date") {
				if ($this->fields[$colname]) {
			    return KT_ADOconvertDate($this->fields[$colname],"%Y-%m-%d %H:%M:%S", $this->fmtDate);
				} else { 
					return @unescapeQuotes($this->fields[$colname]); 
				} 
			}
			setlocale (LC_TIME, "C");
		}
		// Interakt
		return @unescapeQuotes($this->fields[$colname]);
	} else if (!$this->bind) {
			$this->bind = array();
			for ($i=0; $i < $this->_numOfFields; $i++) {
				$o = $this->FetchField($i);
				$this->bind[($o->name)] = $i;
			}
		}
		 return unescapeQuotes($this->fields[$this->bind[($colname)]]);
	}
	
	function _seek($row)
	{
		if ($this->_numOfRows == 0) return false;
		return @mysql_data_seek($this->_queryID,$row);
	}
	
	function MoveNext() 
	{
		if (!$this->EOF) {		
			$this->_currentRow++;
			$this->exfields = $this->fields;//INTERKAT
			$this->fields = @mysql_fetch_array($this->_queryID,$this->fetchMode);
			
			if (is_array($this->fields)) return true;
			$this->EOF = true;
		}
		return false;
	}	
	
	function _fetch()
	{
		// Interakt - Begin
		$types=array();
		$i = 0;
		$n=mysql_num_fields ($this->_queryID);
		while ($i < $n) {
			$meta = mysql_fetch_field ($this->_queryID);
    			if ($meta) {
				$this->types[$meta->name]=$meta->type;
	    		}
    			$i++;
    		}
	    	// Interakt - End
		$this->fields = @mysql_fetch_array($this->_queryID,$this->fetchMode);
		return (is_array($this->fields));
	}
	
	function _close() {
		@mysql_free_result($this->_queryID);	
		$this->_queryID = false;	
	}
	
	function MetaType($t,$len=-1,$fieldobj=false)
	{
		if (is_object($t)) {
			$fieldobj = $t;
			$t = $fieldobj->type;
			$len = $fieldobj->max_length;
		}
		
		$len = -1; // mysql max_length is not accurate
		switch (strtoupper($t)) {
		case 'STRING': 
		case 'CHAR':
		case 'VARCHAR': 
		case 'TINYBLOB': 
		case 'TINYTEXT': 
		case 'ENUM': 
		case 'SET': 
			if ($len <= $this->blobSize) return 'C';
			
		case 'TEXT':
		case 'LONGTEXT': 
		case 'MEDIUMTEXT':
			return 'X';
		case 'IMAGE':
		case 'LONGBLOB': 
		case 'BLOB':
		case 'MEDIUMBLOB':
			return !empty($fieldobj->binary) ? 'B' : 'X';
			
		case 'DATE': return 'D';
		
		case 'TIME':
		case 'DATETIME':
		case 'TIMESTAMP': return 'T';
		
		case 'INT': 
		case 'INTEGER':
		case 'BIGINT':
		case 'TINYINT':
		case 'MEDIUMINT':
		case 'SMALLINT': 
			
			if (!empty($fieldobj->primary_key)) return 'R';
			else return 'I';
		
		default: return 'N';
		}
	}

}
}
?>
