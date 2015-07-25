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
if(!(($index==1) or ($index==2) or ($index==5) or ($index==8) or ($index==8.5) or ($index==8.6) or ($index==8.7) or ($index==8.8) or ($index==9))){
echo "<table width='50%' border='0' align='center'>";
echo "<tr align='center'><td><font color='#006666' size='3'><strong>รายชื่อนักเรียนที่มีความต้องการพิเศษ ปีการศึกษา  $year_active_result[ed_year]</strong></font></td></tr>";
echo "</table>";
}

//ส่วนเพิ่มข้อมูล
if($index==1){
echo "<Center>";
echo "<Font color='#006666' Size=3><B>เลือกจากรายชื่อ</B></Font>";
echo "</Cener>";
echo "<Br><Br>";

//ส่วนของการแยกหน้า
$pagelen=50;  // 1_กำหนดแถวต่อหน้า
$url_link="option=spacial_student&task=student_sch_disable&class_index=$_REQUEST[class_index]&index=1";  // 2_กำหนดลิงค์ฺ
$sql = "select  * from  student_main_main ";

			if($_REQUEST['class_index']!=""){
			$sql .= "where ed_year='$year_active_result[ed_year]'  and  classlevel='$_REQUEST[class_index]' and school_code='$_SESSION[user_school]' ";
			}
			else{
			$sql .= "where ed_year='$year_active_result[ed_year]' and school_code='$_SESSION[user_school]' ";
			}

$dbquery = mysqli_query($connect,$sql);
$num_rows=mysqli_num_rows
($dbquery);
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
		echo "<Tr>";
		echo "<td align='right'>";
		echo "<form name='frm1'>";
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

		echo "&nbsp;<INPUT TYPE='button' name='smb' value='เลือกชั้น' onclick='goto_index(1)' class=entrybutton>";
		echo "</div>";
		echo "</td></Tr></Table>";
		//จบ

$sql = "select  * from  student_main_main ";

			if($_REQUEST['class_index']!=""){
			$sql .= "where ed_year='$year_active_result[ed_year]'  and  classlevel='$_REQUEST[class_index]' and school_code='$_SESSION[user_school]' ";
			}
			else{
			$sql .= "where ed_year='$year_active_result[ed_year]' and school_code='$_SESSION[user_school]' ";
			}

$sql .= " order by classlevel ,classroom, student_id limit $start,$pagelen";
$dbquery = mysqli_query($connect,$sql);
echo  "<table width=90% border='0' align='center'>";
echo "<Tr bgcolor=#FFCCCC align='center' ><Td width='50'>ที่</Td><Td width='90'>เลขประจำตัว<br>นักเรียน</Td><Td width='120'>เลขประจำตัว<br>ประชาชน</Td><Td align='center'>ชื่อ</Td><Td width='70'>เพศ</Td><Td width='70'>ชั้น</Td><Td width='50'>ห้อง</Td><Td width='200'>โรงเรียน</Td><Td width='140'>เลือกเป็นเด็กที่มี<br>ความต้องการพิเศษ</Td></Tr>";
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
echo "<td align='center'><input type='checkbox' name='$result[person_id]'></td>";
echo "</Tr>";
$M++;
$N++;  //*เกี่ยวข้องกับการแยกหน้า
	}

echo "</Table>";

echo "<Br>";
echo "<INPUT TYPE='button' name='smb' value='ตกลง' onclick='goto_url(1)'>
	&nbsp;&nbsp;<INPUT TYPE='button' name='back' value='ยกเลิก' onclick='goto_url(0)'>";
echo "</form>";
}

//ส่วนยืนยันการลบข้อมูล
if($index==2) {
echo "<table width='500' border='0' align='center'>";
echo "<tr><td align='center'><font color='#990000' size='4'>โปรดยืนยันความต้องการลบข้อมูลอีกครั้ง</font><br></td></tr>";
echo "<tr><td align=center>";
echo "<INPUT TYPE='button' name='smb' value='ยืนยัน' onclick='location.href=\"?option=spacial_student&task=student_sch_disable&index=3&id=$_GET[id]&disable_type=$_REQUEST[disable_type]&page=$_REQUEST[page]\"'>
		&nbsp;&nbsp;<INPUT TYPE='button' name='back' value='ยกเลิก' onclick='location.href=\"?option=spacial_student&task=student_sch_disable&disable_type=$_REQUEST[disable_type]&page=$_REQUEST[page]\"'";
echo "</td></tr></table>";
}

