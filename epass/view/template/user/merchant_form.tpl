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
        <form action="<?php echo $action; ?>" method="post" enctype="multipart/form-data" id="form-user" class="form-horizontal">
          <div class="form-group">
            <label class="col-sm-2 control-label" for="input-user-group">商户名</label>
            <div class="col-sm-10">
              <input type="text" name="merchant_name" value="<?php echo $merchant_name; ?>" placeholder="商户名称" id="input- " class="form-control" />
               <?php if ($error_merchant_name) { ?>
              	<div class="text-danger"><?php echo $error_merchant_name; ?></div>
              <?php } ?>
            </div>
          </div>
          <?php if(empty($country)){?>
          	 <div class="form-group countrys" for="0">
                <label class="col-sm-2 control-label" for="input-user-group">国家</label>
                <div class="col-sm-10">
                    <div class="col-sm-3">
                      <select name="country[0][name]"  class="form-control col-sm-5 country_class" for="0">
                      	<?php foreach ($country_list as $cy){?>
                        	<option value="<?php echo $cy['country_id']?>"><?php echo $cy['country_name']?></option>
                        <?php }?>
                      </select>
                       <?php if ($error_country) { ?>
                      	<div class="text-danger"><?php echo $error_country; ?></div>
                       <?php } ?>
                    </div>
                    <div class="col-sm-2 well well-sm" style="height: 100px;overflow:auto">
                    </div>
                    <a class="btn btn-danger" onclick="deletecounty($(this))" title="" data-toggle="tooltip" ><i class="fa fa-minus-circle"></i></a>
               </div>
            </div>
          <?php }else{?>
          	<?php foreach ($country as $k=>$v){?>
          		<div class="form-group countrys" for="<?php echo $k?>">
                <label class="col-sm-2 control-label" for="input-user-group">国家</label>
                <div class="col-sm-10">
                    <div class="col-sm-3">
                      <select name="country[<?php echo $k;?>][name]"  class="form-control col-sm-5 country_class" for="<?php echo $k;?>">
                      	<?php foreach ($country_list as $cy){?>
                      		<?php if($v['name']==$cy['country_id']){?>
                        	<option selected="selected" value="<?php echo $cy['country_id']?>"><?php echo $cy['country_name']?></option>
                        	<?php }else{?>
                        		<option value="<?php echo $cy['country_id']?>"><?php echo $cy['country_name']?></option>
                        	<?php }?>
                        <?php }?>
                      </select>
                       <?php if ($error_country) { ?>
                      	<div class="text-danger"><?php echo $error_country; ?></div>
                       <?php } ?>
                    </div>
                    <div class="col-sm-2 well well-sm" style="height: 100px;overflow:auto">
                    	<?php foreach ($v['list'] as $li){?>
                    		<div class="checkbox">
                    			<label>
                    				<?php 
                    				    $is_true = false;
                    				    foreach ($v['lines'] as $line){
                    				        if($line == $li['line_id']){
                    				            $is_true = true;
                    				        }
                    				    }
                    				?>
                    				<?php if($is_true){?>
                    					<input type="checkbox" checked="checked" value="<?php echo $li['line_id']?>" name="country[<?php echo $k;?>][lines][]">
                    				<?php }else{?>
                    					<input type="checkbox" value="<?php echo $li['line_id']?>" name="country[<?php echo $k;?>][lines][]">
                    				<?php }?>
                    				
                    			<?php echo $li['title']?></label>
                    		</div>
                    	<?php }?>
                    </div>
                    <a class="btn btn-danger" onclick="deletecounty($(this))" title="" data-toggle="tooltip" ><i class="fa fa-minus-circle"></i></a>
               </div>
            </div>
          	<?php }?>
          <?php }?>
         
          <div class="form-group">
            <label class="col-sm-2 control-label" for="input-user-group">
				<button class="btn btn-primary" title=""  type="button" id="addCountry" ><i class="fa fa-plus-circle"></i></button>
			</label>
          </div>
          
          <div class="form-group">
            <label class="col-sm-2 control-label" for="input-user-group">电话</label>
            <div class="col-sm-10">
              <input type="text" name="tel" value="<?php echo $merchant_tel; ?>" placeholder="联系电话" id="input- " class="form-control" />
            </div>
          </div>
          
          
          <div class="form-group">
            <label class="col-sm-2 control-label" for="input-user-group">邮箱</label>
            <div class="col-sm-10">
              <input type="text" name="email" value="<?php echo $merchant_email; ?>" placeholder="邮箱" id="input- " class="form-control" />
            </div>
          </div>
          
          <div class="form-group">
            <label class="col-sm-2 control-label" for="input-user-group">app_id</label>
            <div class="col-sm-10">
              <input type="text" name="app_id" value="<?php echo $merchant_appid; ?>" placeholder="APP_ID" id="input-appid" class="form-control" />
            </div>
          </div>
          
          <div class="form-group">
            <label class="col-sm-2 control-label" for="input-user-group">APP_NAME</label>
            <div class="col-sm-10">
              <input type="text" name="app_name" value="<?php echo $merchant_appname; ?>" placeholder="APP_NAME" id="input-appid" class="form-control" />
            </div>
          </div>
          
          
          <div class="form-group">
            <label class="col-sm-2 control-label" for="input-user-group">模式</label>
            <div class="col-sm-10">
              <select class="form-control col-sm-5" name="model">
              	<?php foreach ($model_list as $mo){?>
              		<?php if($mo['model_id']==$merchant_model){?>
              			<option selected="selected" value="<?php echo $mo['model_id']?>"><?php echo $mo['model_name']?></option>
              		<?php }else{?>
              		<option value="<?php echo $mo['model_id']?>"><?php echo $mo['model_name']?></option>
              		<?php }?>
              	<?php }?>
              </select>
            </div>
          </div>
          
        </form>
      </div>
    </div>
  </div>
