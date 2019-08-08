<?php
header("Content-Type: text/html; charset=utf-8");
require_once("function.php");  
include "header.php";
@session_start();
if(!checkUser()){    echo Message(35,"red",$titel1,$msg1,"<a href='login.php?link=employee.entry'> $login </a>");
  exit;
  }
include('class/mysqli_oop.php');
$db = new Database();
$db->connect();



?>
<link rel="stylesheet" href="w3.css">
<form id='frm' method='POST' action="" class="form-horizontal">
<div id="page-wrapper">
<div class="container-fluid">
<div class="row" id="main" >
<div class="row">
<div class="col-sm-12" style=""> <h4>รายการอาหารที่ชื่นชอบ</h4>      </div>
</div>
<div class="row">
<div class="col-sm-6" style="text-align: left; padding-top:30px; padding-bottom:15px;">
  <a href="shop.index.php"><button type="button" class="btn btn-warning btn-sm" title="กลับ"><i class="glyphicon glyphicon-circle-arrow-left"></i> กลับ</button></a>
  </div>
<div class="col-sm-6" style="text-align: right; padding-top:30px; padding-bottom:15px;">
<button type="button" id="Save" class="btn btn-success btn-sm" title="บันทึก"><i class="glyphicon glyphicon-floppy-save"></i> บันทึก</button>
</div>
</div>
<div class="col-sm-12 col-md-12 well" id="content">


  <table class="table table-striped">
    <!--tr>
      <th>ลำดับที่</th>
      <th>ประเภท</th>
      <th>ชื่ออาหาร</th>
      <th>สถานะ</th>
      <th>&nbsp;</th>
    </-->
<?php
$shop_id = $_SESSION["UShopid"];    
  $sqlcmd = "select id,category_food from tbl_category_food where category_status = 'y' and shopid = $shop_id "; 
  $db->sql($sqlcmd);
$res = $db->getResult();	
	foreach($res as $data){
		$id = @$data["id"];
		$category_food = @$data["category_food"];
?>
<tr>
    <td colspan="3" align="left"><?php echo @$category_food;?></td>
</tr>
<?php
$sqlcmddt = "select * from tbl_category_food_detail where shopid=$shop_id and category_food_id = $id order by food_name"; 
$db->sql(@$sqlcmddt);
$resdt =@ $db->getResult();	
$i=0;
foreach($resdt as $datadt){
    @$i++;
?>
  <tr>
    <td><center><?php echo @$i;?></center></td>
    <td><?php echo @$datadt["food_name"]?></td>
    <td>
    <div class="w3-row">
       <div class="w3-half">
          <input type="checkbox" id="checkval<?php echo base64_encode($datadt['id']);?>" class="w3-check" value="<?php echo base64_encode($datadt['id']);?>"> 
       </div>
       </div>
    </td>
  </tr>
<?php 
	}	
}?>
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
          alert(cat_id); 
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
      

});
</script>
