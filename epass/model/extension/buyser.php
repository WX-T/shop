<?php
class ModelExtensionBuyser extends Model {
    public function getBuyserList(){
        $sql = 'select * from sl_buyserinfo';
        return $this->db->query($sql)->rows;
    }
    
    public function getBuyserInfo($buyser_id){
        
        $sql = "select * from sl_buyserinfo where buyser_id = ". (int)$buyser_id;
        return $this->db->query($sql)->row;
    }
    
    //获取买手下Amazon账号
    public function getAmazonAccounts($buyser_id){
        $sql = "select * from sl_amazon_account where buyser_id = ". (int)$buyser_id;
        
        return $this->db->query($sql)->rows;
    }
    
    //添加充值并记录
    public function paycheck($data){
        //添加充值记录
        $inser_historysql = "insert into sl_amazon_history (amazon_id,history_type,card_no,card_password,order_id,price,add_time) values(".(int)$data['amazon'].", 1, '". trim($data['cardno']) ."','". trim($data['pass']) ."', null,". $data['price'] .",'". date('Y-m-d H:i:s',time()) ."' )";
        if($this->db->query($inser_historysql)){
            //更新sl_amazon_accoun表
            $updatesql = 'update sl_amazon_account set balance = balance+'.(int) $data['price'].', count_price = count_price+'.(int)$data['price'].' where amazon_id = '.(int) $data['amazon'];
            if($this->db->query($updatesql)){
                return true;
            }else{
                return false;
            }
        }else{
            return false;
        }
    }
    
    //查询买手余额
    public function getBuyserPrice($buyser_id){
        $sql = 'select sum(balance) as price from sl_amazon_account where buyser_id = '.(int) $buyser_id;
        return $this->db->query($sql)->row;
    }
    
    //查询未分配的订单信息
    public function getNoTaskOrders(){
        $sql = "SELECT order_id,total FROM sl_order WHERE order_status_id = 24 AND source = 'amazon' AND is_task = 0";
        return $this->db->query($sql)->rows;
    }
    
    //新建任务表
    public function CreateTask($buyser_id,$status,$data){
        $sql = "insert into sl_task_info (`status`,`order_price`,`buyser_id`,`order_id`) values (" .(int)$status. ",". (float)$data['price'] .",". (int)$buyser_id .", " . $data['order_id']. ")";
        return $this->db->query($sql);
    }
    
    //查询订单金额
    public function getOrderPrice($order_id){
        $sql = 'select total from sl_order where order_id = '. (int) $order_id;
        return $this->db->query($sql)->row;
    }
    
    //查询买手待完成任务总数
    public function getBacklog($buyser_id) {
        $sql = 'select count(*) as number from sl_task_info where status=1 and buyser_id = '.(int) $buyser_id;
        return $this->db->query($sql)->row;
    }
    
    //查询买手任务总数
    public function getTaskNum($buyser_id) {
        $sql = 'select count(*) as number from sl_task_info where buyser_id = '. (int) $buyser_id;
        return $this->db->query($sql)->row;
    }
    
    //设置订单任务状态is_task
    public function updateOrderStatus($order_id,$status = 0){
        $sql = 'update sl_order set is_task = '.(int) $status. ' where order_id = '. (int) $order_id;
        return $this->db->query($sql);
    }
    
    /**
     * 获取任务详情总数
     */
    public function getTaskinfoTotal($data){
        $sql = "SELECT count(*) as total FROM sl_task_info t1 LEFT JOIN sl_buyserinfo t2 ON t1.buyser_id = t2.buyser_id where 1=1";
        if (!empty($data['filter_task_id'])) {
            $sql .= " AND t1.task_id = '" . (int)$data['filter_task_id'] . "'";
        }
        
        if (!empty($data['filter_buyser_name'])) {
            $sql .= " AND t2.buyser_name = '" . $data['filter_buyser_name'] . "'";
        }
        
        if (!empty($data['filter_task_status'])) {
            $sql .= " AND t1.`status` = '" . $data['filter_task_status'] . "'";
        }
        
        return $this->db->query($sql)->row;
    }
    
