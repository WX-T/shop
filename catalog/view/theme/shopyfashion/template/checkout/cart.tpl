<!DOCTYPE html>
<html>
<head>
	<meta name="viewport" content="width=device-width,initial-scale=1,minimum-scale=1,maximum-scale=1,user-scalable=no" />
	<meta charset="utf-8">
	<title>购物车</title>
	<link href="http://cdn.legoods.com/boc/css/indexnew.css" rel="stylesheet">
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
	<!--头部-->
   	<div class="head">
   		<!--搜索-->
   		<div class="back" id="back">
	   			<img class="lazy" src="catalog/view/theme/shopyfashion/image/back.png"/>
	   		</div>
   		<h1>购物车</h1>
			<p class="three-point"><i></i></p>
			<p class="down">完成</p>
   	</div>
   	<!--头部蒙版-->
   	<div class="topmask">
   	</div>
    <!--购物车物品列表-->
   <div class="myshoppingcar">
    <form action="<?php echo $action; ?>" method="post" id="cart-form" enctype="multipart/form-data">
		<?php foreach($products as $product){?>
		<div class="commodity">
    		<p class="choose" <?php if($product['is_check']){?>style="background: transparent url('catalog/view/theme/shopyfashion/image/check.png') no-repeat scroll 0% 0% / 100% 100%;"<?php }?>><input product_id="<?php echo $product['product_id']?>" key="<?php echo $product['key']?>" type="checkbox" <?php if($product['is_check']){?>checked="checked"<?php }?>/></p>
			<a href="<?=$product['href'] ?>"><img class="img" src="<?php echo $product['thumb']?>" alt="<?php echo $product['name']?>" /></a>
			<h2><a href="<?=$product['href'] ?>"><?php echo $product['name']?></a></h2>
			<a href="<?=$product['href'] ?>"><p class="price"><span><?php echo $product['price'] ?></span><s><?php if($product['listprice']):?><?php echo $product['listprice'];?><?php endif;?></s></p></a>
			<?php if(Param::$counttax[$product['source']]=='0'){?>
				<a href="<?=$product['href'] ?>"><p class="tariff">预计关税：<span><?php echo $product['tariff']?></span></p></a>
			<?php }else{?>
				<a href="<?=$product['href'] ?>"><p class="tariff"><?php echo Param::$source_desc[$product['source']]?></span></p></a>
			<?php }?>
			<p class="num">
    			<a id="jian" href="javascript:void(0);" title="减" class="btn-less" pid="<?php echo $product['key']; ?>">
    				<span class="minus"><i></i></span>
    			</a>
    		 	<input type="text" name="quantity[<?php echo $product['key']; ?>]" value="<?php echo $product['quantity']; ?>" bvalue="<?php echo $product['quantity']; ?>" size="1" class="form-quantity"/>
             	<a href="javascript:void(0);" title="加" class="btn-add" pid="<?php echo $product['key']; ?>">
             		<span class="plus"><i></i></span>
             	</a>
			</p>
		</div>
		<?php }?>
    </form>
   </div>
    <!--底部蒙版-->
    <div class="footermask">
		</div>
    <!--底部操作-->
    <footer>
    	<p class="allcheck"><span></span><font>全选</font></p>
    	<p class="numbers">共<span id="cart_count"><?php echo isset($total)?$total:0?></span>件</p>
    	<div class="footerright">
	    	<p class="allmoney">合计：<span  id="cart_total"><?php echo $totals['total']['text'] ?></span></p>
	    	<a href="javascript:void(0);" id="billing"><p class="balance">结算</p></a>
