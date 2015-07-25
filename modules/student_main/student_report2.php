<?php
/** ensure this file is being included by a parent file */
defined( '_VALID_' ) or die( 'Direct Access to this location is not allowed.' );
//sd page

if(!isset($_REQUEST['year_index'])){
$_REQUEST['year_index']="";
}
if(!isset($_POST['year_index'])){
$_POST['year_index']="";
}
if(!isset($_REQUEST['school_index'])){
$_REQUEST['school_index']="";
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

//ให้ผู้ใช้ระดับโรงเรียนเห็นข้อมูลโรงเรียนตนเองทันที
if(($_SESSION['login_status']>10) and ($_SESSION['login_status']<=14)){
	if (($_POST['year_index']=="")  and  ($_SESSION['user_school']!="")){
	$_REQUEST['school_index']=$_SESSION['user_school'];
	}
}
//อาเรย์สถานศึกษา
$sql = "select * from  system_school";
$dbquery = mysqli_query($connect,$sql);
While ($school_result = mysqli_fetch_array($dbquery)){
$school_code=$school_result['school_code'];
$school_ar[$school_code]=$school_result['school_name'];
}

//อาเรย์ชั้น
$school_class_ar[0]="0";
$school_class_ar[1]="01";
$school_class_ar[2]="02";
$school_class_ar[3]="03";
$school_class_ar[4]="04";
$school_class_ar[5]="05";
$school_class_ar[6]="06";
$school_class_ar[7]="07";
$school_class_ar[8]="08";
$school_class_ar[9]="09";
$school_class_ar[10]="10";
$school_class_ar[11]="11";
$school_class_ar[12]="12";
$school_class_ar[13]="13";
$school_class_ar[14]="14";
$school_class_ar[15]="15";

$school_class_ar2[0]="ไม่ระบุชั้น";
$school_class_ar2[1]="อนุบาล1(3ปี)";
$school_class_ar2[2]="อนุบาล 1";
$school_class_ar2[3]="อนุบาล 2";
$school_class_ar2[4]="ประถมศึกษาปีที่ 1";
$school_class_ar2[5]="ประถมศึกษาปีที่ 2";
$school_class_ar2[6]="ประถมศึกษาปีที่ 3";
$school_class_ar2[7]="ประถมศึกษาปีที่ 4";
$school_class_ar2[8]="ประถมศึกษาปีที่ 5";
$school_class_ar2[9]="ประถมศึกษาปีที่ 6";
$school_class_ar2[10]="มัธยมศึกษาปีที่ 1";
$school_class_ar2[11]="มัธยมศึกษาปีที่ 2";
$school_class_ar2[12]="มัธยมศึกษาปีที่ 3";
$school_class_ar2[13]="มัธยมศึกษาปีที่ 4";
$school_class_ar2[14]="มัธยมศึกษาปีที่ 5";
$school_class_ar2[15]="มัธยมศึกษาปีที่ 6";

echo "<br />";
echo "<table width='50%' border='0' align='center'>";
echo "<tr align='center'><td><font color='#006666' size='3'><strong>จำนวนนักเรียนจำแนกรายชั้น ปีการศึกษา  $year_active_result[ed_year]</strong></font></td></tr>";
echo "</table>";

	//เลือก	โรงเรียน
		echo  "<table width=70% border='0' align='center'>";
		echo "<Tr><td>";
		echo "<form id='frm1' name='frm1'>";
		echo "<div align='right'>";
			echo "<Select  name='school_index' size='1'>";
			echo  "<option  value = ''>ทุกโรงเรียน</option>" ;
		$sql = "select * from  system_school  order by school_type,school_code";
		$dbquery = mysqli_query($connect,$sql);
		While ($result = mysqli_fetch_array($dbquery))
		   {
		   			if($result['school_code']==$_REQUEST['school_index']){
					echo  "<option value = $result[school_code] selected>$result[school_code] $result[school_name]</option>";
					}
					else{
					echo  "<option value = $result[school_code]>$result[school_code] $result[school_name]</option>";
					}
			}
		echo "</select>";

//เลือกปีการศึกษา
		echo "<Select  name='year_index' size='1'>";
		$sql = "select * from  student_main_edyear  order by ed_year";
		$dbquery = mysqli_query($connect,$sql);
		While ($result = mysqli_fetch_array($dbquery))
		   {
		   			if(($result['year_active']==1) and ($_REQUEST['year_index']=="")){
					echo  "<option value = $result[ed_year] selected>ปีการศึกษา $result[ed_year]</option>";
					}
					else if($result['ed_year']==$_REQUEST['year_index']){
					echo  "<option value = $result[ed_year] selected>ปีการศึกษา $result[ed_year]</option>";
					}
					else{
					echo  "<option value = $result[ed_year]>ปีการศึกษา $result[ed_year]</option>";
					}
			}
		echo "</select>";

		echo "&nbsp;<INPUT TYPE='button' name='smb' value='เลือก' onclick='goto_index(1)' class=entrybutton>";
		echo "</div>";
		echo "</form>";
		echo "</td></Tr></Table>";
		//จบ

echo  "<table width=70% border='0' align='center'>";
echo "<Tr bgcolor=#FFCCCC align='center' ><Td width='25%'>ชั้น</Td><Td width='25%'>นักเรียนชาย</Td><Td width='25%'>นักเรียนหญิง</Td><Td width='25%'>รวม</Td></Tr>";
$M=1;
$total_m_gender=0;  //นักเรียนชายทั้งหมด
$total_f_gender=0;  //นักเรียนหญิงทั้งหมด
$total_student=0;  //นักเรียนรวมทุกชั้น
for ($i=0; $i<=15 ; $i++)	{

$sql = "select  count(id) as student from student_main_main  ";
			if($_REQUEST['school_index']=="") {
			$sql .= "where  classlevel=$school_class_ar[$i] and  ed_year='$year_active_result[ed_year]'  ";
			$sql_gender= "select  count(sex) as gender from student_main_main where  ed_year='$year_active_result[ed_year]' and  classlevel=$school_class_ar[$i] and  sex='ช'";
			}
			else{
			$sql .= "where  classlevel=$school_class_ar[$i] and ed_year='$year_active_result[ed_year]'  and  school_code='$_REQUEST[school_index]' ";
			$sql_gender= "select  count(sex) as gender from student_main_main where  ed_year='$year_active_result[ed_year]' and  classlevel=$school_class_ar[$i] and  sex='ช' and  school_code='$_REQUEST[school_index]'";
			}

$dbquery = mysqli_query($connect,$sql);
$result = mysqli_fetch_array($dbquery);
$dbquery_gender= mysqli_query($connect,$sql_gender);
$result_gender = mysqli_fetch_array($dbquery_gender);

		$student = $result['student'];
		$m_gender=$result_gender['gender'];
		$f_gender=$student-$m_gender;
		$total_m_gender +=$m_gender;
		$total_f_gender +=$f_gender;
		$total_student +=$student;

			if(($M%2) == 0)
			$color="#FFFFC";
			else  	$color="#FFFFFF";
$m_gender=number_format($m_gender,0);
$f_gender=number_format($f_gender,0);
if($student>0){
echo "<Tr  bgcolor=$color align='center'><Td align='left'>&nbsp;&nbsp;&nbsp;&nbsp;$school_class_ar2[$i]</Td><Td>$m_gender</Td><Td>$f_gender</Td>";
$student=number_format($student,0);
echo "<Td>$student</Td>";
echo "</Tr>";
$M++;}
} //loop for

		$total_m_gender =number_format($total_m_gender,0);
		$total_f_gender =number_format($total_f_gender,0);
		$total_student =number_format($total_student,0);

echo "<Tr bgcolor=#FFCCCC align='center' ><Td>รวมทั้งหมด</Td><Td>$total_m_gender</Td><Td align='center'> $total_f_gender</Td><Td>$total_student</Td></Tr>";
if($_REQUEST['school_index']!=""){
echo "<Tr  align='right' ><Td colspan='4'><a href='modules/student_main/export_to_excel.php?year_index=$_REQUEST[year_index]&school_index=$_REQUEST[school_index]' target='_blank'>ส่งออกรายชื่อนักเรียนเป็นไฟล์ Excel</a></Td></Tr>";
}
echo "</Table>";

?>
<script>

function goto_index(val){
	if(val==1){
		callfrm("?option=student_main&task=student_report2");
		}
}

</script>
