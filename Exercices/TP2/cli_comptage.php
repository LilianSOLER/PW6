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

function distance($p1, $p2){
  $coeffR = pi()/180;
  $lon1 = $p1["lon"];
  $lat1 = $p1["lat"];
  $lon2 = $p2["lon"];
  $lat2 = $p2["lat"];
  
  $x = ($lon2 - $lon1) * cos(($lat1 + $lat2)/2 * $coeffR);
  $y = $lat2 - $lat1;
  $d = sqrt($x*$x + $y*$y) * 6371;
  return $d;
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

$array = csv_to_array($FILE);
//print_r($array);
echo count($array) . " points d'accès \n";

$point1 = $array[rand(0, count($array)-1)];
echo "Point d'accès 1 choisi : " . $point1["name"] . " (" . $point1["lon"] . "," . $point1["lat"] . ")\n";

// $point2 = $array[rand(0, count($array)-1)];
// echo "Point d'accès 2 choisi : " . $point2["name"] . " (" . $point2["lon"] . "," . $point2["lat"] . ")\n";
// echo distance($point1, $point1) . " km\n";
// echo distance($point1, $point2) . " km\n";

//print_r(distance_point_acces($array, $point1, "all"));
//distance_point_acces($array, $point1, "closest");
print_r(distance_point_acces($array, $point1, "closest", $NUMBER_POINTS));