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
    drawChartWithData = el.name;
    drawChart();
}

function convertDataToChartArray(data) {
    var retDict = {};
    var retArr = [];

    var header = ['Month'];
    var keys = [];

    var dictionary = {};
    for (var q in data)
        for (var query in data[q]) {

            for (var partial in data[q][query]) {
                // yesscotland
                var sub_key = partial;
                // push yesscotland
                if (header.indexOf(partial) < 0) {
                    header.push(partial);
                }
                var sub_val = data[q][query][partial];

                for (var sub in data[q][query][partial]) {
                    if (dictionary[sub] === undefined) {
                        dictionary[sub] = {};
                    }
                    // twitter
                    sub_key = sub;
                    sub_val = data[q][query][partial][sub];
                    console.log(data[q][query][partial][sub]['date']);
                    if (dictionary[sub][data[q][query][partial][sub]['date']] === undefined) {
                        dictionary[sub][data[q][query][partial][sub]['date']] = [];
                    }
                    dictionary[sub][data[q][query][partial][sub]['date']].push(data[q][query][partial][sub]['count']);

                    sub_val = data[q][query][partial][sub];
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

function compareDates(date1, date2) {
    return date1.getDate() === date2.getDate() &&
        date1.getMonth() === date2.getMonth() &&
        date1.getFullYear() === date2.getFullYear();
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
        var queryResponses = [];
        var counter = 0;
        var percentage;
        var loadingcontainer = $('#loading-container');
        // configuring date range for getting the count
        var queryDate = queries[0]['date'];
        var startD = new Date(queryDate);
        var month;
        startD.setDate(startD.getDate() - countRangePlusMinus);

        var endD = new Date(queryDate);
        endD.setDate(endD.getDate() + countRangePlusMinus + 1);

        for (var i = 0; i < queries.length; i++) {
            queryResponses = [];
            do {
                // setting range to 1
                queries[i]['range'] = 1;
                month = (startD.getMonth() + 1 < 10) ? '0' + (startD.getMonth() + 1) : startD.getMonth() + 1;
                queries[i]['date'] = startD.getFullYear() + '-' + month + '-' + startD.getDate();
                $.ajax({
                    type: "GET",
                    url: "../rest/count",
                    async: 'false',
                    data: queries[i],
                    dataType: 'json',
                    success: function (res) {
                        queryResponses.push(res);
                        counter++;
                        if (queryResponses.length === 2 * countRangePlusMinus + 1) {
                            resp.push(queryResponses);
                            queryResponses = [];
                        }
                        // changing loading bar width
                        percentage = (counter * 100) / (queries.length * (2 * countRangePlusMinus + 1));
                        loadingcontainer.children().css("width", percentage + "%");
                        loadingcontainer.children().text(percentage + "%");
                        //
                        if (percentage === 100) {
                            dataToDraw = resp;
                            //convertDataToChartArray(resp);
                            drawChart();
                        }
                    }
                });
                // incrementing the date
                startD.setDate(startD.getDate() + 1);
            } while (!compareDates(startD, endD));
            startD = new Date(queryDate);
            startD.setDate(startD.getDate() - countRangePlusMinus);
        }

    }

    foo(getSearchSpace());
});