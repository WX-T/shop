<!DOCTYPE html>
<html>
	<head>
		<meta charset="UTF-8">
		<meta name="viewport" content="width=device-width,initial-scale=1,minimum-scale=1,maximum-scale=1,user-scalable=no" />	
		<title>我的订单</title>
				<link href="http://cdn.legoods.com/boc/css/shoppingcar.css" rel="stylesheet" />
				<link href="http://cdn.legoods.com/boc/css/swiper.min.css" rel="stylesheet" />
	</head>
	<body>
		<script type="text/javascript">
		    !function () {
		        window.onresize = function () {
		            var fontSize = document.documentElement.clientWidth / 32;
		            fontSize = fontSize > 20 ? 20 : fontSize;
		            document.querySelector('html').style.fontSize = fontSize + 'px';
		            document.querySelector('body').style.fontSize = fontSize + 'px';
		        }
		        window.onresize();
		    }();
		</script>
<script type="text/javascript">
  (function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){
  (i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),
  m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)
  })(window,document,'script','https://www.google-analytics.com/analytics.js','ga');

  ga('create', 'UA-81008565-1', 'auto');
  ga('send', 'pageview');

</script>
		<!--top-->
		<div class="head">
			<div class="back">
				<img class="lazy" src="catalog/view/theme/shopyfashion/image/back.png"/>
			</div>
			<h1>我的订单</h1>
		</div>
		<div class="topmask2">
		</div>
