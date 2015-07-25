<?php
/** ensure this file is being included by a parent file */
defined( '_VALID_' ) or die( 'Direct Access to this location is not allowed.' );

?>
<script type="text/javascript" src="jquery/jquery-1.5.1.js"></script>
<script type="text/javascript">

$(function(){
	$("select#school_code").change(function(){
		var datalist2 = $.ajax({	// รับค่าจาก ajax เก็บไว้ที่ตัวแปร datalist2
			  url: "modules/spacial_student/return_permission_sch_khet.php", // ไฟล์สำหรับการกำหนดเงื่อนไข
			  data:"school_code="+$(this).val(), // ส่งตัวแปร GET ชื่อ school_code ให้มีค่าเท่ากับ ค่าของ school_code
			  async: false
		}).responseText;
		$("select#person_id").html(datalist2); // นำค่า datalist2 มาแสดงใน listbox ที่ 2 ที่ชื่อ person_id
		// ชื่อตัวแปร และ element ต่างๆ สามารถเปลี่ยนไปตามการกำหนด
	});
});
</script>

<?php

//อาเรย์ชื่อโรงเรียน
$sql = "select  * from  system_school ";
$dbquery = mysqli_query($connect,$sql);
While ($result = mysqli_fetch_array($dbquery))
   {
		$school_code = $result['school_code'];
		$school_ar[$school_code]= $result['school_name'];
	}

//ส่วนหัว
echo "<br />";
if(!(($index==1) or ($index==2) or ($index==5))){
echo "<table width='50%' border='0' align='center'>";
echo "<tr align='center'><td><font color='#006666' size='3'><strong>เจ้าหน้าที่นักเรียนพิเศษของโรงเรียน</strong></font></td></tr>";
echo "</table>";
}

//ส่วนฟอร์มรับข้อมูล
if($index==1){
echo "<form id='frm1' name='frm1'>";
echo "<Center>";
echo "<Font color='#006666' Size=3><B>เพิ่มเจ้าหน้าที่นักเรียนพิเศษให้สถานศึกษา</Font>";
echo "</Cener>";
echo "<Br><Br>";
echo "<Table width='80%' Border='0'>";
echo "<Tr align='left'><Td align='right' width='50%'>สถานศึกษา&nbsp;</Td><Td>";
echo "<Select  name='school_code'  id='school_code' size='1'>";
echo  "<option  value = ''>เลือก</option>" ;

$sql = "select * from  system_school  where school_type='1' order by school_type,school_code";
$dbquery = mysqli_query($connect,$sql);
While ($school_result = mysqli_fetch_array($dbquery)){
echo  "<option  value ='$school_result[school_code]'>$school_result[school_code] $school_result[school_name]</option>" ;
}
echo "</select>";
echo "</Td></Tr>";

echo "<Tr align='left'><Td align='right'>บุคลากร&nbsp;&nbsp;</Td><td align='left'>";
echo "<Select  name='person_id'  id='person_id' size='1' >";
echo  "<option  value = ''>เลือกสถานศึกษาก่อน</option>" ;
echo "</select>";
echo "</td></tr>";

echo "<tr><td></td><td></td></tr>";
echo "<tr><td align='right'><INPUT TYPE='button' name='smb' value='ตกลง' onclick='goto_url(1)' class=entrybutton>
	&nbsp;&nbsp;</td>";
echo "<td align='left'><INPUT TYPE='button' name='back' value='ย้อนกลับ' onclick='goto_url(0)' class=entrybutton'></td></tr>";
echo "</Table>";
echo "</form>";
}

//ส่วนยืนยันการลบข้อมูล
if($index==2) {
echo "<table width='500' border='0' align='center'>";
echo "<tr><td align='center'><font color='#990000' size='4'>โปรดยืนยันความต้องการลบข้อมูลอีกครั้ง</font><br></td></tr>";
echo "<tr><td align=center>";
echo "<INPUT TYPE='button' name='smb' value='ยืนยัน' onclick='location.href=\"?option=spacial_student&task=permission_sch_khet&index=3&id=$_GET[id]&page=$_REQUEST[page]\"'>
		&nbsp;&nbsp;<INPUT TYPE='button' name='back' value='ยกเลิก' onclick='location.href=\"?option=spacial_student&task=permission_sch_khet&page=$_REQUEST[page]\"'";
echo "</td></tr></table>";
}

//ส่วนลบข้อมูล
if($index==3){
$sql = "delete from spacial_student_permission where id=$_GET[id]";
$dbquery = mysqli_query($connect,$sql);
}

