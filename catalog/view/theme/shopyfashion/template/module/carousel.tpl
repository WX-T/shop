<?php echo $category;?>
<!--魅力大牌-->
<div class="charm">
	<h3>魅力大牌</h3>
	<p class="more"><a href="index.php?route=product/wapmanufacturer">更多</a></p>
	<?php if($banners){?>
        <?php foreach ($banners as $num => $banner){?>
        	<?php if($num < 6){?>	
            	<div class="charm-goods">
            		<a href="<?php echo $banner['link']?>"><img src="<?php echo $banner['image']?>" class="charm-img"/></a>
            		<p style="display: none;"><a href="<?php echo $banner['link']?>"><?php echo $banner['title']?></a></p>
            		<!-- <a href="<?php echo $banner['link']?>"><img src="catalog/view/theme/shopyfashion/image/slyc/mask.png" class="img-mask"/></a>-->
            	</div>
        	<?php }?>
        <?php }?>
     <?php }?>
</div>
<script>
//魅力大牌的字体位置
$(".charm-goods p").each(function(){
	if($(this).height()/parseInt(_html.style.fontSize)>1){
		$(this).css("margin-top",-1+"rem");	
	}
})
</script>