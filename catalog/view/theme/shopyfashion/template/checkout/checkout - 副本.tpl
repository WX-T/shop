<?php echo $header; ?>
<div class="nav">
<div class="map-nav">
		<div class="panel-align">
	    <?php foreach ($breadcrumbs as $key=>$breadcrumb) { ?>
			        <a href="<?php echo $breadcrumb['href']; ?>"><?php echo $breadcrumb['text']; ?></a>
			        <?php if(count($breadcrumbs) != $key+1){?>
			        <span>></span>
			        <?php }?>
	    <?php } ?>
	    </div>
	</div>
</div>
<?php echo $column_left; ?>
<!-- 内容 -->
<div class="content">
	<div class="panel-align tally">
		<!-- 配送地址 -->
        <div class="title-grey">配送地址<span class="fr"><a href="javascript:void(0);" id="add_new_address" class="blue pdr20">添加新地址 》</a></span></div>
        <div class="shipping_address" id="collapse-shipping-address">
    	</div>
    	
    	<!-- 配送方式 -->
        <div class="title-grey">配送方式</div>
        <div class="shipping_method" id="shipping-method-mode">
    	</div>
    	
    	<!-- 支付方式 -->
        <div class="title-grey">支付方式</div>
        <div class="payment_method" id="payment-mode">
    	</div>
    	
    	<!-- 商品清单 -->
        <div class="title-grey">商品清单</div>
        <div class="confirm" id="order-confirm"></div>
	</div>
</div>


<script type="text/javascript"><!--

$(document).ready(function() {
    
    //配送地址
    <?php if ($shipping_required) { ?>
    $.ajax({
        url: 'index.php?route=checkout/shipping_address',
        dataType: 'html',
        async: false,
        success: function(html) {
            $('.shipping_address').html(html);
            shippingAddressSave();
        },
        error: function(xhr, ajaxOptions, thrownError) {
            alert(thrownError + "\r\n" + xhr.statusText + "\r\n" + xhr.responseText);
        }
    });
    <?php } else { ?>
    $.ajax({
        url: 'index.php?route=checkout/payment_method',
        dataType: 'html',
        async: false,
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

function shippingMethod(){
	//配送方式
    $.ajax({
        url: 'index.php?route=checkout/shipping_method',
        dataType: 'html',
        async: false,
        success: function(html) {
            $('.shipping_method').html(html);
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
        async: false,
        success: function(html) {
            $('.payment_method').html(html);
            paymentMethodSave();
        },
        error: function(xhr, ajaxOptions, thrownError) {
            alert(thrownError + "\r\n" + xhr.statusText + "\r\n" + xhr.responseText);
        }
    }); 
    //支付方式end
}

$(document).on('change' , 'input[name=\'address_id\']', function() {
	shippingAddressSave();
	$.ajax({
        url: 'index.php?route=checkout/shipping_method',
        dataType: 'html',
        async: false,
        success: function(html) {
            $('.shipping_method').html(html);
            shippingMethodSave();
        },
        error: function(xhr, ajaxOptions, thrownError) {
            alert(thrownError + "\r\n" + xhr.statusText + "\r\n" + xhr.responseText);
        }
    }); 
});

$(document).on('change', 'input[name=\'shipping_method\']', function() {
	shippingMethodSave();
	paymentMethodSave();
});

$(document).on('blur', '#comment', function() {
	shippingMethodSave();
});

$(document).on('change', 'input[name=\'payment_method\']', function() {
	paymentMethodSave();
});




var lay_address = '';
$(document).on('click', '#add_new_address', function() {
	lay_address = layer.open({
	    type: 1,
	    title: "添加新地址",
	    area: ['720px', '600px'],
	    shadeClose: true,
	    content: $('#shipping-new')
	});
});

$(document).on('click', '#button-add-shipping-address', function() {
	$("#address_add_new").attr("checked" , "checked");
	shippingAddressSave();
});


//保存配送地址
function shippingAddressSave(){
	$.ajax({
        url: 'index.php?route=checkout/shipping_address/save',
        type: 'post',
        data: $('#collapse-shipping-address input[type=\'text\'], #collapse-shipping-address input[type=\'date\'], #collapse-shipping-address input[type=\'datetime-local\'], #collapse-shipping-address input[type=\'time\'], #collapse-shipping-address input[type=\'password\'], #collapse-shipping-address input[type=\'checkbox\']:checked, #collapse-shipping-address input[type=\'radio\']:checked, #collapse-shipping-address textarea, #collapse-shipping-address select'),
        dataType: 'json',
        async: false,
        success: function(json) {
           $('.alert, .text-danger').remove();
            if (json['error']) {
                if (json['error']['warning']) {
                    $('.shipping_address').prepend('<div class="alert alert-warning">' + json['error']['warning'] + '<button type="button" class="close" data-dismiss="alert">&times;</button></div>');
                }
  								
				for (i in json['error']) {
					var element = $('#input-shipping-' + i.replace('_', '-'));
					
					if ($(element).parent().hasClass('input-group')) {
						$(element).parent().after('<div class="text-danger">' + json['error'][i] + '</div>');
					} else {
						$(element).after('<div class="text-danger">' + json['error'][i] + '</div>');
					}
				}
								
				// Highlight any found errors
				$('.text-danger').parent().parent().addClass('has-error');				
            }else{
            	closeLayer();
            	$.ajax({
                    url: 'index.php?route=checkout/shipping_address',
                    dataType: 'html',
                    async: false,
                    success: function(html) {
                    	layer.close(lay_address);
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
        	closeLayer();
            alert(thrownError + "\r\n" + xhr.statusText + "\r\n" + xhr.responseText);
        }
    }); 
}
//保存配送方式
function shippingMethodSave(){
	$.ajax({
        url: 'index.php?route=checkout/shipping_method/save',
        type: 'post',
        data: $('#shipping-method-mode input[type=\'radio\']:checked, #shipping-method-mode input[name=\'comment\']'),
        dataType: 'json',
        async: false,
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

function paymentMethodSave(){
	$.ajax({
        url: 'index.php?route=checkout/payment_method/save', 
        type: 'post',
        data: $('#payment-mode input[type=\'radio\']:checked, #collapse-payment-method input[type=\'checkbox\']:checked, #collapse-payment-method textarea'),
        dataType: 'json',
        async: false,
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
                        $('#order-confirm').html(html);
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

function closeLayer(){
	layer.closeAll();
}
//--></script> 
<script type="text/javascript"><!--
$(document).on('click' , '#alipay_submit' ,function(){
	layer.closeAll();
	layer.open({
	    type: 1,
	    title: false,
	    closeBtn: false,
	    skin: 'waiting-class',
	    area: ["902px", "478px"],
	    content: $('#alipay_waitpay_box')
	});
	$("#alipaysubmit").submit();
});

//--></script>
<?php echo $footer; ?>