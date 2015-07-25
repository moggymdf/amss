<?php
/** ensure this file is being included by a parent file */
defined( '_VALID_' ) or die( 'Direct Access to this location is not allowed.' );
if($result_permission['p8']!=1){
exit();
}

$officer=$_SESSION['login_user_id'] ;

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
if(!(($index==1) or ($index==2) or ($index==5) or ($index==7) or ($index==1.1))){
echo "<table width='50%' border='0' align='center'>";
echo "<tr align='center'><td><font color='#006666' size='3'><strong>ทะเบียนเงินทดรองราชการ ปีงบประมาณ $year_active_result[budget_year]</strong></font></td></tr>";
echo "</table>";
}

//ส่วนฟอร์มรับข้อมูล
if($index==1){
echo "<form id='frm1' name='frm1'>";
echo "<Center>";
echo "<Font color='#006666' Size=3><B>ทะเบียนยืมเงินทดรองราชการ ปีงบประมาณ$year_active_result[budget_year]</Font>";
echo "</Cener>";
echo "<Br><Br>";
echo "<Table width=70% Border=0 Bgcolor=#Fcf9d8>";

echo "<Tr align='left'><Td align='right'>ที่เอกสาร&nbsp;&nbsp;</Td><Td><Input Type='Text' Name='doc' id='doc' Size='20'></Td></Tr>";

echo "<Tr align='left'><Td align='right'>อ้างอิงทะเบียนขอเบิก/ขอยืมเงิน&nbsp;&nbsp;</Td>";
echo "<td><div align='left'><Select  name='refer_wd_id' size='1'>";
echo  "<option  value = ''>เลือก</option>" ;
$sql = "select  id,item from budget_withdraw where budget_year='$year_active_result[budget_year]' order by id desc";
$dbquery = mysqli_query($connect,$sql);
While ($result = mysqli_fetch_array($dbquery))
   {
$id = $result['id'];
$item = $result['item'];
$item = substr($item,0,150);
echo  "<option value = $id>$id $item</option>";
	}
echo "</select>";
echo "</div></td></tr>";

echo "<Tr align='left'><Td align='right'>รายการ&nbsp;&nbsp;</Td><Td><Input Type='Text' Name='item' id='item' Size='60'></Td></Tr>";

echo "<Tr align='left'><Td align='right'>จำนวนเงิน&nbsp;&nbsp;</Td><Td><Input Type='Text' Name='pay_amount' id='pay_amount' Size='15' ></Td></Tr>";

echo "<Tr align='left'><Td align='right'>ผู้ยืมเงิน&nbsp;&nbsp;</Td><Td><Input Type='Text' Name='borrowed_person' Size='30' ></Td></Tr>";

echo "<Br>";
echo "</Table>";
echo "<Br>";
echo "<INPUT TYPE='button' name='smb' value='ตกลง' onclick='goto_url(1)' class=entrybutton>
		&nbsp;&nbsp;<INPUT TYPE='button' name='back' value='ย้อนกลับ' onclick='goto_url(0)' class=entrybutton'>";

echo "</form>";
}

