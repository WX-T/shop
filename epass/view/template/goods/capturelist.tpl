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
    	  <ul class="nav nav-tabs" role="tablist">
                <li role="presentation" class="<?php echo $filter_type == '1' ? 'active': '' ?>" for="1"><a href="#home" aria-controls="home" role="tab" data-toggle="tab">父商品</a></li>
                <li role="presentation" class="<?php echo $filter_type == '2' ? 'active': '' ?>" for="2"><a href="#profile" aria-controls="profile" role="tab" data-toggle="tab">子商品</a></li>
          </ul>
          <input id="type" type="hidden" name='type' value="" />
          <div class="well">
            <div class="row">
                <form id="gettime" enctype="multipart/form-data" method="post">
                  <div class="col-sm-4">
                    <div class="form-group">
                      <label for="input-order-id" class="control-label">商品编号</label>
                      <input type="text" class="form-control" id="input-order-id" placeholder="商品编号" value="<?php echo $filter_asin?>" name="filter_asin">
                    </div>
                    <div class="form-group">
                        <label class="control-label" for="filter_order_declartype">状态</label>
                        <select name="filter_status" id="filter_status" class="form-control">
                        	<option value=""></option>
                        	<option value="0" <?php echo $filter_status=='0' ?'selected="selected"': ''?>>未发送</option>
                        	<option value="1" <?php echo $filter_status=='1' ?'selected="selected"': ''?>>已发送</option>
                        	<option value="2" <?php echo $filter_status=='2' ?'selected="selected"': ''?>>翻译完成</option>
                        	<option value="3" <?php echo $filter_status=='3' ?'selected="selected"': ''?>>导入中银成功</option>
                        	<option value="4" <?php echo $filter_status=='4' ?'selected="selected"': ''?>>导入中银失败</option>
                        </select>
                    </div>
                  </div>
                  <div class="col-sm-4">
                    <div class="form-group">
                      <label for="input-date-modified" class="control-label">开始时间:</label>
                      <div class="input-group date">
                        <input type="text" class="form-control" id="start_time" data-date-format="YYYY-MM-DD" placeholder="开始时间" value="<?php echo $filter_start_time?>" name="filter_start_time">
                        <span class="input-group-btn">
                        <button class="btn btn-default" type="button"><i class="fa fa-calendar"></i></button>
                        </span></div>
                  	</div>

                  </div>
                  <div class="col-sm-4">
                 	<div class="form-group">
                      <label for="input-date-modified" class="control-label">结束开始时间:</label>
                      <div class="input-group date">
                        <input type="text" class="form-control" id="end_time" data-date-format="YYYY-MM-DD" placeholder="结束" value="<?php echo $filter_end_time?>" name="filter_end_time">
                        <span class="input-group-btn">
                        <button class="btn btn-default" type="button"><i class="fa fa-calendar"></i></button>
                        </span></div>
                  	</div>
                  	<button class="btn btn-primary pull-right" id="button-filter" type="button"><i class="fa fa-search"></i> 筛选</button>
                  </div>
                </form>
            </div>
        </div>
        <div class="table-responsive">
            <table class="table table-bordered table-hover" style="cursor: pointer;">
              <thead>
              	<tr>
              		<?php if($filter_type =='2'){?>
              		<td>父商品编号</td>
              		<?php }?>
              		<td>商品编号</td>
              		<td>商品名</td>
              		<td>品牌名</td>
              		<td>价格(美元)</td>
              		<td>分类1</td>
              		<td>分类2</td>
              		<td>分类3</td>
              		<td>普货税号</td>
              		<td>税则号</td>
              		<td>创建时间</td>
              		<td>状态</td>
              	</tr>
              </thead>
              <tbody>
              <?php foreach ($goods as $good){?>
              	<tr>
              	
              		<?php if($filter_type =='2'){?>
              		<td><?php echo $good['pasin']?></td>
              		<?php }?>
              		<td><?php echo $good['asin']?></td>
              		<td>
              			<?php echo $good['name_en']?>
              			<hr>
              			<?php echo $good['name_cn']?>
              		</td>
              		<td>
              			<?php echo $good['brand_en']?>
              			<hr>
              			<?php echo $good['brand_cn']?>
              		</td>
              		<td>
              			<?php
              			   if($filter_type =='1'){
              			       echo $good['min_price'].'-'.$good['max_price'];
              			   }else if($filter_type == '2'){
              			       echo $good['list_price'];
              			   }
              			?>
              		</td>
              		<td><?php echo $good['category_en1']?>
              			<hr>
              			<?php echo $good['category_cn1']?>
              		</td>
              		<td><?php echo $good['category_en2']?>
              			<hr>
              			<?php echo $good['category_cn2']?>
              		</td>
              		<td><?php echo $good['category_en3']?>
              			<hr>
              			<?php echo $good['category_cn3']?>
              		</td>
              		<td>
              			<?php echo $good['generhscode']?>
              		</td>
              		<td>
              			<?php echo $good['hscode']?>
              		</td>
              		<td><?php echo $good['createtime']?></td>
              		<td>
              			<?php
                  			if($good['Isexp'] == '0' || empty($good['Isexp'])){
                  			    echo '未发送';
                  			}elseif($good['Isexp']=='1'){
                  			    echo '已发送';
                  			}elseif($good['Isexp']=='2'){
                  			    echo '已完成';
                  			}elseif($good['Isexp']=='3'){
                  			    echo '导入中银消费成功';
                  			}elseif($good['Isexp']=='4'){
                  			    echo '导入中银消费失败';
                  			}
                  		?>
              		</td>

              	</tr>
              <?php }?>
              </tbody>
            </table>
    </div>
    <div class="row">
          <div class="col-sm-6 text-left"><?php echo $pagination; ?></div>
          <div class="col-sm-6 text-right"><?php echo $results; ?></div>
    </div>
  </div>
</div>
<?php echo $footer; ?>
<script>
	$("#start_time").datetimepicker({
        format: 'yyyy-mm-dd hh:ii'
    });

	$("#end_time").datetimepicker({
        format: 'yyyy-mm-dd hh:ii'
    });
    /* $("#button-filter").click(function(){
		getList();
     });
 */
    $("#button-filter").on('click',function(){

    	var type = $(".nav-tabs .active").attr('for');
		$("#type").val(type);

    	url = 'index.php?route=goods/capturelist&token=<?php echo $token; ?>';

    	var filter_asin = $('input[name=\'filter_asin\']').val();

    	if (filter_asin) {
    		url += '&filter_asin=' + encodeURIComponent(filter_asin);
    	}

		var filter_status = $('select[name=\'filter_status\']').val();

    	if (filter_status != '') {
    		url += '&filter_status=' + encodeURIComponent(filter_status);
    	}
    	var filter_start_time = $('input[name=\'filter_start_time\']').val();

    	if (filter_start_time) {
    		url += '&filter_start_time=' + encodeURIComponent(filter_start_time);
    	}

    	var filter_end_time = $('input[name=\'filter_end_time\']').val();

    	if (filter_end_time) {
    		url += '&filter_end_time=' + encodeURIComponent(filter_end_time);
    	}

    	var filter_type = $('input[name=\'type\']').val();
    	if (filter_type) {
    		url += '&filter_type=' + encodeURIComponent(filter_type);
    	}
    	location = url;
    })

	//加载列表
	/* function getList(){
		var type = $(".nav-tabs .active").attr('for');
		$("#type").val(type);
	} */
</script>
