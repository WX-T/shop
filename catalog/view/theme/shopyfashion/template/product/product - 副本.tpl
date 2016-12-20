<?php echo $header; ?>
<!--商品详情-->
<link rel="stylesheet" href="catalog/view/javascript/jquery/jqzoom/jquery.jqzoom.css" type="text/css" media="screen" />
<script src="catalog/view/javascript/jquery/jqzoom/jquery.jqzoom-core-pack.js" type="text/javascript"></script>
<?php echo $content_top; ?>
<!--页面主体-->
<div class="content widthcenter">
	<h5 class="site">
		<?php foreach ($breadcrumbs as $key=>$breadcrumb) { ?>
	        <a href="<?php echo $breadcrumb['href']; ?>"><?php echo $breadcrumb['text']; ?></a>
	        <?php if(count($breadcrumbs) != $key+1){?>
	        <span>></span>
	        <?php }?>
	    <?php } ?>
	</h5>
	<div class="product-images">
		<div class="big_box">
		<ul>
			<?php foreach ($images as $key=>$image) { ?>
			<li><img src="<?php echo $image['big']; ?>" /></li>
			<?php } ?>
		</ul>
		</div>
        <p class="turnleft prev"></p>
        <div class="thumb_box">
			<ul>
				<?php if ($images) { ?>
		            <?php foreach ($images as $t_key=>$image) { ?>
		           <li><a class="<?php if($t_key == 0){?> zoomThumbActive<?php }?>" id="thumb<?php echo $t_key;?>" href='javascript:void(0);'><img src='<?php echo $image['thumb']; ?>' title="<?php echo $heading_title; ?>" alt="<?php echo $heading_title; ?>"></a></li>
					<?php } ?>
		        <?php } ?>
			</ul>
		</div>
		<p class="turnright"></p>
	    <div class="product-id">
			<span>商品编号：<?php echo $model;?></span>
			
			
			<p class="like <?php echo $is_addwish?'love':'' ?>" onclick="wishlist.add(<?php echo $product_id;?>,this)"></p>
			<p class="share"></p>
			
			<div class="bdsharebuttonbox share " style="opacity:0;filter:alpha(opacity=0)"><a href="#" class="bds_more" data-cmd="more"></a></div>
		<script>window._bd_share_config={"common":{"bdSnsKey":{},"bdText":"<?php echo $heading_title ?>","bdMini":"2","bdMiniList":false,"bdPic":"<?php echo $image['thumb'] ?>","bdStyle":"0","bdSize":"16"},"share":{}};with(document)0[(getElementsByTagName('head')[0]||body).appendChild(createElement('script')).src='http://bdimg.share.baidu.com/static/api/js/share.js?v=89860593.js?cdnversion='+~(-new Date()/36e5)];
		</script>
	
	

		</div>
	</div>
	<script>window._bd_share_config={"common":{"bdSnsKey":{},"bdText":"<?php echo $heading_title ?>","bdMini":"2","bdMiniList":false,"bdPic":"<?php echo $images[0]['thumb'] ?>","bdStyle":"1","bdSize":"16"},"share":{}};with(document)0[(getElementsByTagName('head')[0]||body).appendChild(createElement('script')).src='http://bdimg.share.baidu.com/static/api/js/share.js?v=89860593.js?cdnversion='+~(-new Date()/36e5)];</script>
	<div class="product-right"  id="product">
		<h2><?php echo $heading_title; ?></h2>
		<input type="hidden" name="product_id" value="<?php echo $product_id; ?>" />
		<div class="evaluate">
			<img src="catalog/view/theme/shopyfashion/image/slyc/five-star.png" />
			<img src="catalog/view/theme/shopyfashion/image/slyc/five-star.png" />
			<img src="catalog/view/theme/shopyfashion/image/slyc/five-star.png" />
			<img src="catalog/view/theme/shopyfashion/image/slyc/five-star.png" />
			<span>(<?php echo $rating; ?>)</span>
		</div>
		<!--商品价格=================================================-->
		<p class="money">
			<?php if(isset($special) && $special){ ?>
			<span><?php echo $special; ?></span> &nbsp;&nbsp;<s><?php echo $price; ?> </s><font>（会员优惠）</font>
			<?php }else{ ?>
			<span><?php echo $price; ?></span>
			<?php } ?>
		</p>
		<?php if($product_tariff){?>
		<p class="intariff">进口关税：<span><?php echo $product_tariff;?></span></p>
		<?php }?>
		<div class="product_options">
		<!-- 尺码、颜色分类、数量 -->
        <?php if ($options) { ?>
        <?php foreach ($options as $option) { ?>
        <?php if ($option['type'] == 'select') { ?>
        <!--邮寄方式-->
       <div class="seloption">
		<p class="mailpattern">模式 
		<img src="catalog/view/theme/shopyfashion/image/slyc/left-sanjiao.png" class="left-arr left_sel_option"/> 
		<span class="modename"><?php echo $option['product_option_value'][0]['name'];?></span>
		<img src="catalog/view/theme/shopyfashion/image/slyc/right-sanjiao.png" class="right-arr right_sel_option" /> 
		<font class="modeprice"><?php if ($option['product_option_value'][0]['price']) { ?>(<?php echo $option['product_option_value'][0]['price']; ?>)<?php } ?></font>
		 <select name="option[<?php echo $option['product_option_id']; ?>]" id="input-option<?php echo $option['product_option_id']; ?>" style="display: none;">
            <?php foreach ($option['product_option_value'] as $option_value) { ?>
            <option value="<?php echo $option_value['product_option_value_id']; ?>" tprice="<?php if ($option_value['price']) { ?><?php echo $option_value['price']; ?><?php } ?>"><?php echo $option_value['name']; ?></option>
            <?php } ?>
          </select>
		</p>
        </div>
        <?php } ?>
        <?php if ($option['type'] == 'radio') { ?>
            <!--尺寸选定-->
        <?php if(isset($option['product_option_value']) && $option['product_option_value']):?>
		<div class="options">
			<font></font>（<p class="rule-text"><?php echo $option['product_option_value'][0]['name'];?></p>）
			<div class="chooserule">
				<?php foreach ($option['product_option_value'] as $pkey=>$option_value) { ?>
				<p><?php echo $option_value['name']; ?><input type="radio" name="option[<?php echo $option['product_option_id']; ?>]" <?php if($pkey == 0){?>checked="checked"<?php }?> value="<?php echo $option_value['product_option_value_id']; ?>" style="display: none;"/></p>
				<?php } ?>
			</div>
		</div>
		<?php endif; ?>
        <?php } ?>
        <?php if ($option['type'] == 'checkbox') { ?>
        <div class="form-group<?php echo ($option['required'] ? ' required' : ''); ?> detail_option">
          <label class="control-label"><?php echo $option['name']; ?>：</label>
          <div id="input-option<?php echo $option['product_option_id']; ?>" class="options">
            <?php foreach ($option['product_option_value'] as $option_value) { ?>
            <div class="checkbox">
              <label>
                <input type="checkbox" name="option[<?php echo $option['product_option_id']; ?>][]" value="<?php echo $option_value['product_option_value_id']; ?>" />
                <?php echo $option_value['name']; ?>
                <?php if ($option_value['price']) { ?>
                (<?php echo $option_value['price_prefix']; ?><?php echo $option_value['price']; ?>)
                <?php } ?>
              </label>
            </div>
            <?php } ?>
          </div>
        </div>
        <?php } ?>
        <?php if ($option['type'] == 'image') { ?>
        <!--颜色选定-->
		<div class="options">
			<span></span>（<p class="color-text"><?php echo $option['product_option_value'][0]['name'];?></p>）
			<div class="choosecolor">
					<?php foreach ($option['product_option_value'] as $pkey=>$option_value) { ?>
					<p><?php echo $option_value['name']; ?><input type="radio" name="option[<?php echo $option['product_option_id']; ?>]" <?php if($pkey == 0){?>checked="checked"<?php }?> value="<?php echo $option_value['product_option_value_id']; ?>" style="display: none;"/></p>
					<?php } ?>
			</div>
		</div>
        <?php } ?>
        <?php if ($option['type'] == 'text') { ?>
        <div class="form-group<?php echo ($option['required'] ? ' required' : ''); ?> detail_option">
          <label class="control-label" for="input-option<?php echo $option['product_option_id']; ?>"><?php echo $option['name']; ?>：</label>
          <input type="text" name="option[<?php echo $option['product_option_id']; ?>]" value="<?php echo $option['value']; ?>" placeholder="<?php echo $option['name']; ?>" id="input-option<?php echo $option['product_option_id']; ?>" class="form-control" />
        </div>
        <?php } ?>
        <?php if ($option['type'] == 'textarea') { ?>
        <div class="form-group<?php echo ($option['required'] ? ' required' : ''); ?> detail_option">
          <label class="control-label" for="input-option<?php echo $option['product_option_id']; ?>"><?php echo $option['name']; ?>：</label>
          <textarea name="option[<?php echo $option['product_option_id']; ?>]" rows="5" placeholder="<?php echo $option['name']; ?>" id="input-option<?php echo $option['product_option_id']; ?>" class="form-control"><?php echo $option['value']; ?></textarea>
        </div>
        <?php } ?>
        <?php if ($option['type'] == 'file') { ?>
        <div class="form-group<?php echo ($option['required'] ? ' required' : ''); ?> detail_option">
          <label class="control-label"><?php echo $option['name']; ?>：</label>
          <button type="button" id="button-upload<?php echo $option['product_option_id']; ?>" data-loading-text="<?php echo $text_loading; ?>" class="btn btn-default btn-block"><i class="fa fa-upload"></i> <?php echo $button_upload; ?></button>
          <input type="hidden" name="option[<?php echo $option['product_option_id']; ?>]" value="" id="input-option<?php echo $option['product_option_id']; ?>" />
        </div>
        <?php } ?>
        <?php if ($option['type'] == 'date') { ?>
        <div class="form-group<?php echo ($option['required'] ? ' required' : ''); ?> detail_option">
          <label class="control-label" for="input-option<?php echo $option['product_option_id']; ?>"><?php echo $option['name']; ?>：</label>
          <div class="input-group date">
            <input type="text" name="option[<?php echo $option['product_option_id']; ?>]" value="<?php echo $option['value']; ?>" data-date-format="YYYY-MM-DD" id="input-option<?php echo $option['product_option_id']; ?>" class="form-control" />
            <span class="input-group-btn">
            <button class="btn btn-default" type="button"><i class="fa fa-calendar"></i></button>
            </span></div>
        </div>
        <?php } ?>
        <?php if ($option['type'] == 'datetime') { ?>
        <div class="form-group<?php echo ($option['required'] ? ' required' : ''); ?> detail_option">
          <label class="control-label" for="input-option<?php echo $option['product_option_id']; ?>"><?php echo $option['name']; ?>：</label>
          <div class="input-group datetime">
            <input type="text" name="option[<?php echo $option['product_option_id']; ?>]" value="<?php echo $option['value']; ?>" data-date-format="YYYY-MM-DD HH:mm" id="input-option<?php echo $option['product_option_id']; ?>" class="form-control" />
            <span class="input-group-btn">
            <button type="button" class="btn btn-default"><i class="fa fa-calendar"></i></button>
            </span></div>
        </div>
        <?php } ?>
        <?php if ($option['type'] == 'time') { ?>
        <div class="form-group<?php echo ($option['required'] ? ' required' : ''); ?> detail_option">
          <label class="control-label" for="input-option<?php echo $option['product_option_id']; ?>"><?php echo $option['name']; ?>：</label>
          <div class="input-group time">
            <input type="text" name="option[<?php echo $option['product_option_id']; ?>]" value="<?php echo $option['value']; ?>" data-date-format="HH:mm" id="input-option<?php echo $option['product_option_id']; ?>" class="form-control" />
            <span class="input-group-btn">
            <button type="button" class="btn btn-default"><i class="fa fa-calendar"></i></button>
            </span></div>
        </div>
        <?php } ?>
        <?php } ?>
        <?php } ?>
        </div>
		<!--数量-->
		<p class="product-num">数量<img src="catalog/view/theme/shopyfashion/image/slyc/icon-minus.png" class="minus" /><span><input id="goodsnum" type="text" name="quantity"></span> <img src="catalog/view/theme/shopyfashion/image/slyc/icon-plus.png" class="plus" /> <font id="stocknum">库存(<?php echo $logged?$stocknum:'会员可见' ?>)</font></p>
		<p class="paytype"><span><font><img  src="catalog/view/theme/shopyfashion/image/slyc/tick.png"></font>支付宝</span> <span><font><img  src="catalog/view/theme/shopyfashion/image/slyc/tick.png"></font>财付通</span><span><font><img  src="catalog/view/theme/shopyfashion/image/slyc/tick.png"></font>银联</span></p>
		<p class="safe"><span><img  src="catalog/view/theme/shopyfashion/image/slyc/zan.png"></span> 商品放心挑, 7天无理由放心退</p>
		<div class="buyit" id="button-cart">
			<img src="catalog/view/theme/shopyfashion/image/slyc/Shopping-Bag-2.png" class="shoppingbag-gold" />
			<p class="addcar btn-cart">添加到购物车</p>
		</div>
		<p class="allmoney"><?php echo $money[0] ?>.<sup><?php echo $money[1]; ?></sup></p>
	</div>
