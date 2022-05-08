<?php

function calcul_interet($montant, $taux, $duree) {
    $cumul = $montant * pow((1 + $taux/100), $duree);
    $cumul = number_format($cumul, 2, ',', ' ');
    return $cumul;
}

?>