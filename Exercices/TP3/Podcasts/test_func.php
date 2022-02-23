<?php
require_once('func.php');

$RSS_PODCAST_URL = [];
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

$TESTS = [
  "get_podcasts" => $RSS_PODCAST_URL,
];

//run tests with different functions and different tests
function TESTS($test){
  global $TESTS;
  $tests = $TESTS[$test]; //get tests array
  $function = "test_" . $test; //get function name
  $function($tests); //run function
}