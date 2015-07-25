<script>
function check_radio(){
			var sch=document.getElementsByName("system_school");
			var sch_select_num=0;
			for(i=0;i<sch.length;i++){
					if(sch[i].checked==true){
					sch_select_num=1;
					}
			}
		    if (sch_select_num==0){
				  alert("กรุณาเลือกสถานศึกษา");
		    }
			else{
			frm1.target = "_self";
			frm1.action = "index.php";
			frm1.method = "POST";
			frm1.submit();
			}
}
</script>

<?php
/** ensure this file is being included by a parent file */
defined( '_VALID_' ) or die( 'Direct Access to this location is not allowed.' );

		if(trim($_POST['username'])==""){
		echo "<script>document.location.href='index.php';</script>\n";
		exit();
		}
$username 	= trim($_POST['username']);
$pass = trim($_POST['pass']);
$pass = md5($pass);

if($username=='admin'){
$sql = "select * from system_user where username='admin' and status='1' ";
}
else{
$sql = "select * from system_user where username='$username' and status='1' ";
}
$dbquery = mysqli_query($connect,$sql);
$result1 = mysqli_fetch_array($dbquery);
if($result1){
		$Myusername = $result1['username'];
		$Mypwd=$result1['userpass'];
				if(strcmp($Mypwd,$pass)) {
					echo "<meta http-equiv='Content-Type' content='text/html; charset=utf-8'>";
					echo "<script>alert('Password ไม่ถูกต้อง'); document.location.href='index.php';</script>\n";
					exit();
				}

		//ตรวจสอบว่าเป็น admin
		if($Myusername=='admin'){
		$_SESSION['login_status'] =99;
		}
		else{
		//ตรวจสอบเป็นบุคลากรปัจจุบันของสพทหรือไม่
		$sql_user = "select * from person_main left join person_position on person_main.position_code=person_position.position_code where person_main.person_id='$result1[person_id]' and person_main.status ='0' ";
		$dbquery_user = mysqli_query($connect,$sql_user);
		$result_user = mysqli_fetch_array($dbquery_user);
				if($result_user){
						if($result_user['position_code']==1){
						$_SESSION['login_status'] =2;
						}
						else if($result_user['position_code']==2){
						$_SESSION['login_status'] =3;
						}
						else{
						$_SESSION['login_status'] =4;
						}
				}
				else{
				//ตรวจสอบเป็นบุคลากรปัจจุบันของโรงเรียนหรือไม่
				$sql_user = "select * from person_sch_main left join person_sch_position on person_sch_main.position_code=person_sch_position.position_code where person_sch_main.person_id='$result1[person_id]' and person_sch_main.status ='0' ";
				$dbquery_user = mysqli_query($connect,$sql_user);
				$result_user = mysqli_fetch_array($dbquery_user);
						if($result_user){
								//กรณีปฏิบัติงานมากกว่า 1 โรงเรียน
								if(($result_user['other']==1) and (!isset($_POST['system_multi_school']))){
								echo "<meta http-equiv='Content-Type' content='text/html; charset=utf-8'>";
								echo "<br>";
								echo "<div align='center'>";
        						echo "<form  name='frm1' onSubmit='check_radio()'>";
								if($_POST['user_os']=='mobile'){
								$width="70%";
								}else{
								$width="30%";
								}
								echo "<table border='1' width='$width'  style='border-collapse: collapse' bordercolor='#800080'>";
								echo "<tr bgcolor='#660066'><td align='center'><FONT SIZE='2' COLOR='#FFFFFF'>&nbsp;<B>เลือกสถานศึกษาสำหรับปฏิบัติงาน</B></FONT></td></tr>";
								$sql_school_select1 = "select * from system_school where school_code='$result_user[school_code]' ";
								$dbquery_school_select1 = mysqli_query($connect,$sql_school_select1);
								$result_school_select1 = mysqli_fetch_array($dbquery_school_select1);
								echo "<tr><td align='left'>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<input type='radio' name='system_school' value=$result_school_select1[school_code]>&nbsp;<FONT SIZE='2'>$result_school_select1[school_name]</FONT></td></tr>";
								$sql_school_select2 = "select * from person_sch_other left join system_school on person_sch_other.school_code=system_school.school_code where person_sch_other.person_id='$result1[person_id]'";
								$dbquery_school_select2 = mysqli_query($connect,$sql_school_select2);
								While ($result_school_select2 = mysqli_fetch_array($dbquery_school_select2)){
								echo "<tr><td align='left'>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<input type='radio' name='system_school' value=$result_school_select2[school_code]>&nbsp;<FONT SIZE='2'>$result_school_select2[school_name]</FONT></td></tr>";
								}
								echo "<input type='hidden' name='login_submit' value='1'>";
								echo "<input type='hidden' name='system_multi_school' value='1'>";
								echo "<input type='hidden' name='username' value='$_POST[username]'>";
								echo "<input type='hidden' name='pass' value='$_POST[pass]'>";
								echo "<input type='hidden' name='user_os' value='$_POST[user_os]'>";
								echo "<tr><td align='center'><INPUT TYPE='button' name='smb' value='ตกลง' onclick='check_radio()'></td></tr>";
								echo "</table>";
								echo "</form>";
								echo "</div>";
								exit();
								}

								if(isset($_POST['system_multi_school'])){
								$_SESSION['user_school']=$_POST['system_school'];
								}
								else{
								$_SESSION['user_school']=$result_user['school_code'];
								}

								$sql_system_school = "select school_name,school_type from system_school where school_code='$_SESSION[user_school]'";
								$query_system_school = mysqli_query($connect,$sql_system_school);
								$result_system_school = mysqli_fetch_array($query_system_school);
								$_SESSION['system_school_name']=$result_system_school['school_name'];
								$_SESSION['system_school_type']=$result_system_school['school_type'];

								if($result_user['position_code']==1){
								$_SESSION['login_status'] =12;
								}
								else if($result_user['position_code']==2){
								$_SESSION['login_status'] =13;
								}
								else {
								$_SESSION['login_status'] =14;
								}
						}
						else{
						echo "<meta http-equiv='Content-Type' content='text/html; charset=utf-8'>";
						echo "<script>alert('คุณไม่ได้เป็นบุคลากรปัจจุบันของหน่วยงาน จึงไม่ได้รับสิทธิ์ใช้งาน'); document.location.href='index.php';</script>\n";
						exit();
						}
				}
		}

		$_SESSION['login_user_id'] = $result1['person_id'];
		if(!isset($result_user['name'])){
		$_SESSION['login_name']=$Myusername;
		}
		else{
		$_SESSION['login_prename'] = $result_user['prename'];
		$_SESSION['login_name'] = $result_user['name'];
		$_SESSION['login_surname'] = $result_user['surname'];
		$_SESSION['login_userposition'] = $result_user['position_name'];
		}
		$sql_module_admin = "select * from system_module_admin where person_id='$result1[person_id]' ";
		$dbquery_module_admin = mysqli_query($connect,$sql_module_admin);
		While ($result_module_admin = mysqli_fetch_array($dbquery_module_admin)){
		$_SESSION['admin_'.$result_module_admin['module']]=$result_module_admin['module'];
		}
}

