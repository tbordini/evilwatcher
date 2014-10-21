<?php
$string = $_POST['txtKeyword'];
$ports = $_POST['txtPorts'];
include 'db.inc.php';
mysql_connect($host,$username,$password) or die(mysql_error());
mysql_select_db($db) or die(mysql_error());
mysql_query("INSERT INTO nmap (keyword,ports) values ('$string','$ports')") or die (mysql_error());
header('Location: ports.php');
?>


