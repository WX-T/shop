<span>支付方式</span>
<i>海贝余额支付</i>
<?php if ($payment_methods) { ?>
<?php foreach ($payment_methods as $payment_method) { ?>
	<?php if ($payment_method['code'] == $code || !$code) { ?>
 	<?php $code = $payment_method['code']; ?>
	<input type="radio" name="payment_method" value="<?php echo $payment_method['code']; ?>" checked="checked" style="display: none;"/>
	<?php } ?>
<?php } ?>
<?php } ?>
