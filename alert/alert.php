<?php
/** ensure this file is being included by a parent file */
defined( '_VALID_' ) or die( 'Direct Access to this location is not allowed.' );
$alert=0;
$alert_content="";

//เตือนขออนุญาตไปราชการรอความเห็นชอบ
$sql_permission_alert = "select permission_main.id from permission_main left join permission_person_set on  permission_main.person_id=permission_person_set.person_id where (permission_person_set.comment_person ='$_SESSION[login_user_id]') and (permission_main.grant_x is null) and (permission_main.comment_person is null)";
$dbquery_permission_alert = mysqli_query($connect,$sql_permission_alert);
if($dbquery_permission_alert){
		$permission_alert_num=mysqli_num_rows($dbquery_permission_alert);
		if($permission_alert_num>=1){
		$alert=1;
		$alert_content=$alert_content."มีผู้ขออนุญาตไปราชการรอความเห็นชอบ  ";
		}
}

//เตือนอนุญาตไปราชการรออนุมัติ(สำหรับผู้ถูกเลือกให้อนุมัติ)
$now=time();
$time_onedayago=$now-86400;
$onedayago=date("Y-m-d H:i:s",$time_onedayago); // ใช้กับalert ขออนุญาตไปราชการและการลา

$sql_permission_alert2 = "select permission_main.id from permission_main left join permission_person_set on  permission_main.person_id=permission_person_set.person_id where (permission_main.grant_person_selected ='$_SESSION[login_user_id]') and (permission_main.rec_date<'$onedayago' or permission_person_set.comment_person is null or permission_person_set.comment_person='' or permission_main.no_comment='1' or permission_main.comment_person is not null) and (permission_main.grant_person is null)";
$dbquery_permission_alert2 = mysqli_query($connect,$sql_permission_alert2);
if($dbquery_permission_alert2){
		$permission_alert2_num=mysqli_num_rows($dbquery_permission_alert2);
		if($permission_alert2_num>=1){
		$alert=1;
		$alert_content=$alert_content."มีผู้ขออนุญาตไปราชการรอการอนุมัติ ";
		}
}
if($permission_alert2_num<1){
		//เตือนอนุญาตไปราชการรออนุมัติ(กรณีทั่วไป)
		$sql_permission_alert2 = "select permission_main.id from permission_main left join permission_person_set on  permission_main.person_id=permission_person_set.person_id where  (permission_person_set.grant_person ='$_SESSION[login_user_id]') and (permission_main.grant_person_selected is null or permission_main.grant_person_selected='') and (permission_main.rec_date<'$onedayago' or permission_person_set.comment_person is null or permission_person_set.comment_person='' or permission_main.no_comment='1' or permission_main.comment_person is not null) and (permission_main.grant_person is null)";
		$dbquery_permission_alert2 = mysqli_query($connect,$sql_permission_alert2);
		if($dbquery_permission_alert2){
				$permission_alert2_num=mysqli_num_rows($dbquery_permission_alert2);
				if($permission_alert2_num>=1){
				$alert=1;
				$alert_content=$alert_content."มีผู้ขออนุญาตไปราชการรอการอนุมัติ ";
				}
		}
}

////////////////////////////////////////////////////////////
//เตือนลาของผู้เห็นชอบ
$sql_la_alert = "select la_main.id from la_main left join la_person_set on  la_main.person_id=la_person_set.person_id where (la_person_set.comment_person ='$_SESSION[login_user_id]') and (la_main.group_sign is null) and (la_main.commander_sign is null)";

$dbquery_la_alert = mysqli_query($connect,$sql_la_alert );
if($dbquery_la_alert){
		$la_alert_num=mysqli_num_rows($dbquery_la_alert);
		if($la_alert_num>=1){
		$alert=1;
		$alert_content=$alert_content."มีผู้ขออนุญาตลารอความเห็นชอบ  ";
		}
}

//เตือนการลารออนุมัติ(สำหรับผู้ถูกเลือกให้อนุมัติ)
$sql_la_alert2 = "select la_main.id from la_main left join la_person_set on  la_main.person_id=la_person_set.person_id where (la_main.grant_p_selected ='$_SESSION[login_user_id]') and (la_main.rec_date<'$onedayago' or la_person_set.comment_person is null or la_person_set.comment_person='' or la_main.no_comment='1' or la_main.group_sign is not null) and (la_main.commander_sign is null)";

