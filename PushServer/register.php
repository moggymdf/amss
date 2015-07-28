<?php
$my = $_POST["regid"];
// รับข้อมูล json
$json = array();
/**
 * ผู้ใช้ลงทะเบียนอุปกรณ์เข้ากับฐานข้อมูล
 * โดยกับค่า reg id ลงในตาราง
 */
if (isset($my)) {
    $gcm_regid = $my; // GCM ID ที่ลงทะเบียน
    // เชื่อมต่อฐานข้อมูลและเก็บรายละเอียดผู้ใช้ลงฐานข้อมูล
    include_once './db_functions.php';
    include_once './gcm.php';

    $db = new DB_Functions();
    $gcm = new GCM();

    if ($db->getUser($gcm_regid)) {
        $res = $db->storeUser($gcm_regid);

        $registatoin_ids = array($gcm_regid);
        $message = "ยินดีต้อนรับสู่สำนักงานคณะกรรมการการศึกษาขั้นพื้นฐาน";

        $result = $gcm->send_notification($registatoin_ids, $message);

        echo $result;
    } else {
        echo "ผู้ใช้ลงทะเบียนแล้ว";
    }
} else {
    echo "ไม่มีค่า my ".$my;
}
?>
