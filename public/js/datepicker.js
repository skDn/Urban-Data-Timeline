/**
 * Created by skDn on 12/11/2015.
 */

var monthNames = ["January", "February", "March", "April", "May", "June",
    "July", "August", "September", "October", "November", "December"];


var dayID = "#day_";
var monthID = "#month_";
var yearID = "#year_";
var dateInputId = "#date_";
var dayDropDownId = "#dayDropDown";
var monthDropDownId = "#monthDropDown";
var yearDropDownId = "#yearDropDown";
var startYear = 2013;
var endYear = 2015;

/**
 * populating the date picker ui element
 */
$(function () {

    //populating the fields
    var template;
    for (var i = 1; i < 32; i++) {
        template = '<li><a type="button" class="btn btn-default">' + i + '</a></li>';
        $(dayDropDownId).append(template);
    }
    for (i = 1; i < 13; i++) {
        template = '<li><a type="button" class="btn btn-default">' + i + '</a></li>';
        $(monthDropDownId).append(template);
    }
    for (i = startYear; i < endYear + 1; i++) {
        template = '<li><a type="button" class="btn btn-default">' + i + '</a></li>';
        $(yearDropDownId).append(template);
    }
    //end of population
});

/**
 * logic behind the data picker
 */
$(function () {
    $(".dropdown-menu li").click(function () {
        var itemID = '#' + $(this).closest('div').find('a').attr("id");
        $(itemID).text($(this).text());
    });
    $(".btn-group ul").each(function () {
        $(this).css({'width': $(this).parent().width()});
    });
    $(".btn-group-justified a").click(function () {
        if ($(this).attr('data-action') === 'decrementDays' || $(this).attr('data-action') === 'incrementDays') {
            var aID = '';
            var dayInputID = dayID + aID;
            var monthInputID = monthID + aID;
            var yearInputID = yearID + aID;


            var day = $(dayInputID).text();
            var month = $(monthInputID).text();
            var year = $(yearInputID).text();

            var d = new Date(year, month - 1, day);

            if ($(this).attr('data-action') === 'decrementDays') {
                d.setDate(d.getDate() - 1);
            }
            if ($(this).attr('data-action') === 'incrementDays') {
                d.setDate(d.getDate() + 1);
            }
            $(dayInputID).text(d.getDate());
            $(monthInputID).text(d.getMonth() + 1);
            $(yearInputID).text(d.getFullYear());
        }
    });
});
/**
 * submitting the input form
 */
$(function () {
    $('form').submit(function () {
        $(dateInputId).val(getDate());
    });
});

/**
 * getting the current date that is entered
 * @param elementID
 * @returns {*}
 */
function getDate(elementID) {
    var thisDay, thisMonth, thisYear;
    if (elementID !== undefined) {
        thisDay = $(dayID + elementID).text().trim();
        thisMonth = $(monthID + elementID).text().trim();
        thisYear = $(yearID + elementID).text().trim();
    }
    else {
        thisDay = $(dayID).text().trim();
        thisMonth = $(monthID).text().trim();
        thisYear = $(yearID).text().trim();
    }
    if (thisDay === 'Day' || thisMonth === 'Month' || thisYear === 'Year') {
        return undefined;
    }
    if(thisMonth.length == 1) {
        thisMonth = '0' + thisMonth;
    }
    if(thisDay.length == 1) {
        thisDay = '0' + thisDay;
    }
    return thisYear + '-' + thisMonth + '-' + thisDay;
}