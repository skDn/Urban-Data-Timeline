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

var timelineFirst = '#timelineFirst';
var timelineSecond = '#timelineSecond';

var mapDiv = 'googleMap';
var latInput = 'latInput';
var lngInput = 'lonInput';

var countRangePlusMinus = 0;


var $timeline_block = $('.section');
var $timeline_elements = $('.event');

//var $timeline_block_first = ($'#queryFirst .section')


var $timeline_nav = $('.timeline_nav');
var $infoBox = $('.infoBox');
//var $timeline = $('.timeline');
var $timeline = $('#' + googleChart);
var offset = 150;


// calculating user clicks and time taken
var number = 0;
var lastClick = 0;
var startTimer;
var startTime = 0;

document.onclick = function () {
    number++;
    if (startTimer === undefined) {
        startTimer = new Date();
        startTime = startTimer.getTime();
    }
    var d = new Date();
    var t = d.getTime();
    console.log('Click: ' + number + ' Time taken: ' + (t - lastClick) / 1000 + ' Total time: ' + (t - startTime) / 1000);
    lastClick = t;

};