//ส่วนลบข้อมูล
if($index==3){
$sql = "delete from spacial_student_disabled where id=$_GET[id]";
$dbquery = mysqli_query($connect,$sql);
}

//ส่วนเพิ่มข้อมูล
if($index==4){
$rec_date = date("Y-m-d");

foreach($_POST as $key =>$value){
		if(!($key=='class_index' or $key=='year_index')){
				$sql = "select * from spacial_student_disabled where person_id='$key' and school_code='$_SESSION[user_school]' ";
				$dbquery = mysqli_query($connect,$sql);

				if(mysqli_num_rows
($dbquery)<1){
				$sql = "insert into spacial_student_disabled (person_id,school_code,officer,rec_date) values ( '$key','$_SESSION[user_school]','$officer','$rec_date')";
				$dbquery = mysqli_query($connect,$sql);
				}
		}
}  //foreach
}

//ส่วนฟอร์มแก้ไขข้อมูล
if ($index==5){
echo "<form Enctype = multipart/form-data id='frm1' name='frm1'>";
echo "<Center>";
echo "<Font color='#006666' Size=3><B>แก้ไขข้อมูล</B></Font>";
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
echo "<Tr align='left'><Td ></Td><Td align='right'><Font color='#006666'><b>รูปภาพ</b></font>&nbsp;&nbsp;&nbsp;&nbsp;</Td><Td><input type='file' name='userfile'></Td></Tr>";
echo "<Tr align='left'><Td ></Td><Td align='right'><Font color='#006666'><b>ความพกพร่อง</b></font>&nbsp;&nbsp;&nbsp;&nbsp;</Td><Td>";
echo "<Select  name='disable_type' size='1'>";
echo  "<option  value = ''>เลือก</option>" ;
		if($result['disable_type']==1){
		echo  "<option value ='1' selected>1.บกพร่องทางการการเห็น</option>";
		}else{
		echo  "<option value ='1'>1.บกพร่องทางการการเห็น</option>";
		}

		if($result['disable_type']==2){
		echo  "<option value ='2' selected>2.บกพร่องทางการการได้ยิน</option>";
		}
		else{
		echo  "<option value ='2'>2.บกพร่องทางการการได้ยิน</option>";
		}

		if($result['disable_type']==3){
		echo  "<option value ='3' selected>3.บกพร่องทางสติปัญญา</option>";
		}
		else{
		echo  "<option value ='3'>3.บกพร่องทางสติปัญญา</option>";
		}

		if($result['disable_type']==4){
		echo  "<option value ='4' selected>4.บกพร่องทางร่างกาย</option>";
		}
		else{
		echo  "<option value ='4'>4.บกพร่องทางร่างกาย</option>";
		}

		if($result['disable_type']==5){
		echo  "<option value ='5' selected>5.มีปัญหาทางการเรียนรู้</option>";
		}
		else{
		echo  "<option value ='5'>5.มีปัญหาทางการเรียนรู้</option>";
		}

		if($result['disable_type']==6){
		echo  "<option value ='6' selected>6.บกพร่องทางการพูดและภาษา</option>";
		}
		else{
		echo  "<option value ='6'>6.บกพร่องทางการพูดและภาษา</option>";
		}

		if($result['disable_type']==7){
		echo  "<option value ='7' selected>7.มีปัญหาทางพฤติกรรมหรืออารมณ์</option>";
		}
		else{
		echo  "<option value ='7'>7.มีปัญหาทางพฤติกรรมหรืออารมณ์</option>";
		}

		if($result['disable_type']==8){
		echo  "<option value ='8' selected>8.ออทิสติก</option>";
		}
		else{
		echo  "<option value ='8'>8.ออทิสติก</option>";
		}

		if($result['disable_type']==9){
		echo  "<option value ='9' selected>9.พิการซ้ำซ้อน</option>";
		}
		else{
		echo  "<option value ='9'>9.พิการซ้ำซ้อน</option>";
		}
echo "</select>";
echo "</Td></Tr>";
echo "<Tr align='left'><Td ></Td><Td align='right'><Font color='#006666'><b>รายละเอียดความพกพร่อง</b></font>&nbsp;&nbsp;&nbsp;&nbsp;</Td><Td><TEXTAREA NAME='disable_detail' ROWS='5' COLS='70'>$result[disable_detail]</TEXTAREA></Td></Tr>";
echo "<Tr align='left'><Td ></Td><Td align='right'><Font color='#006666'><b>ข้อมูลสำคัญอื่น ๆ</b></font>&nbsp;&nbsp;&nbsp;&nbsp;</Td><Td><TEXTAREA NAME='other' ROWS='7' COLS='70'>$result[other]</TEXTAREA></Td></Tr>";
echo "</Table>";
echo "<Br />";
echo "<Input Type=Hidden Name='person_id' Value='$result[person_id]'>";
echo "<Input Type=Hidden Name='id' Value='$_GET[id]'>";
echo "<Input Type=Hidden Name='page' Value='$_REQUEST[page]'>";
echo "<Input Type=Hidden Name='disable_type2' Value='$_REQUEST[disable_type]'>";
echo "<INPUT TYPE='button' name='smb' value='ตกลง' onclick='goto_url_update(1)' class=entrybutton>
		&nbsp;&nbsp;<INPUT TYPE='button' name='back' value='ย้อนกลับ' onclick='goto_url_update(0)'>";

echo "</form>";
}

