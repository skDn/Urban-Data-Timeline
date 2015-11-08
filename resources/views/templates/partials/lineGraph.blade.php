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

<div id="page" style="height:100px;width:500px;margin:auto;margin-top:40px;">
    <div id="loading-container" class="row text-center">
        <img src="https://www.musicianswithoutborders.org/wp-content/themes/mwb/images/ajax-loader-light.gif" width="32"
             height="32" alt="tweet loader"/>
    </div>
</div>

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
    $(document).ready(function () {
        var dict = {};
        $('input').each(function () {
            dict[$(this).attr("name")] = ($(this).val().length > 0) ? $(this).val() : $(this).text();
        });
        dict['day'] = $(dayInputID).text().trim();
        dict['month'] = $(monthInputID).text().trim();
        dict['year'] = $(yearInputID).text().trim();
        resp = [];
        function foo() {
            var upper = parseInt(dict['day']) + 5;
            var lower = parseInt(dict['day']) - 5;
            var result = [];
            for (i = lower; i < upper; i++) {
                dict['day'] = i + "";
                $.ajax({
                    type: "GET",
                    url: "search/count",
                    async: 'false',
                    data: dict,
                    dataType: 'json',
                    success: function (res) {
                        resp.push(res);
                        if (resp.length == 10) {
                            drawLines('#page', resp);
                        }
                    }
                });
            }
        }
        foo();
    });
</script>