</div>
<?php echo $footer; ?>
<link type="text/css" href="view/stylesheet/select.css" rel="stylesheet" media="screen" />
<script type="text/javascript" src="view/javascript/select.js"></script>
<script>
//getLines($(".country_class"));
//$('#optiontype').multipleSelect('setSelects',platform_type.split(','));
$(document).on("change",".country_class",function(){
	getLines($(this));
});
function getLines(the){
	var country = the.val();
	if(country){
		$.ajax({
     	    type: 'GET',
     	    url: "index.php?route=user/merchant/getlines&token=<?php echo $token?>&country_id="+country,
     	    dataType:'json',
     	    success: function(data){
         	    console.log('加载线路------');
         	    var index = the.attr('for');
         	    console.log('index：'+index);
     	    	the.parent().next().html('');
     	    	for(var i=0;i<data.length;i++){
     	    		var cheboxStr = '<div class="checkbox"><label><input type="checkbox" value="'+data[i]['line_id']+'" name="country['+index+'][lines][]"> '+data[i]['title']+'</label></div>';
         	    	the.parent().next().append(cheboxStr);
     	    	}
     	    	
        	}
     	});
	}
}
//新增国家选项
$("#addCountry").click(function(){
	//获取偏移量
	var counts = parseInt($(".countrys").last().attr('for'))+1;
	//拼接字符串
	var html = '<div for="'+counts+'" class="form-group countrys"><label class="col-sm-2 control-label" for="input-user-group">国家</label><div class="col-sm-10"><div class="col-sm-3">';
	html += '<select id="count_'+counts+'" name="country['+counts+'][name]"  class="form-control col-sm-5 country_class" for="'+counts+'">';
	<?php foreach ($country_list as $cy){?>
	html += '<option value="<?php echo $cy['country_id']?>"><?php echo $cy['country_name']?></option>';
    <?php }?>
	html += '</select>';
	html += '</div>';
	html += '<div class="col-sm-2 well well-sm" style="height: 100px;overflow:auto"></div>';
	html += '<a class="btn btn-danger" onclick="deletecounty($(this))" title="" data-toggle="tooltip" ><i class="fa fa-minus-circle"></i></a>';
	html += '</div>';
	html += '</div>';
	$(this).parent().parent().before(html);
	console.log('新增国家选项----'+counts);
	getLines($("#count_"+counts));
	console.log($("#count_"+counts));
});

//删除国家选项
function deletecounty(doc){
	doc.parent().parent().remove();
}
</script>