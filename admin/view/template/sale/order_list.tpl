<?php echo $header; ?><?php echo $column_left; ?>
<div id="content">
  <div class="page-header">
    <div class="container-fluid">
      <div class="pull-right">
        <button type="submit" id="button-shipping" form="form-order" formaction="<?php echo $shipping; ?>" data-toggle="tooltip" title="<?php echo $button_shipping_print; ?>" class="btn btn-info"><i class="fa fa-truck"></i></button>
        <button type="submit" id="button-invoice" form="form-order" formaction="<?php echo $invoice; ?>" data-toggle="tooltip" title="<?php echo $button_invoice_print; ?>" class="btn btn-info"><i class="fa fa-print"></i></button>
        <a href="<?php echo $add; ?>" data-toggle="tooltip" title="<?php echo $button_add; ?>" class="btn btn-primary"><i class="fa fa-plus"></i></a></div>
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
            <div class="col-sm-4">
              <div class="form-group">
                <label class="control-label" for="input-order-id"><?php echo $entry_order_id; ?></label>
                <input type="text" name="filter_order_id" value="<?php echo $filter_order_id; ?>" placeholder="<?php echo $entry_order_id; ?>" id="input-order-id" class="form-control" />
              </div>
              <div class="form-group">
                <label class="control-label" for="input-customer"><?php echo $entry_customer; ?></label>
                <input type="text" name="filter_customer" value="<?php echo $filter_customer; ?>" placeholder="<?php echo $entry_customer; ?>" id="input-customer" class="form-control" />
              </div>
              
              <div class="form-group">
                <label class="control-label" for="filter_order_declartype">是否可走跨境电商</label>
                <select name="filter_order_declartype" id="filter_order_declartype" class="form-control">
                	<option value=""></option>
                	<option value="0" <?php echo $filter_order_declartype=='0' ?'selected="selected"': ''?>>未确认</option>
                	<option value="1" <?php echo $filter_order_declartype=='1' ?'selected="selected"': ''?>>是</option>
                	<option value="5" <?php echo $filter_order_declartype=='5' ?'selected="selected"': ''?>>否</option>
                </select>
              </div>
            </div>
            <div class="col-sm-4">
              <div class="form-group">
                <label class="control-label" for="input-order-status"><?php echo $entry_order_status; ?></label>
                <select name="filter_order_status" id="input-order-status" class="form-control">
                  <option value="*"></option>
                  <?php if ($filter_order_status == '0') { ?>
                  <option value="0" selected="selected"><?php echo $text_missing; ?></option>
                  <?php } else { ?>
                  <option value="0"><?php echo $text_missing; ?></option>
                  <?php } ?>
                  <?php foreach ($order_statuses as $order_status) { ?>
                  <?php if ($order_status['order_status_id'] == $filter_order_status) { ?>
                  <option value="<?php echo $order_status['order_status_id']; ?>" selected="selected"><?php echo $order_status['name']; ?></option>
                  <?php } else { ?>
                  <option value="<?php echo $order_status['order_status_id']; ?>"><?php echo $order_status['name']; ?></option>
                  <?php } ?>
                  <?php } ?>
                </select>
              </div>
              <div class="form-group">
                <label class="control-label" for="input-total"><?php echo $entry_total; ?></label>
                <input type="text" name="filter_total" value="<?php echo $filter_total; ?>" placeholder="<?php echo $entry_total; ?>" id="input-total" class="form-control" />
              </div>
            </div>
            <div class="col-sm-4">
              <div class="form-group">
                <label class="control-label" for="input-date-added"><?php echo $entry_date_added; ?></label>
                <div class="input-group date">
                  <input type="text" name="filter_date_added" value="<?php echo $filter_date_added; ?>" placeholder="<?php echo $entry_date_added; ?>" data-date-format="YYYY-MM-DD" id="input-date-added" class="form-control" />
                  <span class="input-group-btn">
                  <button type="button" class="btn btn-default"><i class="fa fa-calendar"></i></button>
                  </span></div>
              </div>
              <div class="form-group">
                <label class="control-label" for="input-date-modified"><?php echo $entry_date_modified; ?></label>
                <div class="input-group date">
                  <input type="text" name="filter_date_modified" value="<?php echo $filter_date_modified; ?>" placeholder="<?php echo $entry_date_modified; ?>" data-date-format="YYYY-MM-DD" id="input-date-modified" class="form-control" />
                  <span class="input-group-btn">
                  <button type="button" class="btn btn-default"><i class="fa fa-calendar"></i></button>
                  </span></div>
              </div>
              
              <button type="button" id="button-filter" class="btn btn-primary pull-right"><i class="fa fa-search"></i> <?php echo $button_filter; ?></button><br />
 <form method="post" enctype="multipart/form-data" id="gettime">          
		 <div class="form-group">
                <label class="control-label" for="input-date-modified">导出时间:</label>
                <div class="input-group date">
                  <input type="text" name="start_time" placeholder="开始时间" data-date-format="YYYY-MM-DD" id="start_time" class="form-control" />
                  <span class="input-group-btn">
                  <button type="button" class="btn btn-default"><i class="fa fa-calendar"></i></button>
                  </span></div>
           <div class="input-group date">
                  <input type="text" name="end_time" placeholder="结束时间" data-date-format="YYYY-MM-DD" id="end_time" class="form-control" />
                  <span class="input-group-btn">
                  <button type="button" class="btn btn-default"><i class="fa fa-calendar"></i></button>
                  </span></div>
              </div>
               <button type="button" id="ExportExcel" class="btn btn-primary pull-right"><i class="fa"></i><?php echo $button_Export; ?></button>
           </div>
    </form>        
            
            
          </div>
        </div>
        <form method="post" enctype="multipart/form-data" id="form-order">
          <div class="table-responsive">
            <table class="table table-bordered table-hover" style="cursor: pointer;">
              <thead>
                <tr>
                  <td style="width: 1px;" class="text-center"><input type="checkbox" onclick="$('input[name*=\'selected\']').prop('checked', this.checked);" /></td>
                  <td class="text-right"><?php if ($sort == 'o.order_id') { ?>
                    <a href="<?php echo $sort_order; ?>" class="<?php echo strtolower($order); ?>"><?php echo $column_order_id; ?></a>
                    <?php } else { ?>
                    <a href="<?php echo $sort_order; ?>"><?php echo $column_order_id; ?></a>
                    <?php } ?></td>
                  <td class="text-left"><?php if ($sort == 'customer') { ?>
                    <a href="<?php echo $sort_customer; ?>" class="<?php echo strtolower($order); ?>"><?php echo $column_customer; ?></a>
                    <?php } else { ?>
                    <a href="<?php echo $sort_customer; ?>"><?php echo $column_customer; ?></a>
                    <?php } ?></td>
                  <td class="text-left"><?php echo $column_telephone; ?></td>
                  <td class="text-right"><?php if ($sort == 'o.total') { ?>
                    <a href="<?php echo $sort_total; ?>" class="<?php echo strtolower($order); ?>"><?php echo $column_total; ?></a>
                    <?php } else { ?>
                    <a href="<?php echo $sort_total; ?>"><?php echo $column_total; ?></a>
                    <?php } ?></td>
                  <td class="text-left"><?php if ($sort == 'o.date_added') { ?>
                    <a href="<?php echo $sort_date_added; ?>" class="<?php echo strtolower($order); ?>"><?php echo $column_date_added; ?></a>
                    <?php } else { ?>
                    <a href="<?php echo $sort_date_added; ?>"><?php echo $column_date_added; ?></a>
                    <?php } ?></td>
                  <td class="text-left"><?php if ($sort == 'o.date_modified') { ?>
                    <a href="<?php echo $sort_date_modified; ?>" class="<?php echo strtolower($order); ?>"><?php echo $column_date_modified; ?></a>
                    <?php } else { ?>
                    <a href="<?php echo $sort_date_modified; ?>"><?php echo $column_date_modified; ?></a>
                    <?php } ?></td>
                  <td class="text-left">转运公司</td>
                  <td class="text-left">转运单号</td>
                  <td class="text-left">运费</td>
                  <td class="text-left">是否可走跨境电商</td>
                  <td class="text-left"><?php if ($sort == 'status') { ?>
                    <a href="<?php echo $sort_status; ?>" class="<?php echo strtolower($order); ?>"><?php echo $column_status; ?></a>
                    <?php } else { ?>
                    <a href="<?php echo $sort_status; ?>"><?php echo $column_status; ?></a>
                    <?php } ?></td>
                  <td class="text-right"><?php echo $column_action; ?></td>
                </tr>
              </thead>
              <tbody>
                <?php if ($orders) { ?>
                <?php foreach ($orders as $order) { ?>
                <tr class="order_line_tr" title="点击查看商品详情">
                  <td class="text-center"><?php if (in_array($order['order_id'], $selected)) { ?>
                    <input type="checkbox" name="selected[]" value="<?php echo $order['order_id']; ?>" checked="checked" />
                    <?php } else { ?>
                    <input type="checkbox" name="selected[]" value="<?php echo $order['order_id']; ?>" />
                    <?php } ?>
                    <input type="hidden" name="shipping_code[]" value="<?php echo $order['shipping_code']; ?>" /></td>
                  <td class="text-right"><?php echo $order['order_id']; ?></td>
                  <td class="text-left"><?php echo $order['customer']; ?></td>
                  <td class="text-left"><?php echo $order['telephone']; ?></td>           
                  <td class="text-right"><?php echo $order['total']; ?></td>
                  <td class="text-left"><?php echo $order['date_added']; ?></td>
                  <td class="text-left"><?php echo $order['date_modified']; ?></td>
                  <td class="text-left"><?php echo $order['shipping_agents']; ?></td>
                  <td class="text-left"><?php echo $order['assbillno']; ?></td>
                  <td class="text-left"><?php echo $order['ship_price']; ?></td>
                  <td class="text-left">
                  	<?php 
                  	     if($order['declartype']=='1'){
                  	         echo '是';
                  	     }elseif ($order['declartype']=='5'){
                  	         echo '否';        
                  	     }else{
                  	         echo '未确定';
                  	     }
                  	?>
                  </td>
                  <td class="text-left" id="order_status_<?php echo $order['order_id']; ?>"><?php echo $order['status']; ?></td>
                  <td class="text-right">
                  <a href="javascript:void(0);" class='btn btn-primary shipping' id="shipping_<?php echo $order['order_id']; ?>" oid="<?php echo $order['order_id']; ?>" pid="<?php echo $product['order_product_id']; ?>" <?php if($order['status']!='已备货'){?>style="display:none;"<?php }?>><?php echo $button_shipping;?></a>
                  <a href="<?php echo $order['view']; ?>" data-toggle="tooltip" title="<?php echo $button_view; ?>" class="btn btn-info"><i class="fa fa-eye"></i></a>
                   <a href="<?php echo $order['edit']; ?>" data-toggle="tooltip" title="<?php echo $button_edit; ?>" class="btn btn-primary"><i class="fa fa-pencil"></i></a> 
                   <a href="<?php echo $order['delete']; ?>" id="button-delete<?php echo $order['order_id']; ?>" data-toggle="tooltip" title="<?php echo $button_delete; ?>" class="btn btn-danger"><i class="fa fa-trash-o"></i></a>
                   </td>
                </tr>
                <tr style="display:none;" class="order_detail_tr">
                <td></td>
                <td colspan='11' style="padding:2px;">
                <table class="table table-bordered">
	              <thead>
	              <!--订单详情列表 -->
	                <tr>
	                  <td class="text-left" style="width:20%;"><?php echo $column_product; ?></td>
	                  <td class="text-left" style="width:8%;"><?php echo $column_model; ?></td>
	                  <td class="text-right" style="width:5%;"><?php echo $column_quantity; ?></td>
	                  <td class="text-right" style="width:8%;"><?php echo $column_price; ?></td>
	                  <td class="text-right" style="width:8%;"><?php echo $column_total; ?></td>
	                  <td class="text-right" style="width:8%;"><?php echo $column_source; ?></td>
	                  <td class="text-right"><?php echo $column_outurl; ?></td>
	                  <td class="text-right" style="width:6%;">商品链接</td>
	                  <td class="text-right" style="width:10%;"><?php echo $column_party_order_no; ?></td>
	                  <td class="text-right" style="width:8%;"><?php echo $column_party_price; ?></td>
	                  <td class="text-right" style="width:6%;">物流单号</td>
	                  <td class="text-right" style="width:6%;"><?php echo $column_control; ?></td>
	                </tr>
	              </thead>
	              <tbody>
	                <?php foreach ($order['products'] as $product) { ?>
	                <tr>
	                  <td class="text-left"><a href="<?php echo $product['href']; ?>"><?php echo $product['name']; ?></a>
	                    <?php foreach ($product['option'] as $option) { ?>
	                    <br />
	                    <?php if ($option['type'] != 'file') { ?>
	                    &nbsp;<small> - <?php echo $option['name']; ?>: <?php echo $option['value']; ?></small>
	                    <?php } else { ?>
	                    &nbsp;<small> - <?php echo $option['name']; ?>: <a href="<?php echo $option['href']; ?>"><?php echo $option['value']; ?></a></small>
	                    <?php } ?>
	                    <?php } ?></td>
	                  <td class="text-left"><?php echo $product['model']; ?></td>
	                  <td class="text-right"><?php echo $product['quantity']; ?></td>
	                  <td class="text-right"><?php echo $product['price']; ?></td>
	                  <td class="text-right"><?php echo $product['total']; ?></td>
	                  <td class="text-right"><?php echo $product['source']; ?></td>
	                  <td class="text-right"><?php if(trim($product['out_url'])){?><a href="<?php echo $product['out_url']; ?>" target="_blank"><?php echo $product['out_url']; ?></a><?php }?></td>
	                  <td class="text-right"><a href="<?php echo $product['h5url']?>" target="_blank"><?php echo $product['h5url']?></a></td>
	                  <td class="text-right" id="party_order_no_<?php echo $product['order_product_id']; ?>"><?php echo $product['party_order_no']; ?></td>
	                  <td class="text-right" id="party_price_<?php echo $product['order_product_id']; ?>"><?php echo $product['party_price']; ?></td>	                  
	                  <td class="text-right" id=""><?php echo $product['assbillno']; ?></td>
	                  <td class="text-right" id="control_box_<?php echo $product['order_product_id']; ?>">
	                  <?php if($product['confirm_buy']){?>
	                  <span class='detail_sign_text' oid="<?php echo $order['order_id']; ?>" pid="<?php echo $product['order_product_id']; ?>"><?php echo $text_confirm_buy;?></span>
	                  <?php }elseif($product['outofstock'] && !$product['refund']){?>
	                  <span class='detail_sign_error'><?php echo $text_outofstock;?></span>
	                  <a href="javascript:void(0);" class='btn btn-danger refund'  style="padding: 5px 13px;margin-top: 5px;" oid="<?php echo $order['order_id']; ?>" pid="<?php echo $product['order_product_id']; ?>">退款</a>
	                  <?php }elseif($product['refund']){?>
	                  <span class='detail_sign_error'>已退款</span>
	                  <?php }else{?>
	                  <a href="javascript:void(0);" class='btn btn-primary confirm_buy' style="padding: 5px 13px;margin-bottom: 5px;display:block;" oid="<?php echo $order['order_id']; ?>" pid="<?php echo $product['order_product_id']; ?>"><?php echo $button_confirm_buy;?></a>
	                  <a href="javascript:void(0);" class='btn btn-danger outofstock'  style="padding: 5px 13px;" oid="<?php echo $order['order_id']; ?>" pid="<?php echo $product['order_product_id']; ?>">缺货</a>
	                  <?php }?>
	                  </td>
	                </tr>
	                <?php } ?>
	              </tbody>
	            </table>
                </td>
                </tr>
                <?php } ?>
                <?php } else { ?>
                <tr>
                  <td class="text-center" colspan="8"><?php echo $text_no_results; ?></td>
                </tr>
                <?php } ?>
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
  <!--确定购买弹窗  -->
  <div id="confirm_buy_box" style="display: none;padding:20px;">
   <div class="col-sm-12">
              <div class="form-group">
                <label class="control-label" for="input-party_order_no"><?php echo $entry_party_order_no; ?></label>
                <input type="text" placeholder="<?php echo $entry_party_order_no; ?>" id="party_order_no" class="form-control" />
                <input type="hidden" id="o_product_id"/>
                <input type="hidden" id="order_id"/>
              </div>
              <div class="form-group">
                <label class="control-label" for="input-party_price"><?php echo $entry_party_price; ?></label>
                <input type="text" placeholder="<?php echo $entry_party_price; ?>" id="party_price" class="form-control" />
              </div>
              <div class="form-group">
                <label class="control-label" for="input-party_assbillno">物流单号</label>
                <input type="text" placeholder="物流单号" id="party_assbillno" class="form-control" />
              </div>
     <button type="button" id="button-cancel" class="btn btn-primary pull-right"><i class="fa fa-repeat"></i> <?php echo $text_cancel; ?></button>
   	 <button type="button" id="button-sure" class="btn btn-primary pull-right" style="margin-right: 4px;"><i class="fa fa-save"></i> <?php echo $text_sure; ?></button>
   </div>
  </div>

 <!-- 确认发货 -->
  <div id="shipping_box" style="display: none;padding:20px;">
   <div class="col-sm-12">
              <div class="form-group">
                <label class="control-label" for="input-shipping_agents">转运公司</label>
                <input type="text" placeholder="转运公司" id="shipping_agents" class="form-control" />
                <input type="hidden" id="shipping_order_id"/>
                <input type="hidden" id="o_product_id"/>
              </div>
              <div class="form-group">
                <label class="control-label" for="input-assbillno">转运单号</label>
                <input type="text" placeholder="转运单号" id=assbillno class="form-control" />
              </div>
               <div class="form-group">
                <label class="control-label" for="input-ship_price">运费</label>
                <input type="text" placeholder="运费" id=ship_price class="form-control" />
              </div>
               <div class="form-group">
                <label class="control-label" for="input-party_assbillno">物流单号</label>
                <input type="text" placeholder="物流单号" id="party_reserve_assbillno" class="form-control" />
              </div>
     <button type="button" id="button-shipping_cancel" class="btn btn-primary pull-right"><i class="fa fa-repeat"></i> <?php echo $text_cancel; ?></button>
   	 <button type="button" id="button--shipping_sure" class="btn btn-primary pull-right" style="margin-right: 4px;"><i class="fa fa-save"></i> <?php echo $text_sure; ?></button>
   </div>
  </div>
  <script type="text/javascript">

