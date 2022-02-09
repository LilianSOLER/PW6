<?php
$FILE = $argv[1];
$DIST_CLOSE = (float) $argv[2];
$NUMBER_POINTS = (int) $argv[3];

$array = csv_to_array($FILE);

function csv_to_array($file){
  $res = [];
  $lines = file($file, FILE_IGNORE_NEW_LINES);
	foreach ($lines as $line) {
		$l = explode(',', trim($line));
    if(isset($l[4])){
      $l = ["name" => $l[0], "adr" => $l[1], "lon" => (float) $l[2], "lat" => (float) $l[3], "adress_supp" => $l[4]];
    }else{
      $l = ["name" => $l[0], "adr" => $l[1], "lon" => (float) $l[2], "lat" => (float) $l[3]];
    }
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

function search_adress_csv($point,$csv){
  global $array;
  $res = [];
  $i = 0;
  foreach($array as $l){
    if($point["lat"] == $l["lat"] && $point["lon"] == $l["lon"]){
      if(!isset($l["adress_supp"])){
        $res[] = $i;
      }else{
        echo "Adresse de " . $l["name"] . " déjà ajoutée\n";
      }
    }
    $i++;
  }
  return $res;
}

function add_adress_csv($adress, $index, $csv){
  global $array;
  
  if($index != []){
    foreach($index as $i){
      $array[$i]['adress_supp'] = $adress;
      echo "Adresse de " . $array[$i]["name"] . " ajoutée\n";
    }
  }
  
  
  $content = '';
  foreach($array as $l){
    foreach($l as $info){
      $content .= $info . ',';
    }
    $content = rtrim($content, ",");
		$content .= "\n";
  }
  file_put_contents($csv, $content);
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

function smart_curl($url, $verb, $post_argument = -1){
  $ch = curl_init();
  curl_setopt($ch,CURLOPT_URL, $url);
  curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
  
  if($verb != -1){
    if($post_argument == -1){
      echo "Erreur, pas d'argument post";
      return -1;
    }
    curl_setopt($ch, CURLOPT_POST, true);
    curl_setopt($ch,CURLOPT_POSTFIELDS, $post_argument);
  }

  $output = curl_exec($ch);
  curl_close($ch);
  return $output;
}

function coordinate_to_adress_curl($point, $csv){
  $url = "https://api-adresse.data.gouv.fr/reverse/?lon=" . $point['lon'] . "&lat=" . $point['lat'];
  $verb = -1;
  $rep = smart_curl($url, $verb);
  $rep = json_decode($rep);
  if(!isset($rep->features[0]->properties->label)){
    return -1;
  }
  $adress = $rep->features[0]->properties->label;
  if(!isset($adress)){
    return -1;
  }  
  $index = search_adress_csv($point,$csv);
  if($index != []){
    add_adress_csv($adress, $index, $csv);
  }
  return $adress;
}

function fill_adress($times){
  global $array, $FILE;
  for ($i = 0; $i < $times; $i++) {
    $point = $array[rand(0, count($array)-1)];
    echo "Point d'accès " . $i . " choisi : " . $point["name"] . " (" . $point["lon"] . "," . $point["lat"] . ")\n";
    $adress = coordinate_to_adress_curl($point, $FILE );
    if($adress != -1){
      echo $adress;
    }
    echo "\n\n";
  }
}



//print_r($array);
//echo count($array) . " points d'accès \n";

// $point1 = $array[rand(0, count($array)-1)];
// echo "Point d'accès 1 choisi : " . $point1["name"] . " (" . $point1["lon"] . "," . $point1["lat"] . ")\n";

// $point2 = $array[rand(0, count($array)-1)];
// echo "Point d'accès 2 choisi : " . $point2["name"] . " (" . $point2["lon"] . "," . $point2["lat"] . ")\n";
// echo distance($point1, $point1) . " km\n";
// echo distance($point1, $point2) . " km\n";

//print_r(distance_point_acces($array, $point1, "all"));
//distance_point_acces($array, $point1, "closest");
//print_r(distance_point_acces($array, $point1, "closest", $NUMBER_POINTS));
//print_r(coordinate_to_adress($point1, $FILE)); echo "\n";
//print_r(coordinate_to_adress_curl($point1, $FILE )); echo "\n";

fill_adress(10);



