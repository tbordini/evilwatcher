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
$graph = "";
echo "<div class='text_title'>EvilWatcher - Global distribution of ASN/Providers for all domains<br></div><br>";
echo "<div class='evil_table'>";
echo "<table border=1>";
echo "<tr>";
echo "<td>Qtd</td>";
echo "<td>ASN ID</td>";
echo "<td>AS Name</td>";
echo "<td>Country Code</td>";
echo "</tr>";

	$consulta_stats=mysql_query("select count(asn_checks.id) qtd, asn_checks.asn, asn_checks.asname, asn_checks.cc from asn_checks WHERE asn <> '' group by asn_checks.asn order by qtd desc");
	while ($dados_stats = mysql_fetch_array($consulta_stats)){
                echo "<tr>";
                echo "<td><center>".$dados_stats["qtd"] ."</a></td>";
                echo "<td><center>".$dados_stats["asn"] ."</a></td>";
                echo "<td><center>".$dados_stats["asname"] ."</a></td>";
                echo "<td><center>".$dados_stats["cc"] ."</a></td>";
                echo "</tr>";
	}
echo "</table></div>";

        $consulta_graph=mysql_query("select count(asn_checks.id) qtd, asn_checks.asn, asn_checks.asname, asn_checks.cc from asn_checks WHERE asn <> '' group by asn_checks.cc order by qtd desc");
        while ($dados_graph = mysql_fetch_array($consulta_graph)){
		$graph .= "['".$dados_graph["cc"]."',".$dados_graph["qtd"]."],";
}

echo "
  <head>
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
    </script>
  </head>
  <body>
    <br><div class='text_title'>Geographic Distribution by ASN</div><br><br>
    <center><div id='chart_div' style='width: 800px; height: 500px; align: center'></div></center>
  </body>
";
echo "<br><br><div class='text_title'>EvilWatcher - Global reputation for all checks<br></div><br>";
echo "<div class='evil_table'>";
echo "<table border=1>";
echo "<tr>";
echo "<td>Qtd</td>";
echo "<td>Reputation</td>";
echo "<td>Category</td>";
echo "</tr>";

$consulta_stats_rep=mysql_query("SELECT count(category) as qtd, reputation, category FROM dns_checks group by reputation, category order by qtd desc");
while ($dados_stats_rep = mysql_fetch_array($consulta_stats_rep)){
    echo "<tr>";
    echo "<td><center>".$dados_stats_rep["qtd"] ."</a></td>";
    echo "<td><center>".$dados_stats_rep["reputation"] ."</a></td>";
    echo "<td><center>".$dados_stats_rep["category"] ."</a></td>";
    echo "</tr>";
}
echo "</table></div>";

echo "<br><a href=dash.php>Back</a>";
?>
</html>
