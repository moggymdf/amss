<?php
header("Content-Type: application/vnd.ms-excel");
header('Content-Disposition: attachment; filename="person.xls"');# ชื่อไฟล์
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

$sql = "select * from  person_position order by position_code";
$dbquery = mysqli_query($connect,$sql);
While ($result = mysqli_fetch_array($dbquery)){
$position_ar[$result['position_code']]=$result['position_name'];
}

$sql = "select * from  system_workgroup order by workgroup_order";
$dbquery = mysqli_query($connect,$sql);
While ($result = mysqli_fetch_array($dbquery)){
$department_ar[$result['workgroup']]=$result['workgroup_desc'];
}

$sql = "select * from person_main order by department,position_code,person_order";
$dbquery = mysqli_query($connect,$sql);
echo "<table><Tr><Td align='center'>ที่</Td><Td align='center'>ชื่อ</Td><Td align='center'>ตำแหน่ง</Td><Td align='center'>กลุ่ม</Td></Tr>";
$N=1;
While ($result = mysqli_fetch_array($dbquery))
	{
		$id = $result['id'];
		$person_id = $result['person_id'];
		$prename=$result['prename'];
		$name= $result['name'];
		$surname = $result['surname'];
		$position_code= $result['position_code'];
		$department= $result['department'];

		echo "<Tr><Td align='center'>$N</Td><Td align='left'>$prename&nbsp;$name&nbsp;&nbsp;$surname</Td><Td align='left'>";
		if(isset($position_ar[$position_code])){
		echo $position_ar[$position_code];
		}
		echo "</Td><Td align='left'>";
		if(isset($department_ar[$department])){
		echo $department_ar[$department];
		}
		echo "</Td></Tr>";
$N++;
	}
echo "</Table>";
?>
</BODY>
</HTML>
