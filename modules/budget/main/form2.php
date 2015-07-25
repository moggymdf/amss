<?php
session_start();
header("Content-Type: application/vnd.ms-word");
header('Content-Disposition: attachment; filename="command.doc"');# ชื่อไฟล์
?>
<html xmlns:o="urn:schemas-microsoft-com:office:office"
xmlns:x="urn:schemas-microsoft-com:office:excel"
xmlns="http://www.w3.org/TR/REC-html40">
<HTML>
<HEAD>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
</HEAD>

<BODY>

 <?php
require_once "../../../amssplus_connect.php";

$v_office=$_SESSION['office_name'];

$sql = "select * from budget_reserve_money where id='$_GET[id]'";
$dbquery = mysqli_query($connect,$sql);
$result = mysqli_fetch_array($dbquery);
		$id = $result['id'];
		$item = $result['item'];
		$pay_amount = $result['pay_amount'];
		$pay_amount=number_format($pay_amount,2);
		$payed_person = $result['borrowed_person'];
		$rec_date = $result['rec_date'];

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
            <td width="46%"><font size="3">งาน</font></td>
            <td width="1%"><font size="3">&nbsp;</font></td>
            <td width="53%"><font size="3">เลขที่.........................</font></td>
          </tr>
          <tr>
            <td><font size="3">หมวดรายจ่าย</font></td>
            <td><font size="3">&nbsp;</font></td>
            <td><table width="100%" border="0">
                <tr>
                  <td><font size="3">ฎีกาที่.............................</font></td>
                  <td><font size="3">ใบถอนที่</font></td>
                </tr>
              </table></td>
          </tr>
          <tr>
            <td><font size="3">ลักษณะงาน</font></td>
            <td><font size="3">&nbsp;</font></td>
            <td><font size="3">เลขที่เช็ค
              ....................................................................................
              </font></tr>
        </table>
      </div></td>
  </tr>
  <tr>
    <td colspan="2"> <div align="center">
        <table width="100%" border="0">
          <tr>
            <td width="46%"><font size="3">&nbsp;</font></td>
            <td width="54%"><table width="100%" border="0">
                <tr>
                  <td width="15%">&nbsp;</td>
                  <td width="85%"><font size="3"> <?php echo $v_office ?> </font></td>
                </tr>
              </table></td>
          </tr>
          <tr>
            <td><font size="3">&nbsp;</font></td>
            <td><font size="3">วันที่&nbsp;&nbsp;&nbsp;<?php echo$thai_date?>
