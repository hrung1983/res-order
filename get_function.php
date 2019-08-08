<?php
header("Content-Type: text/html; charset=utf-8"); 
session_start();
require_once dirname(__FILE__) . "/db/db.php";

require_once("dbcontroller.php");
$db_handle = new DBController();

//--รหัสบริษัทเลือกสาขา
if(!empty(@$_REQUEST["Branch_sch"])) {
	$query ="SELECT * FROM ADS_BRANCH WHERE COMPANY_CODE ='".@$_REQUEST["Branch_sch"]."'";
	$results = $db_handle->runQuery($query);
?>
	<option value="">เลือก</option>
<?php
	foreach($results as $state) {
?>
	<option value="<?php echo $state["BRANCH_CODE"]; ?>"><?php echo $state["BRANCH_NAME"]; ?></option>
<?php
	}
}

//--รหัสสาขาเลือกชั้น FL
if(!empty(@$_REQUEST["Floor_sch"])) {
	$query ="SELECT * FROM ADS_BRANCH WHERE BRANCH_CODE = '".@$_REQUEST["Floor_sch"]."'";
	$results = $db_handle->runQuery($query);
	?>
	<option value="">เลือก</option>
	<?php
	$FL_BRANCH_CODE=@$_REQUEST["Floor_sch"];
	$FL_BRANCH_FLOOR=0;
	foreach($results as $state) {
		$FL_BRANCH_FLOOR=$state["BRANCH_FLOOR"];
	}

	for($i=1;$i<=$FL_BRANCH_FLOOR;$i++){
	?>
	<option value="<?php echo $FL_BRANCH_CODE."/"."FL".$i; ?>"><?php echo "FL".$i; ?></option>
	<?php
	}	
}


//--รหัสสาขาเลือกตำแหน่ง
if(!empty(@$_REQUEST["Position_sch"])) {
	//แยกคำ
	$pie = explode("/", @$_REQUEST["Position_sch"]);
	 //$pie[0]; 
	 //$pie[1];

	$query ="SELECT * FROM ADS_POSITION WHERE BRANCH_CODE = '".$pie[0]."'";
	$results = $db_handle->runQuery($query);
	?>
	<option value="">เลือก</option>
	<?php
	foreach($results as $state) {
	?>
	<option value="<?php echo $state["POSITION_CODE"]; ?>"><?php echo $state["POSITION_CODE"]; ?></option>
	<?php
	}	
}

//--รหัสตำแหน่งเลือกประเภทสื่อ
if(!empty(@$_REQUEST["Mediatype_sch"])) {
	$query ="SELECT * FROM ADS_MEDIA_TYPE WHERE POSITION_CODE = '".@$_REQUEST["Mediatype_sch"]."'";
	$results = $db_handle->runQuery($query);
	?>
	<option value="">เลือก</option>
	<?php
	foreach($results as $state) {
	?>
	<option value="<?php echo $state["MEDIA_TYPE_CODE"]; ?>"><?php echo $state["MEDIA_TYPE_CODE"]; ?></option>
	<?php
	}	
}

//--รหัสสาขา-ชั้นเลือกโซน
if(!empty(@$_REQUEST["Zone_sch"])) {
	//แยกคำ
	$pie = explode("/", @$_REQUEST["Zone_sch"]);
	//$pie[0]; 
	//$pie[1];
	$query ="SELECT * FROM ADS_ZONE WHERE BRANCH_CODE = '".$pie[0]."' AND ZONE_BRANCH_FLOOR='".$pie[1]."'";
	$results = $db_handle->runQuery($query);
	?>
	<option value="">เลือก</option>
	<?php
	foreach($results as $state) {
	?>
	<option value="<?php echo $state["ZONE_CODE"]; ?>"><?php echo $state["ZONE_CODE"]; ?></option>
	<?php
	}	
}

