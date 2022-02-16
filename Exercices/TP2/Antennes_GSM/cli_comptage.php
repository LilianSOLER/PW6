<?php
require_once 'comptage.php';
$FILE = $argv[1];
$DIST_CLOSE = (float) $argv[2];
$NUMBER_POINTS = (int) $argv[3];
$array = csv_to_array($FILE);

//print_r($array);
echo number_antennes($array);
echo operateur($array);