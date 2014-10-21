<?php
$id_key = $_GET['id'];
include 'db.inc.php';
mysql_connect($host,$username,$password) or die(mysql_error());
mysql_select_db($db) or die(mysql_error());
mysql_query("UPDATE nmap SET deleted=1 where id=$id_key") or die (mysql_error());
header('Location: ports.php');
?>


