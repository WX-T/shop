<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0, user-scalable=0,minimal-ui" />
	<script src="catalog/view/javascript/jquery/jquery-2.1.1.min.js" type="text/javascript" charset="utf-8"></script>
    <script src="catalog/view/javascript/layer/layer.js" type="text/javascript" charset="utf-8"></script>
    <link href="catalog/view/theme/shopyfashion/stylesheet/shoppingcar.css" rel="stylesheet">
    <title><?php echo $heading_title?></title>
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
            <img src="catalog/view/theme/shopyfashion/image/back.png" />
            
        </div>
        <h1><?php echo $heading_title?></h1>
    </div>
    <div class="topmask">
		</div>
    <!--头部蒙版-->
    <div class="occupied"></div>

<!--新增收获信息-->
    <div class="your-address">
        <ul>
        <form  action="<?php echo $action; ?>" method="post" enctype="multipart/form-data" class="form-horizontal">
            <li></li>
            <?php if($error_address){?>
            	<script>
            	layer.open({
            	    content: '<?php echo $error_address?>',
            	    style: 'background-color:#fff; color:black; border:none;',
            	    time: 2
            	});
            	</script>
            <?php }elseif($error_shipping_telephone){?>
            	<script>
            	layer.open({
            	    content: '<?php echo $error_shipping_telephone?>',
            	    style: 'background-color:#fff; color:black; border:none;',
            	    time: 2
            	});
            	</script>
            <?php }?>
            <li><p class="name"><input type="text" name="fullname" placeholder="收货人" value="<?php echo $fullname;?>"/></p></li>
            <li><p class="phonenum"><input type="text" name="shipping_telephone" maxlength="11" placeholder="手机号" value="<?php echo $shipping_telephone;?>"/></p></li>
            <li class="receivegoods-address"><p class="choose-address"><span>收货地址</span>
                    <select style="display: none;" class="form-control" id="country_id" name="country_id">
                        <option selected="selected" value="44">China(中国)</option>
                    </select>
                	<select name="zone_id" id="zone_id">
                	</select>
                	<select name="city_id" id="city_id"><option selected="selected">--请选择--</option></select>
                	<!--<select name="area_id" id="area_id"><option selected="selected">--请选择--</option></select>-->
            	</p>
            </li>
            <li><p class="postcode"><input name="postcode" id="postcode" type="text" placeholder="邮政编码" value="<?php echo $postcode?>" /></p></li>
            <li><p class="write-address"><input name="address" type="text" placeholder="详细地址" value="<?php echo $address?>" /></p></li>
   		  <div class="compile-address">
            <li><p class="default"><span><em><i></i><input type="radio" id="default" name="default" value="1" /></em></span><em>设置默认收货地址</em></p></li>
      	    <?php if(!empty($fullname)){?>
           		 <div class="button">
            		<li><input id="backs" class="cancel" type="reset" value="取消" /><input id="subform" class="save" type="button" value="保存" /><input id="del" class="save" type="reset" value="删除" /></li>
           		 </div>
            <?php }else{?>
            	<div class="button">
           			 <li><input id="subform" class="sure-btn" type="button" value="确认收货人信息" /></li>
          		</div>
            <?php }?>
          </div>
        </form>
        </ul>
    </div>
    <div>
    </div>
    <script type="text/javascript">
    <?php if(isset($address_id)){ ?>
        var address_id = "<?php echo $address_id ?>";
    	$.ajax({
    		url: 'index.php?route=account/address/getEditAddressData&address_id=' + address_id,
    		dataType: 'json',
    		success: function(json) {
    			getzoneinfo(json.zone_id , json.city_id , json.area_id);
    			$("#area_id option[value='"+json.area_id+"']").attr("selected",true);
    			$("#modifyaddress_title").html('修改收货信息');
    			$("#modify_address_id").val(address_id);
    			$("#fullname").val(json.fullname);
    			$("#shipping_telephone").val(json.shipping_telephone);
    			$("#postcode").val(json.postcode);
    			$("#country_id").val(json.country_id);
    			$("#zone_id").val(json.zone_id);
    			$("#city").val(json.city_id);
    			$("#address").val(json.address);
    			//javascript:document.getElementById('address-add').scrollIntoView();
    		}
    	});
	 <?php }?>  
        //是否设置为默认地址
       	/*  $(".your-address ul li:eq(6)").click(function () {
            $(".your-address ul li:eq(6) em").toggleClass("backchange");
            
        }) */
        
        //文本框获取焦点
        //$(".your-address ul li [type='text']").focus(function () {
        //    $(this).val("");
        //})
		
		
		$("#subform").click(function(){
			$("form").submit();
		});
		$("#backs").click(function(){
			history.go(-1);
		});

		//删除地址
		$("#del").click(function(){

			layer.open({
                content: '确定删除该地址吗？',
                btn: ['确认', '取消'],
                shadeClose: false,
                yes: function(){
                	$.ajax({
        	    		url: 'index.php?route=account/address/delete&address_id=' + address_id,
        	    		dataType: 'json',
        	    		success: function(json) {
							if(json==1){
								layer.open({
								    content: '删除成功',
								    time: 2
								});
								location = 'index.php?route=account/address';
							}else{
								layer.open({
								    content: '删除失败',
								    time: 2
								});
							}
            	    	}
        	    	});
                }, no: function(){
                	layer.closeAll();
                }
            });
		});
		$('.your-address select[name=\'country_id\']').on('change', function() {
        	$.ajax({
        		url: 'index.php?route=checkout/checkout/country&country_id=' + this.value,
        		dataType: 'json',
        		beforeSend: function() {
        			$('#collapse-shipping-address select[name=\'country_id\']').after(' <i class="fa fa-circle-o-notch fa-spin"></i>');
        		},
        		complete: function() {
        			$('.fa-spin').remove();
        		},
        		success: function(json) {
        			$('.fa-spin').remove();
        			html = '<option value=""><?php echo $text_select; ?></option>';
        
        			if (json['zone'] != '') {
        				for (i = 0; i < json['zone'].length; i++) {
        					html += '<option value="' + json['zone'][i]['zone_id'] + '"';
        
        					if (json['zone'][i]['zone_id'] == '<?php echo $zone_id; ?>') {
        						html += ' selected="selected"';
        					}
        
        					html += '>' + json['zone'][i]['name'] + '</option>';
        				}
        			} else {
        				html += '<option value="0" selected="selected"><?php echo $text_none; ?></option>';
        			}
        
        			$('.your-address select[name=\'zone_id\']').html(html);
        		},
        		error: function(xhr, ajaxOptions, thrownError) {
        			alert(thrownError + "\r\n" + xhr.statusText + "\r\n" + xhr.responseText);
        		}
        	});
        });

		$('.your-address select[name=\'country_id\']').trigger('change');
				
		//地址联动
        $(document).on('change' , "#zone_id" , function(){
        	var province = $(this).val();
        	getzoneinfo(province , '' , '');
        });
        
        $(document).on('change',"#city_id",function(){
        	var cityid  = $(this).val();
        	var codeId = $("#city_id").children('option:selected').attr('codeid');
        	$("#postcode").val(codeId);
        	getcityinfo(cityid , '');
        })
        
