<?php
    /**
     * 
     * 搜索记录表sl_search_history
     * @author Administrator
     *
     */
    class ModelCatalogSearch extends Model {
        /**
         * 获取用户搜索记录
         * $customer_id 用户id
         */
        public function getSearchHistory($customer_id){
            $history = '';
            if(!empty($customer_id)){
                $query = $this->db->query("select * from ".DB_PREFIX."search_history where customer_id = ".(int)$customer_id);
                $history = $query->rows;
            }
            return $history;
        }
        /**
         * 添加搜索记录
         * $customer_id 用户id
         * $coutn 搜索内容
         */
        public function addSearchHistory($customer_id,$count=''){
            $row = 0;
            if(!empty($customer_id)){
               $row = $this->db->query("INSERT INTO `" .DB_PREFIX."search_history` SET `customer_id`=".(int)$customer_id.",content= '".$count."',createtime= NOW()");
            }
            //var_dump($row);
        }
    }