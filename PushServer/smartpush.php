<?php

function smartpush($uid,$message) {
    include "db_functions.php";
    include "gcm.php";
    $gcm = new GCM();
    $db = new DB_Functions();
    $users = $db->getAllUsers();
    if ($users != false)
        $no_of_users = mysql_num_rows($users);
    else
        $no_of_users = 0;

    if ($no_of_users > 0) {
        while ($row = mysql_fetch_array($users)) {

            $regId = $row['gcm_regid'];
            // $message = "สวัสดีชาวโลก";

            $registatoin_ids = array($regId);
            // $message = array("price" => $message);

            $result = $gcm->send_notification($registatoin_ids, $message);

            //echo $result;
        }
    } else {
        echo "ไม่มีข้อมูล";
    }
}
?>
