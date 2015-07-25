<?php
	if($_SESSION['user_os']=='mobile'){
			if($_SESSION['login_status']<5){
			include("modules/spacial_student/student_sch_disable_report3_mobile.php");
			}
			else if($_SESSION['login_status']>=12){
			include("modules/spacial_student/student_sch_disable_report1_mobile.php");
			}
	}
	else{
	echo "<br />";
	echo "<br />";
	echo "<br />";
	echo "<div align='center'><img src='modules/spacial_student/images/spacial_student.jpg' border='0' width='30%'></div>";
	}
?>
