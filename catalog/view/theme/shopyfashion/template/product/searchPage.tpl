<!DOCTYPE html>
<html>
	<head>
		<meta charset="UTF-8">
		<meta name="viewport" content="width=device-width,initial-scale=1,minimum-scale=1,maximum-scale=1,user-scalable=no" />	
		<title>搜索</title>
		<link href="catalog/view/theme/shopyfashion/stylesheet/shoppingcar.css" rel="stylesheet">
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
		<div class="head">
			<div class="back">
				<img src="catalog/view/theme/shopyfashion/image/back.png"/>
			</div>
			<form action="<?php echo $url;?>" method='post'>
			<div class="search">
				<p class="search-btn"></p>
				<input id="searchinput" type="search" name='searchit' value="" placeholder="搜索你想找的商品" style="position: absolute; top: 0;left: 2.5rem;width: 21rem;height: 2.6rem;"/>
				
			</div>
			</form>
		</div>
		<div class="topmask">
		</div>
		<!--search history-->
		<div class="search-history">
			<h2><img src="catalog/view/theme/shopyfashion/image/search.png"/>搜索历史</h2>
			<?php if(isset($history)){?>
				<?php foreach($history as $v){?>
    			<p class="history" onclick="clickHistory('<?=$v['content']?>')"><?=$v['content']?></p>
    			<?php }?>
			<?php }else{?>
				<p class="history">无搜索历史,请登录</p>
			<?php }?>
		</div>
		<!--热门推荐-->
		<div class="hot-recommend"> 
			<h2><img src="catalog/view/theme/shopyfashion/image/fire.png"/>热门推荐</h2>
			<a href="###">Royal  Nectar皇家蜂毒眼霜</a>
			<a href="###">神奇番木瓜</a>
			<a href="###">Suprematismm</a>
			<a href="###">神奇番木瓜</a>
			<a href="###">Suprematismm</a>
			<a href="###">Royal  Nectar皇家蜂毒眼霜</a>
			<a href="###">Royal  Nectar皇家蜂毒眼霜</a>
			<a href="###">神奇番木瓜</a>
			<a href="###">神奇番木瓜</a>
		</div>
		<!--联想搜索-->
		<div class="think-search">
			<p><img src="catalog/view/theme/shopyfashion/image/flower.png"/><a href="" >BLOISLAND</a></p>
			<p><img src="catalog/view/theme/shopyfashion/image/flower.png"/><a href="" >BLOISLAND皇家蜂毒眼霜</a></p>
			<p><img src="catalog/view/theme/shopyfashion/image/flower.png"/><a href="" >BLOISLAND皇家蜂毒眼霜</a></p>
		</div>
		<div class="btm-five" style="height: 50px;width:100%;"></div>
		
		<script src="catalog/view/javascript/jquery/jquery-2.1.1.min.js" type="text/javascript" charset="utf-8	"></script>
		<script src="catalog/view/javascript/js/jq.snow.js" type="text/javascript" charset="utf-8	"></script>
		<script type="text/javascript">
			//页面白底
			$("html,body").css({"height":"100%","background":"#fff"})
			//搜索框搜索
			$(".search-btn").click(function(){
	    	window.location="<?php echo $url ?>"+'&search='+$('#searchinput').val();
		});			
			//联想搜索商品
			$(".search input").focus(function(){
				$(".search-history,.hot-recommend").hide();
				$(".think-search").show();
			}).blur(function(){
				//$(".think-search").hide();
				//$(".search-history,.hot-recommend").show();
			})
			
			//联想搜索
			$(".think-search a").click(function(){
				//alert($(this).text());
				//window.location="<?php echo $url ?>"+'&search='+$(this).text();
				$(".think-search a").attr("href","<?php echo $url ?>"+'&search='+$(this).text());
			});
				
			//$(document).on("click",".think-search a",function(){
			//	alert($(this).text());
			//	window.location="<?php echo $url ?>"+'&search='+$(this).text();
			//})	
	
			
			$('#searchinput').bind('input propertychange', function() {
                $.ajax({
					'url':"<?php echo $searchurl?>&filter_name="+$(this).val(),
					'type':'get',
					success:function(json){
						$(".think-search").html("");
						for(var i=0;i<json.length;i++){
							$(".think-search").append("<p class='sear' name='"+json[i]['name']+"'><img src='catalog/view/theme/shopyfashion/image/flower.png'/>"+json[i]['name']+"</p>");
						}
					}
                });
            });
            //热门推荐搜索
          $(".hot-recommend a").click(function(){
	    	window.location="<?php echo $url ?>"+'&search='+$(this).text();
		});
			//点击搜索历史
			function clickHistory(search){
				window.location="<?php echo $url ?>"+'&search='+search;
			}
			$(".back").click(function(){
				history.go(-1);
			});
			$(document).on("click",".sear",function(e){
				window.location="<?php echo $url ?>"+'&search='+$(this).text();
			});
			
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