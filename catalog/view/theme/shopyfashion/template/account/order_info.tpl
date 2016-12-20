<?php echo $header; ?>
<link href="http://cdn.legoods.com/boc/css/shoppingcar.css" rel="stylesheet">
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
<!--主体内容-->
    <div class="orderdetails widthcenter">
      <h2>订单详情</h2>
      <div class="order-msg">
        <h3>订单信息</h3>
        <p>订单编号：<span><?php echo $order_id; ?></span></p>
        <p>订单时间：<span><?php echo $histories[0]['date_added']; ?></span></p>
        <p>订单状态：<span><?php echo $status ?></span></p>
        <p>订单金额：<font><?php echo end($totals)['text'] ?></font></p>
        <!--待付款的按钮-->
        <?php if($order_status_id=='21'){ ?>
          <div class="msg-bottom">
            <p>该订单会为您保留48小时（从下单之日算起），48小时之后如果还未付款，系统将自动取消该订单。</p>
            <p class="cancelorder" oid="<?php echo $order_id; ?>">取消订单</p>
            <p class="paynow" id="gopay" oid="<?php echo $order_id; ?>">立即支付</p>  
          </div>
        <?php }elseif($order_status_id=='3'){ ?>
          <!--待收货的按钮,已完成的就是修改  继续购买 为  申请售后-->
          <div class="order-remind">
            <p class="logistics">物流信息：<span><?php echo $shipping_agents;?></span><?php if($assbillno){?>[<font><?php echo $assbillno;?></font>]<?php }?></p>
            <p class="remind">重要提醒：十里洋场平台及销售商不会以订单异常、系统升级为由，要求您点击任何网址链接进行退款操作。</p>
            <p class="continue"><a href="<?php echo $continuebuy;?>">继续购买</a></p>
          </div>
        <?php } ?>
      </div>
      <!--商品信息-->
      <div class="goods-msg">
        <h3>商品信息</h3>
        <?php foreach($products as $product): ?>
          <div class="goods">
            <img src="<?php echo $product['thumb'] ?>"/>
            <p class="name"><a href="<?php echo $product['href'] ?>"><?php echo $product['name'] ?></a></p> 
            <p class="choose">
              <?php foreach($product['option'] as $option): ?>
                <?php echo $option['name'] ?>：<span><?php echo $option['value'] ?></span>、
              <?php endforeach; ?>
            </p>
            <p class="number">X<?=$product['quantity']?></p>
            <?php if($product['tariff_price']):?>
            <p class="inprice">关税：<span><?php echo $product['tariff_price']; ?></span></p>
            <?php endif;?>
            <p class="allprice">总价：<span><?php echo $product['total'] ?></span></p>
            <p class="like <?php echo !empty($is_addwish)?'red':'' ?>" onclick="wishlist.add('<?php echo $product['product_id'];?>' , this);" title="<?php echo $product['has_wish'] ? '点击取消收藏' : '点击收藏'?>"><?php echo $product['has_wish'] ? '已收藏' : '收藏' ?></p>
          </div>
        <?php endforeach; ?>
      <!--收货信息-->
      <div class="goods-receipt">
        <h3>收货信息</h3>
        <p class="username">姓名：<span><?php echo $name ?></span></p>
        <p class="postcode">邮编：<span><?php echo $shipping_postcode ?></span></p>
        <p class="phonenumber">手机：<?php echo $shipping_telephone ?></p>
        <p class="address">地址：<span><?php echo $address ?></span></p>
      </div>
      <!--配送信息-->
      <div class="delivery-msg">
        <h3>配送信息</h3>
        <p>模式：<span>直邮</span></p>
        <?php if(isset($totals['shipping'])){?>
        <p>费用：<font><?php echo $totals['shipping']['text'] ?></font></p>
        <?php }?>
      </div>
      <!--支付信息-->
      <div class="pay-msg">
        <h3>支付信息</h3>
        <p class="payway">支付方式：<span><?php echo $payment_method ?></span></p>
        <!--待付款和已完成  显示 下单时间 为支付时间-->
        <p class="paytime overbookingtime">下单时间：<span><?php echo $date_modified ?></span></p>
      </div>
      <!--备注信息-->
      <div class="remark-msg">
        <h3>备注信息</h3>
        <p class="remark-text">订单备注：<span><?php echo $comment?$comment:'无' ?></span></p>
      </div>
      <!--结算信息-->
      <div class=" settlement-msg">
        <h3>结算信息</h3>
        <div class="bottom-left">
          <p>已享受会员优惠</p>
           <p><span>￥<?php echo $discount?></span></p>
          <p><span>&nbsp;</span></p> 
        </div>
        <div class="bottom-right">
          <?php if(isset($totals['sub_total'])){?>
          <p><span>商品金额:</span><font><?php echo $totals['sub_total']['text'] ?></font></p>
          <?php }?>
          <?php if($has_tariff){?>
          <p><span>进口关税:</span><font><?php echo $tariff_price;?></font></p>
          <?php }?>
          <?php if(isset($totals['shipping'])){?>
          <p><span>配送费用:</span><font><?php echo $totals['shipping']['text'] ?></font></p>
          <?php }?>
          <?php if(isset($totals['total'])){?>
          <p class="allprice"><span>订单总金额:</span><font><?php echo $totals['total']['text'] ?></font></p>
          <?php }?>
        </div>
      </div>
    </div>
  </div>
  <div id="paynow_info">
  </div>
<?php echo $column_right; ?>
<?php echo $content_bottom; ?>
<script type="text/javascript"><!--
$("#back").click(function(){
	history.go(-1);
});
$(document).ready(function(){
	$("#gopay").click(function(){
		var order_id = $(this).attr('oid');
		$.ajax({
            url: 'index.php?route=checkout/confirm/defepayment&order_id='+order_id,
            dataType: 'html',
            success: function(html) {
            	$("#paynow_info").html(html);
                $('#wisdom-confirm').trigger("click");
                $('#alipay-confirm').trigger("click");
                $('#cod-confirm').trigger("click");
			},
            error: function(xhr, ajaxOptions, thrownError) {
                alert(thrownError + "\r\n" + xhr.statusText + "\r\n" + xhr.responseText);
            }
        }); 
	});
	
	$(".cancelorder").click(function(){
		var order_id = $(this).attr('oid');
		var lay = layer.confirm('确定要取消该订单吗？', {icon: 3 , title: false} ,function(){
			$.ajax({
	            url: 'index.php?route=account/order/cancel&order_id='+order_id,
	            dataType: 'json',
	            success: function(json) {
	            	layer.close(lay);
	            	if(json['error']){
	            		layer.alert(json['error'], {icon: 2 , title: false , shade: false});
	            	}else{
	            		window.location.reload(); 
	            	}
				},
	            error: function(xhr, ajaxOptions, thrownError) {
	                alert(thrownError + "\r\n" + xhr.statusText + "\r\n" + xhr.responseText);
	            }
	        }); 
		}); 
	});
});
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