//         //复选框选中与取消
//     	$(".choose input[type='checkbox']").click(function(){
//     		if($(this).is(":checked")){
    			
//     		}else{
//     			$('#default').parent().css({"background":"url(image/catalog/slyceck.png) no-repeat","background-size":"100% 100%"});
//     		}
//     	})
    	
    	$(document).ready(function(){
    		$('#default').parent().css({"background":"url(catalog/view/theme/shopyfashion/image/check.png) no-repeat","background-size":"100% 100%"});
        });
        //获取城市地域信息
        function getzoneinfo(zone_id , city_id , area_id){
        	$.ajax({
        		url: 'index.php?route=checkout/shipping_address/zoomeinfo',
        		type: 'post',
        		data: 'zoome_id=' + zone_id,
        		dataType: 'json',
        		success: function(json) {
        			$('#city_id').empty();
        			for(var i=0;i<json.length;i++){
        				if(json[i]['zone_id'] == city_id){
        					$("#city_id").append("<option codeid='"+json[i]['code']+"' value='"+json[i]['zone_id']+"' selected='selected'>"+json[i]['name']+"</option>");
        				}else{
        					$("#city_id").append("<option codeid='"+json[i]['code']+"' value='"+json[i]['zone_id']+"'>"+json[i]['name']+"</option>");
        				}
        			}
        			if(city_id){
        				//getcityinfo(city_id ,area_id);
        			}else{
        				$("#city_id").trigger('change');
        			}
        		}
        	});
        }
        
        //获取区县
        function getcityinfo(city_id ,area_id){
        	$.ajax({
        		url: 'index.php?route=checkout/shipping_address/zoomeinfo',
        		type: 'post',
        		data: 'zoome_id=' + city_id,
        		dataType: 'json',
        		success: function(data) {
        			$('#area_id').empty();
        			for(var i=0;i<data.length;i++){
        				if(data[i]['zone_id'] == area_id){
        					$("#area_id").append("<option value='"+data[i]['zone_id']+"' selected='selected'>"+data[i]['name']+"</option>");
        				}else{
        					$("#area_id").append("<option value='"+data[i]['zone_id']+"'>"+data[i]['name']+"</option>");
        				}
        			}
        		}
        	});
        
        }

        //function get
		$("#back").click(function(){
    		history.go(-1);
        });
    
		
    </script>
</body>
</html>