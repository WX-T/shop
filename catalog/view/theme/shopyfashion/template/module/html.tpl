<?php if($heading_title =='首页动态新闻'): ?>
<p class="slogan"><?php echo $html ?></p>
<script>
	left();
	var run = setInterval("left()",30);
	var i =900;
	function left(){
		i-=2;
		$('#indexhtml').scrollLeft(1500-i);
		if(i<=0){
			i=1500;
		}
	}
	
	$('#indexhtml').hover(
	  function () {
	    clearInterval(run);
	  },
	  function () {
	    run = setInterval("left()",30);
	  }
	);
</script>
<?php else:?>
<?php echo $html; ?>
<?php endif; ?>
