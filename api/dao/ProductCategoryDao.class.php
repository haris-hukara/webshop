<?php 
 require_once dirname(__FILE__)."/BaseDao.class.php";

class ProductCategoryDao extends BaseDao{

    public function __construct(){
        parent::__construct("product_category");
    }
    
    public function get_product_categories($search, $offset, $limit, $order = "-id"){
        switch (substr($order, 0, 1)){
            case '-': $order_direction = 'ASC'; break;
            case '+': $order_direction = 'DESC'; break;
            default: throw new Exception("Invalid order format"); break;
        };
        
        return $this->query( "SELECT * 
                              FROM product_category
                              WHERE LOWER(name) LIKE CONCAT('%', :name, '%')
                              ORDER BY ${order} ${order_direction}
                              LIMIT ${limit} OFFSET ${offset}", 
                             ["name" => strtolower($search)]);
    }

    public function get_category_count(){
        return $this->query( "SELECT pc.name, COUNT(pc.name) AS 'total'
                                FROM products p
                                JOIN product_subcategory ps ON ps.id = p.subcategory_id
                                JOIN product_category pc ON pc.id = ps.category_id
                                GROUP BY pc.id", 
                            []);


    }


    

}
?>