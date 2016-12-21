<?php echo $header; ?><?php echo $column_left; ?>
<div id="content">
  <div class="page-header">
    <div class="container-fluid">
      <div class="pull-right">
        <button type="submit" form="form-special" data-toggle="tooltip" title="<?php echo $button_save; ?>" class="btn btn-primary"><i class="fa fa-save"></i></button>
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
        <h3 class="panel-title"><i class="fa fa-pencil"></i> <?php echo $text_edit; ?></h3>
      </div>
      <div class="panel-body">
        <form action="<?php echo $action; ?>" method="post" enctype="multipart/form-data" id="form-special" class="form-horizontal">
          <div class="form-group">
            <label class="col-sm-2 control-label" for="input-name">主题名称</label>
            <div class="col-sm-10">
              <input type="text" name="name" value="<?php echo $name; ?>" placeholder="<?php echo $entry_name; ?>" id="input-name" class="form-control" />
              <?php if ($error_name) { ?>
              <div class="text-danger"><?php echo $error_name; ?></div>
              <?php } ?>
            </div>
          </div>
          
          <div class="tab-pane" id="tab-image">
              <div class="table-responsive">
                <table id="images" class="table table-striped table-bordered table-hover">
                  <thead>
                    <tr>
                      <td class="text-left">国家图片</td>
                      <td class="text-left">链接</td>
                      <td class="text-right">商品</td>
                      <td></td>
                    </tr>
                  </thead>
                  <tbody>
                   <?php if(empty($images)){?>
                        <tr id="image-row<?php echo $image_row; ?>">
                          <td class="text-left"><a href="" id="thumb-image<?php echo $image_row; ?>" data-toggle="image" class="img-thumbnail"><img src="<?php echo $image['thumb']; ?>" alt="" title="" data-placeholder="<?php echo $placeholder; ?>" /></a><input type="hidden" name="images[<?php echo $image_row; ?>][image]" value="<?php echo $image['image']; ?>" id="input-image<?php echo $image_row; ?>" /></td>
                          <td class="text-right"><input type="text" name="images[<?php echo $image_row; ?>][url]" value="<?php if(isset($image['url'])){echo $image['url'];} ?>" placeholder="推荐链接" class="form-control" /></td>
                          <td class="text-right">
                          	<div class="col-sm-7 text-left">
                              <input type="text" id="id_<?php echo $image_row;?>" name="" row="<?php echo $image_row;?>" placeholder="商品" id="" class="form-control product" />
                              <div id="featured-product" class="well well-sm" style="height: 100px; overflow: auto;">
                              </div>
                            </div>
                          </td>
                          <td class="text-left"><button type="button" onclick="$('#image-row<?php echo $image_row; ?>').remove();" data-toggle="tooltip" title="删除" class="btn btn-danger"><i class="fa fa-minus-circle"></i></button></td>
                        </tr>
                    <?php }else{?>
                    	<?php foreach($images as $key=>$image){?>
                    		<tr id="image-row<?php echo $key; ?>">
                              <td class="text-left"><a href="" id="thumb-image<?php echo $key; ?>" data-toggle="image" class="img-thumbnail"><img src="<?php echo $image['image']; ?>" alt="" title="" data-placeholder="<?php echo $placeholder; ?>" /></a><input type="hidden" name="images[<?php echo $key; ?>][image]" value="<?php echo $image['image_value']; ?>" id="input-image<?php echo $key; ?>" /></td>
                              <td class="text-right"><input type="text" name="images[<?php echo $key; ?>][url]" value="<?php if(isset($image['url'])){echo $image['url'];} ?>" placeholder="推荐链接" class="form-control" /></td>
                              <td class="text-right">
                              	<div class="col-sm-7 text-left">
                                  <input type="text" id="id_<?php echo $key;?>" name="" row="<?php echo $key;?>" placeholder="商品" id="" class="form-control product" />
                                  <div id="featured-product" class="well well-sm" style="height: 100px; overflow: auto;">
                                      	<?php foreach ($image['product'] as $id=>$p){?>
                                      	<div id="featured-product<?php echo $p['product_id']?>">
                                        <i class="fa fa-minus-circle"></i>
                                        <?php echo $p['name']?>
                                        <input name="images[<?php echo $key?>][product][]" value="<?php echo $p['product_id']?>" type="hidden">
                                        </div>
                                   <?php }?>
                                  </div>
                                </div>
                              </td>
                              <td class="text-left"><button type="button" onclick="$('#image-row<?php echo $key; ?>').remove();" data-toggle="tooltip" title="删除" class="btn btn-danger"><i class="fa fa-minus-circle"></i></button></td>
                            </tr>
                    	<?php }?>
                    <?php }?>
                  </tbody>
                  <tfoot>
                    <tr>
                      <td colspan="3"></td>
                      <td class="text-left"><button type="button" onclick="addImage();" data-toggle="tooltip" title="添加图片" class="btn btn-primary"><i class="fa fa-plus-circle"></i></button></td>
                    </tr>
                  </tfoot>
                </table>
              </div>
            </div>
          <div class="form-group">
            <label class="col-sm-2 control-label" for="input-status"><?php echo $entry_status; ?></label>
            <div class="col-sm-10">
              <select name="status" id="input-status" class="form-control">
                <?php if ($status) { ?>
                <option value="1" selected="selected"><?php echo $text_enabled; ?></option>
                <option value="0"><?php echo $text_disabled; ?></option>
                <?php } else { ?>
                <option value="1"><?php echo $text_enabled; ?></option>
                <option value="0" selected="selected"><?php echo $text_disabled; ?></option>
                <?php } ?>
              </select>
            </div>
          </div>
        </form>
      </div>
    </div>
  </div>
