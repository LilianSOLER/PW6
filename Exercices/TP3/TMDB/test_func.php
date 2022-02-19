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
    if($movie_details == -1){
      continue;
    }
    echo "Details: ";
    echo "Title: " . $movie_details['title'] . "\n";
    echo "Original title: " . $movie_details['original_title'] . "\n";
    if($movie_details['tagline'] != -1){
      echo "Tagline: " . $movie_details['tagline'] . "\n";
    }
    echo "Overview: " . $movie_details['overview'] . "\n";
    echo "Link: " . $movie_details['link'] . "\n";
    echo "\n\n";
  }

  echo "Done.\n\n";
}