<?php
header("Content-Type: text/html; charset=utf-8"); 
session_start();
require_once dirname(__FILE__) . "/db/db.php";

require_once("dbcontroller.php");
$db_handle = new DBController();

?>
<html>
<head>
<title></title>
<head>
<style>
body{width:610px;font-family:calibri;}
.frmDronpDown {border: 1px solid #7ddaff;background-color:#C8EEFD;margin: 2px 0px;padding:40px;border-radius:4px;}
.demoInputBox {padding: 10px;border: #bdbdbd 1px solid;border-radius: 4px;background-color: #FFF;width: 50%;}
.row{padding-bottom:15px;}
</style>
<script src="js/jquery-3.3.1.min.js"></script>
<script src="js/bootstrap.min.js"></script>

<script>
	function getBranch(val) {
		$.ajax({
		type: "POST",
		url: "get_function.php",
		data:'Branch_sch='+val,
		success: function(data){
			if(data == ''){
				$("#ddlBranch").html("<option value=''>Select Branch</option>");
			}else{
				$("#ddlBranch").html(data);
			}	
		}
		});
	}

	function getFloor(val) {
		$.ajax({
		type: "POST",
		url: "get_function.php",
		data:'Floor_sch='+val,
		success: function(data){
			if(data == ''){
				$("#ddlFloor").html("<option value=''>Select Floor</option>");
			}else{
				$("#ddlFloor").html(data);
			}	
		}
		});	
	}

	function getPosition(val) {
		$.ajax({
		type: "POST",
		url: "get_function.php",
		data:'Position_sch='+val,
		success: function(data){
			if(data == ''){
				$("#ddlPosition").html("<option value=''>Select Position</option>");
			}else{
				$("#ddlPosition").html(data);
			}	
		}
		});
	}

	function getMediatype(val) {
		$.ajax({
		type: "POST",
		url: "get_function.php",
		data:'Mediatype_sch='+val,
		success: function(data){
			if(data == ''){
				$("#ddlMediatype").html("<option value=''>Select Mediatype</option>");
			}else{
				$("#ddlMediatype").html(data);
			}		
		}
		});
	}

	function getZone(val) {
		//alert(val);	
		$.ajax({
		type: "POST",
		url: "get_function.php",
		data:'Zone_sch='+val,
		success: function(data){
			if(data == ''){
				$("#ddlZone").html("<option value=''>Select Zone</option>");
			}else{
				$("#ddlZone").html(data);
			}	
		}
		});
	}
</script>

</head>

<body>
<div class="frmDronpDown">

<div class="row">
<?php

	$query ="SELECT * FROM ADS_COMPANY";
	$results =$db_handle->runQuery($query);
?>
<label>COMPANY:</label><br/>
<select name="country" id="country-list" class="demoInputBox" onChange="getBranch(this.value);">
<option value="-1">Select Company</option>
<?php
foreach($results as $result) {
?>
	<option value="<?php echo $result["COMPANY_CODE"]; ?>"><?php echo $result["COMPANY_NAME"]; ?></option>
<?php
}
?>
</select>
</div>

<div class="row">
<label>BRANCH:</label><br/>
<select name="ddlBranch" id="ddlBranch" class="demoInputBox" onChange="getFloor(this.value);">
<option value="-1">Select Branch</option>
</select>
</div>

<div class="row">
<label>FLOOR:</label><br/>
<select name="ddlFloor" id="ddlFloor" class="demoInputBox" onChange="getPosition(this.value);">
<option value="-1">Select Floor</option>
</select>
</div>

<div class="row">
<label>ตำแหน่ง:</label><br/>
<select name="ddlPosition" id="ddlPosition" class="demoInputBox" onChange="getMediatype(this.value);">
<option value="-1">Select Position</option>
</select>
</div>

<div class="row">
<label>ประเภทสื่อ:</label><br/>
<select name="ddlMediatype" id="ddlMediatype" class="demoInputBox" onChange="getZone(ddlFloor.value);">
<option value="-1">Select MediaType</option>
</select>
</div>

<div class="row">
<label>โซน:</label><br/>
<select name="ddlZone" id="ddlZone" class="demoInputBox">
<option value="-1">Select Zone</option>
</select>
</div>

</div>
</body>
</html>