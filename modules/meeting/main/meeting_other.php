<link rel="stylesheet" href="//netdna.bootstrapcdn.com/bootstrap/3.3.2/css/bootstrap.min.css">
<link rel="stylesheet" href="//netdna.bootstrapcdn.com/font-awesome/3.2.1/css/font-awesome.min.css">
<link href="modules/meeting/css/datepicker.css" rel="stylesheet" media="screen">

<?php
/** ensure this file is being included by a parent file */
defined( '_VALID_' ) or die( 'Direct Access to this location is not allowed.' );
$login_group=mysqli_real_escape_string($connect,$_SESSION['login_group']);
if(!($login_group<=4)){
exit();
}

require_once "modules/meeting/time_inc.php";
?>
<script type="text/javascript" src="./css/js/calendarDateInput.js"></script>
<?php

$user=mysqli_real_escape_string($connect,$_SESSION['login_user_id']);
$system_user_department=mysqli_real_escape_string($connect,$_SESSION['system_user_department']);
$system_user_department_name=mysqli_real_escape_string($connect,$_SESSION['system_user_department_name']);

//กรณีเลือกแสดงเฉพาะห้องประชุม
if(isset($_REQUEST['room_index'])){
$room_index=$_REQUEST['room_index'];
}else{
	$room_index = "";
	}
//ส่วนหัว
echo "<br />";

if(isset($_GET['index'])){
$getindex=mysqli_real_escape_string($connect,$_GET['index']);
}else {$getindex="";}

if(isset($_POST['index'])){
$postindex=mysqli_real_escape_string($connect,$_POST['index']);
}else {$postindex="";}

if(!(($getindex==1) or ($getindex==2) or ($getindex==11))){

echo "<table width='100%' border='0' align='center' >";
echo "<tr align='center'><td><font color='#006666' size='3'><strong>ทะเบียนจองห้องประชุม</strong></font></td></tr>";
echo "</table>";
}

