<?php
require_once ('config.php');

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
  global $BASE_URL, $POSTER_SIZES, $POSTER_SIZE_INDEX;
  $movie = tmdb_get('movie/' . $id, $params);

  if(isset($movie->success)){
    echo "Details introuvables pour l'id $id\n";
    return -1;
  }

  $movie_details = [
    'id' => $id,
    'title' => $movie->title,
    'original_title' => $movie->original_title,
    'tagline' => -1,
    'overview' => $movie->overview,
    'link' => $movie->homepage,
    'poster' => $BASE_URL . $POSTER_SIZES[$POSTER_SIZE_INDEX] . $movie->poster_path
  ];

  if(isset($movie->tagline)){
    $movie_details['tagline'] = $movie->tagline;
  }
  return $movie_details;
}

function find_details_n_lang($id, $nlang) {
  global $LANGUAGES;
  $movie_details = [];

  if($nlang == 0){
    return $movie_details;
  }
  if($nlang > count($LANGUAGES)){
    $nlang = count($LANGUAGES);
  }

  for($i = 0; $i < $nlang; $i++){
    $movie_details[] = find_details($id, ['language' => $LANGUAGES[$i]]);
  }
  return $movie_details;
}

function sort_movies_by($movies, $criteria) {
  if($movies == NULL){
    echo "Aucun film trouvé\n";
    return -1;
  }
  if(count($movies) == 1){
    return $movies;
  }
  if(!isset($movies[0]->$criteria)){
    echo "Critère $criteria introuvable\n";
    return -1;
  }

  $criteria_values = [];
  foreach($movies as $movie){
    $criteria_values[] = $movie->$criteria;
  }
  array_multisort($criteria_values, SORT_ASC, $movies);
  return $movies;
}

function find_details_with_query($query, $nmovies, $params = null) {
  $movie_details = [];

  $movies_with_query = tmdb_get("search/movie", ["query" => $query]);

  if($movies_with_query->total_results == 0){
    echo "Aucun film trouvé pour la recherche $query\n";
    return -1;
  }
  if($nmovies > $movies_with_query->total_results){
    $nmovies = $movies_with_query->total_results;
  }
  $movies_with_query = $movies_with_query->results;
  $movies_with_query = array_slice($movies_with_query, 0, $nmovies);
  $movies_with_query = sort_movies_by($movies_with_query, 'release_date');

  foreach($movies_with_query as $movie){
    $movie_details[] = find_details($movie->id, $params);
  }
  return $movie_details;
}

function find_details_with_query_n_lang($query, $nmovies, $nlang){
  global $LANGUAGES;
  $movie_details = [];

  if($nlang == 0){
    return $movie_details;
  }
  if($nlang > count($LANGUAGES)){
    $nlang = count($LANGUAGES);
  }

  for($i = 0; $i < $nlang; $i++){
    $movie_details[] = find_details_with_query($query, $nmovies, ['language' => $LANGUAGES[$i]]);
  }
  return $movie_details;  
}

function get_collection_id($name){
  $tmp = tmdb_get("search/collection", ["query" => $name]);
  if(isset($tmp->success)){
    echo "Aucune collection trouvée pour le nom $name\n";
    return -1;
  }
  if($tmp->total_results == 0){
    echo "Aucune collection trouvée pour le nom $name\n";
    return -1;
  }
  return $tmp->results[0]->id;
}

function get_movie_from_collection($id_collection){
  $collection = tmdb_get('collection/' . $id_collection);
  if(isset($collection->success)){
    echo "Collection introuvable pour l'id $id_collection\n";
    return -1;
  }
  return $collection->parts;
}

function get_actors($id){
  $movie = tmdb_get("movie/" . $id . "/credits");
  if(isset($movie->success)){
    echo "Aucun acteur trouvé pour l'id $id\n";
    return -1;
  }
  $actors = [];
  foreach($movie->cast as $actor){
    unset($actor->adult, $actor->order);
    $actors[] = $actor;
  }
  return $actors;
}


function get_collection_actors($id_collection){
  $movies = get_movie_from_collection($id_collection);
  $ids = [];
  foreach($movies as $movie){
    $ids[] = $movie->id;
  }
  $actors = [];
  foreach($ids as $id){
    $actors = array_merge($actors, get_actors($id));
  }
  return $actors;
}
