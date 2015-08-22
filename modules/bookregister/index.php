<!--Bootstrap selectpicker -->
<script src="./modules/bookregister/js/bootstrap-select.min.js"></script>
<link href="./modules/bookregister/css/bootstrap-select.min.css" rel="stylesheet" media="screen">

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
