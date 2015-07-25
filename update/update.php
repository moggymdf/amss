<?php
if($result_version['system_version']<2.5 ){
	require_once('update/file_update/v_2_5.php');
}
if($result_version['system_version']<2.6 ){
	require_once('update/file_update/v_2_6.php');
}
if($result_version['system_version']<2.9 ){
	require_once('update/file_update/v_2_9.php');
}
if($result_version['system_version']<3.0 ){
	require_once('update/file_update/v_3_0.php');
}
if($result_version['system_version']<3.1 ){
	require_once('update/file_update/v_3_1.php');
}


//ส่วนบันทึกเวอร์ชั่นปัจจุบัน
$sql_update="update system_version set system_version='$code_version'";
$dbquery = mysqli_query($connect,$sql_update);
?>