if ($index==6){

$rec_date = date("Y-m-d");

//ฟังชั่นupload
function file_upload() {
		$uploaddir = 'modules/spacial_student/picture/';      //ที่เก็บไไฟล์
		$uploadfile = $uploaddir.basename($_FILES['userfile']['name']);
		$basename = basename($_FILES['userfile']['name']);

		$pic_code=$_POST['person_id'];
		//ลบไฟล์เดิม
		$exists_file=$uploaddir."1_".$pic_code.substr($basename,-4);
		if(file_exists($exists_file)){
		unlink($exists_file);
		}

		if (move_uploaded_file($_FILES['userfile']['tmp_name'],  $uploadfile))
			{
				$before_name  = $uploaddir.$basename;
				$changed_name = $uploaddir."1_".$pic_code.substr($basename,-4) ;
				rename("$before_name" , "$changed_name");

	 	//ลดขนาดภาพ
			if(substr($basename,-3)=="JPG" or substr($basename,-3)=="jpg"){
				$ori_file=$changed_name;
				$ori_size=getimagesize($ori_file);
				$ori_w=$ori_size[0];
				$ori_h=$ori_size[1];
					if($ori_w>600){
					$new_w=600;
					$new_h=round(($new_w/$ori_w)*$ori_h);
					$ori_img=imagecreatefromjpeg($ori_file);
					$new_img=imagecreatetruecolor($new_w, $new_h);
					imagecopyresized($new_img, $ori_img,0,0, 0,0, $new_w, $new_h, $ori_w, $ori_h);
					$new_file=$ori_file;
					imagejpeg($new_img, $new_file);
					imagedestroy($ori_img);
					imagedestroy($new_img);
					}
				}

			return  $changed_name;
			}
}

$basename = basename($_FILES['userfile']['name']);
		if($basename!=""){
		$changed_name = file_upload();
			if(!isset($changed_name)){
			$changed_name="";
			}
		$sql = "update spacial_student_disabled set disable_type='$_POST[disable_type]',
		disable_detail='$_POST[disable_detail]',
		other='$_POST[other]',
		pic='$changed_name',
		rec_date='$rec_date',
		officer='$officer'
		where id='$_POST[id]'";
		}
		else{
		$sql = "update spacial_student_disabled set disable_type='$_POST[disable_type]',
		disable_detail='$_POST[disable_detail]',
		other='$_POST[other]',
		rec_date='$rec_date',
		officer='$officer'
		where id='$_POST[id]'";
		}
$dbquery = mysqli_query($connect,$sql);
}

