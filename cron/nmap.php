<?php
include("../db.inc.php");
require_once 'Net/Nmap.php';
$conexao = mysql_connect($host,$username,$password);
$db = mysql_select_db($db);
$consulta1=mysql_query("SELECT * FROM nmap where deleted = 0");
while ($dados_nmap = mysql_fetch_array($consulta1)) {
    $id_nmap = $dados_nmap["id"];;
    $keyword = $dados_nmap["keyword"];
    $port_range = $dados_nmap["ports"];
	$servers=mysql_query("SELECT * FROM dns_checks where scanned = 0 and dns_ip_target <> '' and pause = 0 and full_portscan = 0 and (dns_target like '$keyword%' or dns_host like '$keyword%')");
	while ($dados = mysql_fetch_array($servers)) {
		$id_server = $dados["id"];
		$dns_ip_target = $dados["dns_ip_target"];
		$dns_target = $dados["dns_target"];
		$dns_host = $dados["dns_host"];
		$target = array($dns_ip_target);
		$options = array('nmap_binary' => $nmap_path);
		try {
			$nmap = new Net_Nmap($options);
			$nmap_options = array('os_detection' => false,
                          'service_info' => true,
                          'port_ranges' => $port_range,//to scan only specified ports
                          );
			$nmap->enableOptions($nmap_options);
			$res = $nmap->scan($target);
			$failed_to_resolve = $nmap->getFailedToResolveHosts();
			if (count($failed_to_resolve) > 0) {
				echo 'Failed to resolve given hostname/IP: ' .
				implode (', ', $failed_to_resolve) ."\n";
			}
			$hosts = $nmap->parseXMLOutput();
			foreach ($hosts as $key => $host) {
				$services = $host->getServices();
			foreach ($services as $key => $service) {
				if ($service->product <> ''){
					$port_status = "Open";	
				}else{
					$port_status = "Closed/Filtred";
				}
				mysql_query("INSERT INTO nmap_checks(id_server,id_nmap,service_name,port,protocol,prod_info,prod_ver,prod_add,port_status,timestamp) values ('$id_server','$id_nmap','$service->name','$service->port','$service->protocol','$service->product','$service->version','$service->extrainfo','$port_status',NOW())") or die (mysql_error());
				mysql_query("UPDATE dns_checks SET scanned = 1 WHERE id = '$id_server'");
			}
			}
		} catch (Net_Nmap_Exception $ne) {
			echo $ne->getMessage();
		}
	}
}
?>
