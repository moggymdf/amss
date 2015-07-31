<script language='javascript'>
//<!–
function printContentDiv(content){
var printReady = document.getElementById(content);
//var txt= 'nn';
var txt= '';

if (document.getElementsByTagName != null){
var txtheadTags = document.getElementsByTagName('head');
if (txtheadTags.length > 0){
var str=txtheadTags[0].innerHTML;
txt += str; // str.replace(/funChkLoad();/ig, ” “);
}
}
//txt += 'nn';
if (printReady != null){
txt += printReady.innerHTML;
}
//txt +='nn';
var printWin = window.open();
printWin.document.open();
printWin.document.write(txt);
printWin.document.close();
printWin.print();
}
// –>
</script>

<div id="lblPrint">

<?php
/** ensure this file is being included by a parent file */

defined( '_VALID_' ) or die( 'Direct Access to this location is not allowed.' );
//if(!($_SESSION['login_status']<=5)){
$login_status=mysqli_real_escape_string($connect,$_SESSION['login_status']);
if(!($login_status<=105 or $result_permission['p1']==1)){	
exit();
}

$thai_month_arr=array(
	"01"=>"มกราคม",
	"02"=>"กุมภาพันธ์",
	"03"=>"มีนาคม",
	"04"=>"เมษายน",
	"05"=>"พฤษภาคม",
	"06"=>"มิถุนายน",	
	"07"=>"กรกฎาคม",
	"08"=>"สิงหาคม",
	"09"=>"กันยายน",
	"10"=>"ตุลาคม",
	"11"=>"พฤศจิกายน",
	"12"=>"ธันวาคม"					
);

//แปลงรูปแบบ date
if(isset($_GET['datepicker'])){
$f1_date=explode("-", $_GET['datepicker']);
$start_date=$f1_date[2]."-".$f1_date[1]."-"."01";
$end_date=$f1_date[2]."-".$f1_date[1]."-"."31";
$thai_month=$thai_month_arr[$f1_date[1]];
$thai_year=$f1_date[2]+543;
$date_input_tag="$thai_month.$thai_year";
}
else{
$f1_date=date("Y-m-d");
$f1_date=explode("-", $f1_date);
$start_date=$f1_date[0]."-".$f1_date[1]."-"."01";
$end_date=$f1_date[0]."-".$f1_date[1]."-"."31";
$thai_month=$thai_month_arr[$f1_date[1]];
$thai_year=$f1_date[0]+543;
$date_input_tag="$thai_month.$thai_year";
}

echo "<br />";
echo "<table width='99%' border='0' align='center'>";
echo "<tr align='center'><td colspan=2><font color='#006666' size='3'><strong>การปฏิบัติราชการเดือน$thai_month พ.ศ.$thai_year</strong></font></td></tr>";

//ถ้าเป็นผู้บริหารให้แสดงผลรายสำนัก
//$showmydepartment="";
//$showmydepartmentwhere ="";
$department_id=mysqli_real_escape_string($connect,$_SESSION['system_user_department']);

?>
	<link rel="stylesheet" type="text/css" media="all" href="./modules/work/css.css">
	<link rel="stylesheet" href="./jquery/themes/ui-lightness/jquery.ui.all.css">
	<script src="./jquery/jquery-1.5.1.js"></script>
	<script src="./jquery/ui/jquery.ui.core.js"></script>
	<script src="./jquery/ui/jquery.ui.widget.js"></script>
	<script src="./jquery/ui/jquery.ui.datepicker.js"></script>
	<script>
	$(function() {
		$( "#datepicker" ).datepicker({
			showButtonPanel: true,
			dateFormat: 'dd-mm-yy',
			changeMonth: true,
			changeYear: true,
			monthNamesShort: ['ม.ค.', 'ก.พ.', 'มี.ค.', 'เม.ย.', 'พ.ค.', 'มิ.ย.', 'ก.ค.', 'ส.ค.', 'ก.ย.', 'ต.ค.', 'พ.ย.', 'ธ.ค.'],
			dayNamesMin: ['อา','จ','อ','พ','พฤ','ศ','ส'],
			onSelect:function(dateText){  document.frmSearchDate.submit();}
		});
	});
	</script>
<tr align='center'>
	<td  align=left>
	</td>
	<td align=right  id=no_print>
<FORM name=frmSearchDate METHOD=GET>
<INPUT TYPE="hidden" name=option value="work">
<INPUT TYPE="hidden" name=task value="report_2">
เลือกเดือนปี <input type="text" id="datepicker" name=datepicker value=<?php echo  $date_input_tag ?>  readonly Size="12">
</FORM>
	</td>
</tr>

<?php
echo "</table>";

