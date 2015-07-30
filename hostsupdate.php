<html xmlns="http://www.w3.org/1999/html">
<TITLE>Evilwatcher - Monitor domains and hosts attribution</title>
<!-- Credits to: Thiago Bordini thiago (at) bordini (dot) net -->
<head>
    <link rel="stylesheet" href="assets/stylesheets/styles.css">
</head>
<meta http-equiv="content-type" content="text/html;charset=utf-8" />
<br>
<div class='text_title'>EvilWatcher<br></div><br>
<?
$id_key = $_GET['id'];
include("db.inc.php");
mysql_connect($host,$username,$password) or die(mysql_error());
mysql_select_db($db) or die(mysql_error());
mysql_query("SET character_set_results = 'utf8', character_set_client = 'utf8', character_set_connection = 'utf8', character_set_database = 'utf8', character_set_server = 'utf8'");
$sqlHosts = "Select * from servers where id=$id_key";

$rsHosts = mysql_query($sqlHosts) or die(mysql_error());

while ($hosts = mysql_fetch_array($rsHosts))
{
    echo "<form action=hostsupdated.php?id=".$hosts["id"]." method=post>";
    echo "<div class='evil_table'>";
    echo "<table>";
    echo "<tr><td>Update Host</td></tr>";
    echo "<tr><td>Host Name: <input type=text name=txtName size=37 value=".$hosts["name"]."><br></td></tr>";
    echo "<tr><td>Host Address: <input type=text name=txtAddress size=37 value=".$hosts["address"]."><br></td></tr>";
if ($hosts["full_portscan"] == 1){
	$active = "Checked";
} else {
	$active1 = "Checked";
}
echo "<tr><td>Full PortScan for all hosts found? <input type=radio name=txtFullPortScan value=0 ".$active1.">False <input type=radio name=txtFullPortScan value=1 ".$active.">True<br></td></tr>";
        $stop1 = DateTime::createFromFormat('Y-m-d',$hosts["stop_time"]);
        $stop = $stop1->format('d/m/Y');
    echo "<tr><td>Date Stop Checks (dd/mm/yyyy): <input type=text name=txtStopTime size=20 maxlength=10 value=".$stop."><br></td></tr>";
}
echo "<tr><td><input type=submit value=\"Update\"></form></td></tr>";
echo "</table></div>";
?><br>
<center><a href=hosts.php>Back</a>
<html>
