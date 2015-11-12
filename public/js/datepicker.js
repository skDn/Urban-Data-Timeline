/**
 * Created by skDn on 12/11/2015.
 */

var monthNames = ["January", "February", "March", "April", "May", "June",
    "July", "August", "September", "October", "November", "December"];

function getDate(elementID) {
    var retDict = {};
    $('input').each(function () {
        var attrName = $(this).attr("name");
        if (attrName != undefined && attrName.indexOf(elementID) > -1){
            if(attrName.indexOf('query') > -1){
                retDict['query'] = $(this).val();
            }
            if(attrName.indexOf('day') > -1){
                retDict['day'] = $('#day'+elementID).text().trim();
            }
            if(attrName.indexOf('month') > -1){
                retDict['month'] = $('#month'+elementID).text().trim();
            }
            if(attrName.indexOf('year') > -1){
                retDict['year'] = $('#year'+elementID).text().trim();
            }
        }
    });
    return retDict;
}


$(".dropdown-menu li").click(function () {
    var relatedAnchorID = '#' + $(this).closest('div').find('a').attr("id");
    $(relatedAnchorID).text($(this).text());
    $(relatedAnchorID).next().val($(relatedAnchorID).text());
});
$('.btn-group ul').each(function () {
    $(this).css({'width': $(this).parent().width()});
});
$(".btn-group-justified a").click(function () {
    //console.log($(this).attr('data-action'));
    //console.log($(this).attr('data-action') );
    if ($(this).attr('data-action') === 'decrementDays' || $(this).attr('data-action') === 'incrementDays') {
        var aID = $(this).attr("id").split('_')[1];
        var dayInputID = "#day"+aID;
        var monthInputID = "#month"+aID;
        var yearInputID = "#year"+aID;


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
//$('form').submit(function (event) {
//
//    $(dayInputID).next().val($(dayInputID).text());
//    $(monthInputID).next().val(monthNames.indexOf($(monthInputID).text()) + 1);
//    $(yearInputID).next().val($(yearInputID).text());
//});