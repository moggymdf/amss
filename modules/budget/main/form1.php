<?php
session_start();
?>

<html>
<HEAD>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />

<style type="text/css">
<!--
.style1 {
	font-size: 20px;
	font-family: sans-serif, Helvetica, Arial ;
}

.style2 {
	font-size: 16px;
	font-family: sans-serif, Helvetica, Arial ;
}

-->
</style>

</HEAD>

<body>
<?php
require_once "../../../amssplus_connect.php";

//ปีงบประมาณ
$sql = "select * from  budget_year where year_active='1' order by budget_year desc limit 1";
$dbquery = mysqli_query($connect,$sql);
$year_active_result = mysqli_fetch_array($dbquery);
if($year_active_result['budget_year']==""){
echo "<br />";
echo "<div align='center'>ยังไม่ได้กำหนดทำงานในปีงบประมาณใด ๆ  กรุณาไปที่เมนูตั้งค่าระบบ เพื่อกำหนดปีงบประมาณ</div>";
exit();
}


$v_office=$_SESSION['office_name'];

$sql = "select * from budget_main where id='$_GET[id]'";
$dbquery = mysqli_query($connect,$sql);
$result = mysqli_fetch_array($dbquery);
		$id = $result['id'];
		$doc = $result['doc'];
		$item = $result['item'];
		$refer_deega_id= $result['refer_deega_id'];
		$pay_amount = $result['pay_amount'];
		$pay_amount=number_format($pay_amount,2);
		$payed_person = $result['payed_person'];
		$rec_date = $result['rec_date'];

				$sql_2 = "select * from  budget_deega where deega_num='$refer_deega_id' and budget_year='$year_active_result[budget_year]' ";
				$dbquery_2 = mysqli_query($connect,$sql_2);
				$result_2 = mysqli_fetch_array($dbquery_2);
				$withdraw= $result_2['withdraw'];
				$withdraw=number_format($withdraw,2);
				$tax= $result_2['tax'];
				$tax=number_format($tax,2);
				$pay= $result_2['pay'];
				$pay= number_format($pay,2);
 		$today_date = date("d/m/Y");
		list($today_day, $today_month, $today_year) = explode("/", $today_date);
		if ($today_month ==1)  $today_month = "มกราคม";
		if ($today_month ==2)  $today_month = "กุมภาพันธ์";
		if ($today_month ==3)  $today_month = "มีนาคม";
		if ($today_month ==4)  $today_month = "เมษายน";
		if ($today_month ==5)  $today_month = "พฤษภาคม";
		if ($today_month ==6)  $today_month = "มิถุนายน";
		if ($today_month ==7)  $today_month = "กรกฎาคม";
		if ($today_month ==8)  $today_month = "สิงหาคม";
		if ($today_month ==9)  $today_month = "กันยายน";
		if ($today_month ==10)  $today_month = "ตุลาคม";
		if ($today_month ==11)  $today_month = "พฤศจิกายน";
		if ($today_month ==12)  $today_month = "ธันวาคม";
		$today_year = $today_year+543 ;
		$thai_date="$today_day $today_month $today_year";

$sql = "select  * from  person_main where person_id='$_SESSION[login_user_id]'";
$dbquery = mysqli_query($connect,$sql);
$result_person = mysqli_fetch_array($dbquery);
$fullname=$result_person['prename'].$result_person['name']." ".$result_person['surname'];
?>

