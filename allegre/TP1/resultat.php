<?php
require_once 'libcalcul.php';
$cumul = calcul_interet($_GET['montant'], $_GET['taux'], $_GET['duree']);
?>

<!DOCTYPE html>
<html lang="fr">
<head>
  <meta charset="utf-8">
  <title>Calcul d'intérêts composés</title>
  <meta name="author" content="SOLER Lilian">
  <meta name="viewport" content="width=device-width; initial-scale=1.0">
  <link rel="stylesheet" href="theme.css">
</head>
<body>
  <h1>Calcul d'intérêts composés (niv. 1-2)</h1>
  <hr>
  <h2>Résultat : <?php echo $cumul; ?> € </h2>
</body>
</html>