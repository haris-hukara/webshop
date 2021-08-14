<?php 
require_once dirname(__FILE__)."/BaseDao.class.php";

class UserDetailsDao extends BaseDao{

    public function __construct(){
        parent::__construct("user_details");
    }

    public function get_user_details($search, $offset, $limit, $order){
        list($order_column, $order_direction) = self::parse_order($order);
            
            return $this->query( "SELECT * 
                                  FROM user_details
                                  WHERE LOWER(email) LIKE CONCAT('%', :email, '%')
                                  ORDER BY ${order} ${order_direction}
                                  LIMIT ${limit} OFFSET ${offset}", 
                                 ["email" => strtolower($search)]);
        }
}
?>