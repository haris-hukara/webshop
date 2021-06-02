<?php 
require_once dirname(__FILE__)."/BaseDao.class.php";

class UserDetailsDao extends BaseDao{

    public function __construct(){
        parent::__construct("user_details");
    }


}
?>