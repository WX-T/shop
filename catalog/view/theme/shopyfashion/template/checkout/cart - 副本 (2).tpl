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
<div class="content panel-align">
		<!-- 商品列表 -->
		<form action="<?php echo $action; ?>" method="post" id="cart-form" enctype="multipart/form-data">
        <div class="goods-list">
            <ul class="head">
                <li class=" detail">
                   <!--  <span class="fl">
                        <label><input type="checkbox" class="allcheck v-align-mid" checked="checked" id="allcheck"/>  全选</label>
                    </span>  -->
                                            产品详情
                </li>
                <li class="price">单价</li>
                <li class="count">数量</li>
                <li class="subtotal">小计（元）</li>
                <li class="control">操作</li>
            </ul>
            <?php foreach ($products as $product) { ?>
            <ul class="body">
                <li class="detail">
                    <!-- <input type="checkbox" class="check fl  v-align-mid" name="selected[]"  checked="checked" value="<?php echo $product['key']; ?>" pid="<?php echo $product['product_id'];?>"/> -->
                    <?php if ($product['thumb']) { ?>
                    <a href="<?php echo $product['href']; ?>"><img src="<?php echo $product['thumb']; ?>" alt="<?php echo $product['name']; ?>" title="<?php echo $product['name']; ?>" class="img-thumbnail1" /></a>
                    <?php } ?>
                    <div class="fr text-align-left">
                        <p><a href="<?php echo $product['href']; ?>"><?php echo $product['name']; ?></a></p>
                        <p class="c999">款号：<?php echo $product['model']; ?></p>
                        <?php if ($product['option']) { ?>
		                <?php foreach ($product['option'] as $option) { ?>
		                <p class="c999"><?php echo $option['name']; ?>: <?php echo $option['value']; ?></p>
		                <?php } ?>
		                <?php } ?>
                    </div>
                </li>
                <li class="price"><?php echo $product['price']; ?><br/>（<?php echo $product['dprice']; ?>）</li>
                <li class="count">
                <a href="javascript:void(0);" title="减" class="btn-less" pid="<?php echo $product['key']; ?>">-</a>
                <input type="text" name="quantity[<?php echo $product['key']; ?>]" value="<?php echo $product['quantity']; ?>" bvalue="<?php echo $product['quantity']; ?>" size="1" class="form-quantity"/>
                <a href="javascript:void(0);" title="加" class="btn-add" pid="<?php echo $product['key']; ?>">+</a>
                </li>
                <li class=" subtotal"><?php echo $product['total']; ?><br/>（<?php echo $product['dtotal']; ?>）</li>
                <li class="control">
	                <a href="javascript:void(0);" onclick="product_remove('<?php echo $product['key']; ?>');">删 除</a><br/>
	                <a href="javascript:void(0);" onclick="wishlist.add(<?php echo $product['product_id'];?>);">加入收藏夹</a>
                </li>
            </ul>
            <hr>
            <?php } ?>
            <!-- <div class="list-operate">
                <a class="blue" href="javascript:void(0);" id="delete_goods">删 除 |</a>
                <a class="blue" href="javascript:void(0);" id="collect_goods">加入收藏夹</a>
            </div> -->
        </div>
        </form>
  		<div class="goods-subtotal">
            <?php foreach ($totals as $key=>$total) { ?>
            <span><?php echo $total['title']; ?>：</span>
            <span class="actual"><?php echo $total['text']; ?>（<?php echo $total['dtext']; ?>）</span>
            <?php if(count($totals) != $key+1){?><br/><?php }?>
            <?php }?>
            <br />
            <a class="checkout" href="<?php echo $checkout; ?>">
                <img src="catalog/view/theme/shopyfashion/image/go-subtotal.png" />
            </a>
        </div>
        <hr class="hr-grey" />
        <?php echo $content_bottom; ?>
    	<?php echo $column_right; ?>
</div>
<script type="text/javascript"><!--
$(document).ready(function(){
	$("#collect_goods").click(function(){
		$('input[name="selected[]"]:checked').each(function(){    
		    var pid = $(this).attr('pid');
		    wishlist.add(pid);
		});
	});
	
	$(".form-quantity").blur(function(){
		var val = parseInt($(this).val());
		var bval = $(this).attr('bvalue');
		var obj = this;
		if(val <= 0 || isNaN(val)){
			$(this).val(0);
			layer.confirm('数量为 0 将从购物车删除该商品，确定吗？', {icon: 3 , title: false} ,function(){
				$("#cart-form").submit();
			},function(){
				$(obj).val(bval);
			});
		}else{
			$("#cart-form").submit();
		}
		
	});
});

function product_remove(val_id){
	layer.confirm('确定删除该商品吗？', {icon: 3 , title: false} ,function(){
		cart.remove(val_id);
		layer.closeAll();
		location = 'index.php?route=checkout/cart';
	});
}

//--></script>
<?php echo $footer; ?> 