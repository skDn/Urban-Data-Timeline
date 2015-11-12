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
        function createLine(element, x1, y1, x2, y2, thickness, colour) {
            var length = Math.sqrt((x1 - x2) * (x1 - x2) + (y1 - y2) * (y1 - y2));
            var angle = Math.atan2(y2 - y1, x2 - x1) * 180 / Math.PI;
            var transform = 'rotate(' + angle + 'deg)';
            var thick = thickness + "px";
            var line = $('<div>')
                    .appendTo(element)
                // .addClass('line')
                    .css({
                        'position': 'absolute',
                        'transform': transform,
                        'transform-origin': '0 100%',
                        'height': thick,
                        'background': colour,
                    })
                    .width(length)
                    .offset({left: x1, top: y1});

            return line;
        }

        function createCircle(element, x1, y1, size, colour) {
            // var length = Math.sqrt((x1-x2)*(x1-x2) + (y1-y2)*(y1-y2));
            // var angle  = Math.atan2(y2 - y1, x2 - x1) * 180 / Math.PI;
            // var transform = 'rotate('+angle+'deg)';
            var sizePX = size + "px";
            var borderPX = size / 2 + "px";

            var line = $('<div>')
                    .appendTo(element)
                    .addClass('circle')
                    .css({
                        'position': 'absolute',
                        'width': sizePX,
                        'height': sizePX,
                        'background': colour,
                        '-moz-border-radius': borderPX,
                        '-webkit-border-radius': borderPX,
                        'border-radius': borderPX,
                    })
                    .offset({left: x1 - size / 2, top: y1 - size / 2});

            return line;
        }
        //console.log(element.left + " " + element.top + " " + width + " " + height);

        function drawLines(element, data) {
            $("#loading-container").css('display', 'none');
            var element1 = $(element).offset();
            var wid = $(element).width();
            var height = $(element).height();

            data = sortDictionary(data, 'date');
            var firstCount = data[0]['count'];

            var n = data.length;
            // TODO: refactor this
            var max = firstCount;
            var current;
            for (i = 1; i < n; i++) {
                current = data[i]['count'];
                if (current > max) {
                    max = current;
                }
            }

            var distance = wid / n;
            var start = height - (firstCount / max) * height;

            var left = element1.left;
            var top = element1.top;

            console.log(wid + " " + height);

            var x1 = left;
            var y1 = top + start;

            var x2;
            var y2;

            for (i = 1; i < n; i++) {
                x2 = x1 + distance;
                y2 = top + height - (data[i]['count'] / max) * height;
                createLine(element, x1, y1, x2, y2, 3, 'lightblue');
                createCircle(element, x1, y1, 20, 'blue');
                x1 = x2;
                y1 = y2;

            }
            createCircle(element, x1, y1, 20, 'blue');
        }
        //drawLines('#page', [10, 20, 50, 20, 30, 50, 70, 10, 40]);
        function sortDictionary(d, k) {
            return d.sort(function (x, y) {
                return new Date(x[k]).getTime() - new Date(y[k]).getTime();
            })
        }
        function convertJsonToArray(data) {
            var retArr = [];
            retArr.push(['Day','Count']);
            for (i = 0; i<data.length; i++) {
                retArr.push([data[i]['date'],data[i]['count']]);
            }
            return retArr;
        }

        function drawChart(element, data) {
            data = sortDictionary(data, 'date');
            var array = convertJsonToArray(data);
            var data = google.visualization.arrayToDataTable(array);

            var options = {
                title: 'Tweets',
                hAxis: {title: 'Day',  titleTextStyle: {color: '#333'}},
                vAxis: {minValue: 0}
            };

            var chart = new google.visualization.AreaChart(document.getElementById('page'));
            $("#loading-container").css('display', 'none');
            chart.draw(data, options);
        }

        $(document).ready(function () {
            var searchSpace = [];
            var indexes = ['First', 'Second']
            var getInfo;
            for (i = 0; i<indexes.length;++i){
                getInfo = getDate(indexes[i]);
                if (Object.keys(getInfo).length > 0) {
                    searchSpace.push(getInfo);
                }
            }

            function foo(bound,queries) {
                var upper = parseInt(queries[0]['day']) + bound/2;
                var lower = parseInt(queries[0]['day']) - bound/2;
                var limit = bound * queries.length;
                console.log();
                resp = [];
                var j = 0;
                //for (j = 0;j<queries.length-1;j++) {
                    for (i = lower; i < upper; i++) {
                        queries[j]['day'] = i + "";
                        $.ajax({
                            type: "GET",
                            url: "search/count",
                            async: 'false',
                            data: queries[j],
                            dataType: 'json',
                            success: function (res) {
                                resp.push(res);
                                if (resp.length == bound) {
                                    drawChart('#page', resp);
                                }
                            }
                        });
                    }
                //}

            }

            foo(10,searchSpace);
        });
    </script>
@stop