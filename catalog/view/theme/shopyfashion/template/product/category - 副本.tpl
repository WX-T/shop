<?php echo $header; ?>
<?php echo $content_top; ?>
<div class="clearfix"></div>
<div class="listcontent content widthcenter">
      <br>
      <h5 class="site">
         <?php foreach ($breadcrumbs as $key=>$breadcrumb) { ?>
            <a href="<?php echo $breadcrumb['href']; ?>"><?php echo $breadcrumb['text']; ?></a>
            <?php if(count($breadcrumbs) != $key+1){?>
            <span>></span>
            <?php }?>
      <?php } ?>
      </h5>
      <div class="text-title">
        <h1><?php echo $heading_title ?></h1>
        <hr width="100px" color="#fcac45" />
        <hr width="67px" color="#fdc57c"/>
        <p><?php echo $description; ?></p>
      </div>
      <div class="commodity-content">
        <div class="search-brand">品牌
          <font></font>
          <?php if($brands): ?>
            <div class="type-pop">
              <div class="left">
                <?php foreach ($brands as $k=>$brand) { ?>
                <?php if($k<14): ?>
                  <?php if($k%2==0): ?>
                    <p><a href="<?php echo $brand['href'] ?>"><?php echo $brand['name'] ?></a></p>
                  <?php endif; ?>
                <?php endif; ?>
                <?php } ?>
              </div>
              <div class="right">
                <?php foreach ($brands as $key=>$brande) { ?>
                 <?php if($key<15): ?>
                  <?php if($key%2!==0): ?>
                    <p><a href="<?php echo $brande['href'] ?>"><?php echo $brande['name'] ?></a></p>
                  <?php endif; ?>
                <?php endif; ?>
                <?php } ?>
              </div>
            </div>
          <?php endif; ?>
        </div>
        <div class="search-filtrate">筛选
          <font></font>
          <?php if($products): ?>
            <div class="type-pop">
              <?php if($categories): ?>
                  <div class="left">
                <?php foreach($categories as $k=>$category): ?>
                  <?php if($k<12 && $k%2==0): ?>
                    <p><a href="<?php echo $category['href'] ?>"><?php echo $category['name'] ?></a></p>
                  <?php endif; ?>
                <?php endforeach; ?>
                  </div>
                <div class="right">
                  <?php foreach($categories as $num=>$categori): ?>
                  <?php if($num<12): ?>
                    <?php if($num%2!==0): ?>
                      <p><a href="<?php echo $categori['href'] ?>"><?php echo $categori['name'] ?></a></p>
                    <?php endif; ?>
                  <?php endif; ?>
                <?php endforeach; ?>
                </div>
              <?php endif; ?>
            </div>
          <?php endif ?>
        </div>
        <div class="search-sort">排序
          <font></font>
          <?php if($products): ?>
            <div class="type-pop">
              <p><a href="<?php echo $colligate['href'] ?>">综合</a></p>
              <p><a href="<?php echo $date_added['href']; ?>">最新</a></p>
             <p><a href="<?php if($rule == 'p.price' && $order=='ASC'){echo $lowpric['href'];}else{echo $costliness['href'];} ?>">价格&nbsp;<?php if($rule == 'p.price' && $order=='ASC'){?> ↑<?php }elseif($rule!='p.price'){?> ↑<?php }else{?> ↓<?php }?></a></p>
            <p><a href="<?php if($rule == 'rating' && $order=='ASC'){echo $ssales['href'];}else{echo $bsales['href'];} ?>">销量&nbsp;<?php if($rule == 'rating' && $order=='ASC'){?> ↑<?php }elseif($rule!='rating'){?> ↑<?php }else{?> ↓<?php }?></a></p>
            </div>
          <?php endif; ?>
        </div>
        <div class="top_search"><?php echo $pagination; ?></div>
        <div class="commodity-list">
          <?php foreach($products as $product): ?>
            <div class="commodity">
              <a href="<?php echo $product['href'] ?>"><img src="<?php echo $product['thumb'] ?>" class="commodity-img"/>
              <a href="<?php echo $product['href'] ?>"><p class="name"><?php echo $product['name'] ?></p></a>
              <p class="info"><span>Info</span><img src="catalog/view/theme/shopyfashion/image/slyc/color-2.png"/></p>
              
              <p class="price"><?php echo $product['money'][0] ?>.<sup><?php echo $product['money'][1] ?></sup></p>
              <p onclick="cart.add('<?php echo $product['product_id']; ?>');" class="shoppingcar"></p>
              <p class="like <?php echo $product['wishlist']?'love':'' ?>" onclick="wishlist.add(<?php echo $product['product_id'];?>,this)"></p>              <div class="evaluate">
                <img src="catalog/view/theme/shopyfashion/image/slyc/five-pointed.png" />
                <img src="catalog/view/theme/shopyfashion/image/slyc/five-pointed.png" />
                <img src="catalog/view/theme/shopyfashion/image/slyc/five-pointed.png" />
                <img src="catalog/view/theme/shopyfashion/image/slyc/five-pointed.png" />
                <span>&nbsp;<!--(<?php echo $product['rating'] ?>)--></span>
              </div>
            </div>
          <?php endforeach; ?>
        </div>
      </div>
      <div class="bottom-page">
         <?php echo $pagination; ?>
     </div>
    <?php echo $content_bottom; ?>
    </div>
      <div class="lately-browse widthcenter">
        <?php echo $column_right; ?>
      </div>
    <script type="text/javascript">
      //设置底部
      var btmW = $(".bottom").width();
      var btmH = btmW * 0.3536;
      $(".bottom").css("height", btmH);
      $(".bottom .widthcenter").css("height", btmH);  
   /* //收藏
        $(".like").on("click", function() {
          $(this).toggleClass("love");
        })*/
    
     //回到顶部
      $(".up-top").click(function(){
        $("html,body").animate({scrollTop: 0},1000);
      })  
    </script>
  <?php echo $footer ?>