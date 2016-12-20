<div class="list-group account_center">
<ul>
	<li><h3>交易管理</h3>
		<ul>
			<li><a href="<?php echo $order; ?>" class="list-group-item<?php if($online=='order'){ ?> current<?php }?>"><?php echo $text_order; ?></a> </li>
			<li><a href="<?php echo $wishlist; ?>" class="list-group-item<?php if($online=='wishlist'){ ?> current<?php }?>"><?php echo $text_wishlist; ?></a></li>
		</ul>
	</li>
	<li><h3>服务中心</h3>
		<ul>
			<li><a href="<?php echo $return; ?>" class="list-group-item<?php if($online=='return'){ ?> current<?php }?>"><?php echo $text_return; ?></a></li>
		</ul>
	</li>
	<li><h3>个人信息管理</h3>
		<ul>
		  <?php if ($logged) { ?>
		  <li><a href="<?php echo $edit; ?>" class="list-group-item<?php if($online=='edit'){ ?> current<?php }?>"><?php echo $text_edit; ?></a></li>
		  <li><a href="<?php echo $password; ?>" class="list-group-item<?php if($online=='password'){ ?> current<?php }?>"><?php echo $text_password; ?></a></li>
		  <?php } ?>
		  <li><a href="<?php echo $address; ?>" class="list-group-item<?php if($online=='address'){ ?> current<?php }?>"><?php echo $text_address; ?></a></li>
		  <?php if ($logged) { ?>
  		  <li><a href="<?php echo $logout; ?>" class="list-group-item"><?php echo $text_logout; ?></a></li>
  		  <?php } ?>
		</ul>
	</li>
</ul>
</div>
