<link rel="stylesheet" href="//netdna.bootstrapcdn.com/bootstrap/3.3.2/css/bootstrap.min.css">
<link rel="stylesheet" href="//netdna.bootstrapcdn.com/font-awesome/3.2.1/css/font-awesome.min.css">
<?php
/** ensure this file is being included by a parent file */
defined( '_VALID_' ) or die( 'Direct Access to this location is not allowed.' );
?>

<script type="text/javascript" src="jquery/jquery-1.5.1.js"></script>
<script type="text/javascript">
$(function(){
	$("select#department").change(function(){
		var datalist2 = $.ajax({	// รับค่าจาก ajax เก็บไว้ที่ตัวแปร datalist2
			  url: "admin/section/default/return_ajax_subdep.php", // ไฟล์สำหรับการกำหนดเงื่อนไข
			  data:"department="+$(this).val(), // ส่งตัวแปร GET ชื่อ department ให้มีค่าเท่ากับ ค่าของ department
			  async: false
		}).responseText;
		$("select#subdep").html(datalist2); // นำค่า datalist2 มาแสดงใน listbox ที่ 2
		// ชื่อตัวแปร และ element ต่างๆ สามารถเปลี่ยนไปตามการกำหนด
        removeOptions(document.getElementById("person_id")); // clear dropdrowlist person_id when click department
	});
});
$(function(){
	$("select#subdep").change(function(){
		var datalist2 = $.ajax({	// รับค่าจาก ajax เก็บไว้ที่ตัวแปร datalist2
			  url: "admin/section/default/return_ajax_person.php", // ไฟล์สำหรับการกำหนดเงื่อนไข
			  data:"subdep="+$(this).val(), // ส่งตัวแปร GET ชื่อ subdep ให้มีค่าเท่ากับ ค่าของ subdepartment
			  async: false
		}).responseText;
		$("select#person_id").html(datalist2); // นำค่า datalist2 มาแสดงใน listbox ที่ 2
		// ชื่อตัวแปร และ element ต่างๆ สามารถเปลี่ยนไปตามการกำหนด
	});
});
function removeOptions(selectbox){
    var i;
    for(i=selectbox.options.length-1;i>=1;i--){
        selectbox.remove(i);
    }
}
</script>
<?php
//ส่วนหัว
echo "<br />";
if(!(($index==1) or ($index==2) or ($index==5))){
echo "<tableclass='table table-hover table-bordered table-striped table-condensed'>";
echo "<tr align='center'><td><font color='#006666' size='3'><strong>พนักงานขับรถ</strong></font></td></tr>";
echo "</table>";
}

//ส่วนฟอร์มรับข้อมูล
if($index==1){
echo "<form id='frm1' name='frm1'>";
echo "<Center>";
echo "<Font color='#006666' Size=3><B>เพิ่มพนักงานขับรถ</Font>";
echo "</Cener>";
echo "<Br><Br>";
echo "<Table class='table table-hover table-bordered table-striped table-condensed'>";
echo "<Tr><Td align='right' width=40%>เลือกสำนัก&nbsp;&nbsp;&nbsp;&nbsp;</Td>";
echo "<td><div align='left'><Select name='department' id='department' size='1'>";
echo  "<option  value = ''>เลือกสำนัก</option>" ;
$sql = "select * from  system_department order by department";
$dbquery = mysqli_query($connect,$sql);
While ($result_department = mysqli_fetch_array($dbquery)){
echo  "<option  value ='$result_department[department]'>$result_department[department] $result_department[department_name]</option>" ;
}
echo "</select>";
echo "</div></td></tr>";
echo "<Tr><Td align='right'>เลือกกลุ่ม&nbsp;&nbsp;&nbsp;&nbsp;</Td>";
echo "<td><div align='left'><Select name='subdep' id='subdep' size='1'>";
echo  "<option  value = ''>เลือกกลุ่ม</option>" ;
echo "</select>";
echo "</div></td></tr>";
echo "<Tr><Td align='right'>เลือกบุคลากร&nbsp;&nbsp;&nbsp;&nbsp;</Td>";
echo "<td><div align='left'><Select name='person_id' id='person_id' size='1'>";
echo  "<option  value = ''>เลือกบุคลากร</option>" ;
echo "</select>";
echo "</div></td></tr>";
echo "<tr><td align='right'>ปฏิบัติหน้าที่&nbsp;&nbsp;</td>";
echo "<td align='left'>ใช่&nbsp;&nbsp;<input  type=radio name='status' value='1' checked>&nbsp;&nbsp;ไม่ใช่&nbsp;&nbsp;<input  type=radio name='status' value='0'></td></tr>";
echo "<tr><td align='right'></td>";
echo "<td align='left'><INPUT TYPE='button' name='smb' value='ตกลง' onclick='goto_url(1)' class=entrybutton>&nbsp;&nbsp;&nbsp;<INPUT TYPE='button' name='back' value='ย้อนกลับ' onclick='goto_url(0)' class=entrybutton'></td></tr>";
echo "</Table>";
echo "</form>";
}

