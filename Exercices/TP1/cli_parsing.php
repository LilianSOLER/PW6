<?php
$file = 'multiplication.php';

$paragraphs = $file->getElementsByTagName('p');
foreach($paragraphs as $paragraph){
  echo $paragraph->nodeValue, PHP_EQL;
}