$dbquery_la_alert2 = mysqli_query($connect,$sql_la_alert2);
if($dbquery_la_alert2){
		$la_alert2_num=mysqli_num_rows($dbquery_la_alert2);
		if($la_alert2_num>=1){
		$alert=1;
		$alert_content=$alert_content."มีผู้ขออนุญาตลารอการอนุมัติ ";
		}
}
if($la_alert2_num<1){
		//เตือนการลารออนุมัติ(กรณีทั่วไป)
		$sql_la_alert3 = "select la_main.id from la_main left join la_person_set on  la_main.person_id=la_person_set.person_id where (la_person_set.grant_person ='$_SESSION[login_user_id]') and (la_main.grant_p_selected is null or la_main.grant_p_selected='') and (la_main.rec_date<'$onedayago' or la_person_set.comment_person is null or la_person_set.comment_person='' or la_main.no_comment='1' or la_main.group_sign is not null) and (la_main.commander_sign is null)";

		$dbquery_la_alert3 = mysqli_query($connect,$sql_la_alert3);
		if($dbquery_la_alert3){
				$la_alert3_num=mysqli_num_rows($dbquery_la_alert3);
				if($la_alert3_num>=1){
				$alert=1;
				$alert_content=$alert_content."มีผู้ขออนุญาตลารอการอนุมัติ ";
				}
		}
}

//เตือนขอยกเลิกวันลาของผู้เห็นชอบ
$sql_la_alert4 = "select la_cancel.id from la_cancel left join la_person_set on  la_cancel.person_id=la_person_set.person_id where (la_person_set.comment_person ='$_SESSION[login_user_id]') and (la_cancel.group_sign is null) and (la_cancel.commander_sign is null) ";

$dbquery_la_alert4 = mysqli_query($connect,$sql_la_alert4 );
if($dbquery_la_alert4){
		$la_alert4_num=mysqli_num_rows($dbquery_la_alert4);
		if($la_alert4_num>=1){
		$alert=1;
		$alert_content=$alert_content."มีผู้ขออนุญาตยกเลิกวันลารอความเห็นชอบ  ";
		}
}

//เตือนการขอยกเลิกวันลารออนุมัติ(สำหรับผู้ถูกเลือกให้อนุมัติ)
$sql_la_alert5 = "select la_cancel.id from la_cancel left join la_person_set on  la_cancel.person_id=la_person_set.person_id where (la_cancel.grant_p_selected ='$_SESSION[login_user_id]') and (la_cancel.rec_date<'$onedayago' or la_person_set.comment_person is null or la_person_set.comment_person='' or la_cancel.no_comment='1' or la_cancel.group_sign is not null) and (la_cancel.commander_sign is null)";

$dbquery_la_alert5 = mysqli_query($connect,$sql_la_alert5);
if($dbquery_la_alert5){
		$la_alert5_num=mysqli_num_rows($dbquery_la_alert5);
		if($la_alert5_num>=1){
		$alert=1;
		$alert_content=$alert_content."มีผู้ขออนุญาตยกเลิกวันลารอการอนุมัติ ";
		}
}
if($la_alert5_num<1){
		//เตือนการขอยกเลิกวันลารออนุมัติ(กรณีทั่วไป)
		$sql_la_alert6 = "select la_cancel.id from la_cancel left join la_person_set on  la_cancel.person_id=la_person_set.person_id where (la_person_set.grant_person ='$_SESSION[login_user_id]') and (la_cancel.grant_p_selected is null or la_cancel.grant_p_selected='') and (la_cancel.rec_date<'$onedayago' or la_person_set.comment_person is null or la_person_set.comment_person='' or la_cancel.no_comment='1' or la_cancel.group_sign is not null) and (la_cancel.commander_sign is null)";

		$dbquery_la_alert6 = mysqli_query($connect,$sql_la_alert6);
		if($dbquery_la_alert6){
				$la_alert6_num=mysqli_num_rows($dbquery_la_alert6);
				if($la_alert6_num>=1){
				$alert=1;
				$alert_content=$alert_content."มีผู้ขออนุญาตยกเลิกวันลารอการอนุมัติ ";
				}
		}
}

