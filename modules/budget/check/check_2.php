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
        <font color="#006666" size="3"><strong>ตรวจสอบการจัดสรรงบประมาณ ปีงบประมาณ <?php echo $year_active_result['budget_year']?></strong></font>
      </div></td>
  </tr>
</table>
<br>
<?php

					$sql = "select * from  budget_receive where budget_year='$year_active_result[budget_year]' order by  num";
					$dbquery = mysqli_query($connect,$sql);
					$rd=1;
					While ($result = mysqli_fetch_array($dbquery))
						{
						$id = $result['id'];
						$num= $result['num'];
						$item= $result['item'];
						$money= $result['money'];

						$num_ar[$rd]=$num;
						$item_ar[$rd]=$item;
						$money_ar[$rd]=$money;
						$rd++;
	    				}

for($i=1;$i<$rd;$i++)
{
$num_index="2_$num_ar[$i]";
					$sql = "select * from  plan_acti  where code_approve='$num_index' and budget_year='$year_active_result[budget_year]'";
					$dbquery = mysqli_query($connect,$sql);
					$sum_budget=0;
					While ($result = mysqli_fetch_array($dbquery))
						{
							$code_proj_acti= $result['code_proj'];
							$budget_acti= $result['budget_acti'];
							$sum_budget=$sum_budget+$budget_acti;
	    				}
						$sum_budget_ar[$i]=$sum_budget;
}


echo  "<table width='80%' border='0' align='center'>";
echo "<Tr bgcolor=#FFCCCC align=center class=style2><Td>ใบงวด</Td><Td>รายการ</Td><Td>จำนวนเงินตามใบงวด</Td><Td>จัดสรรกิจกรรมในโครงการ</Td><Td align='center'>คงเหลือ</Td></Tr>";
for($x=1;$x<$rd;$x++)
{
	$net=$money_ar[$x]-$sum_budget_ar[$x];
	if($net==0)
	$net1="ครบ";
	else
	$net1=number_format($net,2);
	$money_rec=number_format($money_ar[$x],2);
	$sum_budget=number_format($sum_budget_ar[$x],2);
			if(($x%2) == 0)
			$color="#FFFFC";
			else  	$color="#FFFFFF";
		echo "<Tr bgcolor=$color align=center class=style1><Td>$num_ar[$x]</Td><Td align=left>$item_ar[$x]</Td><Td align=right>$money_rec</Td><Td align=right>$sum_budget</Td><Td align=right>$net1</Td></Tr>";
}
echo "</Table>";
?>
