<!DOCTYPE html>
<html>
<title>Take Order</title>
<meta name="viewport" content="width=device-width, initial-scale=1">
<link rel="stylesheet" href="/css/w3.css">

</body>
</html> 

<style>
ul {
  list-style-type: none;
  margin: 0;
  padding: 0;
  overflow: hidden;
  background-color: #333;
}

li {
  float: left;
}

li a {
  display: block;
  color: white;
  text-align: center;
  padding: 14px 16px;
  text-decoration: none;
}

li a:hover {
  background-color: #111;
}
</style>
</head>
<body>

<meta name="viewport" content="width=device-width, initial-scale=1">
<style>
body {margin:0;}

.navbar {
  overflow: hidden;
  background-color: #333;
  position: fixed;
  top: 0;
  width: 100%;
}

.navbar a {
  float: left;
  display: block;
  color: #f2f2f2;
  text-align: center;
  padding: 14px 16px;
  text-decoration: none;
  font-size: 17px;
}

.navbar a:hover {
  background: #ddd;
  color: black;
}

.main {
  padding: 16px;
  margin-top: 30px;
  height: 1500px; /* Used in this example to enable scrolling */
}
</style>
</head>
<body>
<div class="navbar">
<?php
require_once("function.php"); 
header("Content-Type: text/html; charset=utf-8");

@session_start();/*
if(!checkUser()){    echo Message(35,"red",$titel1,$msg1,"<a href='login.php?link=employee.entry'> $login </a>");
  exit;
  }*/
include('class/mysqli_oop.php');
$db = new Database();
$db->connect();
$shop_id = "1";//$_SESSION["UShopid"];  
$position_order = 148;//"Bar1"; // table

/*
$val =  "y";
$table_name = "tbl_table_que_detail";
$col_var = array('status_active'=>@$val);            
$db->update($table_name,$col_var,"id=".@$position_order);
*/



$sqlcmd = "select id,category_food from tbl_category_food where shopid = $shop_id and category_status = 'y' order by category_order_by";// echo $sqlcmd;
$db->sql($sqlcmd);
$res = $db->getResult();	
	foreach($res as $data){
        echo "<a href='?id=".@$data["id"]."'>".@$data["category_food"]."</a>";
    }	
?>
<a href="#all">รายการที่เลือก</a>
<a href="#all">ย้ายโต๊ะ/รวมโต๊ะ</a>
</div>
<link rel="stylesheet" href="w3.css">
<form id='frm' method='POST' action="" class="form-horizontal">
<div id="page-wrapper">
<div class="container-fluid">
<div class="row" id="main" >
<div class="row">
<div class="col-sm-12" style=""> <h4>รายการอาหาร</h4>      </div>
</div>
<div class="row">
</div>
<div class="col-sm-12 col-md-12 well" id="content">


  <table class="table table-striped" width="100%">
    <tr>
      <th>ลำดับที่</th>
      <th>ชื่ออาหาร</th>
      <th>ปกติ</th>
      <th>พิเศษ</th>
      <th>กลับบ้าน</th>
      <th>&nbsp;</th>
    </tr>


<?php
$id = $_REQUEST["id"];
$sqlcmddt = "select * from tbl_category_food_detail where shopid=$shop_id and category_food_id = $id and status_food='y' order by food_name"; 
$db->sql(@$sqlcmddt);
$resdt =@ $db->getResult();	
$i=0;
foreach($resdt as $datadt){
    @$i++;
?>
  <tr>
    <td><center><?php echo @$i;?></center></td>
    <td><?php echo @$datadt["food_name"]?></td>
    <td><center><img src="img/del.jpeg" height="22" width="22" />&nbsp;
        <?php echo @$datadt["normal_price"]?>&nbsp;
        <img src="img/add.jpg" height="22" width="22" /></center></td>
    <td><center><img src="img/del.jpeg" height="22" width="22" />&nbsp;
        <?php echo @$datadt["extra_price"]?>&nbsp;
        <img src="img/add.jpg" height="22" width="22" /></center></td>
    <td><center><img src="img/del.jpeg" height="22" width="22" />&nbsp;
        <?php echo @$datadt["takeaway"]?>&nbsp;
        <img src="img/add.jpg" height="22" width="22" /></center></td>
    <td>
    <div class="w3-row">
       <div class="w3-half">
          <input type="button"  value="ยืนยัน"> 
       </div>
       </div>
    </td>
  </tr>
<?php 
	}	
?>
</table>
</div>

</div>
</div>
</form>

</div>
<script type="text/javascript">
$(document).ready(function(){
    $("#Save").click(function(){   
          var shopid = document.getElementById("shopid").value;
          var cat_id = document.getElementById("cat_id").value;
          var category_food = document.getElementById("category_food").value;
          var category_status = document.getElementById("category_status").value;
          var category_order_by = document.getElementById("category_order_by").value;
      //    alert(cat_id); 
        $.post('executesql.php',{ mode : "category_food" , 
          shopid : shopid,
          cat_id : cat_id,
          category_food : category_food,
          category_status : category_status,
          category_order_by : category_order_by },
        function(data) {
            window.parent.location.href ="foodmenu.index.php?id="+Math.random(100*1000,1000/2);
          });
        return false;
      });
</script>
