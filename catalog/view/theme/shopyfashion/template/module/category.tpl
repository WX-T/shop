<!--分类-->
<div class="menu-list">
	<div class="swiper-container">
		<div class="swiper-wrapper">
		<?php foreach ($categories as $k=>$categorie){?>
			<div class="swiper-slide"><a href="<?php echo $categorie['href']?>">
				<?php echo $categorie['name']?></a>
			</div>
		<?php }?>
		</div>
	</div>
</div>