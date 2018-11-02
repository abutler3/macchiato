(function($){

  $(document).ready(function(){

    if($.isFunction($.flexslider)){
      $('.flexslider-homepage').flexslider({
        
        easing: "swing",
        animation: "slide",
        touch: false,
        pauseOnHover: true, 
        controlNav: true,
        before: function(slider){
          slider.parent().find(".hero-caption").hide();
        },
        start: function(slider){
          $('body').removeClass('loading');
          if(slider.find(".flex-active-slide").find("figcaption").length){
            slider.parent().find(".hero-caption").html(slider.find(".flex-active-slide").find("figcaption").html());
            slider.parent().find(".hero-caption").slideDown(400);
          }
        },

        after: function(slider){
          if(slider.find(".flex-active-slide").find("figcaption").length){
            slider.parent().find(".hero-caption").html(slider.find(".flex-active-slide").find("figcaption").html());
            slider.parent().find(".hero-caption").fadeIn(400);
          }
        }

      });

      $('.flexslider-full').flexslider({
        animation: "fade",
        pauseOnHover: true 

      });

      $('.flexslider-thumbnails').flexslider({
        controlNav: "thumbnails",
        pauseOnHover: true
      });
    }

  });

})(jQuery);
