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
echo "<table width='50%' border='0' align='center'>";
echo "<tr align='center'><td><font color='#006666' size='3'><strong>รายชื่อนักเรียนที่มีความต้องการพิเศษ ปีการศึกษา  $year_active_result[ed_year]</strong></font></td></tr>";
echo "</table>";
}


if ($index==5){
echo "<form Enctype = multipart/form-data id='frm1' name='frm1'>";
echo "<Center>";
echo "<Font color='#006666' Size=3><B>ข้อมูลพื้นฐาน</B></Font>";
echo "</Cener>";
echo "<Br><Br>";
$sql = "select  * from  spacial_student_disabled left join student_main_main on spacial_student_disabled.person_id=student_main_main.person_id where spacial_student_disabled.id='$_GET[id]'";

$dbquery = mysqli_query($connect,$sql);
$result = mysqli_fetch_array($dbquery);
echo "<Table width='70%' Border='0'>";
echo "<Tr align='left'><Td width=30></Td><Td align='right'>เลขประจำตัวนักเรียน&nbsp;&nbsp;&nbsp;&nbsp;</Td><Td>$result[student_id]</Td></Tr>";
echo "<Tr align='left'><Td width=30></Td><Td align='right'>เลขประจำตัวประชาชน&nbsp;&nbsp;&nbsp;&nbsp;</Td><Td>$result[person_id]</Td></Tr>";
echo "<Tr align='left'><Td width=30></Td><Td align='right'>ชื่อ&nbsp;&nbsp;&nbsp;&nbsp;</Td><Td>$result[prename]$result[name]&nbsp;&nbsp;$result[surname]</Td></Tr>";
echo "<Tr align='left'><Td ></Td><Td align='right'>เพศ&nbsp;&nbsp;&nbsp;&nbsp;</Td><Td>";
if($result['sex']=='ช'){
echo  "ชาย" ;
}
else{
echo  "หญิง" ;
}
echo "</Td></Tr>";

echo "<Tr align='left'><Td ></Td><Td align='right'>ชั้น&nbsp;&nbsp;&nbsp;&nbsp;</Td><Td>";
if($result['classlevel']==1){
echo  "อ.1(3ปี)" ;
}
else if($result['classlevel']==2){
echo  "อ.1" ;
}
else if($result['classlevel']==3){
echo  "อ.2" ;
}
else if($result['classlevel']==4){
echo  "ป.1" ;
}
else if($result['classlevel']==5){
echo  "ป.2" ;
}
else if($result['classlevel']==6){
echo  "ป.3" ;
}
else if($result['classlevel']==7){
echo  "ป.4" ;
}
else if($result['classlevel']==8){
echo  "ป.5" ;
}
else if($result['classlevel']==9){
echo  "ป.6" ;
}
else if($result['classlevel']==10){
echo  "ม.1" ;
}
else if($result['classlevel']==11){
echo  "ม.2" ;
}
else if($result['classlevel']==12){
echo  "ม.3" ;
}
else if($result['classlevel']==13){
echo  "ม.4" ;
}
else if($result['classlevel']==14){
echo  "ม.5" ;
}
else if($result['classlevel']==15){
echo  "ม.6" ;
}
echo "</Td></Tr>";

echo "<Tr align='left'><Td ></Td><Td align='right'>ห้อง&nbsp;&nbsp;&nbsp;&nbsp;</Td><Td>$result[classroom]</Td></Tr>";
echo "<Tr align='left'><Td ></Td><Td align='right'>โรงเรียน&nbsp;&nbsp;&nbsp;&nbsp;</Td><Td>$result[school_name]</Td></Tr>";
if($result['pic']!=""){
echo "<Tr align='left'><Td ></Td><Td align='right'>&nbsp;&nbsp;&nbsp;&nbsp;</Td><Td><img src='$result[pic]' border='0' width='150'></Td></Tr>";
}
echo "<Tr align='left'><Td ></Td><Td align='right'><Font color='#006666'><b>ความพกพร่อง</b></font>&nbsp;&nbsp;&nbsp;&nbsp;</Td><Td>";
		if($result['disable_type']==1){
		echo  "บกพร่องทางการการเห็น";
		}
		else if($result['disable_type']==2){
		echo  "บกพร่องทางการการได้ยิน";
		}
		else if($result['disable_type']==3){
		echo  "บกพร่องทางสติปัญญา";
		}
		else if($result['disable_type']==4){
		echo  "บกพร่องทางร่างกาย";
		}
		else if($result['disable_type']==5){
		echo  "มีปัญหาทางการเรียนรู้";
		}
		else if($result['disable_type']==6){
		echo  "บกพร่องทางการพูดและภาษา";
		}
		else if($result['disable_type']==7){
		echo  "มีปัญหาทางพฤติกรรมหรืออารมณ์";
		}
		else if($result['disable_type']==8){
		echo  "ออทิสติก";
		}
		else if($result['disable_type']==9){
		echo  "พิการซ้ำซ้อน";
		}
echo "</select>";
echo "</Td></Tr>";
echo "<Tr align='left'><Td ></Td><Td align='right'><Font color='#006666'><b>รายละเอียดความพกพร่อง</b></font>&nbsp;&nbsp;&nbsp;&nbsp;</Td><Td><TEXTAREA NAME='disable_detail' ROWS='5' COLS='70' readonly>$result[disable_detail]</TEXTAREA></Td></Tr>";
echo "<Tr align='left'><Td ></Td><Td align='right'><Font color='#006666'><b>ข้อมูลสำคัญอื่น ๆ</b></font>&nbsp;&nbsp;&nbsp;&nbsp;</Td><Td><TEXTAREA NAME='other' ROWS='7' COLS='70' readonly>$result[other]</TEXTAREA></Td></Tr>";
echo "</Table>";
echo "<Br />";
echo "<Input Type=Hidden Name='person_id' Value='$result[person_id]'>";
echo "<Input Type=Hidden Name='id' Value='$_GET[id]'>";
echo "<Input Type=Hidden Name='disable_type' Value='$_REQUEST[disable_type]'>";
echo "<Input Type=Hidden Name='page' Value='$_REQUEST[page]'>";
echo "<INPUT TYPE='button' name='back' value='ย้อนกลับ' onclick='goto_url_update(0)'>";
echo "</form>";
}

