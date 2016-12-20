<!--品牌精选-->
<?php if($heading_title){?>
<div class="brand-choose">
	<?php if($title){?>
		<h1><span></span><?= $title?></h1>
	<?php }?>
    	<div class="top-img">
    		<a href="<?=$images[0]['url']?>"><img src="<?=$images[0]['image']?>"/></a>
    		<span class="triangle"></span>
    	</div>
	<div class="swiper-container swiper-container-horizontal swiper-container-free-mode">
        <div class="swiper-wrapper">
        	<?php foreach ($products as $product){?>
                <div class="swiper-slide"><a href="<?=$product['href']?>">
                	<div class="img">
                			<p class="meyer"><?php echo Param::$source_desc[$product['source']]?></p>
                		<img src="<?=$product['thumb']?>" alt="男士裤子" />
                	</div>
            	
            	<p class="goodsname"><?=$product['name']?></p>
            	<p class="univalence"><?php if($product['special'] && $product['special']){echo $product['special']; }else{echo $product['price'];}?></p>
            	<!--  <p class="stages">日付分期:<font>￥10</font></p> -->
            </a></div>
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
<?php }?>