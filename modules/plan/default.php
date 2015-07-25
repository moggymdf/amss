<!--  <div style="background-image: url(images/plan.jpg); height: 48em; width: 100%; border: 0px solid lawngreen; background-attachment: none; background-color:transparent; background-repeat:no-repeat; background-position: 50% 0%;"></div>
-->
<?php
	if($_SESSION['user_os']=='mobile'){
	include("modules/plan/check/check_1_mobile.php");
	}
	else{
	echo "<div align='center'><img src='images/plan.jpg' border='0' width='100%'></div>";
	}
?>
