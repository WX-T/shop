<!DOCTYPE html>
<html>
	<head>
		<meta charset="UTF-8">
		<meta name="viewport" content="width=device-width,initial-scale=1,minimum-scale=1,maximum-scale=1,user-scalable=no" />
		<title>添加订单</title>
    	<link href="catalog/view/theme/shopyfashion/stylesheet/addorder.css" rel="stylesheet" />
    	<script src="catalog/view/javascript/jquery/jquery-2.1.1.min.js" type="text/javascript" charset="utf-8"></script>

	</head>
	<body>
<script type="text/javascript">
  (function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){
  (i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),
  m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)
  })(window,document,'script','https://www.google-analytics.com/analytics.js','ga');

  ga('create', 'UA-81008565-1', 'auto');
  ga('send', 'pageview');
</script>
		<ul>
			<li>姓名<input name="name" value="" /></li>
			<li>号码<input name="phone" value="" /></li>
			<li>详细地址<input name="address" value="" /></li>
			<li>邮编<input name="postcode" value="" /></li>
			<li>选择地址 <select name="city_id" id="city_id"></select><select name="area_id" id="area_id"></select></li>
			<li>总价<input name="total" value="" /></li>
			
		</ul>
		<script>
    		
           getzoneinfo(44 , '' , '');

            $(document).on('change',"#city_id",function(){
            	var cityid  = $(this).val();
            	var codeId = $("#city_id").children('option:selected').attr('codeid');
            	$("#postcode").val(codeId);
            	getcityinfo(cityid , '');
            })
            
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
		</script>
	</body>
</html>