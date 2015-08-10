<!-- Bootstrap Include -->
<script src="./bootstrap-3.3.5-dist/js/bootstrap-confirmation.min.js"></script>
<script src="./ckeditor_4.5.2_full/ckeditor.js"></script>

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
