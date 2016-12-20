<!DOCTYPE html>
<html>
	<head>
		<meta charset="UTF-8">
		<meta name="viewport" content="width=device-width,initial-scale=1,minimum-scale=1,maximum-scale=1,user-scalable=no" />	
		<title>实名信息备案</title>
		<link rel="stylesheet" type="text/css" href="catalog/view/theme/shopyfashion/stylesheet/shoppingcar.css"/>
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
			<h1>实名信息备案</h1>
		</div>
		<div class="topmask">
		</div>
		<!--实名认证-->
		<div class="realname">
			<p class="name"><span>姓名</span><input type="text" name="" id="cardname" value="<?php echo $message['cardinfo']['cardName']?>" /></p>
			<p class="id-type"><span>证件类型</span>
				<select name="" id="cardtype">
					<?php if($message['cardtype']){?>
                    	<?php for($i=1;$i<=count($message['cardtype']);$i++){?>
                    		<option value="<?php echo $i;?>" <?php if($message['cardinfo']['cardType']==$i){echo 'selected';} ?>><?php echo $message['cardtype'][$i]?></option>
                    	<?php }?>
                	<?php }?>				
				</select>
			</p>
			<p class="idnum"><span>证件号</span><input type="tel" name="" id="cardid" value="<?php echo $message['cardinfo']['cardID'] ?>"maxlength="18" /></p>
			
			<p class="err"></p>
			<p class="save-btn" id="addcard">保存信息</p>
		</div>
		<script src="catalog/view/javascript/jquery/jquery-2.1.1.min.js" type="text/javascript" charset="utf-8"></script>
		<script src="catalog/view/javascript/layer/layer.js" type="text/javascript" charset="utf-8"></script>
   		 <script type="text/javascript">
   		 $(".back").click(function(){
			history.go(-1);
   	   	 });
        //文本框得到焦点改变字体颜色
        $(".add-good-infor li input[type='text'],.real-name li input[type='text']").focus(function () {
            $(this).css('color', '#4d4d4d');
        })
        
        var reg_IdCard = /(^\d{15}$)|(^\d{18}$)|(^\d{17}X$)/;
    
        $("#addcard").on('click' , function(){
        	var cardname = $.trim($("#cardname").val());
        	var cardid = $("#cardid").val();
        	var cardtype = $("#cardtype").val();
        	if(cardname == ''){
        		layer.open({
        		    content: '请输入证件姓名',
        		    style: 'background-color:#fff; color:black; border:none;',
        		    time: 2
        		});
        		return false;
        	}
        	if(cardid == ''){
        		layer.open({
        		    content: '请输入证件号码',
        		    style: 'background-color:#fff; color:black; border:none;',
        		    time: 2
        		});
        		return false;
        	}
        	VdtIdNo(reg_IdCard);
        });
        
        //身份证验证
        function VdtIdNo(reg) {
        var cardname = $.trim($("#cardname").val());
        var cardid = $("#cardid").val();
        var cardtype = $("#cardtype").val();
        if($("#cardtype").val()=="1"){
            var success = Zz(reg);
            if (success) {
                	$.ajax({
                		url: 'index.php?route=checkout/shipping_address/checkcardid',
                		type: 'post',
                		async: false,
                		dataType: 'json',
                		data:{cardid : cardid},
                		success:function(json){
                			if(json['error']){
                				layer.open({
                	    		    content: json['error'],
                	    		    style: 'background-color:#fff; color:black; border:none;',
                	    		    time: 2
                	    		});
                				return false;
                			}else{
                				$.ajax({
                					url: 'index.php?route=checkout/shipping_address/addusercardinfo',
                					type: 'post',
                					async: false,
                					dataType: 'json',
                					data:{cardid : cardid , cardname : cardname , cardtype : cardtype},
                					success:function(json){
                						if(json['error']){
                							layer.open({
                            	    		    content: json['error'],
                            	    		    style: 'background-color:#fff; color:black; border:none;',
                            	    		    time: 2
                            	    		});
                							return false;
                						}else{
                							check_card_info = true;
                							history.go(-1);
                						}
                					}
                				});
                			}
                			
                		}
                	}); 
                }else {
                	layer.open({
    	    		    content: '请输入正确的证件号码',
    	    		    style: 'background-color:#fff; color:black; border:none;',
    	    		    time: 2
    	    		});
                	return false;
                }
            }else{
            	layer.open({
        		    content: '请输入正确的证件号码',
        		    style: 'background-color:#fff; color:black; border:none;',
        		    time: 2
        		});
            	return false;
            }
        }
    
        // [ 0.执行正则表达式  ]
        function Zz(reg) {
            return null != $("#cardid").val().match(reg);
        }

    </script>
    
    </body>
    </html>