if($index==9){
$sql = "select  * from  spacial_student_disabled left join student_main_main on spacial_student_disabled.person_id=student_main_main.person_id where spacial_student_disabled.id='$_REQUEST[id]'";
$dbquery = mysqli_query($connect,$sql);
$result = mysqli_fetch_array($dbquery);

echo "<table width='50%' border='0' align='center'>";
echo "<tr align='center'><td><font color='#006666' size='3'><strong>ความช่วยเหลือนักเรียนที่มีความต้องการพิเศษ</strong></font></td></tr>";
echo "<tr align='center'><td><font color='#006666' size='3'>$result[prename]$result[name]&nbsp;&nbsp;$result[surname]</font></td></tr>";
echo "</table>";

//ส่วนแยกหน้า
$pagelen=15;  // 1_กำหนดแถวต่อหน้า
$url_link="option=spacial_student&task=student_sch_disable_report1&disable_type=$_REQUEST[disable_type]&index=9&id=$_REQUEST[id]&page2=$_GET[page2]";  // 2_กำหนดลิงค์ฺ

$sql = "select * from spacial_student_help1 where person_id='$result[person_id]' ";

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

if(($totalpages>1) and ($totalpages<16)){
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
if($totalpages>15){
			if($page <=8){
			$e_page=15;
			$s_page=1;
			}
			if($page>8){
					if($totalpages-$page>=7){
					$e_page=$page+7;
					$s_page=$page-7;
					}
					else{
					$e_page=$totalpages;
					$s_page=$totalpages-15;
					}
			}
			echo "<div align=center>";
			if($page!=1){
			$f_page1=$page-1;
			echo "<<a href=$PHP_SELF?$url_link&page=1>หน้าแรก </a>";
			echo "<<<a href=$PHP_SELF?$url_link&page=$f_page1>หน้าก่อน </a>";
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
			echo "<a href=$PHP_SELF?$url_link&page=$f_page2> หน้าถัดไป</a>>>";
			echo "<a href=$PHP_SELF?$url_link&page=$totalpages> หน้าสุดท้าย</a>>";
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

echo  "<table width=90% border='0' align='center'>";
echo "<Tr><td align='right'>";
echo "<INPUT TYPE='button' name='smb' value='<<กลับไปหน้ารายชื่อ' onclick='location.href=\"?option=spacial_student&task=student_sch_disable_report1&disable_type=$_REQUEST[disable_type]&page=$_GET[page2]\"'>";

echo "</td>";
echo "</table>";

echo  "<table width=90% border='0' align='center'>";
echo "<Tr bgcolor=#FFCCCC align='center' ><Td width='50'>ที่</Td><Td align='center' width='130'>วันช่วยเหลือ</Td><Td width='170'>ด้าน</Td><Td>เป้าประสงค์</Td><Td>วิธีดำเนินการ</Td><Td>ผลที่เกิดขึ้น</Td><Td width='100'>ภาพกิจกรรม</Td></Tr>";

	$sql2 = "select * from spacial_student_help1 where person_id='$result[person_id]' order by id limit $start,$pagelen";
	$dbquery2 = mysqli_query($connect,$sql2);
	$N=(($page-1)*$pagelen)+1;  //*เกี่ยวข้องกับการแยกหน้า
	$M=1;

	While ($result2 = mysqli_fetch_array($dbquery2)){
	if(($M%2) == 0)
	$color="#FFFFC";
	else  	$color="#FFFFFF";

echo "<Tr align='center' bgcolor='$color'><Td valign='top' align='center'>$N</Td><Td valign='top' align='left'>";
echo $result2['help_date'];
echo  "</Td><Td valign='top' align='left'>";
if($result2['help_type']==1){
echo "ด้านการแพทย์";
}
else if($result2['help_type']==2){
echo "ด้านการดำรงชีวิตและปัจจัย4";
}
else if($result2['help_type']==3){
echo "ด้านการศึกษา";
}
else if($result2['help_type']==4){
echo "ด้านสังคม";
}
else if($result2['help_type']==5){
echo "ด้านการงานอาชีพ";
}
else if($result2['help_type']==6){
echo "ด้านอื่น ๆ";
}
echo "</Td><Td valign='top' align='left'>$result2[purpose]</Td><Td valign='top' align='left'>$result2[operation]</Td><Td valign='top' align='left'>$result2[result]</Td>";

if($result2['pic']!=""){
echo "<Td align='center' valign='top'><a href='modules/spacial_student/pic_show2.php?pic=$result2[pic]' target='_blank'><img src=images/admin/user.gif border='0' alt='รูปภาพ'></a></Td>";
}
else{
echo "<Td align='center'>&nbsp;</Td>";
}
echo "</Tr>";
$M++;
$N++;  //*เกี่ยวข้องกับการแยกหน้า
	}
echo "</table>";
}

//ส่วนการแสดงผล
if(!(($index==5) or ($index==9))){
	if(!isset($_REQUEST['disable_type'])){
	$_REQUEST['disable_type']="";
}

//ส่วนของการแยกหน้า
$pagelen=15;  // 1_กำหนดแถวต่อหน้า
$url_link="option=spacial_student&task=student_sch_disable_report1&disable_type=$_REQUEST[disable_type]";  // 2_กำหนดลิงค์ฺ
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

if(($totalpages>1) and ($totalpages<16)){
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
if($totalpages>15){
			if($page <=8){
			$e_page=15;
			$s_page=1;
			}
			if($page>8){
					if($totalpages-$page>=7){
					$e_page=$page+7;
					$s_page=$page-7;
					}
					else{
					$e_page=$totalpages;
					$s_page=$totalpages-15;
					}
			}
			echo "<div align=center>";
			if($page!=1){
			$f_page1=$page-1;
			echo "<<a href=$PHP_SELF?$url_link&page=1>หน้าแรก </a>";
			echo "<<<a href=$PHP_SELF?$url_link&page=$f_page1>หน้าก่อน </a>";
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
			echo "<a href=$PHP_SELF?$url_link&page=$f_page2> หน้าถัดไป</a>>>";
			echo "<a href=$PHP_SELF?$url_link&page=$totalpages> หน้าสุดท้าย</a>>";
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

		echo  "<table width=90% border='0' align='center'>";
		echo "<Tr>";
		echo "<td align='right'>";
		echo "<form id='frm1' name='frm1'>";
//เลือกประเภทความพิการ
		echo "<Select  name='disable_type' size='1'>";
		echo  "<option value =''>ทุกประเภท</option>";
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

		echo "&nbsp;<INPUT TYPE='button' name='smb' value='เลือก' onclick='goto_index(2)' class=entrybutton>";
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

echo  "<table width=90% border='0' align='center'>";
echo "<Tr bgcolor=#FFCCCC align='center' ><Td width='50'>ที่</Td><Td align='center' width='200'>ชื่อ</Td><Td width='70'>เพศ</Td><Td width='70'>ชั้น</Td><Td width='50'>ห้อง</Td><Td>โรงเรียน</Td><Td>ประเภทความพกพร่อง</Td><Td width='60'>รูปภาพ</Td><Td width='60'>ข้อมูล<br>พื้นฐาน</Td><Td width='60'>ความ<br>ช่วยเหลือ</Td></Tr>";
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
echo "<Td align='left'>$result[prename]$result[name]&nbsp;&nbsp;&nbsp;$result[surname]</Td><Td align='center'>$result[sex]</Td>";
echo "<Td align='center'>$school_class_ar[$classlevel]</Td>";
echo "<Td align='center'>$result[classroom]</Td>";
echo "<Td align='left'>$result[school_name]</Td>";
echo "<Td align='left'>";
if($result['disable_type']>=1){
echo $disable_type_ar[$result['disable_type']];
}
echo "</Td>";
if($result['pic']!=""){
echo "<Td align='center'><a href='modules/spacial_student/pic_show.php?person_id=$result[person_id]' target='_blank'><img src=images/admin/user.gif border='0' alt='รูปภาพ'></a></Td>";
}
else{
echo "<Td align='center'>&nbsp;</Td>";
}
echo "<td><a href=?option=spacial_student&task=student_sch_disable_report1&index=5&id=$result[id]&disable_type=$_REQUEST[disable_type]&page=$page><img src=images/b_browse.png border='0' ></a></td>";
echo "<Td align='center'>";

$sql2 = "select  id from  spacial_student_help1 where person_id='$result[person_id]'";
$dbquery2 = mysqli_query($connect,$sql2);
if($result2 = mysqli_fetch_array($dbquery2)){
echo "<a href=?option=spacial_student&task=student_sch_disable_report1&index=9&id=$result[id]&disable_type=$_REQUEST[disable_type]&page2=$page><img src=images/b_browse.png border='0'></a>";
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
		callfrm("?option=spacial_student&task=student_sch_disable_report1&index=1");   // page ย้อนกลับ
		}
	if(val==2){
		callfrm("?option=spacial_student&task=student_sch_disable_report1");   // page ย้อนกลับ
		}
}

function goto_url_update(val){
	if(val==0){
		callfrm("?option=spacial_student&task=student_sch_disable_report1");   // page ย้อนกลับ
	}
}
</script>
