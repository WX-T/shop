<?php
class ModelMarketingBlackfive extends Model{
  public function editProduct($data){
      if($data['product_id']){
          $select_sql = "select * from sl_blackfive_product_desc where product_id= ". (int) $data['product_id'];
          $productdesc = $this->db->query($select_sql)->row;
          //存在更新
          if($productdesc){
              $updataSql = "update sl_blackfive_product_desc set `name`='".$this->db->escape($data['name'])."',`hot_name`='".$this->db->escape($data['hot_name'])."',`desc`='".$this->db->escape($data['desc'])."',image='".$data['image']."' where product_id = ". (int) $data['product_id'];
              $this->db->query($updataSql);
          }else{
              //添加
              $insertSql = "insert into sl_blackfive_product_desc (`product_id`,`name`,`desc`,`image`,`hot_name`) values ('".(int) $data['product_id']."','".$this->db->escape($data['name'])."','". $this->db->escape($data['desc']) ."','".$data['image']."','".$data['hot_name']."')";
              $this->db->query($insertSql);
          }
      }else{
          return false;
      }
  }
  
  
}