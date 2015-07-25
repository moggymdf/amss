<br />
<table width="90%" border="0" align="center">
  <tr>
    <td><div align="center">
        <p><font color="#006666" size="3"><strong>รายงานการเงิน จำแนกตามงบรายจ่าย</strong></font></p>
      </div></td>
  </tr>
</table>
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
	//กรณีเลือกปี
	$year_index=$_REQUEST['year_index'];
	if($year_index!=""){
		$year_active_result['budget_year']=$year_index;
	}

$pay_group_name_ar[1]="งบบุคลากร";
$pay_group_name_ar[2]="งบดำเนินงาน";
$pay_group_name_ar[3]="งบลงทุน";
$pay_group_name_ar[4]="งบเงินอุดหนุน";
$pay_group_name_ar[5]="งบรายจ่ายอื่น";
$pay_group_name_ar[6]="งบกลาง";
$pay_group_name_ar[7]="งบอื่นๆ";

//////////////////	เลือกปีงบประมาณ
echo "<form  name='frm1'>";
	echo "<table width='85%' align='center'><tr><td align='right'>";
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

echo  "<table width='85%' border='0' align='center'>";
echo "<Tr bgcolor='#FFCCCC' align='center'><Td width='90'>ที่</Td><Td>งบรายจ่าย</Td><Td width='110'>จำนวนเงิน</Td><Td width='110'>ฎีกาเบิก</Td><Td width='110'>คืนคลัง</Td><Td width='110'>คงเหลือ</Td><Td width='70'>%จ่าย</Td><Td width='40'></Td></Tr>";
$N=1;
$M=1;
for ($x=1;$x<=7;$x++){
$sql = "select  sum(budget_receive.money) as money from  budget_receive left join budget_pay_type on  budget_receive.m_pay=budget_pay_type.pay_type_id  where  budget_receive.budget_year='$year_active_result[budget_year]'  and  budget_pay_type.pay_group_id='$x' ";
$dbquery = mysqli_query($connect,$sql);
$result = mysqli_fetch_array($dbquery);
	$money= $result['money'];
						for($i=1;$i<$rd;$i++)
						{
									if($num==$receive_num_ar[$i])
									{
									$withdraw_sum=$withdraw_sum+$withdraw_ar[$i];
									}
						}

						$money_return_sum=0;
						for($i=1;$i<$re;$i++)
						{
									if($num==$receive_num_re_ar[$i])
									{
									$money_return_sum=$money_return_sum+$money_re_ar[$i];
									}
						}




		$net=$money+$money_return_sum-$withdraw_sum;
		$net_total=$net_total+$net;
		$money_total=$money_total+$money;
		$money_return_total=$money_return_total+$money_return_sum;

		$withdraw_sum_total=$withdraw_sum_total+$withdraw_sum;
		if($money>0){
		$percent_deega=(($withdraw_sum-$money_return_sum)/$money)*100;
		$percent_deega=number_format($percent_deega,2);
		}
		$money1=number_format($money,2);
		$withdraw_sum1=number_format($withdraw_sum,2);
		$net1=number_format($net,2);

		$money_return_sum=number_format($money_return_sum,2);

			if(($M%2) == 0)
			$color="#FFFFC";
			else  	$color="#FFFFFF";
		echo "<Tr bgcolor=$color align='center'><Td>$M</Td><Td align='left'>$pay_group_name_ar[$x]</Td><Td align='right'>$money1</Td><Td align='right'>$withdraw_sum1</Td><Td align='right'>$money_return_sum</Td><Td align='right'>$net1</Td><Td align='right'>$percent_deega</Td>";
		if($percent_deega!=0){
		echo "<Td><div align='cente'r><a href=?option=budget&task=main/report_13_2&num=$num&page=$page&year_index=$year_active_result[budget_year]><img src=images/browse.png border='0'></a></div></Td>
	</Tr>";
		}
		else{
		echo "<td></td></tr>";
		}

$M++;
$N++;
}
		if($money_total<>0)
		$percent_total=(($withdraw_sum_total-$money_return_total)/$money_total)*100;

		$percent_total=number_format($percent_total,2);
		$money_total=number_format($money_total,2);
		$withdraw_sum_total=number_format($withdraw_sum_total,2);
		$net_total=number_format($net_total,2);
		$money_return_total=number_format($money_return_total,2);

		echo "<Tr bgcolor='#FFCCCC' align='center'><Td></Td><Td align='center'>รวม</Td><Td align='center'>$money_total</Td><Td align='center'>$withdraw_sum_total</Td><Td>$money_return_total</Td><Td align='center'>$net_total</Td><Td>$percent_total</Td>
		<Td></Td></Tr>";
