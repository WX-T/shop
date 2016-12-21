<?php echo $header; ?><?php echo $column_left; ?>
<div id="content">
  <div class="page-header">
    <div class="container-fluid">
      <div class="pull-right">
        <button type="submit" form="form-pp-std-uk" data-toggle="tooltip" title="<?php echo $button_save; ?>" class="btn btn-primary"><i class="fa fa-save"></i></button>
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
    <?php if (isset($error['error_warning'])) { ?>
    <div class="alert alert-danger"><i class="fa fa-exclamation-circle"></i> <?php echo $error['error_warning']; ?>
      <button type="button" class="close" data-dismiss="alert">&times;</button>
    </div>
    <?php } ?>
    <div class="panel panel-default">
      <div class="panel-heading">
        <h3 class="panel-title"><i class="fa fa-pencil"></i> <?php echo $text_edit; ?></h3>
      </div>
      <div class="panel-body">
        <form action="<?php echo $action; ?>" method="post" enctype="multipart/form-data" id="form-pp-std-uk" class="form-horizontal">
          <ul class="nav nav-tabs">
            <li class="active"><a href="#tab-general" data-toggle="tab"><?php echo $tab_general; ?></a></li>
            <li><a href="#tab-status" data-toggle="tab"><?php echo $tab_order_status; ?></a></li>
            <li><a href="#tab-bank" data-toggle="tab">添加可用银行</a></li>
          </ul>
          <div class="tab-content">
            <div class="tab-pane active" id="tab-general">
              <div class="form-group required">
                <label class="col-sm-2 control-label" for="entry-wisdom-partner"><?php echo $entry_wisdom_partner; ?></label>
                <div class="col-sm-10">
                  <input type="text" name="wisdom_partner" value="<?php echo $wisdom_partner; ?>" placeholder="<?php echo $entry_wisdom_partner; ?>" id="entry-wisdom-partner" class="form-control"/>
                  <?php if ($error_wisdom_partner) { ?>
                  <div class="text-danger"><?php echo $error_wisdom_partner; ?></div>
                  <?php } ?>
                </div>
              </div>
              
              <div class="form-group required">
                <label class="col-sm-2 control-label" for="entry-wisdom-security-code"><?php echo $entry_wisdom_security_code; ?></label>
                <div class="col-sm-10">
                  <input type="text" name="wisdom_security_code" value="<?php echo $wisdom_security_code; ?>" placeholder="<?php echo $entry_wisdom_security_code; ?>" id="entry-wisdom-security-code" class="form-control"/>
                  <?php if ($error_wisdom_security_code) { ?>
                  <div class="text-danger"><?php echo $error_wisdom_security_code; ?></div>
                  <?php } ?>
                </div>
              </div>
              
              <div class="form-group">
                <label class="col-sm-2 control-label" for="input-total"><span data-toggle="tooltip" title="<?php echo $help_total; ?>"><?php echo $entry_total; ?></span></label>
                <div class="col-sm-10">
                  <input type="text" name="wisdom_total" value="<?php echo $wisdom_total; ?>" placeholder="<?php echo $entry_total; ?>" id="input-total" class="form-control"/>
                </div>
              </div>
              
             
              
              <div class="form-group">
                <label class="col-sm-2 control-label" for="input-wisdom-sort-order"><?php echo $entry_wisdom_sort_order; ?></label>
                <div class="col-sm-10">
                  <input type="text" name="wisdom_sort_order" value="<?php echo $wisdom_sort_order; ?>" placeholder="<?php echo $entry_wisdom_sort_order; ?>" id="input-wisdom-sort-order" class="form-control"/>
                </div>
              </div>
              
              <div class="form-group">
                <label class="col-sm-2 control-label" for="input-status"><?php echo $entry_wisdom_status; ?></label>
                <div class="col-sm-10">
                  <select name="wisdom_status" id="input-wisdom-status" class="form-control">
                    <?php if ($wisdom_status) { ?>
                    <option value="1" selected="selected"><?php echo $text_enabled; ?></option>
                    <option value="0"><?php echo $text_disabled; ?></option>
                    <?php } else { ?>
                    <option value="1"><?php echo $text_enabled; ?></option>
                    <option value="0" selected="selected"><?php echo $text_disabled; ?></option>
                    <?php } ?>
                  </select>
                </div>
              </div>
              
              <div class="form-group">
                <label class="col-sm-2 control-label" for="input-debug"><span data-toggle="tooltip" title="<?php echo $help_log; ?>"><?php echo $entry_log; ?></span></label>
                <div class="col-sm-10">
                  <select name="wisdom_log" id="input-debug" class="form-control">
                    <?php if ($wisdom_log) { ?>
                    <option value="1" selected="selected"><?php echo $text_enabled; ?></option>
                    <option value="0"><?php echo $text_disabled; ?></option>
                    <?php } else { ?>
                    <option value="1"><?php echo $text_enabled; ?></option>
                    <option value="0" selected="selected"><?php echo $text_disabled; ?></option>
                    <?php } ?>
                  </select>
                </div>
              </div>
              
            </div>
            
            
            <div class="tab-pane" id="tab-status">
              <div class="form-group">
                <label class="col-sm-2 control-label" for="input-total"><span data-toggle="tooltip" title="<?php echo $help_trade_finished; ?>"><?php echo $entry_trade_finished_status; ?></span></label>
                <div class="col-sm-10">
                  <select name="wisdom_trade_finished_status_id" class="form-control">
                    <?php foreach ($order_statuses as $order_status) { ?>
                    <?php if ($order_status['order_status_id'] == $wisdom_trade_finished_status_id) { ?>
                    <option value="<?php echo $order_status['order_status_id']; ?>" selected="selected"><?php echo $order_status['name']; ?></option>
                    <?php } else { ?>
                    <option value="<?php echo $order_status['order_status_id']; ?>"><?php echo $order_status['name']; ?></option>
                    <?php } ?>
                    <?php } ?>
                  </select>
                </div>
              </div>
              
              <div class="form-group">
                <label class="col-sm-2 control-label" for="input-total"><span data-toggle="tooltip" title="<?php echo $help_trade_paid; ?>"><?php echo $entry_trade_paid_status; ?></span></label>
                <div class="col-sm-10">
                  <select name="wisdom_trade_paid_status_id" class="form-control">
                    <?php foreach ($order_statuses as $order_status) { ?>
                    <?php if ($order_status['order_status_id'] == $wisdom_trade_paid_status_id) { ?>
                    <option value="<?php echo $order_status['order_status_id']; ?>" selected="selected"><?php echo $order_status['name']; ?></option>
                    <?php } else { ?>
                    <option value="<?php echo $order_status['order_status_id']; ?>"><?php echo $order_status['name']; ?></option>
                    <?php } ?>
                    <?php } ?>
                  </select>
                </div>
              </div>
            </div>
            
            
            <div class="tab-pane" id="tab-bank">
                <div class="table-responsive">
                    <table id="images" class="table table-striped table-bordered table-hover">
                      <thead>
                        <tr>
                          <td class="text-left">银行编号</td>
                          <td class="text-right">银行名称</td>
                          <td class="text-right">图片</td>
                          <td class="text-right">排序</td>
                          <td></td>
                        </tr>
                      </thead>
                      <tbody>
                        <?php $bank_row = 0; ?>
                        <?php foreach ($wisdom_banks as $bank) { ?>
                        <tr id="image-row<?php echo $bank_row; ?>">
                           <td class="text-right">
                             <input type="text" name="wisdom_banks[<?php echo $bank_row; ?>][bank_id]" value="<?php echo $bank['bank_id']; ?>" placeholder="银行编号" class="form-control" />
                          </td>
    					  <td class="text-right"><input type="text" name="wisdom_banks[<?php echo $bank_row; ?>][bank_name]" value="<?php echo $bank['bank_name']; ?>" placeholder="银行名称" class="form-control" /></td>
                          
    					  <td class="text-left"><a href="" id="thumb-image<?php echo $bank_row; ?>" data-toggle="image" class="img-thumbnail"><img src="<?php echo $bank['thumb']; ?>" alt="" title="" data-placeholder="<?php echo $placeholder; ?>" /></a><input type="hidden" name="wisdom_banks[<?php echo $bank_row; ?>][image]" value="<?php echo $bank['image']; ?>" id="input-image<?php echo $bank_row; ?>" /></td>
                          
                          <td class="text-right"><input type="text" name="wisdom_banks[<?php echo $bank_row; ?>][sort_order]" value="<?php echo $bank['sort_order']; ?>" placeholder="排序" class="form-control" /></td>
                          
                          <td class="text-left"><button type="button" onclick="$('#bank_row<?php echo $image_row; ?>').remove();" data-toggle="tooltip" title="删除" class="btn btn-danger"><i class="fa fa-minus-circle"></i></button></td>
                        </tr>
                        <?php $bank_row++; ?>
                        <?php } ?>
                      </tbody>
                      <tfoot>
                        <tr>
                          <td colspan="4"></td>
                          <td class="text-left"><button type="button" onclick="addImage();" data-toggle="tooltip" title="添加图片" class="btn btn-primary"><i class="fa fa-plus-circle"></i></button></td>
                        </tr>
                      </tfoot>
                    </table>
                  </div>
              </div>
              
              
              
          </div>
        </form>
      </div>
    </div>
  </div>
