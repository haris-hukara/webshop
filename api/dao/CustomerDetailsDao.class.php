<?php 
require_once dirname(__FILE__)."/BaseDao.class.php";

class CustomerDetailsDao extends BaseDao{

    public function __construct(){
        parent::__construct("customer_details");
    }


}
?>