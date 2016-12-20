<?php if($payment_code == 'wisdom'){?>
<div class="pay-btn" <?php if($type=='defepay'){?>style="display: none;"<?php }?>>
	<p class="promptlypay" id="wisdom-confirm">立即支付</p>
	<p class="hint">(请在48小时内支付完,到期未付款订单将会被<font>取消</font>。)</p>
	<div id="order-confirm">
	</div>
</div>
<?php echo $payment;?>
<?php }elseif($payment_code == 'alipay_direct'){?>
<div class="pay-btn" <?php if($type=='defepay'){?>style="display: none;"<?php }?>>
	<p class="promptlypay" id="alipay-confirm">立即支付</p>
	<p class="hint">(请在48小时内支付完,到期未付款订单将会被<font>取消</font>。)</p>
	<div id="order-confirm" style="display: none;">
	<?php echo $payment;?>
	</div>
</div>
<?php }elseif($payment_code == 'cod'){?>
<div class="pay-btn" <?php if($type=='defepay'){?>style="display: none;"<?php }?>>
	<p class="promptlypay" id="cod-confirm">立即支付</p>
	<p class="hint">(请在48小时内支付完,到期未付款订单将会被<font>取消</font>。)</p>
	<div id="order-confirm" style="display: none;">
	<?php echo $payment;?>
	</div>
</div>
<?php }?>