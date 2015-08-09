<?php
/** ensure this file is being included by a parent file */
defined( '_VALID_' ) or die( 'Direct Access to this location is not allowed.' );
//sd page

$sql_permission = "select * from  bookregister_permission where person_id='$_SESSION[login_user_id]'";
$dbquery_permission = mysqli_query($connect,$sql_permission);
$result_permission = mysqli_fetch_array($dbquery_permission);

if(!isset($_SESSION['admin_bookregister'])){
$_SESSION['admin_bookregister']="";
}

echo "<table width='100%' border='0' cellspacing='0' cellpadding='0'>";
echo "<tr bgcolor='#FFCC00'><td>";
echo "<ul id='nav' class='dropdown dropdown-horizontal'>";
	echo "<li><a href='./'>รายการหลัก</a></li>";
	if($_SESSION['admin_bookregister']=="bookregister" or $result_permission['saraban_status']==1){			//กำหนดสิทธิ์ให้เห็นเมนู  admin และ สารบรรณกลาง สพฐ.
	echo "<li><a href='?option=bookregister' class='dir'>ตั้งค่าระบบ</a>";
		echo "<ul>";
			echo "<li><a href='?option=bookregister&task=permission'>กำหนดเจ้าหน้าที่</a></li>";
			echo "<li><a href='?option=bookregister&task=year'>กำหนดปีปฏิทิน สพฐ.</a></li>";
			echo "<li><a href='?option=bookregister&task=main/office_no'>กำหนดเลขที่หนังสือ</a></li>";
//			echo "<li><a href='?option=bookregister&task=main/cer_sign'>กำหนดผู้ลงนามเกียรติบัตร</a></li>";
//			echo "<li><a href='?option=bookregister&task=cer_officer'>กำหนดผู้ตรวจสอบการลงทะเบียนเกียรติบัตร</a></li>";
		echo "</ul>";
	echo "</li>";
	}
	//เมนูสารบรรณสำนัก
	if($result_permission['saraban_status']==2){			//กำหนดสิทธิ์ให้เห็นเมนู  สารบรรณสำนัก
	echo "<li><a href='?option=bookregister' class='dir'>ตั้งค่าระบบสำนัก</a>";
		echo "<ul>";
			echo "<li><a href='?option=bookregister&task=permission_de'>กำหนดเจ้าหน้าที่</a></li>";
			echo "<li><a href='?option=bookregister&task=year_de'>กำหนดปีปฏิทิน สำนัก</a></li>";
			echo "<li><a href='?option=bookregister&task=main/office_no'>กำหนดเลขที่หนังสือ</a></li>";
	//		echo "<li><a href='?option=bookregister&task=main/cer_sign'>กำหนดผู้ลงนามเกียรติบัตร</a></li>";
	//		echo "<li><a href='?option=bookregister&task=cer_officer'>กำหนดผู้ตรวจสอบการลงทะเบียนเกียรติบัตร</a></li>";
		echo "</ul>";
	echo "</li>";
	}
	//เมนูสารบรรณกลุ่ม
	if($result_permission['saraban_status']==3){			//กำหนดสิทธิ์ให้เห็นเมนู  สารบรรณกลุ่ม
	echo "<li><a href='?option=bookregister' class='dir'>ตั้งค่าระบบกลุ่ม</a>";
		echo "<ul>";
//			echo "<li><a href='?option=bookregister&task=permission'>กำหนดเจ้าหน้าที่</a></li>";
			echo "<li><a href='?option=bookregister&task=year_g'>กำหนดปีปฏิทิน กลุ่ม</a></li>";
		//	echo "<li><a href='?option=bookregister&task=main/office_no'>กำหนดเลขที่หนังสือ</a></li>";
		//	echo "<li><a href='?option=bookregister&task=main/cer_sign'>กำหนดผู้ลงนามเกียรติบัตร</a></li>";
		//	echo "<li><a href='?option=bookregister&task=cer_officer'>กำหนดผู้ตรวจสอบการลงทะเบียนเกียรติบัตร</a></li>";
		echo "</ul>";
	echo "</li>";
	}


	//เมนูทะเบียนหนังสือ สารบรรณกลุ่ม
	if($result_permission['saraban_status']==3){			//กำหนดสิทธิ์ให้เห็นเมนู  สารบรรณกลุ่ม
echo "<li><a href='?option=bookregister&task=main/receive_g' class='dir'>ทะเบียนหนังสือรับกลุ่ม</a>";
		echo "<ul>";
			echo "<li><a href='?option=bookregister&task=main/receive_g'>ทะเบียนหนังสือรับกลุ่ม</a></li>";
		echo "</ul>";
	echo "</li>";

	echo "<li><a href='?option=bookregister&task=main/send_g' class='dir'>ทะเบียนหนังสือส่งกลุ่ม</a>";
		echo "<ul>";
			echo "<li><a href='?option=bookregister&task=main/send_g'>ทะเบียนหนังสือส่งกลุ่ม</a></li>";
		echo "</ul>";
	echo "</li>";
	}

