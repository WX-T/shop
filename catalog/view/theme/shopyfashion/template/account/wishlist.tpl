<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
        <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0, user-scalable=0,minimal-ui" />
        <link href="catalog/view/theme/shopyfashion/stylesheet/babyproduct.css" rel="stylesheet">
    	<link href="catalog/view/theme/shopyfashion/stylesheet/babyheader.css" rel="stylesheet">
        <title>我的收藏</title>
    </head>
<body>
<script type="text/javascript">
  (function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){
  (i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),
  m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)
  })(window,document,'script','https://www.google-analytics.com/analytics.js','ga');

  ga('create', 'UA-81008565-1', 'auto');
  ga('send', 'pageview');

</script>		
	 <a class="to-top"><img src="catalog/view/theme/shopyfashion/image/slyc/top.png" /></a>
    <!--头部-->
    <div class="top">
        <!--搜索-->
        <div class="back">
            <img src="catalog/view/theme/shopyfashion/image/slyc/back.png" />
        </div>
        <h1>收藏</h1>
        <a href="index.php?route=checkout/cart"><p class="shopping-car"></p></a>
    </div>
    <!--头部蒙版-->
    <div class="occupied"></div>
    <title>我的收藏</title>
    <!--大的内容块-->
    <div class="content-slide first-content">
    	<?php foreach($products as $product){?>
            <!--big-->
            <div class="product-left-first big">
                <div>
                    <a href="<?php echo $product['href']?>"><img src="<?php echo $product['thumb']?>" /></a>
                </div>
                <p class="name"><a href="<?php echo $product['href']?>"><?php echo $product['name']?></a></p>
                <p class="price"><em><?php echo $product['special']?$product['special']:$product['price']?></em><del><?php echo $product['price']?></del><em class="VIP">(会员优惠)</em></p>
                <p class="guanshui">预计关税：<em class="money"><?php echo $product['tariff']?></em> <a href="index.php?route=account/wapwishlist&remove=<?php echo $product['product_id']?>"><em class="delete">删除</em></a></p>
                
            </div>
         <?php }?>
    </div>
    <script src="catalog/view/javascript/jquery/jquery-2.1.1.min.js" type="text/javascript" charset="utf-8"></script>
    <script src="catalog/view/javascript/js/fontSize.js" type="text/javascript" charset="utf-8"></script>
    <script type="text/javascript">
    $(".back").click(function(){
    	history.back(-1);
    });
        $(document).ready(function () {
            //回到顶部
            $(".to-top").hide();
            $(function () {
                $(window).scroll(function () {
                    if ($(window).scrollTop() > 200) {
                        $(".to-top").fadeIn(500);
                    } else {
                        $(".to-top").fadeOut(500);
                    }
                });
                $(".to-top").click(function () {
                    $('body,html').animate({
                        scrollTop: 0
                    }, 100);
                    return false;
                });
            });
        });
    </script>
</body>
</html>
