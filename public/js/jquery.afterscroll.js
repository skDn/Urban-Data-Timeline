/*!
* jQuery AfterScroll 1.0
*
* Do something once the bottom of an element comes into view,
* and something when you scroll above it too.
* 
* Extended by Matt Fairbrass to do something when the top of an element
* comes into view.
*
* (c) 2011 Matt Wiebe http://somadesign.ca/
* GPL2 / MIT dual-license, just like jQuery
* http://jquery.org/license/
*
*/
(function($){
	$.fn.afterScroll = function(after_top, before_top, after_bottom, before_bottom) {
		var $win = $(window)
		after_top = after_top || $.noop
		before_top = before_top || $.noop
		after_bottom = after_bottom || $.noop
		before_bottom = before_bottom || $.noop
		
		return this.each(function() {
			var t = this,
			self = $(t),
			elOffset = self.offset(),
			elBottomPos = self.outerHeight() + elOffset.top,
			elTopPos = elOffset.top,
			scrolled = false
			/* make it scrolled && $win.scrollTop() + $win.height() 
			   if want to change when element is comming from bottom of screen*/
			$win.scroll(function() {
				/* Top of element */
				// haven't scrolled past yet
				if ( ! scrolled && $win.scrollTop() >= elTopPos ) {
					after_top.apply(t)
					scrolled = true
				}
				// have scrolled past yet
				else if ( scrolled && $win.scrollTop() < elTopPos ) {
					before_top.apply(t)
					scrolled = false
				}
				
				
				/* Bottom of element*/
				// haven't scrolled past yet
				if ( ! scrolled && $win.scrollTop() >= elBottomPos ) {
					after_bottom.apply(t)
					scrolled = true
				}
				// have scrolled past yet
				else if ( scrolled && $win.scrollTop() < elBottomPos ) {
					before_bottom.apply(t)
					scrolled = false
				}
			}).scroll()
		})
	}
})(jQuery);