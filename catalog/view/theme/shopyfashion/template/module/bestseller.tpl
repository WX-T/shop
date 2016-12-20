<!--猜你喜欢-->
<div class="guesslikes">
	<h3>猜你喜欢</h3>
	<div class="swiper-container swiper-container-horizontal swiper-container-free-mode" id="youlike">
        <div class="swiper-wrapper">
        <?php foreach($products as $product){ ?>
	   		<div class="swiper-slide"name="guess" >
	   			<div class="guess-img">
	   				<a href="<?php echo $product['href'] ?>"><img src="<?php echo $product['thumb'] ?>"/></a>
	   			</div>
	   			<p class="name"><a href="<?php echo $product['href'] ?>"><?php echo $product['name'] ?></a></p>
	   			<a href="<?php echo $product['href'] ?>"><p class="price"><?php if($product['special']){echo $product['special'];}else{echo $product['price'];}?></p></a>
	   			<!-- <p class="stages">日付分期:<font>￥10</font></p> -->
	   		</div>
	   	<?php }?>
	   	</div>	
	</div>
</div>