 <script type="text/javascript"><!--
 $(document).on('click' , '#cod-confirm' ,function(){
	$.ajax({ 
		type: 'get',
		url: 'index.php?route=payment/cod/confirm',
		cache: false,
		success: function() {
			location = '<?php echo $continue; ?>';
		}		
	});
});
//--></script> 