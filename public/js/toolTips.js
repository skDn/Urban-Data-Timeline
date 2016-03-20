/**
 * Created by yordanyordanov on 04/01/2016.
 */

/**
 * show tooltips
 */
$(function () {
    $('[data-toggle="tooltip"]').tooltip();

})

/**
 * show popovers
 */
$('#googleMap').hover(function() {
    $('[data-toggle="popover"]').popover('show');
}, function(){
    $('[data-toggle="popover"]').popover('hide');

    $('[data-toggle="popover"]').popover({
        container: '.popover'
    });
});
