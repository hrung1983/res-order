<?php
include "header.php";
?>
<form id='frm' method='POST' action="checklogin.php" class="form-horizontal">
<input type="hidden" name="id_update" id="id_update" value="<?php echo $id?>">
<div id="page-wrapper">
<div class="container-fluid">
<div class="row" id="main" >
<div class="row">
<div class="col-sm-12" style=""> <h4>เข้าระบบ</h4>      </div>
</div>
<div class="row">
<div class="col-sm-6" style="text-align: left; padding-top:30px; padding-bottom:15px;">
  <a href="question.index.php"><button type="button" class="btn btn-warning btn-sm" title="กลับ"><i class="glyphicon glyphicon-circle-arrow-left"></i> กลับ</button></a>
  </div>
<div class="col-sm-6" style="text-align: right; padding-top:30px; padding-bottom:15px;">
<button type="submit" id="Save" class="btn btn-success btn-sm" title="บันทึก"><i class="glyphicon glyphicon-floppy-save"></i> เข้าระบบ</button>
<input type="hidden" value="<?php echo @$_REQUEST["link"]?>" id="link" name="link">
</div>
</div>
<div class="col-sm-14 col-md-14 well" id="content">
    <div class="form-group">
      <label class="col-sm-2 control-label">ชื่อผู้ใช้งาน : </label>
        <div class="col-sm-6">
        <input type="text" class="form-control" placeholder="Username" id="txtusername" name="txtusername" value="" >
      </div>
    </div>


    <div class="form-group">
        <label class="col-sm-2 control-label">รหัสผ่าน : </label>
      <div class="col-sm-6">
        <input type="password" class="form-control" placeholder="Password" id="txtpassword" name="txtpassword" value="">
      </div>
    </div>




</form>

</div>