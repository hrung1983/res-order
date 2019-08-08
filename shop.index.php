<?php
header("Content-Type: text/html; charset=utf-8");
require_once("function.php");  
include "header.php";
@session_start();
if(!checkUser()){    echo Message(35,"red",$titel1,$msg1,"<a href='login.php?link=shop.index'> $login </a>");
  exit;
  }
include('class/mysqli_oop.php');
$db = new Database();
$db->connect();

?>


<form id='frm' method='POST' action=''>
<div id="page-wrapper">
<div class="container-fluid">
<div class="row" id="main" >
<div class="col-sm-6" style=""> <h4>ข้อมูลร้านค้า</h4>      </div>
<div class="col-sm-6" style="text-align: right; padding-top:30px; padding-bottom:15px;">
<a href="shop.entry.php"><button type="button" class="btn btn-success btn-sm" title="Add" ><i class="glyphicon glyphicon-plus" ></i> เพิ่ม</button></a>
</div>

<div class="table_show">

  <table class="table table-striped">
    <tr>
      <th>ลำดับที่</th>
      <th>รหัสร้านค้า</th>
      <th>ชื่อร้านค้า</th>
      <th>ชื่อเจ้าของร้าน</th>
      <th>ที่อยู่ร้าน</th>
      <th>ชั้น</th>
      <th>ตำแหน่ง</th>
      <th>GPS</th>
      <th>สถานะ</th>
      <th>&nbsp;</th>
    </tr>
<?php
$sqlcmd = "select * from tbl_shop order by shop_name";
$db->sql($sqlcmd);
$res = $db->getResult();	
foreach($res as $data){
    @$i++;
    @$fontcolor = "black";
    if(@$data["status_position"]=="Admin"){
      @$fontcolor = "blue";
    }
?>
  <tr>
    <td><font color="<?php echo $fontcolor;?>"><?php echo @$i;?></font></td>
    <td><font color="<?php echo $fontcolor;?>"><?php echo @$data["shop_id"]?></font></td>
    <td><font color="<?php echo $fontcolor;?>"><?php echo @$data["shop_name"]?></font></td>
    <td><font color="<?php echo $fontcolor;?>"><?php echo @$data["contact_name"]?></font></td>
    <td><font color="<?php echo $fontcolor;?>"><?php echo @$data["address"]?></font></td>
    <td><font color="<?php echo $fontcolor;?>"><?php echo @@$data["level_shop"]?></font></td>
    <td><font color="<?php echo $fontcolor;?>"><?php echo $data["position_shop"]?></font></td>
    <td><font color="<?php echo $fontcolor;?>"><?php echo $data["gps_shop"]?></font></td>
    <td><font color="<?php echo $fontcolor;?>"><?php if(@$data["status_shop"]=="y") echo "ใช้งานปกติ"; else "ยกเลิก"; ?></font></td>
    <td>
      <a href="shop.entry.php?id=<?php echo base64_encode(@$data["id"])?>"><button type="button" class="btn btn-info btn-xs" title="Edit"><i class="glyphicon glyphicon-pencil"></i></button></a>
    </td>
  </tr>
<?php } ?>
</table>
</div>
</div>
</div>
</div>
</form>

</div>