if($index==1.1){
$sql = "select * from budget_reserve_money where id='$_GET[id]'";
$dbquery = mysqli_query($connect,$sql);
$ref_result = mysqli_fetch_array($dbquery);
list($rec_year,$rec_month,$rec_day) = explode("-",$ref_result['rec_date']);

echo "<form id='frm1' name='frm1'>";
echo "<Center>";
echo "<Font color='#006666' Size=3><B>คืนเงินทดรองราชการ ปีงบประมาณ$year_active_result[budget_year]</Font>";
echo "</Cener>";
echo "<Br><Br>";
echo "<Table width='65%' Border='0'>";
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

echo "<Tr align='left'><Td align='right'>ที่เอกสาร&nbsp;&nbsp;</Td><Td><Input Type='Text' Name='doc' id='doc' Size='20' value='$ref_result[document]' readonly></Td></Tr>";

echo "<Tr align='left'><Td align='right'>รายการ&nbsp;&nbsp;</Td><Td><Input Type='Text' Name='item' id='item' Size='60' value='$ref_result[item]' readonly></Td></Tr>";

echo "<Tr align='left'><Td align='right'>จำนวนเงินที่ยืม&nbsp;&nbsp;</Td><Td><Input Type='Text' Name='pay_amount_amount' id='pay_amount' Size='15' value='$ref_result[pay_amount]' readonly>&nbsp;บาท</Td></Tr>";
echo "</Table>";
echo "<Br>";
echo "<table><tr><td>";
echo "<fieldset>";
echo "<legend>&nbsp;<B>ส่วนของการคืนเงินยืม</B>: &nbsp;</legend>";
echo "<table>";
echo "<Tr align='left'><Td align='right'>ที่เอกสาร&nbsp;&nbsp;</Td><Td><Input Type='Text' Name='receive_doc'  Size='15' ></Td></Tr>";
echo "<Tr align='left'><Td align='right'>จำนวนเงินคืน&nbsp;&nbsp;</Td><Td><Input Type='Text' Name='receive_amount' id='receive_amount' Size='15' >&nbsp;บาท</Td></Tr>";
echo "</table>";
echo "</fieldset></td></tr></table>";

echo "<Br>";
echo "<Input Type=Hidden Name='id' Value='$_GET[id]'>";
echo "<Input Type=Hidden Name='page' Value='$_GET[page]'>";
echo "<INPUT TYPE='button' name='smb' value='ตกลง' onclick='goto_url2(1)' class=entrybutton>
		&nbsp;&nbsp;<INPUT TYPE='button' name='back' value='ย้อนกลับ' onclick='goto_url2(0)' class=entrybutton'>";

echo "</form>";
}

//ส่วนยืนยันการลบข้อมูล
if($index==2) {
$page=$_REQUEST['page'];
echo "<table width='500' border='0' align='center'>";
echo "<tr><td align='center'><font color='#990000' size='4'>โปรดยืนยันความต้องการลบข้อมูลอีกครั้ง</font><br></td></tr>";
echo "<tr><td align=center>";
echo "<INPUT TYPE='button' name='smb' value='ยืนยัน' onclick='location.href=\"?option=budget&task=main/reserve_money&index=3&id=$_GET[id]&page=$page\"'>
		&nbsp;&nbsp;<INPUT TYPE='button' name='back' value='ยกเลิก' onclick='location.href=\"?option=budget&task=main/reserve_money&page=$page\"'";
echo "</td></tr></table>";
}

//ส่วนลบข้อมูล
if($index==3){
$sql = "delete from budget_reserve_money where id=$_GET[id]";
$dbquery = mysqli_query($connect,$sql);
}

//ส่วนบันทึกข้อมูล
if($index==4){
$rec_date = date("Y-m-d");
$sql = "insert into budget_reserve_money (budget_year, document, refer_wd_id, item, pay_amount, borrowed_person, pay_rec_date,rec_date, officer) values ('$year_active_result[budget_year]', '$_POST[doc]', '$_POST[refer_wd_id]', '$_POST[item]','$_POST[pay_amount]', '$_POST[borrowed_person]','$rec_date', '$rec_date','$officer')";

$dbquery = mysqli_query($connect,$sql);
}

