<?php
if($_SESSION['user_os']=='mobile'){
include("modules/student_main/menu_mobile.php");
}
else{
include("modules/student_main/menu.php");
}
//ผนวกไฟล์
if($task!=""){
include("$task");
}
else {
include("default.php");
}
?>

