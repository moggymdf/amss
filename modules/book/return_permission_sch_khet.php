<?php
header("Content-type: application/xhtml+xml; charset=utf-8");
header("Cache-Control: no-cache, must-revalidate");

require_once("../../amssplus_connect.php");
$sql = "select * from  person_sch_main  where status='0' and school_code='".$_GET['school_code']."' order by position_code,name";
$query = mysqli_query($connect,$sql);
echo "<option value=''>เลือกบุคลากร</option>";
while($result = mysqli_fetch_array($query)){
	$person_id = $result['person_id'];
	$prename = $result['prename'];
	$name = $result['name'];
	$surname = $result['surname'];
echo "<option value='$person_id'>$prename$name $surname</option>";
}

$sql = "select * from  person_sch_other left join person_sch_main on person_sch_other.person_id=person_sch_main.person_id where person_sch_main.status='0' and person_sch_other.status='0' and person_sch_other.school_code='".$_GET['school_code']."' order by position_code,name";
$query = mysqli_query($connect,$sql);
while($result = mysqli_fetch_array($query)){
	$person_id = $result['person_id'];
	$prename = $result['prename'];
	$name = $result['name'];
	$surname = $result['surname'];
echo "<option value='$person_id'>$prename$name $surname</option>";
}

?>
