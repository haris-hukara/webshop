<?php 
 require_once dirname(__FILE__)."/BaseDao.class.php";

class OrderDetailsDao extends BaseDao{

    public function __construct(){
        parent::__construct("order_details");
    }
    
    
    
}
?>