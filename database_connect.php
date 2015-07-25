<?php
$hostname="localhost";
$user="amss";
$password="amss";
$dbname="amss";
$system_office_code="Smart_Obec";    //รหัสหน่วยงาน

$connect=mysqli_connect($hostname,$user,$password,$dbname) or die("Could not connect MySql");
mysqli_query($connect,"SET NAMES utf8");
?>