$('#button-filter').on('click', function() {
	url = 'index.php?route=sale/order&token=<?php echo $token; ?>';
	
	var filter_order_id = $('input[name=\'filter_order_id\']').val();
	
	if (filter_order_id) {
		url += '&filter_order_id=' + encodeURIComponent(filter_order_id);
	}
	
	var filter_customer = $('input[name=\'filter_customer\']').val();
	
	if (filter_customer) {
		url += '&filter_customer=' + encodeURIComponent(filter_customer);
	}
	
	var filter_order_status = $('select[name=\'filter_order_status\']').val();
	
	if (filter_order_status != '*') {
		url += '&filter_order_status=' + encodeURIComponent(filter_order_status);
	}


	var filter_order_declartype = $('select[name=\'filter_order_declartype\']').val();
	
	if (filter_order_declartype != '') {
		url += '&filter_order_declartype=' + encodeURIComponent(filter_order_declartype);
	}	
		

	var filter_total = $('input[name=\'filter_total\']').val();

	if (filter_total) {
		url += '&filter_total=' + encodeURIComponent(filter_total);
	}	
	
	var filter_date_added = $('input[name=\'filter_date_added\']').val();
	
	if (filter_date_added) {
		url += '&filter_date_added=' + encodeURIComponent(filter_date_added);
	}
	
	var filter_date_modified = $('input[name=\'filter_date_modified\']').val();
	
	if (filter_date_modified) {
		url += '&filter_date_modified=' + encodeURIComponent(filter_date_modified);
	}
				
	location = url;
});

