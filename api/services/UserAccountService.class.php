<?php 
require_once dirname(__FILE__)."/../dao/UserAccountDao.class.php";

class UserAccountService{

    private $dao;

    public function __construct(){
     $this->dao = new UserAccountDao();   
    }


    public function get_user_account($search, $offset, $limit){

            if ($search){
              return ($this->dao->get_user_account($search, $offset, $limit));
            }else{
              return ($this->dao->get_all($offset,$limit));
            }
        }
    


}
?>