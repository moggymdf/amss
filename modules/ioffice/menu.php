<?php
/** ensure this file is being included by a parent file */
defined( '_VALID_' ) or die( 'Direct Access to this location is not allowed.' );
?>
<!-- เมนู -->
<?php
// เมนูสำหรับผู้ดูแล Module
$sql_permission = "select * from person_permission where person_id='$_SESSION[login_user_id]'";
$dbquery_permission = mysqli_query($connect,$sql_permission);
$result_permission = mysqli_fetch_array($dbquery_permission);
// เปลี่ยนจาก ioffice เป็นชื่อ Module
if(!isset($_SESSION['admin_ioffice'])){ $_SESSION['admin_ioffice']=""; }
if(($_SESSION['admin_ioffice']=="ioffice") or ($result_permission['p1']==1)) {
	?>
	<li class="dropdown">
	<a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false">ตั้งค่าระบบ <span class="caret"></span></a>
		<ul class="dropdown-menu" role="menu">
			<li><a href="#">กำหนดเจ้าหน้าที่</a></li>
			<li><a href="#">กำหนดระยะเวลาในการข้ามลำดับ</a></li>
		</ul>
	</li>
<?php
}
// จบส่วนเมนูผู้ดูแล Module
?>
<!-- เมนูผู้ใช้งานทั่วไป -->
<li class="dropdown"> <!-- เมนู Dropdown -->
    <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false">บันทึกเสนอ <span class="caret"></span></a>
    <ul class="dropdown-menu" role="menu">
        <li><a href="?option=<?php echo $_GET['option']; ?>&task=book_insert">เพิ่มบันทึกเสนอใหม่</a></li> <!-- เมนูย่อยใน Dropdown -->
        <li><a href="?option=<?php echo $_GET['option']; ?>&task=book_select">รายการบันทึกเสนอ</a></li> <!-- เมนูย่อยใน Dropdown -->
        <li class="divider"></li> <!-- ขีดเส้นขั้นระหว่างเมนูย่อยใน Dropdown -->
        <li><a href="?option=<?php echo $_GET['option']; ?>&task=book_search">ค้นหาบันทึกเสนอทั้งหมด</a></li> <!-- เมนูย่อยใน Dropdown -->
    </ul>
</li>
<li><a href="?option=<?php echo $_GET['option']; ?>&task=book_pass">สั่งการ</a></li> <!-- เมนูไม่ Dropdown -->
<li><a href="/modules/<?php echo $_GET['option']; ?>/manual/manual.pdf">คู่มือ</a></li> <!-- เมนูไม่ Dropdown -->
