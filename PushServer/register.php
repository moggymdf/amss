<?php
$my = $_POST["regid"];
// response json
$json = array();
/**
 * Registering a user device
 * Store reg id in users table
 */
if (isset($my)) {
    $gcm_regid = $my; // GCM Registration ID
    // Store user details in db
    include_once './db_functions.php';
    include_once './gcm.php';

    $db = new DB_Functions();
    $gcm = new GCM();

    if ($db->getUser($gcm_regid)) {
        $res = $db->storeUser($gcm_regid);

        $registatoin_ids = array($gcm_regid);
        $message = "ยินดีต้อนรับสู่สำนักงานเขตพื้นที่การศึกษาประถมศึกษาสุรินทร์ เขต 3";

        $result = $gcm->send_notification($registatoin_ids, $message);

        echo $result;
    } else {
        echo "ผู้ใช้ลงทะเบียนแล้ว";
    }
} else {
    echo "ไม่มีค่า my ".$my;
}
?>
