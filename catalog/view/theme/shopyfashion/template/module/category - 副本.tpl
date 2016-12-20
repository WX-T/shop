<div class="nav">
		<ul class="nav-list">
			<li><span><a href="<?php echo $more_manufacturers; ?>">知名品牌</a></span>
			 <div class="brand-pop nav-pop">
				<?php foreach($manufacturers as $key=>$manufacturer){?>
				<div class="left">
					<p></p>	
					<p></p>		
				</div>
				<div class="right">
					<p></p>
					<p></p>		
				</div>
				<p><a href="<?php echo $manufacturer['href'];?>"><?php echo $manufacturer['name'];?></a></p>
				<?php } ?>
				<p class="lookall"><a href="<?php echo $more_manufacturers;?>">查看更多</a></p>
			</div>
			</li>
			<?php foreach ($categories as $c_key=>$category) { ?>
			<?php if($c_key<6){?>
			<li><span><a href="<?php echo $category['href']; ?>"><?php echo $category['name']; ?></a></span>
			<!--功能列表    品牌隐藏div-->
				<?php if($category['children']){?>
				<div class="infant-mom-pop nav-pop">
					<div class="left">
					<?php foreach($category['children'] as $key=>$chcat){?>
						<?php if($key<9): ?>
							<p><a href="<?php echo $chcat['href'];?>"><?php echo $chcat['name'];?></a></p>
						<?php endif; ?>
					<?php } ?>
					 <?php if($key>9): ?>
					 	<p><a href="<?php echo $category['href']; ?>">查看全部 &gt;</a></p>
					<?php endif; ?>
					</div>
					<div class="right">
						<?php foreach($category['recommend'] as $num=>$common){?>
							<?php if($num <10): ?>
								<p><a href="<?php echo $common['url'] ?>&category=<?php echo $category['category_id'];?>"><?php echo $common['title'] ?></a></p>
							<?php endif; ?>
							<?php if($num >10): ?>
					 			<a href="<?php echo $category['href'] ?>"><p class="lookall">查看全部品牌 &gt;</p></a>
								<?php  break;?>
							<?php endif; ?>
						<?php } ?>
						
					</div>
				</div>
				<?php }?>
			</li>
		<?php } ?>
		<?php } ?>
	</ul>
</div>
<p class="clearfix"></p>