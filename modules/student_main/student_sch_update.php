<?php
/** ensure this file is being included by a parent file */
defined( '_VALID_' ) or die( 'Direct Access to this location is not allowed.' );
//sd page

$officer=$_SESSION['login_user_id'];

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
if(!(($index==1) or ($index==2) or ($index==5))){
echo "<table width='50%' border='0' align='center'>";
echo "<tr align='center'><td><font color='#006666' size='3'><strong>ปรับปรุงรายชื่อนักเรียน ปีการศึกษา  $year_active_result[ed_year]</strong></font></td></tr>";
echo "</table>";
}

//ส่วนเพิ่มข้อมูล
if($index==1){
echo "<form id='frm1' name='frm1'>";
echo "<Center>";
echo "<Font color='#006666' Size=3><B>เพิ่มข้อมูลนักเรียน</B></Font>";
echo "</Cener>";
echo "<Br><Br>";
echo "<Table width='60%' Border='0'>";
echo "<Tr align='left'><Td width=30></Td><Td align='right'>เลขประจำตัวนักเรียน&nbsp;&nbsp;&nbsp;&nbsp;</Td><Td><Input Type='Text' Name='student_id' Size='13' maxlenght='13' onkeydown='integerOnly()'></Td></Tr>";
echo "<Tr align='left'><Td width=30></Td><Td align='right'>เลขประจำตัวประชาชน&nbsp;&nbsp;&nbsp;&nbsp;</Td><Td><Input Type='Text' Name='person_id' Size='13' maxlenght='13' onkeydown='integerOnly()'></Td></Tr>";
echo "<Tr align='left'><Td width=30></Td><Td align='right'>คำนำหน้าชื่อ&nbsp;&nbsp;&nbsp;&nbsp;</Td><Td><Input Type='Text' Name='prename' Size='15'></Td></Tr>";
echo "<Tr align='left'><Td ></Td><Td align='right'>ชื่อ&nbsp;&nbsp;&nbsp;&nbsp;</Td><Td><Input Type='Text' Name='name'  Size='40'></Td></Tr>";
echo "<Tr align='left'><Td ></Td><Td align='right'>นามสกุล&nbsp;&nbsp;&nbsp;&nbsp;</Td><Td><Input Type='Text' Name='surname'  Size='40'></Td></Tr>";
echo "<Tr align='left'><Td ></Td><Td align='right'>เพศ&nbsp;&nbsp;&nbsp;&nbsp;</Td><Td>";
echo "<Select  name='sex' size='1'>";
echo  "<option  value = ''>เลือก</option>" ;
echo  "<option value ='ช'>ชาย</option>" ;
echo  "<option value ='ญ'>หญิง</option>" ;
echo "</select>";
echo "</Td></Tr>";

echo "<Tr align='left'><Td ></Td><Td align='right'>ชั้น&nbsp;&nbsp;&nbsp;&nbsp;</Td><Td>";
echo "<Select  name='classlevel' size='1'>";
echo  "<option  value = ''>เลือก</option>" ;
echo  "<option  value ='1'>อ.1(3ปี)</option>" ;
echo  "<option  value ='2'>อ.1</option>" ;
echo  "<option  value ='3'>อ.2</option>" ;
echo  "<option  value ='4'>ป.1</option>" ;
echo  "<option  value ='5'>ป.2</option>" ;
echo  "<option  value ='6'>ป.3</option>" ;
echo  "<option  value ='7'>ป.4</option>" ;
echo  "<option  value ='8'>ป.5</option>" ;
echo  "<option  value ='9'>ป.6</option>" ;
echo  "<option  value ='10'>ม.1</option>" ;
echo  "<option  value ='11'>ม.2</option>" ;
echo  "<option  value ='12'>ม.3</option>" ;
echo  "<option  value ='13'>ม.4</option>" ;
echo  "<option  value ='14'>ม.5</option>" ;
echo  "<option  value ='15'>ม.6</option>" ;
echo "</select>";
echo "</Td></Tr>";

echo "<Tr align='left'><Td ></Td><Td align='right'>ห้อง&nbsp;&nbsp;&nbsp;&nbsp;</Td><Td><Input Type='Text' Name='classroom'  Size='4' value='1'></Td></Tr>";

echo "<Br>";
echo "</Table>";
echo "<Br>";
echo "<INPUT TYPE='button' name='smb' value='ตกลง' onclick='goto_url(1)' class=entrybutton>
		&nbsp;&nbsp;<INPUT TYPE='button' name='back' value='ย้อนกลับ' onclick='goto_url(0)' class=entrybutton'>";

echo "</form>";
}

