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
        <font color="#006666" size="3"><strong>ฎีกาที่ไม่มีในระบบ ปีงบประมาณ <?php echo $year_active_result['budget_year']?></strong></font>
      </div></td>
  </tr>
</table>
<br>
<?php
				$sql = "select deega_num from budget_deega where budget_year='$year_active_result[budget_year]' order by deega_num desc";
				$dbquery = mysqli_query($connect,$sql);
				$result = mysqli_fetch_array($dbquery);
				$maxi= $result['deega_num'];

				$sql = "select deega_num from budget_deega where budget_year='$year_active_result[budget_year]' order by deega_num";
				$dbquery = mysqli_query($connect,$sql);
				$rd=1;
				While ($result = mysqli_fetch_array($dbquery))
					{
					$deega_num=$result['deega_num'];
					$deega_num_ar[$deega_num]=$deega_num;
					$rd++;
	 				}

				$sql_cancel = "select deega from budget_cancel_deega where budget_year='$year_active_result[budget_year]' order by deega";
				$dbquery_cancel = mysqli_query($connect,$sql_cancel);
				$rx=1;
				While ($result_cancel = mysqli_fetch_array($dbquery_cancel))
					{
					$deega_cancel=$result_cancel['deega'];
					$deega_cancel_ar[$deega_cancel]=$deega_cancel;
					$rx++;
	 				}


echo  "<table width='40%' border='0' align='center'>";
echo "<Tr bgcolor='#FFCCCC' align='center'><Td>ที่</Td><Td>เลขที่ฎีกา</Td></Tr>";
$M=1;
	for($i=1;$i<=$maxi;$i++){
			if(!isset($deega_num_ar[$i])){
					if(!isset($deega_cancel_ar[$i])){
							if(($M%2) == 0){
							$color="#FFFF99";
							}
							else {
							$color="#FFFFFF";
							}
					echo "<Tr bgcolor=$color align='center'><Td align='center'>$M</Td><Td>$i</Td></Tr>";
					$M++;
					}
			}
	}
echo "</Table>";
?>
