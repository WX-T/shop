<!DOCTYPE html>
<html>
	<head>
		<meta charset="UTF-8">
		<meta name="viewport" content="width=device-width,initial-scale=1,minimum-scale=1,maximum-scale=1,user-scalable=no" />	
		<link href="http://cdn.legoods.com/boc/css/indexnew.css" rel="stylesheet" />
		<script src="http://cdn.legoods.com/boc/javascript/jquery/jquery-2.1.1.min.js" type="text/javascript" charset="utf-8"></script>
		<title>首页</title>
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
	<body>
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
<script type="text/javascript">
  (function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){
  (i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),
  m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)
  })(window,document,'script','https://www.google-analytics.com/analytics.js','ga');

  ga('create', 'UA-81008565-1', 'auto');
  ga('send', 'pageview');

</script>		
	<!--顶部搜索页面-->
	<div class="top-search">
		<a href="index.php?route=product/categorylist&path=1141"><p class="menu-icon"></p></a>
		<a href="###" class="logo"><img class="lazy"  src="http://cdn.legoods.com/boc/shopyfashion/image/logo.png"/></a>
		<p class="search-icon"></p>
		<div class="search">
			<p class="search-btn" id="searchbt"></p><input id="searchtext" type="text" placeholder="搜索你想找的商品" />
		</div>
	</div>
	<div class="top-mask">
	</div>
		<script type="text/javascript">
			var mySwiper = new Swiper('.swiper-container',{
				slidesPerView : 4
			})
		</script>	
	<script type="text/javascript">
	    $("#searchbt").click(function(){
	    	window.open("<?php echo $url ?>"+'&search='+$('#searchtext').val(),"_parent");
	    	
		});
		$('#searchtext').on('keydown', function(e) {
			if (e.keyCode == 13) {
				$('#searchbt').trigger('click');
			}
		});

		//图片大小加载
		function getNaturalWidth(img) {
		    var image = new Image()
		    image.src = img.src
		    var naturalWidth = image.width;
		    var neturalHeight = image.height;
		    return naturalWidth-neturalHeight;
		}
		window.onload = function(){
		    $(".brand-choose .swiper-slide .img img").each(function(){
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
		   $(".everyday-new .goods .goods-img img").each(function(){
			   $(this).css({"width":"auto","height":"auto"});
			   var fontsize =$(window).width()/32*20;
		    	if(getNaturalWidth(this)>0){
		    		
		    		$(this).css({"width":"100%","margin-top":(fontsize-imgH)/2});
		    		var imgH = $(this).height();
		    		$(this).css("margin-top",(fontsize-imgH)/2);
		    	}else{
		    		$(this).css({"height":"100%","margin":"0 auto"});
		    	}
		   }); 
		}
		//new 
	    $(".search-icon").click(function(){
	    	$(this).hide();
	    	$(".logo").hide();
	    	$(".search").css("display","inline-block").find("input").focus();
	    })
	    $(".search input").blur(function(){
	    	$(this).parent().hide();
	    	$(".logo,.search-icon").css("display","inline-block");
	    })
	</script>