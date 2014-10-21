<?php

require 'tldextractphp/tldextract.php';
	$servidor = "www.skylan.com.br";
	$dns_ip_target = gethostbyname($servidor);
	$components = tldextract($servidor);
echo "DNS ip Target: ".$dns_ip_target."<br>\n";
	$dominio = $components->domain.".".$components->tld;
		$result = dns_get_record($dominio, DNS_ALL);
		for($i = 0; $i < count($result); $i++){
			$dns_host = $result[$i]['host'];
			$dns_type = $result[$i]['type'];
			$dns_ip = $result[$i]['ip'];
			$dns_target = $result[$i]['target'];
			$dns_ip_target = gethostbyname($dns_target);

echo "---------------------------------------------<br>\n";
echo "dominio ".$dominio."<br>\n";
echo "dns host ".$dns_host ."<br>\n";
echo "dns type ".$dns_type ."<br>\n";
echo "dns ip ".$dns_ip ."<br>\n";
echo "dns target ".$dns_target ."<br>\n";
echo "dns ip target ".$dns_ip_target ."<br>\n";
}





/*
preg_match("/^(irc.)?([^\/]+)/i",
		$servidor, $matches);
		$dominio = $matches[2];
*/
//$components = tldextract($servidor);
//echo "sub: ". $components->subdomain ."<br>\n"; // www
//echo "domain: ". $components->domain  ."<br>\n";    // bbc
//echo "tld: ". $components->tld  ."<br>\n";       // co.uk
//print_r(parse_url($servidor));

//echo "IP: ".gethostbyname(" ms56002912.msv1.invalid.outlook.com");


?>
