<?php
/** ensure this file is being included by a parent file */
defined( '_VALID_' ) or die( 'Direct Access to this location is not allowed.' );

?>
<script type="text/javascript" src="jquery/jquery-1.5.1.js"></script>
<script type="text/javascript">

$(function(){
	$("select#khet_code").change(function(){
		var datalist2 = $.ajax({	// รับค่าจาก ajax เก็บไว้ที่ตัวแปร datalist2
			  url: "modules/book/return_permission_sch_khet.php", // ไฟล์สำหรับการกำหนดเงื่อนไข
			  data:"khet_code="+$(this).val(), // ส่งตัวแปร GET ชื่อ khet_code ให้มีค่าเท่ากับ ค่าของ khet_code
			  async: false
		}).responseText;
		$("select#person_id").html(datalist2); // นำค่า datalist2 มาแสดงใน listbox ที่ 2 ที่ชื่อ person_id
		// ชื่อตัวแปร และ element ต่างๆ สามารถเปลี่ยนไปตามการกำหนด
	});
});
</script>

<?php

//อาเรย์ชื่อเขต
$sql = "select  * from  system_khet ";
$dbquery = mysqli_query($connect,$sql);
While ($result = mysqli_fetch_array($dbquery))
   {
		$khet_code = $result['khet_code'];
		$khet_ar[$khet_code]= $result['khet_precis'];
	}

//ส่วนหัว
echo "<br />";
if(!(($index==1) or ($index==2) or ($index==5))){
echo "<table width='50%' border='0' align='center'>";
echo "<tr align='center'><td><font color='#006666' size='3'><strong>สารบรรณ  สพท.</strong></font></td></tr>";
echo "</table>";
}

//ส่วนฟอร์มรับข้อมูล
if($index==1){
echo "<form id='frm1' name='frm1'>";
echo "<Center>";
echo "<Font color='#006666' Size=3><B>เพิ่มเจ้าหน้าที่งานสารบรรณ  สพท.</Font>";
echo "</Cener>";
echo "<Br><Br>";
//echo "<Table width='80%' Border='0'>";
echo "<div align='center'><table width='40%'><tr><td>";
echo "<table class='table table-bordered' width='100%' style='background-color:rgba(255,255,255,0.9)'>";

echo "<Tr align='left'><Td align='right'>  สพท.&nbsp;</Td><Td>";
echo "<Select  name='khet_code'  id='khet_code' size='1'>";
echo  "<option  value = ''>เลือก</option>" ;

$sql = "select * from  system_khet  order by khet_type,khet_code";
$dbquery = mysqli_query($connect,$sql);
While ($khet_result = mysqli_fetch_array($dbquery)){
echo  "<option  value ='$khet_result[khet_code]'>$khet_result[khet_code] $khet_result[khet_precis]</option>" ;
}
echo "</select>";
echo "</Td></Tr>";

echo "<Tr align='left'><Td align='right'>บุคลากร&nbsp;&nbsp;</Td><td align='left'>";
echo "<Select  name='person_id'  id='person_id' size='1' >";
echo  "<option  value = ''>เลือก  สพท.ก่อน</option>" ;
echo "</select>";
echo "</td></tr>";

//echo "<tr><td></td><td></td></tr>";
echo "<tr><td align='center' colspan='2'><INPUT TYPE='button' name='smb' value='ตกลง' onclick='goto_url(1)' class=entrybutton>
	&nbsp;&nbsp;";
echo "<INPUT TYPE='button' name='back' value='ย้อนกลับ' onclick='goto_url(0)' class=entrybutton'></td></tr>";
echo "</Table>";
echo "</td></tr></table>";

echo "</form>";
}

//ส่วนยืนยันการลบข้อมูล
if($index==2) {
echo "<table width='500' border='0' align='center'>";
echo "<tr><td align='center'><font color='#990000' size='4'>โปรดยืนยันความต้องการลบข้อมูลอีกครั้ง</font><br></td></tr>";
echo "<tr><td align=center>";
echo "<INPUT TYPE='button' name='smb' value='ยืนยัน' onclick='location.href=\"?option=book&task=permission_sch_khet&index=3&id=$_GET[id]&page=$_REQUEST[page]\"'>
		&nbsp;&nbsp;<INPUT TYPE='button' name='back' value='ยกเลิก' onclick='location.href=\"?option=book&task=permission_sch_khet&page=$_REQUEST[page]\"'";
echo "</td></tr></table>";
}

//ส่วนลบข้อมูล
if($index==3){
$sql = "delete from book_permission where id=$_GET[id]";
$dbquery = mysqli_query($connect,$sql);
}

