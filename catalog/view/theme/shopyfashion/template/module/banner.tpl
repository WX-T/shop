<!--立即优惠模块-->
<?php if($banners['0']['name']=='立享优惠'): ?>
<div class="privilege">
  <div class="widthcenter">
    <a target="_parent"href="<?php echo $banners[0]['link'] ?>"><img src="<?php echo $banners[0]['image']; ?>" class="privilege-img" /></a>
    <div class="privilege-text">
      <a target="_parent"href="<?php echo $banners[0]['link'] ?>"><h2><?php echo $banners[0]['title'] ?></h2></a>
      <p class="privilege-wxplain"><?php echo $describe; ?></p>
    </div>
  </div>
</div>
<?php elseif($banners[0]['name']=='时尚新品'): ?> 
<div class="bg-gray">
    <div class="everyday-new widthcenter">
        <!--时尚新品-->
        <div class="fashion-new">
          <a target="_parent"href="<?php echo $banners[0]['link'] ?>"><img src="<?php echo $banners[0]['image']; ?>" class="fashion-img" /></a>
          <div class="fashion-text">
           <a target="_parent"href="<?php echo $banners[0]['link'] ?>"> <h2><?php echo $banners[0]['title'] ?></h2></a>
            <p class="fashion-explain"><?php echo $describe; ?></p>
            <a target="_parent"href="<?php echo $banners[0]['link'] ?>"><p class="knowmore">点击了解更多 <img src="catalog/view/theme/shopyfashion/image/slyc/sanjiao.png" /></p></a>
          </div>
        </div>
    </div>
</div>
<?php elseif($banners[0]['name']=='活动页面'): ?>
	<div class="newweek-title">
			<a target="_parent"href="<?php echo $banners[0]['link']?>"><img src="<?php echo $banners[0]['image']?>"/></a>
		</div>
		<div class="country">
			<div class="swiper-country country-swiper swiper-container-horizontal swiper-container-free-mode">
		        <div class="swiper-wrapper">
		        	<?php for ($i=1;$i<count($banners);$i++){?>
    		            <div class="swiper-slide">
    		            	<div class="img">
    		            		<a target="_parent"href="<?php echo $banners[$i]['link']?>"><img src="<?php echo $banners[$i]['image']?>" /></a>
    		            	</div>
    		            </div>
		            <?php }?>
		        </div>
			</div>
		</div>
<?php endif; ?>