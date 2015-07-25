<?php
/** ensure this file is being included by a parent file */
defined( '_VALID_' ) or die( 'Direct Access to this location is not allowed.' );
if(!($_SESSION['login_status']<=15)){
exit();
}

$officer=$_SESSION['login_user_id'];

//ปีงบประมาณ
$sql = "select * from  budget_year where year_active='1' order by budget_year desc limit 1";
$dbquery = mysqli_query($connect,$sql);
$year_active_result = mysqli_fetch_array($dbquery);
if($year_active_result['budget_year']==""){
echo "<br />";
echo "<div align='center'>ยังไม่ได้กำหนดทำงานในปีงบประมาณใด ๆ  กรุณาไปที่เมนูตั้งค่าระบบ เพื่อกำหนดปีงบประมาณ</div>";
exit();
}
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

?>
<br />
<table width="90%" border="0" align="center">
  <tr>
    <td><div align="center">
        <p><font color="#006666" size="3"><strong>ทะเบียนโอนการเปลี่ยนแปลงการจัดสรรงบประมาณ ปีงบประมาณ <?php echo $year_active_result['budget_year']?></strong></font></p>
      </div></td>
  </tr>
</table>

<?php

if($index==7){
$sql = "select * from  budget_receive where id=$_GET[id]";
$dbquery = mysqli_query($connect,$sql);
While ($result = mysqli_fetch_array($dbquery))
	{
		$id = $result['id'];
		$num= $result['num'];
		$book_number= $result['book_number'];
		$out_date= $result['out_date'];
		$book_ref= $result['book_ref'];
		$plan= $result['plan'];
		$project= $result['project'];
		$activity= $result['activity'];
		$activity2= $result['activity2'];
		$m_source= $result['m_source'];
		$account= $result['account'];
		$m_pay= $result['m_pay'];
		$item= $result['item'];
		$detail= $result['detail'];
		$money= $result['money'];
		$file= $result['file'];
		$money=number_format($money,2);
		$rec_date= $result['rec_date'];
		$officer= $result['officer'];
	}

	$sql = "select  * from  budget_plan where budget_year='$year_active_result[budget_year]'";
	$dbquery = mysqli_query($connect,$sql);
	While ($result = mysqli_fetch_array($dbquery))
	{
			$code = $result['code'];
			$name = $result['name'];
			$plan_ar[$code]=$name;
	}

	$sql = "select  * from  budget_project where budget_year='$year_active_result[budget_year]'";
	$dbquery = mysqli_query($connect,$sql);
	While ($result = mysqli_fetch_array($dbquery))
	{
			$code = $result['code'];
			$name = $result['name'];
			$project_ar[$code]=$name;
	}

	$sql = "select  * from  budget_key_activity where budget_year='$year_active_result[budget_year]'";
	$dbquery = mysqli_query($connect,$sql);
	While ($result = mysqli_fetch_array($dbquery))
	{
			$code = $result['code'];
			$name = $result['name'];
			$activity_ar[$code]=$name;
	}

	$sql = "select  * from  budget_money_source where budget_year='$year_active_result[budget_year]'";
	$dbquery = mysqli_query($connect,$sql);
	While ($result = mysqli_fetch_array($dbquery))
	{
			$code = $result['code'];
			$name = $result['name'];
			$m_source_ar[$code]=$name;
	}

	$sql = "select * from budget_pay_type order by pay_type_id";
	$dbquery = mysqli_query($connect,$sql);
	While ($result = mysqli_fetch_array($dbquery))
	{
			$code = $result['pay_type_id'];
			$name = $result['pay_type_name'];
			$pay_group_ar[$code]=$name;
	}
echo "<Table  align='center' width='85%' Border='0'>";
echo "<Tr ><Td colspan='2' align='right'><INPUT TYPE='button' name='smb' value='<<กลับหน้าก่อน' onclick='location.href=\"?option=budget&task=budget_unit/receive_report&page=$_GET[page]\"'></Td></Tr>";
echo "<Tr><Td align='right' width='30%'>เลขที่ใบงวด&nbsp;&nbsp;</Td><Td><Input Type=Text Name=''_number Size='5'  value='$num'></Td></Tr>";
echo "<Tr><Td align='right' width='30%'>เลขที่หนังสือ&nbsp;&nbsp;</Td><Td><Input Type=Text Name='book'_number Size='20'  value='$book_number'></Td></Tr>";
echo "<Tr><Td align='right'>ลงวันที่&nbsp;&nbsp;</Td><Td><Input Type='Text'  name='out_date' Size='20' value='$out_date'></Td></Tr>";
echo "<Tr><Td align='right'>อ้างอิงหนังสือจัดสรร&nbsp;&nbsp;</Td><Td><Input Type='Text' Name='book_ref' Size='20' value='$book_ref'></Td></Tr>";
echo "<Tr><Td align='right'>แผนงาน&nbsp;&nbsp;</Td><Td><Input Type='Text' Name='plan' Size='80'  value='$plan_ar[$plan]'></Td></Tr>";
echo "<Tr><Td align='right'>ผลผลิต/โครงการ&nbsp;&nbsp;</Td><Td><Input Type='Text' Name='project' Size='80'  value='$project&nbsp;$project_ar[$project]'></Td></Tr>";
echo "<Tr><Td align='right'>กิจกรรมหลัก&nbsp;&nbsp;</Td><Td><Input Type='Text' Name='activity' Size='80' value='$activity&nbsp;$activity_ar[$activity]'></Td></Tr>";
echo  "<tr><td align='right'>กิจกรรมหลักเพิ่มเติม&nbsp;&nbsp;</td>";
echo   "<td><div align='left'><textarea  name='activity2' cols='40' rows='2'>$activity2</textarea></div></td></tr>";
echo "<Tr><Td align='right'>แหล่งของเงิน&nbsp;&nbsp;</Td><Td><Input Type='Text' Name='m_source' Size='60' value='$m_source&nbsp;$m_source_ar[$m_source]'></Td></Tr>";
echo "<Tr><Td align='right'>รหัสบัญชี&nbsp;&nbsp;</Td><Td><Input Type='Text' Name='account' Size='20'  value='$account'></Td></Tr>";
echo "<Tr><Td align='right'>งบรายจ่าย&nbsp;&nbsp;</Td><Td><Input Type='Text' Name='m_pay' Size='60'  value='$m_pay&nbsp;$pay_group_ar[$m_pay]'></Td></Tr>";
echo "<Tr><Td align='right'>รายการ&nbsp;&nbsp;</Td><Td><Input Type='Text' Name='item' Size='80'  value='$item'></Td></Tr>";
echo   "<tr><td align='right'>รายละเอียด&nbsp;&nbsp;</td>";
echo   "<td><div align='left'><textarea  name='detail' cols='40' rows='4'>$detail</textarea></div></td></tr>";
echo "<Tr><Td align='right'>จำนวนเงิน&nbsp;&nbsp;</Td><Td><Input Type='Tex't Name='mone'y Size='20' value='$money'>&nbsp;บาท</Td></Tr>";
echo "<Tr><Td align='right'>บันทึกข้อมูล (ปีคศ.  เดือน วัน)&nbsp;&nbsp;</Td><Td><Input Type=Text  Size=20  value=$rec_date></Td></Tr>";
if($file!=""){
echo "<Tr><Td align='right'>ไฟล์เอกสาร&nbsp;&nbsp;</Td><Td><a href=$file target=_blank><img src=./images/browse.png border='0' alt='File'></Td></Tr>";
}
echo "<Tr><Td></Td><Td></Td></Tr>";
echo "<Br>";
echo "</Table>";
}

