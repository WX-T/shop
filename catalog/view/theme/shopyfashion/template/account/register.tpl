<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <link href="catalog/view/theme/shopyfashion/stylesheet/register.css" rel="stylesheet">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0, user-scalable=0,minimal-ui" />
    <<link href="catalog/view/theme/shopyfashion/stylesheet/babyheader.css" rel="stylesheet">
    <title>注册</title>
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
    <!--头部-->
    <div class="top">
        <!--搜索-->
        <div class="back">
            <img src="catalog/view/theme/shopyfashion/image/slyc/back.png" />
            <input type="text" />
        </div>
        <h1>注册</h1>
    </div>
    <!--头部蒙版-->
    <div class="occupied"></div>
    <!--输入信息-->
    <div class="information">
        <ul>
        	<form action="<?php echo $action?>" method="post" id="resform">
                <li><input id="fullname" name="fullname" type="text" placeholder="用户名" /></li>
                <li><input id="email" name="email" type="text" placeholder="邮箱" /></li>
                <!-- <li><input type="text" placeholder="请输入验证码" /><input type="button" value="获取验证码" /></li> -->
                <li><input id="password" name="password" type="password" placeholder="6-16位字母和数字的密码" /><input type="button" value="显示" class="show-pwd" /></li>
                <li><input id="confirm" name="confirm" type="password" placeholder="重复密码" /></li>
                <!-- 注册协议 -->
                <input type="checkbox" value="1" name="agree" checked style="display:none">
                <li><input id="submitfrom" type="button" value="注册" /></li>
                 <?php if ($redirect) { ?>
                  <input type="hidden" name="redirect" value="<?php echo $redirect; ?>" />
                <?php } ?>
            </form>
        </ul>
    </div>
        
    <!--合作账号登录-->
    <div class="join-login">
        <p>
            <img src="catalog/view/theme/shopyfashion/image/slyc/logintitle.png" />
        </p>
        <ul>
            <li><img src="catalog/view/theme/shopyfashion/image/slyc/QQ.png" /></li>
            <li><img src="catalog/view/theme/shopyfashion/image/slyc/weixin.png" /></li>
            <li><img src="catalog/view/theme/shopyfashion/image/slyc/weibo.png" /></li>
        </ul>
    </div>
    
    <script src="catalog/view/javascript/layer/layer.js" type="text/javascript" charset="utf-8"></script>
    <script src="catalog/view/javascript/jquery/jquery-2.1.1.min.js" type="text/javascript" charset="utf-8"></script>
  	<script src="catalog/view/javascript/js/fontSize.js" type="text/javascript" charset="utf-8"></script>
    	<?php if($error_email): ?>
        <script>layer.open({
    	    content: '<?php echo $error_email?>',
    	    style: 'background-color:#fff; color:black; border:none;',
    	    time: 2
    	});</script>
        <?php elseif($error_warning): ?>
            <script>layer.open({
        	    content: '<?php echo $error_warning?>',
        	    style: 'background-color:#fff; color:black; border:none;',
        	    time: 2
        	});</script>
        <?php elseif($error_fullname): ?>
            <script>layer.open({
        	    content: '<?php echo $error_fullname?>',
        	    style: 'background-color:#fff; color:black; border:none;',
        	    time: 2
        	});</script>
        <?php elseif($error_password): ?>
            <script>layer.open({
        	    content: '<?php echo $error_password?>',
        	    style: 'background-color:#fff; color:black; border:none;',
        	    time: 2
        	});</script>
        <?php endif; ?>
    <script type="text/javascript">

    	$(".back").click(function(){
			history.go(-1);
        });
        //得到焦点字体颜色改变
        $(".information li input[type='text'],.information li input[type='password']").focus(function () {
            $(this).css('color', '#f8c87b');
        })
        //显示密码
        $(".show-pwd").click(function () {
            if ($(this).val() == '显示') {
                $(this).siblings().attr("type", "text");
                $(this).val('隐藏');
            }
            else {
                $(this).siblings().attr("type", "password");
                $(this).val('显示');
            }
        });

        //验证
        var $name=$("#fullname");
        var $password=$("#password");
        var $surepwd= $("#confirm");
        var $email= $("#email");
        $('#submitfrom').click(function(){
    		var check = true;
    		var reg = /^[\w\-\.]+@[\w\-\.]+(\.\w+)+$/;
            if($name.val().length<=0){
            	layer.open({
            	    content: '请填写用户名',
            	    style: 'background-color:#fff; color:black; border:none;',
            	    time: 2
            	});
                check = false;
            }else if($password.val().length<=0){
            	layer.open({
            	    content: '请输入密码',
            	    style: 'background-color:#fff; color:black; border:none;',
            	    time: 2
            	});
                check = false;
            }else if($surepwd.val().length<=0){
            	 layer.open({
            	    content: '请填确认密码',
            	    style: 'background-color:#fff; color:black; border:none;',
            	    time: 2
            	 });
                 check = false;
            }else if($email.val().length<=0){
            	layer.open({
            	    content: '请输入邮箱',
            	    style: 'background-color:#fff; color:black; border:none;',
            	    time: 2
            	});
                check = false;
            }
            if(!reg.test($email.val())){
            	layer.open({
            	    content: '邮箱格式不正确',
            	    style: 'background-color:#fff; color:black; border:none;',
            	    time: 2
            	});
                check = false;
            }
            if($.trim($name.val()).length<2||$.trim($name.val()).length>20){
            	layer.open({
            	    content: '用户名,2-20个字符,支持字母/中文/数字/下划线',
            	    style: 'background-color:#fff; color:black; border:none;',
            	    time: 2
            	});
                check = false;
            }
            if($.trim($password.val()).length>20||$.trim($password.val()).length<6){
            	layer.open({
            	    content: '密码范围在6到20位之间',
            	    style: 'background-color:#fff; color:black; border:none;',
            	    time: 2
            	});
                check = false;
            }
            if($.trim($surepwd.val()).length>20||$.trim($surepwd.val()).length<6){
            	layer.open({
            	    content: '确认密码范围在6到20位之间',
            	    style: 'background-color:#fff; color:black; border:none;',
            	    time: 2
            	});
                check = false;
            }else if($.trim($password.val())!=$.trim($surepwd.val())){
            	layer.open({
            	    content: '两次密码不一致',
            	    style: 'background-color:#fff; color:black; border:none;',
            	    time: 2
            	});
                check = false;
            }
            if($.trim($email.val())==""||$.trim($email.val())==null||typeof($email.val())==undefined){
            //  alert(21)
            	layer.open({
            	    content: '请输入邮箱',
            	    style: 'background-color:#fff; color:black; border:none;',
            	    time: 2
            	});
                stamp = false;
            }else if(!reg.test($email.val())){
            	layer.open({
            	    content: '邮箱格式不正确',
            	    style: 'background-color:#fff; color:black; border:none;',
            	    time: 2
            	});
                stamp = false;
            }
            if(check){
                $('#resform').submit();
            }
        });
    </script>
</body>
</html>
