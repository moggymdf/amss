<br />
<div align="center">
        <font color="#006666" size="3"><strong>รายงานลูกหนี้เงินยืม</strong></font></p>
      </div>
<?php
if(!($_SESSION['login_status']<=5)){
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
$now=time();

if(!isset($_REQUEST['year_index'])){
$_REQUEST['year_index']="";
}

//ปีงบประมาณ
$sql = "select * from  budget_year where year_active='1' order by budget_year desc limit 1";
$dbquery = mysqli_query($connect,$sql);
$year_active_result = mysqli_fetch_array($dbquery);
if($year_active_result['budget_year']==""){
echo "<br />";
echo "<div align='center'>ยังไม่ได้กำหนดทำงานในปีงบประมาณใด ๆ  กรุณาไปที่เมนูตั้งค่าระบบ เพื่อกำหนดปีงบประมาณ</div>";
exit();
}
	//กรณีเลือกปี
	$year_index=$_REQUEST['year_index'];
	if($year_index!=""){
		$year_active_result['budget_year']=$year_index;
	}

//////////////////	เลือกปีงบประมาณ
echo "<form  name='frm1'>";
	echo "<table width='90%' align='center'><tr><td align='right'>";
	echo "ปีงบประมาณ&nbsp";
	echo "<Select  name='year_index' size='1'>";
	echo  '<option value ="" >เลือก</option>' ;
	$sql_year = "SELECT *  FROM  budget_year order by budget_year";
	$dbquery_year = mysqli_query($connect,$sql_year);
	While ($result_year = mysqli_fetch_array($dbquery_year)){
			 if($year_index==""){
					if($result_year['year_active']==1){
					echo "<option value=$result_year[budget_year]  selected>$result_year[budget_year]</option>";
					}
					else{
					echo "<option value=$result_year[budget_year]>$result_year[budget_year]</option>";
					}
			 }
			 else{
					if($year_index==$result_year['budget_year']){
					echo "<option value=$result_year[budget_year]  selected>$result_year[budget_year]</option>";
					}
					else{
					echo "<option value=$result_year[budget_year]>$result_year[budget_year]</option>";
					}
			}
	}
echo "</select>";
echo "&nbsp;<INPUT TYPE='button' name='smb' value='เลือก' onclick='goto_url(1)' class=entrybutton>";
echo "</td></tr></table>";
echo "</form>";
/////////////////////
$total=0;  //รวมเงินยืมทั้งหมด
echo  "<table width='90%' border='0' align='center'>";
echo "<Tr bgcolor='#FFCCCC' align='center'><Td width='60'>ที่</Td><Td width='80'>วันยืม</Td><Td width='150'>ผู้ยืม</Td><Td>รายการ</Td><Td width='	120'>จำนวนเงิน</Td><Td width='120'>ประเภทเงิน</Td><Td width='100'>สถานะ</Td></Tr>";
$N=1;
$sql = "select * from  budget_reserve_money where budget_year='$year_active_result[budget_year]' and receive_amount='0' ";
$sum_reserve_money=0;
$dbquery = mysqli_query($connect,$sql);
While ($result = mysqli_fetch_array($dbquery)){
		$id = $result['id'];
		$item= $result['item'];
		$pay_amount= $result['pay_amount'];
				$sum_reserve_money=$sum_reserve_money+$pay_amount;
				$total=$total+$pay_amount;
				$pay_amount_2=number_format($pay_amount,2);
		$pay_rec_date= $result['pay_rec_date'];
		$borrowed_person= $result['borrowed_person'];
list($rec_year,$rec_month,$rec_day) = explode("-",$pay_rec_date);
$borrow_day=mktime(0,0,0,$rec_month,$rec_day,$rec_year);
$time_between=$now-$borrow_day;
if($time_between>2592000){
$status_text="<font color='#CC0000'>ครบกำหนด</font>";
}
else{
$status_text="<font color='#33CC99'>ในเวลา</font>";
}
$t_year=($rec_year+543)-2500;
			if(($N%2) == o)
			$color="#FFFFC";
			else  	$color="#FFFFFF";


echo "<Tr bgcolor=$color align='center'><Td>$N</Td><Td align='center'>$rec_day $t_month[$rec_month] $t_year</Td><Td align='left'>$borrowed_person</Td><Td align='left'>$item</Td><Td align='right'>$pay_amount_2</Td><Td align='center'>เงินทดรองราชการ</Td><Td align='center'>$status_text</Td></Tr>";
$N++;
}
if($sum_reserve_money>0){
$sum_reserve_money=number_format($sum_reserve_money,2);
echo "<Tr bgcolor='#99FFFF' align='center'><Td></Td><Td></Td><Td></Td><Td align='center'>รวมเงินทดรองราชการ</Td><Td align='center'>$sum_reserve_money</Td><Td></Td><Td></Td></Tr>";
}

$sql = "select * from  budget_withdraw where budget_year='$year_active_result[budget_year]' and (borrow_status='1' or borrow_status='2') and withdraw_status='0' ";
$dbquery = mysqli_query($connect,$sql);
While ($result = mysqli_fetch_array($dbquery)){
		$item= $result['item'];
		$borrow_status= $result['borrow_status'];
				if($borrow_status==1){
				$budget_type="เงินงบประมาณ";
				}
				else if($borrow_status==2){
				$budget_type="เงินนอกงบประมาณ";
				}
				else {
				$budget_type="";
				}
		$money = $result['money'];
				$total=$total+	$money;
				$money_2=number_format($money,2);
		$p_request = $result['p_request'];
		$borrowed_rec_date  = $result['borrowed_rec_date'];
list($rec_year,$rec_month,$rec_day) = explode("-",$borrowed_rec_date);

$borrow_day=mktime(0,0,0,$rec_month,$rec_day,$rec_year);
$time_between=$now-$borrow_day;
if($time_between>2592000){
$status_text="<font color='#CC0000'>ครบกำหนด</font>";
}
else{
$status_text="<font color='#33CC99'>ในเวลา</font>";
}

$t_year=($rec_year+543)-2500;
			if(($N%2) == 0)
			$color="#FFFFC";
			else  	$color="#FFFFFF";
		echo "<Tr bgcolor=$color align='center'><Td>$N</Td><Td align='center'>$rec_day $t_month[$rec_month] $t_year</Td><Td align='left'>$p_request</Td><Td align='left'>$item</Td><Td align='right'>$money_2</Td><Td align='left'>$budget_type</Td><Td align='center'>$status_text</Td>
		</Tr>";
$N++;
}

$total=number_format($total,2);
echo "<Tr bgcolor='#FFCCCC' align='center'><Td></Td><Td></Td><Td></Td><Td>รวมทั้งสิ้น</Td><Td>$total</Td><Td></Td><Td></Td></Tr>";
echo "</Table>";
?>
<script>
function goto_url(val){
callfrm("?option=budget&task=main/report_8");
}
</script>

