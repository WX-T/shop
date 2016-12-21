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
            <label class="col-sm-2 control-label" for="input-user-group">Amazon账号</label>
            <div class="col-sm-10">
              <select class="form-control col-sm-5" name="amazon">
              	<?php foreach ($amazon_list as $amazon){?>
          		    <option value="<?php echo $amazon['amazon_id']?>"><?php echo $amazon['account_no']?></option>
              	<?php }?>
              </select>
            </div>
          </div>
          
          <div class="form-group">
            <label class="col-sm-2 control-label" for="input-user-group">卡号:</label>
            <div class="col-sm-10">
              <input type="text" name="cardno" value="" placeholder="充值卡账号" id="input_cardno" class="form-control" />
            </div>
          </div>
          
          
          <div class="form-group">
            <label class="col-sm-2 control-label" for="input-user-group">密码:</label>
            <div class="col-sm-10">
              <input type="text" name="pass" value="" placeholder="充值密码" id="input_pass" class="form-control" />
            </div>
          </div>
          
          <div class="form-group">
            <label class="col-sm-2 control-label" for="input-user-group">金额:</label>
            <div class="col-sm-10">
              <input type="text" name="price" value="" placeholder="人民币" id="input_priced" class="form-control" />
            </div>
          </div>
          
        </form>
      </div>
    </div>
  </div>
</div>
<?php echo $footer; ?>