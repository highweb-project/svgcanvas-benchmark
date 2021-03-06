<?php
header('Cache-Control: no-store, no-cache, must-revalidate, max-age=0');
header('Cache-Control: post-check=0, pre-check=0', false);
header('Pragma: no-cache');

$step = $_GET['step'];
$self = $_SERVER['PHP_SELF'];
$mode = $_GET['mode'];
$result = $_GET['result'];
$isOrigin = $_COOKIE['isOrigin'];
$svgObjectCount = $_COOKIE['svgObjectCount'];
$redirectHighWebTest = false;
$redirectGraph = false;
$testPageStep = array($svgObjectCount, $svgObjectCount, $svgObjectCount);

if ($mode == 'initOrigin') {
    unset($_COOKIE['isOrigin']);
    setcookie('isOrigin', true, time() + 60 * 60);
    $isOrigin = true;
}

if ($mode == 'save' && $result) {
    if ($isOrigin == true) {
        setcookie('originResult-'.$svgObjectCount, $result, time() + 60 * 60);
        setcookie('isOrigin', false, time() + 60 * 60);
        $isOrigin = false;
        $redirectHighWebTest = true;
    } else {
        setcookie('highwebResult-'.$svgObjectCount, $result, time() + 60 * 60);
        $redirectGraph = true;
    }
}

if ($mode == 'graph') {
  $url = "svgbenchmark_v4.php?mode=back";
}

?>
<!DOCTYPE html>
<html>
<head>
</head>
<body onload="ready()">
<?php
if ($step !== null && $step >= 0) {
    $count = $testPageStep[$step];

    ++$step;

    if ($step >= count($testPageStep)) {
        $url = $self.'?mode=collect';
    } else {
        $url = $self.'?step='.$step;
    }

    if ($count) {
        $file = 'svg_data_'.$count.'.txt';
        $data = file_get_contents($file, FILE_USE_INCLUDE_PATH);
        echo '<svg version="1.1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" id="canvas" width="5000" height="5000"';

        if ($isOrigin == false) {
            echo 'svgtocanvas="true">';
        } else {
            echo '>';
        }

        echo $data.'</svg>';
    }
}

if ($mode == 'initOrigin' || $mode == 'initHighweb') {
    $url = $self.'?mode=start';
} elseif ($mode == 'start') {
    $url = $self.'?step=0';
} elseif ($mode == 'graph') {
    echo '<script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script><div id="chart_div"></div>';
} elseif ($redirectHighWebTest == true) {
    $url = $self.'?mode=initHighweb';
} elseif ($redirectGraph == true) {
    $url = $self.'?mode=graph';
}

?>
<script>
function ready() {
<?php
$showTimeline = 'window.executeJavaScriptInDevTools("UI.inspectorView.showPanel(\"timeline\");");';
if (!empty($url)) {
    echo $showTimeline;
    $script = 'setTimeout(function() { location.replace("'.$url.'"); }, 1000);';
    echo $script;
}
?>
}

<?php
$toggleCMD = 'window.executeJavaScriptInDevTools("UI.panels.timeline._toggleRecording();");';

if ($mode == 'start') {
    echo $toggleCMD;
} elseif ($mode == 'collect') {
    echo $toggleCMD;
    $jsCollect = file_get_contents('svg_collect.js', FILE_USE_INCLUDE_PATH);
    echo $jsCollect;
} elseif ($mode == 'graph') {
    // echo 'var originResult = '.$_COOKIE['originResult'].';';
    // echo 'var highwebResult = '.$_COOKIE['highwebResult'].';';
    // $jsGraph = file_get_contents('svg_graph.js', FILE_USE_INCLUDE_PATH);
    // echo $jsGraph;
}
?>
</script>
</body>
</html>
