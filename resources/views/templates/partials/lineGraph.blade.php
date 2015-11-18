<style type="text/css">
    div.circle {
        width: 20px;
        height: 20px;
        background: red;
        -moz-border-radius: 10px;
        -webkit-border-radius: 10px;
        border-radius: 10px;
    }
</style>

<div id="page" style="width: 80%;margin:auto;margin-top:40px;">
    <div id="loading-container" class="row text-center">
        <img src="https://www.musicianswithoutborders.org/wp-content/themes/mwb/images/ajax-loader-light.gif" width="32"
             height="32" alt="tweet loader"/>
    </div>
</div>
@section('scripts')
    @parent
    <script type="text/javascript"
            src="https://www.google.com/jsapi?autoload={'modules':[{'name':'visualization','version':'1.1','packages':['corechart']}]}"></script>
    <script type="text/javascript">
        //drawLines('#page', [10, 20, 50, 20, 30, 50, 70, 10, 40]);
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
            return date.substring(8, 11) + '/' + date.substring(5, 7)
        }

        function convertDataToChartArray(data) {
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
            var $listOfButtons = $('<ul></ul>');
            for (var k in dictionary) {
                keys.push(k);
                options['vAxis']['title'] = k;
                $listOfButtons.append('<li><a type="button" class="btn btn-default">' + k.toUpperCase() + '</a></li>');
            }
            $listOfButtons.insertAfter($("#page"));
//            console.log(keys);
//            console.log(convertDicToArray(dictionary, 'twitter'));

            retArr.push(header);
            var con = convertDicToArray(dictionary, 'twitter');

            return retArr.concat(con);
        }
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
        function drawChart(element, data) {

            //data = sortDictionary(data, 'date');
            var array = convertDataToChartArray(data);
            //console.log(array);
            var data = google.visualization.arrayToDataTable(array);


            var chart = new google.visualization.ComboChart(document.getElementById('page'));
            $("#loading-container").css('display', 'none');
            chart.draw(data, options);
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

            function foo(element, queries) {
                resp = [];
                console.log(queries);
                for (i = 0; i < queries.length; i++) {
                    $.ajax({
                        type: "GET",
                        url: "search/count",
                        async: 'false',
                        data: queries[i],
                        dataType: 'json',
                        success: function (res) {
                            resp.push(res);
                            if (resp.length == queries.length) drawChart(element, resp);
                            //if (resp.length == queries.length) console.log(resp);
                        }
                    });
                }
            }

            foo('#page', getSearchSpace());
        });
    </script>
@stop