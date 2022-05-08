<?php
//session_start();

setlocale(LC_TIME, 'fr_FR');
date_default_timezone_set('Europe/Paris');

function addTh($name_cols){
  $res = "";
  foreach($name_cols as $name_col){
    $res .= "<th>$name_col</th>\n";
  }
  return $res;
}

function array_HTML_Table($data, $name_cols,$width){
  $res = "<table class='" . $width . "col'>\n";

  if($name_cols != false){$res .= addTh($name_cols);}

  foreach($data as $value){
    $res .= "<tr>\n";
    foreach($value as $value2){
      if($width == 7){
        foreach($value2 as $value3){
          $res .= "<td>$value3</td>\n";
        }
      }else{
        $res .= "<td>$value2</td>\n";
      }
    }
    $res .= "</tr>\n";
  }

  $res .= "</table>\n";
  return $res;
}

$MONTHS = [];
$STR_DAYS = ["Monday", "Tuesday", "Wednesday", "Thursday", "Friday", "Saturday", "Sunday"];
$generic_array_month = [];
$month = 1;
if(isset($_GET['month'])){
  $month = $_GET['month'];
}

$ncols = 7;
if(isset($_GET['format'])){
  $ncols = $_GET['format'];
}

$YEAR = date('Y');
if(isset($_GET['year'])){
  $YEAR = $_GET['year'];
}


/*if(!isset($_SESSION["MONTHS"])){
  init_month($YEAR);
}
$MONTHS = $_SESSION["MONTHS"];

if(!isset($_SESSION["generic_array_month"])){
  generic_array_month($month, $ncols);
}
$generic_array_month = $_SESSION["generic_array_month"];
*/

init_month($YEAR);
$generic_array_month = generic_array_month($month, $ncols);

function init_month($year){
  global $MONTHS;
  for($month = 1; $month <= 12; $month++){
    $nb_days = date('t',mktime(0, 0, 0, $month, 1, $year));
    $str_month = date('F',mktime(0, 0, 0, $month, 1, $year));
    $MONTHS[$month - 1] = [$str_month, $nb_days];    
  }
}

function generic_array_month($month, $ncols){
  $res = [];
  $res[0] = [];
  global $MONTHS, $YEAR, $STR_DAYS;
  $week = 0;
  for($nday = 1; $nday <= $MONTHS[$month - 1][1]; $nday++){
    $data = [$nday, date('l',mktime(0, 0, 0, $month, $nday, $YEAR)), "vide"];

    if($ncols == 7){
      if($nday != 1){
        if($data[1] == $STR_DAYS[0]){
          $week++;
          $res[$week] = [];
        }
      }
      array_push($res[$week], $data);
    }else{
      $res[$nday - 1] = $data ;
    }
  }  
  return $res;
}

function addEvent($nday, $event, $width){
  global $generic_array_month;
  $i = 0;
  $j = 0;
  foreach($generic_array_month as $value){
    $j = 0;
    if($width == 3){
      if($nday == $value[0]){
        $generic_array_month[$i][2] = $event;
        return;
      }
    }else{
      foreach($value as $value2){
        if($nday == $value2[0]){
          $generic_array_month[$i][$j][2] = $event;
          return;
        }
        $j++;
      }
    }
    $i++;
  }
}
//print_r($generic_array_month);
addEvent(14, "DS WEB", 7);
addEvent(24, "DS WEB 2", 7);
//$_SESSION["generic_array_month"] == $generic_array_month;

?>
<!DOCTYPE html>
<html lang="fr">

<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
	<title>Calendrier - agenda web (niv. 3)</title>
	<meta name="author" content="SOLER Lilian">
	<meta name="viewport" content="width=device-width; initial-scale=1.0">
	<link rel="stylesheet" href="theme.css">
</head>
<body>
	<h1>Calendrier - agenda web (niv. 3)</h1>
	<hr>
  <?php echo array_HTML_Table($generic_array_month, false, $ncols); ?>
</body>
</html>