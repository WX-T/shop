<div class="lady">
	<div class="lady-title">
		<a target="_parent"href="<?php echo $title_url?>"><img src="<?php echo $title_img ?>"/></a>
	</div>
	<div class="swiper-container swiper-container-horizontal swiper-container-free-mode">
        <div class="swiper-wrapper">
        	<?php foreach($products as $product){?>
            <div class="swiper-slide">
		   	 <?php if($flag){?>
		   	 	<div class="country-img" style="z-index:100;position: absolute;top: .5rem !important;background: url(<?php echo $flag[$product['source']]?>) no-repeat; background-size:100% 100%; right: 0;margin: 0 !important; width: 3.2rem;height:2.2rem;">
		   		</div>
		   	 <?php }?>
            	<div class="img">
            		<a target="_parent"href="<?php echo $product['href']?>"><img src="<?php echo $product['thumb']?>" alt="<?php echo $product['name']?>" /></a>
            	</div>
            	<p class="goodsname"><a target="_parent"href="<?php echo $product['href']?>"><?php echo $product['name']?></a></p>
            	<p class="univalence"><a target="_parent"href="<?php echo $product['href']?>"><?php echo $product['price']?></a></p>
            </div>
            <?php }?>
            <div class="swiper-slide">
            	<div class="img">
            		<p class="more">查看更多</p>
            		<p class="right-arr"></p>
            	</div>
            </div>
        </div>
	</div>
</div>