////////////////////////////////////////////////////////////
//เตือนmail
$sql_mail_alert = "select  mail_main.ms_id from mail_main left join mail_sendto_answer on mail_main.ref_id=mail_sendto_answer.ref_id where mail_sendto_answer.send_to='$_SESSION[login_user_id]' and mail_sendto_answer.answer<'1' ";
$dbquery_mail_alert = mysqli_query($connect,$sql_mail_alert );
if($dbquery_mail_alert){
		$mail_num=mysqli_num_rows($dbquery_mail_alert);
		if($mail_num>=1){
		$alert=1;
		$alert_content=$alert_content."มีจดหมายยังไม่ได้รับ  ";
		}
}

/////////////////////////////////////
//เตือนเจ้าหน้าที่ยานพาหนะ
$sql_car_alert1 = "select  id  from car_main where officer_sign is null  and group_sign is null  and  commander_sign is null";
$dbquery_car_alert1 = mysqli_query($connect,$sql_car_alert1);
if($dbquery_car_alert1){
		$num_car1=mysqli_num_rows($dbquery_car_alert1);
		if($num_car1>=1){
				$sql_car_permission1="select id from car_permission where p1='1'  and person_id='$_SESSION[login_user_id]' ";
				$dbquery_car_permission1=mysqli_query($connect,$sql_car_permission1);
				$car_permission_num1=mysqli_num_rows($dbquery_car_permission1);
						if($car_permission_num1>=1){
						$alert=1;
						$alert_content=$alert_content."มีผู้ขออนุญาตใช้รถราชการรอเจ้าหน้าที่  ";
						}
			}
}

//เตือนลงความเห็นยานพาหนะ
$sql_car_alert2 = "select  id  from car_main where officer_sign is not null  and group_sign is null  and  commander_sign is null";
$dbquery_car_alert2 = mysqli_query($connect,$sql_car_alert2);
if($dbquery_car_alert2){
		$num_car2=mysqli_num_rows($dbquery_car_alert2);
		if($num_car2>=1){
				$sql_car_permission2="select id from car_permission where p1='2'  and person_id='$_SESSION[login_user_id]' ";
				$dbquery_car_permission2=mysqli_query($connect,$sql_car_permission2);
				$car_permission_num2=mysqli_num_rows($dbquery_car_permission2);
						if($car_permission_num2>=1){
						$alert=1;
						$alert_content=$alert_content."มีผู้ขออนุญาตใช้รถราชการรอความเห็นชอบ  ";
						}
			}
}

//เตือนอนุมัติยานพาหนะ
$sql_car_alert3 = "select  id from car_main where officer_sign is not null and  commander_sign is null";
$dbquery_car_alert3 = mysqli_query($connect,$sql_car_alert3);
if($dbquery_car_alert3){
		$num_car3=mysqli_num_rows($dbquery_car_alert3);
		if($num_car3>=1){
				$sql_car_permission3="select id from car_permission where p1='3'  and person_id='$_SESSION[login_user_id]' ";
				$dbquery_car_permission3=mysqli_query($connect,$sql_car_permission3);
				$car_permission_num3=mysqli_num_rows($dbquery_car_permission3);
						if($car_permission_num3>=1){
						$alert=1;
						$alert_content=$alert_content."มีผู้ขออนุญาตใช้รถราชการรออนุมัติ  ";
						}
			}
}

//เตือนระบบส่งหนังสือราชการ
if($_SESSION['login_status']<=5){
$sql_book_alert = "select id from book_sendto_answer where  send_to='$_SESSION[login_user_id]' and answer is null";
$dbquery_book_alert = mysqli_query($connect,$sql_book_alert );
}
else if(($_SESSION['login_status']>10) and ($_SESSION['login_status']<=15)){
$sql_book_alert = "select id from book_sendto_answer where  send_to='$_SESSION[login_user_id]' and school='$_SESSION[user_school]' and answer is null";
$dbquery_book_alert = mysqli_query($connect,$sql_book_alert );
}
else{
$dbquery_book_alert=0;
}
if($dbquery_book_alert){
		$book_num=mysqli_num_rows($dbquery_book_alert);
		if($book_num>=1){
		$alert=1;
		$alert_content=$alert_content."มีหนังสือราชการยังไม่ได้รับ  ";
		}
}

?>