//ส่วนฟอร์มแก้ไขข้อมูล
if ($index==5){
echo "<form id='frm1' name='frm1'>";
echo "<Center>";
echo "<Font color='#006666' Size=3><B>แก้ไขรายการเงินทดรองราชการ ปีงบประมาณ $year_active_result[budget_year]</B></Font>";
echo "</Cener>";
echo "<Br><Br>";

echo "<Table width='70%' Border='0'>";
$sql = "select * from budget_reserve_money where id='$_GET[id]'";
$dbquery = mysqli_query($connect,$sql);
$ref_result = mysqli_fetch_array($dbquery);
list($rec_year,$rec_month,$rec_day) = explode("-",$ref_result[rec_date]);

echo "<Tr align='left'><Td ></Td><Td align='right'>วันที่&nbsp;&nbsp;</Td><Td><Select  name='update_date' id='update_date' size='1'>";
echo  "<option  value = ''>เลือก</option>" ;

for($x=1;$x<=31;$x++){
	if($rec_day==$x){
	$date_select[$x]="selected";
	}
	else{
	$date_select[$x]="";
	}
echo  "<option  value =$x $date_select[$x]>$x</option>" ;
}
echo "</select>";
echo "</Td></Tr>";

echo "<Tr align='left'><Td ></Td><Td align='right'>เดือน&nbsp;&nbsp;</Td><Td><Select  name='update_month' id='update_month' size='1'>";
echo  "<option  value = ''>เลือก</option>" ;
for($x=1;$x<=12;$x++){
	if($rec_month==$x){
	$month_select[$x]="selected";
	}
	else{
	$date_select[$x]="";
	}
echo  "<option value =$x $month_select[$x]>$th_month[$x]</option>" ;
}
echo "</select>";
echo "</Td></Tr>";

$update_year=$rec_year+543;
echo "<Tr align='left'><Td ></Td><Td align='right'>ปี&nbsp;&nbsp;</Td><Td><Input Type='Text' Name='update_year' id='update_year' Size='4' maxlength='4' value='$update_year' onkeydown='integerOnly()'></Td></Tr>";

echo "<Tr align='left'><Td ></Td><Td align='right'>ที่เอกสาร&nbsp;&nbsp;</Td><Td><Input Type='Text' Name='doc' id='doc' Size='20' value='$ref_result[document]'></Td></Tr>";

echo "<Tr align='left'><Td ></Td><Td align='right'>อ้างอิงทะเบียนขอเบิก/ขอยืมเงิน&nbsp;&nbsp;</Td>";
echo "<td><div align='left'><Select  name='refer_wd_id' size='1'>";
echo  "<option  value = ''>เลือก</option>" ;
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
		else{
		echo  "<option value = $id>$id $item</option>";
		}
	}
echo "</select>";
echo "</div></td></tr>";

echo "<Tr align='left'><Td ></Td><Td align='right'>รายการ&nbsp;&nbsp;</Td><Td><Input Type='Text' Name='item' id='item' Size='60' value='$ref_result[item]'></Td></Tr>";

echo "<Tr align='left'><Td ></Td><Td align='right'>จำนวนเงินยืม&nbsp;&nbsp;</Td><Td><Input Type='Text' Name='pay_amount' id='pay_amount' Size='15'  value='$ref_result[pay_amount]'><Input Type='Text' Name='pay_rec_date' id='pay_rec_date' Size='10'  value='$ref_result[pay_rec_date]'></Td></Tr>";

echo "<Tr align='left'><Td ></Td><Td align='right'>ผู้ยืม&nbsp;&nbsp;</Td><Td><Input Type='Text' Name='borrowed_person' id='borrowed_person' Size='15'  value='$ref_result[borrowed_person]'></Td></Tr>";
echo "</Table>";

echo "<Br>";
echo "<table><tr><td>";
echo "<fieldset>";
echo "<legend>&nbsp;<B>ส่วนของการคืนเงินยืม</B>: &nbsp;</legend>";
echo "<table>";
echo "<Tr align='left'><Td align='right'>ที่เอกสาร&nbsp;&nbsp;</Td><Td><Input Type='Text' name='receive_doc' Size='10' value='$ref_result[receive_doc]'></Td></Tr>";
echo "<Tr align='left'><Td align='right'>จำนวนเงินคืน&nbsp;&nbsp;</Td><Td><Input Type='Text' Name='receive_amount' Size='15'  value='$ref_result[receive_amount]'></Td></Tr>";
echo "<Tr align='left'><Td align='right'>วันที่คืน (ปี เดือน วัน)&nbsp;&nbsp;</Td><Td><Input Type='Text' name='receive_rec_date' Size='10' value='$ref_result[receive_rec_date]'></Td></Tr>";
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
$rec_date=($_POST['update_year']-543)."-".$_POST['update_month']."-".$_POST['update_date'];
$sql = "update budget_reserve_money set document='$_POST[doc]',
refer_wd_id='$_POST[refer_wd_id]',
item='$_POST[item]',
receive_amount='$_POST[receive_amount]',
pay_amount='$_POST[pay_amount]',
borrowed_person='$_POST[borrowed_person]',
pay_rec_date='$_POST[pay_rec_date]',
receive_doc='$_POST[receive_doc]',
receive_rec_date='$_POST[receive_rec_date]',
officer='$officer' ,
rec_date='$rec_date' where id='$_POST[id]'";
$dbquery = mysqli_query($connect,$sql);
}