<!--选项卡-->
		<div class="tabs">
			<a href="<?php echo $orderurl;?>" hidefocus="true" class="allorder<?php if(!$status){?> active<?php }?>"><span>全部</span></a>
			<a href="<?php echo $orderurl;?>&status=1" hidefocus="true" class="waitforpay<?php if($status == 1){?> active<?php }?>"><span>已付款</span></a>
			<a href="<?php echo $orderurl;?>&status=3" hidefocus="true" class="handle<?php if($status == 3){?> active<?php }?>"><span>待发货</span></a>
			<a href="<?php echo $orderurl;?>&status=24" hidefocus="true" class="waitforreceive<?php if($status == 24){?> active<?php }?>"><span>待收货</span></a>
			<a href="<?php echo $orderurl;?>&status=5" hidefocus="true" class="finish<?php if($status == 5){?> active<?php }?>"><span>已收货</span></a>
			<a href="<?php echo $orderurl;?>&status=7" hidefocus="true" class="finish<?php if($status == 7){?> active<?php }?>"><span>已取消</span></a>
		</div>
		
		<div id="tabs-container" class="swiper-container swiper-container-horizontal">
			<div class="swiper-wrapper"  style="float:left; height:auto;">
				<!--全部-->
				<div class="swiper-slide swiper-slide-active">
					<div class="content-slide">
					<?php if($orders){ ?>
						<!--已完成的订单-->
						<div class="order finishorder">
							<?php foreach($orders as $order){ ?>
							 	<div>
        							<div class="order-head">
        								<p class="id">订单编号：<?php echo $order['order_id'] ?></p>
        								<p class="order-time">下单时间：<span><?php echo $order['date_added']?></span></p>
        								<p class="state"><?php echo $order['status'] ?></p>
        							</div>
        							<div class="order-details">
        							<?php foreach($order['goods'] as $good){ ?>
        								<div class="goods">
        									<a href="<?php echo $good['href']?>"><img src="<?php echo $good['thumb'] ?>" class="goods-img" /></a>
        									<a href="<?php echo $good['href']?>"><p class="name"><?php echo $good['name'] ?></p></a>
        									<p class="price"><span>￥<?php echo $good['price'] ?></span></p>
        									<!--<p class="tariff">预计关税：<?php echo $good['tariff']?></p>-->
        									<p class="number">×<?php echo $good['quantity'] ?></p>
        									<?php if($good['confirm_buy']){?>
        										<span class="msg">已确认购买</span>
        									<?php }elseif($good['outofstock'] && !$good['refund']){?>
        										<span class="msg">缺货并已退款</span>
        									<?php }elseif($good['refund']=='1'){?>
        										<span class="msg">已退款</span>
        									<?php }else{?>
        										<span class="msg">已购买</span>
        									<?php }?>
        								</div>
        							<?php }?>
        							</div>
        							<p class="inall"><span>共<font><?php echo $order['products']?></font>件</span><span>合计：<font><?php echo $order['total'] ?></font></span><span>(含运费<font>￥0.00</font>)</span></p>
        							<?php if($order['status_id']=='29'){?>
        								<p class="inall"><span><font><?php echo $order['status'] ?>:【<?php echo $order['shipping_agents']?>】<span> <font><?php echo !empty($order['logistics']) ? $order['logistics'] : $order['expressno'] ;?></font></span></font></span></p>
        							<?php }?>
        							<div class="operate-btn">
        								<?php if($order['status_id'] == '21'){?>
            								<!-- <p class="delete-btn gopay" oid="<?php echo $order['order_id'] ?>">去支付</p> -->
            								<p class="delete-btn cancel" oid="<?php echo $order['order_id'] ?>">取消订单</p>
        								<?php }elseif(in_array($order['status_id'], array('25','27','26','17'))){?>
        									<a id="loding_tarking" href="<?php echo $order['tracking'];?>"><p class="checklogistics">查看物流</p></a>
            								<p class="delete-btn confirm_receipt" oid="<?php echo $order['order_id'] ?>">确认收货</p>
        								<?php }elseif($order['status_id'] == '1'){?>
        									<p class="delete-btn returnGoods" oid="<?php echo $order['order_id'] ?>">退货</p>
        								<?php }?>
        							</div>
    							</div>
    						<?php }?>
						</div>
					<?php }else{?>
						<h1></h1>
					<?php }?>
					</div>
				</div>
			</div>
		</div>
		<div class="btm-five" style="height: 50px;width:100%;"></div>
		<script src="http://cdn.legoods.com/boc/javascript/jquery/jquery-2.1.1.min.js" type="text/javascript" charset="utf-8"></script>
		<script src="http://cdn.legoods.com/boc/javascript/layer/layer.js" type="text/javascript" charset="utf-8"></script>
		<script src="http://cdn.legoods.com/boc/javascript/js/jquery.lazyload.js" type="text/javascript" charset="utf-8"></script>
		<script src="http://cdn.legoods.com/boc/javascript/js/swiper.min.js" type="text/javascript" charset="utf-8"></script>
		<script type="text/javascript">
		$(".back").click(function(){
    		history.go(-1);
        });
		//确认收货
		$(".confirm_receipt").click(function(e){
			var order_id = $(this).attr("oid");
			layer.open({
			    content: '您确认收货吗？',
			    btn: ['确认', '取消'],
			    shadeClose: false,
			    yes: function(){
        			$.ajax({
        	            url: 'index.php?route=account/order/confirm&order_id='+order_id,
        	            success:function(data){
        					if(data=='1'){
        						layer.open({
        						    content: '确认收货成功！',
        						    time: 2
        						});
        						window.location.reload(); 
        						//$(this).parent(".finishorder").remove();
        						$this.parent().children().remove();
        					}else{
        						layer.open({
        						    content: '确认收货失败！',
        						    time: 2
        						});
        						window.location.reload(); 
        					}
        		        }
        	        }); 
			    }
			});
		});

		$("#loding_tarking").click(function(){
			layer.open({type: 2,shadeClose:false});
		});
		
		$(document).ready(function(){
			$(".gopay").click(function(){
				var order_id = $(this).attr('oid');
				$.ajax({
		            url: 'index.php?route=checkout/confirm/defepayment&order_id='+order_id,
		            dataType: 'html',
		            success: function(html) {
		            	$("#paynow_info").html(html);
		                $('#wisdom-confirm').trigger("click");
		                $('#alipay-confirm').trigger("click");
		                $('#cod-confirm').trigger("click");
					},
		            error: function(xhr, ajaxOptions, thrownError) {
		                alert(thrownError + "\r\n" + xhr.statusText + "\r\n" + xhr.responseText);
		            }
		        }); 
			});
			
			$(".cancel").click(function(){
				var order_id = $(this).attr('oid');
				layer.open({
				    content: '确认删除订单？',
				    btn: ['确认', '取消'],
				    shadeClose: false,
				    yes: function(){
				    	$.ajax({
				            url: 'index.php?route=account/order/cancel&order_id='+order_id,
				            dataType: 'json',
				            success: function(json) {
				            	if(json['error']){
				            		layer.alert(json['error'], {icon: 2 , title: false , shade: false});
				            	}else{
				            		window.location.reload(); 
				            	}
							},
				            error: function(xhr, ajaxOptions, thrownError) {
				                alert(thrownError + "\r\n" + xhr.statusText + "\r\n" + xhr.responseText);
				            }
				        }); 
				    }, no: function(){
				        
				    }
				});
				
			});
			//退货
			$(".returnGoods").click(function(){
				var order_id = $(this).attr('oid');
				layer.open({
				    content: '您确认要退货吗？',
				    btn: ['确认', '取消'],
				    shadeClose: false,
				    yes: function(idx){
						layer.close(idx);
				        var loading = layer.open({type: 2});
				    	$.ajax({
				            url: 'index.php?route=account/order/returnGoods&order_id='+order_id,
				            dataType: 'json',
				            success: function(json) {
				            	layer.close(loading);
				            	if(json.error){
        							layer.open({
        							    content: json.error,
        							    btn: ['确定'],
        							    yes: function(index){
        								layer.close(index);
        							    }
        							});
				            	}else if(json.success){
				            		layer.open({
        							    content: '退货成功，款项已退回至您的额度中！',
        							    btn: ['确定'],
        							    yes: function(index){
        									layer.close(index);
        									window.location.reload(); 
        							    }
        							});
				            	}else{
        							layer.open({
        							    content: '退货失败，请联系客服！',
        							    btn: ['确定'],
        							    yes: function(index){
        									layer.close(index);
        							    }
        							});
					            }
    						},
    			            error: function(xhr, ajaxOptions, thrownError) {
    			            	layer.close(loading);
    			                alert(thrownError + "\r\n" + xhr.statusText + "\r\n" + xhr.responseText);
    			            }
				        }); 
				    }
				});
			});
		});
			//输入框
			$(".searchbox input").on("focus",function(){
				if($(this).val()=="商品名称，商品编号，订单编号"){
					$(this).val("");
				}
			});
			$(".searchbox input").on("blur",function(){
				if($.trim($(this).val())==""){
					$(this).val("商品名称，商品编号，订单编号");
				}
			})
		</script>
		<script>
    var _hmt = _hmt || [];
    (function() {
      var hm = document.createElement("script");
      hm.src = "//hm.baidu.com/hm.js?cd9c4a5618d7dc46a27849db7828d863";
      var s = document.getElementsByTagName("script")[0]; 
      s.parentNode.insertBefore(hm, s);
    })();
</script>
	</body>

</html>
