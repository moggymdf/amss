
<?php
/** ensure this file is being included by a parent file */
defined( '_VALID_' ) or die( 'Direct Access to this location is not allowed.' );
//sd page
$rec_date = date("Y-m-d");
$officer=$_SESSION['login_user_id'];

if($_FILES){

		if($_FILES['userfile']['name']==""){
				?> <script>
				alert("กรุณาเลือกไฟล์ด้วย ค่ะ");
				document.location.href="?option=achievement&task=main/test_import";
				</script>
				<?php
		exit();
		}

// ตรวจสอบว่าเป็น csv file หรือไม่
$uploaddir ="modules/achievement/upload_files/";     //ที่เก็บไฟล์
$uploadfile = $uploaddir.basename($_FILES['userfile']['name']);
$basename = basename($_FILES['userfile']['name']);

		//ลบไฟล์เดิม
		if(file_exists($uploadfile)){
		unlink($uploadfile);
		}

$surname = explode(".", $_FILES['userfile']['name']);
$school_code=explode("_",$surname[0]);
$file_name = explode("_", $_FILES['userfile']['name']);
		//ตรวจสอบนามสกุล
		if($surname[1]!="csv"){
			unlink($_FILES['userfile']['tmp_name']);
				?> <script>
				alert("ไม่ใช่ ไฟล์ประเภท CSV กรุณาอ่านคำอธิบายอีกครั้ง");
				document.location.href="?option=achievement&task=main/test_import";
				</script>
				<?php
			exit();
		}

		if (move_uploaded_file($_FILES['userfile']['tmp_name'],$uploadfile)){
		$changed_name=$uploaddir.$basename;
		rename("$uploadfile" , "$changed_name");

		////ส่วนอ่านไฟล์และบันทึก
				$objCSV = fopen("$changed_name", "r");
				while (($objArr = fgetcsv($objCSV, 1000, ",")) !== FALSE) {
				$test_index[]=$objArr[0];
				$class_index[]=$objArr[1];
				$edyear_index[]=$objArr[2];
								$sql_find = "select * from  achievement_main  where  test_type='$objArr[0]' and  test_class='$objArr[1]' and ed_year='$objArr[2]' and school='$objArr[3]'  ";
								$dbquery_find = mysqli_query($connect,$sql_find);
								$num_row=mysqli_num_rows($dbquery_find);
								if($num_row>=1){
								$sql_del = "delete from  achievement_main  where  test_type='$objArr[0]' and  test_class='$objArr[1]' and ed_year='$objArr[2]' and school='$objArr[3]'  ";
								$dbquery_del = mysqli_query($connect,$sql_del);
								}
				$sql = "insert into achievement_main (test_type,test_class,ed_year,school,thai,math,science,social,english,health,art,vocation,score_avg,officer,rec_date";
				$sql  .=")";
				$sql  .=" values ('$objArr[0]','$objArr[1]','$objArr[2]','$objArr[3]','$objArr[4]','$objArr[5]','$objArr[6]','$objArr[7]','$objArr[8]','$objArr[9]','$objArr[10]','$objArr[11]','$objArr[12]','$officer','$rec_date' ";
			$sql  .=")";
				$dbquery = mysqli_query($connect,$sql);
				}
				fclose($objCSV);
		////end

		}
		else{
		echo  "<br><strong><font color=#990000 size=3>ไม่สามารถอัพโหลดได้</font></strong>";
		exit();
		}
		if($test_index[0]==1){
		echo "<script>document.location.href='?option=achievement&task=main/add_score_1&index=1&ed_year=$edyear_index[0]&test_class=$class_index[0]';</script>\n";
		}
		else if($test_index[0]==2){
		echo "<script>document.location.href='?option=achievement&task=main/add_score_2&index=1&ed_year=$edyear_index[0]&test_class=$class_index[0]';</script>\n";
		}
		else if($test_index[0]==3){
		echo "<script>document.location.href='?option=achievement&task=main/add_score_3&index=1&ed_year=$edyear_index[0]&test_class=$class_index[0]';</script>\n";
		}
}
else{
uploadfile();
}

//ส่วนของform
function uploadfile () {
echo  "<form name ='frm1' Enctype = 'multipart/form-data'>";
echo  "<br>";
echo  "<table align='center' width='50%' border='0'>";
echo  "<tr>";
echo  "<td align='right'><strong><font color='#003366' size='2'>ไฟล์เอกสาร</font></strong></td>";
echo  "<td align='left'><input name = 'userfile'  type = 'file'><font color='#003366' size='2'></font></td>";
echo  "</tr>";
echo  "<tr><td></td><td></td></tr> ";
echo  "<tr> ";
echo  "<td></td><td align = 'left'><INPUT TYPE='button' name='smb' value='ตกลง' onclick='upload(1)' class='entrybutton'></td>";
echo   "</tr>";
echo   "</table>";

echo "<br /><br /><br />";
echo  "<table width=70% border=0 align=center>";
echo "<Tr><Td align='left'><strong>คำอธิบาย</strong></Td></Tr>";
echo "<Tr><Td align='left'>1. ข้อมูลที่จะนำเข้าเป็นไฟล์ประเภท CSV ซึ่งได้จากการแปลงไฟล์ EXCEL </Td></Tr>";
echo "<Tr><Td align='left'>2.  ไฟล์ที่จะนำเข้าต้องไม่มีหัวสดมภ์ </Td></Tr>";
echo "<Tr><Td align='left'>3.  สดมภ์ที่ 1 เป็นรหัสประเภทข้อสอบ  โดยให้ข้อสอบ O-NET มีรหัสเท่ากับ 1  ข้อสอบ NT มีรหัสเท่ากับ 2 ข้อสอบ LAS มีรหัสเท่ากับ 3 </Td></Tr>";
echo "<Tr><Td align='left'>4.  สดมภ์ที่ 2 เป็นรหัสชั้นเริ่มที่ ป1=1 จนถึง ม.6 เท่ากับ 12 </Td></Tr>";
echo "<Tr><Td align='left'>5.  สดมภ์ที่ 3 เป็นปีการศึกษา   สดมภ์ที่ 4 เป็นรหัสโรงเรียน</Td></Tr>";
echo "<Tr><Td align='left'>6.  สดมภ์ที่ 5-13  เป็นค่าคะแนน ลำดับดังนี้ ภาษาไทย สังคม อังกฤษ คณิต วิทย์ สุขศึกษา ศิลปะ การงาน และคะแนนเฉลี่ยทั้ง8กลุ่มสาระ</Td></Tr>";
echo "<Tr><Td align='left'>7.  กรณีเป็น NT สดมภ์ที่ 5-7  เป็นค่าคะแนน ลำดับดังนี้ ความสามารถด้านภาษา ความสามารถด้านคำนวณ ความสามารถด้านเหตุผล  สดมภ์ที่ 13  เป็นคะแนนเฉลี่ย</Td></Tr>";
echo "<Tr><Td align='left'>8.  ตัวอย่างไฟล์ Download ได้ที่เมนูคู่มือ</Td></Tr>";
echo "</Table>";
}

?>
<script>
function upload(val){
	if(val==1){
		callfrm("?option=achievement&task=main/test_import");
		}
}
</script>

