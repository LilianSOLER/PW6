<?php
  require_once("generic_table.php");

  function init_mult_arrat($N){
    $res = array();
    for($i = 1; $i <= $N; $i++){
      $res[$i] = array();
      for($j = 1; $j <= $N; $j++){
        $res[$i][$j] = $i . " * " . $j . " = " . $i * $j;
      }
    }
    return $res;
  }

?>
<!DOCTYPE html>
<html lang="fr">

<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
	<title>Affichage d'un tableau générique (niv. 2)</title>
	<meta name="author" content="SOLER Lilian">
	<meta name="viewport" content="width=device-width; initial-scale=1.0">
	<link rel="stylesheet" href="theme.css">
</head>

<body>
	<h1>Affichage d'un tableau générique (niv. 2)</h1>
	<hr>
	<?php
	if (!isset($_GET['number']) || !is_numeric($_GET['number']) || $_GET['number'] < 1) {
    $N = 10;
	}else{
    $N = $_GET['number'];
  }
  $array = init_mult_arrat($N);
  echo array_HTML_Table($array);
	?>
</body>

</html>