<?php
$hostname="localhost";
$user="root";
$password="xxxxxx";
$dbname="amssplus";
$system_office_code="xxxx";    //รหัสหน่วยงาน

$connect=mysqli_connect($hostname,$user,$password,$dbname) or die("Could not connect MySql");
mysqli_query($connect,"SET NAMES utf8");
?>