$(".order_line_tr").on('click' , function(e){
	if($(e.target).prop("tagName")!='I' && $(e.target).prop("tagName")!='A'){
		$(this).next("tr").toggle();
	}
});

jQuery(function () {
	// 开始时间设置
    jQuery('#start_time').datetimepicker({
        timeFormat: "HH:mm:ss",
        dateFormat: "yy-mm-dd"
    });
    // 结束时间设置
    jQuery('#end_time').datetimepicker({
        timeFormat: "HH:mm:ss",
        dateFormat: "yy-mm-dd"
    });

});


 

$("#ExportExcel").click(function(){
// 	var start_time = $("#start_time").val();
// 	var end_time = $("#end_time").val();

// 		layer.confirm('确定导出列表？', function(){
// 			layer.load("正在导出，请稍等..." ,3);
// 			var index = layer.load(1, {
// 				  shade: [0.1,'#fff'] //0.1透明度的白色背景
// 				});
// 			var index = layer.load(1, {
// 				  shade: [0.1,'#fff'] //0.1透明度的白色背景
// 				});
			$("#gettime").attr("action" ,"index.php?route=sale/order/doexport&token=<?php echo $token; ?>");
			$("#gettime").submit();

	});
	

//确定购买
var lay_confirm_buy = '';
$(".confirm_buy").on('click' , function(){
	var o_product_id = $(this).attr("pid");
	var order_id = $(this).attr("oid");
	$("#o_product_id").val(o_product_id);
	$("#order_id").val(order_id);
	lay_confirm_buy = layer.open({
	    type: 1,
	    title: "确认购买",
	    area: ['516px', '350px'],
	    shadeClose: true,
	    content: $('#confirm_buy_box')
	});
});


