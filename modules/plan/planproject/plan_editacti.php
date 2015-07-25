<?php
// ตรวจสอบปีงบประมาณ
if($_SESSION["mplan_year"]==""){
echo "<br>";
echo "<div align='center'>";
echo "ตรวจสอบการกำหนดปีงบประมาณให้ถูกต้องก่อนค่ะ";
echo "</div>";
exit();
}

require_once("plan_function.php");
require_once("plan_editcalendar.php");
require_once("plan_calendar.php");
require_once("plan_authen.php");  //session_

require_once("dbconfig.inc.php");
$sql_acti="select * from  plan_acti  where id='$_GET[plan_acti_id]'";
$dbquery =DBfieldQuery($sql_acti);
$result = mysqli_fetch_array($dbquery);

	$plan_acti_id =  $result['id'];
	$daythai =  $result['daythai'];
	$code_acti =$result['code_acti'];
	$code_approve =$result['code_approve'];
	$name_acti = $result['name_acti'];
	$tbudget_acti =$result['budget_acti'];
	$mybeginday=$result['begin_date'];
	$myfinishday=$result['finish_date'];
	$code_proj= substr($code_acti,0,3);
	$begin_date =$result['begin_date'];
list($begin_year,$begin_month,$begin_day) = explode("-",$begin_date);
	$finish_date =$result['finish_date'];
list($finish_year,$finish_month,$finish_day) = explode("-",$finish_date);

?>

<script type="text/javascript" src="./css/js/calendarDateInput.js"></script>
<p align="center"><Center>
<Br><Font Size=3 color='#000099'><B>แก้ไขกิจกรรมของโครงการ ปีงบประมาณ <?php echo $_SESSION['budget_year']?></B></Font></p>
<form id='frm1' name='frm1'>
<Table width="90%"  border="1" borderColor="#FFCCFF" align="center" cellpadding="0" cellspacing="0">
<tr>
<!-- Part2	###################   -->
<TD  width="90%"  valign="top" align="center">
<TABLE width="100%" border="0" borderColor=#FF0033 cellpadding="0" cellspacing="0" >
    <tr>
      <TD>
            <TABLE width="100%"  border=0 borderColor=#99CC33 cellpadding="3" cellspacing="0">
					 <tr>
                    <td align="right" width="40%"><b><font color="#003333" size="2" face="MS Sans Serif">รหัสกิจกรรม :</font></b></td>
                    <td align="left"> <input size=6 type=text readonly name="vcode_acti" maxlength=6 value=<?php echo $code_acti?>>
                    </td></tr>
				<tr>
                    <td align="right"><b><font color="#003333" size="2" face="MS Sans Serif">กิจกรรม :</font></b></td>
                    <td align="left"> <textarea name='vname_acti' rows = '3' cols='40' ><?php echo $name_acti?></textarea>
                    </td></tr>
<tr>
                    <td align="right"><b><font color="#003333" size="2" face="MS Sans Serif">วันเริ่มต้นกิจกรรม :</font></b></td>
                    <td align="left"> <script>
								var Y_date=<?php echo $begin_year?>
								var m_date=<?php echo $begin_month?>
								var d_date=<?php echo $begin_day?>
								Y_date= Y_date+'/'+m_date+'/'+d_date
								DateInput('mybeginday', true, 'YYYY-MM-DD', Y_date)</script>
                    </td></tr>
				<tr>
                    <td align="right"><b><font color="#003333" size="2" face="MS Sans Serif">วันสิ้นสุดกิจกรรม :</font></b></td>
                    <td align="left"> <script>
								var Y_date=<?php echo $finish_year?>
								var m_date=<?php echo $finish_month?>
								var d_date=<?php echo $finish_day?>
								Y_date= Y_date+'/'+m_date+'/'+d_date
								DateInput('myfinishday', true, 'YYYY-MM-DD', Y_date)</script>
                    </td></tr>
				<tr>
                    <td align="right"><b><font color="#003333" size="2" face="MS Sans Serif">จำนวนเงิน :</font></b></td>
                    <td align="left"> <input  size=9 type=text  name="vbudget_acti" maxlength=9 value=<?php echo $tbudget_acti?>>
					</td></tr>

                 <tr>
                    <td align="right"><b><font color="#003333" size="2" face="MS Sans Serif">แหล่งเงิน :</font></b></td>
                    <td align="left">
					<?php