//ส่วนบันทึกการช่วยเหลือ
if($index==8){
echo "<form Enctype = multipart/form-data id='frm1' name='frm1'>";
echo "<Center>";
echo "<Font color='#006666' Size=3><B>บันทึกความช่วยเหลือ</B></Font>";
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
echo "<Tr align='left'><Td ></Td><Td align='right'><Font color='#006666'><b>วันช่วยเหลือ</b></font>&nbsp;&nbsp;&nbsp;&nbsp;</Td><Td><input type='text' name='help_date'></Td></Tr>";
echo "<Tr align='left'><Td ></Td><Td align='right'><Font color='#006666'><b>ด้านความช่วยเหลือ</b></font>&nbsp;&nbsp;&nbsp;&nbsp;</Td><Td>";
echo "<Select  name='help_type' size='1'>";
echo  "<option  value = ''>เลือก</option>" ;
		echo  "<option value ='1'>1.ด้านการแพทย์</option>";
		echo  "<option value ='2'>2.ด้านการดำรงชีวิตและปัจจัย4</option>";
		echo  "<option value ='3'>3.ด้านการศึกษา</option>";
		echo  "<option value ='4'>4.ด้านสังคม</option>";
		echo  "<option value ='5'>5.ด้านการงานอาชีพ</option>";
		echo  "<option value ='6'>6.ด้านอื่น ๆ</option>";
echo "</select>";
echo "</Td></Tr>";
echo "<Tr align='left'><Td ></Td><Td align='right'><Font color='#006666'><b>วัตถุประสงค์การช่วยเหลือครั้งนี้</b></font>&nbsp;&nbsp;&nbsp;&nbsp;</Td><Td><TEXTAREA NAME='purpose' ROWS='5' COLS='70'></TEXTAREA></Td></Tr>";
echo "<Tr align='left'><Td ></Td><Td align='right'><Font color='#006666'><b>วิธีดำเนินการ</b></font>&nbsp;&nbsp;&nbsp;&nbsp;</Td><Td><TEXTAREA NAME='operation' ROWS='7' COLS='70'></TEXTAREA></Td></Tr>";
echo "<Tr align='left'><Td ></Td><Td align='right'><Font color='#006666'><b>ผลที่เกิดขึ้น</b></font>&nbsp;&nbsp;&nbsp;&nbsp;</Td><Td><TEXTAREA NAME='result' ROWS='7' COLS='70'></TEXTAREA></Td></Tr>";
echo "<Tr align='left'><Td ></Td><Td align='right'><Font color='#006666'><b>ภาพกิจกรรม</b></font>&nbsp;&nbsp;&nbsp;&nbsp;</Td><Td><input type='file' name='userfile'></Td></Tr>";

echo "</Table>";
echo "<Br />";
echo "<Input Type=Hidden Name='person_id' Value='$result[person_id]'>";
echo "<Input Type=Hidden Name='disable_type' Value='$_GET[disable_type]'>";
echo "<Input Type=Hidden Name='id' Value='$_GET[id]'>";
echo "<Input Type=Hidden Name='page2' Value='$_GET[page2]'>";
echo "<INPUT TYPE='button' name='smb' value='ตกลง' onclick='goto_url_update(3)' class=entrybutton>
		&nbsp;&nbsp;<INPUT TYPE='button' name='back' value='ย้อนกลับ' onclick='goto_url_update(2)'>";
echo "</form>";
}

if($index==8.5){
$index=9;
$rec_date = date("Y-m-d");

//ฟังชั่นupload
function file_upload() {
		$uploaddir = 'modules/spacial_student/picture/';      //ที่เก็บไไฟล์
		$uploadfile = $uploaddir.basename($_FILES['userfile']['name']);
		$basename = basename($_FILES['userfile']['name']);

		$timestamp = time();
		$rand_number=rand();
		$pic_code= $_POST['person_id']."x".$timestamp."x".$rand_number;
		//ลบไฟล์เดิม
		$exists_file=$uploaddir."1_".$pic_code.substr($basename,-4);
		if(file_exists($exists_file)){
		unlink($exists_file);
		}

		if (move_uploaded_file($_FILES['userfile']['tmp_name'],  $uploadfile))
			{
				$before_name  = $uploaddir.$basename;
				$changed_name = $uploaddir."1_".$pic_code.substr($basename,-4) ;
				rename("$before_name" , "$changed_name");

		//ลดขนาดภาพ
			if(substr($basename,-3)=="JPG" or substr($basename,-3)=="jpg"){
				$ori_file=$changed_name;
				$ori_size=getimagesize($ori_file);
				$ori_w=$ori_size[0];
				$ori_h=$ori_size[1];
					if($ori_w>1000){
					$new_w=1000;
					$new_h=round(($new_w/$ori_w)*$ori_h);
					$ori_img=imagecreatefromjpeg($ori_file);
					$new_img=imagecreatetruecolor($new_w, $new_h);
					imagecopyresized($new_img, $ori_img,0,0, 0,0, $new_w, $new_h, $ori_w, $ori_h);
					$new_file=$ori_file;
					imagejpeg($new_img, $new_file);
					imagedestroy($ori_img);
					imagedestroy($new_img);
					}
				}

			return  $changed_name;
			}
}

		$basename = basename($_FILES['userfile']['name']);
		if ($basename!="")
		{
		$changed_name = file_upload();
		}
		if(!isset($changed_name)){
		$changed_name="";
		}
		$sql = "insert into spacial_student_help1 (person_id,school_code,help_date,help_type,purpose,operation,result,pic,officer,rec_date) values ('$_POST[person_id]', '$_SESSION[user_school]','$_POST[help_date]','$_POST[help_type]','$_POST[purpose]','$_POST[operation]','$_POST[result]','$changed_name','$officer','$rec_date')";
		$dbquery = mysqli_query($connect,$sql);
}

