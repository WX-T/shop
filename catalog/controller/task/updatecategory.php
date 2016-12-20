<?php
class ControllerTaskUpdateCategory extends Controller{
	private $error = array();
	
	public function index() {
	    $sqlCategory = "select T2.name from sl_category T1,sl_category_description T2 where T1.category_id=T2.category_id and parent_id ='0' group by T2.name having count(*)>1";
	    $cateList = $this->db->query($sqlCategory)->rows;
	    foreach ($cateList as $cate){
	        $sqlcate = "select T1.category_id from sl_category T1,sl_category_description T2 where T1.category_id=T2.category_id and parent_id ='0' and name='".$cate['name']."' order by category_id";
	        $cateList1 = $this->db->query($sqlcate)->rows;
	        $parentCategory = '';
	        foreach ($cateList1 as $key => $cate1){
	            if($key== 0){
	                $parentCategory = $cate1['category_id'];
	            }
	            if($key != 0){
    	            $this->db->query("UPDATE " . DB_PREFIX . "category set parent_id='".$parentCategory."' WHERE parent_id='".$cate1['category_id']."'");
    	            $this->db->query("UPDATE " . DB_PREFIX . "product_to_category set category_id='".$parentCategory."' WHERE category_id='".$cate1['category_id']."'");
    	            $this->db->query("UPDATE " . DB_PREFIX . "parent_to_category set category_id='".$parentCategory."' WHERE category_id='".$cate1['category_id']."'");
    	            
    	            $this->db->query("DELETE FROM " . DB_PREFIX . "category WHERE category_id='".$cate1['category_id']."'");
    	            $this->db->query("DELETE FROM " . DB_PREFIX . "category_description WHERE category_id='".$cate1['category_id']."'");
    	            $this->db->query("DELETE FROM " . DB_PREFIX . "category_path WHERE category_id='".$cate1['category_id']."'");
    	            $this->db->query("DELETE FROM " . DB_PREFIX . "category_to_layout WHERE category_id='".$cate1['category_id']."'");
    	            $this->db->query("DELETE FROM " . DB_PREFIX . "category_to_store WHERE category_id='".$cate1['category_id']."'");
	            }
	        }
	    }
	    
	    $sqlcate = "select T1.category_id from sl_category T1,sl_category_description T2 where T1.category_id=T2.category_id and parent_id ='0' order by category_id";
	    $cateList = $this->db->query($sqlcate)->rows;
	    foreach ($cateList as $cate){
	        $sqlCategory2 = "select T2.name from sl_category T1,sl_category_description T2 where T1.category_id=T2.category_id and parent_id ='".$cate['category_id']."' group by T2.name having count(*)>1";
	        $cateLists2 = $this->db->query($sqlCategory2)->rows;
	        foreach ($cateLists2 as $cates2){
	            $sqlcate2 = "select T1.category_id from sl_category T1,sl_category_description T2 where T1.category_id=T2.category_id and parent_id ='".$cate['category_id']."' and name='".$cates2['name']."' order by category_id";
	            $cateList2 = $this->db->query($sqlcate2)->rows;
	            $parentCategory2 = '';
	            foreach ($cateList2 as $key2=>$cate2){
    	            if($key2== 0){
    	                $parentCategory2 = $cate2['category_id'];
    	            }
    	            if($key2 != 0){
    	                $this->db->query("UPDATE " . DB_PREFIX . "category set parent_id='".$parentCategory2."' WHERE parent_id='".$cate2['category_id']."'");
    	                $this->db->query("UPDATE " . DB_PREFIX . "product_to_category set category_id='".$parentCategory2."' WHERE category_id='".$cate2['category_id']."'");
    	                $this->db->query("UPDATE " . DB_PREFIX . "parent_to_category set category_id='".$parentCategory2."' WHERE category_id='".$cate2['category_id']."'");
    	                $this->db->query("DELETE FROM " . DB_PREFIX . "category WHERE category_id='".$cate2['category_id']."'");
    	                $this->db->query("DELETE FROM " . DB_PREFIX . "category_description WHERE category_id='".$cate2['category_id']."'");
    	                $this->db->query("DELETE FROM " . DB_PREFIX . "category_path WHERE category_id='".$cate2['category_id']."'");
    	                $this->db->query("DELETE FROM " . DB_PREFIX . "category_to_layout WHERE category_id='".$cate2['category_id']."'");
    	                $this->db->query("DELETE FROM " . DB_PREFIX . "category_to_store WHERE category_id='".$cate2['category_id']."'");
    	            }
	            }
	        }
	    }
	    
	    $sqlcate = "select T1.category_id from sl_category T1,sl_category_description T2 where T1.category_id=T2.category_id and parent_id ='0' order by category_id";
	    $cateList = $this->db->query($sqlcate)->rows;
	    foreach ($cateList as $cate){
	        $sqlcate2 = "select T1.category_id from sl_category T1,sl_category_description T2 where T1.category_id=T2.category_id and parent_id ='".$cate['category_id']."' order by category_id";
	        $cateList2 = $this->db->query($sqlcate2)->rows;
	        foreach ($cateList2 as $cate2){
	            $sqlCategory3 = "select T2.name from sl_category T1,sl_category_description T2 where T1.category_id=T2.category_id and parent_id ='".$cate2['category_id']."' group by T2.name having count(*)>1";
	            $cateLists3 = $this->db->query($sqlCategory3)->rows;
	            foreach ($cateLists3 as $cates3){
	                $sqlcate3 = "select T1.category_id from sl_category T1,sl_category_description T2 where T1.category_id=T2.category_id and parent_id ='".$cate2['category_id']."' and name='".$cates3['name']."' order by category_id";
	                $cateList3 = $this->db->query($sqlcate3)->rows;
	                $parentCategory3 = '';
	                foreach ($cateList3 as $key3=>$cate3){
	                    if($key3== 0){
	                        $parentCategory3 = $cate3['category_id'];
	                    }
	                    if($key3 != 0){
	                        $this->db->query("UPDATE " . DB_PREFIX . "category set parent_id='".$parentCategory3."' WHERE parent_id='".$cate3['category_id']."'");
	                        $this->db->query("UPDATE " . DB_PREFIX . "product_to_category set category_id='".$parentCategory3."' WHERE category_id='".$cate3['category_id']."'");
	                        $this->db->query("UPDATE " . DB_PREFIX . "parent_to_category set category_id='".$parentCategory3."' WHERE category_id='".$cate3['category_id']."'");
	                        $this->db->query("DELETE FROM " . DB_PREFIX . "category WHERE category_id='".$cate3['category_id']."'");
	                        $this->db->query("DELETE FROM " . DB_PREFIX . "category_description WHERE category_id='".$cate3['category_id']."'");
	                        $this->db->query("DELETE FROM " . DB_PREFIX . "category_path WHERE category_id='".$cate3['category_id']."'");
	                        $this->db->query("DELETE FROM " . DB_PREFIX . "category_to_layout WHERE category_id='".$cate3['category_id']."'");
	                        $this->db->query("DELETE FROM " . DB_PREFIX . "category_to_store WHERE category_id='".$cate3['category_id']."'");
	                    }
	                }
	            }
	        }
	    }
	    $this->arrangeCategory();
	}
	
	
	
