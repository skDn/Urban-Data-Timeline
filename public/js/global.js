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