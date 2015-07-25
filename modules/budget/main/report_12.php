<br />
<div align="center">
        <p><font color="#006666" size="3"><strong>รายงานการใช้จ่ายงบประมาณจำแนกตามรหัสงบประมาณ</strong></font></p>
      </div>
<br />
<?php
if($result_permission['p10']!=1){
exit();
}

if(!isset($_REQUEST['year_index'])){
$_REQUEST['year_index']="";
}

//ปีงบประมาณ
$year_index=$_REQUEST['year_index'];
if($year_index!=""){
$year_active_result['budget_year']=$year_index;
}
else{
$sql = "select * from  budget_year where year_active='1' order by budget_year desc limit 1";
$dbquery = mysqli_query($connect,$sql);
$year_active_result = mysqli_fetch_array($dbquery);
			if($year_active_result['budget_year']==""){
			echo "<br />";
			echo "<div align='center'>ยังไม่ได้กำหนดทำงานในปีงบประมาณใด ๆ  กรุณาไปที่เมนูตั้งค่าระบบ เพื่อกำหนดปีงบประมาณ</div>";
			exit();
			}
}

$sql = "select * from  budget_pay_type order by pay_type_id";  // สร้างตัวแปรอาเรย์ของรหัสประเภทรายจ่าย
$dbquery = mysqli_query($connect,$sql);
$ms2=1;
While ($result = mysqli_fetch_array($dbquery))
{
$code= $result['pay_type_id'];
$name= $result['pay_type_name'];
$name_ar[$code]=$name;
$ms2++;
}

$sql = "select distinct pay_group from budget_deega where budget_year='$year_active_result[budget_year]' order by  pay_group";  //แยกรหัสประเภทรายจ่ายจากฎีกา
$dbquery = mysqli_query($connect,$sql);
$ms=1;
While ($result = mysqli_fetch_array($dbquery))
{
$code= $result['pay_group'];
$code_ar[$ms]=$code;
$ms++;
}

$sql = "select  distinct  project  from budget_deega where budget_year='$year_active_result[budget_year]' order by project";  //แยกรหัสงบประมาณจากฎีกา
$dbquery = mysqli_query($connect,$sql);
$rd=1;
While ($result = mysqli_fetch_array($dbquery))
		{
		$project= $result['project'];
		$project_ar[$rd]=$project;
		$rd++;
	 	}

$sql = "select  distinct  project  from  budget_receive where budget_year='$year_active_result[budget_year]' order by  project";  //แยกรหัสงบประมาณจากเงินงวด
$dbquery = mysqli_query($connect,$sql);
$rd2=1;
While ($result = mysqli_fetch_array($dbquery))
		{
		$project_receive= $result['project'];
		$project_receive_ar[$rd2]=$project_receive;
		$rd2++;
	 	}

$x=$rd;		//รวมรหัสงบประมาณระหว่างรหัสจากเงินงวดและรหัสจากฎีกา
for($rd3=1;$rd3<$rd2;$rd3++)
{
		$rd_num=0;
		for($rd4=1;$rd4<$x;$rd4++)
		{
			if($project_receive_ar[$rd3]==$project_ar[$rd4])
			$rd_num=$rd_num+1;
		}
	if($rd_num==0)
	{
	$project_ar[$rd]=$project_receive_ar[$rd3];
	$rd=$rd+1;
	}
}


//เงินคืนคลัง
$ld=$rd;
$money_redeega_total="";
$money_redeega_total_f="";
	for($i=1;$i<$ld;$i++){
	//กำหนดตัวแปร
	$money_redeega_sum[$i]=0;
		$sql = "select  project, money  from  budget_return_deega where project='$project_ar[$i]' and budget_year='$year_active_result[budget_year]'";              // รวมเงินคืนคลังในแต่ละรหัสงบประมาณ
		$dbquery = mysqli_query($connect,$sql);
		While ($result = mysqli_fetch_array($dbquery))
		{
		$money_redeega= $result['money'];
		$money_redeega_sum[$i]=$money_redeega_sum[$i]+$money_redeega;
		}

	$money_redeega_sum_f[$i]=number_format($money_redeega_sum[$i],2);
	$money_redeega_total=$money_redeega_total+$money_redeega_sum[$i];
	$money_redeega_total_f=number_format($money_redeega_total,2);
	}
////
//งบรายจ่าย
	for($i=1;$i<$ms;$i++){
	$money_paygr_ar[$i]=0;
		$sql = "select pay_group, money from budget_return_deega where pay_group='$code_ar[$i]' and budget_year='$year_active_result[budget_year]'";              // รวมเงินคืนคลังในแต่ประเภทการจ่าย
		$dbquery = mysqli_query($connect,$sql);
		While($result = mysqli_fetch_array($dbquery))
		{
		$money_paygr = $result['money'];
		$money_paygr_ar[$i]=$money_paygr_ar[$i]+$money_paygr;
		}
	}

$withdraw_all=0;  //เบิกเงินทั้งหมด
$withdraw_all2=0;

for($i=1;$i<$rd;$i++)  //รวมรายการเบิกตามรหัสงบประมาณ
{
$withdraw_sum=0;
$sql = "select  withdraw from  budget_deega where project='$project_ar[$i]' and budget_year='$year_active_result[budget_year]'";

$dbquery = mysqli_query($connect,$sql);
While ($result = mysqli_fetch_array($dbquery))
		{
		$withdraw= $result['withdraw'];
		$withdraw_sum=$withdraw_sum+$withdraw;
		}
$withdraw_sum_ar[$i]=$withdraw_sum;
$withdraw_all=$withdraw_all+$withdraw_sum_ar[$i];
}

