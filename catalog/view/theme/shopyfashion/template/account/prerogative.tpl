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
				<a href="<?php echo $home ?>"><img src="catalog/view/theme/shopyfashion/image/slyc/logo.png" class="logo" /></a>
				<ul class="top-rightinfo">
					<?php if ($logged) { ?>
					<li class="regist"><a href="<?php echo $order_url; ?>" class="red"><?php echo $text_logged;?></a></li>
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
<div class="member-bg widthcenter">
			<!--这是一张背景图-->
		</div>
		<!--全部特权-->
		<div class="all-prerogative widthcenter">
			<h2 class="all">全部特权</h2>
			<h2 class="level">分级特权</h2>
			<div class="left-list">
				<ul class="list">
					<li class="stair"><span></span>预约商品
						<ul>
							<li>二级菜单</li>
							<li>二级菜单</li>
							<li>二级菜单</li>
						</ul>
					</li>
					<li class="stair"><span></span>优惠折扣
						<ul>
							<li>二级菜单</li>
							<li>二级菜单</li>
							<li>二级菜单</li>
						</ul>
					</li>
					<li class="stair"><span></span>查看库存
						<ul>
							<li>二级菜单</li>
							<li>二级菜单</li>
							<li>二级菜单</li>
						</ul>
					</li>
					<li class="stair"><span></span>退换货
						<ul>
							<li>二级菜单</li>
							<li>二级菜单</li>
							<li>二级菜单</li>
						</ul>
					</li>
					<li class="stair"><span></span>专属客服
						<ul>
							<li>二级菜单</li>
							<li>二级菜单</li>
							<li>二级菜单</li>
						</ul>
					</li>
					<li class="stair"><span></span>积分兑换
						<ul>
							<li>二级菜单</li>
							<li>二级菜单</li>
							<li>二级菜单</li>
						</ul>
					</li>
				</ul>
			</div>
			<div class="right-info">
				<h4>预约商品</h4>
				<p>您在网站购物，按不同品类，将获得不同比例的京豆回馈</p>
				<p>1. 必须是购买实物产品（投资性金银、收藏品除外），不包括：机票、酒店、彩票、卡券等虚拟、服务类产品</p>
				<p>2. 订单金额是指用户实际以现金、银行卡、礼品卡、白条及账户余额方式支付的金额，购物回馈以每笔订单中的单个商品金额（非各个商品累计金额）为基准进行比例计算及发放</p>
				<p>3. 发放时间：订单完成后发放（注：试用期购物回馈仅是待返状态，在试用期内成为PLUS正式会员后即可获得试用期内的购物回馈）</p>
				<p>4. 购物回馈所得数折合人民币最高不超过2000元</p>
			</div>
		</div>
		<!--分级特权-->
		<div class="level-prerogative widthcenter">
			<h2 class="all">全部特权</h2>
			<h2 class="level">分级特权</h2>
			<div class="left-list">
				<ul class="list">
					<li class="stair"><span></span>成长等级
						<ul>
							<li>二级菜单</li>
							<li>二级菜单</li>
							<li>二级菜单</li>
						</ul>
					</li >
					<li class="stair"><span></span>散户
						<ul>
							<li>二级菜单</li>
							<li>二级菜单</li>
							<li>二级菜单</li>
						</ul>
					</li>
					<li class="stair"><span></span>大户
						<ul>
							<li>二级菜单</li>
							<li>二级菜单</li>
							<li>二级菜单</li>
						</ul>
					</li>
					<li class="stair"><span></span>黑户
						<ul>
							<li>二级菜单</li>
							<li>二级菜单</li>
							<li>二级菜单</li>
						</ul>
					</li>
				</ul>
			</div>
			<div class="right-info">
				<h4>成长等级</h4>
				<p>会员级别共分为3个等级，分别为：散户、大户、黑户。</p>
				<p>会员级别的升降均由系统自动处理，无需申请。</p>
				<p>会员级别由成长值决定，成长值越高会员等级越高，享受到的会员权益越大。</p>
				<p>会员级别共分为3个等级，分别为：散户、大户、黑户。</p>
				<p>会员级别的升降均由系统自动处理，无需申请。</p>
				<p>会员级别由成长值决定，成长值越高会员等级越高，享受到的会员权益越大。</p>
			</div>
			
		</div>
		<!--联系我们-->
		<div class="contact-us widthcenter">
			<?php echo $column_left; ?>
		</div>
		
		<?php echo $content_bottom; ?>
		<script type="text/javascript">
			$(".pvg-hover").mouseover(function(){
				$(this).parent().css("background-image","url(catalog/view/theme/shopyfashion/image/slyc/member-blackbg.png)");
				$(this).find("p").css("color","#fff");
			})
			$(".pvg").mouseleave(function(){
				$(this).css("background-image","url(catalog/view/theme/shopyfashion/image/slyc/member-bg.png)");
				$(this).find("p").css("color","#333");
			})
			//实现下拉菜单的列表
			$(".stair").click(function(){
				if($(this).find("ul").css("display")=="none"){
					$(".stair").find("ul").css("display","none");
					$(".stair").css("color","#575755");
					$(this).find("span").css({"background":"url(catalog/view/theme/shopyfashion/image/slyc/icon-member.png) no-repeat 0 -26px"});	
					$(this).css("color","#B7A66E");
					$(this).find("ul").css("display","block");
				}else{
					$(this).find("span").css({"background":"url(catalog/view/theme/shopyfashion/image/slyc/icon-member.png) no-repeat 0 0"});	
					$(this).css("color","#575755");
					$(this).find("ul").css("display","none");
				}
			})
			//切换选项卡
			$(".level").click(function(){
				$(".all-prerogative").css("display","none");
				$(".level-prerogative").css("display","block");
			})
			$(".all").click(function(){
				$(".level-prerogative").css("display","none");
				$(".all-prerogative").css("display","block");
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
		