<!DOCTYPE html>
<html>
	<head>
		<meta charset="UTF-8">
		<meta name="viewport" content="width=device-width,initial-scale=1,minimum-scale=1,maximum-scale=1,user-scalable=no" />
		<title>商品详情</title>
		<link href="http://cdn.legoods.com/boc/css/indexnew.css" rel="stylesheet" />
    	<link href="http://cdn.legoods.com/boc/css/swiper.min.css" rel="stylesheet" />
    	<link href="catalog/view/theme/shopyfashion/stylesheet/indexnew.css" rel="stylesheet" />
		<style>
            .shoppingknows{width: 28rem;margin: 1.5rem auto ;height: 3rem;border: 1px solid #d1d1d1;border-radius: 1.5rem;background: #ffc5d8;text-align: center;}
            .shoppingknows a{display: block;width:100%;font: 1.5rem/3rem "microsoft yahei";color: #fff;}
        </style>
    	<!--单独的style-->
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
		<!--顶部-->
		<div class="head">
			<!--搜索-->
			<div class="back" id="back">
	   			<img src="./catalog/view/theme/shopyfashion/image/back.png"/>
	   		</div>
	   		<h1>商品详情页</h1>
	   		<p class="shopping-car"></p>
	   		<p class="three-points"></p>
	   	</div>
	   	<div class="head-pop">
   			<p class="share bdsharebuttonbox"><span>
   			<a href="#" class="bds_more" data-cmd="more" style="position: absolute;height: 3rem;width: 100%;top: 0;left: 0;opacity: 0;margin: 0;padding: 0;">
	   	</a>
   			</span>分享</p>
   			<p class="index"><span></span>首页 </p>
	   	</div>
   		<div class="topmask">
		</div>
		   	<div id="wrapper">
				<div style="overflow: scroll;">
			   	<div class="banner">
		   		<!--banner-->
			   	<div class="swiper-container goods-banner">
				    <div class="swiper-wrapper banner-border">
				    	<?php foreach ($images as $key=>$image) { ?>
				    		<?php if($key<=6){?>
					    		<div class="swiper-slide"><img src="<?php echo $image['big']?>"/></div>
					    	<?php }?>
					    <?php }?>
				 	</div>
				 	<?php if(isset($flag[$source]['to'])){?>
				 		<div class="country-img" style="z-index:100;position: absolute;top: 1.5rem !important;background: url(<?php echo $flag[$source]['to'][0]?>) no-repeat; background-size:100% 100%; right: 0;margin: 0 !important; width: 6.8rem;height:4.8rem;">
    		   		</div>
    		   		
    		   		<div class="country-img" style="z-index:100;position: absolute;top: 7rem !important;background: url(<?php echo $flag[$source]['to'][1]?>) no-repeat; background-size:100% 100%; right: 0;margin: 0 !important; width: 6.8rem;height:4.8rem;">
    		   		</div>
				 	<?php }else{?>
				 		<div class="country-img" style="z-index:100;position: absolute;top: 1.5rem !important;background: url(<?php echo $flag[$source]?>) no-repeat; background-size:100% 100%; right: 0;margin: 0 !important; width: 6.8rem;height:4.8rem;">
    		   		</div>
				 	<?php }?>
				 	<!-- <div class="remission">
    		    		<p>日付</p>
    		    		<p class="much">￥10</p>
				    </div> -->
				 	<div class="pagination"></div>
				 	<img class="color-choose" style="width: 100%;position: absolute;top: 0;left: 0; margin:1rem auto;z-index: 100;" />	
				</div>
				<!--价格数量-->
				<div class="wrap">
			   		<h2><?php echo $heading_title;?></h2>
			   		
			   		<?php if(Param::$counttax[$source]=='0'){?>
			   			<p class="from"><span><?php echo Param::$source_desc[$source]?></span><span class="tariff">预计关税:<font><?php echo $product_tariff?></font></span></p>
			   		<?php }else{?>
			   			<p class="from"><span><?php echo Param::$source_desc[$source]?></span></p>
			   		<?php }?>
			   		<p class="price"><span id="showprice"><?php if($special && $special){echo $special; }else{echo $price;}?><span class="like" onclick="wishlist.add(<?php echo $product_id?>)"></span></span></p>
			   		<p class="num">购买数量<span class="minus"><i></i></span><span class="number">1</span><input type="hidden" id="quantity" name="quantity" value="1"><span class="plus quantity"><i></i></span></p>
			   		<div id="product" class="product">
			   		<input type="hidden" name="product_id" value="<?php echo $product_id; ?>" />
    			   		<?php if ($options) { ?>
                            <?php foreach ($options as $option) { ?>
                        			<p class="weight colors">
                        				<span class="color-text"><?php echo $option['name'];?></span>
                        				<?php $ke = 20;?>
                        				<?php foreach($option['value'] as $pkey=> $option_value){?>
                        				<?php $ke = $pkey;?>
                        				  <?php $s = false;?>
                        					<?php foreach ($selectOption as $sel){
                        					       if($sel['option_id'] == $option['option_id'] && $sel['option_value_id']== $option_value['option_value_id']){
                        					           $s = true;
                        					           $ke = 100;
                        					       }
                        					   }
                        					?>
                        					<?php 
                        					   if(isset($OtherOptions)){
                        					       $a = false;
                        					       foreach($OtherOptions as $othkey=>$oth){
                        					           foreach ($oth as $other){
                        					               if($othkey==$option['option_id']){
                        					                   if($other['option_value_id']== $option_value['option_value_id']){
                        					                       $a = true;
                        					                   }
                        					               }
                        					           }
                        					       }
                        					   }else{
                        					       $a = true;
                        					   }
                        					?>
                        					<label for ="<?php echo $option_value['option_value_id']; ?>" name="<?php echo $option['option_id']; ?>" class="<?php if(!$a){echo 'label-disabled';}else{echo 'col-color';}?>" <?php  if($s){?>style="background:#359cd4;color: #fff;"<?php }?> > <?php echo $option_value['name']?>
                        						<!-- <img src="<?php echo $option_value['thumb_image']?>"/> -->
                        							<input type="radio" isclick="<?php if(!$a){echo '0';}else{echo '1';}?>" class="<?php echo $option['option_id'];?> inp" opn="<?php echo $option['name'];?>"  name="option[<?php echo $option['option_id'];?>]"  <?php if($s || $ke == 0){?>checked="checked"<?php }?> value="<?php echo $option_value['option_value_id']; ?>" id="<?php echo $option_value['option_value_id']; ?>"/>
                        					</label>
                        				<?php }?>
                        			</p>
                    		<?php }?>
                	 	<?php }?>
                	 </div>
			   	</div>
			</div>
    	   	<!--商品信息-->
    	   	<div class="shoppingknows" ><a href="index.php?route=product/wapproduct/buymustknow">购买须知</a></div>
    	   	<div class="goods-info" style='margin-bottom: 4.5rem;'>
    	   		<h1><span></span>商品信息</h1>
    	   		<div class="info">
    	   		<?php foreach ($attribute_groups as $attribute_group) { ?>
        			<?php foreach ($attribute_group['attribute'] as $attribute) { ?>
        				<p><span class="text"><?php echo $attribute['name']; ?></span><font class="colon">:</font>	<span class="value"><?php echo $attribute['text']; ?></span></p>
        			<?php }?>
        		<?php }?>
    	   		</div>
    	   		<div class="goods-details" >
    	   			<h1><span></span>品牌故事</h1>
        	   		<div class="img">
        	   			<img src="<?php echo $mimage?>"/>
        	   		</div>
        	   		<p class="text"><?php echo $detailed?></p>
        	   		<p class="more"><a href="<?php echo $manufacturers?>">进入品牌专辑 </a><span></span></p>
        	   		<p class="upup"><span></span>上拉显示图文信息</p>
    	   		</div>
    	   	</div>
   	        <!-- 商品详情 -->
    	   	<div class="goods-details goods-des" style="display:none">
    	   		<h1 class="title" style="color: #333;font: 1.6rem/2.5rem "microsoft yahei";margin: 0.5rem 0 0.8rem 0.4rem;"><span style="display: inline-block;float: left;background: #f46276 ;height: 2.5rem;width: .4rem;"></span>商品特性</h1>		
    	   		<?php echo $description; ?><br/><br/><br/>
    	   		<ul>
    	   			<?php foreach ($images as $key=>$image) { ?>
    	   				<?php if($key<=12){?>
			    			<li><img src="<?php echo $image['big']?>"/></li>
			    		<?php }?>
			    	<?php }?>
			    </ul>
    	   	</div>
    	   	
    	   	<!--猜你喜欢-->
   	        <?php echo $content_bottom;?>
    	   	<!--下拉-->
    	   	</div>
    	   	</div>
    	   	
    	   	<!--footer-->
    	   	<div class="footermask">
    	   	</div>
    	   	<div class="footer">
    	   		<span class="add" id="btn-cart">加入购物车</span>		
    	   		<span class="buy" id="buy-now">立即购买</span>
    	   	</div>
    	   	<div class="footer-menu fixed">
                <div class="footer-menu-content pure-form pure-g">
                    <div class="pure-u-1-4">
                        <div class="menu ">
                            <a href="http://m.boccfc.cn/haitao/index.html">
                                <div class="menu-img home-icon"></div>
                                <div class="menu-word">首页</div>
                            </a>
                        </div>
                    </div>
                    <div class="pure-u-1-4">
                        <div class="menu show">
                        	<a href="http://m.boccfc.cn/haitao/view/mall/haitaomall.html">
        	                    <div class="menu-img consume-icon">
        	                    </div>
        	                    <div class="menu-word menu-htmall">商城</div>
                            </a>
                        </div>
                    </div>
                    <div class="pure-u-1-4">
                        <div class="menu">
                        	<a href="http://m.boccfc.cn/haitao/view/mall/haitaocart.html">
        	                    <div class="menu-img pay-icon">
        	                    </div>
        	                    <div class="menu-word menu-htcart">购物车</div>
                            </a>
                        </div>
                    </div>
                    <div class="pure-u-1-4">
                        <div class="menu">
                            <a href="http://m.boccfc.cn/haitao/login.html">
                                <div class="menu-img user-icon">
                                </div>
                                <div class="menu-word">我的海贝</div>
                            </a>
                        </div>
                    </div>
                </div>
            </div>
    	   	<span id="home" src="<?php echo $home?>"></span>
    	   	<p id="thisurl" src="<?php echo $thisurl?>&showodescript=1"><p>
    	   	<p id="getUrl" src="<?php echo $opurl?>"><p>
            <script src="http://cdn.legoods.com/boc/javascript/jquery/jquery-2.1.1.min.js" type="text/javascript" charset="utf-8"></script>
            <script src="http://cdn.legoods.com/boc/javascript/js/swiper.min.js" type="text/javascript" charset="utf-8"></script>
            <script src="http://cdn.legoods.com/boc/javascript/js/yxMobileSlider.js" type="text/javascript" charset="utf-8"></script>
            <script src="http://cdn.legoods.com/boc/javascript/layer/layer.js" type="text/javascript" charset="utf-8"></script>
            <script src="http://cdn.legoods.com/boc/javascript/js/jquery.lazyload.js" type="text/javascript" charset="utf-8"></script>
            <script src="http://cdn.legoods.com/boc/javascript/js/pullToRefresh.js" type="text/javascript" charset="utf-8"></script>
            <script src="http://cdn.legoods.com/boc/javascript/js/iscroll.js" type="text/javascript" charset="utf-8"></script>
         	<script src="http://cdn.legoods.com/boc/javascript/js/common.js" type="text/javascript" charset="utf-8"></script>
         	<script>window._bd_share_config={"common":{"bdSnsKey":{},"bdText":"<?php echo $heading_title?>","bdMini":"2","bdMiniList":false,"bdPic":"<?php echo $images[0]['big']?>","bdStyle":"0","bdSize":"16"},"share":{}};with(document)0[(getElementsByTagName('head')[0]||body).appendChild(createElement('script')).src='http://bdimg.share.baidu.com/static/api/js/share.js?v=89860593.js?cdnversion='+~(-new Date()/36e5)];</script>
         	<!--回到顶部-->
			<p class="backtop"></p>
			<script type="text/javascript">
			
			//选择商品属性

			/* var url = '';
			//获取redio
			for (var a=0;a<optionname.length;a++){
				url += optionname[a]+'='+$('input:radio[name='+optionname[a]+']:checked').val()+'&';
			} */
			
			//function get
			$("#back").click(function(){
	    		history.go(-1);
	        });

			var url ='';
			//获取每次点击选项的值
	        $(".inp").click(function(){
		        if($(this).attr('isclick') =='1'){
		        	//选择商品选项
					var optionname = new Array();
					url = ''
					for(var i=0 ;i <$(".color-text").length;i++){
					  optionname[i] = $(".color-text").eq(i).text();
					}
					var urlArray = new Array();
					for (var a=0;a<optionname.length;a++){
						url += optionname[a]+'='+$('input:radio[opn='+optionname[a]+']:checked').val()+'-';
						//urlArray[optionname[a]]= $('input:radio[name='+optionname[a]+']:checked').val();
					}
					//join('|');
					window.location.href=$("#getUrl").attr("src")+'&options='+url;
			    }
			})
			 	//回到顶部
    		    $(".backtop").click(function(){
    		    	$('.scroller').css("transform","translate(0px, -50px)");  
    	        	return false;  
    		    });
    		    var url ='';
              	$(".col-color").click(function(){
                  	//alert(22);
    				$(this).parent().find("label").css({"background":"#fff","border-color":"#d6d6d6","color":"#333"});
    				$(this).css({"background":"#359cd4","border-color":"#F8C87B","color":"#fff"});
    				var srcimg = $(this).find("img").attr("src");
    				if(srcimg.indexOf("no_image-")<0){
    					var src =srcimg.replace('50x50','425x445');
        				$(".color-choose").attr("src",src);
        			}
        		});
			</script>
            <script type="text/javascript">
               
                $(function(){
                    var pH=$(window).width()/32*4.5+50;    
            		 $(".footermask").css("height",pH);	
                 })
                $(".weight font").click(function(){
                	ajaxGetSalePrice();
                });
				$(".index").click(function(){
					window.location.href=$("#home").attr("src");
				});
                refresher.init({
      	             id: "wrapper",
      	             pullDownAction: Refresh,
      	            pullUpAction: Load
      		    });
      		    function Load() {
      		    	$(".footer").css("display","none");
      	            setTimeout(function () {
      	            	$(".pullUp").css('display',"none");
      	            	$(".footer").css("display","block");
      	                //window.location.href=$("#thisurl").attr("src");
						$(".goods-des").show().find("div").css({"width":"96%","margin":"2px auto"}).find("img").css("width","100%");
						wrapper.refresh();
          	        }, 500);
      	        }
      		    function Refresh() {
      	            setTimeout(function () {	
      	                window.location.href=window.location.href;
      	            }, 500);
      	        }
      	   		$(function(){
      	   			//判断#wrapper的高度
      	   			var wrapperH=$(window).height()-$(".head").height()-50;
      	   			$("#wrapper").css({"height":wrapperH});
      	   			//图片懒加载
      				 $("img.lazy").lazyload({
      				 	threshold : 200,
      				 	effect : "fadeIn",
      				 	failure_limit : 10,
      				 	skip_invisible : false
      				 });
      	   			//轮播图
      				var mySwiper = new Swiper('.banner .swiper-container',{
      					autoplay : 5000,//可选选项，自动滑动
      					loop : true,//可选选项，开启循环
      					pagination : '.pagination',
      				});
      				//左右滑动
      			    var swiper = new Swiper('#youlike', {
      			        pagination: '.swiper-pagination',
      			        slidesPerView: 3.555556,
      			        paginationClickable: true,
      			        spaceBetween: 0,
      			        freeMode: true
      			    });
      				//弹窗分享
      				var w=1;
      	    		$(".three-points").click(function(){
      	    			if($(".head-pop").css("display")=="none"){
      	    				$(".head-pop").show();
      	    			}else{
      	    				$(".head-pop").hide();
      	    		  }
      	    			w=1;
      	    		})
      	    		$('body').on('click',function(){
      	    			
      	    			if($(".head-pop").css("display")=="block"&&w>1){
      	    				$(".head-pop").hide();
      	    			}
      	    			w++;
      	    		});
      	    		//收藏
      	    		$(document).on("click",".like",function(){
      	    			$(this).toggleClass("love");
      	    		})
      	   		});
               /*  //获取价格
                function ajaxGetSalePrice(){
                	$.ajax({
                		url: 'index.php?route=product/wapproduct/getprice',
                		type: 'post',
                		data: $('#product input[type=\'text\'], #product input[type=\'hidden\'], #product input[type=\'radio\']:checked, #product input[type=\'checkbox\']:checked, #product select, #product textarea'),
                		dataType: 'json',
                		success: function(json) {
                			if(json['info']){
                				$("#showprice").html(json['info'].price);
                			}
                		}
                	});
                } */
// 				$(function(){
// 					var $height=$(".goods-info .info .value").height();
// 					var heightV=$(window).width()/32*1.8;
// 					$(".goods-info .info .colon").each(function(){
// 							if($height>heightV){
// 									$(this).css("margin-bottom",".9rem");
// 								}
// 						})
// 			  })	
                
    			//选择商品属性
//                 $(".weight font").click(function(){
// 					$(this).find("input[type='radio']").attr("checked","checked");		
//                 })
    			
    			
    			$(".express font").click(function(){
    				$(this).parent().find("font").css({"background":"#fff","border-color":"#d6d6d6"});
    				$(this).css({"background":"#359cd4","border-color":"#F8C87B"});
    			})
                
            	//图片轮播
            	var bannerW=$(window).width();
            	$(".slider").yxMobileSlider({width:bannerW,height:bannerW,during:3000});
            	//弹窗
            	$(".three-point").click(function(){
            		if($(".head-pop").css("display")=="none"){
            			$(".head-pop").show();
            		}else{
            			$(".head-pop").hide();
            		}
            	})
            	
            	//收藏
            	$(".goods-price .like").click(function(){
            			$(this).toggleClass("love");   			
            	})
            	$(".like span").click(function(){ 
            		$(this).toggleClass("love");
            	})
            	//数量加减
            	$(".minus").click(function(){
            		var index=parseInt($(".number").text())-1;
            		if(parseInt($(".number").text())>1){
            			$(".number").text(index)
            			$("#quantity").val(index);
            		}
            	});
            	$(".quantity").click(function(){
            		var index=parseInt($(".number").text())+1;
            		if(parseInt($(".number").text())<99){
            			$(".number").text(index)
            			$("#quantity").val(index);
            		}
            	})
            	
            	//添加购物车
            	$('#btn-cart').on('click', function() {
                	$.ajax({
                		url: 'index.php?route=checkout/cart/add',
                		type: 'post',
                		data: $('#product input[type=\'text\'],input[type=\'hidden\'], #product input[type=\'radio\']:checked, #product input[type=\'checkbox\']:checked, #product select, #product textarea'),
                		dataType: 'json',
                		async: true,
                		success: function(json) {
                			$('.alert, .text-danger').remove();
                			$('.form-group').removeClass('has-error');
                
                			if (json['error']) {
                				if (json['error']['option']) {
                					for (i in json['error']['option']) {
                						var element = $('#input-option' + i.replace('_', '-'));
                						element.parent().addClass('bd-red')
                					}
                				}
                				if (json['error']['recurring']) {
                					$('select[name=\'recurring_id\']').after('<div class="text-danger">' + json['error']['recurring'] + '</div>');
                				}
                				if (json['error']['quantity']) {
                					layer.open({
                					    title: '提示',
                					    content: json['error']['quantity'],
                					    time: 3,
                					    btn: ['继续浏览']
                					});
                				}
                			}
                			if (json['success']) {
                				layer.open({
            					    content: json['success'],
            					    btn: ['去购物车', '继续购物'],
            					    yes: function(index){
            					    	window.location.href = 'index.php?route=checkout/cart';
            					        layer.close(index);
            					    }
            					});
                				$('#cart-total').html(json['total']);
                			}
                		}
                	});
                });
            
                $("#buy-now").on('click' , function(){
                	$.ajax({
                		url: 'index.php?route=checkout/cart/add',
                		type: 'post',
                		data: $('#product input[type=\'text\'],input[type=\'hidden\'], #product input[type=\'radio\']:checked, #product input[type=\'checkbox\']:checked, #product select, #product textarea'),
                		dataType: 'json',
                		async: true,
                		success: function(json) {
                			if (json['success']) {
                				window.location.href = 'index.php?route=checkout/cart';
                			}else if (json['error']) {
                				if (json['error']['quantity']) {
                					layer.open({
                                        content: json['error']['quantity'],
                                        style: 'background-color:#fff;color:#000; border:none;',
                                        time: 3
                                    });
                				}
                			}
                		}
                	});
            	});
//             	$(function(){
//             		$("body").on("click",".weight input",function(){
//                     	 alert(222);
//         				$(this).parent().parent().find("font").css({"background":"#fff","border-color":"#d6d6d6","color":"#333"});
//         				$(this).parent().css({"background":"#359cd4","border-color":"#F8C87B","color":"#fff"});
//         				var srcimg = $(this).parent().find("img").attr("src");
//         				if(srcimg.indexOf("no_image-")<0){
//         					var src =srcimg.replace('50x50','425x445');
//             				$(".color-choose").attr("src",src);
//             			}
//                 });
            	function getNaturalWidth(img) {
    			    var image = new Image()
    			    image.src = img.src
    			    var naturalWidth = image.width;
    			    var neturalHeight = image.height;
    			    return naturalWidth-neturalHeight;
				}
            window.onload = function(){
        		$(".banner .swiper-slide img").each(function(){
					$(this).css({"height":"auto","width":"auto"});            		
        			var fontsize =$(window).width()/32*24;
        			if(getNaturalWidth(this)>0){
        				$(this).css({"width":"100%","margin-top":(fontsize-imgH)/2});
        				var imgH = $(this).height();
        				$(this).css("margin-top",(fontsize-imgH)/2);
        			}else{
        				$(this).css({"height":"100%","margin":"0 auto"});
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