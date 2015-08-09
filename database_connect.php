<?php
$hostname="db01-smo";
$user="smartobec";
$password="8oojkiyd";
$dbname="smartobec";
$system_office_code="Smart_Obec";    //รหัสหน่วยงาน

$connect=mysqli_connect($hostname,$user,$password,$dbname) or die("Could not connect MySql");
mysqli_query($connect,"SET NAMES utf8");
?>
