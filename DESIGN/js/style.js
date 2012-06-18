$(document).ready(function() {
	//menu first
	$('.firstlink', $('.menu-left ul')).live("click", function(){
		var parent = $(this).parent();
		if ($(parent).hasClass("active")){
    		$(parent).removeClass("active");
        }else{
			$('li', $('.menu-left ul')).removeClass("active");
            $(parent).addClass("active");
            }    	
    	return false;
    });
	//menu second
	$('a', $('.menu-left ul li ul li')).live("click", function(){
		var parent = $(this).parent();
		if ($(parent).hasClass("active")){
    		$(parent).removeClass("active");
        }else{
			$('li', $('.menu-left ul li ul')).removeClass("active");
            $(parent).addClass("active");
            }    	
    	return false;
    });	
});

//function product first slider
function slideSwitch() {
 $('#slider IMG.active').each(function(){
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
