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

$shop_id = $_SESSION["UShopid"];  


if($shop_id!=""){
  $sqlcmd = "select * from tbl_cashdrawer where shopid = $shop_id"; 
  $db->sql($sqlcmd);
$res = $db->getResult();	
	foreach($res as $data){
		$cashdrawer = @$data["cashdrawer"];
	}	
}
?>
<form id='frm' method='POST' action="" class="form-horizontal">
<div id="page-wrapper">
<div class="container-fluid">
<div class="row" id="main" >
<div class="row">
<div class="col-sm-12" style=""> <h4>เงินในลิ้นชัก</h4>      </div>
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

<div class="form-group row">
    <div class="col-md-offset-1 col-md-8">
        <div class="form-group">
        </div>
        <div class="form-group">
          <label class="col-sm-2 control-label">จำนวน : </label>
          <div class="col-sm-10">
              <input type="text" class="form-control" id="cashdrawer" name="cashdrawer" value="<?php echo @$cashdrawer;?>" placeholder="กรุณากรอกจำนวนเงินในลิ้นชัก"> 
          </div>
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
          var cashdrawer = document.getElementById("cashdrawer").value;
          
        $.post('executesql.php',{ mode : "cashdrawer" , 
            cashdrawer : cashdrawer },
        function(data) {
            alert(data.replace("1", ""));
            window.parent.location.href ="cashdrawer.php?id="+Math.random(100*1000,1000/2);
          });
        return false;
      });
      
});
</script>
