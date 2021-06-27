<?php 
 require_once dirname(__FILE__)."/BaseDao.class.php";

class CityDao extends BaseDao{

    public function __construct(){
        parent::__construct("city");
    }
    
    public function get_cities($search, $offset, $limit, $order = "-id"){
        switch (substr($order, 0, 1)){
            case '-': $order_direction = 'ASC'; break;
            case '+': $order_direction = 'DESC'; break;
            default: throw new Exception("Invalid order format"); break;
        };
        
        return $this->query( "SELECT * 
                              FROM city
                              WHERE LOWER(name) LIKE CONCAT('%', :name, '%')
                              ORDER BY ${order} ${order_direction}
                              LIMIT ${limit} OFFSET ${offset}", 
                             ["name" => strtolower($search)]);
    }

    

}
?>