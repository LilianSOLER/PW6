<?php

function array_HTML_Table($array){
  $res = "<table class='exo6'>\n";
  foreach($array as $key => $value){
    $res .= "<tr>\n";
    foreach($value as $key2 => $value2){
      $res .= "<td>$value2</td>\n";
    }
    $res .= "</tr>\n";
  }
  $res .= "</table>\n";
  return $res;
}
?>