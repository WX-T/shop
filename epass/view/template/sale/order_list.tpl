<?php echo $header; ?>
<script type="text/javascript" src="view/javascript/CreateControl.js"></script>
<script type="text/javascript" src="view/javascript/GRInstall.js"></script>
<?php echo $column_left; ?>
<div id="content">
  <div class="page-header">
    <div class="container-fluid"> 
      <div class="pull-right">
      <?php if($user_id==1){?>
        <button type="submit" id="button-shipping" form="form-order" formaction="<?php echo $shipping; ?>" data-toggle="tooltip" title="<?php echo $button_shipping_print; ?>" class="btn btn-info"><i class="fa fa-truck"></i></button>
        <button type="submit" id="button-invoice" form="form-order" formaction="<?php echo $invoice; ?>" data-toggle="tooltip" title="<?php echo $button_invoice_print; ?>" class="btn btn-info"><i class="fa fa-print"></i></button>
        <a href="<?php echo $add; ?>" data-toggle="tooltip" title="<?php echo $button_add; ?>" class="btn btn-primary"><i class="fa fa-plus"></i></a>
        <button type="button" id="ExportReturnExcel" class="btn btn-primary"><i class="fa fa-mail-forward"></i>&nbsp;<?php echo $button_ExportReturn; ?></button>
        <button type="button" id="ExportHotExcel" class="btn btn-primary"><i class="fa fa-mail-forward"></i>&nbsp;<?php echo $button_ExportHot; ?></button>
		<button type="button" id="Exportorder" class="btn btn-primary"><i class="fa fa-reply"></i>&nbsp;<?php echo $order_ExportHot; ?></button>
<!--         <button type="button" id="Exportimport" class="btn btn-primary"><i class="fa fa-reply"></i>&nbsp;更新EXCEL</button> -->
        <button type="button" id="Orderimport" class="btn btn-primary"><i class="fa fa-mail-forward"></i>&nbsp;<?php echo $button_import; ?></button>
        <button type="button" id="ExportExcel" class="btn btn-primary"><i class="fa fa-mail-forward"></i>&nbsp;<?php echo $button_Export; ?></button>
        <?php }else{?>
        <button type="button" id="MerchantExportExcel" class="btn btn-primary"><i class="fa fa-mail-forward"></i>&nbsp;<?php echo $button_Export; ?></button>
        <?php }?>
    	<button type="button" id="print_orders" class="btn btn-primary"><i class="fa fa-mail-forward"></i>&nbsp;打印</button>
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
        <div class="well">
          <div class="row">
          <form method="post" enctype="multipart/form-data" id="gettime">  
            <div class="col-sm-4">
              <div class="form-group">
                <label class="control-label" for="input-order-id"><?php echo $entry_order_id; ?></label>
                <input type="text" name="filter_order_id" value="<?php echo $filter_order_id; ?>" placeholder="<?php echo $entry_order_id; ?>" id="input-order-id" class="form-control" />
              </div>
              <div class="form-group">
                <label class="control-label" for="input-date-modified"><?php echo $party_assbillno; ?></label>
                  <input type="text" name="filter_party_assbillno" value="<?php echo $filter_party_assbillno; ?>" placeholder="<?php echo $party_assbillno; ?>" id="input-date-modified" class="form-control" />
              </div>
              <?php if($merchant_id =='29' || $user_id == 1){?>
                  <div class="form-group">
                    <label class="control-label" for="input-date-modified"><?php echo $part_order_no; ?></label>
                      <input type="text" name="filter_party_order" value="<?php echo $filter_party_order; ?>" placeholder="<?php echo $part_order_no; ?>" id="input-date-modified" class="form-control" />
                  </div>
                  <div class="form-group">
                    <label class="control-label" for="input-customer">拆分订单号</label>
                    <input type="text" name="filter_center_orderno" value="<?php echo $filter_center_orderno; ?>" placeholder="拆分订单号" id="input-center_orderno" class="form-control" />
                  </div>
              <?php }?>
              <div class="form-group">
                <label class="control-label" for="input-customer"><?php echo $entry_customer; ?></label>
                <input type="text" name="filter_customer" value="<?php echo $filter_customer; ?>" placeholder="<?php echo $entry_customer; ?>" id="input-customer" class="form-control" />
              </div>
              <div class="form-group">
                <label class="control-label" for="filter_customer_expressno">国内物流单号</label>
                <input type="text" name="filter_customer_expressno" value="<?php echo $filter_customer_expressno; ?>" placeholder="国内物流单号" id="input-center_customer_expressno" class="form-control" />
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
              <?php if($user_id==1){?>
              <div class="form-group">
                <label class="control-label" for="input-date-modified">下单开始时间:</label>
                <div class="input-group date">
                  <input type="text" name="filter_start_time" value="<?php echo $filter_start_time; ?>" placeholder="开始时间" data-date-format="YYYY-MM-DD" id="start_time" class="form-control" />
                  <span class="input-group-btn">
                  <button type="button" class="btn btn-default"><i class="fa fa-calendar"></i></button>
                  </span></div>
             </div>
             <?php }?>
             <div class="form-group">
                <label class="control-label" for="filter_order_declartype">是否可走跨境电商</label>
                <select name="filter_order_declartype" id="filter_order_declartype" class="form-control">
                	<option value=""></option>
                	<option value="0" <?php echo $filter_order_declartype=='0' ?'selected="selected"': ''?>>未确认</option>
                	<option value="1" <?php echo $filter_order_declartype=='1' ?'selected="selected"': ''?>>是</option>
                	<option value="5" <?php echo $filter_order_declartype=='5' ?'selected="selected"': ''?>>否</option>
                </select>
              </div>
              
              <div class="form-group">
                <label class="control-label" for="filter_customer_telephone">会员手机号</label>
                <input type="text" name="filter_customer_telephone" value="<?php echo $filter_customer_telephone; ?>" placeholder="会员手机号" id="input-center_customer_telephone" class="form-control" />
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
              <?php if($user_id==1){?>
             <div class="form-group">
            	<label class="control-label" for="input-date-modified">下单结束时间:</label>
           		<div class="input-group date">
                  <input type="text" name="filter_end_time" value="<?php echo $filter_end_time; ?>" placeholder="结束时间" data-date-format="YYYY-MM-DD" id="end_time" class="form-control" />
                  <span class="input-group-btn">
                  <button type="button" class="btn btn-default"><i class="fa fa-calendar"></i></button>
                  </span></div>
              </div>
              <?php }?>
              <div class="form-group">
                <label class="control-label" for="filter_order_declartype">线路</label>
                <select name="filter_line_id" id="" class="form-control">
                	<option value=""></option>
                	<?php foreach($all_lines as $line){?>
                		<option value="<?php echo $line['line_id']?>" <?php echo $filter_line_id==$line['line_id'] ?'selected="selected"': ''?>><?php echo $line['title']?></option>
                	<?php }?>
                </select>
              </div>
              <div class="form-group">
               <button type="button" id="button-filter" class="btn btn-primary pull-right" style="margin-top:20px;"><i class="fa fa-search"></i> <?php echo $button_filter; ?></button>
               </div>
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
                  <td class="text-left">拆分订单编号</td>
                  <td class="text-left"><?php if ($sort == 'customer') { ?>
                    <a href="<?php echo $sort_customer; ?>" class="<?php echo strtolower($order); ?>"><?php echo $column_customer; ?></a>
                    <?php } else { ?>
                    <a href="<?php echo $sort_customer; ?>"><?php echo $column_customer; ?></a>
                    <?php } ?></td>
                  <td class="text-left"><?php echo $column_telephone; ?></td>
                  <td class="text-right"><?php if ($sort == 'o.total') { ?>
                    <a href="<?php echo $sort_total; ?>" class="<?php echo strtolower($order); ?>">订单总价</a>
                    <?php } else { ?>
                    <a href="<?php echo $sort_total; ?>">订单总价 </a>
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
                  <td class="text-left">国际物流单号</td>
                 <!--   <td class="text-left">转运公司</td>
                  <td class="text-left">转运单号</td>
                  <td class="text-left">运费</td>-->
                  <td class="text-left">是否可走跨境电商</td>
                  <td class="text-left"><?php if ($sort == 'status') { ?>
                    <a href="<?php echo $sort_status; ?>" class="<?php echo strtolower($order); ?>"><?php echo $column_status; ?></a>
                    <?php } else { ?>
                    <a href="<?php echo $sort_status; ?>"><?php echo $column_status; ?></a>
                    <?php } ?></td>
                  <td class="text-left">物流状态</td>
                  <td class="text-center">商户</td>
                  <td class="text-center">线路</td>
                  <td class="text-center">国内物流公司</td>
                  <td class="text-center">国内物流单号</td>
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
                  <td class="text-left"><?php echo $order['center_orderno']; ?></td>
                  <td class="text-left"><?php echo $order['customer']; ?></td>
                  <td class="text-left"><?php echo $order['telephone']; ?></td>           
                  <td class="text-right"><?php echo $order['total']; ?></td>
                  <td class="text-left"><?php echo $order['date_added']; ?></td>
                  <td class="text-left"><?php echo $order['date_modified']; ?></td>
                  <td class="text-left"><?php echo $order['trackingno']; ?></td>
                 <!--  <td class="text-left"><?php echo $order['shipping_agents']; ?></td>
                  <td class="text-left"><?php echo $order['assbillno']; ?></td>
                  <td class="text-left"><?php echo $order['ship_price']; ?></td> -->
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
                  <td class="text-left"><?php echo $order['trackingstatus']?></td>
                  <td class="text-left"><?php echo $order['merchant_name']?></td>
                  <td class="text-left"><?php echo $order['line_name']?></td>
                  <td class="text-left"><?php echo $order['shipping_agents']?></td>
                  <td class="text-left"><?php echo $order['expressno']?></td>
                  <td class="text-right">
                           <a href="<?php echo $order['view']; ?>" data-toggle="tooltip" title="<?php echo $button_view; ?>" class="btn btn-info"><i class="fa fa-eye"></i></a>
                       <?php if($merchant_id == 0){?>
                       		 <a href="javascript:void(0);" class='btn btn-primary shipping' id="shipping_<?php echo $order['order_id']; ?>" oid="<?php echo $order['order_id']; ?>" pid="<?php echo $product['order_product_id']; ?>" <?php if($order['status']!='订单已确认，待备货' && $order['status']!='部分备货'){?>style="display:none;"<?php }?>><?php echo $button_shipping;?></a>
                       <a href="javascript:void(0);" class='btn btn-primary arrive' id="shipping_<?php echo $order['order_id']; ?>" oid="<?php echo $order['order_id']; ?>" pid="<?php echo $product['order_product_id']; ?>" <?php if($order['status']!='您的宝贝正在发往美国仓'){?>style="display:none;"<?php }?>><?php echo $button_arrive;?></a>
                           <a href="<?php echo $order['edit']; ?>" data-toggle="tooltip" title="<?php echo $button_edit; ?>" class="btn btn-primary"><i class="fa fa-pencil"></i></a> 
                           <a href="<?php echo $order['delete']; ?>" id="button-delete<?php echo $order['order_id']; ?>" data-toggle="tooltip" title="<?php echo $button_delete; ?>" class="btn btn-danger"><i class="fa fa-trash-o"></i></a>
                  	   <?php }else{?>
                  	   	<?php if(!in_array($order['order_status_id'], array('29','30'))){?>
                  	   		<a href="javascript:void(0);" class='btn btn-primary send_goods' oid="<?php echo $order['order_id']; ?>">发货</a>
                  	   	<?php }?>
                  	   <?php }?>
                  </td>	
                </tr>
                <tr style="display:none;" class="order_detail_tr">
                <td></td>
                <td colspan='16' style="padding:2px;">
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
	                  <?php if(!$product['outofstock'] && !in_array($order['order_status_id'], array('0','11','21'))){?>
	                  <a href="javascript:void(0);" class='btn btn-danger refund'  style="padding: 5px 13px;margin-bottom: 5px;" oid="<?php echo $order['order_id']; ?>" pid="<?php echo $product['order_product_id']; ?>">用户退款</a><br/>
	                  <?php }?>
	                  <?php if($product['refund']){?>
	                  <span class='detail_sign_error'>已退款</span>
	                  <?php }elseif($product['confirm_buy']){?>
	                  <span class='detail_sign_text' oid="<?php echo $order['order_id']; ?>" pid="<?php echo $product['order_product_id']; ?>"><?php echo $text_confirm_buy;?></span>
	                  <a href="javascript:void(0);" class='btn btn-primary edit_buy' style="padding: 5px 13px;margin-bottom: 5px;display:block;" oid="<?php echo $order['order_id']; ?>" pid="<?php echo $product['order_product_id']; ?>"><?php echo $button_edit_buy;?></a>
	                  <?php }elseif($product['outofstock'] && !$product['refund']){?>
	                  <span class='detail_sign_error'><?php echo $text_outofstock;?></span>
	                  <a href="javascript:void(0);" class='btn btn-danger refund'  style="padding: 5px 13px;margin-top: 5px;" oid="<?php echo $order['order_id']; ?>" pid="<?php echo $product['order_product_id']; ?>">退款</a>
	                  <?php }else{?>
	                  	 <?php if($merchant_id ==0){?>
  	 		                  <a href="javascript:void(0);"  class='btn btn-primary confirm_stocking' style="padding: 5px 13px;margin-bottom: 5px;display:block;" oid="<?php echo $order['order_id']; ?>" pid="<?php echo $product['order_product_id']; ?>">备货</a>
	                  	 	  <!-- 管理员 -->
  	 		                  <a href="javascript:void(0);" class='btn btn-primary confirm_buy' style="padding: 5px 13px;margin-bottom: 5px;display:block;" oid="<?php echo $order['order_id']; ?>" pid="<?php echo $product['order_product_id']; ?>">确认购买</a>
	                  	 <?php } ?>
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
  <div id="divReport"></div>
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
<!--             <div class="form-group">  -->
<!--                 <label class="control-label" for="input-party_assbillno">物流单号</label>  -->
<!--                  <input type="text" placeholder="物流单号" id="party_assbillno" class="form-control" />  -->
<!--                </div>  -->
     <button type="button" id="button-cancel" class="btn btn-primary pull-right"><i class="fa fa-repeat"></i> <?php echo $text_cancel; ?></button>
   	 <button type="button" id="button-sure" class="btn btn-primary pull-right" style="margin-right: 4px;"><i class="fa fa-save"></i> <?php echo $text_sure; ?></button>
   </div>
  </div>
  
   <!--打印条码弹窗  -->
  <div id="bar_code_box" style="display: none;padding:20px;">
   <div class="col-sm-12">
     <div id="bar_code"  style="width:155px;height:100px;margin:0 auto;border:1px solid #ccc;">
     	 
     </div>
     <br>
     <input type="hidden" id="order_id"/>
     <button type="button" style="margin-left:119px;margin-top:40px;" class="btn btn-primary button-generate-bar-code"><i class="fa fa-repeat"></i>生成条码</button>
     <button type="button" style="margin-left:10px;margin-top:40px;" onclick="printdiv('bar_code')" class="btn btn-primary button-print-bar-code"><i class="fa fa-save  "></i>打印条码</button>
   </div>
  </div>
  
  
  
   <!--确定备货弹窗  -->
  <div id="confirm_stocking_box" style="display: none;padding:20px;">
   <div class="col-sm-12">
     <input type="hidden" id="o_product_id"/>
     <input type="hidden" id="order_id"/>
     <button type="button" id="button-stocking-cancel" class="btn btn-primary pull-right"><i class="fa fa-repeat"></i> <?php echo $text_cancel; ?></button>
   	 <button type="button" id="button-stocking-sure" class="btn btn-primary pull-right" style="margin-right: 4px;"><i class="fa fa-save"></i> <?php echo $text_sure; ?></button>
   </div>
  </div>
  
  
  
  
    <!--修改已确认购买弹窗  -->
  <div id="edit_buy_box" style="display: none;padding:20px;">
   <div class="col-sm-12">
  			  <input type="hidden" id="o_product_id"/>
                <input type="hidden" id="order_id"/>
              <div class="form-group">
                <label class="control-label" for="input-party_order_no"><?php echo $entry_party_order_no; ?></label>
                <input type="text" value="<?php echo $party_order_no; ?>" placeholder="<?php echo $entry_party_order_no; ?>" id="edit_party_order_no" class="form-control" />
                <input type="hidden" id="o_product_id"/>
                <input type="hidden" id="order_id"/>
              </div>
              <div class="form-group">
                <label class="control-label" for="input-party_price"><?php echo $entry_party_price; ?></label>
                <input type="text" value="<?php echo $party_price; ?>" placeholder="<?php echo $entry_party_price; ?>" id="edit_party_price" class="form-control" />
              </div>
               <div class="form-group">
                <label class="control-label" for="input-party_price"><?php echo $entry_party_assbillno; ?></label>
                <input type="text" value="<?php echo $party_assbillno; ?>" placeholder="<?php echo $entry_party_assbillno; ?>" id="edit_party_assbillno" class="form-control" />
              </div>
     <button type="button" id="button-cancel_edit" class="btn btn-primary pull-right"><i class="fa fa-repeat"></i> <?php echo $text_cancel; ?></button>
   	 <button type="button" id="button-sure_edit" class="btn btn-primary pull-right" style="margin-right: 4px;"><i class="fa fa-save"></i> <?php echo $text_sure; ?></button>
   </div>
  </div>
  

 <!-- 确认发货 -->
  <div id="shipping_box" style="display: none;padding:20px;">
   <div class="col-sm-12">
<!--               <div class="form-group"> -->
<!--                 <label class="control-label" for="input-shipping_agents">转运公司</label> -->
<!--                 <input type="text" placeholder="转运公司" id="shipping_agents" class="form-control" /> -->
<!--               </div> -->
<!--               <div class="form-group"> -->
<!--                 <label class="control-label" for="input-assbillno">转运单号</label> -->
<!--                 <input type="text" placeholder="转运单号" id=assbillno class="form-control" /> -->
<!--               </div> -->
<!--                <div class="form-group"> -->
<!--                 <label class="control-label" for="input-ship_price">运费</label> -->
<!--                 <input type="text" placeholder="运费" id=ship_price class="form-control" /> -->
<!--               </div> -->
			 <input type="hidden" id="o_product_id"/>
                <input type="hidden" id="order_id"/>
              <div class="form-group">
                <label class="control-label" for="input-party_assbillno">物流单号</label>
                 <input type="text" placeholder="物流单号" id=party_reserve_assbillno class="form-control" />
              </div>
     <button type="button" id="button-shipping_cancel" class="btn btn-primary pull-right"><i class="fa fa-repeat"></i> <?php echo $text_cancel; ?></button>
   	 <button type="button" id="button--shipping_sure" class="btn btn-primary pull-right" style="margin-right: 4px;"><i class="fa fa-save"></i> <?php echo $text_sure; ?></button>
   </div>
  </div>
  
  <!-- 商户确认发货 -->
<div id="send_goods_box" style="display: none;padding:20px;">
   <div class="col-sm-12">
              <div class="form-group">
                <label class="control-label" for="input-shipping_agents">快递公司</label> 
                 <input type="text" placeholder="快递公司" id="send_company_name" class="form-control" /> 
               </div> 
               <div class="form-group"> 
                <label class="control-label" for="input-assbillno">快递单号</label> 
                 <input type="text" placeholder="快递单号" id="send_company_no" class="form-control" /> 
               </div> 
                <input type="hidden" id="send_goods_order_id"/>
     <button type="button" id="button_close_send" class="btn btn-primary pull-right"><i class="fa fa-repeat"></i> <?php echo $text_cancel; ?></button>
   	 <button type="button" id="button_send_goods" class="btn btn-primary pull-right" style="margin-right: 4px;"><i class="fa fa-save"></i> <?php echo $text_sure; ?></button>
   </div>
  </div>
  
   <!-- 确认到货-->
  <div id="arrive_box" style="display: none;padding:20px;">
   <div class="col-sm-12">
			  <input type="hidden" id="shipping_order_id"/>
              <input type="hidden" id="o_product_id"/>
              <div class="form-group">
           		   <label class="control-label" for="arrive_time">到货时间</label>
           		<div class="input-group date">
                  <input type="text" id=date_arrive placeholder="到货时间" style="width:450px;height:30px;" />
<!--                   <span class="input-group-btn"> -->
<!--                   <button type="button" class="btn btn-default"><i class="fa fa-calendar"></i></button> -->
<!--                   </span> -->
                  </div>
              </div>
     <button type="button" id="button-arrive_cancel" class="btn btn-primary pull-right"><i class="fa fa-repeat"></i> <?php echo $text_cancel; ?></button>
   	 <button type="button" id="button--arrive_sure" class="btn btn-primary pull-right" style="margin-right: 4px;"><i class="fa fa-save"></i> <?php echo $text_sure; ?></button>
   </div>
  </div>
  
  
 <div id="import_box" style="display: none;padding:20px;">
      <form method="post" action="index.php?route=sale/order/impportorderno&token=<?php echo $token; ?>" enctype="multipart/form-data" id="import_form">
        <h3>导入Excel表：</h3><input  type="file" name="post_file" />
<!--         <input type='file' name="post_file"/> -->
        <input type="submit" class="btn btn-primary pull-right" id="import_btnSearch" value="导入">
      </form>
</div>


  
  <script type="text/javascript">
//订单打印
 Install_InsertReport();
$("#print_orders").on('click',function (){
	var chk_value =[];    
	$('input[name="selected[]"]:checked').each(function(){    
	     chk_value.push($(this).val());
    });  
    if(chk_value.length <1){
		alert('请选择订单');
    }else{
		   Install_InsertReport();
    	   var Installed = Install_Detect();
    	   Report = document.getElementById("_ReportOK");
    	   Report.LoadFromURL("<?php echo $xmlUrl?>/view/javascript/orderTemp.js");
    	   for(var i=0; i < chk_value.length;i++){
    		   Report.LoadDataFromURL("<?php echo $xmlUrl?>/index.php?route=common/printxml&order_id="+chk_value[i]);
 	    	   Report.Print(true);
           }
    }
});
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

	var filter_customer_telephone = $('input[name=\'filter_customer_telephone\']').val();
	
	if (filter_customer_telephone) {
		url += '&filter_customer_telephone=' + encodeURIComponent(filter_customer_telephone);
	}

 	var filter_customer_expressno = $('input[name=\'filter_customer_expressno\']').val();
	
	if (filter_customer_expressno) {
		url += '&filter_customer_expressno=' + encodeURIComponent(filter_customer_expressno);
	}

	//

    var filter_line_id = $('select[name=\'filter_line_id\']').val();
	
	if (filter_line_id) {
		url += '&filter_line_id=' + encodeURIComponent(filter_line_id);
	}

	var filter_party_assbillno = $('input[name=\'filter_party_assbillno\']').val();
	
	if (filter_party_assbillno) {
		url += '&filter_party_assbillno=' + encodeURIComponent(filter_party_assbillno);
	}
	
	var filter_order_status = $('select[name=\'filter_order_status\']').val();
	
	if (filter_order_status != '*') {
		url += '&filter_order_status=' + encodeURIComponent(filter_order_status);
	}


	var filter_order_declartype = $('select[name=\'filter_order_declartype\']').val();
	
	if (filter_order_declartype != '') {
		url += '&filter_order_declartype=' + encodeURIComponent(filter_order_declartype);
	}
	<?php if($merchant_id =='29' || $user_id == 1){?>
	var filter_center_orderno = $('input[name=\'filter_center_orderno\']').val();
	
	if (filter_center_orderno != '') {
		url += '&filter_center_orderno=' + encodeURIComponent(filter_center_orderno);
	}	

	
	var filter_party_order = $('input[name=\'filter_party_order\']').val();

	if (filter_party_order !='') {
		url += '&filter_party_order=' + encodeURIComponent(filter_party_order);
	}
	<?php }?>
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

	var filter_start_time = $('input[name=\'filter_start_time\']').val();
	
	if (filter_start_time) {
		url += '&filter_start_time=' + encodeURIComponent(filter_start_time);
	}

	var filter_end_time = $('input[name=\'filter_end_time\']').val();
	
	if (filter_end_time) {
		url += '&filter_end_time=' + encodeURIComponent(filter_end_time);
	}
	
	location = url;
});