//ส่วนยืนยันการลบข้อมูล
if($index==2) {
echo "<table width='500' border='0' align='center'>";
echo "<tr><td align='center'><font color='#990000' size='4'>โปรดยืนยันความต้องการลบข้อมูลอีกครั้ง</font><br></td></tr>";
echo "<tr><td align=center>";
echo "<INPUT TYPE='button' name='smb' value='ยืนยัน' onclick='location.href=\"?option=student_main&task=student_sch_update&index=3&id=$_GET[id]&class_index=$_REQUEST[class_index]&page=$_REQUEST[page]\"'>
		&nbsp;&nbsp;<INPUT TYPE='button' name='back' value='ยกเลิก' onclick='location.href=\"?option=student_main&task=student_sch_update&class_index=$_REQUEST[class_index]&page=$_REQUEST[page]\"'";
echo "</td></tr></table>";
}

//ส่วนลบข้อมูล
if($index==3){
$sql = "delete from student_main_main where id=$_GET[id]";
$dbquery = mysqli_query($connect,$sql);
}

//ส่วนเพิ่มข้อมูล
if($index==4){
$rec_date = date("Y-m-d");

	$sql = "select * from student_main_main where  student_id='$_POST[student_id]' and ed_year='$year_active_result[ed_year]' and school_code='$_SESSION[user_school]'";
	$dbquery = mysqli_query($connect,$sql);

	if(mysqli_num_rows($dbquery)>=1){
	echo "<br /><div align='center'>มีเลขประจำตัวนักเรียนซ้ำกับรายการที่มีอยู่แล้ว ตรวจสอบอีกครั้ง</div>";
	exit();
	}

if($_POST['classroom']<1){
$_POST['classroom']=1;
}
$ref_id=$_SESSION['user_school'].$_POST['student_id'];

$sql = "insert into student_main_main (ed_year,ref_id,school_code,student_id,person_id,prename,name,surname,sex,school_name,classlevel,classroom,rec_date,officer) values ( '$year_active_result[ed_year]','$ref_id','$_SESSION[user_school]','$_POST[student_id]','$_POST[person_id]','$_POST[prename]','$_POST[name]','$_POST[surname]','$_POST[sex]','$_SESSION[system_school_name]','$_POST[classlevel]','$_POST[classroom]','$rec_date','$officer')";
$dbquery = mysqli_query($connect,$sql);
}

