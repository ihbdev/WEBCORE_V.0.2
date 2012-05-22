$(document).ready(function() {
	//menu first
	$('.firstlink', $('.sidebar-left ul')).live("click", function(){
		var parent = $(this).parent();
		if ($(parent).hasClass("active")){
    		$(parent).removeClass("active");
        }else{
			$('li', $('.sidebar-left ul')).removeClass("active");
            $(parent).addClass("active");
            }    	
    	//return false;
    });
	//menu second
	$('a', $('.sidebar-left ul li ul li')).live("click", function(){
		var parent = $(this).parent();
		if ($(parent).hasClass("active")){
    		$(parent).removeClass("active");
        }else{
			$('li', $('.sidebar-left ul li ul')).removeClass("active");
            $(parent).addClass("active");
            }    	
    	//return false;
    });	
	
	//map call popup
	$("a.map-link").fancybox({
		'transitionIn'		: 'none',
		'transitionOut'		: 'none',
		'titlePosition' 	: 'over',
		'titleFormat'		: function(title, currentArray, currentIndex, currentOpts) {
			return '<span id="fancybox-title-over">' + (title.length ? ' &nbsp; ' + title : '') + '</span>';
		}
	});	
});

//slider
$(window).load(function() {
	$('#slider').nivoSlider({
        effect: 'fade', // Specify sets like: 'fold,fade,sliceDown'
        slices: 15, // For slice animations
        boxCols: 8, // For box animations
        boxRows: 4, // For box animations
        animSpeed: 500, // Slide transition speed
        pauseTime: 5000, // How long each slide will show
        startSlide: 0, // Set starting Slide (0 index)
        directionNav: true, // Next & Prev navigation
        directionNavHide: true, // Only show on hover
        controlNav: true, // 1,2,3... navigation
        controlNavThumbs: false, // Use thumbnails for Control Nav
        controlNavThumbsFromRel: false, // Use image rel for thumbs
        controlNavThumbsSearch: '.jpg', // Replace this with...
        controlNavThumbsReplace: '_thumb.jpg', // ...this in thumb Image src
        keyboardNav: true, // Use left & right arrows
        pauseOnHover: false, // Stop animation while hovering
        manualAdvance: false, // Force manual transitions
        captionOpacity: 0.6, // Universal caption opacity
        prevText: 'Prev', // Prev directionNav text
        nextText: 'Next', // Next directionNav text
        randomStart: false, // Start on a random slide
        beforeChange: function(){}, // Triggers before a slide transition
        afterChange: function(){}, // Triggers after a slide transition
        slideshowEnd: function(){}, // Triggers after all slides have been shown
        lastSlide: function(){}, // Triggers when last slide is shown
        afterLoad: function(){} // Triggers when slider has loaded
    });
});

//function product first slider
function slideSwitch() {
 $('a.service-img IMG.active').each(function(){
  var t = this;
  var $next =  $(t).next().length ? $(t).next()
       : $('.first', $(t).parent());
 
  $(t).addClass('last-active');

  $next.css({opacity: 0.0})
   .addClass('active')
   .animate({opacity: 1.0}, 1000, function() {
    $(t).removeClass('active last-active');
   });
 });    
}
//call product first slider
$(function() {
    setInterval( "slideSwitch()", 5000 );
});
