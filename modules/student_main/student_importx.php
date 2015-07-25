
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
				document.location.href="?option=student_main&task=student_import";
				</script>
				<?php
		exit();
		}

// ตรวจสอบว่าเป็น csv file หรือไม่
$uploaddir ="modules/student_main/upload/";     //ที่เก็บไฟล์
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
				document.location.href="?option=student_main&task=student_import";
				</script>
				<?php
			exit();
		}
		//ตรวจสอบชื่อไฟล์
		if($file_name[0]!="student"){
			unlink($_FILES['userfile']['tmp_name']);
				?> <script>
				alert("ไม่ใช่ ไฟล์ student กรุณาอ่านคำอธิบายอีกครั้ง");
				document.location.href="?option=student_main&task=student_import";
				</script>
				<?php
		exit();
		}

//ส่วนตรวจสอบไฟล์ของสถานศึกษา
if($_SESSION['login_status']>=12){
		if($surname[0]!="student_"."$_SESSION[user_school]"){
			unlink($_FILES['userfile']['tmp_name']);
				?> <script>
				alert("ไม่ใช่ไฟล์ student ของโรงเรียนนี้ ไม่อนุญาตให้นำเข้า");
				document.location.href="?option=student_main&task=student_import";
				</script>
				<?php
			exit();
		}
}
//end ส่วนสถานศึกษา

		if (move_uploaded_file($_FILES['userfile']['tmp_name'],$uploadfile)){
		$changed_name=$uploaddir.$basename;
		rename("$uploadfile" , "$changed_name");

		////ส่วนอ่านไฟล์และบันทึก
				$objCSV = fopen("$changed_name", "r");
				while (($objArr = fgetcsv($objCSV, 1000, ",")) !== FALSE) {
								$sql_find = "select oid from  student_main_register  where  oid='$objArr[0]'  ";
								$dbquery_find = mysqli_query($connect,$sql_find);
								$num_row=mysqli_num_rows($dbquery_find);
								if($num_row>=1){
								$sql_del = "delete from student_main_register  where  oid='$objArr[0]' ";
								$dbquery_del = mysqli_query($connect,$sql_del);
								}
				$sql = "insert into student_main_register (oid,schoolid,EDUCATIONYEAR,CLASSLEVELID,IDENTIFICATIONNO,STUDENTID,";
				$sql  .="TITLEID,FIRSTNAME,SURNAME,BIRTHDATE,GENDER,NATIONID,EMAIL,HOMEID,HOMENO,MOO,STREET,";
				$sql  .="POSTCODE,TELEPHONE,PSMOO,PSSTREET,PSPOSTCODE,PSTELEPHONE,TRANSDATE,CLASSROOM,";
				$sql  .="BLOOD,BIRTHPROVINCEID,transcode,marriageid,pstumbolid,psaumphurid,psprovinceid,brotherman1,brotherman2,";
				$sql  .="sistergirl1,sistergirl2,childno,pshomeid,pshomeno,tumbolid,aumphurid,provinceid,RACEID,RELIGIONID,oldschool,";
				$sql  .="tempoid,schoolold,provinceold,languagespeak,speakother,lastupdated,FIRSTNAME_E,SURNAME_E,";
				$sql  .="rec_date,officer";
				$sql  .=")";
				$sql  .=" values ('$objArr[0]','$objArr[1]','$objArr[2]','$objArr[3]','$objArr[4]','$objArr[5]','$objArr[6]','$objArr[7]','$objArr[8]',";
				$sql  .="'$objArr[9]','$objArr[10]','$objArr[11]','$objArr[12]','$objArr[13]','$objArr[14]','$objArr[15]',";
				$sql  .="'$objArr[16]','$objArr[17]','$objArr[18]','$objArr[19]','$objArr[20]','$objArr[21]','$objArr[22]','$objArr[23]','$objArr[24]','$objArr[25]',";
				$sql  .="'$objArr[26]','$objArr[27]','$objArr[28]','$objArr[29]','$objArr[30]','$objArr[31]','$objArr[32]','$objArr[33]','$objArr[34]','$objArr[35]',";
				$sql  .="'$objArr[36]','$objArr[37]','$objArr[38]','$objArr[39]','$objArr[40]','$objArr[41]','$objArr[42]','$objArr[43]','$objArr[44]','$objArr[45]',";
				$sql  .="'$objArr[46]','$objArr[47]','$objArr[48]','$objArr[49]','$objArr[50]','$objArr[51]','$objArr[52]',";
				$sql  .="'$rec_date','$officer'";
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
	 	?> <script>
		document.location.href="?option=student_main&task=student_report1&school_index=<?php echo $school_code[1]?>";
		</script> <?php
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
echo "<Tr><Td align='left'>1. ข้อมูลที่จะนำเข้าเป็นข้อมูลที่ออกจาก Data Management Center </Td></Tr>";
echo "<Tr><Td align='left'>2.  นำเข้าไฟล์ชื่อ student_xxxxxxxx.csv (xxxxxxxx หมายถึงรหัสโรงเรียน) </Td></Tr>";
echo "</Table>";
}

?>
<script>
function upload(val){
	if(val==1){
		callfrm("?option=student_main&task=student_import");
		}
}
</script>

