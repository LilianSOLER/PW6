<?php
function csv_to_array($file){
  $res = [];
  $lines = file($file, FILE_IGNORE_NEW_LINES);
  $legends = explode(';',$lines[0]);
	foreach ($lines as $line) {
		$line = explode(';', trim($line));
    $l = [];
    $i = 0;
    foreach($line as $value){
      $l[$legends[$i]] = [$value];
      $i++;
    }
    $res[] = $l;
  }
	return array_slice($res, 1);
}

function number_antennes($array){
  return "Il y a " . count($array) . " antenne(s).\n";
}

function operateur($array){
  $operators = [];
  for($i = 0; $i < count($array); $i++){
    if(!in_array($array[$i]['OPERATEUR'], $operators)){
      $operators[] = $array[$i]['OPERATEUR'];
    }
  }
  //echo "Il y a " . count($operators) . " opérateur(s).\n";
  return $operators;
}

function operateur_to_string($operator){
  switch($operator){
    case 'ORA':
      return 'Orange';
    case 'BYG':
      return 'Bouygues';
      break;
    default:
      return $operator;
  }  
}

function operateurs_to_string($operators){
  $res = [];
  foreach($operators as $operator){
    $res[] = operateur_to_string($operator[0]);
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


function adress_to_coord($adress){
  // $req = "https://api-adresse.data.gouv.fr/search/q=" . implode('+', explode(' ', $adress));
  // $rep = file_get_contents($req);
  // $rep = json_decode($rep);
  // if(!isset($rep->geometry->coordinates)){
  //   return -1;
  // }
  // return [
  //   "lon" => $rep->geometry->coordinates[0],
  //   "lat" => $rep->geometry->coordinates[1],
  // ];
  return [
    "lon" => 0,
    "lat" => 0,
  ];
}

function distance_point_acces($points, $point, $op, $mode, &$DIST_CLOSE, $number = -1){
  $res = [];
  $coord_point = adress_to_coord($point);
  $point["lon"] = $coord_point["lon"];
  $point["lat"] = $coord_point["lat"];
  foreach ($points as $p) {
    $coord_p = adress_to_coord($p["ANT_ADRES_LIBEL"][0]);
    $p["lon"] = $coord_p["lon"];
    $p["lat"] = $coord_p["lat"];
    if($op == $p["OPERATEUR"][0]){
      $dist = distance($point, $p);
      if($mode == "all" || $dist <= $DIST_CLOSE){
        $res[] = [
          "ANT_ID" => $p["ANT_ID"][0],
          "distance" => $dist,
          "coord" => $coord_p,
        ];
      }
    }
  }

  if($number != -1){
    $cols1 = array_column($res, 'distance');
    $cols2 = array_column($res, 'ANT_ID');
    array_multisort($cols1, $cols2, $res);

    $len = count($res);
    if($len < $number){$number = $len;}
    $res = array_slice($res, 0, $number);
  }
  return $res;
}