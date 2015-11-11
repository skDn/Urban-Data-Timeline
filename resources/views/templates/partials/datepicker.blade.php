<style type="text/css">
    .btn {
        border: 0px solid transparent; /* this was 1px earlier */
    }

    .btn-group-justified div, a:not(:last-of-type) {
        border-right: 1px solid #ccc;
    }

    div > ul {
        box-sizing: border-box;
    }

    .choice {
        width: 600px;
    }
</style>
{{--TODO: remove hardcoded code and make javascript to add each field automatically --}}
<div class=" form-inline" style="margin-top:15px;">
    <div class="btn-group btn-group-justified" role="group" aria-label="...">

        <a type="button" title="Decrement Day" class="btn btn-default" data-action="decrementDays"><span
                    class="glyphicon glyphicon-menu-left"></span></a>

        <div class="btn-group" role="group">
            <a type="button" class="btn btn-default dropdown-toggle" id="day" data-toggle="dropdown">
                @if (isset($data['search']['day']))
                    {{ $data['search']['day'] }}
                @else
                    Day <span class="glyphicon glyphicon-menu-down"></span>
                @endif
            </a>
            <input type="hidden" name="day"/>
            <ul id="test" class="dropdown-menu">

                <li><a type="button" class="btn btn-default">1</a></li>

                <li><a type="button" class="btn btn-default">2</a></li>

                <li><a type="button" class="btn btn-default">3</a></li>

                <li><a type="button" class="btn btn-default">4</a></li>

                <li><a type="button" class="btn btn-default">25</a></li>

            </ul>
        </div>
        <div class="btn-group" role="group">
            <a type="button" class="btn btn-default dropdown-toggle" id="month" data-toggle="dropdown">
                @if (isset($data['search']['month']))
                    {{ $data['search']['month'] }}
                @else
                    Month <span class="glyphicon glyphicon-menu-down"></span>
                @endif
            </a>
            <input type="hidden" name="month">
            <ul id="test" class="dropdown-menu">

                <li><a type="button" class="btn btn-default">January</a></li>

                <li><a type="button" class="btn btn-default">February</a></li>

                <li><a type="button" class="btn btn-default">March</a></li>

                <li><a type="button" class="btn btn-default">April</a></li>

                <li><a type="button" class="btn btn-default">August</a></li>

            </ul>

        </div>
        <div class="btn-group" role="group">
            <a type="button" class="btn btn-default dropdown-toggle" id="year" data-toggle="dropdown">
                @if (isset($data['search']['year']))
                    {{ $data['search']['year'] }}
                @else
                    Year <span class="glyphicon glyphicon-menu-down"></span>
                @endif
            </a>
            <input type="hidden" name="year">
            <ul id="test" class="dropdown-menu">

                <li><a type="button" class="btn btn-default">2015</a></li>

                <li><a type="button" class="btn btn-default">2014</a></li>

                <li><a type="button" class="btn btn-default">2013</a></li>

                <li><a type="button" class="btn btn-default">2012</a></li>

            </ul>

        </div>

        <a type="button" title="Increment Day" class="btn btn-default" data-action="incrementDays"><span
                    class="glyphicon glyphicon-menu-right"></span></a>

    </div>
</div>
@section('scripts')
    @parent

    <script type="text/javascript">
        //   	$('#test li').on('click', function(){
        //   		$('#test1').text($(this).text());
        // });
        var dayInputID = "#day";
        var monthInputID = "#month";
        var yearInputID = "#year";

        var monthNames = ["January", "February", "March", "April", "May", "June",
            "July", "August", "September", "October", "November", "December"];

        $(".dropdown-menu li").click(function () {
            var relatedAnchorID = $(this).closest('div').find('a').attr("id");
            $('#' + relatedAnchorID).text($(this).text());
        });
        $('.btn-group ul').each(function () {
            $(this).css({'width': $(this).parent().width()});
        });
        $(".btn-group-justified a").click(function () {
            //console.log($(this).attr('data-action'));
            //console.log($(this).attr('data-action') );
            if ($(this).attr('data-action') === 'decrementDays' || $(this).attr('data-action') === 'incrementDays') {

                var day = $(dayInputID).text();
                var month = $(monthInputID).text();
                var year = $(yearInputID).text();

                var d = new Date(year, monthNames.indexOf(month), day);

                if ($(this).attr('data-action') === 'decrementDays') {
                    d.setDate(d.getDate() - 1);
                }
                if ($(this).attr('data-action') === 'incrementDays') {
                    d.setDate(d.getDate() + 1);
                }
                $(dayInputID).text(d.getDate());
                $(monthInputID).text(monthNames[d.getMonth()]);
                $(yearInputID).text(d.getFullYear());

            }

            //$("#dayInput").val('1');
            //console.log($("#day").next());

        });
        $('form').submit(function (event) {
            $(dayInputID).next().val($(dayInputID).text());
            $(monthInputID).next().val(monthNames.indexOf($(monthInputID).text()) + 1);
            $(yearInputID).next().val($(yearInputID).text());
        });

    </script>
@stop