//ส่วนฟอร์มแก้ไขข้อมูล
if ($index==5){
echo "<form id='frm1' name='frm1'>";
echo "<Center>";
echo "<Font color='#006666' Size=3><B>แก้ไขข้อมูลนักเรียน</B></Font>";
echo "</Cener>";
echo "<Br><Br>";
$sql = "select * from  student_main_main where id='$_GET[id]'";
$dbquery = mysqli_query($connect,$sql);
$result = mysqli_fetch_array($dbquery);
echo "<Table width='60%' Border='0'>";
echo "<Tr align='left'><Td width=30></Td><Td align='right'>เลขประจำตัวนักเรียน&nbsp;&nbsp;&nbsp;&nbsp;</Td><Td><Input Type='Text' Name='student_id' Size='13' maxlenght='13' onkeydown='integerOnly()' value='$result[student_id]'></Td></Tr>";
echo "<Tr align='left'><Td width=30></Td><Td align='right'>เลขประจำตัวประชาชน&nbsp;&nbsp;&nbsp;&nbsp;</Td><Td><Input Type='Text' Name='person_id' Size='13' maxlenght='13' onkeydown='integerOnly()' value='$result[person_id]'></Td></Tr>";
echo "<Tr align='left'><Td width=30></Td><Td align='right'>คำนำหน้าชื่อ&nbsp;&nbsp;&nbsp;&nbsp;</Td><Td><Input Type='Text' Name='prename' Size='15'  value='$result[prename]'></Td></Tr>";
echo "<Tr align='left'><Td ></Td><Td align='right'>ชื่อ&nbsp;&nbsp;&nbsp;&nbsp;</Td><Td><Input Type='Text' Name='name'  Size='40' value='$result[name]'></Td></Tr>";
echo "<Tr align='left'><Td ></Td><Td align='right'>นามสกุล&nbsp;&nbsp;&nbsp;&nbsp;</Td><Td><Input Type='Text' Name='surname'  Size='40' value='$result[surname]'></Td></Tr>";
echo "<Tr align='left'><Td ></Td><Td align='right'>เพศ&nbsp;&nbsp;&nbsp;&nbsp;</Td><Td>";
echo "<Select  name='sex' size='1'>";
echo  "<option  value = ''>เลือก</option>" ;
if($result['sex']=='ช'){
echo  "<option value ='ช' selected>ชาย</option>" ;
}
else{
echo  "<option value ='ช'>ชาย</option>" ;
}
if($result['sex']=='ญ'){
echo  "<option value ='ญ' selected>หญิง</option>" ;
}
else{
echo  "<option value ='ญ'>หญิง</option>" ;
}

echo "</select>";
echo "</Td></Tr>";

echo "<Tr align='left'><Td ></Td><Td align='right'>ชั้น&nbsp;&nbsp;&nbsp;&nbsp;</Td><Td>";
echo "<Select  name='classlevel' size='1'>";
echo  "<option  value = ''>เลือก</option>" ;
if($result['classlevel']==1){
echo  "<option  value ='1' selected>อ.1(3ปี)</option>" ;
}
else{
echo  "<option  value ='1'>อ.1(3ปี)</option>" ;
}

if($result['classlevel']==2){
echo  "<option  value ='2' selected>อ.1</option>" ;
}
else{
echo  "<option  value ='2'>อ.1</option>" ;
}

if($result['classlevel']==3){
echo  "<option  value ='3' selected>อ.2</option>" ;
}
else{
echo  "<option  value ='3'>อ.2</option>" ;
}

if($result['classlevel']==4){
echo  "<option  value ='4' selected>ป.1</option>" ;
}
else{
echo  "<option  value ='4'>ป.1</option>" ;
}

if($result['classlevel']==5){
echo  "<option  value ='5' selected>ป.2</option>" ;
}
else{
echo  "<option  value ='5'>ป.2</option>" ;
}

if($result['classlevel']==6){
echo  "<option  value ='6' selected>ป.3</option>" ;
}
else{
echo  "<option  value ='6'>ป.3</option>" ;
}

if($result['classlevel']==7){
echo  "<option  value ='7' selected>ป.4</option>" ;
}
else{
echo  "<option  value ='7'>ป.4</option>" ;
}

if($result['classlevel']==8){
echo  "<option  value ='8' selected>ป.5</option>" ;
}
else{
echo  "<option  value ='8'>ป.5</option>" ;
}

if($result['classlevel']==9){
echo  "<option  value ='9' selected>ป.6</option>" ;
}
else{
echo  "<option  value ='9'>ป.6</option>" ;
}

if($result['classlevel']==10){
echo  "<option  value ='10' selected>ม.1</option>" ;
}
else{
echo  "<option  value ='10'>ม.1</option>" ;

}

if($result['classlevel']==11){
echo  "<option  value ='11' selected>ม.2</option>" ;
}
else{
echo  "<option  value ='11'>ม.2</option>" ;
}

if($result['classlevel']==12){
echo  "<option  value ='12' selected>ม.3</option>" ;
}
else{
echo  "<option  value ='12'>ม.3</option>" ;
}

if($result['classlevel']==13){
echo  "<option  value ='13' selected>ม.4</option>" ;
}
else{
echo  "<option  value ='13'>ม.4</option>" ;
}

if($result['classlevel']==14){
echo  "<option  value ='14' selected>ม.5</option>" ;
}
else{
echo  "<option  value ='14'>ม.5</option>" ;
}

if($result['classlevel']==15){
echo  "<option  value ='15' selected>ม.6</option>" ;
}
else{
echo  "<option  value ='15'>ม.6</option>" ;
}
echo "</select>";
echo "</Td></Tr>";

echo "<Tr align='left'><Td ></Td><Td align='right'>ห้อง&nbsp;&nbsp;&nbsp;&nbsp;</Td><Td><Input Type='Text' Name='classroom'  Size='4' value='$result[classroom]'></Td></Tr>";

echo "</Table>";
echo "<Br />";
echo "<Input Type=Hidden Name='id' Value='$_GET[id]'>";
echo "<Input Type=Hidden Name='class_index' Value='$_REQUEST[class_index]'>";
echo "<Input Type=Hidden Name='page' Value='$_REQUEST[page]'>";
echo "<INPUT TYPE='button' name='smb' value='ตกลง' onclick='goto_url_update(1)' class=entrybutton>
		&nbsp;&nbsp;<INPUT TYPE='button' name='back' value='ย้อนกลับ' onclick='goto_url_update(0)'>";

echo "</form>";
}

