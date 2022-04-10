$(document).ready(function () {
    $('.owl-carousel').owlCarousel({
        loop: true,
        autoplay:4000, 
        nav: true,
        items: 1,
        dots:false,
    })
    $('.main-menu li').each(function (k, val) {
        $(this).find('a').removeClass('active')

        if (window.location.origin + window.location.pathname == $(this).find('a').attr('href') || window.location.origin + window.location.pathname == ($(this).find('a').attr('href') + '/')) {
            $(this).find('a').addClass('active');
        }
    })
});
$(document).ready(function() {
    var showChar = 70; 
    var ellipsestext = "...";
    
    $('.des .text').each(function() {
        var content = $(this).html();
 
        if(content.length > showChar) {
 
            var c = content.substr(0, showChar);
            var h = content.substr(showChar, content.length - showChar);
 
            var html = c + '<span class="moreellipses">' + ellipsestext+ '&nbsp;</span><span class="morecontent"><span>' + h + '</span><a href="javascript:void(0)" class="morelink"></a></span>';
 
            $(this).html(html);
        }
 
    });
 
    $(".text").hover(function(){
        $(this).toggleClass('active');
        $(this).find('.morelink').addClass("less");
        //$(this).parent().prev().show();
        $(this).find('.moreellipses').hide();
        $(this).find('.morecontent span').show();

        //return false;
    },function(){
        $(this).toggleClass('active');
        $(this).find('.morelink').removeClass("less");
        $(this).find('.moreellipses').show();
        $(this).find('.morecontent span').hide();
    });
});
$(".btn-menu-mob").click(function(){
    $(this).toggleClass("active");
    $('.wrap-menu').toggleClass("toggle");
});
if($(window).width() < 1024){
    var mySwiper = new Swiper ('.swiper-container', {
        loop: true,
        grabCursor: true,
        slidesPerView: 3,
        slidesPerView: 'auto',
        centeredSlides: true,
        pagination: {
          el: '.swiper-pagination',
        },
      });
}
