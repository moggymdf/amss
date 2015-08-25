<?php
//ini_set('display_errors',1);
//ini_set('display_startup_errors',1);
//error_reporting(-1);
$data = json_decode(file_get_contents("php://input"));
$username = $data->username;
$pass = $data->password;

require "service.php";
$amss = new amss();
echo $amss->getLogin($username,$pass);
?>
