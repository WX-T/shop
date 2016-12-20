<!--图片轮播-->
<div class="banner slider">
	<ul>
		<?php foreach ($banners as $banner) { ?>
		<li><a target="_parent" href="<?php echo $banner['link'] ?>"><img src="<?php echo $banner['image'] ?>"/></a></li>
		<?php }?>
	</ul>
</div>
