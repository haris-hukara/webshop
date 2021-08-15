<?php 
 require_once dirname(__FILE__)."/BaseDao.class.php";

class ProductsDao extends BaseDao{

    public function __construct(){
        parent::__construct("products");
    }

                     
 public function get_products($search, $offset, $limit, $order = "-id", $category =""){

    switch (substr($order, 0, 1)){
        case '-': $order_direction = 'ASC'; break;
        case '+': $order_direction = 'DESC'; break;
        default: throw new Exception("Invalid order format"); break;
    };

    $params = [];
    $params["search"] = $search;
    
    $query = "SELECT   p.id,
                       p.name, 
                       ps.name AS 'category',
                       p.gender_category,                     
                       p.unit_price,
                       p.image_link
               FROM products p
               JOIN product_subcategory ps ON p.subcategory_id = ps.id  
               WHERE LOWER(p.name) LIKE CONCAT('%', :search, '%')";

    if ($category != ""){
        $query .= " AND LOWER(ps.name) LIKE CONCAT('%', :category, '%')";
        $params["category"] = strtolower($category);
    }
        
        $order = substr($order, 1);
        
        if( strtolower($order) == "category"){
            $order = "ps.name";
        }else{
            $order = "p.".$order;
        }

        $query .= "ORDER BY ${order} ${order_direction}
                   LIMIT ${limit} OFFSET ${offset}";

        return $this->query($query,$params);
 }


}
?>