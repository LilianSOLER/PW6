<?php
require_once ('test_func.php');

$CONFIGURATION_INFO = tmdb_get('configuration'); //get configuration info
$BASE_URL = $CONFIGURATION_INFO->images->secure_base_url;
$POSTER_SIZES = $CONFIGURATION_INFO->images->poster_sizes;
$POSTER_SIZE_INDEX = rand(0, count($POSTER_SIZES) - 1); //choose a random poster size

//TEST
// TESTS("tmdb_get"); 
// TESTS("find_details");
// TESTS("find_details_n_lang");
// print_r($CONFIGURATION_INFO);
// TESTS("sort_by");
// TESTS("find_details_with_query");
// TESTS("find_details_with_query_n_lang");
// TESTS("get_collection_id");
// TESTS("get_movie_from_collection");
// TESTS("get_actors");
// TESTS("get_collection_actors");
// TESTS("get_actor_credits");
//TESTS("get_actor_id");

//QUESTIONS
//echo "Il y a " . count(get_collection_actors(get_collection_id("Lord of the Rings"))) . " acteurs dans The Lord of the Rings\n";
//echo "Il y a " . count(get_collection_actors(get_collection_id("Hobbit"))) . " acteurs dans The Hobbit\n";
//print_r(find_details_with_query("Brad Pitt", 10));