<?php
/** ensure this file is being included by a parent file */
defined( '_VALID_' ) or die( 'Direct Access to this location is not allowed.' );
//sd page
//ส่วนหัว
echo "<br />";
if(!(($index==1) or ($index==2) or ($index==5))){
echo "<table width='50%' border='0' align='center'>";
echo "<tr align='center'><td><font color='#006666' size='3'><strong>กลุ่มระบบงานย่อย (Main Menu)</strong></font></td></tr>";
echo "</table>";
}

//ส่วนฟอร์มรับข้อมูล
if($index==1){
echo "<form id='frm1' name='frm1'>";
echo "<Center>";
echo "<Font color='#006666' Size=3><B>เพิ่ม กลุ่มระบบงานย่อย (Main Menu)</Font>";
echo "</Cener>";
echo "<Br><Br>";
echo "<Table width='50%' Border='0' Bgcolor='#Fcf9d8'>";
echo "<Tr><Td align='right' width='50%' >รหัสกลุ่ม&nbsp;&nbsp;&nbsp;&nbsp;</Td><Td align='left' width='50%' ><Input Type='Text' Name='menugroup' Size='5' ></Td></Tr>";
echo "<Tr><Td align='right'>ชื่อกลุ่ม&nbsp;&nbsp;&nbsp;&nbsp;</Td><Td align='left'><Input Type='Text' Name='menugroup_desc' Size='20'></Td></Tr>";
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
echo "<INPUT TYPE='button' name='smb' value='ยืนยัน' onclick='location.href=\"?file=menugroup&index=3&id=$_GET[id]&page=$_REQUEST[page]\"'>
		&nbsp;&nbsp;<INPUT TYPE='button' name='back' value='ยกเลิก' onclick='location.href=\"?file=menugroup&page=$_REQUEST[page]\"'";
echo "</td></tr></table>";
}

//ส่วนลบข้อมูล
if($index==3){
$sql = "delete from system_menugroup where id=$_GET[id]";
$dbquery = mysqli_query($connect,$sql);
}

//ส่วนบันทึกข้อมูล
if($index==4){
$sql = "insert into system_menugroup (menugroup, menugroup_desc) values ('$_POST[menugroup]', '$_POST[menugroup_desc]')";
$dbquery = mysqli_query($connect,$sql);
}

//ส่วนฟอร์มแก้ไขข้อมูล
if ($index==5){
echo "<form id='frm1' name='frm1'>";
echo "<Center>";
echo "<Font color='#006666' Size=3><B>แก้ไขกลุ่ม (Main Menu)</B></Font>";
echo "</Cener>";
echo "<Br><Br>";
echo "<Table width='50%' Border= '0' Bgcolor='#Fcf9d8'>";

$sql = "select * from system_menugroup where id='$_GET[id]'";
$dbquery = mysqli_query($connect,$sql);
$ref_result = mysqli_fetch_array($dbquery);

echo "<Tr><Td align='right'>รหัส&nbsp;&nbsp;&nbsp;&nbsp;</Td><Td align='left'><Input Type='Text' Name='menugroup' Size='5' value='$ref_result[menugroup]'></Td></Tr>";

echo "<Tr><Td align='right'>ชื่อกลุ่ม&nbsp;&nbsp;&nbsp;&nbsp;</Td><Td align='left'><Input Type='Text' Name='menugroup_desc' Size='20' value='$ref_result[menugroup_desc]' ></Td></Tr>";

echo "<tr><td>&nbsp;</td><td>&nbsp;</td></tr>";
echo "<tr><td align='right'><INPUT TYPE='button' name='smb' value='ตกลง' onclick='goto_url_update(1)' class=entrybutton>&nbsp;&nbsp;&nbsp;&nbsp;</td>";
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
$sql = "update system_menugroup set menugroup='$_POST[menugroup]', menugroup_desc='$_POST[menugroup_desc]' where id='$_POST[id]'";
$dbquery = mysqli_query($connect,$sql);
}
if ($index==6.5){
$sql = "select * from system_menugroup order by menugroup_order";
$dbquery = mysqli_query($connect,$sql);
$order_number=1;
While ($result = mysqli_fetch_array($dbquery)){
	if($_GET['menugroup_order']==1 and $result['id']==$_GET['id']){
	$menugroup_order=($order_number*2)-3;
	}
	else if($_GET['menugroup_order']==-1 and $result['id']==$_GET['id']){
	$menugroup_order=($order_number*2)+3;
	}
	else{
	$menugroup_order=($order_number*2)	;
	}
	$sql_order="update system_menugroup set  menugroup_order='$menugroup_order' where id='$result[id]'";
	$dbquery_order = mysqli_query($connect,$sql_order);
$order_number++;
	}
}

