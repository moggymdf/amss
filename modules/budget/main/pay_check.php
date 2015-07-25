<?php
/** ensure this file is being included by a parent file */
defined( '_VALID_' ) or die( 'Direct Access to this location is not allowed.' );
if($result_permission['p9']!=1){
exit();
}

$officer=$_SESSION['login_user_id'];
//การรับ
$budget_status['1']="รับเงินสด";
$budget_status['2']="รับเช็ค/เงินฝากธนาคาร";
$budget_status['3']="จ่ายเงินสด";
$budget_status['4']="จ่ายเช็ค/เงินฝากธนาคาร";
$budget_status['5']="นำเงินสดฝากธนาคาร";
$budget_status['6']="นำเงินสดฝากส่วนราชการผู้เบิก";
$budget_status['7']="ถอนเงินฝากธนาคารเป็นเงินสด";
$budget_status['8']="ถอนเงินฝากธนาคารไปฝากส่วนราชการผู้เบิก";
$budget_status['9']="รับคืนเงินฝากส่วนราชการผู้เบิกมาเป็นเงินสด";
$budget_status['10']="รับคืนเงินฝากส่วนราชการมาเป็นเงินฝากธนาคาร";
//การจ่าย

$t_month['01']="มค";
$t_month['02']="กพ";
$t_month['03']="มีค";
$t_month['04']="เมย";
$t_month['05']="พค";
$t_month['06']="มิย";
$t_month['07']="กค";
$t_month['08']="สค";
$t_month['09']="กย";
$t_month['10']="ตค";
$t_month['11']="พย";
$t_month['12']="ธค";

$th_month['1']="มกราคม";
$th_month['2']="กุมภาพันธ์";
$th_month['3']="มีนาคม";
$th_month['4']="เมษายน";
$th_month['5']="พฤษภาคม";
$th_month['6']="มิถุนายน";
$th_month['7']="กรกฎาคม";
$th_month['8']="สิงหาคม";
$th_month['9']="กันยายน";
$th_month['10']="ตุลาคม";
$th_month['11']="พฤศจิกายน";
$th_month['12']="ธันวาคม";

//ปีงบประมาณ
$sql = "select * from  budget_year where year_active='1' order by budget_year desc limit 1";
$dbquery = mysqli_query($connect,$sql);
$year_active_result = mysqli_fetch_array($dbquery);
if($year_active_result['budget_year']==""){
echo "<br />";
echo "<div align='center'>ยังไม่ได้กำหนดทำงานในปีงบประมาณใด ๆ  กรุณาไปที่เมนูตั้งค่าระบบ เพื่อกำหนดปีงบประมาณ</div>";
exit();
}

//ส่วนหัว
echo "<br />";
if(!(($index==5) or ($index==7))){
echo "<table width='50%' border='0' align='center'>";
echo "<tr align='center'><td><font color='#006666' size='3'><strong>จ่ายเงิน ปีงบประมาณ$year_active_result[budget_year]</strong></font></td></tr>";
echo "</table>";
}

