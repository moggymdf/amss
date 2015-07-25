<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
</head>
<body>

<?php
require_once "../../amssplus_connect.php";

//ปีงบประมาณ
$sql = "select * from  student_main_edyear  where year_active='1' order by  ed_year desc limit 1";
$dbquery = mysqli_query($connect,$sql);
$year_active_result = mysqli_fetch_array($dbquery);
if($year_active_result['ed_year']==""){
echo "<br />";
echo "<div align='center'>ยังไม่ได้กำหนดทำงานในปีการศึกษาใด ๆ  กรุณาไปที่เมนูตั้งค่าระบบ เพื่อกำหนดปีการศึกษา</div>";
exit();
}

$sql_name = "select * from spacial_student_disabled left join student_main_main on spacial_student_disabled.person_id=student_main_main.person_id  where spacial_student_disabled.person_id='$_GET[person_id]' and student_main_main.ed_year='$year_active_result[ed_year]'";
$dbquery_name = mysqli_query($connect,$sql_name);
$result = mysqli_fetch_array($dbquery_name);
		$prename=$result['prename'];
		$name= $result['name'];
		$surname = $result['surname'];
		$pic = $result['pic'];
$full_name="$prename$name&nbsp;&nbsp;$surname";
echo "<br>";
echo "<div align='center'><img src='../../$pic' border='0' width='400'></div>";
echo "<br>";
echo "<div align='center'>";
echo $full_name;
echo "</div>";
?>
<br />
<CENTER><input border="0" src="images/button95.jpg" name="I1" width="100" height="20" type="image" onClick="javascript:window.close()"></CENTER>
</body>
</html>