//确定购买ajax
$("#button-sure").on('click' , function(){
	var o_product_id = $("#o_product_id").val();
	var order_id = $("#order_id").val();
	var party_order_no = $("#party_order_no").val();
	var party_price = parseFloat($("#party_price").val());
// 	alert(o_product_id);
	var hasError = false;
	if($.trim(party_order_no) == ''){
		$("#party_order_no").parent().addClass('has-error');
		hasError = true;
	}
	if(isNaN(party_price) || party_price == 0){
		$("#party_price").val('');
		$("#party_price").parent().addClass('has-error');
		hasError = true;
	}
	if(hasError){
		return false;
	}
	var obj = this;
	$.ajax({
		type : 'post',
		url  : 'index.php?route=sale/order/confirmbuy&token=<?php echo $token; ?>',
	    dataType : 'json',
		data : {order_id : order_id , o_product_id:o_product_id , order_no : party_order_no , price : party_price},
// 			,assbillno:party_assbillno},
		success:function(datas){
			if(datas.code != '-1'){
				if(datas.code == '已备货'){
					$("#shipping_"+order_id).show();
				}
				$("#order_status_"+order_id).html(datas.code);
				$("#party_order_no_"+o_product_id).html(datas.order_no);
				$("#party_price_"+o_product_id).html(datas.price);
				$("#control_box_"+o_product_id).html('<span class="btn btn-primary detail_sign_text confrim_order" oid="<?php echo $order['order_id']; ?>" pid="<?php echo $product['order_product_id']; ?>"><?php echo $text_confirm_buy;?></span>');
				layer.close(lay_confirm_buy);
				$("#party_order_no").val('');
				$("#party_price").val('');
// 				$("#party_assbillno").val('');
			}else{
				layer.alert('系统错误，请稍候重试！' , {icon: 2});
			}
		}
	});
});

