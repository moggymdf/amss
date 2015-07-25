<?php

$id = $_REQUEST['id'];
$page = $_REQUEST['page'];

if($_FILES['userfile']['name']==""){
 		?> <script>
			alert("คุณยังไม่ได้เลือกไฟล์ค่ะ");
			document.location.href="?option=budget&task=budget_unit/receive&page=<?php echo $page;?>";
			</script>
			<?php
exit();
}

$basename = basename($_FILES['userfile']['name']);

if (isset($_FILES['userfile']))
{
$changed_name = file_upload($id);
}
$sql =  "update budget_receive set  file='$changed_name' where id='$id' " ;
	if ($dbquery  = mysqli_query($connect,$sql) and $changed_name!="")
	{
	echo "<div align='left'><B><font color='#0066CC' Size='3'>บันทึกเรียบร้อยแล้ว</font></B></div>";
	}
	else
	{
	echo "<div align='left'><B><font color='#00669C' Size='3'>เกิดปัญหาบางอย่าง ไม่สามารถบันทึกได้ค่ะ</font></B></div>";
	exit();
	}
/*--------------------------*/
function  file_upload($id)
	{
		$uploaddir = 'modules/budget/budget_unit/detail/';      //ที่เก็บไไฟล์
		$uploadfile = $uploaddir.basename($_FILES['userfile']['name']);
		$basename = basename($_FILES['userfile']['name']);
		if (move_uploaded_file($_FILES['userfile']['tmp_name'],  $uploadfile))
			{
			echo  "<br><strong><font color='#003366'  size='3'>อัพโหลดไฟล์เรียบร้อยแล้ว</font></strong>";
				$txt ="budget_".$id;
				$before_name  = $uploaddir . $basename;
				///////
				$array_lastname = explode("." ,$basename) ;
				 $c =count ($array_lastname) - 1 ;
				 $lastname = strtolower ($array_lastname[$c]) ;
				$changed_name = $uploaddir.$txt.".".$lastname;
				///////
				rename("$before_name" , "$changed_name");
				return  $changed_name;
			}
		else
			{
			echo  "<br><strong><font color='#990000' size='3'>ไม่สามารถอัพโหลดได้</font></strong>";
			$changed_name="";
			return  $changed_name;
			}
			sleep(3);
		}

?>
<Form id='user_form' name='frm1'>
</Form>
<script>
	callfrm("?option=budget&task=budget_unit/receive&page=<?php echo $page;?>");
</script>
