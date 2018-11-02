(function($){

	// This handles the sidebar scrolling
	// measurements are only good once EVERYTHING is loaded
	var win = $(window);
	win.load(function(){

		var sidebar = $(".sidebar-inner");
		// If there's no sidebar, no sense doing any of this
		if(sidebar.length){

			var documentHeight; // used to determine if has changed
			var windowWidth;
			var windowHeight;
			var sidebarOffset;
			var endOfSidebarRow;
			var sidebarHeight;
			var scrollDistance = 0;
			var ticking = false;
			var topPadding = sidebar.find(".block").css("margin-top").replace("px", "");
			var supportPageOffset = window.pageYOffset !== undefined;
			var isCSS1Compat = ((document.compatMode || "") === "CSS1Compat");

			// fix the width
			sidebar.width(sidebar.parent().width());

			// Smart resize events are fired only once per resize
			win.smartresize(function(){
				calculateDimensionsAndOffsets();
				win.scroll();
			});

			function calculateDimensionsAndOffsets(){
				windowWidth = win.width();
				windowHeight = win.height();
				sidebar.width(sidebar.parent().width());
				sidebarOffset	= sidebar.parent().offset().top;
				endOfSidebarRow	=  sidebar.parents(".row").height() + sidebarOffset;
				sidebarHeight 	=  sidebar.height();
				documentHeight 	= document.body.clientHeight; // used to detect need to recalculate dimensions
			}

			calculateDimensionsAndOffsets();

			/*
			 * Callback for our scroll event - just
			 * keeps track of the last scroll value
			 */
			function onScroll() {
			    scrollDistance = supportPageOffset ? window.pageYOffset : isCSS1Compat ? document.documentElement.scrollTop : document.body.scrollTop;
			    requestTick();
			}

			/**
			 * Calls rAF if it's not already
			 * been done already
			 */
			function requestTick() {
			    if(!ticking) {
			        requestAnimationFrame(updateSidebarPosition);
			        ticking = true;
			    }
			}

			/**
			* Our animation loop - called by rAF
			* minimize jQuery calls for performance
			*/
			function updateSidebarPosition() {

				// do a quick check to see if the height of the page has changed
				// which indicates something new has loaded in (e.g., a facebook like button, slideshow images, etc.)
				// this needs to be a super lightweight check, so using http://jsperf.com/clientheight-vs-jquery-height
				if(documentHeight != document.body.clientHeight){
					calculateDimensionsAndOffsets();
				}

				// only do this if the height of the sidebar is less than the height of the window itself
				// and we've scrolled past the top of the sidebar (window.pageYOffset is faster than jQuery scrollTop() but is not IE8 compat)
				if (windowWidth >= 720 && scrollDistance > sidebarOffset && sidebarHeight <= windowHeight) {
					if (scrollDistance <= (endOfSidebarRow - sidebarHeight - 2*topPadding)) {
						sidebar.css("marginTop", 0);
						sidebar.addClass("fixed");
					} else {
						sidebar.removeClass("fixed");
						sidebar.css("marginTop", endOfSidebarRow - sidebarOffset - sidebarHeight - 1*topPadding);
					}
				} else {
					sidebar.css("marginTop", 0);
					sidebar.removeClass("fixed");
				}

				// allow further rAFs to be called
				ticking = false;
			}

			// Kick this off
			updateSidebarPosition();

			// only listen for scroll events
			window.addEventListener('scroll', onScroll, false);

		}

	}); // end win.load


})(jQuery);
