<?php if(isset($products)){?>
    <?php foreach($products as $product){?>
        <div class="commodity">
        	<a href="<?php echo $product['href'] ?>"><img class="lazy imgage" src="<?php echo $product['thumb']?>" data-original="<?php echo $product['thumb']?>" alt="图片"/></a>
        	<h2><a href="<?php echo $product['href']?>"><?php echo $product['name']?></a></h2>
        	<a href="<?php echo $product['href'] ?>"><p class="price"><span><?php echo $product['price']; ?></span><?php if($product['listprice']){?></span><s><?php echo $product['listprice'];?></s></p></a>
        	
        	<?php if(Param::$counttax[$product['source']]==1){?>
        		<a href="<?php echo $product['href'] ?>"><p class="tariff">包邮包税</p></a>
        	<?php }else{?>
        		<a href="<?php echo $product['href'] ?>"><p class="tariff">预计关税：<span><?php echo $product['tariff'];?></span></p></a>
        	<?php }?>
        	<p class="amount">×<?php echo $product['quantity']?></p>
        </div>
    <?php }?>
<?php }?>
<?php }?>
