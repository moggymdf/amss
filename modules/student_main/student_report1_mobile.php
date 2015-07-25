<?php
/** ensure this file is being included by a parent file */
defined( '_VALID_' ) or die( 'Direct Access to this location is not allowed.' );
//sd page

if(!isset($_REQUEST['year_index'])){
$_REQUEST['year_index']="";
}

if(!isset($_POST['year_index'])){
$_POST['year_index']="";
}

if(!isset($_SESSION['user_school'])){
$_SESSION['user_school']="";
}

if(!isset($_REQUEST['school_index'])){
$_REQUEST['school_index']="";
}

if(!isset($_REQUEST['class_index'])){
$_REQUEST['class_index']="";
}

//ปีงบประมาณ
$sql = "select * from  student_main_edyear  where year_active='1' order by  ed_year desc limit 1";
$dbquery = mysqli_query($connect,$sql);
$year_active_result = mysqli_fetch_array($dbquery);
if($year_active_result['ed_year']==""){
echo "<br />";
echo "<div align='center'>ยังไม่ได้กำหนดทำงานในปีการศึกษาใด ๆ  กรุณาไปที่เมนูตั้งค่าระบบ เพื่อกำหนดปีการศึกษา</div>";
exit();
}

if($_REQUEST['year_index']!=""){
$year_active_result['ed_year']=$_REQUEST['year_index'];
}

//อาเรย์ชั้น
$school_class_ar[0]="ไม่ระบุชั้น";
$school_class_ar[1]="อ.1(3ปี)";
$school_class_ar[2]="อ.1";
$school_class_ar[3]="อ.2";
$school_class_ar[4]="ป.1";
$school_class_ar[5]="ป.2";
$school_class_ar[6]="ป.3";
$school_class_ar[7]="ป.4";
$school_class_ar[8]="ป.5";
$school_class_ar[9]="ป.6";
$school_class_ar[10]="ม.1";
$school_class_ar[11]="ม.2";
$school_class_ar[12]="ม.3";
$school_class_ar[13]="ม.4";
$school_class_ar[14]="ม.5";
$school_class_ar[15]="ม.6";

echo "<br />";
echo "<table width='100%' border='0' align='center'>";
echo "<tr align='center'><td><font color='#006666'><strong>รายชื่อนักเรียน ปีการศึกษา  $year_active_result[ed_year]</strong></font></td></tr>";
echo "</table>";

