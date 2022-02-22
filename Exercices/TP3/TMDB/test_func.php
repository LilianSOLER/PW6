<?php
require_once ('func.php');

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
      echo "Details introuvables pour l'id $id\n";
    }else{
      display_details($movie_details);
    }  
  }

  echo "Done.\n\n";
}

function display_details($details){
  if(!isset($details['title'])){return ;}
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
    if(!in_array(-1, $movies_details)){
      foreach($movies_details as $movie_details){
        display_details($movie_details);
      }
    }  
  }

  echo "Done.\n\n";
}

$CRITERIAS = ["id", "original_title", "title", "popularity", "vote_average", "vote_count"];
$QUERY = ["Lord of The Rings", "Matrix", "Star Wars", "Harry Potter", "The Godfather", "The Shawshank Redemption", "The Godfather II", "The Dark Knight", "ihfuqdhsiu", "uhefSIDUQHLKUH", "IGUEZZFQISDGKI"];

$tests_sort_by = NULL;
for($i = 0; $i < 10; $i++){
  $query = $QUERY[rand(0, count($QUERY) - 1)];
  $movies = tmdb_get("search/movie", ["query" => $query])->results;
  $tests_sort_by[] = [
    "query" => $query,
    "movies" => $movies,
    "criteria" => $CRITERIAS[rand(0, count($CRITERIAS) - 1)]
  ];
}

function test_sort_by($tests){
  echo "Testing sort_movies_by() ...\n\n";

  foreach($tests as $test){
    $movies = $test['movies'];
    $criteria = $test['criteria'];
    $query = $test['query'];

    echo "Query: $query\n";
    echo "Critère: $criteria\n";
    $movies_sorted = sort_movies_by($movies, $criteria);
    if($movies_sorted == -1){
      echo "Critère $criteria introuvable\n";
    }else{
      foreach($movies_sorted as $movie){
        echo $movie->$criteria . "\n";
      }
    }
    echo "\n\n";
  }

  echo "Done.\n\n";
}

function test_find_details_with_query($tests){
  global $LANGUAGES;
  echo "Testing find_details_with_query() ...\n\n";

  foreach($tests as $test){
    $query = $test['query'];
    $nmovies = rand(0, 10);
    $param = ["language" => $LANGUAGES[rand(0, count($LANGUAGES) - 1)]];

    echo "Query: $query\n";
    echo "Nombre de résultats: $nmovies\n\n";
    $movies_details = find_details_with_query($query, $nmovies, $param);
    if($movies_details == -1){
      echo "Aucun film trouvé pour la recherche $query\n";
    }else{
      foreach($movies_details as $movie_details){
        display_details($movie_details);
      }
    }
    echo "\n\n";
  }
  echo "Done.\n\n";
}

function test_find_details_with_query_n_lang($tests){
  echo "Testing find_details_with_query_n_lang() ...\n\n";

  foreach($tests as $test){
    $query = $test['query'];
    $nmovies = rand(0, 10);
    $nlang = rand(0, 3);

    echo "Query: $query\n";
    echo "Nombre de résultats: $nmovies\n";
    echo "Nombre de langues: $nlang\n\n";
    $movies_details = find_details_with_query_n_lang($query, $nmovies, $nlang);
    if(!in_array(-1, $movies_details)){
      foreach($movies_details as $movie_details){
        foreach($movie_details as $movie){
          display_details($movie);
        }
      }
    }
    echo "\n\n";
  }
  echo "Done.\n\n";
}

$TESTS = 
[
  "tmdb_get" => $tests_tmdb_get,
  "find_details" => $tests_find_details,
  "find_details_n_lang" => $tests_find_details,
  "sort_by" => $tests_sort_by,
  "find_details_with_query" => $tests_sort_by,
  "find_details_with_query_n_lang" => $tests_sort_by
];

function TESTS($test){
  global $TESTS;
  $tests = $TESTS[$test];
  $function = "test_" . $test;
  $function($tests);
}

