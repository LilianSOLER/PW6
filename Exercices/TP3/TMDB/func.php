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

function find_details($id, $params = null) {
  $movie = tmdb_get('movie/' . $id, $params);

  if(isset($movie->success)){
    echo "Details introuvables pour l'id $id\n";
    return -1;
  }

  $movie_details = [
    'title' => $movie->title,
    'original_title' => $movie->original_title,
    'tagline' => -1,
    'overview' => $movie->overview,
    'link' => $movie->homepage,
  ];

  if(isset($movie->tagline)){
    $movie_details['tagline'] = $movie->tagline;
  }
  return $movie_details;
}

function find_details_n_lang($id, $n) {
  global $LANGUAGES;
  $movie_details = [];

  if($n == 0){
    return $movie_details;
  }
  if($n > count($LANGUAGES)){
    $n = count($LANGUAGES);
  }

  for($i = 0; $i < $n; $i++){
    $movie_details[] = find_details($id, ['language' => $LANGUAGES[$i]]);
  }
  return $movie_details;
}