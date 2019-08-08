<!doctype html>
<html>
<head>
<meta charset="utf-8">
<title></title>
</head>

<body>
<?php
require_once dirname(__FILE__) . "/db/db.php";

move_uploaded_file($_FILES["fileCSV"]["tmp_name"],$_FILES["fileCSV"]["name"]); // Copy/Upload CSV

$objCSV = fopen($_FILES["fileCSV"]["name"], "r");
$noRec=0;
while (($objArr = fgetcsv($objCSV, 9999, ",")) !== FALSE) {
	if($noRec >0){
	$strSQL = "INSERT INTO ADS_TEM_MED_CO ";
	$strSQL .="(M_COMPANY_CODE,M_BRANCH_CODE,M_POSITION_CODE,M_MEDIA_TYPE_CODE,M_MEDIA_BRANCH_FLOOR,M_ZONE_CODE,M_MEDIA_NO) ";
	$strSQL .="VALUES ";
	$strSQL .="('".$objArr[0]."','".$objArr[1]."','".$objArr[2]."' ";
	$strSQL .=",'".$objArr[3]."','".$objArr[4]."','".$objArr[5]."','".$objArr[6]."') ";
	}
    echo $strSQL."<br/>";
	/*
	$objParseinsert = oci_parse($objConnect, $strSQL);
    $objExecute = oci_execute($objParseinsert, OCI_DEFAULT);
    if($objExecute){
        oci_commit($objConnect); 
    }else{
        oci_rollback($objConnect);
    }
   	*/	
}

oci_close($objConnect); 

fclose($objCSV);

?>
</table>
</body>
</html>