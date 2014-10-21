<html xmlns="http://www.w3.org/1999/html">
<TITLE>Evilwatcher - Monitor domains and hosts attribution</title>
<!-- Credits to: Thiago Bordini thiago (at) bordini (dot) net -->
<head>
    <link rel="stylesheet" href="styles.css">
</head>
<meta http-equiv="content-type" content="text/html;charset=utf-8" />
<br>
<div class='text_title'>EvilWatcher - Manage Hosts Monitored<br></div><br>
<div class='text_p_bold' align="center">
<form action=hostinclude.php method=post><b>
    Host Name: <input type=text name=txtName size=37><br>
    Host Address: <input type=text name=txtAddress size=37><br>
    Full PortScan for all hosts found? <input type="radio" name="txtFullPortScan" value="0" checked>False <input type="radio" name="txtFullPortScan" value="1">True<br></b>
    Date Stop Checks (dd/mm/yyyy): <input type=text name=txtStopTime size=20 maxlength="10"><br>
    <input type=submit value="Insert"></form><br></div>
<?
include("db.inc.php");
mysql_connect($host,$username,$password) or die(mysql_error());
mysql_select_db($db) or die(mysql_error());

$sqlHosts = "Select * from servers where inactive=0 order by name asc";

$rsHosts = mysql_query($sqlHosts) or die(mysql_error());
echo "<div class='evil_table'>";
echo "<table>";
echo "<td>Name</td><td>Address</td><td>Full PortScan</td><td>Date Inserted</td><td>Date Stop Checks</td><td>Exclude</td><td>Update</td><td>Checks</td>";
while ($hosts = mysql_fetch_array($rsHosts))
{
if ($hosts["full_portscan"]==0){
	$port = "False";
} else {
	$port = "True";
}
    if ($hosts["pause"]==0){
        $action = "1";
        $action_text = "Pause";
    } else {
        $action = "0";
        $action_text = "Play";
    }
    $date_stop = $hosts["stop_time"];
    $data = date('Y-m-d');
    if ($date_stop <= $data){
        $expired = "<font color=red><b> - Check Expired</b></font>";
    } else {
        $expired = "";
    }
echo "<tr><td>". $hosts["name"] . "</td><td>" . $hosts["address"] . "</td><td>" . $port . "</td><td>" .  date('d/m/Y H:i:s',strtotime($hosts["date_time"])) . "</td><td>" .  date('d/m/Y',strtotime($date_stop)) . $expired ."</td><td>" . "<center><a href=hostsdelete.php?id=" .$hosts["id"] . ">[ X ]</a>" . "</td><td>" . "<center><a href=hostsupdate.php?id=" .$hosts["id"] . ">[ U ]</a>" . "</td><td>" . "<center><a href=host_pause.php?id=" .$hosts["id"] . "&status=".$action.">[ ".$action_text." ]</a></center></td></tr>";
}
echo "</table></div>";
?><br>
<a href=dash.php>Back</a>
<html>
