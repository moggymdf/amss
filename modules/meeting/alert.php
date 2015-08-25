<?php

// ส่วนป้องกันไม่ให้เรียกไฟล์ตรงๆ
defined( '_VALID_' ) or die( 'Direct Access to this location is not allowed.' );

// กรณีเป็นผู้ใช้งานระดับ สพฐ.
if($_SESSION["login_group"]==1){
//หาหน่วยงาน
	$sqldepartment = "select person_main.*,system_department.department_name,system_department.department_precis from person_main left join system_department on(person_main.department = system_department.department) where person_id='".$_SESSION['login_user_id']."'";
	//echo $sqldepartment;
	$resultdepartment = mysqli_query($connect, $sqldepartment);
	$rowdepartment = $resultdepartment->fetch_assoc();
	$user_departmentid = $rowdepartment['department'];
	$user_department_name = $rowdepartment['department_name'];
	$user_department_precisname = $rowdepartment['department_precis'];

	// ส่วนในการตรวจสอบงานค้ง
	$sql_alert = "  SELECT
	            		count(*) as count
	          		from meeting_main left join meeting_room on meeting_main.room = meeting_room.room_code where meeting_room.department=".$user_departmentid." and meeting_main.approve=0
	                    ";
	//echo $sql_alert;
	$result_alert = mysqli_query($connect, $sql_alert);
	$row_alert = $result_alert->fetch_assoc();

	// ข้อความที่ต้องการแจ้งเตือน
	$message = "";
	$count = "";
	$alertmessage = "";
	if($row_alert["count"]>0){
		$message = "รายการจองห้องประชุม ";
		$count = $row_alert["count"];
		$alertmessage = "<li><a href='?option=meeting&task=main/officer'>".$message." <span class='badge progress-bar-danger'>".$count."</span></a></li>";
	}

}
?>
