<?php
/** ensure this file is being included by a parent file */
defined( '_VALID_' ) or die( 'Direct Access to this location is not allowed.' );

//ปีงบประมาณ
$sql = "select * from  student_main_edyear  where year_active='1' order by  ed_year desc limit 1";
$dbquery = mysqli_query($connect,$sql);
$year_active_result = mysqli_fetch_array($dbquery);
if($year_active_result['ed_year']==""){
echo "<br />";
echo "<div align='center'>ยังไม่ได้กำหนดทำงานในปีการศึกษาใด ๆ  กรุณาไปที่เมนูตั้งค่าระบบ เพื่อกำหนดปีการศึกษา</div>";
exit();
}
echo "<br>";
echo "<table width='50%' border='0' align='center'>";
echo "<tr align='center'><td><font color='#006666' size='3'><strong>สรุปจำนวนนักเรียนที่มีความต้องการพิเศษ ปีการศึกษา  $year_active_result[ed_year]</strong></font></td></tr>";
echo "</table>";

$sql = "select  * from system_school order by school_type,school_code";
$dbquery = mysqli_query($connect,$sql);
echo  "<table width=90% border='0' align='center'>";
echo "<Tr bgcolor=#FFCCCC align='center' ><Td width='50'>ที่</Td><Td align='center'>
โรงเรียน</Td><Td>ไม่ระบุ</Td><Td>บกพร่อง<br>การมองเห็น</Td><Td>บกพร่อง<br>การได้ยิน</Td><Td>บกพร่อง<br>ทางปัญญา</Td><Td>บกพร่อง<br>ทางร่างกาย</Td><Td>บกพร่อง<br>การเรียนรู้</Td><Td>บกพร่อง<br>ทางภาษา</Td><Td>บกพร่อง<br>ทางพฤติกรรม</Td><Td>ออทิสติก</Td><Td>พิการ<br>ซ้ำซ้อน</Td><td>รวม</td></Tr>";
$M=1;
			$total_0="";
			$total_1="";
			$total_2="";
			$total_3="";
			$total_4="";
			$total_5="";
			$total_6="";
			$total_7="";
			$total_8="";
			$total_9="";
			$sum_total="";

While ($result = mysqli_fetch_array($dbquery))
	{
			if(($M%2) == 0)
			$color="#FFFFC";
			else  	$color="#FFFFF";
			$id=$result['id'];
			$sql2 = "select  disable_type, COUNT(spacial_student_disabled.id) as num  from  spacial_student_disabled left join student_main_main on spacial_student_disabled.person_id=student_main_main.person_id where student_main_main.ed_year='$year_active_result[ed_year]' and spacial_student_disabled.school_code='$result[school_code]' and student_main_main.school_code='$result[school_code]' group by disable_type ";
			$dbquery2 = mysqli_query($connect,$sql2);
			$disable_0="";
			$disable_1="";
			$disable_2="";
			$disable_3="";
			$disable_4="";
			$disable_5="";
			$disable_6="";
			$disable_7="";
			$disable_8="";
			$disable_9="";
			$total=0;
			While ($result2 = mysqli_fetch_array($dbquery2)){
					if($result2['disable_type']==0){
					$disable_0=$result2['num'];
					}
					if($result2['disable_type']==1){
					$disable_1=$result2['num'];
					}
					if($result2['disable_type']==2){
					$disable_2=$result2['num'];
					}
					if($result2['disable_type']==3){
					$disable_3=$result2['num'];
					}
					if($result2['disable_type']==4){
					$disable_4=$result2['num'];
					}
					if($result2['disable_type']==5){
					$disable_5=$result2['num'];
					}
					if($result2['disable_type']==6){
					$disable_6=$result2['num'];
					}
					if($result2['disable_type']==7){
					$disable_7=$result2['num'];
					}
					if($result2['disable_type']==8){
					$disable_8=$result2['num'];
					}
					if($result2['disable_type']==9){
					$disable_9=$result2['num'];
					}
			}
			$total=$disable_0+$disable_1+$disable_2+$disable_3+$disable_4+$disable_5+$disable_6+$disable_7+$disable_8+$disable_9;
			$total_0=$total_0+$disable_0;
			$total_1=$total_1+$disable_1;
			$total_2=$total_2+$disable_2;
			$total_3=$total_3+$disable_3;
			$total_4=$total_4+$disable_4;
			$total_5=$total_5+$disable_5;
			$total_6=$total_6+$disable_6;
			$total_7=$total_7+$disable_7;
			$total_8=$total_8+$disable_8;
			$total_9=$total_9+$disable_9;
			$sum_total=$sum_total+$total;

	if($total>0){
	echo "<Tr bgcolor=$color align='center'><Td>$M</Td>";
	echo "<Td align='left'><a href=?option=spacial_student&task=student_sch_disable_report2&school=$result[school_code]>$result[school_name]</a></Td>";
	echo "<Td>$disable_0</Td><td>$disable_1</td><td>$disable_2</td><td>$disable_3</td><td>$disable_4</td><td>$disable_5</td><td>$disable_6</td><td>$disable_7</td><td>$disable_8</td><td>$disable_9</td><td>$total</td>";
	echo "</Tr>";
	$M++;
	}
}
echo "<Tr bgcolor='#99FFFF' align='center'><td colspan='2'>รวม</td><Td>$total_0</Td><td>$total_1</td><td>$total_2</td><td>$total_3</td><td>$total_4</td><td>$total_5</td><td>$total_6</td><td>$total_7</td><td>$total_8</td><td>$total_9</td><td>$sum_total</td></tr>";
echo "</Table>";
?>
