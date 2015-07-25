<?php
/** ensure this file is being included by a parent file */
defined( '_VALID_' ) or die( 'Direct Access to this location is not allowed.' );
//sd page
if($result_permission['p2']!=1){
exit();
}

$sql = "select * from  budget_year where year_active='1' order by budget_year desc limit 1";
$dbquery = mysqli_query($connect,$sql);
$year_active_result = mysqli_fetch_array($dbquery);
if($year_active_result['budget_year']==""){
echo "<br />";
echo "<div align='center'>ยังไม่ได้กำหนดทำงานในปีงบประมาณใด ๆ  กรุณาไปที่เมนูตั้งค่าระบบ เพื่อกำหนดปีงบประมาณ</div>";
exit();
}

echo "<br />";

if(!(($index==1) or ($index==2) or ($index==5))){
echo "<table width='50%' border='0' align='center'>";
echo "<tr align='center'><td><font color='#006666' size='3'><strong>รายการ แหล่งของเงิน ปีงบประมาณ $year_active_result[budget_year]</strong></font></td></tr>";
echo "</table>";
}
//ส่วนเพิ่มข้อมูล
if($index==1){
echo "<form id='frm1' name='frm1'>";
echo "<Center>";
echo "<Font color='#006666' Size=3><B>เพิ่มแหล่งของเงิน</B></Font>";
echo "</Cener>";
echo "<Br><Br>";
echo "<Table   width=60% Border=0 Bgcolor=#Fcf9d8>";

echo "<Tr align='left'><Td width=20></Td><Td align='right'>รหัส</Td><Td><Input Type='Text' Name='code' Size='15'></Td></Tr>";

echo "<Tr align='left'><Td ></Td><Td align='right'>ชื่อแหล่งของเงิน</Td><Td><Input Type='Text' Name='name'  Size='40'></Td></Tr>";
echo "<Br>";
echo "</Table>";
echo "<Br>";
echo "<INPUT TYPE='button' name='smb' value='ตกลง' onclick='goto_url(1)' class=entrybutton>
		&nbsp;&nbsp;<INPUT TYPE='button' name='back' value='ย้อนกลับ' onclick='goto_url(0)' class=entrybutton'>";

echo "</form>";
}
//ส่วนยืนยันการลบข้อมูล
if($index==2) {
echo "<table width='500' border='0' align='center'>";
echo "<tr><td align='center'><font color='#990000' size='4'>โปรดยืนยันความต้องการลบข้อมูลอีกครั้ง</font><br></td></tr>";
echo "<tr><td align=center>";
echo "<INPUT TYPE='button' name='smb' value='ยืนยัน' onclick='location.href=\"?option=budget&task=category/money_source&index=3&id=$_GET[id]&page=$_REQUEST[page]\"'>
		&nbsp;&nbsp;<INPUT TYPE='button' name='back' value='ยกเลิก' onclick='location.href=\"?option=budget&task=category/money_source&page=$_REQUEST[page]\"'";
echo "</td></tr></table>";
}
//ส่วนลบข้อมูล
if($index==3){
$sql = "delete from budget_money_source where id=$_GET[id]";
$dbquery = mysqli_query($connect,$sql);
}

//ส่วนเพิ่มข้อมูล
if($index==4){

$sql = "select * from budget_money_source where budget_year='$year_active_result[budget_year]' and code='$_POST[code]' ";
$dbquery = mysqli_query($connect,$sql);
if(mysqli_num_rows($dbquery)>=1){
echo "<br /><div align='center'>มีรหัสซ้ำกับรายการที่มีอยู่แล้ว ตรวจสอบอีกครั้ง</div>";
exit();
}
$sql = "insert into budget_money_source (budget_year,code,name) values ( '$year_active_result[budget_year]','$_POST[code]','$_POST[name]')";
$dbquery = mysqli_query($connect,$sql);
}
//ส่วนฟอร์มแก้ไขข้อมูล
if ($index==5){
echo "<form id='frm1' name='frm1'>";
echo "<Center>";
echo "<Font color='#006666' Size=3><B>แก้ไขแหล่งของเงิน</B></Font>";
echo "</Cener>";
echo "<Br><Br>";
$sql = "select * from  budget_money_source where id='$_GET[id]'";
$dbquery = mysqli_query($connect,$sql);
$result = mysqli_fetch_array($dbquery);

echo "<Table   width=70% Border=0 Bgcolor=#Fcf9d8>";
echo "<Tr align='left'><Td width=20></Td><Td align='right'>รหัส</Td><Td><Input Type='Text' Name='code' Size='15' value='$result[code]'></Td></Tr>";

echo "<Tr align='left'><Td ></Td><Td align='right'>ชื่อแหล่งของเงิน</Td><Td><Input Type='Text' Name='name' id='pay_type_name' Size='40' value='$result[name]'></Td></Tr>";
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
$sql = "select * from budget_money_source where budget_year='$year_active_result[budget_year]' and code='$_POST[code]' and id!='$_POST[id]' ";
$dbquery = mysqli_query($connect,$sql);
if(mysqli_num_rows($dbquery)>=1){
echo "<br /><div align='center'>มีรหัสซ้ำกับรายการที่มีอยู่แล้ว ตรวจสอบอีกครั้ง</div>";
exit();
}
$sql = "update budget_money_source set code='$_POST[code]', name='$_POST[name]' where id='$_POST[id]'";
$dbquery = mysqli_query($connect,$sql);
}

