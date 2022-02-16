<?php
require_once 'comptage_func.php';
$FILE = $argv[1];
$DIST_CLOSE = (float) $argv[2];
$NUMBER_POINTS = (int) $argv[3];

$array = csv_to_array($FILE);

//print_r($array);
//echo number_antennes($array);
$operators = operateur($array);
print_r($operators);

$str_operators = operateurs_to_string($operators);
print_r($str_operators);

$random = rand(0, count($array) - 1);
adress_to_coord($array[$random]["ANT_ADRES_LIBEL"][0]);

