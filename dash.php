<html>
<TITLE>Evilwatcher - Monitor domains and hosts attribution</title>
<!-- Credits to: Thiago Bordini thiago (at) bordini (dot) net -->
<head>
    <link rel="stylesheet" href="styles.css">
</head>
<?php
include("db.inc.php");
$conexao = mysql_connect($host,$username,$password);
$db = mysql_select_db($db);
mysql_query("SET character_set_results = 'utf8', character_set_client = 'utf8', character_set_connection = 'utf8', character_set_database = 'utf8', character_set_server = 'utf8'");
echo "<div class='text_title'>EvilWatcher - DashBoard<br></div><br>";
$consulta=mysql_query("SELECT * FROM servers where inactive = 0 and pause = 0");
echo "<div class='evil_table'>";
echo "<table border=1>";
echo "<tr>";
echo "<td>Server</td>";
echo "<td>DNS Host</td>";
echo "<td>DNS Target</td>";
echo "<td>DNS IP Target</td>";
echo "<td>Inserted</td>";
echo "<td>Qtd Checks</td>";
echo "<td>Last Check</td>";
echo "<td>Scanned</td>";
echo "<td>Same Host</td>";
echo "</tr>";
while ($dados = mysql_fetch_array($consulta)) {
	$id = $dados["id"];
	$consulta_dash=mysql_query("SELECT id,dns_host,dns_target,dns_ip_target,dns_timestamp,count,last_check,scanned,pause FROM dns_checks where id_server = $id and pause=0");
    while ($dados_dash = mysql_fetch_array($consulta_dash)){
		$id_host = $dados_dash["id"];
        if ($dados_dash["pause"]==0){
            $action = "1";
            $action_text = "Pause";
        } else {
            $action = "0";
            $action_text = "Play";
        }
	        echo "<tr>";
       		echo "<td><center><a href=monitor_all.php?id=".$id.">".$dados["name"]."</a></td>";
		    echo "<td><center><a href=monitor.php?id=".$id_host.">".$dados_dash["dns_host"] ."</a></td>";
            echo "<td><center>".$dados_dash["dns_target"]." </td>";
            echo "<td><center>".$dados_dash["dns_ip_target"]." - <a href=check_pause.php?id=" .$id_host . "&status=".$action.">[ ".$action_text." ]</a></td>";
            echo "<td><center>".date('d/m/Y H:i:s',strtotime($dados_dash["dns_timestamp"])) ."</td>";
            echo "<td><center>".$dados_dash["count"] ."</td>";
            echo "<td><center>".date('d/m/Y H:i:s',strtotime($dados_dash["last_check"])) ."</td>";
		if ($dados_dash["scanned"] == '0'){
			echo "<td><center>No </td>";
		} else {
            echo "<td><center><a href=view_ports_host.php?id=".$id_host.">Yes</a></td>";
		}
		echo "<td><center><a href=same_host.php?dnshost=".$dados_dash["dns_host"].">View all register same host</a></td>";
		echo "</tr>";
	}
}
echo "</table></div>";
echo "</center>";
?>
</HTML>
