<!DOCTYPE html>
<html>
	<head>
		<meta charset="UTF-8">
		<meta name="viewport" content="width=device-width,initial-scale=1,minimum-scale=1,maximum-scale=1,user-scalable=no" />	
		<title>支付成功</title>
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
			<h1>支付成功</h1>
		</div>
		<div class="topmask">
		</div>
		<!--address-->
		<div class="address">
			<h2><?php if(isset($orderInfo['shipping_fullname'])){ echo $orderInfo['shipping_fullname'];}?></h2>
			<p class="contact-way"><i></i>联系方式：<span><?php if(isset($orderInfo['shipping_telephone'])){ echo $orderInfo['shipping_telephone'];}?></span></p>
			<p class="address-text"><i></i><span class="text">地址：<span><?php if(isset($orderInfo['detail_address'])){ echo $orderInfo['detail_address'];}?></span></span></p>
		</div>
		<p class="paysus-text"><i></i>支付成功！</p>
		<a href="<?php echo $continue;?>"><p class="continue">继续浏览</p></a>
		<script src="catalog/view/javascript/jquery/jquery-2.1.1.min.js" type="text/javascript" charset="utf-8"></script>
		<script>
			$(".back").click(function(){
				history.go(-1)
			});
		</script>
	</body>
</html>
