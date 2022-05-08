<?php

function display_form(){
  $res = "<form action='unicode.php' method='get'>";
  $res .= '<form action="unicode.php" method="get">';
  $res .= '<label for="mot">Entrez un mot : </label>';
  $res .=  '<input type="text" name="mot" id="mot" required>';
  $res .=  '<input type="submit" value="Valider">';
  $res .=  '</form>';
  return $res;
}

function normalize($num){
  while(strlen($num) < 4){
    $num = '0' . $num;
  }
  return $num;
}

function display_unicode($mot){
  $initial = $mot[0];
  $unicode = mb_ord($initial);
  $norm_unicode = normalize($unicode);
  $res =  '<h2>';
  $res .=  $initial . " <a href='https://util.unicode.org/UnicodeJsps/character.jsp?a=" . $norm_unicode . "'> U+" . $norm_unicode .'</a>';
  $res .=  '</h2>';
  return $res;
}

// $main_content = "";

// if(isset($_GET['mot'])){
//   $mots = $_GET['mot'];
//   $main_content .= display_unicode($mots);
//   $main_content .= '<br>';
// }
// $main_content .= display_form();

function create_table_unicode($chars){
  $res = '<div class="container_unicode">';
  $chars_array = str_split($chars);
  foreach($chars_array as $char){
    $char_unicode = normalize(mb_ord($char));
    $char_unicode_normalized = 'U+' . $char_unicode;
    $res .= '<div class="block_unicode"><p>' . $char . "</p><p><a href='https://util.unicode.org/UnicodeJsps/character.jsp?a=" . $char_unicode . "'>" . $char_unicode_normalized .'</a></p></div>';
  }
  $res .= '</div>';
  return $res;
}

//$chars contains all the characters of the alphabet
$chars = "@ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789";
$table = create_table_unicode($chars);

?>
<!DOCTYPE html>
<html lang="fr">

<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
	<title>Analyse des Caractères Unicode (niv. 2)</title>
	<meta name="author" content="SOLER Lilian">
	<meta name="viewport" content="width=device-width; initial-scale=1.0">
	<link rel="stylesheet" href="theme.css">
  <link rel="stylesheet" href="unicode.css">
</head>

<body>
	<h1>Analyse des Caractères Unicode (niv. 2)</h1>
	<hr>
	<?php //echo $main_content; ?>
  <?php echo $table; ?>
</body>

</html>