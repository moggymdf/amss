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
        <font color="#006666" size="3"><strong>รายการขอเบิกฯที่วางฎีกาผิดใบงวด  ปีงบประมาณ <?php echo $year_active_result['budget_year']?></strong></font>
      </div></td>
  </tr>
</table>
<br>

<?php
$sql_person = "select  *  from person_main";
$dbquery_person = mysqli_query($connect,$sql_person);
While ($result_person = mysqli_fetch_array($dbquery_person )){
$person_id= $result_person['person_id'];
$person_name_ar[$person_id]= $result_person['name']." ".$result_person['surname'];
}

$sql= "select  budget_withdraw.item, budget_withdraw.rec_date, budget_withdraw.item, budget_withdraw.money, budget_withdraw.deega, budget_withdraw.officer, plan_acti.code_approve  from  budget_withdraw left join plan_acti on  budget_withdraw.pj_activity=plan_acti.code_acti where budget_withdraw.budget_year='$year_active_result[budget_year]'  and  plan_acti.budget_year='$year_active_result[budget_year]' and (budget_withdraw.deega>0 or budget_withdraw.deega is not null) ";
$dbquery = mysqli_query($connect,$sql);
//แสดงผล
echo  "<table width='70%' border='0' align='center'>";
echo "<Tr bgcolor='#FFCCCC' align='center'><Td width='10%'>ที่</Td><Td width='20%'>วดป</Td><Td width='30%'>รายการ</Td><Td width='30%'>จำนวนเงิน</Td><Td width='10%'>เจ้าหน้าที่</Td></Tr>";
$M=1;
While ($result = mysqli_fetch_array($dbquery)){
$rec_date= $result['rec_date'];
$deega= $result['deega'];
$item= $result['item'];
$officer= $result['officer'];
$money= $result['money'];
$money=number_format($money,2);
$code_approve=$result['code_approve'];

if($code_approve==""){
$code_approve="_";
}

list($category,$rev_num) = explode("_",$code_approve);

		$sql_deega= "select  receive_num  from budget_deega where deega_num='$deega' and  budget_year='$year_active_result[budget_year]' ";
		$dbquery_deega = mysqli_query($connect,$sql_deega);
		$result_deega = mysqli_fetch_array($dbquery_deega);

		if($result_deega['receive_num']==$rev_num){
		continue;
		}
		else{
		if(($M%2) == 0)
		$color="#FFFFC";
		else  $color="#FFFFFF";

		echo "<Tr bgcolor='$color' align='center'><Td align='center'>$M</Td><Td align='center'>$rec_date</Td><Td align='left'>$item</Td><Td align='right'>$money</Td><Td align='left'>$person_name_ar[$officer]</Td></Tr>";
		$M++;
		}
}
echo "</Table>";
?>
