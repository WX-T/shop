<?php echo $header; ?><?php echo $column_left; ?>
<div id="content">
  <div class="page-header">
    <div class="container-fluid">
      <div class="pull-right">
        <button type="submit" form="form-latest" data-toggle="tooltip" title="<?php echo $button_save; ?>" class="btn btn-primary"><i class="fa fa-save"></i></button>
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
        <form action="<?php echo $action; ?>" method="post" enctype="multipart/form-data" id="form-latest" class="form-horizontal">
          <div class="form-group">
            <label class="col-sm-2 control-label" for="input-name"><?php echo $entry_name; ?></label>
            <div class="col-sm-10">
              <input type="text" name="name" value="<?php echo $name; ?>" placeholder="<?php echo $entry_name; ?>" id="input-name" class="form-control" />
              <?php if ($error_name) { ?>
              <div class="text-danger"><?php echo $error_name; ?></div>
              <?php } ?>
            </div>
          </div>
          
          <!--每日上新添加商品-->
           <div class="form-group">
            <label class="col-sm-2 control-label" for="input-product">添加商品</label>
            <div class="col-sm-10">
              <input type="text" name="product" value="" placeholder="<?php echo $entry_product; ?>" id="input-product" class="form-control" />
              <div id="featured-product" class="well well-sm" style="height: 320px; overflow: auto;">
                <?php foreach ($products as $product) { ?>
                <div id="featured-product<?php echo $product['product_id']; ?>" style="width:200px;height:200px;float:left;text-align:center;border: 1px solid #cccccc;padding:5px 5px 10px 5px;margin:0px 5px 5px 0;"><i class="fa fa-minus-circle fa-2x" style="cursor: pointer;margin-bottom:6px;"></i><br/>
                  <a href="" id="thumb-image<?php echo $product['product_id']; ?>" data-toggle="image" class="img-thumbnail"><img src="<?php echo $product['image_thumb']; ?>" alt="" title="" data-placeholder="<?php echo $placeholder; ?>" /></a><input type="hidden" name="product[<?php echo $product['product_id']; ?>][image]" value="<?php echo $product['image']; ?>" id="input-image<?php echo $product['product_id']; ?>" />
                  <span style="margin:5px;display:inline-block;"><?php echo $product['name']; ?></span><br/>
                  <input type="hidden" name="product[<?php echo $product['product_id']; ?>][id]" value="<?php echo $product['product_id']; ?>" />
                </div>
                <?php } ?>
              </div>
            </div>
          </div>

          <!--显示数量-->
          <div class="form-group">
            <label class="col-sm-2 control-label" for="input-limit"><?php echo $entry_limit; ?></label>
            <div class="col-sm-10">
              <input type="text" name="limit" value="<?php echo $limit; ?>" placeholder="<?php echo $entry_limit; ?>" id="input-limit" class="form-control" />
            </div>
          </div>

          <!--宽度-->
          <div class="form-group">
            <label class="col-sm-2 control-label" for="input-width"><?php echo $entry_width; ?></label>
            <div class="col-sm-10">
              <input type="text" name="width" value="<?php echo $width; ?>" placeholder="<?php echo $entry_width; ?>" id="input-width" class="form-control" />
              <?php if ($error_width) { ?>
              <div class="text-danger"><?php echo $error_width; ?></div>
              <?php } ?>
            </div>
          </div>

          <!--高度-->
          <div class="form-group">
            <label class="col-sm-2 control-label" for="input-height"><?php echo $entry_height; ?></label>
            <div class="col-sm-10">
              <input type="text" name="height" value="<?php echo $height; ?>" placeholder="<?php echo $entry_height; ?>" id="input-height" class="form-control" />
              <?php if ($error_height) { ?>
              <div class="text-danger"><?php echo $error_height; ?></div>
              <?php } ?>
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
  <script type="text/javascript"><!--
var image_row = <?php echo $image_row; ?>;

function addImage() {
  html  = '<tr id="image-row' + image_row + '">';
  html += '  <td class="text-left"><a href="" id="thumb-image' + image_row + '"data-toggle="image" class="img-thumbnail"><img src="<?php echo $placeholder; ?>" alt="" title="" data-placeholder="<?php echo $placeholder; ?>" /><input type="hidden" name="images[' + image_row + '][image]" value="" id="input-image' + image_row + '" /></td>';
  html += '  <td class="text-right"><input type="text" name="images[' + image_row + '][url]" value="" placeholder="推荐链接" class="form-control" /></td>';
  html += '  <td class="text-right"><input type="text" name="images[' + image_row + '][sort_order]" value="" placeholder="排序" class="form-control" /></td>';
  html += '  <td class="text-left"><button type="button" onclick="$(\'#image-row' + image_row  + '\').remove();" data-toggle="tooltip" title="删除" class="btn btn-danger"><i class="fa fa-minus-circle"></i></button></td>';
  html += '</tr>';
  
  $('#images tbody').append(html);
  
  image_row++;
}
//--></script> 
  <script type="text/javascript"><!--
$('input[name=\'product\']').autocomplete({
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
    
    $('input[name=\'product\']').val('');
    
    $('#featured-product' + item['value']).remove();
    
    $('#featured-product').append('<div id="featured-product' + item['value'] + '" style="width:200px;height:200px;float:left;text-align:center;border: 1px solid #cccccc;padding:5px 5px 10px 5px;margin:0px 5px 5px 0;"><i class="fa fa-minus-circle fa-2x" style="cursor: pointer;margin-bottom:6px;"></i><br/>'+ '<a href="" id="thumb-image' + item['value'] + '"data-toggle="image" class="img-thumbnail"><img src="<?php echo $placeholder; ?>" alt="" title="" data-placeholder="<?php echo $placeholder; ?>" /></a><input type="hidden" name="product['+item['value']+'][image]" value="" id="input-image' + item['value'] + '" /><br/><span style="margin:5px;display:inline-block;">' + item['label'] + '</span><input type="hidden" name="product['+item['value']+'][id]" value="' + item['value'] + '" /><br/></div>');  
  }
});
  
$('#featured-product').delegate('.fa-minus-circle', 'click', function() {
  var obj = this;
  var clay = layer.confirm('确定删除该商品吗？', {icon: 3 , title: false} ,function(){
    layer.close(clay);
    $(obj).parent().remove();
  });
});
//--></script></div>
<?php echo $footer; ?>