<?php
include ("../database_connect.php");
if($result_version['system_version']<0.3 ){
	require_once('file_update/v_0_3.php');
}

//ส่วนบันทึกเวอร์ชั่นปัจจุบัน
$sql_update="update system_version set system_version='$code_version'";
$dbquery = mysqli_query($connect,$sql_update);
?>