if($index==8.6){
$sql = "delete from spacial_student_help1 where id=$_GET[id]";
$dbquery = mysqli_query($connect,$sql);
$index=9;
$_GET['index_back']=1;
$_REQUEST['id']=$_GET['student_id'];
}

if($index==8.7){
echo "<form Enctype = multipart/form-data id='frm1' name='frm1'>";
echo "<Center>";
echo "<Font color='#006666' Size=3><B>แก้ไขบันทึกความช่วยเหลือ</B></Font>";
echo "</Cener>";
echo "<Br><Br>";

$sql = "select  * from  spacial_student_disabled left join student_main_main on spacial_student_disabled.person_id=student_main_main.person_id where spacial_student_disabled.id='$_GET[student_id]'";

$dbquery = mysqli_query($connect,$sql);
$result = mysqli_fetch_array($dbquery);

$sql2 = "select * from spacial_student_help1 where id=$_GET[id]";
$dbquery2 = mysqli_query($connect,$sql2);
$result2 = mysqli_fetch_array($dbquery2);

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
echo "<Tr align='left'><Td ></Td><Td align='right'><Font color='#006666'><b>วันช่วยเหลือ</b></font>&nbsp;&nbsp;&nbsp;&nbsp;</Td><Td><input type='text' name='help_date' value='$result2[help_date]'></Td></Tr>";
echo "<Tr align='left'><Td ></Td><Td align='right'><Font color='#006666'><b>ด้านความช่วยเหลือ</b></font>&nbsp;&nbsp;&nbsp;&nbsp;</Td><Td>";
echo "<Select  name='help_type' size='1'>";
echo  "<option  value = ''>เลือก</option>" ;
		if($result2['help_type']==1){
		echo  "<option value ='1' selected>1.ด้านการแพทย์</option>";
		}
		else{
		echo  "<option value ='1'>1.ด้านการแพทย์</option>";
		}
		if($result2['help_type']==2){
		echo  "<option value ='2' selected>2.ด้านการดำรงชีวิตและปัจจัย4</option>";
		}
		else {
		echo  "<option value ='2'>2.ด้านการดำรงชีวิตและปัจจัย4</option>";
		}
		if($result2['help_type']==3){
		echo  "<option value ='3' selected>3.ด้านการศึกษา</option>";
		}
		else{
		echo  "<option value ='3'>3.ด้านการศึกษา</option>";
		}
		if($result2['help_type']==4){
		echo  "<option value ='4' selected>4.ด้านสังคม</option>";
		}
		else{
		echo  "<option value ='4'>4.ด้านสังคม</option>";
		}
		if($result2['help_type']==5){
		echo  "<option value ='5' selected>5.ด้านการงานอาชีพ</option>";
		}
		else{
		echo  "<option value ='5'>5.ด้านการงานอาชีพ</option>";
		}
		if($result2['help_type']==6){
		echo  "<option value ='6' selected>6.ด้านอื่น ๆ</option>";
		}
		else{
		echo  "<option value ='6'>6.ด้านอื่น ๆ</option>";
		}
echo "</select>";
echo "</Td></Tr>";
echo "<Tr align='left'><Td ></Td><Td align='right'><Font color='#006666'><b>วัตถุประสงค์การช่วยเหลือครั้งนี้</b></font>&nbsp;&nbsp;&nbsp;&nbsp;</Td><Td><TEXTAREA NAME='purpose' ROWS='5' COLS='70'>$result2[purpose]</TEXTAREA></Td></Tr>";
echo "<Tr align='left'><Td ></Td><Td align='right'><Font color='#006666'><b>วิธีดำเนินการ</b></font>&nbsp;&nbsp;&nbsp;&nbsp;</Td><Td><TEXTAREA NAME='operation' ROWS='7' COLS='70'>$result2[operation]</TEXTAREA></Td></Tr>";
echo "<Tr align='left'><Td ></Td><Td align='right'><Font color='#006666'><b>ผลที่เกิดขึ้น</b></font>&nbsp;&nbsp;&nbsp;&nbsp;</Td><Td><TEXTAREA NAME='result' ROWS='7' COLS='70'>$result2[result]</TEXTAREA></Td></Tr>";
echo "<Tr align='left'><Td ></Td><Td align='right'><Font color='#006666'><b>ภาพกิจกรรม</b></font>&nbsp;&nbsp;&nbsp;&nbsp;</Td><Td><input type='file' name='userfile'></Td></Tr>";

echo "</Table>";
echo "<Br />";
echo "<Input Type=Hidden Name='person_id' Value='$result[person_id]'>";
echo "<Input Type=Hidden Name='help_id' Value='$_GET[id]'>";
echo "<Input Type=Hidden Name='disable_type' Value='$_GET[disable_type]'>";
echo "<Input Type=Hidden Name='page' Value='$_GET[page]'>";
echo "<Input Type=Hidden Name='page2' Value='$_GET[page2]'>";
echo "<Input Type=Hidden Name='id' Value='$_GET[student_id]'>";
echo "<INPUT TYPE='button' name='smb' value='ตกลง' onclick='goto_url_update(4)' class=entrybutton>";
echo "</form>";
}

