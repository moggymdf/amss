<?php
/** ensure this file is being included by a parent file */
defined( '_VALID_' ) or die( 'Direct Access to this location is not allowed.' );

$officer=$_SESSION['login_user_id'];

$sql = "select * from  person_position order by position_code";
$dbquery = mysqli_query($connect,$sql);
While ($result = mysqli_fetch_array($dbquery)){
$position_ar[$result['position_code']]=$result['position_name'];
}

$sql = "select * from  system_workgroup order by workgroup_order";
$dbquery = mysqli_query($connect,$sql);
While ($result = mysqli_fetch_array($dbquery)){
$department_ar[$result['workgroup']]=$result['workgroup_desc'];
}

echo "<br />";
echo "<table width='50%' border='0' align='center'>";
echo "<tr align='center'><td><font color='#006666' size='3'><strong> ครูและบุคลากรในสำนักงานเขตพื้นที่การศึกษา</strong></font></td></tr>";
echo "</table>";
echo "<br />";

$sql = "select * from person_main where status='0' order by department,position_code,person_order";
$dbquery = mysqli_query($connect,$sql);
echo  "<table width='90%' border='0' align='center'>";
echo "<Tr bgcolor='#FFCCCC' align='center'><Td width='70'>ที่</Td><Td>ชื่อ</Td><Td>ตำแหน่ง</Td><Td>กลุ่ม</Td><Td width='60'>รูปภาพ</Td></Tr>";
$N=1;
$M=1;
While ($result = mysqli_fetch_array($dbquery))
	{
		$id = $result['id'];
		$person_id = $result['person_id'];
		$prename=$result['prename'];
		$name= $result['name'];
		$surname = $result['surname'];
		$position_code= $result['position_code'];
		$department= $result['department'];
			if(($M%2) == 0)
			$color="#FFFFC";
			else  	$color="#FFFFFF";

		echo "<Tr bgcolor=$color align='center'><Td>$N</Td><Td align='left'>$prename&nbsp;$name&nbsp;&nbsp;$surname</Td><Td align='left'>";
if(isset($position_ar[$position_code])){
echo $position_ar[$position_code];
}
echo "</Td><Td align='left'>";
if(isset($department_ar[$department])){
echo $department_ar[$department];
}
echo "</Td>";
if($result['pic']!=""){
echo "<Td align='center'><a href='modules/person/pic_show.php?person_id=$person_id' target='_blank'><img src=images/admin/user.gif border='0' alt='รูปภาพ'></a></Td>";
}
else{
echo "<Td align='center'>&nbsp;</Td>";
}
echo "</Tr>";
$M++;
$N++;
	}
echo "</Table>";
echo "<br /><br />";

// ส่วนรายงานสรุป

echo "<table width='50%' border='0' align='center'>";
echo "<tr align='center'><td><font color='#006666' size='3'><strong>สรุปจำนวนบุคลากรจำแนกตามตำแหน่ง</strong></font></td></tr>";
echo "</table>";

$sql = "select * from person_position order by position_code";
$dbquery = mysqli_query($connect,$sql);

echo  "<table width=50% border=0 align=center>";

echo "<Tr bgcolor=#FFCCCC align='center'><Td width='50'>ที่</Td> <Td>รหัส</Td><Td>ตำแหน่ง</Td><Td width='70'>จำนวน</Td></Tr>";
$M=1;
$person_num=0;
While ($result = mysqli_fetch_array($dbquery))
	{
		$id = $result['id'];
		$position_code= $result['position_code'];
		$position_name= $result['position_name'];
			if(($M%2) == 0)
			$color="#FFFFC";
			else  	$color="#FFFFFF";
			//หาจำนวนคนในตำแหน่ง
			$sql_sum = "select  count(name) as member_num from person_main where status='0' and position_code='$position_code'";
			$dbquery_sum = mysqli_query($connect,$sql_sum);
			$result_sum = mysqli_fetch_array($dbquery_sum);
			$person_num=$person_num+$result_sum['member_num'];
echo "<Tr  bgcolor='$color' align='center'><Td>$M</Td> <Td>$position_code</Td> <Td align=left>$position_name</Td><Td>$result_sum[member_num]</Td></Tr>";
$M++;
	}
echo "<Tr bgcolor=#FFCCCC align='center'><Td colspan='3'>รวม</Td><Td>$person_num</Td></Tr>";

echo "</Table>";


?>
<script>
function goto_url(val){
	if(val==0){
		callfrm("?option=person&task=person");   // page ย้อนกลับ
	}else if(val==1){
		if(frm1.person_id.value == ""){
			alert("กรุณากรอกเลขประจำตัวประชาชน");
		}else if(frm1.prename.value==""){
			alert("กรุณากรอกคำนำหน้าชื่อ");
		}else if(frm1.name.value==""){
			alert("กรุณากรอกชื่อ");
		}else if(frm1.surname.value==""){
			alert("กรุณากรอกนามสกุล");
		}else if(frm1.position_code.value==""){
			alert("กรุณาเลือกตำแหน่ง");
		}else{
			callfrm("?option=person&task=person&index=4");   //page ประมวลผล
		}
	}
}

function goto_url_update(val){
	if(val==0){
		callfrm("?option=person&task=person");   // page ย้อนกลับ
	}else if(val==1){
		if(frm1.person_id.value == ""){
			alert("กรุณากรอกเลขประจำตัวประชาชน");
		}else if(frm1.prename.value==""){
			alert("กรุณากรอกคำนำหน้าชื่อ");
		}else if(frm1.name.value==""){
			alert("กรุณากรอกชื่อ");
		}else if(frm1.surname.value==""){
			alert("กรุณากรอกนามสกุล");
		}else if(frm1.position_code.value==""){
			alert("กรุณาเลือกตำแหน่ง");
		}else{
			callfrm("?option=person&task=person&index=6");   //page ประมวลผล
		}
	}
}
</script>
