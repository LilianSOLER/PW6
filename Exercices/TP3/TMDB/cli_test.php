<?php
require_once ('test_func.php');

$CONFIGURATION_INFO = tmdb_get('configuration');
$BASE_URL = $CONFIGURATION_INFO->images->secure_base_url;
$POSTER_SIZES = $CONFIGURATION_INFO->images->poster_sizes;
$POSTER_SIZE_INDEX = rand(0, count($POSTER_SIZES) - 1);


// TESTS("tmdb_get");
// TESTS("find_details");
// TESTS("find_details_n_lang");
// print_r($CONFIGURATION_INFO);
// TESTS("sort_by");
// TESTS("find_details_with_query");
// TESTS("find_details_with_query_n_lang");
// print_r(get_Lords_Trilogy());
// print_r(get_Lords_Trilogy_v2());