<span>配送方式</span>
<?php if ($shipping_methods) { ?>
<?php foreach ($shipping_methods as $shipping_method) { ?>
	<?php if (!$shipping_method['error']) { ?>
	<?php foreach ($shipping_method['quote'] as $quote) { ?>
		<?php if ($quote['code'] == $code || !$code) { ?>
    	<?php $code = $quote['code']; ?>
    	<font class="express" id="express_title"><?php echo $quote['title']; ?>(<?php echo $quote['text'];?>)</font>
    	<input type="radio" name="shipping_method" checked="checked" value="<?php echo $quote['code']; ?>" style="display: none;"/>
		<?php }?>
	<?php } ?>
	<?php } ?>
<?php } ?>
<div id="express-pop-box" style="display:none;">
    <div class="express-pop">
    <?php foreach ($shipping_methods as $shipping_method) { ?>
    	<?php if (!$shipping_method['error']) { ?>
    	<?php foreach ($shipping_method['quote'] as $q_key=>$quote) { ?>
    	<?php if ($quote['code'] == $code || !$code) { ?>
    	<p class="expressage expr_<?php echo $q_key;?>" tid="<?php echo $q_key;?>"><input type="radio" name="shipp_method" value="<?php echo $quote['code']; ?>" checked="checked"/><span><?php echo $quote['title']; ?>(<?php echo $quote['text'];?>)</span></p>
    	<?php }else{?>
    	<p class="expressage expr_<?php echo $q_key;?>" tid="<?php echo $q_key;?>"><input type="radio" name="shipp_method" value="<?php echo $quote['code']; ?>"/><span><?php echo $quote['title']; ?>(<?php echo $quote['text'];?>)</span></p>
    	<?php }?>
    	<?php }?>
    	<?php } ?>
    <?php } ?>
	</div>
</div>
<?php } ?>
<font class="right"></font>
