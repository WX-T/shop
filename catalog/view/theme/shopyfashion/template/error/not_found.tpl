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
<div class="content">
  <div class="panel-align show-goods">
  <?php echo $column_left; ?>
    <div id="content" class="<?php echo $class; ?>"><?php echo $content_top; ?>
      <p class="text-error"><?php echo $text_error; ?></p>
      <div class="text-continue"><a href="<?php echo $continue; ?>" class="btn-continue"><?php echo $button_continue; ?></a></div>
      <?php echo $content_bottom; ?></div>
    <?php echo $column_right; ?>
    </div>
  </div>
<?php echo $footer; ?>