</div>
<!--商品详情-->
<div class="commodity-details widthcenter">
	<div class="details-list">
		<ul>
			<li><a href="javascript:void(0);" onclick="javascript:document.getElementById('information').scrollIntoView()" class="goods_info"><span>商品信息</span></a></li>
			<li><a href="javascript:void(0);" onclick="javascript:document.getElementById('description').scrollIntoView()" class="goods_info"><span>商品详情</span></a></li>
			<li><a href="javascript:void(0);" onclick="javascript:document.getElementById('guarantee').scrollIntoView()" class="goods_info"><span>商品保障</span></a></li>
			<li><a href="javascript:void(0);" onclick="javascript:document.getElementById('recviewed').scrollIntoView()" class="goods_info"><span>最近浏览</span></a></li>
		</ul>
		<p class="jionshoppingcar btn-cart"><span></span>加入购物车</p>
		<p class="browse-text">浏览该商品的用户也看过</p>
		<span class="cricle-1"></span><span class="cricle-2"></span><span class="cricle-3"></span>
	</div>
	
	<div class="listmask"></div>
	<div class="commodity-left">
		<div>
		<div id="information" style="position: absolute;top: -50px;"></div>
		<?php if ($attribute_groups) { ?>
		<ul class="commodity-info">
			<?php foreach ($attribute_groups as $attribute_group) { ?>
			<?php foreach ($attribute_group['attribute'] as $attribute) { ?>
			<li>
				<p class="part">
				<label><?php echo $attribute['name']; ?>：</label>
				<span><?php echo $attribute['text']; ?></span>
				</p>
			</li>
			<?php } ?>
			<?php } ?>
		</ul>
		<?php } ?>
		</div>
		<div class="commoditydetail-img" >
			<p id="description" style="position: absolute; top: -70px;width: 0;height: 0;"></p>	
			<h2>商品详情 <span>Product Information</span></h2>
			<?php echo $description; ?>
		</div>
		<div class="commodity-safe">
			<p id="guarantee" style="position: absolute; top: -70px;width: 0;height: 0;"></p>	
			<h2>商品保障 <span>Product Protextion</span></h2>
			<img src="catalog/view/theme/shopyfashion/image/slyc/safeguard.jpg" />
		</div>
	</div>
	<!--用户还看过的商品-->
	<?php echo $column_right; ?>
	<?php echo $content_bottom; ?>
	<div id="recviewed"></div>
