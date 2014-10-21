<?php
include("../db.inc.php");
$conexao = mysql_connect($host,$username,$password);
$db = mysql_select_db($db);
	$servers=mysql_query("SELECT * FROM dns_checks where check_asn = 0 and dns_ip_target <> ''");
	while ($dados = mysql_fetch_array($servers)) {
		$id_server = $dados["id"];
		$dns_ip_target = $dados["dns_ip_target"];
		$data = `whois -h whois.cymru.com -v $dns_ip_target`;
		$campos = explode("|", $data);
		$asn = preg_replace("/[^0-9]/", "",substr(trim($campos[6]), -6));
		$ip = trim($campos[7]);
		$bgp_prefix = trim($campos[8]);
		$cc = trim($campos[9]);
		$registry = trim($campos[10]);
		$allocated = trim($campos[11]);
		$asname = mb_convert_encoding(trim($campos[12]), 'ISO-8859-1','auto');
        if ($asn <> "" or $asname <> "" or $ip <> "") {
            mysql_query("INSERT INTO asn_checks(id_check,asn,ip,bgp_prefix,cc,registry,allocated,asname,timestamp) values ('$id_server','$asn','$ip','$bgp_prefix','$cc','$registry','$allocated','$asname',NOW())") or die (mysql_error());
            mysql_query("UPDATE dns_checks SET check_asn = 1 WHERE id = '$id_server'");
        }
    }
?>
