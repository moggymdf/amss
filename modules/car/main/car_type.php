<link rel="stylesheet" href="//netdna.bootstrapcdn.com/bootstrap/3.3.2/css/bootstrap.min.css">
<link rel="stylesheet" href="//netdna.bootstrapcdn.com/font-awesome/3.2.1/css/font-awesome.min.css">
<?php
/** ensure this file is being included by a parent file */
defined( '_VALID_' ) or die( 'Direct Access to this location is not allowed.' );
//sd page
if($result_permission['p1']!=1){
exit();
}

echo "<br />";

if(!(($index==1) or ($index==2) or ($index==5))){
echo "<table class='table table-hover table-bordered table-striped table-condensed'>";
echo "<tr align='center'><td><font color='#006666' size='3'><strong>ประเภทยานพาหนะ</strong></font></td></tr>";
echo "</table>";
}
//ส่วนเพิ่มข้อมูล
if($index==1){
echo "<form id='frm1' name='frm1'>";
echo "<Center>";
echo "<Font color='#006666' Size=3><B>เพิ่มข้อมูล</B></Font>";
echo "</Cener>";
echo "<Br><Br>";
echo "<table class='table table-hover table-bordered table-striped table-condensed'>";
echo "<Tr align='left'><Td align='right' width=40%>รหัส</Td><Td><Input Type='Text' Name='code' Size='5'></Td></Tr>";
echo "<Tr align='left'><Td align='right'>ชื่อประเภท</Td><Td><Input Type='Text' Name='name'  Size='40'></Td></Tr>";
echo "<Tr align='left'><Td align='right'></Td><Td><INPUT TYPE='button' name='smb' value='ตกลง' onclick='goto_url(1)' class=entrybutton>
		&nbsp;&nbsp;<INPUT TYPE='button' name='back' value='ย้อนกลับ' onclick='goto_url(0)' class=entrybutton'></Td></Tr>";
echo "<Br>";
echo "</Table>";
echo "<Br>";
echo "";

echo "</form>";
}
//ส่วนยืนยันการลบข้อมูล
if($index==2) {
echo "<table class='table table-hover table-bordered table-striped table-condensed'>";
echo "<tr><td align='center'><font color='#990000' size='4'>โปรดยืนยันความต้องการลบข้อมูลอีกครั้ง</font><br></td></tr>";
echo "<tr><td align=center>";
echo "<INPUT TYPE='button' name='smb' value='ยืนยัน' onclick='location.href=\"?option=car&task=main/car_type&index=3&id=$_GET[id]&page=$_REQUEST[page]\"'>
		&nbsp;&nbsp;<INPUT TYPE='button' name='back' value='ยกเลิก' onclick='location.href=\"?option=car&task=main/car_type&page=$_REQUEST[page]\"'";
echo "</td></tr></table>";
}
//ส่วนลบข้อมูล
if($index==3){
$sql = "delete from car_type where id=$_GET[id]";
$dbquery = mysqli_query($connect,$sql);
}

