/**
 * Created by skDn on 29.10.2015 ?..
 */

// doesnt work
//jQuery(document).ready(function($){
//    function handleKeyPress(e,v){
//        var key=e.keyCode || e.which;
//        if (key==13){
//            alert(v);
//        }
//    }
//});

function handleKeyPress(e, v) {
    var key = e.keyCode || e.which;
    if (key == 13) {
        var data = {
            query: v
        };
        $.ajax({
            type: "GET",
            url: "php/getrss.php",
            data: data,
            dataType: 'json',
            success: function (res) {
                //$("#result").append(res);
                $("script[src='index.js']").remove()
                $.each(res, function () {
                    html =
                        '<div class="cd-timeline-block">' +
                        '<div class="cd-timeline-img cd-tweet">' +
                        '<img src="https://g.twimg.com/Twitter_logo_white.png" alt="Tweet">' +
                        '</div>' +
                        '<!-- cd-timeline-img -->' +
                        '<div class="cd-timeline-content">' +
                        '<h2>Count: '+this.count+'</h2>' +
                        '<p>User name'+this.screen_name+'</p>' +
                        '<a href="#0" class="cd-read-more">Read more</a>' +
                        '<span class="cd-date">Jan 14</span>' +
                        '</div>' +
                        '<!-- cd-timeline-content -->' +
                        '</div>' +
                        '<!-- cd-timeline-block -->';
                    $("#cd-timeline").append(html);
                });
                $("body").append('<script src="js/index.js"></script>');
            }
        });
    }
}

/*
 <div class="cd-timeline-block">
 <div class="cd-timeline-img cd-tweet">
 <img src="https://g.twimg.com/Twitter_logo_white.png" alt="Tweet">
 </div>
 <!-- cd-timeline-img -->

 <div class="cd-timeline-content">
 <h2>Title of section 1</h2>

 <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Iusto, optio, dolorum provident rerum aut hic
 quasi placeat iure tempora laudantium ipsa ad debitis unde? Iste voluptatibus minus veritatis qui
 ut.</p>
 <a href="#0" class="cd-read-more">Read more</a>
 <span class="cd-date">Jan 14</span>
 </div>
 <!-- cd-timeline-content -->
 </div>
 <!-- cd-timeline-block -->
 */