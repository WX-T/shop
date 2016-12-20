<div class="panel panel-default">
  <div class="panel-body" style="text-align: <?php echo $align; ?>;"><span id="AmazonCheckoutWidgetModule<?php echo $module; ?>"></span></div>
</div>
<script type="text/javascript"><!--
new CBA.Widgets.InlineCheckoutWidget({
	merchantId: '<?php echo $merchant_id; ?>',
	buttonSettings: {
		color: '<?php echo $button_colour; ?>',
		background: '<?php echo $button_background; ?>',
		size: '<?php echo $button_size; ?>',
	},
	onAuthorize: function(widget) {
		var redirect = '<?php echo html_entity_decode($amazon_checkout); ?>';
		
		if (redirect.indexOf('?') == -1) {
			window.location = redirect + '?contract_id=' + widget.getPurchaseContractId();
		} else {
			window.location = redirect + '&contract_id=' + widget.getPurchaseContractId();
		}
	}
}).render('AmazonCheckoutWidgetModule<?php echo $module; ?>');
//--></script>
<script type="text/javascript">
  (function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){
  (i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),
  m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)
  })(window,document,'script','https://www.google-analytics.com/analytics.js','ga');

  ga('create', 'UA-81008565-1', 'auto');
  ga('send', 'pageview');

</script>		