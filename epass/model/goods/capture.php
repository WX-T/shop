<?php
class ModelGoodsCapture extends Model {
    public function getcaptureList($data){
        if($data['filter_type']=='1'){
            $table = 'dt_parent_product';
        }else if($data['filter_type'] == '2'){
            $table = 'dt_product';
        }
        $sql = "select * from {$table} where 1=1 ";
        
        if($data['filter_asin']){
             $sql .= " AND asin = '" . $data['filter_asin'] . "'";
        }
        
        if($data['filter_status']!= null){
            $sql .= " AND Isexp = '" . $data['filter_status'] . "'";
        }
        
        if (!empty($data['filter_start_time'])) {
            $sql .= " AND DATE(createtime) >= DATE('" . $this->db->escape($data['filter_start_time']) . "')";
        }
        
        if (!empty($data['filter_end_time'])) {
            $sql .= " AND DATE(createtime) <= DATE('" . $this->db->escape($data['filter_end_time']) . "')";
        } 
        
        $sql .= "order by createtime desc";
        
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
        // 		print_r($sql);die();
        return $query->rows;
    }
    
    public function getcaptureListCount($data){
        if($data['filter_type']=='1'){
            $table = 'dt_parent_product';
        }else if($data['filter_type'] == '2'){
            $table = 'dt_product';
        }
        $sql = "select count(*) as counts from {$table} where 1=1 ";
    
        if($data['filter_asin']){
            $sql .= " AND asin = '" . $data['filter_asin'] . "'";
        }
        
        if($data['filter_status']!= null){
            $sql .= " AND Isexp = '" . $data['filter_status'] . "'";
        }
        
        if (!empty($data['filter_start_time'])) {
         $sql .= " AND DATE(createtime) >= DATE('" . $this->db->escape($data['filter_start_time']) . "')";
        }
    
        if (!empty($data['filter_end_time'])) {
            $sql .= " AND DATE(createtime) <= DATE('" . $this->db->escape($data['filter_end_time']) . "')";
        }
        $query = $this->db->query($sql);
        // 		print_r($sql);die();
        return $query->row['counts'];
    }
    
    //根据父id去父商品asin
    public function  getParentAsin($head_id){
        $sql = "select asin from dt_parent_product where head_id='{$head_id}'";
        $query = $this->db->query($sql);
        // 		print_r($sql);die();
        return $query->row['asin'];
    }
}