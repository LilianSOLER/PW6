<?php
require_once ('test_func.php');

$CONFIGURATION_INFO = tmdb_get('configuration');
$BASE_URL = $CONFIGURATION_INFO->images->secure_base_url;
$POSTER_SIZES = $CONFIGURATION_INFO->images->poster_sizes;
$POSTER_SIZE_INDEX = rand(0, count($POSTER_SIZES) - 1);

//test_tmdb_get($tests_tmdb_get);
test_find_details($tests_find_details);
//test_find_details_n_lang($tests_find_details);
//print_r($CONFIGURATION_INFO);