<?php
$MONTHS = [ "Jan", "Feb", "Mar", "Apr", "May", "Jun",
  "Jul", "Aug", "Sep", "Oct", "Nov", "Dec"];

function month_str_to_int($month_str){
  global $MONTHS;
  $i = 1;
  foreach($MONTHS as $month){
    if($month == $month_str){
      return $i;
    }
    $i++;
  }
  return -1;
}

function normalize_utc($utc_offset){
  $utc = $utc_offset[1] * 10 + $utc_offset[2];
  if($utc_offset[0] == "-"){
    $utc = -$utc;
  }
  return $utc;
}

function date_to_mktime($date){
  try{
    $date = explode(" ", $date);
    $day = $date[1];
    $month = month_str_to_int($date[2]);
    if($month == -1){
      return -1;
    }
    $year = $date[3];
    $time = explode(":", $date[4]);
    $hour = $time[0];
    $minute = $time[1];
    $second = $time[2];
    if(!is_numeric($hour) || !is_numeric($minute) || !is_numeric($second) || !is_numeric($month)
      || !is_numeric($day) || !is_numeric( $year) || !checkdate($month, $day, $year) ){      
      return -1;
    }
    return mktime($hour, $minute, $second, $month, $day, $year);
  }catch(Exception $e){
    return -1;
  }  
}

function sort_podcasts_by_mktime($podcasts){
  if($podcasts == NULL || count($podcasts) == 1){
    return -1;
  }
  $mktime = [];
  foreach($podcasts as $podcast){
    if($podcast == -1){
      $mktime[] = -1;
    }
    $mktime[] = $podcast['pubDate'];
  }
  array_multisort($mktime, SORT_ASC, $podcasts);
  return $podcasts;  
}