<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0, user-scalable=0,minimal-ui" />
  
    <link href="catalog/view/theme/shopyfashion/stylesheet/shoppingcar.css" rel="stylesheet" />
	<script src="catalog/view/javascript/jquery/jquery-2.1.1.min.js" type="text/javascript" charset="utf-8"></script>

    <title>我的收货地址</title>
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
    <!--头部-->
    <div class="head">
        <!--搜索-->
       <div class="back" id="back">
            <img src="catalog/view/theme/shopyfashion/image/back.png" />
        </div>
        <h1>我的收货地址</h1>
        <a href="index.php?route=account/address/add">
			<div class="add-address">		
				<span></span>
			</div>	
		</a>			
    </div>
    <div class="topmask">
		</div>
    <!--头部蒙版-->
    <div class="occupied"></div>
    <!--灰色背景-->
    <div class="grayback"></div>
    
    <!--地址编辑-->
    <div class="address-list">
    <?php if($addresses){?>
       <?php foreach ($addresses as $result) { ?>
    
    <div class="address-info">
        <p class="p-i"><span class="name"><?php echo $result['fullname']?></span><span class="phone"><?php echo $result['shipping_telephone']?></span></p>
        <p class="r-a"><?php echo $result['zone'].$result['city'].$result['area'].$result['add']?></p>
 		<a href="index.php?route=account/address/edit&address_id=<?php echo $result['address_id']?>" class="compile clearfix"><img src="image/catalog/slyc/edit.png" /></a>
        <p class="r-a"><span><?php echo $result['postcode']?></span></p>
    </div>
    
     <?php }?>
    <?php }?>
    </div>
	<div class="btm-five" style="height: 50px;width:100%;"></div>
    <script>
		$(".back").click(function(){
			history.go(-1);
	   });
    </script>
</body>
</html>