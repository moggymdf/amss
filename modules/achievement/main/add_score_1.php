<?php
/** ensure this file is being included by a parent file */
defined( '_VALID_' ) or die( 'Direct Access to this location is not allowed.' );

if(!($result_permission['p1']==1)) {
exit();
}

if(!isset($_REQUEST['ed_year'])){
$_REQUEST['ed_year']="";
}

if(!isset($_REQUEST['edit_code'])){
$_REQUEST['edit_code']="";
}

$officer=$_SESSION['login_user_id'];
$class_ar[6]="ชั้นประถมศึกษาปีที่ 6";
$class_ar[9]="ชั้นมัธยมศึกษาปีที่ 3";
$class_ar[12]="ชั้นมัธยมศึกษาปีที่ 6";

echo "<br>";
//ส่วนฟอร์มกำหนดปีการศึกษา

if($_REQUEST['ed_year']==""){
echo "<br />";
echo "<form id='frm1' name='frm1'>";
echo "<Center>";
echo "<Font color='#006666' Size=3><B>กำหนดปีการศึกษา และชั้นสอบ O-NET</Font>";
echo "</Cener>";
echo "<Br><Br>";
echo "<Table width='300' Border='0' Bgcolor='#Fcf9d8'>";
echo "<Tr><Td align='right'>ปีการศึกษา&nbsp;&nbsp;&nbsp;&nbsp;</Td><Td align='left'><Input Type='Text' Name='ed_year'  id='ed_year' Size='4' maxlength='4' onkeydown='integerOnly()'></Td></Tr>";
echo "<Tr><Td align='right'>ชั้น&nbsp;&nbsp;&nbsp;&nbsp;</Td>";
echo "<td><div align='left'><Select  name='test_class'  id='test_class' size='1'>";
echo  "<option  value = ''>เลือก</option>" ;
echo  "<option value = '6'>ประถมศึกษาปีที่ 6</option>";
echo  "<option value = '9'>มัธยมศึกษาปีที่ 3</option>";
echo  "<option value = '12'>มัธยมศึกษาปีที่ 6</option>";
echo "</select>";
echo "</div></td></tr>";

echo "<tr><td>&nbsp;</td><td>&nbsp;</td></tr>";
echo "<tr><td align='center' colspan='2'><INPUT TYPE='button' name='smb' value='ตกลง' onclick='goto_url2(1)'  ></td></tr>";
echo "</Table>";
echo "</form>";
}

