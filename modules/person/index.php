<?php
if(isset($_REQUEST['index'])){
$index=$_REQUEST['index'];
}
else{
$index="";
}

if($_SESSION['user_os']=='mobile'){
//include("./modules/person/menu_mobile.php");  // Comment บรรทัดนี้
}
else{
//include("./modules/person/menu.php");	// Comment บรรทัดนี้
}
//ผนวกไฟล์
if($task!=""){
include("$task");
}
else {
include("default.php");
}
?>

