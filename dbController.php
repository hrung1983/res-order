<?php

class DBController {
	private $host = "";
	private $user = "system";
	private $password = "1234567890";
	private $database = "//localhost/xe";
	private $objConnect;
	
	function __construct() {
		$this->objConnect = $this->connectDB();
	}
	
	function connectDB() {
		$objConnect =  oci_connect($this->user,$this->password,$this->database,'AL32UTF8');
		return $objConnect;
	}
	
	function runQuery($query) {
		$objParse = @oci_parse($this->objConnect,$query);
    	@oci_execute($objParse);
		while($objResult= oci_fetch_array($objParse,OCI_BOTH)){				
			$resultset[] = $objResult;	
		}
		if(!empty($resultset))return $resultset;
	}
	

}
?>