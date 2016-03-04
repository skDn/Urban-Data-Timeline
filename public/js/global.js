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
var number = (Cookies.get('number') === undefined) ? 0 : Cookies.get('number');
var lastClick = (Cookies.get('lastClick') === undefined) ? 0 : Cookies.get('lastClick');
var startTimer;
var startTime = (Cookies.get('startTime') === undefined) ? 0 : Cookies.get('startTime');

console.log('click,timeperclick,totaltime,xPosition,yPosition');
document.onclick = function (e) {
    number++;
    if (startTimer === undefined && startTime === 0) {
        startTimer = new Date();
        startTime = startTimer.getTime();
        Cookies.set('startTime', startTime);
    }
    var d = new Date();
    var t = d.getTime();
    if (lastClick === 0) {
        console.log(number + ',' + 0 + ',' + (t - startTime) / 1000);
    }
    else {
        console.log(number + ',' + (t - lastClick) / 1000 + ',' + (t - startTime) / 1000 + ',' + e.pageX + ',' + e.pageY);
    }
    lastClick = t;

    Cookies.set('number', number);
    Cookies.set('lastClick', lastClick);

};