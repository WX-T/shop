<?php echo $header; ?><?php echo $column_left; ?>
<div id="content">
  <div class="page-header">
    <div class="container-fluid">
      <div class="pull-right">
        <button type="submit" form="form-user" data-toggle="tooltip" title="<?php echo $button_save; ?>" class="btn btn-primary"><i class="fa fa-save"></i></button>
        <a href="<?php echo $cancel; ?>" data-toggle="tooltip" title="<?php echo $button_cancel; ?>" class="btn btn-default"><i class="fa fa-reply"></i></a></div>
      <h1><?php echo $heading_title; ?></h1>
      <ul class="breadcrumb">
        <?php foreach ($breadcrumbs as $breadcrumb) { ?>
        <li><a href="<?php echo $breadcrumb['href']; ?>"><?php echo $breadcrumb['text']; ?></a></li>
        <?php } ?>
      </ul>
    </div>
  </div>
  <div class="container-fluid">
    <?php if ($error_warning) { ?>
    <div class="alert alert-danger"><i class="fa fa-exclamation-circle"></i> <?php echo $error_warning; ?>
      <button type="button" class="close" data-dismiss="alert">&times;</button>
    </div>
    <?php } ?>
    <div class="panel panel-default">
      <div class="panel-heading">
        <h3 class="panel-title"><i class="fa fa-pencil"></i> <?php echo $text_form; ?></h3>
      </div>
      <div class="panel-body">
      <h1><?php echo $buyser_info['buyser_name'];?></h1>
        <form action="<?php echo $action; ?>" method="post" enctype="multipart/form-data" id="form-user" class="form-horizontal">
		
         <input type="hidden" name="buyser_id" value="<?php echo $buyser_id;?>">
         
           <div class="form-group">
            <label class="col-sm-2 control-label" for="input-product">分配订单</label>
            <div class="col-sm-10">
              <input type="text" name="order" value="" placeholder="订单" id="input-product" class="form-control" />
              <div id="featured-order" class="well well-sm" style="height: 150px; overflow: auto;">
              </div>
            </div>
           </div>
          
          <!-- <div class="form-group">
            <label class="col-sm-2 control-label" for="input-user-group">任务总金额:</label>
            <div class="col-sm-10">
              <input type="text" name="price" value="" placeholder="人民币" id="input_price" class="form-control" />
            </div>
          </div> -->
        </form>
      </div>
    </div>
  </div>
</div>
<script>
$('input[name=\'order\']').autocomplete({
	source: function(request, response) {
		$.ajax({
			url: 'index.php?route=extension/buyser/getOrderAll&token=<?php echo $token; ?>',
			dataType: 'json',
			success: function(json) {
				response($.map(json, function(item) {
					return {
						label: item['order_id'],
						value: item['order_id'],
						price: item['total']
					}
				}));
			}
		});
	},
	select: function(item) {
		$('input[name=\'order\']').val('');
		
		$('#featured-order' + item['value']).remove();
		
		$('#featured-order').append('<div id="featured-order' + item['value'] + '"><i class="fa fa-minus-circle"></i> ' + item['label'] + ' 总价:￥' + item['price'] + '<input price="' + item['price'] + '" type="hidden" name="order[]" value="' + item['value'] + '" /></div>');	
	}
});
	
$('#featured-order').delegate('.fa-minus-circle', 'click', function() {
	var obj = this;
	var clay = layer.confirm('确定取消该订单吗？', {icon: 3 , title: false} ,function(){
		layer.close(clay);
		$(obj).parent().remove();
	});
});

$("#input_price").focus(function(){
	var price = 0;
	$('input[name=\'order[]\']').each(function(i){
		price += Number($(this).attr('price'));
	})
	
	if(price >0){
		$("#input_price").val(price);
	}
});
</script>
<?php echo $footer; ?>