//ส่วนบันทึกข้อมูล
if($index==4){
$rec_date = date("Y-m-d");
$sql = "insert into spacial_student_permission (person_id, school_code, p2, officer,rec_date) values ('$_POST[person_id]', '$_POST[school_code]', '1','$_SESSION[login_user_id]','$rec_date')";
$dbquery = mysqli_query($connect,$sql);
}

//ส่วนฟอร์มแก้ไขข้อมูล
if ($index==5){
echo "<form id='frm1' name='frm1'>";
echo "<Center>";
echo "<Font color='#006666' Size=3><B>แก้ไข เจ้าหน้าที่</B></Font>";
echo "</Cener>";
echo "<Br><Br>";
echo "<Table width='90%' Border= '0' >";

$sql = "select * from spacial_student_permission where id='$_GET[id]'";
$dbquery = mysqli_query($connect,$sql);
$ref_result = mysqli_fetch_array($dbquery);
echo "<Tr align='left'><Td align='right' width='50%'>สถานศึกษา&nbsp;</Td><Td>";
echo "<Select  name='school_code'  id='school_code' size='1'>";
echo  "<option  value = ''>เลือก</option>" ;
$sql = "select * from  system_school  where  school_type='1' order by school_type,school_code";
$dbquery = mysqli_query($connect,$sql);
While ($school_result = mysqli_fetch_array($dbquery)){
			if($school_result['school_code']==$ref_result['school_code']){
			echo  "<option  value ='$school_result[school_code]' selected>$school_result[school_code] $school_result[school_name]</option>" ;
			}
			else{
			echo  "<option  value ='$school_result[school_code]'>$school_result[school_code] $school_result[school_name]</option>" ;
			}
}
echo "</select>";
echo "</Td></Tr>";
echo "<Tr><Td align='right'  width='50%'>บุคลากร&nbsp;&nbsp;</Td>";
echo "<td align='left'><Select  name='person_id'  id='person_id'  size='1'>";
echo  "<option  value = ''>เลือก</option>" ;
$sql = "select  * from person_sch_main where status='0'  and school_code='$ref_result[school_code]' order by position_code,name";
$dbquery = mysqli_query($connect,$sql);
while($result = mysqli_fetch_array($dbquery)){
		$person_id = $result['person_id'];
		$prename = $result['prename'];
		$name = $result['name'];
		$surname = $result['surname'];
			if($person_id==$ref_result[person_id]){
			echo  "<option value = $person_id selected>$prename$name $surname</option>";
			}
			else{
			echo  "<option value = $person_id>$prename$name $surname</option>";
			}
}

$sql = "select  * from person_sch_main left join person_sch_other on person_sch_main.person_id=person_sch_other.person_id where  person_sch_main.status='0' and person_sch_other.school_code='$ref_result[school_code]'";
$dbquery = mysqli_query($connect,$sql);
While ($result = mysqli_fetch_array($dbquery))
   {
		$person_id = $result['person_id'];
		$prename = $result['prename'];
		$name = $result['name'];
		$surname = $result['surname'];
		if($person_id==$ref_result['person_id']){
		echo  "<option value = $person_id selected>$prename$name $surname</option>";
		}
		else{
		echo  "<option value = $person_id>$prename$name $surname</option>";
		}
	}

echo "</select>";
echo "</td></tr>";

echo "<tr><td></td><td></td></tr>";
echo "<tr><td align='right'><INPUT TYPE='button' name='smb' value='ตกลง' onclick='goto_url_update(1)' class=entrybutton>&nbsp;&nbsp;</td>";
echo "<td align='left'><INPUT TYPE='button' name='back' value='ย้อนกลับ' onclick='goto_url_update(0)' class=entrybutton'></td></tr>";
echo "</Table>";
echo "<Br>";
echo "<Input Type=Hidden Name='id' Value='$_GET[id]'>";
echo "<Input Type=Hidden Name='page' Value='$_GET[page]'>";
echo "</form>";
}

//ส่วนปรับปรุงข้อมูล
if ($index==6){
$rec_date = date("Y-m-d");
$sql = "update spacial_student_permission set  person_id='$_POST[person_id]', school_code='$_POST[school_code]',  officer='$_SESSION[login_user_id]', rec_date='$rec_date' where id='$_POST[id]'";
$dbquery = mysqli_query($connect,$sql);
}