//ส่วนฟอร์มรับข้อมูล
if($getindex==1){

echo "<form id='frm1' name='frm1' class='form-control'>";
echo "<Center>";
echo "<Font color='#006666' Size=3><B>จองห้องประชุมในสำนัก</Font>";
echo "</Cener>";
echo "<Br><Br>";
echo "<Table width='70%' class='table table-hover table-bordered table-striped table-condensed'>";
echo "<Tr align='left'><Td align='right'>เลือกห้องประชุม&nbsp;&nbsp;</Td><Td><Select  name='room'  size='1'>";
echo  "<option  value = ''>เลือก</option>" ;
$sql = "select * from meeting_room where department=? and active='1'  order by id";
    $dbquery = $connect->prepare($sql);
    $dbquery->bind_param("i", $system_user_department);
    $dbquery->execute();
    $result_room=$dbquery->get_result();
While ($result = mysqli_fetch_array($result_room))
   {
		$room_code = $result['room_code'];
		$room_name = $result['room_name'];
		if($room_index==$room_code){
		echo  "<option value = $room_code selected>$room_name</option>";
		}
		else{
		echo  "<option value = $room_code>$room_name</option>";
		}
	}
echo "</select>";
echo "</Td></Tr>";

echo "<Tr align='left'><Td align='right'>วันทีเริ่มใช้ห้อง&nbsp;&nbsp;</Td>";

echo "<Td align='left'>";
echo "<table><tr><td>";
?>
              <input class="form-control" type="text" name="book_date_start" autoclose='true' data-provide="datepicker" data-date-language="th" value=""  Size="15">


<?php
echo "</Td><td>&nbsp;&nbsp;ถึงวันที่&nbsp;&nbsp;<td><td>";

echo "<input class='form-control' type='text' name='book_date_end'  data-provide='datepicker' data-autoclose='true' data-date-language='th'  Size='15'>
";

echo "</td></tr></table>";
echo "</Td></Tr>";

echo "<Tr align='left'><Td align='right'>ตั้งแต่เวลา&nbsp;&nbsp;</Td>";
echo "<td><table><tr><Td><Select  name='start_time'  size='1'>";
echo  "<option  value = ''>เลือก</option>" ;
echo  "<option value = 1>01.00 น.</option>";
echo  "<option value = 2>02.00 น.</option>";
echo  "<option value = 3>03.00 น.</option>";
echo  "<option value = 4>04.00 น.</option>";
echo  "<option value = 5>05.00 น.</option>";
echo  "<option value = 6>06.00 น.</option>";
echo  "<option value = 7>07.00 น.</option>";
echo  "<option value = 8 selected>08.00 น.</option>";
echo  "<option value = 9>09.00 น.</option>";
echo  "<option value = 10>10.00 น.</option>";
echo  "<option value = 11>11.00 น.</option>";
echo  "<option value = 12>12.00 น.</option>";
echo  "<option value = 13>13.00 น.</option>";
echo  "<option value = 14>14.00 น.</option>";
echo  "<option value = 15>15.00 น.</option>";
echo  "<option value = 16>16.00 น.</option>";
echo  "<option value = 17>17.00 น.</option>";
echo  "<option value = 18>18.00 น.</option>";
echo  "<option value = 19>19.00 น.</option>";
echo  "<option value = 20>20.00 น.</option>";
echo  "<option value = 21>21.00 น.</option>";
echo  "<option value = 22>22.00 น.</option>";
echo  "<option value = 23>23.00 น.</option>";
echo  "<option value = 24>24.00 น.</option>";
echo "</select>";
echo "</td><td>&nbsp;&nbsp;ถึงเวลา&nbsp;</td>";

echo "<Td><Select  name='finish_time'  size='1'>";
echo  "<option  value = ''>เลือก</option>" ;
echo  "<option value = 1>01.00 น.</option>";
echo  "<option value = 2>02.00 น.</option>";
echo  "<option value = 3>03.00 น.</option>";
echo  "<option value = 4>04.00 น.</option>";
echo  "<option value = 5>05.00 น.</option>";
echo  "<option value = 6>06.00 น.</option>";
echo  "<option value = 7>07.00 น.</option>";
echo  "<option value = 8>08.00 น.</option>";
echo  "<option value = 9>09.00 น.</option>";
echo  "<option value = 10>10.00 น.</option>";
echo  "<option value = 11>11.00 น.</option>";
echo  "<option value = 12>12.00 น.</option>";
echo  "<option value = 13>13.00 น.</option>";
echo  "<option value = 14>14.00 น.</option>";
echo  "<option value = 15>15.00 น.</option>";
echo  "<option value = 16   selected>16.00 น.</option>";
echo  "<option value = 17>17.00 น.</option>";
echo  "<option value = 18>18.00 น.</option>";
echo  "<option value = 19>19.00 น.</option>";
echo  "<option value = 20>20.00 น.</option>";
echo  "<option value = 21>21.00 น.</option>";
echo  "<option value = 22>22.00 น.</option>";
echo  "<option value = 23>23.00 น.</option>";
echo  "<option value = 24>24.00 น.</option>";
echo "</select>";
echo "</Td></Tr></table></td></tr>";
echo "<Tr align='left'><Td align='right'>ประธานการประชุม&nbsp;&nbsp;</Td><Td><Input Type='Text' Name='chairman' Size='100'></Td></Tr>";
echo "<Tr align='left'><Td align='right'>วัตถุประสงค์&nbsp;&nbsp;</Td><Td><Input Type='Text' Name='objective' Size='100'></Td></Tr>";
echo "<Tr align='left'><Td align='right'>จำนวนผู้เข้าประชุม&nbsp;&nbsp;</Td><Td><Input Type='Text' Name='person_num'  Size='5'onkeypress=check_number()>&nbsp;คน</Td></Tr>";
echo "<Tr align='left'><Td align='right'>ผู้ประสานงาน/เบอร์โทร&nbsp;&nbsp;</Td><Td><Input Type='Text' Name='coordinator' Size='100'></Td></Tr>";
echo "<Tr align='left'><Td align='right'>อื่น ๆ (ถ้ามี)&nbsp;&nbsp;</Td><Td><Input Type='Text' Name='other' Size='100'></Td></Tr>";
echo "</Table>";
echo "<Br>";
echo "<INPUT TYPE='hidden' name='room_index' value=$room_index>";
echo "<INPUT TYPE='hidden' name='index' value=4>";
echo "<INPUT TYPE='button' name='smb' value='ตกลง' onclick='goto_url(1)' class=entrybutton>
		&nbsp;&nbsp;<INPUT TYPE='button' name='back' value='ย้อนกลับ' onclick='goto_url(0)' class=entrybutton'>";

echo "</form>";
}

