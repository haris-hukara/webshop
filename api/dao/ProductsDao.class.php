<?php 
 require_once dirname(__FILE__)."/BaseDao.class.php";

class ProductsDao extends BaseDao{

    public function __construct(){
        parent::__construct("products");
    }

    public function get_product_stock($id, $size = NULL){
        
        $query ="SELECT p.id, p.name, s.name AS 'size', ps.quantity_avaliable 
                 FROM products p
                 JOIN product_stock ps ON ps.product_id = p.id
                 JOIN sizes s ON s.id = ps.size_id
                 WHERE p.id = :id AND ps.quantity_avaliable > 0";
        
        $params = [];
        $params["id"] = $id;

        if ($size){
            $query .= " AND LOWER(s.name) = :size";
            $params["size"] = strtolower($size);
        }
            return $this->query($query,$params);
      
    }
    
}
?>