<?php
require_once('vendor/dg/rss-php/src/Feed.php');

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
            'title' => $item->title,
            'link' => $item->enclosure['link'],
            'description' => $item->description,
            'author' => $item->author,
            "category" => $item->category,
            "pubDate" => $item->pubDate,
            "sound" => [
                "url" => $item->enclosure['url'],
                "length" => $item->enclosure['length'],
                "type" => $item->enclosure['type'],
            ],
        ];
    }
    return $podcasts;
}