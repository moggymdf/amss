<?php
/** ensure this file is being included by a parent file */
defined( '_VALID_' ) or die( 'Direct Access to this location is not allowed.' );

if(!isset($_REQUEST['year_index'])){
$_REQUEST['year_index']="";
}
if(!isset($_REQUEST['name_search'])){
$_REQUEST['name_search']="";
}


//ปีงบประมาณ
$sql = "select * from  student_main_edyear  where year_active='1' order by  ed_year desc limit 1";
$dbquery = mysqli_query($connect,$sql);
$year_active_result = mysqli_fetch_array($dbquery);

if($_REQUEST['year_index']!=""){
$year_active_result['ed_year']=$_REQUEST['year_index'];
}

//อาเรย์ชั้น
$school_class_ar['0']="ไม่ระบุชั้น";
$school_class_ar['1']="อ.1(3ปี)";
$school_class_ar['2']="อ.1";
$school_class_ar['3']="อ.2";
$school_class_ar['4']="ป.1";
$school_class_ar['5']="ป.2";
$school_class_ar['6']="ป.3";
$school_class_ar['7']="ป.4";
$school_class_ar['8']="ป.5";
$school_class_ar['9']="ป.6";
$school_class_ar['10']="ม.1";
$school_class_ar['11']="ม.2";
$school_class_ar['12']="ม.3";
$school_class_ar['13']="ม.4";
$school_class_ar['14']="ม.5";
$school_class_ar['15']="ม.6";

echo "<br />";
echo "<table width='50%' border='0' align='center'>";
echo "<tr align='center'><td><font color='#006666' size='3'><strong>ค้นหานักเรียน</strong></font></td></tr>";
echo "</table>";

		echo  "<table width=90% border='0' align='center'>";
		echo "<Tr><td>";
		echo "<form id='frm1' name='frm1'>";
		echo "<div align='center'>";
//เลือกปีการศึกษา
		echo "<Select  name='year_index' size='1'>";
		$sql = "select * from  student_main_edyear  order by ed_year desc";
		$dbquery = mysqli_query($connect,$sql);
		While ($result = mysqli_fetch_array($dbquery))
		   {
		   			if(($result['year_active']==1) and ($_REQUEST['year_index']=="")){
					echo  "<option value = $result[ed_year] selected>ปีการศึกษา $result[ed_year]</option>";
					}
					else if($result['ed_year']==$_REQUEST['year_index']){
					echo  "<option value = $result[ed_year] selected>ปีการศึกษา $result[ed_year]</option>";
					}
					else{
					echo  "<option value = $result[ed_year]>ปีการศึกษา $result[ed_year]</option>";
					}
			}
		echo "</select>";

		if($_REQUEST['name_search']!=""){
		echo "&nbsp;ค้นหาด้วยชื่อหรือนามสกุล&nbsp;<Input Type='Text' Name='name_search' value='$_REQUEST[name_search]' >";
		}
		else{
		echo "&nbsp;ค้นหาด้วยชื่อหรือนามสกุล&nbsp;<Input Type='Text' Name='name_search' Size='30'>";
		}

		echo "&nbsp;<INPUT TYPE='button' name='smb' value='เลือก' onclick='goto_index(1)' class=entrybutton>";
		echo "</div>";
		echo "</form>";
		echo "</td></Tr></Table>";
		//จบ

if($_REQUEST['name_search']!=""){
//ส่วนการแสดงผล
//ส่วนของการแยกหน้า
$pagelen=20;  // 1_กำหนดแถวต่อหน้า
$url_link="option=student_main&task=student_report3&year_index=$_REQUEST[year_index]&name_search=$_REQUEST[name_search]";  // 2_กำหนดลิงค์ฺ
$sql = "select id from student_main_main where  (name like '%$_REQUEST[name_search]%' or surname like '%$_REQUEST[name_search]%' ) and ed_year='$year_active_result[ed_year]' ";
$dbquery = mysqli_query($connect,$sql);
$num_rows=mysqli_num_rows($dbquery);
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

$sql = "select * from student_main_main  where  (name like '%$_REQUEST[name_search]%' or surname like '%$_REQUEST[name_search]%')  and  ed_year='$year_active_result[ed_year]' order by name,surname,classlevel limit $start,$pagelen";
$dbquery = mysqli_query($connect,$sql);

echo  "<table width='80%' border='0' align='center'>";
if ($num_rows>0){
echo "<Tr bgcolor=#FFCCCC align='center' ><Td width='50'>ที่</Td><Td width='90'>เลขประจำตัว<br>นักเรียน</Td><Td width='120'>เลขประจำตัว<br>ประชาชน</Td><Td align='center'>ชื่อ</Td><Td width='70'>เพศ</Td><Td width='70'>ชั้น</Td><Td width='50'>ห้อง</Td><Td width='230'>โรงเรียน</Td></Tr>";
}
else{
echo "<Tr bgcolor=#FFCCCC align='center' ><Td colspan='8'>ไม่พบข้อมูล</Td></Tr>";
}
$N=(($page-1)*$pagelen)+1;  //*เกี่ยวข้องกับการแยกหน้า
$M=1;
While ($result = mysqli_fetch_array($dbquery))
	{
		$id = $result['id'];
		$school_id = $result['school_code'];
		$person_id = $result['person_id'];
		$student_id = $result['student_id'];
		$prename=$result['prename'];
		$name= $result['name'];
		$surname = $result['surname'];
		$sex = $result['sex'];
		$school_class = $result['classlevel'];
		$room=$result['classroom'];

			if(($M%2) == 0)
			$color="#FFFFC";
			else  	$color="#FFFFFF";

echo "<Tr  bgcolor=$color align='center'><Td>$N</Td><Td align='left'>$student_id</Td><Td align='left'>$person_id</Td>";
echo "<Td align='left'>$prename&nbsp;$name&nbsp;&nbsp;$surname</Td><Td align='center'>$sex</Td>";
echo "<Td align='center'>$school_class_ar[$school_class]</Td>";
echo "<Td align='center'>$room</Td>";
echo "<Td align='left'>";
echo $result['school_name'];
echo "</Td>";
echo "</Tr>";
$M++;
$N++;  //*เกี่ยวข้องกับการแยกหน้า
	}
echo "</Table>";
}

?>
<script>

function goto_index(val){
	if(val==1){
		callfrm("?option=student_main&task=student_report3");   // page ย้อนกลับ
		}
}

</script>
