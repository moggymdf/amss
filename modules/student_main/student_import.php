<?php
/** ensure this file is being included by a parent file */
defined( '_VALID_' ) or die( 'Direct Access to this location is not allowed.' );
//sd page
$rec_date = date("Y-m-d");
$officer=$_SESSION['login_user_id'];

//ปีการศึกษา
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
				document.location.href="?option=student_main&task=student_import";
				</script>
				<?php
		exit();
		}

// ตรวจสอบว่าเป็น text file หรือไม่
$uploaddir ="modules/student_main/upload/";     //ที่เก็บไฟล์
$uploadfile = $uploaddir.basename($_FILES['userfile']['name']);
$basename = basename($_FILES['userfile']['name']);

		//ลบไฟล์เดิม
		if(file_exists($uploadfile)){
		unlink($uploadfile);
		}

$file_name = explode(".", $_FILES['userfile']['name']);
		//ตรวจสอบนามสกุล
		if($file_name[1]!="txt"){
			unlink($_FILES['userfile']['tmp_name']);
				?> <script>
				alert("ไม่ใช่ ไฟล์ประเภท Text กรุณาอ่านคำอธิบายอีกครั้ง");
				document.location.href="?option=student_main&task=student_import";
				</script>
				<?php
			exit();
		}

		if (move_uploaded_file($_FILES['userfile']['tmp_name'],$uploadfile)){
		//$changed_name=$uploaddir.$basename;
		//rename("$uploadfile" , "$changed_name");
		$data=file("$uploadfile");
				for($i=1;$i<count($data);$i++){
				list($objArr[0],$objArr[1],$objArr[2],$objArr[3],$objArr[4],$objArr[5],$objArr[6],$objArr[7],$objArr[8],$objArr[9],$objArr[10]) = explode("\t",$data[$i]);
						$ref_id=$objArr[0].$objArr[5];
						if($objArr[3]=='อ.1'){
						$classlevel=2;
						}
						else if($objArr[3]=='อ.2'){
						$classlevel=3;
						}
						else if($objArr[3]=='ป.1'){
						$classlevel=4;
						}
						else if($objArr[3]=='ป.2'){
						$classlevel=5;
						}
						else if($objArr[3]=='ป.3'){
						$classlevel=6;
						}
						else if($objArr[3]=='ป.4'){
						$classlevel=7;
						}
						else if($objArr[3]=='ป.5'){
						$classlevel=8;
						}
						else if($objArr[3]=='ป.6'){
						$classlevel=9;
						}
						else if($objArr[3]=='ม.1'){
						$classlevel=10;
						}
						else if($objArr[3]=='ม.2'){
						$classlevel=11;
						}
						else if($objArr[3]=='ม.3'){
						$classlevel=12;
						}
						else if($objArr[3]=='ม.4'){
						$classlevel=13;
						}
						else if($objArr[3]=='ม.5'){
						$classlevel=14;
						}
						else if($objArr[3]=='ม.6'){
						$classlevel=15;
						}

						if($objArr[10]!="-"){
						$disable=1;
						}
						else{
						$disable="";
						}
						if($i>0){
								$sql_find = "select ref_id from  student_main_main where  ref_id='$ref_id' and ed_year='$year_active_result[ed_year]' ";
								$dbquery_find = mysqli_query($connect,$sql_find);
								$num_row=mysqli_num_rows($dbquery_find);
								if($num_row>=1){
								$sql_del = "delete from student_main_main where ref_id='$ref_id' and ed_year='$year_active_result[ed_year]' ";
								$dbquery_del = mysqli_query($connect,$sql_del);
								}
						$sql = "insert into student_main_main (ed_year,ref_id,school_code,student_id,person_id,prename,name,surname,sex,school_name,classlevel,classroom,disable,";
						$sql  .="rec_date,officer";
						$sql  .=")";
						$sql  .=" values ('$year_active_result[ed_year]','$ref_id','$objArr[0]','$objArr[5]','$objArr[2]','$objArr[7]','$objArr[8]','$objArr[9]','$objArr[6]','$objArr[1]','$classlevel','$objArr[4]','$disable',";
						$sql  .="'$rec_date','$officer'";
						$sql  .=")";
						$dbquery = mysqli_query($connect,$sql);
						}
				}
		}
		else{
		echo  "<br><strong><font color=#990000 size=3>ไม่สามารถอัพโหลดได้</font></strong>";
		exit();
		}
	 	?> <script>
		document.location.href="?option=student_main&task=student_khet_update";
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
echo  "</form>";

echo "<br /><br /><br />";
echo  "<table width=70% border=0 align=center>";
echo "<Tr><Td align='left'><strong>คำอธิบาย</strong></Td></Tr>";
echo "<Tr><Td align='left'>1. ข้อมูลที่จะนำเข้าเป็นข้อมูลที่ออกจาก Data Management Center ซึ่งเป็นไฟล์ประเภท excel</Td></Tr>";
echo "<Tr><Td align='left'>2. ตัดสดมภ์ให้เหลือตามตัวอย่าง (ดูได้จากเมนูคู่มือ) แล้ว Save As เป็นชนิด Text (Tab delimited)</Td></Tr>";
echo "<Tr><Td align='left'>3. เปิดไฟล์จากข้อ 2 ด้วยโปรแกรม Notepad  แล้ว Save as  โดยเปลี่ยน Encodeng เป็น UTF-8</Td></Tr>";
echo "<Tr><Td align='left'>4. นำข้อมูลเข้าจากไฟล์ในข้อ 3</Td></Tr>";
echo "<Tr><Td align='left'>5. ในกรณีที่มีนักเรียนจำนวนมาก และ Server ตั้งเวลาทำงานไว้น้อย จะต้องแบ่งการนำเข้า เช่น ครั้งละ 5,000-10,000 คน เป็นต้น</Td></Tr>";
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

