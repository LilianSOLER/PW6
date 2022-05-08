<?php
require_once ('func.php');

$tests_tmdb_get = [
  ["url_component" => '', "params" => NULL], //test without any url_component
  ["url_component" => 'movie/popular', "params" => ['language' => 'fr']], //test with all argument
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

$LANGUAGES = ["fr", "en", "it", "de", "es", "pt", "ja", "ko", "zh"]; //TODO: add more languages
$tests_find_details = NULL;
for($i = 0; $i < 10; $i++){
  $tests_find_details[] = [ //test with random movie id and random language
    "id" => rand(1, 1000), 
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
    if($movie_details != -1){
      display_details($movie_details);
    }
    else{
      echo "Movie not found.\n";
    }
    echo "\n";
  }

  echo "Done.\n\n";
}

//display details of a movie
function display_details($details){
  if(!isset($details['title'])){return ;}
  echo "Title: " . $details['title'] . "\n";
  echo "Original title: " . $details['original_title'] . "\n";
  if(isset($details['tagline'])){
    echo "Tagline: " . $details['tagline'] . "\n";
  }
  if(isset($details['overview'])){
    echo "Overview: " . $details['overview'] . "\n";
  }
  if(isset($details['link'])){
    echo "Link: " . $details['link'] . "\n";
  }
  echo "Poster: " . $details['poster'] . "\n";
  if(isset($details['trailer'])){
    echo "Trailer: " . $details['trailer'] . "\n";
  }
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
    echo "\n";
  }

  echo "Done.\n\n";
}

$CRITERIAS = ["id", "original_title", "title", "popularity", "vote_average", "vote_count"]; //all possible criterias
$QUERY = ["Lord of The Rings", "Matrix", "Star Wars", "Harry Potter", "The Godfather", "The Shawshank Redemption", "The Godfather II", "The Dark Knight", "ihfuqdhsiu", "uhefSIDUQHLKUH", "IGUEZZFQISDGKI"]; //different queries, true titles and false titles

