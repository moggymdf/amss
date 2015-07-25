<?php
header("Content-Type: application/vnd.ms-excel");
header('Content-Disposition: attachment; filename="student.xls"');# ชื่อไฟล์
?>
<html xmlns:o="urn:schemas-microsoft-com:office:office"
xmlns:x="urn:schemas-microsoft-com:office:excel"
xmlns="http://www.w3.org/TR/REC-html40">
<HTML>
<HEAD>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
</HEAD>

<BODY>
<?php
require_once "../../amssplus_connect.php";

//อาเรย์สถานศึกษา
$sql = "select * from  system_school where school_type='1'";
$dbquery = mysqli_query($connect,$sql);
While ($school_result = mysqli_fetch_array($dbquery)){
$school_code=$school_result['school_code'];
$school_ar[$school_code]=$school_result['school_name'];
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

$sql = "select * from student_main_main where ed_year='$_REQUEST[year_index]' and  school_code='$_REQUEST[school_index]' order by school_code,classlevel,classroom,student_id ";
$dbquery = mysqli_query($connect,$sql);

echo  "<table width='85%' border='0' align='center'>";
echo "<Tr bgcolor=#FFCCCC align='center' ><Td width='50'>ที่</Td><Td width='90'>เลขประจำตัว<br>นักเรียน</Td><Td width='150'>เลขประจำตัว<br>ประชาชน</Td><Td align='center'>ชื่อ</Td><Td width='100'>เพศ</Td><Td width='90'>ชั้น</Td><Td width='50'>ห้อง</Td><Td width='200'>โรงเรียน</Td></Tr>";
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

echo "<Tr  bgcolor=$color align='center'><Td>$M</Td><Td align='left'>$student_id</Td><Td align='left'>$person_id</Td>";
echo "<Td align='left'>$prename&nbsp;$name&nbsp;&nbsp;$surname</Td><Td align='center'>$sex</Td>";
echo "<Td align='center'>$school_class_ar[$school_class]</Td>";
echo "<Td align='center'>$room</Td>";
echo "<Td align='left'>";
if(isset($school_ar[$school_id])){
echo $school_ar[$school_id];
}
echo "</Td>";
echo "</Tr>";
$M++;
	}
echo "</Table>";
?>
</BODY>
</HTML>
