<?php 
require_once dirname(__FILE__)."/BaseService.class.php";
require_once dirname(__FILE__)."/../dao/OrdersDao.class.php";

class OrderService extends BaseService{

 public function __construct(){
   $this->dao = new OrdersDao();   
  }

  public function add_order($order){   
    
   $order = parent::add([ 
      "user_details_id" => $order['user_details_id'],
      "shipping_address" => $order['shipping_address'],
      "payment_method_id" => $order['payment_method_id'],
      "order_date" => date(Config::DATE_FORMAT),
      "status" => $order['status']
    ]);
    return $order;
  }

  public function get_orders($search, $offset, $limit, $order){
    if ($search){
      return ($this->dao->get_orders($search, $offset, $limit, $order));
    }else{
      return ($this->dao->get_all($offset,$limit, $order));
    }
  }


}

?>
