<?php
require_once('vendor/dg/rss-php/src/Feed.php');
require_once('date_func.php');

function get_podcasts($url) {
    try{
      $feed = Feed::loadRss($url);
    }catch(Exception $e){
      return -1;
    }
    $podcasts = $feed->item;
    $podcasts = [];
    foreach ($feed->item as $item) {
        $podcasts[] = [
          "pubDate" => date_to_mktime($item->pubDate),
          "title" => (string) $item->title[0],
          "duration" => explode(" ", $item->description)[2],
          "media" => (string) $item->enclosure["url"],
        ];
    }
    return $podcasts;
}

function slice_podcast_by($podcasts, $slice_by) {
  $podcast_sliced = [];
    if($slice_by == "week"){
      foreach($podcasts as $podcast){
        $date = $podcast['pubDate'];
        $week = date("W", $date);
        $podcast_sliced[$week][] = $podcast;
      }
    }else if($slice_by == "month"){
      foreach($podcasts as $podcast){
        $date = $podcast['pubDate'];
        $month = date("m", $date);
        $podcast_sliced[$month][] = $podcast;
      }
    }else if($slice_by == "year"){
      foreach($podcasts as $podcast){
        $date = $podcast['pubDate'];
        $year = date("Y", $date);
        $podcast_sliced[$year][] = $podcast;
      }
    }else{
      return -1;
    }
  return $podcast_sliced;
}

function dl_n_last_podcasts($podcasts, $n) {
  if($podcasts == -1 || $podcasts == NULL || $n == NULL || $n < 0){
    return -1;
  }
  $podcasts_dl = array_slice($podcasts, -$n);
  foreach($podcasts_dl as $podcast){
    $file_name = rtrim(implode("_", explode(" ", $podcast['title'])));
    $file_name .= ".mp3";
    $url_dl = $podcast['media'];
    exec("wget -q -b -O ./media/mp3/". $file_name . " " . $url_dl);
  }
  return 1;
}