$("#party_order_no,#party_price").on('keyup' , function(){
	$(this).parent().removeClass('has-error');
});

$(document).on('click' , ".outofstock" , function(){
	var obj = this;
	var o_product_id = $(this).attr("pid");
	var order_id = $(this).attr("oid");
	var lay = layer.confirm('确认该商品缺货？' , {icon: 3} , function(){
		layer.close(lay);
		$.ajax({
			type : 'post',
			url  : 'index.php?route=sale/order/outofstock&token=<?php echo $token; ?>',
		    dataType : 'json',
			data : {order_id : order_id , o_product_id:o_product_id},
			success:function(datas){
				if(datas.code != '-1'){
					$("#order_status_"+order_id).html(datas.code);
					$(obj).parent("td").html("<span class='detail_sign_error'><?php echo $text_outofstock;?></span><a href='javascript:void(0);' class='btn btn-danger refund'  style='padding: 5px 13px;' oid='"+datas.order_id+"' pid='"+datas.product_id+"'>退款</a>");
				}else{
					layer.alert('系统错误，请稍候重试！' , {icon: 2});
				}
			}
		});
	});
});


$(document).on('click'  , ".refund" , function(){
	var obj = this;
	var o_product_id = $(this).attr("pid");
	var order_id = $(this).attr("oid");
	var lay = layer.confirm('确认该商品已退款？' , {icon: 3} , function(){
		layer.close(lay);
		$.ajax({
			type : 'post',
			url  : 'index.php?route=sale/order/refund&token=<?php echo $token; ?>',
		    dataType : 'json',
			data : {order_id : order_id , o_product_id:o_product_id},
			success:function(datas){
				if(datas.code != '-1'){
					if(datas.code == '已备货'){
						$("#shipping_"+order_id).show();
					}
					$("#order_status_"+order_id).html(datas.code);
					$(obj).parent("td").html("<span class='detail_sign_error'>已退款</span>");
				}else{
					layer.alert('系统错误，请稍候重试！' , {icon: 2});
				}
			}
		});
	});
});


