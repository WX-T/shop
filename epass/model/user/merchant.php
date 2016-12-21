<?php
class ModelUserMerchant extends Model {
    public function getCountryList(){
        $sql = "select * from sl_merchant_country";
        return $this->db->query($sql)->rows;
    }
    
    public function getLines($country_id){
        $sql = "select * from sl_lines where country_id=".$country_id;
        return $this->db->query($sql)->rows;
    }
    
    public function getLine($line_id){
        $sql = "select * from sl_lines where line_id={$line_id}";
        return $this->db->query($sql)->row;
    }
    //新增
    public function addMerchant($data){
        $sql = "insert into sl_merchant (merchant_name,telphone,email,model_id,app_id,app_name) values ('".$data['merchant_name']."','".$data['tel']."','".$data['email']."','".$data['model']."','".$data['app_id']."','".$data['app_name']."')";
        $this->db->query($sql);
        $merchant_id = $this->db->getLastId();
        //写入国家线路
        //var_dump( unserialize('a:2:{i:0;a:1:{s:7:"line_id";s:1:"1";}i:1;a:1:{s:7:"line_id";s:1:"8";}}'));exit;
        foreach($data['country'] as $v){
            $inser = array();
            $inser['merchant_id'] = $merchant_id;
            $inser['country_id'] = $v['name'];
            $res = array();
            foreach ($v['lines'] as $line){
                //查询lines信息
                $res[] = $this->getLine($line);
            }
            $inser['lines'] = serialize($res);
            //save
            $this->db->query($this->db->insertStr('sl_merchant_lines',$inser));
        }
    }
    
    
    //列表
    public function getMerchants($data=array()){
        $sql = "SELECT * FROM `" . DB_PREFIX . "merchant`";
        
        if (isset($data['start']) || isset($data['limit'])) {
            if ($data['start'] < 0) {
                $data['start'] = 0;
            }
        
            if ($data['limit'] < 1) {
                $data['limit'] = 20;
            }
        
            $sql .= " LIMIT " . (int)$data['start'] . "," . (int)$data['limit'];
        }
        $query = $this->db->query($sql);
        
        return $query->rows;
    }
    
   //获取商户信息
   public function getMerchant($merchant_id){
       $sql = "select * from sl_merchant where merchant_id={$merchant_id}";
       $query = $this->db->query($sql);
       return $query->row;
   }
   
   //获取商户国家线路表
   public function getCountryLines($merchant_id){
       $sql = "select * from sl_merchant_lines where merchant_id={$merchant_id}";
       $query = $this->db->query($sql);
       return $query->rows;
   }
   
   //修改商户
   public function editMerchant($merchant_id,$data){
       //保存基本信息
       $sql = "update sl_merchant set merchant_name='".$data['merchant_name']."',telphone='".$data['tel']."',email='".$data['email']."',model_id = '".$data['model']."',app_id='".$data['app_id']."',app_name='".$data['app_name']."' where merchant_id={$merchant_id}";
       $this->db->query($sql);
       //删除旧记录
       $del = "delete from sl_merchant_lines where merchant_id = {$merchant_id}";
       $this->db->query($del);
       foreach($data['country'] as $v){
            $inser = array();
            $inser['merchant_id'] = $merchant_id;
            $inser['country_id'] = $v['name'];
            $res = array();
            foreach ($v['lines'] as $line){
                //查询lines信息
                $res[] = $this->getLine($line);
            }
            $inser['lines'] = serialize($res);
            //save
            $this->db->query($this->db->insertStr('sl_merchant_lines',$inser));
        }
   }
   
   //所有模式
   public function getModel(){
       $sql = "select * from sl_model";
       return $this->db->query($sql)->rows;
   }
   
   //所有商户
   public function getMerchantAll(){
        $sql = "select * from sl_merchant";
        return $this->db->query($sql)->rows;
   }
   
   //商户下的国家
   public function getMerchantCountry($merchant_id){
       $sql = "SELECT t1.*,t2.country_name from sl_merchant_lines t1,sl_merchant_country t2 WHERE t1.country_id=t2.country_id AND t1.merchant_id= {$merchant_id}";
       return $this->db->query($sql)->rows;
   }
   
   //商户下的线路
   public function getMerchantLines($merchant_id,$country_id){
       $sql = "select * from sl_merchant_lines where merchant_id={$merchant_id} and country_id = {$country_id}";
       return $this->db->query($sql)->row;
   }
}