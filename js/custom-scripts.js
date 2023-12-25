jQuery(document).ready(function ($) {

        
  $=jQuery;

    /* search toggle */

  $(".search-toggle").click(function(){
  $(".search-box").toggle('slow');

  if ( !$(".search-toggle").hasClass("search-active")){
     $(".search-toggle").addClass("search-active");

  }
  else{
  $(".search-toggle").removeClass("search-active");
  }
  
  });

     /* back-to-top button*/

  $('.back-to-top').hide();
  $('.back-to-top').on("click",function(e) {
  e.preventDefault();
  $('html, body').animate({ scrollTop: 0 }, 'slow');
    });
  $('#idolcorp_menu').on("click",function(e) {
  e.preventDefault();
  $('body').toggleClass('idolcorp-menu-active');
  });

    
  $(window).scroll(function(){
    var scrollheight =400;
    if( $(window).scrollTop() > scrollheight ) {
         $('.back-to-top').fadeIn();
        }
      else {
            $('.back-to-top').fadeOut();
           }
   });
//Testimonial slider
  $('#testimonials-slider .bx-slider').bxSlider({
          adaptiveHeight: true,
          pager:false,
     });

  // Mobile search hide on scroll
  $(window).scroll(function(){
    var scrollheight = 100;
    if( $(window).scrollTop() > scrollheight ) {
         $('.search-container').addClass('mobile-search-hide');
        }
      else {
        $('.search-container').removeClass('mobile-search-hide');
      }
   });
});
/* Link Focus Fix */
( function() {
  var is_webkit = navigator.userAgent.toLowerCase().indexOf( 'webkit' ) > -1,
      is_opera  = navigator.userAgent.toLowerCase().indexOf( 'opera' )  > -1,
      is_ie     = navigator.userAgent.toLowerCase().indexOf( 'msie' )   > -1;

  if ( ( is_webkit || is_opera || is_ie ) && document.getElementById && window.addEventListener ) {
    window.addEventListener( 'hashchange', function() {
      var id = location.hash.substring( 1 ),
        element;

      if ( ! ( /^[A-z0-9_-]+$/.test( id ) ) ) {
        return;
      }

      element = document.getElementById( id );

      if ( element ) {
        if ( ! ( /^(?:a|select|input|button|textarea)$/i.test( element.tagName ) ) ) {
          element.tabIndex = -1;
        }

        element.focus();
      }
    }, false );
  }
})();