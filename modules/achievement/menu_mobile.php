<?php
/** ensure this file is being included by a parent file */
defined( '_VALID_' ) or die( 'Direct Access to this location is not allowed.' );
//sd page

$sql_permission = "select * from achievement_permission where person_id='$_SESSION[login_user_id]'";
$dbquery_permission = mysqli_query($connect,$sql_permission);
$result_permission = mysqli_fetch_array($dbquery_permission);

if(!isset($_SESSION['admin_achievement'])){
$_SESSION['admin_achievement']="";
}

echo "<table width='100%' border='0' cellspacing='0' cellpadding='0'>";
echo "<tr bgcolor='#FFCC00'><td>";
echo "<ul id='nav' class='dropdown dropdown-horizontal'>";
	echo "<li><a href='./'>รายการหลัก</a></li>";
	echo "<li><a href='?option=achievement&task=main/report1_1_mobile' class='dir'>O-NET</a></li>";
	echo "<li><a href='?option=achievement&task=main/report4_1_mobile' class='dir'>NT</a></li>";
	echo "<li><a href='?option=achievement&task=main/report6_1_mobile' class='dir'>LAS</a></li>";
	echo "</li>";
echo "</ul>";
echo "</td></tr>";
echo "</table>";
?>