if ($index==6.1){
$rec_date = date("Y-m-d");
$sql = "update budget_reserve_money set receive_doc='$_POST[receive_doc]',receive_amount='$_POST[receive_amount]', receive_rec_date='$rec_date' where id='$_POST[id]'";
$dbquery = mysqli_query($connect,$sql);
}

//ส่วนแสดงรายละเอียด
if ($index==7){
echo "<Center>";
echo "<Font color='#006666' Size=3><B>รายละเอียดรายการเงินทดรองราชการ ปีงบประมาณ $year_active_result[budget_year]</B></Font>";
echo "</Cener>";
echo "<Br>";
$sql = "select * from budget_reserve_money where id='$_GET[id]'";
$dbquery = mysqli_query($connect,$sql);
$ref_result = mysqli_fetch_array($dbquery);
list($rec_year,$rec_month,$rec_day) = explode("-",$ref_result['rec_date']);
echo "<Br>";
echo "<Table  align='center' width='70%' Border='0' Bgcolor='#Fcf9d8'>";
echo "<Tr ><Td colspan='7' align='right'><INPUT TYPE='button' name='smb' value='<<กลับหน้าก่อน' onclick='location.href=\"?option=budget&task=main/reserve_money&page=$_GET[page]\"'></Td></Tr>";

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

echo "<Tr align='left'><Td align='right'>ที่เอกสาร&nbsp;&nbsp;</Td><Td><Input Type='Text' Name='doc' id='doc' Size='20' value='$ref_result[document]' readonly></Td></Tr>";

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

echo "<Tr align='left'><Td align='right'>รายการ&nbsp;&nbsp;</Td><Td><Input Type='Text' Name='item' id='item' Size='50'  value='$ref_result[item]' readonly></Td></Tr>";

echo "<Tr align='left'><Td align='right'>จำนวนเงินยืม&nbsp;&nbsp;</Td><Td><Input Type='Text' Name='pay_amount' id='pay_amount' Size='15'  value='$ref_result[pay_amount]' readonly><Input Type='Text' Name='' id='p' Size='10'  value='$ref_result[pay_rec_date]' readonly></Td></Tr>";

echo "<Tr align='left'><Td align='right'>ผู้ยืม&nbsp;&nbsp;</Td><Td><Input Type='Text' Name='' id='' Size='15'  value='$ref_result[borrowed_person]' readonly></Td></Tr>";

$sql = "select  * from  person_main where person_id='$ref_result[officer]' ";
$dbquery = mysqli_query($connect,$sql);
$result = mysqli_fetch_array($dbquery);
$fullname=$result['prename'].$result['name']." ".$result['surname'];
echo "<Tr align='left'><Td align='right'>เจ้าหน้าที่&nbsp;&nbsp;</Td><Td><Input Type='Text' Name='' Size='30' value='$fullname' readonly></Td></Tr>";
echo "</Table>";

echo "<Br>";
echo "<table><tr><td>";
echo "<fieldset>";
echo "<legend>&nbsp;<B>ส่วนของการคืนเงินยืม</B>: &nbsp;</legend>";
echo "<table>";
echo "<Tr align='left'><Td align='right'>ที่เอกสาร&nbsp;&nbsp;</Td><Td><Input Type='Text' Size='10' value='$ref_result[receive_doc]' readonly></Td></Tr>";
echo "<Tr align='left'><Td align='right'>จำนวนเงินคืน&nbsp;&nbsp;</Td><Td><Input Type='Text' Name='receive_amount' id='receive_amount' Size='15'  value='$ref_result[receive_amount]' readonly></Td></Tr>";
echo "<Tr align='left'><Td align='right'>วันที่คืน (ปี เดือน วัน)&nbsp;&nbsp;</Td><Td><Input Type='Text' Size='10' value='$ref_result[receive_rec_date]' readonly></Td></Tr>";

echo "</table>";
echo "</fieldset></td></tr></table>";
}

