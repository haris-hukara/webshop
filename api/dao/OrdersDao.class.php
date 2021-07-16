<?php 
 require_once dirname(__FILE__)."/BaseDao.class.php";

class OrdersDao extends BaseDao{

    public function __construct(){
        parent::__construct("orders");    
    }
   
    public function get_orders($search, $offset, $limit, $order = "-id"){
        switch (substr($order, 0, 1)){
            case '-': $order_direction = 'ASC'; break;
            case '+': $order_direction = 'DESC'; break;
            default: throw new Exception("Invalid order format"); break;
        };
        
        return $this->query( "SELECT * 
                              FROM orders
                              WHERE LOWER(shipping_address) LIKE CONCAT('%', :shipping_address, '%')
                              ORDER BY ${order} ${order_direction}
                              LIMIT ${limit} OFFSET ${offset}", 
                             ["shipping_address" => strtolower($search)]);
    }
}
?>

