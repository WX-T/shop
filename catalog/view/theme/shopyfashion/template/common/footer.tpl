<!--回到顶部-->
	<p class="backtop"></p>
	<script src="http://cdn.legoods.com/boc/javascript/js/swiper.min.js" type="text/javascript" charset="utf-8"></script>
	<script src="http://cdn.legoods.com/boc/javascript/js/common.js" type="text/javascript" charset="utf-8"></script>
	<script src="http://cdn.legoods.com/boc/javascript/js/yxMobileSlider.js" type="text/javascript" charset="utf-8"></script>
	<script src="http://cdn.legoods.com/boc/javascript/layer/layer.js" type="text/javascript" charset="utf-8"></script>
<script type="text/javascript">
	$(function(){
		//轮播
		var bannerW=$(window).width();
		$(".slider").yxMobileSlider({width:'100%',height:'11rem',during:5000});
		$(".banner img").css("height","auto");
		//滑动
	    var swiper = new Swiper('.swiper-container', {
	        pagination: '.swiper-pagination',
	        slidesPerView: 3.555556,
	        paginationClickable: true,
	        spaceBetween: 0,
	        freeMode: true
	    });
	    //搜索框固定+回到顶部出现
	    $(window).scroll(function(){
			var srcollH=$(window).scrollTop();
			var listH=parseInt($(".brand-choose").offset().top);
			if(srcollH>listH){
				$(".top-search").css({"position":"fixed","top":"0"});
				$(".backtop").show();
			}else{
				$(".top-search").css({"position":"absolute"});
				$(".backtop").hide();
			}
		});
	    //回到顶部
	    $(".backtop").click(function(){
	    	$('body,html').animate({scrollTop:0},300);  
        	return false;  
	    });
	    
	})
</script>
<script>
    var _hmt = _hmt || [];
    (function() {
      var hm = document.createElement("script");
      hm.src = "//hm.baidu.com/hm.js?cd9c4a5618d7dc46a27849db7828d863";
      var s = document.getElementsByTagName("script")[0]; 
      s.parentNode.insertBefore(hm, s);
    })();
</script>
</body>
</html>