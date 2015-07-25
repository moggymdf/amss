<?php
/** ensure this file is being included by a parent file */
defined( '_VALID_' ) or die( 'Direct Access to this location is not allowed.' );

//ส่วนแสดงภาพรวมสถานศึกษา
if($index==2) {
$sql = "select * from bets_test left join bets_group on bets_test.s_group=bets_group.group_code where bets_test.id='$_GET[test_id]'";
$dbquery = mysqli_query($connect,$sql);
$result = mysqli_fetch_array($dbquery);
$g1=$result['g1'];
$g2=$result['g2'];

echo "<table width='100%' border='0' align='center'>";
echo "<tr align='center'><td><font color='#006666'><strong>$result[test_name]</strong></font></td></tr>";
echo "</table>";

		echo  "<table width='100%' border='0' align='center'>";
		echo "<Tr align='center'><Td colspan='4' align='left'></Td><td colspan='4' align='right'>[<a href=?option=bets&task=main/khet_report_1_mobile&page=$_GET[page]><<กลับ</a>]</td></Tr>";
		echo "<Tr bgcolor='#FFCCCC' align='center'><Td>ที่</Td><Td>รหัสสถานศึกษา</Td><Td>ชื่อสถานศึกษา</Td><Td>คะแนน(%)</Td><Td>ประเมิน</Td>";
		echo "</Tr>";
		$sql = "select * from bets_test_schuser left join system_school on bets_test_schuser.school=system_school.school_code where bets_test_schuser.test_id='$_GET[test_id]' order by system_school.school_type,system_school.school_code";
		$dbquery = mysqli_query($connect,$sql);
		$N=1;
		While ($result=mysqli_fetch_array($dbquery)){
					if(($N%2) == 0)
					$color="#FFFFC";
					else  	$color="#FFFFFF";

		//ประมวลผลการสอบ
		$total_percent="";
		$sql_full_score = "select sum(item_score) as full_score, sum(score) as score from bets_answer where test_id='$_GET[test_id]' and school='$result[school_code]' ";
		$dbquery_full_score = mysqli_query($connect,$sql_full_score);
		$result_full_score = mysqli_fetch_array($dbquery_full_score);
		$full_score=$result_full_score['full_score'];
		$total_right=$result_full_score['score'];
		if($full_score!=0){
		$total_percent=($total_right/$full_score)*100;
		$total_percent=number_format($total_percent,2);
		}
		//
		echo "<Tr bgcolor='$color' align='center'><Td>$N</Td><Td>$result[school_code]</Td><Td align='left'>$result[school_name]</Td>";
		echo "<td align='center'>$total_percent ";
		if($total_percent!=""){
		}
		echo "</td><td>";
		if($total_percent<=$g2){
		$bgcolor="#FF0000";
		}
		else if($total_percent>$g2 and $total_percent<$g1){
		$bgcolor="#FFFF00";
		}
		else if($total_percent>=$g1){
		$bgcolor="#66FF00";
		}
		else{
		$bgcolor="#FFFFFF";
		}
		if($total_percent!=""){
		 echo "<table  border='0' cellspacing='0' cellpadding='0' width='13' height='13'>";
		echo "<tr><td bgcolor='$bgcolor'></td></tr>";
		 echo "</table>";
		 }
		echo "</td>";
		echo "</Tr>";
		$N++;
		}
		echo "</table>";
}

