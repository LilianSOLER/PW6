<?php
include_once("comptage_func.php");
$FILE = $argv[1];
$DIST_CLOSE = (float) $argv[2];
$NUMBER_POINTS = (int) $argv[3];
$array = csv_to_array($FILE);

//test_basic($array, $FILE);
//test_distance($array, $FILE);
//test_distance_array($array, $FILE,$NUMBER_POINTS, $DIST_CLOSE);
//test_basic_api($array, $FILE);
//test_curl_api_with_modification_csv($array, $FILE);
coordinates_to_adress_curl($FILE, $array);
