<?php
/** ensure this file is being included by a parent file */
defined( '_VALID_' ) or die( 'Direct Access to this location is not allowed.' );
require_once "modules/la/time_inc.php";

?>
<script type="text/javascript" src="./css/js/calendarDateInput.js"></script>
<?php

$user=$_GET['person_id'];
echo "<br>";

$sql_name = "select * from person_main where person_id='$user'";
$dbquery_name = mysqli_query($connect,$sql_name);
$result_name = mysqli_fetch_array($dbquery_name);
		$person_id = $result_name['person_id'];
		$prename=$result_name['prename'];
		$name= $result_name['name'];
		$surname = $result_name['surname'];
		$position_code = $result_name['position_code'];
$full_name="$prename$name&nbsp;&nbsp;$surname";

echo "<table width='100%' border='0' align='center'>";
echo "<tr align='center'><td><font color='#006666' size='3'><strong>ทะเบียนการลาพักผ่อน</strong></font></td></tr>";
echo "<tr align='center'><td><font color='#006666' size='2'><strong>$full_name</strong></font></td></tr>";
echo "</table>";

if ($index==7){
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

echo "<Center>";
echo "<Font color='#006666' Size='2'><B>รายละเอียดการขออนุญาตลา</B></Font>";
echo "</Cener>";
echo "<Br>";
echo "<Br>";
echo "<Table  align='center' width='80%' Border='0'>";
echo "<Tr ><Td colspan='2' align='right'><INPUT TYPE='button' name='smb' value='<<กลับหน้าก่อน' onclick='location.href=\"?option=la&task=main/report_7&page=$_GET[page]&person_id=$user\"'></Td></Tr>";
$sql = "select * from la_main where id='$_GET[id]'";
$dbquery = mysqli_query($connect,$sql);
$ref_result = mysqli_fetch_array($dbquery);
$id=$ref_result['id'];
$la_type=$ref_result['la_type'];
$grant_p_selected=$ref_result['grant_p_selected'];
$rec_date=$ref_result['rec_date'];
		if($la_type==4){
		echo "<Tr align='left'><Td align='right'>วันเดือนปี&nbsp;&nbsp;</Td><Td>";
echo thai_date_4($rec_date);
echo "</Td></Tr>";
		echo "<Tr align='left'><Td align='right'>เขียนที่&nbsp;&nbsp;</Td><Td><Input Type='Text' Name='write_at' Size='60' value='$ref_result[write_at]'></Td></Tr>";
		echo "<Tr align='left'><Td align='right'>เรื่อง&nbsp;&nbsp;</Td><Td>ลาพักผ่อน</Td></Tr>";

		echo "<Tr align='left'><Td align='right'>เรียน&nbsp;&nbsp;</Td><Td>ผู้อำนวยการ$_SESSION[office_name]</Td></Tr>";

		echo "<Tr align='left'><Td align='right'>ข้าพเจ้า&nbsp;&nbsp;</Td><Td>";
		$sql_name = "select * from person_main left join person_position on person_main.position_code=person_position.position_code where person_main.person_id='$ref_result[person_id]'";
		$dbquery_name = mysqli_query($connect,$sql_name);
		$result_name = mysqli_fetch_array($dbquery_name);
		echo $result_name['prename'].$result_name['name']." ".$result_name['surname']."&nbsp;&nbsp;ตำแหน่ง".$result_name['position_name'];
		echo "</Td></Tr>";

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
		echo "<Tr align='left'><Td align='right'></Td><Td><input type='checkbox'  name='no_comment' id='no_comment' value='1' $no_comment_select>&nbsp;ไม่ต้องผ่านผู้บังคับบัญชาขั้นต้น</Td></Tr>";
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
if(!(($index==1) or ($index==1.1) or ($index==1.2) or ($index==2) or ($index==5) or ($index==7))){

//ส่วนของการแยกหน้า
$sql="select id from la_main where person_id='$user' and la_type='4'";
$dbquery = mysqli_query($connect,$sql);
$num_rows = mysqli_num_rows($dbquery);

$pagelen=15;  // 1_กำหนดแถวต่อหน้า
$url_link="option=la&task=main/report_7&person_id=$_GET[person_id]";  // 2_กำหนดลิงค์ฺ
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
echo "<table width=90% border=0 align=center>";
echo "<Tr ><Td align='right'><INPUT TYPE='button' name='smb' value='<<กลับหน้าสถิติการลา' onclick='location.href=\"?option=la&task=main/report_5\"'></Td></Tr>";
echo "</table>";

$sql="select * from la_main where person_id='$user' and la_type='4' order by id limit $start,$pagelen";
$dbquery = mysqli_query($connect,$sql);

echo  "<table width=90% border=0 align=center>";
echo "<Tr bgcolor='#FFCCCC' align='center'><Td width='60'>เลขที่</Td><Td width='150'>วันขออนุญาต</Td><Td width='170'>ประเภทการลา</Td><Td>ตั้งแต่วันที่</Td><Td>ถึงวันที่</Td><Td width='100'>มีกำหนด</Td><Td width='50'>เอกสาร</Td><Td width='150'>อนุมัติ/คำสั่ง</Td><Td width='100'>รายละเอียด</Td></Tr>";

$N=(($page-1)*$pagelen)+1; //*เกี่ยวข้องกับการแยกหน้า
$M=1;

While ($result = mysqli_fetch_array($dbquery)){
		$id = $result['id'];
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

		$file = $result['document'];
		$officer_sign = $result['officer_sign'];
		$group_sign = $result['group_sign'];
		$grant = $result['commander_grant'];
		$commander_sign = $result['commander_sign'];
		$rec_date = $result['rec_date'];
			if(($M%2) == 0)
			$color="#FFFFB";
			else  	$color="#FFFFFF";
echo "<Tr bgcolor='$color'><Td valign='top' align='center'>$id</Td><Td valign='top' align='left'>";
echo thai_date_3($rec_date);
echo "</Td><Td align='left'>$la_type_name</Td>";
echo "<Td valign='top' align='left' >";
echo thai_date_3($la_start);
echo "</Td>";
echo "<Td valign='top' align='left' >";
echo thai_date_3($la_finish);
echo "</Td>";
echo "<Td valign='top' align='center' >$la_total&nbsp;วัน</Td>";

if($file!=""){
echo   "<Td valign='top' align='center'><a href='$file' target=_blank><IMG SRC='images/b_browse.png' width='16' height='16' border=0 alt='เอกสาร'></a></td>";
}
else{
echo "<Td valign='top' align='left'>&nbsp;</Td>";
}
echo "<Td valign='top' align='center'>";
if($grant==1){
echo "<img src=images/yes.png border='0'><br><font color='#339900'>$result[commander_comment]</font>";
}
else if($grant==2){
echo "<img src=images/no.png border='0'><br><font color='#990000'>$result[commander_comment]</font>";
}
else{
echo "รออนุมัติ";
}
echo "</Td>";
echo "<Td valign='top' align='center'><a href=?option=la&task=main/report_7&index=7&id=$id&person_id=$user&page=$page><img src=images/browse.png border='0' alt='รายละเอียด'></Td>";
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
		callfrm("?option=la&task=main/report_7");   // page ย้อนกลับ
	}else if(val==1){
		if(frm1.write_at.value == ""){
			alert("กรุณากรอกสถานที่เขียน");
		}else if(frm1.because.value == ""){
		alert("กรุณาระบุสาเหตุ");
		}else if(!(frm1.la_type[0].checked || frm1.la_type[1].checked || frm1.la_type[2].checked)){
			alert("กรุณาเลือกประเภทการลา");
		}else if(frm1.la_total.value == ""){
			alert("กรุณากรอกจำนวนวันลา");
		}else if(frm1.contact.value == ""){
			alert("กรุณากรอกสถานที่ติดต่อระหว่างลา");
		}else{
			callfrm("?option=la&task=main/report_7&index=4");   //page ประมวลผล
		}
	}
}

function goto_url2(val){
	if(val==0){
		callfrm("?option=la&task=main/report_7");   // page ย้อนกลับ
	}else if(val==1){
		if(frm1.write_at.value == ""){
			alert("กรุณากรอกสถานที่เขียน");
		}else if(frm1.la_total.value == ""){
			alert("กรุณากรอกจำนวนวันลา");
		}else if(frm1.contact.value == ""){
			alert("กรุณากรอกสถานที่ติดต่อระหว่างลา");
		}else{
			callfrm("?option=la&task=main/report_7&index=4.1");   //page ประมวลผล
		}
	}
}


function goto_url_update(val){
	if(val==0){
		callfrm("?option=la&task=main/report_7");   // page ย้อนกลับ
	}else if(val==1){
		if(frm1.write_at.value == ""){
			alert("กรุณากรอกสถานที่เขียน");
		}else if(frm1.la_total.value == ""){
			alert("กรุณากรอกจำนวนวันลา");
		}else if(frm1.contact.value == ""){
			alert("กรุณากรอกสถานที่ติดต่อระหว่างลา");
		}else{
			callfrm("?option=la&task=main/report_7&index=6");   //page ประมวลผล
		}
	}
}

</script>