//ส่วนบันทึกข้อมูล
if($index==4){
$rec_date=date("Y-m-d");
		$sql = "select * from system_school  order by school_type,school_code";
		$dbquery = mysqli_query($connect,$sql);
		While ($result = mysqli_fetch_array($dbquery)){
		$school_code=$result['school_code'];

		if(isset($_POST[$school_code][1])){
		$thai=$_POST[$school_code][1];
		}
		else{
		$thai="";
		}

		if(isset($_POST[$school_code][2])){
		$math=$_POST[$school_code][2];
		}
		else{
		$math="";
		}

		if(isset($_POST[$school_code][3])){
		$science=$_POST[$school_code][3];
		}
		else{
		$science="";
		}

		if(isset($_POST[$school_code][4])){
		$social=$_POST[$school_code][4];
		}
		else{
		$social="";
		}

		if(isset($_POST[$school_code][5])){
		$english=$_POST[$school_code][5];
		}
		else{
		$english="";
		}

		if(isset($_POST[$school_code][6])){
		$health=$_POST[$school_code][6];
		}
		else{
		$health="";
		}

		if(isset($_POST[$school_code][7])){
		$art=$_POST[$school_code][7];
		}
		else{
		$art="";
		}

		if(isset($_POST[$school_code][8])){
		$vocation=$_POST[$school_code][8];
		}
		else{
		$vocation="";
		}

		if(isset($_POST[$school_code][9])){
		$score_avg=$_POST[$school_code][9];
		}
		else{
		$score_avg="";
		}

		if(!isset($_POST[$school_code][10])){
		$_POST[$school_code][10]="";
		}
						if($_POST[$school_code][10]==0){
						$sql_select = "select * from  achievement_main  where  test_type='1' and test_class='$_REQUEST[test_class]' and ed_year='$_REQUEST[ed_year]' and school='$school_code' ";
						$dbquery_select = mysqli_query($connect,$sql_select);
						$data_num=mysqli_num_rows($dbquery_select);
									if($data_num>0){
									$sql_update = "update  achievement_main set thai='$thai',
									math='$math',
									science='$science',
									social='$social',
									english='$english',
									health='$health',
									art='$art',
									vocation='$vocation',
									score_avg='$score_avg',
									officer='$officer',
									rec_date='$rec_date'
									where  test_type='1' and test_class='$_REQUEST[test_class]' and ed_year='$_REQUEST[ed_year]' and school='$school_code' ";
									$dbquery_update = mysqli_query($connect,$sql_update);
									}
									else {
									$sql_insert = "insert into achievement_main (test_type, test_class, ed_year, school, thai, math, science, social, english, health, art,vocation, score_avg, officer, rec_date) values ('1', '$_REQUEST[test_class]', '$_REQUEST[ed_year]', '$school_code', '$thai', '$math', '$science', '$social', '$english', '$health', '$art', '$vocation', '$score_avg', '$officer', '$rec_date')";
												if($score_avg>0){
												$dbquery_insert = mysqli_query($connect,$sql_insert);
												}
									}
						}
		}
}
//ส่วนแสดงหลัก
if($index==1 or $index==4 or $index==5 ){
$test_class=$_REQUEST['test_class'];
echo "<br />";
echo "<table width='99%' border='0' align='center'>";
echo "<tr align='center'>
	<td align=center><font color='#990000' size='3'><strong>บันทึกคะแนน O-NET $class_ar[$test_class]  ปีการศึกษา $_REQUEST[ed_year] </strong></font>
<font color='#006666' size='3'><strong></strong></font>
</td></tr>";
echo "</table>";
echo "<br />";

echo "<form id='frm1' name='frm1'>";
$sql = "select * from system_school  order by school_type,school_code";
$dbquery = mysqli_query($connect,$sql);
echo  "<table width='98%' border='0' align='center'>";
echo "<Tr bgcolor='#FFCCCC' align='center'><Td width='50'>ที่</Td>";
echo "<Td>โรงเรียน</Td><Td>ภาษาไทย</Td><Td>คณิต</Td><Td>วิทย์</Td><Td>สังคม</Td><Td>อังกฤษ</Td><Td>สุขศึกษา</Td><Td>ศิลปะ</Td><Td>การงาน</Td><Td>เฉลี่ย</Td><Td></Td></Tr>";
$N=1;
$M=1;
While ($result = mysqli_fetch_array($dbquery))
	{
			if(($M%2) == 0){
			$color="#FFFFC";
			}
			else {
			$color="#FFFFFF";
			}

						$sql_select = "select * from  achievement_main  where school='$result[school_code]' and ed_year='$_REQUEST[ed_year]' and test_class='$_REQUEST[test_class]' and test_type='1' ";
						$dbquery_select = mysqli_query($connect,$sql_select);
						$result_select  = mysqli_fetch_array($dbquery_select);
						if($result_select){
								if($_REQUEST['edit_code']==$result['school_code']){
								$disable="";
								}
								else{
								$disable="disabled";
								}
						}
						else{
						$disable="";
						}
echo "<Tr  bgcolor=$color align=center class=style1><Td>$N</Td>";
echo "</Td><Td align='left'>$result[school_code] $result[school_name]</Td>";
echo "<Td><input type='text' name='$result[school_code][1]' id='$result[school_code][1]'  size= 6 value='$result_select[thai]'  $disable></Td>";
echo "<Td><input type='text' name='$result[school_code][2]' id='$result[school_code][2]'  size= 6 value='$result_select[math]'  $disable></Td>";
echo "<Td><input type='text' name='$result[school_code][3]' id='$result[school_code][3]'  size= 6 value='$result_select[science]'  $disable ></Td>";
echo "<Td><input type='text' name='$result[school_code][4]' id='$result[school_code][4]'  size= 6 value='$result_select[social]'  $disable></Td>";
echo "<Td><input type='text' name='$result[school_code][5]' id='$result[school_code][5]'  size= 6 value='$result_select[english]'  $disable></Td>";
echo "<Td><input type='text' name='$result[school_code][6]' id='$result[school_code][6]'  size= 6 value='$result_select[health]'  $disable></Td>";
echo "<Td><input type='text' name='$result[school_code][7]' id='$result[school_code][7]'  size= 6 value='$result_select[art]'  $disable></Td>";
echo "<Td><input type='text' name='$result[school_code][8]' id='$result[school_code][8]'  size= 6 value='$result_select[vocation]'  $disable></Td>";
echo "<Td><input type='text' name='$result[school_code][9]' id='$result[school_code][9]'  size= 6 value='$result_select[score_avg]'  $disable></Td>";
if($disable=="disabled"){
echo  "<input type='hidden' name='$result[school_code][10]'  id='$result[school_code][10]'  value='1'>";
}
else{
echo  "<input type='hidden' name='$result[school_code][10]'  id='$result[school_code][10]'  value='0'>";
}

if($result_select){
			if($_REQUEST['edit_code']==$result['school_code']){
			echo "<Td align='center'><INPUT TYPE='button' name='smb' value='บันทึก' onclick='goto_url(1)' ></td>";
			}
			else{
			echo "<Td align='center'><a href=?option=achievement&task=main/add_score_1&index=5&ed_year=$_REQUEST[ed_year]&test_class=$_REQUEST[test_class]&edit_code=$result[school_code]><img src=images/edit.png border='0' alt='แก้ไข'></a></Td>";
			}
}
else{
echo "<Td align='center'><INPUT TYPE='button' name='smb' value='บันทึก' onclick='goto_url(1)' ></td>";
}
$M++;
$N++;
}
echo  "<input type='hidden' name='ed_year'  id='ed_year'    value='$_REQUEST[ed_year]'>";
echo  "<input type='hidden' name='test_class'  id='test_class'    value='$_REQUEST[test_class]'>";
echo "</Table>";
echo "<br>";
echo "</form>";
}
?>

<script>
function goto_url2(val){
	 if(val==1){
			if(frm1.ed_year.value == ""){
			alert("กรุณากรอกปีการศึกษา");
			}else if(frm1.test_class.value == ""){
			alert("กรุณาเลือกชั้น");
			}else{
			callfrm("?option=achievement&task=main/add_score_1&index=1");
			}
	}
}

function goto_url(val){
	if(val==1){
			if(frm1.ed_year.value == ""){
			alert("ปีการศึกษาไม่ได้ระบุ โประบุปีการศึกษา");
			}else{
			callfrm("?option=achievement&task=main/add_score_1&index=4");
			}
	}
}

</script>