//ส่วนฟอร์มแก้ไขข้อมูล
if ($index==5){
echo "<form id='frm1' name='frm1'>";
echo "<Center>";
echo "<Font color='#006666' Size=3><B>บันทึกการจ่ายเงิน ปีงบประมาณ$year_active_result[budget_year]</B></Font>";
echo "</Cener>";
echo "<Br><Br>";

echo "<Table   width='70%' Border='0'>";
$sql = "select * from budget_main where id='$_GET[id]'";
$dbquery = mysqli_query($connect,$sql);
$ref_result = mysqli_fetch_array($dbquery);
list($rec_year,$rec_month,$rec_day) = explode("-",$ref_result['rec_date']);

echo "<Tr align='left'><Td align='right'>วันที่&nbsp;&nbsp;</Td><Td><Select  name='update_date' id='update_date' size='1'>";
for($x=1;$x<=31;$x++){
	if($rec_day==$x){
	echo  "<option  value =$x $date_select[$x]>$x</option>" ;
	}
}
echo "</select>";
echo "</Td></Tr>";

echo "<Tr align='left'><Td align='right'>เดือน&nbsp;&nbsp;</Td><Td><Select  name='update_month' id='update_month' size='1'>";
for($x=1;$x<=12;$x++){
	if($rec_month==$x){
	echo  "<option value =$x $month_select[$x]>$th_month[$x]</option>" ;
	}
}
echo "</select>";
echo "</Td></Tr>";

$update_year=$rec_year+543;
echo "<Tr align='left'><Td align='right'>ปี&nbsp;&nbsp;</Td><Td><Input Type='Text' Name='update_year' id='update_year' Size='4' maxlength='4' value='$update_year' readonly></Td></Tr>";

echo "<Tr align='left'><Td align='right'>ที่เอกสาร&nbsp;&nbsp;</Td><Td><Input Type='Text' Name='doc' id='doc' Size='20' value='$ref_result[doc]' readonly></Td></Tr>";

echo "<Tr align='left'><Td align='right'>อ้างอิงทะเบียนขอเบิก/ขอยืมเงิน&nbsp;&nbsp;</Td>";
echo "<td><div align='left'><Select  name='refer_wd_id' size='1'>";
$sql = "select  id,item from budget_withdraw where budget_year='$year_active_result[budget_year]' order by id desc";
$dbquery = mysqli_query($connect,$sql);
While ($result = mysqli_fetch_array($dbquery))
   {
$id = $result['id'];
$item = $result['item'];
$item = substr($item,0,150);
		if($result['id']==$ref_result['refer_wd_id']){
		echo  "<option value = $id selected>$id $item</option>";
		}
	}
echo "</select>";
echo "</div></td></tr>";

echo "<Tr align='left'><Td align='right'>อ้างอิงเลขที่ฎีกา&nbsp;&nbsp;</Td>";
echo "<td><div align='left'><Select  name='refer_deega_id' size='1'>";
$sql = "select  id,deega_num, item from budget_deega where budget_year='$year_active_result[budget_year]' order by deega_num desc";
$dbquery = mysqli_query($connect,$sql);
While ($result = mysqli_fetch_array($dbquery))
   {
$deega_num = $result['deega_num'];
$item = $result['item'];
$item = substr($item,0,150);
		if($result['deega_num']==$ref_result['refer_deega_id']){
		echo  "<option value =''>$deega_num $item</option>";
		}
	}
echo "</select>";
echo "</div></td></tr>";

echo "<Tr align='left'><Td align='right'>ประเภทของเงิน&nbsp;&nbsp;</Td>";
echo "<td><div align='left'><Select  name='type_id' id='type_id' size='1'>";
$sql = "select  * from  budget_type where  budget_year='$year_active_result[budget_year]' order by type_id";
$dbquery = mysqli_query($connect,$sql);
While ($result = mysqli_fetch_array($dbquery))
   {
$type_id = $result['type_id'];
$type_name = $result['type_name'];
	if($type_id==$ref_result['type_id']){
	echo  "<option>$type_id $type_name</option>";
	}
	if($ref_result['type_id']==200){
	echo  "<option>เงินงบประมาณ</option>";
	}
}
echo "</select>";
echo "</div></td></tr>";

echo "<Tr align='left'><Td align='right'>รายการจ่าย&nbsp;&nbsp;</Td><Td><Input Type='Text' Name='item' id='item' Size='60' value='$ref_result[item]' readonly></Td></Tr>";

echo "<Tr align='left'><Td align='right'>ประเภทรายการจ่าย&nbsp;&nbsp;</Td>";
echo "<td><div align='left'><Select  name='pay_group' id='group' size='1'>";
$sql = "select  * from  budget_pay_type order by id";
$dbquery = mysqli_query($connect,$sql);
While ($result = mysqli_fetch_array($dbquery)) {
		if($result['pay_type_id']==$ref_result['pay_group']){
		echo  "<option value = $result[pay_type_id] $pay_type_select>$result[pay_type_name]</option>";
		}
	}
echo "</select>";
echo "</div></td></tr>";

echo "<Tr align='left'><Td align='right'>จำนวนเงิน&nbsp;&nbsp;</Td><Td><Input Type='Text' Name='pay_amount' id='pay_amount' Size='15' value='$ref_result[pay_amount]' readonly></Td></Tr>";

echo "<Tr align='left'><Td align='right'>ผู้รับเงิน&nbsp;&nbsp;</Td><Td><Input Type='Text' Name='payed_person' Size='30' value='$ref_result[payed_person]' readonly></Td></Tr>";
echo "</Table>";

echo "<table><tr><td>";
echo "<fieldset>";
echo "<legend>&nbsp;<B>ส่วนของการอนุมัติ</B>: &nbsp;</legend>";
echo "<table>";

echo "<Tr align='left'><Td align='right'>การอนุมัติ&nbsp;&nbsp;</Td>";
echo "<td><div align='left'><Select  name='approve' id='approve' size='1'>";
	if($ref_result['approve']==1){
	echo  "<option>อนุมัติให้จ่ายเงินได้</option>";
	}
	else if($ref_result['approve']==2){
	echo  "<option>ไม่อนุมัติ</option>";
	}
	else{
	echo  "<option>รอการอนุมัติ</option>";
	}
echo "</select>";
echo "</div></td></tr>";
echo "</table>";
echo "</fieldset></td></tr></table>";

echo "<table><tr><td>";
echo "<fieldset>";
echo "<legend>&nbsp;<B>ส่วนของการจ่าย</B>: &nbsp;</legend>";
echo "<table>";

echo "<Tr align='left'><Td align='right'>ลักษณะการจ่าย&nbsp;&nbsp;</Td>";
echo "<td><div align='left'><Select  name='status' id='status' size='1'>";
echo  "<option  value = ''>เลือก</option>" ;
for($x=3;$x<=4;$x++){
	if($ref_result['status']==$x){
	echo  "<option value=$x selected>$budget_status[$x]</option>";
	}
	else {
	echo  "<option value=$x>$budget_status[$x]</option>";
	}
}
echo "</select>";
echo "</div></td></tr>";

echo "<Tr align='left'><Td align='right'>หลักฐานการจ่าย&nbsp;&nbsp;</Td><Td><Input Type='Text' Name='check_number' Size='30' value='$ref_result[check_number]' ></Td></Tr>";

echo "<Tr align='left'><Td align='right'>ผู้รับเงิน&nbsp;&nbsp;</Td><Td><Input Type='Text' Name='payee' Size='30' value='$ref_result[payee]' ></Td></Tr>";

if($ref_result['pay_date']!=null){
echo "<Tr align='left'><Td align='right'>วันจ่ายเงิน (ปี เดือน วัน)&nbsp;&nbsp;</Td><Td><Input Type='Text' Name='pay_date' Size='15' value='$ref_result[pay_date]' ></Td></Tr>";
}
echo "</table>";
echo "</fieldset></td></tr></table>";

echo "<Input Type=Hidden Name='id' Value='$_GET[id]'>";
echo "<Input Type=Hidden Name='page' Value='$_GET[page]'>";
echo "<Br>";
echo "<INPUT TYPE='button' name='smb' value='ตกลง' onclick='goto_url_update(1)' class=entrybutton>
		&nbsp;&nbsp;<INPUT TYPE='button' name='back' value='ย้อนกลับ' onclick='goto_url_update(0)' class=entrybutton'>";
echo "</form>";
}

