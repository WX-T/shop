<?php echo $html_text; ?>
<p class="sure-btn" id="bank_choosed_pay">确认</p>
<!--选择银行卡的层-->
<div class="bank-list" id="bank-list" style="display: none;">
	<h1>选择支付银行</h1>
	<?php $i = 0;?>
	<?php foreach ($bankList as $bank){?>
	<?php $i++;?>
	<div class="bank" <?php if($i>8){?>style="display: none;"<?php }?>>
		<?php if($i==1){?>
		<p class="choose"><input type="radio" name="bank" checked="checked" value="<?php echo $bank['bank_id']?>" class="checkitem"/></p>
		<?php }else{?>
		<p class="unchoose"><input type="radio" name="bank" value="<?php echo $bank['bank_id']?>" class="checkitem"/></p>
		<?php }?>
		<p class="bank-logo"><img src="<?php echo $bank['thumb']?>"/></p>
	</div>
	<?php }?>
	<p class="more" id="more_bank"><span>点击展开更多<img src="catalog/view/theme/shopyfashion/image/slyc/pull-down.png"/></span></p>
	<p class="paynow" id="bank_choosed_pay">立即支付</p>
	<p class="change-payway" id="back_payway">更换支付方式</p>
</div>
<script type="text/javascript"><!--
$(document).ready(function(){
	$(".checkitem").click(function(){
		$(".checkitem").parent().attr('class' , 'unchoose');
		$(this).parent('p').attr('class' , 'choose');
		var bank_id = $("input[name='bank']:checked").val();
		$("#bankId").val(bank_id);
	});

	$(".bank-logo").click(function(){
		$(".checkitem").attr('checked' , false);
		$(".checkitem").parent().attr('class' , 'unchoose');
		$(this).parent().find('.checkitem').attr('checked',true);
		$(this).parent().children('p').eq(0).attr('class' , 'choose');
		var bank_id = $("input[name='bank']:checked").val();
		$("#bankId").val(bank_id);
	});

	$("#more_bank").click(function(){
		$("#bank-list").parent().height('auto');
		$(".bank").show();
		$(this).children().hide();
	});
	$("#bank_choosed_pay").click(function(){
		var bank_id = $("input[name='bank']:checked").val();
		$("#bankId").val(bank_id);
		$("#wisdomsubmit").submit();
	});
});
<!--</script>