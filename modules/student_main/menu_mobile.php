<?php
/** ensure this file is being included by a parent file */
defined( '_VALID_' ) or die( 'Direct Access to this location is not allowed.' );

if($_SESSION['login_status']<5){
$sql_permission = "select * from student_main_permission where person_id='$_SESSION[login_user_id]'";
}
else{
$sql_permission = "select * from student_main_permission where person_id='$_SESSION[login_user_id]' and school_code='$_SESSION[user_school]'";
}

$dbquery_permission = mysqli_query($connect,$sql_permission);
$result_permission = mysqli_fetch_array($dbquery_permission);

if(!isset($_SESSION['admin_student_main'])){
$_SESSION['admin_student_main']="";
}

echo "<table width='100%' border='0' cellspacing='0' cellpadding='0'>";
echo "<tr bgcolor='#FFCC00'><td>";
echo "<ul id='nav' class='dropdown dropdown-horizontal'>";
	echo "<li><a href='./'>รายการหลัก</a></li>";
echo "</ul>";
echo "</td></tr>";
echo "</table>";
?>