//ส่วนยืนยันการลบข้อมูล
if($index==2) {
echo "<table  class='table table-hover table-bordered table-striped table-condensed'>";
echo "<tr><td align='center'><font color='#990000' size='4'>โปรดยืนยันความต้องการลบข้อมูลอีกครั้ง</font><br></td></tr>";
echo "<tr><td align=center>";
echo "<INPUT TYPE='button' name='smb' value='ยืนยัน' onclick='location.href=\"?option=car&task=main/set_driver&index=3&id=$_GET[id]\"'>
		&nbsp;&nbsp;<INPUT TYPE='button' name='back' value='ยกเลิก' onclick='location.href=\"?option=car&task=main/set_driver\"'";
echo "</td></tr></table>";
}

//ส่วนลบข้อมูล
if($index==3){
$sql = "delete from car_driver where id=$_GET[id]";
$dbquery = mysqli_query($connect,$sql);
}

//ส่วนบันทึกข้อมูล
if($index==4){
$rec_date = date("Y-m-d");
$sql = "insert into car_driver (person_id, status, officer,rec_date) values ('$_POST[person_id]', '$_POST[status]','$_SESSION[login_user_id]','$rec_date')";
$dbquery = mysqli_query($connect,$sql);
}

//ส่วนฟอร์มแก้ไขข้อมูล
if ($index==5){
echo "<form id='frm1' name='frm1'>";
echo "<Center>";
echo "<Font color='#006666' Size=3><B>แก้ไข</B></Font>";
echo "</Cener>";
echo "<Br><Br>";

$sql = "select a.*,b.department,b.sub_department from car_driver a left outer join person_main b on a.person_id=b.person_id where a.id='$_GET[id]'";
$dbquery = mysqli_query($connect,$sql);
$ref_result = mysqli_fetch_array($dbquery);

echo "<Table  class='table table-hover table-bordered table-striped table-condensed'>";
echo "<Tr><Td align='right' width=40%>เลือกสำนัก&nbsp;&nbsp;&nbsp;&nbsp;</Td>";
echo "<td><div align='left'><Select name='department' id='department' size='1'>";
echo  "<option  value = ''>เลือกสำนัก</option>" ;
$sql = "select * from  system_department order by department";
$dbquery = mysqli_query($connect,$sql);
While ($result_department = mysqli_fetch_array($dbquery)){
		if($result_department['department']==$ref_result['department']){
		echo  "<option  value ='$result_department[department]' selected>$result_department[department] $result_department[department_name]</option>" ;
		}
		else{
		echo  "<option  value ='$result_department[department]'>$result_department[department] $result_department[department_name]</option>" ;
		}
}
echo "</select>";
echo "</div></td></tr>";

echo "<Tr><Td align='right'>เลือกกลุ่ม&nbsp;&nbsp;&nbsp;&nbsp;</Td>";
echo "<td><div align='left'><Select name='subdep' id='subdep' size='1'>";
echo  "<option  value = ''>เลือก</option>" ;
$sql = "select  * from system_subdepartment where department='$ref_result[department]' order by sub_department_name";
$dbquery = mysqli_query($connect,$sql);
While ($result = mysqli_fetch_array($dbquery))
   {
		$sub_department = $result['sub_department'];
		$sub_department_name = $result['sub_department_name'];
		if($sub_department==$ref_result['sub_department']){
		echo  "<option value = $sub_department selected>$sub_department_name</option>" ;
		}
		else{
		echo  "<option value = $sub_department>$sub_department_name</option>" ;
		}
	}
echo "</select>";
echo "</div></td></tr>";
echo "<Tr><Td align='right'>เลือกบุคลากร&nbsp;&nbsp;&nbsp;&nbsp;</Td>";
echo "<td><div align='left'><Select name='person_id' id='person_id' size='1'>";
echo  "<option  value = ''>เลือก</option>" ;
$sql = "select  * from person_main where department='$ref_result[department]' and sub_department = '$ref_result[sub_department]'and status='0' order by name";
$dbquery = mysqli_query($connect,$sql);
While ($result = mysqli_fetch_array($dbquery))
   {
		$person_id = $result['person_id'];
		$name = $result['name'];
		$surname = $result['surname'];
		if($person_id==$ref_result['person_id']){
		echo  "<option value = $person_id selected>$name $surname</option>" ;
		}
		else{
		echo  "<option value = $person_id>$name $surname</option>" ;
		}
	}
echo "</select>";
echo "</div></td></tr>";
			if($ref_result['status']==1){
			$p1_check1="checked";
			$p1_check2="";
			}
			else{
			$p1_check1="";
			$p1_check2="checked";
			}
echo   "<tr><td align='right'>ปฏิบัติหน้าที่&nbsp;&nbsp;</td>";
echo   "<td align='left'>ใช่&nbsp;&nbsp;<input  type=radio name='status' value='1' $p1_check1>&nbsp;&nbsp;ไม่ใช่&nbsp;&nbsp;<input  type=radio name='status' value='0' $p1_check2></td></tr>";
echo "<tr><td align='right'></td>";
echo "<td align='left'><INPUT TYPE='button' name='smb' value='ตกลง' onclick='goto_url_update(1)' class=entrybutton>&nbsp;&nbsp;&nbsp;&nbsp;<INPUT TYPE='button' name='back' value='ย้อนกลับ' onclick='goto_url_update(0)' class=entrybutton'></td></tr>";
echo "</Table>";
echo "<Br>";
echo "<Input Type=Hidden Name='id' Value='$_GET[id]'>";
echo "</form>";
}

