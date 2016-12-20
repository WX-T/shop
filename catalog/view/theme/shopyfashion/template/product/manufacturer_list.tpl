<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0, user-scalable=0,minimal-ui" />
    <link href="http://cdn.legoods.com/boc/css/index.css" rel="stylesheet" />
	<link href="http://cdn.legoods.com/boc/css/famous.css" rel="stylesheet">
	<link href="http://cdn.legoods.com/boc/css/babyheader.css" rel="stylesheet">
 	<script src="http://cdn.legoods.com/boc/javascript/jquery/jquery-2.1.1.min.js" type="text/javascript" charset="utf-8"></script>
  	<script src="http://cdn.legoods.com/boc/javascript/js/yxMobileSlider.js" type="text/javascript" charset="utf-8"></script>
  	<script src="http://cdn.legoods.com/boc/javascript/js/fontSize.js" type="text/javascript" charset="utf-8"></script>
    <title>知名品牌</title>
</head>
<body>
    <!--头部-->
    <div class="top">
        <!--搜索-->
        <div class="back">
            <img src="catalog/view/theme/shopyfashion/image/slyc/back.png" />
        </div>
        <h1>知名品牌</h1>
        <!--点击搜索按钮，跳转到搜索页面-->
        <a href="index.php?route=product/wapsearch/searchpage"><img src="catalog/view/theme/shopyfashion/image/slyc/search.png" class="add-good-address" /></a>
    </div>
    <!--头部蒙版-->
    <div class="occupied"></div>
    <div class="banner-space">
    	<?php echo $content_top;?>
    </div>
<!--根据首字母展示块-->
<div class="show-big">
    <!--字母展示-->
    <ul class="accord-A">
    	<?php foreach ($categories as $category) { ?>
        	<li><a href="index.php?route=product/wapmanufacturer#<?php echo $category['name']; ?>"><?php echo $category['name']; ?></a></li>
        <?php }?>
    </ul>
    <!--"A"-->
    <?php foreach($categories as $categorie){?>
        <div class="group">
            <p><span name="<?php echo $categorie['name']?>"  ><?php echo $categorie['name']?></span><font id="<?php echo $categorie['name']?>"></font></p>
            <ul>
            <?php if($categorie['manufacturer']){ ?>
          		<?php foreach($categorie as $cate){ ?>
            		<?php if(is_array($cate)){ ?>
              			<?php foreach($cate as $value){ ?>
                            <li><a href="<?php echo $value['href']?>"><img src="<?php echo $value['image']?>" /></a><br/><a href="<?php echo $value['href']?>"><?php echo $value['name']?></a></li>
            			<?php }?>
            		<?php }?>
            	<?php }?>
            <?php }?>
            </ul>
        </div>
    <?php }?>
</div>


<script type="text/javascript">
$(".back").click(function(){
	history.go(-1);
});
$(window).scroll(function () {
    var scroll = $(window).scrollTop();
    if (scroll < 200) {
        $('.accord-A').css("position", "absolute");
    }
    else {
        $('.accord-A').css("position", "fixed");
    }
})
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
<script type="text/javascript">
  (function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){
  (i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),
  m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)
  })(window,document,'script','https://www.google-analytics.com/analytics.js','ga');

  ga('create', 'UA-81008565-1', 'auto');
  ga('send', 'pageview');

</script>		
