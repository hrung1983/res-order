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

if($id!=""){
  $sqlcmd = "select * from tbl_shop where id = $id";
  $db->sql($sqlcmd);
$res = $db->getResult();	
	foreach($res as $data){
		$id = @$data["id"];
		$shop_id = @$data["shop_id"];
		$shop_name = @$data["shop_name"];
		$contact_name = @$data["contact_name"];
		$tel = @$data["tel"];
		$address = @$data["address"];
		$level_shop = @$data["level_shop"];
		$position_shop = @$data["position_shop"];
		$gps_shop = @$data["gps_shop"];
		$status_shop = @$data["status_shop"];
	}	
}
?>
<form id='frm' method='POST' action="" class="form-horizontal">
<div id="page-wrapper">
<div class="container-fluid">
<div class="row" id="main" >
<div class="row">
<div class="col-sm-12" style=""> <h4>ข้อมูลร้านค้า</h4>      </div>
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

<input type="hidden" class="form-control" id="id" name="id" value="<?php echo @$id;?>">
<div class="form-group row">
    <div class="col-md-offset-1 col-md-5">
        <div class="form-group">
        </div>
        <div class="form-group">
          <label class="col-sm-2 control-label">รหัสร้านค้า : </label>
          <div class="col-sm-10">
              <input type="text" class="form-control" id="shop_id" name="shop_id" value="<?php echo @$shop_id;?>" placeholder="กรุณากรอกรหัสร้านค้า">
          </div>
        </div>
        <div class="form-group">
          <label class="col-sm-2 control-label">ชื่อร้านค้า : </label>
          <div class="col-sm-10">
          <input type="text" class="form-control" id="shop_name" name="shop_name" value="<?php echo @$shop_name;?>" placeholder="กรุณากรอกชื่อร้านค้า">
          </div>
        </div>
        <div class="form-group">
          <label class="col-sm-2 control-label">ผู้ติดต่อ  : </label>
          <div class="col-sm-10">
          <input type="text" class="form-control" id="contact_name" name="contact_name" value="<?php echo @$contact_name;?>" placeholder="กรุณากรอกชื่อผู้ติดต่อ">
          </div>
        </div>

        <div class="form-group">
          <label class="col-sm-2 control-label"><nobr>เบอร์โทรศัพท์ : </label>
          <div class="col-sm-10">
          <input type="text" class="form-control" id="tel" name="tel" value="<?php echo @$tel;?>" placeholder="กรุณากรอกเบอร์โทรศัพท์">
        </div>
        </div>
        <div class="form-group">
          <label class="col-sm-2 control-label">ที่อยู่ : </label>
          <div class="col-sm-10">
          <input type="text" class="form-control" id="address" name="address" value="<?php echo @$address;?>" placeholder="กรุณากรอกที่อยู่"  maxlength="10">
        </div>
        </div>
        <div class="form-group">
          <label class="col-sm-2 control-label">ชั้น : </label>
          <div class="col-sm-10">
          <input type="text" class="form-control" id="level_shop" name="level_shop" value="<?php echo @$level_shop;?>" placeholder="กรุณากรอกชั้น"  maxlength="10">
        </div>
        </div>
        <div class="form-group">
          <label class="col-sm-2 control-label">ต่ำแหน่ง : </label>
          <div class="col-sm-10">
          <input type="text" class="form-control" id="position_shop" name="position_shop" value="<?php echo @$position_shop;?>" placeholder="กรุณากรอกต่ำแหน่ง"  maxlength="10">
        </div>
        </div>
        <div class="form-group">
          <label class="col-sm-2 control-label">พิกัดร้านค้า : </label>
          <div class="col-sm-10">
          <input type="text" class="form-control" id="gps_shop" name="gps_shop" value="<?php echo @$gps_shop;?>" placeholder="กรุณากรอกพิกัดร้านค้า"  maxlength="10">
        </div>
        </div>
        <div class="form-group">
          <label class="col-sm-2 control-label">สถานะการใช้งาน :  </label>
          <div class="col-sm-10">
            <select id="status_shop" name="status_shop" class="form-control">
              <option value="y" <?php if(@$status_shop=="y") echo "selected";?>>ใช้งานปกติ</option>
              <option value="n" <?php if(@$status_shop=="n") echo "selected";?>>ยกเลิกการใช้งาน</option>
            </select>
        </div>
        </div>
    </div>
</div>


</div>
</div>
</form>

</div>

<script type="text/javascript">
$(document).ready(function(){
    $("#Save").click(function(){  
          var id = document.getElementById("id").value;
          var shop_id = document.getElementById("shop_id").value;
         var shop_name = document.getElementById("shop_name").value;
          var contact_name = document.getElementById("contact_name").value;
          var tel = document.getElementById("tel").value;
          var address = document.getElementById("address").value;
          var level_shop = document.getElementById("level_shop").value;
          var position_shop = document.getElementById("position_shop").value;
          var gps_shop = document.getElementById("gps_shop").value;
          var status_shop = document.getElementById("status_shop").value;
             
        $.post('executesql.php',{ mode : "insert.shop" , 
          id : id,
          shop_id : shop_id,
          shop_name : shop_name,
          contact_name : contact_name,
          tel : tel,
          address : address,
          level_shop : level_shop,
          position_shop : position_shop,
          gps_shop : gps_shop,
          status_shop : status_shop  },
        function(data) {
            window.parent.location.href ="shop.index.php?id="+Math.random(100*1000,1000/2);
          });
        return false;
      });
      
});
</script>
