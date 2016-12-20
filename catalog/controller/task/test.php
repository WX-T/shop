<?php
/**
 * 自动拆单，按订单金额<2000的原则拆分
 * @author Administrator
 *
 */
class ControllerTaskTest extends Controller{
    

    public function index() {
        $v = isset($this->request->get['v']) ? $this->request->get['v'] : '';
        if($v != md5("_TASK_SPLITORDERS_")){   //112a8792da1fe1778df628e847c0cf41
            echo false;
            exit();
        }
        $sqlOrders = "select order_id from sl_order where order_status_id in ('2','3','5','1','15','17','18','24','25','26') and is_split='0' and send_ordercenter='0' limit 0,100";
        $orderList = $this->db->query($sqlOrders)->rows;
        if($orderList){
            foreach ($orderList as $order){
                //$this->db->query("UPDATE " . DB_PREFIX . "order set is_split='2' WHERE order_id='".$order['order_id']."'");
            }
            $orderArr = array();
			
            foreach ($orderList as $order){
                $sqltotal = "SELECT SUM(quantity) as totalQuantity,sum(total) as goodstotal FROM sl_order_product WHERE `order_id`='".$order['order_id']."'";
                $totalInfo      = $this->db->query($sqltotal)->row;
                $totalQuantity  = $totalInfo['totalQuantity'];
                $goodsTotal     = $totalInfo['goodstotal'];
                //小于2000全部不用拆分
                /* if($goodsTotal <= 2000){
                    $this->db->query("UPDATE " . DB_PREFIX . "order set is_split='1' WHERE order_id='".$order['order_id']."'");
                    continue;
                } */
                $sqlproducts = "SELECT T1.order_product_id,T1.product_id,T1.quantity,T1.price,T1.total,T2.source FROM sl_order_product T1,sl_product T2 WHERE T1.`product_id`=T2.`product_id` AND T1.`order_id`='".$order['order_id']."' AND T1.refund='0'";
                $orderProducts = $this->db->query($sqlproducts)->rows;
                //单种单件商品超2000无法拆分
                if(count($orderProducts) == 1 && $totalQuantity == 1){
                    $this->db->query("UPDATE " . DB_PREFIX . "order set is_split='1' WHERE order_id='".$order['order_id']."'");
                    continue;
                }
                //单种多件件商品超2000，按最接近2000比例拆分
                if(count($orderProducts) == 1){
                    $orderProduct = $orderProducts[0];
                    $piceNum = 0;
                    for ($i = 0 ; $i < intval($orderProduct['quantity']) ; $i ++){
                        if($orderProduct['price']*($i+1) > 2000){
                            $piceNum = $i;
                            break;
                        }
                    }
                    if($piceNum == 0){
                        $this->db->query("UPDATE " . DB_PREFIX . "order set is_split='1' WHERE order_id='".$order['order_id']."'");
                        continue;
                    }
                    $lessNum = intval($orderProduct['quantity']);
                    for ($j = 0; $j < ceil($totalQuantity/$piceNum) ; $j ++){
                        $orderInfo = $order;
                        $orderProduct['quantity'] = $lessNum < $piceNum ? $lessNum : $piceNum;
                        $orderProduct['total']    = intval($orderProduct['quantity'])*$orderProduct['price'];
                        $orderInfo['products'][]  = $orderProduct;
                        $orderArr[$order['order_id']][] = $orderInfo;
                        $lessNum = $lessNum - $piceNum;
                    }
                    continue;
                }
                //多平台多种商品，先按来源匹配
                $productsArr = array();
                foreach ($orderProducts as $products){
                    $products['source'] = strtolower(trim($products['source'])) ? strtolower(trim($products['source'])) : 'amazon';
                    $productsArr[$products['source']][] = $products;
                }
                foreach ($productsArr as $source=>$protArr){
                    $order['source'] = $source;
                   //单一来源产品种数和数量都为1
                   if(count($protArr) == 1 && $protArr[0]['quantity'] == 1){
                       $orderInfo = $order;
                       $orderInfo['products'] = $protArr;
                       $orderArr[$order['order_id']][] = $orderInfo;
                   //产品种数为1，数量>1，按最接近2000拆分
                   }elseif(count($protArr) == 1){
                       $piceNum = 0;
                       for ($i = 0 ; $i < intval($protArr[0]['quantity']) ; $i ++){
                           if($protArr[0]['price']*($i+1) > 2000){
                               $piceNum = $i;
                               break;
                           }
                       }
                       if($piceNum == 0){
                           $orderInfo = $order;
                           $orderInfo['products'] = $protArr;
                           $orderArr[$order['order_id']][] = $orderInfo;
                           continue;
                       }
                       $lessNum = intval($protArr[0]['quantity']);
                       $orderProduct = $protArr[0];
                       for ($j = 0; $j < ceil(intval($protArr[0]['quantity'])/$piceNum) ; $j ++){
                           $orderInfo = $order;
                           $orderProduct['quantity'] = $lessNum < $piceNum ? $lessNum : $piceNum;
                           $orderProduct['total']    = intval($orderProduct['quantity'])*$orderProduct['price'];
                           $orderInfo['products'][] = $orderProduct;
                           $orderArr[$order['order_id']][] = $orderInfo;
                           $lessNum = $lessNum - $piceNum;
                       }
                   }else{       //多产品种数，多数量
                       $priceArr = array();
                       $prodArr = array();
                       foreach ($protArr as $pkey=>$prod){
                           //拆分单件超2000
                           if($prod['quantity'] == 1 && $prod['total']>2000){
                               $orderInfo = $order;
                               $orderInfo['products'][] = $prod;
                               $orderArr[$order['order_id']][] = $orderInfo;
                               unset($protArr[$pkey]);
                           }else{
                               $priceArr[$prod['order_product_id']] = $prod['total'];
                               $prodArr[$prod['order_product_id']] = $prod;
                           }
                       }
                       //拆分其他小于2000
                       if(array_sum($priceArr) <= 2000){
                           $orderInfo = $order;
                           $orderInfo['products'] = $protArr;
                           $orderArr[$order['order_id']][] = $orderInfo;
                       }else{
                           $this->splitSpecOrder($prodArr , $order ,$orderArr);
                       }
                   }
                }
            }
            $this->doSplitOrder($orderArr);
        }else{
            echo '无需拆分订单';
        }
    }
    
    
    /**
     * 执行新订单拆分
     * @param unknown $orderArr  待拆分订单集合
     */
    public function doSplitOrder($orderArr){
        $num = 0;
        $this->load->model('account/order');
        $newOrderNoArr = array();
        foreach ($orderArr as $oid=>$norder){
            $orderInfo = $this->model_account_order->getOrderInfo($oid);
            if($orderInfo['is_split'] == '1'){
                continue;
            }
            if(!$orderInfo){
                continue;
            }
            $sqltotal = "SELECT SUM(quantity) as totalQuantity,sum(total+tariff_price) as goodstotal FROM sl_order_product WHERE `order_id`='".$oid."'";
            $totalInfo      = $this->db->query($sqltotal)->row;
            $totalQuantity  = $totalInfo['totalQuantity'];
            $goodsTotal     = $totalInfo['goodstotal'];
            $shippingPirce  = $orderInfo['total'] - $goodsTotal;
            //新订单
            foreach ($norder as $neorder){
                $neworderQuantity = 0;
                foreach ($neorder['products'] as $item){
                    $neworderQuantity += intval($item['quantity']);
                }
                //新订单比例
                $newopices = $neworderQuantity/$totalQuantity;
                $newShippingPrice = $shippingPirce*$newopices;
                $newTariffPrice = $orderInfo['tariff_price']*$newopices;
                $newOrderTotal = $newTariffPrice+$newShippingPrice;
                $newGoodsTotal  = 0;
                foreach ($neorder['products'] as $item){
                    $newGoodsTotal += $item['price']*intval($item['quantity']);
                    $newOrderTotal += $item['price']*intval($item['quantity']);
                }
                $newOrderNo = '';
                if(array_key_exists($oid, $newOrderNoArr)){
                    $newOrderNoArr[$oid] = $newOrderNoArr[$oid]+1;
                    $newOrderNo = 'LG'.$oid.'-'.intval($newOrderNoArr[$oid]);
                }else{
                    $newOrderNoArr[$oid] = 1;
                    $newOrderNo = 'LG'.$oid.'-'.intval($newOrderNoArr[$oid]);
                }
                //添加新订单
                $insertOrderSql = '';
                foreach ($orderInfo as $key=>$value){
                    if(in_array($key, array('order_id'))){
                        continue;
                    }
                    if(in_array($key, array('ship_price'))){
                        $value = floatval($value);
                    }
                    if($key == 'total'){
                        $value = $newOrderTotal;
                    }elseif($key == 'tariff_price'){
                        $value = $newTariffPrice;
                    }elseif($key == 'is_split'){
                        $value = '1';
                    }elseif($key == 'parent_order_id'){
                        $value = $oid;
                    }elseif($key == 'center_orderno'){
                        $value = $newOrderNo;
                    }elseif($key == 'date_modified'){
                        $value = date('Y-m-d H:i:s');
                    }elseif($key == 'source'){
                        $value = $neorder['source'];
                    }
                    if($insertOrderSql == ''){
                        $insertOrderSql .= "INSERT INTO `" . DB_PREFIX . "order` SET ".$key."='".$value."'";
                    }else{
                        $insertOrderSql .= ",".$key."='".$value."'";
                    }
                }
                $this->db->query($insertOrderSql);
                $new_order_id = $this->db->getLastId();
                //新订单汇总
                $sqlTotal = "SELECT * from sl_order_total where order_id='".$oid."'";
                $orderTotals = $this->db->query($sqlTotal)->rows;
                if($orderTotals){
                    foreach ($orderTotals as $total){
                        if($total['code'] == 'sub_total'){
                            $total['value'] = $newGoodsTotal;
                        }elseif($total['code'] == 'shipping'){
                            $total['value'] = $newShippingPrice;
                        }elseif($total['code'] == 'total'){
                            $total['value'] = $newOrderTotal;
                        }
                        $this->db->query("INSERT INTO " . DB_PREFIX . "order_total SET order_id = '" . (int)$new_order_id . "', code = '" . $this->db->escape($total['code']) . "', title = '" . $this->db->escape($total['title']) . "', `value` = '" . (float)$total['value'] . "', sort_order = '" . (int)$total['sort_order'] . "'");
                    }
                }
                $sqlHistory = "SELECT * from sl_order_history where order_id='".$oid."'";
                $orderHistores = $this->db->query($sqlHistory)->rows;
                if($orderHistores){
                    foreach ($orderHistores as $history){
                        $this->db->query("insert into `" . DB_PREFIX . "order_history`(order_id,order_status_id,date_added) values('".$new_order_id."','".(int)$history['order_status_id']."','".$history['date_added']."')");
                    }
                }
                //新订单商品
                foreach ($neorder['products'] as $item){
                    $sqlproduct = "SELECT * FROM sl_order_product where order_product_id='".$item['order_product_id']."'";
                    $orderProduct = $this->db->query($sqlproduct)->row;
                    $insertOrderProductSql = '';
                    foreach ($orderProduct as $key=>$value){
                        if(in_array($key, array('order_product_id'))){
                            continue;
                        }
                        if($key == 'order_id'){
                            $value = $new_order_id;
                        }elseif($key == 'quantity'){
                            $value = intval($item['quantity']);
                        }elseif($key == 'total'){
                            $value = $orderProduct['price']*intval($item['quantity']);
                        }elseif($key == 'tariff_price'){
                            $value = (intval($item['quantity'])/$neworderQuantity)*$newTariffPrice;
                        }elseif($key == 'party_price'){
                            $value = (intval($item['quantity'])/$orderProduct['quantity'])*$orderProduct['party_price'];
                        }
                        if($insertOrderProductSql == ''){
                            $insertOrderProductSql .= "INSERT INTO `" . DB_PREFIX . "order_product` SET ".$key."='".$value."'";
                        }else{
                            $insertOrderProductSql .= ",".$key."='".$value."'";
                        }
                    }
                    $this->db->query($insertOrderProductSql);
                    $new_order_product_id = $this->db->getLastId();
                    //新订单属性
                    $sqlOption = "SELECT * from sl_order_option where order_id='".$oid."' and order_product_id='".$orderProduct['order_product_id']."'";
                    $orderOptions = $this->db->query($sqlOption)->rows;
                    if($orderOptions){
                        foreach ($orderOptions as $option){
                            $this->db->query("INSERT INTO " . DB_PREFIX . "order_option SET order_id = '" . (int)$new_order_id . "', order_product_id = '" . (int)$new_order_product_id . "', product_option_id = '" . (int)$option['product_option_id'] . "', product_option_value_id = '" . (int)$option['product_option_value_id'] . "', name = '" . $this->db->escape($option['name']) . "', `value` = '" . $this->db->escape($option['value']) . "', `type` = '" . $this->db->escape($option['type']) . "'");
                        }
                    }
                }
            }
            $this->db->query("UPDATE " . DB_PREFIX . "order set order_status_id='0',is_split='1' WHERE order_id='".$oid."'");
            $num ++;
        }
        echo '拆分订单： '.$num.' 个';
    }
    
    
    /**
     * 递归拆单，按价格，按max+min方式
     * @param unknown $prodArr
     * @param unknown $order
     * @param unknown $ordersArr
     */
    public function splitSpecOrder($prodArr , $order ,  &$ordersArr){
        if(empty($prodArr)){        //递归到最后将无商品，结束
            return false;
        }
        //得到最大价格，最小价格
        $priceArr = array();
        foreach ($prodArr as $prod){
            $priceArr[$prod['order_product_id']] = $prod['total'];
        }
        //最大价格的商品
        $maxProductId = array_search(max($priceArr), $priceArr);
        $prodInfo = $prodArr[$maxProductId];
        if(array_sum($priceArr)<=2000){ //余下的总价<=2000 直接合并成一个订单
            $orderInfo = $order;
            $orderInfo['products'] = $prodArr;
            $ordersArr[$order['order_id']][] = $orderInfo;
        }elseif($prodInfo['total'] > 2000){//最大价格>2000直接按2000拆分
            $piceNum = 0;
            for ($i = 0 ; $i < intval($prodInfo['quantity']) ; $i ++){
                if($prodInfo['price']*($i+1) > 2000){
                    $piceNum = $i;
                    break;
                }
            }
            if($piceNum == 0){
                $orderProduct = $prodInfo;
                $orderInfo = $order;
                $orderProduct['quantity'] = $prodInfo['quantity'];
                $orderProduct['total']    = $prodInfo['total'];
                $orderInfo['products'][]  = $orderProduct;
                $ordersArr[$order['order_id']][] = $orderInfo;
                unset($prodArr[$maxProductId]);
                $this->splitSpecOrder($prodArr, $order, $ordersArr);
            }else{
                $lessNum = intval($prodInfo['quantity']);
                $orderProduct = $prodInfo;
                for ($j = 0; $j < floor(intval($prodInfo['quantity'])/$piceNum) ; $j ++){
                    $orderInfo = $order;
                    $orderProduct['quantity'] = $lessNum < $piceNum ? $lessNum : $piceNum;
                    $orderProduct['total']    = intval($orderProduct['quantity'])*$orderProduct['price'];
                    $orderInfo['products'][] = $orderProduct;
                    $ordersArr[$order['order_id']][] = $orderInfo;
                    $lessNum = $lessNum - $piceNum;
                }
                //按数量刚好拆分，则拆分完，否则余下的数量继续往下拆分
                if(intval($prodInfo['quantity'])%$piceNum == 0){
                    unset($prodArr[$maxProductId]);
                }else{
                    $prodArr[$maxProductId]['quantity'] = intval($prodInfo['quantity'])%$piceNum;
                    $prodArr[$maxProductId]['total']    = $prodArr[$maxProductId]['price']*intval($prodArr[$maxProductId]['quantity']);
                }
                //递归拆分
                $this->splitSpecOrder($prodArr, $order, $ordersArr);
            }
        }elseif(count($prodArr) == 1){          //只剩一种商品<2000时，直接拆分成订单
            $orderInfo = $order;
            $orderInfo['products'] = $prodArr;
            $ordersArr[$order['order_id']][] = $orderInfo;
            unset($prodArr[$maxProductId]);
            $this->splitSpecOrder($prodArr, $order, $ordersArr);
        }else{            //还剩多个商品，按最大值+最小值拆分
            $minProductId = array_search(min($priceArr), $priceArr);
            if($minProductId == $maxProductId){
                $priceArray = $priceArr;
                unset($priceArray[$maxProductId]);
                $minProductId = array_search(min($priceArray), $priceArray);
            }
            $minPordInfo = $prodArr[$minProductId];
            if($prodInfo['total'] + $minPordInfo['total'] > 2000){      //最大值+最小值>2000时，最大值商品直接拆分，然后递归
                $orderInfo = $order;
                $orderInfo['products'][] = $prodInfo;
                $ordersArr[$order['order_id']][] = $orderInfo;
                unset($prodArr[$maxProductId]);
                //递归拆分
                $this->splitSpecOrder($prodArr, $order, $ordersArr);
            }else{      //最大值+最小值<=2000时，最大值+最小值商品凑单拆分，然后递归
                $orderInfo = $order;
                $orderInfo['products'][] = $prodInfo;
                $orderInfo['products'][] = $minPordInfo;
                $ordersArr[$order['order_id']][] = $orderInfo;
                unset($prodArr[$maxProductId]);
                unset($prodArr[$minProductId]);
                //递归拆分
                $this->splitSpecOrder($prodArr, $order, $ordersArr);
            }
        }
    }
    
    
    /**
     * 历史数据按excel拆分订单
     */
    public function history(){
        include './epass/PHPExcel/PHPExcel.php';
        $objPHPExcel = new PHPExcel();
        $uploadfile='tmp/split20160801.xlsx';//上传后的文件名地址
        $extend = pathinfo($uploadfile);
        $extend = strtolower($extend["extension"]);
        $extend=='xlsx' ? $reader_type='Excel2007' : $reader_type='Excel5';
        $objReader = PHPExcel_IOFactory::createReader($reader_type);//use excel2007 for 2007 format
        $objPHPExcel = $objReader->load($uploadfile);
        $inData = $objPHPExcel->getSheet(1)->toArray();
        array_shift($inData);
        $orders = array();
        foreach($inData as $data){
            $newOrderId = trim($data['0']);
            $oldOrderId = str_replace('LG', '', explode('-', $newOrderId)[0]);
            $orders[$oldOrderId][] = $data;
            $ids .= $oldOrderId.",";
        }
        $orderArr = array();
        foreach ($orders as $key=>$order){
            $newOrders = array();
            foreach ($order as $neworder){
                $newOrders[trim($neworder[0])][] = $neworder;
            }
            $orderArr[$key] = $newOrders;
        }
        $this->load->model('account/order');
        $num = 0;
        foreach ($orderArr as $oid=>$norder){
            $orderInfo = $this->model_account_order->getOrderInfo($oid);
            if($orderInfo['is_split'] == '1'){
                continue;
            }
            if(!$orderInfo){
                continue;
            }
            $sqltotal = "SELECT SUM(quantity) as totalQuantity,sum(total+tariff_price) as goodstotal FROM sl_order_product WHERE `order_id`='".$oid."'";
            $totalInfo      = $this->db->query($sqltotal)->row;
            $totalQuantity  = $totalInfo['totalQuantity'];
            $goodsTotal     = $totalInfo['goodstotal'];
            $shippingPirce  = $orderInfo['total'] - $goodsTotal;
            //新订单
            foreach ($norder as $neorder){
                $neworderQuantity = 0;
                foreach ($neorder as $item){
                    $neworderQuantity += intval($item['27']);
                }
                //新订单比例
                $newopices = $neworderQuantity/$totalQuantity;
                $newShippingPrice = $shippingPirce*$newopices;
                $newTariffPrice = $orderInfo['tariff_price']*$newopices;
                $newOrderTotal = $newTariffPrice+$newShippingPrice;
                $newGoodsTotal  = 0;
                foreach ($neorder as $item){
                    $sqlproduct = "SELECT T1.* FROM sl_order_product T1,sl_product T2 WHERE T1.`product_id`=T2.`product_id` AND T2.`model`='".$item['25']."' AND T1.`order_id`='".$oid."'";
                    $orderProduct = $this->db->query($sqlproduct)->row;
                    $newGoodsTotal += $orderProduct['price']*intval($item['27']);
                    $newOrderTotal += $orderProduct['price']*intval($item['27']);
                }
                //添加新订单
                $insertOrderSql = '';
                foreach ($orderInfo as $key=>$value){
                    if(in_array($key, array('order_id'))){
                        continue;
                    }
                    if(in_array($key, array('ship_price'))){
                        $value = floatval($value);
                    }
                    if($key == 'total'){
                        $value = $newOrderTotal;
                    }elseif($key == 'tariff_price'){
                        $value = $newTariffPrice;
                    }elseif($key == 'is_split'){
                        $value = '1';
                    }elseif($key == 'parent_order_id'){
                        $value = $oid;
                    }elseif($key == 'center_orderno'){
                        $value = trim($item['0']);
                    }elseif($key == 'date_modified'){
                        $value = date('Y-m-d H:i:s');
                    }
                    if($insertOrderSql == ''){
                        $insertOrderSql .= "INSERT INTO `" . DB_PREFIX . "order` SET ".$key."='".$value."'";
                    }else{
                        $insertOrderSql .= ",".$key."='".$value."'";
                    }
                }
                $this->db->query($insertOrderSql);
                $new_order_id = $this->db->getLastId();
                //新订单汇总
                $sqlTotal = "SELECT * from sl_order_total where order_id='".$oid."'";
                $orderTotals = $this->db->query($sqlTotal)->rows;
                if($orderTotals){
                    foreach ($orderTotals as $total){
                        if($total['code'] == 'sub_total'){
                            $total['value'] = $newGoodsTotal;
                        }elseif($total['code'] == 'shipping'){
                            $total['value'] = $newShippingPrice;
                        }elseif($total['code'] == 'total'){
                            $total['value'] = $newOrderTotal;
                        }
                        $this->db->query("INSERT INTO " . DB_PREFIX . "order_total SET order_id = '" . (int)$new_order_id . "', code = '" . $this->db->escape($total['code']) . "', title = '" . $this->db->escape($total['title']) . "', `value` = '" . (float)$total['value'] . "', sort_order = '" . (int)$total['sort_order'] . "'");
                    }
                }
                $sqlHistory = "SELECT * from sl_order_history where order_id='".$oid."'";
                $orderHistores = $this->db->query($sqlHistory)->rows;
                if($orderHistores){
                    foreach ($orderHistores as $history){
                        $this->db->query("insert into `" . DB_PREFIX . "order_history`(order_id,order_status_id,date_added) values('".$new_order_id."','".(int)$history['order_status_id']."','".$history['date_added']."')");
                    }
                }
                //新订单商品
                foreach ($neorder as $item){
                    $sqlproduct = "SELECT T1.* FROM sl_order_product T1,sl_product T2 WHERE T1.`product_id`=T2.`product_id` AND T2.`model`='".$item['25']."' AND T1.`order_id`='".$oid."'";
                    $orderProduct = $this->db->query($sqlproduct)->row;
                    $insertOrderProductSql = '';
                    foreach ($orderProduct as $key=>$value){
                        if(in_array($key, array('order_product_id'))){
                            continue;
                        }
                        if($key == 'order_id'){
                            $value = $new_order_id;
                        }elseif($key == 'quantity'){
                            $value = intval($item['27']);
                        }elseif($key == 'total'){
                            $value = $orderProduct['price']*intval($item['27']);
                        }elseif($key == 'tariff_price'){
                            $value = (intval($item['27'])/$neworderQuantity)*$newTariffPrice;
                        }elseif($key == 'party_price'){
                            $value = (intval($item['27'])/$orderProduct['quantity'])*$orderProduct['party_price'];
                        }
                        if($insertOrderProductSql == ''){
                            $insertOrderProductSql .= "INSERT INTO `" . DB_PREFIX . "order_product` SET ".$key."='".$value."'";
                        }else{
                            $insertOrderProductSql .= ",".$key."='".$value."'";
                        }
                    }
                    $this->db->query($insertOrderProductSql);
                    $new_order_product_id = $this->db->getLastId();
                    //新订单属性
                    $sqlOption = "SELECT * from sl_order_option where order_id='".$oid."' and order_product_id='".$orderProduct['order_product_id']."'";
                    $orderOptions = $this->db->query($sqlOption)->rows;
                    if($orderOptions){
                        foreach ($orderOptions as $option){
                            $this->db->query("INSERT INTO " . DB_PREFIX . "order_option SET order_id = '" . (int)$new_order_id . "', order_product_id = '" . (int)$new_order_product_id . "', product_option_id = '" . (int)$option['product_option_id'] . "', product_option_value_id = '" . (int)$option['product_option_value_id'] . "', name = '" . $this->db->escape($option['name']) . "', `value` = '" . $this->db->escape($option['value']) . "', `type` = '" . $this->db->escape($option['type']) . "'");
                        }
                    }
                }
            }
            $this->db->query("UPDATE " . DB_PREFIX . "order set order_status_id='0',is_split='1' WHERE order_id='".$oid."'");
            $num ++;
        }
        echo '拆分订单： '.$num.' 个';
    }
}