//เพิ่มจองห้องต่างสำนัก
if($getindex==11){

echo "<form id='frm1' name='frm1' class='form-control'>";
echo "<Center>";
echo "<Font color='#006666' Size=3><B>จองห้องประชุมต่างสำนัก</Font>";
echo "</Cener>";
echo "<Br><Br>";
echo "<Table width='70%' class='table table-hover table-bordered table-striped table-condensed'>";
echo "<Tr align='left'><Td align='right'>เลือกห้องประชุม&nbsp;&nbsp;</Td><Td><Select  name='room'  size='1'>";
echo  "<option  value = ''>เลือก</option>" ;
$sql = "select * from meeting_room where department!=? and active='1'  order by id";
    $dbquery = $connect->prepare($sql);
    $dbquery->bind_param("i", $system_user_department);
    $dbquery->execute();
    $result_room=$dbquery->get_result();
While ($result = mysqli_fetch_array($result_room))
   {
		$room_code = $result['room_code'];
		$room_name = $result['room_name'];
		if($room_index==$room_code){
		echo  "<option value = $room_code selected>$room_name</option>";
		}
		else{
		echo  "<option value = $room_code>$room_name</option>";
		}
	}
echo "</select>";
echo "</Td></Tr>";

echo "<Tr align='left'><Td align='right'>วันทีเริ่มใช้ห้อง&nbsp;&nbsp;</Td>";

echo "<Td align='left'>";
echo "<table><tr><td>";
?>
              <input class="form-control" type="text" name="book_date_start" autoclose='true' data-provide="datepicker" data-date-language="th" value=""  Size="15">
<?php
echo "</Td><td>&nbsp;&nbsp;ถึงวันที่&nbsp;&nbsp;<td><td>";

echo "<input class='form-control' type='text' name='book_date_end'  data-provide='datepicker' data-autoclose='true' data-date-language='th'  Size='15'>
";

echo "</td></tr></table>";
echo "</Td></Tr>";

echo "<Tr align='left'><Td align='right'>ตั้งแต่เวลา&nbsp;&nbsp;</Td>";
echo "<td><table><tr><Td><Select  name='start_time'  size='1'>";
echo  "<option  value = ''>เลือก</option>" ;
echo  "<option value = 1>01.00 น.</option>";
echo  "<option value = 2>02.00 น.</option>";
echo  "<option value = 3>03.00 น.</option>";
echo  "<option value = 4>04.00 น.</option>";
echo  "<option value = 5>05.00 น.</option>";
echo  "<option value = 6>06.00 น.</option>";
echo  "<option value = 7>07.00 น.</option>";
echo  "<option value = 8 selected>08.00 น.</option>";
echo  "<option value = 9>09.00 น.</option>";
echo  "<option value = 10>10.00 น.</option>";
echo  "<option value = 11>11.00 น.</option>";
echo  "<option value = 12>12.00 น.</option>";
echo  "<option value = 13>13.00 น.</option>";
echo  "<option value = 14>14.00 น.</option>";
echo  "<option value = 15>15.00 น.</option>";
echo  "<option value = 16>16.00 น.</option>";
echo  "<option value = 17>17.00 น.</option>";
echo  "<option value = 18>18.00 น.</option>";
echo  "<option value = 19>19.00 น.</option>";
echo  "<option value = 20>20.00 น.</option>";
echo  "<option value = 21>21.00 น.</option>";
echo  "<option value = 22>22.00 น.</option>";
echo  "<option value = 23>23.00 น.</option>";
echo  "<option value = 24>24.00 น.</option>";
echo "</select>";
echo "</td><td>&nbsp;&nbsp;ถึงเวลา&nbsp;</td>";

echo "<Td><Select  name='finish_time'  size='1'>";
echo  "<option  value = ''>เลือก</option>" ;
echo  "<option value = 1>01.00 น.</option>";
echo  "<option value = 2>02.00 น.</option>";
echo  "<option value = 3>03.00 น.</option>";
echo  "<option value = 4>04.00 น.</option>";
echo  "<option value = 5>05.00 น.</option>";
echo  "<option value = 6>06.00 น.</option>";
echo  "<option value = 7>07.00 น.</option>";
echo  "<option value = 8>08.00 น.</option>";
echo  "<option value = 9>09.00 น.</option>";
echo  "<option value = 10>10.00 น.</option>";
echo  "<option value = 11>11.00 น.</option>";
echo  "<option value = 12>12.00 น.</option>";
echo  "<option value = 13>13.00 น.</option>";
echo  "<option value = 14>14.00 น.</option>";
echo  "<option value = 15>15.00 น.</option>";
echo  "<option value = 16   selected>16.00 น.</option>";
echo  "<option value = 17>17.00 น.</option>";
echo  "<option value = 18>18.00 น.</option>";
echo  "<option value = 19>19.00 น.</option>";
echo  "<option value = 20>20.00 น.</option>";
echo  "<option value = 21>21.00 น.</option>";
echo  "<option value = 22>22.00 น.</option>";
echo  "<option value = 23>23.00 น.</option>";
echo  "<option value = 24>24.00 น.</option>";
echo "</select>";
echo "</Td></Tr></table></td></tr>";
echo "<Tr align='left'><Td align='right'>ประธานการประชุม&nbsp;&nbsp;</Td><Td><Input Type='Text' Name='chairman' Size='100'></Td></Tr>";
echo "<Tr align='left'><Td align='right'>วัตถุประสงค์&nbsp;&nbsp;</Td><Td><Input Type='Text' Name='objective' Size='100'></Td></Tr>";
echo "<Tr align='left'><Td align='right'>จำนวนผู้เข้าประชุม&nbsp;&nbsp;</Td><Td><Input Type='Text' Name='person_num'  Size='5'onkeypress=check_number()>&nbsp;คน</Td></Tr>";
echo "<Tr align='left'><Td align='right'>ผู้ประสานงาน/เบอร์โทร&nbsp;&nbsp;</Td><Td><Input Type='Text' Name='coordinator' Size='100'></Td></Tr>";
echo "<Tr align='left'><Td align='right'>อื่น ๆ (ถ้ามี)&nbsp;&nbsp;</Td><Td><Input Type='Text' Name='other' Size='100'></Td></Tr>";
echo "</Table>";
echo "<Br>";
echo "<INPUT TYPE='hidden' name='room_index' value=$room_index>";
echo "<INPUT TYPE='hidden' name='index' value=4>";
echo "<INPUT TYPE='button' name='smb' value='ตกลง' onclick='goto_url(1)' class=entrybutton>
		&nbsp;&nbsp;<INPUT TYPE='button' name='back' value='ย้อนกลับ' onclick='goto_url(0)' class=entrybutton'>";

echo "</form>";
}


