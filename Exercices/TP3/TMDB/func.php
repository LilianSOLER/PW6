<?php
require_once "config.php";

$api_prefix = 'http://api.themoviedb.org/3/';  //3rd API version

/**
 * TMDB query function
 * @param string $url_component (after the prefix)
 * @param array (associative) GET parameters (ex. ['language' => 'fr'])
 * @return string $content
**/
function tmdb_get($url_component, $params=null) {
  global $api_key, $api_prefix;
  $target_url = $api_prefix . $url_component . '?api_key=' . $api_key;
  $target_url .= (isset($params) ? '&' . http_build_query($params) : '');
  list($content, $info) = smartcurl($target_url);

  return json_decode($content);
}


/**
* curl wrapper
* @param string $url
* @return string $content
**/  
function smartcurl($url) {
  $ch = curl_init();
  curl_setopt($ch, CURLOPT_URL, $url);
  curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
  curl_setopt($ch, CURLOPT_USERAGENT, "php-libcurl");
  curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);

  $raw_content = curl_exec($ch);
  $info = curl_getinfo($ch);
  curl_close($ch);
  return [$raw_content, $info];
}

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
