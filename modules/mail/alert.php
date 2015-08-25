<?php

// ส่วนป้องกันไม่ให้เรียกไฟล์ตรงๆ
defined( '_VALID_' ) or die( 'Direct Access to this location is not allowed.' );

$alertmessage = "";
$count = "";
$message = "";

// ส่วนในการตรวจสอบงานค้าง 1
$sql_alert = "  select count(*) as count from mail_main left join mail_sendto_answer on mail_main.ref_id=mail_sendto_answer.ref_id where mail_sendto_answer.send_to='$_SESSION[login_user_id]' and mail_sendto_answer.answer<'1' ";
//echo $sql_alert;
$result_alert = mysqli_query($connect, $sql_alert);
$row_alert = $result_alert->fetch_assoc();
// ข้อความที่ต้องการแจ้งเตือน 1
if($row_alert["count"]>0){
	$message = "มีจดหมายที่ยังไม่ได้อ่าน";
	$link = "option=mail&task=main/receive";
	$count = $row_alert["count"];
	$alertmessage = "<li><a href='?".$link."'>".$message." <span class='badge progress-bar-danger'>".$row_alert["count"]."</span></a></li>";
}

// ส่วนในการตรวจสอบงานค้าง 2
/*
$sql_alert = "  SELECT
                count(*) as count
              FROM
                ioffice_book
              WHERE
                ioffice_book.bookstatus=2";
//echo $sql_alert;
$result_alert = mysqli_query($connect, $sql_alert);
$row_alert = $result_alert->fetch_assoc();
// ข้อความที่ต้องการแจ้งเตือน 2
if($row_alert["count"]>0){
  $message = "บันทึกเสนอรอลงความเห็น/สั่งการ ";
  $link = "option=ioffice&task=book_pass";
  $count .= $row_alert["count"];
  $alertmessage .= "<li><a href='?".$link."'>".$message." <span class='badge progress-bar-danger'>".$row_alert["count"]."</span></a></li>";
}
*/

?>
