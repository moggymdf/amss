<?php

// ส่วนป้องกันไม่ให้เรียกไฟล์ตรงๆ
defined( '_VALID_' ) or die( 'Direct Access to this location is not allowed.' );

//หาหน่วยงาน
    $login_user_id=mysqli_real_escape_string($connect,$_SESSION['login_user_id']);
    $sql_user_depart="select * from person_main where person_id=? ";
    $query_user_depart = $connect->prepare($sql_user_depart);
    $query_user_depart->bind_param("i", $login_user_id);
    $query_user_depart->execute();
    $result_quser_depart=$query_user_depart->get_result();
While ($result_user_depart = mysqli_fetch_array($result_quser_depart))
   {
    $user_departid=$result_user_depart['department'];
    }
//หาชื่อหน่วยงาน
    $sql_depart_name="select * from system_department where department=? ";
    $query_depart_name = $connect->prepare($sql_depart_name);
    $query_depart_name->bind_param("i", $user_departid);
    $query_depart_name->execute();
    $result_qdepart_name=$query_depart_name->get_result();
While ($result_depart_name = mysqli_fetch_array($result_qdepart_name))
   {
    $user_department_name=$result_depart_name['department_name'];
    $user_department_precisname=$result_depart_name['department_precis'];
	}

// ส่วนในการตรวจสอบงานค้ง
$sql_alert = "  SELECT
            		count(*) as count
          		from meeting_main left join meeting_room on meeting_main.room = meeting_room.room_code where meeting_room.department=$user_departid and meeting_main.approve=0
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

?>
