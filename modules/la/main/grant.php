<?php
/** ensure this file is being included by a parent file */
defined( '_VALID_' ) or die( 'Direct Access to this location is not allowed.' );
require_once "modules/la/time_inc.php";

?>
<script type="text/javascript" src="./css/js/calendarDateInput.js"></script>
<?php

$user=$_SESSION['login_user_id'];

if(!isset($_POST['no_comment'])){
$_POST['no_comment']="";
}

//ส่วนหัว
echo "<br />";
if(!(($index==1) or ($index==5) or ($index==7))){

echo "<table width='100%' border='0' align='center'>";
echo "<tr align='center'><td><font color='#006666' size='3'><strong>อนุม้ติ/คำสั่ง ของผู้บังคับบัญชา</strong></font></td></tr>";
echo "<tr align='center'><td><font color='#006666' size='2'><strong>ทะเบียนการลา</strong></font></td></tr>";
echo "</table>";
}

$sql_name = "select * from person_main";
$dbquery_name = mysqli_query($connect,$sql_name);
While ($result_name = mysqli_fetch_array($dbquery_name)){
		$person_id = $result_name['person_id'];
		$prename=$result_name['prename'];
		$name= $result_name['name'];
		$surname = $result_name['surname'];
		$position_code = $result_name['position_code'];
$full_name_ar[$person_id]="$prename$name&nbsp;&nbsp;$surname";
}

//ส่วนบันทึกข้อมูล
if(!isset($_POST['allchk'])){
$_POST['allchk']="";
}

if($index==4){
$date_time_now = date("Y-m-d H:i:s");
	foreach($_POST as $key => $value){
		if($key!=$_POST['allchk']){
		$sql = "update la_main set commander_grant='$value', commander_sign='$_SESSION[login_user_id]', grant_date='$date_time_now' where id='$key'";
		$dbquery = mysqli_query($connect,$sql);
		}
	}
}

