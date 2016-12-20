<?php echo $header; ?>
<link href="catalog/view/theme/shopyfashion/stylesheet/shoppingcar.css" rel="stylesheet">
<?php echo $content_top; ?>
<div class="breadcrumb">
<h5 class="site">
  <?php foreach ($breadcrumbs as $key=>$breadcrumb) { ?>
    <a href="<?php echo $breadcrumb['href']; ?>"><?php echo $breadcrumb['text']; ?></a>
    <?php if(count($breadcrumbs) != $key+1){?>
    <span>></span>
    <?php }?>
  <?php } ?>
</h5>
</div>
<!--购物车内容-->
<div class="showshoppingcar widthcenter">
	<!--购物第三步图片-->
	<img src="catalog/view/theme/shopyfashion/image/slyc/step3.png"/>
	<div class="commit-success">
		<img src="catalog/view/theme/shopyfashion/image/slyc/success-car.png"/>
		<div class="orderinfo">
			<h2>订单已经提交成功！</h2>
			<p>订单编号：<?php echo $orderInfo['order_id'];?></p>
			<p>订单金额：<font>￥<?php echo $orderInfo['total'];?></font></p>
		</div>
		<p class="payment-way" id="payment-way">支付方式：<span><?php echo $orderInfo['payment_method'];?></span>  <a href="javascript:void(0);" id="changePaymethod">更改支付方式>></a></p>
		<div id="choose_payment_method" style="display:none;">
			<p class="payment-way">请选择支付方式：</p>
			<!--支付方式-->
			<div class="reset-payway">
				<div class="payment_method" id="payment-mode">
				<?php if ($payment_methods) { ?>
				<?php foreach ($payment_methods as $payment_method) { ?>
					<?php if ($payment_method['code'] == $payment_code || !$payment_code) { ?>
				 	<?php $code = $payment_method['code']; ?>
					<p class="checked pay"><input type="radio" name="payment_method" value="<?php echo $payment_method['code']; ?>" checked="checked"/><span><?php echo $payment_method['title']; ?></span></p>
					<?php } else { ?>
					<p class="uncheck pay"><input type="radio" name="payment_method" value="<?php echo $payment_method['code']; ?>"/><span><?php echo $payment_method['title']; ?></span></p>
					<?php } ?>
				<?php } ?>
				<?php } ?>
	        	</div>
			</div>
		</div>
		<div id="payment_box">
    		
		</div>
		<p class="explain-text first">确认付款请去订单详情页面去提交付款信息</p>
		<p class="explain-text">支付成功后，可以在 会员中心的我的订单 处查看订单和追踪订单状态</p>
	</div>	
</div>
<?php echo $column_right; ?>
<?php echo $content_bottom; ?>
<script type="text/javascript"><!--
$(document).ready(function(){
	$("#changePaymethod").click(function(){
		$("#payment-way").hide();
		$("#choose_payment_method").show();
	});
	var payment_code = $('input[name=\'payment_method\']:checked').val();
	paymentMethodSave(payment_code);
});

$(document).on('change', 'input[name=\'payment_method\']', function() {
	$(".pay").removeClass('checked');
	$(".pay").addClass('uncheck');
	$(this).parent().removeClass('uncheck');
	$(this).parent().removeClass('checked');
	$(this).parent().addClass('checked');
	var payment_code = $(this).val();
	paymentMethodSave(payment_code);
});

function paymentMethodSave(payment_code){
	$.ajax({
        url: 'index.php?route=checkout/confirm/payment',
        dataType: 'text',
        data : {order_id : "<?php echo $orderInfo['order_id'];?>" , code : payment_code},
        success: function(html) {
            $('#payment_box').html(html);
		},
        error: function(xhr, ajaxOptions, thrownError) {
            alert(thrownError + "\r\n" + xhr.statusText + "\r\n" + xhr.responseText);
        }
    });
}
//--></script> 
<script type="text/javascript"><!--
$(document).on('click' , '#wisdom-confirm' ,function(){
	layer.open({
	    type: 1,
	    shade: 0.3,
	    area: ['auto', 'auto'], //宽高
	    title: false, //不显示标题
	    content: $('#bank-list'),
	});
});

$(document).on('click' , "#back_payway" , function(){
	layer.closeAll();
})
<!--</script>
<script type="text/javascript">
  (function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){
  (i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),
  m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)
  })(window,document,'script','https://www.google-analytics.com/analytics.js','ga');

  ga('create', 'UA-81008565-1', 'auto');
  ga('send', 'pageview');

</script>		
<?php echo $footer; ?>