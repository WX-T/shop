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
        <div class="table-responsive">
          <table class="table table-bordered table-hover">
            <thead>
              <tr>
                <td class="text-left">任务ID</td>
                <td class="text-left">任务状态</td>
                <td class="text-left">订单金额 </td>
                <td class="text-left">操作 </td>
              </tr>
            </thead>
            <tbody>
            <?php foreach($orders as $order){?>
              <tr class="order_line_tr" title="点击查看任务详情">
                <td class="text-left"><?php echo $order['task_id'];?></td>
                <td class="text-left"><?php echo $order['status'];?></td>
                <td class="text-left"><?php echo $order['order_price'];?></td>
                <td class="text-left">
               		 	<a href="javascript:void(0);" class='btn btn-primary shipping' id="shipping_<?php echo $order['order_id']; ?>" oid="<?php echo $order['order_id']; ?>" pid="<?php echo $product['order_product_id']; ?>" <?php if($order['status']!='订单已确认，待备货' && $order['status']!='部分备货'){?>style="display:none;"<?php }?>><?php echo $button_shipping;?></a>
                        <a href="javascript:void(0);" class='btn btn-primary arrive' id="shipping_<?php echo $order['order_id']; ?>" oid="<?php echo $order['order_id']; ?>" pid="<?php echo $product['order_product_id']; ?>" <?php if($order['status']!='您的宝贝正在发往美国仓'){?>style="display:none;"<?php }?>><?php echo $button_arrive;?></a>
                  	   	<?php if(!in_array($order['order_status_id'], array('29','30'))){?>
                  	   		<a href="javascript:void(0);" class='btn btn-primary send_goods' taskid="<?php echo $order['task_id']?>" oid="<?php echo $order['order_id']; ?>">发货</a>
                  	   	<?php }elseif($order['status_id'] == '3'){?>
                  	   		任务完成
                  	   	<?php }?>
                </td>
              </tr>
              <tr style="display:none;" class="order_detail_tr">
                <td colspan='6' style="padding:2px;">
                <table class="table table-bordered">
	              <thead>
	              <!--订单详情列表 -->
	                <tr>
	                  <td class="text-left" style="width:10%;">商品</td>
	                  <td class="text-right" style="width:6%;">编号</td>
	                  <td class="text-right" style="width:3%;">数量</td>
	                  <td class="text-right" style="width:3%;">单品价格</td>
	                  <td class="text-right" style="width:3%;">总价格</td>
	                  <td class="text-right" style="width:6%;">第三方链接</td>
	                  <td class="text-right" style="width:6%;">操作</td>
	                </tr>
	              </thead>
	              <tbody>
	              <?php foreach ($order['products'] as $product) { ?>
	                <tr>
	                  <td class="text-left"><?php echo $product['name']; ?>
	                    <?php foreach ($product['option'] as $option) { ?>
	                    <br />
	                    <?php if ($option['type'] != 'file') { ?>
	                    &nbsp;<small> - <?php echo $option['name']; ?>: <?php echo $option['value']; ?></small>
	                    <?php } else { ?>
	                    &nbsp;<small> - <?php echo $option['name']; ?>: <a href="<?php echo $option['href']; ?>"><?php echo $option['value']; ?></a></small>
	                    <?php } ?>
	                    <?php } ?></td>
	                  <td class="text-right"><?php echo $product['model']; ?></td>
	                  <td class="text-right"><?php echo $product['quantity']; ?></td>
	                  <td class="text-right"><?php echo $product['price']; ?></td>
	                  <td class="text-right"><?php echo $product['total']; ?></td>
	                  <td class="text-right"><?php if(trim($product['out_url'])){?><a href="<?php echo $product['out_url']; ?>" target="_blank"><?php echo $product['out_url']; ?></a><?php }?></td>
	                  <td class="text-right">
    	                  <?php if($product['refund']){?>
    	                  	<span class='detail_sign_error'>已退款</span>
    	                  <?php }elseif($product['confirm_buy']){?>
    	                  	<span class='detail_sign_text' oid="<?php echo $order['order_id']; ?>" pid="<?php echo $product['order_product_id']; ?>">已确认购买</span>
    	                  <button type="button" oid="<?php echo $order['order_id']; ?>" pid="<?php echo $product['order_product_id']; ?>" taskid="<?php echo $order['task_id'];?>"  class="btn btn-primary edit_buy">编辑以购买</button>
    	                  <?php }elseif($product['confirm_buy']=='0' && empty($product['party_order_no'])){?>
	                  	  <button type="button" pid="<?php echo $product['order_product_id']?>" oid="<?php echo $order['order_id']?>" taskid="<?php echo $order['task_id'];?>"  class="btn btn-primary confirm_buy">确认购买</button>
	                  	  <?php }?>
	                  </td>
	                </tr>
	              <?php }?>
	              </tbody>
	            </table>
                </td>
                </tr>
              <?php }?>
            </tbody>
          </table>
        </div>
      </div>
    </div>
  </div>
</div>

