<!DOCTYPE html>
<html>
	<head>
		<meta charset="UTF-8">
		<meta name="viewport" content="width=device-width,initial-scale=1,minimum-scale=1,maximum-scale=1,user-scalable=no" />	
		<title>个人中心</title>
		<link rel="stylesheet" type="text/css" href="catalog/view/theme/shopyfashion/stylesheet/shoppingcar.css"/>
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
			<h1>个人中心</h1>
			<p class="three-point"></p>
		</div>
		<div class="topmask">
		</div>
		<!--个人信息-->
		<div class="personer">
			<div class="personer-img">
				<img src="catalog/view/theme/shopyfashion/image/header.png"/>
			</div>
			<h2><?php echo $fullname?></h2>
		</div>
		<!--操作选项-->
		<p class="myorder"><i></i>我的订单</p>
		<div class="order-detail">
			<ul>
				<li>
					<div class="order-icon payment">
						<a href="<?php echo $orderurl;?>&status=21"><img src="catalog/view/theme/shopyfashion/image/icons2.png"/></a>
					</div>
					<p class="order-name"><a href="<?php echo $orderurl;?>&status=21">待付款</a></p>
				</li>
				<li>
					<div class="order-icon drop-shipping">
						<a href="<?php echo $orderurl;?>&status=1"><img src="catalog/view/theme/shopyfashion/image/icons3.png"/></a>
					</div>
					<p class="order-name"><a href="<?php echo $orderurl;?>&status=1">待发货</a></p>
				</li>
				<li>
					<div class="order-icon willreceiving">
						<a href="<?php echo $orderurl;?>&status=3"><img src="catalog/view/theme/shopyfashion/image/icons4.png"/></a>
					</div>
					<p class="order-name"><a href="<?php echo $orderurl;?>&status=3">待收货</a></p>
				</li>
				<li>
					<div class="order-icon returns">
						<a href="<?php echo $orderurl;?>&status=7"><img src="catalog/view/theme/shopyfashion/image/icons1.png"/></a>
					</div>
					<p class="order-name"><a href="<?php echo $orderurl;?>&status=7">取消</a></p>
				</li>
			</ul>
		</div>
		<div class="person-operate">
			<p class="person-address"><i></i><a href="index.php?route=account/address">我的收货地址</a><span></span></p>
			<p class="person-realname"><i></i><a href="index.php?route=account/realname">实名信息备案</a><span></span></p>
			<p class="person-help"><i></i><a href="index.php?route=information/help">帮助与反馈</a><span></span></p>
			<p class="person-safe"><i></i>账户与安全<span></span></p>
			<p class="person-safe"><i></i><a href="index.php?route=account/logout">退出</a><span></span></p>
		</div>
		<div class="btm-five" style="height: 50px;width:100%;"></div>
    	<script src="catalog/view/javascript/jquery/jquery-2.1.1.min.js" type="text/javascript" charset="utf-8"></script>
		<script type="text/javascript">
    		$(".back").click(function(){
        		history.go(-1);
            });
			//设置背景颜色
			$("html,body").css({"height":"100%","overflow-y":"scroll","background":"url('catalog/view/theme/shopyfashion/image/personal-bg.jpg')"})
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