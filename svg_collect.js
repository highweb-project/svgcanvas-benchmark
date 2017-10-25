window.setDevToolsCallback(function(resultJSON) {
    console.log("resultJSON : " + resultJSON);

    var jsonObj, paramsObj;
    try {
      jsonObj = JSON.parse(resultJSON);
      paramsObj = JSON.parse(jsonObj.params);
    } catch (exp) {
    }

    if (paramsObj && paramsObj.idle) {
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
