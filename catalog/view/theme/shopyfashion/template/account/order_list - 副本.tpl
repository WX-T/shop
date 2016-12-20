<script type="text/javascript">
  (function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){
  (i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),
  m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)
  })(window,document,'script','https://www.google-analytics.com/analytics.js','ga');

  ga('create', 'UA-81008565-1', 'auto');
  ga('send', 'pageview');

</script>
<?php echo $header; ?>
<div class="nav">
<div class="map-nav">
		<div class="panel-align">
	    <?php foreach ($breadcrumbs as $key=>$breadcrumb) { ?>
			        <a href="<?php echo $breadcrumb['href']; ?>"><?php echo $breadcrumb['text']; ?></a>
			        <?php if(count($breadcrumbs) != $key+1){?>
			        <span>></span>
			        <?php }?>
	    <?php } ?>
	    </div>
	</div>
</div>
<div class="content">
<div class="panel-align show-body">
  <?php echo $column_left; ?>
  	<div class="right_top">
	      <div class="rtop_nav">
	      <div class="left">
	      <img src="catalog/view/theme/shopyfashion/image/head-portrait.png"/>
	      <span class="text_span">姓名：<span><?php echo $text_username;?></span></span>
	      </div>
	      <div class="right">
	      <a href="<?php echo $address;?>">我的收货地址</a>
	      <!-- <a href="">我的优惠券</a> -->
	      <a href="<?php echo $cart;?>">我的购物车</a>
	      </div>
	      </div>
	      <ul class="order_status">
	      	<li class="border"><a href="<?php echo $orderurl;?>">全部订单</a></li>
	      	<li class="border"><a href="<?php echo $orderurl;?>&status=0">待付款</a></li>
	      	<li class="border"><a href="<?php echo $orderurl;?>&status=17">待发货</a></li>
	      	<li class="border"><a href="<?php echo $orderurl;?>&status=3">待收货</a></li>
	      	<li class="border"><a href="<?php echo $orderurl;?>&status=11">退款</a></li>
	      	<li><a href="<?php echo $orderurl;?>&status=5">已完成</a></li>
	      </ul>
      </div>
    <div class="content_right">
      <?php if ($orders) { ?>
      <div class="table-responsive">
        <table class="table table-bordered table-hover">
          <thead>
            <tr>
              <td class="text-center"><?php echo $column_order_id; ?><span class="apart"></span></td>
              <td class="text-center"><?php echo $column_status; ?><span class="apart"></span></td>
              <td class="text-center"><?php echo $column_date_added; ?><span class="apart"></span></td>
              <td class="text-center"><?php echo $column_product; ?><span class="apart"></span></td>
              <td class="text-center"><?php echo $column_customer; ?><span class="apart"></span></td>
              <td class="text-center"><?php echo $column_total; ?><span class="apart"></span></td>
              <td class="text-center">操作</td>
            </tr>
          </thead>
          <tbody>
            <?php foreach ($orders as $order) { ?>
            <tr>
              <td class="text-center">#<?php echo $order['order_id']; ?><span class="apart"></span></td>
              <td class="text-center"><?php echo $order['status']; ?><span class="apart"></span></td>
              <td class="text-center"><?php echo $order['date_added']; ?><span class="apart"></span></td>
              <td class="text-center"><?php echo $order['products']; ?><span class="apart"></span></td>
              <td class="text-center"><?php echo $order['name']; ?><span class="apart"></span></td>
              <td class="text-center"><?php echo $order['total']; ?><span class="apart"></span></td>
              <td class="text-center"><a href="<?php echo $order['href']; ?>" data-toggle="tooltip" title="<?php echo $button_view; ?>" class="btn btn-info">查看详情</a></td>
            </tr>
            <?php } ?>
          </tbody>
        </table>
      </div>
      <div class="text-right"><?php echo $pagination; ?></div>
      <?php } else { ?>
      <p class="none"><?php echo $text_empty; ?></p>
      <?php } ?>
</div>
</div>
</div>
<?php echo $footer; ?>