//ส่วนบันทึกข้อมูล
if($index==4){
$rec_date = date("Y-m-d");
$sql = "insert into book_permission (person_id, p3, officer,rec_date) values ('$_POST[person_id]', '$_POST[khet_code]', '$_SESSION[login_user_id]','$rec_date')";
$dbquery = mysqli_query($connect,$sql);
}

//ส่วนฟอร์มแก้ไขข้อมูล
if ($index==5){
echo "<form id='frm1' name='frm1'>";
echo "<Center>";
echo "<Font color='#006666' Size=3><B>แก้ไข เจ้าหน้าที่</B></Font>";
echo "</Cener>";
echo "<Br><Br>";
//echo "<Table width='90%' Border= '0' >";

echo "<div align='center'><table width='40%'><tr><td>";
echo "<table class='table table-bordered' width='100%' style='background-color:rgba(255,255,255,0.9)'>";


$sql = "select * from book_permission where id='$_GET[id]'";
$dbquery = mysqli_query($connect,$sql);
$ref_result = mysqli_fetch_array($dbquery);
echo "<Tr align='left'><Td align='right'>  สพท.&nbsp;</Td><Td>";
echo "<Select  name='khet_code'  id='khet_code' size='1'>";
echo  "<option  value = ''>- - - - เลือก - - - -</option>" ;
$sql = "select * from  system_khet  order by khet_type,khet_code";
$dbquery = mysqli_query($connect,$sql);
While ($khet_result = mysqli_fetch_array($dbquery)){
			if($khet_result['khet_code']==$ref_result['p3']){
			echo  "<option  value ='$khet_result[khet_code]' selected>$khet_result[khet_code] $khet_result[khet_precis]</option>" ;
			}
			else{
			echo  "<option  value ='$khet_result[khet_code]'>$khet_result[khet_code] $khet_result[khet_precis]</option>" ;
			}
}
echo "</select>";
echo "</Td></Tr>";
echo "<Tr><Td align='right'>บุคลากร&nbsp;&nbsp;</Td>";
//echo "$khet_result[khet_code]";
echo "<td align='left'><Select  name='person_id'  id='person_id'  size='1'>";
echo  "<option  value = ''>- - - - เลือก - - - -</option>" ;
$khet_id=$khet_result[khet_code];
//$sql = "select  * from person_khet_main where status='0'  and khet_code='$khet_id' order by name";
$sql = "select  * from person_khet_main where status='0'  and khet_code='$ref_result[p3]' order by position_code,name";
$dbquery = mysqli_query($connect,$sql);
while($result = mysqli_fetch_array($dbquery)){
		$person_id = $result['person_id'];
		$name = $result['name'];
		$surname = $result['surname'];
			if($person_id==$ref_result['person_id']){
			echo  "<option value = $person_id selected>$name $surname</option>";
			}
			else{
			echo  "<option value = $person_id>$name $surname</option>";
			}
}
$sql = "select * from  person_sch_other left join person_sch_main on person_sch_other.person_id=person_sch_main.person_id where person_sch_main.status='0' and person_sch_other.status='0' and person_sch_other.khet_code='$ref_result[p3]' order by position_code,name";
$query = mysqli_query($connect,$sql);
while($result = mysqli_fetch_array($query)){
	$person_id = $result['person_id'];
	$prename = $result['prename'];
	$name = $result['name'];
	$surname = $result['surname'];
			if($person_id==$ref_result['person_id']){
			echo  "<option value = $person_id selected>$name $surname</option>";
			}
			else{
			echo  "<option value = $person_id>$name $surname</option>";
			}
}
echo "</select>";
echo "</td></tr>";

//echo "<tr><td></td><td></td></tr>";
echo "<tr><td align='center' colspan='2'><INPUT TYPE='button' name='smb' value='ตกลง' onclick='goto_url_update(1)' class=entrybutton>&nbsp;&nbsp;";
echo "<INPUT TYPE='button' name='back' value='ย้อนกลับ' onclick='goto_url_update(0)' class=entrybutton'></td></tr>";
echo "</Table>";
echo "</td></tr></table>";

echo "<Br>";
echo "<Input Type=Hidden Name='id' Value='$_GET[id]'>";
echo "<Input Type=Hidden Name='page' Value='$_GET[page]'>";
echo "</form>";
}

//ส่วนปรับปรุงข้อมูล
if ($index==6){
$rec_date = date("Y-m-d");
$sql = "update book_permission set  person_id='$_POST[person_id]', p3='$_POST[khet_code]',  officer='$_SESSION[login_user_id]', rec_date='$rec_date' where id='$_POST[id]'";
$dbquery = mysqli_query($connect,$sql);
}

