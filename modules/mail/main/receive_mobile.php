<?php
/** ensure this file is being included by a parent file */
defined( '_VALID_' ) or die( 'Direct Access to this location is not allowed.' );

if(isset($_REQUEST['switch_index'])){
	$switch_index=$_REQUEST['switch_index'];
}else{
	$switch_index="";
}

if(!($_SESSION['login_status']<=500)){
exit();
}
require_once "modules/mail/time_inc.php";
$user=$_SESSION['login_user_id'];

//ส่วนหัว
if(!($index==4)){

echo "<table width='100%' border='0' align='center'>";
echo "<tr align='center'><td><font color='#006666'><strong>ทะเบียนรับจดหมาย</strong></font></td></tr>";
echo "</table>";
}

//ส่วนแสดงผล
if(!($index==4)){
			if(isset($_REQUEST['return_index'])==8){
			$index=8;
			}
//ส่วนของการแยกหน้า
$sql="select mail_main.ms_id from mail_main left join mail_sendto_answer on mail_main.ref_id=mail_sendto_answer.ref_id where mail_sendto_answer.send_to='$user' ";
$dbquery = mysqli_query($connect,$sql);
$num_rows = mysqli_num_rows($dbquery );

$pagelen=20;  // 1_กำหนดแถวต่อหน้า
$url_link="option=mail&task=main/receive_mobile";  // 2_กำหนดลิงค์
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
echo "</div>";  }
//จบแยกหน้า


//////////////////////////////////////////

$sql="select * from mail_main left join mail_sendto_answer on mail_main.ref_id=mail_sendto_answer.ref_id where mail_sendto_answer.send_to='$user' order by mail_main.ms_id limit $start,$pagelen";
$dbquery = mysqli_query($connect,$sql);
echo  "<table width='100%' border='1' align='center' style='border-collapse: collapse'>";

echo "<Tr bgcolor='#99ccff' align='center'><Td>ที่</Td><Td>จดหมายจาก</Td><Td>วันที่ส่ง</Td><Td>เรื่อง</Td><Td>รับ</Td><Td>วันที่รับ</Td></Tr>";

$N=(($page-1)*$pagelen)+1; //*เกี่ยวข้องกับการแยกหน้า
$M=1;
While ($result = mysqli_fetch_array($dbquery)){
$sch_person_index=0;
		$id = $result['ms_id'];
		$subject = $result['subject'];
		$sender = $result['sender'];
		$ref_id = $result['ref_id'];
		$rec_date = $result['send_date'];
		$answer_time=$result['answer_time'];
			if(($M%2) == 0)
			$color="#E5E5FF";
			else  	$color="FFFFFF";

		$query_person=mysqli_query($connect,"SELECT * FROM  person_main WHERE person_id='$sender' ") ;
		$result_person=mysqli_fetch_array($query_person);
		$prename=$result_person['prename'];
		$name= $result_person['name'];
		$surname = $result_person['surname'];
		$full_name="$prename$name&nbsp;&nbsp;$surname";

echo "<Tr bgcolor='$color'><Td align='center'>$id</Td><Td align='left'>$full_name</Td><Td align='left'>";
echo thai_date_4($rec_date);
echo "</Td><Td align='left'>";
?>
<A HREF="javascript:void(0)"
onclick="window.open('modules/mail/main/maildetail.php?id=<?php echo $id;?>', 'bookdetail','width=700,height=500,scrollbars')" title="คลิกเพื่อดูรายละเอียด"><span style="text-decoration: none"><?php echo $subject; ?></span></A>
<?php
if(($sch_person_index==1) and ($_SESSION['login_status']<=4)){
echo " [$result_sch[school_name]]";
}
echo "</Td>";
			if($result['answer']==1){
			echo "<td align='center'><img src=images/yes.png border='0' alt='รับแล้ว'></td>";
			}
			else{
			echo "<td align='center'><img src=images/no.png border='0' alt='ยังไม่ได้รับ'></td>";
			}

echo "<td align='left'>";
if($answer_time>0){
echo thai_date_4($answer_time);
}
echo "</td>";
echo "</Tr>";

$M++;
$N++;  //*เกี่ยวข้องกับการแยกหน้า
}
echo "</Table>";
}

?>
