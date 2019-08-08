<?php
header("Content-Type: text/html; charset=utf-8");
require_once("function.php");  
include "header.php";
@session_start();
if(!checkUser()){    echo Message(35,"red",$titel1,$msg1,"<a href='login.php?link=employee.index'> $login </a>");
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
<div class="col-sm-6" style=""> <h4>ข้อมูลพนักงาน</h4>      </div>
<div class="col-sm-6" style="text-align: right; padding-top:30px; padding-bottom:15px;">
<a href="employee.entry.php"><button type="button" class="btn btn-success btn-sm" title="Add" ><i class="glyphicon glyphicon-plus" ></i> เพิ่ม</button></a>
</div>

<div class="table_show">

  <table class="table table-striped">
    <tr>
      <th>ลำดับที่</th>
      <th>ชื่อ</th>
      <th>นามสกุล</th>
      <th>Username</th>
      <th>เบอร์โทรศํพท์</th>
      <th>ตำแหน่ง</th>
      <th>สถานะ</th>
      <th>&nbsp;</th>
    </tr>
<?php
$sqlcmd = "select * from tbl_user order by fname";
$db->sql($sqlcmd);
$res = $db->getResult();	
foreach($res as $data){
    @$i++;
    @$fontcolor = "black";
    if(@$data["permission_user"]=="Admin"){
      @$fontcolor = "blue";
    }
?>
  <tr>
    <td><font color="<?php echo $fontcolor;?>"><?php echo @$i;?></font></td>
    <td><font color="<?php echo $fontcolor;?>"><?php echo @$data["fname"]?></font></td>
    <td><font color="<?php echo $fontcolor;?>"><?php echo @$data["sname"]?></font></td>
    <td><font color="<?php echo $fontcolor;?>"><?php echo @$data["username"]?></font></td>
    <td><font color="<?php echo $fontcolor;?>"><?php echo @@$data["tel"]?></font></td>
    <td><font color="<?php echo $fontcolor;?>"><?php echo $data["permission_user"]?></font></td>
    <td><font color="<?php echo $fontcolor;?>"><?php if(@$data["status_user"]=="y") echo "ใช้งานปกติ"; else "ยกเลิก"; ?></font></td>
    <td>
      <a href="employee.entry.php?id=<?php echo base64_encode(@$data["id"])?>"><button type="button" class="btn btn-info btn-xs" title="Edit"><i class="glyphicon glyphicon-pencil"></i></button></a>
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
