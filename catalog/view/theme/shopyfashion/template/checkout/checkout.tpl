<!DOCTYPE html>
<html>
	<head>
		<meta charset="UTF-8">
		<meta name="viewport" content="width=device-width,initial-scale=1,minimum-scale=1,maximum-scale=1,user-scalable=no" />	
		<title>确认支付</title>
		<link rel="stylesheet" type="text/css" href="http://cdn.legoods.com/boc/css/shoppingcar.css"/>
		<script src="http://cdn.legoods.com/boc/javascript/layer/layer.js" type="text/javascript" charset="utf-8"></script>
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
				<img class="lazy" data-original="catalog/view/theme/shopyfashion/image/back.png"/>
			</div>
			<h1>确认支付</h1>
		</div>
		<div class="topmask">
		</div>
		<!--address-->
		<div class="address delivery-address shipping_address" id="collapse-shipping-address">
			
		</div> 
		<!--购买的物品-->
		<div class="myshoppingcar goods-details">
		</div>
		<!--购买信息-->
		<div class="acquisition-info ">
			<div class="buyer identity" id="identity">
			</div>
			<p class="del-type"><span>配送方式</span><i>快递免邮</i></p>
			<p class="remark"><span>订单备注</span><span class="right"></span></p>
			<textarea name="" rows="" cols="" class="remark-text"></textarea>					
			<p class="pay-way pay-type"><span>支付方式</span><i>余额支付</i></p>
		</div>
		<!--底部统计-->
		<div class="footermask">
		</div>
		<footer class="details-bottom">
		</footer>
		<!--2016/04/07 更新-->
		<div class="mask">
		</div>
		<div class="sure-pop">
			<h3>验证信息 <em class="close"><i></i></em></h3>
			<p class="verify"><span>动态密码：</span><input type="text" name="" id="" value="" class="input-verity" placeholder="请输入..."/><input type="button" id="verify-btn" class="button-verity" value="获取动态密码"></p>
			<p style='color: #ee4036;font: 1rem/2rem "microsoft yahei";height: 2rem;margin-top: 0.5rem; text-align: center;'><input id="confirm_cb" type="checkbox" value="1" /><a href="index.php?route=product/wapproduct/buymustknow">我已阅读并认同购买须知</a></p>
			<p class="varity-err"></p>
			<p class="submit-btn" style="margin-top:-0.5rem;"><button class="submitbtn">提交</button></p>
		</div>
		<div class="btm-five" style="height: 50px;width:100%;"></div>
		
		<script src="http://cdn.legoods.com/boc/javascript/jquery/jquery-2.1.1.min.js" type="text/javascript" charset="utf-8"></script>
		<script src="http://cdn.legoods.com/boc/javascript/js/jquery.lazyload.js" type="text/javascript" charset="utf-8"></script>
		<script type="text/javascript">
		
		$(".back").click(function(){
    		history.go(-1);
        });
		//实名备案跳转
		$(document).on('click' , '#identity' ,function(){
			location = 'index.php?route=account/realname';
		});
			$(function(){
				//图片懒加载
				 $("img.lazy").lazyload({
				 	threshold : 200,
				 	effect : "fadeIn",
				 	failure_limit : 10,
				 	skip_invisible : false
				 });
				$(".remark").click(function(){
					if($(".remark-text").css("display")=="none"){
						$(this).find(".right").css("transform","rotate(90deg)");
						$(".remark-text").css("display","block");
					}else{
						$(this).find(".right").css("transform","rotate(0deg)");
						$(".remark-text").css("display","none");
						
					}
				});
			});
			var check_card_info = false;
			var cardType = "<?php echo $cardinfo['cardType']?>";
			$(document).ready(function() {
				if(cardType!='0'){
					check_card_info = true;
				}
			    //配送地址
			    <?php if ($shipping_required) { ?>
			    $.ajax({
			        url: 'index.php?route=checkout/shipping_address',
			        dataType: 'html',
			        async: true,
			        success: function(html) {
			            $('.delivery-address').html(html);
			            if($("#no_address").val()!='1'){
			                //如果没有则调用添加地址
			            	shippingAddressSave();
			            	getCard();
			            }
			        },
			        error: function(xhr, ajaxOptions, thrownError) {
			            alert(thrownError + "\r\n" + xhr.statusText + "\r\n" + xhr.responseText);
			        }
			    });
			    <?php } else { ?>
			    $.ajax({
			        url: 'index.php?route=checkout/payment_method',
			        dataType: 'html',
			        async: true,
			        success: function(html) {
			            $('.payment_method').html(html);
			            paymentMethodSave();
			        },
			        error: function(xhr, ajaxOptions, thrownError) {
			            alert(thrownError + "\r\n" + xhr.statusText + "\r\n" + xhr.responseText);
			        }
			    }); 
			    <?php } ?>
			  //end配送地址
			});
			$(document).on('click' , '#collapse-shipping-address' ,function(){
				var address_id = $(this).find("input[name=address_id]").val();
				location = 'index.php?route=account/address';
			});
			function shippingMethod(){
				//配送方式
			    $.ajax({
			        url: 'index.php?route=checkout/shipping_method',
			        dataType: 'html',
			        async: true,
			        success: function(html) {
			            $('.del-type').html(html);
			            shippingMethodSave();
			        },
			        error: function(xhr, ajaxOptions, thrownError) {
			            alert(thrownError + "\r\n" + xhr.statusText + "\r\n" + xhr.responseText);
			        }
			    }); 
			    //end配送方式
			}
			function paymentMethod(){
				 //支付方式
			    $.ajax({
			        url: 'index.php?route=checkout/payment_method',
			        dataType: 'html',
			        async: true,
			        success: function(html) {
			            $('.pay-type').html(html);
			            paymentMethodSave();
			        },
			        error: function(xhr, ajaxOptions, thrownError) {
			            alert(thrownError + "\r\n" + xhr.statusText + "\r\n" + xhr.responseText);
			        }
			    }); 
			    //支付方式end
			}
			
			
			//获取身份证信息
			function getCard(){
				$.ajax({
					url: 'index.php?route=checkout/shipping_address/getCard',
					dataType: 'html',
					success: function(html){
						$(".identity").html(html);
					}
				});
			}
			//获取商品
			function paymentMethodSave(){
				$.ajax({
			        url: 'index.php?route=checkout/payment_method/save', 
			        type: 'post',
			        data: $('.pay-type input[type=\'radio\']:checked, .del-type input[type=\'checkbox\']:checked, .del-type textarea'),
			        dataType: 'json',
			        async: true,
			        success: function(json) {
			            $('.alert, .text-danger').remove();
			            if (json['error']) {
			                if (json['error']['warning']) {
			                    $('.payment_method').prepend('<div class="alert alert-warning">' + json['error']['warning'] + '<button type="button" class="close" data-dismiss="alert">&times;</button></div>');
			                }           
			            } else {
			                $.ajax({
			                    url: 'index.php?route=checkout/confirm',
			                    dataType: 'html',
			                    success: function(html) {
			                        $('.goods-details').html(html);
			                        ajaxgettotal();
								},
			                    error: function(xhr, ajaxOptions, thrownError) {
			                        alert(thrownError + "\r\n" + xhr.statusText + "\r\n" + xhr.responseText);
			                    }
			                }); 
			            }
			        },
			        error: function(xhr, ajaxOptions, thrownError) {
			            alert(thrownError + "\r\n" + xhr.statusText + "\r\n" + xhr.responseText);
			        }
			    }); 
			}
			function ajaxgettotal(){
				$.ajax({
			        url: 'index.php?route=checkout/confirm/total',
			        dataType: 'html',
			        success: function(html) {
			            $(".details-bottom").html(html);
					},
			        error: function(xhr, ajaxOptions, thrownError) {
			            alert(thrownError + "\r\n" + xhr.statusText + "\r\n" + xhr.responseText);
			        }
			    }); 
			}
			//保存配送地址
			function shippingAddressSave(){
				$.ajax({
			        url: 'index.php?route=checkout/shipping_address/save',
			        type: 'post',
			        data: $('#collapse-shipping-address input[type=\'text\'], #collapse-shipping-address input[type=\'date\'], #collapse-shipping-address input[type=\'datetime-local\'], #collapse-shipping-address input[type=\'time\'], #collapse-shipping-address input[type=\'password\'], #collapse-shipping-address input[type=\'checkbox\']:checked, #collapse-shipping-address input[type=\'radio\']:checked, #collapse-shipping-address textarea, #collapse-shipping-address select'),
			        dataType: 'json',
			        async: true,
			        success: function(json) {
			            if (json['error']) {
			                if (json['error']['warning']) {
			                    $('.shipping_address').prepend('<div class="alert alert-warning">' + json['error']['warning'] + '<button type="button" class="close" data-dismiss="alert">&times;</button></div>');
			                }else{
			                	for (i in json['error']) {
			    					$("#address_error_msg").html(json['error'][i]);
			    					$("#address_error").show();
			    					break;
			    				}
			                }
			            }else{
			            	$.ajax({
			                    url: 'index.php?route=checkout/shipping_address',
			                    dataType: 'html',
			                    async: true,
			                    success: function(html) {
			                        $('.shipping_address').html(html);
			                    },
			                    error: function(xhr, ajaxOptions, thrownError) {
			                        alert(thrownError + "\r\n" + xhr.statusText + "\r\n" + xhr.responseText);
			                    }
			                });
			            	shippingMethod();
			            }
			        },
			        error: function(xhr, ajaxOptions, thrownError) {
			            alert(thrownError + "\r\n" + xhr.statusText + "\r\n" + xhr.responseText);
			        }
			    }); 
			}
			//保存配送方式
			function shippingMethodSave(){
				$.ajax({
			        url: 'index.php?route=checkout/shipping_method/save',
			        type: 'post',
			        data: $('.del-type input[type=\'radio\']:checked, #shipping-method-mode input[name=\'comment\']'),
			        dataType: 'json',
			        async: true,
			        success: function(json) {
			            $('.alert, .text-danger').remove();
			            if (json['error']) {
			                if (json['error']['warning']) {
			                    $('.shipping_method').prepend('<div class="alert alert-warning">' + json['error']['warning'] + '<button type="button" class="close" data-dismiss="alert">&times;</button></div>');
			                }           
			            }else{
			            	paymentMethod();
			            }
			        },
			        error: function(xhr, ajaxOptions, thrownError) {
			            alert(thrownError + "\r\n" + xhr.statusText + "\r\n" + xhr.responseText);
			        }
			    });
			}
			$(document).on('change', 'input[name=\'payment_method\']', function() {
				$(".pay").removeClass('checked');
				$(".pay").addClass('uncheck');
				$(this).parent().removeClass('uncheck');
				$(this).parent().removeClass('checked');
				$(this).parent().addClass('checked');
				paymentMethodSave();
			});

			//确认支付按钮
			$(document).on('click' , '#pay-confirm'  , function(){
				if(check_card_info == false){
					layer.open({
					    content: '请填写实名备案信息',
					    style: 'background-color:#fff; color:black; border:none;',
					    time: 2
					});
				}else{
					//显示验证码
					$(".sure-pop,.mask").show();
				}
			});

			/*验证码*/
			var wait=60;  
			function time(o) {  
		        if (wait == 0) {  
		            o.removeAttribute("disabled");            
		            o.value="获取动态密码"; 
		            o.style.color="#7fbe31";
		            o.style.borderColor="#7fbe31";
		            o.style.backgroundColor="#DCEAC9";
		            wait = 60;  
		        }else{
			        /*发送验证码*/
			        if(wait==60){
			        	$.ajax({
	    			        url: 'index.php?route=checkout/checkout/sendverif',
	    			        type: 'post',
	    			        success: function(data) {
	    			        	if(data==0){
	    			        		$(".varity-err").css("color","#EE4036").text("发送失败,请稍后发送！");
		    			        }
	    			        },
	    			    });
				    }
			        o.setAttribute("disabled", true);  
		            o.value="重新发送(" + wait + ")";  
		            o.style.color="#aaa";
		            o.style.borderColor="#aaa";
		            o.style.backgroundColor="#fbfbfb";
			        wait--;  
		            setTimeout(function() {  
		                time(o)  
		            },  
		            1000);  
		        }  
		    }  
			document.getElementById("verify-btn").onclick=function(){time(this);}    
			$(".submitbtn").click(function(){
				var issend = false;
				
				var verity=$(".input-verity").val();
				var confim_ck = $("input[type='checkbox']").is(':checked');
				if($.trim(verity)==""||$.trim(verity)==null){
					$(".varity-err").css("color","#EE4036").text("验证不能为空！");
					setTimeout(function(){
						$(".varity-err").text("");	
					},2000);
					return false;
				}else if(!confim_ck){
					$(".varity-err").css("color","#EE4036").text("请同意协议！");
					setTimeout(function(){
						$(".varity-err").text("");	
					},2000);
					return false;
				}else{
					/*是否成功发送验证码*/
					$.ajax({
				        url: 'index.php?route=checkout/checkout/is_send',
				        type: 'post',
				        success: function(data) {
				        	if(data=='1'){
				        		issend = true;
				        		layer.open({type: 2});
								$.ajax({
							        url: 'index.php?route=checkout/submitted',
							        type: 'post',
							        data : {verif : verity},
							        dataType: 'json',
							        success: function(json) {
										window.location.href = json['redirect'];
							        },
							        error: function(xhr, ajaxOptions, thrownError) {
							            alert(thrownError + "\r\n" + xhr.statusText + "\r\n" + xhr.responseText);
							        }
							    });
					        }else{
					        	$(".varity-err").css("color","#EE4036").text("请重新发送验证码！");
						    }
				        },
				       
				    });
				}				
			});
			//关闭弹窗
			$(".close").click(function(){
				$(".sure-pop,.mask").hide();
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
		