//ส่วนยืนยันการลบข้อมูล

if(isset($_GET['id'])){
$getid=mysqli_real_escape_string($connect,$_GET['id']);
}else {$getid="";}

/*
if(isset($_GET['page'])){
$getpage=mysqli_real_escape_string($connect,$_GET['page']);
}else {$getpage="";}

if(isset($_GET['room_index'])){
$getroom_index=mysqli_real_escape_string($connect,$_GET['room_index']);
}else {$getroom_index="";}
*/

if($getindex==2) {
echo "<table width='500' border='0' align='center'>";
echo "<tr><td align='center'><font color='#990000' size='4'>โปรดยืนยันความต้องการลบข้อมูลอีกครั้ง</font><br></td></tr>";
echo "<tr><td align=center>";
echo "<INPUT TYPE='button' name='smb' value='ยืนยัน' onclick='location.href=\"?option=meeting&task=main/meeting&index=3&id=$getid&page=$_REQUEST[page]&room_index=$_REQUEST[room_index]\"'>
		&nbsp;&nbsp;<INPUT TYPE='button' name='back' value='ยกเลิก' onclick='location.href=\"?option=meeting&task=main/meeting&page=$_REQUEST[page]&room_index=$_REQUEST[room_index]\"'";
echo "</td></tr></table>";
}

//ส่วนลบข้อมูล
if($getindex==3){
$sql = "delete from meeting_main where id=?";
    $dbquery = $connect->prepare($sql);
    $dbquery->bind_param("i", $getid);
    $dbquery->execute();
    $result=$dbquery->get_result();
 }

