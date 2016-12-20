<!DOCTYPE html>
<html>
	<head>
		<meta charset="UTF-8">
		<meta name="viewport" content="width=device-width,initial-scale=1,minimum-scale=1,maximum-scale=1,user-scalable=no" />	
		<title>分类</title>
		<link href="http://cdn.legoods.com/boc/css/indexnew.css" rel="stylesheet" />
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
		<!--top-->
			<!--顶部搜索页面-->
	<div class="top-search">
		<a href="index.php"><p class="menu-icon"></p></a>
		<a href="###" class="logo"><img class="lazy"  src="http://cdn.legoods.com/boc/shopyfashion/image/logo.png"/></a>
		<p class="search-icon"></p>
		<div class="search">
			<p class="search-btn" id="searchbt"></p><input id="searchtext" type="text" placeholder="搜索你想找的商品" />
		</div>
	</div>
	<div class="top-mask">
	</div>
		<!--main-->
		<div class="main">
			<!--左边栏-->
			<div class="slide">
				<ul class="nav">
					<!--  <li class="" onclick="getchild('manufacturer')">国际大牌</li>-->
					<?php foreach($list as $key=>$v){?>
    					<li class="<?php echo $urlpath==$v['path']?'active':''?>" onclick="getchild(<?php echo $v['path']?>)" path="<?php echo $v['path']?>"><span></span><?php echo $v['name']?></li>
    				<?php }?>
				</ul>
			</div>
			<!--content-->
			<div class="content">
				<div class="part">
				</div>
			</div>
		</div>
		<div class="btm-five" style="height: 50px;width:100%;"></div>
			<div class="footer-menu fixed">
                <div class="footer-menu-content pure-form pure-g">
                    <div class="pure-u-1-4">
                        <div class="menu ">
                            <a href="http://m.boccfc.cn/haitao/index.html">
                                <div class="menu-img home-icon"></div>
                                <div class="menu-word">首页</div>
                            </a>
                        </div>
                    </div>
                    <div class="pure-u-1-4">
                        <div class="menu show">
                        	<a href="http://m.boccfc.cn/haitao/view/mall/haitaomall.html">
        	                    <div class="menu-img consume-icon">
        	                    </div>
        	                    <div class="menu-word menu-htmall">商城</div>
                            </a>
                        </div>
                    </div>
                    <div class="pure-u-1-4">
                        <div class="menu">
                        	<a href="http://m.boccfc.cn/haitao/view/mall/haitaocart.html">
        	                    <div class="menu-img pay-icon">
        	                    </div>
        	                    <div class="menu-word menu-htcart">购物车</div>
                            </a>
                        </div>
                    </div>
                    <div class="pure-u-1-4">
                        <div class="menu">
                            <a href="http://m.boccfc.cn/haitao/login.html">
                                <div class="menu-img user-icon">
                                </div>
                                <div class="menu-word">我的海贝</div>
                            </a>
                        </div>
                    </div>
                </div>
            </div>
		<script src="http://cdn.legoods.com/boc/javascript/jquery/jquery-2.1.1.min.js" type="text/javascript" charset="utf-8	"></script>
		<script src="http://cdn.legoods.com/boc/javascript/js/jquery.lazyload.js" type="text/javascript" charset="utf-8"></script>
		<script type="text/javascript">
			//搜索框固定+回到顶部出现
    	    $(window).scroll(function(){
    			var srcollH=$(window).scrollTop();
    			var listH=$(window).height();
    			if(srcollH>listH){
    				$(".top-search").css({"position":"fixed","top":"0"});
    				$(".backtop").show();
    			}else{
    				$(".top-search").css({"position":"absolute"});
    				$(".backtop").hide();
    			}
    		});
			$(function(){
				//$(".back").click(function(){history.go(-1)});
				//搜索
				$(".search-btn").click(function(){
			    	window.location="<?php echo $url ?>"+'&search='+$('#searchtext').val();
				});
				$('#searchtext').on('keydown', function(e) {
					if (e.keyCode == 13) {
						$('.search-btn').trigger('click');
					}
				});
				//图片懒加载
				 $("img.lazy").lazyload({
				 	threshold : 200,
				 	effect : "fadeIn",
				 	failure_limit : 10,
				 	skip_invisible : false
				 });
				//初始化显示 【为你推荐】
				$(".part").show();
				//点击左侧nav切换右边内容
				var index=$(".nav li").index($(".active"))+1;
				$(".nav li").click(function(){
					$(".nav li").removeClass("active");
					$(this).addClass("active");
					var index=$(".nav li").index(this)+1;
				})
			})
			//首次加载
			getchild(<?php echo $urlpath?>);
			//查询子分类及商品
			function getchild(path){
				$.ajax({
				    url: "index.php?route=product/categorylist/getchild&path=" + path,    //请求的url地址
				    type: "GET",   //请求方式
				    dataType: "json",
				    success: function(data) {
					    $(".part").html("");
					   	if(data['results']== undefined){
					   		for(var i=0;i<data.length;i++){
								$(".part").append("<h2>"+data[i]['name']+"</h2>");
								$(".part").append("<ul class='recommend clearfix' id='class"+i+"'>");
								for(var a=0;a<data[i]['child'].length;a++){
									if(data[i]['child'][a]['name']){
										var classname = 'class'+i;
										$("#"+classname).append("<li><a href='"+data[i]['child'][a]['href']+"'><em><img class='lazy' data-original='"+data[i]['child'][a]['image']+"' src='"+data[i]['child'][a]['image']+"' style='display: inline;'></em> <span>"+data[i]['child'][a]['name']+"</span></a></li>");
									}
								}
								$(".part").append("</ul>");
							}
						}else{
							$(".part").append("<h2>国际大牌</h2>");
							$(".part").append("<ul class='recommend clearfix' id='manufacture'>");
							for(var i=0;i<data['results'].length;i++){
								$("#manufacture").append("<li><a href='"+data['results'][i]['href']+"'><em><img class='lazy' data-original='"+data['results'][i]['image']+"' src='"+data['results'][i]['image']+"' style='display: inline;'></em> <span>"+data['results'][i]['name']+"</span></a></li>");
							}
							$(".part").append("</ul>");
						}
						
				    },
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
