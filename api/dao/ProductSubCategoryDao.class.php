<?php 
 require_once dirname(__FILE__)."/BaseDao.class.php";

class ProductSubCategoryDao extends BaseDao{

    public function __construct(){
        parent::__construct("product_subcategory");
    }
    
    public function get_product_subcategories($search, $offset, $limit, $order = "-id"){
        switch (substr($order, 0, 1)){
            case '-': $order_direction = 'ASC'; break;
            case '+': $order_direction = 'DESC'; break;
            default: throw new Exception("Invalid order format"); break;
        };
        
        return $this->query( "SELECT * 
                              FROM product_subcategory
                              WHERE LOWER(name) LIKE CONCAT('%', :name, '%')
                              ORDER BY ${order} ${order_direction}
                              LIMIT ${limit} OFFSET ${offset}", 
                             ["name" => strtolower($search)]);
    }

}
?>