//ส่วนฟอร์มแก้ไขข้อมูล
if ($index==5){
echo "<form Enctype = multipart/form-data id='frm1' name='frm1'>";
echo "<Center>";
echo "<Font color='#006666' Size=3><B>อนุม้ติ/คำสั่ง ของผู้บังคับบัญชา</B></Font>";
echo "</Cener>";
echo "<Br><Br>";
echo "<Table width='95%' Border='0'>";

$sql = "select * from la_main where id='$_GET[id]'";
$dbquery = mysqli_query($connect,$sql);
$ref_result = mysqli_fetch_array($dbquery);
$id=$ref_result['id'];
$person_id=$ref_result['person_id'];
$la_type=$ref_result['la_type'];
$grant_p_selected=$ref_result['grant_p_selected'];
$rec_date=$ref_result['rec_date'];
//สพท
$sql_person = "select * from  person_main where person_id='$ref_result[person_id]' ";
$dbquery_person = mysqli_query($connect,$sql_person);
$result_person = mysqli_fetch_array($dbquery_person);
$fullname=$result_person['prename'].$result_person['name']." ".$result_person['surname'];
$position=$result_person['position_code'];
$sql = "select * from  person_position where position_code='$position'";
$dbquery = mysqli_query($connect,$sql);
$result = mysqli_fetch_array($dbquery);
$position_name=$result['position_name'];
		//โรงเรียน
		if(!$result_person){
		$sql_person = "select * from  person_sch_main left join system_school on person_sch_main.school_code=system_school.school_code where person_id='$person_id' ";
		$dbquery_person = mysqli_query($connect,$sql_person);
		$result_person = mysqli_fetch_array($dbquery_person);
		$fullname=$result_person['prename'].$result_person['name']." ".$result_person['surname']." "."(".$result_person['school_name'].")";
		$position=$result_person['position_code'];
		$sql = "select * from  person_sch_position where position_code='$position'";
		$dbquery = mysqli_query($connect,$sql);
		$result = mysqli_fetch_array($dbquery);
		$position_name=$result['position_name'];
		}

		echo "<Tr align='left'><Td align='right'>วันที่&nbsp;&nbsp;</Td><Td>";
		echo thai_date_4($rec_date);
		echo "</Td></Tr>";
		if($la_type<4){
		echo "<Tr align='left'><Td align='right'>เขียนที่&nbsp;&nbsp;</Td><Td><Input Type='Text' Name='write_at' Size='30' value='$ref_result[write_at]'></Td></Tr>";
		$check1=""; $check2=""; $check3="";
		if($ref_result['la_type']==1){
		$check1="checked";
		}
		else if($ref_result['la_type']==2){
		$check2="checked";
		}
		else if($ref_result['la_type']==3){
		$check3="checked";
		}
		echo "<Tr align='left'><Td align='right'>เรื่อง&nbsp;&nbsp;</Td><Td><Input Type='radio' Name='la_type' value='1' $check1>ลาป่วย&nbsp;&nbsp;<Input Type='radio' Name='la_type' value='2' $check2>ลากิจ&nbsp;&nbsp;<Input Type='radio' Name='la_type' value='3' $check3>ลาคลอด</Td></Tr>";

		echo "<Tr align='left'><Td align='right'>เรียน&nbsp;&nbsp;</Td><Td>ผู้อำนวยการ$_SESSION[office_name]</Td></Tr>";

		echo "<Tr align='left'><Td align='right'>ข้าพเจ้า&nbsp;&nbsp;</Td><Td>$fullname&nbsp;&nbsp;ตำแหน่ง&nbsp;&nbsp;$position_name</Td></Tr>";

		echo "<Tr align='left'><Td align='right'>เนื่องจาก&nbsp;&nbsp;</Td><Td><Input Type='Text' Name='because' Size='60' value='$ref_result[because]'></Td></Tr>";

		echo "<Tr align='left'><Td align='right'>ขอลาตั้งแต่วันที่&nbsp;&nbsp;</Td>";

		echo "<Td align='left'>";
		$la_start=explode("-", $ref_result['la_start']);
		?>
		<script>
										var Y_date=<?php echo $la_start[0]?>
										var m_date=<?php echo $la_start[1]?>
										var d_date=<?php echo $la_start[2]?>
										Y_date= Y_date+'/'+m_date+'/'+d_date
										DateInput('la_start', true, 'YYYY-MM-DD', Y_date)</script>
		<?php

		echo "</Td></Tr>";

		echo "<Tr align='left'><Td align='right'>ถึงวันที่&nbsp;&nbsp;</Td>";

		echo "<Td align='left'>";
		$la_finish=explode("-", $ref_result['la_finish']);
		?>
		<script>
										var Y_date=<?php echo $la_finish[0]?>
										var m_date=<?php echo $la_finish[1]?>
										var d_date=<?php echo $la_finish[2]?>
										Y_date= Y_date+'/'+m_date+'/'+d_date
										DateInput('la_finish', true, 'YYYY-MM-DD', Y_date)</script>
		<?php
		echo "</Td></Tr>";

		echo "<Tr align='left'><Td align='right'>&nbsp;</Td>";

		echo "<Td>มีกำหนด&nbsp;&nbsp;<Input Type='Text' Name='la_total' Size='5' value='$ref_result[la_total]'>&nbsp;&nbsp;วัน";

		echo "<Tr align='left'><Td align='right'>ลาครั้งสุดท้ายตั้งแต่วันที่&nbsp;&nbsp;</Td>";
		echo "<Td align='left'>";
		$last_la_start=explode("-", $ref_result['last_la_start']);
		?>
		<script>
										var Y_date=<?php echo $last_la_start[0]?>
										var m_date=<?php echo $last_la_start[1]?>
										var d_date=<?php echo $last_la_start[2]?>
										Y_date= Y_date+'/'+m_date+'/'+d_date
										DateInput('last_la_start', true, 'YYYY-MM-DD', Y_date)</script>
		<?php
		echo "</Td></Tr>";

		echo "<Tr align='left'><Td align='right'>ถึงวันที่&nbsp;&nbsp;</Td>";
		echo "<Td align='left'>";
		$last_la_finish=explode("-", $ref_result['last_la_finish']);
		?>
		<script>
										var Y_date=<?php echo $last_la_finish[0]?>
										var m_date=<?php echo $last_la_finish[1]?>
										var d_date=<?php echo $last_la_finish[2]?>
										Y_date= Y_date+'/'+m_date+'/'+d_date
										DateInput('last_la_finish', true, 'YYYY-MM-DD', Y_date)</script>
		<?php
		echo "<Tr align='left'><Td align='right'>&nbsp;</Td>";
		echo "<Td>มีกำหนด&nbsp;&nbsp;<Input Type='Text' Name='last_la_total' Size='5' value='$ref_result[last_la_total]'>&nbsp;&nbsp;วัน";


		echo "<Tr align='left'><Td align='right'>ระหว่างลาติดต่อได้ที่&nbsp;&nbsp;</Td><Td><Input Type='Text' Name='contact' Size='60' value='$ref_result[contact]'>&nbsp;&nbsp;เบอร์โทรศัำพท์&nbsp;&nbsp;<Input Type='Text' Name='contact_tel'  Size='10' value='$ref_result[contact_tel]'></Td></Tr>";

if($ref_result['no_comment']==1){
$no_comment_select="checked";
}
else{
$no_comment_select="";
}
echo "<Tr align='left'><Td align='right'>ไม่ต้องผ่านผู้บังคับบัญชาขั้นต้น&nbsp;&nbsp;</Td><Td><input type='checkbox'  name='no_comment' id='no_comment' value='1' $no_comment_select>&nbsp;&nbsp;(เลือกกรณีผู้บังคับบัญชาขั้นต้นไม่ได้ปฏิบัติราชการ)</Td></Tr>";

		echo "<Tr align='left'><Td align='right'>เลือกผู้อนุมัติ (ปกติไม่ต้องเลือก)&nbsp;&nbsp;</Td><Td><Select  name='grant_p_selected'  size='1'>";
		echo  "<option  value = ''>เลือก</option>" ;
		$sql = "select * from person_main where status='0' and (position_code='1' or position_code='2') order by position_code,person_order";
		$dbquery = mysqli_query($connect,$sql);
		While ($result = mysqli_fetch_array($dbquery))
		   {
				$person_id = $result['person_id'];
				$name = $result['name'];
				$surname = $result['surname'];
				if($person_id==$ref_result['grant_p_selected']){
				echo  "<option value = $person_id selected>$name $surname</option>";
				}
				else{
				echo  "<option value = $person_id>$name $surname</option>";
				}
			}
		echo "</select>";
		echo "&nbsp;&nbsp;(ใช้กรณีผู้อนุมัติิปกติไม่อยู่  เช่น รองผอ.สพท. ซึ่งเป็นผู้อนุมัติกลุ่มนี้ไม่อยู่ เป็นต้น) </Td></Tr>";

		echo "<Tr align='left'><Td align='right'>&nbsp;</Td><Td>";

		echo "<table><tr><td>";
		echo "<fieldset>";
		echo "<legend>&nbsp;<B>สถิติการลาในปีงบประมาณนี้</B>: &nbsp;</legend>";
		echo "<table border='1'>";
		echo "<tr align='center'><td>ประเภทการลา</td><td>ลามาแล้ว<br>(วันทำการ)</td><td>ลาครั้งนี้<br>(วันทำการ)</td><td>รวมเป็น<br>(วันทำการ)</td></tr>";

		echo "<tr align='center'><td>ป่วย</td><td><Input Type='Text' Name='sick_ago' Size='5'  value='$ref_result[sick_ago]'></td><td><Input Type='Text' Name='sick_this' Size='5'  value='$ref_result[sick_this]'></td><td><Input Type='Text' Name='sick_total' Size='5' value='$ref_result[sick_total]'></td></tr>";

		echo "<tr align='center'><td>กิจส่วนตัว</td><td><Input Type='Text' Name='privacy_ago' Size='5' value='$ref_result[privacy_ago]'></td><td><Input Type='Text' Name='privacy_this' Size='5' value='$ref_result[privacy_this]'></td><td><Input Type='Text' Name='privacy_total' Size='5' value='$ref_result[privacy_total]'></td></tr>";

		echo "<tr align='center'><td>คลอดบุตร</td><td><Input Type='Text' Name='birth_ago' Size='5' value='$ref_result[birth_ago]'></td><td><Input Type='Text' Name='birth_this' Size='5' value='$ref_result[birth_this]'></td><td><Input Type='Text' Name='birth_total' Size='5' value='$ref_result[birth_total]'></td></tr>";
		echo "</table>";
		echo "</fieldset></td></tr></table>";
		echo "</Td></tr>";
		}
		if($la_type==4){
		echo "<Tr align='left'><Td align='right'>เขียนที่&nbsp;&nbsp;</Td><Td><Input Type='Text' Name='write_at' Size='30' value='$ref_result[write_at]'></Td></Tr>";

		echo "<Tr align='left'><Td align='right'>เรื่อง&nbsp;&nbsp;</Td><Td>ลาพักผ่อน</Td></Tr>";

		echo "<Tr align='left'><Td align='right'>เรียน&nbsp;&nbsp;</Td><Td>ผู้อำนวยการ$_SESSION[office_name]</Td></Tr>";

		echo "<Tr align='left'><Td align='right'>ข้าพเจ้า&nbsp;&nbsp;</Td><Td>$fullname&nbsp;&nbsp;ตำแหน่ง&nbsp;&nbsp;$position_name</Td></Tr>";

		echo "<Tr align='left'><Td align='right'>&nbsp;</Td>";

		echo "<Td>มีวันลาพักผ่อนสะสม&nbsp;&nbsp;<Input Type='Text' Name='relax_collect' Size='5' value='$ref_result[relax_collect]'>&nbsp;&nbsp;วันทำการ และประจำปีอีก 10 วันทำการ รวมเป็น&nbsp;&nbsp;<Input Type='Text' Name='relax_this_year' Size='5' value='$ref_result[relax_this_year]'>&nbsp;&nbsp;วันทำการ";

		echo "<Tr align='left'><Td align='right'>ขอลาตั้งแต่วันที่&nbsp;&nbsp;</Td>";
		echo "<Td align='left'>";
		$la_start=explode("-", $ref_result['la_start']);
		?>
		<script>
										var Y_date=<?php echo $la_start[0]?>
										var m_date=<?php echo $la_start[1]?>
										var d_date=<?php echo $la_start[2]?>
										Y_date= Y_date+'/'+m_date+'/'+d_date
										DateInput('la_start', true, 'YYYY-MM-DD', Y_date)</script>
		<?php
		echo "</Td></Tr>";

		echo "<Tr align='left'><Td align='right'>ถึงวันที่&nbsp;&nbsp;</Td>";
		echo "<Td align='left'>";
		$la_finish=explode("-", $ref_result['la_finish']);
		?>
		<script>
										var Y_date=<?php echo $la_finish[0]?>
										var m_date=<?php echo $la_finish[1]?>
										var d_date=<?php echo $la_finish[2]?>
										Y_date= Y_date+'/'+m_date+'/'+d_date
										DateInput('la_finish', true, 'YYYY-MM-DD', Y_date)</script>
		<?php
		echo "</Td></Tr>";

		echo "<Tr align='left'><Td align='right'>&nbsp;</Td>";
		echo "<Td>มีกำหนด&nbsp;&nbsp;<Input Type='Text' Name='la_total' id='la_total' Size='5' value='$ref_result[la_total]'>&nbsp;&nbsp;วัน";

		echo "<Tr align='left'><Td align='right'>ระหว่างลาติดต่อได้ที่&nbsp;&nbsp;</Td><Td><Input Type='Text' Name='contact'  Size='60' value='$ref_result[contact]'>&nbsp;&nbsp;เบอร์โทรศัำพท์&nbsp;&nbsp;<Input Type='Text' Name='contact_tel' Size='10' value='$ref_result[contact_tel]'></Td></Tr>";

if($ref_result['no_comment']==1){
$no_comment_select="checked";
}
else{
$no_comment_select="";
}
echo "<Tr align='left'><Td align='right'>ไม่ต้องผ่านผู้บังคับบัญชาขั้นต้น&nbsp;&nbsp;</Td><Td><input type='checkbox'  name='no_comment' id='no_comment' value='1' $no_comment_select>&nbsp;&nbsp;(เลือกกรณีผู้บังคับบัญชาขั้นต้นไม่ได้ปฏิบัติราชการ)</Td></Tr>";

		echo "<Tr align='left'><Td align='right'>เลือกผู้อนุมัติ (ปกติไม่ต้องเลือก)&nbsp;&nbsp;</Td><Td><Select  name='grant_p_selected'  size='1'>";
		echo  "<option  value = ''>เลือก</option>" ;
		$sql = "select * from person_main where status='0' and (position_code='1' or position_code='2') order by position_code,person_order";
		$dbquery = mysqli_query($connect,$sql);
		While ($result = mysqli_fetch_array($dbquery))
		   {
				$person_id = $result['person_id'];
				$name = $result['name'];
				$surname = $result['surname'];
				if($person_id==$ref_result['grant_p_selected']){
				echo  "<option value = $person_id selected>$name $surname</option>";
				}
				else{
				echo  "<option value = $person_id>$name $surname</option>";
				}
			}
		echo "</select>";
		echo "&nbsp;&nbsp;(ใช้กรณีผู้อนุมัติิปกติไม่อยู่  เช่น รองผอ.สพท. ซึ่งเป็นผู้อนุมัติกลุ่มนี้ไม่อยู่ เป็นต้น) </Td></Tr>";

		echo "<Tr align='left'><Td align='right'>&nbsp;</Td><Td>";

		echo "<table><tr><td>";
		echo "<fieldset>";
		echo "<legend>&nbsp;<B>สถิติการลาในปีงบประมาณนี้</B>: &nbsp;</legend>";
		echo "<table border='1'>";
		echo "<tr align='center'><td>ลามาแล้ว<br>(วันทำการ)</td><td>ลาครั้งนี้<br>(วันทำการ)</td><td>รวมเป็น<br>(วันทำการ)</td></tr>";

		echo "<tr align='center'><td><Input Type='Text' Name='relax_ago'  Size='5'  value='$ref_result[relax_ago]'></td><td><Input Type='Text' Name='relax_this' Size='5' value='$ref_result[relax_this]'></td><td><Input Type='Text' Name='relax_total' Size='5' value='$ref_result[relax_total]'></td></tr>";

		echo "</table>";
		echo "</fieldset></td></tr></table>";
		echo "</Td></tr>";
		echo "<Input Type=Hidden Name='la_type' Value='4'>";
		}
echo "</Table>";

echo "<table width='70%'><tr><td>";
echo "<fieldset>";
echo "<legend>&nbsp;<B>ส่วนการรับมอบงาน</B>: &nbsp;</legend>";
echo "<table>";
echo "<Tr align='left'><Td align='right'>ผู้รับมอบ&nbsp;&nbsp;</Td><Td><Select  name='job_person'  size='1'>";
echo  "<option  value = ''>เลือก</option>" ;
$sql = "select * from person_main where status='0' and position_code>'1' order by department, position_code,person_order";
$dbquery = mysqli_query($connect,$sql);
While ($result = mysqli_fetch_array($dbquery))
   {
		$person_id = $result['person_id'];
		$name = $result['name'];
		$surname = $result['surname'];
		if($person_id==$ref_result['job_person']){
		echo  "<option value = $person_id selected>$name $surname</option>";
		}
		else{
		echo  "<option value = $person_id>$name $surname</option>";
		}
	}
echo "</select>";
echo "</Td>";

if($ref_result['job_person_sign']==1){
echo "<td><input type='checkbox' checked>รับมอบงาน</td>";
}
else{
echo "<td><input type='checkbox'>รับมอบงาน</td>";
}
echo "</Tr>";
echo "</table>";
echo "</fieldset></td></tr></table>";

echo "<table width='70%'><tr><td>";
echo "<fieldset>";
echo "<legend>&nbsp;<B>ส่วนของการตรวจสอบ</B>: &nbsp;</legend>";
echo "<table>";
echo "<Tr align='left'><Td align='right'>บันทึกการตรวจสอบ(ถ้ามี)&nbsp;&nbsp;</Td><Td><Input Type='Text' Name='officer_comment' Size='60' value='$ref_result[officer_comment]'></Td></Tr>";
echo "</table>";
echo "</fieldset></td></tr></table>";

echo "<table width='70%'><tr><td>";
echo "<fieldset>";
echo "<legend>&nbsp;<B>ส่วนความเห็นของผู้บังคับบัญชาขั้นต้น</B>: &nbsp;</legend>";
echo "<table>";
echo "<Tr align='left'><Td align='right'>บันทึกความเห็น(ถ้ามี)&nbsp;&nbsp;</Td><Td><Input Type='Text' Name='group_comment' Size='60' value='$ref_result[group_comment]'></Td></Tr>";
echo "</table>";
echo "</fieldset></td></tr></table>";

echo "<table width='70%'><tr><td>";
echo "<fieldset>";
echo "<legend>&nbsp;<B>ส่วนของผู้อนุมัติ</B>: &nbsp;</legend>";
echo "<table>";
echo "<Tr align='left'><Td align='right'>คำสั่ง(ถ้ามี)&nbsp;&nbsp;</Td><Td><Input Type='Text' Name='commander_comment' Size='60' value='$ref_result[commander_comment]'></Td></Tr>";
		$commander_grant_check1=""; $commander_grant_check2="";
		if($ref_result['commander_grant']==1){
		$commander_grant_check1="checked";
		}
		else if($ref_result['commander_grant']==2){
		$commander_grant_check2="checked";
		}
echo "<Tr align='left'><Td align='right'>อนุมัติ/ไม่อนุมัติ&nbsp;&nbsp;</Td><Td><Input Type='radio' Name='commander_grant' value='1' $commander_grant_check1>อนุมัติ&nbsp;&nbsp;<Input Type='radio' Name='commander_grant' value='2' $commander_grant_check2>ไม่อนุมัติ&nbsp;&nbsp;</Td></Tr>";
echo "</table>";
echo "</fieldset></td></tr></table>";

echo "<Input Type=Hidden Name='id' Value='$_GET[id]'>";
echo "<Input Type=Hidden Name='page' Value='$_GET[page]'>";
echo "<Br>";
echo "<INPUT TYPE='button' name='smb' value='ลงนาม' onclick='goto_url_update(1)' class=entrybutton>
		&nbsp;&nbsp;<INPUT TYPE='button' name='back' value='ย้อนกลับ' onclick='goto_url_update(0)' class=entrybutton'>";
echo "</form>";
}