//ส่วนการแสดงผล
if(!($index==1 or $index==2 or $index==3)){
echo "<table width='100%' border='0' align='center'>";
echo "<tr align='center'><td><font color='#006666'><strong>รายงานผลการสอบ</strong></font></td></tr>";
echo "</table>";
$sql_page = "select * from bets_test order by bets_test.id";
$dbquery_page = mysqli_query($connect,$sql_page);
$num_rows=mysqli_num_rows($dbquery_page);

$pagelen=10; // กำหนดแถวต่อหน้า
$url_link="option=bets&task=main/khet_report_1_mobile";
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

if(($totalpages>1) and ($totalpages<6)){
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
if($totalpages>5){
			if($page <=3){
			$e_page=5;
			$s_page=1;
			}
			if($page>3){
					if($totalpages-$page>=2){
					$e_page=$page+2;
					$s_page=$page-2;
					}
					else{
					$e_page=$totalpages;
					$s_page=$totalpages-5;
					}
			}
			echo "<div align=center>";
			if($page!=1){
			$f_page1=$page-1;
			echo "<<a href=$PHP_SELF?$url_link&page=1>แรก </a>";
			echo "<<<a href=$PHP_SELF?$url_link&page=$f_page1>ก่อน </a>";
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
			echo "<a href=$PHP_SELF?$url_link&page=$f_page2> ถัด</a>>>";
			echo "<a href=$PHP_SELF?$url_link&page=$totalpages> ท้าย</a>>";
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

echo "<form id='frm1' name='frm1'>";
$sql = "select * from bets_test order by bets_test.id limit $start,$pagelen";
$dbquery = mysqli_query($connect,$sql);
echo  "<table width='100%' border='0' align='center'>";
echo "<Tr bgcolor='#FFCCCC' align='center'><Td>ที่</Td><Td>ชื่อการสอบ</Td><Td>ชั้น</Td><Td>คะแนน(%)</Td><Td>ประเมิน</Td><Td>สถานศึกษา</Td></Tr>";
$N=(($page-1)*$pagelen)+1;  //*เกี่ยวข้องกับการแยกหน้า
$M=1;
While ($result = mysqli_fetch_array($dbquery))
	{
		$id = $result['id'];
		$test_name= $result['test_name'];

		if(($M%2) == 0)
		$color="#FFFFC";
		else  	$color="#FFFFFF";

		$class_text="";
		if($result['class_room']==4){
		$class_text="ป.1";
		}
		else if($result['class_room']==5){
		$class_text="ป.2";
		}
		else if($result['class_room']==6){
		$class_text="ป.3";
		}
		else if($result['class_room']==7){
		$class_text="ป.4";
		}
		else if($result['class_room']==8){
		$class_text="ป.5";
		}
		else if($result['class_room']==9){
		$class_text="ป.6";
		}
		else if($result['class_room']==10){
		$class_text="ม.1";
		}
		else if($result['class_room']==11){
		$class_text="ม.2";
		}
		else if($result['class_room']==12){
		$class_text="ม.3";
		}
		else if($result['class_room']==13){
		$class_text="ม.4";
		}
		else if($result['class_room']==14){
		$class_text="ม.5";
		}
		else if($result['class_room']==15){
		$class_text="ม.6";
		}

echo "<Tr bgcolor=$color align='center'><Td>$N</Td><Td align='left'>$test_name <font color='#006666'>[รหัส$id]</font></Td><td>$class_text</td>";

		//หาเกณฑ์การสอบ
		$g1=$result['g1'];
		$g2=$result['g2'];

		//ประมวลผลการสอบ
		$total_percent="";
		$sql_full_score = "select sum(item_score) as full_score, sum(score) as score from bets_answer where test_id='$id' ";
		$dbquery_full_score = mysqli_query($connect,$sql_full_score);
		$result_full_score = mysqli_fetch_array($dbquery_full_score);
		$full_score=$result_full_score['full_score'];
		$total_right=$result_full_score['score'];
		if($full_score!=0){
		$total_percent=($total_right/$full_score)*100;
		$total_percent=number_format($total_percent,2);
		}

		echo "<td>$total_percent</td><td>";
		if($total_percent<=$g2){
		$bgcolor="#FF0000";
		}
		else if($total_percent>$g2 and $total_percent<$g1){
		$bgcolor="#FFFF00";
		}
		else if($total_percent>=$g1){
		$bgcolor="#66FF00";
		}
		else{
		$bgcolor="#FFFFFF";
		}
		if($total_percent!=""){
		 echo "<table  border='0' cellspacing='0' cellpadding='0' width='13' height='13'>";
		echo "<tr><td bgcolor='$bgcolor'></td></tr>";
		 echo "</table>";
		 }
		echo "</td>";

echo "<td><a href=?option=bets&task=main/khet_report_1_mobile&test_id=$result[id]&index=2&page=$page><img src=images/b_home.png border='0'></a></td>";
echo "</Tr>";
$M++;
$N++;
	}
echo "</Table>";
echo "</form>";
}
?>
