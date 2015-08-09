<?php
	if($_SESSION['user_os']=='mobile'){
	include("modules/ioffice/ioffice_report1_mobile.php");
	}
	else{
	echo "<br />";
	echo "<br />";
	echo "<br />";
	echo "<div align='center'><img src='./modules/ioffice/images/ioffice.png' class='img-responsive'></div>";
	}
?>

