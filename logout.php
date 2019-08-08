<?php
@session_start();
unset($_SESSION["Uid"]);        
unset($_SESSION["Uname"]);
unset($_SESSION["Usname"]);
unset($_SESSION["Uposition"]);
header("Location: login.php?link=index");
?>