if ($index==6){
	$sql = "select * from student_main_main where  student_id='$_POST[student_id]' and ed_year='$year_active_result[ed_year]' and school_code='$_SESSION[user_school]' and id!='$_POST[id]' ";
	$dbquery = mysqli_query($connect,$sql);

	if(mysqli_num_rows($dbquery)>=1){
	echo "<br /><div align='center'>มีเลขประจำตัวนักเรียนซ้ำกับรายการที่มีอยู่แล้ว ตรวจสอบอีกครั้ง</div>";
	exit();
	}

$rec_date = date("Y-m-d");
$ref_id=$_SESSION['user_school'].$_POST['student_id'];
$sql = "update student_main_main set student_id='$_POST[student_id]',
ref_id='$ref_id',
person_id='$_POST[person_id]',
prename='$_POST[prename]',
name='$_POST[name]',
surname='$_POST[surname]',
sex='$_POST[sex]',
classlevel='$_POST[classlevel]',
classroom='$_POST[classroom]',
rec_date='$rec_date',
officer='$officer'
where id='$_POST[id]'";
$dbquery = mysqli_query($connect,$sql);
}

//ส่วนการแสดงผล
if(!(($index==1) or ($index==2) or ($index==5))){
//ส่วนของการแยกหน้า
$pagelen=50;  // 1_กำหนดแถวต่อหน้า
$url_link="option=student_main&task=student_sch_update&year_index=$_REQUEST[year_index]&class_index=$_REQUEST[class_index]";  // 2_กำหนดลิงค์ฺ
$sql = "select  * from  student_main_main ";

			if(($_REQUEST['school_index']=="") and ($_REQUEST['class_index']=="")){
			$sql .= "where ed_year='$year_active_result[ed_year]'  ";
			}
			else if(($_REQUEST['school_index']!="") and ($_REQUEST['class_index']!="")){
			$sql .= "where  ed_year='$year_active_result[ed_year]' and classlevel='$_REQUEST[class_index]' and  school_code='$_REQUEST[school_index]'  ";
			}
			else if($_REQUEST['school_index']!=""){
			$sql .= "where  ed_year='$year_active_result[ed_year]' and school_code='$_REQUEST[school_index]'  ";
			}
			else if($_REQUEST['class_index']!=""){
			$sql .= "where ed_year='$year_active_result[ed_year]'  and  classlevel='$_REQUEST[class_index]'  ";
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

 		//เลือกชั้น
		echo  "<table width=90% border='0' align='center'>";
		echo "<Tr><td align='left'><INPUT TYPE='button' name='smb' value='เพิ่มข้อมูล' onclick='location.href=\"?option=student_main&task=student_sch_update&index=1\"'></td>";
		echo "<td align='right'>";
		echo "<form id='frm1' name='frm1'>";
		echo "<div align='right'>";
		echo "<Select  name='class_index' size='1'>";

				if($_REQUEST['class_index']=='0'){
				$select_class_0="selected";
				}
				else if($_REQUEST['class_index']=='1'){
				$select_class_1="selected";
				}
				else if($_REQUEST['class_index']=='2'){
				$select_class_2="selected";
				}
				else if($_REQUEST['class_index']=='3'){
				$select_class_3="selected";
				}
				else if($_REQUEST['class_index']=='4'){
				$select_class_4="selected";
				}
				else if($_REQUEST['class_index']=='5'){
				$select_class_5="selected";
				}
				else if($_REQUEST['class_index']=='6'){
				$select_class_6="selected";
				}
				else if($_REQUEST['class_index']=='7'){
				$select_class_7="selected";
				}
				else if($_REQUEST['class_index']=='8'){
				$select_class_8="selected";
				}
				else if($_REQUEST['class_index']=='9'){
				$select_class_9="selected";
				}
				else if($_REQUEST['class_index']=='10'){
				$select_class_10="selected";
				}
				else if($_REQUEST['class_index']=='11'){
				$select_class_11="selected";
				}
				else if($_REQUEST['class_index']=='12'){
				$select_class_12="selected";
				}
				else if($_REQUEST['class_index']=='13'){
				$select_class_13="selected";
				}
				else if($_REQUEST['class_index']=='14'){
				$select_class_14="selected";
				}
				else if($_REQUEST['class_index']=='15'){
				$select_class_15="selected";
				}

		echo  "<option  value = ''>ทุกชั้น</option>" ;
		echo  "<option value =0 $select_class_0>ไม่ระบุชั้น</option>";
		echo  "<option value =1 $select_class_1>อ.1(3ปี)</option>";
		echo  "<option value =2 $select_class_2>อ.1</option>";
		echo  "<option value =3 $select_class_3>อ.2</option>";
		echo  "<option value =4 $select_class_4>ป.1</option>";
		echo  "<option value =5 $select_class_5>ป.2</option>";
		echo  "<option value =6 $select_class_6>ป.3</option>";
		echo  "<option value =7 $select_class_7>ป.4</option>";
		echo  "<option value =8 $select_class_8>ป.5</option>";
		echo  "<option value =9 $select_class_9>ป.6</option>";
		echo  "<option value =10 $select_class_10>ม.1</option>";
		echo  "<option value =11 $select_class_11>ม.2</option>";
		echo  "<option value =12 $select_class_12>ม.3</option>";
		echo  "<option value =13 $select_class_13>ม.4</option>";
		echo  "<option value =14 $select_class_14>ม.5</option>";
		echo  "<option value =15 $select_class_15>ม.6</option>";
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

$sql = "select  * from  student_main_main ";
$sql_count= "select  count(id) as student from student_main_main ";
$sql_gender= "select  count(sex) as gender from student_main_main ";

			if(($_REQUEST['school_index']=="") and ($_REQUEST['class_index']=="")){
			$sql .= "where ed_year='$year_active_result[ed_year]'  ";
			$sql2= "where ed_year='$year_active_result[ed_year]'  ";
			}
			else if(($_REQUEST['school_index']!="") and ($_REQUEST['class_index']!="")){
			$sql .= "where  ed_year='$year_active_result[ed_year]' and classlevel='$_REQUEST[class_index]' and  school_code='$_REQUEST[school_index]'  ";
			$sql2= "where  ed_year='$year_active_result[ed_year]' and classlevel='$_REQUEST[class_index]' and  school_code='$_REQUEST[school_index]'  ";
			}
			else if($_REQUEST['school_index']!=""){
			$sql .= "where  ed_year='$year_active_result[ed_year]' and school_code='$_REQUEST[school_index]'  ";
			$sql2= "where  ed_year='$year_active_result[ed_year]' and school_code='$_REQUEST[school_index]'  ";
			}
			else if($_REQUEST['class_index']!=""){
			$sql .= "where ed_year='$year_active_result[ed_year]'  and  classlevel='$_REQUEST[class_index]'  ";
			$sql2= "where ed_year='$year_active_result[ed_year]'  and  classlevel='$_REQUEST[class_index]'  ";
			}
$sql3=" and  sex like 'ช'  ";


$sql_count=$sql_count.$sql2;
$sql_gender=$sql_gender.$sql2.$sql3;

$sql .= " order by classlevel ,classroom, student_id limit $start,$pagelen";
$dbquery = mysqli_query($connect,$sql);
////ส่วนการนับ
$dbquery_count = mysqli_query($connect,$sql_count);
$result_count = mysqli_fetch_array($dbquery_count);
$dbquery_gender = mysqli_query($connect,$sql_gender);
$result_gender = mysqli_fetch_array($dbquery_gender);
////


echo  "<table width=90% border='0' align='center'>";
echo "<Tr bgcolor=#FFCCCC align='center' ><Td width='50'>ที่</Td><Td width='90'>เลขประจำตัว<br>นักเรียน</Td><Td width='120'>เลขประจำตัว<br>ประชาชน</Td><Td align='center'>ชื่อ</Td><Td width='70'>เพศ</Td><Td width='70'>ชั้น</Td><Td width='50'>ห้อง</Td><Td width='200'>โรงเรียน</Td><Td width='60'>ลบ</Td><Td width='60'>แก้ไข</Td></Tr>";
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
echo "<Tr  bgcolor=$color align='center'><Td>$N</Td><Td>$result[student_id]</Td><Td>$result[person_id]</Td>";
echo "<Td align='left'>$result[prename]$result[name]&nbsp;&nbsp;&nbsp;$result[surname]</Td><Td align='center'>$result[sex]</Td>";
echo "<Td align='center'>$school_class_ar[$classlevel]</Td>";
echo "<Td align='center'>$result[classroom]</Td>";
echo "<Td align='left'>$result[school_name]</Td>";
echo "<td><a href=?option=student_main&task=student_sch_update&index=2&id=$result[id]&class_index=$_REQUEST[class_index]&page=$page><img src=images/drop.png border='0' alt='ลบ'></a></td><td><a href=?option=student_main&task=student_sch_update&index=5&id=$result[id]&class_index=$_REQUEST[class_index]&page=$page><img src=images/edit.png border='0' alt='แก้ไข'></a></td>";
echo "</Tr>";
$M++;
$N++;  //*เกี่ยวข้องกับการแยกหน้า
	}

$total_f_gender=$result_count['student']-$result_gender['gender'];
$total_f_gender =number_format($total_f_gender,0);
$student = $result_count['student'];
$student=number_format($student,0);
$m_gender=$result_gender['gender'];
$m_gender=number_format($m_gender,0);
echo "<Tr bgcolor=#FFCCCC align='center' ><Td></Td><Td></Td><Td></Td><Td align='center'>รวมทั้งหมด $student คน</Td><Td colspan='3'>ชาย $m_gender หญิง ";
echo $total_f_gender ;
echo "</Td><Td colspan='3'></Td></Tr>";
echo "</Table>";
}