//ส่วนแสดงผล
if(!(($index==1) or ($index==2) or ($index==5))){

//ส่วนของการแยกหน้า
$pagelen=20;  // 1_กำหนดแถวต่อหน้า
$url_link="option=book&task=permission_sch_khet";  // 2_กำหนดลิงค์ฺ
$sql = "select  id  from book_permission where book_permission.p3!=''";
$dbquery = mysqli_query($connect,$sql);
$num_rows=mysqli_num_rows($dbquery);
$totalpages=ceil($num_rows/$pagelen);
//
if(!isset($_REQUEST['page'])){
$_REQUEST['page']="";
}
//
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

$sql = "select book_permission.id,  book_permission.officer, person_khet_main.prename, person_khet_main.name, person_khet_main.surname, book_permission.p3 from book_permission left join person_khet_main on book_permission.person_id=person_khet_main.person_id  where book_permission.p3!='' order by book_permission.id  limit $start,$pagelen";
$dbquery = mysqli_query($connect,$sql);
//echo  "<table width=70% border=0 align=center>";
echo "<div align='center'><table width='70%'><tr><td>";
echo "<table class='table table-bordered' width='100%' style='background-color:rgba(255,255,255,0.9)'>";

echo "<Tr><Td colspan='6' align='left'><INPUT TYPE='button' name='smb' value='เพิ่มเจ้าหน้าที่' onclick='location.href=\"?option=book&task=permission_sch_khet&index=1\"'</Td></Tr>";

echo "<Tr bgcolor='#FFCCCC'><Td  align='center'>ที่</Td><Td  align='center'>สพท.</Td><Td  align='center'>ชื่อเจ้าหน้าที่</Td><Td align='center' width='180'>ผู้กำหนดเจ้าหน้าที่</Td><Td align='center' width='50'>ลบ</Td><Td align='center'  width='50'>แก้ไข</Td></Tr>";
$N=(($page-1)*$pagelen)+1;  //*เกี่ยวข้องกับการแยกหน้า
$M=1;
While ($result = mysqli_fetch_array($dbquery))
	{
		$id = $result['id'];
		$p3 = $result['p3'];
		$prename = $result['prename'];
		$name = $result['name'];
		$surname = $result['surname'];
		$rec_person = $result['officer'];
					///////////////////
					$person_level=0;
					$sql_person = "select  * from person_main  where person_id='$rec_person'";
					$dbquery_person = mysqli_query($connect,$sql_person);
					if($result_person = mysqli_fetch_array($dbquery_person)){
					$person_level=1;  //สพฐ.
					}
					else{
					$sql_person = "select  * from person_khet_main  where person_id='$rec_person'";
					$dbquery_person = mysqli_query($connect,$sql_person);
					$result_person = mysqli_fetch_array($dbquery_person);
					$person_level=2;   //สพท.
					}
					////////////////////

			if(($M%2) == 0)
			$color="#FFFFC";
			else  	$color="#FFFFFF";
		echo "<Tr bgcolor=$color><Td align='center' width='50'>$N</Td><Td  align='left'>$p3 $khet_ar[$p3]</Td><Td  align='left'>$prename$name $surname</Td><td>$result_person[prename]$result_person[name] $result_person[surname]</td>";
		if($person_level==1){
		echo "<Td align='center' width='50' ><a href=?option=book&task=permission_sch_khet&index=2&id=$id&page=$page><img src=images/drop.png border='0' alt='ลบ'></a></Td>
		<Td align='center' width='50'><a href=?option=book&task=permission_sch_khet&index=5&id=$id&page=$page><img src=images/edit.png border='0' alt='แก้ไข'></a></Td>";
		}
		else{
		echo "<td></td><td></td>";
		}
		echo "</Tr>";
$M++;
$N++;  //*เกี่ยวข้องกับการแยกหน้า
	}
echo "</Table>";
echo "</td></tr></table>";

}

?>
<script>
function goto_url(val){
	if(val==0){
		callfrm("?option=book&task=permission_sch_khet");   // page ย้อนกลับ
	}else if(val==1){
		if(frm1.khet_code.value == ""){
			alert("กรุณาเลือก  สพท.");
		}else if(frm1.person_id.value == ""){
			alert("กรุณาเลือกบุคลากร");
		}else{
			callfrm("?option=book&task=permission_sch_khet&index=4");   //page ประมวลผล
		}
	}
}

function goto_url_update(val){
	if(val==0){
		callfrm("?option=book&task=permission_sch_khet");   // page ย้อนกลับ
	}else if(val==1){
		if(frm1.khet_code.value == ""){
			alert("กรุณาเลือก  สพท.");
		}else if(frm1.person_id.value == ""){
			alert("กรุณาเลือกบุคลากร");
		}else{
			callfrm("?option=book&task=permission_sch_khet&index=6");   //page ประมวลผล
		}
	}
}
</script>
