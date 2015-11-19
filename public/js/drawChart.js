/**
 * Created by skDn on 19/11/2015.
 */
/**
 * Global variabls
 */
var drawChartWithData = 'twitter';
var elem = 'page';
var chartArray;
var chart = new google.visualization.ComboChart(document.getElementById(elem));
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
    },
};

function sortDictionary(d, k) {
    return d.sort(function (x, y) {
        return new Date(x[k]).getTime() - new Date(y[k]).getTime();
    })
}

function convertDicToArray(dict, value) {
    retArray = [];
    for (key in dict[value]) {
        record = [];
        record.push(convertStringDate(key));
        for (i in dict[value][key]) {
            record.push(dict[value][key][i]);
        }
        retArray.push(record);
    }
    return retArray;
}
// yyyy-mm-dd format expected
function convertStringDate(date) {
    return date.substring(8, 11).trim() + '/' + date.substring(5, 7).trim();
}

function a_onClick(el) {
    drawChartWithData = el.name;
    drawChart();
}

function convertDataToChartArray(data) {
    var retDict = {};
    var retArr = [];

    var header = ['Month'];
    var keys = [];

    var dictionary = {};

    for (query in data) {

        for (partial in data[query]) {
            // yesscotland
            var sub_key = partial;
            // push yesscotland
            header.push(partial);
            var sub_val = data[query][partial];
            //console.log(sub_key);

            for (sub in data[query][partial]) {
                if (dictionary[sub] == undefined) {
                    dictionary[sub] = {};
                }
                // twitter
                sub_key = sub;
                sub_val = data[query][partial][sub];
                //console.log(sub_key);
                for (sub1 in data[query][partial][sub]) {
                    //console.log(data[query][partial][sub][sub1]['date']);
                    if (dictionary[sub][data[query][partial][sub][sub1]['date']] == undefined) {
                        dictionary[sub][data[query][partial][sub][sub1]['date']] = [];
                    }
                    dictionary[sub][data[query][partial][sub][sub1]['date']].push(data[query][partial][sub][sub1]['count']);

                    sub_val = data[query][partial][sub][sub1];
                    //console.log(sub_val);
                }
            }

        }


    }
    //var $listOfButtons = $('<ul class="chartButtons"></ul>');
    //for (var k in dictionary) {
    //    keys.push(k);
    //    options['vAxis']['title'] = k;
    //    $listOfButtons.append('<li><a type="button" class="btn btn-default" name=' + k + ' onClick="a_onClick(this)">' + k.toUpperCase() + '</a></li>');
    //}
    //var $div = $('<div class="btn-group btn-group-justified" role="group"></div>');
    //$div.append($listOfButtons);
    var $div = $('<div class="center-block col-lg-8 btn-group btn-group-justified" style="margin-top: 15px;" role="group"></div>');
    for (var k in dictionary) {
        keys.push(k);
        options['vAxis']['title'] = k;
        $div.append('<a type="button" class="btn btn-default" name=' + k + ' onClick="a_onClick(this)">' + k.toUpperCase() + '</a>');
    }

    $div.insertAfter($("#page"));
//            console.log(keys);
//            console.log(convertDicToArray(dictionary, 'twitter'));

    retArr.push(header);
    var con;

    for (var i in keys) {
        con = convertDicToArray(dictionary, keys[i]);
        retDict[keys[i]] = retArr.concat(con);
    }
    //return retArr.concat(con);
    return retDict;
}

function drawChart() {
    if (chartArray == undefined)
        chartArray = convertDataToChartArray(dataToDraw);

    var dataConv = google.visualization.arrayToDataTable(chartArray[drawChartWithData]);
    $("#loading-container").css('display', 'none');
    options['vAxis']['title'] = drawChartWithData;
    chart.draw(dataConv, options);
}



$(document).ready(function () {
    function getSearchSpace() {
        var searchSpace = [];
        var indexes = [];
        $('input').each(function () {
            var itemID = $(this).attr('id');
            if (itemID != undefined) {
                if (itemID.indexOf('query') > -1) {
                    var searchIt = {};
                    // uncomment if use more than one date picker
                    //var index = itemID.split('_')[1];
                    //searchIt['date'] = getDate(index);
                    searchIt['date'] = getDate();
                    searchIt['query'] = $(this).val();
                    searchSpace.push(searchIt);
                }
            }
        });
        return searchSpace;
    }
    function foo(queries) {
        var resp = [];
        for (i = 0; i < queries.length; i++) {
            $.ajax({
                type: "GET",
                url: "search/count",
                async: 'false',
                data: queries[i],
                dataType: 'json',
                success: function (res) {
                    resp.push(res);
                    if (resp.length == queries.length) {
                        dataToDraw = resp;
                        drawChart();
                    }
                }
            });
        }
    }
    foo(getSearchSpace());
});