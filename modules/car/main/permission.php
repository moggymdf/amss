<?php
/** ensure this file is being included by a parent file */
defined( '_VALID_' ) or die( 'Direct Access to this location is not allowed.' );
?>
<script type="text/javascript" src="jquery/jquery-1.5.1.js"></script> 
<script type="text/javascript">
$(function(){
	$("select#department").change(function(){
		var datalist2 = $.ajax({	// รับค่าจาก ajax เก็บไว้ที่ตัวแปร datalist2
			  url: "admin/section/default/return_ajax_person.php", // ไฟล์สำหรับการกำหนดเงื่อนไข
			  data:"department="+$(this).val(), // ส่งตัวแปร GET ชื่อ department ให้มีค่าเท่ากับ ค่าของ department
			  async: false
		}).responseText;		
		$("select#person_id").html(datalist2); // นำค่า datalist2 มาแสดงใน listbox ที่ 2 
		// ชื่อตัวแปร และ element ต่างๆ สามารถเปลี่ยนไปตามการกำหนด
	});
});

</script>
<?php
//ส่วนหัว
echo "<br />";
if(!(($index==1) or ($index==2) or ($index==5))){
echo "<table width='50%' border='0' align='center'>";
echo "<tr align='center'><td><font color='#006666' size='3'><strong>เจ้าหน้าที่ ผู้ให้ความเห็นชอบ  และผู้อนุมัติ</strong></font></td></tr>";
echo "</table>";
}

//ส่วนฟอร์มรับข้อมูล
if($index==1){
echo "<form id='frm1' name='frm1'>";
echo "<Center>";
echo "<Font color='#006666' Size=3><B>กำหนดเจ้าหน้าที่ ผู้ให้ความเห็นชอบ  และผู้อนุมัติ</Font>";
echo "</Cener>";
echo "<Br><Br>";
echo "<Table width='50%' Border='0' Bgcolor='#Fcf9d8' style='padding:15px;'>";

echo "<Tr><Td align='right'>สำนัก&nbsp;&nbsp;&nbsp;&nbsp;</Td>";
echo "<td><div align='left'><Select name='department' id='department' size='1'>";
echo  "<option  value = ''>เลือกสำนัก</option>" ;
$sql = "select * from  system_department order by department";
$dbquery = mysqli_query($connect,$sql);
While ($result_department = mysqli_fetch_array($dbquery)){
echo  "<option  value ='$result_department[department]'>$result_department[department] $result_department[department_name]</option>" ;
}	
echo "</select>";
echo "</div></td></tr>";

echo "<Tr><Td align='right'>บุคลากร&nbsp;&nbsp;&nbsp;&nbsp;</Td>";
echo "<td><div align='left'><Select name='person_id' id='person_id' size='1'>";
echo  "<option  value = ''>เลือกบุคลากร</option>" ;
echo "</select>";
echo "</div></td></tr>";
echo   "<tr><td align='right'>เจ้าหน้าที่&nbsp;&nbsp;</td>";
echo   "<td align='left'><input  type='radio' name='car_permission1' value='1'></td></tr>";
echo   "<tr><td align='right'>ผู้ให้ความเห็นชอบ&nbsp;&nbsp;</td>";
echo   "<td align='left'><input  type='radio' name='car_permission1' value='2'></td></tr>";
echo   "<tr><td align='right'>ผู้อนุมัติ&nbsp;&nbsp;</td>";
echo   "<td align='left'><input  type='radio' name='car_permission1' value='3'></td></tr>";

echo "<tr><td>&nbsp;</td><td>&nbsp;</td></tr>";
echo "<tr><td align='right'><INPUT TYPE='button' name='smb' value='ตกลง' onclick='goto_url(1)' class=entrybutton>
	&nbsp;&nbsp;&nbsp;</td>";
echo "<td align='left'><INPUT TYPE='button' name='back' value='ย้อนกลับ' onclick='goto_url(0)' class=entrybutton'></td></tr>";
echo "</Table>";
echo "</form>";
}

