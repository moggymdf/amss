<?php
/** ensure this file is being included by a parent file */
defined( '_VALID_' ) or die( 'Direct Access to this location is not allowed.' );
include("FusionCharts/FusionCharts.php");
//include("FusionCharts/Fc_Colors.php");

$class_ar[1]="ชั้นประถมศึกษาปีที่ 1";
$class_ar[2]="ชั้นประถมศึกษาปีที่ 2";
$class_ar[3]="ชั้นประถมศึกษาปีที่ 3";
$class_ar[4]="ชั้นประถมศึกษาปีที่ 4";
$class_ar[5]="ชั้นประถมศึกษาปีที่ 5";
$class_ar[6]="ชั้นประถมศึกษาปีที่ 6";
$class_ar[7]="ชั้นมัธยมศึกษาปีที่ 1";
$class_ar[8]="ชั้นมัธยมศึกษาปีที่ 2";
$class_ar[9]="ชั้นมัธยมศึกษาปีที่ 3";
$class_ar[10]="ชั้นมัธยมศึกษาปีที่ 4";
$class_ar[11]="ชั้นมัธยมศึกษาปีที่ 5";
$class_ar[12]="ชั้นมัธยมศึกษาปีที่ 6";

if(!isset($_REQUEST['school_code'])){
$_REQUEST['school_code']="";
}
if(!isset($_REQUEST['class_index'])){
$_REQUEST['class_index']=3;
}
if(!isset($_REQUEST['ed_year'])){
$_REQUEST['ed_year']="";
}

?>
	<SCRIPT LANGUAGE="Javascript" SRC="FusionCharts/FusionCharts.js"></SCRIPT>
	<style type="text/css">
	<!--
	body {
		font-family: Arial, Helvetica, sans-serif;
		font-size: 12px;
	}
	.text{
		font-family: Arial, Helvetica, sans-serif;
		font-size: 12px;
	}
	-->
	</style>

<CENTER>
<h2>คะแนนสอบ NT และการประเมิน แบบที่ 2</h2>
<h3><?php echo $class_ar[$_REQUEST['class_index']] ?></h3>
<?php
echo "<form id='frm1' name='frm1'>";
echo "<table width='85%' align='center'><tr><td align='right'>";