//ส่วนบันทึกข้อมูล
if($postindex==4){
$date_time_now = date("Y-m-d H:i:s");

//ตรวจสอบ
if(isset($_POST['room'])){
$room=mysqli_real_escape_string($connect,$_POST['room']);
}else {$room=""; }
if(isset($_POST['book_date_start'])){
$book_date_start=mysqli_real_escape_string($connect,$_POST['book_date_start']);
    $book_date_start=explode("/", $book_date_start);
    $book_date_start=$book_date_start[2]."-".$book_date_start[1]."-".$book_date_start[0];  //ปี เดือน วัน
}else {$book_date_start=""; }
if(isset($_POST['book_date_end'])){
$book_date_end=mysqli_real_escape_string($connect,$_POST['book_date_end']);
    $book_date_end=explode("/", $book_date_end);
    $book_date_end=$book_date_end[2]."-".$book_date_end[1]."-".$book_date_end[0];  //ปี เดือน วัน
}else {$book_date_end=""; }
if(isset($_POST['start_time'])){
$start_time=mysqli_real_escape_string($connect,$_POST['start_time']);
}else {$start_time=""; }
if(isset($_POST['finish_time'])){
$finish_time=mysqli_real_escape_string($connect,$_POST['finish_time']);
}else {$finish_time=""; }
if(isset($_POST['chairman'])){
$chairman=mysqli_real_escape_string($connect,$_POST['chairman']);
}else {$chairman=""; }
if(isset($_POST['objective'])){
$objective=mysqli_real_escape_string($connect,$_POST['objective']);
}else {$objective=""; }
if(isset($_POST['person_num'])){
$person_num=mysqli_real_escape_string($connect,$_POST['person_num']);
}else {$person_num=""; }
if(isset($_POST['coordinator'])){
$coordinator=mysqli_real_escape_string($connect,$_POST['coordinator']);
}else {$coordinator=""; }
if(isset($_POST['other'])){
$other=mysqli_real_escape_string($connect,$_POST['other']);
}else {$other=""; }

$sql_insert = "insert into meeting_main (id , room , book_date_start , book_date_end , start_time, finish_time , chairman , objective , person_num , book_person , user_book , rec_date , approve , reason , coordinator, other , officer , officer_date) values ('',?,?,?,?,?,?,?,?,?,?,?,'','',?,?,'','')";
//    $dbquery_insert = $connect->prepare($sql_insert);

//    $dbquery_insert->bind_param("issiississsss", $room , $book_date_start , $book_date_end , $start_time , $finish_time , $chairman , $objective , $person_num , $user , $user , $date_time_now , $coordinator , $other);
//    $dbquery_insert->execute();
//    $result_insert=$dbquery_insert->get_result();
if ($dbquery_insert = $connect->prepare($sql_insert)) {

    $dbquery_insert->bind_param("issiississsss", $room , $book_date_start , $book_date_end , $start_time , $finish_time , $chairman , $objective , $person_num , $user , $user , $date_time_now , $coordinator , $other);
     $dbquery_insert->execute();
    $result_insert=$dbquery_insert->get_result();

    // execute it and all...
} else {
    die("Errormessage: ". $connect->error);
}
    //$dbquery = mysqli_query($connect,$sql_insert);
}

