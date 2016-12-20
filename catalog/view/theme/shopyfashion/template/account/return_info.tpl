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
      <table class="list table table-bordered table-hover table_order_detail">
        <thead>
          <tr>
            <td class="text-left" colspan="2"><label class="detail_line"><?php echo $text_return_detail; ?></label></td>
          </tr>
        </thead>
        <tbody>
          <tr>
            <td class="text-left" style="width: 50%;"><b><?php echo $text_return_id; ?></b> #<?php echo $return_id; ?><br />
              <b><?php echo $text_date_added; ?></b> <?php echo $date_added; ?></td>
            <td class="text-left" style="width: 50%;"><b><?php echo $text_order_id; ?></b> #<?php echo $order_id; ?><br />
              <b><?php echo $text_date_ordered; ?></b> <?php echo $date_ordered; ?></td>
          </tr>
        </tbody>
      </table>
      <hr />
      <table class="list table table-bordered table-hover table_order_detail">
        <thead>
          <tr>
            <td class="text-center" style="width: 400px;"><?php echo $column_product; ?><span class="border_line"></span></td>
            <td class="text-center"><?php echo $column_model; ?><span class="border_line"></span></td>
            <td class="text-center"><?php echo $column_quantity; ?><span class="border_line"></span></td>
          </tr>
        </thead>
        <tbody>
          <tr>
            <td class="text-center">
            <a href="<?php echo $href; ?>" target="_blank"><img src="<?php echo $thumb; ?>" class="img-thumbnail1"/></a>
            <div class="fr text-align-left wid280">
            <a href="<?php echo $href; ?>" target="_blank"><?php echo $product; ?></a>
            </div>
            </td>
            <td class="text-center"><?php echo $model; ?></td>
            <td class="text-center"><?php echo $quantity; ?></td>
          </tr>
        </tbody>
      </table>
      <table class="list table table-bordered table-hover table_order_detail">
        <thead>
          <tr>
            <td class="text-center" style="width: 33.3%;"><?php echo $column_reason; ?><span class="border_line"></span></td>
            <td class="text-center" style="width: 33.3%;"><?php echo $column_opened; ?><span class="border_line"></span></td>
            <td class="text-center" style="width: 33.3%;"><?php echo $column_action; ?><span class="border_line"></span></td>
          </tr>
        </thead>
        <tbody>
          <tr>
            <td class="text-center"><?php echo $reason; ?></td>
            <td class="text-center"><?php echo $opened; ?></td>
            <td class="text-center"><?php echo $action; ?></td>
          </tr>
        </tbody>
      </table>
      <?php if ($comment) { ?>
      <hr />
      <table class="list table table-bordered table-hover table_order_detail">
        <thead>
          <tr>
            <td class="text-left"><label class="detail_line"><?php echo $text_comment; ?></label></td>
          </tr>
        </thead>
        <tbody>
          <tr>
            <td class="text-left"><?php echo $comment; ?></td>
          </tr>
        </tbody>
      </table>
      <?php } ?>
      <?php if ($histories) { ?>
      <hr />
      <h2><?php echo $text_history; ?></h2>
      <table class="list table table-bordered table-hover table_order_detail">
        <thead>
          <tr>
            <td class="text-center" style="width: 33.3%;"><?php echo $column_date_added; ?><span class="border_line"></span></td>
            <td class="text-center" style="width: 33.3%;"><?php echo $column_status; ?><span class="border_line"></span></td>
            <td class="text-center" style="width: 33.3%;"><?php echo $column_comment; ?><span class="border_line"></span></td>
          </tr>
        </thead>
        <tbody>
          <?php foreach ($histories as $history) { ?>
          <tr>
            <td class="text-center"><?php echo $history['date_added']; ?><span class="border_line"></span></td>
            <td class="text-center"><?php echo $history['status']; ?><span class="border_line"></span></td>
            <td class="text-center"><?php echo $history['comment']; ?><span class="border_line"></span></td>
          </tr>
          <?php } ?>
        </tbody>
      </table>
      <?php } ?>
      <div class="buttons clearfix">
        <div class="pull-right"><a href="<?php echo $continue; ?>" class="btn btn-primary">返回列表</a></div>
      </div>
      <?php echo $content_bottom; ?></div>
    <?php echo $column_right; ?></div>
</div>
</div>
<?php echo $footer; ?>