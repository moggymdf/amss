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
?>
