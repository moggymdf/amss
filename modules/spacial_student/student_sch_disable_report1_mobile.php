<?php
/** ensure this file is being included by a parent file */
defined( '_VALID_' ) or die( 'Direct Access to this location is not allowed.' );
//sd page

$officer=$_SESSION['login_user_id'];
require_once "modules/spacial_student/time_inc.php";
$disable_type_ar[1]="บกพร่องทางการการเห็น";
$disable_type_ar[2]="บกพร่องทางการการได้ยิน";
$disable_type_ar[3]="บกพร่องทางสติปัญญา";
$disable_type_ar[4]="บกพร่องทางร่างกาย";
$disable_type_ar[5]="มีปัญหาทางการเรียนรู้";
$disable_type_ar[6]="บกพร่องทางการพูดและภาษา";
$disable_type_ar[7]="มีปัญหาทางพฤติกรรมหรืออารมณ์";
$disable_type_ar[8]="ออทิสติก";
$disable_type_ar[9]="พิการซ้ำซ้อน";

if(!isset($_REQUEST['year_index'])){
$_REQUEST['year_index']="";
}

if(!isset($_POST['year_index'])){
$_POST['year_index']="";
}

if(!isset($_SESSION['user_school'])){
$_SESSION['user_school']="";
}

if(!isset($_REQUEST['school_index'])){
$_REQUEST['school_index']="";
}

if(!isset($_REQUEST['class_index'])){
$_REQUEST['class_index']="";
}

//ปีงบประมาณ
$sql = "select * from  student_main_edyear  where year_active='1' order by  ed_year desc limit 1";
$dbquery = mysqli_query($connect,$sql);
$year_active_result = mysqli_fetch_array($dbquery);
if($year_active_result['ed_year']==""){
echo "<br />";
echo "<div align='center'>ยังไม่ได้กำหนดทำงานในปีการศึกษาใด ๆ  กรุณาไปที่เมนูตั้งค่าระบบ เพื่อกำหนดปีการศึกษา</div>";
exit();
}

if($_REQUEST['year_index']!=""){
$year_active_result['ed_year']=$_REQUEST['year_index'];
}

$_REQUEST['school_index']=$_SESSION['user_school'];

//อาเรย์ชั้น
$school_class_ar[0]="ไม่ระบุชั้น";
$school_class_ar[1]="อ.1(3ปี)";
$school_class_ar[2]="อ.1";
$school_class_ar[3]="อ.2";
$school_class_ar[4]="ป.1";
$school_class_ar[5]="ป.2";
$school_class_ar[6]="ป.3";
$school_class_ar[7]="ป.4";
$school_class_ar[8]="ป.5";
$school_class_ar[9]="ป.6";
$school_class_ar[10]="ม.1";
$school_class_ar[11]="ม.2";
$school_class_ar[12]="ม.3";
$school_class_ar[13]="ม.4";
$school_class_ar[14]="ม.5";
$school_class_ar[15]="ม.6";

echo "<br />";

if(!(($index==5) or ($index==9))){
echo "<table width='100%' border='0' align='center'>";
echo "<tr align='center'><td><font color='#006666'><strong>รายชื่อนักเรียนที่มีความต้องการพิเศษ</strong></font></td></tr><tr align='center'><td><font color='#006666'> ปีการศึกษา  $year_active_result[ed_year] (ร.ร.ตนเอง)</font></td></tr>";
echo "</table>";
}

