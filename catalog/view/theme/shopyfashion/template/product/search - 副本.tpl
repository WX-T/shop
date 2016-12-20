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
	 <!-- 排序 -->
     <div class=" panel-align sort-goods">
     	<form method="get" action="" id="sortFrom">
     	<ul>
        	<li class="orderby<?php if($sort == 'p.sort_order'){?> current<?php }?>"><a href="javascript:void(0);" onclick="product_sort('p.sort_order');">综合<?php if($sort == 'p.sort_order' && $order=='ASC'){?> ↑<?php }else{?> ↓<?php }?></a></li>
        	<li class="orderby<?php if($sort == 'p.rating'){?> current<?php }?>"><a href="javascript:void(0);" onclick="product_sort('p.rating');">销量<?php if($sort == 'p.rating' && $order=='ASC'){?> ↑<?php }else{?> ↓<?php }?></a></li>
            <li class="orderby<?php if($sort == 'p.date_added'){?> current<?php }?>"><a href="javascript:void(0);" onclick="product_sort('p.date_added');">新品<?php if($sort == 'p.date_added' && $order=='ASC'){?> ↑<?php }else{?> ↓<?php }?></a></li>
            <li class="orderby<?php if($sort == 'p.price'){?> current<?php }?>"><a href="javascript:void(0);" onclick="product_sort('p.price');">价格 <?php if($sort == 'p.price' && $order=='ASC'){?> ↑<?php }else{?> ↓<?php }?></a></li>
            <li class="input-price">
            <input type="text" class="small-txt" id="s_start_price" value="<?php echo $start_price;?>"/>
            <input type="text" class="small-txt" id="s_end_price" value="<?php echo $end_price;?>"/>
            <a href="javascript:void(0);" class="btn btn-primary" id="price_search">确定</a>
            </li>
            <!-- <li class="pager">
            	<span class="pdr10"> 1/5 </span>
                <img src="catalog/view/theme/shopyfashion/image/jiantou-left-1.png" />
                <img src="catalog/view/theme/shopyfashion/image/jiantou-right-2.png" />
            </li> -->
        </ul>
        <input type="hidden" value="product/search" name="route">
        <input type="hidden" value="<?php echo $search;?>" name="search">
        <input type="hidden" value="<?php echo $sort;?>" id="sort" name="sort">
        <input type="hidden" value="<?php echo $order;?>" id="order" name="order">
        <input type="hidden" value="<?php echo $start_price;?>" id="start_price" name="start_price">
        <input type="hidden" value="<?php echo $end_price;?>" id="end_price" name="end_price">
        </form>
    </div>
  <!-- 展示商品 -->
    <div class=" panel-align show-goods">
    <?php echo $column_left; ?>
    <?php if ($column_left && $column_right) { ?>
    <?php $class = 'col-sm-6'; ?>
    <?php } elseif ($column_left || $column_right) { ?>
    <?php $class = 'col-sm-9'; ?>
    <?php } else { ?>
    <?php $class = 'col-sm-12'; ?>
    <?php } ?>
    <div class="list">
    	<ul>
    		<?php foreach ($products as $product) { ?>
        	<li>
            <a href="<?php echo $product['href']; ?>"><img width="295" height="300" src="<?php echo $product['thumb']; ?>" alt="<?php echo $product['name']; ?>" title="<?php echo $product['name']; ?>" /></a>
            <div class="shade">
            <div class="left"><a href="javascript:void(0);" title="收藏" onclick="wishlist.add('<?php echo $product['product_id']; ?>');"><img src="catalog/view/theme/shopyfashion/image/collect.png"/></a></div>    
            <div class="right"><a href="javascript:void(0);" title="对比" onclick="compare.add('<?php echo $product['product_id']; ?>');"><img src="catalog/view/theme/shopyfashion/image/compare.png"/></a></div>                               
            </div>
            <div class="title"><a href="<?php echo $product['href']; ?>"><?php echo $product['name']; ?></a></div>
            	<div class="detail">
            		<?php if ($product['price']) { ?>
	                  <?php if (!$product['special']) { ?>
	                  <span class="jiaqian"><?php echo $product['price']; ?></span>
	                  <?php } else { ?>
	                  <span class="jiaqian"><?php echo $product['price']; ?><br/>
	                  <span class="shuiqian">原价：<?php echo $product['special']; ?></span></span>
	                  <?php } ?>
	                <?php } ?>
                    <div class="fr top">
                    	<a href="javascript:void(0);" onclick="cart.add('<?php echo $product['product_id']; ?>');"><img src="catalog/view/theme/shopyfashion/image/join-goods.png" /></a>
                    </div>
                 </div>
             </li> 
              <?php } ?> 
	  	 </ul>
	  	 <?php if (!$products) { ?>
         <p class="none"><?php echo $text_empty; ?></p>
         <?php } ?>
     </div>
     <div class="row">
         <div class="text-left"><?php if(isset($pagination)){echo $pagination;} ?><div class="text-result"><span><?php if(isset($results)){echo $results;} ?></span></div></div>
     </div>
</div>
</div>
<script type="text/javascript">
$(document).ready(function(){
});

function product_sort(psort){
	var sort = $("#sort").val();
	var order = $("#order").val();
	if(psort == sort){
		if(order == 'ASC'){
			$("#order").val('DESC');
		}else{
			$("#order").val('ASC');
		}
	}else{
		$("#sort").val(psort)
		$("#order").val('DESC');
	}
	$("#sortFrom").submit();
}

$("#price_search").on('click' , function(){
	$("#start_price").val($("#s_start_price").val());
	$("#end_price").val($("#s_end_price").val());
	$("#sortFrom").submit();
});
</script>
<?php echo $footer; ?> 