if($index==8.8){
$rec_date = date("Y-m-d");
//ฟังชั่นupload
function file_upload() {
		$uploaddir = 'modules/spacial_student/picture/';      //ที่เก็บไไฟล์
		$uploadfile = $uploaddir.basename($_FILES['userfile']['name']);
		$basename = basename($_FILES['userfile']['name']);

		$timestamp = time();
		$rand_number=rand();
		$pic_code= $_POST['person_id']."x".$timestamp."x".$rand_number;
		//ลบไฟล์เดิม
		$exists_file=$uploaddir."1_".$pic_code.substr($basename,-4);
		if(file_exists($exists_file)){
		unlink($exists_file);
		}

		if (move_uploaded_file($_FILES['userfile']['tmp_name'],  $uploadfile))
			{
				$before_name  = $uploaddir.$basename;
				$changed_name = $uploaddir."1_".$pic_code.substr($basename,-4) ;
				rename("$before_name" , "$changed_name");

		//ลดขนาดภาพ
			if(substr($basename,-3)=="JPG" or substr($basename,-3)=="jpg"){
				$ori_file=$changed_name;
				$ori_size=getimagesize($ori_file);
				$ori_w=$ori_size[0];
				$ori_h=$ori_size[1];
					if($ori_w>1000){
					$new_w=1000;
					$new_h=round(($new_w/$ori_w)*$ori_h);
					$ori_img=imagecreatefromjpeg($ori_file);
					$new_img=imagecreatetruecolor($new_w, $new_h);
					imagecopyresized($new_img, $ori_img,0,0, 0,0, $new_w, $new_h, $ori_w, $ori_h);
					$new_file=$ori_file;
					imagejpeg($new_img, $new_file);
					imagedestroy($ori_img);
					imagedestroy($new_img);
					}
				}

			return  $changed_name;
			}
}

		$basename = basename($_FILES['userfile']['name']);
		if ($basename!="")
		{
		$changed_name = file_upload();
		}
		if(!isset($changed_name)){
		$changed_name="";
		}
		$sql = "update spacial_student_help1 set help_date='$_POST[help_date]',
		help_type='$_POST[help_type]',
		purpose='$_POST[purpose]',
		operation='$_POST[operation]',
		result='$_POST[result]',
		pic='$changed_name',
		rec_date='$rec_date',
		officer='$officer'
		where id='$_POST[help_id]'";
$dbquery = mysqli_query($connect,$sql);

$index=9;
$_GET['index_back']=1;
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
$url_link="option=spacial_student&task=student_sch_disable&disable_type=$_REQUEST[disable_type]&index=9&id=$_REQUEST[id]&page2=$_REQUEST[page2]";  // 2_กำหนดลิงค์ฺ

$sql = "select * from spacial_student_help1 where person_id='$result[person_id]' ";

$dbquery = mysqli_query($connect,$sql);
$num_rows=mysqli_num_rows
($dbquery);
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

echo  "<table width=95% border='0' align='center'>";
echo "<Tr><td align='left'><INPUT TYPE='button' name='smb' value='เพิ่มข้อมูลการช่วยเหลือ' onclick='location.href=\"?option=spacial_student&task=student_sch_disable&index=8&id=$_REQUEST[id]&disable_type=$_REQUEST[disable_type]&page2=$_REQUEST[page2]\"'></td><td align='right'>";
echo "<INPUT TYPE='button' name='smb' value='<<กลับหน้ารายชื่อ' onclick='location.href=\"?option=spacial_student&task=student_sch_disable&disable_type=$_REQUEST[disable_type]&page2=$_REQUEST[page2]\"'>";
echo "</td>";
echo "</table>";

echo  "<table width=95% border='0' align='center'>";
echo "<Tr bgcolor=#FFCCCC align='center' ><Td width='50'>ที่</Td><Td align='center' width='130'>วันช่วยเหลือ</Td><Td width='170'>ด้าน</Td><Td>เป้าประสงค์</Td><Td>วิธีดำเนินการ</Td><Td>ผลที่เกิดขึ้น</Td><Td width='100'>ภาพกิจกรรม</Td><Td align='center' width='100'>วันบันทึก</Td><Td width='120'>ผู้บันทึก</Td><Td width='60'>ลบ</Td><Td width='60'>แก้ไข</Td></Tr>";

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
echo "<td align='center' valign='top' >";
echo thai_date_3($result2['rec_date']);
echo "</td>";
echo "<td align='left' valign='top'>";
				$sql_person = "select * from person_main where person_id='$result2[officer]' ";
				$dbquery_person = mysqli_query($connect,$sql_person);
				$result_person = mysqli_fetch_array($dbquery_person);
				if(!$result_person){
				$sql_person= "select * from person_sch_main where person_id='$result2[officer]' ";
				$dbquery_person = mysqli_query($connect,$sql_person);
				$result_person = mysqli_fetch_array($dbquery_person);
				}
echo $result_person['prename'].$result_person['name']." ".$result_person['surname'];
echo "</td>";
if($result2['officer']==$officer){
echo "<Td valign='top' align='center'><a href=?option=spacial_student&task=student_sch_disable&index=8.6&id=$result2[id]&student_id=$_REQUEST[id]&disable_type=$_REQUEST[disable_type]&page=$page&page2=$_REQUEST[page2]><img src=images/drop.png border='0' alt='ลบ'></a></Td><Td valign='top' align='center'><a href=?option=spacial_student&task=student_sch_disable&index=8.7&id=$result2[id]&student_id=$_REQUEST[id]&disable_type=$_REQUEST[disable_type]&page=$page&page2=$_REQUEST[page2]><img src=images/edit.png border='0' alt='แก้ไข'></a></Td>";
}
else{
echo "<Td></td><Td></td>";
}
echo "</Tr>";
$M++;
$N++;  //*เกี่ยวข้องกับการแยกหน้า
	}


