/**
 * Created by skDn on 12/11/2015.
 */

var monthNames = ["January", "February", "March", "April", "May", "June",
    "July", "August", "September", "October", "November", "December"];

var dayID = "#day_";
var monthID = "#month_";
var yearID = "#year_";
var dateInputId = "#date_"

function getDate(elementID) {
    var thisDay, thisMonth, thisYear;
    if (elementID != undefined) {
        thisDay = $(dayID + elementID).text().trim();
        thisMonth = $(monthID + elementID).text().trim();
        thisYear = $(yearID + elementID).text().trim();
    }
    else {
        thisDay = $(dayID).text().trim();
        thisMonth = $(monthID).text().trim();
        thisYear = $(yearID).text().trim();
    }
    return thisYear+'-'+thisMonth+'-'+thisDay;
}


$(".dropdown-menu li").click(function () {
    var itemID = '#' + $(this).closest('div').find('a').attr("id");
    $(itemID).text($(this).text());
});
$(".btn-group ul").each(function () {
    $(this).css({'width': $(this).parent().width()});
});
$(".btn-group-justified a").click(function () {
    //console.log($(this).attr('data-action'));
    //console.log($(this).attr('data-action') );
    if ($(this).attr('data-action') === 'decrementDays' || $(this).attr('data-action') === 'incrementDays') {
        //var aID = $(this).attr("id").split('_')[1];
        var aID = '';
        var dayInputID = dayID+aID;
        var monthInputID = monthID+aID;
        var yearInputID = yearID+aID;


        var day = $(dayInputID).text();
        var month = $(monthInputID).text();
        var year = $(yearInputID).text();

        var d = new Date(year, month-1, day);

        if ($(this).attr('data-action') === 'decrementDays') {
            d.setDate(d.getDate() - 1);
        }
        if ($(this).attr('data-action') === 'incrementDays') {
            d.setDate(d.getDate() + 1);
        }
        $(dayInputID).text(d.getDate());
        $(monthInputID).text(d.getMonth()+1);
        $(yearInputID).text(d.getFullYear());

    }

    //$("#dayInput").val('1');
    //console.log($("#day").next());

});
$('form').submit(function (event) {
    //$('input').each(function () {
    //    var itemID = $(this).attr('id');
    //    if ( itemID != undefined && itemID.indexOf('date') > -1 ) {
    //        var index = itemID.split('_')[1];
    //        $(dateInputId+index).val(getDate(index));
    //    }
    //});
    $(dateInputId).val(getDate());
});