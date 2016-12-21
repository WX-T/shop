<?php echo $header; ?>
<style>
.img-thumbnail1 {
    background-color: #ffffff;
    border: 1px solid #dddddd;
    border-radius: 3px;
    display: inline-block;
    height: auto;
    line-height: 1.42857;
    max-width: 100%;
    padding: 4px;
    transition: all 0.2s ease-in-out 0s;
}
</style>
<?php echo $column_left; ?>
<div id="content">
  <div class="page-header">
    <div class="container-fluid">
      <div class="pull-right">
        <button type="submit" form="form-marketing" data-toggle="tooltip" title="<?php echo $button_save; ?>" class="btn btn-primary"><i class="fa fa-save"></i></button>
        <a href="<?php echo $cancel; ?>" data-toggle="tooltip" title="<?php echo $button_cancel; ?>" class="btn btn-default"><i class="fa fa-reply"></i></a></div>
      <h1><?php echo $heading_title; ?></h1>
      <ul class="breadcrumb">
        <?php foreach ($breadcrumbs as $breadcrumb) { ?>
        <li><a href="<?php echo $breadcrumb['href']; ?>"><?php echo $breadcrumb['text']; ?></a></li>
        <?php } ?>
      </ul>
    </div>
  </div>
  <div class="container-fluid">
    <?php if ($error_warning) { ?>
    <div class="alert alert-danger"><i class="fa fa-exclamation-circle"></i> <?php echo $error_warning; ?>
      <button type="button" class="close" data-dismiss="alert">&times;</button>
    </div>
    <?php } ?>
    <div class="panel panel-default">
      <div class="panel-heading">
        <h3 class="panel-title"><i class="fa fa-pencil"></i> <?php echo $text_form; ?></h3>
      </div>
      <div class="panel-body">
        <form action="<?php echo $action; ?>" method="post" enctype="multipart/form-data" id="form-marketing" class="form-horizontal">
          <div class="form-group required">
            <label class="col-sm-2 control-label" for="input-name">商品名</label>
            <div class="col-sm-10">
              <input type="text"  name="name" value="<?php echo $name; ?>" placeholder="<?php echo $entry_name; ?>" id="input-name" class="form-control" />
              <?php if ($error_name) { ?>
              <div class="text-danger"><?php echo $error_name; ?></div>
              <?php } ?>
            </div>
          </div>
          
          <div class="form-group required">
            <label class="col-sm-2 control-label" for="input-name">活动名</label>
            <div class="col-sm-10">
              <input type="text"  name="hot_name" value="<?php echo $hot_name; ?>" placeholder="活动名称" id="input-hot_name" class="form-control" />
            </div>
          </div>
          <div class="form-group">
                <label class="col-sm-2 control-label" for="input-image"><?php echo $entry_image; ?></label>
                <div class="col-sm-10">
                	<div id="uploader-demo" class="wu-example">
                        <!--用来存放item-->
                       <div id="fileList" class="uploader-list"></div>
                        <div id="filePicker">选择图片</div>
                        <div id="WU_FILE_0" class="img-thumbnail1"><img src="<?php echo $thumb; ?>"><div class="info"></div></div>
                        <input id="input-image" name="image" value="<?php echo $image; ?>" type="hidden">
                    </div>
                   <!--  <span id="uploadImg" class="btn btn-success">上传图片</span> -->
                  <!-- <a href="" id="thumb-image" data-toggle="image" class="img-thumbnail"><img src="<?php echo $thumb; ?>" alt="" title="" data-placeholder="<?php echo $placeholder; ?>" /></a>
                  <input type="hidden" name="image" value="<?php echo $image; ?>" id="input-image" /> -->
                </div>
          </div>
          <div class="form-group">
            <label class="col-sm-2 control-label" for="input-description"><?php echo $entry_description; ?></label>
            <div class="col-sm-10">
              <textarea name="desc" placeholder="<?php echo $entry_description; ?>" id="input-description"><?php echo $desc ?></textarea>
            </div>
          </div>
          <input type="hidden" name="product_id" value="<?php echo $product_id;?>">
        </form>
      </div>
    </div>
  </div>
  <p id="token" val="<?php echo $token?>"></p>
  <script type="text/javascript"><!--
  $('#input-description').summernote({height: 300});

