<?php
//ผนวกไฟล์
if($task!=""){
include("$task");
}
else {
include("default.php");
}
?>
