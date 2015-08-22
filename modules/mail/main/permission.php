<?php
/** ensure this file is being included by a parent file */
defined( '_VALID_' ) or die( 'Direct Access to this location is not allowed.' );
$admin_meeting=mysqli_real_escape_string($connect,$_SESSION['admin_mail']);
if($admin_meeting!='mail'){
exit();
}
$login_group=mysqli_real_escape_string($connect,$_SESSION['login_group']);
if(!($login_group<=1)){
exit();
}

if(!isset($_SESSION['login_user_id'])){ $_SESSION['login_user_id']=""; exit();
}else{
//หาหน่วยงาน
$login_user_id=mysqli_real_escape_string($connect,$_SESSION['login_user_id']);
    $sql_user_depart="select * from person_main where person_id=? ";
    $query_user_depart = $connect->prepare($sql_user_depart);
    $query_user_depart->bind_param("i", $login_user_id);
    $query_user_depart->execute();
    $result_quser_depart=$query_user_depart->get_result();
While ($result_user_depart = mysqli_fetch_array($result_quser_depart))
   {
    $user_departid=$result_user_depart['department'];
    }
//หาชื่อหน่วยงาน
    $sql_depart_name="select * from system_department where department=? ";
    $query_depart_name = $connect->prepare($sql_depart_name);
    $query_depart_name->bind_param("i", $user_departid);
    $query_depart_name->execute();
    $result_qdepart_name=$query_depart_name->get_result();
While ($result_depart_name = mysqli_fetch_array($result_qdepart_name))
   {
    $user_department_name=$result_depart_name['department_name'];
    $user_department_precisname=$result_depart_name['department_precis'];
	}
}


//ตรวจสอบ POST
if(isset($_POST['index'])){
$postindex=mysqli_real_escape_string($connect,$_POST['index']);
}else {$postindex="";}

if(isset($_GET['index'])){
$index=mysqli_real_escape_string($connect,$_GET['index']);
}else {$index="";}

//ส่วนหัว
echo "<br />";
if(!(($index==1) or ($index==2) or ($index==5))){
echo "<table width='50%' border='0' align='center'>";
echo "<tr align='center'><td><font color='#006666' size='3'><strong>เจ้าหน้าที่</strong></font></td></tr>";
echo "</table>";
}

//ส่วนฟอร์มรับข้อมูล
if($index==1){
echo "<form id='frm1' name='frm1'>";
echo "<Center>";
echo "<Font color='#006666' Size=3><B>เพิ่มเจ้าหน้าที่</Font>";
echo "</Cener>";
echo "<Br><Br>";
echo "<Table width='50%' Border='0' Bgcolor='#Fcf9d8' class='table table-hover table-bordered table-striped table-condensed'>";
echo "<Tr><Td align='right'>สำนัก&nbsp;&nbsp;&nbsp;&nbsp;</Td>";
echo "<td><div align='left' class='form-group'> $user_department_name";
echo "</div></td></tr>";
echo "<Tr><Td align='right'>บุคลากร&nbsp;&nbsp;&nbsp;&nbsp;</Td>";
echo "<td><div align='left' class='form-group'><Select name='person_id' class='selectpicker show-tick' title='เลือกบุคลากร' data-live-search='true'>";
//echo  "<option  value = ''>เลือกบุคลากร</option>" ;
    $sql = "select  * from person_main where department = ? and status=0 order by name";
    $dbquery_person = $connect->prepare($sql);
    $dbquery_person->bind_param("i", $user_departid);
    $dbquery_person->execute();
    $result_person=$dbquery_person->get_result();
    while($result_personname = $result_person->fetch_array())
   {
     $personname = $result_personname['prename'].$result_personname['name']." ".$result_personname['surname'];
     $personid = $result_personname['person_id'];

    $sql = "select  * from mail_permission where person_id=?";
    $dbquery_permiss = $connect->prepare($sql);
    $dbquery_permiss->bind_param("i", $personid);
    $dbquery_permiss->execute();
    $result_permiss=$dbquery_permiss->get_result();
     while($result_permissuser = $result_permiss->fetch_array())
    {
         $permissid = $result_permissuser["person_id"];
     }

        if($permissid!=$personid){
        echo "<option  value ='$personid'> $personname</option>" ;
        }
    }

echo "</select>";
echo "</div></td></tr>";
echo   "<tr><td align='right'>อนุญาตให้เป็นเจ้าหน้าที่&nbsp;&nbsp;</td>";
echo   "<td align='left'>ใช่<input  type=radio name='mail_permission1' value='1' checked>&nbsp;&nbsp;ไม่ใช่<input  type=radio name='mail_permission1' value='0'></td></tr>";

echo "<tr><td>&nbsp;</td><td>&nbsp;</td></tr>";
echo "<tr><td align='right'><INPUT TYPE='button' name='smb'  class='btn btn-primary' value='ตกลง' onclick='goto_url(1)' class=entrybutton>
	&nbsp;&nbsp;&nbsp;</td>";
echo "<td align='left'><INPUT TYPE='button' name='back' class='btn btn-default' value='ย้อนกลับ' onclick='goto_url(0)' class=entrybutton'></td></tr>";
echo "</Table>";
echo "</form>";
}

