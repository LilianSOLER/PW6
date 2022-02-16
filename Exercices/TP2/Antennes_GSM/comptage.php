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
	return $res;
}

function number_antennes(&$array){
  return "Il y a " . count($array) . " antenne(s).\n";
}

function operateur(&$array){
  $res = 0;
  $operators = [];
  for($i = 0; $i < count($array); $i++){
    if(!in_array($array[$i]['OPERATEUR'], $operators)){
      $operators[] = $array[$i]['OPERATEUR'];
      $res++;
    }
  }
  return "Il y a " . $res . " opérateur(s).\n";
}