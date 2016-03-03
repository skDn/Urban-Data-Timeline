/**
 * Created by skDn on 06/02/2016.
 */
/**
 * Global variabls
 */
var drawChartWithData = 'twitter';
var googleChart = 'googleChart';
var chartArray;
var chart;
var dataToDraw;
var options = {
    legend: {position: 'top', maxLines: 10},
    vAxis: {title: ""},
    hAxis: {title: "Date"},
    seriesType: "bars",
    series: {5: {type: "line"}},
    animation: {
        duration: 1000,
        easing: 'out'
    }
};
var firstQuery = '#query_First';
var secondQuery = '#query_Second';

// calculating user clicks and time taken
var number = 0;
var lastClick = 0;
var startTimer;
var startTime = 0;

console.log('click,timeperclick,totaltime');
document.onclick = function () {
    number++;
    if (startTimer === undefined) {
        startTimer = new Date();
        startTime = startTimer.getTime();
    }
    var d = new Date();
    var t = d.getTime();
    if (lastClick === 0) {
        console.log(number + ',' + 0 + ',' + (t - startTime) / 1000);
    }
    else {
        console.log(number + ',' + (t - lastClick) / 1000 + ',' + (t - startTime) / 1000);
    }
    lastClick = t;

};