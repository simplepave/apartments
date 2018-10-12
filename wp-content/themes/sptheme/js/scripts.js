$(document).ready(function(){

	$('.icon-menu').click(function(event){
		$(this).toggleClass('active');
		$(this).next('div.nav_block').toggleClass('active');
	});
	
	$('.nav_block ul li a').on('click', function(){
		$('div.icon-menu').removeClass('active');
		$('div.nav_block').removeClass('active');
	});
	
	$('select').styler({ selectSearch: true });
	
	$(".popup").magnificPopup({removalDelay:300,type:"inline"});
		
});

$(function(){
    });
    $(window).load(function(){
      $('#carousel').flexslider({
        animation: "slide",
        controlNav: false,
        animationLoop: false,
        slideshow: false,
        itemWidth:170,
        itemMargin: 30,
        asNavFor: '#slider'
      });

      $('#slider').flexslider({
        animation: "slide",
        controlNav: false,
        animationLoop: false,
        slideshow: false,
        sync: "#carousel",
        start: function(slider){
          $('body').removeClass('loading');
        }
      });
    });


$(function(){
	$('input[placeholder], textarea[placeholder]').placeholder();
});