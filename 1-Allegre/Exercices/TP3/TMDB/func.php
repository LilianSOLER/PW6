<?php
require_once ('config.php');//to get the api key

$LANGUAGES = ["fr", "en", "it", "de", "es", "pt", "ja", "ko", "zh"]; //TODO: add more languages
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

//find details of a movie by id (and language)
function find_details($id, $params = null) {
  global $BASE_URL, $POSTER_SIZES, $POSTER_SIZE_INDEX; //to get the poster sizes
  $movie = tmdb_get('movie/' . $id, $params); //get info about the movie

  if(isset($movie->success)){ //if the movie is not found (success = false) return -1 
    return -1;
  }

  $movie_details = [ //create an array with the movie details
    'id' => $id,
    'title' => $movie->title,
    'original_title' => $movie->original_title,
    'poster' => $BASE_URL . $POSTER_SIZES[$POSTER_SIZE_INDEX] . $movie->poster_path
  ];
  //add to the movie details optional fields if they exist
  if(isset($movie->overview) && $movie->overview != ''){
    $movie_details['overview'] = $movie->overview;
  }
  if(isset($movie->homepage) && $movie->homepage != ''){
    $movie_details['link'] = $movie->homepage;
  }
  if(isset($movie->tagline) && $movie->tagline != ''){
    $movie_details['tagline'] = $movie->tagline;
  }
  $movie = tmdb_get('movie/' . $id . '/videos', $params);
  if(isset($movie->results[0])){
    $movie_details['trailer'] = "https://www.youtube.com/watch?v=" . $movie->results[0]->key;
  }
  return $movie_details;
}

//find details of a movie by title in n different languages
function find_details_n_lang($id, $nlang) {
  global $LANGUAGES; //to get the languages
  $movie_details = [];

  if($nlang == 0){ //if the number of languages is 0, return the details of the movie in the default language
    return 1;
  }
  if($nlang > count($LANGUAGES)){//if the number of languages is greater than the number of languages, return the details of the movie in all languages
    $nlang = count($LANGUAGES);
  }

  for($i = 0; $i < $nlang; $i++){ //add the details of the movie in the n first languages
    $movie_details[] = find_details($id, ['language' => $LANGUAGES[$i]]);
  }
  return $movie_details;
}

//sort a list of movies by a specific field
function sort_movies_by($movies, $criteria) {
  if($movies == NULL){ //if the list of movies is empty, return -1
    echo "Aucun film trouvé\n";
    return -1;
  }
  if(count($movies) == 1){ //if the list of movies contains only one movie, return the movie
    return $movies;
  }
  if(!isset($movies[0]->$criteria)){ //if the list of movies doesn't contain the field, return -1
    echo "Critère $criteria introuvable\n";
    return -1;
  }

  $criteria_values = [];
  foreach($movies as $movie){ //add the values of the field to an array
    $criteria_values[] = $movie->$criteria;
  }
  array_multisort($criteria_values, SORT_ASC, $movies); //sort the array
  return $movies;
}

//find n movies by a specific field
function find_details_with_query($query, $nmovies, $params = null) {
  $movie_details = [];

  $movies_with_query = tmdb_get("search/movie", ["query" => $query]); //get the movies with the query

  if($movies_with_query->total_results == 0){ //if there are no movies with the query, return -1
    echo "Aucun film trouvé pour la recherche $query\n";
    return -1;
  }
  if($nmovies > $movies_with_query->total_results){ //if the number of movies is greater than the number of movies with the query, return the number of movies with the query
    $nmovies = $movies_with_query->total_results;
  }
  $movies_with_query = $movies_with_query->results;
  $movies_with_query = array_slice($movies_with_query, 0, $nmovies); //get the n first movies with the query
  $movies_with_query = sort_movies_by($movies_with_query, 'release_date'); //sort the movies by release date

  foreach($movies_with_query as $movie){ //add the details of the movies to an array
    $movie_details[] = find_details($movie->id, $params);
  }
  return $movie_details;
}

//find n movies by a specific field in n different languages
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

//find the id of a collection by its name
function get_collection_id($name){
  $tmp = tmdb_get("search/collection", ["query" => $name]); //get the collections with the query
  if(isset($tmp->success)){ //if the collection is not found (success = false) return -1
    echo "Aucune collection trouvée pour le nom $name\n";
    return -1;
  }
  if($tmp->total_results == 0){ //if there are no collections with the query, return -1
    echo "Aucune collection trouvée pour le nom $name\n";
    return -1;
  }
  return $tmp->results[0]->id; //return the id of the first collection with the query
}

//find movies in a collection
function get_movie_from_collection($id_collection){
  $collection = tmdb_get('collection/' . $id_collection);//get the collection
  if(isset($collection->success)){ //if the collection is not found (success = false) return -1
    echo "Collection introuvable pour l'id $id_collection\n";
    return -1;
  }
  return $collection->parts; //return the movies of the collection
}

//find actors in a movie
function get_actors($id){
  $movie = tmdb_get("movie/" . $id . "/credits"); //get the credit of a movie
  if(isset($movie->success)){ //if the movie is not found (success = false) return -1
    echo "Aucun acteur trouvé pour l'id $id\n";
    return -1;
  }
  $actors = [];
  foreach($movie->cast as $actor){
    unset($actor->adult, $actor->order);//remove the fields that are not needed
    $actors[] = $actor; //add the actors to an array
  }
  return $actors;
}

//find all actors in a collection
function get_collection_actors($id_collection){
  $movies = get_movie_from_collection($id_collection); //get the movies of the collection
  $ids = [];
  foreach($movies as $movie){//add the ids of the movies to an array
    $ids[] = $movie->id;
  }
  $actors = [];
  foreach($ids as $id){ //for each movie, get the actors and merge them to an array
    $actors = array_merge($actors, get_actors($id));
  }
  return $actors;
}

//find credit of an actor
function get_actor_credits($id_actor){
  $actor = tmdb_get("person/" . $id_actor . "/movie_credits"); //get the credit of an actor
  if(isset($actor->success)){ //if the actor is not found (success = false) return -1
    echo "Acteur introuvable pour l'id $id_actor\n";
    return -1;
  }
  $actor_credits = [];
  foreach($actor->cast as $actor_movie){ //for each movie of the actor, add the credit to an array
    $actor_credits[] = [
      "character" => $actor_movie->character,
      "movie_id" => $actor_movie->id,
      "movie_title" => $actor_movie->title
    ];
  }
  if(count($actor_credits) == 0){ //if the actor has no credit, return -1
    echo "Aucun film trouvé pour l'acteur $id_actor\n";
    return -1;
  }
  return $actor_credits;
}

//find the id of an actor by his name
function get_actor_id($name){
  $tmp = tmdb_get("search/person", ["query" => $name]); //get the actors with the query
  if(isset($tmp->success)){ //if the actor is not found (success = false) return -1
    echo "Aucun acteur trouvé pour le nom $name\n";
    return -1;
  }
  if($tmp->total_results == 0){ //if there are no actors with the query, return -1
    echo "Aucun acteur trouvé pour le nom $name\n";
    return -1;
  }
  return $tmp->results[0]->id; //return the id of the first actor with the query
}
