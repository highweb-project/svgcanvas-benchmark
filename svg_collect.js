window.setDevToolsCallback(function(resultJSON) {
    var jsonObj = JSON.parse(resultJSON);
    var paramsObj = JSON.parse(jsonObj.params);

    if (paramsObj.idle) {
        setTimeout(function() {
            location.replace(window.location.pathname + "?mode=save&result=" + JSON.stringify(paramsObj));
        }, 100);
    } else {
        setTimeout(function() {
            window.executeJavaScriptInDevTools("Timeline.TimelineUIUtils.callResultCallback();");
        }, 500);
    }
});
window.executeJavaScriptInDevTools("Timeline.TimelineUIUtils.callResultCallback();");