<p align="center"><font size="4"><strong>ใบสั่งจ่าย</strong></font></p>
<table width="100%" border="1" align="center" bordercolor="#000000">
  <tr>
    <td colspan="2"> <div align="center">
        <table width="100%" border="0">
          <tr>
            <td width="46%"><font size="2">งาน</font></td>
            <td width="1%"><font size="2">&nbsp;</font></td>
            <td width="53%"><font size="2">เลขที่   <input type="text"  size="20"  value="<?php echo $doc?>"></font></td>
          </tr>
          <tr>
            <td><font size="2">หมวดรายจ่าย</font></td>
            <td><font size="2">&nbsp;</font></td>
            <td><table width="100%" border="0">
                <tr>
                  <td><font size="2">ฎีกาที่  <input type="text" name="textfield" size="10" value="<?php echo $refer_deega_id?>"></font></td>
                  <td><font size="2">ใบถอนที่</font></td>
                </tr>
              </table></td>
          </tr>
          <tr>
            <td><font size="2">ลักษณะงาน</font></td>
            <td><font size="2">&nbsp;</font></td>
            <td><font size="2">เลขที่เช็ค
              <input type="text" name="textfield" size="20">
              </font></tr>
        </table>
      </div></td>
  </tr>
  <tr>
    <td colspan="2"> <div align="center">
        <table width="100%" border="0">
          <tr>
            <td width="46%"><font size="2">&nbsp;</font></td>
            <td width="54%"><table width="100%" border="0">
                <tr>
                  <td width="15%">&nbsp;</td>
                  <td width="85%"><font size="2"><?php echo $v_office ?></font></td>
                </tr>
              </table></td>
          </tr>
          <tr>
            <td><font size="2">&nbsp;</font></td>
            <td><font size="2">วันที่ <input type="text" name="textfield" size="20"  value="<?php echo $thai_date?>">