$(".order_line_tr").on('click' , function(e){
	if($(e.target).prop("tagName")!='I' && $(e.target).prop("tagName")!='A'){
		$(this).next("tr").toggle();
	}
});


var lay_import_buy = '';
$("#Exportorder").on('click' , function(){
	lay_import_buy = layer.open({
	    type: 1,
	    title: "导入订单信息",
	    area: ['460px', '160px'],
	    shadeClose: true,
	    content: $('#import_box')
	});
}); 




//导出订单列表
$("#Orderimport").click(function(){
			$("#gettime").attr("action" ,"index.php?route=sale/order/orderexport&token=<?php echo $token; ?>");
			$("#gettime").submit();

	});

//导出商品销量列表
$("#ExportHotExcel").click(function(){
			$("#gettime").attr("action" ,"index.php?route=sale/order/dohotexport&token=<?php echo $token; ?>");
			$("#gettime").submit();

	});

//管理员导出订单类表
$("#ExportExcel").click(function(){
	$("#gettime").attr("action" ,"index.php?route=sale/order/doexport&token=<?php echo $token; ?>");
	$("#gettime").submit();

});

//商户导出订单类表
$("#MerchantExportExcel").click(function(){
			$("#gettime").attr("action" ,"index.php?route=sale/order/merchantdoexport&token=<?php echo $token; ?>");
			$("#gettime").submit();

});
	//导出已退款订单
