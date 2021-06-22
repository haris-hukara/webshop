<?php 
 require_once dirname(__FILE__)."/BaseDao.class.php";

class OrdersDao extends BaseDao{

    public function __construct(){
        parent::__construct("orders");    
    }
    public function get_orders(){
            return parent::get_all();
    }
}
?>

