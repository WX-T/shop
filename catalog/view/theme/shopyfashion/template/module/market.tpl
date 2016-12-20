<div class="brand-choose">
	  <h1><span></span><font><?php echo $heading_title;?></font></h1>
	  <?php foreach($list as $resoult){?>
    	 <div class="swiper-container swiper-container-horizontal swiper-container-free-mode">
    	 <a style="position: absolute;top: 0.5rem;z-index: 20000;width: 9rem;display: block;background:#fff;" target="_parent" href="<?php echo $resoult['link']?>">
    		<img src="<?php echo $resoult['image']?>" class="flag-img"/>
    	 </a>
            <div class="swiper-wrapper" style="margin-left: 8.5rem;">
                <?php foreach ($resoult['products'] as $product){?>
                    <div class="swiper-slide">
        				<div class="img">
                    		<a target="_parent" href="<?php echo $product['href']?>"><img src="<?php echo $product['thumb']?>" alt="<?php echo $product['thumb']?>" /></a>
                    		 
                    	</div>
                    	<p class="goodsname"><a target="_parent" href="<?php echo $product['href']?>"><?php echo $product['name']?></a></p>
                    	<p class="univalence"><a target="_parent" href="<?php echo $product['href']?>"><?php if($product['special'] && $product['special']){echo $product['special']; }else{echo $product['price'];}?></a></p>
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
	<?php }?>
</div>