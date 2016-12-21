<?php echo $header; ?><?php echo $column_left; ?>
<div id="content">
  <div class="page-header">
    <div class="container-fluid">
      <div class="pull-right"><a href="<?php echo $add; ?>" data-toggle="tooltip" title="<?php echo $button_add; ?>" class="btn btn-primary"><i class="fa fa-plus"></i></a>
      </div>
      <h1>商户管理</h1>
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
        <h3 class="panel-title"><i class="fa fa-list"></i> 商户列表</h3>
      </div>
      <div class="panel-body">
        <form action="" method="post" enctype="multipart/form-data" id="form-user">
          <div class="table-responsive">
            <table class="table table-bordered table-hover">
              <thead>
                <tr>
                	<td class="text-center">商户ID</td>
                	<td class="text-center">商户名</td>
                	<td class="text-center">email</td>
                	<td class="text-center">tel</td>
                	<td class="text-center">商品总数</td>
                	<td class="text-center">订单总数</td>
                	<td class="text-center">操作</td>
                </tr>
              </thead>
              <tbody>
              <?php foreach ($mercahnts as $v){?>
              	<tr>
              		<td class="text-center"><?php echo $v['merchant_id']?></td>
              		<td class="text-center"><?php echo $v['merchant_name']?></td>
              		<td class="text-center"><?php echo $v['email']?></td>
              		<td class="text-center"><?php echo $v['telphone']?></td>
              		<td class="text-center"><?php echo $v['product_count']?></td>
              		<td class="text-center"><?php echo $v['order_count']?></td>
              		<td class="text-center"><a href="<?php echo $v['edit']; ?>" data-toggle="tooltip" title="修改" class="btn btn-primary"><i class="fa fa-pencil"></i></a></td>
              	</tr>
              <?php }?>
              </tbody>
            </table>
          </div>
        </form>
        <div class="row">
          <div class="col-sm-6 text-left"><?php echo $pagination; ?></div>
          <div class="col-sm-6 text-right"><?php echo $results; ?></div>
        </div>
      </div>
    </div>
  </div>
</div>
<?php echo $footer; ?> 