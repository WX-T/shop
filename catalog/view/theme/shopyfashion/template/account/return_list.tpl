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
    <div class="content_body"><?php echo $content_top; ?>
      <h2>商品退换记录</h2>
      <?php if ($returns) { ?>
      <table class="table">
        <thead>
          <tr>
            <td class="text-center"><?php echo $column_return_id; ?><span class="line"></span></td>
            <td class="text-center"><?php echo $column_status; ?><span class="line"></span></td>
            <td class="text-center"><?php echo $column_date_added; ?><span class="line"></span></td>
            <td class="text-center"><?php echo $column_order_id; ?><span class="line"></span></td>
            <td class="text-center"><?php echo $column_customer; ?><span class="line"></span></td>
            <td class="text-center">操作<span class="line"></span></td>
          </tr>
        </thead>
        <tbody>
          <?php foreach ($returns as $return) { ?>
          <tr>
            <td class="text-center">#<?php echo $return['return_id']; ?></td>
            <td class="text-center"><?php echo $return['status']; ?></td>
            <td class="text-center"><?php echo $return['date_added']; ?></td>
            <td class="text-center"><?php echo $return['order_id']; ?></td>
            <td class="text-center"><?php echo $return['name']; ?></td>
            <td class="text-center"><a href="<?php echo $return['href']; ?>" data-toggle="tooltip" title="<?php echo $button_view; ?>" class="btn btn-info">查看</a></td>
          </tr>
          <?php } ?>
        </tbody>
      </table>
      <div class="text-right"><?php echo $pagination; ?></div>
      <?php } else { ?>
      <p class="no_content"><?php echo $text_empty; ?></p>
      <?php } ?>
      <?php echo $content_bottom; ?></div>
    <?php echo $column_right; ?></div>
</div>
</div>
<?php echo $footer; ?>