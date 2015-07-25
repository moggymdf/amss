
<?php
/** ensure this file is being included by a parent file */
defined( '_VALID_' ) or die( 'Direct Access to this location is not allowed.' );
//sd page
$rec_date = date("Y-m-d");
$officer=$_SESSION['login_user_id'];

//ปีการศึกษา
$sql = "select * from  student_main_edyear  where year_active='1' order by  ed_year desc limit 1";
$dbquery = mysqli_query($connect,$sql);
$year_active_result = mysqli_fetch_array($dbquery);
if($year_active_result['ed_year']==""){
echo "<br />";
echo "<div align='center'>ยังไม่ได้กำหนดทำงานในปีการศึกษาใด ๆ  กรุณาไปที่เมนูตั้งค่าระบบ เพื่อกำหนดปีการศึกษา</div>";
exit();
}

//ตรวจสอบว่ามีข้อมูลปีการศึกษาปัจจุบันหรือไม่
$sql_2 = "select * from  student_main_main  where  ed_year='$year_active_result[ed_year]' ";
$dbquery_2 = mysqli_query($connect,$sql_2);
$year_active_result_2 = mysqli_fetch_array($dbquery_2);
if($year_active_result_2){
echo "<br />";
echo "<div align='center'>มีข้อมูลปีปัจจุบันอยู่แล้ว  ระบบการเลื่อนชั้นจะไม่ดำเนินการให้ในกรณีมีข้อมูลในปีปัจจุบันแล้ว</div>";
exit();
}

if($index==1){
$year_ref=$year_active_result['ed_year']-1;
$sql_find = "select * from  student_main_main  where  ed_year='$year_ref' ";
$dbquery_find = mysqli_query($connect,$sql_find);
		while($result = mysqli_fetch_array($dbquery_find)){
		$classlevel=$result['classlevel'];
		if($classlevel==1){
		$classlevel=2;
		}
		else if($classlevel==2){
		$classlevel=3;
		}
		else if($classlevel==4){
		$classlevel=5;
		}
		else if($classlevel==5){
		$classlevel=6;
		}
		else if($classlevel==6){
		$classlevel=7;
		}
		else if($classlevel==7){
		$classlevel=8;
		}
		else if($classlevel==8){
		$classlevel=9;
		}
		else if($classlevel==10){
		$classlevel=11;
		}
		else if($classlevel==11){
		$classlevel=12;
		}
		else if($classlevel==13){
		$classlevel=14;
		}
		else if($classlevel==14){
		$classlevel=15;
		}
						if(!($result['classlevel']==3 or $result['classlevel']==9 or $result['classlevel']==12 or $result['classlevel']==15)){
						$sql = "insert into student_main_main (ed_year,ref_id,school_code,student_id,person_id,prename,name,surname,sex,school_name,classlevel,classroom,disable,";
						$sql  .="rec_date,officer";
						$sql  .=")";
						$sql  .=" values ('$year_active_result[ed_year]','$result[ref_id]','$result[school_code]','$result[student_id]','$result[person_id]','$result[prename]','$result[name]','$result[surname]','$result[sex]','$result[school_name]','$classlevel','$result[classroom]','$result[disable]',";
						$sql  .="'$rec_date','$officer'";
						$sql  .=")";
						$dbquery = mysqli_query($connect,$sql);
						}
		}
	 	?> <script>
		document.location.href="?option=student_main&task=student_khet_update";
		</script> <?php
}

echo "<br /><br /><br />";
echo  "<table width=70% border=0 align=center>";
echo "<Tr><Td align='left'><strong>คำอธิบาย</strong></Td></Tr>";
echo "<Tr><Td align='left'>1. การเลื่อนชั้นเป็นทางเลือกหนึ่งสำหรับการบันทึกข้อมูลปีการศึกษาใหม่</Td></Tr>";
echo "<Tr><Td align='left'>2. การเลื่อนชั้นจะเลื่อนทุกชั้น ยกเว้น อนุบาลปีสุดท้าย ป.6  ม.3 และ ม.6</Td></Tr>";
echo "</Table>";
echo "<br /><br /><br />";
echo  "<form name ='frm1'>";
echo  "<table align='center' width='50%' border='0'>";
echo  "<tr> ";
echo  "<td align = 'center'><INPUT TYPE='button' name='smb' value='ตกลง' onclick='tranfer(1)'></td>";
echo   "</tr>";
echo   "</table>";
echo  "</form>";

?>
<script>
function tranfer(val){
	if(val==1){
		callfrm("?option=student_main&task=student_tranfer&index=1");
		}
}
</script>