$("#ExportReturnExcel").click(function(){
	$("#gettime").attr("action" ,"index.php?route=sale/order/doexport&type=return&token=<?php echo $token; ?>");
	$("#gettime").submit();

});




//编辑已确认购买的信息
	var lay_edit_buy = '';
	$(".edit_buy").on('click' , function(){
		var o_product_id = $(this).attr("pid");
		var order_id = $(this).attr("oid");
		$("#o_product_id").val(o_product_id);
		$("#order_id").val(order_id);
// 		alert(order_id);
		lay_edit_buy = layer.open({
		    type: 1,
		    title: "编辑信息",
		    area: ['516px', '380px'],
		    shadeClose: true,
		    content: $('#edit_buy_box')
		});
		$.ajax({
			type : 'post',
			url  : 'index.php?route=sale/order/getbuy&token=<?php echo $token; ?>',
		    dataType : 'json', 
			data : {order_id : order_id , o_product_id:o_product_id},
			success:function(data){
				$("#edit_party_order_no").val(data.party_order_no);
				$("#edit_party_price").val(data.party_price);
				$("#edit_party_assbillno").val(data.party_assbillno);
			}
		});
	});

	

	$("#button-sure_edit").on('click' , function(){
		var order_id = $("#order_id").val();
		var o_product_id = $("#o_product_id").val();
		var order_id = $("#order_id").val();
		var edit_party_order_no = $("#edit_party_order_no").val();
		var edit_party_price = parseFloat($("#edit_party_price").val());
		var edit_party_assbillno = $("#edit_party_assbillno").val();
		var hasError = false;
		if($.trim(edit_party_order_no) == ''){
			$("#edit_party_order_no").parent().addClass('has-error');
			hasError = true;
		}
		if(isNaN(edit_party_price) || party_price == 0){
			$("#edit_party_price").val('');
			$("#edit_party_price").parent().addClass('has-error');
			hasError = true;
		}
		if($.trim(edit_party_assbillno) == ''){
			$("#edit_party_assbillno").parent().addClass('has-error');
			hasError = true;
		}
		if(hasError){
			return false;
		}
		var obj = this;
		$.ajax({
			type : 'post',
			url  : 'index.php?route=sale/order/editbuy&token=<?php echo $token; ?>',
		    dataType : 'json', 
			data : {order_id : order_id , o_product_id:o_product_id , order_no : edit_party_order_no , price : edit_party_price , party_assbillno : edit_party_assbillno},
			success:function(datas){
				layer.close(lay_edit_buy);
				if(datas.code == '3'){
					layer.msg('修改成功！', {icon: 1,time: 1500}, function(){
						window.location.reload();
					});}
			}
		});
	});
	
