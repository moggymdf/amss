<?php

class DB_Functions {

    private $db;
    // constructor
    function __construct() {
        include_once './db_connect.php';
        // connecting to database
        $this->db = new DB_Connect();
        $this->db->connect();
    }

    // destructor
    function __destruct() {}

    /**
     * Storing new user
     * returns user details
     */
    public function storeUser($gcm_regid) {
            // insert user into database
            $result = mysql_query("INSERT INTO gcm_users (id, gcm_regid, created_at) VALUES(NULL, '$gcm_regid', NOW())");
            // check for successful store
            if ($result) {
                // get user details
                $id = mysql_insert_id(); // last inserted id
                $result = mysql_query("SELECT * FROM gcm_users WHERE id = $id") or die(mysql_error());
                // return user details
                if (mysql_num_rows($result) > 0) {
                    return mysql_fetch_array($result);
                } else {
                    return false;
                }
            } else {
                return false;
            }

    }

    /**
     * เลือกผู้ใช้ทุกคน
     */
    public function getAllUsers() {
        $result = mysql_query("select * FROM gcm_users");
        return $result;
    }

    public function getUser($gcm_regid) {
        $result = mysql_query("select * FROM gcm_users WHERE gcm_regid='$gcm_regid'");
        $no_of_row = mysql_num_rows($result);
        if ($no_of_row > 0) {
            return false;
        } else {
            return true;
        }
    }

}

?>