</font></td>
          </tr>
          <tr>
            <td colspan="2"><table width="100%" border="0">
                <tr>
                  <td width="12%">&nbsp;</td>
                  <td width="88%"><font size="2">ข้าพเจ้า   <?php echo $fullname?></font></td>
                </tr>
              </table></td>
          </tr>
          <tr>
            <td colspan="2"><font size="2">( )ข้าราชการ ( )ลูกจ้างประจำ สังกัด <?php echo $v_office ?></font></td>
          </tr>
          <tr>
            <td colspan="2"><font size="2">เจ้าหนี้ หรือ ผู้มีสิทธิ์รับเงิน </font>
              <font size="2">
              <input type="radio" name="radiobutton">
              ร้านค้า
              <input type="radio" name="radiobutton" >
              บริษัท
              <input type="radio" name="radiobutton" >
              หจก
              <input type="radio" name="radiobutton" >
              หสน
              <input type="radio" name="radiobutton" >
              อืน ๆ </font> </td>
          </tr>
          <tr>
            <td><font size="2">ชื่อ
              <input type="text" name="textfield" size="40" value="<?php echo $payed_person?>">
              </font></td>
            <td><font size="2">ตำแหน่ง
              <input type="text" name="textfield" size="40">
              </font></td>
          </tr>
          <tr>
            <td><font size="2">ขอรับเงินค่า
              <input type="text" name="item" size="40" value="<?php echo $item?>">
              </font></td>
            <td><font size="2">จำนวนเงิน
              <input type="text" name="textfield" size="20"  value="<?php echo $withdraw?>">
              บาท</font></td>
          </tr>
          <tr>
            <td><font size="2">หักภาษี ณ ที่จ่าย
              <input type="text" name="textfield" size="20" value="<?php echo $tax?>">
              บาท</font></td>
            <td><font size="2">คงเหลือ
              <input type="text" name="textfield" size="20" value="<?php echo $pay?>">
              บาท</font></td>
          </tr>
          <tr>
            <td colspan="2"><font size="2">
              <input type="text" name="textfield" size="50">
              เพื่อพิจารณาอนุมัติ</font></td>
          </tr>
          <tr>
            <td><font size="2">&nbsp;</font></td>
            <td><font size="2">(ลงชื่อ)..................................................ผู้ยื่นใบสั่งจ่าย</font></td>
          </tr>
          <tr>
            <td>&nbsp;</td>
            <td><font size="2">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
			&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;(<?php echo $fullname?>)</font></td>
          </tr>
          <tr>
            <td colspan="2"><table width="100%" border="0">
                <tr>
                  <td width="13%"><font size="2">&nbsp;</font></td>
                  <td width="87%"><font size="2">ได้ตรวจสอบรายการขอรับเงินถูกต้องแล้ว
                    ควรอนุมัติ</font></td>
                </tr>
              </table></td>
          </tr>
          <tr>
            <td><font size="2">&nbsp;</font></td>
            <td><font size="2">(ลงชื่อ)...............................................หัวหน้างานการเงิน</font></td>
          </tr>
          <tr>
            <td><font size="2">&nbsp;</font></td>
            <td><font size="2">(.............................................................)</font></td>
          </tr>
          <tr>
            <td colspan="2"><table width="100%" border="0">
                <tr>
                  <td width="13%">&nbsp;</td>
                  <td width="87%"><font size="2">ได้ตรวจสอบรายการขอรับเงินถูกต้องแล้ว
                    ควรอนุมัติให้จ่ายเงินได้</font></td>
                </tr>
              </table></td>
          </tr>
          <tr>
            <td><font size="2">&nbsp;</font></td>
            <td><font size="2">(ลงชื่อ).....................................<font size="1">ผอ.กลุ่มบริหารงานการเงินฯ</font></font></td>
          </tr>
          <tr>
            <td><font size="2">&nbsp;</font></td>
            <td><font size="2">(..........................................................)</font></td>
          </tr>
          <tr>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
          </tr>
        </table>
      </div></td>
  </tr>
  <tr>
    <td width="49%"><div align="center">
        <table width="98%" border="0">
          <tr>
            <td><table width="103%" border="0">
                <tr>
                  <td>&nbsp;</td>
                </tr>
                <tr>
                  <td><div align="center"><font size="2">(ลงชื่อ)..................................ผอ.กลุ่มบริหารงานการเงินฯ</font></div></td>
                </tr>
                <tr>
                  <td><div align="center">(....................................................)</div></td>
                </tr>
                <tr>
                  <td><div align="center"><font size="2">วันที่ ..............................................................
                      </font></div></td>
                </tr>
                <tr>
                  <td><div align="center"><font size="3"><strong>ควรอนุมัติ</strong></font></div></td>
                </tr>
                <tr>
                  <td>&nbsp;</td>
                </tr>
                <tr>
                  <td><div align="center"><font size="2">(ลงชื่อ)...............................................</font></div></td>
                </tr>
                <tr>
                  <td><div align="center">(....................................................)</div></td>
                </tr>
                <tr>
                  <td><div align="center"><font size="2">วันที่ ...............................................
                      </font></div></td>
                </tr>
                <tr>
                  <td><div align="center"><font size="3"><strong>อนุมัติ</strong></font></div></td>
                </tr>
                <tr>
                  <td>&nbsp;</td>
                </tr>
                <tr>
                  <td>&nbsp;</td>
                </tr>
                <tr>
                  <td><div align="center"><font size="2">...............................................</font></div></td>
                </tr>
              </table></td>
          </tr>
        </table>
      </div></td>
    <td width="51%"><table width="100%" border="0">
        <tr>
          <td><div align="center"><strong>ได้รับเงินไปถูกต้องเรียบร้อยแล้ว</strong></div></td>
        </tr>
        <tr>
          <td><div align="center"></div></td>
        </tr>
        <tr>
          <td>&nbsp;</td>
        </tr>
        <tr>
          <td><div align="center"><font size="2">(ลงชื่อ)...................................................ผู้รับเงิน</font></div></td>
        </tr>
        <tr>
          <td><div align="center">(....................................................)</div></td>
        </tr>
        <tr>
          <td><div align="center"><font size="2">วันที่ ..............................................................
              </font></div></td>
        </tr>
        <tr>
          <td>&nbsp;</td>
        </tr>
        <tr>
          <td><div align="center"><strong>ได้จ่ายเงินให้ผู้รับถูกต้องแล้ว</strong></div></td>
        </tr>
        <tr>
          <td>&nbsp;</td>
        </tr>
        <tr>
          <td><div align="center"><font size="2">(ลงชื่อ)...................................................ผู้จ่ายเงิน</font></div></td>
        </tr>
        <tr>
          <td><div align="center">(.....................................................)</div></td>
        </tr>
        <tr>
          <td><div align="center"><font size="2">วันที่ ..............................................................
              </font></div></td>
        </tr>
      </table></td>
  </tr>
</table>
<p>&nbsp; </p>

</body>
</html>