</font></td>
          </tr>
          <tr>
            <td colspan="2"><table width="100%" border="0">
                <tr>
                  <td width="12%">&nbsp;</td>
                  <td width="88%"><font size="3">ข้าพเจ้า&nbsp;&nbsp;&nbsp;<?php echo$fullname?>
                    &nbsp;&nbsp;&nbsp;ข้าราชการ ลูกจ้างประจำ สังกัด<?php echo $v_office ?>
                  </font></td>
                </tr>
              </table></td>
          </tr>
          <tr>
            <td colspan="2"><font size="3">เจ้าหนี้ หรือ ผู้มีสิทธิ์รับเงิน </font>
              <font size="3">
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
            <td><font size="3">ชื่อ&nbsp;&nbsp;&nbsp;<?php echo$payed_person?>
              </font></td>
            <td><font size="3">ตำแหน่ง.................................................
              </font></td>
          </tr>
          <tr>
            <td><font size="3">ขอรับเงินค่า&nbsp;&nbsp;&nbsp;<?php echo$item?>
              </font></td>
            <td><font size="3">จำนวนเงิน&nbsp;&nbsp;&nbsp;<?php echo$pay_amount?>&nbsp;&nbsp;
              บาท</font></td>
          </tr>
          <tr>
            <td><font size="3">หักภาษี ณ ที่จ่าย ...........................................
              บาท</font></td>
            <td><font size="3">คงเหลือ.................................................
              บาท</font></td>
          </tr>
          <tr>
            <td colspan="2"><font size="3">
              &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;เพื่อพิจารณาอนุมัติ</font></td>
          </tr>
          <tr>
            <td><font size="3">&nbsp;</font></td>
            <td><font size="3">(ลงชื่อ)..................................................ผู้ยื่นใบสั่งจ่าย</font></td>
          </tr>
          <tr>
            <td>&nbsp;</td>
            <td><font size="3">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
			&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;(<?php echo$fullname?>)</font></td>
          </tr>
          <tr>
            <td colspan="2"><table width="100%" border="0">
                <tr>
                  <td width="13%"><font size="3">&nbsp;</font></td>
                  <td width="87%"><font size="3">ได้ตรวจสอบรายการขอรับเงินถูกต้องแล้ว
                    ควรอนุมัติ</font></td>
                </tr>
              </table></td>
          </tr>
          <tr>
            <td><font size="3">&nbsp;</font></td>
            <td><font size="3">(ลงชื่อ)..................................................หัวหน้างานการเงิน</font></td>
          </tr>
          <tr>
            <td><font size="3">&nbsp;</font></td>
            <td><font size="3">(.............................................................)</font></td>
          </tr>
          <tr>
            <td colspan="2"><table width="100%" border="0">
                <tr>
                  <td width="13%">&nbsp;</td>
                  <td width="87%"><font size="3">ได้ตรวจสอบรายการขอรับเงินถูกต้องแล้ว
                    ควรอนุมัติให้จ่ายเงินได้</font></td>
                </tr>
              </table></td>
          </tr>
          <tr>
            <td><font size="3">&nbsp;</font></td>
            <td><font size="3">(ลงชื่อ)...................................................<font size="3">ผอ.กลุ่มบริหารการเงินฯ</font></font></td>
          </tr>
          <tr>
            <td><font size="3">&nbsp;</font></td>
            <td><font size="3">(..............................................................)</font></td>
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
                  <td><div align="center"><font size="3">(ลงชื่อ).............................................ผอ.กลุ่มบริหารการเงินฯ</font></div></td>
                </tr>
                <tr>
                  <td><div align="center">(....................................................)</div></td>
                </tr>
                <tr>
                  <td><div align="center"><font size="3">วันที่ ..............................................................
                      </font></div></td>
                </tr>
                <tr>
                  <td><div align="center"><font size="3"><strong>ควรอนุมัติ</strong></font></div></td>
                </tr>
                <tr>
                  <td><div align="center"><font size="3">(ลงชื่อ)..........................................................
                      </font></div></td>
                </tr>
                <tr>
                  <td><div align="center">(....................................................)</div></td>
                </tr>
                <tr>
                  <td><div align="center"><font size="3">วันที่ ....................................................
                      </font></div></td>
                </tr>
                <tr>
                  <td><div align="center"><font size="3"><strong>อนุมัติ</strong></font></div></td>
                </tr>
                <tr>
                  <td>&nbsp;</td>
                </tr>
                <tr>
                  <td><div align="center"><font size="3">..................................................................</font></div></td>
                </tr>
              </table></td>
          </tr>
        </table>
      </div></td>
    <td width="51%" valign="top"><table width="100%" border="0">
        <tr>
          <td><div align="center"><strong>ได้รับเงินไปถูกต้องเรียบร้อยแล้ว</strong></div></td>
        </tr>
        <tr>
          <td><div align="center"><font size="3">(ลงชื่อ)...................................................ผู้รับเงิน</font></div></td>
        </tr>
        <tr>
          <td><div align="center">(....................................................)</div></td>
        </tr>
        <tr>
          <td><div align="center"><font size="3">วันที่ ..............................................................
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
          <td><div align="center"><font size="3">(ลงชื่อ)...................................................ผู้จ่ายเงิน</font></div></td>
        </tr>
        <tr>
          <td><div align="center">(.....................................................)</div></td>
        </tr>
        <tr>
          <td><div align="center"><font size="3">วันที่ ..............................................................
              </font></div></td>
        </tr>
      </table></td>
  </tr>
</table>
<p>&nbsp; </p>

</BODY>
</HTML>

