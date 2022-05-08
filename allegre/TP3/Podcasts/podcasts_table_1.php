<?php
require_once('func.php');
require_once('date_func.php');

$METH_SCI =
  [
    "url" => "https://radiofrance-podcast.net/podcast09/d4463877-caa3-4507-9399-f5eb00fde027/rss_14312.xml"
  ];

$podcasts = get_podcasts($METH_SCI['url']);

function podcasts_to_HTML_table($podcasts)
{
  $table = "<table>";
  $table .= "<tr>";
  foreach ($podcasts[0] as $key => $value) {
    $table .= "<th>$key</th>";
  }
  $table .= "</tr>";
  foreach ($podcasts as $podcasts) {
    $table .= "<tr>";
    foreach ($podcasts as $key => $value) {
      if ($key == "pubDate") {
        $table .= "<td>" . date('Y-m-d H:i:s', $value) . "</td>";
      } else {
        if ($key == "media") {
          $table .= "<td><audio controls><source src='$value' type='audio/mpeg'></audio></td>";
        } else {
          $table .= "<td>$value</td>";
        }
      }
    }
    $table .= "</tr>";
  }

  $table .= "</table>";
  return $table;
}
?>
<!DOCTYPE html>
<html lang="fr">

<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="stylesheet" href="table.css">
  <title>1. Tableau des podcasts</title>
</head>

<body>
  <h1>1. Tableau des podcasts</h1>
  <?php echo podcasts_to_HTML_table($podcasts) ?>
</body>

</html>