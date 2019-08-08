<?php
session_start(); 
require_once("function.php"); 
include('class/mysqli_oop.php');
$db = new Database();
$db->connect();
$username=$_REQUEST["txtusername"];
$password=$_REQUEST["txtpassword"];
$link = @$_REQUEST["link"];
 	$sqlcmd = "SELECT
                    *
                    FROM
                    tbl_user
				WHERE tbl_user.username='$username' and tbl_user.`password`='$password' and tbl_user.status_user = 'y'";

$db->sql($sqlcmd);
$res = $db->getResult();
$row = $db->numRows();
if($row==0){
	echo Message(35,"red",$titel1,$msg1,"<a href='login.php?link=login'> $login </a>");
	exit;
} else {
	foreach($res as $output){
				$_SESSION["Uid"] = $output["id"];        
				$_SESSION["Uname"] = $output["fname"];
				$_SESSION["Usname"] = $output["sname"];
				$_SESSION["Upermission_user"] = $output["permission_user"];
				$_SESSION["UShopid"] = $output["shop_id"];
			  if($link != ""){
				 header("Location:$link.php"); 
			  } else {
				 header("Location:shop.index.php"); 
			 }
	}	
}
?>