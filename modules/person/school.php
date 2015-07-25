<?php
/** ensure this file is being included by a parent file */
defined( '_VALID_' ) or die( 'Direct Access to this location is not allowed.' );
//sd page

echo "<br />";
echo "<table width='100%' border='0' align='center'>";
echo "<tr align='center'><td><font color='#006666' size='3'><strong>สถานศึกษา</strong></font></td></tr>";
echo "<tr align='center'><td><font color='#006666' size='2'><strong>(ดูได้อย่างเดียวเพื่อประกอบการทำงานระบบบุคลากร การเพิ่ม ลบ แก้ไข สถานศึกษา เป็นหน้าที่ผู้ดูแลระบบ AMSS++)</strong></font></td></tr>";
echo "</table>";
echo "<br>";

//ส่วนการแสดงผล
if(!(($index==1) or ($index==2) or ($index==5))){

$sql = "select * from system_school order by school_type,school_code";
$dbquery = mysqli_query($connect,$sql);

echo  "<table width=75% border=0 align=center>";
echo "<Tr bgcolor=#FFCCCC align='center' class=style2><Td width='50'>ที่</Td> <Td>รหัสสถานศึกษา</Td><Td>ชื่อสถานศึกษา</Td><Td>ประเภท</Td></Tr>";
$M=1;
While ($result = mysqli_fetch_array($dbquery))
	{
		$id = $result['id'];
		$school_code= $result['school_code'];
		$school_name= $result['school_name'];
		$school_type= $result['school_type'];
			if($school_type==1){
			$school_type_text="สถานศึกษารัฐบาล";
			}
			else if($school_type==2){
			$school_type_text="<font color='#FF0000'>สถานศึกษาเอกชน</font>";
			}
			else{
			$school_type_text="";
			}

			if(($M%2) == 0)
			$color="#FFFFC";
			else  	$color="#FFFFFF";

		echo "<Tr  bgcolor=$color align='center'><Td>$M</Td> <Td>$school_code</Td><Td align=left>$school_name</Td><Td align=left>$school_type_text</Td></Tr>";
$M++;
	}
echo "</Table>";
}


?>
<script>
function goto_url(val){
	if(val==0){
		callfrm("?file=school&task=school");   // page ย้อนกลับ
	}else if(val==1){
		if(frm1.school_code.value == ""){
			alert("กรุณากรอกรหัสตำแหน่ง");
		}else if(frm1.school_name.value==""){
			alert("กรุณากรอกชื่อตำแหน่ง");
		}else if(frm1.school_type.value==""){
			alert("กรุณาเลือกประเภทสถานศึกษา");
		}else{
			callfrm("?file=school&task=school&index=4");   //page ประมวลผล
		}
	}
}

function goto_url_update(val){
	if(val==0){
		callfrm("?file=school&task=school");   // page ย้อนกลับ
	}else if(val==1){
		if(frm1.school_code.value == ""){
			alert("กรุณากรอกรหัสตำแหน่ง");
		}else if(frm1.school_name.value==""){
			alert("กรุณากรอกชื่อตำแหน่ง");
		}else if(frm1.school_type.value==""){
			alert("กรุณาเลือกประเภทสถานศึกษา");
		}else{
			callfrm("?file=school&task=school&index=6");   //page ประมวลผล
		}
	}
}
</script>
