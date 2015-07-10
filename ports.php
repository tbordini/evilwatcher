<html xmlns="http://www.w3.org/1999/html">
<TITLE>Evilwatcher - Monitor domains and hosts attribution</title>
<!-- Credits to: Thiago Bordini thiago (at) bordini (dot) net -->
<head>
    <link rel="stylesheet" href="assets/stylesheets/styles.css">
</head>
<meta http-equiv="content-type" content="text/html;charset=utf-8" />
<br>
<div class='text_title'>EvilWatcher - Ports for NMAP Check<br></div><br>
<div class='text_p_bold' align="center">
    <form action=portinclude.php method=post>
        <b>Port String: (ex:www) <input type=text name=txtKeyword size=37><br>
            Port Number: (ex:80 or 80,81,82)</b> <input type=text name=txtPorts size=37><br>
        <input type=submit value="Insert"></form><br>
<?
include("db.inc.php");
mysql_connect($host,$username,$password) or die(mysql_error());
mysql_select_db($db) or die(mysql_error());
mysql_query("SET character_set_results = 'utf8', character_set_client = 'utf8', character_set_connection = 'utf8', character_set_database = 'utf8', character_set_server = 'utf8'");

$sqlPorts = "Select * from nmap where deleted=0 order by keyword asc";

$rsPorts = mysql_query($sqlPorts) or die(mysql_error());
echo "<div class='evil_table'>";
echo "<table>";
echo "<td>Port String<td>Port Number(s)<td>Exclude<td>Update";
while ($ports = mysql_fetch_array($rsPorts))
{
echo "<tr><td>" . $ports["keyword"] . "<td>" . $ports["ports"] . "<td>" .
"<center><a href=portsdelete.php?id=" .$ports["id"] . ">[ X ]</a>" . "<td>" .
"<center><a href=portsupdate.php?id=" .$ports["id"] . ">[ U ]</a>";
}
echo "</table></div>";
?>
<a href=dash.php>Back</a></div>
</html>
