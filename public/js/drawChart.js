/**
 * Created by skDn on 19/11/2015.
 */

function sortDictionary(d, k) {
    return d.sort(function (x, y) {
        return new Date(x[k]).getTime() - new Date(y[k]).getTime();
    })
}

function convertDicToArray(dict, value) {
    var retArray = [];
    for (var key in dict[value]) {
        var record = [];
        record.push(convertStringDate(key));
        for (var i in dict[value][key]) {
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
    var drawChartWithData = el.name;
    drawChart();
}

function convertDataToChartArray(data) {
    var retDict = {};
    var retArr = [];

    var header = ['Month'];
    var keys = [];

    var dictionary = {};

    for (var query in data) {

        for (var partial in data[query]) {
            // yesscotland
            var sub_key = partial;
            // push yesscotland
            header.push(partial);
            var sub_val = data[query][partial];

            for (var sub in data[query][partial]) {
                if (dictionary[sub] === undefined) {
                    dictionary[sub] = {};
                }
                // twitter
                sub_key = sub;
                sub_val = data[query][partial][sub];
                for (var sub1 in data[query][partial][sub]) {
                    if (dictionary[sub][data[query][partial][sub][sub1]['date']] === undefined) {
                        dictionary[sub][data[query][partial][sub][sub1]['date']] = [];
                    }
                    dictionary[sub][data[query][partial][sub][sub1]['date']].push(data[query][partial][sub][sub1]['count']);

                    sub_val = data[query][partial][sub][sub1];
                }
            }

        }


    }
    var $div = $('<div class="center-block col-lg-8 btn-group btn-group-justified" style="margin-top: 15px;" role="group"></div>');
    for (var k in dictionary) {
        keys.push(k);
        options['vAxis']['title'] = k;
        $div.append('<a type="button" class="btn btn-default" name=' + k + ' onClick="a_onClick(this)">' + k.toUpperCase() + '</a>');
    }

    $div.insertAfter($("#" + googleChart));

    retArr.push(header);
    var con;

    for (var i in keys) {
        con = convertDicToArray(dictionary, keys[i]);
        retDict[keys[i]] = retArr.concat(con);
    }
    return retDict;
}

function drawChart() {
    if (chartArray == undefined)
        chartArray = convertDataToChartArray(dataToDraw);
    chart = new google.visualization.ComboChart(document.getElementById(googleChart));
    var dataConv = google.visualization.arrayToDataTable(chartArray[drawChartWithData]);
    $("#loading-container").css('display', 'none');
    options['vAxis']['title'] = drawChartWithData;
    chart.draw(dataConv, options);
}


$(document).ready(function () {
    function getSearchSpace() {
        var searchSpace = [];
        var lat = $('#' + latInput).val();
        var lng = $('#' + lngInput).val();
        $('input').each(function () {
            var itemID = $(this).attr('id');
            if (itemID != undefined) {
                if (itemID.indexOf('query') > -1) {
                    var searchIt = {};
                    // uncomment if use more than one date picker
                    searchIt['date'] = getDate();
                    searchIt['query'] = $(this).val();
                    searchIt['lat'] = lat;
                    searchIt['lng'] = lng;
                    searchSpace.push(searchIt);
                }
            }
        });
        return searchSpace;
    }

    function foo(queries) {
        var resp = [];
        var percentage;
        var loadingcontainer = $('#loading-container');
        for (var i = 0; i < queries.length; i++) {
            $.ajax({
                type: "GET",
                url: "search/count",
                async: 'false',
                data: queries[i],
                dataType: 'json',
                success: function (res) {
                    resp.push(res);
                    // changing loading bar width
                    percentage = (resp.length * 100) / queries.length;
                    loadingcontainer.children().css("width", percentage + "%");
                    loadingcontainer.children().text(percentage + "%");
                    //
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