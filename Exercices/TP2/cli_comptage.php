<?php
$FILE = $argv[1];
$DIST_CLOSE = (float) $argv[2];
$NUMBER_POINTS = (int) $argv[3];

function csv_to_array($file){
  $res = [];
  $lines = file($file, FILE_IGNORE_NEW_LINES);
	foreach ($lines as $line) {
		$l = explode(',', trim($line));
    $l = ["name" => $l[0], "adr" => $l[1], "lon" => (float) $l[2], "lat" => (float) $l[3]];
    $res[] = $l;
  }
	return $res;
}

function distance ($p, $q) {
  $scale = 10000000 / 90; // longueur d'un degré le long d'un méridien
  $a = ((float)$p['lon'] - (float)$q['lon']);
  $b = (cos((float)$p['lat']/180.0*M_PI) * ((float)$p['lat'] - (float)$q['lat']));
  $res = $scale * sqrt( $a**2 + $b**2 );
  return (float)sprintf("%5.1f", $res);
}


function distance_point_acces($points, $point, $mode, $number = -1){
  global $DIST_CLOSE;
  $res = [];
  foreach ($points as $p) {
    $dist = distance($point, $p);
    if($mode == "all" || $dist <= $DIST_CLOSE){
      $res[] = [
        "name" => $p["name"],
        "distance" => $dist,
      ];
    }
  }

  if($number != -1){
    $cols1 = array_column($res, 'distance');
    $cols2 = array_column($res, 'name');
    array_multisort($cols1, $cols2, $res);

    $len = count($res);
    if($len < $number){$number = $len;}
    $res = array_slice($res, 0, $number);
  }
  return $res;
}

function coordinate_to_adress($point){
  $req = "https://api-adresse.data.gouv.fr/reverse/?lon=" . $point['lon'] . "&lat=" . $point['lat'];
  $rep = file_get_contents($req);
  $rep = json_decode($rep);
  if(!isset($rep->features[0]->properties->label)){
    return -1;
  }
  return $rep->features[0]->properties->label;
}


$array = csv_to_array($FILE);
print_r($array);
echo count($array) . " points d'accès \n";

$point1 = $array[rand(0, count($array)-1)];
echo "Point d'accès 1 choisi : " . $point1["name"] . " (" . $point1["lon"] . "," . $point1["lat"] . ")\n";

// $point2 = $array[rand(0, count($array)-1)];
// echo "Point d'accès 2 choisi : " . $point2["name"] . " (" . $point2["lon"] . "," . $point2["lat"] . ")\n";
// echo distance($point1, $point1) . " km\n";
// echo distance($point1, $point2) . " km\n";

//print_r(distance_point_acces($array, $point1, "all"));
//distance_point_acces($array, $point1, "closest");
//print_r(distance_point_acces($array, $point1, "closest", $NUMBER_POINTS));
//coordinate_to_adress($point1) . "\n";