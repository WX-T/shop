<!DOCTYPE html>
<html>
	<head>
		<meta charset="UTF-8">
		<meta name="viewport" content="width=device-width,initial-scale=1,minimum-scale=1,maximum-scale=1,user-scalable=no" />
		<title>分类</title>
		<link href="http://cdn.legoods.com/boc/css/index.css" rel="stylesheet">
		<link href="http://cdn.legoods.com/boc/css/swiper.min.css" rel="stylesheet">
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
		<div class="list-top">
			<div class="header">
				<div class="back">
					<img class="lazy" src="catalog/view/theme/shopyfashion/image/back.png"/>
				</div>
				<div class="search">
					<p class="search-btn" id="searchbt"></p>
					<input type="text" id="searchtext" placeholder="搜索你想找的商品" value="<?php echo isset($thistitle)?$thistitle:''?>" style="position: absolute; top: 0;left: 2.5rem;width: 21rem;height: 2.6rem;"/>
				</div>
			</div>
			<!--排序-->
			<div class="filter">
				<a href="<?php echo $colligate['href'];?>" class="synthesize variable active">综合<span class="actived"></span></a>
				<p><a href="<?php if($rule == 'rating' && $order=='ASC'){echo $ssales['href'];}else{echo $bsales['href'];} ?>">销量&nbsp;<?php if($rule == 'rating' && $order=='ASC'){?> ↑<?php }elseif($rule!='rating'){?> ↑<?php }else{?> ↓<?php }?></a></p>
				<p><a href="<?php if($rule == 'p.price' && $order=='ASC'){echo $lowpric['href'];}else{echo $costliness['href'];} ?>">价格&nbsp;<?php if($rule == 'p.price' && $order=='ASC'){?> ↑<?php }elseif($rule!='p.price'){?> ↑<?php }else{?> ↓<?php }?></a></p>
				<a href="###" class="filtrate">筛选<span></span></a>
			</div>
		</div>
		<div class="listmask">
		</div>
		<!--搜索结果-->
		<div class="search-result" id="wrapper">
			<?php foreach($products as $product){?>
    	   		<div class="guess">
    	   			<a href="<?php echo $product['href']?>" class="a-img"><img class="lazy" data-original="<?php echo $product['thumb']?>" src="<?php echo $product['thumb']?>"/></a>
    	   			<p class="name"><a href="<?php echo $product['href']?>"><?php echo $product['name']?></a></p>
    	   			<a href="<?php echo $product['href']?>"><p class="price"><span><?php echo $product['min_price']?>-<?php echo $product['max_price']?></span><s> <?php echo $product['price']?></s></p></a>
    	   			<a href="<?php echo $product['href']?>"><p class="tariff">预计关税:<font><?php echo $product['tariff']?></font></p></a>
    	   		</div>
    	   	<?php }?>
	   	</div>
	   	<?php if($pageinfo['total']>$pageinfo['limit']){?>
	   	<p class="loding">正在加载...</p>
	   	<?php }else{?>
	   	<p class="loding">没有更多商品了...</p> 
	   	<?php }?>
	   	<div class="btm-five" style="height: 50px;width:100%;"></div>
	   	<script src="http://cdn.legoods.com/boc/javascript/jquery/jquery-2.1.1.min.js" type="text/javascript" charset="utf-8"></script>
		<script src="http://cdn.legoods.com/boc/javascript/js/jquery.lazyload.js" type="text/javascript" charset="utf-8"></script>
		<script src="http://cdn.legoods.com/boc/javascript/js/endless-scroll.js" type="text/javascript" charset="utf-8"></script>
	    <!--回到顶部-->
		<p class="backtop"></p>
		<script type="text/javascript">
		 	//回到顶部
    		$(window).scroll(function(){
    			var srcollH=$(window).scrollTop();
    			if(srcollH>300){
    				$(".backtop").show();
    			}else{
    				$(".backtop").hide();
    			} 
    		});
		    $(".backtop").click(function(){
		    	$('body,html').animate({scrollTop:0},300);  
	        	return false;  
		    });
		</script>
        <script type="text/javascript">
        $(".back").click(function(){
    		history.go(-1);
        });
        $(document).ready(function () {
            //回到顶部
            $(".to-top").hide();
            $(function () {
                $(window).scroll(function () {
                    //$(window).scrollTop()这个方法是当前滚动条滚动的距离
                    //$(window).height()获取当前窗体的高度
                    //$(document).height()获取当前文档的高度
                    var bot = 0.5; //bot是底部距离的高度
                    if ((bot + $(window).scrollTop()) >= ($(document).height() - $(window).height())) {
                    	getPage();
                    }
                });
            });
   	 	});
        var page = 2;
        //分页
        function getPage(){
        	$(".loding").text("正在加载更多商品...");
        	$.ajax({
    			url: 'index.php?route=product/wapmanufacturer/Page&manufacturer_id=<?php echo $manufacturer_id?>&page='+page,
    			type: 'post',
    			dataType: 'json',
    			success: function(json) {
        			if(!json.length){
    					$(".loding").text("没有更多商品...");
                	}
    				var special = '';
    				for(var i=0;i<json.length;i++){
    					if(json[i]['special']){
    						special = json[i]['special'];
                    	}else{
                    		special = json[i]['price'];
                        }

    					var html = "<div class='guess'><a href='"+json[i]['href']+"'><img class='lazy' src='"+json[i]['thumb']+"' /></a><p class='name'><a href='"+json[i]['href']+"'>"+json[i]['name']+"</a></p><a href='"+json[i]['href']+"'><p class='price'><span>"+json[i]['min_price']+"-"+json[i]['max_price']+"</span><s>"+json[i]['price']+"</s></p></a><a href='"+json[i]['href']+"'><p class='tariff'>预计关税:<font>"+json[i]['tariff']+"</font></p></a>";
    					//var html = "<div class='product-left-first big'><div><a href='"+json[i]['href']+"'><img src='"+json[i]['thumb']+"' /></a></div><p class='name'><a href='"+json[i]['href']+"'>"+json[i]['name']+"</a></p><p class='price'><em>"+special+"</em><del>"+json[i]['price']+"</del><em class='VIP'>(会员优惠)</em></p><p class='guanshui'>预计关税:<em class='money'>"+json[i]['tariff']+"</em></p></div>";
    					$(".search-result").append(html);
    				}
        		}
    		}); 
    		page++;
         }
         
          $("#searchbt").click(function(){
          	$val = $('#searchtext').val();
	    	window.location="index.php?route=product/wapsearch&search="+$val;
		});

		$('#searchtext').on('keydown', function(e) {
			if (e.keyCode == 13) {
				$('.search-btn').trigger('click');
			}
		});

		//商品尺寸设置
		function size(a){
    		var b=$(a);
			var fontsize =$(window).width()/32*13;
			if(getNaturalWidth(a)>0){
				//alert(22);
				b.css({"width":"100%","margin-top":(fontsize-imgH)/2});
				var imgH = b.height();
				b.css("margin-top",(fontsize-imgH)/2);
			}else{
				b.css({"height":"100%","margin":"0 auto"});
			}
		}
   
    function getNaturalWidth(img) {
		    var image = new Image()
		    image.src = img.src
		    var naturalWidth = image.width;
		    var neturalHeight = image.height;
		    return naturalWidth-neturalHeight;
	}
    window.onload = function(){
		$(".a-img img").each(function(){
			var fontsize =$(window).width()/32*13;
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