<!--确定购买弹窗  -->
  <div id="confirm_buy_box" style="display: none;padding:20px;">
   <div class="col-sm-12">
             <div class="form-group"> 
             <label class="control-label" for="input-party_order_no">第三方订单号</label>
                <input type="text" placeholder="第三方订单号" id="party_order_no" class="form-control" />  
                <input type="hidden" id="o_product_id"/>
                <input type="hidden" id="order_id"/>
                <input type="hidden" id="amazon_id" />
                <input type="hidden" id="taskid" />
              </div>
              <div class="form-group">
               <label class="control-label" for="input-party_price">最终成交价格</label>
                <input type="text" placeholder="最终成交价格" id="party_price" class="form-control" />
              </div>
              <div class="form-group">
               <label class="control-label" for="input-party_price">Amazon购买账号</label>
                <select class="form-control col-sm-5" name="amazon">
              	<?php foreach ($amazon_list as $amazon){?>
          		    <option value="<?php echo $amazon['amazon_id']?>"><?php echo $amazon['account_no']?></option>
              	<?php }?>
                </select>
              </div>
   	 <button type="button" id="button-sure" class="btn btn-primary pull-right" style="margin-right: 4px;margin-top: 46px;"><i class="fa fa-save"></i> <?php echo $text_sure; ?></button>
   </div>
  </div>

   <!--修改已确认购买弹窗  -->
  <div id="edit_buy_box" style="display: none;padding:20px;">
   <div class="col-sm-12">
  			  <input type="hidden" id="o_product_id"/>
                <input type="hidden" id="order_id"/>
              <div class="form-group">
                <label class="control-label" for="">第三方订单号</label>
                <input type="text" value="<?php echo $party_order_no; ?>" placeholder="第三方订单号" id="edit_party_order_no" class="form-control" />
                <input type="hidden" id="o_product_id"/>
                <input type="hidden" id="order_id"/>
              </div>
              <div class="form-group">
                <label class="control-label" for="">最终成交价格</label>
                <input type="text" value="<?php echo $party_price; ?>" placeholder="最终成交价格" id="edit_party_price" class="form-control" />
              </div>
               <div class="form-group">
                <label class="control-label" for="">物流单号</label>
                <input type="text" value="<?php echo $party_assbillno; ?>" placeholder="物流单号" id="edit_party_assbillno" class="form-control" />
              </div>
     <button type="button" id="button-cancel_edit" class="btn btn-primary pull-right"><i class="fa fa-repeat"></i> <?php echo $text_cancel; ?></button>
   	 <button type="button" id="button-sure_edit" class="btn btn-primary pull-right" style="margin-right: 4px;"><i class="fa fa-save"></i> <?php echo $text_sure; ?></button>
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
  
<script>
$(".order_line_tr").on('click' , function(e){
	if($(e.target).prop("tagName")!='I' && $(e.target).prop("tagName")!='A'){
		$(this).next("tr").toggle();
	}
});

//确定购买
var lay_confirm_buy = '';
$(".confirm_buy").on('click' , function(){
	$("#party_order_no").val('');
	$("#party_price").val('');
	var o_product_id = $(this).attr("pid");
	var order_id = $(this).attr("oid");
	var taskid = $(this).attr('taskid');
	$("#o_product_id").val(o_product_id);
	$("#order_id").val(order_id);
	$("#taskid").val(taskid);
	
	lay_confirm_buy = layer.open({
	    type: 1,
	    title: "确认购买",
	    area: ['516px', '400px'],
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
	var taskid = $("#taskid").val();
	var amazon_id = $('select[name=\'amazon\']').val();// 	alert(o_product_id);
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
		url  : 'index.php?route=extension/executetask/confirmbuy&token=<?php echo $token; ?>',
	    dataType : 'json',
		data : {order_id : order_id , o_product_id:o_product_id , order_no : party_order_no , price : party_price, amazon_id : amazon_id, task_id : taskid},
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

$(document).on('click' , ".outofstock" , function(){
	var obj = this;
	var o_product_id = $(this).attr("pid");
	var order_id = $(this).attr("oid");
	var lay = layer.confirm('确认该商品缺货？' , {icon: 3} , function(){
		layer.close(lay);
		$.ajax({
			type : 'post',
			url  : 'index.php?route=extension/executetask/outofstock&token=<?php echo $token; ?>',
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

//编辑已确认购买的信息
var lay_edit_buy = '';
$(".edit_buy").on('click' , function(){
	var o_product_id = $(this).attr("pid");
	var order_id = $(this).attr("oid");
	$("#o_product_id").val(o_product_id);
	$("#order_id").val(order_id);
//		alert(order_id);
	lay_edit_buy = layer.open({
	    type: 1,
	    title: "编辑信息",
	    area: ['516px', '380px'],
	    shadeClose: true,
	    content: $('#edit_buy_box')
	});
	$.ajax({
		type : 'post',
		url  : 'index.php?route=extension/executetask/getbuy&token=<?php echo $token; ?>',
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
		url  : 'index.php?route=extension/executetask/editbuy&token=<?php echo $token; ?>',
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

$("#button-cancel_edit").on('click' , function(){
	layer.close(lay_edit_buy);
});

//商户发货
$(".send_goods").on('click', function(){
	var order_id = $(this).attr("oid");
	var task_id = $(this).attr('taskid');
	$("#send_goods_order_id").val(order_id);
	$("#button_send_goods").attr('oid',order_id);
	$("#button_send_goods").attr('taskid',task_id);
	//判断是否是国内现货
	$.ajax({
		type : 'post',
		url  : 'index.php?route=extension/executetask/judgestock&token=<?php echo $token; ?>',
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
							url  : 'index.php?route=extension/executetask/merchantsendgoods&token=<?php echo $token; ?>',
						    dataType : 'json',
							data : {order_id : order_id,type:2,task_id:task_id},
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
	var task_id = $(this).attr('taskid');
	alert(task_id)
	var shipping_agents = $("#send_company_name").val();			//快递公司
	var expressno = $("#send_company_no").val();					//快递单号
	if(shipping_agents.length < 2 || expressno.length <6){
		layer.msg('请输入正确的快递单号和快递公司');
	}else{
		$.ajax({
			type : 'post',
			url  : 'index.php?route=sale/order/merchantsendgoods&token=<?php echo $token; ?>',
		    dataType : 'json',
			data : {order_id : order_id,shipping_agents:shipping_agents,expressno:expressno,type:1,task_id:task_id},
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
</script>
<?php echo $footer; ?>