$tests_sort_by = NULL;
for($i = 0; $i < 10; $i++){
  $query = $QUERY[rand(0, count($QUERY) - 1)];
  $movies = tmdb_get("search/movie", ["query" => $query])->results;
  $tests_sort_by[] = [ //test with random query and random criterias
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
    if($movies_sorted != -1){
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
    if($movies_details != -1){
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

$COLLECTIONS_NAME = ["Avengers", "Star Wars", "Harry Potter", "Lord of The Rings", "The Godfather", "The Shawshank Redemption", "The Godfather", "Batman", "Matrix", "Terminator", "fdsqihxcgkl", "uhefSIDUQHLKUH", "IGUEZZFQISDGKI"]; //different collections names, true names and false names
$test_collections = NULL;
for($i = 0; $i < 10; $i++){
  $name = $COLLECTIONS_NAME[rand(0, count($COLLECTIONS_NAME) - 1)];
  $test_collections[] = [ //test with random collection name
    "name" => $name,
  ];
}

function test_get_collection_id($tests){
  echo "Testing get_collection_id() ...\n\n";

  foreach($tests as $test){
    $collection_name = $test['name'];
    $collection_id = get_collection_id($collection_name);
    if($collection_id != -1){
      echo "Collection name: $collection_name\n";
      echo "Collection id: $collection_id\n";
    }
    echo "\n\n";
  }
  echo "Done.\n\n";
}

function test_get_movie_from_collection($tests){
  echo "Testing get_movie_from_collection() ...\n\n";

  foreach($tests as $test){
    $collection_name = $test['name'];
    $collection_id = get_collection_id($collection_name);
    if($collection_id != -1){
      echo "Collection name: $collection_name\n";
      echo "Collection id: $collection_id\n";
      $movies = get_movie_from_collection($collection_id);
      if($movies == -1){
        echo "Collection $collection_name introuvable\n";
      }else{
        foreach($movies as $movie){
          echo $movie->title . "\n";
        }
      }
    }
    echo "\n\n";
  }
  echo "Done.\n\n";
}

$n_tests_get_actors = rand(3, 10); //random number of tests

function test_get_actors($n_tests){
  echo "Testing get_actors() ...\n\n";

  for($i = 0; $i < $n_tests; $i++){
    $id = rand(0, 1000);
    $actors = get_actors($id);
    if($actors != -1){
      echo "Movie id: $id\n";
      echo "Nombre d'acteurs: " . count($actors) . "\n";
      foreach($actors as $actor){
        echo $actor->name . "\n";
      }
    }
    echo "\n\n";
  }
  echo "Done.\n\n";
}

function test_get_collection_actors($tests){
  echo "Testing collection_actors() ...\n\n";

  foreach($tests as $test){
    $collection_name = $test['name'];
    $collection_id = get_collection_id($collection_name);
    if($collection_id != -1){
      echo "Collection name: $collection_name\n";
      echo "Collection id: $collection_id\n";
      $actors = get_collection_actors($collection_id);
      if($actors != -1){
        echo "Nombre d'acteurs: " . count($actors) . "\n";
        foreach($actors as $actor){
          echo $actor->name . "\n";
        }
      }
    }
    echo "\n\n";
  }
  echo "Done.\n\n";
}


function test_get_actor_credits($tests){
  echo "Testing get_actor_credits() ...\n\n";

  foreach($tests as $test){
    $actor_credits = get_actor_credits($test['id']);
    if($actor_credits != -1){
      echo "Actor id: " . $test['id'] . "\n";
      echo "Nombre de films: " . count($actor_credits) . "\n";
      foreach($actor_credits as $actor_credit){
        echo $actor_credit["movie_title"] . " as " . $actor_credit["character"] . "\n";
      }
    }
    echo "\n\n";
  }
  echo "Done.\n\n"; 
}

$HOBBIT_ACTORS = get_collection_actors(get_collection_id("Hobbit")); //get actors of Hobbit collection
$SHIT = ["ejdfhkq", "eqzdsfuihkj", "iohlkefzqnsdk", "euçazfsdyqikjh"]; //false actors name
$test_get_actor_id = NULL;
for($i = 0; $i < $n_tests_get_actors; $i++){
  $test_get_actor_id[] = [$HOBBIT_ACTORS[rand(0, count($HOBBIT_ACTORS) - 1)]->name]; //random actor from Hobbit collection
}

for($i = 0; $i < $n_tests_get_actors; $i++){
  $test_get_actor_id[] = [$SHIT[rand(0, count($SHIT) - 1)]]; //random false actor name
}

function test_get_actor_id($tests){
  echo "Testing get_actor_id() ...\n\n";

  foreach($tests as $test){
    $actor_id = get_actor_id($test[0]);
    if($actor_id != -1){
      echo "Actor name: " . $test[0] . "\n";
      echo "Actor id: $actor_id\n";
    }
    echo "\n\n";
  }
  echo "Done.\n\n";
}
  


//different tests and his tests array
$TESTS = 
[
  "tmdb_get" => $tests_tmdb_get,
  "find_details" => $tests_find_details,
  "find_details_n_lang" => $tests_find_details,
  "sort_by" => $tests_sort_by,
  "find_details_with_query" => $tests_sort_by,
  "find_details_with_query_n_lang" => $tests_sort_by,
  "get_collection_id" => $test_collections,
  "get_movie_from_collection" => $test_collections,
  "get_actors" => $n_tests_get_actors,
  "get_collection_actors" => $test_collections,
  "get_actor_credits" => $tests_find_details,
  "get_actor_id" => $test_get_actor_id
];

//run tests with different functions and different tests
function TESTS($test){
  global $TESTS;
  $tests = $TESTS[$test]; //get tests array
  $function = "test_" . $test; //get function name
  $function($tests); //run function
}

