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



$sqlcmd = "select table_mnt,que_mnt,bar_mnt from tbl_table_que where shopid = $shop_id ";// echo $sqlcmd;
$db->sql($sqlcmd);
$res = $db->getResult();	
	foreach($res as $data){
		$table_mnt = @$data["table_mnt"];
		$que_mnt = @$data["que_mnt"];
		$bar_mnt = @$data["bar_mnt"];
	}	

?>
<form id='frm' method='POST' action="" class="form-horizontal">
<div id="page-wrapper">
<div class="container-fluid">
<div class="row" id="main" >
<div class="row">
<div class="col-sm-12" style=""> <h4>โต๊ะ-คิว-บาร์</h4>      </div>
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

<input type="hidden" class="form-control" id="shopid" name="shopid" value="<?php echo @$shop_id?>">
<div class="form-group row">
    <div class="col-md-offset-1 col-md-8">
        <div class="form-group">
        </div>
        <div class="form-group">
        <label class="col-sm-2 control-label">จำนวนบาร์  : </label>
          <div class="col-sm-10">
          <input type="text" class="form-control" id="bar_mnt" name="bar_mnt" value="<?php echo @$bar_mnt;?>" placeholder="กรุณากรอกจำนวนบาร์">
          </div>
        </div>
        <div class="form-group">
          <label class="col-sm-2 control-label">จำนวนคิว :  </label>
          <div class="col-sm-10">
              <input type="text" class="form-control" id="que_mnt" name="que_mnt" value="<?php echo @$que_mnt;?>" placeholder="กรุณากรอกจำนวนคิว (กลับบ้าน)">
            </div>
        </div>
        <div class="form-group">
        <label class="col-sm-2 control-label">จำนวนโต๊ะ : </label>
          <div class="col-sm-10">
              <input type="text" class="form-control" id="table_mnt" name="table_mnt" value="<?php echo @$table_mnt;?>" placeholder="กรุณากรอกจำนวนโต๊ะ">
          </div>
        </div>

        <div class="table_show">
<?php // if(@$id!=""){?>
  <table class="table table-striped">
    <tr>
      <th>ลำดับที่</th>
      <th>โต๊ะ</th>
      <th>สถานะ</th>
    </tr>
    
<?php
$sqlcmddt = "select id,mnt,status_active from tbl_table_que_detail where shopid=$shop_id order by id";
$db->sql(@$sqlcmddt);
$resdt =@ $db->getResult();	
foreach($resdt as $datadt){
    @$i++;
?>
  <tr>
    <td><font color="<?php echo "black";?>"><?php echo @$i;?></font></td>
    <td><font color="<?php echo "black";?>"><?php echo @$datadt["mnt"]?></font></td>
    <td>
       <select id="status_active" name="status_active" onchange="changevalue('<?php echo base64_encode(@$datadt['id'])?>',this.value);" class="form-control">
            <option value='y' <?php if(@$datadt["status_active"]=="y") echo "selected";?>>ใช้งานปกติ</option>
            <option value='n' <?php if(@$datadt["status_active"]=="n") echo "selected";?>>ปิดปรับปรุง</option>
       </select>
    </td>
  </tr>
<?php } ?>
</table>
<?php // }?>
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
          var table_mnt = document.getElementById("table_mnt").value;
          var que_mnt = document.getElementById("que_mnt").value;
          var bar_mnt = document.getElementById("bar_mnt").value; 
        $.post('executesql.php',{ mode : "table_que" , 
            table_mnt : table_mnt,
            que_mnt : que_mnt,
            bar_mnt : bar_mnt},
        function(data) {
          //  alert(data);
            window.parent.location.href ="table.php?id="+Math.random(100*1000,1000/2);
          });
        return false;
      });
    
});

  
function changevalue(id,val){
        $.post('executesql.php',{ mode : "change_value_table_que" , 
            id : id,
            val : val},
        function(data) {
            //alert(data);
            window.parent.location.href ="table.php?id="+Math.random(100*1000,1000/2);
          });
      }
</script>
