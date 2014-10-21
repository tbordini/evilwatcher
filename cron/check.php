<?php
include("../db.inc.php");
include("../geoipcity.inc");
include("../geoipregionvars.php");
$base = geoip_open($evil_path."/GeoLiteCity.dat",GEOIP_STANDARD);
require 'tldextractphp/tldextract.php';
$conexao = mysql_connect($host,$username,$password);
$db = mysql_select_db($db);
$data_check = date('Y-m-d');
$consulta=mysql_query("SELECT * FROM servers where inactive = 0 and pause = 0 and stop_time >= NOW()");

while ($dados = mysql_fetch_array($consulta)) {
    $id_server = $dados["id"];
    $servidor = $dados["address"];
    if(filter_var($servidor, FILTER_VALIDATE_IP) == false) {
        $components = tldextract($servidor);
        $servidor = $components->subdomain . "." . $components->domain . "." . $components->tld;
        $pos = strpos($servidor, '.');
        if ($pos == true){
            $dns_ip_target = $servidor;
        } else {
            $servidor = substr(substr($servidor,1),0,-1);
        }
        $dns_ip_target = gethostbyname($servidor);
    } else {
        $dns_ip_target = gethostbyname($servidor);
    }
    $localizacao = geoip_record_by_addr($base, "$dns_ip_target");
    $full_portscan = $dados["full_portscan"];
    if ($dns_ip_target != NULL) {
        $dns_host = $servidor;
        $dns_geo_country_code = $localizacao->country_code3;
        $dns_geo_country_name = addslashes($localizacao->country_name);
        if (isset($GEOIP_REGION_NAME[$localizacao->country_code][$localizacao->region])) {
            $dns_geo_region = addslashes($GEOIP_REGION_NAME[$localizacao->country_code][$localizacao->region]);
        } else {
            $dns_geo_region = "Indisponible";
        }
        $dns_geo_city = addslashes($localizacao->city);
        $dns_geo_latitude = $localizacao->latitude;
        $dns_geo_longitude = $localizacao->longitude;
        $dns_type = 'A';
        $wot = "http://api.mywot.com/0.4/public_link_json2?hosts=" . $dns_host;
        $wot .= "/&callback=process&key=" . $wot_api_key;
        $results = file_get_contents($wot);
        $tratado = substr(substr($results, 10), 0, -3);
        $conjunto = explode(":", $tratado);
        $reput = explode(",", substr($conjunto[3], 0, -5));
        $val_reput = trim(substr($reput[0], 2));
        $posicao = strpos($tratado, "categories");
        $posicao = $posicao + 16;
        $cat_id = substr(substr($tratado, $posicao), 0, 3);
        if ($val_reput >= 80) {
            $desc = "Excellent";
        } elseif ($val_reput >= 60) {
            $desc = "Good";
        } elseif ($val_reput >= 40) {
            $desc = "Unsatisfactory";
        } elseif ($val_reput >= 20) {
            $desc = "Poor";
        } elseif ($val_reput >= 0) {
            $desc = "Very Poor";
        }
        $category = array("101" => "Malware or viruses",
            "102" => "Poor customer experience",
            "103" => "Phishing",
            "104" => "Scam",
            "105" => "Potentially illegal",
            "201" => "Misleading claims or unethical",
            "202" => "Privacy risks",
            "203" => "Suspicious",
            "204" => "Hate, discrimination",
            "205" => "Spam",
            "206" => "Potentially unwanted programs",
            "207" => "Ads / pop-ups",
            "301" => "Online tracking",
            "302" => "Alternative or controversial medicine",
            "303" => "Opinions, religion, politics",
            "304" => "Other",
            "501" => "Good site");
        $category_desc = $category[$cat_id];
        $ips = mysql_query("SELECT id from dns_checks where dns_ip_target = '$dns_ip_target' and pause = 0");
        $qtd = mysql_num_rows($ips);
        while ($dados = mysql_fetch_array($ips)) {
            $id_check = $dados["id"];
        }
        if ($qtd == '0') {
            mysql_query("INSERT INTO dns_checks(id_server,dns_host,dns_type,dns_ip_target,dns_geo_country_code,dns_geo_country_name,dns_geo_region,dns_geo_city,dns_geo_latitude,dns_geo_longitude,dns_timestamp,last_check,val_reputation,reputation, category,full_portscan) values ('$id_server','$dns_host','$dns_type','$dns_ip_target','$dns_geo_country_code','$dns_geo_country_name','$dns_geo_region','$dns_geo_city','$dns_geo_latitude','$dns_geo_longitude',NOW(),NOW(),'$val_reput','$desc','$category_desc','$full_portscan')") or die (mysql_error());
        } else {
            mysql_query("UPDATE dns_checks SET count = count+1,last_check=NOW() WHERE id = '$id_check'");
        }
        $components = tldextract($servidor);
        $dominio = $components->domain . "." . $components->tld;
        $result = dns_get_record($dominio, DNS_ALL);
        for ($i = 0; $i < count($result); $i++) {
            $dns_host = $result[$i][host];
            $dns_type = $result[$i][type];
            $dns_ip = $result[$i][ip];
            $dns_target = $result[$i][target];
            $dns_ip_target = gethostbyname($dns_target);
            if(filter_var($dns_ip_target, FILTER_VALIDATE_IP) !== false){
            if ($dns_ip <> "" or $dns_target <> "" or $dns_ip_target <> "") {
                $localizacao = geoip_record_by_addr($base, "$dns_ip_target");
                if ($localizacao != NULL) {
                    $dns_geo_country_name = addslashes($localizacao->country_name);
                    $dns_geo_country_code = $localizacao->country_code3;
                    if (isset($GEOIP_REGION_NAME[$localizacao->country_code][$localizacao->region])) {
                        $dns_geo_region = addslashes($GEOIP_REGION_NAME[$localizacao->country_code][$localizacao->region]);
                    } else {
                        $dns_geo_region = "Indisponible";
                    }
                    $dns_geo_city = addslashes($localizacao->city);
                    $dns_geo_latitude = $localizacao->latitude;
                    $dns_geo_longigutde = $localizacao->longitude;
                }
                $ips = mysql_query("SELECT id from dns_checks where dns_ip_target = '$dns_ip_target' and pause = 0");
                $qtd = mysql_num_rows($ips);
                while ($dados = mysql_fetch_array($ips)) {
                    $id_check = $dados["id"];
                }
                if ($qtd == '0') {
                    $wot = "http://api.mywot.com/0.4/public_link_json2?hosts=" . $dns_host;
                    $wot .= "/&callback=process&key=" . $wot_api_key;
                    $results = file_get_contents($wot);
                    $tratado = substr(substr($results, 10), 0, -3);
                    $conjunto = explode(":", $tratado);
                    $reput = explode(",", substr($conjunto[3], 0, -5));
                    $val_reput = trim(substr($reput[0], 2));
                    $posicao = strpos($tratado, "categories");
                    $posicao = $posicao + 16;
                    $cat_id = substr(substr($tratado, $posicao), 0, 3);
                    if ($val_reput >= 80) {
                        $desc = "Excellent";
                    } elseif ($val_reput >= 60) {
                        $desc = "Good";
                    } elseif ($val_reput >= 40) {
                        $desc = "Unsatisfactory";
                    } elseif ($val_reput >= 20) {
                        $desc = "Poor";
                    } elseif ($val_reput >= 0) {
                        $desc = "Very Poor";
                    }
                    $category = array("101" => "Malware or viruses",
                        "102" => "Poor customer experience",
                        "103" => "Phishing",
                        "104" => "Scam",
                        "105" => "Potentially illegal",
                        "201" => "Misleading claims or unethical",
                        "202" => "Privacy risks",
                        "203" => "Suspicious",
                        "204" => "Hate, discrimination",
                        "205" => "Spam",
                        "206" => "Potentially unwanted programs",
                        "207" => "Ads / pop-ups",
                        "301" => "Online tracking",
                        "302" => "Alternative or controversial medicine",
                        "303" => "Opinions, religion, politics",
                        "304" => "Other",
                        "501" => "Good site");
                    $category_desc = $category[$cat_id];
                    mysql_query("INSERT INTO dns_checks(id_server,dns_host,dns_type,dns_target,dns_ip_target,dns_geo_country_code,dns_geo_country_name,dns_geo_region,dns_geo_city,dns_geo_latitude,dns_geo_longitude,dns_timestamp,last_check,val_reputation,reputation, category) values ('$id_server','$dns_host','$dns_type','$dns_target','$dns_ip_target','$dns_geo_country_code','$dns_geo_country_name','$dns_geo_region','$dns_geo_city','$dns_geo_latitude','$dns_geo_longitude',NOW(),NOW(),'$val_reput','$desc','$category_desc')") or die (mysql_error());
                } else {
                    mysql_query("UPDATE dns_checks SET count = count+1,last_check=NOW() WHERE id = '$id_check'");
                }
            }
            }
        }
        }
    }