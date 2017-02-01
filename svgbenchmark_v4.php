<?php
header('Cache-Control: no-store, no-cache, must-revalidate, max-age=0');
header('Cache-Control: post-check=0, pre-check=0', false);
header('Pragma: no-cache');

setcookie('svgObjectCount', '1000', time() + 60 * 60);

$mode = $_GET['mode'];
$svgObjectCount = $_COOKIE['svgObjectCount'];
$url = 'svgbenchmark_v4_sub.php?mode=initOrigin';

if ($mode == 'back') {
    switch ($svgObjectCount) {
      case 1000:
      setcookie('svgObjectCount', '2500', time() + 60 * 60);
      break;
      case 2500:
      setcookie('svgObjectCount', '5000', time() + 60 * 60);
      break;
      case 5000:
      setcookie('svgObjectCount', '10000', time() + 60 * 60);
      break;
      case 10000:
      $url = 'svgbenchmark_v4.php?mode=graph';
      break;
    }
} elseif ($mode == 'graph') {
    unset($url);
}

?>
<!DOCTYPE html>
<html>
<head>
</head>
<body onload="ready()">
<?php
if ($mode == 'graph') {
    echo '<script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
    <div id="chart_div_loading"></div>
    <div id="chart_div_scripting"></div>
    <div id="chart_div_rendering"></div>
    <div id="chart_div_painting"></div>
    <div id="chart_div_other"></div>
    <div id="chart_div_idle"></div>';
}
 ?>
<script>
function ready() {
  <?php
  if (!empty($url)) {
      $script = 'setTimeout(function() { location.replace("'.$url.'"); }, ';
      if ($svgObjectCount == 1000) {
          $script .= '3000);';
      } else {
          $script .= '1000);';
      }

      echo $script;
  }
  ?>
}
<?php
if ($mode == 'graph') {
      echo 'var originResult_1000 = '.$_COOKIE['originResult-1000'].';';
      echo 'var highwebResult_1000 = '.$_COOKIE['highwebResult-1000'].';';
      echo 'var originResult_2500 = '.$_COOKIE['originResult-2500'].';';
      echo 'var highwebResult_2500 = '.$_COOKIE['highwebResult-2500'].';';
      echo 'var originResult_5000 = '.$_COOKIE['originResult-5000'].';';
      echo 'var highwebResult_5000 = '.$_COOKIE['highwebResult-5000'].';';
      echo 'var originResult_10000 = '.$_COOKIE['originResult-10000'].';';
      echo 'var highwebResult_10000 = '.$_COOKIE['highwebResult-10000'].';';
      $jsGraph = file_get_contents('svg_graph.js', FILE_USE_INCLUDE_PATH);
      echo $jsGraph;
  }
?>
</script>
</body>
</html>
