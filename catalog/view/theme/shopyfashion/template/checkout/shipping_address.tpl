<?php if ($addresses) { ?>
<input type="radio" name="shipping_address" value="existing" id="address_modify" checked="checked" style="display: none;"/>
<input type="radio" name="shipping_address" value="new" id="address_add_new" style="display: none;"/>
    <?php foreach ($addresses as $key=>$address){?>
    	<?php if($key==$address_id){?>
    	<input type="radio" name="address_id" value="<?php echo $address['address_id']; ?>" style="display: none;" <?php if ($address['address_id'] == $address_id) { ?>checked="checked"<?php }?>/>
           	<h2><?php echo $address['fullname']; ?></h2>
			<p class="contact-way"><i></i>联系方式：<span><?php echo $address['shipping_telephone']; ?></span></p>
			<p class="address-text"><i></i><span class="text">地址：<span><?php echo $address['zone_name']?> <?php echo $address['city_name']?> <?php echo $address['area_name']?> <?php echo $address['address']?></span></span></p>
			<p class="turn-right"></p>
       	<?php }?>
    <?php }?>
<?php }else{?>
		<span class="font-text">您还没有填写地址，请先去填写地址</span>
		<p class="turn-right"></p>
<?php }?>

