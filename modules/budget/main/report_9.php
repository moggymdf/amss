<br />
<div align="center">
        <font color="#006666" size="3"><strong>รายงานการจัดสรรงบประมาณจำแนกตามโครงการ</strong></font></p>
      </div>
<?php
if(!($_SESSION['login_status']<=15)){
exit();
}

if(!isset($_REQUEST['year_index'])){
$_REQUEST['year_index']="";
}

if(!isset($_REQUEST['workgroup'])){
$_REQUEST['workgroup']="";
}

//ปีงบประมาณ
$sql = "select * from  budget_year where year_active='1' order by budget_year desc limit 1";
$dbquery = mysqli_query($connect,$sql);
$year_active_result = mysqli_fetch_array($dbquery);
if($year_active_result['budget_year']==""){
echo "<br />";
echo "<div align='center'>ยังไม่ได้กำหนดทำงานในปีงบประมาณใด ๆ  กรุณาไปที่เมนูตั้งค่าระบบ เพื่อกำหนดปีงบประมาณ</div>";
exit();
}
	//กรณีเลือกปี
	$year_index=$_REQUEST['year_index'];
	if($year_index!=""){
		$year_active_result['budget_year']=$year_index;
	}
	//ตัวแปรกลุ่มงาน
	$workgroup=$_REQUEST['workgroup'];

if($workgroup!=""){
$sql = "select * from  plan_proj  where budget_year='$year_active_result[budget_year]' and code_clus='$workgroup' order by code_proj ";
}
else{
$sql = "select * from  plan_proj  where budget_year='$year_active_result[budget_year]' order by code_proj ";
}
					$dbquery = mysqli_query($connect,$sql);
					$rd=1;
					$sum_momey_proj=0;
					While ($result = mysqli_fetch_array($dbquery))
						{
							$code_clus_plan= $result['code_clus'];
							$code_proj_plan= $result['code_proj'];
							$name_proj_plan= $result['name_proj'];
							$budget_proj_plan= $result['budget_proj'];
									$sum_momey_proj=$sum_momey_proj+$budget_proj_plan;
							$owner_proj = $result['owner_proj'];
							$code_clus_plan_ar[$rd]=$code_clus_plan;
							$code_proj_plan_ar[$rd]=$code_proj_plan;
							$name_proj_plan_ar[$rd]=$name_proj_plan;
							$budget_proj_plan_ar[$rd]=$budget_proj_plan;
							$owner_proj_ar[$rd]=$owner_proj;
						$rd++;
	    				}

					$sql = "select  * from  plan_acti  where budget_year='$year_active_result[budget_year]' order by code_acti";
					$dbquery = mysqli_query($connect,$sql);
					$re=1;
					While ($result = mysqli_fetch_array($dbquery))
						{
							$code_proj_acti= $result['code_proj'];
							$code_acti= $result['code_acti'];
							$name_acti= $result['name_acti'];
							$budget_acti= $result['budget_acti'];
							$budget_approve= $result['budget_approve'];
							$code_approve= $result['code_approve'];
							if($code_approve<1)
							$code_approve="<font color=#FF0000>No</font>";

							$code_proj_acti_ar[$re]=$code_proj_acti;
							$code_acti_ar[$re]=$code_acti;
							$name_acti_ar[$re]=$name_acti;
							$budget_acti_ar[$re]=$budget_acti;
							$budget_approve_ar[$re]=$budget_approve;
							$code_approve_ar[$re]=$code_approve;
						$re++;
	    				}

//บุคคล
$sql = "select  * from person_main  order by position_code,name";
$dbquery = mysqli_query($connect,$sql);
while ($result = mysqli_fetch_array($dbquery)){
$person_ar[$result['person_id']]=$result['prename'].$result['name']." ".$result['surname'];
}

//////////////////	เลือกปีงบประมาณและกลุ่มงาน
echo "<form  name='frm1'>";
	echo "<table width='95%' align='center'><tr><td align='right'>";