?>
<script>

function goto_index(val){
	if(val==1){
		callfrm("?option=student_main&task=student_sch_update");   // page ย้อนกลับ
		}
}

function goto_url(val){
	if(val==0){
		callfrm("?option=student_main&task=student_sch_update");   // page ย้อนกลับ
	}else if(val==1){
		if(frm1.student_id.value == ""){
			alert("กรุณากรอกเลขประจำตัวนักเรียน");
		}else if(frm1.prename.value==""){
			alert("กรุณากรอกคำนำหน้าชื่อ");
		}else if(frm1.name.value==""){
			alert("กรุณากรอกชื่อ");
		}else if(frm1.surname.value==""){
			alert("กรุณากรอกนามสกุล");
		}else if(frm1.sex.value==""){
			alert("กรุณาเลือกเพศ");
		}else if(frm1.classlevel.value==""){
			alert("กรุณาเลือกชั้น");
		}else{
			callfrm("?option=student_main&task=student_sch_update&index=4");   //page ประมวลผล
		}
	}
}

function goto_url_update(val){
	if(val==0){
		callfrm("?option=student_main&task=student_sch_update");   // page ย้อนกลับ
	}else if(val==1){
		if(frm1.student_id.value == ""){
			alert("กรุณากรอกเลขประจำตัวนักเรียน");
		}else if(frm1.prename.value==""){
			alert("กรุณากรอกคำนำหน้าชื่อ");
		}else if(frm1.name.value==""){
			alert("กรุณากรอกชื่อ");
		}else if(frm1.surname.value==""){
			alert("กรุณากรอกนามสกุล");
		}else if(frm1.sex.value==""){
			alert("กรุณาเลือกเพศ");
		}else if(frm1.classlevel.value==""){
			alert("กรุณาเลือกชั้น");
		}else{
			callfrm("?option=student_main&task=student_sch_update&index=6");   //page ประมวลผล
		}
	}
}

</script>
