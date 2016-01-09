/**
 * Created by yordanyordanov on 04/01/2016.
 */

$(function () {
    $('[data-toggle="tooltip"]').tooltip();

})

$('#googleMap').hover(function() {
    $('[data-toggle="popover"]').popover('show');
}, function(){
    $('[data-toggle="popover"]').popover('hide');
});
