
<?php
/** ensure this file is being included by a parent file */
defined( '_VALID_' ) or die( 'Direct Access to this location is not allowed.' );
//sd page
$rec_date = date("Y-m-d");
$officer=$_SESSION['login_user_id'];

//ปีงบประมาณ
$sql = "select * from  student_main_edyear  where year_active='1' order by  ed_year desc limit 1";
$dbquery = mysqli_query($connect,$sql);
$year_active_result = mysqli_fetch_array($dbquery);
if($year_active_result['ed_year']==""){
echo "<br />";
echo "<div align='center'>ยังไม่ได้กำหนดทำงานในปีการศึกษาใด ๆ  กรุณาไปที่เมนูตั้งค่าระบบ เพื่อกำหนดปีการศึกษา</div>";
exit();
}

if($_FILES){

		if($_FILES['userfile']['name']==""){
				?> <script>
				alert("กรุณาเลือกไฟล์ด้วย ค่ะ");
				document.location.href="?option=student_main&task=student_import_2";
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
				document.location.href="?option=student_main&task=student_import_2";
				</script>
				<?php
			uploadfile();
			exit();
		}
		//ตรวจสอบชื่อไฟล์
		if($file_name[0]!="studentmis"){
			unlink($_FILES['userfile']['tmp_name']);
				?> <script>
				alert("ไม่ใช่ ไฟล์ studentmis กรุณาอ่านคำอธิบายอีกครั้ง");
				document.location.href="?option=student_main&task=student_import_2";
				</script>
				<?php
			uploadfile();
			exit();
		}

//ส่วนตรวจสอบไฟล์ของสถานศึกษา
if($_SESSION['login_status']>=12){
		if($surname[0]!="studentmis_"."$_SESSION[user_school]"){
			unlink($_FILES['userfile']['tmp_name']);
				?> <script>
				alert("ไม่ใช่ไฟล์ studentmis ของโรงเรียนนี้ ไม่อนุญาตให้นำเข้า");
				document.location.href="?option=student_main&task=student_import_2";
				</script>
				<?php
			uploadfile();
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
				if($objArr[2]==$year_active_result[ed_year]){
								$sql_find = "select STUDENTOID from  student_main_inf  where STUDENTOID='$objArr[0]' and EDUCATIONYEAR='$objArr[2]' ";
								$dbquery_find = mysqli_query($connect,$sql_find);
								$num_row=mysqli_num_rows($dbquery_find);
								if($num_row>=1){
								$sql_del = "delete from student_main_inf  where STUDENTOID='$objArr[0]' and EDUCATIONYEAR='$objArr[2]' ";
								$dbquery_del = mysqli_query($connect,$sql_del);
								}
				$sql = "insert into student_main_inf (STUDENTOID,SCHOOLID,EDUCATIONYEAR,CLASSLEVEL,CLASSROOM,CLASSADJUST,";
				$sql  .="STUDENTSTATUSID,HOMELESS,JOURNEYTYPEID,CHARACTERDESIRABLE,READTHINKWRITE,NUTRITIONSTATUS,SUPPORTQTY,ROCKDTKM,ROCKDTM,RUBBERDTKM,";
				$sql  .="RUBBERDTM,WATERDTKM,WATERDTM,OCCASIONID,POORUNIFORM,POORSTATIONERY,POORBOOK,POORFOOD,";
				$sql  .="HOMELESSTYPE,operated,lastupdated,oidold,graduate,learnnext,learnstatus,showing,TIMEIDT,graduate_date,";
				$sql  .="rec_date,officer";
				$sql  .=")";
				$sql  .=" values ('$objArr[0]','$objArr[1]','$objArr[2]','$objArr[3]','$objArr[4]','$objArr[5]','$objArr[6]','$objArr[7]','$objArr[8]',";
				$sql  .="'$objArr[9]','$objArr[10]','$objArr[11]','$objArr[12]','$objArr[13]','$objArr[14]','$objArr[15]',";
				$sql  .="'$objArr[16]','$objArr[17]','$objArr[18]','$objArr[19]','$objArr[20]','$objArr[21]','$objArr[22]','$objArr[23]','$objArr[24]','$objArr[25]',";
				$sql  .="'$objArr[26]','$objArr[27]','$objArr[28]','$objArr[29]','$objArr[30]','$objArr[31]','$objArr[32]','$objArr[33]',";
				$sql  .="'$rec_date','$officer'";
				$sql  .=")";
				$dbquery = mysqli_query($connect,$sql);
				}  //end if
				} //end while
				fclose($objCSV);
		////end
		}
		else{
		echo  "<br><strong><font color=#990000 size=3>ไม่สามารถอัพโหลดได้</font></strong>";
		exit();
		}
	 	?> <script>
		document.location.href="?option=student_main&task=student_report1&school_index=<?php echo $school_code[1]?>";
		</script>	<?php
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
echo "<Tr><Td align='left'>1. ข้อมูลที่จะนำเข้าเป็นข้อมูลที่ออกจาก Data  Management Center </Td></Tr>";
echo "<Tr><Td align='left'>2.  นำเข้าไฟล์ชื่อ studentmis_xxxxxxxx.csv (xxxxxxxx หมายถึงรหัสโรงเรียน) </Td></Tr>";
echo "</Table>";
}
?>
<script>
function upload(val){
	if(val==1){
		callfrm("?option=student_main&task=student_import_2");
		}
}
</script>

