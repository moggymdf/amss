<?php
/** ensure this file is being included by a parent file */
defined( '_VALID_' ) or die( 'Direct Access to this location is not allowed.' );

//ส่วนการแสดงผล
if(!($index==3)){
$person_id=$_SESSION['login_user_id'];

$sql = "select * from student_main_main where person_id='$person_id' order by id desc limit 0,1";
$dbquery_student = mysqli_query($connect,$sql);
$result_student = mysqli_fetch_array($dbquery_student);

echo "<table width='50%' border='0' align='center'>";
echo "<tr align='center'><td><font color='#006666' ><strong>รายงานผลการสอบ</strong></font></td></tr>";
echo "<tr align='center'><td><font color='#006666'><strong>$result_student[prename]$result_student[name] $result_student[surname]</strong></font></td></tr>";
echo "</table>";

$sql_page = "select *,bets_sch_test.id from bets_sch_test left join bets_schtest_testuser on bets_sch_test.id=bets_schtest_testuser.sch_test_id where bets_sch_test.school='$_SESSION[user_school]' and bets_schtest_testuser.person_id='$_SESSION[login_user_id]' and bets_schtest_testuser.stop_test='1' ";
$dbquery_page = mysqli_query($connect,$sql_page);
$num_rows=mysqli_num_rows($dbquery_page);

$pagelen=20; // กำหนดแถวต่อหน้า
$url_link="option=bets&task=main/student_report_1_mobile";
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
$sql = "select *,bets_sch_test.id from bets_sch_test left join bets_schtest_testuser on bets_sch_test.id=bets_schtest_testuser.sch_test_id where bets_sch_test.school='$_SESSION[user_school]' and bets_schtest_testuser.person_id='$_SESSION[login_user_id]' and bets_schtest_testuser.stop_test='1' order by bets_sch_test.id limit $start,$pagelen";
$dbquery = mysqli_query($connect,$sql);
echo  "<table width='100%' border='0' align='center'>";
echo "<Tr bgcolor='#FFCCCC' align='center'><Td>ที่</Td><Td>ชื่อการสอบ</Td><Td>คะแนน(%)</Td><Td>ประเมิน</Td></Tr>";
$N=(($page-1)*$pagelen)+1;  //*เกี่ยวข้องกับการแยกหน้า
$M=1;
While ($result = mysqli_fetch_array($dbquery))
	{
		$id = $result['id'];
		$sch_test_name= $result['sch_test_name'];

		if(($M%2) == 0)
		$color="#FFFFC";
		else  	$color="#FFFFFF";

		//หาเกณฑ์การสอบ
		$sql_g = "select * from bets_test where bets_test.id='$result[test_id]'";
		$dbquery_g = mysqli_query($connect,$sql_g);
		$result_g = mysqli_fetch_array($dbquery_g);
		$g1=$result_g['g1'];
		$g2=$result_g['g2'];

		//ประมวลผลการสอบ
		$total_percent="";
		$sql_full_score = "select sum(item_score) as full_score, sum(score) as score from bets_answer where sch_test_id='$id' and person_id='$_SESSION[login_user_id]'";
		$dbquery_full_score = mysqli_query($connect,$sql_full_score);
		$result_full_score = mysqli_fetch_array($dbquery_full_score);
		$full_score=$result_full_score['full_score'];
		$total_right=$result_full_score['score'];
		if($full_score!=0){
		$total_percent=($total_right/$full_score)*100;
		$total_percent=number_format($total_percent,2);
		}

echo "<Tr bgcolor=$color align='center'><Td>$N</Td><Td align='left'>$sch_test_name</Td>";
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
echo "</Tr>";
$M++;
$N++;
	}
echo "</Table>";
echo "</form>";
}
?>