//ส่วนปรับปรุงสถานะmodule
if ($index==7){
	if($_GET['module_active']==1){
	$module_active=0;
	}
	else{
	$module_active=1;
	}
$sql = "update system_menugroup set module_active='$module_active' where id='$_GET[id]'";
$dbquery = mysqli_query($connect,$sql);
}

//ส่วนแสดงผล
if(!(($index==1) or ($index==2) or ($index==5))){

	//ส่วนของการแยกหน้า
$pagelen=20;  // 1_กำหนดแถวต่อหน้า
$url_link="file=menugroup";  // 2_กำหนดลิงค์ฺ
$sql = "select * from system_menugroup"; // 3_กำหนด sql

$dbquery = mysqli_query($connect,$sql);
$num_rows = mysqli_num_rows($dbquery );
$totalpages=ceil($num_rows/$pagelen);
//เพิ่มเติม
if(!isset($_REQUEST['page'])){
$_REQUEST['page']="";
}
//
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

$sql = "select * from system_menugroup order by menugroup_order limit $start,$pagelen";
$dbquery = mysqli_query($connect,$sql);
$num_effect = mysqli_num_rows($dbquery );  // จำนวนข้อมูลในหน้านี้
echo  "<table width=60% border=0 align=center>";
echo "<Tr><Td colspan='7' align='left'><INPUT TYPE='button' name='smb' value='เพิ่มกลุ่ม' onclick='location.href=\"?file=menugroup&index=1\"'</Td></Tr>";

echo "<Tr bgcolor='#FFCCCC'><Td  align='center' width='50'>ที่</Td><Td  align='center' width='100'>รหัสกลุ่ม</Td><Td  align='center'>ชื่อกลุ่ม</Td><Td align='center' width='50'>ลำดับ</Td><Td align='center' width='50'>ลบ</Td><Td align='center' width='50'>แก้ไข</Td></Tr>";

$N=(($page-1)*$pagelen)+1;  //*เกี่ยวข้องกับการแยกหน้า
$M=1;

While ($result = mysqli_fetch_array($dbquery))
	{
		$id = $result['id'];
		$menugroup= $result['menugroup'];
		$menugroup_desc = $result['menugroup_desc'];
		if(($M%2) == 0)
			$color="#FFFFC";
			else  	$color="#FFFFFF";
		echo "<Tr bgcolor=$color><Td align='center'>$N</Td><Td  align='center'>$menugroup</Td><Td align='left'>$menugroup_desc</Td>";

		echo "<Td align='center'>";
		if(!($M==1 and $page==1)){
		echo "<a href=?file=menugroup&index=6.5&id=$id&menugroup_order=1&page=$page><img src=../images/uparrow.png border='0' alt='ขึ้นด้านบน'></a>";
		}
		if(!($M==$num_effect and $page==$totalpages)){
		echo "<a href=?file=menugroup&index=6.5&id=$id&menugroup_order=-1&page=$page><img src=../images/downarrow.png border='0' alt='ลงด้านล่าง'></a>";
		}
		echo "</Td>";

		echo "<Td align='center'><a href=?file=menugroup&index=2&id=$id&page=$page><img src=../images/drop.png border='0' alt='ลบ'></a></Td>
		<Td align='center'><a href=?file=menugroup&index=5&id=$id&page=$page><img src=../images/edit.png border='0' alt='แก้ไข'></a></Td>
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
		callfrm("?file=menugroup");   // page ย้อนกลับ
	}else if(val==1){
		if(frm1.menugroup.value == ""){
			alert("กรุณากรอกรหัสกลุ่ม");
		}else if(frm1.menugroup_desc.value==""){
			alert("กรุณากรอกชื่อกลุ่ม('งาน')");
		}else{
			callfrm("?file=menugroup&index=4");   //page ประมวลผล
		}
	}
}

function goto_url_update(val){
	if(val==0){
		callfrm("?file=menugroup");   // page ย้อนกลับ
	}else if(val==1){
		if(frm1.menugroup.value == ""){
			alert("กรุณากรอกรหัสกลุ่ม");
		}else if(frm1.menugroup_desc.value==""){
			alert("กรุณากรอกชื่อกลุ่ม('งาน')");
		}else{
			callfrm("?file=menugroup&index=6");   //page ประมวลผล
		}
	}
}
</script>