//ส่วนแสดงผล
if(!(($index==1) or ($index==2) or ($index==5) or ($index==7) or ($index==1.1))){

//ส่วนของการคำนวณ
$sql = "select * from budget_reserve_money where budget_year='$year_active_result[budget_year]'";

$receive_total=0;  //ตัวแปรรวมรายรับทั้งหมด
$pay_total=0;

$dbquery = mysqli_query($connect,$sql);
$num_rows = mysqli_num_rows($dbquery );  // นำตัวแปรไปใช้ในส่วนของการแยกหน้า
While ($result = mysqli_fetch_array($dbquery)) {
$receive_total=$receive_total+$result ['receive_amount']; //รวมรับทั้งหมด
$pay_total=$pay_total+$result ['pay_amount']; //รวมจ่ายทั้งหมด
}
$net_amount=$pay_total-$receive_total;
$net_amount=number_format($net_amount,2);

//ส่วนของการแยกหน้า
$pagelen=20;  // กำหนดแถวต่อหน้า
$url_link="option=budget&task=main/reserve_money";  //กำหนดลิงค์ฺ

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

		//link เพิ่มข้อมูล
		echo  "<table width=95% border=0 align=center>";
		echo "<Tr><Td align='left'><INPUT TYPE='button' name='smb' value='จ่ายเงินทดรองราชการ' onclick='location.href=\"?option=budget&task=main/reserve_money&index=1\"'></Td>";
		echo "</Tr></Table>";

$sql = "select * from  budget_reserve_money where budget_year='$year_active_result[budget_year]' limit $start,$pagelen";

$dbquery = mysqli_query($connect,$sql);

echo  "<table width='95%' border='0' align='center'>";
echo "<tr bgcolor='#FFCCCC' align='center'><td width='50'>ที่</td><td width='70'>วดป</td><td width='70'>ที่เอกสาร</td><td width='70'>ที่อ้างอิง</td><td>รายการ</td><td width='90'>จำนวนเงินยืม</td><td width='90'>จำนวนเงินคืน</td><Td width='50'>รายละเอียด</Td><td width='40'>ลบ</td><td width='40'>แก้ไข</td><Td width='50'>พิมพ์ใบสั่งจ่าย</Td></tr>";
$N=(($page-1)*$pagelen)+1;  //*เกี่ยวข้องกับการแยกหน้า
$M=1;
While ($result = mysqli_fetch_array($dbquery))
	{
		$id = $result['id'];
		$doc= $result['document'];
		$refer_wd_id= $result['refer_wd_id'];
		$item = $result['item'];
		$receive_amount = $result['receive_amount'];
		$pay_amount = $result['pay_amount'];
		$receive_amount=number_format($receive_amount,2);
		$pay_amount=number_format($pay_amount,2);
		$rec_date = $result['rec_date'];

list($rec_year,$rec_month,$rec_day) = explode("-",$rec_date);
$t_year=($rec_year+543)-2500;
			if(($M%2) == 0)
			$color="#FFFFC";
			else  	$color="#FFFFFF";

		echo "<Tr bgcolor=$color><Td align='center'>$N</Td><Td>$rec_day $t_month[$rec_month] $t_year</Td><Td align='left'>$doc</Td><Td align='center'>";
		if($refer_wd_id>0){
echo "<a href=?option=budget&task=main/refer_wd&id=$refer_wd_id&page=$page&back_page=reserve_money>$refer_wd_id</a>";
}
		echo "</Td><Td align='left'>";
		echo $item;
		echo "</Td><Td align='right'>$pay_amount</Td>";
		if($receive_amount>0){
		echo "<Td align='right'>$receive_amount</Td>";
		}
		else{
		echo "<Td align='center'><a href=?option=budget&task=main/reserve_money&index=1.1&id=$id&page=$_REQUEST[page]><img src=images/b_search.png border='0' alt='คลิก เพื่อคืนเงิน'></a></Td>";
		}
		echo "<Td width=90><div align=center><a href=?option=budget&task=main/reserve_money&id=$id&index=7&page=$page><img src=./images/browse.png border='0' alt='รายละเอียด'></a></td>";
			if($officer==$result['officer']){
		echo "<Td><div align='center'><a href=?option=budget&task=main/reserve_money&index=2&id=$id&page=$page><img src=images/drop.png border='0' alt='ลบ'></a></div></Td>
		<Td align='center'><a href=?option=budget&task=main/reserve_money&index=5&id=$id&page=$page><img src=images/edit.png border='0' alt='แก้ไข'></a></div></Td>";
		}
		else{
		echo "<td>&nbsp;</td><td>&nbsp;</td>";
		}
echo "<td align='center'><a href='modules/budget/main/form2.php?id=$id' target='_blank'><img src=images/b_print.png border='0' alt='print'></a></td>";
		echo "</Tr>";
$M++;
$N++;  //*เกี่ยวข้องกับการแยกหน้า
	}
echo "<tr bgcolor='#FFCCCC'><td></td><td></td><td></td><td></td><td align='center'>คงเหลือยังไม่คืน</td><td align='center'>$net_amount</td><td></td><td></td><td></td><td></td><td></td></tr>";
echo "</Table>";
}
?>
<script>
function goto_url(val){
	if(val==0){
		callfrm("?option=budget&task=main/reserve_money");   // page ย้อนกลับ
	}else if(val==1){
		if(frm1.doc.value == ""){
			alert("กรุณากรอกที่เอกสาร");
		}else if(frm1.item.value == ""){
			alert("กรุณากรอกรายการรับเงิน");
		}else if(frm1.pay_amount.value == ""){
			alert("กรุณากรอกจำนวนเงิน");
		}else if(frm1.borrowed_person.value == ""){
			alert("กรุณากรอกชื่อผู้ยืมเงิน");
		}else{
			callfrm("?option=budget&task=main/reserve_money&index=4");   //page ประมวลผล
		}
	}
}

function goto_url2(val){
	if(val==0){
		callfrm("?option=budget&task=main/reserve_money&page=<?=$_REQUEST[page]?>");   // page ย้อนกลับ
	}else if(val==1){
		if(frm1.receive_amount.value == ""){
			alert("กรุณากรอกจำนวนเงิน");
		}else{
			callfrm("?option=budget&task=main/reserve_money&index=6.1");   //page ประมวลผล
		}
	}
}

function goto_url_update(val){
	if(val==0){
		callfrm("?option=budget&task=main/reserve_money&page=<?=$_REQUEST[page]?>");   // page ย้อนกลับ
	}else if(val==1){
		if(frm1.update_date.value == ""){
			alert("กรุณาเลือกวันที่");
		}else if(frm1.update_month.value==""){
			alert("กรุณาเลือกเดือน");
		}else if(frm1.update_year.value==""){
			alert("กรุณากรอกปี");
		}else if(frm1.doc.value==""){
			alert("กรุณากรอกที่เอกสาร");
		}else if(frm1.item.value == ""){
			alert("กรุณากรอกรายการรับเงิน");
		}else{
			callfrm("?option=budget&task=main/reserve_money&index=6");   //page ประมวลผล
		}
	}
}

</script>

