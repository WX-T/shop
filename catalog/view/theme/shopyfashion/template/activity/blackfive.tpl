<!DOCTYPE html>
<html>
	<head>
		<meta charset="UTF-8">
		<meta name="viewport" content="width=device-width,initial-scale=1,minimum-scale=1,maximum-scale=1,user-scalable=no" />
		<title>商品列表</title>
		<link rel="stylesheet" type="text/css" href="http://cdn.legoods.com/boc/cssnewAdd.css"/>
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
		<div class="head">
			<div class="back">
				<img src="./catalog/view/theme/shopyfashion/image/back.png"/>
			</div>
			<div class="logo">
				<img src="http://cdn.legoods.com/boc/shopyfashion/image/logo.png"/>
			</div>
			<p class="three-point"></p>
		</div>
		<div class="topmask">
		</div>
		<div class="titleimg">
			<img src="<?php echo $banner?>"/>
		</div>
		<!--liebiao-->
		<div class="addlist">
			<?php foreach ($products as $product){?>
			<div class="goods">
				<div class="goodsimg">
					<a href="<?php echo $product['link']?>" class="a-img" target="_parent"><img src="<?php echo $product['image']?>"/></a>
				</div>
				<div class="right-text">
					<a target="_parent" href="<?php echo $product['link']?>"><p class="gname"><?php echo $product['name']?></p></a>
					<p class="gprice">￥<?php echo $product['price']?> <span>包邮包税</span></p>
					<p class="bottomtext"><span class="txt-left"><?php echo $product['hot_name']?></span><span class="txt-right"><?php echo $product['add_date']?></span></p>
				</div>
			</div>
			<?php }?>
		</div>
		<script src="http://cdn.legoods.com/boc/javascript/jquery/jquery-2.1.1.min.js" type="text/javascript" charset="utf-8"></script>
		<script type="text/javascript">
			function getNaturalWidth(img) {
			    var image = new Image()
			    image.src = img.src
			    var naturalWidth = image.width;
			    var neturalHeight = image.height;
			    return naturalWidth>neturalHeight;
			}
			window.onload = function(){
				$(".a-img img").each(function(){
					var fontSize = $(window).width()/32*6;
					if(getNaturalWidth(this)){
						$(this).css({"width":"100%","height":"auto"});
						var height = (fontSize - $(this).height())/2;
						$(this).css("margin-top",height);
					}else{
						$(this).css({"height":"100%","width":"auto","margin":"0 auto"});
					}
				})
				
			}

			$(".back").click(function(){
	    		history.go(-1);
	        });
		</script>
	</body>
</html>
