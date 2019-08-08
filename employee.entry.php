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
$id = @$_REQUEST["id"];
//$user_id = base64_decode($id);

if($id!=""){
  $sqlcmd = "select * from tbl_user where id = ".base64_decode($id);
  $db->sql($sqlcmd);
$res = $db->getResult();		
	foreach($res as $data){
		$fname = @$data["fname"];
		$sname = @$data["sname"];
		$username = @$data["username"];
		$password = @$data["password"];
		$tel = @$data["tel"];
    $status_active = @$data["status_user"];
    $email = @$data["email"];
    $address = @$data["address"];
	}	
}
  
  
  
?>



<form id='frm' method='POST' action="" class="form-horizontal">
<!--input type="text" name="id_update" id="id_update" value="<?php// echo $id?>"-->
<div id="page-wrapper">
<div class="container-fluid">
<div class="row" id="main" >
<div class="row">
<div class="col-sm-12" style=""> <h4>ข้อมูลพนักงาน</h4>      </div>
</div>
<div class="row">
<div class="col-sm-6" style="text-align: left; padding-top:30px; padding-bottom:15px;">
  <a href="employee.index.php"><button type="button" class="btn btn-warning btn-sm" title="กลับ"><i class="glyphicon glyphicon-circle-arrow-left"></i> กลับ</button></a>
  </div>
<div class="col-sm-6" style="text-align: right; padding-top:30px; padding-bottom:15px;">
<button type="button" id="Save" class="btn btn-success btn-sm" title="บันทึก"><i class="glyphicon glyphicon-floppy-save"></i> บันทึก</button>
</div>
</div>
<div class="col-sm-12 col-md-12 well" id="content">

<input type="hidden" class="form-control" id="user_id" name="user_id" value="<?php echo @$id;?>">
<div class="form-group row">
    <div class="col-md-offset-1 col-md-7">
        <div class="form-group">
        </div>
        <div class="form-group">
          <label class="col-sm-2 control-label">ชื่อ : </label>
          <div class="col-sm-10">
              <input type="text" class="form-control" id="fname" name="fname" value="<?php echo @$fname;?>" placeholder="กรุณากรอกชื่อ">
          </div>
        </div>
        <div class="form-group">
          <label class="col-sm-2 control-label">นามสกุล : </label>
          <div class="col-sm-10">
          <input type="text" class="form-control" id="sname" name="sname" value="<?php echo @$sname;?>" placeholder="กรุณากรอกสกุล">
          </div>
        </div>
        <div class="form-group">
          <label class="col-sm-2 control-label">Username : </label>
          <div class="col-sm-10">
          <input type="text" class="form-control" id="username" name="username" value="<?php echo @$username;?>" placeholder="กรุณากรอกชื่อผู้ใช้งาน">
          </div>
        </div>

        <div class="form-group">
          <label class="col-sm-2 control-label">Password : </label>
          <div class="col-sm-10">
          <input type="text" class="form-control" id="tpassword" name="tpassword" value="<?php echo @$password;?>" placeholder="กรุณากรอกรหัสผ่าน">
        </div>
        </div>
        <div class="form-group">
          <label class="col-sm-2 control-label">Tel. : </label>
          <div class="col-sm-10">
          <input type="text" class="form-control" id="tel" name="tel" value="<?php echo @$tel;?>" placeholder="กรุณากรอกเบอร์โทรศัพท์"  maxlength="10">
        </div>
        </div>
        <div class="form-group">
          <label class="col-sm-2 control-label">Email. : </label>
          <div class="col-sm-10">
          <input type="text" class="form-control" id="email" name="email" value="<?php echo @$email;?>" placeholder="กรุณากรอก email"  maxlength="100">
        </div>
        </div>
        <div class="form-group">
          <label class="col-sm-2 control-label">Address. : </label>
          <div class="col-sm-10">
          <input type="text" class="form-control" id="address" name="address" value="<?php echo @$address;?>" placeholder="กรุณากรอกที่อยู่"  maxlength="100">
        </div>
        </div>
        <div class="form-group">
          <label class="col-sm-2 control-label">ตำแหน่ง : </label>
          <div class="col-sm-10">
            <select id="status_position" name="status_position" class="form-control">
              <option value="Admin" <?php if(@$status_position=="Admin") echo "selected";?>>ผู้ดูแลระบบ</option>
              <option value="Manager" <?php if(@$status_position=="Manager") echo "selected";?>>ผู้ใช้งาน</option>
              <option value="cashier" <?php if(@$status_position=="cashier") echo "selected";?>>พนักงานเก็บเงิน</option>
            </select>
        </div>
        </div>

        <div class="form-group">
          <label class="col-sm-2 control-label">สถานะ : </label>
          <div class="col-sm-10">
            <select id="status_active" name="status_active" class="form-control">
              <option value="y" <?php if(@$status_active=="y") echo "selected";?>>ใช้งานปกติ</option>
              <option value="n" <?php if(@$status_active=="n") echo "selected";?>>ยกเลิก</option>
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
          var user_id = document.getElementById("user_id").value;
          var fname = document.getElementById("fname").value;
          var sname = document.getElementById("sname").value;
          var username = document.getElementById("username").value;
          var tpassword = document.getElementById("tpassword").value;
          var tel = document.getElementById("tel").value;
          var status_active = document.getElementById("status_active").value;
          var status_position = document.getElementById("status_position").value;
          var email = document.getElementById("email").value;
          var address = document.getElementById("address").value;
          
        $.post('executesql.php',{ mode : "user", 
          user_id : user_id,
          fname : fname,
          sname : sname,
          username : username,
          tpassword : tpassword,
          tel : tel,
          status_active : status_active,
          status_position : status_position,
          email : email,
          address : address},
        function(data) {
         // alert(data);
            window.parent.location.href ="employee.index.php?id="+Math.random(100*1000,1000/2);
          });
        return false;
      });
      
});
</script>
