(function($){

	var win = $(window);

	$(document).ready(function(){

		// Extra actions to take when dropdown is shown
		$('.dropdown').on('shown.bs.dropdown', function (event){
			if( !event ) event = window.event;
			var dropdown = $(event.target);
			// Set aria-expanded to true
			dropdown.find('.dropdown-menu').attr('aria-expanded', true);

			// Improve the default positioning of dropdown menus
			// by making them dependant on the available size
			fitActiveDropdownsToScreen(dropdown);
		});


		// Extra actions to take when dropdown is closed
		$(document).on('hidden.bs.dropdown', function(event) {
			if( !event ) event = window.event;
			var dropdown = $(event.target);

			// Set aria-expanded to false 
			dropdown.find('.dropdown-menu').attr('aria-expanded', false);
		});

		// Actions to take when window is resized
		win.smartresize(function(){
			$(".dropdown.open").each(function(){
				activateDefaultTabs();
				fitActiveDropdownsToScreen(this);
			});
		});

		
	    /*
	    *
	    * Simple vertical tabs for megamenus
	    * designed to be a bit easier to make responsive than default bootstrap tabs
	    * In the dropdown menu, convert items with class of megamenu_tab 
	    * into functional megamenus
	    *
	    */

	    // Find all menus containing megamenu_tab items
	    // (megamenu_tabs are links inserted into the menu with a path of <megamenu_tab>)
	    // Barista Special Menu Items converts them into a span with that class.
	    // Add a container for the tab content to go in, add classes to make megamenus function
	    $('.dropdown-menu').has('.megamenu_tab')
	    .addClass('megamenu')
	    .children("ul")
	    .wrap('<div class="row"></div>')
	    .addClass('megamenu-tabs')
	    .parent().append('<div class="barista-tab-content-holder"></div>');

	    $('.dropdown-menu .megamenu_tab').parent().addClass("megamenu-tab-container");

	    // Convert megamenu tab spans to <a> tags
	    $('.dropdown-menu span.megamenu_tab').each(function(){   
	      $(this).replaceWith('<a href="#" class="megamenu_tab">'+$(this).html()+' <i class="fa fa-chevron-right"></i></a>');
	    });

	    // Handle clicking of megamenu tabs
	    $('.dropdown-menu a.megamenu_tab').click(function (e) {

	      // prevent clicks in tabs nested under dropdowns from collapsing the dropdown
	      e.stopPropagation();
	      e.preventDefault();

	      // We use this to determine if we're in vertical tab mode or in collapsey mode (small screens)
	      mode = "vertical_tab";
	      if($(".barista-tab-content-holder").css("display") == "none"){
	        mode = "collapse";
	      }

	      // With collapsibles, we allow them all to be collapsed (whereas vertical tabs, one is always open)
	      if(mode == "vertical_tab") {
	        $(this).parent("li").addClass("active").siblings().removeClass('active');
	      } else {
	        $(this).parent("li").toggleClass("active").siblings().removeClass('active');
	      }

	      content = $(this).parent("li").find(".menu");
	      vertical_content_holder = $(this).parents(".megamenu").find(".barista-tab-content-holder");
	      megamenutabs = vertical_content_holder.siblings('ul.megamenu-tabs');
	      
	      if(mode == "collapse"){
	        // Slide up every submenu that isn't active
	        megamenutabs.children("li").not(".active").children(".menu").slideUp();
	        megamenutabs.children("li.active").children(".menu").slideDown();

	      }

	      // go ahead and do the vertical tab content move in case they switch modes (rotate device, etc.)
	      vertical_content_holder.empty();
	      vertical_content = content.clone(true,true).show(); // true indicates that events should be cloned
	      vertical_content_holder.append(vertical_content);

	      vertical_content_holder.css("min-height",0);
	      megamenutabs.css("min-height",0);

	      // make sure tab container, with the grey background, is at least as tall as the content holder beside it
	      megamenutabs.css("min-height",vertical_content_holder.height());
	      // make sure tab content, with the white background, is at least as tall as the tabs container beside it
	      vertical_content_holder.css("min-height",megamenutabs.outerHeight());

	      // This is listened for in the AZ Directory and FacultyDB integration js
	      $(this).trigger('megamenutab-activated');

	    });

	    // when the dropdown is shown, reclick the active tab to ensure height calculation
	    // for tab container is accurate
	    $('.dropdown-menu.megamenu').parent().on('shown.bs.dropdown', function () {
	      $(this).find('.active > a.megamenu_tab').click();
	    });

	    // Click any tabs that are anchor links matching window hash
	    // has the effect of defaulting to tabs appropriately
	    if(window.location.hash){
	      $('a[href="' + window.location.hash + '"]').click();
	    }

	    activateDefaultTabs();

	});


    // call this on open of dropdowns, and on resize
    function fitActiveDropdownsToScreen(dropdown){
      // reset to default positions
      // max-width on the actual item may be set to be smaller
      $(dropdown).children(".dropdown-menu").css("width","500px");
      $(dropdown).children(".dropdown-menu").css("left",0)

      offset = $(dropdown).offset();
      dropdown_container_offset = $(".nav-site").position();
      dropdown_container_width = $(".nav-site").width();
      window_width = $( window ).width();
      dropdown_width = $(dropdown).children(".dropdown-menu").width();
      right_overflow = (dropdown_width + offset.left) - (window_width - 2 * dropdown_container_offset.left);

      if(dropdown_width > .85*dropdown_container_width){

        // too big for this window size, or close to 100% already
        $(dropdown).children(".dropdown-menu").css("left",(dropdown_container_offset.left-offset.left) + "px").width(window_width - 2 * dropdown_container_offset.left);

	    } else if(right_overflow >  0){

	        // Fits, but not when aligned typically.
	        // slide to the left the amount it was extending past window
	        $(dropdown).children(".dropdown-menu").css("left",(0-right_overflow) + "px");

	    } else {

	        // Fits, doesn't overlap right side. Put it right where it usually would be
	        $(dropdown).children(".dropdown-menu").css("left",0);

	    }
	}

	// Called on load and on resize
	function activateDefaultTabs(){

		$('.megamenu').each(function(){

			// Hide all inactive content from collapsibles
			$(this).find("li.megamenu-tab-container").not(".active").children(".menu").hide();

			// in vertical tab mode
			if($(".barista-tab-content-holder").css("display") != "none"){
				// if a particular tab isn't already active, mark the first tab as active
				if($(this).find("li.megamenu-tab-container.active").length < 1){
					$(this).find('li.megamenu-tab-container').first().addClass("active");
				}

			} else {
				
			}
		});
		// Make content match what it should look like when clicked
		$(".megamenu-tab-container.active").children('a').each(function(){
			$(this).click();
		});

	}




})(jQuery);