//ส่วนยืนยันการลบข้อมูล
if($index==2) {
echo "<table width='500' border='0' align='center'>";
echo "<tr><td align='center'><font color='#990000' size='4'>โปรดยืนยันความต้องการลบข้อมูลอีกครั้ง</font><br></td></tr>";
echo "<tr><td align=center>";
echo "<INPUT TYPE='button' name='smb' value='ยืนยัน' onclick='location.href=\"?option=car&task=main/permission&index=3&id=$_GET[id]\"'>
		&nbsp;&nbsp;<INPUT TYPE='button' name='back' value='ยกเลิก' onclick='location.href=\"?option=car&task=main/permission\"'";
echo "</td></tr></table>";
}

//ส่วนลบข้อมูล
if($index==3){
$sql = "delete from car_permission where id=$_GET[id]";
$dbquery = mysqli_query($connect,$sql);
echo "<script>document.location.href='?option=car&task=main/permission'; </script>\n";
}

//ส่วนบันทึกข้อมูล
if($index==4){
$rec_date = date("Y-m-d");
$sql = "insert into car_permission (person_id, p1, officer,rec_date) values ('$_POST[person_id]', '$_POST[car_permission1]', '$_SESSION[login_user_id]','$rec_date')";
$dbquery = mysqli_query($connect,$sql);
echo "<script>document.location.href='?option=car&task=main/permission'; </script>\n";
}

//ส่วนฟอร์มแก้ไขข้อมูล
if ($index==5){
echo "<form id='frm1' name='frm1'>";
echo "<Center>";
echo "<Font color='#006666' Size=3><B>แก้ไข</B></Font>";
echo "</Cener>";
echo "<Br><Br>";
echo "<Table width='50%' Border= '0' Bgcolor='#Fcf9d8'>";
$sql = "select * from car_permission where id='$_GET[id]'";
$dbquery = mysqli_query($connect,$sql);
$ref_result = mysqli_fetch_array($dbquery);
echo "<Tr><Td align='right'>บุคลากร&nbsp;&nbsp;&nbsp;&nbsp;</Td>";
echo "<td><div align='left'><Select  name='person_id'  size='1'>";
echo  "<option  value = ''>เลือก</option>" ;
$sql = "select  * from person_main where status='0' order by name";
$dbquery = mysqli_query($connect,$sql);
While ($result = mysqli_fetch_array($dbquery))
   {
		$person_id = $result['person_id'];
		$name = $result['name'];
		$surname = $result['surname'];
		if($person_id==$ref_result['person_id']){
		echo  "<option value = $person_id selected>$name $surname</option>";
		}
		else{
		echo  "<option value = $person_id>$name $surname</option>";
		}
	}
echo "</select>";
echo "</div></td></tr>";
$p1_check1="";  $p1_check2="";  $p1_check3="";

			if($ref_result['p1']==1){
			$p1_check1="checked";
			}
			else if($ref_result['p1']==2){
			$p1_check2="checked";
			}
			else if($ref_result['p1']==3){
			$p1_check3="checked";
			}
echo   "<tr><td align='right'>เจ้าหน้าที่&nbsp;&nbsp;</td>";
echo   "<td align='left'><input  type='radio' name='car_permission1' value='1' $p1_check1></td></tr>";
echo   "<tr><td align='right'>ผู้ให้ความเห็นชอบ&nbsp;&nbsp;</td>";
echo   "<td align='left'><input  type='radio' name='car_permission1' value='2' $p1_check2></td></tr>";
echo   "<tr><td align='right'>ผู้อนุมัติ&nbsp;&nbsp;</td>";
echo   "<td align='left'><input  type='radio' name='car_permission1' value='3' $p1_check3></td></tr>";

echo "<tr><td>&nbsp;</td><td>&nbsp;</td></tr>";
echo "<tr><td align='right'><INPUT TYPE='button' name='smb' value='ตกลง' onclick='goto_url_update(1)' class=entrybutton>&nbsp;&nbsp;&nbsp;&nbsp;</td>";
echo "<td align='left'><INPUT TYPE='button' name='back' value='ย้อนกลับ' onclick='goto_url_update(0)' class=entrybutton'></td></tr>";
echo "</Table>";
echo "<Br>";
echo "<Input Type=Hidden Name='id' Value='$_GET[id]'>";
echo "</form>";
}

