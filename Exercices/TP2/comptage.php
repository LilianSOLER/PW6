<?php
require_once 'comptage_func.php';
$FILE = 'data/borneswifi_EPSG4326_20171004_utf8.csv';
$DIST_CLOSE = (float) 2000;
$array = csv_to_array($FILE);

$lon = "";
$lat = "";
$top = "";

if(isset($_GET['lon']) || isset($_GET['lat']) || isset($_GET['top'])){
  $lon = $_GET['lon'];
  $lat = $_GET['lat'];
  $top = $_GET['top'];
}


function display_form(){
  $res = '
  <h1>Points d\'accès wifi - Webservice</h1>
  <hr>
  <form action="comptage.php" method="get">
    <p>
      <label for="lat">Latitude :</label>
      <input type="number" name="lat" id="lat" min="0" max="90" step="0.001" required>
    </p>
    <p>
      <label for="lon">Longitude :</label>
      <input type="number" name="lon" id="lon" min="0" max="90" step="0.001" required>
    </p>
    <p>
      <label for="top">Combien voulez vous de site proche :</label>
      <input type="number" name="top" id="top" min="0" max="64" step="1" required>
    </p>
    <input type="submit" value="Calculer">
  </form>';
  echo $res;
}

function display_info(&$top, &$lat, &$lon, &$array, &$DIST_CLOSE){
  $point = ["lon" => $lon, "lat" => $lat];
  $dists = distance_point_acces($array, $point, "closest", $DIST_CLOSE, $top);
  $res = [];
  $rep = json_encode($rep);
  print_r($rep);
}

function display_info_geo(&$top, &$lat, &$lon, &$array, &$DIST_CLOSE){
  $point = ["lon" => $lon, "lat" => $lat];
  $dists = distance_point_acces($array, $point, "closest", $DIST_CLOSE, $top);
  $res = [];
  foreach($dists as $dist){
    $res[] = ["type" => "point", "coordinates" => $dist['coord']];
  }
  $rep = ["type" => "FeatureCollection", "features" => $res];
  $rep = json_encode($rep);
  print_r($rep);
}

?>

<!DOCTYPE html>
<html lang="fr">
<head>
  <meta charset="utf-8">
  <title>Points d'accès wifi - Webservice</title>
  <meta name="author" content="SOLER Lilian">
  <meta name="viewport" content="width=device-width; initial-scale=1.0">
  <link rel="stylesheet" href="theme.css">
</head>
<body>
  <?php
  if(!isset($_GET['lon']) || !isset($_GET['lat']) || !isset($_GET['top'])){
    display_form();
  }else{
    display_info_geo($top, $lat, $lon, $array, $DIST_CLOSE);
  }
  ?>
</body>
</html>