if($index==""){
//ส่วนการแสดงผล
//ส่วนของการแยกหน้า
$pagelen=50;  // 1_กำหนดแถวต่อหน้า
$url_link="option=student_main&task=student_report1_mobile&year_index=$_REQUEST[year_index]&school_index=$_REQUEST[school_index]&class_index=$_REQUEST[class_index]";  // 2_กำหนดลิงค์ฺ
$sql = "select  * from  student_main_main ";

			if(($_REQUEST['school_index']=="") and ($_REQUEST['class_index']=="")){
			$sql .= "where ed_year='$year_active_result[ed_year]'  ";
			}
			else if(($_REQUEST['school_index']!="") and ($_REQUEST['class_index']!="")){
			$sql .= "where  ed_year='$year_active_result[ed_year]' and classlevel='$_REQUEST[class_index]' and  school_code='$_REQUEST[school_index]'  ";
			}
			else if($_REQUEST['school_index']!=""){
			$sql .= "where  ed_year='$year_active_result[ed_year]' and school_code='$_REQUEST[school_index]'  ";
			}
			else if($_REQUEST['class_index']!=""){
			$sql .= "where ed_year='$year_active_result[ed_year]'  and  classlevel='$_REQUEST[class_index]'  ";
			}

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

 		//เลือกชั้น
		echo  "<table width=100% border='0' align='center'>";
		echo "<Tr><td align='right'>";
		echo "<form id='frm1' name='frm1'>";
		echo "<div align='right'>";
		echo "<Select  name='class_index' size='1' onchange='goto_index(1)'>";

				if($_REQUEST['class_index']=='0'){
				$select_class_0="selected";
				}
				else if($_REQUEST['class_index']=='1'){
				$select_class_1="selected";
				}
				else if($_REQUEST['class_index']=='2'){
				$select_class_2="selected";
				}
				else if($_REQUEST['class_index']=='3'){
				$select_class_3="selected";
				}
				else if($_REQUEST['class_index']=='4'){
				$select_class_4="selected";
				}
				else if($_REQUEST['class_index']=='5'){
				$select_class_5="selected";
				}
				else if($_REQUEST['class_index']=='6'){
				$select_class_6="selected";
				}
				else if($_REQUEST['class_index']=='7'){
				$select_class_7="selected";
				}
				else if($_REQUEST['class_index']=='8'){
				$select_class_8="selected";
				}
				else if($_REQUEST['class_index']=='9'){
				$select_class_9="selected";
				}
				else if($_REQUEST['class_index']=='10'){
				$select_class_10="selected";
				}
				else if($_REQUEST['class_index']=='11'){
				$select_class_11="selected";
				}
				else if($_REQUEST['class_index']=='12'){
				$select_class_12="selected";
				}
				else if($_REQUEST['class_index']=='13'){
				$select_class_13="selected";
				}
				else if($_REQUEST['class_index']=='14'){
				$select_class_14="selected";
				}
				else if($_REQUEST['class_index']=='15'){
				$select_class_15="selected";
				}

		echo  "<option  value = ''>ทุกชั้น</option>" ;
		echo  "<option value =0 $select_class_0>ไม่ระบุชั้น</option>";
		echo  "<option value =1 $select_class_1>อ.1(3ปี)</option>";
		echo  "<option value =2 $select_class_2>อ.1</option>";
		echo  "<option value =3 $select_class_3>อ.2</option>";
		echo  "<option value =4 $select_class_4>ป.1</option>";
		echo  "<option value =5 $select_class_5>ป.2</option>";
		echo  "<option value =6 $select_class_6>ป.3</option>";
		echo  "<option value =7 $select_class_7>ป.4</option>";
		echo  "<option value =8 $select_class_8>ป.5</option>";
		echo  "<option value =9 $select_class_9>ป.6</option>";
		echo  "<option value =10 $select_class_10>ม.1</option>";
		echo  "<option value =11 $select_class_11>ม.2</option>";
		echo  "<option value =12 $select_class_12>ม.3</option>";
		echo  "<option value =13 $select_class_13>ม.4</option>";
		echo  "<option value =14 $select_class_14>ม.5</option>";
		echo  "<option value =15 $select_class_15>ม.6</option>";
		echo "</select>";
		echo "</td></tr><td align='right'>";
	//เลือก	โรงเรียน
			echo "<Select  name='school_index' size='1' onchange='goto_index(1)'>";
			echo  "<option  value = ''>ทุกโรงเรียน</option>" ;
		$sql = "select * from  system_school  order by school_type,school_name";
		$dbquery = mysqli_query($connect,$sql);
		While ($result = mysqli_fetch_array($dbquery))
		   {
		   			if($result['school_code']==$_REQUEST['school_index']){
					echo  "<option value = $result[school_code] selected>$result[school_name]</option>";
					}
					else{
					echo  "<option value = $result[school_code]>$result[school_name]</option>";
					}
			}
		echo "</select>";
		echo "</td></tr><td align='right'>";
//เลือกปีการศึกษา
		echo "<Select  name='year_index' size='1' onchange='goto_index(1)'>";
		$sql = "select * from  student_main_edyear  order by ed_year";
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
		echo "</div>";
		echo "</form>";
		echo "</td></Tr></Table>";
		//จบ

$sql = "select  * from  student_main_main ";
$sql_count= "select  count(id) as student from student_main_main ";
$sql_gender= "select  count(sex) as gender from student_main_main ";

			if(($_REQUEST['school_index']=="") and ($_REQUEST['class_index']=="")){
			$sql .= "where ed_year='$year_active_result[ed_year]'  ";
			$sql2= "where ed_year='$year_active_result[ed_year]'  ";
			}
			else if(($_REQUEST['school_index']!="") and ($_REQUEST['class_index']!="")){
			$sql .= "where  ed_year='$year_active_result[ed_year]' and classlevel='$_REQUEST[class_index]' and  school_code='$_REQUEST[school_index]'  ";
			$sql2= "where  ed_year='$year_active_result[ed_year]' and classlevel='$_REQUEST[class_index]' and  school_code='$_REQUEST[school_index]'  ";
			}
			else if($_REQUEST['school_index']!=""){
			$sql .= "where  ed_year='$year_active_result[ed_year]' and school_code='$_REQUEST[school_index]'  ";
			$sql2= "where  ed_year='$year_active_result[ed_year]' and school_code='$_REQUEST[school_index]'  ";
			}
			else if($_REQUEST['class_index']!=""){
			$sql .= "where ed_year='$year_active_result[ed_year]'  and  classlevel='$_REQUEST[class_index]'  ";
			$sql2= "where ed_year='$year_active_result[ed_year]'  and  classlevel='$_REQUEST[class_index]'  ";
			}
$sql3=" and  sex like 'ช'  ";


$sql_count=$sql_count.$sql2;
$sql_gender=$sql_gender.$sql2.$sql3;

$sql .= " order by classlevel ,classroom, student_id limit $start,$pagelen";
$dbquery = mysqli_query($connect,$sql);
////ส่วนการนับ
$dbquery_count = mysqli_query($connect,$sql_count);
$result_count = mysqli_fetch_array($dbquery_count);
$dbquery_gender = mysqli_query($connect,$sql_gender);
$result_gender = mysqli_fetch_array($dbquery_gender);
////


echo  "<table width=100% border='0' align='center'>";
echo "<Tr bgcolor=#FFCCCC align='center' ><Td>ที่</Td><Td align='center'>ชื่อ</Td><Td>ชั้น</Td><Td>ห้อง</Td><Td>โรงเรียน</Td></Tr>";
$N=(($page-1)*$pagelen)+1;  //*เกี่ยวข้องกับการแยกหน้า
$M=1;
While ($result = mysqli_fetch_array($dbquery))
	{

			if(($M%2) == 0)
			$color="#FFFFC";
			else  	$color="#FFFFFF";
			$id=$result['id'];
			$classlevel=$result['classlevel'];
			$school_code=$result['school_code'];
echo "<Tr  bgcolor=$color align='center'><Td>$N</Td>";
echo "<Td align='left'>$result[prename]$result[name]&nbsp;&nbsp;&nbsp;$result[surname]</Td>";
echo "<Td align='center'>$school_class_ar[$classlevel]</Td>";
echo "<Td align='center'>$result[classroom]</Td>";
echo "<Td align='left'>$result[school_name]</Td>";
echo "</Tr>";
$M++;
$N++;  //*เกี่ยวข้องกับการแยกหน้า
	}

$total_f_gender=$result_count['student']-$result_gender['gender'];
$total_f_gender =number_format($total_f_gender,0);
$student = $result_count['student'];
$student=number_format($student,0);
$m_gender=$result_gender['gender'];
$m_gender=number_format($m_gender,0);
echo "<Tr bgcolor=#FFCCCC align='center'><Td align='center' colspan='2'>รวมทั้งหมด $student คน</Td><Td colspan='3'>ชาย $m_gender หญิง ";
echo $total_f_gender ;
echo "</Td></Tr>";
echo "</Table>";
}

?>
<script>

function goto_index(val){
	if(val==1){
		callfrm("?option=student_main&task=student_report1_mobile");   // page ย้อนกลับ
		}
}

</script>
