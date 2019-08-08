<?php
session_start(); 
header("Content-Type: text/html; charset=utf-8"); 
require_once("function.php"); 
@session_start();
if(!checkUser()){    echo Message(35,"red",$titel1,$msg1,"<a href='login.php?link=login'> $login </a>");
  exit;
  }
include('class/mysqli_oop.php');
$db = new Database();
$db->connect();

$mode = $_REQUEST["mode"];
switch ($mode) {
        case "insert.shop" : 
        $id = @$_REQUEST["id"];
        $shop_id = @$_REQUEST["shop_id"];
        $shop_name = @$_REQUEST["shop_name"];
        $contact_name = @$_REQUEST["contact_name"];
        $tel = @$_REQUEST["tel"];
        $address = @$_REQUEST["address"];
        $level_shop = @$_REQUEST["level_shop"];
        $position_shop = @$_REQUEST["position_shop"];
        $gps_shop = @$_REQUEST["gps_shop"];
        $status_shop = @$_REQUEST["status_shop"];

		$col_var = array('shop_id'=>$shop_id,'shop_name'=>$shop_name,'contact_name'=>$contact_name,'tel'=>$tel,'address'=>$address,'level_shop'=>$level_shop,'position_shop'=>$position_shop,'gps_shop'=>$gps_shop,'status_shop'=>$status_shop);
		$table_name = "tbl_shop";
        if($id==""){            
			$db->insert($table_name,$col_var);	
        } else if($id!=""){		
		    $db->update($table_name,$col_var,'id = '.$id); 	
        }
        //echo $id;
        $db->disconnect();
    break;

    case "category_food" : 
    
        $shopid = @$_REQUEST["shopid"];
        $cat_id = @$_REQUEST["cat_id"];
        $category_food = @$_REQUEST["category_food"];
        $category_status = @$_REQUEST["category_status"];
        $category_order_by = @$_REQUEST["category_order_by"];

		$col_var = array('category_food'=>$category_food,'category_status'=>$category_status,'category_order_by'=>$category_order_by,'shopid'=>$shopid);
		$table_name = "tbl_".$mode;
        if($cat_id==""){            
            echo $db->insert($table_name,$col_var);	
            echo "insert success";
           
        } else if($cat_id!=""){		
            echo $db->update($table_name,$col_var,'id = '.$cat_id); 	
            echo "update success";
        }
        //echo $id;
        $db->disconnect();
    break;

    case "category_food_detail" : 
    
        $id = @$_REQUEST["id"];
        $shopid = @$_REQUEST["shopid"];                     
        $cate_id = @$_REQUEST["cate_id"];

        $foodname = @$_REQUEST["foodname"];
        $normalprice = @$_REQUEST["normalprice"];
        $extraprice = @$_REQUEST["extraprice"];
        $takeaway = @$_REQUEST["takeaway"];
        $status_food = @$_REQUEST["status_food"];


		$col_var = array('shopid'=>$shopid,'category_food_id'=>$cate_id,'food_name'=>$foodname,'normal_price'=>$normalprice,'extra_price'=>$extraprice,'takeaway'=>$takeaway,'status_food'=>$status_food);
		$table_name = "tbl_".$mode;
        if($id==""){            
             $db->insert($table_name,$col_var);	
          
        } else if($id!=""){		
		    $db->update($table_name,$col_var,'id = '.$id); 	
            echo "update seccess.";
        }
        
        echo " =".base64_encode($cate_id);
        $db->disconnect();
    break;

    
    case "table_que" : 
        $shopid = $_SESSION["UShopid"];
        $table_mnt = @$_REQUEST["table_mnt"];
        $que_mnt = @$_REQUEST["que_mnt"];
        $bar_mnt = @$_REQUEST["bar_mnt"];
       
		$table_name = "tbl_".$mode;

        //header 
        $db->delete($table_name,"shopid=".$shopid);
		$col_var = array('shopid'=>$shopid,'table_mnt'=>$table_mnt,'que_mnt'=>$que_mnt,'bar_mnt'=>$bar_mnt);            
        $db->insert($table_name,$col_var);	
        
        //detail
        $table_name_detail = "tbl_".$mode."_detail";
        $db->delete($table_name_detail,"shopid=".$shopid);
        
        for($i=1;$i<=$bar_mnt;$i++){
            $tbl = "Bar".$i;
            $state = "y";
            $col_var_detail = array('shopid'=>$shopid,'seq'=>$i,'mnt'=>$tbl,'status_active'=>$state);            
            $db->insert($table_name_detail,$col_var_detail);  
        }
        for($i=1;$i<=$que_mnt;$i++){
            $tbl = "Que".$i;
            $state = "y";
            $col_var_detail = array('shopid'=>$shopid,'seq'=>$i,'mnt'=>$tbl,'status_active'=>$state);            
            $db->insert($table_name_detail,$col_var_detail);  
        }
        for($i=1;$i<=$table_mnt;$i++){
            $tbl = "Table".$i;
            $state = "y";
            $col_var_detail = array('shopid'=>$shopid,'seq'=>$i,'mnt'=>$tbl,'status_active'=>$state);            
            $db->insert($table_name_detail,$col_var_detail);  
        }


        $db->disconnect();
    break;


    case "change_value_table_que" : 
        $id = base64_decode(@$_REQUEST["id"]);
        $val = @$_REQUEST["val"];
		$table_name = "tbl_table_que_detail";
		$col_var = array('status_active'=>$val);            
        $db->update($table_name,$col_var,"id=".$id);	
        $db->disconnect();

    break;

    
    case "user" : 
        $user_id = base64_decode(@$_REQUEST["user_id"]);       
        $fname = @$_REQUEST["fname"];
        $sname = @$_REQUEST["sname"];
        $username = @$_REQUEST["username"];
        $tpassword = @$_REQUEST["tpassword"];
        $tel = @$_REQUEST["tel"];
        $status_user = @$_REQUEST["status_active"];
        $status_position = @$_REQUEST["status_position"];
        $email = @$_REQUEST["email"];
        $address = @$_REQUEST["address"];
        $shopid = $_SESSION["UShopid"];
        $col_var = array('fname'=>$fname,'sname'=>$sname,'username'=>$username,'password'=>$tpassword,'shop_id'=>$shopid,
        'tel'=>$tel,'status_user'=>$status_user,'permission_user'=>$status_position,'email'=>$email,'address'=>$address);
		$table_name = "tbl_".$mode;
        if($user_id==""){            
            echo $db->insert($table_name,$col_var);	
            echo "insert seccess.";
        } else if($user_id!=""){		
		    $db->update($table_name,$col_var,'id = '.$user_id); 	
            echo "update seccess.";
        }
        $db->disconnect();

    break;

    case "cashdrawer" :      
        $cashdrawer = @$_REQUEST["cashdrawer"];
        $shopid = $_SESSION["UShopid"];
        $col_var = array('shopid'=>$shopid,'cashdrawer'=>$cashdrawer);
        $table_name = "tbl_".$mode;
        $db->delete($table_name,"shopid=".$shopid);            
        $db->insert($table_name,$col_var);	
        echo "insert seccess.";       
        $db->disconnect();

    break;
}