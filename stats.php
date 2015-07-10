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
$id_server = $_GET['id_server'];
$graph = "";
echo "<div class='evil_table'>";
echo "<table border=1>";
echo "<tr>";
echo "<td>Qtd</td>";
echo "<td>ASN ID</td>";
echo "<td>AS Name</td>";
echo "<td>Country Code</td>";
echo "</tr>";

	$consulta_stats=mysql_query("select count(asn_checks.asn) qtd, asn_checks.asn, asn_checks.asname, asn_checks.cc , asn_checks.id_check, dns_checks.id, dns_checks.id_server from asn_checks, dns_checks where asn_checks.id_check = dns_checks.id and  dns_checks.id_server = $id_server group by asn_checks.asn order by qtd desc");
	while ($dados_stats = mysql_fetch_array($consulta_stats)){

                echo "<tr>";
                echo "<td><center>".$dados_stats["qtd"] ."</a></td>";
                echo "<td><center>".$dados_stats["asn"] ."</a></td>";
                echo "<td><center>".$dados_stats["asname"] ."</a></td>";
                echo "<td><center>".$dados_stats["cc"] ."</a></td>";
                echo "</tr>";
	}
echo "</table></div>";

        $consulta_graph=mysql_query("select count(asn_checks.asn) qtd, asn_checks.asn, asn_checks.asname, asn_checks.cc , asn_checks.id_check, dns_checks.id, dns_checks.id_server from asn_checks, dns_checks where asn_checks.id_check = dns_checks.id and  dns_checks.id_server = $id_server group by asn_checks.cc order by qtd desc");
        while ($dados_graph = mysql_fetch_array($consulta_graph)){
		$graph .= "['".$dados_graph["cc"]."',".$dados_graph["qtd"]."],";
}

echo "
<br><div class='text_title'>Global distribution of ASN/Providers for this domain</div><br><br>
    <script type='text/javascript' src='https://www.google.com/jsapi'></script>
    <script type='text/javascript'>
     google.load('visualization', '1', {'packages': ['geochart']});
     google.setOnLoadCallback(drawRegionsMap);

      function drawRegionsMap() {
        var data = google.visualization.arrayToDataTable([
          ['Country', 'Qtd'],
          ".substr($graph,0,-1)."
        ]);

        var options = {};

        var chart = new google.visualization.GeoChart(document.getElementById('chart_div'));
        chart.draw(data, options);
    };
    </script><center>
    <div id=\"chart_div\" style=\"width: 600px; height: 400px;\" align='center'></div></center>

";
echo "<br><a href=\"javascript:window.history.go(-1)\">Back</a>";
?>
</html>