//ส่วนปรับปรุงข้อมูล
if ($index==6){
if(!isset($_POST['pay_date'])){
$_POST['pay_date']="";
}
 	if($_POST['pay_date']==""){
	$rec_date=date("Y-m-d");
	}
	else{
	$rec_date =$_POST['pay_date'];
	}
$sql = "update budget_main set check_number='$_POST[check_number]',
status='$_POST[status]',
payee='$_POST[payee]',
payer='$officer', pay_date='$rec_date' where id='$_POST[id]'";
$dbquery = mysqli_query($connect,$sql);
}

//ส่วนแสดงรายละเอียด
if ($index==7){
echo "<Center>";
echo "<Font color='#006666' Size='3'><B>รายละเอียดการจ่ายเงิน ปีงบประมาณ$year_active_result[budget_year]</B></Font>";
echo "</Cener>";
echo "<Br><Br>";

echo "<Table width='70%' Border='0'>";
echo "<Tr ><Td colspan='11' align='right'><INPUT TYPE='button' name='smb' value='<<กลับหน้าก่อน' onclick='location.href=\"?option=budget&task=main/pay_check&page=$_GET[page]\"'></Td></Tr>";

$sql = "select * from budget_main where id='$_GET[id]'";
$dbquery = mysqli_query($connect,$sql);
$ref_result = mysqli_fetch_array($dbquery);
list($rec_year,$rec_month,$rec_day) = explode("-",$ref_result['rec_date']);

echo "<Tr align='left'><Td align='right'>วันที่&nbsp;&nbsp;</Td><Td><Select  name='update_date' id='update_date' size='1'>";
for($x=1;$x<=31;$x++){
	if($rec_day==$x){
	echo  "<option  value =$x>$x</option>" ;
	}
}
echo "</select>";
echo "</Td></Tr>";

echo "<Tr align='left'><Td align='right'>เดือน&nbsp;&nbsp;</Td><Td><Select  name='update_month' id='update_month' size='1'>";
for($x=1;$x<=12;$x++){
	if($rec_month==$x){
	echo  "<option value =$x $month_select[$x]>$th_month[$x]</option>" ;
	}
}
echo "</select>";
echo "</Td></Tr>";

$update_year=$rec_year+543;
echo "<Tr align='left'><Td align='right'>ปี&nbsp;&nbsp;</Td><Td><Input Type='Text' Name='update_year' id='update_year' Size='4' maxlength='4' value='$update_year' readonly></Td></Tr>";

echo "<Tr align='left'><Td align='right'>ที่เอกสาร&nbsp;&nbsp;</Td><Td><Input Type='Text' Name='doc' id='doc' Size='20' value='$ref_result[doc]' readonly></Td></Tr>";

echo "<Tr align='left'><Td align='right'>อ้างอิงทะเบียนขอเบิก/ขอยืมเงิน&nbsp;&nbsp;</Td>";
echo "<td><div align='left'><Select  name='refer_wd_id' size='1'>";
$sql = "select  id,item from budget_withdraw where budget_year='$year_active_result[budget_year]' order by id desc";
$dbquery = mysqli_query($connect,$sql);
While ($result = mysqli_fetch_array($dbquery))
   {
$id = $result['id'];
$item = $result['item'];
$item = substr($item,0,150);
		if($result['id']==$ref_result['refer_wd_id']){
		echo  "<option value = $id>$id $item</option>";
		}
	}
echo "</select>";
echo "</div></td></tr>";

echo "<Tr align='left'><Td align='right'>อ้างอิงเลขที่ฎีกา&nbsp;&nbsp;</Td>";
echo "<td><div align='left'><Select  name='refer_deega_id' size='1'>";
$sql = "select  id,deega_num, item from budget_deega where budget_year='$year_active_result[budget_year]' order by deega_num desc";
$dbquery = mysqli_query($connect,$sql);
While ($result = mysqli_fetch_array($dbquery))
   {
$deega_num = $result['deega_num'];
$item = $result['item'];
$item = substr($item,0,150);
		if($result['deega_num']==$ref_result['refer_deega_id']){
		echo  "<option value =''>$deega_num $item</option>";
		}
	}
echo "</select>";
echo "</div></td></tr>";

echo "<Tr align='left'><Td align='right'>ประเภทของเงิน&nbsp;&nbsp;</Td>";
echo "<td><div align='left'><Select  name='type_id' id='type_id' size='1'>";
$sql = "select  * from  budget_type where budget_year='$year_active_result[budget_year]' order by type_id";
$dbquery = mysqli_query($connect,$sql);
While ($result = mysqli_fetch_array($dbquery))
   {
$type_id = $result['type_id'];
$type_name = $result['type_name'];
	if($type_id==$ref_result['type_id']){
	echo  "<option>$type_id $type_name</option>";
	}
	if($ref_result['type_id']==200){
	echo  "<option>เงินงบประมาณ</option>";
	}
}
echo "</select>";
echo "</div></td></tr>";

echo "<Tr align='left'><Td align='right'>รายการจ่าย&nbsp;&nbsp;</Td><Td><Input Type='Text' Name='item' id='item' Size='60' value='$ref_result[item]'></Td></Tr>";

echo "<Tr align='left'><Td align='right'>ประเภทรายการจ่าย&nbsp;&nbsp;</Td>";
echo "<td><div align='left'><Select  name='pay_group' id='group' size='1'>";
$sql = "select  * from  budget_pay_type order by id";
$dbquery = mysqli_query($connect,$sql);
While ($result = mysqli_fetch_array($dbquery)) {
		if($result['pay_type_id']==$ref_result['pay_group']){
		echo  "<option value = $result[pay_type_id] $pay_type_select>$result[pay_type_name]</option>";
		}
	}
echo "</select>";
echo "</div></td></tr>";

echo "<Tr align='left'><Td align='right'>จำนวนเงิน&nbsp;&nbsp;</Td><Td><Input Type='Text' Name='pay_amount' id='pay_amount' Size='15'  value='$ref_result[pay_amount]' readonly></Td></Tr>";

echo "<Tr align='left'><Td align='right'>ผู้รับเงิน&nbsp;&nbsp;</Td><Td><Input Type='Text' Name='' id='' Size='15'  value='$ref_result[payed_person]' readonly></Td></Tr>";

$sql = "select  * from  person_main where person_id='$ref_result[officer]' ";
$dbquery = mysqli_query($connect,$sql);
$result = mysqli_fetch_array($dbquery);
$fullname=$result['prename'].$result['name']." ".$result['surname'];
echo "<Tr align='left'><Td align='right'>เจ้าหน้าที่&nbsp;&nbsp;</Td><Td><Input Type='Text' Name='' Size='30' value='$fullname' readonly></Td></Tr>";
echo "</Table>";

echo "<table><tr><td>";
echo "<fieldset>";
echo "<legend>&nbsp;<B>ส่วนของการอนุมัติ</B>: &nbsp;</legend>";
echo "<table>";
echo "<Tr align='left'><Td align='right'>การอนุมัติ&nbsp;&nbsp;</Td>";
echo "<td><div align='left'><Select  name='approve' id='approve' size='1'>";
	if($ref_result['approve']==1){
	echo  "<option>อนุมัติให้จ่ายเงินได้</option>";
	}
	else if($ref_result['approve']==2){
	echo  "<option>ไม่อนุมัติ</option>";
	}
	else{
	echo  "<option>รอการอนุมัติ</option>";
	}
echo "</select>";
echo "</div></td></tr>";

$sql = "select  * from  person_main where person_id='$ref_result[approve_name]' ";
$dbquery = mysqli_query($connect,$sql);
$result = mysqli_fetch_array($dbquery);
$fullname=$result['prename'].$result['name']." ".$result['surname'];
echo "<Tr align='left'><Td align='right'>ผู้อนุมัติ&nbsp;&nbsp;</Td><Td><Input Type='Text' Name='' Size='30' value='$fullname' readonly></Td></Tr>";

echo "<Tr align='left'><Td align='right'>วันอนุมัติ (ปี เดือน วัน)&nbsp;&nbsp;</Td><Td><Input Type='Text' Name='' id='' Size='15'  value='$ref_result[approve_date]' readonly></Td></Tr>";
echo "</table>";
echo "</fieldset></td></tr></table>";

echo "<table><tr><td>";
echo "<fieldset>";
echo "<legend>&nbsp;<B>ส่วนของการจ่าย</B>: &nbsp;</legend>";
echo "<table>";

echo "<Tr align='left'><Td align='right'>ลักษณะการจ่าย&nbsp;&nbsp;</Td>";
echo "<td><div align='left'><Select  name='status' id='status' size='1'>";
for($x=3;$x<=4;$x++){
	if($ref_result['status']==$x){
	echo  "<option>$budget_status[$x]</option>";
	}
}
echo "</select>";
echo "</div></td></tr>";

echo "<Tr align='left'><Td align='right'>หลักฐานการจ่าย&nbsp;&nbsp;</Td><Td><Input Type='Text' Name='check_number' Size='30' value='$ref_result[check_number]' readonly></Td></Tr>";

echo "<Tr align='left'><Td align='right'>ผู้รับเงิน&nbsp;&nbsp;</Td><Td><Input Type='Text' Name='payee' Size='30' value='$ref_result[payee]' readonly></Td></Tr>";

$sql = "select  * from  person_main where person_id='$ref_result[payer]' ";
$dbquery = mysqli_query($connect,$sql);
$result = mysqli_fetch_array($dbquery);
$fullname=$result['prename'].$result['name']." ".$result['surname'];
echo "<Tr align='left'><Td align='right'>ผู้จ่ายเงิน&nbsp;&nbsp;</Td><Td><Input Type='Text' Name='' Size='30' value='$fullname' readonly></Td></Tr>";

echo "<Tr align='left'><Td align='right'>วันจ่ายเงิน (ปี เดือน วัน)&nbsp;&nbsp;</Td><Td><Input Type='Text' Name='pay_date' Size='15' value='$ref_result[pay_date]' readonly></Td></Tr>";

echo "</table>";
echo "</fieldset></td></tr></table>";
}