//ส่วนแสดงผล
if(!(($getindex==1) or ($getindex==2) or ($getindex==11))){

//ส่วนของการแยกหน้า
if($room_index>=1){
$sql_meeting="select id from meeting_main  where room=$room_index ";
}
else{
$sql_meeting="select id from meeting_main";
}
    $dbquery_meeting = $connect->prepare($sql_meeting);
    //$dbquery_meeting->bind_param("i", $room_index);
    $dbquery_meeting->execute();
    $result_meeting=$dbquery_meeting->get_result();

$num_rows = mysqli_num_rows($result_meeting);

$pagelen=20;  // 1_กำหนดแถวต่อหน้า
$url_link="option=meeting&task=main/meeting&room_index=$room_index";  // 2_กำหนดลิงค์ฺ
$totalpages=ceil($num_rows/$pagelen);

if(!isset($_REQUEST['page'])){
$_REQUEST['page']="";
}

if($_REQUEST['page']==""){
$page=$totalpages;
		if($page<2){
		$page=1;
		}
}
else{
		if($totalpages<$_REQUEST['page']){
		$page=$totalpages;
					if($page<1){
					$page=1;
					}
		}
		else{
		$page=$_REQUEST['page'];
		}
}

$start=($page-1)*$pagelen;

if(($totalpages>1) and ($totalpages<16)){
echo "<div align=center>";
echo "หน้า	";
			for($i=1; $i<=$totalpages; $i++)	{
					if($i==$page){
					echo "[<b><font size=+1 color=#990000>$i</font></b>]";
					}
					else {
					echo "<a href=$PHP_SELF?$url_link&page=$i>[$i]</a>";
					}
			}
echo "</div>";
}
if($totalpages>15){
			if($page <=8){
			$e_page=15;
			$s_page=1;
			}
			if($page>8){
					if($totalpages-$page>=7){
					$e_page=$page+7;
					$s_page=$page-7;
					}
					else{
					$e_page=$totalpages;
					$s_page=$totalpages-15;
					}
			}
			echo "<div align=center>";
			if($page!=1){
			$f_page1=$page-1;
			echo "<<a href=$PHP_SELF?$url_link&page=1>หน้าแรก </a>";
			echo "<<<a href=$PHP_SELF?$url_link&page=$f_page1>หน้าก่อน </a>";
			}
			else {
			echo "หน้า	";
			}
			for($i=$s_page; $i<=$e_page; $i++){
					if($i==$page){
					echo "[<b><font size=+1 color=#990000>$i</font></b>]";
					}
					else {
					echo "<a href=$PHP_SELF?$url_link&page=$i>[$i]</a>";
					}
			}
			if($page<$totalpages)	{
			$f_page2=$page+1;
			echo "<a href=$PHP_SELF?$url_link&page=$f_page2> หน้าถัดไป</a>>>";
			echo "<a href=$PHP_SELF?$url_link&page=$totalpages> หน้าสุดท้าย</a>>";
			}
			echo " <select onchange=\"location.href=this.options[this.selectedIndex].value;\" size=\"1\" name=\"select\">";
			echo "<option  value=\"\">หน้า</option>";
				for($p=1;$p<=$totalpages;$p++){
				echo "<option  value=\"?$url_link&page=$p\">$p</option>";
				}
			echo "</select>";
echo "</div>";
}
//จบแยกหน้า


$sql_room = "select * from meeting_room where active='1' order by id";
    $dbquery_room = $connect->prepare($sql_room);
    //$dbquery_room->bind_param("i", $system_user_department);
    $dbquery_room->execute();
    $result_meetroom=$dbquery_room->get_result();
While ($result_room = mysqli_fetch_array($result_meetroom))
{
$room_ar[$result_room['room_code']]=$result_room['room_name'];
}

if($room_index>=1){
//$sql="select meeting_main.id, meeting_main.room, meeting_main.book_date, meeting_main.start_time, meeting_main.finish_time, meeting_main.objective, meeting_main.person_num, meeting_main.other, meeting_main.book_person, meeting_main.rec_date, meeting_main.approve, meeting_main.reason, person_main.name ,person_main.surname ,meeting_main.coordinator,meeting_main.chairman from meeting_main left join person_main on meeting_main.book_person = person_main.person_id where meeting_main.room='$room_index' order by meeting_main.book_date,meeting_main.room,meeting_main.start_time limit $start,$pagelen";
$sql_join="select meeting_main.*, person_main.* ,meeting_main.id as id ,meeting_main.rec_date as rec_date  from meeting_main left join person_main on meeting_main.book_person = person_main.person_id where meeting_main.room='$room_index' and person_main.department!='$system_user_department' order by meeting_main.book_date_start,meeting_main.room,meeting_main.start_time limit $start,$pagelen";
}
else{
$sql_join="select meeting_main.*, person_main.* ,meeting_main.id as id ,meeting_main.rec_date as rec_date from meeting_main left join person_main on meeting_main.book_person = person_main.person_id where person_main.department!='$system_user_department' order by meeting_main.book_date_start,meeting_main.room,meeting_main.start_time limit $start,$pagelen";
}
    $dbquery_join = $connect->prepare($sql_join);
    //$dbquery_join->bind_param("i", $room_index);
    $dbquery_join->execute();
    $result_joinroom=$dbquery_join->get_result();

//$dbquery = mysqli_query($connect,$sql);

echo  "<table width=95% border=0 align=center class='table table-hover table-bordered table-striped table-condensed'>";
echo "<Tr><Td colspan='7' align='left'><INPUT TYPE='button' name='smb' value='จองห้องประชุมในสำนัก' onclick='location.href=\"?option=meeting&task=main/meeting&index=1&room_index=$room_index\"'>";
echo "&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;";
echo "<INPUT TYPE='button' name='smb' value='จองห้องประชุมต่างสำนัก' onclick='location.href=\"?option=meeting&task=main/meeting&index=11\"'>";
echo "</Td>";

echo "<Td colspan='5' align='right'>";

echo "<form  name='frm1'>";
echo "&nbsp;<Select  name='room_index' size='1'>";
echo  '<option value ="" >ทุกห้องประชุม</option>' ;
    $sql_room = "SELECT *  FROM meeting_room where department=? and active='1' order by room_code";
    $sql_room = $connect->prepare($sql_room);
    $sql_room->bind_param("i", $system_user_department);
    $sql_room->execute();
    $result_showroom=$sql_room->get_result();
		//$dbquery_room = mysqli_query($connect,$sql_room);
				While ($result_room = mysqli_fetch_array($result_showroom ))
				{
						if ($room_index==$result_room ['room_code']){
						echo "<option value=$result_room[room_code]  selected>$result_room[room_name]</option>";
						}
						else{
						echo "<option value=$result_room[room_code]>$result_room[room_name]</option>";
						}
				}
					echo "</select>";
echo "&nbsp;<INPUT TYPE='button' name='smb' value='เลือก' onclick='goto_url2(1)'>";
echo "</form>";

echo "</Td>";
echo "</Tr>";

echo "<Tr bgcolor='#FFCCCC' align='center'><Td width='80'>วันที่เริ่ม</Td><Td width='80'>วันที่สิ้นสุด</Td><Td width='100'>ห้องประชุม</Td><Td  width='60'>ตั้งแต่เวลา</Td><Td width='60'>ถึงเวลา</Td><Td>ประธานการประชุม/วัตถุประสงค์</Td><Td width='200'>อื่น ๆ/ผู้ประสานงาน</Td><Td>วันเวลาจอง</Td><Td width='40'>ลบ</Td><Td width='40'>อนุมัติ</Td><Td>หมายเหตุ</Td></Tr>";

$N=(($page-1)*$pagelen)+1; //*เกี่ยวข้องกับการแยกหน้า
$M=1;

While ($result = mysqli_fetch_array($result_joinroom)){
 		$id= $result['id'];
		$room= $result['room'];
		$start_time=$result['start_time'];
		$start_time=number_format($start_time,2);
		$finish_time=$result['finish_time'];
		$finish_time=number_format($finish_time,2);
		$book_date_start = $result['book_date_start'];
		$book_date_end = $result['book_date_end'];
		$rec_date = $result['rec_date'];
		$name= $result['name'];
		$surname = $result['surname'];
        $coordinator = $result['coordinator'];
		$chairman = $result['chairman'];
		$person_num = $result['person_num'];
		$book_person = $result['book_person'];
		$user_book = $result['user_book'];
		$other = $result['other'];
		$rec_date = $result['rec_date'];

            if(($M%2) == 0)
			$color="#FFFFB";
			else  	$color="#FFFFFF";
echo "<Tr bgcolor='$color'>";
echo "<Td align='left'>";
echo thai_date_3($book_date_start);
echo "</Td>";
echo "<Td align='left'>";
echo thai_date_3($book_date_end);
echo "</Td>";
echo "<Td align='left'>";
if(isset($room_ar[$room])){
echo $room_ar[$room];
}
echo "</Td>";
echo "<Td align='center'>$start_time น.</Td><Td align='center' >$finish_time น.</Td>";
echo "<td>$result[chairman]/$result[objective]</td>";

echo "<td>$result[other]/$result[coordinator]</td>";
echo "<Td>";
echo thai_date_4($rec_date);
//echo $rec_date;

    echo "</Td>";

if($result['book_person']==$user){
echo "<Td align='center'><a href=?option=meeting&task=main/meeting&index=2&id=$id&page=$page&room_index=$room_index><img src=images/drop.png border='0' alt='ลบ'></Td>";
}
else{
echo "<td></td>";
}

if($result['approve']==1){
echo "<Td align='center'><img src=images/yes.png border='0' alt='อนุมัติ'></Td>";
}
else if($result['approve']==2){
echo "<Td align='center'><img src=images/no.png border='0' alt='ไม่อนุมัติ'></Td>";
}
else {
echo "<td></td>";
}

if($result['reason']!=""){
echo "<Td align='left'>$result[reason]</Td>";
}
else{
echo "<td></td>";
}

echo "</Tr>";

$M++;
$N++;  //*เกี่ยวข้องกับการแยกหน้า
}
echo "</Table>";
}

