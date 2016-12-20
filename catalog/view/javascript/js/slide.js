window.onload = function () {
    var mySwiper1 = new Swiper('#header', {
        freeMode: true,
        slidesPerView: 'auto',
    });
    var mySwiper2 = new Swiper('#banner', {
        autoplay: 5000,
        visibilityFullFit: true,
        loop: true,
        pagination: '.pagination',
    });

    var tabsSwiper = new Swiper('#tabs-container', {
        speed: 500,
        onSlideChangeStart: function () {
            $(".tabs .active").removeClass('active')
            $(".tabs a").eq(tabsSwiper.activeIndex).addClass('active')
        }
    })
    $(".tabs a").on('touchstart mousedown', function (e) {
        e.preventDefault();
        $(".tabs .active").removeClass('active')
        $(this).addClass('active')
        tabsSwiper.slideTo($(this).index());
		$("html,body").animate({scrollTop: 0},200);
    })
    $(".tabs a").click(function (e) {
        e.preventDefault();
        
    })

}