if($_SESSION['login_status']<=4){
	echo "ปีงบประมาณ&nbsp";
	echo "<Select  name='year_index' size='1'>";
	echo  '<option value ="" >เลือก</option>' ;
	$sql_year = "SELECT *  FROM  budget_year order by budget_year";
	$dbquery_year = mysqli_query($connect,$sql_year);
	While ($result_year = mysqli_fetch_array($dbquery_year)){
			 if($year_index==""){
					if($result_year['year_active']==1){
					echo "<option value=$result_year[budget_year]  selected>$result_year[budget_year]</option>";
					}
					else{
					echo "<option value=$result_year[budget_year]>$result_year[budget_year]</option>";
					}
			 }
			 else{
					if($year_index==$result_year['budget_year']){
					echo "<option value=$result_year[budget_year]  selected>$result_year[budget_year]</option>";
					}
					else{
					echo "<option value=$result_year[budget_year]>$result_year[budget_year]</option>";
					}
			}
	}
echo "</select>";
}
echo "&nbsp;<Select  name='workgroup' size='1'>";
echo  '<option value ="" >ทุกกลุ่ม(งาน)</option>' ;
						$sql = "SELECT *  FROM   system_workgroup";
						$dbquery = mysqli_query($connect,$sql);
						While ($result = mysqli_fetch_array($dbquery))
							{
								if ($workgroup==$result['workgroup']){
								echo "<option value=$result[workgroup]  selected>$result[workgroup_desc]</option>";
								}
								else{
								echo "<option value=$result[workgroup]>$result[workgroup_desc]</option>";
								}
							}
					echo "</select>";
echo "&nbsp;<INPUT TYPE='button' name='smb' value='เลือก' onclick='goto_url(1)' class=entrybutton>";
echo "</td></tr></table>";
echo "</form>";
/////////////////////

echo  "<table width='95%' border='0' align='center'>";
echo "<Tr bgcolor='#FFCCCC' align='center'><Td width='50'>ที่</Td><Td width='50'>รหัส</Td><Td width='70'>โครงการ</Td><Td>กิจกรรม</Td><Td width=120>งบประมาณ</Td><Td width='130'>แหล่งงบประมาณ</Td><Td width='100'>ผู้รับผิดชอบ</Td></Tr>";

for($i=1;$i<$rd;$i++)
{
$budget_proj_plan_ar[$i]=number_format($budget_proj_plan_ar[$i],2);
echo "<Tr bgcolor='#FFFFC'><Td align='center'>$i</Td><Td align='center'>$code_proj_plan_ar[$i]</Td><Td colspan='2'>$name_proj_plan_ar[$i]</Td><Td align=right><font color='#FF0033'>$budget_proj_plan_ar[$i]</font></Td><Td></Td><Td>";
$person=$owner_proj_ar[$i];
echo "$person_ar[$person]</Td></Tr>";
		$acti_num=0;
		for($x=1;$x<$re;$x++)
		{
				if($code_proj_plan_ar[$i]==$code_proj_acti_ar[$x])
					{
					$acti_num=$acti_num+1;
					$budget_acti=number_format($budget_acti_ar[$x],2);

if($code_approve_ar[$x]=="<font color=#FF0000>No</font>"){
$code_approve_ar[$x]="_";
}

list($category,$type) = explode("_",$code_approve_ar[$x]);
if($category==2){
$type_text="งบประมาณงวด $type";
}
else if($category==1){
$type_text="นอกงบประมาณ($type)";
}
else{
$type_text="";
}

					echo "<Tr><Td ></Td><Td></Td><Td></Td><Td align=left><font color='#0000FF'>$code_acti_ar[$x]</font>&nbsp;$name_acti_ar[$x]</Td><Td align=right>$budget_acti</Td><Td align='left'>$type_text</Td><Td></Td></Tr>";
					}
		}
}
$sum_momey_proj=number_format($sum_momey_proj,2);
echo "<Tr bgcolor='#FFCCCC' align='center'><Td></Td><Td></Td><Td></Td><Td>รวม</Td><Td>$sum_momey_proj</Td><Td></Td><Td></Td></Tr>";
echo "</Table>";
?>

<script>
function goto_url(val){
callfrm("?option=budget&task=main/report_9");
}
</script>
