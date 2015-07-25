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
        <font color="#006666" size="3"><strong>รายการขอเบิกฯที่ยังไม่ได้วางฎีกา  ปีงบประมาณ <?php echo $year_active_result['budget_year']?></strong></font>
      </div></td>
  </tr>
</table>
<br>

<?php
//ส่วนของการแยกหน้า
$sql= "select  id  from  budget_withdraw where  budget_year='$year_active_result[budget_year]'  and  (budget_withdraw.deega <1 or budget_withdraw.deega is null) ";
$dbquery = mysqli_query($connect,$sql);
$num_rows=mysqli_num_rows($dbquery); //นำไปแยกหน้า
$pagelen=20 ; // 1.กำหนดแถวต่อหน้า
$url_link="option=budget&task=check/check_6";  // 2_กำหนดลิงค์ฺ
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

$sql= "select budget_withdraw.id, budget_withdraw.item, budget_withdraw.rec_date, budget_withdraw.item, budget_withdraw.money, person_main.name, person_main.surname  from  budget_withdraw left join person_main on  budget_withdraw.officer=person_main.person_id where budget_withdraw.budget_year='$year_active_result[budget_year]'  and  (budget_withdraw.deega <1 or budget_withdraw.deega is null)  order by budget_withdraw.id  limit $start,$pagelen";
$dbquery = mysqli_query($connect,$sql);
//แสดงผล
echo  "<table width='80%' border='0' align='center'>";
echo "<Tr bgcolor='#FFCCCC' align='center'><Td width='10%'>ที่</Td><Td width='10%'>วดป</Td><Td width='40%'>รายการ</Td><Td width='20%'>จำนวนเงิน</Td><Td width='20%'>เจ้าหน้าที่</Td></Tr>";
$N=(($page-1)*$pagelen)+1;  //*เกี่ยวข้องกับการแยกหน้า
$M=1;
While ($result = mysqli_fetch_array($dbquery)){
$item= $result['item'];
$money= $result['money'];
$money=number_format($money,2);
$rec_date=$result['rec_date'];
$name= $result['name'];
$surname= $result['surname'];
	if(($M%2) == 0)
		$color="#FFFFC";
		else  $color="#FFFFFF";

echo "<Tr bgcolor='$color' align='center'><Td align='center'>$M</Td><Td align='center'>$rec_date</Td><Td align='left'>$item</Td><Td align='right'>$money</Td><Td align='left'>$name $surname </Td></Tr>";
$M++;
$N++;  //*เกี่ยวข้องกับการแยกหน้า
}
echo "</Table>";
?>
