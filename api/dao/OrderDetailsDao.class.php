<?php 
 require_once dirname(__FILE__)."/BaseDao.class.php";

class OrderDetailsDao extends BaseDao{

    public function __construct(){
        parent::__construct("order_details");
    }
    
    public function get_order_details_by_id($id){
      $details =  $this->query("SELECT * 
                      FROM order_details
                      WHERE order_id = :order_id", 
                      ["order_id" => $id]);
    return $details;
    }   

    
    
}
?>