//ส่วนยืนยันการลบข้อมูล
if($index==2) {
echo "<table width='500' border='0' align='center'>";
echo "<tr><td align='center'><font color='#990000' size='4'>โปรดยืนยันความต้องการลบข้อมูลอีกครั้ง</font><br></td></tr>";
echo "<tr><td align=center>";
echo "<INPUT TYPE='button' name='smb' value='ยืนยัน' onclick='location.href=\"?option=mail&task=main/permission&index=3&id=$_GET[id]\"'>
		&nbsp;&nbsp;<INPUT TYPE='button' name='back' value='ยกเลิก' onclick='location.href=\"?option=mail&task=main/permission\"'";
echo "</td></tr></table>";
}

//ส่วนลบข้อมูล
if($index==3){
$sql = "delete from mail_permission where id=$_GET[id]";
$dbquery = mysqli_query($connect,$sql);
echo "<script>document.location.href='?option=mail&task=main/permission'; </script>\n";
}

//ส่วนบันทึกข้อมูล
if($index==4){
$rec_date = date("Y-m-d");
$sql = "insert into mail_permission (person_id, p1, officer,rec_date) values ('$_POST[person_id]', '$_POST[mail_permission1]','$_SESSION[login_user_id]','$rec_date')";
$dbquery = mysqli_query($connect,$sql);
echo "<script>document.location.href='?option=mail&task=main/permission'; </script>\n";
}

//ส่วนฟอร์มแก้ไขข้อมูล
if ($index==5){
echo "<form id='frm1' name='frm1'>";
echo "<Center>";
echo "<Font color='#006666' Size=3><B>แก้ไข เจ้าหน้าที่</B></Font>";
echo "</Cener>";
echo "<Br><Br>";
echo "<Table width='50%' Border= '0' Bgcolor='#Fcf9d8'>";
$sql = "select * from mail_permission where id='$_GET[id]'";
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
			if($ref_result['p1']==1){
			$p1_check1="checked";
			$p1_check2="";
			}
			else{
			$p1_check1="";
			$p1_check2="checked";
			}
echo   "<tr><td align='right'>อนุญาตให้เป็นเจ้าหน้าที่ได้&nbsp;&nbsp;</td>";
echo   "<td align='left'>ใช่<input  type=radio name='mail_permission1' value='1' $p1_check1>&nbsp;&nbsp;ไม่ใช่<input  type=radio name='mail_permission1' value='0' $p1_check2></td></tr>";

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
$sql = "update mail_permission set  person_id='$_POST[person_id]', p1='$_POST[mail_permission1]', officer='$_SESSION[login_user_id]', rec_date='$rec_date' where id='$_POST[id]'";
$dbquery = mysqli_query($connect,$sql);
echo "<script>document.location.href='?option=mail&task=main/permission'; </script>\n";
}

//ส่วนแสดงผล
if(!(($index==1) or ($index==2) or ($index==5))){

$sql = "select mail_permission.id, mail_permission.p1, person_main.name, person_main.surname from mail_permission left join person_main on mail_permission.person_id=person_main.person_id order by mail_permission.id";
$dbquery = mysqli_query($connect,$sql);
echo  "<table width=50% border=0 align=center>";
echo "<Tr><Td colspan='5' align='left'><INPUT TYPE='button' name='smb' value='เพิ่มเจ้าหน้าที่' onclick='location.href=\"?option=mail&task=main/permission&index=1\"'</Td></Tr>";

echo "<Tr bgcolor='#FFCCCC'><Td  align='center' rowspan='2' >ที่</Td><Td  align='center' rowspan='2' >ชื่อเจ้าหน้าที่</Td><td  align='center'>สิทธื์</td><Td align='center' rowspan='2' width='50'>ลบ</Td><Td align='center' rowspan='2' width='50'>แก้ไข</Td></Tr>";
echo "<tr bgcolor='#CC9900'><Td  align='center' width='80'>เจ้าหน้าที่</Td></tr>";
$M=1;
While ($result = mysqli_fetch_array($dbquery))
	{
		$id = $result['id'];
		$name = $result['name'];
		$surname = $result['surname'];
			if($result['p1']==1){
			$p1_pic="<img src=images/yes.png border='0' alt='มีสิทธิ์'>";			}
			else{
			$p1_pic="<img src=images/no.png border='0' alt='ไม่มีสิทธิ์'>";
			}
			if(($M%2) == 0)
			$color="#FFFFC";
			else  	$color="#FFFFFF";
		echo "<Tr bgcolor=$color><Td align='center' width='50'>$M</Td><Td  align='left'>$name $surname</Td><Td align='center'>$p1_pic</Td>
		<Td align='center' width='50' ><a href=?option=mail&task=main/permission&index=2&id=$id><img src=images/drop.png border='0' alt='ลบ'></a></Td>
		<Td align='center' width='50'><a href=?option=mail&task=main/permission&index=5&id=$id><img src=images/edit.png border='0' alt='แก้ไข'></a></Td>
	</Tr>";
$M++;
	}
echo "</Table>";
}

?>
<script>
function goto_url(val){
	if(val==0){
		callfrm("?option=mail&task=main/permission");   // page ย้อนกลับ
	}else if(val==1){
		if(frm1.person_id.value == ""){
			alert("กรุณาเลือกบุคลากร");
		}else{
			callfrm("?option=mail&task=main/permission&index=4");   //page ประมวลผล
		}
	}
}

function goto_url_update(val){
	if(val==0){
		callfrm("?option=mail&task=main/permission");   // page ย้อนกลับ
	}else if(val==1){
		if(frm1.person_id.value == ""){
			alert("กรุณาเลือกบุคลากร");
		}else{
			callfrm("?option=mail&task=main/permission&index=6");   //page ประมวลผล
		}
	}
}
</script>
