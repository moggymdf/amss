<link rel="stylesheet" href="//netdna.bootstrapcdn.com/bootstrap/3.3.2/css/bootstrap.min.css">
<link rel="stylesheet" href="//netdna.bootstrapcdn.com/font-awesome/3.2.1/css/font-awesome.min.css">
<link href="modules/meeting/css/datepicker.css" rel="stylesheet" media="screen">

<?php
$user=mysqli_real_escape_string($connect,$_SESSION['login_user_id']);
$system_user_department=mysqli_real_escape_string($connect,$_SESSION['system_user_department']);
$system_user_department_name=mysqli_real_escape_string($connect,$_SESSION['system_user_department_name']);

/** ensure this file is being included by a parent file */
defined( '_VALID_' ) or die( 'Direct Access to this location is not allowed.' );
$login_group=mysqli_real_escape_string($connect,$_SESSION['login_group']);
if(!($login_group<=4)){
exit();
}
    //ตรวจสอบสิทธิ์ผู้ใช้
    $sql_permis = "select * from  meeting_permission where person_id=? ";
    $dbquery_permis = $connect->prepare($sql_permis);
    $dbquery_permis->bind_param("i", $user);
    $dbquery_permis->execute();
    $result_qpermis=$dbquery_permis->get_result();
    While ($result_permis = mysqli_fetch_array($result_qpermis))
    {
        $user_permis=$result_permission['p1'];
    }
    if($user_permis!=1){
        exit();
    }

require_once "modules/meeting/time_inc.php";
?>
<script type="text/javascript" src="./css/js/calendarDateInput.js"></script>
<?php


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
echo "<tr align='center'><td><font color='#006666' size='3'><strong>รายการจองห้องประชุมของบุคลากรในสำนัก $system_user_department_name</strong></font><br><br></td></tr>";
echo "</table>";
}


//ส่วนยืนยันการลบข้อมูล

if(isset($_GET['id'])){
$getid=mysqli_real_escape_string($connect,$_GET['id']);
}else {$getid="";}


