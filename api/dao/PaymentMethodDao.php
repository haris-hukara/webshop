<?php 
 require_once dirname(__FILE__)."/BaseDao.class.php";

class PaymentMethodDao extends BaseDao{

    public function __construct(){
        parent::__construct("payment_method");
    }

    public function get_payment_method_name_by_id($id){
        $payment_name = $this->get_by_id($id);
        return $payment_name['name'];
    }

}
?>