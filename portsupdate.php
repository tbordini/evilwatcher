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
$sqlPorts = "Select * from nmap where id=$id_key";

$rsPorts = mysql_query($sqlPorts) or die(mysql_error());

while ($ports = mysql_fetch_array($rsPorts))
{
    echo "<form action=portsupdated.php?id=".$ports["id"]." method=post>";
    echo "<div class='evil_table'>";
    echo "<table>";
    echo "<tr><td>Ports for NMAP Check</td></tr>";
    echo "<tr><td>Port String: (ex:www) <input type=text name=txtKeyword size=37 value=".$ports["keyword"]."></td></tr>";
    echo "<tr><td>Port Number: (ex:80 or 80,81,82) <input type=text name=txtPorts size=37 value=".$ports["ports"]."></td></tr>";
}

echo "<tr><td><input type=submit value=\"Update\"></form></td></tr>";
echo "</table></div>";
?><br>
<center><a href=ports.php>Back</a>
<html>
