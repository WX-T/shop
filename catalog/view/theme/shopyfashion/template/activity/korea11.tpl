<!DOCTYPE html>
<html>
	<head>
		<meta charset="UTF-8">
		<meta name="viewport" content="width=device-width,initial-scale=1,minimum-scale=1,maximum-scale=1,user-scalable=no" />
		<title>活动页</title>
		<link rel="stylesheet" type="text/css" href="http://cdn.legoods.com//boc/11css/double.css"/>
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
			<div class="back" onclick="history.go(-1)">
				<img src="./catalog/view/theme/shopyfashion/image/back.png"/>
			</div>
			<h1><?php echo $title;?></h1>
			<p class="three-point"></p>
		</div>
		<div class="topmask">
		</div>
		<?php if($list){?>
			<?php foreach($list as $val){?>
    		<div class="gosodseries">
    			<div class="bannerImg">
    				<a target="_parent" href="<?php echo $val['target']?>"><img src="<?php echo $val['banner']?>"/></a>
    			</div>
    			<div class="goodsbrands">
    			<?php foreach ($val['products'] as $product){?>
    				<div class="goods">
    					<div class="img">
    						<a target="_parent" href="<?php echo $product['href']?>"><img src="<?php echo $product['thumb']?>"/></a>
    					</div>
    					<a target="_parent" href="<?php echo $product['href']?>"><p class="name"><?php echo $product['name']?></p></a>
    					<p class="price"><?php echo $product['price']?></p>
    				</div>
    				<?php }?>
    			</div>
    		</div>
    		<?php }?>
		<?php }?>
		<script src="../JavaScripts/jquery-1.11.3.min.js" type="text/javascript" charset="utf-8"></script>
		<script type="text/javascript">
			function newIamge(img){
				var newimg = new Image();
				newimg.src = img.src;
				var sum = newimg.width-newimg.height;
				return sum;

			}

			window.onload=function(){
				$(".goods .img img").each(function(){
				var img = $(this);
				if(newIamge(this)>=0){
					img.css({"width":"100%","height":"auto"});
					var height =$(window).width()/32*12 - img.height();
					img.css("margin-top",height/2);
				}else{
					img.css({"height":"100%","width":"auto","margin":"0 auto"});
				}
			})
			}
		</script>
	</body>
</html>
