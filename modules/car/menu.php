<?php
/** ensure this file is being included by a parent file */
defined( '_VALID_' ) or die( 'Direct Access to this location is not allowed.' );

$sql_permission = "select * from  car_permission where person_id='$_SESSION[login_user_id]'";
$dbquery_permission = mysqli_query($connect,$sql_permission);
$result_permission = mysqli_fetch_array($dbquery_permission);

if(!isset($_SESSION['admin_car'])){
$_SESSION['admin_car']="";
}

	if(($_SESSION['admin_car']=="car")  or ($result_permission['p1']==1)){ ?>
	<li class='dropdown'>
		<a href='?option=car' class='dropdown-toggle' data-toggle='dropdown' role='button' aria-expanded='false'>
			<span class='glyphicon glyphicon-cog' aria-hidden='true'></span>
			&nbsp;ตั้งค่าระบบ <span class='caret'></span></a>
		<ul class='dropdown-menu' role='menu'>
			<li><a href='?option=car&task=main/permission'>กำหนดเจ้าหน้าที่</a></li>
			<?php if($result_permission['p1']==1){ ?>
			<li><a href='?option=car&task=main/car_type'>กำหนดประเภท</a></li>
			<li><a href='?option=car&task=main/car_list'>กำหนดยานพาหนะ</a></li>
			<li><a href='?option=car&task=main/set_driver'>กำหนดพนักงานขับรถ</a></li>
			<?php } ?>
		</ul>
	</li>
	<?php }

	if($_SESSION['login_group']<=4){ ?>
	<li class='dropdown'>
		<a href='?option=car' class='dropdown-toggle' data-toggle='dropdown' role='button' aria-expanded='false'>
			<span class='glyphicon glyphicon-road' aria-hidden='true'></span>
			&nbsp;ขอใช้ยานพาหนะ <span class='caret'></span>
		</a>
		<ul class='dropdown-menu' role='menu'>
			<li><a href='?option=car&task=main/car_request'>ขอใช้รถราชการ</a></li>
		</ul>
	</li>
	<?php }

	if($_SESSION['login_group']<=4 and $result_permission['p1']==1){ ?>
	<li class='dropdown'>
		<a href='?option=car' class='dropdown-toggle' data-toggle='dropdown' role='button' aria-expanded='false'>
			<span class='glyphicon glyphicon-user' aria-hidden='true'></span>
			&nbsp;>เจ้าหน้าที่ <span class='caret'></span>
		</a>
		<ul class='dropdown-menu' role='menu'>
			<li><a href='?option=car&task=main/car_officer'>เจ้าหน้าที่ลงความเห็น</a></li>
			<li><a href='?option=car&task=main/oil_withdraw'>ใบเบิกน้ำมัน</a></li>
		</ul>
	</li>
	<?php }

	if($_SESSION['login_group']<=4 and $result_permission['p1']>=2){ ?>
	<li class='dropdown'>
		<a href='?option=car' class='dropdown-toggle' data-toggle='dropdown' role='button' aria-expanded='false'>
			<span class='glyphicon glyphicon-check' aria-hidden='true'></span>
			&nbsp;ลงความเห็น/อนุมัติ <span class='caret'></span>
		</a>
		<ul class='dropdown-menu' role='menu'>
			<?php if($result_permission['p1']==2){ ?>
			<li><a href='?option=car&task=main/car_group'>ผู้ให้ความเห็นชอบ</a></li>
			<?php }
			if($result_permission['p1']==3) { ?>
			<li><a href='?option=car&task=main/car_commander'>ผู้อนุมัติ</a></li>
			<?php } ?>
		</ul>
	</li>
	<?php }

	if($_SESSION['login_group']<=4){ ?>
	<li class='dropdown'>
		<a href='?option=car' class='dropdown-toggle' data-toggle='dropdown' role='button' aria-expanded='false'>
			<span class='glyphicon glyphicon-stats' aria-hidden='true'></span>
			&nbsp;รายงาน <span class='caret'></span>
		</a>
		<ul class='dropdown-menu' role='menu'>
			<li><a href='?option=car&task=main/car_report'>รายงานการใช้ยานหานะ</a></li>
		</ul>
	</li>
	<?php } ?>

	<li class='dropdown'>
		<a href='?option=car' class='dropdown-toggle' data-toggle='dropdown' role='button' aria-expanded='false'>
			<span class='glyphicon glyphicon-book' aria-hidden='true'></span>
			&nbsp;คู่มือ <span class='caret'></span>
		</a>
		<ul class='dropdown-menu' role='menu'>
			<li><a href='modules/car/manual/car.pdf' target='_blank'>คู่มือ</a></li>
		</ul>
	</li>
