/**
 * Created by skDn on 02/12/2015.
 */
// Docs at http://simpleweatherjs.com
$(document).ready(function() {
    $.simpleWeather({
        location: 'London, UK',
        woeid: '',
        unit: 'c',
        success: function(weather) {
            // html = '<h2><i class="icon-'+weather.code+'"></i> '+weather.temp+'&deg;'+weather.units.temp+'</h2>';
            // html += '<ul><li>'+weather.city+', '+weather.region+'</li>';
            // html += '<li class="currently">'+weather.currently+'</li>';
            // html += '<li>'+weather.wind.direction+' '+weather.wind.speed+' '+weather.units.speed+'</li></ul>';

            html = '<div class="col-xs-5">'
            html += '<i class="icon-'+weather.code+'"></div>';
            // html += '<ul><li>'+weather.city+', '+weather.region+'</li>';
            html += '<div class="col-xs-5 text-right">';
            html += '<h2></i> '+weather.temp+'&deg;'+weather.units.temp+'</h2></div>';
            // html += '<p class="alerts-heading">'+weather.currently+'</p>';
            // html += '<p class="alerts-text">'+weather.wind.direction+' '+weather.wind.speed+' '+weather.units.speed+'<p></div>';
            $("#weather").html(html);
        },
        error: function(error) {
            $("#weather").html('<p>'+error+'</p>');
        }
    });
});