//ส่วนแสดงผล
if(!(($index==1) or ($index==2) or ($index==5))){

//ส่วนของการแยกหน้า
$pagelen=20;  // 1_กำหนดแถวต่อหน้า
$url_link="option=spacial_student&task=permission_sch_khet";  // 2_กำหนดลิงค์ฺ
$sql = "select spacial_student_permission.id from spacial_student_permission where spacial_student_permission.p2='1' ";
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

$sql = "select spacial_student_permission.id,  spacial_student_permission.officer, person_sch_main.prename,person_sch_main.name, person_sch_main.surname,spacial_student_permission.school_code from spacial_student_permission left join person_sch_main on spacial_student_permission.person_id=person_sch_main.person_id  where spacial_student_permission.p2='1' order by spacial_student_permission.school_code, spacial_student_permission.id  limit $start,$pagelen";
$dbquery = mysqli_query($connect,$sql);
echo  "<table width=70% border=0 align=center>";
echo "<Tr><Td colspan='5' align='left'><INPUT TYPE='button' name='smb' value='เพิ่มเจ้าหน้าที่' onclick='location.href=\"?option=spacial_student&task=permission_sch_khet&index=1\"'</Td></Tr>";

echo "<Tr bgcolor='#FFCCCC'><Td  align='center'>ที่</Td><Td  align='center'>โรงเรียน</Td><Td  align='center'>ชื่อเจ้าหน้าที่</Td><Td align='center' width='180'>ผู้กำหนดเจ้าหน้าที่</Td><Td align='center' width='50'>ลบ</Td><Td align='center'  width='50'>แก้ไข</Td></Tr>";
$N=(($page-1)*$pagelen)+1;  //*เกี่ยวข้องกับการแยกหน้า
$M=1;
While ($result = mysqli_fetch_array($dbquery))
	{
		$id = $result['id'];
		$prename = $result['prename'];
		$name = $result['name'];
		$surname = $result['surname'];
		$rec_person = $result['officer'];
		$school_code = $result['school_code'];
					///////////////////
					$person_level=0;
					$sql_person = "select  * from person_main  where person_id='$rec_person'";
					$dbquery_person = mysqli_query($connect,$sql_person);
					if($result_person = mysqli_fetch_array($dbquery_person)){
					$person_level=1;  //สพท.
					}
					else{
					$sql_person = "select  * from person_sch_main  where person_id='$rec_person'";
					$dbquery_person = mysqli_query($connect,$sql_person);
					$result_person = mysqli_fetch_array($dbquery_person);
					$person_level=2;   //โรงเรียน
					}
					////////////////////

			if(($M%2) == 0)
			$color="#FFFFC";
			else  	$color="#FFFFFF";
		echo "<Tr bgcolor=$color><Td align='center' width='50'>$N</Td><Td  align='left'>$school_code $school_ar[$school_code]</Td><Td  align='left'>$prename$name $surname</Td><td>$result_person[prename]$result_person[name] $result_person[surname]</td>";
		if($person_level==1){
		echo "<Td align='center' width='50' ><a href=?option=spacial_student&task=permission_sch_khet&index=2&id=$id&page=$page><img src=images/drop.png border='0' alt='ลบ'></a></Td>
		<Td align='center' width='50'><a href=?option=spacial_student&task=permission_sch_khet&index=5&id=$id&page=$page><img src=images/edit.png border='0' alt='แก้ไข'></a></Td>";
		}
		else{
		echo "<td></td><td></td>";
		}
		echo "</Tr>";
$M++;
$N++;  //*เกี่ยวข้องกับการแยกหน้า
	}
echo "</Table>";
}

?>
<script>
function goto_url(val){
	if(val==0){
		callfrm("?option=spacial_student&task=permission_sch_khet");   // page ย้อนกลับ
	}else if(val==1){
		if(frm1.school_code.value == ""){
			alert("กรุณาเลือกสถานศึกษา");
		}else if(frm1.person_id.value == ""){
			alert("กรุณาเลือกบุคลากร");
		}else{
			callfrm("?option=spacial_student&task=permission_sch_khet&index=4");   //page ประมวลผล
		}
	}
}

function goto_url_update(val){
	if(val==0){
		callfrm("?option=spacial_student&task=permission_sch_khet");   // page ย้อนกลับ
	}else if(val==1){
		if(frm1.school_code.value == ""){
			alert("กรุณาเลือกสถานศึกษา");
		}else if(frm1.person_id.value == ""){
			alert("กรุณาเลือกบุคลากร");
		}else{
			callfrm("?option=spacial_student&task=permission_sch_khet&index=6");   //page ประมวลผล
		}
	}
}
</script>
