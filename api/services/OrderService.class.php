<?php 
require_once dirname(__FILE__)."/BaseService.class.php";
require_once dirname(__FILE__)."/../dao/OrdersDao.class.php";
require_once dirname(__FILE__)."/../dao/OrderDetailsDao.class.php";

class OrderService extends BaseService{
private $orderDetailsDao;
private $smtpClient;

 public function __construct(){
   $this->dao = new OrdersDao();   
   $this->orderDetailsDao = new OrderDetailsDao();
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

  public function get_orders(){
      return $this->dao->get_orders();
  }

}

?>