//ส่วนการแสดงผล
if(!(($index==5) or ($index==9))){
	if(!isset($_REQUEST['disable_type'])){
	$_REQUEST['disable_type']="";
}

//ส่วนของการแยกหน้า
$pagelen=15;  // 1_กำหนดแถวต่อหน้า
$url_link="option=spacial_student&task=student_sch_disable_report1_mobile&disable_type=$_REQUEST[disable_type]";  // 2_กำหนดลิงค์ฺ
if($_REQUEST['disable_type']!=""){
$sql = "select  * from  spacial_student_disabled left join student_main_main on spacial_student_disabled.person_id=student_main_main.person_id where  student_main_main.ed_year='$year_active_result[ed_year]' and spacial_student_disabled.disable_type='$_REQUEST[disable_type]' and student_main_main.school_code='$_SESSION[user_school]' and spacial_student_disabled.school_code='$_SESSION[user_school]' ";
}
else{
$sql = "select  * from  spacial_student_disabled left join student_main_main on spacial_student_disabled.person_id=student_main_main.person_id where  student_main_main.ed_year='$year_active_result[ed_year]' and student_main_main.school_code='$_SESSION[user_school]' and spacial_student_disabled.school_code='$_SESSION[user_school]' ";
}
$dbquery = mysqli_query($connect,$sql);
$num_rows=mysqli_num_rows($dbquery);
$totalpages=ceil($num_rows/$pagelen);

if(!isset($_REQUEST['page'])){
$_REQUEST['page']="";
}

if($_REQUEST['page']==""){
$page=$totalpages;
		if($page<2){
		$page=1;
		}
}
else{
		if($totalpages<$_REQUEST['page']){
		$page=$totalpages;
					if($page<1){
					$page=1;
					}
		}
		else{
		$page=$_REQUEST['page'];
		}
}

$start=($page-1)*$pagelen;

if(($totalpages>1) and ($totalpages<6)){
echo "<div align=center>";
echo "หน้า	";
			for($i=1; $i<=$totalpages; $i++)	{
					if($i==$page){
					echo "[<b><font size=+1 color=#990000>$i</font></b>]";
					}
					else {
					echo "<a href=$PHP_SELF?$url_link&page=$i>[$i]</a>";
					}
			}
echo "</div>";
}
if($totalpages>5){
			if($page <=3){
			$e_page=5;
			$s_page=1;
			}
			if($page>3){
					if($totalpages-$page>=2){
					$e_page=$page+2;
					$s_page=$page-2;
					}
					else{
					$e_page=$totalpages;
					$s_page=$totalpages-5;
					}
			}
			echo "<div align=center>";
			if($page!=1){
			$f_page1=$page-1;
			echo "<<a href=$PHP_SELF?$url_link&page=1>แรก </a>";
			echo "<<<a href=$PHP_SELF?$url_link&page=$f_page1>ก่อน </a>";
			}
			else {
			echo "หน้า	";
			}
			for($i=$s_page; $i<=$e_page; $i++){
					if($i==$page){
					echo "[<b><font size=+1 color=#990000>$i</font></b>]";
					}
					else {
					echo "<a href=$PHP_SELF?$url_link&page=$i>[$i]</a>";
					}
			}
			if($page<$totalpages)	{
			$f_page2=$page+1;
			echo "<a href=$PHP_SELF?$url_link&page=$f_page2> ถัด</a>>>";
			echo "<a href=$PHP_SELF?$url_link&page=$totalpages> ท้าย</a>>";
			}
			echo " <select onchange=\"location.href=this.options[this.selectedIndex].value;\" size=\"1\" name=\"select\">";
			echo "<option  value=\"\">หน้า</option>";
				for($p=1;$p<=$totalpages;$p++){
				echo "<option  value=\"?$url_link&page=$p\">$p</option>";
				}
			echo "</select>";
echo "</div>";
}
//จบแยกหน้า

		echo  "<table width=100% border='0' align='center'>";
		echo "<Tr>";
		echo "<td align='right'>";
		echo "<form id='frm1' name='frm1'>";
//เลือกประเภทความพิการ
		echo "<Select  name='disable_type' size='1' onchange='goto_index(2)'>";
		echo  "<option value =''>ทุกประเภท(รวมไม่ระบุ)</option>";
		if($_REQUEST['disable_type']==1){
		echo  "<option value ='1' selected>1.บกพร่องทางการการเห็น</option>";
		}else{
		echo  "<option value ='1'>1.บกพร่องทางการการเห็น</option>";
		}

		if($_REQUEST['disable_type']==2){
		echo  "<option value ='2' selected>2.บกพร่องทางการการได้ยิน</option>";
		}
		else{
		echo  "<option value ='2'>2.บกพร่องทางการการได้ยิน</option>";
		}

		if($_REQUEST['disable_type']==3){
		echo  "<option value ='3' selected>3.บกพร่องทางสติปัญญา</option>";
		}
		else{
		echo  "<option value ='3'>3.บกพร่องทางสติปัญญา</option>";
		}

		if($_REQUEST['disable_type']==4){
		echo  "<option value ='4' selected>4.บกพร่องทางร่างกาย</option>";
		}
		else{
		echo  "<option value ='4'>4.บกพร่องทางร่างกาย</option>";
		}

		if($_REQUEST['disable_type']==5){
		echo  "<option value ='5' selected>5.มีปัญหาทางการเรียนรู้</option>";
		}
		else{
		echo  "<option value ='5'>5.มีปัญหาทางการเรียนรู้</option>";
		}

		if($_REQUEST['disable_type']==6){
		echo  "<option value ='6' selected>6.บกพร่องทางการพูดและภาษา</option>";
		}
		else{
		echo  "<option value ='6'>6.บกพร่องทางการพูดและภาษา</option>";
		}

		if($_REQUEST['disable_type']==7){
		echo  "<option value ='7' selected>7.มีปัญหาทางพฤติกรรมหรืออารมณ์</option>";
		}
		else{
		echo  "<option value ='7'>7.มีปัญหาทางพฤติกรรมหรืออารมณ์</option>";
		}

		if($_REQUEST['disable_type']==8){
		echo  "<option value ='8' selected>8.ออทิสติก</option>";
		}
		else{
		echo  "<option value ='8'>8.ออทิสติก</option>";
		}

		if($_REQUEST['disable_type']==9){
		echo  "<option value ='9' selected>9.พิการซ้ำซ้อน</option>";
		}
		else{
		echo  "<option value ='9'>9.พิการซ้ำซ้อน</option>";
		}

		echo "</select>";
		echo "</form>";
		echo "</td></Tr></Table>";
		//จบ

if($_REQUEST['disable_type']!=""){
$sql = "select  *,spacial_student_disabled.id from  spacial_student_disabled left join student_main_main on spacial_student_disabled.person_id=student_main_main.person_id where  student_main_main.ed_year='$year_active_result[ed_year]' and spacial_student_disabled.disable_type='$_REQUEST[disable_type]' and student_main_main.school_code='$_SESSION[user_school]' and spacial_student_disabled.school_code='$_SESSION[user_school]' order by student_main_main.classlevel ,student_main_main.classroom, student_main_main.student_id limit $start,$pagelen";
}
else{
$sql = "select  *,spacial_student_disabled.id from  spacial_student_disabled left join student_main_main on spacial_student_disabled.person_id=student_main_main.person_id where  student_main_main.ed_year='$year_active_result[ed_year]' and student_main_main.school_code='$_SESSION[user_school]' and spacial_student_disabled.school_code='$_SESSION[user_school]' order by student_main_main.classlevel ,student_main_main.classroom, student_main_main.student_id limit $start,$pagelen";
}
$dbquery = mysqli_query($connect,$sql);

echo  "<table width=100% border='0' align='center'>";
echo "<Tr bgcolor=#FFCCCC align='center' ><Td>ที่</Td><Td align='center'>ชื่อ</Td><Td>ชั้น</Td><Td>ประเภท</Td></Tr>";
$N=(($page-1)*$pagelen)+1;  //*เกี่ยวข้องกับการแยกหน้า
$M=1;
While ($result = mysqli_fetch_array($dbquery))
	{

			if(($M%2) == 0)
			$color="#FFFFC";
			else  	$color="#FFFFFF";
			$id=$result['id'];
			$classlevel=$result['classlevel'];
			$school_code=$result['school_code'];
echo "<Tr  bgcolor=$color align='center'><Td>$N</Td>";
echo "<Td align='left'>$result[prename]$result[name]&nbsp;&nbsp;&nbsp;$result[surname]</Td>";
echo "<Td align='center'>$school_class_ar[$classlevel]</Td>";
echo "<Td align='left'>";
if($result['disable_type']>=1){
echo $disable_type_ar[$result['disable_type']];
}
echo "</Td>";
echo "</Tr>";
$M++;
$N++;  //*เกี่ยวข้องกับการแยกหน้า
	}

echo "</Table>";
}
?>
<script>
function goto_index(val){
	if(val==1){
		callfrm("?option=spacial_student&task=student_sch_disable_report1_mobile&index=1");   // page ย้อนกลับ
		}
	if(val==2){
		callfrm("?option=spacial_student&task=student_sch_disable_report1_mobile");   // page ย้อนกลับ
		}
}
</script>