//ส่วนแสดงผล
if(!($index==7)){
//ส่วนของการคำนวณ
$receive_total=0; //iวมรับ
$sql="select * from budget_receive where budget_year='$year_active_result[budget_year]' order by num";
$dbquery = mysqli_query($connect,$sql);
$num_rows = mysqli_num_rows($dbquery );  //นำไปแยกหน้า
While ($result = mysqli_fetch_array($dbquery)) {
$receive_total=$receive_total+$result['money'];
$receive_total_ar[$result['id']]=$receive_total;   //รวมรับ รายรายการ
}

	//ส่วนของการแยกหน้า
$pagelen=20; // 1.กำหนดแถวต่อหน้า
$url_link="option=budget&task=budget_unit/receive_report";  //2.กำหนด url เพจ
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

$sql = "select * from budget_receive where budget_year='$year_active_result[budget_year]' order by num limit $start,$pagelen ";
$dbquery = mysqli_query($connect,$sql);
$num_effect = mysqli_num_rows($dbquery );  // จำนวนข้อมูลในหน้านี้
echo  "<table width='95%' border='0' align='center'>";
echo "<Tr bgcolor='#FFCCCC' align='center'><Td width='60'>ที่ใบงวด</Td><Td width='70'>วดป</Td><Td>รายการ</Td><Td width='120'>จำนวนเงิน</Td><Td width='50' align=center>รายละเอียด</td><td width='60'>รวม</Td></Tr>";
$N=(($page-1)*$pagelen)+1;  //*เกี่ยวข้องกับการแยกหน้า
$M=1;
While ($result = mysqli_fetch_array($dbquery))
	{
		$id = $result['id'];
		$num= $result['num'];
		$item= $result['item'];
		$money= $result['money'];
		$file= $result['file'];
		$money=number_format($money,2);
		$rec_date=$result['rec_date'];

		if(($M%2) == 0)
		$color="#FFFFC";
		else  	$color="#FFFFFF";
		list($rec_year,$rec_month,$rec_day) = explode("-",$rec_date);
		$t_year=($rec_year+543)-2500;

		echo "<Tr bgcolor='$color' align='center'><Td>$num</Td><Td align='left'>$rec_day $t_month[$rec_month] $t_year</Td><Td align='left'>";
		echo $item;
		echo "</Td><Td align=right>$money</Td>
		<Td><div align=center><a href=?option=budget&task=budget_unit/receive_report&index=7&id=$id&page=$page><img src=./images/browse.png border='0' alt='รายละเอียด'></a></td>";
	//กำหนดสัญญาลักษ์ ถึงนี้
		if($M==$num_effect){
		$tungnee="ถึงนี้";
		}
		else {
		$tungnee="ถึงนี้>>";
		}

		if(!isset($_GET['cal_id'])){
		$_GET['cal_id']="";
		}

		if($_GET['cal_id']==$id){
		echo "<Td align='center'><a href=?option=budget&task=budget_unit/receive_report&page=$page>$tungnee</a></Td>";
		echo "</Tr>";
		break;  //ออกจากloop
		}
		else {
		echo "<Td align='center'><a href=?option=budget&task=budget_unit/receive_report&cal_id=$id&page=$page>ถึงนี้</a></Td>";
		echo "</Tr>";
		}
$M++;
$N++; //*เกี่ยวข้องกับการแยกหน้า
	}
//สรุป
if(isset($id) and isset($receive_total_ar[$id])){
$receive_item_total=number_format($receive_total_ar[$id],2);
}
else{
$receive_item_total="";
}

echo "<Tr bgcolor='#FFCCCC'><Td colspan='2'></Td><Td align='center'>รวม</Td><Td align='center'>$receive_item_total</Td><Td colspan='3'></Td></Tr>";
echo "</Table>";
}
//จบส่วนแสดงผล

?>
