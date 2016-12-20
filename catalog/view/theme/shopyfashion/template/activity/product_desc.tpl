<!DOCTYPE html>
<html>
	<head>
		<meta charset="UTF-8">
		<meta name="viewport" content="width=device-width,initial-scale=1,minimum-scale=1,maximum-scale=1,user-scalable=no" />
		<title><?php echo $name?></title>
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
		
		<!--shoutu-->
		<div class="img">
			<img src="<?php echo $image?>"/>
			<p><i></i><span><?php echo $hot_name?> |</span><span><?php echo $add_date?></span></p>
		</div>
		<p class="goodsname"><?php echo $name?></p>
		<p class="goodsprice">￥<?php echo $price?> <span>包邮保税</span></p>
		<div class="textinfo">
			<?php echo $desc?>
		</div>
		<div class="bottom">
			<a href="<?php echo $href?>">直达链接 >>></a>
		</div>
		<script src="http://cdn.legoods.com/boc/javascript/jquery/jquery-2.1.1.min.js" type="text/javascript" charset="utf-8"></script>
		<script type="text/javascript">
    		$(".back").click(function(){
        		history.go(-1);
            });
			function getNaturalWidth(img) {
			    var image = new Image()
			    image.src = img.src
			    var naturalWidth = image.width;
			    var neturalHeight = image.height;
			    return naturalWidth>neturalHeight;
			}
			window.onload = function(){
				
				$(".img img").each(function(){
					console.log(getNaturalWidth(this));
					var fontSize = $(window).width()/32*26;
					
					if(getNaturalWidth(this)){
						$(this).css({"width":"100%","height":"auto"});
						var height = (fontSize - $(this).height())/2;
						$(this).css("margin-top",height);
					}else{
						$(this).css({"height":"100%","width":"auto","margin":"0 auto"});
					}
				})
				
			}
		</script>
	</body>
</html>
