<?php
require_once('func.php');

$CONFIGURATION_INFO = tmdb_get('configuration'); //get configuration info
$BASE_URL = $CONFIGURATION_INFO->images->secure_base_url;
$POSTER_SIZES = $CONFIGURATION_INFO->images->poster_sizes;
$POSTER_SIZE_INDEX = rand(0, count($POSTER_SIZES) - 1); //choose a random poster size

$cols = (isset($_GET['cols']) && is_numeric($_GET['cols'])) ? $_GET['cols'] : '-1'; //get the number of columns

$id = (isset($_GET['id']) && is_numeric($_GET['id'])) ? $_GET['id'] : '550'; //get the id of the movie
if ($cols != -1) {
  $movie_details = find_details_n_lang($id, $cols); //get the details of the movie in the n first languages
} else {
  $movie_details = find_details($id); //get the details of the movie in the default language
}

if ($movie_details == -1) {
  if ($cols != -1) {
    $movie_details = find_details_n_lang('550', $cols); //get the details of the movie in the n first languages
  } else {
    $movie_details = find_details('550'); //get the details of the movie in the default language
  }
}

$title = (isset($movie_details[0]['title'])) ? $movie_details[0]['title'] : $movie_details['title']; //get the title of the movie

function movie_details_to_HTML_table($details, $cols)
{
  global $title;
  $res = "<table>\n";
  $arr = ($cols == -1) ? $details : $details[0];
  if ($cols != -1) {
    $res .= "<tr>\n";
    foreach ($arr as $key => $value) {
      $res .= "<th> " . $key . "</th>\n";
    }
    $res .= "</tr>\n";
  }
  foreach ($details as $key => $detail) {
    if ($cols != -1) {
      $res .= "<tr>\n";
      foreach ($detail as $key => $value) {
        if ($key != 'poster') {
          if ($key == 'link' || $key == 'trailer') {
            $res .= "<td><a href='" . $value . "'>" . $key . " : " . $title . "</a></td>\n";
          } else {
            $res .= "<td> " . $value . "</td>\n";
          }
        } else {
          $res .= "<td><img src='" . $value . "' alt='" . $title . "'></td>\n";
        }
      }
    } else {
      if ($key != 'poster') {
        $res .= "<tr>\n";
        $res .= "<th>" . $key . "</th>\n";
        if ($key == 'link') {
          $res .= '<td><a href=' . $detail . '>' . $key . " : " . $title . "</a></td>\n";
        } else {
          if ($key == 'trailer') {
            // $res .= '<td></iframe src="' . $detail . '&autoplay=1"></iframe></td>';
            $res .= '<td><iframe width="560" height="315"
            src="' . $detail . '" frameborder="0" 
            allowfullscreen></iframe></td>';
          } else {
            $res .= "<td>$detail</td>\n";
          }
        }
        $res .= "</tr>\n";
      }
    }
  }
  $res .= "</table>\n";
  return $res;
}
?>
<!DOCTYPE html>
<html lang="fr">

<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="stylesheet" href="film.css">
  <title>Page de détails de <?php echo $title ?></title>
</head>

<body>
  <h1>Page de détail de <?php echo $title ?></h1>
  <?php
  echo movie_details_to_HTML_table($movie_details, $cols);
  ?>
</body>

</html>