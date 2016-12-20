<!DOCTYPE html>
<html>
	<head>
		<meta charset="utf-8">
		<title>会员特权</title>
		<link href="catalog/view/theme/shopyfashion/stylesheet/member.css" rel="stylesheet">
		<script src="catalog/view/javascript/jquery/jquery-2.1.1.min.js" type="text/javascript"></script>
	</head>
	<body>
	<!--top-->
	<div class="top">
		<div class="top-bg">
			<div class="topcenter">
				<a href="<?php echo $home ?>"><img src="catalog/view/theme/shopyfashion/image/slyc/logo.png" class="logo" style="position: relative;z-index: 999;"/></a>
				<ul class="top-rightinfo">
					<?php if ($logged) { ?>
					<li class="regist"><a href="<?php echo $order_url;?>" class="red"><?php echo $text_logged;?></a></li>
					<li class="login"><a href="<?php echo $href_logout;?>" class="gray">退出</a></li>
					<?php } else { ?>
					<li class="regist"><a href="<?php echo $register; ?>">注册</a></li>
					<li class="login"><a href="<?php echo $login; ?>">登录</a></li>
					<?php } ?>
					<a href="<?php echo $wishlist; ?>"><li class="like">(<?php echo $text_wishlist; ?>)</li></a>
					<a href="<?php echo $shopping_cart; ?>"><li class="shopping">(<?php echo $cart; ?>)</li></a>
				</ul>
			</div>
		</div>
	</div>

<!--立享特权-->
<div class="member-now widthcenter">
	<!--这是一张背景图-->
</div>
		<!--会员特权-->
		
		<!--会员等级-->
		
		<!--会员推荐-->
		<?php echo $column_right; ?>
		
		<!--联系我们-->
		<div class="contact-us widthcenter">
			<?php echo $column_left; ?>
		</div>
		<?php echo $content_bottom ?>
		<script type="text/javascript">
			$(".pvg-hover").mouseover(function(){
				$(this).parent().css("background-image","url(catalog/view/theme/shopyfashion/image/slyc/member-blackbg.png)");
				$(this).find("p").css("color","#fff");
			})
			$(".pvg").mouseleave(function(){
				$(this).css("background-image","url(catalog/view/theme/shopyfashion/image/slyc/member-bg.png)");
				$(this).find("p").css("color","#333");
			})
		</script>
<script type="text/javascript">
  (function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){
  (i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),
  m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)
  })(window,document,'script','https://www.google-analytics.com/analytics.js','ga');

  ga('create', 'UA-81008565-1', 'auto');
  ga('send', 'pageview');

</script>		