echo "</table>";
}

//ส่วนการแสดงผล
if(!(($index==1) or ($index==2) or ($index==5) or ($index==8) or ($index==8.5) or ($index==8.6) or ($index==8.7) or ($index==8.8) or ($index==9))){

if(!isset($_REQUEST['disable_type'])){
$_REQUEST['disable_type']="";
}
if(isset($_REQUEST['page2'])){
$_REQUEST['page']=$_REQUEST['page2'];
}
echo "<Input Type=Hidden Name='disable_type' Value='$_REQUEST[disable_type]'>";
if(isset($_POST['disable_type2'])){
$_REQUEST['disable_type']=$_POST['disable_type2'];
}

//ส่วนของการแยกหน้า
$pagelen=15;  // 1_กำหนดแถวต่อหน้า
$url_link="option=spacial_student&task=student_sch_disable&disable_type=$_REQUEST[disable_type]";  // 2_กำหนดลิงค์ฺ
if($_REQUEST['disable_type']!=""){
$sql = "select  * from  spacial_student_disabled left join student_main_main on spacial_student_disabled.person_id=student_main_main.person_id where  student_main_main.ed_year='$year_active_result[ed_year]' and spacial_student_disabled.disable_type='$_REQUEST[disable_type]' and student_main_main.school_code='$_SESSION[user_school]' and spacial_student_disabled.school_code='$_SESSION[user_school]' ";
}
else{
$sql = "select  * from  spacial_student_disabled left join student_main_main on spacial_student_disabled.person_id=student_main_main.person_id where  student_main_main.ed_year='$year_active_result[ed_year]' and student_main_main.school_code='$_SESSION[user_school]' and spacial_student_disabled.school_code='$_SESSION[user_school]' ";
}
$dbquery = mysqli_query($connect,$sql);
$num_rows=mysqli_num_rows
($dbquery);
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
		echo "<Tr><td align='left'><INPUT TYPE='button' name='smb' value='เพิ่มนักเรียนที่มีความต้องการพิเศษ' onclick='location.href=\"?option=spacial_student&task=student_sch_disable&index=1\"'></td>";
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
echo "<Tr bgcolor=#FFCCCC align='center' ><Td width='50'>ที่</Td><Td align='center'>ชื่อ</Td><Td width='70'>เพศ</Td><Td width='70'>ชั้น</Td><Td width='50'>ห้อง</Td><Td width='200'>โรงเรียน</Td><Td width='200'>ประเภทความพกพร่อง</Td><Td width='60'>รูปภาพ</Td><Td width='60'>ลบ</Td><Td width='60'>ข้อมูล<br>พื้นฐาน</Td><Td width='60'>ความ<br>ช่วยเหลือ</Td></Tr>";
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
echo "<td><a href=?option=spacial_student&task=student_sch_disable&index=2&id=$result[id]&disable_type=$_REQUEST[disable_type]&page=$page><img src=images/drop.png border='0' alt='ลบ'></a></td><td><a href=?option=spacial_student&task=student_sch_disable&index=5&id=$result[id]&disable_type=$_REQUEST[disable_type]&page=$page><img src=images/edit.png border='0' alt='แก้ไข'></a></td>";
echo "<Td align='center'><a href=?option=spacial_student&task=student_sch_disable&index=9&id=$result[id]&disable_type=$_REQUEST[disable_type]&page2=$page><img src=images/edit.png border='0' alt='บันทึกความช่วยเหลือ'></a></Td>";
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
		callfrm("?option=spacial_student&task=student_sch_disable&index=1");   // page ย้อนกลับ
		}
	if(val==2){
		callfrm("?option=spacial_student&task=student_sch_disable");   // page ย้อนกลับ
		}
}

