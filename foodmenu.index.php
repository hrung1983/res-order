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
<div class="col-sm-6" style=""> <h4>ข้อมูลประเภทอาหาร</h4>      </div>
<div class="col-sm-6" style="text-align: right; padding-top:30px; padding-bottom:15px;">
<a href="foodmenu.entry.php"><button type="button" class="btn btn-success btn-sm" title="Add" ><i class="glyphicon glyphicon-plus" ></i> เพิ่ม</button></a>
</div>

<div class="table_show">

  <table class="table table-striped">
    <tr>
      <th>ลำดับที่</th>
      <th>ประเภทของอาหาร</th>
      <th>เรียงลำดับ</th>
      <th>สถานะ</th>
      <th>&nbsp;</th>
    </tr>
<?php
$sqlcmd = "select * from tbl_category_food where shopid=1 order by category_food";
$db->sql($sqlcmd);
$res = $db->getResult();	
foreach($res as $data){
    @$i++;
?>
  <tr>
    <td><font color="<?php echo $fontcolor;?>"><?php echo @$i;?></font></td>
    <td><font color="<?php echo $fontcolor;?>"><?php echo @$data["category_food"]?></font></td>
    <td><font color="<?php echo $fontcolor;?>"><?php if(@$data["category_status"]=="y") echo "ใช้งานปกติ"; else "ยกเลิก"; ?></font></td>
    <td><font color="<?php echo $fontcolor;?>"><?php echo @$data["category_order_by"]?></font></td>
    <td>
      <a href="foodmenu.entry.php?id=<?php echo base64_encode(@$data["id"])?>"><button type="button" class="btn btn-info btn-xs" title="Edit"><i class="glyphicon glyphicon-pencil"></i></button></a>
      
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
