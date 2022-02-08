<?php
$FILE = $argv[1];

function csv_to_array($file){
  $res = [];
  $lines = file($file, FILE_IGNORE_NEW_LINES);
	foreach ($lines as $line) {
		$l = explode(',', trim($line));
		$res[] = array($l);
	}
	return $res;
}

$array = csv_to_array($FILE);
print_r($array);
echo count($array) . " points d'accès \n";