</div>

<script>
$(document).on('click','.fa-minus-circle',function(){
	var obj = this;
	var clay = layer.confirm('确定删除该商品吗？', {icon: 3 , title: false} ,function(){
		layer.close(clay);
		$(obj).parent().remove();
	});
})
<?php if(isset($count)){?>
var image_row = <?php echo $count?>;
<?php }else{?>
var image_row = 0;
<?php }?>
function addImage() {
	image_row++;
	html  = '<tr id="image-row' + image_row + '">';
	html += '  <td class="text-left"><a href="" id="thumb-image' + image_row + '"data-toggle="image" class="img-thumbnail"><img src="<?php echo $placeholder; ?>" alt="" title="" data-placeholder="<?php echo $placeholder; ?>" /><input type="hidden" name="images[' + image_row + '][image]" value="" id="input-image' + image_row + '" /></td>';
	html += '  <td class="text-right"><input type="text" name="images[' + image_row + '][url]" value="" placeholder="推荐链接" class="form-control" /></td>';
	html += '  <td class="text-right"><div class="col-sm-7 text-left"><input type="text" name="" row="'+image_row+'" placeholder="商品" id="id_'+image_row+'"  class="form-control product" /><div id="featured-product'+image_row+'" class="well well-sm" style="height: 100px; overflow: auto;"></div></div></td>';
	html += '  <td class="text-left"><button type="button" onclick="$(\'#image-row' + image_row  + '\').remove();" data-toggle="tooltip" title="删除" class="btn btn-danger"><i class="fa fa-minus-circle"></i></button></td>';
	html += '</tr>';
	$('#images tbody').append(html);
	$(".product").autocomplete({
		source: function(request, response) {
			$.ajax({
				url: 'index.php?route=catalog/product/autocomplete&token=<?php echo $token; ?>&filter_name=' +  encodeURIComponent(request),
				dataType: 'json',
				success: function(json) {
					response($.map(json, function(item) {
						return {
							label: item['name'],
							value: item['product_id']
						}
					}));
				}
			});
		},
		select: function(item) {
			var length=$(this).parent().find(".well input").length;
			var val =$(this).parent().find(".well input")
			var is_show = true;
			for(var i=0;i<length;i++){
				var val =$(this).parent().find(".well input").eq(i).val();
				console.log(val);
				 if(val==item['value']){
					is_show = false;
				} 
			}
			if(is_show){
				$(this).parent().find(".well").append('<div id="featured-product' + item['value'] + '"><i class="fa fa-minus-circle"></i> ' + item['label'] + '<input type="hidden" name="images['+image_row+'][product][]" value="' + item['value'] + '" /></div>');
			}
		}
	});
}



$(".product").autocomplete({
	source: function(request, response) {
		$.ajax({
			url: 'index.php?route=catalog/product/autocomplete&token=<?php echo $token; ?>&filter_name=' +  encodeURIComponent(request),
			dataType: 'json',
			success: function(json) {
				response($.map(json, function(item) {
					return {
						label: item['name'],
						value: item['product_id']
					}
				}));
			}
		});
	},
	select: function(item) {
		var row_id = $(this).attr('row');
		var length=$(this).parent().find(".well input").length;
		var val =$(this).parent().find(".well input")
		var is_show = true;
		for(var i=0;i<length;i++){
			var val =$(this).parent().find(".well input").eq(i).val();
			console.log(val);
			 if(val==item['value']){
				is_show = false;
			} 
		}
		if(is_show){
			$(this).parent().find(".well").append('<div id="featured-product' + item['value'] + '"><i class="fa fa-minus-circle"></i> ' + item['label'] + '<input type="hidden" name="images['+row_id+'][product][]" value="' + item['value'] + '" /></div>');	
			//$('input[name=\'product\']').val('');
		}
		//$('#featured-product' + item['value']).remove();
		//$('#featured-product').append('<div id="featured-product' + item['value'] + '"><i class="fa fa-minus-circle"></i> ' + item['label'] + '<input type="hidden" name="product[]" value="' + item['value'] + '" /></div>');	
	}
});
</script>