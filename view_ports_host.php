<html xmlns="http://www.w3.org/1999/html">
<TITLE>Evilwatcher - Monitor domains and hosts attribution</title>
<!-- Credits to: Thiago Bordini thiago (at) bordini (dot) net -->
<head>
    <link rel="stylesheet" href="assets/stylesheets/styles.css">
</head>
<meta http-equiv="content-type" content="text/html;charset=utf-8" />
<?php
include("db.inc.php");
$conexao = mysql_connect($host,$username,$password);
$db = mysql_select_db($db);
mysql_query("SET character_set_results = 'utf8', character_set_client = 'utf8', character_set_connection = 'utf8', character_set_database = 'utf8', character_set_server = 'utf8'");
$id = $_GET['id'];
$consulta_checks=mysql_query("select dns_checks.id, dns_checks.id_server, dns_checks.dns_host, dns_checks.dns_target, servers.name, servers.address from dns_checks, servers
where servers.id = dns_checks.id_server and dns_checks.id = $id");
echo "<div class='evil_table'>";
echo "<table>";
	while ($dados_checks = mysql_fetch_array($consulta_checks)){
        echo "<tr><td><b>View all ports scanned from the server: </b>".$dados_checks["name"] . " ( ".$dados_checks["address"]." )</td></tr>";
		echo "<tr><td><b><div align='left'>Server : </b>". $dados_checks["name"] ."<br>";
		echo "<b>Address Server : </b>". $dados_checks["address"] ."<br>";
        if ($dados_checks["dns_target"] == "") {
            echo "<b>Host Scanned : </b>" . $dados_checks["dns_host"] . "<br>";
        } else {
            echo "<b>Host Scanned : </b>" . $dados_checks["dns_target"] . "<br>";
        }
        echo "</div></td></tr>";
        echo "<table>";
        echo "<tr>";
        echo "<td>Service Name</td>";
        echo "<td>Port Scanned</td>";
        echo "<td>Protocol</td>";
        echo "<td>Product Information</td>";
        echo "<td>Product Version</td>";
        echo "<td>Aditional Information</td>";
        echo "<td>Port Status</td>";
        echo "<td>Date/Time Check</td>";
        echo "</tr>";
			$consulta_scan=mysql_query("select * from nmap_checks where id_server = $id");
			while ($dados_port = mysql_fetch_array($consulta_scan)) {
                if ($dados_port["port_status"] == "Open"){
                    $color = "green";
                }else{
                    $color = "red";
                }
                echo "<tr>";
                echo "<td>". $dados_port["service_name"] . "</td>";
                echo "<td>". $dados_port["port"]. "</td>";
                echo "<td>". $dados_port["protocol"]. "</td>";
                echo "<td>". $dados_port["prod_info"]. "</td>";
                echo "<td>". $dados_port["prod_ver"]. "</td>";
                echo "<td>". $dados_port["prod_add"]. "</td>";
                echo "<td><font color=".$color.">". $dados_port["port_status"] . "</font></td>";
                echo "<td>". date('d/m/Y H:i:s',strtotime($dados_port["timestamp"]))  . "</td>";
                echo "</tr>";
			}
        echo "</table>";
        }
echo "</table></div>";
echo "<br><a href=\"javascript:window.history.go(-1)\">Back</a>";
?>
</html>