echo "</Table>";

// งบกลาง
echo "<br>";
echo  "<table width='85%' border='0' align='center'>";
echo "<Tr bgcolor='#FFCCCC' align='center'><Td width='90'>ที่</Td><Td>งบกลาง</Td><Td width='110'>จำนวนเงิน</Td><Td width='110'>ฎีกาเบิก</Td><Td width='110'>คืนคลัง</Td><Td width='110'>คงเหลือ</Td><Td width='70'>%จ่าย</Td><Td width='40'></Td></Tr>";
$N=1;
$M=1;
$item_ar[1]="เงินเดือน";
$item_ar[2]="ค่ารักษาพยาบาล";
$item_ar[3]="ค่าการศึกษาบุตร";
$item_ar[4]="อื่นๆ";

for ($x=1;$x<=4;$x++){
$sql = "select  sum(budget_receive.money) as money from  budget_receive left join budget_pay_type on  budget_receive.m_pay=budget_pay_type.pay_type_id  where  budget_receive.budget_year='$year_active_result[budget_year]'  and  budget_pay_type.pay_group_id='$x' ";
$dbquery = mysqli_query($connect,$sql);
$result = mysqli_fetch_array($dbquery);
	$money= $result['money'];
						for($i=1;$i<$rd;$i++)
						{
									if($num==$receive_num_ar[$i])
									{
									$withdraw_sum=$withdraw_sum+$withdraw_ar[$i];
									}
						}

						$money_return_sum=0;
						for($i=1;$i<$re;$i++)
						{
									if($num==$receive_num_re_ar[$i])
									{
									$money_return_sum=$money_return_sum+$money_re_ar[$i];
									}
						}




		$net=$money+$money_return_sum-$withdraw_sum;
		$net_total=$net_total+$net;
		$money_total=$money_total+$money;
		$money_return_total=$money_return_total+$money_return_sum;

		$withdraw_sum_total=$withdraw_sum_total+$withdraw_sum;
		if($money>0){
		$percent_deega=(($withdraw_sum-$money_return_sum)/$money)*100;
		$percent_deega=number_format($percent_deega,2);
		}
		$money1=number_format($money,2);
		$withdraw_sum1=number_format($withdraw_sum,2);
		$net1=number_format($net,2);

		$money_return_sum=number_format($money_return_sum,2);

			if(($M%2) == 0)
			$color="#FFFFC";
			else  	$color="#FFFFFF";
		echo "<Tr bgcolor=$color align='center'><Td>$M</Td><Td align='left'>$item_ar[$x]</Td><Td align='right'>$money1</Td><Td align='right'>$withdraw_sum1</Td><Td align='right'>$money_return_sum</Td><Td align='right'>$net1</Td><Td align='right'>$percent_deega</Td>";
		if($percent_deega!=0){
		echo "<Td><div align='cente'r><a href=?option=budget&task=main/report_13_2&num=$num&page=$page&year_index=$year_active_result[budget_year]><img src=images/browse.png border='0'></a></div></Td>
	</Tr>";
		}
		else{
		echo "<td></td></tr>";
		}

$M++;
$N++;
}
		if($money_total<>0)
		$percent_total=(($withdraw_sum_total-$money_return_total)/$money_total)*100;

		$percent_total=number_format($percent_total,2);
		$money_total=number_format($money_total,2);
		$withdraw_sum_total=number_format($withdraw_sum_total,2);
		$net_total=number_format($net_total,2);
		$money_return_total=number_format($money_return_total,2);

		echo "<Tr bgcolor='#FFCCCC' align='center'><Td></Td><Td align='center'>รวม</Td><Td align='center'>$money_total</Td><Td align='center'>$withdraw_sum_total</Td><Td>$money_return_total</Td><Td align='center'>$net_total</Td><Td>$percent_total</Td>
		<Td></Td></Tr>";
echo "</Table>";

// End งบกลาง


?>

<script>
function goto_url(val){
callfrm("?option=budget&task=main/report_13");
}
</script>
