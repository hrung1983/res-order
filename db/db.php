<?php
header("Content-Type: text/html; charset=utf-8"); 
ini_set("error_reporting","E_ALL & ~E_NOTICE");
date_default_timezone_set('Asia/Bangkok');

//localhost
//$objConnect = oci_connect("system","1234567890","//localhost/xe",'AL32UTF8');

// Server QNET
//$objConnect = oci_connect("ADSADM","Advert1sement","//129.200.15.1:1527/QNET",'AL32UTF8'); 



$system['type'] = "mysql";
switch($system['type']){

	case "oracle":
		require_once dirname(__FILE__) . "/db/oracle.php";
		$hostname = "(DESCRIPTION=(ADDRESS_LIST = (ADDRESS = (PROTOCOL = TCP)(HOST = ".$system['database']['hostname'].")(PORT = 1521)))(CONNECT_DATA=(SID = ".$system['database']['sid'].")))";
		$db = new sql_db($hostname, $system['database']['username'], $system['database']['password'], $system['database']['databasename'], false);
		break;
    case "mysql":	
		require_once("db/mysql.php");
        $db = new sql_db('localhost','root','','db_food', true);
       // $db->sql_query("SET CHARACTER SET utf-8");
       // $db->sql_query("SET character_set_results=utf-8");
        //$db->sql_query("SET character_set_client=utf-8");
        //$db->sql_query("SET character_set_connection=utf-8"); 
        break;  	
    case "mssql":
        require_once dirname(__FILE__) . "/db/mssql.php";
        $db = new sql_db($system['database']['hostname'], $system['database']['username'], $system['database']['password'], $system['database']['databasename'], false);
        break;        
}


?>