<!-- 	    	<p class="collect">收藏</p> -->
	    	<p class="del">删除</p>
    	</div>
    </footer>
    <script src="http://cdn.legoods.com/boc/javascript/jquery/jquery-2.1.1.min.js" type="text/javascript" charset="utf-8"></script>
    <script src="http://cdn.legoods.com/boc/javascript/layer/layer.js" type="text/javascript" charset="utf-8"></script>
    <script src="http://cdn.legoods.com/boc/javascript/js/cart.js" type="text/javascript" charset="utf-8"></script>
    <script src="http://cdn.legoods.com/boc/javascript/js/jquery.lazyload.js" type="text/javascript" charset="utf-8"></script>
    <script type="text/javascript">
		var userstatus = '<?php echo $userstatus?>';
    	$("#back").click(function(){
    		history.go(-1);
        });
   		 $(function(){
	         var pH=$(window).width()/32*4.5+50;    
			 $(".footermask").css("height",pH);	
	   	})
        function product_remove(val_id){
            layer.open({
                content: '确定删除该商品吗？',
                btn: ['确认', '取消'],
                shadeClose: false,
                yes: function(){
                	cart.remove(val_id);
                    layer.closeAll();
                    location = 'index.php?route=checkout/cart';
                }, no: function(){
                	layer.closeAll();
                }
            });
         }
        //删除选中
        $(".del").click(function(){
        	var chk_value =[]; 
			$("input[type='checkbox']:checked").each(function(){
					chk_value.push($(this).attr("key"));
			}); 
			if(chk_value.length <=0){
				layer.open({
				    content: '未选择商品',
				    style: 'background-color:#FFFFFF; color:black; border:none;',
				    time: 2
				});
				
			}else{
				product_remove(chk_value);
			}
			
        })    
        
        
        $(".form-quantity").blur(function(){
        var val = parseInt($(this).val());
        var bval = $(this).attr('bvalue');
        var obj = this;
        if(val <= 0 || isNaN(val)){
            $(this).val(0);
            layer.open({
                content: '数量为 0 将从购物车删除该商品，确定吗？',
                btn: ['确认', '取消'],
                shadeClose: false,
                yes: function(){
                	$("#cart-form").submit();
                }, no: function(){
                	$(obj).val(bval);
                }
            });
        }else{
            $("#cart-form").submit();
        }
        
    });
    	
    	//批量收藏
    	$(".collect").click(function(){
    		var chk_value =[]; 
			$("input[type='checkbox']:checked").each(function(){
				chk_value.push($(this).attr("product_id"));
			});
			if(chk_value.length <=0){
				layer.open({
				    content: '未选择商品',
				    style: 'background-color:#FFFFFF; color:black; border:none;',
				    time: 2
				});
				
			}else{
				wishlists(chk_value);
			}
        });


		//收藏
        function wishlists (product_ids){
    		$.ajax({
    			url: 'index.php?route=account/wapwishlist/addall',
    			type: 'post',
    			data: 'product_id=' + product_ids,
    			dataType: 'json',
    			success: function(json) {
    				if (json['success']) {
    					layer.open({
    					    content: json['success'],
    					    style: 'background-color:#fff; color:black; border:none;',
    					    time: 3
    					});
    					//$('#content').parent().before('<div class="alert alert-success"><i class="fa fa-check-circle"></i> ' + json['success'] + '<button type="button" class="close" data-dismiss="alert">&times;</button></div>');
    				}
    				
    				if (json['info']) {
    					if(json['info'] == 'removed'){
    					}else{
    						layer.open({
    						    content: json['info'],
    						    style: 'background-color:#fff; color:black; border:none;',
    						    time: 3
    						});
    					}
    				}

    			}
    		});
    	}
    	
      	// $('body').delegate('*','click',function(e){alert(e.target.nodeName)});
    	//默认隐藏 收藏和删除
    	$(".collect-btn,.delete-btn").hide();
    	//复选框选中与取消
    	$(".choose input[type='checkbox']").click(function(){
    		if($(this).is(":checked")){
    			$(this).parent().css({"background":"url(catalog/view/theme/shopyfashion/image/check.png) no-repeat","background-size":"100% 100%"});
    		}else{
    			$(this).parent().css({"background":"none"});
    		}
    		product_checkchange();
    	})
    	//全选与全取消
    	$(document).on("click",".allcheck",function(){
    		$(this).addClass("allcancel");
    		$(this).find("font").text("全取消");
    		$(".choose input[type='checkbox']").each(function(){
    			$(this).attr("checked",true);
    			$(this).parent().css({"background":"url(catalog/view/theme/shopyfashion/image/check.png) no-repeat","background-size":"100% 100%"});
    		});
    		product_checkchange();
    	});
    	
    	$(document).on("click",".allcancel",function(){
    		$(this).removeClass("allcancel");
    		$(this).find("font").text("全选");
    		$(".choose input[type='checkbox']").each(function(){
    			$(this).attr("checked",false);
    			$(this).parent().css({"background":"url(image/catalog/slyc/check.png) no-repeat","background-size":"100% 100%"});
    		})
    		product_checkchange();
    	});
    
    	$(".btn-less").on('click' , function(){
    		if($(this).next(".form-quantity").val()>1){
    			var key = $(this).attr('pid');
    			var quantity = parseInt($(".form-quantity").val());
    			$(this).next().val(parseInt($(this).next().val())-1);
    			if($(this).next().val()<=0){
    				$(this).next().val(1);
    			}
    			$("#cart-form").submit();
    		}
    
    	});
    	
    	$(".btn-add").on('click' , function(){
    		var key = $(this).attr('pid');
    		$(this).prev().val(parseInt($(this).prev().val())+1);
    		if($(this).prev().val()<=0){
    			$(this).prev().val(1);
    		}
    		$("#cart-form").submit();
    	});
    	
    	//点编辑
    	$("body").delegate(".three-point","click",function(){
    		$(".three-point,.allmoney,.balance").hide();
    		$(".down,.collect,.del").css("display","inline-block");
    	});
    	
    	$(document).delegate(".down","click",function(){
    		$(".down,.collect,.del").hide();
    		$(".three-point,.allmoney,.balance").css("display","inline-block");
    	});

    	$("#billing").on('click' , function(){
        	var is_canbuy = true;
        	if(userstatus == '2'){
				var tipmsg = '很抱歉，目前暂时无法为您提供海贝信用支付，期待下次为您服务。';
				is_canbuy = false;
            }else if(userstatus == '3'){
            	var tipmsg = '客官别急，小二们正快马加鞭审核中，为您加急开通海贝信用额度。';
            	is_canbuy = false;
            }else if(userstatus == '4'){
                var tipmsg = '呀！客官先激活海贝信用额度，再来打赏吧！';
            	is_canbuy = false;
            }
            if(!is_canbuy){
            	layer.open({
				    content: tipmsg,
				    btn: ['确定'],
				    yes: function(index){
				    	window.location.href = '<?php echo $appindex_url;?>';
				        layer.close(index);
				    }
				});
				return false;
            }
    		var chk_value =[]; 
			$("input[type='checkbox']:checked").each(function(){
				chk_value.push($(this).attr("key"));
			});
			if(chk_value == ''){
				layer.open({
				    content: '请选择购物车中的商品',
				    style: 'background-color:#fff; color:black; border:none;',
				    time: 2
				});
			}else{
				window.location.href='<?php echo $checkout?>';
			}
			
        });
    	function product_checkchange(){
    		var chk_value =[]; 
			$("input[type='checkbox']:checked").each(function(){
				chk_value.push($(this).attr("key"));
			});
    		$.ajax({
    			url: 'index.php?route=checkout/cart/checkchange',
    			type: 'post',
    			data: {keys : chk_value},
    			dataType: 'json',
    			success: function(json) {
        			$("#cart_count").html(json.total);
        			$("#cart_total").html(json.totals.total.text);
    			}
    		});
        }
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