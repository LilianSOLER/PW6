<?php
require_once 'comptage_func.php';
$FILE = 'data/DSPE_ANT_GSM_EPSG4326.csv';
$DIST_CLOSE = (float) 10000;
$array = csv_to_array($FILE);

$operators = operateur($array);
$str_operators = operateurs_to_string($operators);

$lon = "";
$lat = "";
$top = "";
$op = "";

if(isset($_GET['lon']) || isset($_GET['lat']) || isset($_GET['top']) || isset($_GET['op'])){
  $lon = $_GET['lon'];
  $lat = $_GET['lat'];
  $top = $_GET['top'];
  $op = $_GET['op'];
}


function display_form(){
  global $str_operators, $operators;
  $res = '
  <h1>Antennes - Webservice</h1>
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
    <p>
      <label for="op">De quel opérateur :</label>
      <select name="op" id="op">
      <option value="">--Please choose an option--</option>';
    
      for($i = 0; $i < count($str_operators); $i++){
        $res .= '<option value="' . $operators[$i][0] . '">' . $str_operators[$i] . '</option>';
      }
      $res .= '</select>
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

function display_info_geo($top, $lat, $lon, $op, &$array, &$DIST_CLOSE){
  $point = ["lon" => $lon, "lat" => $lat];
  $dists = distance_point_acces($array, $point, $op, "all", $DIST_CLOSE, $top);
  //print_r($dists);
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
  if(!isset($_GET['lon']) || !isset($_GET['lat']) || !isset($_GET['top']) || !isset($_GET['op'])){
    display_form();
  }else{
    display_info_geo($top, $lat, $lon, $op, $array, $DIST_CLOSE);
  }
  ?>
</body>
</html>