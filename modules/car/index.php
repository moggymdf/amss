<!-- Bootstrap Include -->
<link rel="stylesheet" type="text/css" href="./bootstrap-3.3.5-dist/css/bootstrap.min.css">
<script src="./bootstrap-3.3.5-dist/js/jquery-1.11.3.min.js"></script>
<script src="./bootstrap-3.3.5-dist/js/bootstrap.min.js"></script>
<script src="./bootstrap-3.3.5-dist/js/bootstrap-confirmation.min.js"></script>
<script src="./ckeditor_4.5.2_full/ckeditor.js"></script>

<?php
//ผนวกเมนู
if($_SESSION['user_os']=='mobile'){
$module_menu_path="./modules/$_REQUEST[option]/menu_mobile.php";
}
else{
$module_menu_path="./modules/$_REQUEST[option]/menu.php";
}
if(file_exists($module_menu_path)){
require_once("$module_menu_path");
}
else{
die ("No MenuPage");
}

//ผนวกไฟล์
if($task!=""){
			$module_file_path="modules/$_REQUEST[option]/".$task;
			if(file_exists($module_file_path)){
			require_once("$module_file_path");
			}else{
			die ("No Page");
			}
}
else {
			$module_file_path="modules/$_REQUEST[option]/"."default.php";
			if(file_exists($module_file_path)){
			require_once("$module_file_path");
			}else{
			die ("No DefaultPage");
			}
}
?>

<!-- Bootstrap Popover -->
<script>
	$(function () {
 		$('[data-toggle="popover"]').popover()
	})
</script>

<!-- Bootstrap Confirmation -->
<script>
	$('[data-toggle="confirmation"]').confirmation()
</script>
