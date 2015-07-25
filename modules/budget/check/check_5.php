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
        <font color="#006666" size="3"><strong>ตรวจสอบฎีกากับการอ้างอิงการขอเบิกฯ  จำแนกตามฎีกา ปีงบประมาณ <?php echo $year_active_result['budget_year']?></strong></font>
      </div></td>
  </tr>
</table>
<br>

<?php
//ส่วนของการแยกหน้า
$sql = "select * from  budget_deega where budget_year='$year_active_result[budget_year]' and receive_num!='oth' and receive_num!='sly' and receive_num!='ctr' and receive_num!='etr' order by id ";
$dbquery = mysqli_query($connect,$sql);
$num_rows=mysqli_num_rows($dbquery); //นำไปแยกหน้า
$pagelen=20 ; // 1.กำหนดแถวต่อหน้า
$url_link="option=budget&task=check/check_5";  // 2_กำหนดลิงค์ฺ
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

$sql = "select * from  budget_deega where budget_year='$year_active_result[budget_year]' and receive_num!='oth' and receive_num!='sly' and receive_num!='ctr' and receive_num!='etr' order by id limit $start,$pagelen";
$dbquery = mysqli_query($connect,$sql);
//แสดงผล
echo  "<table width='60%' border='0' align='center'>";
echo "<Tr bgcolor='#FFCCCC' align='center'><Td width='20%'>เลขที่ฎีกา</Td><Td width='30%'>จำนวนเงินตามฎีกา</Td><Td width='30%'>จำนวนเงินอ้างอิงไปยังการขอเบิกฯ</Td><Td width='20%'>ส่วนต่าง</Td></Tr>";
$N=(($page-1)*$pagelen)+1;  //*เกี่ยวข้องกับการแยกหน้า
$M=1;
While ($result = mysqli_fetch_array($dbquery)){
$deega_num= $result['deega_num'];
$withdraw= $result['withdraw'];
		if(($M%2) == 0)
		$color="#FFFFC";
		else  $color="#FFFFFF";

		$sql_withdraw = "select  sum(money) as withdraw_money from  budget_withdraw where  budget_year='$year_active_result[budget_year]' and deega='$deega_num'";
		$dbquery_withdraw=mysqli_query($connect,$sql_withdraw);
		$result_withdraw = mysqli_fetch_array($dbquery_withdraw);
		$withdraw_money=$result_withdraw['withdraw_money'];
		$net=$withdraw-$withdraw_money;
		$net2=number_format($net,2);
		$withdraw=number_format($withdraw,2);
		$withdraw_money=number_format($withdraw_money,2);
echo "<Tr bgcolor='$color' align='center'><Td align='center'>$deega_num</Td><Td align='right'>$withdraw</Td><Td align='right'>$withdraw_money</Td><Td align='right'>$net2</Td></Tr>";
$M++;
$N++;  //*เกี่ยวข้องกับการแยกหน้า
}
echo "</Table>";
?>