var lay_shipping = '';
$(".shipping").on('click' , function(){
	var order_id = $(this).attr("oid");
	$("#shipping_order_id").val(order_id);
	lay_shipping = layer.open({
	    type: 1,
	    title: "发货",
	    area: ['586px', '450px'],
	    shadeClose: true,
	    content: $('#shipping_box')
	});
});

//确定发货
$("#button--shipping_sure").click(function(){
	var order_id = $("#shipping_order_id").val();
	var shipping_agents = $("#shipping_agents").val();
	var assbillno = $("#assbillno").val();
	var ship_price = parseFloat($("#ship_price").val());
	var party_assbillno = $("#party_reserve_assbillno").val();

	var hasError = false;
	if($.trim(shipping_agents) == ''){
		$("#shipping_agents").parent().addClass('has-error');
		hasError = true;
	}
	if($.trim(assbillno) == ''){
		$("#assbillno").parent().addClass('has-error');
		hasError = true;
	}
	if(isNaN(ship_price) || ship_price == 0){
		$("#ship_price").val('');
		$("#ship_price").parent().addClass('has-error');
		hasError = true;
	}
	if($.trim(party_assbillno) == ''){
	 	$("#party_reserve_assbillno").parent().addClass('has-error');
	 	hasError = true;
	}
	if(hasError){
		return false;
	}
	$.ajax({
		type : 'post',
		url  : 'index.php?route=sale/order/shipment&token=<?php echo $token; ?>',
	    dataType : 'json',
		data : {order_id : order_id , shipping_agents : shipping_agents , assbillno : assbillno , ship_price : ship_price , party_assbillno : party_assbillno},
		success:function(datas){
			layer.close(lay_shipping);
			if(datas.code == '1'){
				
				layer.msg('发货成功！', {icon: 1,time: 1500}, function(){
					window.location.reload();
				});
			}else{
				layer.alert('系统错误，请稍候重试！' , {icon: 2});
			}
		}
	});
});


