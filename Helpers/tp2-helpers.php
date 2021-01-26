<?php

/**
 * @param float $lon
 * @param float $lat
 * @return array ['lon'=>float, 'lat'=>float]
 */
function geopoint($lon, $lat) {
  return ['lon'=>$lon, 'lat'=>$lat];
}

/* 
   @param $p array('lon'=>int, 'lat'=>int)
   @param $q array('lon'=>int, 'lat'=>int)
   @return int distance (approx.) in meters
*/
function distance ($p, $q) {
  $scale = 10000000 / 90; // longueur d'un degré le long d'un méridien
  $a = ((float)$p['lon'] - (float)$q['lon']);
  $b = (cos((float)$p['lat']/180.0*M_PI) * ((float)$p['lat'] - (float)$q['lat']));
  $res = $scale * sqrt( $a**2 + $b**2 );
  return (float)sprintf("%5.1f", $res);
}

/**
 * curl wrapper
 * @param string $url
 * @param int verb verbosity 0, 1, 2
 * @return string $content
 **/  
  
function smartcurl($url, $verb) {
    $ch = curl_init();
	
	if ($verb == 2) { echo "$url\n"; }
    if ($verb == 1) { echo "." ; }
    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);

    $output = curl_exec($ch);
    curl_close($ch);      

    return $output;
}




/*  return a standard accesspoint structure
    @param  array $row  numeric array matching a csv line
    @return array $accesspoint
*/
function initAccesspoint($row) {
  return array(
      'name' => $row[0], //string
      'adr' => $row[1],  //string
      'lon' => $row[2],  //float, in decimal degrees
      'lat' => $row[3]   //float, in decimal degrees
     );  
}
