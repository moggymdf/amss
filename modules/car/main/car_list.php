<?php
/** ensure this file is being included by a parent file */
defined( '_VALID_' ) or die( 'Direct Access to this location is not allowed.' );
//sd page
if($result_permission['p1']!=1){
exit();
}

//ฟังชั่นupload
function file_upload() {
		$uploaddir = 'modules/car/upload_files/';      //ที่เก็บไไฟล์
		$uploadfile = $uploaddir.basename($_FILES['userfile']['name']);
		$basename = basename($_FILES['userfile']['name']);

		$pic_code=$_POST['car_code'];
		//ลบไฟล์เดิม
		$exists_file=$uploaddir.$pic_code.substr($basename,-4);
		if(file_exists($exists_file)){
		unlink($exists_file);
		}

		if (move_uploaded_file($_FILES['userfile']['tmp_name'],  $uploadfile))
			{
				$before_name  = $uploaddir.$basename;
				$changed_name = $uploaddir.$pic_code.substr($basename,-4) ;
				rename("$before_name" , "$changed_name");

		//ลดขนาดภาพ
				if(substr($basename,-3)=="jpg"){
				$ori_file=$changed_name;
				$ori_size=getimagesize($ori_file);
				$ori_w=$ori_size[0];
				$ori_h=$ori_size[1];
					if($ori_w>500){
					$new_w=500;
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

echo "<br />";
if(!(($index==1) or ($index==2) or ($index==5))){
echo "<table width='100%' border='0' align='center'>";
echo "<tr align='center'><td><font color='#006666' size='3'><strong>ยานพาหนะ</strong></font></td></tr>";
echo "</table>";
}

//ส่วนเพิ่มข้อมูล
if($index==1){
echo "<form Enctype = multipart/form-data id='frm1' name='frm1'>";
echo "<Center>";
echo "<Font color='#006666' Size=3><B>เพิ่มยานพาหนะ</B></Font>";
echo "</Cener>";
echo "<Br><Br>";
echo "<Table   width='60%' Border='0'>";
echo "<Tr align='left'><Td  align='right'>ประเภท&nbsp;&nbsp;</Td>";
echo "<td><div align='left'><Select  name='car_type' id='car_type' size='1'>";
echo  "<option  value = ''>เลือก</option>" ;
$sql = "select * from  car_type  order by code";
$dbquery = mysqli_query($connect,$sql);
While ($result = mysqli_fetch_array($dbquery))
   {
   $name=$result['name'];
		echo  "<option value = $result[code]>$result[code] $name</option>" ;
	}
echo "</select>";
echo "</div></td></tr>";

echo "<Tr align='left'><Td  align='right'>รหัสยานพาหนะ&nbsp;&nbsp;</Td><Td><Input Type='Text' Name='car_code' id='car_code' Size='3'  maxlength='3' onkeydown='integerOnly()'></Td></Tr>";

echo "<Tr align='left'><Td  align='right'>เลขทะเบียน&nbsp;&nbsp;</Td><Td><Input Type='Text' Name='car_number' id='car_number' Size='20'></Td></Tr>";

echo "<Tr align='left'><Td  align='right'>ชื่อยานพาหนะ&nbsp;&nbsp;</Td><Td><Input Type='Text' Name='car_name' id='car_name' Size='60'></Td></Tr>";

echo "<Tr><Td align='right'>สถานะ&nbsp;&nbsp;&nbsp;&nbsp;</Td>";
echo "<td><div align='left'><Select  name='status'  id='status' size='1'>";
echo  "<option  value = ''>เลือก</option>" ;
echo  "<option value = '1'>1.พาหนะปัจจุบันใช้งานเฉพาะ</option>";
echo  "<option value = '2'>2.พาหนะปัจจุบันอนุญาตให้จองใช้งาน </option>";
echo  "<option value = '3'>3.พาหนะที่เคยใช้งาน </option>";
echo "</select>";
echo "</div></td></tr>";

echo  "<tr align='left'>";
echo  "<td align='right'>ไฟล์รูปภาพ&nbsp;&nbsp;</td>";
echo  "<td align='left'><input name = 'userfile' type = 'file'></td>";
echo  "</tr>";

echo "<Br>";
echo "</Table>";
echo "<Br>";
echo "<INPUT TYPE='button' name='smb' value='ตกลง' onclick='goto_url(1)' class=entrybutton>
		&nbsp;&nbsp;<INPUT TYPE='button' name='back' value='ย้อนกลับ' onclick='goto_url(0)' class=entrybutton'>";
echo "</form>";
echo "<br /><br />";
}

//ส่วนยืนยันการลบข้อมูล
if($index==2) {
echo "<table width='500' border='0' align='center'>";
echo "<tr><td align='center'><font color='#990000' size='4'>โปรดยืนยันความต้องการลบข้อมูลอีกครั้ง</font><br></td></tr>";
echo "<tr><td align=center>";
echo "<INPUT TYPE='button' name='smb' value='ยืนยัน' onclick='location.href=\"?option=car&task=main/car_list&index=3&id=$_GET[id]&page=$_REQUEST[page]\"'>
		&nbsp;&nbsp;<INPUT TYPE='button' name='back' value='ยกเลิก' onclick='location.href=\"?option=car&task=main/car_list&page=$_REQUEST[page]\"'";
echo "</td></tr></table>";
}

//ส่วนลบข้อมูล
if($index==3){
$sql = "delete from car_car where id=$_GET[id]";
$dbquery = mysqli_query($connect,$sql);
}

//ส่วนเพิ่มข้อมูล
if($index==4){
$basename = basename($_FILES['userfile']['name']);
if ($basename!="")
{
$changed_name = file_upload();
}

$sql = "select  * from  car_car where  car_code='$_POST[car_code]'  ";
$dbquery = mysqli_query($connect,$sql);
$num_rows=mysqli_num_rows($dbquery);
		if($num_rows>=1){
					?>
					<script>
					alert("รหัสยานพาหนะมีอยู่แล้ว  ยกเลิกการบันทึกข้อมูล");
					</script>
					<?php
		}
		else {
		$sql = "insert into car_car (car_code, car_type, car_number, name,  pic, status) values ('$_POST[car_code]', '$_POST[car_type]','$_POST[car_number]','$_POST[car_name]', '$changed_name' , '$_POST[status]' )";
		$dbquery = mysqli_query($connect,$sql);
		}
}

//ส่วนฟอร์มแก้ไขข้อมูล
if ($index==5){
echo "<form Enctype = multipart/form-data id='frm1' name='frm1'>";
echo "<Center>";
echo "<Font color='#006666' Size=3><B>แก้ไข</B></Font>";
echo "</Cener>";
echo "<Br><Br>";
$sql = "select * from  car_car where id='$_GET[id]'";
$dbquery = mysqli_query($connect,$sql);
$result_ref = mysqli_fetch_array($dbquery);

echo "<Table  width='60%' Border='0' >";
echo "<Tr align='left'><Td  align='right'>ประเภท&nbsp;&nbsp;</Td>";
echo "<td><div align='left'><Select  name='car_type' id='car_type' size='1'>";
echo  "<option  value = ''>เลือก</option>" ;
$sql = "select * from  car_type  order by code";
$dbquery = mysqli_query($connect,$sql);
While ($result = mysqli_fetch_array($dbquery))
   {
   $name=$result['name'];
		   if($result_ref ['car_type']==$result[code]){
			echo  "<option value = $result[code] selected>$result[code] $name</option>" ;
			}
			else{
			echo  "<option value = $result[code]>$result[code] $name</option>" ;
			}
	}
echo "</select>";
echo "</div></td></tr>";

echo "<Tr align='left'><Td  align='right'>รหัสยานพาหนะ&nbsp;&nbsp;</Td><Td><Input Type='Text' Name='car_code' id='car_code' Size='3'  maxlength='3'  value='$result_ref[car_code]'  onkeydown='integerOnly()'></Td></Tr>";

echo "<Tr align='left'><Td  align='right'>เลขทะเบียน&nbsp;&nbsp;</Td><Td><Input Type='Text' Name='car_number' id='car_number' Size='20' value='$result_ref[car_number]' ></Td></Tr>";

echo "<Tr align='left'><Td  align='right'>ชื่อยานพาหนะ&nbsp;&nbsp;</Td><Td><Input Type='Text' Name='car_name' id='car_name' Size='60' value='$result_ref[name]' ></Td></Tr>";

echo "<Tr><Td align='right'>สถานะ&nbsp;&nbsp;&nbsp;&nbsp;</Td>";
echo "<td><div align='left'><Select  name='status'  id='status' size='1'>";
echo  "<option  value = ''>เลือก</option>" ;

		if($result_ref[status]==1){
		$selected_1="selected";
		$selected_2="";
		$selected_3="";
		}
		else if($result_ref[status]==2){
		$selected_1="";
		$selected_2="selected";
		$selected_3="";
		}
		else if($result_ref[status]==3){
		$selected_1="";
		$selected_2="";
		$selected_3="selected";
		}
echo  "<option value = '1' $selected_1>1.พาหนะปัจจุบันใช้งานเฉพาะ</option>";
echo  "<option value = '2' $selected_2>2.พาหนะปัจจุบันอนุญาตให้จองใช้งาน </option>";
echo  "<option value = '3' $selected_3>3.พาหนะที่เคยใช้งาน </option>";
echo "</select>";
echo "</div></td></tr>";

echo  "<tr align='left'>";
echo  "<td align='right'>ไฟล์รูปภาพ&nbsp;&nbsp;</td>";
echo  "<td align='left'><input name = 'userfile' type = 'file'></td>";
echo  "</tr>";
echo "</Table>";
echo "<Br>";
echo "<Input Type=Hidden Name='id' Value='$_GET[id]'>";
echo "<Input Type=Hidden Name='page' Value='$_GET[page]'>";
echo "<INPUT TYPE='button' name='smb' value='ตกลง' onclick='goto_url_update(1)' class=entrybutton>
		&nbsp;&nbsp;<INPUT TYPE='button' name='back' value='ย้อนกลับ' onclick='goto_url_update(0)' class=entrybutton'>";

echo "</form>";
}

//ส่วนปรับปรุงข้อมูล
if ($index==6){
$sql = "select * from car_car where  car_code='$_POST[car_code]' and  id!='$_POST[id]' ";
$dbquery = mysqli_query($connect,$sql);
if(mysqli_num_rows($dbquery)>=1){
echo "<br /><div align='center'>มีรหัสซ้ำกับรายการที่มีอยู่แล้ว ตรวจสอบอีกครั้ง</div>";
exit();
}
$basename = basename($_FILES['userfile']['name']);
if ($basename!=""){
$changed_name = file_upload();
$sql = "update car_car set  car_code='$_POST[car_code]',
car_type='$_POST[car_type]',
car_number='$_POST[car_number]',
name='$_POST[car_name]',
status='$_POST[status]',
pic='$changed_name'
where id='$_POST[id]'";
}
else{
$sql = "update car_car set  car_code='$_POST[car_code]',
car_type='$_POST[car_type]',
car_number='$_POST[car_number]',
name='$_POST[car_name]',
status='$_POST[status]'
where id='$_POST[id]'";
}
$dbquery = mysqli_query($connect,$sql);
}

//ส่วนแสดง
if(!(($index==1) or ($index==2) or ($index==5))){
	//ส่วนของการแยกหน้า
$pagelen=20;  // 1_กำหนดแถวต่อหน้า
$url_link="option=car&task=main/car_list";  // 2_กำหนดลิงค์ฺ
$sql = "select * from car_car "; // 3_กำหนด sql

$dbquery = mysqli_query($connect,$sql);
$num_rows = mysqli_num_rows($dbquery );
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

$sql = "select car_car.id, car_car.car_code, car_car.name as car_name, car_car.car_number, car_type.name, car_car.status, car_car.pic from  car_car left join car_type on car_car.car_type=car_type.code  order by  car_car.car_type, car_car.car_code limit $start,$pagelen";

$dbquery = mysqli_query($connect,$sql);
echo  "<table width='85%' border='0' align='center'>";
echo "<Tr><Td colspan='6' align='left'><INPUT TYPE='button' name='smb' value='เพิ่มข้อมูล' onclick='location.href=\"?option=car&task=main/car_list&index=1\"'>";
echo "</Td></Tr>";

echo "<Tr bgcolor=#FFCCCC align=center class=style2><Td width='50'>ที่</Td><Td width='100'>รหัส</Td><Td width='200'>ประเภทยานพาหนะ</Td><Td>ชื่อยานพาหนะ</Td><Td>เลขทะเบียน</Td><Td>สถานะภาพ</Td><Td align='center' width='50'>รูป</Td><Td align='center' width='50'>ลบ</Td><Td align='center' width='50'>แก้ไข</Td></Tr>";
$N=(($page-1)*$pagelen)+1;  //*เกี่ยวข้องกับการแยกหน้า
$M=1;
While ($result = mysqli_fetch_array($dbquery))
	{
		$id = $result['id'];
		$car_code= $result['car_code'];
		$car_type= $result['name'];
		$car_name = $result['car_name'];
		$car_number = $result['car_number'];
		$status = $result['status'];
				if($status==1){
				$status="<font color='#FF9933'>พาหนะปัจจุบันใช้งานเฉพาะ</font>";
				}
				else if ($status==2){
				$status="พาหนะปัจจุบันอนุญาตให้จองใช้งาน";
				}
				else if ($status==3){
				$status="<font color='#FF0000'>พาหนะที่เคยใช้งาน</font>";
				}

			if(($M%2) == 0)
			$color="#FFFFC";
			else  	$color="#FFFFFF";

		echo "<Tr  bgcolor=$color align=center class=style1><Td>$N</Td><Td>$car_code</Td><Td align='left'>$car_type</Td><Td align=left>$car_name</Td><Td align=left>$car_number</Td><Td align=left>$status</Td>";
if($result['pic']!=""){
echo "<Td align='center'><a href='modules/car/main/pic_show.php?&id=$id' target='_blank'><img src=images/admin/user.gif border='0' alt='รูปภาพ'></a></Td>";
}
else{
echo "<Td align='center'>&nbsp;</Td>";
}
echo "<Td><div align=center><a href=?option=car&task=main/car_list&index=2&id=$id&page=$page><img src=images/drop.png border='0' alt='ลบ'></a></div></Td>
		<Td><a href=?option=car&task=main/car_list&index=5&id=$id&page=$page><img src=images/edit.png border='0' alt='แก้ไข'></a></div></Td>
	</Tr>";
$M++;
$N++;  //*เกี่ยวข้องกับการแยกหน้า
	}
echo "</Table>";
}

?>
<script>
function goto_url(val){
	if(val==0){
		callfrm("?option=car&task=main/car_list");   // page ย้อนกลับ
	}else if(val==1){
		if(frm1.car_type.value == ""){
			alert("กรุณาเลือกประเภท");
		}else if(frm1.car_code.value==""){
			alert("กรุณากรอกรหัสยานพาหนะ");
		}else if(frm1.car_number.value==""){
			alert("กรุณากรอกเลขทะเบียนยานพาหนะ");
		}else if(frm1.car_name.value==""){
			alert("กรุณากรอกชื่อยานพาหนะ");
		}else if(frm1.status.value==""){
			alert("กรุณาเลือกสถานะ");
		}else{
			callfrm("?option=car&task=main/car_list&index=4");   //page ประมวลผล
		}
	}
}

function goto_url_update(val){
	if(val==0){
		callfrm("?option=car&task=main/car_list");   // page ย้อนกลับ
	}else if(val==1){
		if(frm1.car_type.value == ""){
			alert("กรุณาเลือกประเภท");
		}else if(frm1.car_code.value==""){
			alert("กรุณากรอกรหัสยานพาหนะ");
		}else if(frm1.car_number.value==""){
			alert("กรุณากรอกเลขทะเบียนยานพาหนะ");
		}else if(frm1.car_name.value==""){
			alert("กรุณากรอกชื่อยานพาหนะ");
		}else if(frm1.status.value==""){
			alert("กรุณาเลือกสถานะ");
		}else{
			callfrm("?option=car&task=main/car_list&index=6");   //page ประมวลผล
		}
	}
}
</script>