//ส่วนเพิ่มข้อมูล
if($index==4){

$sql = "select * from car_type where  code='$_POST[code]' ";
$dbquery = mysqli_query($connect,$sql);
if(mysqli_num_rows($dbquery)>=1){
echo "<br /><div align='center'>มีรหัสซ้ำกับรายการที่มีอยู่แล้ว ตรวจสอบอีกครั้ง</div>";
exit();
}
$sql = "insert into car_type (code,name) values ('$_POST[code]','$_POST[name]')";
$dbquery = mysqli_query($connect,$sql);
}
//ส่วนฟอร์มแก้ไขข้อมูล
if ($index==5){
echo "<form id='frm1' name='frm1'>";
echo "<Center>";
echo "<Font color='#006666' Size=3><B>แก้ไข</B></Font>";
echo "</Cener>";
echo "<Br><Br>";
$sql = "select * from  car_type where id='$_GET[id]'";
$dbquery = mysqli_query($connect,$sql);
$result = mysqli_fetch_array($dbquery);

echo "<table class='table table-hover table-bordered table-striped table-condensed'>";
echo "<Tr align='left'><Td width=20></Td><Td align='right'>รหัส</Td><Td><Input Type='Text' Name='code' Size='5' value='$result[code]'></Td></Tr>";

echo "<Tr align='left'><Td ></Td><Td align='right'>ชื่อประเภท</Td><Td><Input Type='Text' Name='name' id='pay_type_name' Size='40' value='$result[name]'></Td></Tr>";
echo "</Table>";
echo "<Br />";
echo "<Input Type=Hidden Name='id' Value='$_GET[id]'>";
echo "<Input Type=Hidden Name='page' Value='$_GET[page]'>";
echo "<INPUT TYPE='button' name='smb' value='ตกลง' onclick='goto_url_update(1)' class=entrybutton>
		&nbsp;&nbsp;<INPUT TYPE='button' name='back' value='ย้อนกลับ' onclick='goto_url_update(0)' class=entrybutton'>";

echo "</form>";
}
//ส่วนปรับปรุงข้อมูล
if ($index==6){
$sql = "select * from car_type where  code='$_POST[code]' and id!='$_POST[id]' ";
$dbquery = mysqli_query($connect,$sql);
if(mysqli_num_rows($dbquery)>=1){
echo "<br /><div align='center'>มีรหัสซ้ำกับรายการที่มีอยู่แล้ว ตรวจสอบอีกครั้ง</div>";
exit();
}
$sql = "update car_type set code='$_POST[code]', name='$_POST[name]' where id='$_POST[id]'";
$dbquery = mysqli_query($connect,$sql);
}

//ส่วนการแสดงผล
if(!(($index==1) or ($index==2) or ($index==5))){

//ส่วนของการแยกหน้า
$pagelen=20;  // 1_กำหนดแถวต่อหน้า
$url_link="option=car&task=main/car_type";  // 2_กำหนดลิงค์ฺ
$sql = "select * from  car_type "; // 3_กำหนด sql

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

$sql = "select * from car_type  order by code  limit $start,$pagelen";
$dbquery = mysqli_query($connect,$sql);
echo  "<table class='table table-hover table-bordered table-striped table-condensed'>";
echo "<Tr><Td colspan='6' align='left'><INPUT TYPE='button' name='smb' value='เพิ่มข้อมูล' onclick='location.href=\"?option=car&task=main/car_type&index=1\"'>";
echo "</Td></Tr>";
echo "<Tr bgcolor=#FFCCCC align='center' class=style2><Td width='50'>ที่</Td><Td width='100'>รหัส</Td><Td>ชื่อ</Td><Td width='50'>ลบ</Td><Td width='50'>แก้ไข</Td></Tr>";
$N=(($page-1)*$pagelen)+1;  //*เกี่ยวข้องกับการแยกหน้า
$M=1;
While ($result = mysqli_fetch_array($dbquery))
	{
		$id = $result['id'];
		$code= $result['code'];
		$name = $result['name'];
			if(($M%2) == 0)
			$color="#FFFFC";
			else  	$color="#FFFFFF";

		echo "<Tr  bgcolor=$color align=center class=style1><Td>$N</Td><Td align='center'>$code</Td> <Td align='left'>$name</Td><Td><div align='center'><a href=?option=car&task=main/car_type&index=2&id=$id&page=$page><img src=images/drop.png border='0' alt='ลบ'></a></div></Td>
		<Td><a href=?option=car&task=main/car_type&index=5&id=$id&page=$page><img src=images/edit.png border='0' alt='แก้ไข'></a></div></Td>
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
		callfrm("?option=car&task=main/car_type");   // page ย้อนกลับ
	}else if(val==1){
		if(frm1.code.value == ""){
			alert("กรุณากรอกรหัส");
		}else if(frm1.name.value==""){
			alert("กรุณากรอกชื่อประเภท");
		}else{
			callfrm("?option=car&task=main/car_type&index=4");   //page ประมวลผล
		}
	}
}

function goto_url_update(val){
	if(val==0){
		callfrm("?option=car&task=main/car_type");   // page ย้อนกลับ
	}else if(val==1){
		if(frm1.code.value == ""){
			alert("กรุณากรอกรหัส");
		}else if(frm1.name.value==""){
			alert("กรุณากรอกชื่อประเภท");
		}else{
			callfrm("?option=car&task=main/car_type&index=6");   //page ประมวลผล
		}
	}
}
</script>
