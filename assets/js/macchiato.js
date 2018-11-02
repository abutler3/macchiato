(function($){

    var win = $(window);
    var nav_position = "bottom";
    var no_js = true;

    $(document).ready(function(){

      $("#brandDropdown").addClass("collapse");
      $("#brandCollapseButton").addClass("collapsed");

      // premptively execute resize early so above code runs as quick as possible (since may cause page reflow.)
      win.smartresize();

      // in order to use a dropdown within this collapsing element, need to toggle overflow
      $('#searchFormWrapper').on({
        shown: function(){
          $(this).css('overflow','visible');
        },
        hide: function(){
          $(this).css('overflow','hidden');
        }
      });

    // make tables responsive by wrapping them in a div (and applying overflow-x: auto to that div)
    $('.main-content-container').find('table').wrap('<div class="responsive-table" />');

    // enable popovers on anything with a popover class (or some legacy classes)
    $(".clickover-trigger, .popover-trigger, [data-toggle=popover]").each(function(){
      // Place the title in a different attribute temporarily
      $(this).attr("data-title-holder", $(this).attr("title"));
    }).popover().on('show.bs.popover', function (e) {
      // Populate the popover title with a close button
      var $element = $(this);
      titleWithCloseButton = $element.attr("data-title-holder") + '<button type="button" id="close" class="close">&times;</button>';
      $element.attr('data-original-title', titleWithCloseButton);
    }).on('shown.bs.popover', function (e) {
      // attach close button functionality 
      var $element = $(this);
      $("#close").click(function () {
        $element.trigger("click");
      });
    }).on('click',function(e){
      // prevent links that trigger popovers from jumping to top of page
      e.preventDefault();
    });


  }); // end document.ready


})(jQuery);
