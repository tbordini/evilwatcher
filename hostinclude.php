<?php
$name = $_POST['txtName'];
$address = $_POST['txtAddress'];
$portscan = $_POST['txtFullPortScan'];
if ($_POST['txtStopTime'] == ''){
    $stop = date('Y-m-d', strtotime("+31 days"));
} else {
    $stop1 = DateTime::createFromFormat('d/m/Y',$_POST['txtStopTime']);
    $stop = $stop1->format('Y-m-d');
}
include 'db.inc.php';
mysql_connect($host,$username,$password) or die(mysql_error());
mysql_select_db($db) or die(mysql_error());
mysql_query("INSERT INTO servers (name,address,full_portscan,date_time,stop_time) values ('$name','$address','$portscan',now(),'$stop')") or die (mysql_error());
header('Location: hosts.php');
?>


