<?php echo $header; ?><?php echo $column_left; ?>
<div id="content">
<div class="page-header">
  <div class="container-fluid">
    <h1><?php echo $heading_title; ?></h1>
    <ul class="breadcrumb">
      <?php foreach ($breadcrumbs as $breadcrumb) { ?>
      <li><a href="<?php echo $breadcrumb['href']; ?>"><?php echo $breadcrumb['text']; ?></a></li>
      <?php } ?>
    </ul>
  </div>
</div>
<div class="container-fluid">
	<div style="display:none" id="tip_success" class="alert alert-success"><i class="fa fa-check-circle"></i> <b id="success_text">成功: 已经修改分类！</b>      <button data-dismiss="alert" class="close" type="button">×</button>
    </div>
    
    <div style="display:none" id="tip_error" class="alert alert-danger"><i class="fa fa-exclamation-circle"></i> <b id="error_text">警告: 存在错误，请检查！</b>      <button data-dismiss="alert" class="close" type="button">×</button>
    </div>
  <div class="panel panel-default">
    <div class="panel-heading">
      <h3 class="panel-title"><i class="fa fa-exclamation-triangle"></i> <?php echo $heading_title; ?></h3>
    </div>
    <div class="panel-body">
    	<div class="row">
          <div class="col-md-4">
          		<div class="input-group input-group-lg">
                  <span class="input-group-addon" id="">URL</span>
                  <input type="text" id='product_url' class="form-control" placeholder="输入商品URL" aria-describedby="sizing-addon1">
                </div>
          </div>
          <div class="col-md-4">
		  	 <button class="btn btn-primary dropdown-toggle" id="docapture" type="button">执行抓取</button>
		  </div>
          <div class="col-md-4">
          	 <a class="btn btn-primary" href="<?php echo $put_epass_api;?>" role="button">发送到通关服务平台</a>
          	 <a class="btn btn-primary" href="<?php echo $call_finish_aip_url;?>" role="button">取出翻译完成的商品</a>
          	 <a class="btn btn-primary" href="<?php echo $call_classif_aip_url;?>" role="button">导入翻译完成商品</a>
          </div>
        </div>
    </div>
  </div>
</div>
<?php echo $footer; ?>
<script>
	$("#docapture").click(function(){
		var product_url = $("#product_url").val();
		if(product_url.length <6){
			layer.msg('输入正确的URL');
			$("#error_text").text('输入正确的URL');
			$("#tip_error").show();
		}else{
			var lod = layer.load(1, {
				  shade: [0.1,'#fff'] //0.1透明度的白色背景
			});
			$.ajax({
	     	    type: 'POST',
	     	    url: "index.php?route=goods/capture/captureapi&token=<?php echo $token?>" ,
	     	    data:'url='+product_url,
	     	    dataType:'json',
	     	    success: function(data){
					if(data.code=='01'){
						layer.close(lod);
						layer.msg(data.msg,{time:3000,icon:5});
						$("#error_text").text(data.msg);
						$("#tip_error").show();
					}else if(data.code=='00'){
						layer.close(lod);
						layer.msg(data.msg,{time:3000,icon:1});
						$("#success_text").text(data.msg);
						$("#tip_success").show();
					}
		     	}
	     	});
		}
	});
</script>