$("#shipping_agents,#assbillno,#ship_price").on('keyup' , function(){
	$(this).parent().removeClass('has-error');
});

$("#button-cancel").on('click' , function(){
	layer.close(lay_confirm_buy);
});

$("#button-reserve-cancel").on('click' , function(){
	layer.close(lay_confirm_order);
});

$("#button-shipping_cancel").on('click' , function(){
	layer.close(lay_shipping);
});


//--></script> 
  <script type="text/javascript"><!--
$('input[name=\'filter_customer\']').autocomplete({
	'source': function(request, response) {
		$.ajax({
			url: 'index.php?route=sale/customer/autocomplete&token=<?php echo $token; ?>&filter_name=' +  encodeURIComponent(request),
			dataType: 'json',			
			success: function(json) {
				response($.map(json, function(item) {
					return {
						label: item['name'],
						value: item['customer_id']
					}
				}));
			}
		});
	},
	'select': function(item) {
		$('input[name=\'filter_customer\']').val(item['label']);
	}	
});
//--></script> 
  <script type="text/javascript"><!--
$('input[name^=\'selected\']').on('change', function() {
	$('#button-shipping, #button-invoice').prop('disabled', true);
	
	var selected = $('input[name^=\'selected\']:checked');
	
	if (selected.length) {
		$('#button-invoice').prop('disabled', false);
	}
	
	for (i = 0; i < selected.length; i++) {
		if ($(selected[i]).parent().find('input[name^=\'shipping_code\']').val()) {
			$('#button-shipping').prop('disabled', false);
			
			break;
		}
	}
});

$('input[name^=\'selected\']:first').trigger('change');

$('a[id^=\'button-delete\']').on('click', function(e) {
	e.preventDefault();
	
	if (confirm('<?php echo $text_confirm; ?>')) {
		location = $(this).attr('href');
	}
});
//--></script> 
  <script src="view/javascript/jquery/datetimepicker/bootstrap-datetimepicker.min.js" type="text/javascript"></script>
  <link href="view/javascript/jquery/datetimepicker/bootstrap-datetimepicker.min.css" type="text/css" rel="stylesheet" media="screen" />
  <script type="text/javascript"><!--
$('.date').datetimepicker({
	pickTime: false
});
//--></script></div>
<?php echo $footer; ?>