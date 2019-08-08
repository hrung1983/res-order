<?php
   //header("Content-Type: text/html; charset=utf-8"); 
@session_start();
    $msg1 = "คุณไม่มีสิทธิ์ใช้งานหน้านี้";
    $msg2 = "กรุณากลับไปล็อกอินอีกครั้ง";
    $titel1 = "แจ้งเตือน";
    $login = "ล็อกอินใหม่";
    $back = "กลับ";
    
	function setfont($str){
        return iconv( 'UTF-8', 'TIS-620', $str);
    }
	
    function format_moneys($val){
    	return number_format(sprintf("%01.2f", $val),2);
    }
   
    function Message($Size,$Color,$Message,$Comment,$Link){
        $temp = "<br><center>\n";
        $temp .= "<table width=$Size% border=0 cellspacing=0 cellpadding=0 bgcolor=#000000>\n";
        $temp .= "<tr><td><table width=100% border=0 cellpadding=2 cellspacing=1>\n";
        $temp .= "<tr bgcolor=#FFFFCC>\n"; 
        $temp .= "<td align=center><br>\n";
        $temp .= "<font color=$Color class=size3><b>$Message</b></font>\n";
        $temp .= "<br><br>$Comment<br><br>\n";
        $temp .= "</td></tr></table></td></tr></table><br>\n";
        $temp .= "[ $Link ]\n";
        $temp .= "</center>\n";
        return ( $temp ) ;
    }   

    function checkUser(){ 
        if(isset($_SESSION["Uid"])){
            return  true;
        } else {				
            return false;
        }
    }

    function checkAdmin(){ 
        if($_SESSION["Uposition"]=="Admin"){
            return  true;
        } else {				
            return false;
        }
    }
    

    function getDteTme(){
        $today = getdate();
        $dte = $today["year"] ."-".$today["mon"]."-".$today["mday"]." ".($today["hours"]-1).":".$today["minutes"].":".$today["seconds"];         
        return $dte;
    }
?>