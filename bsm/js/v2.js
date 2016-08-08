/**
 *
 */

$(document).ready(function (){


  
});


//function to scroll when clicking on navbar
$("#navbar-collapse-main ul li a[href^='#'], #home a[href^='#']").on('click', function(e) {
   // prevent default anchor click behavior
   e.preventDefault();

   // store hash
   var hash = this.hash;

   // animate
   $('html, body').animate({
       scrollTop: $(hash).offset().top
     }, 300, function(){

       // when done, add hash to url
       // (default click behaviour)
       window.location.hash = hash;
     });

});

//update address bar when scrolling
$(window).on('activate.bs.scrollspy', function (e) {
    history.replaceState({}, "", $("a[href^='#']", e.target).attr("href"));
});