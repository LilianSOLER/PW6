<?php

$a = 12;
$b = 123.45;
$c = 'valeur textuelle';
$d = "chaîne de $c";

$t = ['un', 'deux', 'trois'];
$u = ['one' => 'un', 'two' => 'deux', 'three' => 'trois'];

echo "\n a=";
var_dump($a);
echo "\n b=";
var_dump($b);
echo "\n c=";
var_dump($c);
echo "\n d=";
var_dump($d);

echo "\n t=";
var_dump($t);
echo "\n u=";
var_dump($u);

# Maintenant, remplacez les appels à var_dump() par print_r()