//--รหัสส่งค่าจาก transactionpoint.add.php ค้นหา transactionpoint.search.php
if(!empty(@$_REQUEST["Table_sch"])) {
	$pamSearch = @$_REQUEST["Table_sch"];

	$sqlSearch="SELECT 
				ADS_COMPANY.COMPANY_NAME,
				ADS_MEDIA.COMPANY_CODE,
				ADS_MEDIA.BRANCH_CODE,
				ADS_BRANCH.BRANCH_NAME,
				ADS_MEDIA.MEDIA_CODE,
				ADS_MEDIA.MEDIA_DESCRIPTION,
				ADS_MEDIA.MEDIA_WIDTH,
				ADS_MEDIA.MEDIA_LONG,
				ADS_MEDIA.UNIT_CODE,
				ADS_UNIT.UNIT_NAME
				FROM ADS_MEDIA
				INNER JOIN ADS_BRANCH
				ON ADS_MEDIA.BRANCH_CODE   = ADS_BRANCH.BRANCH_CODE
				AND ADS_MEDIA.COMPANY_CODE = ADS_BRANCH.COMPANY_CODE
				INNER JOIN ADS_UNIT
				ON ADS_MEDIA.UNIT_CODE = ADS_UNIT.UNIT_CODE
				INNER JOIN ADS_MEDIA_TYPE
				ON ADS_MEDIA.MEDIA_TYPE_CODE = ADS_MEDIA_TYPE.MEDIA_TYPE_CODE
				INNER JOIN ADS_POSITION
				ON ADS_MEDIA.POSITION_CODE    = ADS_POSITION.POSITION_CODE
				AND ADS_POSITION.COMPANY_CODE = ADS_BRANCH.COMPANY_CODE
				AND ADS_POSITION.BRANCH_CODE  = ADS_BRANCH.BRANCH_CODE
				INNER JOIN ADS_COMPANY
				ON ADS_BRANCH.COMPANY_CODE = ADS_COMPANY.COMPANY_CODE
				INNER JOIN ADS_ZONE
				ON ADS_MEDIA.BRANCH_FLOOR = ADS_ZONE.ZONE_BRANCH_FLOOR
				AND ADS_MEDIA.ZONE_CODE   = ADS_ZONE.ZONE_CODE
				AND ADS_ZONE.COMPANY_CODE = ADS_BRANCH.COMPANY_CODE
				AND ADS_ZONE.BRANCH_CODE  = ADS_BRANCH.BRANCH_CODE
				INNER JOIN ADS_MEDIA_PRICE
				ON ADS_MEDIA.MEDIA_CODE = ADS_MEDIA_PRICE.MEDIA_CODE
				LEFT JOIN ADS_TIME_PERIOD
				ON ADS_MEDIA_PRICE.TIME_PERIOD_CODE = ADS_TIME_PERIOD.TIME_PERIOD_CODE
				WHERE ADS_MEDIA.MEDIA_CODE like '%$pamSearch%'
				GROUP BY
				ADS_COMPANY.COMPANY_NAME,
				ADS_MEDIA.COMPANY_CODE,
				ADS_MEDIA.BRANCH_CODE,
				ADS_BRANCH.BRANCH_NAME,
				ADS_MEDIA.MEDIA_CODE,
				ADS_MEDIA.MEDIA_DESCRIPTION,
				ADS_MEDIA.MEDIA_WIDTH,
				ADS_MEDIA.MEDIA_LONG,
				ADS_MEDIA.UNIT_CODE,
				ADS_UNIT.UNIT_NAME
";


?>
<thead>
 <tr>
       <th>Select</th>
       <th>No.</th>
       <th>บริษัท</th>
       <th>สาขา</th>
       <th>รหัส</th>
       <th>รายละเอียด</th>
     </tr>
</thead>
<tbody>
<?php
 	$rows = 1;
	$objSearch = @oci_parse($objConnect, $sqlSearch);
 	@oci_execute($objSearch);
    while($objResultSearch = @oci_fetch_array($objSearch,OCI_BOTH)){
		
?>
    <tr>
    <td>
	<a href="transactionpoint.add.php?txtSearch=<?php echo @$objResultSearch["MEDIA_CODE"]; ?>" class="btn btn-primary btn-xs">เลือก</a>
    </td>
    <td><?php echo $rows;?></td>
    <td><?php echo @$objResultSearch["COMPANY_NAME"]; ?></td>
    <td><?php echo @$objResultSearch["BRANCH_NAME"]; ?></td>
    <td><?php echo @$objResultSearch["MEDIA_CODE"]; ?></td>
    <td><?php echo @$objResultSearch["MEDIA_DESCRIPTION"]; ?></td>
    </tr>
<?php } ?>
</tbody>
<?php
}

