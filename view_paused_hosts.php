<html>
<TITLE>Evilwatcher - Monitor domains and hosts attribution</title>
<!-- Credits to: Thiago Bordini thiago (at) bordini (dot) net -->
<head>
    <link rel="stylesheet" href="assets/stylesheets/styles.css">
</head>
<?php
include("db.inc.php");
$conexao = mysql_connect($host,$username,$password);
$db = mysql_select_db($db);
echo "<div class='text_title'>EvilWatcher - Show all hosts and servers with checks paused<br></div><br>";
$consulta=mysql_query("SELECT * FROM servers where inactive = 0 and pause = 1");
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
	$consulta_dash=mysql_query("SELECT id,dns_host,dns_target,dns_ip_target,dns_timestamp,count,last_check,scanned FROM dns_checks where id_server = $id");
	while ($dados_dash = mysql_fetch_array($consulta_dash)){
		$id_host = $dados_dash["id"];
	        
	        echo "<tr>";
       		echo "<td><center><a href=monitor_all.php?id=".$id.">".$dados["name"]."</a></td>";
		echo "<td><center><a href=monitor.php?id=".$id_host.">".$dados_dash["dns_host"] ."</a></td>";
                echo "<td><center>".$dados_dash["dns_target"]." </td>";
                echo "<td><center>".$dados_dash["dns_ip_target"]." </td>";
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
