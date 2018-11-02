(function($){

  $(document).ready(function(){

    // ryan's little retina image replacement script, call it anytime it switches to or out of retina
    if (window.matchMedia && window.matchMedia("42").addListener) {
      var isRetinaTest = window.matchMedia("(-webkit-min-device-pixel-ratio: 2),(min-resolution: 192dpi)");
      isRetinaTest.addListener(retinafy);
      retinafy();
    }

  });


  // a little magic for swapping out retina images
  function retinafy(){
    var isRetina = window.matchMedia("(-webkit-min-device-pixel-ratio: 2),(min-resolution: 192dpi)").matches;

    if(isRetina) {
      $('img[data-retina-src]').each(function(){

        if($(this).attr("data-retina-src")){
            $(this).attr("data-nonretina-src", $(this).attr("src"));  // save the old src
            $(this).attr("src",$(this).attr("data-retina-src"));  // replace it with the retina src
          }
        });
    } else {
        // this function was called because it *was* retina but now isn't.  Swap images back out.
        $('img[data-nonretina-src]').each(function(){
          var nonretinasrc = $(this).attr("data-nonretina-src");
          if(nonretinasrc){
            $(this).attr("src",nonretinasrc);  // replace it with the retina src
          }
        });
      }
    }

})(jQuery);