//เมนูทะเบียนหนังสือ สารบรรณสำนัก
	if($result_permission['saraban_status']==2){			//กำหนดสิทธิ์ให้เห็นเมนู  สารบรรณสำนัก
echo "<li><a href='?option=bookregister&task=main/receive_de' class='dir'>ทะเบียนหนังสือรับสำนัก</a>";
		echo "<ul>";
			echo "<li><a href='?option=bookregister&task=main/receive_de'>ทะเบียนหนังสือรับสำนัก</a></li>";
		echo "</ul>";
	echo "</li>";

	echo "<li><a href='?option=bookregister&task=main/send_de' class='dir'>ทะเบียนหนังสือส่งสำนัก</a>";
		echo "<ul>";
			echo "<li><a href='?option=bookregister&task=main/send_de'>ทะเบียนหนังสือส่งสำนัก</a></li>";
		echo "</ul>";
	echo "</li>";
	}

	if($_SESSION['admin_bookregister']=="bookregister" or $result_permission['saraban_status']==1){		 //กำหนดสิทธิ์ให้เห็นเมนู  admin และ สารบรรณกลาง สพฐ.
	echo "<li><a href='?option=bookregister&task=main/receive' class='dir'>ทะเบียนหนังสือรับ สพฐ.</a>";
		echo "<ul>";
			echo "<li><a href='?option=bookregister&task=main/receive'>ทะเบียนหนังสือรับ สพฐ.</a></li>";
		echo "</ul>";
	echo "</li>";

	echo "<li><a href='?option=bookregister&task=main/send' class='dir'>ทะเบียนหนังสือส่ง สพฐ.</a>";
		echo "<ul>";
			echo "<li><a href='?option=bookregister&task=main/send'>ทะเบียนหนังสือส่ง สพฐ.</a></li>";
		echo "</ul>";
	echo "</li>";
	echo "<li><a href='?option=bookregister&task=main/command' class='dir'>ทะเบียนคำสั่ง สพฐ.</a>";
		echo "<ul>";
			echo "<li><a href='?option=bookregister&task=main/command'>ทะเบียนคำสั่ง สพฐ.</a></li>";
		echo "</ul>";
//	echo "</li>";
//	echo "<li><a href='?option=bookregister&task=main/certificate' class='dir'>ทะเบียนเกียรติบัตร</a>";
//		echo "<ul>";
//			echo "<li><a href='?option=bookregister&task=main/certificate'>ทะเบียนเกียรติบัตร</a></li>";
//			echo "<li><a href='?option=bookregister&task=main/certificate_officer'>เจ้าหน้าที่ทะเบียนเกียรติบัตร</a></li>";
//		echo "</ul>";
//	echo "</li>";
}

	echo "<li><a href='?option=bookregister' class='dir'>คู่มือ</a>";
		echo "<ul>";
				echo "<li><a href='modules/bookregister/manual/bookregister.pdf' target='_blank'>คู่มือ</a></li>";
		echo "</ul>";
	echo "</li>";
echo "</ul>";
echo "</td></tr>";
echo "</table>";
?>
