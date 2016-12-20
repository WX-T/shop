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
    <div class="content_body1"><?php echo $content_top; ?>
      <?php if ($products) { ?>
      <table class="table table-striped">
        <thead>
          <tr>
            <td class="text-center" colspan="2" style="width: 30%;">产品详情<span class="line"></span></td>
            <td class="text-center"><?php echo $column_model; ?><span class="line"></span></td>
            <td class="text-center"><?php echo $column_stock; ?><span class="line"></span></td>
            <td class="text-center"><?php echo $column_price; ?><span class="line"></span></td>
            <td class="text-center"><?php echo $column_action; ?><span class="line"></span></td>
          </tr>
        </thead>
        <tbody>
          <?php foreach ($products as $product) { ?>
          <tr>
            <td class="text-center"><?php if ($product['thumb']) { ?>
              <a href="<?php echo $product['href']; ?>"><img src="<?php echo $product['thumb']; ?>" alt="<?php echo $product['name']; ?>" title="<?php echo $product['name']; ?>" class="border"/></a>
              <?php } ?></td>
            <td class="text-center"><a href="<?php echo $product['href']; ?>"><?php echo $product['name']; ?></a></td>
            <td class="text-center"><?php echo $product['model']; ?></td>
            <td class="text-right"><?php echo $product['stock']; ?></td>
            <td class="text-right"><?php if ($product['price']) { ?>
              <div class="price">
                <?php if (!$product['special']) { ?>
                <?php echo $product['price']; ?>
                <?php } else { ?>
                <b><?php echo $product['special']; ?></b><br/><s><?php echo $product['price']; ?></s>
                <?php } ?>
              </div>
              <?php } ?></td>
            <td class="text-center">
              <a href="javascript:void(0);" onclick="cart.add('<?php echo $product['product_id']; ?>');"><img src="catalog/view/theme/shopyfashion/image/add-to-cart.png"></a><br/>
              <a href="<?php echo $product['remove']; ?>" data-toggle="tooltip" title="<?php echo $button_remove; ?>" class="delete">删除</a></td>
          </tr>
          <?php } ?>
        </tbody>
      </table>
      <?php } else { ?>
      <p class="none"><?php echo $text_empty; ?></p>
      <?php } ?>
      <?php echo $content_bottom; ?></div>
    <?php echo $column_right; ?></div>
</div>
</div>
<?php echo $footer; ?>  