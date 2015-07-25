<?php
if($result_permission['p10']!=1){
exit();
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
?>

<br />
<table width="90%" border="0" align="center">
  <tr>
    <td><div align="center">
        <font color="#006666" size="3"><strong>ตรวจสอบการเบิกตามฎีกากับการตัดยอดโครงการ จำแนกตามใบงวด ปีงบประมาณ <?php echo $year_active_result['budget_year']?></strong></font>
      </div></td>
  </tr>
</table>
<br>

<?php
$sql = "select  num from  budget_receive where budget_year='$year_active_result[budget_year]' order by num desc";
$dbquery = mysqli_query($connect,$sql);
$result = mysqli_fetch_array($dbquery);
$maxi= $result['num'];

//หาจำนวนเงินเบิกแต่ละใบงวด
for($i=1;$i<=$maxi;$i++){
$withdraw_deega_sum=0;
		$sql = "select  sum(withdraw) as withdraw_sum  from  budget_deega  where  receive_num='$i' and budget_year='$year_active_result[budget_year]' ";
		$dbquery = mysqli_query($connect,$sql);
		While ($result = mysqli_fetch_array($dbquery)){
		$withdraw_sum_ar[$i]=$result['withdraw_sum'];
		}
}

//หาจำนวนเงินตัดกิจกรรมโครงการจำแนกตามใบงวด
for($i=1;$i<=$maxi;$i++){
$code_approve="2_$i";
$sql_act = "select  sum(budget_withdraw.money) as withdraw_money from  budget_withdraw left join plan_acti on budget_withdraw.pj_activity=plan_acti.code_acti where  plan_acti.code_approve='$code_approve' and budget_withdraw.budget_year='$year_active_result[budget_year]' and plan_acti.budget_year='$year_active_result[budget_year]'";
			$dbquery_act = mysqli_query($connect,$sql_act);
			$result_act = mysqli_fetch_array($dbquery_act);
			$withdraw_money[$i]=$result_act['withdraw_money'];
}

//แสดงผล
echo  "<table width=70% border=0 align=center>";
echo "<Tr bgcolor='#FFCCCC' align='center'><Td width='20%'>เลขที่ใบงวด</Td><Td width='30%'>จำนวนเงินเบิกตามฎีกา</Td><Td width='30%'>จำนวนเงินตัดตามโครงการ</Td><Td width='20%'>ส่วนต่าง</Td></Tr>";

$withdraw_deega_total=0;  //รวมเงินฎีกา
$withdraw_withdraw_total=0;  //รวมเงินเบิก
$net_sum=0;
$M=1;
for($i=1;$i<=$maxi;$i++)
{

$net=$withdraw_sum_ar[$i]-$withdraw_money[$i];
$net2=number_format($net,2);
$withdraw_deega=number_format($withdraw_sum_ar[$i],2);
$withdraw_widthdraw=number_format($withdraw_money[$i],2);
$withdraw_deega_total=$withdraw_deega_total+$withdraw_sum_ar[$i];
$withdraw_withdraw_total=$withdraw_withdraw_total+$withdraw_money[$i];

$net_sum=$net_sum+$net;

			if(($M%2) == 0)
			$color="#FFFFC";
			else  	$color="#FFFFFF";
		echo "<Tr bgcolor='$color' align='center'><Td>$i</Td><Td align='right'>$withdraw_deega</Td><Td align='right'>$withdraw_widthdraw</Td><Td align=right>$net2</Td></Td></Tr>";
$M++;
}
$withdraw_deega_total=number_format($withdraw_deega_total,2);
$withdraw_withdraw_total=number_format($withdraw_withdraw_total,2);
$net_sum=number_format($net_sum,2);

echo "<Tr bgcolor='#FFCCCC' align='center'><Td>รวม</Td><Td>$withdraw_deega_total</Td><Td>$withdraw_withdraw_total</Td><Td>$net_sum</Td></Tr>";
echo "</Table>";
echo "<br>";
echo "<b>หมายเหตุ</b>";
echo "&nbsp;&nbsp;ไม่ได้นำเงินคืนโครงการและเงินคืนคลังมาคำนวณ";
?>
