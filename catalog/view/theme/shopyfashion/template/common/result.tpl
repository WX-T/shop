<!DOCTYPE html>
<html>
	<head>
		<meta charset="UTF-8">
		<meta name="viewport" content="width=device-width,initial-scale=1,minimum-scale=1,maximum-scale=1,user-scalable=no" />	
		<title>支付失败</title>
		<link href="catalog/view/theme/shopyfashion/stylesheet/shoppingcar.css" rel="stylesheet">	</head>
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
		<!--top-->
		<div class="head">
			<div class="back">
				<img src="catalog/view/theme/shopyfashion/image/back.png"/>
			</div>
			<h1>支付失败</h1>
		</div>
		<div class="topmask">
		</div>
		<a href="<?php echo $orderlist;?>"><p class="paysus-text"><i></i><?php echo $error;?></p></a>
		<a href="<?php echo $continue;?>"><p class="continue">继续浏览</p></a>
		<script src="catalog/view/javascript/jquery/jquery-2.1.1.min.js" type="text/javascript" charset="utf-8"></script>
		<script>
			$(".back").click(function(){
				history.go(-1)
			});
		</script>
	</body>
</html>

