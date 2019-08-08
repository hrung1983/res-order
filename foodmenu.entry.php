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
 
$id = base64_decode(@$_REQUEST["id"]);

$shop_id = $_SESSION["UShopid"];  


if($id!=""){
  $sqlcmd = "select * from tbl_category_food where id = $id"; 
  $db->sql($sqlcmd);
$res = $db->getResult();	
	foreach($res as $data){
		$id = @$data["id"];
		$category_food = @$data["category_food"];
		$category_status = @$data["category_status"];
		$category_order_by = @$data["category_order_by"];
	}	
}
?>
<form id='frm' method='POST' action="" class="form-horizontal">
<div id="page-wrapper">
<div class="container-fluid">
<div class="row" id="main" >
<div class="row">
<div class="col-sm-12" style=""> <h4>รายละเอียดประเภทอาหาร</h4>      </div>
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

<input type="hidden" class="form-control" id="cat_id" name="cat_id" value="<?php echo @$id;?>">
<input type="hidden" class="form-control" id="shopid" name="shopid" value="<?php echo @$shop_id?>">
<div class="form-group row">
    <div class="col-md-offset-1 col-md-8">
        <div class="form-group">
        </div>
        <div class="form-group">
          <label class="col-sm-2 control-label">ประเภทของอาหาร : </label>
          <div class="col-sm-10">
              <input type="text" class="form-control" id="category_food" name="category_food" value="<?php echo @$category_food;?>" placeholder="กรุณากรอกประเภทของอาหาร">
          </div>
        </div>
        <div class="form-group">
          <label class="col-sm-2 control-label">สถานะการใช้งาน :  </label>
          <div class="col-sm-10">
            <select id="category_status" name="category_status" class="form-control">
              <option value="y" <?php if(@$category_status=="y") echo "selected";?>>ใช้งานปกติ</option>
              <option value="n" <?php if(@$category_status=="n") echo "selected";?>>ยกเลิกการใช้งาน</option>
            </select>
        </div>
        </div>
        <div class="form-group">
          <label class="col-sm-2 control-label">เรียงลำดับ  : </label>
          <div class="col-sm-10">
          <input type="text" class="form-control" id="category_order_by" name="category_order_by" value="<?php echo @$category_order_by;?>" placeholder="กรุณากรอกตัวเลขที่จะเรียงลำดับ">
          </div>
        </div>

        
        </div>
    </div>
</div>


<div class="table_show">
<?php if(@$id!=""){?>
  <table class="table table-striped">
    <tr>
      <th>ลำดับที่</th>
      <th>ชื่ออาหาร</th>
      <th>ราคาปกติ</th>
      <th>ราคาพิเศษ</th>
      <th>ราคากลับบ้าน</th>
      <th>สถานะ</th>
      <th>&nbsp;</th>
    </tr>
    <tr>
      <th><input type="text" id="" name="" class="form-control" style="width: 50px;" readonly></th>
      <th><input type="text" id="foodname" name="foodname" class="form-control"></th>
      <th><input type="text" id="normalprice" name="normalprice" class="form-control" style="width: 80px;"></th>
      <th><input type="text" id="extraprice" name="extraprice" class="form-control" style="width: 80px;"></th>
      <th><input type="text" id="takeaway" name="takeaway" class="form-control" style="width: 80px;"></th>
      <th><select id="status_food" name="status_food" class="form-control"><option value="y">ใช้งาน</option><option value="n">ยกเลิก</option></select></th>
      <th><button type="button" id="SaveItem" class="btn btn-success btn-sm" title="บันทึก"><i class="glyphicon glyphicon-floppy-save"></i> บันทึก</button></th>
    </tr>
<?php
$sqlcmddt = "select * from tbl_category_food_detail where shopid=$shop_id and category_food_id = $id order by food_name"; 
$db->sql(@$sqlcmddt);
$resdt =@ $db->getResult();	
foreach($resdt as $datadt){
    @$i++;
?>
  <tr>
    <td><center><font color="<?php echo $fontcolor;?>"><?php echo @$i;?></font></center></td>
    <td><font color="<?php echo $fontcolor;?>"><?php echo @$datadt["food_name"]?></font></td>
    <td><center><font color="<?php echo $fontcolor;?>"><?php echo @$datadt["normal_price"]?><center></font></td>
    <td><center><font color="<?php echo $fontcolor;?>"><?php echo @$datadt["extra_price"]?><center></font></td>
    <td><center><font color="<?php echo $fontcolor;?>"><?php echo @$datadt["takeaway"]?><center></font></td>
    <td><font color="<?php echo $fontcolor;?>"><?php if(@$datadt["status_food"]=="y") echo "ใช้งาน"; else "ยกเลิก"; ?></font></td>
    <td>
      <a href="foodmenu.entry.php?id=<?php echo base64_encode(@$data["id"])?>"><button type="button" class="btn btn-info btn-xs" title="Edit"><i class="glyphicon glyphicon-pencil"></i></button></a>
      
    </td>
  </tr>
<?php } ?>
</table>
<?php }?>
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
      


      $("#SaveItem").click(function(){
        
          var shopid = document.getElementById("shopid").value;
          var cate_id = document.getElementById("cat_id").value;
          var foodname = document.getElementById("foodname").value;
          var normalprice = document.getElementById("normalprice").value;
          var extraprice = document.getElementById("extraprice").value;
          var takeaway = document.getElementById("takeaway").value;
          var status_food = document.getElementById("status_food").value;
       
        $.post('executesql.php',{ mode : "category_food_detail", 
          shopid : shopid,
          cate_id : cate_id,
          foodname : foodname,
          normalprice : normalprice,
          extraprice : extraprice,
          takeaway : takeaway,
          status_food : status_food},
        function(data) {
          var ressplit = data.split("1 =");
          var cid = ressplit[1];
        //  alert(cid);
            window.parent.location.href ="foodmenu.entry.php?sid=&=&id="+cid+"&cid_math="+Math.random(100*1000,1000/2);
          });
        return false;
      });
});
</script>