//ส่วนการคัดลอกข้อมูลจากปีที่แล้ว
if ($index==7){
$year=$year_active_result['budget_year']-1;
$sql = "select * from budget_money_source where budget_year='$year' order by id";
$dbquery = mysqli_query($connect,$sql);
		if(mysqli_num_rows($dbquery)>=1){
				While ($result = mysqli_fetch_array($dbquery)){
				$code= $result['code'];
				$name = $result['name'];
				$sql_insert = "insert into budget_money_source (budget_year,code,name) values ( '$year_active_result[budget_year]','$code','$name')";
$dbquery_insert = mysqli_query($connect,$sql_insert);
				}
		}
		else {
		echo "<br /><div align='center'>ไม่มีข้อมูลปีเก่า</div>";
		}
}

//ส่วนการแสดงผล
if(!(($index==1) or ($index==2) or ($index==5))){

//ส่วนของการแยกหน้า
$pagelen=20;  // 1_กำหนดแถวต่อหน้า
$url_link="option=budget&task=category/money_source";  // 2_กำหนดลิงค์ฺ
$sql = "select * from budget_money_source where budget_year='$year_active_result[budget_year]'"; // 3_กำหนด sql

$dbquery = mysqli_query($connect,$sql);
$num_rows = mysqli_num_rows($dbquery);
$totalpages=ceil($num_rows/$pagelen);

//
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

$sql = "select * from budget_money_source where budget_year='$year_active_result[budget_year]' order by id  limit $start,$pagelen";
$dbquery = mysqli_query($connect,$sql);
echo  "<table width=70% border=0 align=center>";
echo "<Tr><Td colspan='6' align='left'><INPUT TYPE='button' name='smb' value='เพิ่มข้อมูล' onclick='location.href=\"?option=budget&task=category/money_source&index=1\"'>";
if(mysqli_num_rows($dbquery)==0){
echo "<INPUT TYPE='button' name='smb' value='คัดลอกข้อมูลจากปีเก่า' onclick='location.href=\"?option=budget&task=category/money_source&index=7\"'>";
}
echo "</Td></Tr>";
echo "<Tr bgcolor=#FFCCCC align='center' class=style2><Td width='50'>ที่</Td><Td>ปีงบประมาณ</Td><Td>รหัส</Td><Td>ชื่อ</Td><Td width='50'>ลบ</Td><Td width='50'>แก้ไข</Td></Tr>";
$N=(($page-1)*$pagelen)+1;  //*เกี่ยวข้องกับการแยกหน้า
$M=1;
While ($result = mysqli_fetch_array($dbquery))
	{
		$id = $result['id'];
		$budget_year=$result['budget_year'];
		$code= $result['code'];
		$name = $result['name'];
			if(($M%2) == 0)
			$color="#FFFFC";
			else  	$color="#FFFFFF";

		echo "<Tr  bgcolor=$color align=center class=style1><Td>$N</Td><td>$budget_year</td><Td align='left'>$code</Td> <Td align='left'>$name</Td><Td><div align='center'><a href=?option=budget&task=category/money_source&index=2&id=$id&page=$page><img src=images/drop.png border='0' alt='ลบ'></a></div></Td>
		<Td><a href=?option=budget&task=category/money_source&index=5&id=$id&page=$page><img src=images/edit.png border='0' alt='แก้ไข'></a></div></Td>
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
		callfrm("?option=budget&task=category/money_source");   // page ย้อนกลับ
	}else if(val==1){
		if(frm1.code.value == ""){
			alert("กรุณากรอกรหัส");
		}else if(frm1.name.value==""){
			alert("กรุณากรอกชื่อแหล่งของเงิน");
		}else{
			callfrm("?option=budget&task=category/money_source&index=4");   //page ประมวลผล
		}
	}
}

function goto_url_update(val){
	if(val==0){
		callfrm("?option=budget&task=category/money_source");   // page ย้อนกลับ
	}else if(val==1){
		if(frm1.code.value == ""){
			alert("กรุณากรอกรหัส");
		}else if(frm1.name.value==""){
			alert("กรุณากรอกชื่อแหล่งของเงิน");
		}else{
			callfrm("?option=budget&task=category/money_source&index=6");   //page ประมวลผล
		}
	}
}
</script>
