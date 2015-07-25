<br />
<div align="center">
        <font color="#006666" size="3"><strong>รายการฎีกาเบิกตามรหัสงบประมาณจำแนกตามงบรายจ่าย</strong></font>
      </div>
<?php
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
	if($year_index==""){
		$year_index=$year_active_result['budget_year'];
	}
//จบส่วนปีงบประมาณ

$sql = "select  id  from  budget_deega where project='$_GET[project]' and pay_group='$_GET[pay_group]' and budget_year='$year_index' ";
$dbquery = mysqli_query($connect,$sql);
$num_rows = mysqli_num_rows($dbquery );

//ส่วนของการแยกหน้า
$pagelen=20;  //จำนวนข้อมูลต่อหน้า
$url_link="option=budget&task=main/report_12_2&year_index=$year_index&project=$_REQUEST[project]&pay_group=$_REQUEST[pay_group]";  // 2_กำหนดลิงค์ฺ
$totalpages=ceil($num_rows/$pagelen);

if(!isset($_REQUEST['page'])){
$_REQUEST['page']="";
}

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

$sql = "select  * from  budget_deega  where project='$_GET[project]' and pay_group='$_GET[pay_group]' and budget_year='$year_index' order by deega_num  limit $start,$pagelen ";
$dbquery = mysqli_query($connect,$sql);
echo "<br>";
echo  "<table width='95%' border='0' align='center'>";
echo "<Tr><Td colspan='9' align='right'><INPUT TYPE='button' name='smb' value='<<กลับหน้า่ก่อน' onclick='location.href=\"?option=budget&task=main/report_12&year_index=$year_active_result[budget_year]\"'</Td></Tr>";

echo "<Tr bgcolor='#FFCCCC' align='center'><Td width='50'>ที่</Td><Td width='80'>ว/ด/ป</Td><Td width='80'>เลขที่ฎีกา</Td><Td width='100'>เลขที่เอกสาร</Td><Td>รายการ</Td><Td width='100'>ขอเบิก</Td><Td width='100'>ภาษี</Td><Td width='100'>รับจริง</Td><Td width='40'></Td></Tr>";
$N=(($page-1)*$pagelen)+1;  //*เกี่ยวข้องกับการแยกหน้า
$M=1;
While ($result = mysqli_fetch_array($dbquery))
	{
		$id = $result['id'];
		$doc= $result['doc'];
		$deega_num= $result['deega_num'];
		$item= $result['item'];
		$withdraw= $result['withdraw'];
		$withdraw=number_format($withdraw,2);
		$tax= $result['tax'];
		$tax=number_format($tax,2);
		$pay= $result['pay'];
		$pay=number_format($pay,2);
		$rec_date= $result['rec_date'];
list($rec_year,$rec_month,$rec_day) = explode("-",$rec_date);
$t_year=($rec_year+543)-2500;
			if(($M%2) == 0)
			$color="#FFFFC";
			else  	$color="#FFFFFF";

		echo "<Tr bgcolor=$color align='center'><Td>$N</Td><Td>$rec_day $t_month[$rec_month] $t_year</Td><Td>$deega_num</Td><Td align='left'>$doc</Td><Td align=left>$item</Td><Td align='right'>$withdraw</Td><Td align='right'>$tax</Td><Td align='right'>$pay</Td>
		<Td><div align='center'><font size=3><a href=?option=budget&task=main/report_12_3&year_index=$year_active_result[budget_year]&id=$id&page=$page&project=$_GET[project]&pay_group=$_GET[pay_group]><img src=images/browse.png border='0'></a></font></div></Td>
	</Tr>";
$M++;
$N++;  //*เกี่ยวข้องกับการแยกหน้า
}

echo "</Table>";
?>