//打印条码弹框
	var lay_bar_cod = '';
	$(".bar-code").on('click' , function(){
		$("#bar_code").html('');
		var o_product_id = $(this).attr("pid");
		var order_id = $(this).attr("oid");
		$("#o_product_id").val(o_product_id);
		$("#order_id").val(order_id);
		lay_bar_code = layer.open({
		    type: 1,
		    title: "打印条码",
		    area: ['500px', '300px'],
		    shadeClose: true,
		    content: $('#bar_code_box')
		});
	});

//生成条码
	$(".button-generate-bar-code").on('click' , function(){
		var order_id = $("#order_id").val();
		lay_print = $("#bar_code").html('<img id="barcodeIMg" src="index.php?route=sale/order/getbarcode&token=<?php echo $token; ?>& order_id='+order_id+'"/>');
	});

	//打印
	function printdiv(printpage)
	{
    	var headstr = "<html><head><title></title></head><body>";
    	var footstr = "</body>";
    	var newstr = document.all.item(printpage).innerHTML;
    	var oldstr = document.body.innerHTML;
    	document.body.innerHTML = headstr+newstr+footstr;
    	window.print();
    	document.body.innerHTML = oldstr;
    	return false;
	}

//确定备货
var lay_confirm_stocking = '';
$(".confirm_stocking").on('click' , function(){
	var o_product_id = $(this).attr("pid");
	var order_id = $(this).attr("oid");
	$("#o_product_id").val(o_product_id);
	$("#order_id").val(order_id);
	lay_confirm_stocking = layer.open({
	    type: 1,
	    title: "确认备货",
	    area: ['220px', '125px'],
	    shadeClose: true,
	    content: $('#confirm_stocking_box')
	});
});



