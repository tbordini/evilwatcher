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
echo "<div class='evil_table'>";
echo "<table>";
	$consulta_checks=mysql_query("SELECT * FROM dns_checks where id = $id");
	while ($dados_checks = mysql_fetch_array($consulta_checks)){
		$id_host = $dados_checks["id"];
        echo "<tr><td><b>Displaying all the information from the host: </b>".$dados_checks["dns_host"] . " ( ".$dados_checks["dns_ip_target"]." )</td></tr>";
		echo "<tr><td><b><div align='left'>DNS Host : </b>". $dados_checks["dns_host"] ."<br>";
		echo "<b>DNS IP : </b>". $dados_checks["dns_ip"] ."<br>";
		echo "<b>DNS Type : </b>". $dados_checks["dns_type"] ."<br>";
		echo "<b>DNS Target : </b>". $dados_checks["dns_target"] ."<br>";
		echo "<b>DNS IP Target : </b>". $dados_checks["dns_ip_target"] ."<br>";
		echo "<b>Country Code : </b>". $dados_checks["dns_geo_country_code"] ."<br>";
		echo "<b>Country Name : </b>". $dados_checks["dns_geo_country_name"] ."<br>";
		echo "<b>Region : </b>". $dados_checks["dns_geo_region"] ."<br>";
		echo "<b>City : </b>". $dados_checks["dns_geo_city"] ."<br>";
		echo "<b>Latitude : </b>". $dados_checks["dns_geo_latitude"] ."<br>";
		echo "<b>Longitude : </b>". $dados_checks["dns_geo_longitude"] ."<br>";
		echo "<b>Inserted : </b>". date('d/m/Y H:i:s',strtotime($dados_checks["dns_timestamp"])) ."<br>";
		echo "<b>Qtd Checks : </b>". $dados_checks["count"] ."<br>";
		echo "<b>Last Check : </b>". date('d/m/Y H:i:s',strtotime($dados_checks["last_check"])) ."<br>";
		if ($dados_checks["reputation"]<> ""){
		echo "<b>Reputation : </b>". $dados_checks["reputation"];
		if ($dados_checks["val_reputation"] >= 80){
		    $img = "assets/images/excellent.png";
		} elseif ($dados_checks["val_reputation"] >= 60){
		    $img = "assets/images/good.png";
		} elseif ($dados_checks["val_reputation"] >= 40){
		    $img = "assets/images/unsatisfactory.png";
		} elseif ($dados_checks["val_reputation"] >= 20){
    		    $img = "assets/images/poor.png";
		} elseif ($dados_checks["val_reputation"] >= 0){
    		    $img = "assets/images/verypoor.png";
		}
		echo " <img src=".$img."> - ";
		echo "<b>Category Reputation : </b>". $dados_checks["category"] ."<br></div></td></tr>";
		}
		$consulta_asn=mysql_query("SELECT * from asn_checks where id_check = $id_host");
			while ($dados_asn = mysql_fetch_array($consulta_asn)){
				echo "<tr><td><b>ASN Information</b><br></td></tr>";
				echo "<tr><td><b><div align='left'>ID ASN : </b>". $dados_asn["asn"] . "<br>";
				echo "<b>AS Name: </b>". $dados_asn["asname"] . "<br>";
				echo "<b>IP ASN : </b>". $dados_asn["ip"] . "<br>";
				echo "<b>BGP Prefix :</b> ". $dados_asn["bgp_prefix"] . "<br>";
				echo "<b>Country Code :</b> ". $dados_asn["cc"] . "<br>";
				echo "<b>Registry : </b>". $dados_asn["registry"] . "<br>";
				echo "<b>Date allocated :</b> ". date('d/m/Y',strtotime($dados_asn["allocated"])) . "<br>";
				echo "</div></td></tr>";
			}
        echo "<tr><td><b>Portscan Result</b></td></tr>";
		if ($dados_checks["scanned"] == '0'){
			echo "<tr><td><b><div align='left'>Scanned : </b>No <br></div></td></tr>";
		} else {
			echo "<tr><td><b><div align='left'>Scanned : </b>Yes <br></div></td></tr>";
			$consulta_scan=mysql_query("SELECT nmap.keyword as keyword, nmap.ports as ports, nmap_checks.service_name as service_name, nmap_checks.port as check_port, nmap_checks.protocol as protocol, nmap_checks.prod_info as prod_info, nmap_checks.prod_ver as prod_ver, nmap_checks.prod_add as prod_add, nmap_checks.port_status as port_status, nmap_checks.timestamp as timestamp FROM nmap_checks,nmap where nmap_checks.id_server = $id_host and nmap_checks.id_nmap = nmap.id"); 
			while ($dados_port = mysql_fetch_array($consulta_scan)) {
 				echo "<tr><td><b><div align='left'>Keyword Triged : </b>". $dados_port["keyword"] . " <br>";
				echo "<b>Ports Scanned : </b>". $dados_port["ports"] . " <br>";
				echo "<b>Service Name : </b>". $dados_port["service_name"] . " <br>";
				echo "<b>Check port : </b>". $dados_port["check_port"] . " <br>";
				echo "<b>Protocol : </b>". $dados_port["protocol"] . " <br>";
				echo "<b>Product Information : </b>". $dados_port["prod_info"] . " <br>";
				echo "<b>Product Version : </b>". $dados_port["prod_ver"] . " <br>";
				echo "<b>Product Aditional Information : </b>". $dados_port["prod_add"] . " <br>";
				if ($dados_port["port_status"] == "Open"){
					$color = "green";
				}else{
					$color = "red";
				}
				echo "<b>Port Status : </b><font color=".$color.">". $dados_port["port_status"] . "</font> <br>";
				echo "<b>Date/Time Check : </b>". date('d/m/Y H:i:s',strtotime($dados_port["timestamp"])) . "</div></td></tr>";
			}

		}
	}
echo "</table></div>";
echo "<br><a href=\"javascript:window.history.go(-1)\">Back</a>";
?>
</html>
