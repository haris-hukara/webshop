<?php 
require_once dirname(__FILE__)."/BaseDao.class.php";

class CustomerDetailsDao extends BaseDao{

    public function add_customer_details($customerDetails){
        return $this->insert("customer_details", $customerDetails);
    }
    
    public function update_customer_details($id, $customerDetails){
        $this->update("customer_details", $id, $customerDetails);
    }
    
    public function get_customer_details($id){
        return $this->query_unique("SELECT * FROM customer_details WHERE id = :id ", ["id" => $id]); 
    }


}
?>