</div>
<script type="text/javascript"><!--
	var bank_row = <?php echo $bank_row; ?>;
    function addImage() {
    	html  = '<tr id="image-row' + bank_row + '">';
    	
        html += '  <td class="text-right"><input type="text" name="wisdom_banks[' + bank_row + '][bank_id]" value="" placeholder="银行编号" class="form-control automanufacturer" /></td>';
    
    	html += '  <td class="text-right"><input type="text" name="wisdom_banks[' + bank_row + '][bank_name]" value="" placeholder="银行名称" class="form-control" /></td>';

    	html += '  <td class="text-left"><a href="" id="thumb-image' + bank_row + '"data-toggle="image" class="img-thumbnail"><img src="<?php echo $placeholder; ?>" alt="" title="" data-placeholder="<?php echo $placeholder; ?>" /><input type="hidden" name="wisdom_banks[' + bank_row + '][image]" value="" id="input-image' + bank_row + '" /></td>';
        
    	html += '  <td class="text-right"><input type="text" name="wisdom_banks[' + bank_row + '][sort_order]" value="" placeholder="排序" class="form-control" /></td>';
    	
    	html += '  <td class="text-left"><button type="button" onclick="$(\'#image-row' + bank_row  + '\').remove();" data-toggle="tooltip" title="删除" class="btn btn-danger"><i class="fa fa-minus-circle"></i></button></td>';
    	html += '</tr>';
    	
    	$('#images tbody').append(html);
    	
    	bank_row++;
    }
//--></script> 
<?php echo $footer; ?>