//ส่วนปรับปรุงข้อมูล
if ($index==6){
$date_time_now = date("Y-m-d H:i:s");
		$sql = "update la_main set commander_comment='$_POST[commander_comment]',
		commander_sign='$_SESSION[login_user_id]',
		commander_grant='$_POST[commander_grant]',
		grant_date='$date_time_now'
		where id='$_POST[id]'";
		$dbquery = mysqli_query($connect,$sql);
}

if ($index==7){
echo "<Center>";
echo "<Font color='#006666' Size=3><B>รายละเอียดการขออนุญาตลา</B></Font>";
echo "</Cener>";
echo "<Br>";

echo "<Br>";
echo "<Table  align='center' width='80%' Border='0'>";
echo "<Tr ><Td colspan='2' align='right'><INPUT TYPE='button' name='smb' value='<<กลับหน้าก่อน' onclick='location.href=\"?option=la&task=main/grant&page=$_GET[page]\"'></Td></Tr>";

$sql = "select * from la_main where id='$_GET[id]'";
$dbquery = mysqli_query($connect,$sql);
$ref_result = mysqli_fetch_array($dbquery);
$id=$ref_result['id'];
$person_id=$ref_result['person_id'];
$la_type=$ref_result['la_type'];
$grant_p_selected=$ref_result['grant_p_selected'];
$rec_date=$ref_result['rec_date'];

$sql_person = "select * from  person_main where person_id='$ref_result[person_id]' ";
$dbquery_person = mysqli_query($connect,$sql_person);
$result_person = mysqli_fetch_array($dbquery_person);
$fullname=$result_person['prename'].$result_person['name']." ".$result_person['surname'];
$position=$result_person['position_code'];
$sql = "select * from  person_position where position_code='$position'";
$dbquery = mysqli_query($connect,$sql);
$result = mysqli_fetch_array($dbquery);
$position_name=$result['position_name'];
		//โรงเรียน
		if(!$result_person){
		$sql_person = "select * from  person_sch_main left join system_school on person_sch_main.school_code=system_school.school_code where person_id='$person_id' ";
		$dbquery_person = mysqli_query($connect,$sql_person);
		$result_person = mysqli_fetch_array($dbquery_person);
		$fullname=$result_person['prename'].$result_person['name']." ".$result_person['surname']." "."(".$result_person['school_name'].")";
		$position=$result_person['position_code'];
		$sql = "select * from  person_sch_position where position_code='$position'";
		$dbquery = mysqli_query($connect,$sql);
		$result = mysqli_fetch_array($dbquery);
		$position_name=$result['position_name'];
		}

		if($la_type<4){
		echo "<Tr align='left'><Td align='right'>วันเดือนปี&nbsp;&nbsp;</Td><Td>";
echo thai_date_4($rec_date);
echo "</Td></Tr>";
		echo "<Tr align='left'><Td align='right'>เขียนที่&nbsp;&nbsp;</Td><Td><Input Type='Text' Name='write_at' Size='30' value='$ref_result[write_at]'></Td></Tr>";
		$check1=""; $check2=""; $check3="";
		if($ref_result['la_type']==1){
		$check1="checked";
		}
		else if($ref_result['la_type']==2){
		$check2="checked";
		}
		else if($ref_result['la_type']==3){
		$check3="checked";
		}
		echo "<Tr align='left'><Td align='right'>เรื่อง&nbsp;&nbsp;</Td><Td><Input Type='radio' Name='la_type' value='1' $check1>ลาป่วย&nbsp;&nbsp;<Input Type='radio' Name='la_type' value='2' $check2>ลากิจ&nbsp;&nbsp;<Input Type='radio' Name='la_type' value='3' $check3>ลาคลอด</Td></Tr>";

		echo "<Tr align='left'><Td align='right'>เรียน&nbsp;&nbsp;</Td><Td>ผู้อำนวยการ$_SESSION[office_name]</Td></Tr>";

		echo "<Tr align='left'><Td align='right'>ข้าพเจ้า&nbsp;&nbsp;</Td><Td>$fullname&nbsp;&nbsp;ตำแหน่ง&nbsp;&nbsp;$position_name</Td></Tr>";

		echo "<Tr align='left'><Td align='right'>เนื่องจาก&nbsp;&nbsp;</Td><Td><Input Type='Text' Name='because' Size='60' value='$ref_result[because]'></Td></Tr>";

		echo "<Tr align='left'><Td align='right'>ขอลาตั้งแต่วันที่&nbsp;&nbsp;</Td>";

		echo "<Td align='left'>";
		$la_start=explode("-", $ref_result['la_start']);
		?>
		<script>
										var Y_date=<?php echo $la_start[0]?>
										var m_date=<?php echo $la_start[1]?>
										var d_date=<?php echo $la_start[2]?>
										Y_date= Y_date+'/'+m_date+'/'+d_date
										DateInput('la_start', true, 'YYYY-MM-DD', Y_date)</script>
		<?php

		echo "</Td></Tr>";

		echo "<Tr align='left'><Td align='right'>ถึงวันที่&nbsp;&nbsp;</Td>";

		echo "<Td align='left'>";
		$la_finish=explode("-", $ref_result['la_finish']);
		?>
		<script>
										var Y_date=<?php echo $la_finish[0]?>
										var m_date=<?php echo $la_finish[1]?>
										var d_date=<?php echo $la_finish[2]?>
										Y_date= Y_date+'/'+m_date+'/'+d_date
										DateInput('la_finish', true, 'YYYY-MM-DD', Y_date)</script>
		<?php
		echo "</Td></Tr>";

		echo "<Tr align='left'><Td align='right'>&nbsp;</Td>";

		echo "<Td>มีกำหนด&nbsp;&nbsp;<Input Type='Text' Name='la_total' Size='5' value='$ref_result[la_total]'>&nbsp;&nbsp;วัน";

		echo "<Tr align='left'><Td align='right'>ลาครั้งสุดท้ายตั้งแต่วันที่&nbsp;&nbsp;</Td>";
		echo "<Td align='left'>";
		$last_la_start=explode("-", $ref_result['last_la_start']);
		?>
		<script>
										var Y_date=<?php echo $last_la_start[0]?>
										var m_date=<?php echo $last_la_start[1]?>
										var d_date=<?php echo $last_la_start[2]?>
										Y_date= Y_date+'/'+m_date+'/'+d_date
										DateInput('last_la_start', true, 'YYYY-MM-DD', Y_date)</script>
		<?php
		echo "</Td></Tr>";

		echo "<Tr align='left'><Td align='right'>ถึงวันที่&nbsp;&nbsp;</Td>";
		echo "<Td align='left'>";
		$last_la_finish=explode("-", $ref_result['last_la_finish']);
		?>
		<script>
										var Y_date=<?php echo $last_la_finish[0]?>
										var m_date=<?php echo $last_la_finish[1]?>
										var d_date=<?php echo $last_la_finish[2]?>
										Y_date= Y_date+'/'+m_date+'/'+d_date
										DateInput('last_la_finish', true, 'YYYY-MM-DD', Y_date)</script>
		<?php
		echo "<Tr align='left'><Td align='right'>&nbsp;</Td>";
		echo "<Td>มีกำหนด&nbsp;&nbsp;<Input Type='Text' Name='last_la_total' Size='5' value='$ref_result[last_la_total]'>&nbsp;&nbsp;วัน";


		echo "<Tr align='left'><Td align='right'>ระหว่างลาติดต่อได้ที่&nbsp;&nbsp;</Td><Td><Input Type='Text' Name='contact' Size='60' value='$ref_result[contact]'>&nbsp;&nbsp;เบอร์โทรศัำพท์&nbsp;&nbsp;<Input Type='Text' Name='contact_tel'  Size='10' value='$ref_result[contact_tel]'></Td></Tr>";

		echo  "<tr align='left'>";
		echo  "<td align='right'>เอกสาร(ถ้ามี)&nbsp;&nbsp;</td>";
		echo  "<td align='left'><input name = 'userfile' type = 'file'></td>";
		echo  "</tr>";

if($ref_result['no_comment']==1){
$no_comment_select="checked";
}
else{
$no_comment_select="";
}
echo "<Tr align='left'><Td align='right'>ไม่ต้องผ่านผู้บังคับบัญชาขั้นต้น&nbsp;&nbsp;</Td><Td><input type='checkbox'  name='no_comment' id='no_comment' value='1' $no_comment_select>&nbsp;&nbsp;(เลือกกรณีผู้บังคับบัญชาขั้นต้นไม่ได้ปฏิบัติราชการ)</Td></Tr>";

		echo "<Tr align='left'><Td align='right'>เลือกผู้อนุมัติ (ปกติไม่ต้องเลือก)&nbsp;&nbsp;</Td><Td><Select  name='grant_p_selected'  size='1'>";
		echo  "<option  value = ''>เลือก</option>" ;
		$sql = "select * from person_main where status='0' and (position_code='1' or position_code='2') order by position_code,person_order";
		$dbquery = mysqli_query($connect,$sql);
		While ($result = mysqli_fetch_array($dbquery))
		   {
				$person_id = $result['person_id'];
				$name = $result['name'];
				$surname = $result['surname'];
				if($person_id==$ref_result['grant_p_selected']){
				echo  "<option value = $person_id selected>$name $surname</option>";
				}
				else{
				echo  "<option value = $person_id>$name $surname</option>";
				}
			}
		echo "</select>";
		echo "&nbsp;&nbsp;(ใช้กรณีผู้อนุมัติิปกติไม่อยู่  เช่น รองผอ.สพท. ซึ่งเป็นผู้อนุมัติกลุ่มนี้ไม่อยู่ เป็นต้น) </Td></Tr>";

		echo "<Tr align='left'><Td align='right'>&nbsp;</Td><Td>";

		echo "<table><tr><td>";
		echo "<fieldset>";
		echo "<legend>&nbsp;<B>สถิติการลาในปีงบประมาณนี้</B>: &nbsp;</legend>";
		echo "<table border='1'>";
		echo "<tr align='center'><td>ประเภทการลา</td><td>ลามาแล้ว<br>(วันทำการ)</td><td>ลาครั้งนี้<br>(วันทำการ)</td><td>รวมเป็น<br>(วันทำการ)</td></tr>";

		echo "<tr align='center'><td>ป่วย</td><td><Input Type='Text' Name='sick_ago' Size='5'  value='$ref_result[sick_ago]'></td><td><Input Type='Text' Name='sick_this' Size='5'  value='$ref_result[sick_this]'></td><td><Input Type='Text' Name='sick_total' Size='5' value='$ref_result[sick_total]'></td></tr>";

		echo "<tr align='center'><td>กิจส่วนตัว</td><td><Input Type='Text' Name='privacy_ago' Size='5' value='$ref_result[privacy_ago]'></td><td><Input Type='Text' Name='privacy_this' Size='5' value='$ref_result[privacy_this]'></td><td><Input Type='Text' Name='privacy_total' Size='5' value='$ref_result[privacy_total]'></td></tr>";

		echo "<tr align='center'><td>คลอดบุตร</td><td><Input Type='Text' Name='birth_ago' Size='5' value='$ref_result[birth_ago]'></td><td><Input Type='Text' Name='birth_this' Size='5' value='$ref_result[birth_this]'></td><td><Input Type='Text' Name='birth_total' Size='5' value='$ref_result[birth_total]'></td></tr>";
		echo "</table>";
		echo "</fieldset></td></tr></table>";
		echo "</Td></tr>";
		}
		if($la_type==4){
		echo "<Tr align='left'><Td align='right'>วันเดือนปี&nbsp;&nbsp;</Td><Td>";
echo thai_date_4($rec_date);
echo "</Td></Tr>";
		echo "<Tr align='left'><Td align='right'>เขียนที่&nbsp;&nbsp;</Td><Td><Input Type='Text' Name='write_at' Size='30' value='$ref_result[write_at]'></Td></Tr>";
		echo "<Tr align='left'><Td align='right'>เรื่อง&nbsp;&nbsp;</Td><Td>ลาพักผ่อน</Td></Tr>";

		echo "<Tr align='left'><Td align='right'>เรียน&nbsp;&nbsp;</Td><Td>ผู้อำนวยการ$_SESSION[office_name]</Td></Tr>";

		echo "<Tr align='left'><Td align='right'>ข้าพเจ้า&nbsp;&nbsp;</Td><Td>$fullname&nbsp;&nbsp;ตำแหน่ง&nbsp;&nbsp;$position_name</Td></Tr>";

		echo "<Tr align='left'><Td align='right'>&nbsp;</Td>";

		echo "<Td>มีวันลาพักผ่อนสะสม&nbsp;&nbsp;<Input Type='Text' Name='relax_collect' Size='5' value='$ref_result[relax_collect]'>&nbsp;&nbsp;วันทำการ และประจำปีอีก 10 วันทำการ รวมเป็น&nbsp;&nbsp;<Input Type='Text' Name='relax_this_year' Size='5' value='$ref_result[relax_this_year]'>&nbsp;&nbsp;วันทำการ";

		echo "<Tr align='left'><Td align='right'>ขอลาตั้งแต่วันที่&nbsp;&nbsp;</Td>";
		echo "<Td align='left'>";
		$la_start=explode("-", $ref_result['la_start']);
		?>
		<script>
										var Y_date=<?php echo $la_start[0]?>
										var m_date=<?php echo $la_start[1]?>
										var d_date=<?php echo $la_start[2]?>
										Y_date= Y_date+'/'+m_date+'/'+d_date
										DateInput('la_start', true, 'YYYY-MM-DD', Y_date)</script>
		<?php
		echo "</Td></Tr>";

		echo "<Tr align='left'><Td align='right'>ถึงวันที่&nbsp;&nbsp;</Td>";
		echo "<Td align='left'>";
		$la_finish=explode("-", $ref_result['la_finish']);
		?>
		<script>
										var Y_date=<?php echo $la_finish[0]?>
										var m_date=<?php echo $la_finish[1]?>
										var d_date=<?php echo $la_finish[2]?>
										Y_date= Y_date+'/'+m_date+'/'+d_date
										DateInput('la_finish', true, 'YYYY-MM-DD', Y_date)</script>
		<?php
		echo "</Td></Tr>";

		echo "<Tr align='left'><Td align='right'>&nbsp;</Td>";
		echo "<Td>มีกำหนด&nbsp;&nbsp;<Input Type='Text' Name='la_total' id='la_total' Size='5' value='$ref_result[la_total]'>&nbsp;&nbsp;วัน";

		echo "<Tr align='left'><Td align='right'>ระหว่างลาติดต่อได้ที่&nbsp;&nbsp;</Td><Td><Input Type='Text' Name='contact'  Size='60' value='$ref_result[contact]'>&nbsp;&nbsp;เบอร์โทรศัำพท์&nbsp;&nbsp;<Input Type='Text' Name='contact_tel' Size='10' value='$ref_result[contact_tel]'></Td></Tr>";

if($ref_result['no_comment']==1){
$no_comment_select="checked";
}
else{
$no_comment_select="";
}
echo "<Tr align='left'><Td align='right'>ไม่ต้องผ่านผู้บังคับบัญชาขั้นต้น&nbsp;&nbsp;</Td><Td><input type='checkbox'  name='no_comment' id='no_comment' value='1' $no_comment_select>&nbsp;&nbsp;(เลือกกรณีผู้บังคับบัญชาขั้นต้นไม่ได้ปฏิบัติราชการ)</Td></Tr>";

		echo "<Tr align='left'><Td align='right'>เลือกผู้อนุมัติ (ปกติไม่ต้องเลือก)&nbsp;&nbsp;</Td><Td><Select  name='grant_p_selected'  size='1'>";
		echo  "<option  value = ''>เลือก</option>" ;
		$sql = "select * from person_main where status='0' and (position_code='1' or position_code='2') order by position_code,person_order";
		$dbquery = mysqli_query($connect,$sql);
		While ($result = mysqli_fetch_array($dbquery))
		   {
				$person_id = $result['person_id'];
				$name = $result['name'];
				$surname = $result['surname'];
				if($person_id==$ref_result['grant_p_selected']){
				echo  "<option value = $person_id selected>$name $surname</option>";
				}
				else{
				echo  "<option value = $person_id>$name $surname</option>";
				}
			}
		echo "</select>";
		echo "&nbsp;&nbsp;(ใช้กรณีผู้อนุมัติิปกติไม่อยู่  เช่น รองผอ.สพท. ซึ่งเป็นผู้อนุมัติกลุ่มนี้ไม่อยู่ เป็นต้น) </Td></Tr>";

		echo "<Tr align='left'><Td align='right'>&nbsp;</Td><Td>";

		echo "<table><tr><td>";
		echo "<fieldset>";
		echo "<legend>&nbsp;<B>สถิติการลาในปีงบประมาณนี้</B>: &nbsp;</legend>";
		echo "<table border='1'>";
		echo "<tr align='center'><td>ลามาแล้ว<br>(วันทำการ)</td><td>ลาครั้งนี้<br>(วันทำการ)</td><td>รวมเป็น<br>(วันทำการ)</td></tr>";

		echo "<tr align='center'><td><Input Type='Text' Name='relax_ago'  Size='5'  value='$ref_result[relax_ago]'></td><td><Input Type='Text' Name='relax_this' Size='5' value='$ref_result[relax_this]'></td><td><Input Type='Text' Name='relax_total' Size='5' value='$ref_result[relax_total]'></td></tr>";

		echo "</table>";
		echo "</fieldset></td></tr></table>";
		echo "</Td></tr>";
		}
echo "</table>";

echo "<table width='70%'><tr><td>";
echo "<fieldset>";
echo "<legend>&nbsp;<B>ส่วนการรับมอบงาน</B>: &nbsp;</legend>";
echo "<table>";
echo "<Tr align='left'><Td align='right'>ผู้รับมอบ&nbsp;&nbsp;</Td><Td><Select  name='job_person'  size='1'>";
echo  "<option  value = ''>เลือก</option>" ;
$sql = "select * from person_main where status='0' and position_code>'1' order by department, position_code,person_order";
$dbquery = mysqli_query($connect,$sql);
While ($result = mysqli_fetch_array($dbquery))
   {
		$person_id = $result['person_id'];
		$name = $result['name'];
		$surname = $result['surname'];
		if($person_id==$ref_result['job_person']){
		echo  "<option value = $person_id selected>$name $surname</option>";
		}
		else{
		echo  "<option value = $person_id>$name $surname</option>";
		}
	}
echo "</select>";
echo "</Td>";

if($ref_result['job_person_sign']==1){
echo "<td><input type='checkbox' checked>รับมอบงาน</td>";
}
else{
echo "<td><input type='checkbox'>รับมอบงาน</td>";
}
echo "</Tr>";
echo "</table>";
echo "</fieldset></td></tr></table>";

echo "<table width='70%'><tr><td>";
echo "<fieldset>";
echo "<legend>&nbsp;<B>ส่วนการตรวจสอบ</B>: &nbsp;</legend>";
echo "<table>";
echo "<Tr align='left'><Td align='right' width='180'>บันทึกการตรวจสอบ(ถ้ามี)&nbsp;&nbsp;</Td><Td><Input Type='Text' Name='officer_comment' Size='60' value='$ref_result[officer_comment]'></Td></Tr>";
$officer_sign=$ref_result['officer_sign'];

if(!isset($full_name_ar[$officer_sign])){
$full_name_ar[$officer_sign]="";
}

echo "<Tr align='left'><Td align='right'>ลงชื่อ&nbsp;&nbsp;</Td><Td><Input Type='Text' Size='40' value='$full_name_ar[$officer_sign]'></Td></Tr>";
$officer_date= thai_date_4($ref_result['officer_date']);
echo "<Tr align='left'><Td align='right'>วดป&nbsp;&nbsp;</Td><Td><Input Type='Text' Size='30' value='$officer_date'></Td></Tr>";
echo "</table>";
echo "</fieldset></td></tr></table>";

echo "<table width='70%'><tr><td>";
echo "<fieldset>";
echo "<legend>&nbsp;<B>ส่วนความเห็นของผู้บังคับบัญชาขั้นต้น</B>: &nbsp;</legend>";
echo "<table>";
echo "<Tr align='left'><Td align='right' width='180'>บันทึกความเห็น(ถ้ามี)&nbsp;&nbsp;</Td><Td><Input Type='Text' Name='group_comment' Size='60' value='$ref_result[group_comment]'></Td></Tr>";
$group_sign=$ref_result['group_sign'];

if(!isset($full_name_ar[$group_sign])){
$full_name_ar[$group_sign]="";
}

echo "<Tr align='left'><Td align='right'>ลงชื่อ&nbsp;&nbsp;</Td><Td><Input Type='Text' Size='40' value='$full_name_ar[$group_sign]'></Td></Tr>";
$group_date= thai_date_4($ref_result['group_date']);
echo "<Tr align='left'><Td align='right'>วดป&nbsp;&nbsp;</Td><Td><Input Type='Text' Size='30' value='$group_date'></Td></Tr>";
echo "</table>";
echo "</fieldset></td></tr></table>";

echo "<table width='70%'><tr><td>";
echo "<fieldset>";
echo "<legend>&nbsp;<B>ส่วนการอนุมัติ</B>: &nbsp;</legend>";
echo "<table>";
echo "<Tr align='left'><Td align='right' width='180'>คำสั่ง(ถ้ามี)&nbsp;&nbsp;</Td><Td><Input Type='Text' Name='commander_comment' Size='60' value='$ref_result[commander_comment]'></Td></Tr>";
		$commander_grant_check1=""; $commander_grant_check2="";
		if($ref_result['commander_grant']==1){
		$commander_grant_check1="checked";
		}
		else if($ref_result['commander_grant']==2){
		$commander_grant_check2="checked";
		}
echo "<Tr align='left'><Td align='right'>อนุมัติ/ไม่อนุมัติ&nbsp;&nbsp;</Td><Td><Input Type='radio' Name='commander_grant' value='1' $commander_grant_check1>อนุมัติ&nbsp;&nbsp;<Input Type='radio' Name='commander_grant' value='2' $commander_grant_check2>ไม่อนุมัติ&nbsp;&nbsp;</Td></Tr>";
$commander_sign=$ref_result['commander_sign'];

if(!isset($full_name_ar[$commander_sign])){
$full_name_ar[$commander_sign]="";
}

echo "<Tr align='left'><Td align='right'>ลงชื่อ&nbsp;&nbsp;</Td><Td><Input Type='Text' Size='40' value='$full_name_ar[$commander_sign]'></Td></Tr>";
$grant_date= thai_date_4($ref_result['grant_date']);
echo "<Tr align='left'><Td align='right'>วดป&nbsp;&nbsp;</Td><Td><Input Type='Text' Size='30' value='$grant_date'></Td></Tr>";
echo "</table>";
echo "</fieldset></td></tr></table>";
}

