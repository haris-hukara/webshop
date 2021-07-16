<?php 
require_once dirname(__FILE__)."/BaseService.class.php";
require_once dirname(__FILE__)."/../dao/OrderDetailsDao.class.php";

class OrderDetailsService extends BaseService{

 public function __construct(){
   $this->dao = new OrderDetailsDao();   
  }

  public function get_order_details_by_id($id){
    return ($this->dao->get_order_details_by_id($id));
    }

  public function get_order_price_by_id($id){
    return ($this->dao->get_order_price_by_id($id));
    }

}

?>