//--รหัสส่งค่าจาก ค้นหา transactionpoint.search.php
if(!empty(@$_REQUEST["tranpoint_sch"])) {
	
	$comSearch = @$_REQUEST["com_sch"];
	$brnSearch = @$_REQUEST["brn_sch"];
	//$floSearch = @$_REQUEST["flo_sch"];
	if(!empty(@$_REQUEST["flo_sch"])) {
		$floSearch = explode("/", @$_REQUEST["flo_sch"]);
		$floSearch[1];
	}	
	$posSearch = @$_REQUEST["pos_sch"];
	$medSearch = @$_REQUEST["med_sch"];
	$zonSearch = @$_REQUEST["zon_sch"];
	//$pamSearch = @$_REQUEST["com_sch"];

$sqlWhere=" WHERE ";
$sqlWhere = $sqlWhere." ADS_COMPANY.COMPANY_CODE='$comSearch' ";

if(!empty($brnSearch)){
	$sqlWhere = $sqlWhere." AND ADS_MEDIA.BRANCH_CODE='$brnSearch' ";
}

if(!empty(@$_REQUEST["flo_sch"])){
	$sqlWhere = $sqlWhere." AND ADS_MEDIA.BRANCH_FLOOR='$floSearch[1]' ";
}

if(!empty($posSearch)){
	$sqlWhere = $sqlWhere." AND ADS_MEDIA.POSITION_CODE='$posSearch' ";
}

if(!empty($medSearch)){
	$sqlWhere = $sqlWhere." AND ADS_MEDIA.MEDIA_TYPE_CODE='$medSearch' ";
}

if(!empty($zonSearch)){
	$sqlWhere = $sqlWhere." AND ADS_MEDIA.BRANCH_CODE='$ZONE_CODE' ";
}
	
	
	$sqlSearch="SELECT 
				ADS_COMPANY.COMPANY_NAME,
				ADS_MEDIA.COMPANY_CODE,
				ADS_MEDIA.BRANCH_CODE,
				ADS_BRANCH.BRANCH_NAME,
				ADS_MEDIA.MEDIA_CODE,
				ADS_MEDIA.MEDIA_DESCRIPTION,
				ADS_MEDIA.MEDIA_WIDTH,
				ADS_MEDIA.MEDIA_LONG,
				ADS_MEDIA.UNIT_CODE,
				ADS_UNIT.UNIT_NAME
				FROM ADS_MEDIA
				INNER JOIN ADS_BRANCH
				ON ADS_MEDIA.BRANCH_CODE   = ADS_BRANCH.BRANCH_CODE
				AND ADS_MEDIA.COMPANY_CODE = ADS_BRANCH.COMPANY_CODE
				INNER JOIN ADS_UNIT
				ON ADS_MEDIA.UNIT_CODE = ADS_UNIT.UNIT_CODE
				INNER JOIN ADS_MEDIA_TYPE
				ON ADS_MEDIA.MEDIA_TYPE_CODE = ADS_MEDIA_TYPE.MEDIA_TYPE_CODE
				INNER JOIN ADS_POSITION
				ON ADS_MEDIA.POSITION_CODE    = ADS_POSITION.POSITION_CODE
				AND ADS_POSITION.COMPANY_CODE = ADS_BRANCH.COMPANY_CODE
				AND ADS_POSITION.BRANCH_CODE  = ADS_BRANCH.BRANCH_CODE
				INNER JOIN ADS_COMPANY
				ON ADS_BRANCH.COMPANY_CODE = ADS_COMPANY.COMPANY_CODE
				INNER JOIN ADS_ZONE
				ON ADS_MEDIA.BRANCH_FLOOR = ADS_ZONE.ZONE_BRANCH_FLOOR
				AND ADS_MEDIA.ZONE_CODE   = ADS_ZONE.ZONE_CODE
				AND ADS_ZONE.COMPANY_CODE = ADS_BRANCH.COMPANY_CODE
				AND ADS_ZONE.BRANCH_CODE  = ADS_BRANCH.BRANCH_CODE
				INNER JOIN ADS_MEDIA_PRICE
				ON ADS_MEDIA.MEDIA_CODE = ADS_MEDIA_PRICE.MEDIA_CODE
				LEFT JOIN ADS_TIME_PERIOD
				ON ADS_MEDIA_PRICE.TIME_PERIOD_CODE = ADS_TIME_PERIOD.TIME_PERIOD_CODE
				
				$sqlWhere
				
				GROUP BY
				ADS_COMPANY.COMPANY_NAME,
				ADS_MEDIA.COMPANY_CODE,
				ADS_MEDIA.BRANCH_CODE,
				ADS_BRANCH.BRANCH_NAME,
				ADS_MEDIA.MEDIA_CODE,
				ADS_MEDIA.MEDIA_DESCRIPTION,
				ADS_MEDIA.MEDIA_WIDTH,
				ADS_MEDIA.MEDIA_LONG,
				ADS_MEDIA.UNIT_CODE,
				ADS_UNIT.UNIT_NAME
";


?>
<thead>
 <tr>
       <th>Select <?php //echo $sqlSearch;?></th>
       <th>No.</th>
       <th>บริษัท</th>
       <th>สาขา</th>
       <th>รหัส</th>
       <th>รายละเอียด</th>
     </tr>
</thead>
<tbody>
<?php
 	$rows = 1;
	$objSearch = @oci_parse($objConnect, $sqlSearch);
 	@oci_execute($objSearch);
    while($objResultSearch = @oci_fetch_array($objSearch,OCI_BOTH)){
		
?>
    <tr>
    <td>
	<a href="transactionpoint.add.php?txtSearch=<?php echo @$objResultSearch["MEDIA_CODE"]; ?>" class="btn btn-primary btn-xs">เลือก</a>
    </td>
    <td><?php echo $rows;?></td>
    <td><?php echo @$objResultSearch["COMPANY_NAME"]; ?></td>
    <td><?php echo @$objResultSearch["BRANCH_NAME"]; ?></td>
    <td><?php echo @$objResultSearch["MEDIA_CODE"]; ?></td>
    <td><?php echo @$objResultSearch["MEDIA_DESCRIPTION"]; ?></td>
    </tr>
<?php } ?>
</tbody>
<?php
}
?>