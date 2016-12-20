<?php
/**
 * 
 * 双十一之韩国丽人篇
 * 
 */

class ControllerActivityKorea11 extends Controller{
    public function index(){
        $this->load->model('catalog/product');
        $this->load->model('tool/image');
        $type = $this->request->get['type'];
        $data = array();
        if($type){
            if($type=='korea'){
              $data['title'] = '双十一之韩国丽人篇';
              $data['list'] = array(
                    array(
                        'target'=>'http://boc.legoods.com/index.php?route=product/wapsearch&search=%E9%9D%A2%E8%86%9C',
                        'banner'=>'http://cdn.legoods.com/boc/11/banners_01.jpg',
                        'products'=>array(22062,22060,22043,21936,)),
                    array(
                        'target'=>'http://boc.legoods.com/index.php?route=product/wapsearch&search=%E8%BA%AB%E4%BD%93%E4%B9%B3',
                        'banner'=>'http://cdn.legoods.com/boc/11/banners_02.jpg',
                        'products'=>array(22005,21994,22022,21986,)),
                    array(
                        'target'=>'http://boc.legoods.com/index.php?route=product/wapsearch&search=%E5%8F%A3%E7%BA%A2',
                        'banner'=>'http://cdn.legoods.com/boc/11/banners_03.jpg',
                        'products'=>array(28975,28984,28999,29000)),
                    array(
                        'target'=>'http://boc.legoods.com/index.php?route=product/wapsearch&search=%E6%96%BD%E5%8D%8E%E6%B4%9B%E4%B8%96%E5%A5%87',
                        'banner'=>'http://cdn.legoods.com/boc/11/banners_04.jpg',
                        'products'=>array(25445,25443,25447,25448,))
                
                );
            }elseif($type=='guonei'){
                $data['title'] = '双十一之国内现货篇';
                $data['list'] = array(
                    array(
                        'target'=>'http://boc.legoods.com/index.php?route=product/wapsearch&search=SANTA%20VITTORIA',
                        'banner'=>'http://cdn.legoods.com/boc/hodong/jbanner1.jpg',
                        'products'=>array(22143,22144,22137,22138)),
                    array(
                        'target'=>'http://boc.legoods.com/index.php?route=product/wapsearch&search=%E8%91%A1%E8%90%84%E9%85%92',
                        'banner'=>'http://cdn.legoods.com/boc/hodong/jbanner2.jpg',
                        'products'=>array(25873,25196,25195,25875))
                );
            }elseif($type=='jpcl'){
                $data['title'] = '双十一之日本潮流篇';
                //日本潮流
                $data['list'] = array(
                    array(  //包包
                        'target'=>'http://boc.legoods.com/index.php?route=product/wapsearch&search=jp_beb',
                        'banner'=>'http://cdn.legoods.com/boc/hodong/banners_09.jpg',
                        'products'=>array(28354,28356,28361,28362)),
                    array(  //美腿袜
                        'target'=>'http://boc.legoods.com/index.php?route=product/wapsearch&search=jp_mtw',
                        'banner'=>'http://cdn.legoods.com/boc/hodong/banners_10.jpg',
                        'products'=>array(29122,29120,29119)),
                    array(  //洗发
                        'target'=>'http://boc.legoods.com/index.php?route=product/wapsearch&search=jp_hus',
                        'banner'=>'http://cdn.legoods.com/boc/hodong/banners_11.jpg',
                        'products'=>array(29007,29014,29124,29126)),
                    array(  //洗衣
                        'target'=>'http://boc.legoods.com/index.php?route=product/wapsearch&search=jp_xfy',
                        'banner'=>'http://cdn.legoods.com/boc/hodong/banners_12.jpg',
                        'products'=>array(29107,29111,29113,29106))
                );
            }elseif($type=='canada'){
                $data['title'] = '双十一之加拿大保健篇';
                //加拿大
                $data['list'] = array(
                    array(  //营养品
                        'target'=>'http://boc.legoods.com/index.php?route=product/wapsearch&search=hot_yyp',
                        'banner'=>'http://cdn.legoods.com/boc/hodong/banners_05.jpg',
                        'products'=>array(29048,28435,29024,29061)),
                    array(  //中老年
                        'target'=>'http://boc.legoods.com/index.php?route=product/wapsearch&search=hot_zln',
                        'banner'=>'http://cdn.legoods.com/boc/hodong/banners_06.jpg',
                        'products'=>array(29019,29054,29069,29055)),
                    array(  //婴幼儿
                        'target'=>'http://boc.legoods.com/index.php?route=product/wapsearch&search=hot_yyet',
                        'banner'=>'http://cdn.legoods.com/boc/hodong/banners_07.jpg',
                        'products'=>array(28462,28458,28386,29081)),
                    array(  //孕妇
                        'target'=>'http://boc.legoods.com/index.php?route=product/wapsearch&search=hot_yfsp',
                        'banner'=>'http://cdn.legoods.com/boc/hodong/banners_08.jpg',
                        'products'=>array(28455,28441,29040,29056))
                );
            }elseif($type =='amazon'){
                $data['title'] = '双十一之美国亚马逊篇';
                //亚马逊
                $data['list'] = array(
                    array(  //包包
                        'target'=>'http://boc.legoods.com/index.php?route=product/wapsearch&search=%E5%8C%85',
                        'banner'=>'http://cdn.legoods.com/boc/hodong/abanner1.jpg',
                        'products'=>array(27829,19322,19236,28506)),
                    array(  //鞋子
                        'target'=>'http://boc.legoods.com/index.php?route=product/wapsearch&sort=rating&order=ASC&search=%E9%9E%8B',
                        'banner'=>'http://cdn.legoods.com/boc/hodong/abanner2.jpg',
                        'products'=>array(28609,27523,28486,23289)),
                    array(  //衣服
                        'target'=>'http://boc.legoods.com/index.php?route=product/wapsearch&search=%E5%A4%96%E5%A5%97',
                        'banner'=>'http://cdn.legoods.com/boc/hodong/abanner3.jpg',
                        'products'=>array(28706,28936,23245,24972)),
                    array(  //电子产品
                        'target'=>'http://boc.legoods.com/index.php?route=product/category&path=1062_1063_1069',
                        'banner'=>'http://cdn.legoods.com/boc/hodong/abanner4.jpg',
                        'products'=>array(26688,26423,21628,24986))
                );
            }
        }
        
        
        
        //查询商品详情
        foreach ($data['list'] as &$list){
            foreach ($list['products'] as &$product){
                $results = $this->model_catalog_product->getProductProductIds($product);
                foreach ($results as $result) {
                    if ($result['image']) {
                        $image = $this->model_tool_image->resize($result['image']);
                    } else {
                        $image = $this->model_tool_image->resize('placeholder.png');
                    }
                
                    if (($this->config->get('config_customer_price') && $this->customer->isLogged()) || !$this->config->get('config_customer_price')) {
                        $price = $this->currency->format($this->tax->calculate($result['price'], $result['tax_class_id'], $this->config->get('config_tax')));
                    } else {
                        $price = false;
                    }
                
                    if ((float)$result['hotsale']) {
                        $hotsale = $this->currency->format($this->tax->calculate($result['hotsale'], $result['tax_class_id'], $this->config->get('config_tax')));
                    } else {
                        $hotsale = false;
                    }
                
                    if ($this->config->get('config_tax')) {
                        $tax = $this->currency->format((float)$result['hotsale'] ? $result['hotsale'] : $result['price']);
                    } else {
                        $tax = false;
                    }
                
                    if ($this->config->get('config_review_status')) {
                        $rating = $result['rating'];
                    } else {
                        $rating = false;
                    }
                
                    $product = array(
                        'product_id'  => $result['product_id'],
                        'thumb'       => $image,
                        'name'        => $result['name'],
                        'description' => utf8_substr(strip_tags(html_entity_decode($result['description'], ENT_QUOTES, 'UTF-8')), 0, $this->config->get('config_product_description_length')) . '..',
                        'price'       => $price,
                        'hotsale'     => $hotsale,
                        'tax'         => $tax,
                        'rating'      => $rating,
                        'href'        => $this->url->link('product/wapproduct', 'product_id=' . $result['product_id']),
                        'source'      => strtolower(trim($result['source'])) ? strtolower(trim($result['source'])) : 'amazon',
                    );
                }
            }
        }
        $this->response->setOutput($this->load->view($this->config->get('config_template') . '/template/activity/korea11.tpl', $data));
    }
}