//รวมรายรับตามรหัสงบประมาณ
$sum_receive_money=0;
for($i=1;$i<$rd;$i++)
{
$total_receive_money=0;
$sql = "select  money  from budget_receive where  project='$project_ar[$i]' and budget_year='$year_active_result[budget_year]'";
		$dbquery = mysqli_query($connect,$sql);
		While ($result = mysqli_fetch_array($dbquery))
		{
		$receive_money= $result['money'];
		$total_receive_money=$total_receive_money+$receive_money;
		}
$total_receive_money_ar[$i]=$total_receive_money;
$net_project_ar[$i]=$total_receive_money_ar[$i]-$withdraw_sum_ar[$i]+$money_redeega_sum[$i];
$sum_receive_money=$sum_receive_money+$total_receive_money_ar[$i];

		if($total_receive_money_ar[$i]<>0)
		{
		$percent[$i]=($withdraw_sum_ar[$i]/$total_receive_money_ar[$i])*100;
		$percent[$i]=number_format($percent[$i],2);
		}
		else{
		$percent[$i]="";
		}
$total_receive_money_ar[$i]=number_format($total_receive_money_ar[$i],2);
$net_project_ar[$i]=number_format($net_project_ar[$i],2);
}


//////////////////	เลือกปีงบประมาณ
echo "<form  name='frm1'>";
	echo "<table width='95%' align='center'><tr><td align='right'>";
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

echo  "<table width=95% border=0 align=center>";
echo "<Tr bgcolor=#FFCCCC align=center class=style2><Td>ที่</Td><Td>รหัสงบประมาณ</Td><Td>งบรายจ่าย</Td><Td>เงินตามใบงวด</Td><Td>ฎีกาเบิก</Td><Td>คืนคลัง</Td><Td>คงเหลือ</Td><Td>%จ่าย</Td><Td></Td></Tr>";

for($i=1;$i<$rd;$i++)
{
$withdraw1_sum_ar[$i]=number_format($withdraw_sum_ar[$i],2);
echo "<Tr bgcolor='#FFFFCC' align='center'><Td>$i</Td><Td align='left'>$project_ar[$i]</Td><Td align='right'></Td><Td align='right'>$total_receive_money_ar[$i]</Td><Td align='right'>$withdraw1_sum_ar[$i]</Td><Td align='right'>$money_redeega_sum_f[$i]</Td><Td align='right'>$net_project_ar[$i]</Td><Td align='right'>$percent[$i]</Td><Td></Td></Tr>";

						for($m=1;$m<$ms;$m++)
						{
									$withdraw2_sum=0;
									$sql = "select withdraw from budget_deega where project='$project_ar[$i]' and  pay_group='$code_ar[$m]' and budget_year='$year_active_result[budget_year]'";
									$dbquery = mysqli_query($connect,$sql);
									While ($result = mysqli_fetch_array($dbquery))
									{
									$withdraw2= $result['withdraw'];
									$withdraw2_sum=$withdraw2_sum+$withdraw2;
									}
									$withdraw22_sum=number_format($withdraw2_sum,2);
									if($withdraw2_sum!=0)
									{
									$pay_group=$code_ar[$m];
									echo "<Tr  align=center class=style1><Td></Td><Td align=left></Td><Td align=left>$code_ar[$m]$name_ar[$pay_group]</Td><Td></Td><Td align=right><font color=#993300>$withdraw22_sum</font></Td><Td align=right></Td><Td></Td><Td></Td>
									<Td><div align=center><font size=3><a href=?option=budget&task=main/report_12_2&year_index=$year_active_result[budget_year]&project=$project_ar[$i]&pay_group=$code_ar[$m]><img src=images/browse.png border='0' alt='รายละเอียด'></a></font></div></Td>
									</Tr>";
									}
						if(!isset($withdraw2_sum_ar[$m])){
						$withdraw2_sum_ar[$m]=0;
						}
						$withdraw2_sum_ar[$m]=$withdraw2_sum_ar[$m]+$withdraw2_sum;
						$withdraw_all2=$withdraw_all2+$withdraw2_sum;
						}
}
$withdraw_all=number_format($withdraw_all,2);
$withdraw_all2=number_format($withdraw_all2,2);
$sum_receive_money_f=number_format($sum_receive_money,2);
echo "<Tr bgcolor=#FFCCCC align=center class=style1><Td></Td><Td align=center>รวม</Td><Td></Td><Td align=center>$sum_receive_money_f</Td><Td align=center>$withdraw_all</Td><Td align=right>$money_redeega_total_f</Td>
<Td></Td><Td></Td><Td></Td></Tr>";
echo "</Table>";
echo "<br>";

echo  "<table width=50% border=0 align=center>";
echo "<Tr bgcolor=#FFCCCC align=center class=style2><Td>ที่</Td><Td>รหัส</Td><Td>งบรายจ่าย</Td><Td>ฎีกาเบิก</Td><Td>คืนคลัง</Td></Tr>";
for($m=1;$m<$ms;$m++)
{
		if(isset($money_paygr_ar[$m])){
		$money_paygr_ar[$m]=number_format($money_paygr_ar[$m],2);
		}
		else{
		$money_paygr_ar[$m]=0.00;
		}
$money=number_format($withdraw2_sum_ar[$m],2);
$pay_group=$code_ar[$m];
echo "<Tr><Td align='center''>$m</Td><Td>$code_ar[$m]</Td><Td>$name_ar[$pay_group]</Td><Td align=right>$money</Td><Td align='right'>$money_paygr_ar[$m]</Td></Tr>";
}
echo "</Table>";
?>
<script>
function goto_url(val){
callfrm("?option=budget&task=main/report_12");
}
</script>
