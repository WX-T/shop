<?php echo $header; ?><?php echo $column_left; ?>
<div id="content">
  <div class="page-header">
    <div class="container-fluid">
      <div class="pull-right">
        <a href="<?php echo $add; ?>" data-toggle="tooltip" title="添加" class="btn btn-primary"><i class="fa fa-plus"></i></a>
      </div>
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
        <div class="table-responsive">
          <table class="table table-bordered table-hover">
            <thead>
              <tr>
                <td class="text-left">买手ID </td>
                <td class="text-left">买手名 </td>
                <td class="text-left">待完成任务数 </td>
                <td class="text-left">余额 </td>
                <td class="text-left">任务总数 </td>
                <td class="text-left">创建时间 </td>
                <td class="text-left">操作 </td>
              </tr>
            </thead>
            <tbody>
              <?php foreach ($buyser_list as $buyser) { ?>
              <tr>
                <td class="text-left"><?php echo $buyser['buyser_id']; ?></td>
                <td class="text-left"><?php echo $buyser['buyser_name']; ?></td>
                <td class="text-left"><?php echo $buyser['backlog_num'];?></td>
                <td class="text-left">￥<?php echo $buyser['price'] >0 ? $buyser['price'] : 0;?></td>
                <td class="text-left"><?php echo $buyser['task_num'];?></td>
                <td class="text-left"><?php echo $buyser['add_time'];?></td>
                <td class="text-left">
                  <a href="<?php echo $taskallocation_btn;?>&buyer_id=<?php echo $buyser['buyser_id'];?>"> <button type="button" class="btn btn-primary">分配任务</button></a>
                  <a href="<?php echo $rechargeadd_btn;?>&buyer_id=<?php echo $buyser['buyser_id'];?>"> <button type="button" class="btn btn-primary">充值</button></a>
                </td>
              </tr>
              <?php } ?>
            </tbody>
          </table>
        </div>
      </div>
    </div>
  </div>
</div>
<?php echo $footer; ?>