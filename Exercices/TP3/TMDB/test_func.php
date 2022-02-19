<?php
require_once "func.php";

$tests_tmdb_get = [
  ["url_component" => '', "params" => NULL],
  ["url_component" => 'movie/popular', "params" => ['language' => 'fr']],
  ["url_component" => 'movie/popular', "params" => ['language' => 'en']]
];

function test_tmdb_get($tests) {
  echo "Testing tmdb_get ...\n";

  foreach($tests as $test){
    print_r($test);
    $content = tmdb_get($test['url_component'], $test['params']);
    echo "URL: $test->url_component\n";
    echo "Content: ";
    print_r($content);
  }

  echo "Done.\n\n";
}

$LANGUAGES = ["fr", "en", "it", "de", "es", "pt", "ja", "ko", "zh"];
$tests_find_details = NULL;
for($i = 20; $i < 30; $i++){
  $tests_find_details[] = [
    "id" => rand(1, 100), 
    "params" => ['language' => $LANGUAGES[rand(0, count($LANGUAGES) - 1)]]
  ];
}

function test_find_details($tests) {
  echo "Testing find_details() ...\n\n";

  foreach($tests as $test){
    $id = $test['id'];
    $param = $test['params'];

    echo "ID: $id\n";
    $movie_details = find_details($id, $param);
    if($movies_details == -1){
      echo "Details introuvables pour l'id $id\n";
    }else{
      display_details($movie_details);
    }
    
  }

  echo "Done.\n\n";
}

function display_details($details){
  echo "Title: " . $details['title'] . "\n";
  echo "Original title: " . $details['original_title'] . "\n";
  if($details['tagline'] != -1){
    echo "Tagline: " . $details['tagline'] . "\n";
  }
  echo "Overview: " . $details['overview'] . "\n";
  echo "Link: " . $details['link'] . "\n";
  echo "Poster: " . $details['poster'] . "\n";
  echo "\n\n";
}

function test_find_details_n_lang($tests, $n = 3){
  echo "Testing find_details_n_lang() ...\n\n";

  foreach($tests as $test){
    $id = $test['id'];
    $param = $test['params'];

    echo "ID: $id\n";
    $movies_details = find_details_n_lang($id, $n);
    if($movies_details == -1){
      echo "Details introuvables pour l'id $id\n";
    }else{
      foreach($movies_details as $movie_details){
        display_details($movie_details);
      }
    }  
  }

  echo "Done.\n\n";

}