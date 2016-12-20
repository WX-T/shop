<?php echo $header; ?>
<div class="nav">
<div class="map-nav">
		<div class="panel-align">c
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
    <div class="content_address"><?php echo $content_top; ?>
      <h2><?php echo $text_address_book; ?><a href="javascript:void(0);" id="add_address"><img src="catalog/view/theme/shopyfashion/image/new_address.png"></a></h2>
      <?php if ($addresses) { ?>
      <table class="table table-striped">
        <?php foreach ($addresses as $result) { ?>
        <tr>
          <td class="text-left"><?php echo $result['address']; ?></td>
          <td class="text-right"><a href="javascript:void(0);" class="address_edit" turl="<?php echo $result['update']; ?>"><?php echo $button_edit; ?></a> &nbsp;|&nbsp; 
          <a href="javascript:void(0);" onclick="address_delete('<?php echo $result['delete']; ?>')"><?php echo $button_delete; ?></a></td>
        </tr>
        <?php } ?>
      </table>
      <?php } else { ?>
      <p><?php echo $text_empty; ?></p>
      <?php } ?>
      <?php echo $content_bottom; ?></div>
    <?php echo $column_right; ?></div>
    </div>
</div>
<script type="text/javascript">
<?php if ($success) { ?>
layer.alert('<?php echo $success; ?>', {icon: 1 , title: false , shade: false ,skin:'layui-layer-rim'});
<?php } ?>
<?php if ($error_warning) { ?>
layer.alert('<?php echo $error_warning; ?>', {icon: 2 , title: false , shade: false ,skin:'layui-layer-rim'});
<?php } ?>

$(document).ready(function(){
	$(".address_edit").click(function(){
		var url = $(this).attr("turl");
		layer.open({
		    type: 2,
		    title: "编辑地址",
		    area: ['830px', '680px'],
		    shade: 0.4,
		    shadeClose: true,
		    content: url
		});
	});
	
	$("#add_address").click(function(){
		layer.open({
		    type: 2,
		    title: "新建地址",
		    area: ['830px', '680px'],
		    shade: 0.4,
		    shadeClose: true,
		    content: '<?php echo $add; ?>'
		});
	});
});

function closeLayer(){
	layer.closeAll();
}

function address_delete(url){
	layer.confirm('确定删除该地址吗？', {icon: 3 , title: false} ,function(){
		location=url;
	});
}
</script>
<?php echo $footer; ?>