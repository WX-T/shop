<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <link href="catalog/view/theme/shopyfashion/stylesheet/register.css" rel="stylesheet" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0, user-scalable=0,minimal-ui" />
    <link href="catalog/view/theme/shopyfashion/stylesheet/babyheader.css" rel="stylesheet" />
    <title>登录</title>
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
        <!--返回-->
        <div class="back">
            <a href="index.php?route=common/waphome"><img src="catalog/view/theme/shopyfashion/image/slyc/closeone.png" /></a>
        </div>
    </div>
    <!--头部蒙版-->
    <div class="occupied"></div>
    <!--页面logo-->
    <div class="logo">
        <img src="catalog/view/theme/shopyfashion/image/slyc/mainlogo.png" />
    </div>
    <!--输入用户名和密码-->
    <div class="login">
    <form action="index.php?route=account/waplogin" id="loginForm" method='post'>
        <div class="input-message">
            <ul>
                <li>
                    <img src="catalog/view/theme/shopyfashion/image/slyc/userid.png" />
                    <input type="text" id="email" name="email" placeholder="用户名" />
                    <img src="catalog/view/theme/shopyfashion/image/slyc/closetwo.png" class="clear-infor"/>
                </li>
                <li>
                    <img src="catalog/view/theme/shopyfashion/image/slyc/pwd.png" />
                    <input type=password id="pwd" name="password" placeholder="密码" />
                    <img src="catalog/view/theme/shopyfashion/image/slyc/closetwo.png" class="clear-infor" />
                </li>
                <li class="forget-pwd">忘记密码？</li>
                <li id="login-bt"><p id="submit">登录</p></li>
                <li><input id="register" type="button" value="注册" /></li>
            </ul>
            <?php if ($redirect) { ?>
              <input type="hidden" name="redirect" value="<?php echo $redirect; ?>" />
            <?php } ?>
        </div>
      </form>
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
        
    </div>
    <!--找回密码-->
    <div class="find-pwd">
        <input type="button" value="找回密码" />
        <input type="button" value="取消" />

    </div>
    <script src="catalog/view/javascript/jquery/jquery-2.1.1.min.js" type="text/javascript" charset="utf-8"></script>
    <script src="catalog/view/javascript/layer/layer.js" type="text/javascript" charset="utf-8"></script>
    <script src="catalog/view/javascript/js/fontSize.js" type="text/javascript" charset="utf-8"></script>
    <?php if($error_warning){?>
    	<script type="text/javascript">
        	layer.open({
        	    content: '<?php echo isset($error_warning['login'])?$error_warning['login']:$error_warning['over']?>',
        	    btn: ['OK']
        	});
    	</script>
    <?php }?>
    <script type="text/javascript">
    $("#register").click(function(){
    	location.href = "index.php?route=account/register";
    });
	var stampemail = false;
	var stamppwd = false;
		//提交表单
		$("#submit").click(function (){
			if($("#email").val().length < 3){
				stampemail = false;
			}else{
				stampemail = true;
			}

			if($("#pwd").val().length<3){
				stamppwd = false;
			}else{
				stamppwd = true;
			}

			if(!stampemail){
				layer.open({
				    content: '账号不能少于3位',
				    time: 2 //2秒后自动关闭
				});
			}else if(!stamppwd){
				layer.open({
				    content: '密码不能少于3位',
				    time: 2 //2秒后自动关闭
				});
			}else{
				$("#loginForm").submit();
			}
		
		});

		/* //登录
		function login(){
			var email = $("#email").val();
			var pwd = $("#pwd").val();
			$.ajax({
				url: 'index.php?index.php?route=account/waplogin',
				type: 'post',
				data:{'email':email,'password':pwd} ,
				dataType: 'json',
				success: function(json) {
					alert(json)
				}
			});
		} */
    	
        //文本框得到焦点字体颜色
        $(".input-message li input[type='text']").focus(function () {
            $(this).css('color', '#f8c87b');
        })
        //文本框失去焦点字体颜色
        //$(".input-message li input[type='text']").blur(function () {
        //    $(this).css('color', '#7c643e');
        //})
        //清空文本框
        $('.clear-infor').click(function () {
            $(this).siblings("input").val("");
            $(this).siblings("input").focus();
        })
        //忘记密码
        $('.forget-pwd').click(function () {
            $('.join-login ul').css("display", "none");
            $('.login,.top,.logo').css({ opacity: 0.5 });
            $('.find-pwd').fadeIn('slow');
        })
        //取消
        $('.find-pwd input:last').click(function () {
            $('.login,.top,.logo').css({ opacity: 1 });
            $('.find-pwd').hide();
            $('.join-login ul').css("display", "block");
        })
    </script>
</body>
</html>