echo "<Select  name='class_index' size='1'>";
				if($_REQUEST['class_index']=='1'){
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

//echo  "<option value =1 $select_class_1>ชั้น ป.1</option>";
//echo  "<option value =2 $select_class_2>ชั้น ป.2</option>";
echo  "<option value =3 $select_class_3>ชั้น ป.3</option>";
//echo  "<option value =4 $select_class_4>ชั้น ป.4</option>";
//echo  "<option value =5 $select_class_5>ชั้น ป.5</option>";
//echo  "<option value =6 $select_class_6>ชั้น ป.6</option>";
//echo  "<option value =7 $select_class_7>ชั้น ม.1</option>";
//echo  "<option value =8 $select_class_8>ชั้น ม.2</option>";
//echo  "<option value =9 $select_class_9>ชั้น ม.3</option>";
//echo  "<option value =10 $select_class_10>ชั้น ม.4</option>";
//echo  "<option value =11 $select_class_11>ชั้น ม.5</option>";
//echo  "<option value =12 $select_class_12>ชั้น ม.6</option>";
echo "</select>";

echo "<Select  name='ed_year' size='1'>";
$sql = "select distinct ed_year from achievement_main where  test_type='2' and test_class='$_REQUEST[class_index]' order by ed_year desc ";
$dbquery = mysqli_query($connect,$sql);
$year=1;
While ($result_year = mysqli_fetch_array($dbquery)){
			$year_ar[$year]=$result_year['ed_year'];
			if($_REQUEST['ed_year']==""){
			echo "<option value=$result_year[ed_year]>ปีการศึกษา $result_year[ed_year]</option>";
			}
			else{
					if($_REQUEST['ed_year']==$result_year['ed_year']){
					echo "<option value=$result_year[ed_year] selected>ปีการศึกษา $result_year[ed_year]</option>";
					}
					else{
					echo "<option value=$result_year[ed_year]>ปีการศึกษา $result_year[ed_year]</option>";
					}
			}
$year++;
}
	echo "</select>";
	echo "&nbsp;<INPUT TYPE='button' name='smb' value='เลือก' onclick='goto_display(1)' class='entrybutton'>";
echo "</td></tr></table>";
echo "</form>";

echo "<Table width=85%' Border='0' Bgcolor='#Fcf9d8'>";
  echo "<Tr bgcolor='#FFCCCC'><Td  align='center' width='4%'>ที่</Td><Td  align='center' width='17%'>โรงเรียน</Td><Td  align='center' width='16%'>ความสามารถด้านภาษา</Td><td align='center'  width='16%'>ความสามารถด้านคำนวณ</td><Td align='center'  width='16%'>ความสามารถด้านเหตุผล</Td><Td align='center' width='16%' >เฉลี่ย</Td><Td align='center' >ผลการประเมิน</Td></Tr>";

$sql = "select distinct achievement_main.school ,system_school.school_name from achievement_main left join system_school on achievement_main.school=system_school.school_code where  achievement_main.test_type='2' and achievement_main.test_class='$_REQUEST[class_index]' order by system_school.school_type, system_school.school_code ";
$dbquery = mysqli_query($connect,$sql);
$M=1;
While ($result_1 = mysqli_fetch_array($dbquery)){
			if($_REQUEST['ed_year']==""){
			$strQuery = "select thai, math, science, social, english, health, art, vocation, score_avg from achievement_main where test_type='2' and test_class='$_REQUEST[class_index]' and ed_year='$year_ar[1]' and school='$result_1[school]' ";
			}
			else{
			$strQuery = "select thai, math, science, social, english, health, art, vocation, score_avg from achievement_main where test_type='2' and test_class='$_REQUEST[class_index]' and ed_year='$_REQUEST[ed_year]' and school='$result_1[school]' ";
			}
			$result = mysqli_query($connect,$strQuery);
			$ors = mysqli_fetch_array($result);
			if(($M%2) == 0)
			$color="#CCCCCC";
			else  	$color="#FFFFFF";

		$thai=number_format($ors['thai'],2);
		$math=number_format($ors['math'],2);
		$science=number_format($ors['science'],2);
		$score_avg=number_format($ors['score_avg'],2);

		if($score_avg>0){
		 echo "<Tr bgcolor=$color><Td  align='center' >$M</Td><Td  align='left' >$result_1[school] $result_1[school_name]</Td><Td  align='center'>$thai</Td><td align='center' >$math</td><Td align='center'>$science</Td><Td align='center' >$score_avg</Td><Td align='left' >";
		 //คะแนนจุดตัด
		$a=60;
		$b=30;
		$color[2]="#00CC00";
        echo "<table  border='0' cellspacing='0' cellpadding='0'>";
        echo "<tr><td></td>";
				$score_ceil=$score_avg/2;
				if($score_ceil>50){
				$score_ceil=0;   //error
				}
				for($j=0;$j<=$score_ceil;$j++){
						 		if ($j<=($b/2)){
	  							$cl='#FF0000';
						  		}
						 		else if (($j>($b/2)) and ($j<($a/2))){
						  		$cl='#FFFF00';
						  		}
						   		else if ($j>=($a/2)){
						  		$cl='#00CC00';
						  		}
          	 echo "<td bgcolor='$cl' width='1' >&nbsp;</td>";
			 }
          	echo "</tr>";
         	echo "</table>";
	echo "</Td></Tr>";
	$M++;
	 }
}
echo "</Table>";
?>
</CENTER>

<script>
function goto_display(val){
	if(val==1){
		callfrm("?option=achievement&task=main/report4_2");
		}
}
</script>

