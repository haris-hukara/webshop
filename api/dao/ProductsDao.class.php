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

 public function get_avaliable_products($search, $offset, $limit, $order = "-id", $category =""){

        switch (substr($order, 0, 1)){
            case '-': $order_direction = 'ASC'; break;
            case '+': $order_direction = 'DESC'; break;
            default: throw new Exception("Invalid order format"); break;
        };

        $params = [];
        $params["search"] = $search;
        
        $avaliable_products = "SELECT DISTINCT ps.product_id
                                FROM products p 
                                JOIN product_stock ps ON p.id = ps.product_id
                                WHERE p.id = 1 
                                AND ps.quantity_avaliable > 0";

        $query = "SELECT p.id,
                        p.name, 
                        ps.name AS 'category',
                        p.gender_category,                     
                        p.unit_price,
                        p.image_link
                FROM products p
                JOIN product_subcategory ps ON p.subcategory_id = ps.id  
                WHERE p.id IN ( {$avaliable_products} )
                AND LOWER(p.name) LIKE CONCAT('%', :search, '%')";

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

        public function get_avaliable_sizes($product_id){
            $query =  "SELECT ps.product_id, ps.size_id, ps.quantity_avaliable
                       FROM products p 
                       JOIN product_stock ps ON p.id = ps.product_id
                       WHERE p.id = :product_id
                       AND ps.quantity_avaliable > 0";

            $params = [];
            $params["product_id"] = $product_id;

            return $this->query($query,$params);
        }
}
?>