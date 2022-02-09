<?php
//return an array with the char present in the string
function delete_occurence_in_string($string)
{
  $array = array();
  $i = 0;
  while ($i < strlen($string))
  {
    if (!in_array($string[$i], $array))
      array_push($array, $string[$i]);
    $i++;
  }
  return $array;
}

function normalize($num){
  while(strlen($num) < 4){
    $num = '0' . $num;
  }
  return $num;
}

//return a the HTML code for a table of char and his unicode
function create_unicode($chars_array){
  $res = [];
  foreach($chars_array as $char){
    $char_unicode = normalize(mb_ord($char));
    $char_unicode_normalized = 'U+' . $char_unicode;
    array_push($res, [$char, $char_unicode_normalized]);
  }
  return $res;
}

$lang = $_GET['lang'];
$rep_lang = "Le texte est en ";

switch($lang){
  case "fr":
    $rep_lang .= "français";
    break;
  case "ru":
    $rep_lang .= "russe";
    break;
  case "el":
    $rep_lang .= "grec";
    break;
  case "hy":
    $rep_lang .= "arménien";
    break;
  case "ar":
    $rep_lang .= "arabe";
    break;
  case "zh":
    $rep_lang .= "chinois";
    break;
  case "ko":
    $rep_lang .= "coréen";
    break;
  case "hi":
    $rep_lang .= "hindi";
    break;
  default:
    $rep_lang = "La langue n'est pas reconnu";;  
  }

  $text = $_GET['text'];
  $chars_array = delete_occurence_in_string($text);
  $text = create_unicode($chars_array);
  //$text = implode(delete_occurence_in_string($_GET['text']));

  $rep = [];
  //$rep['lang'] = $rep_lang;
  $rep['text'] = $text;
  $rep_json = json_encode($rep);
  echo json_last_error();
  var_dump($rep_json);