//ส่วนรายละเอียด
echo  "<table width='98%' border='0' align='center'>";
echo "<Tr bgcolor='#FFCCCC' align='center'><Td width='50'>ที่</Td>";
echo "<Td>ชื่อ</Td><Td>ตำแหน่ง</Td><Td>มา</Td><Td>ไปราชการ</Td><Td>ลาป่วย</Td><Td>ลากิจ</Td><Td>ลาพักผ่อน</Td><Td>ลาคลอด</Td><Td>ลาอื่นๆ</Td><Td>มาสาย</Td><Td>ไม่มา</Td></Tr>";
//ถ้าเป็นผู้บริหารให้แสดงผลเฉพาะส่วนผู้บริหาร
//แสดงชื่อหน่วยงาน
$login_user_id = mysqli_real_escape_string($connect,$_SESSION['login_user_id']);
$sql= "select position_code,id from person_main where person_id=? ";
    $dbquery_name = $connect->prepare($sql);
    $dbquery_name->bind_param("i", $login_user_id);
    $dbquery_name->execute();
    $result_name=$dbquery_name->get_result();
    while($result_person = $result_name->fetch_array())
	   {
        $result_position_id = $result_person['position_code'];
		$result_person_id = $result_person['id'];
        //$department_id = $department_id;
    }
	//$connect->close();
$N=1;
    $sql_sumworkperson= "select * from person_main where department = ? order by position_code ";
    $dbquery_sumwork = $connect->prepare($sql_sumworkperson);
    $dbquery_sumwork->bind_param("i", $department_id);
    $dbquery_sumwork->execute();
    $result_shownallperson = $dbquery_sumwork->get_result();
    while($result_allperson = $result_shownallperson->fetch_array())
	   {

$work_1_sum=0; $work_2_sum=0; $work_3_sum=0;	$work_4_sum=0;	$work_5_sum=0;	$work_6_sum=0;	$work_7_sum=0;	$work_8_sum=0;	$work_9_sum=0;$work_sum_total=0;		
        
            $person_id = $result_allperson['person_id'];
            $prename=$result_allperson['prename'];
            $name= $result_allperson['name'];
            $surname = $result_allperson['surname'];
            $position_code = $result_allperson['position_code'];
            //$work = $result_allperson['work'];
            $full_name="$prename$name&nbsp;&nbsp;$surname";

            $sql_work = "select work from work_main  where (work_date between ? and ?) and (person_id=?) ";
            $dbquery_work = $connect->prepare($sql_work);
            $dbquery_work->bind_param("sss",$start_date,$end_date,$person_id);
            $dbquery_work->execute();
            $result_daywork = $dbquery_work->get_result();
            
            while($result_work = $result_daywork->fetch_array())
	           {
             $work = $result_work['work'];
  		
			if($work==1){
			$work_1_sum=$work_1_sum+1;
			}
			else if($work==2){
			$work_2_sum=$work_2_sum+1;
			}
			else if($work==3){
			$work_3_sum=$work_3_sum+1;
			}			
			else if($work==4){
			$work_4_sum=$work_4_sum+1;
			}			
			else if($work==5){
			$work_5_sum=$work_5_sum+1;
			}			
			else if($work==6){
			$work_6_sum=$work_6_sum+1;
			}			
			else if($work==7){
			$work_7_sum=$work_7_sum+1;
			}			
			else if($work==8){
			$work_8_sum=$work_8_sum+1;
			}			
			else if($work==9){
			$work_9_sum=$work_9_sum+1;
			}			
        }
 
            if(($N%2) == 0)
			$color="#FFFFC";
			else  $color="#FFFFFF";
       
        
            $sql_post= "select position_name from person_position where position_code=? ";   
            $dbquery_post = $connect->prepare($sql_post);
            $dbquery_post->bind_param("i",$position_code);
            $dbquery_post->execute();
            $result_personpost = $dbquery_post->get_result();
            while($result_post = $result_personpost->fetch_array())
	        {
            $position_name=$result_post['position_name'];
            }


echo "<tr bgcolor='$color'>";
echo "<td align='center'>$N</td><td>";
if(isset($full_name)){
echo "<a href='?option=work&task=report_3&person_id=$person_id&start_date=$start_date&end_date=$end_date' target='_blank'>$full_name</a>";
}
else{
echo "<a href='?option=work&task=report_3&person_id=$person_id&start_date=$start_date&end_date=$end_date' target='_blank'>ไมมีรายชื่อ($person_id)</a>";
}
echo"</td>";
echo "<td>";
	if(isset($position_name)){
	echo $position_name;
	}
echo "</td>";
if($work_1_sum==0){
$work_1_sum="";
}
if($work_2_sum==0){
$work_2_sum="";
}
if($work_3_sum==0){
$work_3_sum="";
}
if($work_4_sum==0){
$work_4_sum="";
}
if($work_5_sum==0){
$work_5_sum="";
}
if($work_6_sum==0){
$work_6_sum="";
}
if($work_7_sum==0){
$work_7_sum="";
}
if($work_8_sum==0){
$work_8_sum="";
}
if($work_9_sum==0){
$work_9_sum="";
}

echo "<td align='center' bgcolor='#CCFFFF'>$work_1_sum</td><td align='center'>$work_2_sum</td><td align='center' bgcolor='#CCFFFF'>$work_3_sum</td><td align='center'>$work_4_sum</td><td align='center' bgcolor='#CCFFFF'>$work_5_sum</td><td align='center'>$work_6_sum</td><td align='center' bgcolor='#CCFFFF'>$work_7_sum</td><td align='center'>$work_8_sum</td><td align='center' bgcolor='#CCFFFF'>$work_9_sum</td>";
echo "</tr>";
$N++;

    }

echo "</table>";
?>

</div>
<br />
<a href="javascript:printContentDiv('lblPrint');"><img src="images/b_print.png" border=0> พิมพ์หน้านี้</a>
