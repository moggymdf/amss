<?php
/** ensure this file is being included by a parent file */
defined( '_VALID_' ) or die( 'Direct Access to this location is not allowed.' );

require_once "modules/news/time_inc.php";

//กรณีเลือกประเภท
if(isset($_REQUEST['section_index'])){
$section_index=$_REQUEST['section_index'];
}
else{
$section_index="";
}

$sql = "select * from  news_mainitem where item_active='1' order by code desc limit 1";
$dbquery = mysqli_query($connect,$sql);
$item_active_result = mysqli_fetch_array($dbquery);
if($item_active_result['code']==""){
echo "<br />";
echo "<div align='center'>ยังไม่ได้กำหนดชื่อเรื่อง</div>";
exit();
}

//อาเรย์ประเภท
$sql = "select * from news_section where mainitem_code='$item_active_result[code]' order by code";
$dbquery = mysqli_query($connect,$sql);
While ($result = mysqli_fetch_array($dbquery)) {
	$code= $result['code'];
	$section_ar[$code]=$result['name'];
}

echo "<br />";
echo "<table width='90%' border='0' align='center'>";
echo "<tr align='center'><td><font color='#006666' size='3'><strong>$item_active_result[mainitem]</strong></font></td></tr>";
echo "</table>";

//ส่วนของการแยกหน้า
$pagelen=20;  // 1_กำหนดแถวต่อหน้า
$url_link="option=news&task=main/report1";  // 2_กำหนดลิงค์ฺ
		if($section_index!=""){
		$sql = "select * from news_news where (mainitem_code='$item_active_result[code]') and (section='$section_index')"; // 3_กำหนด sql
		}
		else{
		$sql = "select * from news_news where mainitem_code='$item_active_result[code]'"; // 3_กำหนด sql
		}

$dbquery = mysqli_query($connect,$sql);
$num_rows = mysqli_num_rows($dbquery );
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
					echo "<a href=$PHP_SELF?$url_link&page=$i&section_index=$section_index>[$i]</a>";
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
			echo "<<<a href=$PHP_SELF?$url_link&page=$f_page1&section_index=$section_index>หน้าก่อน </a>";
			}
			else {
			echo "หน้า	";
			}
			for($i=$s_page; $i<=$e_page; $i++){
					if($i==$page){
					echo "[<b><font size=+1 color=#990000>$i</font></b>]";
					}
					else {
					echo "<a href=$PHP_SELF?$url_link&page=$i&section_index=$section_index>[$i]</a>";
					}
			}
			if($page<$totalpages)	{
			$f_page2=$page+1;
			echo "<a href=$PHP_SELF?$url_link&page=$f_page2&section_index=$section_index> หน้าถัดไป</a>>>";
			echo "<a href=$PHP_SELF?$url_link&page=$totalpages&section_index=$section_index> หน้าสุดท้าย</a>>";
			}
			echo " <select onchange=\"location.href=this.options[this.selectedIndex].value;\" size=\"1\" name=\"select\">";
			echo "<option  value=\"\">หน้า</option>";
				for($p=1;$p<=$totalpages;$p++){
				echo "<option  value=\"?$url_link&page=$p&section_index=$section_index\">$p</option>";
				}
			echo "</select>";
echo "</div>";
}
//จบแยกหน้า

//////////////////	เลือกประเภท
echo "<form  name='frm1'>";
	echo "<table width='90%' align='center'><tr><td align='right'>";
	echo "ประเภท&nbsp";
	echo "<Select  name='section_index' size='1'>";
	echo  '<option value ="" >ทั้งหมด</option>' ;
	$sql_section = "select * from  news_section where mainitem_code='$item_active_result[code]' order by code";
	$dbquery_section = mysqli_query($connect,$sql_section);
	While ($result_section = mysqli_fetch_array($dbquery_section)){
			 if($section_index==""){
					echo "<option value=$result_section[code]>$result_section[name]</option>";
			 }
			 else{
					if($section_index==$result_section['code']){
					echo "<option value=$result_section[code]  selected>$result_section[name]</option>";
					}
					else{
					echo "<option value=$result_section[code]>$result_section[name]</option>";
					}
			}
	}
echo "</select>";
echo "&nbsp;<INPUT TYPE='button' name='smb' value='เลือก' onclick='goto_url(1)' class=entrybutton>";
echo "</td></tr></table>";
echo "</form>";
/////////////////////
if($section_index!=""){
$sql = "select * from news_news where (mainitem_code='$item_active_result[code]') and (section='$section_index') order by id  limit $start,$pagelen";
}
else{
$sql = "select * from news_news where mainitem_code='$item_active_result[code]' order by id  limit $start,$pagelen";
}
$dbquery = mysqli_query($connect,$sql);
echo  "<table width=90% border=0 align=center>";
echo "<Tr bgcolor=#FFCCCC align='center'><Td width='50'>ที่</Td><Td width='150'>วดป</Td><Td width='250'>ประเภท</Td><Td>ข้อความ</Td><Td width='50'>File</Td><Td width='160'>ผู้รายงาน</Td></Tr>";
$N=(($page-1)*$pagelen)+1;  //*เกี่ยวข้องกับการแยกหน้า
$M=1;
While ($result = mysqli_fetch_array($dbquery))
	{
		$id = $result['id'];
		$report_date=$result['report_date'];
		$report_date=thai_date_4($report_date);
		$section= $result['section'];
		$news = $result['news'];
		$file = $result['file'];
			if(($M%2) == 0)
			$color="#FFFFC";
			else  	$color="#FFFFFF";

				$sql2 = "select * from person_main where person_id='$result[officer]' ";
				$dbquery2 = mysqli_query($connect,$sql2);
				$result2 = mysqli_fetch_array($dbquery2);
				if(!$result2){
				$sql2= "select * from person_sch_main where person_id='$result[officer]' ";
				$dbquery2 = mysqli_query($connect,$sql2);
				$result2 = mysqli_fetch_array($dbquery2);
				}

		echo "<Tr bgcolor='$color' align='center'><Td valign='top'>$N</Td><td valign='top'>$report_date</td><Td align='left' valign='top'>$section_ar[$section]</Td><Td align='left' valign='top'>$news</Td>";
if($file!=""){
echo   "<Td valign='top'><a href='$file' target=_blank><IMG SRC='images/b_browse.png' width='16' height='16' border=0 alt='เอกสาร'></a></td>";
}
else{
echo "<Td align='left' valign='top'></Td>";
}
echo "<Td align='left' valign='top'>$result2[prename]$result2[name]&nbsp;$result2[surname]</Td>";
echo "</Tr>";
$M++;
$N++;  //*เกี่ยวข้องกับการแยกหน้า
	}
echo "</Table>";


?>
<script>
function goto_url(val){
callfrm("?option=news&task=main/report1");
}
</script>
