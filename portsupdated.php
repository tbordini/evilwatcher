<?php
$id_key = $_GET['id'];
$termo = $_POST['txtKeyword'];
$ports = $_POST['txtPorts'];
include 'db.inc.php';
mysql_connect($host,$username,$password) or die(mysql_error());
mysql_select_db($db) or die(mysql_error());
mysql_query("UPDATE nmap SET keyword='$termo',ports='$ports' where id=$id_key") or die (mysql_error());
header('Location: ports.php');
?>