//ส่วนแสดงผล
if(!(($index==1) or ($index==5) or ($index==7))){
//ส่วนของการแยกหน้า

$now=time();
$time_onedayago=$now-86400;
$onedayago=date("Y-m-d H:i:s",$time_onedayago);

$sql = "select la_main.id, la_main.person_id, la_main.rec_date, la_main.la_type, la_main.la_start, la_main.la_finish, la_main.la_total, la_main.document, la_main.group_sign,la_main.commander_grant,la_main.commander_comment,la_main.commander_sign,la_main.grant_date from la_main left join la_person_set on  la_main.person_id=la_person_set.person_id where (la_main.grant_p_selected ='$_SESSION[login_user_id]' or la_person_set.grant_person ='$_SESSION[login_user_id]') and (la_main.rec_date<'$onedayago' or la_person_set.comment_person is null or la_person_set.comment_person='' or la_main.no_comment='1' or la_main.group_sign is not null) ";
$dbquery = mysqli_query($connect,$sql);
$num_rows = mysqli_num_rows($dbquery );

$pagelen=15;  // 1_กำหนดแถวต่อหน้า
$url_link="option=la&task=main/grant";  // 2_กำหนดลิงค์ฺ
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
$sql = "select la_main.id, la_main.person_id, la_main.rec_date, la_main.la_type, la_main.la_start, la_main.la_finish, la_main.la_total, la_main.document,  la_main.grant_p_selected, la_main.group_sign,la_main.commander_grant,la_main.commander_comment,la_main.commander_sign,la_main.grant_date from la_main left join la_person_set on  la_main.person_id=la_person_set.person_id where (la_main.grant_p_selected ='$_SESSION[login_user_id]' or la_person_set.grant_person ='$_SESSION[login_user_id]') and (la_main.rec_date<'$onedayago' or la_person_set.comment_person is null or la_person_set.comment_person='' or la_main.no_comment='1' or la_main.group_sign is not null) order by la_main.commander_grant desc,la_main.id limit $start,$pagelen";

$dbquery = mysqli_query($connect,$sql);

echo "<form id='frm1' name='frm1'>";
echo  "<table width='98%' border='0' align='center'>";
echo "<Tr><Td colspan='11' align='right'><INPUT TYPE='checkbox' name='allchk'  id='allckk' onclick='CheckAll()'>เลือก/ไม่เลือกทั้งหมด</Td></Tr>";
echo "<Tr bgcolor='#FFCCCC' align='center'><Td width='60'>เลขที่</Td><Td>ผู้ขออนุญาต</Td><Td width='100'>วันขออนุญาต</Td><Td width='100'>ประเภทการลา</Td><Td>ตั้งแต่วันที่</Td><Td>ถึงวันที่</Td><Td>มีกำหนด</Td><Td>เอกสาร</Td><Td width='50'>รายละเอียด</Td><Td><INPUT TYPE='button' name='smb' value='อนุมัติ' onclick='goto_url(1)'></Td><Td width='40'>บันทึก</Td></Tr>";

$N=(($page-1)*$pagelen)+1; //*เกี่ยวข้องกับการแยกหน้า
$M=1;

While ($result = mysqli_fetch_array($dbquery)){
		$id = $result['id'];
		$person_id = $result['person_id'];
		$file = $result['document'];
		$grant_p_selected = $result['grant_p_selected'];
		$rec_date = $result['rec_date'];
			if(($M%2) == 0)
			$color="#FFFFB";
			else  	$color="#FFFFFF";

if(($grant_p_selected!="" ) && ($grant_p_selected!=$_SESSION['login_user_id'])){
continue;
}

		$la_type = $result['la_type'];
			$la_type_name="";
			if($la_type==1){
			$la_type_name="ลาป่วย";
			}
			else if($la_type==2){
			$la_type_name="ลากิจ";
			}
			else if($la_type==3){
			$la_type_name="ลาคลอด";
			}
			else if($la_type==4){
			$la_type_name="ลาพักผ่อน";
			}
		$la_start = $result['la_start'];
		$la_finish = $result['la_finish'];
		$la_total = $result['la_total'];


echo "<Tr bgcolor='$color'><Td valign='top' align='center'>$id</Td>";

$sql_person = "select * from  person_main where person_id='$person_id' ";
$dbquery_person = mysqli_query($connect,$sql_person);
$result_person = mysqli_fetch_array($dbquery_person);
$fullname=$result_person['prename'].$result_person['name']." ".$result_person['surname'];
		if(!$result_person){
		$sql_person = "select * from  person_sch_main left join system_school on person_sch_main.school_code=system_school.school_code where person_id='$person_id' ";
		$dbquery_person = mysqli_query($connect,$sql_person);
		$result_person = mysqli_fetch_array($dbquery_person);
		$fullname=$result_person['prename'].$result_person['name']." ".$result_person['surname']." "."(".$result_person['school_name'].")";
		}
echo "</Td><Td valign='top' align='left'>$fullname</Td>";
echo "<Td valign='top' align='left'>";
echo thai_date_3($rec_date);
echo "</Td><Td valign='top' align='left'>$la_type_name</Td>";
echo "<Td valign='top' align='left' >";
echo thai_date_3($la_start);
echo "</Td>";
echo "<Td valign='top' align='left' >";
echo thai_date_3($la_finish);
echo "</Td>";
echo "<Td valign='top' align='center' >$la_total&nbsp;วัน</Td>";
if($file!=""){
echo   "<Td align='center'><a href='$file' target=_blank><IMG SRC='images/b_browse.png' width='16' height='16' border=0 alt='เอกสาร'></a></td>";
}
else{
echo "<Td></Td>";
}
echo "<Td align='center'><a href=?option=la&task=main/grant&index=7&id=$id&page=$page><img src=images/browse.png border='0' alt='รายละเอียด'></Td>";

		if($result['commander_grant']=='1'){
		echo "<Td align='center'><img src=images/yes.png border='0'><br>$result[commander_comment]</td>";
		}
		else if($result['commander_grant']=='2'){
		echo "<Td align='center'><img src=images/no.png border='0'><br>$result[commander_comment]</td>";
		}
		else{
		echo "<Td align='center'><input type='checkbox' name='$id' id='$id' value='1'></td>";
		}

$now=time();
$timestamp=make_time_2($result['grant_date']);
if($result['grant_date']==""){
$timestamp_2=$now+1800;
}
else{
$timestamp=make_time_2($result['grant_date']);
$timestamp_2=$timestamp+1800;
}

if($now<$timestamp_2){
echo "<Td valign='top' align='center'><a href=?option=la&task=main/grant&index=5&id=$id&page=$page><img src=images/edit.png border='0' alt='บันทึก'></a></Td>";
}
else{
echo "<Td></td>";
}
echo "</Tr>";

$M++;
$N++;  //*เกี่ยวข้องกับการแยกหน้า
}
echo "</Table>";
echo "<input type='hidden' name='page' value=$_REQUEST[page]>";
echo "</form>";
}

?>
<script>
function goto_url(val){
	if(val==0){
		callfrm("?option=la&task=main/grant");   // page ย้อนกลับ
	}else if(val==1){
		callfrm("?option=la&task=main/grant&index=4");   //page ประมวลผล
	}
}

function goto_url_update(val){
	if(val==0){
		callfrm("?option=la&task=main/grant");   // page ย้อนกลับ
	}else if(val==1){
		if(!(frm1.commander_grant[0].checked || frm1.commander_grant[1].checked)){
			alert("กรุณาเลือกการอนุมัติ");
		}else{
			callfrm("?option=la&task=main/grant&index=6");   //page ประมวลผล
		}
	}
}

function CheckAll() {
	for (var i = 0; i < document.frm1.elements.length; i++)
	{
	var e = document.frm1.elements[i];
	if (e.name != "allchk")
		e.checked = document.frm1.allchk.checked;
	}
}
</script>
