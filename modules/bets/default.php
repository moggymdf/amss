<?php
	if($_SESSION['user_os']=='mobile'){
			if($_SESSION['login_status']>=2 and $_SESSION['login_status']<=4){
			include("modules/bets/main/khet_report_1_mobile.php");
			}
			else if($_SESSION['login_status']>=12 and $_SESSION['login_status']<=14){
			include("modules/bets/main/sch_report_1_mobile.php");
			}
			else if($_SESSION['login_status']==16){
			include("modules/bets/main/student_report_1_mobile.php");
			}

	}
	else{
	echo "<br />";
	echo "<br />";
	echo "<br />";
	echo "<div align='center'><img src='modules/bets/images/bets.jpg' border='0' width='45%'></div>";
	}
?>