if($getindex==2) {
echo "<table width='500' border='0' align='center'>";
echo "<tr><td align='center'><font color='#990000' size='4'>โปรดยืนยันความต้องการลบข้อมูลอีกครั้ง</font><br></td></tr>";
echo "<tr><td align=center>";
echo "<INPUT TYPE='button' name='smb' value='ยืนยัน' onclick='location.href=\"?option=meeting&task=main/meeting_dep&index=3&id=$getid&page=$_REQUEST[page]\"'>
		&nbsp;&nbsp;<INPUT TYPE='button' name='back' value='ยกเลิก' onclick='location.href=\"?option=meeting&task=main/meeting_dep&page=$_REQUEST[page]\"'";
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


//ส่วนแสดงผล
if(!(($getindex==1) or ($getindex==2) or ($getindex==11))){

if(isset($_POST['status_index'])){
$poststatus_index=mysqli_real_escape_string($connect,$_POST['status_index']);
    if($poststatus_index!=""){
    $showstatus=" and meeting_main.approve=$poststatus_index ";
    }else{$showstatus="";}
}else {$poststatus_index=""; $showstatus="";}


//ส่วนของการแยกหน้า
//$sql_meeting="select id from meeting_main where user_book=? ";
$sql_joinroom="select meeting_main.*, person_main.* ,meeting_main.id as id ,meeting_main.rec_date as rec_date from meeting_main left join person_main on meeting_main.book_person = person_main.person_id where person_main.department=? $showstatus order by meeting_main.book_date_start desc,meeting_main.room,meeting_main.start_time ";

    $dbquery_joinroom = $connect->prepare($sql_joinroom);
    $dbquery_joinroom->bind_param("i", $system_user_department);
    $dbquery_joinroom->execute();
    $result_joinroomnum=$dbquery_joinroom->get_result();

$num_rows = mysqli_num_rows($result_joinroomnum);

$pagelen=20;  // 1_กำหนดแถวต่อหน้า
$url_link="option=meeting&task=main/meeting_dep";  // 2_กำหนดลิงค์ฺ
$totalpages=ceil($num_rows/$pagelen);

if(!isset($_REQUEST['page'])){
$_REQUEST['page']="";
}

if($_REQUEST['page']==""){
$page=$totalpages;
		if($page<2){
		$page=1;
		}
$start=0;

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
    $start=($page-1)*$pagelen;
}

//$start=($page-1)*$pagelen;

if(($totalpages>1) and ($totalpages<16)){
echo "<div align=center>";
echo "หน้า	";
			for($i=1; $i<=$totalpages; $i++)	{
                if($start==0){$page=1;}
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

$sql_join="select meeting_main.*, person_main.* ,meeting_main.id as id ,meeting_main.rec_date as rec_date from meeting_main left join person_main on meeting_main.book_person = person_main.person_id where person_main.department=? $showstatus order by meeting_main.book_date_start desc,meeting_main.room,meeting_main.start_time limit $start,$pagelen";

    $dbquery_join = $connect->prepare($sql_join);
    $dbquery_join->bind_param("i", $system_user_department);
    $dbquery_join->execute();
    $result_joinroom=$dbquery_join->get_result();

//$dbquery = mysqli_query($connect,$sql);

echo  "<table width=95% border=0 align=center class='table table-hover table-bordered table-striped table-condensed'>";
//echo "<Tr><Td colspan='13' align='left'><table width='100%'><tr><td align='left'><INPUT TYPE='button' name='smb' class='btn btn-success' value='จองห้องประชุมในสำนัก' onclick='location.href=\"?option=meeting&task=main/meeting&index=1\"'>";
//echo "&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;";
//echo "<INPUT TYPE='button' name='smb' class='btn btn-danger' value='จองห้องประชุมต่างสำนัก' onclick='location.href=\"?option=meeting&task=main/meeting&index=11\"'>";

echo "<Tr><Td colspan='13' align='left'><table width='100%'><tr><td align='left'>";
echo "</Td><td align='right'>";

//เพิ่มการเลือกสถานะ
echo "<form  name='frm1'>";

echo "&nbsp;<Select  name='status_index' size='1'>";
echo "<option value ='' >ทุกสถานะ</option>" ;
echo "<option value ='0' >รอการอนุมัติ</option>" ;
echo "<option value ='1' >อนุมัติแล้ว</option>" ;
echo "<option value ='2' >ไม่อนุมัติ</option>" ;
echo "</select>";
echo "&nbsp;<INPUT TYPE='button' name='smb' class='btn btn-info' value='เลือก'  onclick='goto_url2(1)'>";
echo "</form>";


echo "</td></tr></table>";

echo "</td></Tr>";

echo "<Tr class='success' align='center'><Td width='80'>วันที่เริ่ม</Td><Td width='80'>วันที่สิ้นสุด</Td><Td width='100'>ห้องประชุม</Td><Td  width='60'>ตั้งแต่เวลา</Td><Td width='60'>ถึงเวลา</Td><Td>ประธานการประชุม/วัตถุประสงค์</Td><Td width='200'>อื่น ๆ/ผู้ประสานงาน</Td><Td>ผู้จอง(วันเวลา)</Td><Td width='40'>ลบ</Td><Td width='40'>อนุมัติ</Td><Td>หมายเหตุ</Td></Tr>";

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

    $sql_room = "select * from meeting_room where room_code=? ";
    $dbquery_room = $connect->prepare($sql_room);
    $dbquery_room->bind_param("i", $room);
    $dbquery_room->execute();
    $result_meetroom=$dbquery_room->get_result();
    While ($result_room = mysqli_fetch_array($result_meetroom))
    {
        $room_name=$result_room['room_name'];
    }
            //if(($M%2) == 0)
			$color="";
			//else  	$color="#FFFFFF";
echo "<Tr bgcolor='$color'>";
echo "<Td align='left'>";
echo thai_date_3($book_date_start);
echo "</Td>";
echo "<Td align='left'>";
echo thai_date_3($book_date_end);
echo "</Td>";
echo "<Td align='left'>";
echo $room_name;
echo "</Td>";
echo "<Td align='center'>$start_time น.</Td><Td align='center' >$finish_time น.</Td>";
echo "<td>$result[chairman]/$result[objective]</td>";

echo "<td>$result[other]/$result[coordinator]</td>";
echo "<Td>$name $surname (";
echo thai_date_4($rec_date);
//echo $rec_date;

    echo ")</Td>";

if($user_permis==1){
echo "<Td align='center'><a href=?option=meeting&task=main/meeting_dep&index=2&id=$id&page=$page><img src=images/drop.png border='0' alt='ลบ'></Td>";
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
		}else if(frm1.book_date_start.value > frm1.book_date_end.value){
			alert("วันที่เริ่มต้นมากกว่าวันที่สิ้นสุด กรุณาเลือกวันที่ใหม่");
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