function goto_url(val){
	if(val==0){
		callfrm("?option=spacial_student&task=student_sch_disable");
	}else if(val==1){
		callfrm("?option=spacial_student&task=student_sch_disable&index=4");
	}
}

function goto_url_update(val){
	if(val==0){
		callfrm("?option=spacial_student&task=student_sch_disable");   // page ย้อนกลับ
	}else if(val==1){
			callfrm("?option=spacial_student&task=student_sch_disable&index=6");   //page ประมวลผล
	}else if(val==2){
			callfrm("?option=spacial_student&task=student_sch_disable&index=9");   //page ประมวลผล
	}else if(val==3){
			if(frm1.help_date.value == ""){
			alert("กรุณากรอกวันช่วยเหลือ");
			}else if(frm1.help_type.value ==""){
			alert("กรุณาเลือกประเภทการช่วยเหลือ");
			}else if(frm1.purpose.value ==""){
			alert("กรุณากรอกเป้าประสงค์ในการช่วยเหลือ");
			}else if(frm1.operation.value ==""){
			alert("กรุณากรอกวิธีการดำเนินการช่วยเหลือ");
			}else if(frm1.result.value ==""){
			alert("กรุณากรอกผลที่เกิดขึ้นจากการช่วยเหลือ");
			}else{
			callfrm("?option=spacial_student&task=student_sch_disable&index=8.5");
			}
	}else if(val==4){
			if(frm1.help_date.value == ""){
			alert("กรุณากรอกวันช่วยเหลือ");
			}else if(frm1.help_type.value ==""){
			alert("กรุณาเลือกประเภทการช่วยเหลือ");
			}else if(frm1.purpose.value ==""){
			alert("กรุณากรอกเป้าประสงค์ในการช่วยเหลือ");
			}else if(frm1.operation.value ==""){
			alert("กรุณากรอกวิธีการดำเนินการช่วยเหลือ");
			}else if(frm1.result.value ==""){
			alert("กรุณากรอกผลที่เกิดขึ้นจากการช่วยเหลือ");
			}else{
			callfrm("?option=spacial_student&task=student_sch_disable&index=8.8");
			}
	}
}

</script>