$sql = "select * from  budget_year where year_active='1' order by budget_year desc limit 1";
$dbquery =DBfieldQuery($sql);
$year_active_result = mysqli_fetch_array($dbquery);
if($year_active_result['budget_year']==""){
echo "<br />";
echo "<div align='left'>ระบบการเงินและบัญชียังไม่ได้กำหนดทำงานในปีงบประมาณใด ๆ</div>";
}

echo "<br />";

		echo "<Select  name='vcode_approve' size='1'>";
		$sql = "select  num, item from  budget_receive where  budget_year='$year_active_result[budget_year]' order by num desc";
		$dbquery =DBfieldQuery($sql);
		echo  "<option  value = ''>เลือก</option>" ;
		echo "<optgroup label='งบประมาณ'>";
		While ($result = mysqli_fetch_array($dbquery))
		   {
		$num = $result['num'];
		$item_name = $result['item'];
		$item_name=substr($item_name,0,150);
				if((substr($code_approve,0,1)==2) and (substr($code_approve,2)==$num)){
					echo  "<option value ='2_$num' selected>งวดที่&nbsp;$num&nbsp;$item_name</option>";
					}
					else{
					echo  "<option value ='2_$num'>งวดที่&nbsp;$num&nbsp;$item_name</option>";
					}
			}
		echo  "</optgroup>";

		$sql_type = "select * from budget_type where budget_year='$year_active_result[budget_year]' and type_id<'200' order by type_id";
		$dbquery_type =DBfieldQuery($sql_type);
		echo "<optgroup label='เงินนอกงบประมาณ'>";
		While ($result_type = mysqli_fetch_array($dbquery_type))
		   {
		$type_id = $result_type['type_id'];
		$type_name = $result_type['type_name'];
		$type_name=substr($type_name,0,150);
					if((substr($code_approve,0,1)==1) and (substr($code_approve,2)==$type_id)){
					echo  "<option value ='1_$type_id' selected>$type_id $type_name</option>";
					}
					else{
					echo  "<option value ='1_$type_id'>$type_id $type_name</option>";
					}
			}
		echo  "</optgroup>";
		echo "</select>";
				?>
                    </td></tr>

              </table>
		</TD>
	 </table>
<?php
echo "<p align='center'>";
echo "<Input Type=Hidden Name='vcode_proj' Value='$code_proj'>";
echo "<Input Type=Hidden Name='plan_acti_id' Value='$plan_acti_id'>";
echo " <Input Type='button' name='smb' value='ตกลง' onclick='goto_url_update(1)' class='button'>&nbsp;<Input Type='button' name='smb' value='ย้อนกลับ' onclick='goto_url_update(0)' class='button'>";
echo "</p>";
echo "</CENTER><BR>";
 //====== end menu ====
?>
 </table>
<!-- Part3	## -->

</Tr>
<!-- loop  ok-->
</Table>

 </form>
<script>
function goto_url_update(val){

	if(val==0){
		callfrm("?option=plan&task=planproject/plan_in_acti&vcode_proj=<?php echo $code_proj;?>&optioncase=1");
	}
	else if(val==1)
	{
				if(frm1.vcode_acti.value == "")
						{
						alert("กรุณาป้อน	รหัสกิจกรรม \n 001,002,...");
						document.frm1.vcode_acti.focus();
						return false;
						}
				else if(frm1.vname_acti.value == "")
						{
						alert("กรุณาป้อน กิจกรรม");
						document.frm1.vname_acti.focus();
						return false;
						}
				else if(frm1.vbudget_acti.value == "")
						{
						 alert("กรุณาป้อน จำนวนเงิน");
						document.frm1.vbudget_acti.focus();
						return false;
						}
				else
						{ callfrm("?option=plan&task=planproject/plan_updacti"); }  //page ประมวลผล
			} // if(val==1)
} //goto_url_update(val)
</script>