	public function arrangeCategory(){
	    $this->db->query("DELETE FROM " . DB_PREFIX . "category_path");
	    $sql = "select * from sl_category where parent_id='0'";
	    $categoryList = $this->db->query($sql)->rows;
	    foreach($categoryList as $category){
	        $this->db->query("INSERT INTO " . DB_PREFIX . "category_path set category_id='".$category['category_id']."',path_id='".$category['category_id']."',level='0'");
	        $sql2 = "select * from sl_category where parent_id='".$category['category_id']."'";
	        $categoryList2 = $this->db->query($sql2)->rows;
	        foreach ($categoryList2 as $category2){
	            $this->db->query("INSERT INTO " . DB_PREFIX . "category_path set category_id='".$category2['category_id']."',path_id='".$category['category_id']."',level='0'");
	            $this->db->query("INSERT INTO " . DB_PREFIX . "category_path set category_id='".$category2['category_id']."',path_id='".$category2['category_id']."',level='1'");
	            $sql3 = "select * from sl_category where parent_id='".$category2['category_id']."'";
	            $categoryList3 = $this->db->query($sql3)->rows;
	            foreach ($categoryList3 as $category3){
	                $this->db->query("INSERT INTO " . DB_PREFIX . "category_path set category_id='".$category3['category_id']."',path_id='".$category['category_id']."',level='0'");
	                $this->db->query("INSERT INTO " . DB_PREFIX . "category_path set category_id='".$category3['category_id']."',path_id='".$category2['category_id']."',level='1'");
	                $this->db->query("INSERT INTO " . DB_PREFIX . "category_path set category_id='".$category3['category_id']."',path_id='".$category3['category_id']."',level='2'");
	            }
	        }
	    }
	}
}