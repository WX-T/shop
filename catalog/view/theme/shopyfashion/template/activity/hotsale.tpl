<!DOCTYPE html>
<html>
	<head>
		<meta charset="UTF-8">
		<meta name="viewport" content="width=device-width,initial-scale=1,minimum-scale=1,maximum-scale=1,user-scalable=no" />
		<title>乐购首页界面</title>
		<link rel="stylesheet" type="text/css" href="http://cdn.legoods.com/boc/css/index.css"/>
		<link rel="stylesheet" type="text/css" href="http://cdn.legoods.com/boc/css/swiper.min.css"/>
		<script src="http://cdn.legoods.com/boc/javascript/jquery/jquery-2.1.1.min.js" type="text/javascript" charset="utf-8"></script>
		<script src="http://cdn.legoods.com/boc/javascript/js/swiper.min.js" type="text/javascript" charset="utf-8"></script>
		<style>
            html, body {
            background: transparent !important;
            color: transparent !important;
            background-color: #fff !important;
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            -webkit-backface-visibility: visible;
         }
        </style>	
	</head>
	<body style="background: #fff;padding-bottom: 50px;">
		<script type="text/javascript">
		    !function () {
		        window.onresize = function () {
		            var fontSize = document.documentElement.clientWidth / 32;
		            fontSize = fontSize > 20 ? 20 : fontSize;
		            document.querySelector('html').style.fontSize = fontSize + 'px';
		            document.querySelector('body').style.fontSize = fontSize + 'px';
		        }
		        window.onresize();
		    }();
		</script>
        <?php echo $content_top?>
		<script type="text/javascript">
		    var swiper = new Swiper('.swiper-container', {
		        pagination: '.swiper-pagination',
		        slidesPerView: 3.555556,
		        paginationClickable: true,
		        spaceBetween: 0,
		        freeMode: true
		    });
		    var swipers = new Swiper('.country-swiper', {
		        pagination: '.swiper-pagination',
		        slidesPerView: 2.4,
		        paginationClickable: true,
		        spaceBetween: 10,
		        freeMode: true
		    });
		 
            function getNaturalWidth(img) {
    		    var image = new Image()
    		    image.src = img.src
    		    var naturalWidth = image.width;
    		    var neturalHeight = image.height;
    		    return naturalWidth-neturalHeight;
    		}
    		window.onload = function(){
    		    $(".swiper-slide .img img").each(function(){
        		    $(this).css({"width":"auto","height":"auto"});
    		    	var fontsize =$(window).width()/32*7;
    		    	if(getNaturalWidth(this)>0){
    		    		
    		    		$(this).css({"width":"100%","margin-top":(fontsize-imgH)/2});
    		    		var imgH = $(this).height();
    		    		$(this).css("margin-top",(fontsize-imgH)/2);
    		    	}else{
    		    		$(this).css({"height":"100%","margin":"0 auto"});
    		    	}
    		   });
    		}
		</script>
	</body>
</html>