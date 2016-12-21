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
    <?php if ($error_warning) { ?>
    <div class="alert alert-danger"><i class="fa fa-exclamation-circle"></i> <?php echo $error_warning; ?>
      <button type="button" class="close" data-dismiss="alert">&times;</button>
    </div>
    <?php } ?>
    <?php if ($success) { ?>
    <div class="alert alert-success"><i class="fa fa-check-circle"></i> <?php echo $success; ?>
      <button type="button" class="close" data-dismiss="alert">&times;</button>
    </div>
    <?php } ?>
    <div class="panel panel-default">
      <div class="panel-heading">
        <h3 class="panel-title"><i class="fa fa-list"></i> <?php echo $text_list; ?></h3>
      </div>
      <div class="panel-body">
      	<div class="well">
            <div class="row">
              <form method="post" enctype="multipart/form-data" id="gettime">  
                <div class="col-sm-4">
                  <div class="form-group">
                    <label class="control-label" for="filter_task_id">任务ID</label>
                    <input name="filter_task_id" value="" placeholder="订单 ID" id="input_task_id" class="form-control" type="text">
                  </div>
                </div>
                <div class="col-sm-4">
                  <div class="form-group">
                    <label class="control-label" for="filter_buyser_name">买手名</label>
                    <input name="filter_buyser_name" value="" placeholder="总计" id="input_buyser_name" class="form-control" type="text">
                  </div>
                </div>
                <div class="col-sm-4">
                 <div class="form-group">
                    <label class="control-label" for="filter_task_status">任务状态</label>
                    <select name="filter_task_status" id="filter_task_status" class="form-control">
                    	<option value=""></option>
                    	<option value="1">待完成</option>
                    	<option value="1">已购买</option>
                    </select>
                  </div>
                  <div class="form-group">
                   <button type="button" id="button-filter" class="btn btn-primary pull-right" style="margin-top:20px;"><i class="fa fa-search"></i> 筛选</button>
                   </div>
               </div>
        	 </form>        
            </div>
        </div>
        <div class="table-responsive">
          <table class="table table-bordered table-hover">
            <thead>
              <tr>
                <td class="text-left">任务ID </td>
                <td class="text-left">买手名 </td>
                <td class="text-left">任务状态 </td>
                <td class="text-left">任务订单金额</td>
                <td class="text-left">任务实际金额</td>
                <td class="text-left">差价</td>
              </tr>
            </thead>
            <tbody>
            <?php foreach($task_info as $task){?>
              <tr>
                <td class="text-left"><?php echo $task['task_id'];?> </td>
                <td class="text-left"><?php echo $task['buyser_name'];?></td>
                <td class="text-left"><?php echo $task['status'];?></td>
                <td class="text-left"><?php echo $task['order_price'];?></td>
                <td class="text-left"><?php echo $task['buy_price'];?></td>
                <td class="text-left"><?php echo $task['difference'];?></td>
              </tr>
             <?php }?>
            </tbody>
          </table>
        </div>
      </div>
    </div>
  </div>
</div>
<script>
$('#button-filter').on('click', function() {
	url = 'index.php?route=extension/taskinfo&token=<?php echo $token; ?>';

	var filter_task_id = $('input[name=\'filter_task_id\']').val();
	if (filter_task_id) {
		url += '&filter_task_id=' + encodeURIComponent(filter_task_id);
	}

	
	var filter_buyser_name = $('input[name=\'filter_buyser_name\']').val();
	if (filter_buyser_name) {
		url += '&filter_buyser_name=' + encodeURIComponent(filter_buyser_name);
	}

	
	var filter_task_status = $('select[name=\'filter_task_status\']').val();
	if (filter_task_status != '') {
		url += '&filter_task_status=' + encodeURIComponent(filter_task_status);
	}

	location = url;
})
</script>
<?php echo $footer; ?>