    /**
     * 获取任务详情
     */
    public function getTaskInfos($data){
        $sql = "SELECT t1.task_id, t1.`status`, t1.buyser_id, t1.order_id,t1.order_price,t1.buy_price, t2.buyser_name FROM sl_task_info t1 LEFT JOIN sl_buyserinfo t2 ON t1.buyser_id = t2.buyser_id where 1=1 ";
        
        if (!empty($data['filter_task_id'])) {
            $sql .= " AND t1.task_id = '" . (int)$data['filter_task_id'] . "'";
        }
        
        if (!empty($data['filter_buyser_name'])) {
            $sql .= " AND t2.buyser_name = '" . $data['filter_buyser_name'] . "'";
        }
        
        if (!empty($data['filter_task_status'])) {
            $sql .= " AND t1.`status` = '" . $data['filter_task_status'] . "'";
        }
        
        if (!empty($data['filter_buyser_id'])) {
            $sql .= " AND t1.buyser_id = '" . (int)$data['filter_buyser_id'] . "'";
        }
        
        if (isset($data['start']) || isset($data['limit'])) {
            if ($data['start'] < 0) {
                $data['start'] = 0;
            }
        
            if ($data['limit'] < 1) {
                $data['limit'] = 2;
            }
        
            $sql .= " LIMIT " . (int)$data['start'] . "," . (int)$data['limit'];
        }
        
        return $this->db->query($sql)->rows;
    }
    
    /**
     * 查询当前登录用户的买手
     */
    public function getLoginBuyserID($user_id) {
        $sql = 'select buyser_id from sl_user where user_id = '.(int) $user_id;
        return $this->db->query($sql)->row;
    }
    
    //过去amazon账户余额
    protected function getAmazonPrice($amazon_id){
        $sql = 'select balance from sl_amazon_account where amazon_id = '.(int) $amazon_id;
        return $this->db->query($sql)->row;
    }
    
    /**
     * 买手确认购买，添加到历史
     */
    public function confirmbuyHistory($order_id, $amazon_id, $price, $task_id) {
        $blance = (int) $this->getAmazonPrice($amazon_id)['balance'] - $price;
        //添加购买记录
        $historysql = "update sl_task_info set status=2, balance = balance+".floatval($blance).", amazon_account=".($amazon_id).", buy_price = buy_price+".floatval($price)." where task_id=".(int)$task_id ;
        if($this->db->query($historysql)){
             $buy_sql = "insert into sl_amazon_history (amazon_id,history_type,order_id,price,task_id,add_time) values (".(int) $amazon_id.",2,".(int)$order_id.",".floatval($price).",".(int) $task_id.", '". date('Y-m-d H:i:s', time()) ."')";
             if($this->db->query($buy_sql)){
                //扣除账户金额
                $sql = "update sl_amazon_account set balance = balance-".floatval($price)." where amazon_id = ".(int)$amazon_id;
                if($this->db->query($sql)){
                    return  true;
                } 
             }
        }
        return false;
        
    }
    
   /**
    * 设置任务状态
    */
    public function setTaskStatus($status, $task_id) {
        if(!$status || !$task_id){
            return false;
        }
        $sql = 'update sl_task_info set status ='.(int) $status.' where task_id='.(int) $task_id;
        return $this->db->query($sql);
    }
    
    /**
     * 买手添加
     */
    public function addBuyser($buyser_name){
        if(empty($buyser_name)){
            return false;
        }
        $sql = "insert into sl_buyserinfo (buyser_name,add_time) values ('". $buyser_name ."', '".date('Y-m-d H:i:s', time())."')";
        return $this->db->query($sql);
    }
    
    /**
     * 添加Amazon账号
     */
    public function addAmazonAccount($data, $buyser_id) {
        $sql = "insert into sl_amazon_account (account_no,add_time,buyser_id) values ('". $data['amazon_account'] ."', '". date('Y-m-d H:i:s', time()) ."', ". (int)$buyser_id .")";
        
        return $this->db->query($sql);
    }
    
}