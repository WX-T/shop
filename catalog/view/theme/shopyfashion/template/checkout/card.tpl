<!--实名备案-->
<?php if(!$cardinfo['cardType']){?>
	<span class="font-text">您还没有实名备案，请先去填写</span><i class="right"></i>
<?php }else{?>
    <h3><?php echo $cardinfo['cardName']?></h3>
	<span><?php echo $cardinfo['cardID']?></span>
	<span class="right"></span>
<?php }?>