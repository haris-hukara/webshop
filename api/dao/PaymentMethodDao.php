<?php 
 require_once dirname(__FILE__)."/BaseDao.class.php";

class PaymentMethodDao extends BaseDao{

    public function __construct(){
        parent::__construct("payment_method");
    }



?>