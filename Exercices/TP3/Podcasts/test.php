<?php
require_once('func.php');
require_once('date_func.php');

$Meth_Sci = "http://radiofrance-podcast.net/podcast09/rss_14312.xml";
$RSS_PODCAST_URL = [$Meth_Sci];
for($i = 0; $i < 10; $i++) {
    $RSS_PODCAST_URL[] = "http://radiofrance-podcast.net/podcast09/rss_143" . rand(10, 99) . ".xml";
}


function test_get_podcasts($tests){
  echo "Test get_podcast() ...\n\n";

  foreach($tests as $test){
    $url = $test;
    $podcasts = get_podcasts($url);
    echo "Url: $url\n";
    if($podcasts != -1){
      echo "Nombre de podcasts: " . count($podcasts) . "\n";
      foreach($podcasts as $podcast){
        echo $podcast['title'] . "\n";
      }
    }else{
      echo "Podcast not found";
    }
    echo "\n\n";
  }
  echo "Done.\n\n";
}

$UTC = [];
$SIGN = ["+", "-"];
for($i = 0; $i < 10; $i++){
  $sign = $SIGN[rand(0, 1)];
  $utc = rand(0, 9) . rand(0, 9);
  $UTC[] = implode("", [$sign, $utc, 0, 0]);
}

function test_normalize_utc($tests){
  echo "Test normalize_utc() ...\n\n";

  foreach($tests as $utc){
    echo $utc . " become " . normalize_utc($utc) . "\n\n";
  }

  echo "Done.\n\n";
}

$test_month_str_to_int = $MONTHS;
$shit_month_str = ["iufdhvqxlkc", "zefsqioudhjwx", "12254365", "-adzsqg12"];

for($i = 0; $i < 10; $i++){
  $test_month_str_to_int[] = $shit_month_str[rand(0, count($shit_month_str) - 1)];
}

function test_month_str_to_int($tests){
  echo "Test month_str_to_int() ...\n\n";

  foreach($tests as $month_str){
    echo $month_str;
    $date_mktime = month_str_to_int($month_str);
    if($date_mktime != -1){
      echo " become " . $date_mktime;
    }else{
      echo " can't be transform";
    }
    echo "\n\n";    
  }

  echo "Done.\n\n";
}

$DATES = [];
for($i = 0; $i < 10; $i++){
  $day = rand(0, 50);
  $str_month = $MONTHS[rand(0, count($MONTHS) -1)];
  $year = rand(0, 3000);
  $time = implode(":", [rand(0,24), rand(0,60),rand(0,60)]);
  $utc = $UTC[rand(0, count($UTC) - 1)];
  $DATES[] = implode(" ", ["XXX,", $day, $str_month, $year, $time, $utc]);
}

function test_date_to_mktime($tests){
  echo "Test date_to_mktime() ...\n\n";

  foreach($tests as $date){
    echo $date;
    $date_mktime = date_to_mktime($date);
    if($date_mktime != -1){
      echo " become " . date('Y-m-d H:i:s', $date_mktime);
    }else{
      echo " can't be transform";
    }
    echo "\n\n";    
  }

  echo "Done.\n\n"; 
}

$test_slice_podcast_by = 
[
  "podcasts" => get_podcasts($Meth_Sci),
  "slice_by" => ["week", "month", "year", "no"]
];

function test_slice_podcast_by($tests){
  echo "Test slice_podcast_by() ...\n\n";

  foreach($tests["slice_by"] as $slice_by){
    $podcasts = $tests['podcasts'];
    if($podcasts != -1){
      $podcast_sliced = slice_podcast_by($podcasts, $slice_by);
      echo "Slice by: $slice_by\n";
      if($podcast_sliced != -1){
        echo "Nombre de groupes de podcasts: " . count($podcast_sliced) . "\n";
        foreach($podcast_sliced as $key => $podcasts){
          echo "Nombre de podcasts dans le groupe $key: " . count($podcasts) . "\n";
          foreach($podcasts as $podcast){
            echo $podcast['title'] . " in " . date('Y-m-d H:i:s', $podcast["pubDate"]) . "\n";
          }
          echo "\n";
        }
      }else{
        echo "Podcast not found";
      }
    }else{
        echo "Podcast not found";
      }
    echo "\n\n";
  }
  echo "Done.\n\n";
}

$TESTS = [
  "get_podcasts" => $RSS_PODCAST_URL,
  "normalize_utc" => $UTC,
  "month_str_to_int" => $test_month_str_to_int,
  "date_to_mktime" => $DATES,
  "slice_podcast_by" => $test_slice_podcast_by,
];

//run tests with different functions and different tests
function TESTS($test){
  global $TESTS;
  $tests = $TESTS[$test]; //get tests array
  $function = "test_" . $test; //get function name
  $function($tests); //run function
}