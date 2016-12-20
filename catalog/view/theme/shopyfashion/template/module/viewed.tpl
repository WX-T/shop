<?php if (count($products) > 0) { ?>
<div class="lately-browse widthcenter">
	<p id="recviewed" style="position: absolute; top: -70px;width: 0;height: 0;"></p>	
	<h2>最近浏览 <span>Recently Viewed</span></h2>
	<div class="up-down">
		<p class="arr-up" id="arr-up1"></p>
		<p class="arr-down" id="arr-down1"></p>
	</div>
	<div class="browse-box">
		 <ul>
		 <?php foreach ($products as $product): ?>
		<li class="browse">
			<a href="<?php echo $product['href']; ?>"><img src="<?php echo $product['thumb']; ?>" /></a>
			<p class="price"><a href="<?php echo $product['href']; ?>"><?php echo $product['special'] ? $product['special'] : $product['price']; ?></a></p>
		</li>
		<?php endforeach;?>
		</ul>
	</div>
</div>
	
<script type="text/javascript"><!--
 $(function() {
 	$(".browse-box").jCarouselLite({
 	btnNext: "#arr-up1",
 	btnPrev: "#arr-down1",
 	circular : false,
 	auto:3000,
 	speed:1000,
 	visible:13,
 	scroll:4,
 	onMouse:true,
 	easing: "easeOutBack"
 	});
 });
 --></script> 
 <script type="text/javascript">
  (function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){
  (i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),
  m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)
  })(window,document,'script','https://www.google-analytics.com/analytics.js','ga');

  ga('create', 'UA-81008565-1', 'auto');
  ga('send', 'pageview');

</script>		
<?php } ?>