//确定备货ajax
$("#button-stocking-sure").on('click' , function(){
	var o_product_id = $("#o_product_id").val();
	var order_id = $("#order_id").val();
	
	var obj = this;
	$.ajax({
		type : 'post',
		url  : 'index.php?route=sale/order/confirmbuy&token=<?php echo $token; ?>',
	    dataType : 'json',
		data : {order_id : order_id , o_product_id:o_product_id},
		success:function(datas){
			if(datas.code != '-1'){
				layer.alert('备货成功！' , {icon: 2});
				layer.close(lay_confirm_stocking);
				window.location.reload();
// 				$("#party_assbillno").val('');
			}else{
				layer.alert('系统错误，请稍候重试！' , {icon: 2});
				layer.close(lay_confirm_stocking);
			}
		},
        error: function(xhr, ajaxOptions, thrownError) {
            alert(thrownError + "\r\n" + xhr.statusText + "\r\n" + xhr.responseText);
        }
	});
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
	    area: ['516px', '300px'],
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
		success:function(datas){
			if(datas.code != '-1'){
				if(datas.code == '订单已确认，待备货'){
					$("#shipping_"+order_id).show();
				}
				$("#order_status_"+order_id).html(datas.code);
				$("#party_order_no_"+o_product_id).html(datas.order_no);
				$("#party_price_"+o_product_id).html(datas.price);
				$("#control_box_"+o_product_id).html('<span class="btn btn-primary detail_sign_text confrim_order" oid="<?php echo $order['order_id']; ?>" pid="<?php echo $product['order_product_id']; ?>"><?php echo $text_confirm_buy;?></span>');
				layer.close(lay_confirm_buy);
				$("#party_order_no").val('');
				$("#party_price").val('');
				window.location.reload();
// 				$("#party_assbillno").val('');
			}else{
				layer.alert('系统错误，请稍候重试！' , {icon: 2});
			}
		},
        error: function(xhr, ajaxOptions, thrownError) {
            alert(thrownError + "\r\n" + xhr.statusText + "\r\n" + xhr.responseText);
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
	var lay = layer.confirm('确认对该商品退款吗？' , {icon: 3} , function(){
		layer.close(lay);
		var index = layer.load(1, {shade: [0.1,'#000']});
		$.ajax({
			type : 'post',
			url  : 'index.php?route=sale/order/refund&token=<?php echo $token; ?>',
		    dataType : 'json',
			data : {order_id : order_id , o_product_id:o_product_id},
			success:function(datas){
				layer.close(index);
				if(datas.resunt == '00'){
					if(datas.code == '订单已确认，待备货'){
						$("#shipping_"+order_id).show();
					}
					$("#order_status_"+order_id).html(datas.code);
					$(obj).parent("td").html("<span class='detail_sign_error'>已退款</span>");
				}else{
					layer.alert(datas.code , {icon: 2});
				}
			}
		});
	});
});


//确认到货
var lay_arrive = '';
$(".arrive").on('click' , function(){
	var order_id = $(this).attr("oid");
	$("#shipping_order_id").val(order_id);
	lay_shipping = layer.open({
	    type: 1,
	    title: "到货",
	    area: ['586px', '230px'],
	    shadeClose: true,
	    content: $('#arrive_box')
	});
});

//确定到货
$("#button--arrive_sure").click(function(){
	var order_id = $("#shipping_order_id").val();
	var date_arrive = $("#date_arrive").val();
	var hasError = false;
	if($.trim(date_arrive) == ''){
	 	$("#date_arrive").parent().addClass('has-error');
	 	hasError = true;
	}
	if(hasError){
		return false;
	}
	$.ajax({
		type : 'post',
		url  : 'index.php?route=sale/order/goodsarrive&token=<?php echo $token; ?>',
	    dataType : 'json',
		data : {order_id : order_id , date_arrive : date_arrive},
		success:function(datas){
			layer.close(lay_arrive);
			if(datas.code == '2'){
				layer.msg('成功到货！', {icon: 1,time: 1500}, function(){
					window.location.reload();
				});
			}else{
				layer.alert('系统错误，请稍候重试！' , {icon: 2});
			}
		}
	});
});



//确定发货
var lay_shipping = '';
$(".shipping").on('click' , function(){
	var order_id = $(this).attr("oid");
	$("#shipping_order_id").val(order_id);
	lay_shipping = layer.open({
	    type: 1,
	    title: "发货",
	    area: ['586px', '230px'],
	    shadeClose: true,
	    content: $('#shipping_box')
	});
});


//商户发货
$(".send_goods").on('click', function(){
	var order_id = $(this).attr("oid");
	$("#send_goods_order_id").val(order_id);
	$("#button_send_goods").attr('oid',order_id);
	//判断是否是国内现货
	$.ajax({
		type : 'post',
		url  : 'index.php?route=sale/order/judgestock&token=<?php echo $token; ?>',
	    dataType : 'json',
		data : {order_id : order_id},
		success:function(data){
			if(data.code==1){			//国内现货
				lay_send = layer.open({
				    type: 1,
				    title: "发货",
				    area: ['586px', '330px'],
				    shadeClose: true,
				    content: $('#send_goods_box')
				});
			}else{						//非国内现货

				layer.confirm('是否确认发货？', {
					  btn: ['确认','取消'] //按钮
					}, function(){
						$.ajax({
							type : 'post',
							url  : 'index.php?route=sale/order/merchantsendgoods&token=<?php echo $token; ?>',
						    dataType : 'json',
							data : {order_id : order_id,type:2},
							success:function(data){
								if(data.code==1){			//成功
									layer.msg('发货成功！', {icon: 1,time: 1500}, function(){
										window.location.reload();
									});
								}else{						//失败
									layer.alert('失败！' , {icon: 2});
								}
							}
						});
					}, function(){
					  layer.close();
				});
			}
		}
	});
});
//expressno
//shipping_agents
//商户确认发货
$("#button_send_goods").on('click', function(){
	var order_id = $(this).attr("oid");
	var shipping_agents = $("#send_company_name").val();			//快递公司
	var expressno = $("#send_company_no").val();					//快递单号
	if(shipping_agents.length < 2 || expressno.length <6){
		layer.msg('请输入正确的快递单号和快递公司');
	}else{
		$.ajax({
			type : 'post',
			url  : 'index.php?route=sale/order/merchantsendgoods&token=<?php echo $token; ?>',
		    dataType : 'json',
			data : {order_id : order_id,shipping_agents:shipping_agents,expressno:expressno,type:1},
			success:function(data){
				if(data.code==1){			//成功
					layer.msg('发货成功！', {icon: 1,time: 1500}, function(){
						window.location.reload();
					});
				}else{						//失败
					layer.alert('失败！' , {icon: 2});
				}
			}
		});
	}
});
//确定发货
$("#button--shipping_sure").click(function(){
	var order_id = $("#shipping_order_id").val();
	var party_assbillno = $("#party_reserve_assbillno").val();
// 	alert(edit_party_assbillno);
	var hasError = false;
	
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
		data : {order_id : order_id , party_assbillno : party_assbillno},
		success:function(datas){
			layer.close(lay_shipping);
			if(datas.code == '1'){
				layer.msg('发货成功！', {icon: 1,time: 1500}, function(){
					window.location.reload();
				});
			}else if(datas.code == '2'){
				layer.alert('失败，已存在物流单号' , {icon: 2});
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

$("#button_close_send").on('click' , function(){
	layer.close(lay_send);
});


$("#button-stocking-cancel").on('click' , function(){
	layer.close(lay_confirm_stocking);
});

$("#button-arrive_cancel").on('click' , function(){
	layer.close(lay_shipping);
});

$("#button-cancel_edit").on('click' , function(){
	layer.close(lay_edit_buy);
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