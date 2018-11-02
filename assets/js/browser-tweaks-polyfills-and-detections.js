/**
 * Protect window.console method calls, e.g. console is not defined on IE
 * unless dev tools are open, and IE doesn't define console.debug
 */
 (function() {
 	if (typeof console === "undefined") {
 		this.console = {
 			log: function() {},
 			info: function() {},
 			error: function() {},
 			warn: function() {}
 		};
 	}
 })();

 (function($){

 	$(document).ready(function(){

		// Detect touch capable browser (not perfect, so don't use it for anything mission critical - UI enhancements ok)
		if (('ontouchstart' in window) || (navigator.maxTouchPoints > 0) || (navigator.msMaxTouchPoints > 0)) {
			$("html").addClass("touch")
		}

	    // annoying, but <IE9 don't support the (super useful) :last-child CSS3 selector 
	    // feature detection for just the last-child selector is hassle-ish, and it's not too big of a deal
	    // so, just polyfill it for <= IE 8(I'm using a pretty standard IE8 and older browser test here.)
	    // the polyfill isn't particularly performant, so it's used sparingly
	    if(document.all && !document.addEventListener){
	    	$(":last-child").addClass("last-child");
	    }

	});

 })(jQuery);


// Debounce .resize()
(function($,sr){
    // debouncing function from John Hann
    // http://unscriptable.com/index.php/2009/03/20/debouncing-javascript-methods/
    var debounce = function (func, threshold, execAsap) {
    	var timeout;

    	return function debounced () {
    		var obj = this, args = arguments;
    		function delayed () {
    			if (!execAsap) {
    				func.apply(obj, args);
    			}
    			timeout = null;
    		}

    		if (timeout) {
    			clearTimeout(timeout);
    		} else if (execAsap) {
    			func.apply(obj, args);
    		}
    		timeout = setTimeout(delayed, threshold || 100);
    	};
    };
    // smartresize 
    jQuery.fn[sr] = function(fn){ return fn ? this.bind('resize', debounce(fn)) : this.trigger(sr); };

})(jQuery,'smartresize');