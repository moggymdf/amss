<?php
if(isset($_REQUEST['index'])){
$index=$_REQUEST['index'];
}
else{
$index="";
}
//ผนวกไฟล์
if($task!=""){
include("$task");
}
else {
include("default.php");
}
?>
