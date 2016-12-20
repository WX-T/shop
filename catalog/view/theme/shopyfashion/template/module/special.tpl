<?php if($heading_title=='浏览该商品的用户也看过' || $heading_title=='购物车推荐商品'): ?>
<div class="commodity-right">
	<div class="reviewlist">
		<ul>
			<?php foreach ($products as $product): ?>
			<li class="similarity">
				<a href="<?php echo $product['href']; ?>"><img src="<?php echo $product['thumb']; ?>" /></a>
				<p class="browse-name"><a href="<?php echo $product['href']; ?>"><?php echo $product['name']; ?></a></p>
				<p class="browse-price"><?php echo $product['special'] ? $product['special'] : $product['price']; ?></p>
				<p class="like "></p>
				<p class="add-shoppingcar"></p>
			</li>
			<?php endforeach;?>
		</ul>
	</div>
	<div class="up-down">
		<p class="arr-up" id="arr-up2"></p>
		<p class="arr-down" id="arr-down2"></p>
	</div>
</div> 
<script type="text/javascript"><!--
$(function() {
	$(".reviewlist").jCarouselLite({
	btnNext: "#arr-up2",
	btnPrev: "#arr-down2",
	vertical : true,
	auto:2500,
	speed:1500,
	visible:6,
	scroll:1,
	onMouse:true,
	easing: "easeOutBack"
	});
});
--></script>  
<script type="text/javascript">
  (function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){
  (i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),
  m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)
  })(window,document,'script','https://www.google-analytics.com/analytics.js','ga');

  ga('create', 'UA-81008565-1', 'auto');
  ga('send', 'pageview');

</script>		
<?php else: ?>
<div class="title-red"><?php echo $heading_title; ?> >></div>
<div class="goods-recommend">
	<a href="javascript:void(0);" class="single_prve"><img src="catalog/view/theme/shopyfashion/image/jiantou-left.png" class="fl" /></a>
	<div class="carousel">
	<ul>
		<?php foreach ($products as $product) { ?>
        <li>
        	<a href="<?php echo $product['href']; ?>"><img width="130" height="130" src="<?php echo $product['thumb']; ?>" alt="<?php echo $product['name']; ?>" title="<?php echo $product['name']; ?>" class="img-responsive" /></a>
            <br />
            <p class="title"><a href="<?php echo $product['href']; ?>"><?php echo $product['name']; ?></a></p>
            <?php if (!$product['special']) { ?>
            <span class="deal-with"><?php echo $product['price']; ?></span>
            <?php } else { ?>
            <span class="delete"><?php echo $product['price']; ?></span>
            <br />
            <span class="deal-with"><?php echo $product['special']; ?></span>
            <?php } ?>
            <br />
            <p class="join">
            	<a href="javascript:void(0);" onclick="cart.add('<?php echo $product['product_id']; ?>');">
               		<img src="catalog/view/theme/shopyfashion/image/join-cart.png" />
                </a>
            </p>
        </li> 
        <?php } ?>    
     </ul>
     </div>
     <a href="javascript:void(0);" class="single_next"><img src="catalog/view/theme/shopyfashion/image/jiantou-right.png" class="fr" /></a>
</div>  
<?php endif; ?>