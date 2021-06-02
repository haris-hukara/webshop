<?php 
require_once dirname(__FILE__)."/BaseDao.class.php";

class UserDetailsDao extends BaseDao{

    public function __construct(){
        parent::__construct("user_details");
    }

    public function get_user_details($search, $offset, $limit){
        return $this->query("SELECT * 
                             FROM user_details
                             WHERE LOWER(email) LIKE CONCAT('%', :email, '%')
                             LIMIT ${limit} OFFSET ${offset}", ["email" => strtolower($search)]);
    }
}
?>