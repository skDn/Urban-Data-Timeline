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