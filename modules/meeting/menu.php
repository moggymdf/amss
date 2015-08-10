<?php
/** ensure this file is being included by a parent file */
defined( '_VALID_' ) or die( 'Direct Access to this location is not allowed.' );

$sql_permission = "select * from  meeting_permission where person_id='$_SESSION[login_user_id]'";
$dbquery_permission = mysqli_query($connect,$sql_permission);
$result_permission = mysqli_fetch_array($dbquery_permission);

if(!isset($_SESSION['admin_meeting'])){
$_SESSION['admin_meeting']="";
}

	if($_SESSION['admin_meeting']=="meeting"){ ?>
	<li class='dropdown'>
		<a href='#' class='dropdown-toggle' data-toggle='dropdown' role='button' aria-expanded='false'>
			<span class='glyphicon glyphicon-cog' aria-hidden='true'></span>
			&nbsp;ตั้งค่าระบบ <span class='caret'></span>
		</a>
		<ul class='dropdown-menu' role='menu'>
			<li><a href='?option=meeting&task=main/permission'>กำหนดเจ้าหน้าที่</a></li>
			<li><a href='?option=meeting&task=main/set_room'>กำหนดห้องประชุม</a></li>
		</ul>
	</li>
	<?php }
	if($_SESSION['login_group']<=4){ ?>
	<li class='dropdown'>
		<a href='#' class='dropdown-toggle' data-toggle='dropdown' role='button' aria-expanded='false'>
			<span class='glyphicon glyphicon-edit' aria-hidden='true'></span>
			&nbsp;จองห้องประชุม <span class='caret'></span>
		</a>
		<ul class='dropdown-menu' role='menu'>
			<li><a href='?option=meeting&task=main/meeting'>จองห้องประชุม</a></li>
			<li><a href='?option=meeting&task=main/search'>ค้นหาห้องประชุมว่าง</a></li>
		<?php if(($result_permission['p1']==1) or ($_SESSION['admin_meeting']=="meeting")){ ?>
			<li><a href='?option=meeting&task=main/officer'>อนุญาตให้ใช้ห้องประชุม</a></li>
			<li><a href='?option=meeting&task=main/meeting_dep'>รายการจองของคนในสำนัก</a></li>
		<?php } ?>
		</ul>
	</li>
	<?php }
	if($_SESSION['login_group']<=4){ ?>
	<li class='dropdown'>
		<a href='#' class='dropdown-toggle' data-toggle='dropdown' role='button' aria-expanded='false'>
			<span class='glyphicon glyphicon-stats' aria-hidden='true'></span>
			&nbsp;รายงาน <span class='caret'></span>
		</a>
		<ul class='dropdown-menu' role='menu'>
			<?php if(($result_permission['p1']==1) or ($_SESSION['admin_meeting']=="meeting")){ ?>
			<li><a href='?option=meeting&task=main/report1'>สรุปการใช้ห้องประชุมในสำนัก</a></li>
			<?php } ?>
		</ul>
	</li>
	<?php } ?>
	<li class='dropdown'>
		<a href='#' class='dropdown-toggle' data-toggle='dropdown' role='button' aria-expanded='false'>
			<span class='glyphicon glyphicon-book' aria-hidden='true'></span>
			&nbsp;คู่มือ <span class='caret'></span>
		</a>
		<ul class='dropdown-menu' role='menu'>
			<li><a href='modules/meeting/manual/meeting.pdf' target='_blank'>คู่มือจองห้องประชุม</a></li>
		</ul>
	</li>