$sql = "select id, pay_amount from  budget_main where budget_year='$year_active_result[budget_year]' and pay_amount !='null' order by rec_date, id";
$dbquery = mysqli_query($connect,$sql);
$num_rows = mysqli_num_rows($dbquery );  // นำตัวแปรไปใช้ในส่วนของการแยกหน้า
//ส่วนแสดงผล
if(!(($index==5) or ($index==7))){

//ส่วนของการแยกหน้า
$pagelen=20; // กำหนดแถวต่อหน้า
$url_link="option=budget&task=main/pay_check";
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

$sql = "select * from  budget_main where budget_year='$year_active_result[budget_year]' and pay_amount !='null' order by rec_date, id limit $start,$pagelen";
$dbquery = mysqli_query($connect,$sql);

echo  "<table width=90% border=0 align=center>";
echo "<Tr bgcolor='#FFCCCC' align='center'><Td width='30'>ที่</Td><Td width='70'>วดป</Td><Td>รายการ</Td><Td width='120'>จำนวนเงิน</Td><Td width='120'>ประเภทเงิน</Td><Td width='60'>รายละเอียด</Td><Td width='60'>อนุมัติ</Td><Td width='60'>จ่ายเงิน</Td><Td width='60'>บันทึก</Td></Tr>";
$N=(($page-1)*$pagelen)+1;  //*เกี่ยวข้องกับการแยกหน้า
$M=1;
While ($result = mysqli_fetch_array($dbquery))
	{
		$id = $result['id'];
		$item = $result['item'];
		$pay_group = $result['pay_group'];
		$pay_amount = $result['pay_amount'];
		$pay_amount=number_format($pay_amount,2);
		$rec_date = $result['rec_date'];

list($rec_year,$rec_month,$rec_day) = explode("-",$rec_date);
$t_year=($rec_year+543)-2500;
			if(($M%2) == 0)
			$color="#FFFFC";
			else  	$color="#FFFFFF";

		if($result['approve']==1){
		$approve_pic="<img src=./images/green.gif border='0' alt='อนุมัติ'>";
		}
		else if($result['approve']==2){
		$approve_pic="<img src=./images/red.gif border='0' alt='ไม่อนุมัติ'>";
		}
		else {
		$approve_pic="<img src=./images/yellow.gif border='0' alt='คลิกอนุมัติจ่ายเงิน'>";
		}

		if($result['type_id']<200){
		$type_bud_text="เงินนอกงบประมาณ";
		}
		else if($result['type_id']==200){
		$type_bud_text="เงินงบประมาณ";
		}
		else if($result['type_id']>200){
		$type_bud_text="เงินรายได้แผ่นดิน";
		}
		else {
		$type_bud_text="";
		}

		if($result['check_number']!=""){
		$pay_pic="<img src=./images/green.gif border='0' alt='จ่ายเงินแล้ว'>";
		}
		else {
		$pay_pic="<img src=./images/red.gif border='0' alt='ยังไม่ได้จ่ายเงิน'>";
		}

echo "<Tr bgcolor=$color><Td align='center'>$N</Td> <Td>$rec_day $t_month[$rec_month] $t_year</Td><Td align=left>$item</Td><Td align='right'>$pay_amount</Td><Td align='left'>$type_bud_text</Td><Td align='center'><a href=?option=budget&task=main/pay_check&index=7&id=$id&page=$page><img src=./images/browse.png border='0' alt='รายละเอียด'></a></Td><td align='center'>$approve_pic</td></Td><td align='center'>$pay_pic</td>";
echo "<Td align='center'><a href=?option=budget&task=main/pay_check&index=5&id=$id&page=$page><img src=images/edit.png border='0' alt='แก้ไข'></a></div></Td></Tr>";
$M++;
$N++;  //*เกี่ยวข้องกับการแยกหน้า
	}
echo "</Table>";
echo "<br />";
echo "<table width='50%' border='0' align='center'>";
echo "<tr><td><img src=./images/yellow.gif></td><td>รอการอนุมัติ</td></tr>";
echo "<tr><td><img src=./images/green.gif></td><td>อนุมัติให้จ่่ายเงินได้ / จ่ายเงินแล้ว</td></tr>";
echo "<tr><td><img src=./images/red.gif></td><td>ไม่อนุมัติ / ยังไม่ได้จ่ายเงิน</td></tr>";
echo "</Table>";
}

?>
<script>
function goto_url_update(val){
	if(val==0){
		callfrm("?option=budget&task=main/pay_check&page=<?php  echo $_REQUEST['page']?>");   // page ย้อนกลับ
	}else if(val==1){
		if(frm1.status.value == ""){
			alert("กรุณาเลือกลักษณะการจ่าย");
		}else if(frm1.check_number.value == ""){
			alert("กรุณากรอกหลักฐานการจ่าย");
		}else if(frm1.payee.value==""){
			alert("กรุณากรอกชื่อผู้รับเงิน");
		}else{
			callfrm("?option=budget&task=main/pay_check&index=6");
		}
	}
}

</script>