//初始化Web Uploader
  uploader = WebUploader.create({
     // 选完文件后，是否自动上传。
      auto: true,
     // 文件接收服务端。
     server: 'index.php?route=common/filemanager/uploadProductImg&token=<?php echo $token?>&product_id=<?php echo $product_id?>',
     // 选择文件的按钮。可选。
     // 内部根据当前运行是创建，可能是input元素，也可能是flash.
     pick: {'id':'#filePicker','multiple':false}, //只能选择一个图片
     // 只允许选择图片文件。
     accept: {
         title: 'Images',
         extensions: 'gif,jpg,jpeg,bmp,png',
         mimeTypes: 'image/*'
     },
     fileSizeLimit : 3000000,	//限制大约3M
 });
   
 //当有文件添加进来的时候
 uploader.on( 'fileQueued', function( file ) {
 	//只能上传一个图片
   if(uploader.getFiles().length >=1){
 	  $(".img-thumbnail1").remove();
 	  //uploader.removeFile(uploader.getFiles())
   }
 	  var $li = $(
               '<div id="' + file.id + '" class="img-thumbnail1">' +
                   '<img>' +
                   '<div class="info">' + file.name + '</div>' +
                   '<p class="list-group-item-warning" style="text-align:center;">等待上传</p>'+
               '</div>'
               ),
           $img = $li.find('img');
       // $list为容器jQuery实例
       $("#uploader-demo").append( $li );
       // 创建缩略图
       // 如果为非图片文件，可以不用调用此方法。
       // thumbnailWidth x thumbnailHeight 为 100 x 100
       uploader.makeThumb( file, function( error, src ) {
           if ( error ) {
               $img.replaceWith('<span>不能预览</span>');
               return;
           }
           $img.attr( 'src', src );
       }, 100, 100 );
 });
 //文件上传过程中创建进度条实时显示。
 uploader.on( 'uploadProgress', function( file, percentage ) {
   var $li = $( '#'+file.id ),
       $percent = $li.find('.progress .progress-bar');
   // 避免重复创建
   if ( !$percent.length ) {
       $percent = $('<div class="progress progress-striped active">' +
         '<div class="progress-bar" role="progressbar" style="width: 0%">' +
         '</div>' +
       '</div>').appendTo( $li ).find('.progress-bar');
   }

   $li.find('p.state').text('上传中');

   $percent.css( 'width', percentage * 100 + '%' );
 });
 // 文件上传成功，给item添加成功class, 用样式标记上传成功。
 uploader.on( 'uploadSuccess', function( file,data ) {
   $( '#'+file.id ).addClass('upload-state-done');
   //判断是否真的上传成功
   if(data.code=='1'){
 	  $("#input-image").remove();
 	  $( '#'+file.id ).find('p').remove();
 	  $( '#'+file.id ).append('<p class="list-group-item-success" style="text-align:center;">上传成功</p>');
 	  $( '#'+file.id).parent().append('<input name="image" value="'+data.success+'" id="input-image" type="hidden">');
   }else{
 	  $( '#'+file.id ).find('p').remove();
 	  $( '#'+file.id ).append('<p class="list-group-item-danger" style="text-align:center;">上传失败</p>');
   }
 });
 // 文件上传失败，显示上传出错。
 uploader.on( 'uploadError', function( file ) {
 	var $li = $( '#'+file.id ),
       $error = $li.find('div.error');

   // 避免重复创建
   if ( !$error.length ) {
       $error = $('<div class="error"> </div>').appendTo( $li );
   }

   $error.text('上传失败');
 });

 // 完成上传完了，成功或者失败，先删除进度条。
 uploader.on( 'uploadComplete', function( file ) {
   $( '#'+file.id ).find('.progress').remove();
 });
//--></script></div>
<?php echo $footer; ?>