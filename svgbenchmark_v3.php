<?php
header('Cache-Control: no-store, no-cache, must-revalidate, max-age=0');
header('Cache-Control: post-check=0, pre-check=0', false);
header('Pragma: no-cache');

$step = $_GET['step'];
$self = $_SERVER['PHP_SELF'];
$mode = $_GET['mode'];
$result = $_GET['result'];
$isOrigin = $_COOKIE['isOrigin'];
$redirectHighWebTest = false;
$redirectGraph = false;

if ($mode == 'initOrigin') {
    unset($_COOKIE['isOrigin']);
    setcookie('isOrigin', true, time() + 60 * 3);
    $isOrigin = true;
}

if ($mode == 'save' && $result) {
    if ($isOrigin == true) {
        setcookie('originResult', $result, time() + 60 * 3);
        setcookie('isOrigin', false, time() + 60 * 3);
        $isOrigin = false;
        $redirectHighWebTest = true;
    } else {
        setcookie('highwebResult', $result, time() + 60 * 3);
        $redirectGraph = true;
    }
}
?>
<!DOCTYPE html>
<html>
<head>
</head>
<body onload="ready()">
<?php
if ($step !== null && $step >= 0) {
    $testPageStep = array('1000', '1000','1000','1000','1000','1000','1000','1000','1000','1000');
    $count = $testPageStep[$step];

    ++$step;

    if ($step >= count($testPageStep)) {
        $url = 'svgbenchmark_v3.php?mode=collect';
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
if (!empty($url)) {
    $script = 'setTimeout(function() { location.replace("'.$url.'"); }, 1500);';
    echo $script;
}
?>
}

<?php
$toggleCMD = 'window.executeJavaScriptInDevTools("WebInspector.context.flavor(WebInspector.TimelinePanel)._toggleRecording();");';

if ($mode == 'start') {
    echo $toggleCMD;
} elseif ($mode == 'collect') {
    echo $toggleCMD;
    $jsCollect = file_get_contents('svg_collect.js', FILE_USE_INCLUDE_PATH);
    echo $jsCollect;
} elseif ($mode == 'graph') {
    echo 'var originResult = '.$_COOKIE['originResult'].';';
    echo 'var highwebResult = '.$_COOKIE['highwebResult'].';';
    $jsGraph = file_get_contents('svg_graph.js', FILE_USE_INCLUDE_PATH);
    echo $jsGraph;
}
?>
</script>
</body>
</html>