//ส่วนปรับปรุงข้อมูล
if ($index==6){
$rec_date = date("Y-m-d");
$sql = "update car_permission set  person_id='$_POST[person_id]', p1='$_POST[car_permission1]', officer='$_SESSION[login_user_id]', rec_date='$rec_date' where id='$_POST[id]'";
$dbquery = mysqli_query($connect,$sql);
echo "<script>document.location.href='?option=car&task=main/permission'; </script>\n";
}

//ส่วนแสดงผล
if(!(($index==1) or ($index==2) or ($index==5))){

$sql = "select car_permission.id, car_permission.p1, person_main.prename, person_main.name, person_main.surname from car_permission left join person_main on car_permission.person_id=person_main.person_id  order by car_permission.p1";
$dbquery = mysqli_query($connect,$sql);
echo  "<table width='60%' border='0' align='center'>";
echo "<Tr><Td colspan='5' align='left'><INPUT TYPE='button' name='smb' value='เพิ่มข้อมูล' onclick='location.href=\"?option=car&task=main/permission&index=1\"'></Td></Tr>";

echo "<Tr bgcolor='#FFCCCC'><Td  align='center' rowspan='2' >ที่</Td><Td  align='center' rowspan='2' >ชื่อเจ้าหน้าที่</Td><td  align='center' colspan='3'>สิทธื์</td><Td align='center' rowspan='2' width='50'>ลบ</Td><Td align='center' rowspan='2' width='50'>แก้ไข</Td></Tr>";
echo "<tr bgcolor='#CC9900'><Td  align='center' width='80'>เจ้าหน้าที่</Td><Td  align='center' width='80'>ผู้เห็นชอบ</Td><Td  align='center' width='80'>ผู้อนุมัติ</Td></tr>";
$M=1;
While ($result = mysqli_fetch_array($dbquery))
	{
		$id = $result['id'];
		$prename = $result['prename'];
		$name = $result['name'];
		$surname = $result['surname'];
		
			$p1_pic="";
			$p2_pic="";
			$p3_pic="";
			if($result['p1']==1){
			$p1_pic="<img src=images/yes.png border='0' alt='มีสิทธิ์'>";	
			}
			else if($result['p1']==2){
			$p2_pic="<img src=images/yes.png border='0' alt='มีสิทธิ์'>";	
			}
			else if($result['p1']==3){
			$p3_pic="<img src=images/yes.png border='0' alt='มีสิทธิ์'>";
			}
			
			if(($M%2) == 0)
			$color="#FFFFC";
			else  	$color="#FFFFFF";
		echo "<Tr bgcolor=$color><Td align='center' width='50'>$M</Td><Td  align='left'>$prename$name $surname</Td><Td align='center'>$p1_pic</Td><Td align='center'>$p2_pic</Td><Td align='center'>$p3_pic</Td>
		<Td align='center' width='50' ><a href=?option=car&task=main/permission&index=2&id=$id><img src=images/drop.png border='0' alt='ลบ'></a></Td>
		<Td align='center' width='50'><a href=?option=car&task=main/permission&index=5&id=$id><img src=images/edit.png border='0' alt='แก้ไข'></a></Td>
	</Tr>";
$M++;
	}
echo "</Table>";
}

?>
<script>
function goto_url(val){
	if(val==0){
		callfrm("?option=car&task=main/permission");   // page ย้อนกลับ 
	}else if(val==1){
		if(frm1.person_id.value == ""){
		alert("กรุณาเลือกบุคลากร");
		}
		else if(frm1.car_permission1[0].checked ==false && frm1.car_permission1[1].checked ==false && frm1.car_permission1[2].checked ==false ){
			alert("กรุณาเลือกเจ้าหน้าที่ หรือผู้เห็นชอบ หรือผู้อนุมัติ ");
		}else{
			callfrm("?option=car&task=main/permission&index=4");   //page ประมวลผล
		}
	}
}

function goto_url_update(val){
	if(val==0){
		callfrm("?option=car&task=main/permission");   // page ย้อนกลับ 
	}else if(val==1){
		if(frm1.person_id.value == ""){
			alert("กรุณาเลือกบุคลากร");
		}else{
			callfrm("?option=car&task=main/permission&index=6");   //page ประมวลผล
		}
	}
}
</script>
