<html xmlns="http://www.w3.org/1999/html">
<TITLE>Evilwatcher - Monitor domains and hosts attribution</title>
<!-- Credits to: Thiago Bordini thiago (at) bordini (dot) net -->
<head>
    <link rel="stylesheet" href="styles.css">
</head>
<meta http-equiv="content-type" content="text/html;charset=utf-8" />
<?php
include("db.inc.php");
$conexao = mysql_connect($host,$username,$password);
$db = mysql_select_db($db);
mysql_query("SET character_set_results = 'utf8', character_set_client = 'utf8', character_set_connection = 'utf8', character_set_database = 'utf8', character_set_server = 'utf8'");
$dnshost = $_GET['dnshost'];
echo "<div class='evil_table'>";
echo "<table>";
echo "<tr><td>View all register same host</td></tr>";
echo "<tr><td><b>Host : </b>" .$dnshost . "<br></td></tr>";

echo "<table border=1>";
echo "<tr>";
echo "<td>DNS IP</td>";
echo "<td>DNS Type</td>";
echo "<td>DNS Target</td>";
echo "<td>DNS IP Target</td>";
echo "<td>Country Code</td>";
echo "<td>Country Name </td>";
echo "<td>Region</td>";
echo "<td>City</td>";
echo "<td>Latitude</td>";
echo "<td>Longitude</td>";
echo "<td>Inserted</td>";
echo "<td>Qtd Checks</td>";
echo "<td>Last Check</td>";
echo "</tr>";
	$consulta_checks1=mysql_query("SELECT * FROM dns_checks where dns_host = '$dnshost' order by last_check asc");
	while ($dados_checks1 = mysql_fetch_array($consulta_checks1)){
		echo "<tr>";
		$id_host = $dados_checks1["id"];
		echo "<td>". $dados_checks1["dns_ip"] ."</td>";
		echo "<td>". $dados_checks1["dns_type"] ."</td>";
		echo "<td>". $dados_checks1["dns_target"] ."</td>";
		echo "<td>". $dados_checks1["dns_ip_target"] ."</td>";
		echo "<td>". $dados_checks1["dns_geo_country_code"] ."</td>";
		echo "<td>". $dados_checks1["dns_geo_country_name"] ."</td>";
		echo "<td>". $dados_checks1["dns_geo_region"] ."</td>";
		echo "<td>". $dados_checks1["dns_geo_city"] ."</td>";
		echo "<td>". $dados_checks1["dns_geo_latitude"] ."</td>";
		echo "<td>". $dados_checks1["dns_geo_longitude"] ."</td>";
		echo "<td>". date('d/m/Y H:i:s',strtotime($dados_checks1["dns_timestamp"])) ."</td>";
		echo "<td>". $dados_checks1["count"] ."</td>";
		echo "<td>". date('d/m/Y H:i:s',strtotime($dados_checks1["last_check"])) ."</td>";
		echo "</tr>";
	}
echo "</table></div></table>";
echo "<br><a href=\"javascript:window.history.go(-1)\">Back</a>";
?>
</html>
