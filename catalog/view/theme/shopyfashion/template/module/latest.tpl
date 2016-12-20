<!--每日上新-->
<?php foreach ($products as $key=>$product){?>
    <div class="everyday-new">
		 <?php if(!$key>0){?>
			<h1><span></span><font>每日新品</font></h1>
		 <?php }?>
		<div class="goods">
			<div class="goods-img">
		   	 <?php if (isset($flag[$product['source']]['to'])){?>
		   	 		<div class="country-img" style="position: absolute;top: .5rem !important;background: url(<?php echo $flag[$product['source']]['to'][0]?>) no-repeat; background-size:100% 100%; right: 0;margin: 0 !important; width: 8.8rem;height:6.6rem;">
		   		</div>
		   		
		   		<div class="country-img" style="position: absolute;top: 7rem !important;background: url(<?php echo $flag[$product['source']]['to'][1]?>) no-repeat; background-size:100% 100%; right: 0;margin: 0 !important; width: 8.8rem;height:6.6rem;">
		   		</div>
		   	 <?php }else{?>
		   	 	<div class="country-img" style="position: absolute;top: .5rem !important;background: url(<?php echo $flag[$product['source']]?>) no-repeat; background-size:100% 100%; right: 0;margin: 0 !important; width: 8.8rem;height:6.6rem;">
		   		</div>
		   	 <?php }?>
				<a target="_parent" href="<?php echo $product['href']?>"><img class="lazy" src="<?php echo $product['thumb']?>" data-original="<?php echo $product['thumb']?>"/></a>
			</div>
			<h2 class="name"><a target="_parent" href="<?php echo $product['href']?>"><?php echo $product['name']?></a></h2>
			<p class="from"><a target="_parent" href="<?php echo $product['href']?>"><span><?php echo Param::$source_desc[$product['source']]?></span></a></p>
			<p class="price"><a target="_parent" href="<?php echo $product['href']?>"><span><?php echo $product['special']?$product['special']:$product['price'];?></span><s><?php echo $product['price']?></s></a></p>
			<div class="click">
				<p class="like" onclick="wishlist.add(<?php echo $product['product_id']?>,this)"><i></i><span>20</span><em>+</em></p>
				<p class="share"><i class="bds_more" data-cmd="more"></i><span>99</span><em>+</em></p>
			</div>
		</div>
	</div>
	
<?php }?>
	

<div class="btm-five" style="height: 50px;width:100%;"></div>

