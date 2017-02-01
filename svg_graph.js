function findMaxValue() {
    var arr = Object.keys(originResult_1000).map(function(key) {
        console.log("key : " + key + ", originResult_1000[key] : " + originResult_1000[key]);
        if(key == "idle") return 0;
        return originResult_1000[key];
    });

    arr = arr.concat(Object.keys(originResult_1000).map(function(key) {
        if(key == "idle") return 0;
        return originResult_2500[key];
    }));

    arr = arr.concat(Object.keys(originResult_1000).map(function(key) {
        if(key == "idle") return 0;
        return originResult_5000[key];
    }));

    arr = arr.concat(Object.keys(originResult_1000).map(function(key) {
        if(key == "idle") return 0;
        return originResult_10000[key];
    }));

    arr = arr.concat(Object.keys(originResult_1000).map(function(key) {
        if(key == "idle") return 0;
        return highwebResult_1000[key];
    }));

    arr = arr.concat(Object.keys(originResult_1000).map(function(key) {
        if(key == "idle") return 0;
        return highwebResult_2500[key];
    }));

    arr = arr.concat(Object.keys(originResult_1000).map(function(key) {
        if(key == "idle") return 0;
        return highwebResult_5000[key];
    }));

    arr = arr.concat(Object.keys(originResult_1000).map(function(key) {
        if(key == "idle") return 0;
        return highwebResult_10000[key];
    }));

    var max = Math.max.apply(null, arr);

    return max;
}

function drawChart() {
    var dataLoading = google.visualization.arrayToDataTable([
        ['Object', 'origin', 'highweb'],
        ['1000', originResult_1000.loading, highwebResult_1000.loading],
        ['2500', originResult_2500.loading, highwebResult_2500.loading],
        ['5000', originResult_5000.loading, highwebResult_5000.loading],
        ['10000', originResult_10000.loading, highwebResult_10000.loading]
    ]);
    var dataScripting = google.visualization.arrayToDataTable([
        ['Object', 'origin', 'highweb'],
        ['1000', originResult_1000.scripting, highwebResult_1000.scripting],
        ['2500', originResult_2500.scripting, highwebResult_2500.scripting],
        ['5000', originResult_5000.scripting, highwebResult_5000.scripting],
        ['10000', originResult_10000.scripting, highwebResult_10000.scripting]
    ]);
    var dataRendering = google.visualization.arrayToDataTable([
        ['Object', 'origin', 'highweb'],
        ['1000', originResult_1000.rendering, highwebResult_1000.rendering],
        ['2500', originResult_2500.rendering, highwebResult_2500.rendering],
        ['5000', originResult_5000.rendering, highwebResult_5000.rendering],
        ['10000', originResult_10000.rendering, highwebResult_10000.rendering]
    ]);
    var dataPainting = google.visualization.arrayToDataTable([
        ['Object', 'origin', 'highweb'],
        ['1000', originResult_1000.painting, highwebResult_1000.painting],
        ['2500', originResult_2500.painting, highwebResult_2500.painting],
        ['5000', originResult_5000.painting, highwebResult_5000.painting],
        ['10000', originResult_10000.painting, highwebResult_10000.painting]
    ]);
    var dataOther = google.visualization.arrayToDataTable([
        ['Object', 'origin', 'highweb'],
        ['1000', originResult_1000.other, highwebResult_1000.other],
        ['2500', originResult_2500.other, highwebResult_2500.other],
        ['5000', originResult_5000.other, highwebResult_5000.other],
        ['10000', originResult_10000.other, highwebResult_10000.other]
    ]);
    var dataIdle = google.visualization.arrayToDataTable([
        ['Object', 'origin', 'highweb'],
        ['1000', originResult_1000.idle, highwebResult_1000.idle],
        ['2500', originResult_2500.idle, highwebResult_2500.idle],
        ['5000', originResult_5000.idle, highwebResult_5000.idle],
        ['10000', originResult_10000.idle, highwebResult_10000.idle]
    ]);

    var maxVAxis = findMaxValue();
    console.log("maxVAxis : " + maxVAxis);

    var options = {
        title: 'Loading Benchmark (Lower is better)',
        hAxis: {
            title: 'SVG Object',
            titleTextStyle: {
                color: '#333'
            }
        },
        vAxis: {
            minValue: 0
        }
    };

    options.vAxis.maxValue = maxVAxis;

    var chartLoading = new google.visualization.AreaChart(document.getElementById('chart_div_loading'));
    var chartScripting = new google.visualization.AreaChart(document.getElementById('chart_div_scripting'));
    var chartRendering = new google.visualization.AreaChart(document.getElementById('chart_div_rendering'));
    var chartPainting = new google.visualization.AreaChart(document.getElementById('chart_div_painting'));
    var chartOther = new google.visualization.AreaChart(document.getElementById('chart_div_other'));
    var chartIdle = new google.visualization.AreaChart(document.getElementById('chart_div_idle'));

    chartLoading.draw(dataLoading, options);

    options.title = 'Scripting Benchmark (Lower is better)';
    chartScripting.draw(dataScripting, options);

    options.title = 'Rendering Benchmark (Lower is better)';
    chartRendering.draw(dataRendering, options);

    options.title = 'Painting Benchmark (Lower is better)';
    chartPainting.draw(dataPainting, options);

    options.title = 'Other Benchmark (Lower is better)';
    chartOther.draw(dataOther, options);

    options.title = 'Idle Benchmark (Lower is better)';
    chartIdle.draw(dataIdle, options);
}

google.charts.load('current', {
    'packages': ['corechart']
});
google.charts.setOnLoadCallback(drawChart);