if(!(($getindex==1) or ($getindex==2) or ($getindex==3) or ($getindex==11))) {
echo "<br>";
echo "&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<img src=images/yes.png border='0'> หมายถึง อนุมัติให้ใช้ห้องประชุม&nbsp;&nbsp;<img src=images/no.png border='0'> หมายถึง ไม่อนุมัติให้ใช้ห้องประชุม";
}
?>
    <script src="//getbootstrap.com/2.3.2/assets/js/jquery.js"></script>
    <script src="//getbootstrap.com/2.3.2/assets/js/google-code-prettify/prettify.js"></script>

    <script src="modules/meeting/js/bootstrap-datepicker.js"></script>
       <script src="modules/meeting/js/bootstrap-datepicker.th.js"></script>

    <script id="datepicker"  type="text/javascript">
      function datepicker() {
        $('.datepicker').datepicker({
          format: 'yyyy-mm-dd',
          autoclose : true
          });
      }
    </script>

    <script type="text/javascript">
      $(function(){
        $('pre[data-source]').each(function(){
          var $this = $(this),
            $source = $($this.data('source'));

          var text = [];
          $source.each(function(){
            var $s = $(this);
            if ($s.attr('type') == 'text/javascript'){
              text.push($s.html().replace(/(\n)*/, ''));
            } else {
              text.push($s.clone().wrap('<div>').parent().html()
                .replace(/(\"(?=[[{]))/g,'\'')
                .replace(/\]\"/g,']\'').replace(/\}\"/g,'\'') // javascript not support lookbehind
                .replace(/\&quot\;/g,'"'));
            }
          });

          $this.text(text.join('\n\n').replace(/\t/g, '    '));
        });

        prettyPrint();
        demo();
      });
    </script>


<script>
function goto_url(val){
	if(val==0){
		callfrm("?option=meeting&task=main/meeting");   // page ย้อนกลับ
	}else if(val==1){
		if(frm1.room.value == ""){
			alert("กรุณาเลือกห้องประชุม");
		}else if(frm1.book_date_start.value == ""){
			alert("กรุณาระบุวันเริ่มต้น");
		}else if(frm1.book_date_end.value == ""){
			alert("กรุณาระบุวันที่สิ้นสุด");
		}else if(frm1.start_time.value == ""){
			alert("กรุณาระบุเวลาเริ่มประชุม");
		}else if(frm1.finish_time.value == ""){
			alert("กรุณาระบุเวลาเลิกประชุม");
		}else if(frm1.chairman.value == ""){
			alert("กรุณาระบุประธานการประชุม");
		}else if(frm1.objective.value == ""){
			alert("กรุณาระบุวัตถุประสงค์ของการใช้");
		}else if(frm1.person_num.value == ""){
			alert("กรุณาระบุจำนวนผู้เข้าประชุม");
		}else if(frm1.coordinator.value == ""){
			alert("กรุณาระบุผู้ประสานงานและเบอร์โทรศัพท์");
		}else{
			callfrm("?option=meeting&task=main/meeting");   //page ประมวลผล
		}
	}
}

function goto_url2(val){
callfrm("?option=meeting&task=main/meeting");
}

</script>
<SCRIPT language=JavaScript>
function check_number() {
e_k=event.keyCode
//if (((e_k < 48) || (e_k > 57)) && e_k != 46 ) {
if (e_k != 13 && (e_k < 48) || (e_k > 57)) {
event.returnValue = false;
alert("ต้องเป็นตัวเลขเท่านั้น... \nกรุณาตรวจสอบข้อมูลของท่านอีกครั้ง...");
}
}
</script>
