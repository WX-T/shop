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
  <div class="row">
    <div class="content_info"><?php echo $content_top; ?>
      <table class="table table-bordered table-hover table_order_detail">
        <thead>
          <tr>
            <td class="text-left" colspan="2"><label class="detail_line"><?php echo $text_order_detail; ?></label></td>
          </tr>
        </thead>
        <tbody>
          <tr>
            <td class="text-left" style="width: 50%;"><?php if ($invoice_no) { ?>
              <b><?php echo $text_invoice_no; ?></b> <?php echo $invoice_no; ?><br />
              <?php } ?>
              <b><?php echo $text_order_id; ?></b> #<?php echo $order_id; ?><br />
              <b><?php echo $text_date_added; ?></b> <?php echo $date_added; ?></td>
            <td class="text-left"><?php if ($payment_method) { ?>
              <b><?php echo $text_payment_method; ?></b> <?php echo $payment_method; ?><br />
              <?php } ?>
              <?php if ($shipping_method) { ?>
              <b><?php echo $text_shipping_method; ?></b> <?php echo $shipping_method; ?>
              <?php } ?></td>
          </tr>
        </tbody>
      </table>
      <hr />
      <table class="table table-bordered table-hover table_order_detail">
        <thead>
          <tr>
            <!-- <td class="text-left" style="width: 50%;"><?php echo $text_payment_address; ?></td> -->
            <?php if ($shipping_address) { ?>
            <td class="text-left"><label class="detail_line">配送地址</label></td>
            <?php } ?>
          </tr>
        </thead>
        <tbody>
          <tr>
            <!-- <td class="text-left"><?php echo $payment_address; ?></td> -->
            <?php if ($shipping_address) { ?>
            <td class="text-left shipping_address"><?php echo $shipping_address; ?></td>
            <?php } ?>
          </tr>
        </tbody>
      </table>
       <hr />
      <div class="table-responsive">
        <table class="table table-bordered table-hover table_order_detail">
          <thead>
            <tr>
              <td class="text-center">商品详情<span class="border_line"></span></td>
              <td class="text-center"><?php echo $column_quantity; ?><span class="border_line"></span></td>
              <td class="text-center"><?php echo $column_price; ?><span class="border_line"></span></td>
              <td class="text-center"><?php echo $column_total; ?><span class="border_line"></span></td>
              <?php if ($products) { ?>
              <td style="width: 20px;">操作<span class="border_line"></span></td>
              <?php } ?>
            </tr>
          </thead>
          <tbody>
            <?php foreach ($products as $product) { ?>
            <tr>
              <td class="text-left" style="width:400px;">
                <a href="<?php echo $product['href']; ?>" target="_blank"><img src="<?php echo $product['thumb']; ?>" class="img-thumbnail1"/></a>
                <div class="fr text-align-left wid280">
                <a href="<?php echo $product['href']; ?>" target="_blank"><?php echo $product['name']; ?></a>
                <?php foreach ($product['option'] as $option) { ?>
                <br />
                &nbsp;<small> - <?php echo $option['name']; ?>: <?php echo $option['value']; ?></small>
                <?php } ?>
                </div>
                </td>
              <td class="text-center"><?php echo $product['quantity']; ?></td>
              <td class="text-center"><?php echo $product['price']; ?><br/>（<?php echo $product['dprice']; ?>）</td>
              <td class="text-center total_price"><?php echo $product['total']; ?><br/>（<?php echo $product['dtotal']; ?>）</td>
              <td class="text-center" style="white-space: nowrap;"><?php if ($product['reorder']) { ?>
                <a href="<?php echo $product['reorder']; ?>" data-toggle="tooltip" title="<?php echo $button_reorder; ?>" class="btn btn-primary">返单</a>
                <?php } ?>
                <?php if ($product['return']) { ?>
                <a href="<?php echo $product['return']; ?>" data-toggle="tooltip" title="<?php echo $button_return; ?>" class="btn btn-primary">退换商品</a></td>
            	<?php }?>
            </tr>
            <?php } ?>
            <?php foreach ($vouchers as $voucher) { ?>
            <tr>
              <td class="text-left"><?php echo $voucher['description']; ?></td>
              <td class="text-left"></td>
              <td class="text-right">1</td>
              <td class="text-right"><?php echo $voucher['amount']; ?></td>
              <td class="text-right"><?php echo $voucher['amount']; ?></td>
              <?php if ($products) { ?>
              <td></td>
              <?php } ?>
            </tr>
            <?php } ?>
          </tbody>
          <tfoot>
          <tr>
          <td colspan="6"></td>
          </tr>
            <?php foreach ($totals as $total) { ?>
            <tr>
              <td colspan="2"></td>
              <td class="text-right"><b class="total_title"><?php if ($total['title'] == '总计') { ?>实付款：<?php }else{?><?php echo $total['title']; ?>：<?php }?></b></td>
              <td class="text-right" colspan="2"><span class="total_text"><?php echo $total['text']; ?>（<?php echo $total['dtext']; ?>）</span></td>
              <?php if ($products) { ?>
              <td></td>
              <?php } ?>
            </tr>
            <?php } ?>
          </tfoot>
        </table>
      </div>
      <?php if ($comment) { ?>
      <hr />
      <table class="table table-bordered table-hover table_order_detail">
        <thead>
          <tr>
            <td class="text-left"><label class="detail_line"><?php echo $text_comment; ?></label></td>
          </tr>
        </thead>
        <tbody>
          <tr>
            <td class="text-left"><p class="comment"><?php echo $comment; ?></p></td>
          </tr>
        </tbody>
      </table>
      <?php } ?>
      <?php if ($histories) { ?>
       <hr />
      <h3><label class="history_line"><?php echo $text_history; ?></label></h3>
      <table class="table table-bordered table-hover table_order_detail">
        <thead>
          <tr>
            <td class="text-center"><?php echo $column_date_added; ?><span class="border_line"></span></td>
            <td class="text-center"><?php echo $column_status; ?><span class="border_line"></span></td>
            <td class="text-center"><?php echo $column_comment; ?><span class="border_line"></span></td>
          </tr>
        </thead>
        <tbody>
          <?php foreach ($histories as $history) { ?>
          <tr>
            <td class="text-center"><?php echo $history['date_added']; ?></td>
            <td class="text-center"><?php echo $history['status']; ?></td>
            <td class="text-center"><?php echo $history['comment']; ?></td>
          </tr>
          <?php } ?>
        </tbody>
      </table>
      <?php } ?>
      <?php echo $content_bottom; ?></div>
    <?php echo $column_right; ?></div>
</div>
</div>
<script type="text/javascript">
  <?php if ($success) { ?>
  var msg = '<?php echo $success; ?>';
  layer.alert(msg, {icon: 1 , title: false , shade: false ,skin:'layui-layer-rim'});
  <?php } ?>
  <?php if ($error_warning) { ?>
  layer.alert('<?php echo $error_warning; ?>', {icon: 2 , title: false , shade: false ,skin:'layui-layer-rim'});
  <?php } ?>
</script>
<script type="text/javascript">
  (function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){
  (i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),
  m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)
  })(window,document,'script','https://www.google-analytics.com/analytics.js','ga');

  ga('create', 'UA-81008565-1', 'auto');
  ga('send', 'pageview');

</script>
<?php echo $footer; ?>