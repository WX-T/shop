<?php echo $header; ?>
<link href="catalog/view/theme/shopyfashion/stylesheet/personalinfor.css" rel="stylesheet" />
    <!--个人资料内容-->
    <div class="personal-inform">
        <ul>
            <li></li>
            <li>
                <span>头像</span><img src="catalog/view/theme/shopyfashion/image/slyc/backgray.png" /><img src="<?php echo $headphoto?'catalog/view/theme/shopyfashion/image/headphoto/'.$headphoto:'catalog/view/theme/shopyfashion/image/slyc/username.png'?>" />
            </li>
            <li><span>用户名称</span><img src="catalog/view/theme/shopyfashion/image/slyc/backgray.png" /><font><?php echo $fullname?></font></li>
            <li><span>密码修改</span><img src="catalog/view/theme/shopyfashion/image/slyc/backgray.png" /></li>
            <li><a href="index.php?route=account/logout"><input type="button" value="退出" /></a></li>
        </ul>
    </div>
    <!--弹出框的蒙版-->
        <div class="mask"></div>
    <!--照片上传选择方式-->
    <div class="upload-style">
        <ul>
            <li>拍照</li>
            <li>从手机相册选择</li>
            <li>取消</li>
        </ul>
    </div>
    <div id="header-img" style="width:350px;height:150px;border:2px solid #666;display:none;position:absolute;top:30%;left:10%;z-index:99999;background:#ddd;text-algin:center;border-radius:3px;line-height:150px;">
        <form style="height:150px;" action="index.php?route=common/wapfilemanager" method="post" enctype="multipart/form-data">
            <span style="font-size:1.5em;display:inline-block;height:150px;">
                <label>上传头像:<input id="headphoto" type="file" name="headphoto" style="width:135px;height:35px;" /></label>
                <input type="submit" onclick="return addHeadphoto(this);" value="上传" style="width:57px;height:35px" /><span style="color:red;font-size:13px;"></span>
            </span>
        </form>
    </div>
    <script src="catalog/view/javascript/jquery/jquery-2.1.1.min.js"></script>
    <script src="catalog/view/javascript/js/fontSize.js"></script>
    <script src="catalog/view/javascript/js/ajaxfileupload.js"></script>
    <script type="text/javascript">
        $('.personal-inform ul li:eq(1)').click(function () {
            $('.mask').show();
            $('.upload-style').animate({"bottom":"0"},500);
        })
        $('.upload-style ul li:eq(2)').click(function () {
            $('.mask').hide();
            $('.upload-style').animate({ "bottom": "-8rem" } ,1000);
        });
        $('.upload-style ul li:eq(1)').click(function () {
        	$('#header-img').css('display','block');
        	$('.mask').hide();
        	$('.upload-style').animate({ "bottom": "-8rem" } ,500);
        });
        function addHeadphoto(obj){
            var headphoto = $('#headphoto').val();
            if(headphoto == ''){
                $(obj).next().html('*请选择图片');
                return false;
            }else {
                return true;
            }
        }
    </script>
    <script type="text/javascript">
  (function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){
  (i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),
  m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)
  })(window,document,'script','https://www.google-analytics.com/analytics.js','ga');

  ga('create', 'UA-81008565-1', 'auto');
  ga('send', 'pageview');

</script>