else if(!$result1){
		//ตรวจว่ามีชื่่อในทะเบียน user หรือไม่ หากlogin ด้วยเลข 13 หลัก
		$sql3 = "select * from system_user where person_id='$username' and status='1' ";
		$dbquery3 = mysqli_query($connect,$sql3);
		$num_rows=mysqli_num_rows($dbquery3);
				if($num_rows>=1){
						echo "<meta http-equiv='Content-Type' content='text/html; charset=utf-8'>";
						echo "<script>alert('คุณมีชื่อผู้ใช้อยู่แล้ว กรุณา login ด้วย Username และ Password'); document.location.href='index.php';</script>\n";
						exit();
				}
		$sql2 = "select * from person_main where person_id='$username' and status='0' ";
		$dbquery2 = mysqli_query($connect,$sql2);
		$result2 = mysqli_fetch_array($dbquery2);
				if($result2){
				$system_warning_1=1;
				$_SESSION['login_user_id'] = $result2['person_id'];
				$_SESSION['login_status'] =5;
				$_SESSION['login_prename'] = $result2['prename'];
				$_SESSION['login_name'] = $result2['name'];
				$_SESSION['login_surname'] = $result2['surname'];
				}
				else{
				$sql2_1 = "select * from person_sch_main where person_id='$username' and status='0' ";
				$dbquery2_1 = mysqli_query($connect,$sql2_1);
				$result2_1 = mysqli_fetch_array($dbquery2_1);
						if($result2_1){
						$system_warning_1=1;
						$_SESSION['login_user_id'] = $result2_1['person_id'];
						$_SESSION['login_status'] =15;
						$_SESSION['login_prename'] = $result2_1['prename'];
						$_SESSION['login_name'] = $result2_1['name'];
						$_SESSION['login_surname'] = $result2_1['surname'];
						}
						else{
						$sql4 = "select * from student_main_main,student_main_edyear where student_main_main.person_id='$username' and student_main_main.ed_year=student_main_edyear.ed_year and student_main_edyear.year_active='1' ";
						$dbquery4 = mysqli_query($connect,$sql4);
						$result4 = mysqli_fetch_array($dbquery4);
								if($result4){
								$_SESSION['login_user_id'] = $result4['person_id'];
								$_SESSION['login_status'] =16;
								$_SESSION['login_prename'] = $result4['prename'];
								$_SESSION['login_name'] = $result4['name'];
								$_SESSION['login_surname'] = $result4['surname'];
								$_SESSION['user_school']=$result4['school_code'];
								$sql_system_school = "select school_name from system_school where school_code='$_SESSION[user_school]'";
								$query_system_school = mysqli_query($connect,$sql_system_school);
								$result_system_school = mysqli_fetch_array($query_system_school);
								$_SESSION['system_school_name']=$result_system_school['school_name'];
								}
								else{
								echo "<meta http-equiv='Content-Type' content='text/html; charset=utf-8'>";
								echo "<script>alert('ไม่พบชื่ออยู่ในระบบ'); document.location.href='index.php';</script>\n";
								exit();
								}
						}
				}
}

//ชื่อหน่วยงาน
$sql_office_name = "select * from  system_office_name";
$dbquery_office_name = mysqli_query($connect,$sql_office_name);
$result_office_name = mysqli_fetch_array($dbquery_office_name);
$_SESSION['office_name'] =$result_office_name['office_name'];

//os
$_SESSION['user_os'] = $_POST['user_os'];

//ส่วนของ version และปรับปรุงระบบ
$sql_version = "select * from system_version order by id";
$dbquery_version = mysqli_query($connect,$sql_version);
$result_version = mysqli_fetch_array($dbquery_version);

require_once('version.php');
$_SESSION['system_version'] = $code_version;

if($result_version['system_version']!=$code_version){
	require_once('update/update.php');
}

$_SESSION['AMSSPLUS']=1;
if(isset($_SESSION['SMSS'])){
unset($_SESSION['SMSS']);
}

if(isset($system_office_code)){
$_SESSION['office_code']=$system_office_code;
}
else{
$_SESSION['office_code']="";
}

if(!isset($_SESSION['user_school'])){
$_SESSION['user_school']="";
}
//ส่วนของระบบแจ้งเตือน
require_once('alert/alert.php');
?>