</div>
<script type="text/javascript"><!--
$('.btn-cart').on('click', function() {
	$.ajax({
		url: 'index.php?route=checkout/cart/add',
		type: 'post',
		data: $('#product input[type=\'text\'], #product input[type=\'hidden\'], #product input[type=\'radio\']:checked, #product input[type=\'checkbox\']:checked, #product select, #product textarea'),
		dataType: 'json',
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
			}
			if (json['success']) {
				//$('.breadcrumb').after('<div class="alert alert-success">' + json['success'] + '<button type="button" class="close" data-dismiss="alert">&times;</button></div>');
				layer.msg(json['success'], {time : -1 , title: false , shade: false , closeBtn:1});
				$('#cart-total').html(json['total']);
				//$('html, body').animate({ scrollTop: 0 }, 'slow');
				$('#cart_box').load('index.php?route=common/cart/info');
			}
		}
	});
});

$(".goods_info").on('click' , function(){
	$(".goods_info").removeClass('active');
	$(this).addClass('active');
});


$(".choosecolor p,.chooserule p").on('click' , function(){
	$(this).find('input').attr("checked" , "checked");
});
//--></script> 
<script type="text/javascript"><!--
$(function() {
	$(".thumb_box").jCarouselLite({
		btnNext: ".turnright",
		btnPrev: ".turnleft",
		circular : false,
		visible: 4,
		speed: 1000
	});
	var thumbArray = new Array();
	$(".thumb_box ul li").each(function(i){
		thumbArray.push("#"+$(this).children('a').attr('id'));
	});
	$(".thumb_box ul li a").on('click' , function(){
		$(".thumb_box ul li a").removeClass("zoomThumbActive");
		$(this).addClass("zoomThumbActive");
	});
	$(".big_box").jCarouselLite({
		visible: 1,
		btnGo : thumbArray,
		speed: 1000
	});
});
--></script> 
<script type="text/javascript"><!--
/* $(document).ready(function(){
	$('.jqzoom').jqzoom({
		zoomType: 'standard',
        lens:true,
        preloadText: false,
        preloadImages: false,
        alwaysOn:false,
        title:false,
        zoomWidth: 360,
        zoomHeight: 360,
        xOffset:10,
        yOffset:0,
        position:'right'
    });
}); */
--></script> 
<script type="text/javascript">
	//选择默认颜色大小
	var color = $('.choosecolor p').first().attr('name');
	var size = $('.chooserule p').first().attr('name');
	$('#secolor').attr('name','option['+color+']');
	$('#secolor').val($('.choosecolor p').first().attr('id'));
	$('#sesize').attr('name','option['+size+']');
	$('#sesize').val($('.chooserule p').first().attr('id'));
	$('#defaultcolor').html($('.choosecolor p').first().html());
	$('#defaultsize').html($('.chooserule p').first().html());
	//判断有无属性
	if($('choosecolor p').length<=0){
		$('choosecolor').remove();
	}
	if($('.chooserule p').length<=0){
		$('.chooserule').remove();
	}
	//函数入口
	$(function() {
		
		var isshow=false;//定义一个标记
		//选择颜色
		$(".options span").mouseover(function(){
			$(".choosecolor").show();					
		});
		
		$(".choosecolor").mousemove(function(){
			isshow=true;
			$(this).show();
		});
		$(".choosecolor").mouseleave(function(){
			if(isshow){
				setTimeout(function(){
					$(".choosecolor").css("display","none")
				},300);
				isshow=false;
			}
		});
		$(".choosecolor p").click(function(){
			var colorText=$(this).text();
			//颜色值
			var colorval = $(this).attr('id');
			//颜色名
			var colorname = $(this).attr('name');
			$('#secolor').val(colorval);
			$('#secolor').attr('name','option['+colorname+']');
			$(".choosecolor").hide();
			$(".color-text").text(colorText);
		});
		
		//选择尺寸
	$(".options font").mouseover(function(){
		$(".chooserule").show();
	});
	$(".chooserule").mousemove(function(){
		isshow=true;
		$(this).show();
	});
	$(".chooserule").mouseleave(function(){
		if(isshow){
				setTimeout(function(){
					$(".chooserule").css("display","none")
				},300);
				isshow=false;
			}
	});
	$(".chooserule p").click(function(){
			var colorText=$(this).text();
			$('.chooserule p').removeClass('optsize');
			//大小值
			var sizeval = $(this).attr('id');
			//大小name
			var sizename = $(this).attr('name');
			$('#sesize').val(sizeval);
			$('#sesize').attr('name','option['+sizename+']');
			$(this).addClass('optsize');
			$(".chooserule").hide();
			$(".rule-text").text(colorText);
		});
	
	//功能列表滚动到顶部定位
	var listH=$(".details-list").offset().top;
	$(window).scroll(function(){
		var scroH=$(this).scrollTop();
		if(scroH>=listH){
			$(".details-list").css({"position":"fixed","top":"0","z-index":"3","left":"50%","margin-left":"-600px"});
			$(".listmask").css({"width":"100%","height":"50px"})
		}else if(scroH<listH){
			$(".details-list").css({"position":"relative","top":"auto","z-index":"auto","left":"auto","margin-left":"auto"});
			$(".listmask").css("height","0");
		}
	});
	
	$(".left_sel_option").on('click' , function(){
		var obj = $(this).parent().find('select');
		$(this).parent().find('select').children("option").each(function(i){
			if($(this).attr("value") == $(obj).val()){
				if($(this).prev().val()!=undefined){
					$(obj).children("option").removeAttr('selected');
					var name = $(this).prev().html();
					var price = $(this).prev().attr("tprice");
					$(obj).parent().find(".modename").html(name);
					$(obj).parent().find(".modeprice").html(price);
					$(this).prev().attr('selected' , true);
				}
				return false;
			}
		});
	});
	
	$(".right_sel_option").on('click' , function(){
		var obj = $(this).parent().find('select');
		$(obj).children("option").each(function(i){
			if($(this).attr("value") == $(obj).val()){
				if($(this).next().val()!=undefined){
					$(obj).children("option").removeAttr('selected');
					var name = $(this).next().html();
					var price = $(this).next().attr("tprice");
					$(obj).parent().find(".modename").html(name);
					$(obj).parent().find(".modeprice").html(price);
					$(this).next().attr('selected' , true);
				}
				return false;
			}
		});
	});
})

//商品数量
//数量加
$('#goodsnum').val(1);
$('.plus').click(function(){
	var i = $('#goodsnum').val();
	i++;
	$('#goodsnum').val(i);
});

$('.minus').click(function(){
	var a = $('#goodsnum').val();
	a--;
	if(a<=0){
		a=1;
	}
	$('#goodsnum').val(a);
});
	
</script>
<?php echo $footer; ?>