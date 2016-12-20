<!DOCTYPE html>
<html>
	<head>
		<meta charset="UTF-8">
		<meta name="viewport" content="width=device-width,initial-scale=1,minimum-scale=1,maximum-scale=1,user-scalable=no" />	
		<title>查看物流</title>
		<link rel="stylesheet" type="text/css" href="http://cdn.legoods.com/boc/css/shoppingcar.css?v=20160923"/>
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
				<img class="lazy" src="catalog/view/theme/shopyfashion/image/back.png" data-original="catalog/view/theme/shopyfashion/image/back.png"/>
			</div>
			<h1>查看物流</h1>
		</div>
		<div class="topmask">
		</div>
		<!--物流信息-->
		<div class="log-info">
			<div class="g-img">
				<img class="lazy" src="<?php echo $order_image;?>"/>
			</div>
			<p class="l-s"><span>物流状态：</span><span class="l-state"><?php echo $order_statust?></span></p>
			<?php if($order_statust=='清关完成'){
			     echo '<p><span>承运来源：</span><span>圆通速递</span></p>';
			     echo '<p><span>运单编号：</span><span>5389217763</span></p>';
			     echo '<p><span>官方电话：</span><span>95544</span></p>';
			 }?>
		</div>
		<!--物流追踪-->
		<div class="log-trace">
			<h2>物流追踪</h2>
			<ul>
				<?php foreach($list as $key=>$v){?>
    				<li class="<?php if($key==count($list)-1){echo 'active';}?>">
    					<i class="step"></i>
    					<p class="where"><?php echo $v['Remark']?></p>
    					<p class="time"><?php echo $v['Createtime']?></p>
    				</li>
    			<?php }?>
				<!-- <li class="active">
					<i class="step"></i>
					<p class="where">[<span class="city">北京市</span>]<span class="work">北京市朝阳望京</span><span class="status">已收入</span></p>
					<p class="time">2015-11-13 05:29:23</p>
				</li>
				<li>
					<i class="step"></i>
					<p class="where">[<span class="city">北京市</span>]<span class="work">乐购轻松购</span><span class="status">已发货</span></p>
					<p class="time">2015-11-13 05:29:23</p>
				</li> -->
			</ul>
		</div>
		<!--猜你喜欢-->
		<?php echo $content_top;?>
		<script src="http://cdn.legoods.com/boc/javascript/jquery/jquery-2.1.1.min.js" type="text/javascript" charset="utf-8"></script>
		
		<script>
		$(".back").click(function(){
    		history.go(-1);
        });
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
