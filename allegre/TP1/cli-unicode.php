<?php
/* Utilise l'encodage interne UTF-8 */
mb_internal_encoding("UTF-8");

foreach($argv as $arg){
  if(!($arg == $argv[0])){
    echo mb_ord($arg[0]) . "\n";
  }  
}
?>