//ส่วนปรับปรุงข้อมูล
if ($index==6){
$rec_date = date("Y-m-d");
$sql = "update car_driver set  person_id='$_POST[person_id]', status='$_POST[status]', officer='$_SESSION[login_user_id]', rec_date='$rec_date' where id='$_POST[id]'";
$dbquery = mysqli_query($connect,$sql);
}

//ส่วนแสดงผล
if(!(($index==1) or ($index==2) or ($index==5))){

$sql = "select car_driver.id, car_driver.status, person_main.prename, person_main.name, person_main.surname from car_driver left join person_main on car_driver.person_id=person_main.person_id order by car_driver.id";
$dbquery = mysqli_query($connect,$sql);
echo  "<table  class='table table-hover table-bordered table-striped table-condensed'>";
echo "<Tr><Td colspan='5' align='left'><INPUT TYPE='button' name='smb' value='เพิ่มพนักงานขับรถ' onclick='location.href=\"?option=car&task=main/set_driver&index=1\"'</Td></Tr>";

echo "<Tr bgcolor='#FFCCCC'><Td  align='center' rowspan='2' >ที่</Td><Td  align='center' rowspan='2' >ชื่อพนักงานขับรถ</Td><td  align='center'>สถานะ</td><Td align='center' rowspan='2' width='50'>ลบ</Td><Td align='center' rowspan='2' width='50'>แก้ไข</Td></Tr>";
echo "<tr bgcolor='#CC9900'><Td  align='center' width='80'>ปฏิบัติงาน</Td></tr>";
$M=1;
While ($result = mysqli_fetch_array($dbquery))
	{
		$id = $result['id'];
		$prename = $result['prename'];
		$name = $result['name'];
		$surname = $result['surname'];
			if($result['status']==1){
			$p1_pic="<img src=images/yes.png border='0' alt='ปฏิบัติหน้าที่'>";			}
			else{
			$p1_pic="<img src=images/no.png border='0' alt='ไม่ได้ปฏิบัติหน้าที่'>";		}
			if(($M%2) == 0)
			$color="#FFFFC";
			else  	$color="#FFFFFF";
		echo "<Tr bgcolor=$color><Td align='center' width='50'>$M</Td><Td  align='left'>$prename$name $surname</Td><Td align='center'>$p1_pic</Td>
		<Td align='center' width='50' ><a href=?option=car&task=main/set_driver&index=2&id=$id><img src=images/drop.png border='0' alt='ลบ'></a></Td>
		<Td align='center' width='50'><a href=?option=car&task=main/set_driver&index=5&id=$id><img src=images/edit.png border='0' alt='แก้ไข'></a></Td>
	</Tr>";
$M++;
	}
echo "</Table>";
}

?>
<script>
function goto_url(val){
	if(val==0){
		callfrm("?option=car&task=main/set_driver");   // page ย้อนกลับ
	}else if(val==1){
		if(frm1.person_id.value == ""){
			alert("กรุณาเลือกบุคลากร");
		}else{
			callfrm("?option=car&task=main/set_driver&index=4");   //page ประมวลผล
		}
	}
}

function goto_url_update(val){
	if(val==0){
		callfrm("?option=car&task=main/set_driver");   // page ย้อนกลับ
	}else if(val==1){
		if(frm1.person_id.value == ""){
			alert("กรุณาเลือกบุคลากร");
		}else{
			callfrm("?option=car&task=main/set_driver&index=6");   //page ประมวลผล
		}
	}
}
</script>
