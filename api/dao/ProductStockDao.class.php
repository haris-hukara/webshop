<?php 
 require_once dirname(__FILE__)."/BaseDao.class.php";

class ProductStockDao extends BaseDao{

    public function __construct(){
        parent::__construct("product_stock");
    }
    
    public function get_product_stock_by_size_name($id, $size = NULL){
        
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
            return $this->query_unique($query,$params);
    }

    public function get_product_stock_by_size_id($id, $size_id = NULL){
        
        $query ="SELECT p.id, p.name, s.id AS 'size_id', s.name AS 'size_name', ps.quantity_avaliable 
                 FROM products p
                 JOIN product_stock ps ON ps.product_id = p.id
                 JOIN sizes s ON s.id = ps.size_id
                 WHERE p.id = :id AND s.id = :size_id";
        
        $params = [];
        $params["size_id"] = $size_id;
        $params["id"] = $id;

            return $this->query_unique($query,$params);
    }


    public function change_product_stock($product_id, $size_id, $quantity_ordered){  
        $product = $this->get_product_stock_by_size_id($product_id, $size_id);
        $quantity_avaliable = $product['quantity_avaliable'];
                
        if( ( $quantity_avaliable - $quantity_ordered ) >= 0 ){
        $this->query(
                    ("UPDATE product_stock
                      SET quantity_avaliable = (quantity_avaliable - :quantity_ordered)
                      WHERE product_id = :product_id AND size_id = :size_id"),
                   
                   [ "product_id" => $product_id, 
                     "size_id" => $size_id, 
                     "quantity_ordered" => $quantity_ordered]  
                    );
        }
    }

    public function set_product_stock($product_id, $size_id, $new_quantity){  
        $this->query(
                    ("UPDATE product_stock
                      SET quantity_avaliable = :new_quantity
                      WHERE product_id = :product_id AND size_id = :size_id"),
                   
                   [ "product_id" => $product_id, 
                     "size_id" => $size_id, 
                     "new_quantity" => $new_quantity]  
                    );
    }
   
       
    public function update_product_stock($product_id, $size_id, $quantity_avaliable){  
                
       $params = [ "product_id" => $product_id, 
                    "size_id" => $size_id, 
                    "quantity_avaliable" => $quantity_avaliable] ;
      
       $query =   "UPDATE product_stock
                   SET quantity_avaliable = :quantity_avaliable
                   WHERE product_id = :product_id AND size_id = :size_id";
       
       $this->query( $query, $params);
       
       return $params;
    }

} 
?>